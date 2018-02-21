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

    public function __construct(
        MultiStepFlowRegistryInterface $flowRegistry,
        ControllerResolverInterface $controllerResolver,
        ArgumentResolverInterface $argumentResolver
    ) {
        $this->flowRegistry = $flowRegistry;
        $this->controllerResolver = $controllerResolver;
        $this->argumentResolver = $argumentResolver;
    }

    public function stepAction(Request $request, string $flow_slug, string $step_slug)
    {
        $flow = $this->flowRegistry->getFlowBySlug($flow_slug);
        $step = $flow->getStepBySlug($step_slug);
        $configuredController = $step->getControllerAction();

        $request->attributes->set('_controller', $configuredController);
        $request->attributes->set('flow', $flow);
        $request->attributes->set('step', $step);

        $callableController = $this->controllerResolver->getController($request);
        $arguments = $this->argumentResolver->getArguments($request, $callableController);

        $controller = $callableController[0];
        if ($controller instanceof TemplateAwareControllerInterface && $step->getTemplate() !== '') {
            $controller->setTemplate($step->getTemplate());
        }

        return call_user_func_array($callableController, $arguments);
    }
}
