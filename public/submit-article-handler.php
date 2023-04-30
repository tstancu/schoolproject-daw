<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once '../public/includes/db.php';
require_once '../public/includes/queries.php';
require_once '../public/includes/utils.php';

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    // var_dump($_POST);
    // var_dump($_FILES);
    
    // Get the form data
    $title = $_POST['title'];
    $author = $_POST['author'];
    $content = $_POST['content'];
    // var_dump($_POST['content']);
    // var_dump($_FILES);
    // var_dump($_FILES['pdf-file']['tmp_name']);
    // var_dump(empty($_FILES['pdf-file']['tmp_name']));
    // var_dump(empty($content));
    // var_dump(empty($content) && empty($_FILES['pdf-file']['tmp_name']));
    

    // Check if either content or pdf file has been uploaded
    if (empty($content) && empty($_FILES['pdf-file']['tmp_name'])) {
        echo json_encode(array('message' => 'Please enter content or upload a PDF file.'));
    } else {
        
        if (empty($content) && $_FILES['pdf-file']['type'] !== 'application/pdf') {
            http_response_code(400); 
            echo json_encode(array('message' => 'Please upload a PDF file'));
            return;
        }

        if (!empty($_FILES['pdf-file']['tmp_name'])) {
            //print_r("suntem aici la pdf check");
            $pdf_file_path = $_FILES['pdf-file']['tmp_name'];
            $pdf_file = extract_text_from_pdf($pdf_file_path);
        }

        $content = empty($content) ? $pdf_file : $content;
        $author_id = get_author_by_name($author);
        $author_id = $author_id['id'];
        $slug = slugify($title);
        $preview = substr($content, 0, 200);
        $published_at = date('Y-m-d H:i:s');
        $subscription_level_id = 1;


        // Insert the article into the database
        $result = insert_article($subscription_level_id, $author_id, $title, $content, $preview, $slug, $published_at);
        if ($result) {
            echo json_encode(array('message' => 'Article submitted successfully.'));
        } else {
            echo json_encode(array('message' => 'Error submitting article.'));
        }
    }

    
}

?>