<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Factory;

use solutionDrive\MultiStepBundle\Model\MultiStepFlow;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;

class MultiStepFlowFactory
{
    /** @var MultiStepFactory */
    private $stepFactory;

    public function __construct(MultiStepFactory $stepFactory)
    {
        $this->stepFactory = $stepFactory;
    }

    /**
     * @param string     $id     The ID of the flow
     * @param string[][] $config The configuration (steps) of the flow
     */
    public function createFromConfig(string $id, array $config): MultiStepFlowInterface
    {
        $flow = new MultiStepFlow();
        $flow->setId($id);
        if (true === isset($config['slug'])) {
            $flow->setSlug((string) $config['slug']);
        } else {
            $flow->setSlug($id);
        }
        foreach ($config['steps'] as $key => $value) {
            $step = $this->stepFactory->createFromConfig($key, $value);
            $flow->addStep($step);
        }
        return $flow;
    }
}
