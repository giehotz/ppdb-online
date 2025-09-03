<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->get('/', 'PagesController::index');
$routes->get('/announcements', 'AnnouncementController::index');
$routes->get('/announcement/(:num)', 'AnnouncementController::detail/$1');
$routes->get('/pages/(:segment)', 'PagesController::page/$1');
$routes->get('/pages/madrasah_profil', 'PagesController::madrasahProfile');

// Auth routes
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/attempt-login', 'AuthController::attemptLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/auth/attempt-register', 'AuthController::attemptRegister');
$routes->get('/logout', 'AuthController::logout');

// Profile routes
$routes->get('/profile/edit', 'ProfileController::edit');
$routes->post('/profile/update', 'ProfileController::update');

// User routes
$routes->get('/user/dashboard', 'UserController::dashboard');
$routes->get('/pengguna/dashboard', 'UserController::dashboard'); // Added for user-friendly URL

// Student routes
$routes->get('/student/dashboard', 'StudentController::dashboard', ['filter' => 'role:siswa']);
$routes->get('/siswa/dashboard', 'StudentController::dashboard', ['filter' => 'role:siswa']); // Added for user-friendly URL
$routes->get('/student/registration', 'StudentController::registrationForm', ['filter' => 'role:siswa']);
$routes->post('/student/save-draft', 'StudentController::saveDraft', ['filter' => 'role:siswa']);
$routes->post('/student/submit-registration', 'StudentController::submitRegistration', ['filter' => 'role:siswa']);

// Student document routes
$routes->get('/student/documents', 'DocumentController::index', ['filter' => 'role:siswa']);
$routes->post('/documents/upload', 'DocumentController::upload', ['filter' => 'role:siswa']);
$routes->get('/documents/download/(:num)', 'DocumentController::download/$1', ['filter' => 'role:siswa,panitia,admin']);
$routes->post('/documents/delete/(:num)', 'DocumentController::delete/$1', ['filter' => 'role:siswa']);

// Notification routes
$routes->get('/notifications/unread', 'NotificationController::getUnread');
$routes->get('/notifications/all', 'NotificationController::getAll');
$routes->post('/notifications/mark-as-read', 'NotificationController::markAsRead');

// Announcement routes
$routes->get('/announcement', 'AnnouncementController::index');
$routes->get('/announcement/create', 'AnnouncementController::create', ['filter' => 'role:admin,panitia']);
$routes->post('/announcement/store', 'AnnouncementController::store', ['filter' => 'role:admin,panitia']);
$routes->get('/announcement/edit/(:num)', 'AnnouncementController::edit/$1', ['filter' => 'role:admin,panitia']);
$routes->post('/announcement/update/(:num)', 'AnnouncementController::update/$1', ['filter' => 'role:admin,panitia']);
$routes->get('/announcement/delete/(:num)', 'AnnouncementController::delete/$1', ['filter' => 'role:admin,panitia']);

// Panitia routes
$routes->get('/panitia/dashboard', 'Panitia\DashboardController::index', ['filter' => 'role:panitia']);
$routes->get('/committee/dashboard', 'Panitia\DashboardController::index', ['filter' => 'role:panitia']); // Added for user-friendly URL
$routes->get('/panitia/documents', 'PanitiaController::documents', ['filter' => 'role:panitia']);
$routes->get('/panitia/documents/(:num)', 'PanitiaController::documentDetail/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/verify-document', 'PanitiaController::verifyDocument', ['filter' => 'role:panitia']);

// Panitia registration routes
$routes->get('/panitia/registrations', 'PanitiaRegistrationController::index', ['filter' => 'role:panitia']);
$routes->get('/panitia/registrations/(:num)', 'PanitiaRegistrationController::detail/$1', ['filter' => 'role:panitia']);
$routes->get('/panitia/verification/(:num)', 'Panitia\VerificationController::index/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/update-registration-status', 'Panitia\VerificationController::updateStatus', ['filter' => 'role:panitia']);
$routes->post('/panitia/verify-document', 'Panitia\VerificationController::verifyDocument', ['filter' => 'role:panitia']);

// Panitia student management routes
$routes->get('/panitia/students', 'Panitia\StudentManagementController::index', ['filter' => 'role:panitia']);
$routes->get('/panitia/students/create', 'Panitia\StudentManagementController::create', ['filter' => 'role:panitia']);
$routes->post('/panitia/students/store', 'Panitia\StudentManagementController::store', ['filter' => 'role:panitia']);
$routes->get('/panitia/students/edit/(:num)', 'Panitia\StudentManagementController::edit/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/students/update/(:num)', 'Panitia\StudentManagementController::update/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/students/delete/(:num)', 'Panitia\StudentManagementController::delete/$1', ['filter' => 'role:panitia']);

// Panitia user management routes
$routes->get('/panitia/users', 'Panitia\UserManagementController::index', ['filter' => 'role:panitia']);
$routes->get('/panitia/users/create', 'Panitia\UserManagementController::create', ['filter' => 'role:panitia']);
$routes->post('/panitia/users/store', 'Panitia\UserManagementController::store', ['filter' => 'role:panitia']);
$routes->get('/panitia/users/edit/(:num)', 'Panitia\UserManagementController::edit/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/users/update/(:num)', 'Panitia\UserManagementController::update/$1', ['filter' => 'role:panitia']);
$routes->get('/panitia/users/delete/(:num)', 'Panitia\UserManagementController::delete/$1', ['filter' => 'role:panitia']);

// Panitia export routes
$routes->get('/panitia/export', 'Panitia\ExcelExportController::index', ['filter' => 'role:panitia']);
$routes->post('/panitia/export/submissions', 'Panitia\ExcelExportController::exportSubmissions', ['filter' => 'role:panitia']);
$routes->post('/panitia/export/detailed-report', 'Panitia\ExcelExportController::exportDetailedReport', ['filter' => 'role:panitia']);
$routes->get('/panitia/export/pdf/registration-form/(:num)', 'Panitia\PdfExportController::studentRegistrationForm/$1', ['filter' => 'role:panitia']);
$routes->get('/panitia/export/pdf/registration-receipt/(:num)', 'Panitia\PdfExportController::studentRegistrationReceipt/$1', ['filter' => 'role:panitia']);

// Admin routes
$routes->get('/admin/dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']);
$routes->get('/administrator/dashboard', 'AdminController::dashboard', ['filter' => 'role:admin']); // Added for user-friendly URL
$routes->post('/admin/toggle-registration', 'AdminController::toggleRegistration', ['filter' => 'role:admin']);
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // Admin user management routes
    $routes->get('users', 'Admin\UserManagementController::index');
    $routes->get('users/create', 'Admin\UserManagementController::create');
    $routes->post('users/store', 'Admin\UserManagementController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserManagementController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserManagementController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserManagementController::delete/$1');
    
    // Admin settings routes
    $routes->get('settings', 'Admin\SettingsController::index');
    $routes->post('settings/save', 'Admin\SettingsController::save');
    
    // Admin madrasah profile routes
    $routes->get('madrasah-profile', 'Admin\MadrasahProfileController::index');
    $routes->post('madrasah-profile/save', 'Admin\MadrasahProfileController::save');
    
    // Admin academic years routes
    $routes->get('academic-years', 'Admin\AcademicYearController::index');
    $routes->get('academic-years/form', 'Admin\AcademicYearController::form');
    $routes->get('academic-years/form/(:num)', 'Admin\AcademicYearController::form/$1');
    $routes->post('academic-years/save', 'Admin\AcademicYearController::save');
    $routes->post('academic-years/delete/(:num)', 'Admin\AcademicYearController::delete/$1');
    $routes->post('academic-years/set-active/(:num)', 'Admin\AcademicYearController::setActive/$1');
    
    // Admin CMS routes
    $routes->get('cms', 'Admin\CMSController::index');
    $routes->get('cms/form', 'Admin\CMSController::form');
    $routes->get('cms/form/(:num)', 'Admin\CMSController::form/$1');
    $routes->post('cms/save', 'Admin\CMSController::save');
    $routes->post('cms/delete/(:num)', 'Admin\CMSController::delete/$1');
    
    // Admin submissions routes
    $routes->get('submissions', 'Admin\SubmissionController::index');
    
    // Admin documents routes
    $routes->get('documents', 'Admin\DocumentController::index');
    
    // Admin reports routes
    $routes->get('reports', 'Admin\ReportController::index');
});

// Catch-all route for pages
$routes->get('/(:segment)', 'PagesController::page/$1');