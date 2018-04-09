<?php
/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\StepChecker;

interface StepRequiredCheckerInterface
{
    public function check(FlowContextInterface $flowContext): bool;
}
