<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="jadwalController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Jadwal Praktikum</h4>
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
        </div>
        <div class="card-body">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a ng-repeat="item in datas.jurusan" ng-class="{'nav-item nav-link active' : $index==0, 'nav-item nav-link':$index !=0}" ng-click="setNilai(item.id)" id="nav-home-{{$index+1}}" data-toggle="tab" href="#nav-home{{$index+1}}" role="tab" aria-controls="nav-home{{$index+1}}" aria-selected="true">{{item.jurusan}}</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table datatable="ng" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kelas</th>
                                    <th>Matakuliah</th>
                                    <th>Hari</th>
                                    <th>Dosen</th>
                                    <th>Ruangan</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in jadwals.jadwal">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.tahun_akademik}}</td>
                                    <td>{{item.kelas}}</td>
                                    <td>{{item.nama_matakuliah}}</td>
                                    <td>{{item.hari}}</td>
                                    <td>{{item.nama_dosen}}</td>
                                    <td>{{item.ruang}}</td>
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
                            <input type="text" class="form-control form-control-sm" ng-model="datas.ta.tahun_akademik" required aria-describedby="helpId" placeholder="Tahun Akademik" readonly>
                        </div>
                        <div class="form-group">
                            <label>Jurusan</label>
                            <select class="form-control form-control-sm" ng-options="item.jurusan for item in datas.jurusan" ng-model="jurusan"></select>
                        </div>
                        <div class="form-group">
                            <label>Matakuliah</label>
                            <select class="form-control form-control-sm" ng-options="item.nama_matakuliah for item in jurusan.matakuliah" ng-model="matakuliah" ng-change="model.matakuliah_id = matakuliah.id; model.nama_matakuliah = matakuliah.nama_matakuliah"></select>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control form-control-sm" ng-options="item.kelas for item in datas.kelas" ng-model="kelas" ng-change="model.kelas_id = kelas.id; model.kelas = kelas.kelas"></select>
                        </div>
                        <div class="form-group">
                            <label>Dosen Pengampu</label>
                            <select class="form-control form-control-sm select2" ng-options="item.nama_dosen for item in datas.dosen | orderBy:'nama_dosen'" ng-model="dosen" ng-change="model.dosen_id = dosen.id; model.nama_dosen = dosen.nama_dosen"></select>
                        </div>
                        <div class="form-group">
                            <label>Hari</label>
                            <select class="form-control form-control-sm" ng-options="item for item in hari" ng-model="model.hari"></select>
                        </div>
                        <div class="form-group">
                            <label>Ruangan</label>
                            <select class="form-control form-control-sm" ng-model="model.ruang">
                                <option value="Software I">Software I</option>
                                <option value="Software II">Software II</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Shift</label>
                            <select class="form-control form-control-sm" ng-model="model.shift">
                                <option value="Shift I">Shift I</option>
                                <option value="Shift II">Shift II</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Jam Praktikum</label>
                            <div class="form-inline d-flex justify-content-between">
                                <!-- <div class="form-group"> -->
                                <input type="time" ng-model="model.jam_mulai" class="form-control form-control-sm mr-4" placeholder="" aria-describedby="helpId">
                                <span>s/d</span>
                                <input type="time" ng-model="model.jam_selesai" class="form-control form-control-sm ml-4" placeholder="" aria-describedby="helpId">
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