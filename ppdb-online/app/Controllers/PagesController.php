<?php

namespace App\Controllers;

use App\Models\CMSModel;
use App\Models\AcademicYearModel;
use App\Models\SettingModel;

class PagesController extends BaseController
{
    protected $cmsModel;
    protected $academicYearModel;
    protected $settingModel;

    public function __construct()
    {
        $this->cmsModel = new CMSModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->settingModel = new SettingModel();
    }

    /**
     * Show the homepage/landing page
     */
    public function index()
    {
        // Get latest announcements (max 3)
        $announcements = $this->cmsModel->getLatestAnnouncements(3);
        
        // Get all published info posts
        $infoPosts = $this->cmsModel->getPublishedInfo();
        
        // Get active academic year
        $academicYear = $this->academicYearModel->getActive();
        
        // Get registration status
        $isRegistrationOpen = $this->settingModel->get('registration_is_open', false);
        
        $data = [
            'title' => 'Beranda',
            'announcements' => $announcements,
            'infoPosts' => $infoPosts,
            'academicYear' => $academicYear,
            'isRegistrationOpen' => $isRegistrationOpen
        ];

        return view('pages/home', $data);
    }

    /**
     * Show a specific page by slug
     */
    public function page($slug)
    {
        $page = $this->cmsModel->getPublishedBySlug($slug);
        
        if (!$page) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Halaman tidak ditemukan");
        }
        
        $data = [
            'title' => $page['title'],
            'page' => $page
        ];

        return view('pages/page', $data);
    }

    /**
     * Show announcements list
     */
    public function announcements()
    {
        $announcements = $this->cmsModel->getPublishedByType('announcement');
        
        $data = [
            'title' => 'Pengumuman',
            'announcements' => $announcements
        ];

        return view('pages/announcements', $data);
    }

    /**
     * Show a specific announcement
     */
    public function announcement($slug)
    {
        $announcement = $this->cmsModel->getPublishedBySlug($slug);
        
        if (!$announcement || $announcement['type'] !== 'announcement') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Pengumuman tidak ditemukan");
        }
        
        $data = [
            'title' => $announcement['title'],
            'announcement' => $announcement
        ];

        return view('pages/announcement', $data);
    }
}