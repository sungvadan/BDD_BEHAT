Feature: ls
  In order to see the directory structure
  As a Unix user
  I need to be able to list the current directory's contents

  Background:
    Given There is a file named "john"

  Scenario: List 2 files in the directory
    Given There is a file named "marc"
    When I run command "ls"
    Then I should see "john" in the output
    And I should see "marc" in the output

  Scenario: list 1 file in one directory
    Given There is a dir named "ingen"
    When I run command "ls"
    Then I should see "john" in the output
    And I should see "ingen" in the output
