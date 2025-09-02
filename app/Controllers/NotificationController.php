<?php

namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    protected $notificationModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Get unread notifications for the current user
     * 
     * @return mixed
     */
    public function getUnread()
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $notifications = $this->notificationModel->getUnreadNotifications(session()->get('user_id'));
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $notifications,
            'count' => count($notifications)
        ]);
    }

    /**
     * Mark all notifications as read for the current user
     * 
     * @return mixed
     */
    public function markAsRead()
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $this->notificationModel->markAsRead(session()->get('user_id'));
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Notifications marked as read'
        ]);
    }

    /**
     * Get all notifications for the current user
     * 
     * @return mixed
     */
    public function getAll()
    {
        if (!session()->has('user_id')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $notifications = $this->notificationModel->getUserNotifications(session()->get('user_id'));
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $notifications
        ]);
    }
}