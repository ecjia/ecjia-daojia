<?php

namespace spec\PhpSpec\Formatter\Presenter\Differ;

use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
use PhpSpec\Formatter\Presenter\Differ\EngineInterface;
=======
use PhpSpec\Formatter\Presenter\Differ\DifferEngine;
>>>>>>> v2-test

class DifferSpec extends ObjectBehavior
{
    function it_chooses_proper_engine_based_on_values(
<<<<<<< HEAD
        EngineInterface $engine1, EngineInterface $engine2
=======
        DifferEngine $engine1, DifferEngine $engine2
>>>>>>> v2-test
    ) {
        $engine1->supports('string1', 'string2')->willReturn(true);
        $engine2->supports('string1', 'string2')->willReturn(false);
        $engine1->compare('string1', 'string2')->willReturn('string1 !== string2');

        $engine1->supports(2, 1)->willReturn(false);
        $engine2->supports(2, 1)->willReturn(true);
        $engine2->compare(2, 1)->willReturn('2 !== 1');

        $this->addEngine($engine1);
        $this->addEngine($engine2);

        $this->compare('string1', 'string2')->shouldReturn('string1 !== string2');
        $this->compare(2, 1)->shouldReturn('2 !== 1');
    }

    function it_returns_null_if_engine_not_found()
    {
        $this->compare(1, 2)->shouldReturn(null);
    }

<<<<<<< HEAD
    function its_constructor_allows_a_list_of_engines(EngineInterface $engine)
=======
    function its_constructor_allows_a_list_of_engines(DifferEngine $engine)
>>>>>>> v2-test
    {
        $this->beConstructedWith(array($engine));
        $engine->supports('string1', 'string2')->willReturn(true);
        $engine->compare('string1', 'string2')->willReturn('string1 !== string2');

        $this->compare('string1', 'string2')->shouldReturn('string1 !== string2');
    }
}
