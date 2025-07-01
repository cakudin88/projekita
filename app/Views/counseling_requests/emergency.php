<?= $this->extend('layouts/fast') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Error Database</h4>
                <p>Tabel <code>counseling_requests</code> belum ada atau belum memiliki struktur yang benar.</p>
                <hr>
                <p class="mb-0">Silakan ikuti langkah-langkah berikut untuk memperbaiki:</p>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-wrench me-2"></i>Langkah Perbaikan</h5>
                </div>
                <div class="card-body">
                    <ol>
                        <li class="mb-3">
                            <strong>Buka phpMyAdmin</strong>
                            <br><small class="text-muted">Akses: <a href="http://localhost/phpmyadmin" target="_blank">http://localhost/phpmyadmin</a></small>
                        </li>
                        <li class="mb-3">
                            <strong>Pilih Database Aplikasi</strong>
                            <br><small class="text-muted">Pilih database yang digunakan oleh aplikasi ini</small>
                        </li>
                        <li class="mb-3">
                            <strong>Klik Tab "SQL"</strong>
                            <br><small class="text-muted">Di bagian atas phpMyAdmin</small>
                        </li>
                        <li class="mb-3">
                            <strong>Copy & Paste Script SQL</strong>
                            <br><small class="text-muted">Copy isi file <code>create_missing_tables.sql</code> dan paste di area SQL</small>
                        </li>
                        <li class="mb-3">
                            <strong>Klik "Go"</strong>
                            <br><small class="text-muted">Untuk menjalankan script SQL</small>
                        </li>
                        <li>
                            <strong>Refresh Halaman Ini</strong>
                            <br><small class="text-muted">Setelah script berhasil dijalankan</small>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-code me-2"></i>Script SQL</h5>
                </div>
                <div class="card-body">
                    <p>Copy script berikut ke phpMyAdmin:</p>
                    <div class="bg-dark text-light p-3 rounded" style="font-family: monospace; font-size: 0.9em;">
-- Drop table jika sudah ada (untuk memastikan struktur yang benar)<br>
DROP TABLE IF EXISTS `counseling_requests`;<br><br>

-- Tabel counseling_requests dengan struktur yang benar<br>
CREATE TABLE `counseling_requests` (<br>
&nbsp;&nbsp;`id` int(11) NOT NULL AUTO_INCREMENT,<br>
&nbsp;&nbsp;`student_id` int(11) NOT NULL,<br>
&nbsp;&nbsp;`type` enum('individu','kelompok','klasikal') NOT NULL DEFAULT 'individu',<br>
&nbsp;&nbsp;`theme` varchar(255) NOT NULL,<br>
&nbsp;&nbsp;`group_name` varchar(255) DEFAULT NULL,<br>
&nbsp;&nbsp;`description` text NOT NULL,<br>
&nbsp;&nbsp;`status` enum('pending','approved','rejected','scheduled','completed') NOT NULL DEFAULT 'pending',<br>
&nbsp;&nbsp;`requested_at` timestamp NULL DEFAULT NULL,<br>
&nbsp;&nbsp;`scheduled_at` timestamp NULL DEFAULT NULL,<br>
&nbsp;&nbsp;`approved_by` int(11) DEFAULT NULL,<br>
&nbsp;&nbsp;`approved_at` timestamp NULL DEFAULT NULL,<br>
&nbsp;&nbsp;`created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,<br>
&nbsp;&nbsp;`updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,<br>
&nbsp;&nbsp;PRIMARY KEY (`id`)<br>
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
                    </div>
                    <button class="btn btn-outline-secondary btn-sm mt-2" onclick="copySQL()">
                        <i class="fas fa-copy me-2"></i>Copy Script
                    </button>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="/counseling-requests" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>Coba Lagi
                </a>
                <a href="/dashboard" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-home me-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copySQL() {
    const sqlText = `DROP TABLE IF EXISTS \`counseling_requests\`;

CREATE TABLE \`counseling_requests\` (
  \`id\` int(11) NOT NULL AUTO_INCREMENT,
  \`student_id\` int(11) NOT NULL,
  \`type\` enum('individu','kelompok','klasikal') NOT NULL DEFAULT 'individu',
  \`theme\` varchar(255) NOT NULL,
  \`group_name\` varchar(255) DEFAULT NULL,
  \`description\` text NOT NULL,
  \`status\` enum('pending','approved','rejected','scheduled','completed') NOT NULL DEFAULT 'pending',
  \`requested_at\` timestamp NULL DEFAULT NULL,
  \`scheduled_at\` timestamp NULL DEFAULT NULL,
  \`approved_by\` int(11) DEFAULT NULL,
  \`approved_at\` timestamp NULL DEFAULT NULL,
  \`created_at\` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  \`updated_at\` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (\`id\`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;`;
    
    navigator.clipboard.writeText(sqlText).then(function() {
        alert('Script SQL berhasil dicopy! Paste di phpMyAdmin.');
    });
}
</script>
<?= $this->endSection() ?>
