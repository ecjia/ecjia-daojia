Feature: Developer is shown a parse error
  As a Developer
  I want to know if a parse error was thrown
  So that I can know that I can handle pass errors

<<<<<<< HEAD
  @isolated @php:~5.4||~7.0
  Scenario: Spec attempts to call an undeclared function
=======
  Scenario: Parse error in class
>>>>>>> v2-test
    Given the spec file "spec/Message/Fatal/ParseSpec.php" contains:
      """
      <?php

      namespace spec\Message\Fatal;

      use Parse;
      use PhpSpec\ObjectBehavior;
<<<<<<< HEAD
      use Prophecy\Argument;

      class ParseSpec extends ObjectBehavior
      {
          function it_thro ws_a_syntax_error()
=======

      class ParseSpec extends ObjectBehavior
      {
          function it_throws_a_syntax_error()
>>>>>>> v2-test
          {
              $this->cool();
          }
      }

      """
    And the spec file "src/Message/Fatal/Parse.php" contains:
      """
      <?php

      namespace Message\Parse;

<<<<<<< HEAD
=======
      class Par se
      {
          public function cool()
          {
              return true;
          }
      }

      """
    When I run phpspec
    Then I should see "1 broken"

  Scenario: Parse error in spec
    Given the spec file "spec/Message/Fatal2/ParseSpec.php" contains:
      """
      <?php

      namespace spec\Message\Fatal2;

      use Parse;
      use PhpSpec\ObjectBehavior;

      class ParseSpec extends ObjectBehavior
      {
          function it_thro ws_a_syntax_error()
          {
              $this->cool();
          }
      }

      """
    And the spec file "src/Message/Fatal2/Parse.php" contains:
      """
      <?php

      namespace Message\Parse2;

>>>>>>> v2-test
      class Parse
      {
          public function cool()
          {
              return true;
          }
      }

      """
<<<<<<< HEAD
    When I run phpspec with the "junit" formatter
    Then I should see "syntax error"
=======
    When I run phpspec
    Then I should see "1 broken"
    And I should see "syntax error"
>>>>>>> v2-test
