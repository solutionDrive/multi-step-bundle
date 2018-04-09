<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\StepChecker;

use solutionDrive\MultiStepBundle\Context\FlowContextInterface;

class DefaultStepRequiredChecker implements StepRequiredCheckerInterface
{
    public function check(FlowContextInterface $flowContext): bool
    {
        return true;
    }
}
