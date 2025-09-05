<?php

/**
 * SubmissionModel
 * 
 * Model to interact with the 'submissions' table in the database.
 * This model provides methods for querying and validating submission records.
 */
namespace App\Models;

use CodeIgniter\Model;

class SubmissionModel extends Model
{
    protected $table = 'submissions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    /**
     * Fields that can be mass-assigned
     */
    protected $allowedFields = [
        'student_id',
        'registration_no',
        'status',
        'rejection_reason',
        'verified_by',
        'academic_year_id',
    ];

    /**
     * Timestamp settings
     */
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /**
     * Validation rules
     */
    protected $validationRules = [
        'student_id' => 'required|is_natural_no_zero',
        'registration_no' => 'required|max_length[30]',
        'status' => 'required|in_list[menunggu_verifikasi,terverifikasi,diterima,cadangan,ditolak]',
        'rejection_reason' => 'permit_empty|max_length[255]',
        'verified_by' => 'permit_empty|is_natural_no_zero',
        'academic_year_id' => 'permit_empty|is_natural_no_zero',
    ];

    protected $skipValidation = false;

    /**
     * Get submissions filtered by academic year
     *
     * @param int $academicYearId ID of the academic year
     * @return array List of submissions
     */
    public function getByAcademicYear($academicYearId)
    {
        return $this->where('academic_year_id', $academicYearId)->findAll();
    }

    /**
     * Get submissions with related academic year information
     *
     * @return array List of submissions with academic year labels
     */
    public function getWithAcademicYear()
    {
        return $this->select('submissions.*, academic_years.year_label')
            ->join('academic_years', 'submissions.academic_year_id = academic_years.id', 'left')
            ->findAll();
    }
}