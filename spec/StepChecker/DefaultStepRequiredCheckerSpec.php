<?php

namespace spec\solutionDrive\MultiStepBundle\StepChecker;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\StepChecker\DefaultStepRequiredChecker;
use solutionDrive\MultiStepBundle\StepChecker\StepRequiredCheckerInterface;

class DefaultStepRequiredCheckerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DefaultStepRequiredChecker::class);
    }

    function it_implements_step_required_checker_interface()
    {
        $this->shouldImplement(StepRequiredCheckerInterface::class);
    }

    function it_returns_true()
    {
        $this->check()->shouldReturn(true);
    }
}
