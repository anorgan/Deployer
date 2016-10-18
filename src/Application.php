<?php

namespace Anorgan\Deployer\Cli;

use Anorgan\Deployer\Cli\Command\Deploy;
use Anorgan\Deployer\Cli\Command\Info;
use Anorgan\Deployer\Cli\Command\Init;
use Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    const CONFIG_FILE = 'deployer.yml';

    protected $root;
    protected $config;

    /**
     * @return array An array of default Command instances
     */
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();

        $commands[] = new Deploy();
        $commands[] = new Info();
        $commands[] = new Init();

        return $commands;
    }

    public function getRoot()
    {
        if (null === $this->root) {
            $this->root = getcwd();
        }

        return $this->root;
    }

    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig(array $config = [])
    {
        $this->config = $config;
    }
}
