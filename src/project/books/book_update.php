<?php
require_once 'php/lib/config.php';
require_once 'php/lib/session.php';
require_once 'php/lib/forms.php';
require_once 'php/lib/utils.php';

startSession();

try {
    // Initialize form data array
    $data = [];
    // Initialize errors array
    $errors = [];
    
    // Check if request is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method.');
    }

    // Get form data
    $data = [
        'id' => $_POST['id'] ?? null,
        'title' => $_POST['title'] ?? null,
        'author' => $_POST['author'] ?? null,
        'year' => $_POST['year'] ?? null,
        'publisher_id' => $_POST['publisher_id'] ?? null,
        'description' => $_POST['description'] ?? null,
        'isbn' => $_POST['isbn'] ?? [],
        'cover' => $_FILES['cover'] ?? null
    ];

    // Define validation rules
    $rules = [
        'id' => 'required|integer',
        'title' => 'required|notempty|min:1|max:255',
        'author' => 'required|notempty|min:1|max:255',
        'year' => 'required|notempty',
        'publisher_id' => 'required|integer',
        'description' => 'required|notempty|min:10|max:5000',
        'isbn' => 'required|array|min:1|max:10',
        'cover' => 'file|cover|mimes:jpg,jpeg,png|max_file_size:5242880' // optional -- no required rule
    ];

    // Validate all data (including file)
    $validator = new Validator($data, $rules);

    if ($validator->fails()) {
        // Get first error for each field
        foreach ($validator->errors() as $field => $fieldErrors) {
            $errors[$field] = $fieldErrors[0];
        }

        throw new Exception('Validation failed.');
    }

    // Find existing book
    $book = Book::findById($data['id']);
    if (!$book) {
        throw new Exception('Book not found.');
    }

    // Verify publisher exists
    $publisher = publisher::findById($data['publisher_id']);
    if (!$publisher) {
        throw new Exception('Selected publisher does not exist.');
    }

    // Verify platforms exist
    foreach ($data['isbn'] as $platformId) {
        if (!Platform::findById($platformId)) {
            throw new Exception('One or more selected platforms do not exist.');
        }
    }

    // Process the uploaded cover (validation already completed)
    $coverFilename = null;
    $uploader = new coverUpload();
    if ($uploader->hasFile('cover')) {
        // Delete old cover
        $uploader->deletecover($book->cover_filename);
        // Process new cover
        $coverFilename = $uploader->process($_FILES['cover']);
        // Check for processing errors
        if (!$coverFilename) {
            throw new Exception('Failed to process and save the cover.');
        }
    }
    
    // Update the book instance
    $book->title = $data['title'];
    $book->author = $data['author'];
    $book->year = $data['year'];
    $book->publisher_id = $data['publisher_id'];
    $book->isbn = $data['isbn'];
    $book->description = $data['description'];
    if ($coverFilename) {
        $book->cover_filename = $coverFilename;
    }

    // Save to database
    $book->save();

    // Delete existing platform associations
    BookPlatform::deleteByBook($book->id);
    // Create new platform associations
    if (!empty($data['isbn']) && is_array($data['isbn'])) {
        foreach ($data['isbn'] as $platformId) {
            BookPlatform::create($book->id, $platformId);
        }
    }

    // Clear any old form data
    clearFormData();
    // Clear any old errors
    clearFormErrors();

    // Set success flash message
    setFlashMessage('success', 'Book updated successfully.');

    // Redirect to book details page
    redirect('book_view.php?id=' . $book->id);
}
catch (Exception $e) {
    // Error - clean up uploaded cover
    if ($coverFilename) {
        $uploader->deletecover($coverFilename);
    }

    // Set error flash message
    setFlashMessage('error', 'Error: ' . $e->getMessage());

    // Store form data and errors in session
    setFormData($data);
    setFormErrors($errors);

    // Redirect back to edit page if there is an ID; otherwise, go to index page
    if (isset($data['id']) && $data['id']) {
        redirect('book_edit.php?id=' . $data['id']);
    }
    else {
        redirect('index.php');
    }
}
