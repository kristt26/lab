<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="jadwalMengawasController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Jadwal Perkuliahan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Matakuliah</th>
                                    <th>Kelas</th>
                                    <th>Prodi</th>
                                    <th>Hari</th>
                                    <th>Ruangan</th>
                                    <th>Jam</th>
                                    <th>Total Mahasiswa</th>
                                    <th>Laboran</th>
                                    <th>Jumlah Pertemuan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in kontrak">
                                    <td>{{$index+1}}</td>
                                    <td ng-click="showMahasiswa(item)"><a href="">{{item.nama_matakuliah}}</a></td>
                                    <td>{{item.kelas}}</td>
                                    <td>{{item.jurusan}}</td>
                                    <td>{{item.hari}}</td>
                                    <td>{{item.ruang}}</td>
                                    <td>{{item.jam_mulai}} s/d {{item.jam_selesai}}</td>
                                    <td>{{item.jmlmahasiswa}}</td>
                                    <td>{{item.nama_mahasiswa}}</td>
                                    <td>{{item.jumlahPertemuan}}</td>
                                    <td width="7%">
                                        <div class="d-flex justify-content-between">
                                            <a href="<?= base_url() ?>assets/berkas/{{item.modul}}" target="_blank" class="btn btn-info btn-sm mr-2" title="Download Modul"><i class="fas fa-book"></i></a>
                                            <a href="<?= base_url() ?>absen_rooms/{{item.id}}" class="btn btn-primary btn-sm mr-2" title="Absen Mahasiswa"><i class="fas fa-user-alt"></i></a>
                                            <button class="btn btn-warning btn-sm" title="Absen Laboran" ng-click="openPertemuan(item)"><i class="fas fa-sign-in-alt"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="showMahasiswa" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Daftar Mahasiswa Praktikum {{model.nama_matakuliah}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Mahasiswa</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in mahasiswas">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nama_mahasiswa}}</td>
                                    <td>{{item.kelas}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modul" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Absen Praktikum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- <div class="modal-body">
                    <iframe src="https://docs.google.com/gview?url=http://remote.url.tld/path/to/document.doc&embedded=true"></iframe>
                </div> -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>