<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="jadwalController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Jadwal Praktikum</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tahun Ajaran</th>
                                <th>Kelas</th>
                                <th>Matakuliah</th>
                                <th>Hari</th>
                                <th>Jam Mulai</th>
                                <th>Jam Selesai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="item in datas.jadwal">
                                <td>{{$index+1}}</td>
                                <td>{{item.ta}}</td>
                                <td>{{item.kelas}}</td>
                                <td>{{item.matakuliah}}</td>
                                <td>{{item.hari}}</td>
                                <td>{{item.jam_mulai}}</td>
                                <td>{{item.jam_selesai}}</td>
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
                    <h5 class="modal-title">Tambah Jadwal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="save()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun Ajaran</label>
                            <input type="text" class="form-control" ng-model="datas.ta.tahun_akademik" required aria-describedby="helpId" placeholder="Tahun Akademik" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select class="form-control" ng-options="item.jurusan for item in datas.jurusan" ng-model="jurusan" ng-change="matakuliahs = jurusan.matakuliah"></select>
                        </div>
                        <div class="form-group">
                            <label>Matakuliah</label>
                            <select class="form-control" ng-options="item.nama_matakuliah for item in matakuliahs" ng-model="matakuliah" ng-change="model.matakuliah_id = matakuliah.id"></select>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control" ng-options="item.kelas for item in datas.kelas" ng-model="kelas" ng-change="model.kelas_id = kelas.id"></select>
                        </div>
                        <div class="form-group">
                            <label>Hari</label>
                            <select class="form-control" ng-options="item for item in hari" ng-model="model.hari"></select>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Praktikum</label>
                            <div class="form-inline d-flex justify-content-between">
                                <!-- <div class="form-group"> -->
                                <input type="time" ng-model="model.jam_mulai" class="form-control mr-4" placeholder="" aria-describedby="helpId">
                                <span>s/d</span>
                                <input type="time" ng-model="model.jam_selesai" class="form-control ml-4" placeholder="" aria-describedby="helpId">
                                <!-- </div> -->
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