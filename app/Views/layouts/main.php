<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>Sistem Manajemen Sekolah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #1e40af;
            --light-blue: #dbeafe;
            --dark-blue: #1e3a8a;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            transition: all 0.3s ease;
            z-index: 1000;
            transform: translateX(0);
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .sidebar .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 600;
        }

        .sidebar-nav {
            padding: 20px 0;
        }

        .sidebar-nav .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border: none;
            transition: all 0.3s ease;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background-color: rgba(255,255,255,0.1);
            color: white;
            border-left: 4px solid white;
        }

        .sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 10px;
        }

        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
        }

        .navbar-brand {
            color: var(--primary-blue) !important;
            font-weight: 600;
            font-size: 1.25rem;
        }

        .content-area {
            padding: 30px;
        }

        .stats-card {
            background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(37, 99, 235, 0.25);
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stats-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .stats-icon {
            opacity: 0.7;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 1px solid #e2e8f0;
            border-radius: 15px 15px 0 0 !important;
        }

        .profile-dropdown .avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-radius: 10px;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
        }

        .alert-success {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .toggle-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--secondary-blue);
            transform: scale(1.05);
        }

        .list-group-item-action {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .list-group-item-action:hover {
            background-color: #f8fafc;
            border-left-color: var(--primary-blue);
            transform: translateX(5px);
        }

        .btn {
            transition: all 0.3s ease;
            border-radius: 8px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-250px);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .toggle-btn {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .toggle-btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Toggle Button -->
    <button class="toggle-btn" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-graduation-cap me-2"></i>SMS</h4>
        </div>
        
        <nav class="sidebar-nav">
            <a href="/dashboard" class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            
            <?php if (session()->get('role_name') == 'super_admin'): ?>
            <hr class="text-white-50 my-3">
            <div class="px-3 mb-2">
                <small class="text-white-50 text-uppercase">Administrator</small>
            </div>
            <a href="/admin/users" class="nav-link">
                <i class="fas fa-users"></i>Kelola Pengguna
            </a>
            <a href="/admin/roles" class="nav-link">
                <i class="fas fa-user-tag"></i>Kelola Role
            </a>
            <?php endif; ?>

            <?php if (in_array(session()->get('role_name'), ['kepala_sekolah', 'guru_bk', 'wali_kelas'])): ?>
            <hr class="text-white-50 my-3">
            <div class="px-3 mb-2">
                <small class="text-white-50 text-uppercase">Akademik</small>
            </div>
            <a href="/students" class="nav-link">
                <i class="fas fa-user-graduate"></i>Data Siswa
            </a>
            <a href="/teachers" class="nav-link">
                <i class="fas fa-chalkboard-teacher"></i>Data Guru
            </a>
            <?php endif; ?>

            <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin', 'kepala_sekolah'])): ?>
            <hr class="text-white-50 my-3">
            <div class="px-3 mb-2">
                <small class="text-white-50 text-uppercase">Bimbingan Konseling</small>
            </div>
            <a href="/counseling" class="nav-link <?= strpos(uri_string(), 'counseling') === 0 ? 'active' : '' ?>">
                <i class="fas fa-heart"></i>Dashboard BK
            </a>
            <a href="/counseling/sessions" class="nav-link <?= uri_string() == 'counseling/sessions' ? 'active' : '' ?>">
                <i class="fas fa-comments"></i>Sesi Konseling
            </a>
            
            <?php endif; ?>
            <a href="/counseling/records" class="nav-link <?= uri_string() == 'counseling/records' ? 'active' : '' ?>">
                <i class="fas fa-folder-open"></i>Rekam Jejak
            </a>
            <a href="/counseling/reports" class="nav-link <?= uri_string() == 'counseling/reports' ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i>Laporan BK
            </a>
            <a href="/appointments" class="nav-link <?= uri_string() == 'appointments' ? 'active' : '' ?>">
                <i class="fas fa-calendar-alt"></i>Jadwal Konseling
            </a>
            <a href="/counseling-requests" class="nav-link <?= strpos(uri_string(), 'counseling-requests') === 0 ? 'active' : '' ?>">
                <i class="fas fa-envelope-open-text"></i>Permintaan Konseling
            </a>
            <?php endif; ?>

            <?php if (session()->get('role_name') == 'wali_murid'): ?>
            <hr class="text-white-50 my-3">
            <div class="px-3 mb-2">
                <small class="text-white-50 text-uppercase">Anak Saya</small>
            </div>
            <a href="/my-children" class="nav-link">
                <i class="fas fa-child"></i>Data Anak
            </a>
            <a href="/grades" class="nav-link">
                <i class="fas fa-chart-line"></i>Nilai Anak
            </a>
            <?php endif; ?>

            <?php if (session()->get('role_name') == 'murid'): ?>
            <hr class="text-white-50 my-3">
            <div class="px-3 mb-2">
                <small class="text-white-50 text-uppercase">Akademik</small>
            </div>
            <a href="/my-grades" class="nav-link">
                <i class="fas fa-chart-line"></i>Nilai Saya
            </a>
            <a href="/my-schedule" class="nav-link">
                <i class="fas fa-calendar"></i>Jadwal Pelajaran
            </a>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <span class="navbar-brand"><?= isset($title) ? $title : 'Dashboard' ?></span>
                
                <div class="navbar-nav ms-auto">
                    <div class="nav-item dropdown profile-dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="avatar me-2">
                                <?= strtoupper(substr(session()->get('full_name'), 0, 1)) ?>
                            </div>
                            <span><?= session()->get('full_name') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><h6 class="dropdown-header"><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></h6></li>
                            <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Auto-dismiss alerts
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Handle responsive sidebar
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                sidebar.classList.remove('show');
                mainContent.classList.remove('expanded');
            } else {
                sidebar.classList.remove('show');
            }
        });
    </script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
