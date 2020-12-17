<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-4">Selamat Datang</h1>
            <div class="alert alert-secondary" role="alert">
                Fitur <i>tambah, hapus, dan edit</i> data hanya dilakukan oleh <a href="/login" class="alert-link">admin</a>.
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>