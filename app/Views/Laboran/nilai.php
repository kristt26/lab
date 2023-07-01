<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="setKomponenController">
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <label for="">Matakuliah</label>
                    <select name="jemaat" id="jemaat" ui-select2 class="form-control form-control-sm select2" data-placeholder="--Pilih Marakuliah--" ng-options="item as (item.kode+' - '+item.nama_matakuliah+' | Kelas '+item.kelas) for item in datas" ng-model="matakuliah" ng-change="getData(matakuliah)" required>
                        <option value=""></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-8 mb-9 mb-3" ng-show="matakuliah">
            <div class="accordion" id="accordion2">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#bobotNilai" aria-expanded="true" aria-controls="collapseOne">
                        <h6>Bobot Nilai</h6>
                    </div>
                    <div id="bobotNilai" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                        <div class="card-body">
                            <form ng-submit="saveKomponen()">
                                <div class="form-row">
                                    <div class="form-group col-md-4 col-6" style="margin-bottom: 0rem;" ng-repeat="item in dataKomponen.komponen">
                                        <label for="inputEmail4">{{item.komponen}}</label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="number" ng-class="{'form-control bg-danger text-white': item.bobot == 0 && total>=100, 'form-control': !item.bobot || ((item.bobot == 0 || item.bobot>0) && total<=100)}" id="bobot{{$index}}" ng-model="item.bobot" ng-change="calculate()" aria-label="Small" aria-describedby="inputGroup-sizing-sm" required>
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="inputEmail4"><strong>Total</strong></label>
                                        <div class="input-group input-group-sm mb-3">
                                            <input type="number" ng-class="{'form-control bg-warning text-dark': total<100, 'form-control bg-danger text-dark': total>100, 'form-control bg-info text-white': total==100}" readonly id="total" ng-model="total" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroup-sizing-sm">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" ng-show="matakuliah">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Data Mahasiswa</h4>
                    <div class="d-flex justify-content-end" ng-if="showButton">
                        <button class="btn btn-info btn-sm mr-2" ng-click="inputTugas(matakuliah)">Tugas</button>
                        <button class="btn btn-primary btn-sm mr-2" ng-click="inputUas(matakuliah)">UAS</button>
                        <a href="<?= base_url('nilai')?>/excel/nilai/{{matakuliah.jadwal_id}}" target="_blank" class="btn btn-secondary btn-sm mr-2" ng-click="toExcel('nilai', matakuliah)">To Excel</a>
                        <button class="btn btn-warning btn-sm" ng-click="setNilai(matakuliah)">Set Nilai</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th rowspan="2">NO</th>
                                        <th rowspan="2">NPM</th>
                                        <th rowspan="2">NAMA</th>
                                        <th class="text-center" colspan="{{dataKomponen.komponen.length}}">NILAI</th>
                                        <th rowspan="2" class="text-center">TOTAL<br>NILAI</th>
                                        <th rowspan="2" class="text-center">NILAI<br>HURUF</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                    <tr>
                                        <th class="text-center" ng-repeat="item in dataKomponen.komponen">{{item.komponen | uppercase}}<br>({{item.bobot}}%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in dataKomponen.mahasiswa" ng-class="{'text-danger': item.huruf=='D' || item.huruf=='E', 'text-info': item.huruf=='A' || item.huruf=='B' || item.huruf=='C'}">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.npm}}</td>
                                        <td>{{item.nama_mahasiswa | uppercase}}</td>
                                        <td ng-repeat="nilai in item.nilai">
                                            {{nilai.nilai}}
                                        </td>
                                        <td>{{item.total}}</td>
                                        <td>{{item.huruf}}</td>
                                        <!-- <td>
                                            <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm" ng-click="delete(item)"><i class="fas fa-trash"></i></button>
                                        </td> -->
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
</div>
<?= $this->endSection() ?>