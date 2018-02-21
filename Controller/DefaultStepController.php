<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Controller;

use sd\Morpheus\MultiStepBundle\Model\MultiStepFlowInterface;
use sd\Morpheus\MultiStepBundle\Model\MultiStepInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultStepController extends Controller implements TemplateAwareControllerInterface
{
    /** @var string */
    private $template = 'MultiStepBundle::default_step.html.twig';

    public function renderAction(MultiStepFlowInterface $flow, MultiStepInterface $step): Response
    {
        return $this->render($this->getTemplate(), [
            'flow' => $flow,
            'step' => $step,
        ]);
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }
}
