<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @author: Tobias Wojtylak <tw@solutiondrive.de>
 * @date: 22.03.18
 * @time: 11:22
 * @copyright: 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Router\MultistepRouter;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MultistepRouterFactory implements MultistepRouterFactoryInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function create(Request $request, string $flowSlug): MultistepRouterInterface
    {
        return new MultistepRouter($this->router, $request, $flowSlug);
    }
}
