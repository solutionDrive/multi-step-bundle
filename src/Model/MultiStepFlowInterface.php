<?php declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Model;

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

    public function getStepById(string $id): MultiStepInterface;

    public function getStepBySlug(string $slug): MultiStepInterface;

    public function getStepAfter(MultiStepInterface $currentStep): ?MultiStepInterface;

    public function getStepBefore(MultiStepInterface $currentStep): ?MultiStepInterface;

    public function addStep(MultiStepInterface $step): void;

    public function getFirstStep(): MultiStepInterface;
}
