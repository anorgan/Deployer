<?php

namespace Deployer;

use Psr\Log\LoggerInterface;
use Symfony\Component\Process\Process;

class Runner
{
    private $config;
    private $logger;
    private $steps;

    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
        $this->steps  = $this->config['steps'];
    }

    public function run()
    {
        foreach ($this->getSteps() as $step) {
            $this->logger->info('Starting "'.$step->getTitle().'"');
            foreach ($step->getCommands() as $command) {
                $this->runCommand($command);
            }
            $this->logger->info('Finished "'.$step->getTitle().'"');
        }
    }

    /**
     * @return DeployStep[]
     */
    public function getSteps()
    {
        return $this->steps;
    }

    private function runCommand($command)
    {
        $this->logger->info('Running "'.$command.'"');
        $process = new Process($command);
        $process->mustRun();
    }
}
