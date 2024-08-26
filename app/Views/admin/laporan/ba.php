<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div ng-controller="laporanController">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h4>Daftar Rekapitulasi</h4>
            <a href="<?= base_url('laporan/cetakba')?>" target="_blank" class="btn btn-primary btn-sm"><i class="far fa-file-excel fa-lg"></i> To Excel</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jurusan</th>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Shift</th>
                                <th>Jumlah Mahasiswa</th>
                                <th>Total Pertamuan</th>
                                <th>Total</th>
                                <th>Laboran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 0; ?>
                            <?php foreach ($data as $key => $value) : ?>
                                <?php foreach ($value->matakuliah as $key1 => $mat) : ?>
                                    <tr>
                                        <td><?= $no = $no+1?></td>
                                        <td><?= $value->jurusan?></td>
                                        <td><?= $mat->nama_matakuliah?></td>
                                        <td><?= $mat->kelas?></td>
                                        <td><?= $mat->shift?></td>
                                        <td><?= $mat->jumlah_mahasiswa?></td>
                                        <td><?= $mat->total_pertemuan?></td>
                                        <td><?= $mat->total?></td>
                                        <td><?= $mat->laboran?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="save()">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Jurusan</label>
                            <input type="text" class="form-control" ng-model="model.jurusan" required aria-describedby="helpId" placeholder="Nama Jurusan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>