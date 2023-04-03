<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div ng-controller="registerController">
    <form ng-submit="save()">
        <div class="form-group row">
            <div class="col-sm-4 mb-3 mb-sm-0">
                <div class="form-group">
                    <label for="">NPM</label>
                    <input type="text" class="form-control" aria-describedby="helpId" ng-model="model.npm" placeholder="NPM Mahasiswa">
                </div>
                <!-- <input type="text" class="form-control" > -->
            </div>
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" aria-describedby="helpId" ng-model="model.npm" placeholder="Nama Mahasiswa">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="">Jurusan</label>
                    <select class="form-control" ng-model="jurusan" ng-options="item.kelas for item in datas.jurusan" ng-change="model.jurusan_id=jurusan.id"></select>
                </div>
            </div>
            <div class="col-sm-4 mb-3 mb-sm-0">
                <div class="form-group">
                    <label for="">Kelas</label>
                    <select class="form-control" ng-model="kelas" ng-options="item.kelas for item in datas.kelas" ng-change="model.kelas_id = kelas.id"></select>
                </div>
            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" class="form-control" ng-model="model.email" placeholder="Email Address">
                </div>
            </div>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="form-group">
                    <div class="form-group">
                        <label for="">Telp/Hp</label>
                        <input type="text" class="form-control" ng-model="model.kontak" placeholder="Telpon/Hp">
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" ng-model="model.alamat" placeholder="Alamat">
        </div>

        <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
    </form>
</div>

<!-- Modal -->
<div class="modal fade" id="role" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Masuk sebagai?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul>
                    <li ng-repeat="item in roles" ng-click="setRole(item)">{{item.role}}</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
</div>

<?= $this->endSection() ?>