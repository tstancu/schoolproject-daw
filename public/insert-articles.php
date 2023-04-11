<?php
require_once 'includes/db.php';

$query = "INSERT INTO articles (title, content, author, published_at, subscription_level_id) VALUES
('Top 10 Web Design Trends in 2023', 'Web design trends are constantly evolving. In this article, we will explore the top 10 web design trends of 2023, including dark mode, minimalism, and more. Read on to learn how these trends can enhance user experience and boost conversions...', 'Author1', NOW(), 1),
('How to Start a Successful Podcast in 2023', 'Podcasting has become increasingly popular in recent years. If you''re looking to start your own podcast in 2023, this article will guide you through the process. We''ll cover everything from choosing a topic to marketing your show...', 'Author2', NOW(), 1),
('Mastering JavaScript: Advanced Techniques for Web Development', 'JavaScript is an essential tool for modern web developers. In this in-depth article, we''ll explore advanced JavaScript techniques to take your web development skills to the next level. Topics include closures, promises, and more...', 'Author3', NOW(), 2),
('The Complete Guide to Search Engine Optimization (SEO) in 2023', 'Search engine optimization (SEO) is crucial for the success of any website. In this comprehensive guide, we''ll dive deep into the latest SEO strategies, trends, and tools to help you improve your site''s ranking and drive more organic traffic...', 'Author4', NOW(), 2);";

if ($conn->query($query) === TRUE) {
    echo "Articles inserted successfully.";
} else {
    echo "Error: " . $query . "<br>" . $conn->error;
}

$conn->close();
?>