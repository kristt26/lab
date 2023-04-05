<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="mengawasController">
    <div class="row">
        <div class="col-md-7" ng-if="setView">
            <div class="card">
                <div class="card-header">
                    <h5>Jadwal Perkuliahan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4 mb-3" ng-repeat="item in jadwals">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah}}</strong></h6>
                                    <h6 style="font-size: 12px;"></i>Kls: {{item.kelas}} | Semester {{item.semester}}</h6>
                                    <h6 style="font-size: 12px;"><i class="far fa-clock"></i>{{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                    <!-- <p class="card-text">Pengawas</p> -->
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-success btn-sm btn-block" ng-click="pilih(item)">Pilih</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div ng-class="{'col-md-5': setView, 'col-md-12': !setView}">
            <div class="card">
                <div class="card-header">
                    <h5>Daftar Mengawas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div ng-class="{'col-6': setView, 'col-md-3': !setView}" class="" ng-repeat="item in kontrak">
                            <div class="card text-left">
                                <div class="card-body">
                                <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah}}</strong></h6>
                                    <h6 style="font-size: 12px;"></i>Kls: {{item.kelas}} | Semester {{item.semester}}</h6>
                                    <h6 style="font-size: 12px;"><i class="far fa-clock"></i>{{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-warning btn-sm btn-block" ng-click="hapus(item)">Batal</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>