<?php

namespace spec\solutionDrive\MultiStepBundle\Factory;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Factory\MultistepRouterFactory;
use solutionDrive\MultiStepBundle\Factory\MultistepRouterFactoryInterface;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MultistepRouterFactorySpec extends ObjectBehavior
{

    function let(RouterInterface $router): void
    {
        $this->beConstructedWith($router);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(MultistepRouterFactory::class);
    }

    function it_should_implement_multistep_router_factory_interface(): void
    {
        $this->shouldImplement(MultistepRouterFactoryInterface::class);
    }

    function it_can_create_multistep_router(Request $request): void
    {
        $this->create($request, 'flowSlug')->shouldBeAnInstanceOf(MultistepRouterInterface::class);
    }
}
