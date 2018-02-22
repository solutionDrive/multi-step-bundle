<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Controller;

use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;

interface FlowAwareInterface
{
    public function getFlow(): ?MultiStepFlowInterface;

    public function setFlow(?MultiStepFlowInterface $flow): void;
}
