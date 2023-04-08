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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Matakuliah</th>
                                    <th>Kelas</th>
                                    <th>Hari</th>
                                    <th>Ruangan</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in kontrak">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.nama_matakuliah}}</td>
                                    <td>{{item.kelas}}</td>
                                    <td>{{item.hari}}</td>
                                    <td>{{item.ruang}}</td>
                                    <td>{{item.jam_mulai}}</td>
                                    <td>{{item.jam_selesai}}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" ng-click="edit(item)" title="Modul Praktikum"><i class="fas fa-book"></i></button>
                                        <button class="btn btn-primary btn-sm" ng-click="qrcode(item)" title="QrCode untuk absen"><i class="fas fa-qrcode"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
   
    <div class="modal fade" id="showQrcode" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Absen Praktikum</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div id="qrcode"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>