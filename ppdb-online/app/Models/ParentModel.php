<?php

namespace App\Models;

use CodeIgniter\Model;

class ParentModel extends Model
{
    protected $table = 'parents';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'relation',
        'full_name',
        'nik',
        'education',
        'occupation',
        'monthly_income',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'relation' => 'required|in_list[ayah,ibu,wali]',
        'full_name' => 'required|max_length[150]',
        'nik' => 'required|exact_length[16]|numeric',
        'education' => 'required|in_list[SD,SMP,SMA,D1,D2,D3,S1,S2,S3,Lainnya]',
        'occupation' => 'required|max_length[100]',
        'monthly_income' => 'permit_empty|decimal',
    ];
    
    protected $validationMessages = [
        'nik' => [
            'exact_length' => 'NIK harus 16 digit angka',
            'numeric' => 'NIK harus berupa angka',
        ],
    ];
    
    protected $skipValidation = false;
}