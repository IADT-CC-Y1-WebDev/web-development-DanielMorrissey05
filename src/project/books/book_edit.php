<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method.');
    }
    if (!array_key_exists('id', $_GET)) {
        throw new Exception('No book ID provided.');
    }
    $id = $_GET['id'];

    $book = book::findById($id);
    if ($book === null) {
        throw new Exception("book not found.");
    }

    $bookisbn = isbn::findByBook($book->isbn);
    $bookisbnIds = [];
    foreach ($bookisbn as $isbn) {
        $bookisbnIds[] = $isbn->id;
    }

    $publishers = publisher::findAll();
    $isbn = isbn::findAll();
}
catch (PDOException $e) {
    setFlashMessage('error', 'Error: ' . $e->getMessage());
    redirect('/index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'php/inc/head_content.php'; ?>
        <title>Edit book</title>
    </head>
    <body>
        <div class="container">
            <div class="width-12">
                <?php require 'php/inc/flash_message.php'; ?>
            </div>
            <div class="width-12">
                <h1>Edit book</h1>
            </div>
            <div class="width-12">
                <form action="book_update.php" method="POST" enctype="multipart/form-data">
                    <div class="input">
                        <input type="hidden" name="id" value="<?= h($book->id) ?>">
                    </div>
                    <div class="input">
                        <label class="special" for="title">Title:</label>
                        <div>
                            <input type="text" id="title" name="title" value="<?= old('title', $book->title) ?>" required>
                            <p><?= error('title') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="author">Author:</label>
                        <div>
                            <input type="text" id="author" name="author" value="<?= old('author', $book->author) ?>" required>
                            <p><?= error('author') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="year">Release Year:</label>
                        <div>
                            <input type="number" id="year" name="year" min="1900" max="2099" value="<?= old('year', $book->year) ?>" required>
                            <p><?= error('year') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="publisher_id">publisher:</label>
                        <div>
                            <select id="publisher_id" name="publisher_id" required>
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value="<?= h($publisher->id) ?>" <?= chosen('publisher_id', $publisher->id, $book->publisher_id) ? "selected" : "" ?>>
                                        <?= h($publisher->name) ?>
                                    </option>
                                <?php } ?>
                            </select>
                            <p><?= error('publisher_id') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special" for="description">Description:</label>
                        <div>
                            <textarea id="description" name="description" required><?= old('description', $book->description) ?></textarea>
                            <p><?= error('description') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <label class="special">isbns:</label>
                        <div>
                            <?php foreach ($isbns as $isbn) { ?>
                                <div>
                                    <input type="checkbox" 
                                        id="isbn_<?= h($isbn->id) ?>" 
                                        name="isbn_ids[]" 
                                        value="<?= h($isbn->id) ?>"
                                        <?= chosen('isbn_ids', $isbn->id, $bookisbnsIds) ? "checked" : "" ?>
                                    >
                                    <label for="isbn_<?= h($isbn->id) ?>"><?= h($isbn->name) ?></label>
                                </div>
                            <?php } ?>
                        </div>
                        <p><?= error('isbn_ids') ?></p>
                    </div>
                    <div><img src="covers/<?= $book->cover_filename ?>" /></div>
                    <div class="input">
                        <label class="special" for="cover">cover (optional):</label>
                        <div>
                            <input type="file" id="cover" name="cover" accept="cover/*">
                            <p><?= error('cover') ?></p>
                        </div>
                    </div>
                    <div class="input">
                        <button class="button" type="submit">Update book</button>
                        <div class="button"><a href="index.php">Cancel</a></div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<?php
// Clear form data after displaying
clearFormData();
// Clear errors after displaying
clearFormErrors();
?>