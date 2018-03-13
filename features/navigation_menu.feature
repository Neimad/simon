Feature: Navigation menu
    In order to navigate the website
    As a user
    I need a menu providing links to the available pages

    @wip
    Scenario: Getting the menu
        Given a page exists with title "Foo"
          And a page exists with title "Bar"
          And a page exists with title "Baz"
        When I requests the home page
        Then the navigation menu should contain
            | label |  uri |
            | Foo   | /foo |
            | Bar   | /bar |
            | Baz   | /baz |
