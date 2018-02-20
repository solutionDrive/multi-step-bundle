<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Factory;

use sd\Morpheus\MultiStepBundle\Model\MultiStep;
use sd\Morpheus\MultiStepBundle\Model\MultiStepInterface;

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
        $step->setControllerAction($config['controller']);
        return $step;
    }
}
