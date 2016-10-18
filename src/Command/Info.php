<?php

namespace Anorgan\Deployer\Cli\Command;

use Anorgan\Deployer\Common\Deployer;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Info extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('info')
            ->setDescription('Show defined destinations with their parameters')
            ->addArgument('destination', InputArgument::OPTIONAL, 'Show only info for this destination')
            ->setHelp(<<<'EOT'
Show defined destinations
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getApplication()->getConfig();

        foreach ($config as $destination => $destinationConfig) {
            $deployRunner = Deployer::create($destinationConfig);
            $output->writeln('<info>'.$destination.'</info>:');
            foreach ($deployRunner->getSteps() as $step) {
                $output->writeln('<comment>'.$step->getTitle().'</comment>');
                foreach ($step->getCommands() as $command) {
                    $output->writeln('  '.$command);
                }
            }
        }
    }
}
