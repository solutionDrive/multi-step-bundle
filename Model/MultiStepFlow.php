<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Model;

class MultiStepFlow implements MultiStepFlowInterface
{
    /** @var string */
    private $id = '';

    /** @var MultiStepInterface[] */
    private $steps = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return MultiStep[]
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function addStep(MultiStepInterface $step): void
    {
        $this->steps[] = $step;
    }
}
