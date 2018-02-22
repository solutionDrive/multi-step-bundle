<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Model\MultiStepInterface;

interface StepDirectionAwareInterface
{
    public function getNextStep(): ?MultiStepInterface;

    public function setNextStep(?MultiStepInterface $step): void;

    public function getNextStepLink(): ?string;

    public function setNextStepLink(?string $link): void;

    public function getPreviousStep(): ?MultiStepInterface;

    public function setPreviousStep(?MultiStepInterface $step): void;

    public function getPreviousStepLink(): ?string;

    public function setPreviousStepLink(?string $link): void;
}
