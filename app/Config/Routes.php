<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default redirect to login
$routes->get('/', 'AuthController::login');

// Simple test route
$routes->get('/test-simple', function() {
    return 'Simple route working!';
});

$routes->get('/test-basic', 'TestBasicController::index');
$routes->get('/test-base', 'TestBaseController::index');

// BK Controller routes
$routes->get('/bk', 'BKController::index');
$routes->get('/bk/test', 'BKController::testModel');
$routes->get('/bk/dashboard', 'BKController::dashboard');

// Debug routes (without auth filter)
$routes->get('/debug/counseling', 'CounselingController::index');
$routes->get('/debug/counseling-simple', 'CounselingController::simple');
$routes->get('/debug/counseling-category', 'CounselingController::testCategoryModel');
$routes->get('/debug/counseling-models', 'CounselingController::testModels');
$routes->get('/debug/counseling-dashboard', 'CounselingController::dashboard');
$routes->get('/debug/simple-counseling', 'SimpleCounselingController::index');
$routes->get('/debug/test', 'TestController::testCounseling');
$routes->get('/debug/users', 'TestController::testUsers');
$routes->get('/debug', 'DebugController::index');
$routes->get('/debug/check-counseling', 'DebugController::checkCounseling');

// Authentication routes
$routes->get('/login', 'AuthController::login');
$routes->post('/login-process', 'AuthController::loginProcess');
$routes->get('/logout', 'AuthController::logout');

// BK Routes (testing without auth)
$routes->get('/counseling', 'BKController::dashboard');
$routes->get('/counseling/debug', 'BKController::debugView');
$routes->get('/counseling/debug-sessions', 'BKController::debugSessions');
$routes->get('/counseling/sessions-simple', 'BKController::sessionsSimple');
$routes->get('/counseling/simple', 'BKController::simpleHtml');
$routes->get('/counseling/test-layout', 'BKController::testLayout');
$routes->get('/counseling/debug-data', 'BKController::debugData');
$routes->get('/counseling/minimal', 'BKController::minimalDashboard');
$routes->get('/counseling/test-dashboard', 'BKController::testSimpleDashboard');
$routes->get('/counseling/sessions', 'BKController::sessions');
$routes->get('/counseling/create', 'BKController::create');
$routes->get('/counseling/test', 'BKController::testModel');
$routes->get('/counseling/records', 'BKController::records');
$routes->get('/counseling/records/student/(:num)', 'BKController::studentRecords/$1');
$routes->get('/counseling/reports', 'BKController::reports');
$routes->get('/counseling/export', 'BKController::exportReports');
$routes->get('/counseling/api/stats', 'BKController::apiStats');
$routes->post('/counseling/store', 'BKController::store');

// Students & Teachers routes (for Guru BK, Kepala Sekolah, Wali Kelas)
$routes->get('/students', 'StudentsController::index');
$routes->get('/students/detail/(:num)', 'StudentsController::detail/$1');
$routes->get('/teachers', 'TeachersController::index');
$routes->get('/counseling/edit/(:num)', 'BKController::edit/$1');
$routes->post('/counseling/update/(:num)', 'BKController::update/$1');
$routes->delete('/counseling/delete/(:num)', 'BKController::delete/$1');

// Dashboard routes (protected)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/profile', 'DashboardController::profile');
    
    // Test routes
    $routes->get('/test/counseling', 'TestController::testCounseling');
    
    // BK/Counseling routes - using BKController
    $routes->get('/counseling', 'BKController::dashboard');
    $routes->get('/counseling/debug', 'BKController::debugView');
    $routes->get('/counseling/simple', 'BKController::simpleHtml');
    $routes->get('/counseling/test-layout', 'BKController::testLayout');
    $routes->get('/counseling/debug-data', 'BKController::debugData');
    $routes->get('/counseling/minimal', 'BKController::minimalDashboard');
    $routes->get('/counseling/test-dashboard', 'BKController::testSimpleDashboard');
    $routes->get('/counseling/sessions', 'BKController::sessions');
    $routes->get('/counseling/create', 'BKController::create');
    $routes->get('/counseling/test', 'BKController::testModel');
    $routes->get('/counseling-test', 'TestBKController::index');
    
    // CRUD routes for counseling sessions
    $routes->post('/counseling/store', 'BKController::store');
    $routes->get('/counseling/edit/(:num)', 'BKController::edit/$1');
    $routes->post('/counseling/update/(:num)', 'BKController::update/$1');
    $routes->delete('/counseling/delete/(:num)', 'BKController::delete/$1');
});

// Admin routes (for super admin only)
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/create', 'Admin\UserController::create');
    $routes->post('users/store', 'Admin\UserController::store');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->delete('users/delete/(:num)', 'Admin\UserController::delete/$1');
    
    $routes->get('roles', 'Admin\RoleController::index');
    $routes->get('roles/create', 'Admin\RoleController::create');
    $routes->post('roles/store', 'Admin\RoleController::store');
    $routes->get('roles/edit/(:num)', 'Admin\RoleController::edit/$1');
    $routes->post('roles/update/(:num)', 'Admin\RoleController::update/$1');
    $routes->delete('roles/delete/(:num)', 'Admin\RoleController::delete/$1');
});

// Additional route for appointments
$routes->get('/appointments', 'AppointmentController::index');

// Counseling Request routes
$routes->get('/counseling-requests', 'CounselingRequestController::index');
$routes->get('/counseling-requests/create', 'CounselingRequestController::create');
$routes->post('/counseling-requests/store', 'CounselingRequestController::store');
$routes->post('/counseling-requests/approve/(:num)', 'CounselingRequestController::approve/$1');
$routes->post('/counseling-requests/decline/(:num)', 'CounselingRequestController::decline/$1');
