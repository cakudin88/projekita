<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>SMS</title>
    
    <!-- Optimized CSS Loading -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" async>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" async>
    
    <!-- Critical CSS Inline -->
    <style>
        :root{--primary:#2563eb;--secondary:#1e40af;--success:#10b981;--warning:#f59e0b;--purple:#8b5cf6}
        *{box-sizing:border-box}
        body{font-family:system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#f8fafc;margin:0;line-height:1.5}
        .sidebar{background:linear-gradient(135deg,var(--primary),var(--secondary));min-height:100vh;position:fixed;top:0;left:0;width:250px;transition:transform .2s ease;z-index:1000;overflow-y:auto}
        .sidebar.collapsed{transform:translateX(-250px)}
        .main-content{margin-left:250px;transition:margin .2s ease;min-height:100vh}
        .main-content.expanded{margin-left:0}
        .navbar{background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.1);padding:.5rem 1rem}
        .content-area{padding:1rem}
        .stats-card{background:linear-gradient(135deg,var(--primary),var(--secondary));color:#fff;border-radius:8px;padding:1.25rem;margin-bottom:1rem;transition:transform .15s ease;box-shadow:0 2px 4px rgba(0,0,0,.1)}
        .stats-card:hover{transform:translateY(-2px)}
        .card{border:none;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1)}
        .nav-link{transition:background-color .15s ease}
        .nav-link:hover{background:rgba(255,255,255,.1)}
        .btn{transition:all .15s ease}
        /* Fix untuk menghilangkan blok putih di sidebar */
        .sidebar .nav-link {
            background: transparent !important;
            color: white !important;
        }
        .sidebar .nav-link.bg-white.bg-opacity-20 {
            background: rgba(255,255,255,0.2) !important;
        }
        .sidebar .nav-link:not(.bg-white) {
            background: transparent !important;
        }
        /* Pastikan tidak ada div atau elemen lain yang putih */
        .sidebar div:not(.border-bottom):not(.px-2) {
            background: transparent !important;
        }
        /* Additional CSS fix untuk menghilangkan blok putih */
        .sidebar * {
            background: transparent !important;
        }
        .sidebar .border-bottom {
            background: transparent !important;
        }
        .sidebar .px-2 {
            background: transparent !important;
        }
        .sidebar .nav-link.bg-white.bg-opacity-20 {
            background: rgba(255,255,255,0.2) !important;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1) !important;
        }
        /* Pastikan elemen small tetap transparan */
        .sidebar small {
            background: transparent !important;
        }
        /* Reset semua background di dalam sidebar kecuali yang diperlukan */
        .sidebar div:not(.bg-white):not(.bg-opacity-20) {
            background: transparent !important;
        }
        @media (max-width:768px){
            .sidebar{transform:translateX(-250px)}
            .sidebar.show{transform:translateX(0)}
            .main-content{margin-left:0}
            #toggleSidebar{display:block!important}
        }
    </style>
</head>
<body>
    <!-- Simplified Toggle -->
    <button class="btn btn-primary position-fixed" style="top:10px;left:10px;z-index:1001;display:none" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Optimized Sidebar -->
    <div class="sidebar text-white" id="sidebar">
        <div class="p-3 border-bottom border-white-50">
            <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>SMS</h5>
            <small class="text-white-50">Sistem Manajemen Sekolah</small>
        </div>
        
        <nav class="p-2">
            <a href="/dashboard" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'dashboard' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <a href="/profile" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'profile' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-user me-2"></i>Profile
            </a>
            
            <?php if (session()->get('role_name') == 'super_admin'): ?>
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">ADMINISTRATOR</small>
            </div>
            <a href="/admin/users" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-users me-2"></i>Kelola Pengguna
            </a>
            <a href="/admin/roles" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-user-tag me-2"></i>Kelola Role
            </a>
            <?php endif; ?>

            <?php if (in_array(session()->get('role_name'), ['kepala_sekolah', 'guru_bk', 'wali_kelas'])): ?>
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">AKADEMIK</small>
            </div>
            <a href="/students" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-user-graduate me-2"></i>Data Siswa
            </a>
            <a href="/teachers" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-chalkboard-teacher me-2"></i>Data Guru
            </a>
            <?php endif; ?>

            <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin', 'kepala_sekolah'])): ?>
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">BIMBINGAN KONSELING</small>
            </div>
            <a href="/counseling" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'counseling') === 0 && uri_string() !== 'counseling/sessions' && uri_string() !== 'counseling/create' && uri_string() !== 'counseling/records' && uri_string() !== 'counseling/reports' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-heart me-2"></i>Dashboard BK
            </a>
            <a href="/counseling/sessions" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'counseling/sessions' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-comments me-2"></i>Sesi Konseling
            </a>
            <?php if (in_array(session()->get('role_name'), ['guru_bk', 'super_admin'])): ?>
            <a href="/counseling/create" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'counseling/create' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-plus-circle me-2"></i>Sesi Baru
            </a>
            <?php endif; ?>
            <a href="/counseling/records" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'counseling/records' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-folder-open me-2"></i>Rekam Jejak
            </a>
            <a href="/counseling/reports" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'counseling/reports' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-chart-line me-2"></i>Laporan BK
            </a>
            <a href="/appointments" class="nav-link text-white d-block p-2 text-decoration-none <?= uri_string() == 'appointments' ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-calendar-alt me-2"></i>Jadwal Konseling
            </a>
            <a href="/counseling-requests" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'counseling-requests') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-envelope-open-text me-2"></i>Permintaan Konseling
            </a>
            <a href="/chat" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'chat') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-comments me-2"></i>Chat Siswa
            </a>
            <a href="/incident-reports" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'incident-reports') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-exclamation-triangle me-2"></i>Laporan Kejadian
            </a>
            <?php endif; ?>

            <?php if (session()->get('role_name') == 'wali_murid'): ?>
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">ANAK SAYA</small>
            </div>
            <a href="/my-children" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-child me-2"></i>Data Anak
            </a>
            <a href="/grades" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-chart-line me-2"></i>Nilai Anak
            </a>
            <?php endif; ?>

            <?php if (session()->get('role_name') == 'murid'): ?>
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">AKADEMIK</small>
            </div>
            <a href="/my-grades" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-chart-line me-2"></i>Nilai Saya
            </a>
            <a href="/my-schedule" class="nav-link text-white d-block p-2 text-decoration-none">
                <i class="fas fa-calendar me-2"></i>Jadwal Pelajaran
            </a>
            
            <div class="px-2 mt-3 mb-1">
                <small class="text-white-50">KONSELING</small>
            </div>
            <a href="/counseling-requests" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'counseling-requests') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-envelope-open-text me-2"></i>Permintaan Konseling
            </a>
            <a href="/chat" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'chat') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-comments me-2"></i>Chat Guru BK
            </a>
            <?php if (session()->get('can_report_incident')): ?>
            <a href="/incident-reports" class="nav-link text-white d-block p-2 text-decoration-none <?= strpos(uri_string(), 'incident-reports') === 0 ? 'bg-white bg-opacity-20' : '' ?>">
                <i class="fas fa-exclamation-triangle me-2"></i>Lapor Kejadian
            </a>
            <?php endif; ?>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Simplified Header -->
        <nav class="navbar navbar-light">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1"><?= isset($title) ? $title : 'Dashboard' ?></span>
                
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width:32px;height:32px">
                            <?= strtoupper(substr(session()->get('full_name'), 0, 1)) ?>
                        </div>
                        <span><?= session()->get('full_name') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header"><?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></h6></li>
                        <li><a class="dropdown-item" href="/profile"><i class="fas fa-user me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt me-2"></i>Keluar</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?= $this->renderSection('content') ?>
        </div>
    </div>

    <!-- Optimized JavaScript -->
    <script>
        // Inline critical JavaScript for faster loading
        (function() {
            'use strict';
            
            // Cache DOM elements
            let toggle, sidebar, content;
            
            function initUI() {
                toggle = document.getElementById('toggleSidebar');
                sidebar = document.getElementById('sidebar');
                content = document.getElementById('mainContent');
                
                // Show toggle on mobile
                if (window.innerWidth <= 768 && toggle) {
                    toggle.style.display = 'block';
                }
                
                // Toggle sidebar
                if (toggle) {
                    toggle.addEventListener('click', function() {
                        sidebar.classList.toggle('show');
                    });
                }
                
                // Auto dismiss alerts after 4 seconds
                const alerts = document.querySelectorAll('.alert');
                if (alerts.length > 0) {
                    setTimeout(() => {
                        alerts.forEach(alert => {
                            alert.style.opacity = '0';
                            setTimeout(() => alert.remove(), 300);
                        });
                    }, 4000);
                }
            }
            
            // Fast DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initUI);
            } else {
                initUI();
            }
        })();
    </script>
    
    <!-- Load Bootstrap JS asynchronously -->
    <script>
        // Load Bootstrap JS after page load
        window.addEventListener('load', function() {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js';
            script.async = true;
            document.head.appendChild(script);
        });
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
