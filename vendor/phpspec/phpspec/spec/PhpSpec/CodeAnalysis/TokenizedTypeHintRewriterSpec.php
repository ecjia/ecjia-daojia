<?php

namespace spec\PhpSpec\CodeAnalysis;

<<<<<<< HEAD
use PhpSpec\CodeAnalysis\DisallowedScalarTypehintException;
=======
use PhpSpec\CodeAnalysis\DisallowedNonObjectTypehintException;
use PhpSpec\CodeAnalysis\DisallowedUnionTypehintException;
>>>>>>> v2-test
use PhpSpec\CodeAnalysis\NamespaceResolver;
use PhpSpec\Loader\Transformer\TypeHintIndex;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TokenizedTypeHintRewriterSpec extends ObjectBehavior
{
    function let(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $this->beConstructedWith($typeHintIndex, $namespaceResolver);
<<<<<<< HEAD
    }

    function it_is_a_typehint_rewriter()
    {
=======
        $namespaceResolver->resolve(Argument::cetera())->willReturn('someClass');
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();
    }

    function it_is_a_typehint_rewriter(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $this->beConstructedWith($typeHintIndex, $namespaceResolver);
        $namespaceResolver->resolve(Argument::cetera())->willReturn('someClass');
        $namespaceResolver->analyse(Argument::any())->shouldNotBeCalled();

>>>>>>> v2-test
        $this->shouldHaveType('PhpSpec\CodeAnalysis\TypeHintRewriter');
    }

    function it_leaves_alone_specs_with_no_typehints()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar()
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar()
            {
            }
        }

        ');
    }

    function it_removes_typehints_from_single_argument_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(\Foo\Bar $bar)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar)
            {
            }
        }

        ');
    }

    function it_does_not_remove_typehints_in_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(\Foo\Bar $bar)
            {
                new class($argument) implements InterfaceName
                {
                    public function foo(Foo $foo) {}
                };
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar)
            {
                new class($argument) implements InterfaceName
                {
                    public function foo(Foo $foo) {}
                };
            }
        }

        ');
    }

    function it_removes_typehints_for_multiple_arguments_in_methods()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar $bar, Baz $baz)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar,  $baz)
            {
            }
        }

        ');
    }

<<<<<<< HEAD
=======
    function it_removes_union_type_hints()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar $bar, Baz $baz)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar,  $baz)
            {
            }
        }

        ');
    }

>>>>>>> v2-test
    function it_indexes_typehints_that_are_removed(TypeHintIndex $typeHintIndex, NamespaceResolver $namespaceResolver)
    {
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();

        $namespaceResolver->resolve('FooSpec')->willReturn('FooSpec');
        $namespaceResolver->resolve('Foo\Bar')->willReturn('Foo\Bar');
        $namespaceResolver->resolve('Baz')->willReturn('Baz');

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Foo\Bar $bar, Baz $baz)
            {
            }
        }

        ');

        $typeHintIndex->add('FooSpec', 'bar', '$bar', 'Foo\Bar')->shouldHaveBeenCalled();
        $typeHintIndex->add('FooSpec', 'bar', '$baz', 'Baz')->shouldHaveBeenCalled();
    }

    function it_indexes_invalid_typehints(
        TypeHintIndex $typeHintIndex,
        NamespaceResolver $namespaceResolver
    ) {
<<<<<<< HEAD
        $e = new DisallowedScalarTypehintException();
=======
        $e = new DisallowedNonObjectTypehintException();
>>>>>>> v2-test
        $namespaceResolver->analyse(Argument::any())->shouldBeCalled();

        $namespaceResolver->resolve('FooSpec')->willReturn('FooSpec');
        $namespaceResolver->resolve('int')->willThrow($e);

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(int $bar)
            {
            }
        }

        ');

        $typeHintIndex->addInvalid('FooSpec', 'bar', '$bar', $e)->shouldHaveBeenCalled();
        $typeHintIndex->add('FooSpec', 'bar', '$bar', Argument::any())->shouldNotHaveBeenCalled();
    }

    function it_preserves_line_numbers()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function(
                $foo,
                array $bar,
                Foo\Bar $arg3,
                $arg4
            )
            {
            }
        }
        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function(
                $foo,
                array $bar,
                 $arg3,
                $arg4
            )
            {
            }
        }
        ');
    }

    function it_do_not_remove_typehints_of_non_spec_classes()
    {
        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar $bar, Baz $baz)
            {
            }
        }

        class Bar
        {
            public function foo(Baz $baz)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar,  $baz)
            {
            }
        }

        class Bar
        {
            public function foo(Baz $baz)
            {
            }
        }

        ');
    }
<<<<<<< HEAD
=======

    function it_removes_union_types()
    {
        if (PHP_VERSION_ID < 8000) {
            return;
        }

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar|Baz $bar)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar( $bar)
            {
            }
        }

        ');
    }

    function it_removes_union_types_with_whitespace()
    {
        if (PHP_VERSION_ID < 8000) {
            return;
        }

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar | Baz $bar)
            {
            }
        }

        ')->shouldReturn('
        <?php

        class FooSpec
        {
            public function bar(   $bar)
            {
            }
        }

        ');
    }

    function it_indexes_union_types(TypeHintIndex $typeHintIndex)
    {
        if (PHP_VERSION_ID < 8000) {
            return;
        }

        $this->rewrite('
        <?php

        class FooSpec
        {
            public function bar(Bar | Baz $bar)
            {
            }
        }

        ');

        $typeHintIndex->addInvalid(
            'someClass',
            'bar',
            '$bar',
            Argument::type(DisallowedUnionTypehintException::class)
        )->shouldHaveBeenCalled();
    }
>>>>>>> v2-test
}
