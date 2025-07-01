<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Rekam Jejak Konseling</h1>
                    <p class="text-muted mb-0">Riwayat konseling semua siswa</p>
                </div>
                <div>
                    <a href="/counseling" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>

            <!-- Filter dan Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Kelas</label>
                            <select class="form-select" id="filterClass">
                                <option value="">Semua Kelas</option>
                                <option value="7A">7A</option>
                                <option value="7B">7B</option>
                                <option value="7C">7C</option>
                                <option value="8A">8A</option>
                                <option value="8B">8B</option>
                                <option value="8C">8C</option>
                                <option value="9A">9A</option>
                                <option value="9B">9B</option>
                                <option value="9C">9C</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Jumlah Sesi</label>
                            <select class="form-select" id="filterSessions">
                                <option value="">Semua</option>
                                <option value="0">Belum pernah konseling</option>
                                <option value="1-3">1-3 sesi</option>
                                <option value="4-10">4-10 sesi</option>
                                <option value="10+">Lebih dari 10 sesi</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pencarian</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchStudent" placeholder="Cari nama atau NIS siswa...">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-folder-open me-2"></i>Rekam Jejak Siswa
                        </h5>
                        <div>
                            <button class="btn btn-outline-primary btn-sm me-2">
                                <i class="fas fa-download me-1"></i>Export
                            </button>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-print me-1"></i>Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-warning">
                            <strong>Peringatan:</strong> <?= $error ?>
                            <br><small>Menampilkan data contoh untuk demo.</small>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($students)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data rekam jejak</h5>
                            <p class="text-muted">Data rekam jejak akan muncul setelah ada sesi konseling.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="recordsTable">
                                <thead>
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Sesi</th>
                                        <th>Sesi Terakhir</th>
                                        <th>Kategori Terakhir</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?= $student['nis'] ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-2">
                                                        <?= strtoupper(substr($student['name'], 0, 2)) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= $student['name'] ?></strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark"><?= $student['class'] ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary"><?= $student['total_sessions'] ?></span>
                                            </td>
                                            <td>
                                                <?php if ($student['latest_session']): ?>
                                                    <?= date('d/m/Y', strtotime($student['latest_session'])) ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($student['last_category']): ?>
                                                    <span class="badge bg-info"><?= $student['last_category'] ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                $statusClass = 'bg-success';
                                                $statusText = 'Normal';
                                                
                                                if ($student['total_sessions'] == 0) {
                                                    $statusClass = 'bg-secondary';
                                                    $statusText = 'Belum Konseling';
                                                } elseif ($student['total_sessions'] >= 5) {
                                                    $statusClass = 'bg-warning';
                                                    $statusText = 'Perlu Perhatian';
                                                } elseif ($student['total_sessions'] >= 10) {
                                                    $statusClass = 'bg-danger';
                                                    $statusText = 'Butuh Intervensi';
                                                }
                                                ?>
                                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            onclick="viewRecords(<?= $student['id'] ?>)" title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <a href="/counseling/create?student_id=<?= $student['id'] ?>" 
                                                       class="btn btn-outline-success" title="Buat Sesi Baru">
                                                        <i class="fas fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Rekam Jejak Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <div class="text-center py-3">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                        <p class="text-muted mt-2">Memuat data...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 40px;
    height: 40px;
    background-color: #007bff;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
</style>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterClass = document.getElementById('filterClass');
    const filterSessions = document.getElementById('filterSessions');
    const searchStudent = document.getElementById('searchStudent');
    const table = document.getElementById('recordsTable');
    
    function filterTable() {
        const classFilter = filterClass.value.toLowerCase();
        const sessionFilter = filterSessions.value;
        const searchTerm = searchStudent.value.toLowerCase();
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let row of rows) {
            const cells = row.getElementsByTagName('td');
            const nis = cells[0].textContent.toLowerCase();
            const name = cells[1].textContent.toLowerCase();
            const className = cells[2].textContent.toLowerCase();
            const totalSessions = parseInt(cells[3].textContent);
            
            let showRow = true;
            
            // Class filter
            if (classFilter && !className.includes(classFilter)) {
                showRow = false;
            }
            
            // Session filter
            if (sessionFilter) {
                if (sessionFilter === '0' && totalSessions > 0) showRow = false;
                if (sessionFilter === '1-3' && (totalSessions < 1 || totalSessions > 3)) showRow = false;
                if (sessionFilter === '4-10' && (totalSessions < 4 || totalSessions > 10)) showRow = false;
                if (sessionFilter === '10+' && totalSessions <= 10) showRow = false;
            }
            
            // Search filter
            if (searchTerm && !name.includes(searchTerm) && !nis.includes(searchTerm)) {
                showRow = false;
            }
            
            row.style.display = showRow ? '' : 'none';
        }
    }
    
    filterClass.addEventListener('change', filterTable);
    filterSessions.addEventListener('change', filterTable);
    searchStudent.addEventListener('input', filterTable);
});

function viewRecords(studentId) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const modalContent = document.getElementById('modalContent');
    
    // Show loading
    modalContent.innerHTML = `
        <div class="text-center py-3">
            <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
            <p class="text-muted mt-2">Memuat data...</p>
        </div>
    `;
    
    modal.show();
    
    // Fetch student records
    fetch(`/counseling/records/student/${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const student = data.student;
                const sessions = data.sessions;
                
                let timelineHtml = '';
                if (sessions.length > 0) {
                    sessions.forEach(session => {
                        const statusClass = session.status === 'completed' ? 'bg-success' : 'bg-primary';
                        const statusText = session.status === 'completed' ? 'Selesai' : 'Berlangsung';
                        
                        timelineHtml += `
                            <div class="timeline-item">
                                <div class="timeline-marker ${statusClass}"></div>
                                <div class="timeline-content">
                                    <h6>${new Date(session.session_date).toLocaleDateString('id-ID')}</h6>
                                    <p class="text-muted mb-1">Kategori: ${session.category_name}</p>
                                    <p>${session.description}</p>
                                    ${session.notes ? `<p class="text-muted"><small>Catatan: ${session.notes}</small></p>` : ''}
                                    <span class="badge ${statusClass}">${statusText}</span>
                                </div>
                            </div>
                        `;
                    });
                } else {
                    timelineHtml = '<p class="text-center text-muted">Belum ada sesi konseling.</p>';
                }
                
                modalContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <div class="avatar-circle mx-auto mb-3" style="width: 80px; height: 80px; font-size: 24px;">
                                        ${student.name.substr(0, 2).toUpperCase()}
                                    </div>
                                    <h5>${student.name}</h5>
                                    <p class="text-muted">NIS: ${student.nis}</p>
                                    <span class="badge bg-light text-dark">${student.class}</span>
                                    ${student.email ? `<p class="text-muted mt-2"><small>${student.email}</small></p>` : ''}
                                    ${student.phone ? `<p class="text-muted"><small>${student.phone}</small></p>` : ''}
                                    <a href="/counseling/create?student_id=${student.id}" class="btn btn-success btn-sm mt-3 w-100">
                                        <i class="fas fa-plus me-1"></i>Buat Sesi Baru
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="mb-3">Riwayat Sesi Konseling (${data.total_sessions} sesi)</h6>
                            <div class="timeline">
                                ${timelineHtml}
                            </div>
                        </div>
                    </div>
                `;
            } else {
                modalContent.innerHTML = `
                    <div class="alert alert-danger">
                        <strong>Error:</strong> ${data.message}
                    </div>
                `;
            }
        })
        .catch(error => {
            modalContent.innerHTML = `
                <div class="alert alert-danger">
                    <strong>Error:</strong> Gagal memuat data. ${error.message}
                </div>
            `;
        });
}
</script>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #dee2e6;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 3px solid #007bff;
}
</style>

<?= $this->endSection() ?>
