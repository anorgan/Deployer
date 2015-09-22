<?php

namespace spec\Deployer;

use PhpSpec\ObjectBehavior;

class CommandSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Deployer\Command');
    }
}
