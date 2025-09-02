<?php

namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id',
        'title',
        'message',
        'is_read',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'user_id' => 'required|is_natural_no_zero',
        'title' => 'required|max_length[255]',
        'message' => 'required',
        'is_read' => 'permit_empty|in_list[0,1]',
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get unread notifications for a user
     * 
     * @param int $userId
     * @return array
     */
    public function getUnreadNotifications($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
    
    /**
     * Mark notifications as read for a user
     * 
     * @param int $userId
     * @return bool
     */
    public function markAsRead($userId)
    {
        return $this->where('user_id', $userId)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }
    
    /**
     * Get all notifications for a user
     * 
     * @param int $userId
     * @return array
     */
    public function getUserNotifications($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}