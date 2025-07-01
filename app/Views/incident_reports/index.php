<!-- Daftar laporan kejadian murid -->
<h3>Laporan Kejadian Saya</h3>
<a href="/incident-reports/create">+ Buat Laporan Baru</a>
<table border="1" cellpadding="5">
<tr><th>Tanggal</th><th>Deskripsi</th><th>Status</th></tr>
<?php foreach ($reports as $r): ?>
<tr>
    <td><?= $r['created_at'] ?></td>
    <td><?= esc($r['description']) ?></td>
    <td><?= esc($r['status']) ?></td>
</tr>
<?php endforeach; ?>
</table>
