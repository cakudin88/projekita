<?= $this->extend('layouts/simple') ?>

<?= $this->section('content') ?>

<h1>Dashboard</h1>
<p>Selamat datang di sistem manajemen sekolah!</p>

<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Users</h5>
                <h2><?= isset($stats['total_users']) ? $stats['total_users'] : '0' ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Roles</h5>
                <h2><?= isset($stats['total_roles']) ? $stats['total_roles'] : '0' ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Total Students</h5>
                <h2><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : '0' ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5>Total Teachers</h5>
                <h2><?= isset($stats['guru_count']) ? $stats['guru_count'] : '0' ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Informasi Akun</h5>
            </div>
            <div class="card-body">
                <p><strong>Nama:</strong> <?= session()->get('full_name', 'Guest') ?></p>
                <p><strong>Username:</strong> <?= session()->get('username', 'N/A') ?></p>
                <p><strong>Email:</strong> <?= session()->get('email', 'N/A') ?></p>
                <p><strong>Role:</strong> <?= session()->get('role_name', 'Unknown') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <?php if (session()->get('role_name') == 'super_admin'): ?>
                <a href="/admin/users" class="btn btn-primary me-2 mb-2">Manage Users</a>
                <a href="/admin/roles" class="btn btn-secondary me-2 mb-2">Manage Roles</a>
                <?php endif; ?>
                <a href="/students" class="btn btn-success me-2 mb-2">Students</a>
                <a href="/teachers" class="btn btn-info me-2 mb-2">Teachers</a>
                <a href="/counseling" class="btn btn-warning me-2 mb-2">Counseling</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
