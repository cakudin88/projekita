<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Minimal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Dashboard</h1>
        <p>Welcome: <?= session()->get('full_name', 'Guest') ?></p>
        <p>Role: <?= session()->get('role_name', 'Unknown') ?></p>
        
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3><?= isset($stats['total_users']) ? $stats['total_users'] : '0' ?></h3>
                        <p>Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3><?= isset($stats['total_roles']) ? $stats['total_roles'] : '0' ?></h3>
                        <p>Total Roles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3><?= isset($stats['total_siswa']) ? $stats['total_siswa'] : '0' ?></h3>
                        <p>Total Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h3><?= isset($stats['guru_count']) ? $stats['guru_count'] : '0' ?></h3>
                        <p>Total Teachers</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="/admin/users" class="btn btn-primary">Users</a>
            <a href="/admin/roles" class="btn btn-secondary">Roles</a>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>
