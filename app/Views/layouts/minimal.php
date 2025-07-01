<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title . ' - ' : '' ?>SMS</title>
    
    <!-- Minimal CSS -->
    <style>
        :root{--primary:#2563eb;--success:#10b981;--warning:#f59e0b;--info:#06b6d4;--secondary:#6b7280}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:system-ui,sans-serif;background:#f8fafc;line-height:1.5}
        .container-fluid{max-width:1200px;margin:0 auto;padding:1rem}
        .card{background:#fff;border-radius:8px;box-shadow:0 1px 3px rgba(0,0,0,.1);margin-bottom:1rem}
        .card-body{padding:1rem}
        .btn{display:inline-block;padding:.5rem 1rem;border-radius:6px;text-decoration:none;border:1px solid;font-size:.9rem;text-align:center;transition:all .15s}
        .btn-primary{background:var(--primary);color:#fff;border-color:var(--primary)}
        .btn-outline-primary{background:transparent;color:var(--primary);border-color:var(--primary)}
        .btn-outline-primary:hover{background:var(--primary);color:#fff}
        .btn-success{background:var(--success);color:#fff;border-color:var(--success)}
        .btn-outline-success{background:transparent;color:var(--success);border-color:var(--success)}
        .btn-outline-success:hover{background:var(--success);color:#fff}
        .btn-warning{background:var(--warning);color:#fff;border-color:var(--warning)}
        .btn-outline-warning{background:transparent;color:var(--warning);border-color:var(--warning)}
        .btn-outline-warning:hover{background:var(--warning);color:#fff}
        .btn-info{background:var(--info);color:#fff;border-color:var(--info)}
        .btn-outline-info{background:transparent;color:var(--info);border-color:var(--info)}
        .btn-outline-info:hover{background:var(--info);color:#fff}
        .btn-secondary{background:var(--secondary);color:#fff;border-color:var(--secondary)}
        .btn-outline-secondary{background:transparent;color:var(--secondary);border-color:var(--secondary)}
        .btn-outline-secondary:hover{background:var(--secondary);color:#fff}
        .row{display:flex;flex-wrap:wrap;margin:-0.5rem}
        .col-md-3{flex:0 0 25%;padding:0.5rem}
        .col-md-4{flex:0 0 33.333%;padding:0.5rem}
        .col-md-6{flex:0 0 50%;padding:0.5rem}
        .col-md-8{flex:0 0 66.666%;padding:0.5rem}
        .g-2>.col-md-3,.g-2>.col-md-6{padding:0.25rem}
        .w-100{width:100%}
        .d-flex{display:flex}
        .d-block{display:block}
        .justify-content-between{justify-content:space-between}
        .align-items-center{align-items:center}
        .text-white{color:#fff}
        .text-muted{color:#6b7280}
        .text-success{color:var(--success)}
        .mb-0{margin-bottom:0}
        .mb-1{margin-bottom:0.25rem}
        .mb-2{margin-bottom:0.5rem}
        .mb-3{margin-bottom:1rem}
        .me-1{margin-right:0.25rem}
        .p-3{padding:1rem}
        .opacity-75{opacity:0.75}
        .bg-primary{background-color:var(--primary)}
        .bg-success{background-color:var(--success)}
        .bg-warning{background-color:var(--warning)}
        .bg-info{background-color:var(--info)}
        .border-0{border:none}
        .fixed-bottom{position:fixed;bottom:0;left:0;right:0}
        h3{font-size:1.75rem;font-weight:700}
        h5{font-size:1.25rem;font-weight:600}
        h6{font-size:1rem;font-weight:600}
        small{font-size:0.875rem}
        hr{border:none;border-top:1px solid #e5e7eb;margin:0.5rem 0}
        .fas{font-family:"Font Awesome 6 Free";font-weight:900}
        .fa-users:before{content:"\f0c0"}
        .fa-user-graduate:before{content:"\f501"}
        .fa-chalkboard-teacher:before{content:"\f51c"}
        .fa-user-check:before{content:"\f4fc"}
        .fa-user-tag:before{content:"\f507"}
        .fa-heart:before{content:"\f004"}
        .fa-plus:before{content:"\f067"}
        .fa-user:before{content:"\f007"}
        .fa-2x{font-size:2em}
        @media (max-width:768px){
            .col-md-3,.col-md-4,.col-md-6,.col-md-8{flex:0 0 100%}
            .container-fluid{padding:0.5rem}
        }
    </style>
</head>
<body>
    <!-- Top Bar -->
    <div style="background:#fff;border-bottom:1px solid #e5e7eb;padding:0.5rem 0;margin-bottom:1rem">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong style="color:var(--primary)">
                        <i class="fas fa-graduation-cap me-1"></i>
                        Sistem Manajemen Sekolah
                    </strong>
                </div>
                <div>
                    <a href="/logout" class="btn btn-outline-secondary" style="font-size:0.8rem;padding:0.25rem 0.5rem">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="container-fluid">
            <div style="background:#d1fae5;color:#065f46;padding:0.75rem;border-radius:6px;margin-bottom:1rem">
                <?= session()->getFlashdata('success') ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="container-fluid">
            <div style="background:#fee2e2;color:#991b1b;padding:0.75rem;border-radius:6px;margin-bottom:1rem">
                <?= session()->getFlashdata('error') ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Content -->
    <?= $this->renderSection('content') ?>

    <!-- Load Font Awesome icons after page load -->
    <script>
        window.addEventListener('load', function() {
            const link = document.createElement('link');
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
            link.rel = 'stylesheet';
            document.head.appendChild(link);
        });
    </script>
</body>
</html>
