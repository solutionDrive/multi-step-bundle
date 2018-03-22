<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Router;

use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

interface MultistepRouterInterface
{
    public function generateStepLink(MultiStepInterface $step): string;
}
