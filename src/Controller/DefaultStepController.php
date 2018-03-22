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
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;
use solutionDrive\MultiStepBundle\Router\MultistepRouterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultStepController extends Controller implements TemplateAwareControllerInterface, FlowAwareInterface
{
    /** @var string */
    private $template = 'MultiStepBundle::default_step.html.twig';

    /** @var FlowContext */
    private $flowContext;

    /** @var MultistepRouterInterface */
    private $router;

    public function renderAction(Request $request): Response
    {
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
            'flow' => $this->flowContext->getFlow(),
            'step' => $this->flowContext->getCurrentStep(),
        ];
    }

    /**
     * Redirects the user to the next step of the flow.
     * Throws an NoNextOrPreviousStepException if there isn't any next step.
     */
    public function redirectToNextStep(int $statusCode = 302): RedirectResponse
    {
        return $this->redirectToStep($this->getNextStep(), $statusCode);
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
