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

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function setTemplate(string $template): void
    {
        $this->template = $template;
    }

    public function getControllerAction(): string
    {
        return $this->controllerAction;
    }

    public function setControllerAction(string $controllerAction): void
    {
        $this->controllerAction = $controllerAction;
    }
}
