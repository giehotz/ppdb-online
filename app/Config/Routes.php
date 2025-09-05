<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'PagesController::index');


// Authentication routes
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::attemptRegister');
$routes->get('/auth/force-change-password', 'AuthController::forceChangePassword');
$routes->post('/auth/process-force-change-password', 'AuthController::processForceChangePassword');

// Student registration routes
$routes->get('/student/registration', 'StudentController::registrationForm');

// Student routes
$routes->group('student', function ($routes) {
    $routes->get('dashboard', 'StudentController::dashboard');
    $routes->post('save-personal', 'StudentController::savePersonal');
    $routes->post('save-school', 'StudentController::saveSchool');
    $routes->post('save-address', 'StudentController::saveAddress');
    $routes->post('save-parents', 'StudentController::saveParents');
    $routes->post('save-family-card', 'StudentController::saveFamilyCard');
    $routes->post('submit-final', 'StudentController::submitFinal');
});

// Admin routes
$routes->group('admin', function ($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/(:num)/edit', 'Admin\UserController::edit/$1');
    $routes->post('users/(:num)/update', 'Admin\UserController::update/$1');
    $routes->post('users/(:num)/delete', 'Admin\UserController::delete/$1');
    $routes->get('users/(:num)/reset-password', 'Admin\UserController::resetPassword/$1');

    // Academic Year routes
    $routes->get('academic-years', 'Admin\AcademicYearController::index');
    $routes->get('academic-years/create', 'Admin\AcademicYearController::create');
    $routes->post('academic-years/store', 'Admin\AcademicYearController::store');
    $routes->get('academic-years/(:num)/edit', 'Admin\AcademicYearController::edit/$1');
    $routes->post('academic-years/(:num)/update', 'Admin\AcademicYearController::update/$1');
    $routes->post('academic-years/(:num)/delete', 'Admin\AcademicYearController::delete/$1');

    // Madrasah Profile routes
    $routes->get('madrasah-profile', 'Admin\MadrasahProfileController::index');
    $routes->post('madrasah-profile/save', 'Admin\MadrasahProfileController::save');

    // Settings routes
    $routes->get('settings', 'Admin\SettingsController::index');
    $routes->post('settings/update', 'Admin\SettingsController::update');

    // CMS routes
    $routes->get('cms', 'Admin\CMSController::index');
    $routes->get('cms/create', 'Admin\CMSController::create');
    $routes->post('cms/store', 'Admin\CMSController::store');
    $routes->get('cms/(:num)/edit', 'Admin\CMSController::edit/$1');
    $routes->post('cms/(:num)/update', 'Admin\CMSController::update/$1');
    $routes->post('cms/(:num)/delete', 'Admin\CMSController::delete/$1');

    // Document routes
    $routes->get('documents', 'Admin\DocumentController::index');
    $routes->get('documents/create', 'Admin\DocumentController::create');
    $routes->post('documents/store', 'Admin\DocumentController::store');
    $routes->get('documents/(:num)/edit', 'Admin\DocumentController::edit/$1');
    $routes->post('documents/(:num)/update', 'Admin\DocumentController::update/$1');
    $routes->post('documents/(:num)/delete', 'Admin\DocumentController::delete/$1');

    // Submission routes
    $routes->get('submissions', 'Admin\SubmissionController::index');
    $routes->get('submissions/(:num)', 'Admin\SubmissionController::show/$1');
    $routes->post('submissions/(:num)/verify', 'Admin\SubmissionController::verify/$1');
    $routes->post('submissions/(:num)/accept', 'Admin\SubmissionController::accept/$1');
    $routes->post('submissions/(:num)/reject', 'Admin\SubmissionController::reject/$1');
    $routes->post('submissions/(:num)/delete', 'Admin\SubmissionController::delete/$1');

    // Report routes
    $routes->get('reports', 'Admin\ReportController::index');
    $routes->get('reports/export', 'Admin\ReportController::export');
    
    // Panitia User Management routes
    $routes->get('users/create', 'Panitia\UserManagementController::create');
    $routes->post('users/store', 'Panitia\UserManagementController::store');
    $routes->get('users/(:num)/edit', 'Panitia\UserManagementController::edit/$1');
    $routes->post('users/(:num)/update', 'Panitia\UserManagementController::update/$1');
    $routes->post('users/(:num)/delete', 'Panitia\UserManagementController::delete/$1');
});

// Pages routes (public)
$routes->get('/pages/(:any)', 'PagesController::show/$1');

// Profile routes
$routes->get('/profile', 'ProfileController::index');
$routes->get('/profile/edit', 'ProfileController::edit');
$routes->post('/profile/update', 'ProfileController::update');
$routes->post('/profile/change-password', 'ProfileController::changePassword');

// Notification routes
$routes->get('/notifications', 'NotificationController::index');
$routes->post('/notifications/mark-as-read', 'NotificationController::markAsRead');
$routes->post('/notifications/mark-all-as-read', 'NotificationController::markAllAsRead');

// Announcement routes
$routes->get('/announcements', 'AnnouncementController::index');
$routes->get('/announcements/(:num)', 'AnnouncementController::show/$1');

// Panitia routes
$routes->group('panitia', function ($routes) {
    $routes->get('dashboard', 'Panitia\DashboardController::index');
    $routes->get('students', 'Panitia\StudentManagementController::index');
    $routes->get('students/(:num)', 'Panitia\StudentManagementController::show/$1');
    $routes->get('students/(:num)/verify', 'Panitia\VerificationController::show/$1');
    $routes->post('students/(:num)/verify', 'Panitia\VerificationController::verify/$1');
    $routes->get('students/(:num)/accept', 'Panitia\VerificationController::accept/$1');
    $routes->post('students/(:num)/accept', 'Panitia\VerificationController::accept/$1');
    $routes->get('students/(:num)/reject', 'Panitia\VerificationController::reject/$1');
    $routes->post('students/(:num)/reject', 'Panitia\VerificationController::reject/$1');
    $routes->get('export/excel', 'Panitia\ExcelExportController::index');
    $routes->get('export/pdf', 'Panitia\PdfExportController::index');
    $routes->get('export/pdf/(:num)', 'Panitia\PdfExportController::generate/$1');
});

// Document routes (public)
$routes->get('/documents', 'DocumentController::index');
$routes->get('/documents/download/(:num)', 'DocumentController::download/$1');

// Test routes
$routes->get('/test', 'TestController::index');