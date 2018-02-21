<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Model;

class MultiStep implements MultiStepInterface
{
    /** @var string */
    private $id = '';

    /** @var string */
    private $alias = '';

    /** @var string */
    private $slug = '';

    /** @var string */
    private $template = '';

    /** @var string */
    private $controllerAction = '';

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * {@inheritdoc}
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    /**
     * {@inheritdoc}
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * {@inheritdoc}
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    /**
     * {@inheritdoc}
     */
    public function getControllerAction(): string
    {
        return $this->controllerAction;
    }

    /**
     * {@inheritdoc}
     */
    public function setControllerAction(string $controllerAction): void
    {
        $this->controllerAction = $controllerAction;
    }
}
