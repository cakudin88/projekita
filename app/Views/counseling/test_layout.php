<?= $this->extend('layouts/fast') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Test Layout System</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <strong>Success!</strong> Layout system bekerja dengan baik.
                    </div>
                    <p><?= $message ?? 'No message' ?></p>
                    <p>Jika Anda melihat halaman ini dengan sidebar dan header yang benar, berarti layout app.php berfungsi.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
