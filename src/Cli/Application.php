<?php

namespace Deployer\Cli;

use Deployer\Cli\Command\Deploy;
use Deployer\Cli\Command\Info;
use Deployer\Cli\Command\Init;
use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    const CONFIG_FILE   = 'deployer.yaml';
    
    const ROUTE_HOME        = 'home';
    const ROUTE_ENTRY       = 'entry';
    const ROUTE_CATEGORY    = 'category';
    const ROUTE_TAG         = 'tag';
    
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
}
