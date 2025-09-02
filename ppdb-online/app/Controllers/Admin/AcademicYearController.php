<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AcademicYearModel;

class AcademicYearController extends BaseController
{
    protected $academicYearModel;

    public function __construct()
    {
        $this->academicYearModel = new AcademicYearModel();
    }

    /**
     * Show the academic years list
     */
    public function index()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $academicYears = $this->academicYearModel->orderBy('created_at', 'DESC')->findAll();

        $data = [
            'title' => 'Tahun Akademik',
            'academicYears' => $academicYears
        ];

        return view('admin/academic_years/index', $data);
    }

    /**
     * Show the form to create or edit an academic year
     */
    public function form($id = null)
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return redirect()->to('/login');
        }

        $academicYear = null;
        if ($id) {
            $academicYear = $this->academicYearModel->find($id);
            if (!$academicYear) {
                throw new \CodeIgniter\Exceptions\PageNotFoundException("Tahun akademik dengan ID $id tidak ditemukan");
            }
        }

        $data = [
            'title' => $id ? 'Edit Tahun Akademik' : 'Tambah Tahun Akademik',
            'academicYear' => $academicYear
        ];

        return view('admin/academic_years/form', $data);
    }

    /**
     * Save or update an academic year
     */
    public function save()
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $id = $this->request->getPost('id');

        $data = [
            'year_label' => $this->request->getPost('year_label'),
            'wave' => $this->request->getPost('wave'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'announcement_date' => $this->request->getPost('announcement_date'),
            'quota_total' => $this->request->getPost('quota_total'),
            'status' => $this->request->getPost('status'),
        ];

        // Handle quota per class as JSON
        $quotaPerClass = $this->request->getPost('quota_per_class');
        if ($quotaPerClass) {
            $data['quota_per_class'] = json_encode($quotaPerClass);
        }

        // Validate data
        if (!$this->academicYearModel->validate($data)) {
            $errors = $this->academicYearModel->errors();
            $errorMessage = implode(', ', $errors);
            return $this->response->setJSON(['status' => 'error', 'message' => $errorMessage]);
        }

        // Save or update academic year
        if ($id) {
            // Update existing academic year
            $data['id'] = $id;
            if ($this->academicYearModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Tahun akademik berhasil diperbarui.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui tahun akademik.']);
            }
        } else {
            // Create new academic year
            if ($this->academicYearModel->save($data)) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Tahun akademik berhasil disimpan.']);
            } else {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan tahun akademik.']);
            }
        }
    }

    /**
     * Delete an academic year
     */
    public function delete($id)
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        if ($this->academicYearModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Tahun akademik berhasil dihapus.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menghapus tahun akademik.']);
        }
    }

    /**
     * Set academic year as active
     */
    public function setActive($id)
    {
        // Ensure user is logged in and is admin
        if (!session()->has('user_id') || session()->get('role') !== 'admin') {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        // Set all academic years to archived first
        $this->academicYearModel->set(['status' => 'archived'])->update();

        // Set selected academic year as active
        if ($this->academicYearModel->update($id, ['status' => 'active'])) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Tahun akademik berhasil diatur sebagai aktif.']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengatur tahun akademik sebagai aktif.']);
        }
    }
}