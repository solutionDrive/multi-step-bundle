<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Model\MultiStepInterface;

interface StepAwareInterface
{
    public function getStep(): ?MultiStepInterface;

    public function setStep(?MultiStepInterface $step): void;
}
