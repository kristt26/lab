<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="praktikumController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Matakuliah Anda</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4" ng-repeat="item in kontrak">
                            <div ng-class="{'card text-left mb-3 text-white bg-primary': item.pertemuan_id, 'card text-left mb-3': !item.pertemuan_id}">
                                <div class="card-body">
                                    <h6 style="font-size: 15px;" class="card-title"><strong>{{item.nama_matakuliah }} | {{item.initial}}</strong></h6>
                                    <h6 style="font-size: 12px;"></i>Kls: {{item.kelas}} | Semester {{item.semester}} | {{item.shift}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-calendar fa-fw"></i>: {{item.hari}} | <i class="far fa-clock"></i>: {{item.jam_mulai}} - {{item.jam_selesai}}</h6>
                                    <h6 style="font-size: 12px;"><i class="fas fa-user fa-fw"></i>: {{item.laboran}}</h6>
                                </div>
                                <div class="card-footer text-right">
                                    <a ng-if="item.modul" href="<?= base_url() ?>assets/berkas/{{item.modul}}" target="_blank" class="btn btn-info btn-sm" title="Download Modul"><i class="fas fa-book"></i></a>
                                    <button ng-if="showQrcode" class="btn btn-primary btn-sm" ng-click="qrcode(item)" title="QrCode untuk absen"><i class="fas fa-qrcode"></i></button>
                                    <button class="btn btn-secondary btn-sm" ng-click="daftarAbsen(item)" title="Daftar Absen"><i class="fas fa-list"></i></button>
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

    <!-- Modal -->
    <div class="modal fade" id="showAbsen" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                    <div class="modal-header">
                            <h6 class="modal-title">Info Absen {{itemData.nama_matakuliah}}</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </div>
                <div class="modal-body">
                    <div class="tabel-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td style="font-size: small; width:10%;" ng-repeat="item in dataAbsen">Per. {{item.pertemuan}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: small; width:10%;" ng-repeat="item in dataAbsen">{{item.tgl ? (item.tgl | date: 'd-MM-y') : item.by}}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: small; width:10%;" class="text-center" ng-repeat="item in dataAbsen">{{item.status}}</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $('#exampleModal').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);
            // Use above variables to manipulate the DOM
            
        });
    </script>
</div>
<?= $this->endSection() ?>