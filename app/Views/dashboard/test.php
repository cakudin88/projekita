<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1>Dashboard Test</h1>
    <p>Welcome, <?= session()->get('full_name', 'Guest') ?>!</p>
    <p>Your role: <?= session()->get('role_name', 'Unknown') ?></p>
    
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Users</h5>
                    <h3><?= isset($stats['total_users']) ? $stats['total_users'] : '0' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Roles</h5>
                    <h3><?= isset($stats['total_roles']) ? $stats['total_roles'] : '0' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Students</h5>
                    <h3><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : '0' ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5>Total Teachers</h5>
                    <h3><?= isset($stats['guru_count']) ? $stats['guru_count'] : '0' ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
