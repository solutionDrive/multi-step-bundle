<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Controller;

use solutionDrive\MultiStepBundle\Context\FlowContext;
use solutionDrive\MultiStepBundle\Context\FlowContextInterface;
use solutionDrive\MultiStepBundle\Exception\NoNextOrPreviousStepException;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultStepController extends Controller implements TemplateAwareControllerInterface, StepAwareInterface, FlowAwareInterface
{
    /** @var string */
    private $template = 'MultiStepBundle::default_step.html.twig';

    /** @var MultiStepFlowInterface */
    private $flow;

    /** @var FlowContext */
    private $flowContext;

    /** @var MultistepRouterInterface */
    private $router;

    public function renderAction(Request $request): Response
    {
        // Enable simple navigation
        if ('next' === $request->get('navigate_to_direction')) {
            return $this->redirectToNextStep();
        } elseif ('previous' === $request->get('navigate_to_direction')) {
            return $this->redirectToPreviousStep();
        }

        // Render template for current step
        return $this->render($this->getTemplate(), $this->getTemplateVariables());
    }

    /**
     * Returns a widely usable array of template variables.
     * Look here into function definition to see which variables are provided exactly.
     *
     * @return mixed[]
     */
    public function getTemplateVariables(): array
    {
        return [
            'flow' => $this->getFlow(),
            'step' => $this->getStep(),
            'hasNextStep' => $this->hasNextStep(),
            'hasPreviousStep' => $this->hasPreviousStep(),
            'nextStepLink' => $this->getNextStepLink(),
            'previousStepLink' => $this->getPreviousStepLink(),
        ];
    }

    /**
     * Redirects the user to the next step of the flow.
     * Throws an NoNextOrPreviousStepException if there isn't any next step.
     */
    public function redirectToNextStep(int $statusCode = 302): RedirectResponse
    {
        return $this->redirectToStep($this->getNextStepLink(), $statusCode);
    }

    /**
     * Redirects the user to the previous step of the flow.
     * Throws an NoNextOrPreviousStepException if there isn't any previous step.
     */
    public function redirectToPreviousStep(int $statusCode = 302): RedirectResponse
    {
        return $this->redirectToStep($this->getPreviousStep(), $statusCode);
    }

    protected function redirectToStep(MultiStepInterface $step, int $statusCode): RedirectResponse
    {
        if (null === $step) {
            throw new NoNextOrPreviousStepException();
        }
        return $this->redirect($this->router->generateStepLink($step), $statusCode);
    }

    /**
     * Returns true if there is a next step in the flow.
     */
    public function hasNextStep(): bool
    {
        return $this->flowContext->hasNextStep();
    }

    /**
     * Returns true if there is a previous step in the flow.
     */
    public function hasPreviousStep(): bool
    {
        return $this->flowContext->hasPreviousStep();
    }

    /**
     * Returns the configured template.
     * Can be overriden in step definition, see README.md for details.
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Overrides the defaulte template path.
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getNextStep(): ?MultiStepInterface
    {
        return $this->flowContext->getNextStep();
    }

    public function getPreviousStep(): ?MultiStepInterface
    {
        return $this->flowContext->getPreviousStep();
    }

    public function getNextStepLink(): ?string
    {
        return $this->hasNextStep() ? $this->router->generateStepLink($this->getNextStep()) : null;
    }

    public function getPreviousStepLink(): ?string
    {
        return $this->hasPreviousStep() ? $this->router->generateStepLink($this->getPreviousStep()) : null;
    }

    public function getFlow(): ?MultiStepFlowInterface
    {
        return $this->flow;
    }

    public function setFlow(?MultiStepFlowInterface $flow): void
    {
        $this->flow = $flow;
    }

    public function getStep(): ?MultiStepInterface
    {
        return $this->flowContext->getCurrentStep();
    }

    public function getFlowContext(): FlowContextInterface
    {
        return $this->flowContext;
    }

    public function setFlowContext(FlowContextInterface $flowContext): void
    {
        $this->flowContext = $flowContext;
    }

    public function setRouter(MultistepRouterInterface $router): void
    {
        $this->router = $router;
    }

    public function getRouter(): MultistepRouterInterface
    {
        return $this->router;
    }
}
