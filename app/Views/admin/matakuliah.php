<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="matakuliahController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Daftar Jurusan</h5>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group">
                  <label for="">Pilih Jurusan</label>
                  <select class="form-control" ng-options="item.jurusan for item in datas" ng-model="jurusan" ng-change="showMatakuliah(jurusan)"></select>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama Matakuliah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in matakuliah">
                                <td>{{$index+1}}</td>
                                <td>{{item.kode}}</td>
                                <td>{{item.nama_matakuliah}}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-danger btn-sm" ng-click="delete(item)"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="save()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kode matakuliah</label>
                            <input type="text" class="form-control" ng-model="model.kode" required aria-describedby="helpId" placeholder="Kode Matakuliah">
                        </div>
                        <div class="form-group">
                            <label>Nama matakuliah</label>
                            <input type="text" class="form-control" ng-model="model.nama_matakuliah" required aria-describedby="helpId" placeholder="Nama Matakuliah">
                        </div>
                        <div class="form-group">
                          <label>Jurusan</label>
                          <select class="form-control" ng-model="model.jurusan_id">
                            <option ng-repeat="item in datas" value="{{item.id}}">{{ item.jurusan }}</option>
                          </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>