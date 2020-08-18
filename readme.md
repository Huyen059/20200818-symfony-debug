# Title: Test Driven Development

- Repository: `php-debugging`
- Type of Challenge: `Learning challenge`
- Duration: `3 days`
- Team challenge : `pair`

## Learning objectives
- Ability to write and read unit tests
- Understanding the importance of Test Driven Development

## The Mission
In the following scenario we are going to explore "Unit Tests" and Test Driven Development, feel free to ask your coach more information about this.
Start with watching this [great youtube introduction](https://www.youtube.com/watch?v=WMqe0jkqPMQ) to the subject.

We are going to create a simple booking software for meeting rooms.
You can write this in Symfony or in vanilla PHP, whatever you find most simple.

### What are unit tests?
Unit testing is testing small pieces of your code in isolation with test code. So instead of going to your browser and verifying everything works, you create a piece of code that checks if another piece of code works.

The immediate advantages that come to mind are:

- Running the tests becomes automate-able and repeatable
- You can test at a much more granular level than point-and-click testing via a GUI
- Once a test is written to prevent a certain bug, this bug can never happen again, improving long term stability.

### What is Test Driven Development?
Another way to look at unit testing is that you write the tests first. This is known as Test-Driven Development (TDD for short). TDD brings additional advantages:

- You don't write speculative "I might need this in the future" code -- just enough to make the tests pass
- The code you've written is always covered by tests
- By writing the test first, you're forced into thinking about how you want to call the code, which usually improves the design of the code in the long run.

### What is PHPUnit?
[PHPUnit](https://phpunit.de/) is the PHP version of the [xUnit architecture](https://en.wikipedia.org/wiki/XUnit) for unit testing frameworks. This means that many other languages have their own version of this unit testing framework. This means you will be able to write tests in many languages after learning about PHPUnit!

### Installation
#### Not using composer, not using symfony
Follow [the steps on the official site](https://phpunit.readthedocs.io/en/9.3/installation.html).

#### I am not using Symfony
Run `composer require --dev phpunit/phpunit ^9`

Check if it works with

`./vendor/bin/phpunit --version`

Always place your tests in the tests/ directory, you will need to create this directory yourself.

#### I am using symfony
Rename the `phpunit.xml.dist` on the root to `phpunit.xml`.

Always place your tests in the tests/ directory.

### How to use PHPUnit?
After installation, run `./vendor/bin/phpunit tests`, this will run all valid tests in your tests directory.

## Must-have features
Create the following entities
 - User
    - password, email (if working with the login)
    - username OR email field (you can choose)
    - credit (integer, start credit 100)
    - premiumMember (bool, default false)
- Room
    - name
    - onlyForPremiumMembers (bool, default false)
- Bookings
    - Relation to room & User
    - Start date (datetime)
    - End date (datetime)
    
### Only when using Symfony
Skip this step if you are NOT using Symfony, it will consume too much time.

Use the make bundle to create a login and register page, and make it so all other pages cannot be viewed without logging in.

You can change the access levels in the ´config/security.yml´ file.
    
###General flow
For now just create rooms directly in the db, you do not need to provide an interface for this.

When a user logs in he gets to see all the rooms, with a link to book a room.
He then selects a start and end date and time between which he is wants access to the room.
He is then charged 2 EUR for each hour he booked the room.

The following conditions apply:

 - Rooms marked as premium can only be hired for premium members
 - Room can only be booked if no other User has already booked it in the framework
 - No room can be book for more than 4 hours
 - Check if they can afford the rent for the room
 
***For all these conditions try to use Test Driven Development first.***

Let's do the first requirement together!

"Rooms marked as premium can only be hired for premium members"

First I am going to write my tests, without even writing any real application code!
I will obviously need both a User, and a Room object. I decided it makes the most sense if the function to check room availability is on the room object.

@TODO
 
## Nice to have
- Provide a page where the user can recharge his credit. Write a unit test for this!
- Create an admin role that can manage the rooms. In symfony you could use the `make:crud` command for this.
- Create a "password forget" flow. In symfony you could use the maker bundle for this.