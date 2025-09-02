<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'role',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'username' => 'required|alpha_numeric_space|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password_hash' => 'required|max_length[255]',
        'role' => 'required|in_list[admin,siswa,panitia,kepala_sekolah]',
    ];
    
    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan',
        ],
        'email' => [
            'is_unique' => 'Email sudah terdaftar',
        ],
    ];
    
    protected $skipValidation = false;
}