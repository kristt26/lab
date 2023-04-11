<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="absenRoomsController">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mr-4 p-2">
                        <label for="">Program Studi</label>
                        <select class="form-control col-md-3" ng-options="item as ('Pertemuan ke - '+item.pertemuan) for item in pertemuans" ng-model="pertemuan" ng-change="showMahasiswa(pertemuan)"></select>
                    </div>
                    <div class="table-responsive" style="margin-top: 20px;">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="10%">NPM</th>
                                    <th width="60%">Nama</th>
                                    <th>Absen Oleh</th>
                                    <th>Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="item in pertemuan.mahasiswas" ng-class="{'bg-danger text-white':item.status=='A', 'bg-success text-white': item.status=='H', 'bg-warning text-dark': item.status=='I' || item.status=='S'}">
                                    <td>{{$index+1}}</td>
                                    <td>{{item.npm}}</td>
                                    <td>{{item.nama_mahasiswa | uppercase}}</td>
                                    <td>{{item.by}}</td>
                                    <td>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1{{item.npm}}" ng-model="item.status" name="radio{{item.npm}}" ng-change="absenMahasiswa(item)" value="H" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline1{{item.npm}}">H</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2{{item.npm}}" ng-model="item.status" name="radio{{$index+1}}" ng-change="absenMahasiswa(item)" value="I" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline2{{item.npm}}">I</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline3{{item.npm}}" ng-model="item.status" name="radio{{$index+1}}" ng-change="absenMahasiswa(item)" value="S" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline3{{item.npm}}">S</label>
                                        </div>
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline4{{item.npm}}" ng-model="item.status" name="radio{{$index+1}}" ng-change="absenMahasiswa(item)" value="A" class="custom-control-input">
                                            <label class="custom-control-label" for="customRadioInline4{{item.npm}}">A</label>
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