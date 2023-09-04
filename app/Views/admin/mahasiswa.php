<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="mahasiswaController">
    <div class="card">
        <div class="card-body">
            <nav class="mb-4">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-mahasiswa-tab" ng-click="clear()" data-toggle="tab" href="#nav-mahasiswa" role="tab" aria-controls="nav-mahasiswa" aria-selected="true">Daftar Mahasiswa</a>
                    <a class="nav-item nav-link" id="nav-pengajuan-tab" ng-click="clear()" data-toggle="tab" href="#nav-ppengajuan" role="tab" aria-controls="nav-ppengajuan" aria-selected="false">Pengajuan User</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-mahasiswa" role="tabpanel" aria-labelledby="nav-mahasiswa-tab">
                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <label for="">Program Studi</label>
                            <select class="form-control" ng-model="jurusans" ng-options="item.jurusan for item in datas.jurusan" ng-change="getMahasiswa(jurusans.id, '1')">
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12" ng-show="jurusans">
                        <div class="table-responsive">
                            <table datatable="ng" dt-options="dtOptions" class="table table-bordered table-striped" style="width: 99%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPM</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Email</th>
                                        <th>Kontak</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in dataMahasiswa | orderBy: 'npm'">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.npm}}</td>
                                        <td>{{item.nama_mahasiswa}}</td>
                                        <td>{{item.kelas}}</td>
                                        <td>{{item.email}}</td>
                                        <td>{{item.kontak}}</td>
                                        <td>{{item.status=='0' ? 'Tidak Aktif':'Aktif'}}</td>
                                        <td>
                                            <!-- <button class="btn btn-warning btn-sm" ng-click="edit(item)" data-toggle="tooltip" data-placement="top" title="Ubah data"><i class="fas fa-edit"></i></button> -->
                                            <!-- <button class="btn btn-danger btn-sm" ng-click="delete(item)" data-toggle="tooltip" data-placement="top" title="Hapus data"><i class="fas fa-trash"></i></button> -->
                                            <button class="btn btn-info btn-sm" ng-click="reset(item)"data-toggle="tooltip" data-placement="top" title="Reset Password"><i class="fas fa-retweet"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-ppengajuan" role="tabpanel" aria-labelledby="nav-pengajuan-tab">
                    <div class="d-flex justify-content-between">
                        <div class="form-group">
                            <label for="">Program Studi</label>
                            <select class="form-control" ng-model="jurusans" ng-options="item.jurusan for item in datas.jurusan" ng-change="getMahasiswa(jurusans.id, '0')">
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="col-md-12" ng-show="jurusans">
                        <div class="table-responsive">
                            <table datatable="ng" dt-options="dtOptions" class="table table-bordered table-striped" style="width: 99%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NPM</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Email</th>
                                        <th>Kontak</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in dataMahasiswa">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.npm}}</td>
                                        <td>{{item.nama_mahasiswa}}</td>
                                        <td>{{item.kelas}}</td>
                                        <td>{{item.email}}</td>
                                        <td>{{item.kontak}}</td>
                                        <td>{{item.status=='0' ? 'Tidak Aktif':'Aktif'}}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" ng-click="approve(item)"  title="Approve Pengajuan"><i class="fas fa-check"></i></button>
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
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Mahasiswa</h5>
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
                            <select class="form-control" ng-options="item.nama_matakuliah for item in matakuliahs" ng-model="matakuliah" ng-change="model.matakuliah_id = matakuliah.id; model.nama_matakuliah = matakuliah.nama_matakuliah"></select>
                        </div>
                        <div class="form-group">
                            <label>Kelas</label>
                            <select class="form-control" ng-options="item.kelas for item in datas.kelas" ng-model="kelas" ng-change="model.kelas_id = kelas.id; model.kelas = kelas.kelas"></select>
                        </div>
                        <div class="form-group">
                            <label>Hari</label>
                            <select class="form-control" ng-options="item for item in hari" ng-model="model.hari"></select>
                        </div>
                        <div class="form-group">
                            <label>Ruangan</label>
                            <select class="form-control" ng-model="model.ruang">
                                <option value="Software I">Software I</option>
                                <option value="Software II">Software II</option>
                            </select>
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