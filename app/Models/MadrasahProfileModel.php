<?php

namespace App\Models;

use CodeIgniter\Model;

class MadrasahProfileModel extends Model
{
    protected $table = 'madrasah_profile';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'name',
        'npsn',
        'nsm',
        'nss',
        'address',
        'district',
        'regency',
        'province',
        'postal_code',
        'phone',
        'email',
        'website',
        'headmaster_name',
        'headmaster_nip',
        'logo_path',
        'letterhead_path',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|max_length[255]',
        'npsn' => 'required|max_length[20]',
        'nsm' => 'permit_empty|max_length[20]',
        'nss' => 'permit_empty|max_length[20]',
        'address' => 'required|max_length[255]',
        'district' => 'required|max_length[100]',
        'regency' => 'required|max_length[100]',
        'province' => 'required|max_length[100]',
        'postal_code' => 'required|max_length[10]',
        'phone' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email|max_length[150]',
        'website' => 'permit_empty|max_length[150]',
        'headmaster_name' => 'required|max_length[150]',
        'headmaster_nip' => 'permit_empty|max_length[30]',
        'logo_path' => 'permit_empty|max_length[255]',
        'letterhead_path' => 'permit_empty|max_length[255]',
    ];
    
    protected $skipValidation = false;
}