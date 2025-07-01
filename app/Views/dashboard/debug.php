<?= $this->extend('layouts/minimal') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">Dashboard Debug - <?= date('d F Y') ?></h5>
            
            <div class="row">
                <div class="col-md-12">
                    <h6>Selamat datang, <?= session()->get('full_name') ?>!</h6>
                    <p>Role: <?= ucwords(str_replace('_', ' ', session()->get('role_name'))) ?></p>
                    
                    <?php if (isset($stats)): ?>
                    <h6>Statistik:</h6>
                    <ul>
                        <li>Total Pengguna: <?= $stats['total_users'] ?? 'Error' ?></li>
                        <li>Total Role: <?= $stats['total_roles'] ?? 'Error' ?></li>
                        <li>Total Siswa: <?= $stats['total_siswa'] ?? 'Error' ?></li>
                        <li>Total Guru: <?= $stats['guru_count'] ?? 'Error' ?></li>
                        <li>Pengguna Aktif: <?= $stats['active_users'] ?? 'Error' ?></li>
                    </ul>
                    <?php else: ?>
                    <p class="text-danger">Stats data tidak tersedia</p>
                    <?php endif; ?>
                    
                    <hr>
                    
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="/optimize" class="btn btn-primary btn-sm w-100">Clear All Cache</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/dashboard/clear-cache" class="btn btn-secondary btn-sm w-100">Clear Dashboard Cache</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/performance" class="btn btn-info btn-sm w-100">Test Performance</a>
                        </div>
                        <div class="col-md-3">
                            <a href="/dashboard/profile" class="btn btn-success btn-sm w-100">Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endsection() ?>
