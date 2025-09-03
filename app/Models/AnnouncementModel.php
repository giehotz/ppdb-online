<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'title',
        'content',
        'date',
        'sender',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'title' => 'required|max_length[255]',
        'content' => 'required',
        'date' => 'required|valid_date',
        'sender' => 'required|max_length[100]',
    ];
    
    protected $validationMessages = [
        'title' => [
            'required' => 'Judul pengumuman harus diisi',
            'max_length' => 'Judul pengumuman maksimal 255 karakter',
        ],
        'content' => [
            'required' => 'Isi pengumuman harus diisi',
        ],
        'date' => [
            'required' => 'Tanggal pengumuman harus diisi',
            'valid_date' => 'Format tanggal tidak valid',
        ],
        'sender' => [
            'required' => 'Pengirim harus diisi',
            'max_length' => 'Nama pengirim maksimal 100 karakter',
        ],
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get all announcements ordered by date (newest first)
     *
     * @return array
     */
    public function getAll()
    {
        return $this->orderBy('date', 'DESC')->findAll();
    }
    
    /**
     * Get announcement by ID
     *
     * @param int $id
     * @return array|null
     */
    public function getById($id)
    {
        return $this->find($id);
    }
    
    /**
     * Get latest announcements (default 5)
     *
     * @param int $limit
     * @return array
     */
    public function getLatest($limit = 5)
    {
        return $this->orderBy('date', 'DESC')->limit($limit)->findAll();
    }
}