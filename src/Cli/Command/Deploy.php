<?php

namespace Deployer\Cli\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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

    }
}
