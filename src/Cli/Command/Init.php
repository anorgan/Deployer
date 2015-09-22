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
            ->setDescription('Initialize deploy.yml file')
            ->setHelp(<<<EOT
Setup config file
EOT
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configFile = $this->getApplication()->getRoot().'/'.\Deployer\Cli\Application::CONFIG_FILE;
        if (file_exists($configFile)) {
            throw new \Exception('Deployer already initialized.');
        }

        $config = <<<CONFIG
# Environments
production:
  servers:
    app1:
      type: ssh # local or webhook
      host: app1.domain.com
      user: deployer
      path: /var/www/domain.com

  steps:
    Tests:
      commands:
        - bin/phpspec run -fpretty

  success:
    - echo "send email with output"
    - echo "send notification on Slack"

  # Run after any failure to deploy to destination (optional)
  fail:
    - echo "weep"
CONFIG;

        if (false === file_put_contents($configFile, $config)) {
            throw new \Exception('Could not write to '.$configFile);
        }
    }
}
