<?php declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Component\HttpFoundation\Request;

interface MultistepRouterFactoryInterface
{
    public function create(Request $request, string $flowSlug): MultistepRouterInterface;
}
