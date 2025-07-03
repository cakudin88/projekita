<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<!-- Chat view -->
<h3>Chat dengan <?= esc($otherUser['full_name']) ?></h3>
<div style="border:1px solid #ccc; padding:10px; height:300px; overflow-y:auto;">
    <?php foreach ($chat as $msg): ?>
        <div style="margin-bottom:8px;">
            <b><?= $msg['sender_id'] == $userId ? 'Saya' : esc($otherUser['full_name']) ?>:</b>
            <?= esc($msg['message']) ?>
            <span style="font-size:10px; color:#888;">(<?= $msg['created_at'] ?>)</span>
        </div>
    <?php endforeach; ?>
</div>
<form method="post" action="/chat/send">
    <input type="hidden" name="receiver_id" value="<?= $otherId ?>">
    <input type="text" name="message" placeholder="Tulis pesan..." required style="width:80%;">
    <button type="submit">Kirim</button>
</form>

<?= $this->endSection() ?>
