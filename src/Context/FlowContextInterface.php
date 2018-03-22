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

interface FlowContextInterface
{
    public function getCurrentStep(): MultiStepInterface;

    public function getNextStep(): ?MultiStepInterface;

    public function getPreviousStep(): ?MultiStepInterface;

    public function hasNextStep(): bool;

    public function hasPreviousStep(): bool;

    public function getFlow(): MultiStepFlowInterface;
}
