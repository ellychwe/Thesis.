<?php
session_start();
include("scholarship/db_connect.php");

$user_id = $_SESSION['user_id'] ?? null;

$response = [
    "notifications" => [],
    "messages" => [],
    "notification_count" => 0,
    "message_count" => 0,
    "user" => []
];

if ($user_id) {
    // Fetch unread notifications
    $notif_sql = "SELECT * FROM notifications WHERE user_id=? AND is_read=0 ORDER BY created_at DESC LIMIT 10";
    $stmt = $conn->prepare($notif_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $notif_result = $stmt->get_result();
    $notifications = $notif_result->fetch_all(MYSQLI_ASSOC);

    // Count unread notifications
    $notif_count_sql = "SELECT COUNT(*) AS count FROM notifications WHERE user_id=? AND is_read=0";
    $stmt = $conn->prepare($notif_count_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $count_result = $stmt->get_result()->fetch_assoc();

    // Fetch unread messages
    $msg_sql = "SELECT * FROM messages WHERE receiver_id=? AND is_read=0 ORDER BY created_at DESC LIMIT 10";
    $stmt = $conn->prepare($msg_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $msg_result = $stmt->get_result();
    $messages = $msg_result->fetch_all(MYSQLI_ASSOC);

    // Count unread messages
    $msg_count_sql = "SELECT COUNT(*) AS count FROM messages WHERE receiver_id=? AND is_read=0";
    $stmt = $conn->prepare($msg_count_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $msg_count = $stmt->get_result()->fetch_assoc();

    // Fetch user info (NO profile_pic)
    $user_sql = "SELECT id, name, role FROM users WHERE id=?";
    $stmt = $conn->prepare($user_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    // Add default avatar if none
    $user['avatar'] = "default.png";

    $response = [
        "notifications" => $notifications,
        "messages" => $messages,
        "notification_count" => $count_result['count'],
        "message_count" => $msg_count['count'],
        "user" => $user
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
