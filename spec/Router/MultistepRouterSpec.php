<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Router;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Model\MultiStep;
use solutionDrive\MultiStepBundle\Router\MultistepRouter;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class MultistepRouterSpec extends ObjectBehavior
{
    /** @var string */
    private $flowSlug = 'build-gold-machine';

    function let(RouterInterface $router, Request $request): void
    {
        $this->beConstructedWith($router, $request, $this->flowSlug);
    }

    function it_is_initializable(): void
    {
        $this->shouldHaveType(MultistepRouter::class);
    }

    function it_should_implement_multistep_router_interface(): void
    {
        $this->shouldImplement(MultistepRouterInterface::class);
    }

    function it_can_generate_step_links(MultiStep $step, RouterInterface $router, Request $request): void
    {
        $stepLink = 'generated-link';
        $stepSlug = 'catch-smurfs';
        $routeName = 'multistep';
        $step->getSlug()->shouldBeCalled()->willReturn($stepSlug);

        $request->get('_route')->shouldBeCalled()->willReturn('multistep');

        $router
            ->generate($routeName, [
                'flow_slug' => $this->flowSlug,
                'step_slug' => $stepSlug,
            ])
            ->willReturn($stepLink);

        $this->generateStepLink($step)->shouldBe($stepLink);
    }
}
