<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'student_id',
        'doc_type',
        'file_name',
        'file_path',
        'mime_type',
        'size_bytes',
        'status',
        'notes',
        'uploaded_by',
        'uploaded_at',
        'verified_by',
        'verified_at',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'doc_type' => 'required|in_list[birth_certificate,family_card,photo,rapor,kip,other]',
        'file_name' => 'required|max_length[255]',
        'file_path' => 'required|max_length[255]',
        'mime_type' => 'required|max_length[100]',
        'size_bytes' => 'required|integer',
        'status' => 'required|in_list[uploaded,verified,rejected]',
        'notes' => 'permit_empty|max_length[255]',
        'uploaded_by' => 'required|is_natural_no_zero',
        'uploaded_at' => 'required|valid_date',
        'verified_by' => 'permit_empty|is_natural_no_zero',
        'verified_at' => 'permit_empty|valid_date',
    ];
    
    protected $skipValidation = false;
}