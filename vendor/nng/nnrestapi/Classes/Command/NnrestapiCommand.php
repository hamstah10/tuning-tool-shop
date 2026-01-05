<?php

declare(strict_types=1);

namespace Nng\Nnrestapi\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Scheduler command for EXT:nnrestapi maintenance tasks.
 * 
 * You can call this from command line (TYPO3 cli):
 * ```
 * vendor/bin/typo3 nnrestapi:run
 * ```
 *
 */
class NnrestapiCommand extends Command
{
	/**
	 * Configure the command by defining
	 * the name, options and arguments
	 */
	protected function configure(): void
	{
		$this->setDescription('Run maintenance tasks for EXT:nnrestapi.');
		$this->setHelp('Clears expired log entries based on extension manager settings.');
	}

	/**
	 * Executes the command
	 *
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int error code
	 */
	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$io = new SymfonyStyle($input, $output);
		$io->title($this->getDescription());

		$result = \nn\rest::Log()->clear();
		$deleted = $result['deleted'] ?? 0;
		$io->writeln("Expired log entries cleared. Deleted {$deleted} entries.");

		return Command::SUCCESS;
	}
}
