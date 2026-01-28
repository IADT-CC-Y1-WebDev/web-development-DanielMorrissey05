<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exceptions Exercises - PHP Introduction</title>
    <link rel="stylesheet" href="/exercises/css/style.css">
</head>
<body>
    <div class="back-link">
        <a href="index.php">&larr; Back to PHP Introduction</a>
        <a href="/examples/01-php-introduction/08-exceptions.php">View Example &rarr;</a>
    </div>

    <h1>Exceptions Exercises</h1>

    <!-- Exercise 1 -->
    <h2>Exercise 1: Basic Exception Handling</h2>
    <p>
        <strong>Task:</strong>
        Create a function called <code>calculateSquareRoot($number)</code> that throws an
        exception if the number is negative (you cannot take the square root of a negative number).
        If the number is valid, return its square root using <code>sqrt()</code>.
        Test it with values 16, 25, and -9, catching any exceptions.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        function calculateSquareRoot($number){
        if ($number <= 0){
            throw new Exception ("This number is negative so it is invalid");
        } 

        return sqrt($number);
    }

    $numbers = [16, 25, -9];

    foreach ($numbers as $num) {
        try {
            echo "Square root of $num is " . calculateSquareRoot($num) . "<br>";
        } catch (Exception $e) {
            echo "Error for $num: " . $e->getMessage() . "<br>";
        }
    }
        ?>
    </div>

    <!-- Exercise 2 -->
    <h2>Exercise 2: Validating User Input</h2>
    <p>
        <strong>Task:</strong>
        Create a function called <code>validateEmail($email)</code> that checks if an email
        address contains an "@" symbol. If it doesn't, throw an exception with the message
        "Invalid email: missing @ symbol". Test it with "user@example.com", "invalid-email",
        and "test@test.ie".
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        function validateEmail($email){
            if (strpos($email, "@") == false) {
                throw new Exception ("Invalid email: missing @ symbol");
            }
        }

        $testEmails = ["user@example.com", "invalid-email", "test@test.ie"];
        foreach ($testEmails as $email) {
            try {
                validateEmail($email);
                echo "$email is valid\n" . "<br>";
            } catch (Exception $e) {
                echo "email is invalid: " . $e->getMessage() . "\n" . "<br>";
            }
        }
        ?>
    </div>

    <!-- Exercise 3 -->
    <h2>Exercise 3: Using Finally</h2>
    <p>
        <strong>Task:</strong>
        Create a function called <code>processFile($filename)</code> that throws an exception
        if the filename is empty. Use a try/catch/finally block where the finally block
        always prints "Processing complete". Test with both a valid filename and an empty string.
    </p>

    <p class="output-label">Output:</p>
    <div class="output">
        <?php
        // TODO: Write your solution here
        function processFile($filename){
            try{
                if (empty($filename))
                throw new Exception ("file name is empty");
            }
            catch (Exception $e) {
                echo "Error" . $e->getMessage();
            }
            finally{
                echo "Processing complete";
            }
            
        }
        processFile("");
        ?>
    </div>

</body>
</html>
