<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="kontrakController">
    <div class="row">
        <div class="col-md-8 mb-4" ng-if="setView">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Daftar Matakuliah</h5>
                    <div class="form-group row">
                        <!-- <label for="inputPassword" class="col-sm-3 col-form-label">Filter</label> -->
                        <div class="col-sm-12">
                            <input type="text" class="form-control" placeholder="Enter this...." ng-model="filterr">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3" ng-repeat="item in jadwals">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah}} | {{item.initial}}</strong></h6>
                                    <h6 style="font-size: 12px;"></i>Kls: {{item.kelas}} | Semester {{item.semester}} | {{item.shift}} | Kapasitas {{item.kapasitas}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-calendar fa-fw"></i>: {{item.hari}} | <i class="far fa-clock"></i>{{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                    <!-- <p class="card-text">Pengawas</p> -->
                                </div>
                                <div class="card-footer text-right">
                                    <button ng-show="item.kapasitas == 0 || item.kapasitas>item.jumlah" class="btn btn-success btn-sm btn-block" ng-click="pilih(item)">Pilih</button>
                                    <button ng-show="item.kapasitas !== 0 && item.kapasitas<=item.jumlah" class="btn btn-warning btn-sm btn-block text-dark " disabled>Kelas Penuh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div ng-class="{'col-md-4': setView, 'col-md-12': !setView}">
            <div class="card">
                <div class="card-header">
                    <h5>Matakuliah Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div ng-class="{'col-md-12': setView, 'col-md-3': !setView}" class="" ng-repeat="item in kontrak">
                            <div ng-class="{'card text-left mb-3 text-white bg-primary': item.pertemuan_id, 'card text-left mb-3': !item.pertemuan_id}">
                                <div class="card-body">
                                    <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah }} | {{item.initial}}</strong></h6>
                                    <h6 style="font-size: 12px;"></i>Kls: {{item.kelas}} | Semester {{item.semester}} | {{item.shift}} | Kapasitas {{item.kapasitas}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-calendar fa-fw"></i>: {{item.hari}} | <i class="far fa-clock"></i>: {{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                </div>
                                <div class="card-footer text-right">
                                    <button ng-if="setView" class="btn btn-danger btn-sm" ng-click="hapus(item)"><i class="fas fa-trash fa-fw"></i></button>
                                    <a ng-if="item.modul" href="<?= base_url() ?>assets/berkas/{{item.modul}}" target="_blank" class="btn btn-info btn-sm" title="Download Modul"><i class="fas fa-book"></i></a>
                                    <button ng-if="showQrcode" class="btn btn-primary btn-sm" ng-click="qrcode(item)" title="QrCode untuk absen"><i class="fas fa-qrcode"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="showQrcode" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Absen Praktikum {{matakuliah.nama_matakuliah}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="qrcode"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>