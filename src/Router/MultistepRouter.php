<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Router;

use solutionDrive\MultiStepBundle\Model\MultiStepInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MultistepRouter implements MultistepRouterInterface
{
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var string
     */
    private $flowSlug;
    /**
     * @var Request
     */
    private $request;

    public function __construct(RouterInterface $router, Request $request, string $flowSlug)
    {
        $this->router = $router;
        $this->flowSlug = $flowSlug;
        $this->request = $request;
    }

    public function generateStepLink(MultiStepInterface $step): string
    {
        $routeParams = [
            'flow_slug' => $this->flowSlug,
            'step_slug' => $step->getSlug(),
        ];
        return $this->router->generate($this->request->get('_route'), $routeParams);
    }
}
