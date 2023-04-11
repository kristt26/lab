<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="mengawasController">
    <div class="row">
        <div class="col-md-8" ng-if="setView">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Jadwal Perkuliahan</h5>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-3 col-form-label">Filter</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Enter this...." ng-model="filter">
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3" ng-repeat="item in jadwals | filter: filter">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah}} | {{item.initial}}</strong></h6>
                                    <h6 style="font-size: 13px;"></i>Kls: {{item.kelas}} | Semester: {{item.semester}} | <i class="fas fa-user fa-fw"></i>: {{item.jmlmahasiswa}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-calendar fa-fw"></i>: {{item.hari}} | <i class="far fa-clock"></i>{{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                    <!-- <p class="card-text">Pengawas</p> -->
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-success btn-sm btn-block" ng-if="!item.mengawas_id" ng-click="pilih(item)">Pilih</button>
                                    <button class="btn btn-secondary btn-sm btn-block" ng-if="item.mengawas_id" disabled>Sudah Diambil</button>
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
                    <h5>Daftar Mengawas</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div ng-class="{'col-12': setView, 'col-md-4': !setView}" class="" ng-repeat="item in kontrak">
                            <div class="card text-left">
                                <div class="card-body">
                                    <h6 style="font-size: 16px;" class="card-title"><strong>{{item.nama_matakuliah}} | {{item.initial}}</strong></h6>
                                    <h6 style="font-size: 13px;"></i>Kls: {{item.kelas}} | Semester: {{item.semester}} | <i class="fas fa-user fa-fw"></i>: {{item.jmlmahasiswa}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-calendar fa-fw"></i>: {{item.hari}} | <i class="far fa-clock"></i>{{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-danger btn-sm" ng-click="hapus(item)" title="Batalkan mengawas"><i class="fas fa-trash fa-fw"></i></button>
                                    <a href="<?= base_url()?>rooms/{{item.id}}" class="btn btn-info btn-sm" title="Absen Mahasiswa"><i class="fas fa-user-alt fa-fw"></i></a>
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