<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Model\MultiStepFlowInterface;

interface FlowAwareInterface
{
    public function getFlow(): ?MultiStepFlowInterface;

    public function setFlow(?MultiStepFlowInterface $flow): void;
}
