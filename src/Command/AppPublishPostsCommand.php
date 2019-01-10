<?php

namespace App\Command;


use App\Entity\Post;
use App\Entity\User;
use App\Entity\UserGroups;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\VkService;
use getjump\Vk\Core as VkApi;

class AppPublishPostsCommand extends Command
{
	protected static $defaultName = 'app:publishPosts';
	/**
	 * @var VkService
	 */
	protected $vkService;
	/**
	 * @var EntityManagerInterface
	 */
	protected $em;
	
	protected $logger;
	
	public function __construct(VkService $vkService, EntityManagerInterface $em, LoggerInterface $log)
	{
		$this->vkService = $vkService;
		$this->em        = $em;
		$this->logger = $log;
		parent::__construct(null);
	}
	
	protected function configure()
	{
		$this->setDescription('Publish vk posts');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io    = new SymfonyStyle($input, $output);
		$users = $this->em->getRepository(User::class)->findAll();
		foreach ($users as $user)
		{
			$vk     = $this->vkService->getVkInstanse($user->getToken());
			$groups = $user->getUserGroups();
			/**
			 * @var UserGroups $group
			 */
			foreach ($groups as $group)
			{
				$dateTime = new \DateTime('now');
				$dateTime->add(new \DateInterval('PT' . rand(5, 58) . 'M'));
				$posts = $this->em->getRepository(Post::class)->findBy([
					'published' => false,
					'tag'       => $group->getTag()
				], null, 25);
				$io->writeln('Группа: ' . $group->getGroupId());
				
				$io->progressStart(count($posts));
				foreach ($posts as $post)
				{
					try
					{
						$this->publishPost($vk, $group->getGroupId(), $post, $dateTime->getTimestamp());
						$post->setPublished(true);
						$this->em->merge($post);
						$this->em->flush();
						$io->progressAdvance();
						$dateTime->add(new \DateInterval('PT' . rand(5, 58) . 'M'));
					} catch (\Exception $e)
					{
						$this->em->clear();
						$this->logger->error($e->getMessage() . " file : " . $e->getFile() . " line: " . $e->getLine());
					}
					finally
					{
						sleep(rand(1, 2));
					}
					
				}
			}
			
		}
	}
	
	
	private function publishPost(VkApi $vk, $groupId, Post $post, $timestamp = 0)
	{
		$postData = json_decode($post->getPostData(), true);
		$params   = [
			'owner_id'     => '-' . $groupId,
			'friends_only' => 0,
			'from_group'   => 1,
			'message'      => $postData['message'] ?? "",
			'attachments'  => $postData['attachments'] ?? "",
			'services'     => "",
			'signed'       => 0,
			'publish_date' => $timestamp,
			'lat'          => 0,
			'long'         => 0,
			'place_id'     => '',
			'post_id'      => '',
			//'guid'                 => ,
			'mark_as_ads'  => 0,
		];
		
		return $vk->request('wall.post', $params)->getResponse();
		
	}
}

