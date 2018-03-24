<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\User;
use App\Entity\WatchingGroups;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\VkService;

/**
 * Class ParsePostsCommand
 *
 * @package App\Command
 */
class ParsePostsCommand extends Command
{
	/**
	 *
	 */
	const postPerGroup = 10;
	/**
	 * @var string
	 */
	protected static $defaultName = 'app:parsePosts';
	/**
	 * @var VkService
	 */
	protected $vkService;
	/**
	 * @var EntityManager
	 */
	protected $em;
	
	protected $logger;
	
	protected $registry;
	
	/**
	 * ParsePostsCommand constructor.
	 *
	 * @param VkService $vkService
	 */
	public function __construct(VkService $vkService, RegistryInterface $registry, LoggerInterface $log)
	{
		$this->registry  = $registry;
		$this->vkService = $vkService;
		$this->em        = $this->registry->getEntityManager();
		$this->logger    = $log;
		parent::__construct(null);
	}
	
	/**
	 *
	 */
	protected function configure()
	{
		$this->setDescription('Parse posts from Vk');
	}
	
	/**
	 * @param InputInterface  $input
	 * @param OutputInterface $output
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);
		
		$users = $this->em->getRepository(User::class)->findAll();
		foreach ($users as $user)
		{
			$io->writeln('Пользователь с id: ' . $user->getVkUserId());
			$vk             = $this->vkService->getVkInstanse($user->getToken());
			$watchingGroups = $user->getWatchingGroups();
			/**
			 * @var WatchingGroups $group
			 */
			foreach ($watchingGroups as $group)
			{
				$io->writeln('Парсинг группы: ' . $group->getShortName());
				$posts = $vk->request('wall.get', [
					'owner_id' => '',
					'domain'   => $group->getShortName(),
					'offset'   => 0,
					'count'    => self::postPerGroup
				])->getResponse();
				$io->progressStart(count($posts));
				foreach ($posts as $post)
				{
					try
					{
						$res        = [
							'message'     => $post->text ? $post->text : "",
							'attachments' => isset($post->attachments) ? $this->parseAttach($post->attachments) : ""
						];
						$postEntity = new Post();
						$postEntity->setPostData(json_encode($res));
						$postEntity->setTag($group->getTag());
						$postEntity->setHash(md5(json_encode($res)));
						$this->em->merge($postEntity);
						$this->em->flush();
						$io->progressAdvance();
					} catch (\Exception $e)
					{
						$this->em->clear();
						$this->em = $this->registry->resetManager();
						$this->logger->error($e->getMessage() . " file : " . $e->getFile() . " line: " . $e->getLine());
					}
					
				}
				
				
				$io->progressFinish();
				sleep(rand(2, 5));
			}
		}
		
		
	}
	
	/**
	 * @param $attachments
	 *
	 * @return bool|string
	 */
	private function parseAttach($attachments)
	{
		$result = "";
		foreach ($attachments as $attachment)
		{
			$attachment = (array) $attachment;
			$type       = $attachment['type'];
			if (!in_array($type, [
				'link',
				'page'
			]))
			{
				$attachment[$type] = (array) $attachment[$type];
				$result            .= $type . $attachment[$type]['owner_id'] . "_" . $attachment[$type]['id'] . ",";
			}
			
		}
		
		return substr($result, 0, -1);
	}
}
