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
$routes->get('/debug/students', 'DebugController::checkStudentData');
$routes->get('/debug/dashboard', 'DebugController::dashboard');

// Debug routes
$routes->get('/debug', 'DebugTest::index');
$routes->get('/debug/test', 'DebugTest::testView');

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

    // === CHAT & INCIDENT REPORT ROUTES ===
    // Chat: murid ke guru_bk, guru_bk ke murid
    $routes->get('/chat', 'ChatController::index');
    $routes->get('/chat/(:num)', 'ChatController::index/$1');
    $routes->post('/chat/send', 'ChatController::send');

    // Incident report: murid (khusus yang boleh), guru_bk (manage)
    $routes->get('/incident-reports', 'IncidentReportController::index');
    $routes->get('/incident-reports/create', 'IncidentReportController::create');
    $routes->post('/incident-reports/create', 'IncidentReportController::create');
    $routes->get('/incident-reports/review/(:num)', 'IncidentReportController::review/$1');
    $routes->post('/incident-reports/review/(:num)', 'IncidentReportController::review/$1');

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
// Counseling Requests Routes (Role-based)
$routes->get('/counseling-requests', 'CounselingRequestController::index');
$routes->get('/counseling-requests/status', 'CounselingRequestController::status');
$routes->get('/counseling-requests/create', 'CounselingRequestController::create');
$routes->post('/counseling-requests/store', 'CounselingRequestController::store');
$routes->get('/counseling-requests/manage-list', 'CounselingRequestController::manage_list');
$routes->get('/counseling-requests/manage/(:num)', 'CounselingRequestController::manage/$1');
$routes->post('/counseling-requests/approve/(:num)', 'CounselingRequestController::approve/$1');
$routes->post('/counseling-requests/reject/(:num)', 'CounselingRequestController::reject/$1');

// Dashboard routes
$routes->get('/dashboard/lightning', 'DashboardController::lightning', ['filter' => 'auth']);

// Dashboard debug routes
$routes->get('/dashboard/debug', 'DashboardController::debug', ['filter' => 'auth']);

// Dashboard cache management
$routes->get('/dashboard/clear-cache', 'DashboardController::clearCache', ['filter' => 'auth']);
$routes->get('/dashboard/clearCache', 'DashboardController::clearCache');

// Performance optimization routes
$routes->get('/optimize', 'OptimizeController::index', ['filter' => 'auth']);
$routes->get('/optimize/status', 'OptimizeController::status', ['filter' => 'auth']);

// Performance testing routes (development only)
$routes->get('/performance', 'PerformanceTestController::index', ['filter' => 'auth']);
$routes->get('/performance/benchmark', 'PerformanceTestController::benchmark', ['filter' => 'auth']);

// Database testing routes
$routes->get('/db-test', 'DatabaseTestController::index');

// Database fix route (temporary)

// User list route (temporary for development)
$routes->get('/users/list', 'UserListController::listUsers');


