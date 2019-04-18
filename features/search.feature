Feature: Search
  In order to find products dinosaurs love
  As a web user
  I need to be able to search for products

  Background:
    Given I am on "/"

  Scenario Outline:
    When I fill in search box with "<term>"
    And I press the search button
    Then I should see "<result>"
    Examples:
      | term    | result            |
      | Samsung | Samsung Galaxy    |
      | xbox    | No products found |

#  Scenario Outline:
#    When I fill in "searchTerm" with "<term>"
#    And I press "search_submit"
#    Then I should see "<result>"
#    Examples:
#      | term    | result            |
#      | Samsung | Samsung Galaxy    |
#      | xbox    | No products found |

