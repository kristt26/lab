<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="taController">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah data</h4>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Tahun Akademik</label>
                            <input type="text" class="form-control" ng-model="model.tahun_akademik" required aria-describedby="helpId" placeholder="Tahun Akademik">
                        </div>
                        <div class="form-group">
                            <label>Semester</label>
                            <select class="form-control" ng-model ="model.semester">
                              <option value="Ganjil">Ganjil</option>
                              <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mulai Registration</label>
                            <input type="date" class="form-control" ng-model="model.tgl_mulai" required aria-describedby="helpId" placeholder="Tanggal Mulai Registrasi">
                        </div>
                        <div class="form-group">
                            <label>Selesai Registration</label>
                            <input type="date" class="form-control" ng-model="model.tgl_selesai" required aria-describedby="helpId" placeholder="Tanggal Selesai Registrasi">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" ng-model ="model.status">
                              <option value="0">Tidak Aktif</option>
                              <option value="1">Aktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Daftar Tahun Akademik</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tahun Akademik</th>
                                        <th>Semeter</th>
                                        <th>Mulai Registrasi</th>
                                        <th>Selesai Registrasi</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in datas">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.tahun_akademik}}</td>
                                        <td>{{item.semester}}</td>
                                        <td>{{item.tgl_mulai}}</td>
                                        <td>{{item.tgl_selesai}}</td>
                                        <td>{{item.status=="0" ? "Tidak Aktif" : "Aktif"}}</td>
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
        </div>
    </div>
    <!-- Modal -->
</div>
<?= $this->endSection() ?>