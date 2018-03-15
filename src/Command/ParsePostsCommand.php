<?php

namespace App\Command;

use App\Entity\Post;
use App\Entity\WatchingGroups;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\VkService;

class ParsePostsCommand extends Command
{
	const postPerGroup = 10;
    protected static $defaultName = 'app:parsePosts';
	protected $vkService;
	protected $em;
	
	
	public function __construct(VkService $vkService, EntityManagerInterface  $em)
	{
		$this->vkService = $vkService;
		$this->em = $em;
		parent::__construct(null);
	}
    protected function configure()
    {
        $this
            ->setDescription('Parse posts from Vk')
			->addArgument('token', InputArgument::REQUIRED, 'Vk access token')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		$io   = new SymfonyStyle($input, $output);
		$token = $input->getArgument('token');
		$vk = $this->vkService->getVkInstanse($token);
		
		$watchingGroups =$this->em->getRepository(WatchingGroups::class)->findAll();
		/**
		 * @var WatchingGroups $group
		 */
		foreach ($watchingGroups as $group)
		{
			$io->writeln('Парсинг группы: '.$group->getShortName());
			$posts = $vk->request('wall.get', [
				'owner_id' =>'',
				'domain' => $group->getShortName(),
				'offset' => 0,
				'count'  => self::postPerGroup
			])->getResponse();
			$io->progressStart(count($posts));
			foreach ($posts as $post)
			{
				try{
					$res        = [
						'message'     => $post->text ? $post->text : "",
						'attachments' => isset($post->attachments) ? $this->parseAttach($post->attachments):""
					];
					$postEntity = new Post();
					$postEntity->setPostData(json_encode($res));
					$postEntity->setTag($group->getTag());
					$postEntity->setHash(md5(json_encode($res)));
					$this->em->persist($postEntity);
					$this->em->flush();
					$io->progressAdvance();
				}catch (\Exception $e)
				{
					$this->em = $this->em->create(
						$this->em->getConnection(),
						$this->em->getConfiguration()
					);
					//$io->error('error');
				}
				
			}
			
			
			$io->progressFinish();
		}
		
    }
    private function parseAttach($attachments)
	{
		$result ="";
		foreach ($attachments as $attachment)
		{
			$attachment = (array) $attachment;
			$type = $attachment['type'];
			if (!in_array($type,['link','page']))
			{
				$attachment[$type] =(array) $attachment[$type];
				$result .= $type.$attachment[$type]['owner_id']."_".$attachment[$type]['id'].",";
				if (!isset($attachment[$type]['owner_id']))
				{
					var_dump($attachment);
				}
			}
			
		}
		return substr($result,0,-1);
	}
}
