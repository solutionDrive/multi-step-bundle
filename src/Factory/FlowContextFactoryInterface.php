<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Context\FlowContextInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;

interface FlowContextFactoryInterface
{
    public function create(MultiStepFlowInterface $flow, string $currentStepSlug): FlowContextInterface;
}
