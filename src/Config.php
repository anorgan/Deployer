<?php

namespace Deployer;

use Symfony\Component\OptionsResolver\OptionsResolver;

class Config extends OptionsResolver
{
    protected $options = [];
    protected $type;

    public function __construct($type = 'root')
    {
        $this->type = $type;
        switch ($type) {
            case 'environment':
                $this->configureEnvironmentOptions();

                break;

            case 'server':
                $this->configureServerOptions();

                break;

            case 'step':
                $this->configureStepOptions();

                break;

            default:
                break;
        }
    }

    public function resolve(array $options = array())
    {
        switch ($this->type) {
            case 'root':
            case 'environment':
            case 'server':
            case 'step':
                foreach ($options as $item => $value) {
                    if (is_array($value)) {
                        $this->setDefined($item);
                        $this->setAllowedTypes($item, 'array');
                        $nextType = $this->getNextType($item);
                        $resolver = new self($nextType);
                        $options[$item] = $resolver->resolve($value);
                    }
                }

                return $options;

                break;

            default:
                return parent::resolve($options);

                break;
        }
    }

    private function getNextType($item)
    {
        switch ($item) {
            case 'servers':
                return 'server';

            case 'steps':
                return 'step';

            default:
                return 'environment';
        }
    }

    private function configureEnvironmentOptions()
    {
        $this->setDefined([
            'servers',
            'steps',
            'success',
            'fail'
        ]);

        $this->setAllowedTypes('servers', 'array');
        $this->setAllowedTypes('steps', 'array');
        $this->setAllowedTypes('success', 'array');
        $this->setAllowedTypes('fail', 'array');

        $this->setDefault('servers', [
            'localhost' => [
                'type' => 'local'
            ]
        ]);
        $this->setRequired('steps');
        $this->setDefault('success', []);
        $this->setDefault('fail', []);
    }

    private function configureServerOptions()
    {
        $this->setDefined([
            'type',
            'host',
            'user',
            'path',
        ]);

        $this->setAllowedTypes('type', 'string');
        $this->setAllowedTypes('host', 'string');
        $this->setAllowedTypes('user', 'string');
        $this->setAllowedTypes('path', 'string');

        $this->setDefault('type', 'local');
        $this->setDefault('host', 'localhost');
        $this->setDefault('user', null);
        $this->setDefault('path', null);
    }

    private function configureStepOptions()
    {
        $this->setDefined([
            'servers',
            'commands',
            'path',
            'allow_failure',
        ]);

        $this->setAllowedTypes('servers', ['string', 'array']);
        $this->setAllowedTypes('commands', 'array');
        $this->setAllowedTypes('path', 'string');
        $this->setAllowedTypes('allow_failure', 'bool');

        $this->setDefault('servers', 'all');
        $this->setRequired('commands');
        $this->setDefault('path', null);
        $this->setDefault('allow_failure', false);
    }
}
