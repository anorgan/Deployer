<?php

namespace Deployer\Cli\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Info extends BaseCommand
{

    protected function configure()
    {
        $this
            ->setName('info')
            ->setDescription('Show defined destinations with their parameters')
            ->addArgument('destination', InputArgument::OPTIONAL, 'Show only info for this destination')
            ->setHelp(<<<EOT
Show defined destinations
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
