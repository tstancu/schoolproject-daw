<?php
require_once '../public/includes/db.php';
require_once '../public/includes/queries.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['author-name']) ? $_POST['author-name'] : '';
    $email = isset($_POST['author-bio']) ? $_POST['author-bio'] : '';
    $bio = isset($_POST['author-picture-url']) ? $_POST['author-picture-url'] : '';

    // Check if the author already exists
    // $existingAuthor = get_author_by_name($name);
    // var_dump($existingAuthor);
    if (get_author_by_name($name)) {
        // Author already exists
        http_response_code(400);
        echo json_encode(array('message' => 'Author already exists.'));
        exit;
    }

    // Insert the new author
    $result = insert_author($name, $email, $bio);
    if (!$result) {
        http_response_code(500);
        echo json_encode(array('message' => 'Failed to add author.'));
        exit;
    }

    // Return success response
    http_response_code(200);
    echo json_encode(array('message' => 'Author added successfully.', 'author' => $_POST['author-name']));
    exit;
} else {
    http_response_code(405);
    echo json_encode(array('message' => 'Method not allowed.'));
    exit;
}