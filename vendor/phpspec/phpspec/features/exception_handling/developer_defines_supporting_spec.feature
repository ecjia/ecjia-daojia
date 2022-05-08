Feature: Developer has defined a supporting class and should not see a silent error
  As a Developer
  I want to see if my supporting class is properly defined
  So that I can better trace where my changes caused a fatal error

  @isolated
<<<<<<< HEAD
  Scenario: Spec attempts to run a class with an undeclared interface, outputs to stdout
=======
  Scenario: Spec attempts to run a class with trying to implement throwable, outputs to stdout
>>>>>>> v2-test
    Given the spec file "spec/SomethingSpec.php" contains:
      """
      <?php
        namespace spec;

        use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
        use Prophecy\Argument;
=======
>>>>>>> v2-test

        class SomethingSpec extends ObjectBehavior
        {
            function it_is_initializable()
            {
                $this->shouldHaveType('Something');
            }
        }

<<<<<<< HEAD
        class ExampleClass implements NotDefinedInterface
=======
        class ExampleClass implements \Throwable
>>>>>>> v2-test
        {
        }

      """
    And the class file "src/Something.php" contains:
      """
      <?php
      namespace spec;

      class Something
      {
          public function __construct($param)
          {
              if ($param == 'throw') {
                  throw new \Exception();
              }
          }
      }

      """
    When I run phpspec
    Then I should see "Fatal error happened while executing the following"
