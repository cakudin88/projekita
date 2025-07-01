<!-- Review laporan kejadian oleh guru BK -->
<h3>Review Laporan Kejadian</h3>
<p><b>Deskripsi:</b> <?= esc($report['description']) ?></p>
<p><b>Status:</b> <?= esc($report['status']) ?></p>
<form method="post">
    <label>Ubah Status:
        <select name="status">
            <option value="pending" <?= $report['status']==='pending'?'selected':'' ?>>Pending</option>
            <option value="reviewed" <?= $report['status']==='reviewed'?'selected':'' ?>>Reviewed</option>
            <option value="closed" <?= $report['status']==='closed'?'selected':'' ?>>Closed</option>
        </select>
    </label>
    <button type="submit">Simpan</button>
</form>
