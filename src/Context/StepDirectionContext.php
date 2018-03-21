<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Context;

use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

class StepDirectionContext implements StepDirectionContextInterface
{
    /**
     * @var MultiStepFlowInterface
     */
    private $flow;

    /**
     * @var string
     */
    private $currentStepSlug;

    public function __construct(MultiStepFlowInterface $flow, string $currentStepSlug)
    {
        $this->flow = $flow;
        $this->currentStepSlug = $currentStepSlug;
    }

    public function getCurrentStep(): MultiStepInterface
    {
        return $this->flow->getStepBySlug($this->currentStepSlug);
    }

    public function getNextStep(): ?MultiStepInterface
    {
        $currentStep = $this->getCurrentStep();
        return $this->flow->getStepAfter($currentStep);
    }

    public function getPreviousStep(): ?MultiStepInterface
    {
        $currentStep = $this->getCurrentStep();
        return $this->flow->getStepBefore($currentStep);
    }

    public function hasNextStep(): bool
    {
        return null !== $this->getNextStep();
    }

    public function hasPreviousStep(): bool
    {
        return null !== $this->getPreviousStep();
    }

    public function getFlow(): MultiStepFlowInterface
    {
        return $this->flow;
    }
}
