<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Model;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Model\MultiStep;
use solutionDrive\MultiStepBundle\Model\MultiStepInterface;

final class MultiStepSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf(MultiStep::class);
    }

    function it_implements_multi_step_interface()
    {
        $this->shouldImplement(MultiStepInterface::class);
    }

    function it_has_alias()
    {
        $value = 'test';
        $this->setAlias($value);
        $this->getAlias()->shouldReturn($value);
    }

    function it_has_id()
    {
        $value = 'test';
        $this->setId($value);
        $this->getId()->shouldReturn($value);
    }

    function it_has_slug()
    {
        $value = 'test';
        $this->setSlug($value);
        $this->getSlug()->shouldReturn($value);
    }

    function it_has_template()
    {
        $value = 'test';
        $this->setTemplate($value);
        $this->getTemplate()->shouldReturn($value);
    }

    function it_has_controller_action()
    {
        $value = 'test';
        $this->setControllerAction($value);
        $this->getControllerAction()->shouldReturn($value);
    }
}
