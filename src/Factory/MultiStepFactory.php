<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Model\MultiStep;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

class MultiStepFactory
{
    /**
     * @param string   $id     ID of this step
     * @param string[] $config Complex configuration array of this step
     */
    public function createFromConfig(string $id, array $config): MultiStepInterface
    {
        $step = new MultiStep();
        $step->setId($id);
        $step->setAlias($config['alias']);
        $step->setSlug($config['slug']);
        $step->setTemplate($config['template']);
        $step->setControllerAction($config['controller']);
        return $step;
    }
}
