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
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#tambah" ng-click="clear()"><i class="fas fa-plus"></i></button>
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
                            <td>{{item.status == "0" ? "Tidak Aktif" : "Aktif"}}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="tambah" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Tambah Modul {{matakuliah.nama_matakuliah}} | {{jurusan.initial}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="save()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="" class="col-form-label col-form-label-sm">Judul Modul</label>
                            <input type="text" class="form-control form-control-sm" ng-model="model.judul" aria-describedby="helpId" placeholder="" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label col-form-label-sm">Status</label>
                            <select class="form-control form-control-sm" ng-model="model.status" required>
                                <option value="0">Tidak Aktif</option>
                                <option value="1">Aktif</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-form-label col-form-label-sm">File Modul</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input form-control-sm" accept="application/pdf" id="berkas_baptis" ng-model="model.berkas" ng-required="!model.id" base-sixty-four-input>
                                <label class="custom-file-label" for="validatedCustomFile">{{model.berkas? model.berkas.filename : model.id ? model.modul : 'Pilih File...'}}</label>
                            </div>
                            
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