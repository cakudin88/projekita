<?php if (!isset($student) || !isset($sessions) || count($sessions) === 0): ?>
    <div class="alert alert-info">Belum ada rekam jejak konseling untuk siswa ini.</div>
<?php else: ?>
    <h6>Rekap Naratif Konseling</h6>
    <ul class="list-group mb-2">
        <?php foreach ($sessions as $session): ?>
            <li class="list-group-item">
                <div class="fw-bold mb-1">
                    <?= date('d M Y', strtotime($session['session_date'])) ?> - <?= esc($session['category_name']) ?>
                    <span class="badge bg-<?= $session['status'] === 'completed' ? 'success' : ($session['status'] === 'ongoing' ? 'warning' : 'secondary') ?> ms-2">
                        <?= ucfirst($session['status']) ?>
                    </span>
                </div>
                <div class="mb-1"><strong>Topik:</strong> <?= esc($session['description']) ?></div>
                <?php if (!empty($session['notes'])): ?>
                    <div class="small text-muted"><strong>Catatan:</strong> <?= esc($session['notes']) ?></div>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
