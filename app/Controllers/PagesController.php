<?php

namespace App\Controllers;

use App\Models\CMSModel;
use App\Models\AcademicYearModel;
use App\Models\SettingModel;
use App\Models\MadrasahProfileModel;

class PagesController extends BaseController
{
    protected $cmsModel;
    protected $academicYearModel;
    protected $settingModel;
    protected $madrasahProfileModel;

    public function __construct()
    {
        $this->cmsModel = new CMSModel();
        $this->academicYearModel = new AcademicYearModel();
        $this->settingModel = new SettingModel();
        $this->madrasahProfileModel = new MadrasahProfileModel();
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
        
        // Check if registration is open based on academic year dates
        $isRegistrationOpenByDate = false;
        if ($academicYear) {
            $today = date('Y-m-d');
            $startDate = $academicYear['start_date'];
            $endDate = $academicYear['end_date'];
            
            // Check if today is within registration period
            if ($today >= $startDate && $today <= $endDate) {
                $isRegistrationOpenByDate = true;
            }
        }
        
        // Check setting override
        $settingRegistrationOpen = $this->settingModel->get('registration_open');
        $isRegistrationOpenBySetting = null;
        if ($settingRegistrationOpen !== null) {
            $isRegistrationOpenBySetting = (bool) $settingRegistrationOpen;
        }
        
        // Determine final registration status
        // If setting is explicitly set, use it; otherwise use date-based check
        $isRegistrationOpen = $isRegistrationOpenBySetting !== null ? 
                              $isRegistrationOpenBySetting : 
                              $isRegistrationOpenByDate;
        
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
    
    /**
     * Show madrasah profile page
     */
    public function madrasahProfile()
    {
        $profile = $this->madrasahProfileModel->first();
        
        if (!$profile) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Profil madrasah tidak ditemukan");
        }
        
        $data = [
            'title' => 'Profil Madrasah',
            'profile' => $profile
        ];

        return view('pages/madrasah_profile', $data);
    }
}