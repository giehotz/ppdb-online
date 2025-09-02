<?php

namespace App\Models;

use CodeIgniter\Model;

class PriorSchoolModel extends Model
{
    protected $table = 'prior_schools';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'school_name',
        'school_level',
        'school_type',
        'accreditation_status',
        'city',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'school_name' => 'required|max_length[150]',
        'school_level' => 'required|in_list[TK,RA,SD,Lainnya]',
        'school_type' => 'required|in_list[negeri,swasta]',
        'accreditation_status' => 'required|in_list[terakreditasi,tidak_terakreditasi,unknown]',
        'city' => 'required|max_length[100]',
    ];
    
    protected $skipValidation = false;
}