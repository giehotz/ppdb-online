<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyCardModel extends Model
{
    protected $table = 'family_cards';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'kk_number',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'kk_number' => 'required|exact_length[16]|numeric',
    ];
    
    protected $validationMessages = [
        'kk_number' => [
            'exact_length' => 'Nomor KK harus 16 digit angka',
            'numeric' => 'Nomor KK harus berupa angka',
        ],
    ];
    
    protected $skipValidation = false;
}