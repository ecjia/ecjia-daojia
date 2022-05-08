<?php
<<<<<<< HEAD

namespace spec\PhpSpec\Matcher;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

use PhpSpec\Formatter\Presenter\PresenterInterface;

class ObjectStateMatcherSpec extends ObjectBehavior
{
    function let(PresenterInterface $presenter)
=======
declare(strict_types = 1);

namespace spec\PhpSpec\Matcher;

use PhpSpec\Formatter\Presenter\Presenter;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ObjectStateMatcherSpec extends ObjectBehavior
{
    function let(Presenter $presenter)
>>>>>>> v2-test
    {
        $presenter->presentValue(Argument::any())->willReturn('val1', 'val2');
        $presenter->presentString(Argument::any())->willReturnArgument();

        $this->beConstructedWith($presenter);
    }

    function it_is_a_matcher()
    {
<<<<<<< HEAD
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\MatcherInterface');
=======
        $this->shouldBeAnInstanceOf('PhpSpec\Matcher\Matcher');
>>>>>>> v2-test
    }

    function it_infers_matcher_alias_name_from_methods_prefixed_with_is()
    {
        $subject = new \ReflectionClass($this);

<<<<<<< HEAD
        $this->supports('beAbstract', $subject, array())->shouldReturn(true);
=======
        $this->supports('beAbstract', $subject, [])->shouldReturn(true);
>>>>>>> v2-test
    }

    function it_throws_exception_if_checker_method_not_found()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Fracture\MethodNotFoundException')
<<<<<<< HEAD
            ->duringPositiveMatch('beSimple', $subject, array());
    }

    function it_matches_if_state_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringPositiveMatch('beUserDefined', $subject, array());
    }

    function it_does_not_match_if_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('beFinal', $subject, array());
=======
            ->duringPositiveMatch('beSimple', $subject, []);
    }

    function it_positive_matches_if_state_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringPositiveMatch('beUserDefined', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beFinal', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_null()
    {
        $subject = new class
        {
            public function isMatched()
            {

            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_integer()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return 123;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_float()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return 1.2;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_string()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return '';
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_array()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return [];
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_object()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return $this;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_does_not_positive_match_if_state_checker_returns_resource()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return curl_init();
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('beMatched', $subject, []);
    }

    function it_negative_matches_if_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringNegativeMatch('beFinal', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beUserDefined', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_null()
    {
        $subject = new class
        {
            public function isMatched()
            {

            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_integer()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return 123;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_float()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return 1.2;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_string()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return '';
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_array()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return [];
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_object()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return $this;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
    }

    function it_does_not_negative_match_if_state_checker_returns_resource()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return curl_init();
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('beMatched', $subject, []);
>>>>>>> v2-test
    }

    function it_infers_matcher_alias_name_from_methods_prefixed_with_has()
    {
        $subject = new \ReflectionClass($this);

<<<<<<< HEAD
        $this->supports('haveProperty', $subject, array('something'))->shouldReturn(true);
=======
        $this->supports('haveProperty', $subject, ['something'])->shouldReturn(true);
>>>>>>> v2-test
    }

    function it_throws_exception_if_has_checker_method_not_found()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Fracture\MethodNotFoundException')
<<<<<<< HEAD
            ->duringPositiveMatch('haveAnything', $subject, array('str'));
    }

    function it_matches_if_has_checker_returns_true()
=======
            ->duringPositiveMatch('haveAnything', $subject, ['str']);
    }

    function it_positive_matches_if_has_checker_returns_true()
>>>>>>> v2-test
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringPositiveMatch(
<<<<<<< HEAD
            'haveMethod', $subject, array('it_matches_if_has_checker_returns_true')
        );
    }

    function it_does_not_match_if_has_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\FailureException')
            ->duringPositiveMatch('haveProperty', $subject, array('other'));
=======
            'haveMethod', $subject, ['it_positive_matches_if_has_checker_returns_true']
        );
    }

    function it_does_not_positive_match_if_has_state_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveProperty', $subject, ['other']);
    }

    function it_does_not_positive_match_if_has_checker_returns_null()
    {
        $subject = new class
        {
            public function hasMatch()
            {

            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_integer()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return 123;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_float()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return 1.2;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_string()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return '';
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_array()
    {
        $subject = new class
        {
            public function hasMatched()
            {
                return [];
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatched', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_object()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return $this;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_does_not_positive_match_if_has_checker_returns_resource()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return curl_init();
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringPositiveMatch('haveMatch', $subject, []);
    }

    function it_negative_matches_if_has_checker_returns_false()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldNotThrow()->duringNegativeMatch(
            'haveMethod', $subject, ['other']
        );
    }

    function it_does_not_negative_match_if_has_state_checker_returns_true()
    {
        $subject = new \ReflectionClass($this);

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch(
                'haveMethod',
                $subject,
                [
                    'it_does_not_negative_match_if_has_state_checker_returns_true'
                ]
            );
    }

    function it_does_not_negative_match_if_has_checker_returns_null()
    {
        $subject = new class
        {
            public function hasMatch()
            {

            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_integer()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return 123;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_float()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return 1.2;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_string()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return '';
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_array()
    {
        $subject = new class
        {
            public function hasMatched()
            {
                return [];
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatched', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_object()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return $this;
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
    }

    function it_does_not_negative_match_if_has_checker_returns_resource()
    {
        $subject = new class
        {
            public function hasMatch()
            {
                return curl_init();
            }
        };

        $this->shouldThrow('PhpSpec\Exception\Example\MethodFailureException')
            ->duringNegativeMatch('haveMatch', $subject, []);
>>>>>>> v2-test
    }

    function it_does_not_match_if_subject_is_callable()
    {
        $subject = function () {};

<<<<<<< HEAD
        $this->supports('beCallable', $subject, array())->shouldReturn(false);
=======
        $this->supports('beCallable', $subject, [])->shouldReturn(false);
    }

    function it_does_not_throw_when_positive_match_true()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return true;
            }
        };

        $this->positiveMatch('beMatched', $subject, [])->shouldBe(null);
    }

    function it_does_not_throw_when_negative_match_false()
    {
        $subject = new class
        {
            public function isMatched()
            {
                return false;
            }
        };

        $this->negativeMatch('beMatched', $subject, [])->shouldBe(null);
>>>>>>> v2-test
    }
}
