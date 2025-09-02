<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'user_id',
        'nis_local',
        'nisn',
        'nik',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'class_level',
        'parallel_class',
        'attendance_no',
        'class_rank',
        'student_status',
        'hobby',
        'aspiration',
        'siblings_count',
        'submission_state',
        'submitted_at',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'user_id' => 'permit_empty|is_natural_no_zero',
        'nis_local' => 'permit_empty|max_length[20]',
        'nisn' => 'permit_empty|exact_length[10]|numeric',
        'nik' => 'required|exact_length[16]|numeric',
        'full_name' => 'required|max_length[150]',
        'birth_place' => 'required|max_length[100]',
        'birth_date' => 'required|valid_date',
        'gender' => 'required|in_list[L,P]',
        'class_level' => 'required|integer|greater_than[0]|less_than_equal_to[6]',
        'parallel_class' => 'permit_empty|max_length[5]',
        'attendance_no' => 'permit_empty|integer',
        'class_rank' => 'permit_empty|integer',
        'student_status' => 'required|in_list[baru,pindahan]',
        'hobby' => 'permit_empty|max_length[100]',
        'aspiration' => 'permit_empty|max_length[100]',
        'siblings_count' => 'integer|greater_than_equal_to[0]',
        'submission_state' => 'required|in_list[draft,submitted]',
        'submitted_at' => 'permit_empty|valid_date',
    ];
    
    protected $validationMessages = [
        'nisn' => [
            'exact_length' => 'NISN harus 10 digit',
            'numeric' => 'NISN harus berupa angka',
        ],
        'nik' => [
            'exact_length' => 'NIK harus 16 digit',
            'numeric' => 'NIK harus berupa angka',
        ],
    ];
    
    protected $skipValidation = false;
}