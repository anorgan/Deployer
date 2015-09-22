<?php

namespace Deployer\Cli\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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
        $config = $this->getApplication()->getConfig();

        print_r($config);

        // List all destinations, skip "magic" before and after
        foreach ($config as $destination => $destinationConfig) {
            if (in_array($destination, ['before'])) {
                if ($destination === 'before') {
                    $output->writeln('<info>'. $destination .'</info> each destination run:');
                } else {
                    $output->writeln('<info>Run on deploy status '. $destination .'</info>:');
                }
            } else {
                $output->writeln('<info>'. $destination .'</info>');
            }

            array_walk_recursive($destinationConfig, function($item, $key) use ($output) {
                if (is_numeric($key)) {
                    $string = ' $ ';
                } elseif (in_array($key, ['success', 'fail'])) {
                    $output->writeln('<info>Run on deploy status '. $key .'</info>:');
                } else {
                    $string = $key .': ';
                }

                $output->writeln('<comment>'. $string .'</comment>'. $item);
            });
        }
    }
}
