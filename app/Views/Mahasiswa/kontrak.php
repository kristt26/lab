<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="jadwalController">
    <div class="row">
        <div class="col-4">
            <div class="row">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title">Nama Matakuliah</h4>
                        <p class="card-text">Pengawas</p>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="row">
                <div class="card text-left">
                    <div class="card-body">
                        <h4 class="card-title">Nama Matakuliah</h4>
                        <p class="card-text">Pengawas</p>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success"><i class="fas fa-plus"></i></button>
                        <button class="btn btn-danger"><i class="fas fa-times"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>