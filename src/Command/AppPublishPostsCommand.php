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
	
	public function __construct(VkService $vkService, EntityManagerInterface $em)
	{
		$this->vkService = $vkService;
		$this->em        = $em;
		
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
				
				$posts = $this->em->getRepository(Post::class)->findBy([
					'published' => false,
					'tag'       => $group->getTag()
				], null, 25);
				$io->writeln('Группа: ' . $group->getGroupId());
				
				$io->progressStart(count($posts));
				foreach ($posts as $post)
				{
					$this->publishPost($vk, $group->getGroupId(), $post, $dateTime->getTimestamp());
					$post->setPublished(true);
					$this->em->merge($post);
					$this->em->flush();
					$io->progressAdvance();
					$dateTime->add(new \DateInterval('PT' . rand(5, 58).'M'));
				}
			}
			
		}
	}
	
	
	private function publishPost($vk, $groupId, Post $post, $timestamp = 0)
	{
		$postData = json_decode($post->getPostData(), true);
		$params = [
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
		try
		{
			//$tmp = $vk->request('wall.post', $params)->getResponse();
		} catch (\Exception $e)
		{
		
		}
		sleep(rand(1, 2));
	}
}

