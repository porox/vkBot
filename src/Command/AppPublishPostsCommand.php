<?php

namespace App\Command;

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
	protected $vkService;
	
	public function __construct(VkService $vkService)
	{
		$this->vkService = $vkService;
		
		parent::__construct(null);
	}
	
	protected function configure()
	{
		$this->setDescription('Add a short description for your command')
			->addArgument('token', InputArgument::REQUIRED, 'Vk access token')
			
			->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
	}
	
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io   = new SymfonyStyle($input, $output);
		
		//$this->vkService->getVkInstanse()->
		$arg1 = $input->getArgument('arg1');
		
		if ($arg1)
		{
			$io->note(sprintf('You passed an argument: %s', $arg1));
		}
		
		$io->success('You have a new command! Now make it your own! Pass --help to see your options.');
	}
}
