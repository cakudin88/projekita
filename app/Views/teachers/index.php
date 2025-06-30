<?= $this->extend('layouts/app') ?>
<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-3"><i class="fas fa-chalkboard-teacher me-2"></i>Data Guru</h1>
    <div class="card mb-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list me-2"></i>Daftar Guru</span>
            <form class="d-flex" method="get" action="">
                <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari nama/NIP..." value="<?= esc($_GET['q'] ?? '') ?>">
                <select name="subject" class="form-select form-select-sm me-2">
                    <option value="">Semua Mapel</option>
                    <?php
                    $subjectList = array_unique(array_column($teachers, 'subject'));
                    sort($subjectList);
                    foreach ($subjectList as $subject):
                        $selected = (isset($_GET['subject']) && $_GET['subject'] == $subject) ? 'selected' : '';
                    ?>
                        <option value="<?= esc($subject) ?>" <?= $selected ?>><?= esc($subject) ?></option>
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
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Mata Pelajaran</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Filter logic (simple, for demo)
                        $filtered = $teachers;
                        if (!empty($_GET['q'])) {
                            $q = strtolower($_GET['q']);
                            $filtered = array_filter($filtered, function($t) use ($q) {
                                return strpos(strtolower($t['name']), $q) !== false || strpos(strtolower($t['nip']), $q) !== false;
                            });
                        }
                        if (!empty($_GET['subject'])) {
                            $filtered = array_filter($filtered, function($t) {
                                return $t['subject'] == $_GET['subject'];
                            });
                        }
                        ?>
                        <?php if (!empty($filtered)): ?>
                            <?php $no = 1; foreach ($filtered as $teacher): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($teacher['nip']) ?></td>
                                    <td><?= esc($teacher['name']) ?></td>
                                    <td><?= esc($teacher['subject']) ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal" data-nip="<?= esc($teacher['nip']) ?>" data-name="<?= esc($teacher['name']) ?>" data-subject="<?= esc($teacher['subject']) ?>">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center text-muted">Tidak ada data guru sesuai filter.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Global untuk Detail Guru -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Guru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>NIP:</strong> <span id="modalNip"></span></li>
                    <li class="list-group-item"><strong>Nama:</strong> <span id="modalName"></span></li>
                    <li class="list-group-item"><strong>Mata Pelajaran:</strong> <span id="modalSubject"></span></li>
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
        document.getElementById('modalNip').textContent = button.getAttribute('data-nip');
        document.getElementById('modalName').textContent = button.getAttribute('data-name');
        document.getElementById('modalSubject').textContent = button.getAttribute('data-subject');
    });
});
</script>
<?= $this->endSection() ?>
