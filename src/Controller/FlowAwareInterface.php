<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Controller;

use solutionDrive\MultiStepBundle\Context\FlowContextInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;

interface FlowAwareInterface
{
    public function setFlowContext(FlowContextInterface $flowContext): void;

    public function getFlowContext(): FlowContextInterface;

    public function setRouter(MultistepRouterInterface $router): void;

    public function getRouter(): MultistepRouterInterface;

    public function getNextStep(): ?MultiStepInterface;

    public function getPreviousStep(): ?MultiStepInterface;
}
