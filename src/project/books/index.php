<?php
require_once 'php/lib/config.php';
require_once 'php/lib/utils.php';

try {
    $books = Book::findAll();
} 
catch (PDOException $e) {
    die("<p>PDO Exception: " . $e->getMessage() . "</p>");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>Books</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12 header">
                <?php require 'php/inc/flash_message.php'; ?>
                <div class="button">
                    <a href="book_create.php">Add New Book</a>
                </div>
            </div>
        </div>
        <div class="container">
            <a href="book_list.php">books</a>
        </div>
    </body>
</html>