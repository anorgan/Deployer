<?php

namespace spec\Deployer;

use Deployer\Config;
use Deployer\DeployStep;
use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class RunnerSpec extends ObjectBehavior
{
    public function let(Config $config, LoggerInterface $logger, DeployStep $step1, DeployStep $step2)
    {
        $step1->getTitle()->willReturn('Step 1');
        $step2->getTitle()->willReturn('Step 2');
        $step1->getCommands()->willReturn(['echo "step 1: command 1"', 'echo "step 1: command 2"']);
        $step2->getCommands()->willReturn(['echo "step 2: command 1"', 'echo "step 2: command 2"']);
        $config->offsetGet('steps')->willReturn([
            $step1,
            $step2,
        ]);
        $this->beConstructedWith($config, $logger);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Deployer\Runner');
    }

    public function it_runs_commands_in_correct_order_and_logs_them(LoggerInterface $logger)
    {
        $logger->info('Starting "Step 1"')->shouldBeCalled();
        $logger->info('Running "echo "step 1: command 1""')->shouldBeCalled();
        $logger->info('Running "echo "step 1: command 2""')->shouldBeCalled();
        $logger->info('Finished "Step 1"')->shouldBeCalled();

        $logger->info('Starting "Step 2"')->shouldBeCalled();
        $logger->info('Running "echo "step 2: command 1""')->shouldBeCalled();
        $logger->info('Running "echo "step 2: command 2""')->shouldBeCalled();
        $logger->info('Finished "Step 2"')->shouldBeCalled();

        $this->run();
    }
}
