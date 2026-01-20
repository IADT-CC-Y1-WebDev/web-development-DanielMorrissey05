<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Variables Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/01-variables.php">View Example &rarr;</a>
    </div>

    <h1>Variables Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Personal Information</h2>
    <p>
        <strong>Task:</strong> 
        Create variables for your first name, last name, age, and city. 
        Then output a sentence using these variables that says "My name 
        is [first] [last], I am [age] years old and I live in [city]."
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $firstName = "Daniel";
        $lastName = "Morrissey";
        $age = 20;
        $city = "Dublin";

        echo "My name is $firstName $lastName, I am $age years old and I live in $city";
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Shopping Calculator</h2>
    <p>
        <strong>Task:</strong> 
        Create variables for three product prices and their quantities. 
        Calculate the subtotal for each product (price × quantity), then 
        calculate the total cost. Apply a 10% discount and display the 
        final price.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $price1 = 10;
        $quantity1 = 15;
        $price2 = 10;
        $quantity2 = 20;
        $price3 = 15;
        $quantity3 = 25;

        $subTotal1 = $price1 * $quantity1;
        $subTotal2 = $price2 * $quantity2;
        $subTotal3 = $price3 * $quantity3;

        $total = $subTotal1 + $subTotal2 + $subTotal3;
        $discount = $total * 0.9;
        $final = $total - $discount;

        echo "The total is $final"; 
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: User Status</h2>
    <p>
        <strong>Task:</strong> 
        Create boolean variables for isStudent, hasDiscount, and isPremiumMember. 
        Use the ternary operator to display "Yes" or "No" for each status.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        $isStudent = true; 
        $hasDiscount = true;
        $isPremiumMember = false;

        echo "Signed in: " .($isStudent ? "Yes" : "No") . "<br>";
        echo "Has account: "  .($hasDiscount ? "Yes" : "No") . "<br>";
        echo "Is premium member: " .($isPremiumMember ? "Yes" : "No") . "<br>";

        ?>
    </div>

</body>
</html>
