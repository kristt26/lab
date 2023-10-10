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
                                    <th>Shift</th>
                                    <th>Hari</th>
                                    <th>Dosen</th>
                                    <th>Ruangan</th>
                                    <th>Jam Praktikum</th>
                                    <th>Kapasitas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in jadwals.jadwal">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.tahun_akademik}}</td>
                                    <td>{{item.kelas}}</td>
                                    <td>{{item.nama_matakuliah}}</td>
                                    <td>{{item.shift}}</td>
                                    <td>{{item.hari}}</td>
                                    <td>{{item.nama_dosen}}</td>
                                    <td>{{item.ruang}}</td>
                                    <td>{{item.jam_mulai}} s/d {{item.jam_selesai}}</td>
                                    <td>{{item.kapasitas}}</td>
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
        <div class="modal-dialog modal-lg" role="document">
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Jurusan</label>
                                    <select class="form-control form-control-sm" ng-options="item.jurusan for item in datas.jurusan" ng-model="jurusan"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Semester</label>
                                    <select class="form-control form-control-sm" ng-model="smt">
                                        <option value="1">Semester 1</option>
                                        <option value="2">Semester 2</option>
                                        <option value="3">Semester 3</option>
                                        <option value="4">Semester 4</option>
                                        <option value="5">Semester 5</option>
                                        <option value="6">Semester 6</option>
                                        <option value="7">Semester 7</option>
                                        <option value="8">Semester 8</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kelas</label>
                                    <select class="form-control form-control-sm" ng-options="item.kelas for item in datas.kelas" ng-model="kelas" ng-change="model.kelas_id = kelas.id; model.kelas = kelas.kelas"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Matakuliah</label>
                                    <select class="form-control form-control-sm" ng-options="item.nama_matakuliah for item in jurusan.matakuliah | filter:{semester:smt}" ng-model="matakuliah" ng-change="model.matakuliah_id = matakuliah.id; model.nama_matakuliah = matakuliah.nama_matakuliah"></select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label>Dosen Pengampu</label>
                                    <select class="form-control form-control-sm"ng-options="item.nama_dosen for item in datas.dosen | orderBy:'nama_dosen'" ng-model="dosen" ng-change="model.dosen_id = dosen.id; model.nama_dosen = dosen.nama_dosen"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Hari</label>
                                    <select class="form-control form-control-sm" ng-options="item for item in hari" ng-model="model.hari"></select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Ruangan</label>
                                    <select class="form-control form-control-sm" ng-model="model.ruang">
                                        <option value="Software I">Software I</option>
                                        <option value="Software II">Software II</option>
                                        <option value="Hardware">Hardware</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Shift</label>
                                    <select class="form-control form-control-sm" ng-model="model.shift">
                                        <option value="Shift I">Shift I</option>
                                        <option value="Shift II">Shift II</option>
                                        <option value="Shift III">Shift III</option>
                                        <option value="Shift IV">Shift IV</option>
                                        <option value="Shift V">Shift V</option>
                                        <option value="Shift VI">Shift VI</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kapasitas</label>
                                    <input type="text" class="form-control form-control-sm" ng-model="model.kapasitas" required aria-describedby="helpId" placeholder="Kosongkan jika tidak ada batasan">
                                </div>
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