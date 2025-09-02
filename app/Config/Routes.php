<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Auth routes
$routes->get('/login', 'AuthController::login');
$routes->post('/auth/attempt-login', 'AuthController::attemptLogin');
$routes->get('/register', 'AuthController::register');
$routes->post('/auth/attempt-register', 'AuthController::attemptRegister');
$routes->get('/logout', 'AuthController::logout');

// Student routes
$routes->get('/student/dashboard', 'StudentController::dashboard', ['filter' => 'role:siswa']);
$routes->get('/student/registration', 'StudentController::registrationForm', ['filter' => 'role:siswa']);
$routes->post('/student/save-draft', 'StudentController::saveDraft', ['filter' => 'role:siswa']);
$routes->post('/student/submit-registration', 'StudentController::submitRegistration', ['filter' => 'role:siswa']);

// Student document routes
$routes->get('/student/documents', 'DocumentController::index', ['filter' => 'role:siswa']);
$routes->post('/documents/upload', 'DocumentController::upload', ['filter' => 'role:siswa']);
$routes->get('/documents/download/(:num)', 'DocumentController::download/$1', ['filter' => 'role:siswa,panitia,admin']);

// Notification routes
$routes->get('/notifications/unread', 'NotificationController::getUnread');
$routes->get('/notifications/all', 'NotificationController::getAll');
$routes->post('/notifications/mark-as-read', 'NotificationController::markAsRead');

// Panitia routes
$routes->get('/panitia/dashboard', 'Panitia\DashboardController::index', ['filter' => 'role:panitia']);
$routes->get('/panitia/documents', 'PanitiaController::documents', ['filter' => 'role:panitia']);
$routes->get('/panitia/documents/(:num)', 'PanitiaController::documentDetail/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/verify-document', 'PanitiaController::verifyDocument', ['filter' => 'role:panitia']);

// Panitia registration routes
$routes->get('/panitia/registrations', 'PanitiaRegistrationController::index', ['filter' => 'role:panitia']);
$routes->get('/panitia/registrations/(:num)', 'PanitiaRegistrationController::detail/$1', ['filter' => 'role:panitia']);
$routes->get('/panitia/verification/(:num)', 'Panitia\VerificationController::index/$1', ['filter' => 'role:panitia']);
$routes->post('/panitia/update-registration-status', 'Panitia\VerificationController::updateStatus', ['filter' => 'role:panitia']);

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
$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // Admin user management routes
    $routes->get('users', 'Admin\UserManagementController::index');
    $routes->get('users/create', 'Admin\UserManagementController::create');
    $routes->post('users/store', 'Admin\UserManagementController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserManagementController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserManagementController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserManagementController::delete/$1');
});