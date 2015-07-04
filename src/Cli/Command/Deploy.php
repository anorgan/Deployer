<?php

namespace Deployer\Cli\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Yaml;

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

        $configFile = $this->getApplication()->getRoot() .'/'. \Deployer\Cli\Application::CONFIG_FILE;
        if (!file_exists($configFile) || !is_readable($configFile)) {
            throw new \Exception('Can not read config file '. $configFile);
        }

        $destination = $input->getArgument('destination');

        $config = Yaml::parse(file_get_contents($configFile));

        if (!isset($config[$destination])) {
            throw new \Exception('Destination '. $destination .' not found in '. $configFile);
        }

        $beforeCommands = $config['before'];
        $destinationConfig = $config[$destination];

        if ($this->runCommands($beforeCommands, $output)) {
            if (!empty($beforeCommands)) {
                $output->writeln('<info>All before commands ran, deploying to <comment>'. $destination .'</comment></info>');
            }

            if ($this->deploy($destinationConfig, $output)) {
                $this->runCommands($destinationConfig['success'], $output);
            } else {
                $this->runCommands($destinationConfig['fail'], $output);
            }
        }
    }

    protected function deploy($config, $output)
    {
        if ($config['type'] == 'ssh') {
            $host = $config['host'];
            $commands = [];
            foreach ($config['commands'] as $command) {
                $commands[] = 'ssh '. $host .' "'. $command .'"';
            }

            return $this->runCommands($commands, $output);
        }
    }

    protected function runCommands($commands, $output)
    {
        foreach ($commands as $command) {

            $process = new Process($command);
            $process->run();

            // executes after the command finishes
            if (!$process->isSuccessful()) {
                $output->writeln('<error>'.  $process->getErrorOutput() .'</error>');
                $output->writeln('<error>Original command: '.  $command .'</error>');

                return false;
            }
        }

        $output->writeln('<comment> $ '.  $process->getOutput() .'</comment>');
        return true;
    }
}
