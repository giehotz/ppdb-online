<?php

namespace App\Controllers\Panitia;

use App\Controllers\BaseController;
use App\Models\SubmissionModel;
use App\Models\StudentModel;
use App\Models\ParentModel;
use App\Models\AddressModel;
use App\Models\PriorSchoolModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class ExcelExportController extends BaseController
{
    protected $submissionModel;
    protected $studentModel;
    protected $parentModel;
    protected $addressModel;
    protected $priorSchoolModel;

    public function __construct()
    {
        $this->submissionModel = new SubmissionModel();
        $this->studentModel = new StudentModel();
        $this->parentModel = new ParentModel();
        $this->addressModel = new AddressModel();
        $this->priorSchoolModel = new PriorSchoolModel();
    }

    public function index()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        return view('panitia/export_options', ['title' => 'Opsi Ekspor Data']);
    }

    public function exportSubmissions()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get filter parameters
        $status = $this->request->getPost('status');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $format = $this->request->getPost('format') ?? 'xlsx';

        // Build query with filters
        $builder = $this->submissionModel
            ->select('submissions.*, students.full_name, students.nisn, students.nik, students.birth_date, students.gender, students.class_level')
            ->join('students', 'submissions.student_id = students.id');

        if ($status && $status !== 'all') {
            $builder->where('submissions.status', $status);
        }

        if ($startDate) {
            $builder->where('submissions.created_at >=', $startDate);
        }

        if ($endDate) {
            $builder->where('submissions.created_at <=', $endDate . ' 23:59:59');
        }

        $submissions = $builder->orderBy('submissions.created_at', 'ASC')->findAll();

        // Prepare data for export
        $exportData = [];
        $header = [
            'No', 'No. Registrasi', 'Nama Lengkap', 'NISN', 'NIK', 'Tanggal Lahir', 'Jenis Kelamin', 
            'Kelas yang Dituju', 'Status', 'Tanggal Daftar'
        ];

        $exportData[] = $header;

        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'diterima' => 'Diterima',
            'cadangan' => 'Cadangan',
            'ditolak' => 'Ditolak'
        ];

        foreach ($submissions as $index => $submission) {
            $exportData[] = [
                $index + 1,
                $submission['registration_no'],
                $submission['full_name'],
                $submission['nisn'] ?? '-',
                $submission['nik'],
                date('d/m/Y', strtotime($submission['birth_date'])),
                $submission['gender'] === 'L' ? 'Laki-laki' : 'Perempuan',
                $submission['class_level'],
                $statusLabels[$submission['status']] ?? $submission['status'],
                date('d/m/Y H:i', strtotime($submission['created_at']))
            ];
        }

        // Export to selected format
        if ($format === 'csv') {
            $this->exportToCsv($exportData, 'Laporan_Pendaftaran_' . date('Y-m-d'));
        } else {
            $this->exportToExcel($exportData, 'Laporan_Pendaftaran_' . date('Y-m-d'));
        }
    }

    public function exportDetailedReport()
    {
        // Ensure user is logged in and is panitia
        if (!session()->has('user_id') || session()->get('role') !== 'panitia') {
            return redirect()->to('/login');
        }

        // Get filter parameters
        $status = $this->request->getPost('status');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $format = $this->request->getPost('format') ?? 'xlsx';

        // Build query with filters
        $builder = $this->submissionModel
            ->select('submissions.*, students.*, users.username')
            ->join('students', 'submissions.student_id = students.id')
            ->join('users', 'students.user_id = users.id', 'left');

        if ($status && $status !== 'all') {
            $builder->where('submissions.status', $status);
        }

        if ($startDate) {
            $builder->where('submissions.created_at >=', $startDate);
        }

        if ($endDate) {
            $builder->where('submissions.created_at <=', $endDate . ' 23:59:59');
        }

        $submissions = $builder->orderBy('submissions.created_at', 'ASC')->findAll();

        // Prepare data for export
        $exportData = [];
        $header = [
            'No', 'No. Registrasi', 'Username', 'Nama Lengkap', 'NISN', 'NIK', 'Tempat Lahir', 'Tanggal Lahir', 
            'Jenis Kelamin', 'Kelas yang Dituju', 'Kelas Paralel', 'No. Absen', 'Peringkat Kelas', 
            'Status Siswa', 'Hobi', 'Cita-cita', 'Jumlah Saudara', 'Status Pendaftaran', 'Alasan Penolakan', 
            'Tanggal Daftar'
        ];

        $exportData[] = $header;

        $statusLabels = [
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'diterima' => 'Diterima',
            'cadangan' => 'Cadangan',
            'ditolak' => 'Ditolak'
        ];

        foreach ($submissions as $index => $submission) {
            $exportData[] = [
                $index + 1,
                $submission['registration_no'],
                $submission['username'] ?? '-',
                $submission['full_name'],
                $submission['nisn'] ?? '-',
                $submission['nik'],
                $submission['birth_place'],
                date('d/m/Y', strtotime($submission['birth_date'])),
                $submission['gender'] === 'L' ? 'Laki-laki' : 'Perempuan',
                $submission['class_level'],
                $submission['parallel_class'] ?? '-',
                $submission['attendance_no'] ?? '-',
                $submission['class_rank'] ?? '-',
                $submission['student_status'] === 'baru' ? 'Baru' : 'Pindahan',
                $submission['hobby'] ?? '-',
                $submission['aspiration'] ?? '-',
                $submission['siblings_count'],
                $statusLabels[$submission['status']] ?? $submission['status'],
                $submission['rejection_reason'] ?? '-',
                date('d/m/Y H:i', strtotime($submission['created_at']))
            ];
        }

        // Export to selected format
        if ($format === 'csv') {
            $this->exportToCsv($exportData, 'Laporan_Detail_Pendaftaran_' . date('Y-m-d'));
        } else {
            $this->exportToExcel($exportData, 'Laporan_Detail_Pendaftaran_' . date('Y-m-d'));
        }
    }

    private function exportToExcel($data, $filename)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Fill the sheet with data
        foreach ($data as $rowIndex => $rowData) {
            $colIndex = 'A';
            foreach ($rowData as $cellData) {
                $sheet->setCellValue($colIndex . ($rowIndex + 1), $cellData);
                $colIndex++;
            }
        }

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    private function exportToCsv($data, $filename)
    {
        // Set headers for download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="' . $filename . '.csv"');
        header('Cache-Control: max-age=0');

        $output = fopen('php://output', 'w');
        
        foreach ($data as $rowData) {
            fputcsv($output, $rowData);
        }
        
        fclose($output);
        exit;
    }
}