<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Exception\NoNextOrPreviousStepException;
use sd\Morpheus\MultiStepBundle\Model\MultiStepFlowInterface;
use sd\Morpheus\MultiStepBundle\Model\MultiStepInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultStepController extends Controller implements TemplateAwareControllerInterface, StepDirectionAwareInterface, FlowAwareInterface, StepAwareInterface
{
    /** @var string */
    private $template = 'MultiStepBundle::default_step.html.twig';

    /** @var MultiStepFlowInterface */
    private $flow;

    /** @var MultiStepInterface */
    private $step;

    /** @var MultiStepInterface|null */
    private $previousStep;

    /** @var MultiStepInterface|null */
    private $nextStep;

    /** @var string|null */
    private $previousStepLink;

    /** @var string|null */
    private $nextStepLink;

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
        if (null === $this->nextStepLink) {
            throw new NoNextOrPreviousStepException();
        }
        return $this->redirect($this->nextStepLink, $statusCode);
    }

    /**
     * Redirects the user to the previous step of the flow.
     * Throws an NoNextOrPreviousStepException if there isn't any previous step.
     */
    public function redirectToPreviousStep(int $statusCode = 302): RedirectResponse
    {
        if (null === $this->previousStepLink) {
            throw new NoNextOrPreviousStepException();
        }
        return $this->redirect($this->previousStepLink, $statusCode);
    }

    /**
     * Returns true if there is a next step in the flow.
     */
    public function hasNextStep(): bool
    {
        return null !== $this->nextStep;
    }

    /**
     * Returns true if there is a previous step in the flow.
     */
    public function hasPreviousStep(): bool
    {
        return null !== $this->previousStep;
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
        return $this->nextStep;
    }

    public function setNextStep(?MultiStepInterface $step): void
    {
        $this->nextStep = $step;
    }

    public function getPreviousStep(): ?MultiStepInterface
    {
        return $this->previousStep;
    }

    public function setPreviousStep(?MultiStepInterface $step): void
    {
        $this->previousStep = $step;
    }

    public function getNextStepLink(): ?string
    {
        return $this->nextStepLink;
    }

    public function setNextStepLink(?string $link): void
    {
        $this->nextStepLink = $link;
    }

    public function getPreviousStepLink(): ?string
    {
        return $this->previousStepLink;
    }

    public function setPreviousStepLink(?string $link): void
    {
        $this->previousStepLink = $link;
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
        return $this->step;
    }

    public function setStep(?MultiStepInterface $step): void
    {
        $this->step = $step;
    }
}
