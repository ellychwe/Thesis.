<?php
require_once "db_connect.php";
session_start();

$user_id = $_SESSION['user_id'] ?? null;

$response = [
    "notifications" => 0,
    "messages" => 0,
    "notifList" => []
];

if ($user_id) {
    // Unread notifications count
    $notif_result = $conn->query("SELECT COUNT(*) AS total FROM notifications WHERE user_id = $user_id AND is_read = 0");
    if ($notif_result) {
        $response["notifications"] = $notif_result->fetch_assoc()['total'];
    }

    // Latest 5 notifications
    $notif_list_result = $conn->query("SELECT id, message, created_at, is_read 
                                       FROM notifications 
                                       WHERE user_id = $user_id 
                                       ORDER BY created_at DESC 
                                       LIMIT 5");
    if ($notif_list_result && $notif_list_result->num_rows > 0) {
        while ($row = $notif_list_result->fetch_assoc()) {
            $response["notifList"][] = $row;
        }
    }

    // Unread messages count
    $msg_result = $conn->query("SELECT COUNT(*) AS total FROM messages WHERE receiver_id = $user_id AND is_read = 0");
    if ($msg_result) {
        $response["messages"] = $msg_result->fetch_assoc()['total'];
    }
}

header("Content-Type: application/json");
echo json_encode($response);
?>
