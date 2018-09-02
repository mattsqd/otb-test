Feature: AJAX Submission
  In order to login to a bonus play account
  As an anonymous user
  I need to be able to submit the club wyndham form

  Scenario: The club wyndham form is showing
    Given I am on the homepage
    Then I should see "Sign In"

  @javascript
  Scenario: A club wyndham member can sign in
    Given I am on the homepage
    And I fill in "Email" with "kpstancil@gmail.com"
    And I fill in "Contract Number" with "281822452"
    When I press "Sign In"
    And I wait for Ajax to finish
    Then I should see "Hi, CATHERINE. Thanks for signing in."

  @javascript
  Scenario: A club wyndham member with invalid credentials sees an error message.
    Given I am on the homepage
    And I fill in "Email" with "kpstancil@gmail.com"
    And I fill in "Contract Number" with "badpass"
    When I press "Sign In"
    And I wait for Ajax to finish
    Then I should see "Sorry, we could not authenticate your credentials. See FAQs for more information."
