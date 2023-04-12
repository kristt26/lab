<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="componenController">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Tambah data</h4>
                </div>
                <form ng-submit="save()">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Komponen</label>
                            <input type="text" class="form-control" ng-model="model.komponen" required aria-describedby="helpId" placeholder="Komponen Penilaian">
                        </div>
                        <div class="form-group">
                            <label>Persentase</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" class="form-control" ng-model="model.persentase" required aria-describedby="helpId" placeholder="Komponen penilaian dalam %">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                    </div>
                </form>
            </div>

        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h4>Daftar Tahun Akademik</h4>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#add"><i class="fas fa-plus"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Komponen Penilaian</th>
                                        <th>Persentase</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in datas">
                                        <td>{{$index+1}}</td>
                                        <td>{{item.komponen}}</td>
                                        <td>{{item.persentase}}%</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" ng-click="edit(item)"><i class="fas fa-edit"></i></button>
                                            <button class="btn btn-danger btn-sm" ng-click="delete(item)"><i class="fas fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr ng-class="{'bg-success text-white': total == 100, 'bg-warning  text-dark': total < 100, 'bg-danger text-white': total > 100}">
                                        <td colspan="2">Total Persentase</td>
                                        <td>{{total}}%</td>
                                    </tr>
                                </tfoot>
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