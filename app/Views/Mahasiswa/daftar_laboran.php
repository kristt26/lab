<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="daftarLaboranController">
    <div class="card">
        <div class="card-body">
            <form ng-submit="save()" ng-if="!datas">
                <div class="form-group">
                    <label>Alasan mendaftar</label>
                    <textarea class="form-control" rows="4" ng-model="model.alasan"></textarea>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-info">Daftar</button>
                </div>
            </form>
            <div class="alert alert-warning" role="alert" ng-if="datas">
                Anda telah mendaftar sebagai laboran
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>