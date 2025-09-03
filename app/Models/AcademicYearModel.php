<?php

namespace App\Models;

use CodeIgniter\Model;

class AcademicYearModel extends Model
{
    protected $table = 'academic_years';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'year_label',
        'wave',
        'start_date',
        'end_date',
        'announcement_date',
        'quota_total',
        'quota_per_class',
        'status',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'year_label' => 'required|max_length[9]',
        'wave' => 'permit_empty|integer',
        'start_date' => 'required|valid_date',
        'end_date' => 'required|valid_date',
        'announcement_date' => 'permit_empty|valid_date',
        'quota_total' => 'permit_empty|integer',
        'quota_per_class' => 'permit_empty',
        'status' => 'required|in_list[active,archived]',
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get active academic year
     */
    public function getActive()
    {
        return $this->where('status', 'active')->first();
    }
    
    /**
     * Get academic years by status
     */
    public function getByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }
}