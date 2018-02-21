<?php declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Model;

interface MultiStepFlowInterface
{
    public function getId(): string;

    public function setId(string $id): void;

    public function getSlug(): string;

    public function setSlug(string $slug): void;

    /**
     * @return MultiStepInterface[]
     */
    public function getSteps(): array;

    public function addStep(MultiStepInterface $step): void;
}
