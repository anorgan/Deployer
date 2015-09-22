<?php

namespace Deployer;

use Psr\Log\LoggerInterface;

class Runner
{
    private $config;
    private $logger;

    public function __construct(Config $config, LoggerInterface $logger)
    {
        $this->config = $config;
        $this->logger = $logger;
    }

    public function run()
    {
        foreach ($this->getSteps() as $step) {
            foreach ($step->getCommands() as $command) {
                $this->runCommand($command);
            }
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
    }
}
