<?php

namespace Deployer\Cli\Command;

use Deployer\Config;
use Deployer\Deployer;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;

class Deploy extends BaseCommand
{
    const DEFAULT_DESTINATION = 'production';

    protected function configure()
    {
        $this
            ->setName('deploy')
            ->setDescription('Deploy to defined destinations')
            ->addArgument('destination', InputArgument::OPTIONAL, 'Where to deploy? Name of the destination in config file', self::DEFAULT_DESTINATION)
            ->setHelp(<<<EOT
Deploy to destination
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getApplication()->getConfig();

        $destination = $input->getArgument('destination');

        $verbosityLevelMap = array(
            LogLevel::NOTICE => OutputInterface::VERBOSITY_NORMAL,
            LogLevel::INFO   => OutputInterface::VERBOSITY_NORMAL,
        );
        $logger = new ConsoleLogger($output, $verbosityLevelMap);
        $config = $config[$destination];

        $deployRunner = Deployer::create($config, $logger);
        $deployRunner->run();
    }
}
