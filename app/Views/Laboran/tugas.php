<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="setNilaiController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>List Tugas</h5>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm mr-2" ng-click="tambahJumlah()"><i class="fas fa-plus"></i> Tambah</button>
                        <a href="javascript:history.back()" class="btn btn-secondary btn-sm mr-2">Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                   <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center align-middle" width="2%">No</th>
                                    <th rowspan="2" class="text-center align-middle" width="10%" ng-click="dataOrder('npm')">NPM</th>
                                    <th rowspan="2" class="text-center align-middle" width="20%" ng-click="dataOrder('nama_mahasiswa')">Nama</th>
                                    <th ng-if="datas.mahasiswa[0].tugas.length>0" colspan="{{datas.tugas.length+1}}" class="text-center">Tugas</th>
                                </tr>
                                <tr>
                                    <th ng-if="datas.mahasiswa[0].tugas.length>0" ng-repeat="item in datas.tugas" class="text-center">{{item.ke}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in datas.mahasiswa | orderBy: order">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.npm}}</td>
                                    <td>{{item.nama_mahasiswa}}</td>
                                    <td ng-repeat="nilai in item.tugas">
                                        <input type="number"
                                          class="form-control" name="" id="nilai{{$index}}" ng-model="nilai.nilai" ng-blur="save(nilai)" aria-describedby="helpId" placeholder="">
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