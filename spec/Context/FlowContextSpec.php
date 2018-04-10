<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Context;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use solutionDrive\MultiStepBundle\Context\FlowContext;
use solutionDrive\MultiStepBundle\Context\FlowContextInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;
use solutionDrive\MultiStepBundle\StepChecker\StepRequiredCheckerInterface;

class FlowContextSpec extends ObjectBehavior
{
    public function let(MultiStepFlowInterface $flow, MultiStepInterface $currentStep): void
    {
        $flow->getStepBySlug('step')->willReturn($currentStep);
        $this->beConstructedWith($flow, 'step');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(FlowContext::class);
    }

    public function it_implements_step_direction_context_interface(): void
    {
        $this->shouldImplement(FlowContextInterface::class);
    }

    public function it_returns_current_step(MultiStepInterface $currentStep): void
    {
        $this->getCurrentStep()->shouldBe($currentStep);
    }

    public function it_returns_direct_successor_as_next_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $nextStep,
        StepRequiredCheckerInterface $stepRequiredChecker
    ): void {
        $stepRequiredChecker->check()->shouldBeCalled()->willReturn(true);
        $nextStep->getStepRequiredChecker()->willReturn($stepRequiredChecker);
        $flow->getStepAfter(Argument::any())->shouldBeCalled()->willReturn($nextStep);
        $this->getNextStep()->shouldBe($nextStep);
    }

    public function it_returns_step_after_successor_as_next_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $currentStep,
        MultiStepInterface $nextStep,
        MultiStepInterface $nextStepAfter,
        StepRequiredCheckerInterface $stepRequiredCheckerNext,
        StepRequiredCheckerInterface $stepRequiredCheckerAfterNext
    ): void {

        $stepRequiredCheckerNext->check()->shouldBeCalled()->willReturn(false);
        $nextStep->getStepRequiredChecker()->willReturn($stepRequiredCheckerNext);

        $stepRequiredCheckerAfterNext->check()->shouldBeCalled()->willReturn(true);
        $nextStepAfter->getStepRequiredChecker()->willReturn($stepRequiredCheckerAfterNext);

        $flow->getStepAfter($currentStep)->shouldBeCalled()->willReturn($nextStep);
        $flow->getStepAfter($nextStep)->shouldBeCalled()->willReturn($nextStepAfter);
        $this->getNextStep()->shouldBe($nextStepAfter);
    }

    public function it_returns_direct_predecessor_previous_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $previousStep,
        StepRequiredCheckerInterface $stepRequiredChecker
    ): void
    {
        $stepRequiredChecker->check()->shouldBeCalled()->willReturn(true);
        $previousStep->getStepRequiredChecker()->willReturn($stepRequiredChecker);
        $flow->getStepBefore(Argument::any())->shouldBeCalled()->willReturn($previousStep);
        $this->getPreviousStep()->shouldBe($previousStep);
    }

    public function it_returns_step_before_predecessor_as_previous_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $currentStep,
        MultiStepInterface $previousStep,
        MultiStepInterface $prviousStepBefore,
        StepRequiredCheckerInterface $stepRequiredCheckerPrevious,
        StepRequiredCheckerInterface $stepRequiredCheckerBeforePrevious
    ): void {

        $stepRequiredCheckerPrevious->check()->shouldBeCalled()->willReturn(false);
        $previousStep->getStepRequiredChecker()->willReturn($stepRequiredCheckerPrevious);

        $stepRequiredCheckerBeforePrevious->check()->shouldBeCalled()->willReturn(true);
        $prviousStepBefore->getStepRequiredChecker()->willReturn($stepRequiredCheckerBeforePrevious);

        $flow->getStepBefore($currentStep)->shouldBeCalled()->willReturn($previousStep);
        $flow->getStepBefore($previousStep)->shouldBeCalled()->willReturn($prviousStepBefore);
        $this->getPreviousStep()->shouldBe($prviousStepBefore);
    }

    public function it_returns_false_for_has_next_step(MultiStepFlowInterface $flow): void
    {
        $flow->getStepAfter(Argument::any())->willReturn(null);
        $this->hasNextStep()->shouldBe(false);
    }

    public function it_returns_true_for_has_next_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $nextStep,
        StepRequiredCheckerInterface $stepRequiredChecker
    ): void {
        $stepRequiredChecker->check()->shouldBeCalled()->willReturn(true);
        $nextStep->getStepRequiredChecker()->willReturn($stepRequiredChecker);
        $flow->getStepAfter(Argument::any())->willReturn($nextStep);
        $this->hasNextStep()->shouldBe(true);
    }

    public function it_returns_false_for_has_previous_step(MultiStepFlowInterface $flow): void
    {
        $flow->getStepBefore(Argument::any())->willReturn(null);
        $this->hasPreviousStep()->shouldBe(false);
    }

    public function it_returns_true_for_has_previous_step(
        MultiStepFlowInterface $flow,
        MultiStepInterface $previousStep,
        StepRequiredCheckerInterface $stepRequiredChecker
    ): void {
        $stepRequiredChecker->check()->shouldBeCalled()->willReturn(true);
        $previousStep->getStepRequiredChecker()->willReturn($stepRequiredChecker);
        $flow->getStepBefore(Argument::any())->willReturn($previousStep);
        $this->hasPreviousStep()->shouldBe(true);
    }

    public function it_returns_flow(MultiStepFlowInterface $flow): void
    {
        $this->getFlow()->shouldBe($flow);
    }
}
