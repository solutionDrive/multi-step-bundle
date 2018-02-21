<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Model;

use sd\Morpheus\MultiStepBundle\Exception\StepNotFoundException;

class MultiStepFlow implements MultiStepFlowInterface
{
    /** @var string */
    private $id = '';

    /** @var string */
    private $slug = '';

    /** @var MultiStepInterface[] */
    private $steps = [];

    /** @var MultiStepInterface[] */
    private $stepsBySlug = [];

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return MultiStep[]
     */
    public function getSteps(): array
    {
        return $this->steps;
    }

    public function getStepById(string $id): MultiStepInterface
    {
        if (false === isset($this->steps[$id])) {
            throw new StepNotFoundException($id);
        }
        return $this->steps[$id];
    }

    public function getStepBySlug(string $slug): MultiStepInterface
    {
        if (false === isset($this->stepsBySlug[$slug])) {
            throw new StepNotFoundException('', $slug);
        }
        return $this->stepsBySlug[$slug];
    }

    public function addStep(MultiStepInterface $step): void
    {
        $this->steps[$step->getId()] = $step;
        $this->stepsBySlug[$step->getSlug()] = $step;
    }
}
