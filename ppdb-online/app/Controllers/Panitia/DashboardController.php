<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\DocumentModel;
use App\Models\StudentModel;
use App\Models\AddressModel;

class DashboardController extends BaseController
{
    protected $submissionModel;
    protected $documentModel;
    protected $studentModel;
    protected $addressModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->documentModel = new DocumentModel();
        $this->studentModel = new StudentModel();
        $this->addressModel = new AddressModel();
    }

    public function index()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get key metrics
        $totalRegistrants = $this->submissionModel->countAllResults(false);
        $acceptedRegistrants = $this->submissionModel
            ->where('status', 'diterima')
            ->countAllResults(false);
        $pendingVerification = $this->submissionModel
            ->where('status', 'menunggu_verifikasi')
            ->countAllResults(false);
        $newDocuments = $this->documentModel
            ->where('status', 'uploaded')
            ->countAllResults(false);

        // Get registration trend data (last 7 days)
        $registrationTrend = $this->getRegistrationTrend();

        // Get status composition data
        $statusComposition = $this->getStatusComposition();

        // Get geographic distribution data
        $geographicDistribution = $this->getGeographicDistribution();

        // Get school type distribution data
        $schoolTypeDistribution = $this->getSchoolTypeDistribution();

        $data = [
            'title' => 'Dasbor Panitia',
            'totalRegistrants' => $totalRegistrants,
            'acceptedRegistrants' => $acceptedRegistrants,
            'pendingVerification' => $pendingVerification,
            'newDocuments' => $newDocuments,
            'registrationTrend' => $registrationTrend,
            'statusComposition' => $statusComposition,
            'geographicDistribution' => $geographicDistribution,
            'schoolTypeDistribution' => $schoolTypeDistribution
        ];

        return view('panitia/dashboard', $data);
    }

    /**
     * Get registration trend data for the last 7 days
     * 
     * @return array
     */
    private function getRegistrationTrend()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('submissions');
        
        $result = $builder->select("DATE(created_at) as date, COUNT(*) as count")
            ->where('created_at >=', date('Y-m-d', strtotime('-7 days')))
            ->groupBy('DATE(created_at)')
            ->orderBy('date', 'ASC')
            ->get()
            ->getResultArray();
        
        return $result;
    }

    /**
     * Get status composition data
     * 
     * @return array
     */
    private function getStatusComposition()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('submissions');
        
        $result = $builder->select("status, COUNT(*) as count")
            ->groupBy('status')
            ->get()
            ->getResultArray();
        
        return $result;
    }

    /**
     * Get geographic distribution data
     * 
     * @return array
     */
    private function getGeographicDistribution()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('addresses a');
        $builder->join('students s', 'a.student_id = s.id');
        $builder->join('submissions sub', 's.id = sub.student_id');
        
        $result = $builder->select("a.regency as region, COUNT(*) as count")
            ->where('a.regency IS NOT NULL')
            ->groupBy('a.regency')
            ->orderBy('count', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();
        
        return $result;
    }

    /**
     * Get school type distribution data
     * 
     * @return array
     */
    private function getSchoolTypeDistribution()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('prior_schools ps');
        $builder->join('students s', 'ps.student_id = s.id');
        $builder->join('submissions sub', 's.id = sub.student_id');
        
        $result = $builder->select("ps.school_type, COUNT(*) as count")
            ->where('ps.school_type IS NOT NULL')
            ->groupBy('ps.school_type')
            ->get()
            ->getResultArray();
        
        return $result;
    }
}