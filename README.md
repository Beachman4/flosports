# Aylon's Test Project to join Flosports

### My thoughts and what is in the project

I decided not to use Bootstrap, especially since you said that you wanted to look at my css implementation, so I just did it all from scratch.  I feel that Bootstrap would have been a bit overkill because doing it without it was simple.

I decided to just have 1 table for "orders" and that would house, first name, last name, phone number, toppings and type.  I may have misunderstood the instructions if you wanted specifically 2 tables.  If so that's a really simple change and would just incorporate relationships in doctrine to achieve the same effect.

So lets start with the front-end. I used pure css(Scss) to achieve the styling. I used Jquery for the javascript stuff. I basically emulated Pizza Hut's pizza creation (Although they use angular).  For mobile, I hide the pizza and just show the selection.

On the backend, I had one entity and therefor 1 repository for Orders. I have 2 controllers. One for front-end, basic form based stuff and redirection logic. I have a controller for Rest endpoints, using the FOSRestBundle. I also utilize what I call a creator class, which will take an array of values and convert the values into the entity you give it.  That way you can easily do something like this:
    
    $entity = $creator->setValues($values)->create();
    $entityManager->persist($entity);
    $entityManager->flush();
Instead of an endless chain of setFirstName, setLastName, setPhoneNumber. It will also automatically reject if you pass it an invalid variable, like doing `pizza_toppings`. The class will convert that to `setPizzaToppings`. Using is_callable, it'll check if that is a valid variable or function and reject if not

User facing:

    /(index): 2 buttons, create order and find orders
    /create: Create a new order for pizza
    /find: Has input for phone number to search for pizzas
    /list: displays list when given a phone number as query paraemter, if it doesn't exist, it'll redirect back
    /thank-you: Page you are redirected to after creating an order. This was just a funny page, because it'll select between 1 and 6 months and say "Your pizza will be delivered in N months, Remember 30 minutes or more and it's free(I wonder why we're losing money with this policy)" Just a little humor
    
    
Rest Api:

    GET /api/orders: Will list orders and has an optional parameter to filter by phone number
    POST /api/orders: Requires 5 request parameters and will return 400 Bad Request when given invalid or missing a request parameter.
    The parameters are:
    first_name: String, A-Za-z
    last_name: String, A-Za-z
    phone_number: String, 0-9
    toppings: Array, a-z
    type: String, a-z
    
    
    
That's pretty much the entire project.



# Running

In order:

    composer install
    
    php bin/console server:run
    
And you're done! Visit the site at localhost:8000




# Testing

There are 2 tests. One Unit and One functional. For the unit test I was specifically testing the OrderCreator class, to check if it would return the Order Entity and reject on invalid variables.  The functional test is for testing api calls, so for that you will need to be running the dev server.


To run the tests:

    ./vendor/bin/phpunit
    
or if you have it globally installed

    phpunit