<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container" style="width: 800px; margin: 0 auto;">
    <div class="row">
        <div class="col">
            <h2 class="mt-4 ">Detail Komik</h2>
            <div class="row no-gutters">
                <div class="col-md-4">
                    <img src="/img/<?= $komik['sampul']; ?>" class="card-img " alt="...">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h3 class="card-title"><b><?= $komik['judul']; ?></b></h3>
                        <div class="card-text">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Penulis : <?= $komik['penulis']; ?><br></li>
                                <li class="list-group-item">Ilustrator : <?= $komik['ilustrator']; ?></li>
                                <li class="list-group-item">Genre : <?= $komik['genre']; ?></li>
                                <li class="list-group-item">Penerbit : <?= $komik['penerbit']; ?></li>
                                <li class="list-group-item">Tahun terbit : <?= $komik['tahun_terbit']; ?></li>
                            </ul>
                        </div>
                        <?php if (logged_in()) : ?>
                            <a class="btn btn-warning mr-2" href="/komik/edit/<?= $komik['slug']; ?>">Edit</a>
                            <form action="/komik/<?= $komik['id']; ?>" method="post" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin mengahapus?');">Hapus</button>
                            </form>
                        <?php endif; ?>
                        <a href="/komik" class="btn btn-outline-secondary" id="back">Kembali</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card" id="text">
                        <h4>Sinopsis :</h4>
                        <p><?= $komik['sinopsis']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>