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
        $configFile = $this->getApplication()->getRoot() .'/'. \Deployer\Cli\Application::CONFIG_FILE;
        if (!file_exists($configFile) || !is_readable($configFile)) {
            throw new \Exception('Can not read config file '. $configFile);
        }

        $config = Yaml::parse(file_get_contents($configFile));

        // List all destinations, skip "magic" before and after
        foreach ($config as $destination => $destinationConfig) {
            if (in_array($destination, ['before', 'after'])) {
                $output->writeln('<info>'. $destination .'</info> each destination run:');
            } else {
                $output->writeln('<info>'. $destination .'</info>');
            }

            array_walk_recursive($destinationConfig, function($item, $key) use ($output) {
                static $indent = 0;
                if (is_numeric($key)) {
                    $string = ' $ ';
                } else {
                    $string = $key .': ';
                }

                $output->writeln('<comment>'. $string .'</comment>'. $item);
            });
        }
    }
}
