<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Registry;

use sd\Morpheus\MultiStepBundle\Model\MultiStepFlowInterface;

interface MultiStepFlowRegistryInterface
{
    /**
     * @return MultiStepFlowInterface[]
     */
    public function getFlows(): array;

    public function addFlow(MultiStepFlowInterface $flow): void;

    public function getFlowById(string $id): MultiStepFlowInterface;

    public function getFlowBySlug(string $slug): MultiStepFlowInterface;

    /**
     * @param string[][] $config
     */
    public function addByConfig(string $id, array $config): void;
}
