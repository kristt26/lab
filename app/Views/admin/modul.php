<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="modulController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Daftar Jurusan</h5>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group">
                    <label for="">Pilih Matakuliah</label>
                    <select class="form-control" ng-options="item.nama_matakuliah for item in datas" ng-model="matakuliah" ng-change="showModul(matakuliah)"></select>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Modul</th>
                                <th>File Modul</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in modul">
                                <td>{{$index+1}}</td>
                                <td>{{item.judul}}</td>
                                <td>{{item.modul}}</td>
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
                            <label>Judul Modul</label>
                            <input type="text" class="form-control" ng-model="model.judul" required aria-describedby="helpId" placeholder="Judul Modul">
                        </div>
                        <div class="form-group">
                            <label>File Modul</label>
                            <input type="file" class="form-control-file" ng-model="model.modul" placeholder="File Modul" aria-describedby="fileHelpId">
                            <small id="fileHelpId" class="form-text text-muted">unggah file modul di sini</small>
                        </div>
                        <div class="form-group">
                            <label>Matakuliah</label>
                            <select class="form-control" ng-model="model.matakuliah_id">
                                <option ng-repeat="item in datas" value="{{item.id}}">{{ item.nama_matakuliah }}</option>
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