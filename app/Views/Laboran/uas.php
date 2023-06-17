<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="setNilaiController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>List UAS</h5>
                    <a href="javascript:history.back()" class="btn btn-secondary btn-sm mr-2">Kembali</a>
                    <!-- <button class="btn btn-primary btn-sm mr-2" ng-click="tambahJumlah()"><i class="fas fa-plus"></i></button> -->
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" width="5%">No</th>
                                    <th class="text-center align-middle" width="15%">NPM</th>
                                    <th class="text-center align-middle">Nama</th>
                                    <th class="text-center" width="15%">Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.npm}}</td>
                                    <td>{{item.nama_mahasiswa}}</td>
                                    <td>
                                        <input type="number"
                                          class="form-control" id="nilai{{$index}}" ng-model="item.nilai.nilai" ng-blur="saveUas(item.nilai)">
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
<?= $this->endSection() ?>