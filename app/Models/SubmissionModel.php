<?php

namespace App\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table = 'submissions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'registration_no',
        'status',
        'rejection_reason',
        'verified_by',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'registration_no' => 'required|max_length[30]',
        'status' => 'required|in_list[menunggu_verifikasi,terverifikasi,diterima,cadangan,ditolak]',
        'rejection_reason' => 'permit_empty|max_length[255]',
        'verified_by' => 'permit_empty|is_natural_no_zero',
    ];
    
    protected $skipValidation = false;
}