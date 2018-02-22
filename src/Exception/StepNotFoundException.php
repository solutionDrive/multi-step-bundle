<?php
declare(strict_types=1);

/*
 * Created by solutionDrive GmbH
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace solutionDrive\MultiStepBundle\Exception;

use Throwable;

class StepNotFoundException extends \RuntimeException
{
    /** @var string */
    private $id = '';

    /** @var string */
    private $slug = '';

    public function __construct(
        string $id = '',
        string $slug = '',
        string $message = '',
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->id = $id;
        $this->slug = $slug;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}
