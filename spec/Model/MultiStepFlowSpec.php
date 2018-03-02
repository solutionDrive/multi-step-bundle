<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Model;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Exception\StepNotFoundException;
use solutionDrive\MultiStepBundle\Model\MultiStepFlow;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

final class MultiStepFlowSpec extends ObjectBehavior
{
    function let(
        MultiStepInterface $step
    ) {
        $step->getId()->willReturn('default-test-id');
        $step->getSlug()->willReturn('default-test-slug');
    }

    function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf(MultiStepFlow::class);
    }

    function it_implements_multi_step_flow_interface()
    {
        $this->shouldImplement(MultiStepFlowInterface::class);
    }

    function it_has_id() {
        $value = 'test';
        $this->setId($value);
        $this->getId()->shouldReturn($value);
    }

    function it_has_steps(
        MultiStepInterface $step
    ) {
        $this->addStep($step);
        $this->getSteps()->shouldContain($step);
    }

    function it_has_slug() {
        $this->setSlug('testslug');
        $this->getSlug()->shouldReturn('testslug');
    }

    function it_can_get_step_by_id(
        MultiStepInterface $step
    ) {
        $step->getId()->willReturn('testid');
        $this->addStep($step);
        $this->getStepById('testid')->shouldReturn($step);
    }

    function it_can_throw_exception_on_get_step_by_id() {
        $this->shouldThrow(StepNotFoundException::class)->during('getStepById', ['testid']);
    }

    function it_can_get_step_by_slug(
        MultiStepInterface $step
    ) {
        $step->getSlug()->willReturn('testslug');
        $this->addStep($step);
        $this->getStepBySlug('testslug')->shouldReturn($step);
    }

    function it_can_throw_exception_on_get_step_by_slug() {
        $this->shouldThrow(StepNotFoundException::class)->during('getStepBySlug', ['testslug']);
    }

    function it_can_get_step_before_another(
        MultiStepInterface $stepCurrent,
        MultiStepInterface $stepBefore
    ) {
        $stepBefore->getId()->willReturn('step-before');
        $stepBefore->getSlug()->willReturn('step-before');
        $stepCurrent->getId()->willReturn('step-current');
        $stepCurrent->getSlug()->willReturn('step-current');
        $this->addStep($stepBefore);
        $this->addStep($stepCurrent);

        $this->getStepBefore($stepCurrent)->shouldReturn($stepBefore);
    }

    function it_can_not_get_step_before_first(
        MultiStepInterface $stepCurrent
    ) {
        $stepCurrent->getId()->willReturn('step-current');
        $stepCurrent->getSlug()->willReturn('step-current');
        $this->addStep($stepCurrent);

        $this->getStepBefore($stepCurrent)->shouldReturn(null);
    }

    function it_can_get_step_after_another(
        MultiStepInterface $stepCurrent,
        MultiStepInterface $stepAfter
    ) {
        $stepCurrent->getId()->willReturn('step-current');
        $stepCurrent->getSlug()->willReturn('step-current');
        $stepAfter->getId()->willReturn('step-after');
        $stepAfter->getSlug()->willReturn('step-after');
        $this->addStep($stepCurrent);
        $this->addStep($stepAfter);

        $this->getStepAfter($stepCurrent)->shouldReturn($stepAfter);
    }

    function it_can_not_get_step_after_last(
        MultiStepInterface $stepCurrent
    ) {
        $stepCurrent->getId()->willReturn('step-current');
        $stepCurrent->getSlug()->willReturn('step-current');
        $this->addStep($stepCurrent);

        $this->getStepAfter($stepCurrent)->shouldReturn(null);
    }

    function it_can_get_first_step(
        MultiStepInterface $firstStep
    ) {
        $firstStep->getId()->willReturn('first-step');
        $firstStep->getSlug()->willReturn('first-step');
        $this->addStep($firstStep);

        $this->getFirstStep()->shouldReturn($firstStep);
    }
}
