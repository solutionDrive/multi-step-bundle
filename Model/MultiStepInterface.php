<?php declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace sd\Morpheus\MultiStepBundle\Model;

interface MultiStepInterface
{
    public function getId(): string;

    public function setId(string $id): void;

    public function getAlias(): string;

    public function setAlias(string $alias): void;

    public function getSlug(): string;

    public function setSlug(string $slug): void;

    public function getControllerAction(): string;

    public function setControllerAction(string $controllerAction): void;
}
