<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function get_authors() {
    global $conn;
    $sql = 'SELECT id, name FROM authors ORDER BY name';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $authors = array();
    while ($row = $result->fetch_assoc()) {
        $authors[] = $row;
    }
    return $authors;
}

function insert_article($subscription_level_id, $author_id, $title, $content, $preview, $slug, $published_at) {
    global $conn;
    $sql = "INSERT INTO articles (subscription_level_id, author_id, title, content, preview, slug, published_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iisssss', $subscription_level_id, $author_id, $title, $content, $preview, $slug, $published_at);

    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function get_author_by_name($name) {
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM authors WHERE name = ?");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $author = $result->fetch_assoc();
    $stmt->close();
    
    return $author;
}

function insert_author($name, $bio, $profile_image_url) {
    global $conn;

    $sql = "INSERT INTO authors (name, bio, profile_image_url) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $name, $bio, $profile_image_url);
    $stmt->execute();
    return $stmt->affected_rows > 0;
  }

  function getSubscriptionLevelById($user_id)
{
    global $conn;
    $sql = "SELECT subscription_level_id FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $subscription_level_id = null;
    $stmt->bind_result($subscription_level_id);
    $stmt->fetch();
    $stmt->close();

    return $subscription_level_id;
}


function getUserById($id)
{
    global $conn;
    
    $sql = "SELECT * FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    return $user;
}
