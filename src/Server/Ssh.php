<?php

namespace Deployer\Server;

use Ssh\SshConfigFileConfiguration;
use Ssh\Session;
use Symfony\Component\Process\Process;

class Ssh extends AbstractServer
{
    private $user;

    /**
     * @param string $title
     * @param string $path
     * @param string $hostname
     * @param $user
     * @param LoggerInterface $logger
     */
    public function __construct($title, $path, $hostname, $user, LoggerInterface $logger = null)
    {
        parent::__construct($title, $path, $logger);

        $this->setHostname($hostname);
        $this->user = $user;
    }

    public function runCommands()
    {
        $commands = implode('; ', $this->getCommands());
        $this->logger->info('Running "'.$commands.'"');
        $process = new Process($commands);

        $commandLine = $process->getCommandLine();
        $this->logger->info('Running "'.$commandLine.'"');
        $this->getSession()->getExec()->run($commandLine);
    }

    /**
     * @return Session
     */
    private function getSession()
    {
        $configuration = new SshConfigFileConfiguration(getenv('HOME').'/~ssh/config', $this->getHostname());
        $session = new Session($configuration);

        return $session;
    }
}
