<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Factory;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Factory\MultiStepFactory;
use solutionDrive\MultiStepBundle\Factory\MultiStepFlowFactory;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

class MultiStepFlowFactorySpec extends ObjectBehavior
{
    function let(
        MultiStepFactory $stepFactory,
        MultiStepInterface $step1
    ) {
        $this->beConstructedWith($stepFactory);

        $step1->getId()->willReturn('default-test-id');
        $step1->getSlug()->willReturn('default-test-slug');
    }

    function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf(MultiStepFlowFactory::class);
    }

    function it_can_create_flow(
        MultiStepFactory $stepFactory,
        MultiStepInterface $step1
    ) {
        $step1config = [
            'alias'         => 'TestAlias',
            'slug'          => 'TestSlug',
            'controller'    => 'TestController',
        ];
        $config = [
            'slug'          => 'TestFlowSlug',
            'steps' => [
                'enter_code' => $step1config,
            ]
        ];

        $stepFactory->createFromConfig('enter_code', $step1config)->shouldBeCalled()->willReturn($step1);

        $flow = $this->createFromConfig('testid', $config);
        $flow->getId()->shouldReturn('testid');
        $flow->getSlug()->shouldReturn('TestFlowSlug');
        $flow->getSteps()->shouldContain($step1);
    }
}
