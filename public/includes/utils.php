<?php
function get_subscription_level_id($user_id, $conn) {
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

// Update the user's subscription_level_id in the database (example)
// ... your code for updating the subscription_level_id ...

// Get the updated subscription_level_id
// $updated_subscription_level_id = get_subscription_level_id($_SESSION['user_id'], $conn);

// Update the subscription_level_id in the session
// $_SESSION['subscription_level_id'] = $updated_subscription_level_id;
?>