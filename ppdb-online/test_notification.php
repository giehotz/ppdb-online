<?php
// Simple test script to simulate status update and notification creation

// Include the autoloader
require_once 'vendor/autoload.php';

// Bootstrap the application
$paths = new Config\Paths();
$app = new CodeIgniter\CodeIgniter($paths);

// Get the service container
$services = \Config\Services::createServices();

// Get the notification model
$notificationModel = new \App\Models\NotificationModel();

// Simulate updating a submission status and creating a notification
echo "Simulating status update and notification creation...\n";

// Create a notification for the student
$notificationData = [
    'user_id' => 1, // teststudent user ID
    'title' => 'Status Pendaftaran Diperbarui',
    'message' => 'Kabar baik! Dokumen dan data pendaftaran Anda dengan nomor PPDB-2025-0001 telah berhasil diverifikasi oleh panitia.',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
];

$notificationId = $notificationModel->insert($notificationData);

if ($notificationId) {
    echo "Notification created successfully with ID: " . $notificationId . "\n";
    
    // Test retrieving unread notifications
    $unreadNotifications = $notificationModel->getUnreadNotifications(1);
    echo "Unread notifications for user ID 1: " . count($unreadNotifications) . "\n";
    
    // Test marking as read
    $notificationModel->markAsRead(1);
    echo "Notifications marked as read\n";
    
    // Check unread notifications again
    $unreadNotifications = $notificationModel->getUnreadNotifications(1);
    echo "Unread notifications for user ID 1 after marking as read: " . count($unreadNotifications) . "\n";
} else {
    echo "Failed to create notification\n";
}