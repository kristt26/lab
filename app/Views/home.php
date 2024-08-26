<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h4><?= session()->get('role')=='Admin' ? 'Praktikum hari ini' : (session()->get('role')=='Mahasiswa' ? 'Praktikum anda hari ini' : (session()->get('role')=='Laboran' ? 'Praktikum yang anda awasi hari ini' : "Matakulaih yang ada ampu" )) ?></h4>
                <a href="https://play.google.com/store/apps/details?id=com.ocph23.absenlabstimikmobile" class="btn btn-info" target="_blank">Download App for Android</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Matakuliah</th>
                                <th>Kelas</th>
                                <th>Shift</th>
                                <th>Prodi</th>
                                <th>Ruangan</th>
                                <th>Jam</th>
                                <th>Dosen</th>
                                <th>Laboran</th>
                                <th>Jlm. Mahasiswa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $value) : ?>
                                <tr>
                                    <td><?= $key+1?></td>
                                    <td><?= strtoupper($value['nama_matakuliah'])?></td>
                                    <td><?= strtoupper($value['kelas'])?></td>
                                    <td><?= $value['shift']?></td>
                                    <td><?= $value['jurusan']?></td>
                                    <td><?= $value['ruang']?></td>
                                    <td><?= $value['jam_mulai']. ' s/d '.$value['jam_selesai']?></td>
                                    <td><?= strtoupper($value['nama_dosen'])?></td>
                                    <td><?= strtoupper($value['nama_mahasiswa'])?></td>
                                    <td><?= $value['jumlah']?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>