<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Controller;

interface TemplateAwareControllerInterface
{
    public function getTemplate(): string;

    public function setTemplate(string $template): void;
}
