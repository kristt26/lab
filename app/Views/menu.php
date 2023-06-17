<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <img src="assets/img/logo/android-icon-36x36.png" alt="">
                <div class="sidebar-brand-text mx-3">LS2J</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <li ng-class="{'nav-item active': title=='Home', 'nav-item': title!='Home'}">
                <a class="nav-link" href="<?= base_url() ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <!-- Nav Item - Dashboard -->
            <?php if (session()->get("role") == "Admin") : ?>
                <li class="nav-item">
                    <a ng-class="{'nav-link' : root=='Master Data', 'nav-link collapsed' : root!='Master Data'}" href="#" data-toggle="collapse" data-target="#master" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Master Data</span>
                    </a>
                    <div id="master" ng-class="{'collapse show' : root=='Master Data', 'collapse' : root!='Master Data'}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a ng-class="{'collapse-item active': title=='Tahun Akademik', 'collapse-item': title!='Tahun Akademik'}" href="<?= base_url('ta') ?>">Tahun Akademik</a>
                            <a ng-class="{'collapse-item active': title=='Jurusan', 'collapse-item': title!='Jurusan'}" href="<?= base_url('jurusan') ?>">Jurusan</a>
                            <a ng-class="{'collapse-item active': title=='Kelas', 'collapse-item': title!='Kelas'}" href="<?= base_url('kelas') ?>">Kelas</a>
                            <a ng-class="{'collapse-item active': title=='Matakuliah', 'collapse-item': title!='Matakuliah'}" href="<?= base_url('matakuliah') ?>">Matakuliah</a>
                            <a ng-class="{'collapse-item active': title=='Modul', 'collapse-item': title!='Modul'}" href="<?= base_url('modul') ?>">Modul</a>
                            <a ng-class="{'collapse-item active': title=='Komponen Nilai', 'collapse-item': title!='Komponen Nilai'}" href="<?= base_url('komponen_nilai') ?>">Komponen Nilai</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a ng-class="{'nav-link' : root=='Pendataan', 'nav-link collapsed' : root!='Pendataan'}" href="#" data-toggle="collapse" data-target="#pendataan" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-database"></i>
                        <span>Pendataan</span>
                    </a>
                    <div id="pendataan" ng-class="{'collapse show' : root=='Pendataan', 'collapse' : root!='Pendataan'}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a ng-class="{'collapse-item active': title=='Mahasiswa', 'collapse-item': title!='Mahasiswa'}" href="<?= base_url('mahasiswa') ?>">Mahasiswa</a>
                            <a ng-class="{'collapse-item active': title=='Laboran', 'collapse-item': title!='Laboran'}" href="<?= base_url('laboran') ?>">Laboran</a>
                            <a ng-class="{'collapse-item active': title=='Jadwal', 'collapse-item': title!='Jadwal'}" href="<?= base_url('jadwal') ?>">Jadwal</a>
                        </div>
                    </div>
                </li>
            <?php endif; ?>

            <?php if (session()->get("role") == "Mahasiswa") : ?>
                <!-- <li ng-class="{'nav-item active': title=='Registration', 'nav-item': title!='registration'}">
                    <a class="nav-link" href="<?= base_url('registration') ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Registration</span></a>
                </li> -->
                <li ng-class="{'nav-item active': title=='Daftar Laboran', 'nav-item': title!='Daftar Laboran'}">
                    <a class="nav-link" href="<?= base_url('daftar_laboran') ?>">
                        <i class="fa fa-filter" aria-hidden="true"></i>
                        <span>Daftar Laboran</span></a>
                </li>
                <li ng-class="{'nav-item active': title=='Registration', 'nav-item': title!='registration'}">
                    <a class="nav-link" href="<?= base_url('praktikum') ?>">
                        <i class="fas fa-list"></i>
                        <span>Daftar Praktikum</span></a>
                </li>
            <?php endif; ?>

            <?php if (session()->get("role") == "Laboran") : ?>

                <li ng-class="{'nav-item active': title=='Jadwal Mengawas' || title=='Absen Mahasiswa', 'nav-item': title!='Jadwal Mengawas'|| title !='Absen Mahasiswa'}">
                    <a class="nav-link" href="<?= base_url('jadwal_mengawas') ?>">
                        <i class="fas fa-calendar"></i>
                        <span>Jadwal Mengawas</span></a>
                </li>
                <li ng-class="{'nav-item active': title=='Komponen Penilaian' || title=='Input Tugas', 'nav-item': title!='Komponen Penilaian' || title!='Input Tugas'}">
                    <a class="nav-link" href="<?= base_url('nilai') ?>">
                        <i class="fas fa-check"></i>
                        <span>Nilai</span></a>
                </li>
            <?php endif; ?>
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>