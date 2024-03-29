<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="dosenController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h5>Daftar Dosen</h5>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form ng-submit="save()">
                                <div class="form-group">
                                    <label>NIDN</label>
                                    <input type="text" class="form-control" ng-model="model.kode" required aria-describedby="helpId" placeholder="Kode Matakuliah">
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" ng-model="model.nama_matakuliah" required aria-describedby="helpId" placeholder="Nama Matakuliah">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table datatable="ng" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NIDN</th>
                                            <th>Nama Dosen</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in datas">
                                            <td>{{$index+1}}</td>
                                            <td>{{item.nidn}}</td>
                                            <td>{{item.nama_dosen}}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm" ng-click="delete(item)"><i class="fas fa-trash"></i></button>
                                                <button class="btn btn-info btn-sm" ng-click="reset(item)"><i class="fas fa-retweet"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
                            <label>Semester</label>
                            <input type="text" class="form-control" ng-model="model.semester" required aria-describedby="helpId" placeholder="Semester">
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