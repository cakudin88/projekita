<?= $this->extend('layouts/fast') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-3"><i class="fas fa-user-graduate me-2"></i>Data Siswa</h1>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>Daftar Siswa</span>
            <form class="d-flex" method="get" action="">
                <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari nama/NIS..." value="<?= esc($_GET['q'] ?? '') ?>">
                <select name="class" class="form-select form-select-sm me-2">
                    <option value="">Semua Kelas</option>
                    <?php
                    $kelasList = array_unique(array_column($students, 'class'));
                    sort($kelasList);
                    foreach ($kelasList as $kelas):
                        $selected = (isset($_GET['class']) && $_GET['class'] == $kelas) ? 'selected' : '';
                    ?>
                        <option value="<?= esc($kelas) ?>" <?= $selected ?>><?= esc($kelas) ?></option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-light btn-sm" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Grade</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Filter logic (simple, for demo)
                        $filtered = $students;
                        if (!empty($_GET['q'])) {
                            $q = strtolower($_GET['q']);
                            $filtered = array_filter($filtered, function($s) use ($q) {
                                return strpos(strtolower($s['name']), $q) !== false || strpos(strtolower($s['nis']), $q) !== false;
                            });
                        }
                        if (!empty($_GET['class'])) {
                            $filtered = array_filter($filtered, function($s) {
                                return $s['class'] == $_GET['class'];
                            });
                        }
                        ?>
                        <?php if (!empty($filtered)): ?>
                            <?php $no = 1; foreach ($filtered as $student): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($student['nis']) ?></td>
                                    <td><?= esc($student['name']) ?></td>
                                    <td><?= esc($student['class']) ?></td>
                                    <td><?= esc($student['grade']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-nis="<?= esc($student['nis']) ?>" data-name="<?= esc($student['name']) ?>" data-class="<?= esc($student['class']) ?>" data-grade="<?= esc($student['grade']) ?>">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center text-muted">Tidak ada data siswa sesuai filter.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Global untuk Detail Siswa -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>NIS:</strong> <span id="modalNis"></span></li>
                    <li class="list-group-item"><strong>Nama:</strong> <span id="modalName"></span></li>
                    <li class="list-group-item"><strong>Kelas:</strong> <span id="modalClass"></span></li>
                    <li class="list-group-item"><strong>Grade:</strong> <span id="modalGrade"></span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var detailModal = document.getElementById('detailModal');
    detailModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        document.getElementById('modalNis').textContent = button.getAttribute('data-nis');
        document.getElementById('modalName').textContent = button.getAttribute('data-name');
        document.getElementById('modalClass').textContent = button.getAttribute('data-class');
        document.getElementById('modalGrade').textContent = button.getAttribute('data-grade');
    });
});
</script>
<?= $this->endSection() ?>
