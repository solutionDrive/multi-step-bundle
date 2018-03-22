<?php
/**
 * Created by solutionDrive GmbH.
 *
 * @author: Tobias Wojtylak <tw@solutiondrive.de>
 * @date: 22.03.18
 * @time: 11:25
 * @copyright: 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Component\HttpFoundation\Request;

interface MultistepRouterFactoryInterface
{
    public function create(Request $request, string $flowSlug): MultistepRouterInterface;
}
