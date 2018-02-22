<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Registry\MultiStepFlowRegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing\RouterInterface;

class MultiStepController extends Controller
{
    /** @var MultiStepFlowRegistryInterface */
    private $flowRegistry;

    /** @var ControllerResolverInterface */
    private $controllerResolver;

    /** @var ArgumentResolverInterface */
    private $argumentResolver;

    public function __construct(
        MultiStepFlowRegistryInterface $flowRegistry,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver
    ) {
        $this->flowRegistry = $flowRegistry;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function stepAction(Request $request, string $flow_slug, string $step_slug): Response
    {
        $flow = $this->flowRegistry->getFlowBySlug($flow_slug);
        $step = $flow->getStepBySlug($step_slug);
        $configuredController = $step->getControllerAction();

        $request->attributes->set('_controller', $configuredController);

        $currentRoute = $request->get('_route');

        $callableController = $this->controllerResolver->getController($request);
        $arguments = $this->argumentResolver->getArguments($request, $callableController);

        $controller = $callableController[0];

        // set template if configured
        if ($controller instanceof TemplateAwareControllerInterface && '' !== $step->getTemplate()) {
            $controller->setTemplate($step->getTemplate());
        }

        // set previous and next steps
        if ($controller instanceof StepDirectionAwareInterface) {
            /** @var RouterInterface $router */
            $router = $this->get('router');
            $nextStep = $flow->getStepAfter($step);
            $previousStep = $flow->getStepBefore($step);

            if (null !== $nextStep) {
                $nextStepLink = $router->generate(
                    $currentRoute,
                    ['flow_slug' => $flow_slug, 'step_slug' => $nextStep->getSlug()]
                );
                $controller->setNextStep($nextStep);
                $controller->setNextStepLink($nextStepLink);
            }
            if (null !== $previousStep) {
                $previousStepLink = $router->generate(
                    $currentRoute,
                    ['flow_slug' => $flow_slug, 'step_slug' => $previousStep->getSlug()]
                );
                $controller->setPreviousStep($previousStep);
                $controller->setPreviousStepLink($previousStepLink);
            }
        }

        // set flow
        if ($controller instanceof FlowAwareInterface) {
            $controller->setFlow($flow);
        }

        // set step
        if ($controller instanceof StepAwareInterface) {
            $controller->setStep($step);
        }

        return call_user_func_array($callableController, $arguments);
    }
}
