<?php

namespace spec\PhpSpec\Formatter\Presenter\Differ;

<<<<<<< HEAD
=======
use PhpSpec\Exception\Example\FailureException;
>>>>>>> v2-test
use PhpSpec\ObjectBehavior;

class StringEngineSpec extends ObjectBehavior
{
    function it_is_a_diff_engine()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('PhpSpec\Formatter\Presenter\Differ\EngineInterface');
=======
        $this->shouldBeAnInstanceOf('PhpSpec\Formatter\Presenter\Differ\DifferEngine');
>>>>>>> v2-test
    }

    function it_supports_string_values()
    {
        $this->supports('string1', 'string2')->shouldReturn(true);
    }

    function it_calculates_strings_diff()
    {
        $expected = <<<DIFF
<code>
@@ -1,1 +1,1 @@
<diff-del>-string1</diff-del>
<diff-add>+string2</diff-add>
</code>
DIFF;

<<<<<<< HEAD
        $this->compare('string1', 'string2')->shouldReturn($expected);
    }
=======
        $this->compare('string1', 'string2')->shouldBeEqualRegardlessOfLineEndings($expected);
    }

    public function getMatchers(): array
    {
        return [
            'beEqualRegardlessOfLineEndings' => function ($actual, $expected) {
                $actual = str_replace("\r", '', $actual);
                if ($actual !== $expected) {
                    throw new FailureException('Strings are not equal.');
                }

                return true;
            }
        ];
    }

>>>>>>> v2-test
}
