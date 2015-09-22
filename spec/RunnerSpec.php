<?php

namespace spec\Deployer;

use Deployer\Config;
use Deployer\DeployStep;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class RunnerSpec extends ObjectBehavior
{
    public function let(Config $config, LoggerInterface $logger)
    {
        $this->beConstructedWith($config, $logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Deployer\Runner');
    }

    public function it_gets_and_runs_commands_of_each_step_in_correct_order(DeployStep $step1, DeployStep $step2)
    {
        $step1->getCommands()->willReturn(['echo "step 1: command 1', 'echo "step 1: command 2']);
        $step2->getCommands()->willReturn(['echo "step 2: command 1', 'echo "step 2: command 2']);
        $this->getSteps()->willReturn([
            $step1,
            $step2,
        ]);

        $this->runCommand('echo "step 1: command 1')->shouldBeCalled();
        $this->runCommand('echo "step 1: command 2')->shouldBeCalled();
        $this->runCommand('echo "step 2: command 1')->shouldBeCalled();
        $this->runCommand('echo "step 2: command 2')->shouldBeCalled();

        $this->run();
    }

    public function it_logs_each_step(LoggerInterface $logger, DeployStep $step)
    {
        $logger->info('Starting "Step 1"')->shouldBeCalled();
        $logger->info('Finished "Step 1"')->shouldBeCalled();

        $this->getSteps()->willReturn([
            $step,
        ]);
        $this->run();
    }
}
