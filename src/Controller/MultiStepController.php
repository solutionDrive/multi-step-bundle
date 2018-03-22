<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Controller;

use solutionDrive\MultiStepBundle\Factory\FlowContextFactoryInterface;
use solutionDrive\MultiStepBundle\Factory\MultistepRouterFactoryInterface;
use solutionDrive\MultiStepBundle\Registry\MultiStepFlowRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

class MultiStepController extends Controller
{
    /** @var MultiStepFlowRegistryInterface */
    private $flowRegistry;

    /** @var ControllerResolverInterface */
    private $controllerResolver;

    /** @var ArgumentResolverInterface */
    private $argumentResolver;
    /**
     * @var FlowContextFactoryInterface
     */
    private $flowContextFactory;
    /**
     * @var MultistepRouterFactoryInterface
     */
    private $stepRouterFactory;

    public function __construct(
        MultiStepFlowRegistryInterface $flowRegistry,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver,
        FlowContextFactoryInterface $flowContextFactory,
        MultistepRouterFactoryInterface $stepRouterFactory
    ) {
        $this->flowRegistry = $flowRegistry;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
        $this->flowContextFactory = $flowContextFactory;
        $this->stepRouterFactory = $stepRouterFactory;
    }

    public function stepAction(Request $request, string $flow_slug, string $step_slug): Response
    {
        $flow = $this->flowRegistry->getFlowBySlug($flow_slug);
        $flowContext = $this->flowContextFactory->create($flow, $step_slug);
        $router = $this->stepRouterFactory->create($request, $flow_slug);

        $step = $flowContext->getCurrentStep();
        $configuredController = $step->getControllerAction();

        $request->attributes->set('_controller', $configuredController);

        $callableController = $this->controllerResolver->getController($request);
        $arguments = $this->argumentResolver->getArguments($request, $callableController);

        $controller = $callableController[0];

        // set template if configured
        if ($controller instanceof TemplateAwareControllerInterface && '' !== $step->getTemplate()) {
            $controller->setTemplate($step->getTemplate());
        }

        // set flow context
        if ($controller instanceof StepAwareInterface) {
            $controller->setFlowContext($flowContext);
            $controller->setRouter($router);
        }

        // set flow
        if ($controller instanceof FlowAwareInterface) {
            $controller->setFlow($flow);
        }


        return call_user_func_array($callableController, $arguments);
    }

    public function firstStepAction(string $flow_slug): Response
    {
        $flow = $this->flowRegistry->getFlowBySlug($flow_slug);
        $firstStep = $flow->getFirstStep();
        $router = $this->get('router');
        $firstStepLink = $router->generate(
            'sd_multistep',
            ['flow_slug' => $flow_slug, 'step_slug' => $firstStep->getSlug()]
        );

        return new RedirectResponse($firstStepLink);
    }
}
