<?php
declare(strict_types=1);

/**
 * Created by solutionDrive GmbH.
 *
 * @copyright 2018 solutionDrive GmbH
 */

namespace spec\solutionDrive\MultiStepBundle\Factory;

use PhpSpec\ObjectBehavior;
use solutionDrive\MultiStepBundle\Factory\MultiStepFactory;

class MultiStepFactorySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldBeAnInstanceOf(MultiStepFactory::class);
    }

    function it_can_create_step()
    {
        $config = [
            'alias'         => 'TestAlias',
            'slug'          => 'TestSlug',
            'template'      => 'TestTemplate',
            'controller'    => 'TestController',
            'skippable'     => true,
        ];

        $step = $this->createFromConfig('test_id', $config);
        $step->getId()->shouldReturn('test_id');
        $step->getAlias()->shouldReturn('TestAlias');
        $step->getSlug()->shouldReturn('TestSlug');
        $step->getTemplate()->shouldReturn('TestTemplate');
        $step->getControllerAction()->shouldReturn('TestController');
        $step->isSkippable()->shouldReturn(true);
    }
}
