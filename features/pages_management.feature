Feature: Pages management
    In order to modify the available pages on the website
    As an administrator
    I need to be able to create and delete pages and update their content

    Scenario: Creating a page
        When I create a page with title "Foo" and content
            """
            Proident deserunt eu ullamco laboris amet commodo exercitation
            culpa sunt nulla duis id. Irure proident proident Lorem incididunt
            nostrud adipisicing proident deserunt elit aute ut esse non ut.
            """
        Then it should be available

    Scenario: Deleting a page
        Given a page exists with title "Foo" and content
            """
            Proident deserunt eu ullamco laboris amet commodo exercitation
            culpa sunt nulla duis id. Irure proident proident Lorem incididunt
            nostrud adipisicing proident deserunt elit aute ut esse non ut.
            """
        When I delete it
        Then it should be unaivalable

    Scenario: Updating a page title
        Given a page exists with title "Foo" and content
            """
            Proident deserunt eu ullamco laboris amet commodo exercitation
            culpa sunt nulla duis id. Irure proident proident Lorem incididunt
            nostrud adipisicing proident deserunt elit aute ut esse non ut.
            """
        When I set its title to "Bar"
        Then its title should be "Bar"

    Scenario: Updating a page content
        Given a page exists with title "Foo" and content
            """
            Proident deserunt eu ullamco laboris amet commodo exercitation
            culpa sunt nulla duis id. Irure proident proident Lorem incididunt
            nostrud adipisicing proident deserunt elit aute ut esse non ut.
            """
        When I set its content to
            """
            Ullamco Lorem deserunt amet aliqua dolore do aute ad cupidatat
            exercitation eu. Consequat sit sunt commodo anim nostrud incididunt
            culpa commodo veniam laboris mollit ipsum enim elit.
            """
        Then its content should be
            """
            Ullamco Lorem deserunt amet aliqua dolore do aute ad cupidatat
            exercitation eu. Consequat sit sunt commodo anim nostrud incididunt
            culpa commodo veniam laboris mollit ipsum enim elit.
            """
