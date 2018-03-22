<?php

namespace spec\solutionDrive\MultiStepBundle\Factory;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Context\FlowContext;
use solutionDrive\MultiStepBundle\Factory\FlowContextFactoryInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;

class FlowContextFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(FlowContextFactoryInterface::class);
    }

    function it_implements_flow_context_factory_interface()
    {
        $this->shouldImplement(FlowContextFactoryInterface::class);
    }

    function it_can_create_flow_context(MultiStepFlowInterface $flow)
    {
        $this->create($flow, 'slug')->shouldBeAnInstanceOf(FlowContext::class);
    }
}
