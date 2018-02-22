<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Registry;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Exception\FlowNotFoundException;
use solutionDrive\MultiStepBundle\Factory\MultiStepFlowFactory;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;
use solutionDrive\MultiStepBundle\Registry\MultiStepFlowRegistry;

class MultiStepFlowRegistrySpec extends ObjectBehavior
{
    function let(
        MultiStepFlowFactory $flowFactory,
        MultiStepFlowInterface $flow
    ) {
        $this->beConstructedWith($flowFactory);

        $flow->getId()->willReturn('defaulttestid');
        $flow->getSlug()->willReturn('defaulttestslug');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MultiStepFlowRegistry::class);
    }

    function it_can_have_flows(
        MultiStepFlowInterface $flow
    ) {
        $this->addFlow($flow);
        $this->getFlows()->shouldContain($flow);
    }

    function it_can_create_flow_from_config(
        MultiStepFlowInterface $flow,
        MultiStepFlowFactory $flowFactory
    ) {
        $flowFactory->createFromConfig('testid', ['slug' => 'testslug'])->shouldBeCalled()->willReturn($flow);
        $this->addByConfig('testid', ['slug' => 'testslug']);
    }

    function it_can_get_flow_by_id(
        MultiStepFlowInterface $flow
    ) {
        $flow->getId()->willReturn('testid');
        $this->addFlow($flow);
        $this->getFlowById('testid')->shouldReturn($flow);
    }

    function it_can_throw_exception_on_get_flow_by_id() {
        $this->shouldThrow(FlowNotFoundException::class)->during('getFlowById', ['testid']);
    }

    function it_can_get_flow_by_slug(
        MultiStepFlowInterface $flow
    ) {
        $flow->getSlug()->willReturn('testslug');
        $this->addFlow($flow);
        $this->getFlowBySlug('testslug')->shouldReturn($flow);
    }

    function it_can_throw_exception_on_get_flow_by_slug() {
        $this->shouldThrow(FlowNotFoundException::class)->during('getFlowBySlug', ['testslug']);
    }
}
