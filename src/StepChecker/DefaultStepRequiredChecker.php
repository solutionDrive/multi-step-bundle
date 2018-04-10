<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\StepChecker;

class DefaultStepRequiredChecker implements StepRequiredCheckerInterface
{
    public function check(): bool
    {
        return true;
    }
}
