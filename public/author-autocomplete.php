<?php
// Include the database connection file
require_once '../public/includes/db.php';

require_once '../public/includes/queries.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
if (isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    //var_dump ($searchTerm = $_GET['term']);
    $authors = get_authors();

    $matches = array_filter($authors, function($author) use ($searchTerm) {
        return strpos(strtolower($author['name']), strtolower($searchTerm)) !== false;
    });

    $results = array_map(function($match) {
        return array(
            'label' => $match['name'],
            'id' => $match['id']
        );
    }, $matches);

    header('Content-Type: application/json');
    echo json_encode($results);
}
?>