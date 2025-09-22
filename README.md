# AskMate, again

## Story

It is now an unbeatable fact that PHP is the best programming language out there, but you're wondering about how much exactly.
You and your friends decided to rewrite an old project of yours in PHP from the Web Module and you chose AskMate to find out...

## What are you going to learn?

- the MySQL equivalent of the SQL commands you already familiar with
- PHP sessions
- hashed passwords in PHP
- file uploading with PHP
- HTML and the Blade template engine

## Tasks

1. As a user I would like to have the possibility to register a new account into the system.
    - The page is linked from the front page
    - There is a form on the registration page when a request is issued with `GET` method
    - The form asks for `email address`, `password` and issues a `POST` request to registration on submit
    - After submitting you are redirected back to the main page and the new user account is saved in the database
    - For a user account we store the `email`, a `password_hash` and the date/time of the registration

2. As a registered user, I'd like to be able to login to the system with my previously saved `email` and `password`.
    - The page is linked from the front page
    - There is a form on the login page when a request is issued with `GET` method
    - The form asks for `email address`, `password` and issues a `POST` request to login on submit
    - After submitting you are redirected back to the main page and the given user is logged in
    - It is only possible to ask or answer a question if the user is logged in

3. Implement the page that displays all questions.
    - Load and display the data from `question` table
    - Sort the questions by the latest question on top

4. Implement a form that allows you to add a question.
    - The page is linked from the list page
    - There is a `POST` form with at least `title` and `message` fields
    - After submitting, you are redirected to "Display a question" page of this new question

5. Create the page that displays a question by its `id`. Below the question list all answers for it.
    - There are links to the question pages from the list page
    - The page displays the question `title` and `message`
    - The page displays all the answers to a question

6. There should be a page where I can list all the existing tags and that how many questions are marked with the given tags
    - The page is linked from the front page and a question's page
    - The page is accessible when I'm not logged in

7. Add tags to questions.
    - The tags are displayed on the question detail page
    - There is an "add tag" link which leads to the page for adding a tag
    - The page allows to either choose from existing tags, or define a new one.

8. Allow the user to delete tags from questions
    - There is an `X` link next to each tag
    - Clicking that link deletes the tag and reloads the question page

9. Implement editing an existing question by its `id`.
    - The page is linked from the question's page
    - There is a `POST` form with at least `title` and `message` fields
    - The fields are pre-filled with existing question's data
    - After submitting, you are redirected back to "Display a question" page and you see the changed data

10. Implement deleting a question by its `id`.
    - There should be a deletion link on the question page
    - Deleting redirects you back to the list of questions

11. Implement voting on questions.
    - Vote numbers are displayed next to questions on the question list page
    - There are "vote up/down" links next to questions on the question list page
    - Voting up increases, voting down decreases the `vote_number` of the question by one
    - Voting redirects you back to the question list

12. As a user when I add a new question I would like to be saved as the user who creates the new question.
    - The `user id` of the currently logged in user is saved when a new question is saved

13. Implement posting a new answer.
    - The question detail page links to this page
    - The page has a `POST` form with a field called `message`
    - Posting an answer redirects you back to the question detail page, and the new answer is there

14. Allow the user to edit the posted answers.
    - The page is linked from the answer's page
    - There is a form with a `message` field, and issues a `POST` request
    - The field is pre-filled with existing answer's data
    - After submitting, you are redirected back to the question detail page, and the answer is updated

15. Implement deleting an answer by its `id`.
    - There should be a deletion link on the question page, next to an answer
    - Deleting redirects you back to the question detail page

16. Implement voting on answers.
    - Vote numbers are displayed next to answers on the question detail page
    - There are "vote up/down" links next to answers
    - Voting up increases, voting down decreases the `vote_number` of the answer by one
    - Voting redirects you back to the question detail page

17. As a user when I add a new answer I would like to be saved as the user who creates the new answer.
    - The `user id` of the currently logged in user is saved when a new answer is saved

18. Allow the user to upload an image for a question.
    - The form for adding question contain an "image" file field
    - You can attach an image (`.jpg`, `.png`)
    - The image is saved on server and displayed next to question
    - When you delete the question, the file gets deleted as well

19. Implement searching in questions and answers.
    - There is a search box and "Search" button on the main page
    - When you write something and press the button, you see a results list of questions (same data as in the list page)
    - The results list contains questions for which the `title` or `description` contain the searched phrase
    - The results list also contains questions which have answers for which the `message` contains the searched phrase

20. There should be a page where I can list all the registered users with all their attributes.
    - The page is linked from the front page when I'm logged in
    - The page is not accessible when I'm not logged in
    - Theres is a `<table/>` with user data in it. The table should have these details of a user:
  - User id
  - User email
  - Registration date
  - Count of asked questions
  - Count of answers

21. [OPTIONAL] Highlight the search phrase in the search results.
    - On the search results page, the searched phrase should be highlighted
    - If the phrase is found in an answer, the answer is also displayed (slightly indented)
    - The search phrase is also highlighted in the answers

22. [OPTIONAL] As a user I would like to have the possibility to mark an answer as accepted.
    - On a question's page for every answer there is a clickable element that can be used to mark an answer as accepted
    - When there is an accepted answer there is an option to remove the accepted state
    - Only the user who asked the question can change the accepted state of answers
    - An accpted answer has a visual distinction from other answers

23. [OPTIONAL] As a user I would like to get clarification on every form if the data I send is valid or not.
    - When the data is valid, it should have no effect on the functionality.
    - When there is an error, it should appear on the page, notifying the user.
    - The data validation is done by using `Regular Expressions`.

## General requirements

- Your approach should include the object-oriented concepts.
- Use your own MVC framework for this team project.

## Hints

- None

## Background materials

- <i class="far fa-exclamation"></i> [PHP - Sessions](https://www.tutorialspoint.com/php/php_sessions.htm)
- <i class="far fa-video"></i> [Set and Read Cookies with PHP](https://youtu.be/9DMrMruYGFY)
- <i class="far fa-video"></i> [PHP Password Security](https://youtu.be/nLb5GodBTFo)
- <i class="far fa-video"></i> [PHP File Uploads](https://youtu.be/PGzxw8Fo2Dw)
- <i class="far fa-book-open"></i> [MySQL Naming Conventions](https://medium.com/@centizennationwide/mysql-naming-conventions-e3a6f6219efe)
