<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="modulController">
    <div class="card">
        <!-- <div class="card-header d-flex justify-content-between">
            <h5>Modul Praktikum</h5>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div> -->
        <div class="card-body">
            <div class="d-flex">
                <div class="form-group mr-4 p-2">
                    <label for="">Program Studi</label>
                    <select class="form-control" ng-options="item.jurusan for item in jurusans" ng-model="jurusan" ng-change="showMatakuliah(jurusan)"></select>
                </div>
                <div class="form-group p-2">
                    <label for="">Matakuliah</label>
                    <select class="form-control" ng-options="item.nama_matakuliah for item in matakuliahs" ng-model="matakuliah" ng-change="showModul(matakuliah)"></select>
                </div>
                <div class="ml-auto p-2" ng-if="matakuliah">
                    <button class="btn btn-primary btn-sm" ng-click="setTambah()"><i class="fas fa-plus"></i></button>
                </div>
            </div>
            <div class="table-responsive">
                <table datatable="ng" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th width="30%">Judul</th>
                            <th>File</th>
                            <th>Status</th>
                            <th width="10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="item in moduls">
                            <td>{{$index+1}}</td>
                            <td>{{item.judul}}</td>
                            <td>{{item.modul}}</td>
                            <td>{{item.status}}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" ng-click="delete(item)"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr ng-if="tambah">
                            <td></td>
                            <td><input type="text" class="form-control" id="judull" value="" ng-model="model.judul"></td>
                            <td><input type="file" class="form-control" ng-model="model.berkas"></td>
                            <td>
                                <select class="form-control" ng-model="model.status">
                                    <option value="0">Tidak Aktif</option>
                                    <option value="1">Aktif</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" ng-click="save()"><i class="fas fa-save"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>