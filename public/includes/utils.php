<?php
require_once('db.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define('__ROOT__', dirname(dirname(dirname(__FILE__))));
define('__FILEROOT__', dirname(__FILE__));

require_once(__ROOT__.'/vendor/autoload.php');


use Smalot\PdfParser\Parser;
use PHPMailer\PHPMailer\PHPMailer;

if (class_exists('Smalot\PdfParser\Parser')) {

    $parser = new Parser();

  } else {

    error_log('Parser class is not loaded');
  }


function slugify($string)
{
    $string = strtolower(trim($string));
    $string = preg_replace('/[^a-z0-9-]/', '-', $string);
    $string = preg_replace('/-+/', "-", $string);
    return $string;
}

// function isEditor()
// {
//     if (!isset($_SESSION['user_id']) || !in_array('editor', $_SESSION['user_roles'])) {
//         //header('Location: index.php');
//         return $_SESSION['user_id'];
//         //exit;
//     }
// }

function isEditor()
{
    global $conn;

    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $user = getUserById($_SESSION['user_id']);

    if ($user['role_id'] == 2) {
        return true;
    }

    return false;
}

function extract_text_from_pdf($pdf_path) {
    $parser = new Parser();
    $pdf = $parser->parseFile($pdf_path);
    $text = $pdf->getText();
    return $text;
}