Feature: Developer generates a spec
  As a Developer
  I want to automate creating specs
  In order to avoid repetitive tasks and interruptions in development flow

  Scenario: Generating a spec
    When I start describing the "CodeGeneration/SpecExample1/Markdown" class
    Then a new spec should be generated in the "spec/CodeGeneration/SpecExample1/MarkdownSpec.php":
      """
      <?php

      namespace spec\CodeGeneration\SpecExample1;

<<<<<<< HEAD
      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;
=======
      use CodeGeneration\SpecExample1\Markdown;
      use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

      class MarkdownSpec extends ObjectBehavior
      {
          function it_is_initializable()
          {
<<<<<<< HEAD
              $this->shouldHaveType('CodeGeneration\SpecExample1\Markdown');
=======
              $this->shouldHaveType(Markdown::class);
>>>>>>> v2-test
          }
      }

      """

<<<<<<< HEAD
=======
  @issue1210
  Scenario: Generating a spec with alphabetised imports
    When I start describing the "Zyzzyva/SpecExample/Example" class
    Then a new spec should be generated in the "spec/Zyzzyva/SpecExample/ExampleSpec.php":
      """
      <?php

      namespace spec\Zyzzyva\SpecExample;

      use PhpSpec\ObjectBehavior;
      use Zyzzyva\SpecExample\Example;

      class ExampleSpec extends ObjectBehavior
      {
          function it_is_initializable()
          {
              $this->shouldHaveType(Example::class);
          }
      }

      """
>>>>>>> v2-test

  @issue687
  Scenario: Generating a spec with the same namespace as the source
    Given the config file contains:
    """
    suites:
      code_generator_suite:
        namespace: CodeGeneration\SpecExample2
        spec_path: spec/
        spec_prefix: ''

    """
    When I start describing the "CodeGeneration/SpecExample2/Markdown" class
    Then a new spec should be generated in the "spec/CodeGeneration/SpecExample2/MarkdownSpec.php":
    """
    <?php

    namespace CodeGeneration\SpecExample2;

<<<<<<< HEAD
    use PhpSpec\ObjectBehavior;
    use Prophecy\Argument;
=======
    use CodeGeneration\SpecExample2\Markdown;
    use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

    class MarkdownSpec extends ObjectBehavior
    {
        function it_is_initializable()
        {
<<<<<<< HEAD
            $this->shouldHaveType('CodeGeneration\SpecExample2\Markdown');
=======
            $this->shouldHaveType(Markdown::class);
>>>>>>> v2-test
        }
    }

    """

  @issue687
  Scenario: Generating a spec with the same namespace as the source even with psr4 prefix on src
    Given the config file contains:
    """
    suites:
      code_generator_suite:
        namespace: CodeGeneration\SpecExample2
        psr4_prefix: CodeGeneration
        spec_path: spec/
        spec_prefix: ''

    """
    When I start describing the "CodeGeneration/SpecExample2/Markdown" class
    Then a new spec should be generated in the "spec/SpecExample2/MarkdownSpec.php":
    """
    <?php

    namespace CodeGeneration\SpecExample2;

<<<<<<< HEAD
    use PhpSpec\ObjectBehavior;
    use Prophecy\Argument;
=======
    use CodeGeneration\SpecExample2\Markdown;
    use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

    class MarkdownSpec extends ObjectBehavior
    {
        function it_is_initializable()
        {
<<<<<<< HEAD
            $this->shouldHaveType('CodeGeneration\SpecExample2\Markdown');
=======
            $this->shouldHaveType(Markdown::class);
>>>>>>> v2-test
        }
    }

    """

  @issue127
  Scenario: Generating a spec with PSR0 must convert classname underscores to directory separator
    When I start describing the "CodeGeneration/SpecExample1/Text_Markdown" class
    Then a new spec should be generated in the "spec/CodeGeneration/SpecExample1/Text/MarkdownSpec.php":
      """
      <?php

      namespace spec\CodeGeneration\SpecExample1;

<<<<<<< HEAD
      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;
=======
      use CodeGeneration\SpecExample1\Text_Markdown;
      use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

      class Text_MarkdownSpec extends ObjectBehavior
      {
          function it_is_initializable()
          {
<<<<<<< HEAD
              $this->shouldHaveType('CodeGeneration\SpecExample1\Text_Markdown');
=======
              $this->shouldHaveType(Text_Markdown::class);
>>>>>>> v2-test
          }
      }

      """

  @issue127
  Scenario: Generating a spec with PSR0 must not convert namespace underscores to directory separator
    When I start describing the "CodeGeneration/Spec_Example2/Text_Markdown" class
    Then a new spec should be generated in the "spec/CodeGeneration/Spec_Example2/Text/MarkdownSpec.php":
      """
      <?php

      namespace spec\CodeGeneration\Spec_Example2;

<<<<<<< HEAD
      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;
=======
      use CodeGeneration\Spec_Example2\Text_Markdown;
      use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

      class Text_MarkdownSpec extends ObjectBehavior
      {
          function it_is_initializable()
          {
<<<<<<< HEAD
              $this->shouldHaveType('CodeGeneration\Spec_Example2\Text_Markdown');
=======
              $this->shouldHaveType(Text_Markdown::class);
>>>>>>> v2-test
          }
      }

      """

  Scenario: Generating a spec for a class with psr4 prefix
    Given the config file contains:
      """
      suites:
        behat_suite:
          namespace: Behat\CodeGeneration
          psr4_prefix: Behat\CodeGeneration
      """
    When I start describing the "Behat/CodeGeneration/Markdown" class
    Then a new spec should be generated in the "spec/MarkdownSpec.php":
      """
      <?php

      namespace spec\Behat\CodeGeneration;

<<<<<<< HEAD
      use PhpSpec\ObjectBehavior;
      use Prophecy\Argument;
=======
      use Behat\CodeGeneration\Markdown;
      use PhpSpec\ObjectBehavior;
>>>>>>> v2-test

      class MarkdownSpec extends ObjectBehavior
      {
          function it_is_initializable()
          {
<<<<<<< HEAD
              $this->shouldHaveType('Behat\CodeGeneration\Markdown');
          }
      }

      """
=======
              $this->shouldHaveType(Markdown::class);
          }
      }

      """

  Scenario: Generating a spec for class with namespace containing reserved keyword
    Given I have started describing the "Namespace/ClassExample1/Markdown" class
    Then I should an error about invalid class name "Namespace\ClassExample1\Markdown" to generate spec for
    And there should be no file "spec/Namespace/ClassExample1/MarkdownSpec.php"
>>>>>>> v2-test
