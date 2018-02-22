<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Registry;

use solutionDrive\MultiStepBundle\Exception\FlowNotFoundException;
use solutionDrive\MultiStepBundle\Factory\MultiStepFlowFactory;
use solutionDrive\MultiStepBundle\Model\MultiStepFlowInterface;

class MultiStepFlowRegistry implements MultiStepFlowRegistryInterface
{
    /** @var MultiStepFlowInterface[] */
    private $flows = [];

    /** @var MultiStepFlowInterface[] */
    private $flowsBySlug = [];

    /** @var MultiStepFlowFactory */
    private $flowFactory;

    public function __construct(MultiStepFlowFactory $flowFactory)
    {
        $this->flowFactory = $flowFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getFlows(): array
    {
        return $this->flows;
    }

    public function getFlowById(string $id): MultiStepFlowInterface
    {
        if (false === isset($this->flows[$id])) {
            throw new FlowNotFoundException($id);
        }
        return $this->flows[$id];
    }

    public function getFlowBySlug(string $slug): MultiStepFlowInterface
    {
        if (false === isset($this->flowsBySlug[$slug])) {
            throw new FlowNotFoundException('', $slug);
        }
        return $this->flowsBySlug[$slug];
    }

    public function addFlow(MultiStepFlowInterface $flow): void
    {
        $this->flows[$flow->getId()] = $flow;
        $this->flowsBySlug[$flow->getSlug()] = $flow;
    }

    /**
     * {@inheritdoc}
     */
    public function addByConfig(string $id, array $config): void
    {
        $this->addFlow($this->flowFactory->createFromConfig($id, $config));
    }
}
