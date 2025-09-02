<?php
// Simple test script to test the NotificationModel

// Include the autoloader
require_once 'vendor/autoload.php';

// Load database configuration
$db = \Config\Database::connect();

// Create a notification directly using the Query Builder
$data = [
    'user_id' => 1,
    'title' => 'Test Notification',
    'message' => 'This is a test notification message',
    'is_read' => 0,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
];

$result = $db->table('notifications')->insert($data);

if ($result) {
    echo "Notification inserted successfully\n";
    
    // Try to retrieve it
    $notification = $db->table('notifications')->where('user_id', 1)->get()->getResult();
    echo "Found " . count($notification) . " notifications for user ID 1\n";
    
    if (count($notification) > 0) {
        echo "First notification title: " . $notification[0]->title . "\n";
        echo "First notification message: " . $notification[0]->message . "\n";
    }
} else {
    echo "Failed to insert notification\n";
}