<?php

namespace Deployer\Cli\Command;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Init extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('init')
            ->setDescription('Initialize deploy.yaml file')
            ->setHelp(<<<EOT
Setup config file
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $this->getApplication()->getRoot() .'/'. \Deployer\Cli\Application::CONFIG_FILE;
        if (file_exists($configFile)) {
            throw new \Exception('Deployer already initialized.');
        }

        $config = <<<CONFIG
# Run before any destination (optional)
before:
    - phpunit
    - codecept run acceptance

production:
    type: ssh
    host: your-domain
    commands:
        - cd /path/to/app
        - git fetch origin
        - git reset --hard origin/master

# Run after any destination (optional)
after:
    - send email with output
    - send notification on Slack
CONFIG;

        if (false === file_put_contents($configFile, $config)) {
            throw new \Exception('Could not write to '. $configFile);
        }
    }
}
