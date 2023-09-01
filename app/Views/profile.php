<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<?php if(session()->get('change')=='0'):?>
    <div class="alert alert-danger" role="alert">
      Ubah password terlebih dahulu
    </div>
<?php endif;?>
<?php if(!session()->get('photo')):?>
    <div class="alert alert-danger" role="alert">
      Silahkan upload Foto anda
    </div>
<?php endif;?>
<div class="row gutters-sm" ng-controller="profileController">
    <div class="col-lg-4 pb-5">
        <!-- Account Sidebar-->
        <div class="author-card pb-2">
            <div class="author-card-cover" style="background-image: url(https://bootdey.com/img/Content/flores-amarillas-wallpaper.jpeg);"></div>
            <div class="author-card-profile">
                <div class="author-card-avatar" ng-click="openFile()">
                    <img ng-src="{{photo}}" alt="Daniel Adams">
                </div>
                <div class="author-card-details">
                    <h4 class="author-card-name">{{datas.nama_mahasiswa}}</h4>
                    <h4 class="author-card-npm">{{datas.npm}}</h4>
                    <span class="author-card-position">{{datas.jurusan}}</span>
                </div>
            </div>
            <div style="padding-left: 38px;">
                <button class="btn btn-info btn-sm" ng-click="openFile()">Upload Photo</button>
            </div>
            <input type="file" id='my_file' style="display: none;" accept="image/*" ng-model="foto" ng-change="uploadFoto(foto)" base-sixty-four-input/>
        </div>
        <!-- <div class="wizard">
            <nav class="list-group list-group-flush">
                <a class="list-group-item active" href="#">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><i class="fa fa-shopping-bag mr-1 text-muted"></i>
                            <div class="d-inline-block font-weight-medium text-uppercase">Orders List</div>
                        </div><span class="badge badge-secondary">6</span>
                    </div>
                </a><a class="list-group-item" href="https://www.bootdey.com/snippets/view/bs4-profile-settings-page" target="__blank"><i class="fa fa-user text-muted"></i>Profile Settings</a><a class="list-group-item" href="#"><i class="fa fa-map-marker text-muted"></i>Addresses</a>
                <a class="list-group-item" href="https://www.bootdey.com/snippets/view/bs4-wishlist-profile-page" tagert="__blank">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><i class="fa fa-heart mr-1 text-muted"></i>
                            <div class="d-inline-block font-weight-medium text-uppercase">My Wishlist</div>
                        </div><span class="badge badge-secondary">3</span>
                    </div>
                </a>
                <a class="list-group-item" href="#">
                    <div class="d-flex justify-content-between align-items-center">
                        <div><i class="fa fa-tag mr-1 text-muted"></i>
                            <div class="d-inline-block font-weight-medium text-uppercase">My Tickets</div>
                        </div><span class="badge badge-secondary">4</span>
                    </div>
                </a>
            </nav>
        </div> -->
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form ng-submit="save()">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Nama</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" ng-class="{'form-control-plaintext': !ubah, 'form-control': ubah}" ng-model="model.nama_mahasiswa" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">NPM</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" ng-class="{'form-control-plaintext': !ubah, 'form-control': ubah}" ng-model="model.npm" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Telepon/HP</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="text" ng-class="{'form-control-plaintext': !ubah, 'form-control': ubah}" ng-model="model.kontak" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <input type="email" ng-class="{'form-control-plaintext': !ubah, 'form-control': ubah}" ng-model="model.email" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Alamat</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <textarea ng-if="ubah" class="form-control" rows="4" ng-model="model.alamat"></textarea>
                            <input ng-if="!ubah" type="text" ng-class="{'form-control-plaintext': !ubah, 'form-control': ubah}" ng-model="model.alamat" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Jurusan</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select ng-if="ubah" class="form-control" ng-model="jurusan" ng-options="item.jurusan for item in jurusans" ng-change="model.jurusan_id = jurusan.id;model.jurusan=jurusan.jurusan"></select>
                            <input type="text" ng-if="!ubah" class="form-control-plaintext" ng-model="model.jurusan" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Kelas</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <select ng-if="ubah" class="form-control" ng-model="kelas" ng-options="item.kelas for item in kelass" ng-change="model.kelas_id = kelas.id;model.kelas=kelas.kelas"></select>
                            <input type="text" ng-if="!ubah" class="form-control-plaintext" ng-model="model.kelas" ng-disabled="!ubah">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 text-secondary">
                            <button ng-if="!ubah" type="button" class="btn btn-info px-4" ng-click="edit()">Ubah</button>
                            <button ng-if="!ubah" type="button" class="btn btn-warning px-4" data-toggle="modal" data-target="#modelId">Ubah Password</button>
                            <button ng-if="ubah" type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ng-submit="reset()">
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">Old Password</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <input type="password" class="form-control form-control-sm" ng-model="password.oldPassword">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-5">
                                    <h6 class="mb-0">New Password</h6>
                                </div>
                                <div class="col-sm-7 text-secondary">
                                    <input type="text" class="form-control form-control-sm" ng-model="password.newPassword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<style>
    .widget-author {
        margin-bottom: 58px;
    }

    .author-card {
        position: relative;
        padding-bottom: 48px;
        background-color: #fff;
        box-shadow: 0 12px 20px 1px rgba(64, 64, 64, .09);
    }

    .author-card .author-card-cover {
        position: relative;
        width: 100%;
        height: 100px;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }

    .author-card .author-card-cover::after {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        content: '';
        opacity: 0.5;
    }

    .author-card .author-card-cover>.btn {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 0 10px;
    }

    .author-card .author-card-profile {
        display: table;
        position: relative;
        margin-top: -22px;
        padding-right: 15px;
        padding-bottom: 16px;
        padding-left: 20px;
        z-index: 5;
    }

    .author-card .author-card-profile .author-card-avatar,
    .author-card .author-card-profile .author-card-details {
        display: table-cell;
        vertical-align: middle;
    }

    .author-card .author-card-profile .author-card-avatar {
        width: 145px;
        border-radius: 50%;
        box-shadow: 0 8px 20px 0 rgba(0, 0, 0, .15);
        overflow: hidden;
    }

    .author-card .author-card-profile .author-card-avatar>img {
        display: block;
        width: 100%;
    }

    .author-card .author-card-profile .author-card-details {
        padding-top: 20px;
        padding-left: 15px;
    }

    .author-card .author-card-profile .author-card-name {
        margin-bottom: 2px;
        font-size: 16px;
        font-weight: bold;
    }

    .author-card .author-card-profile .author-card-jurusan {
        margin-bottom: 2px;
        font-size: 14px;
        font-weight: bold;
    }

    .author-card .author-card-profile .author-card-npm {
        margin-bottom: 2px;
        font-size: 14px;
        /* font-weight: bold; */
    }

    .author-card .author-card-profile .author-card-position {
        display: block;
        color: #8c8c8c;
        font-size: 12px;
        font-weight: 600;
    }

    .author-card .author-card-info {
        margin-bottom: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .author-card .author-card-social-bar-wrap {
        position: absolute;
        bottom: -18px;
        left: 0;
        width: 100%;
    }

    .author-card .author-card-social-bar-wrap .author-card-social-bar {
        display: table;
        margin: auto;
        background-color: #fff;
        box-shadow: 0 12px 20px 1px rgba(64, 64, 64, .11);
    }

    .btn-style-1.btn-white {
        background-color: #fff;
    }

    .list-group-item i {
        display: inline-block;
        margin-top: -1px;
        margin-right: 8px;
        font-size: 1.2em;
        vertical-align: middle;
    }

    .mr-1,
    .mx-1 {
        margin-right: .25rem !important;
    }

    .list-group-item.active:not(.disabled) {
        border-color: #e7e7e7;
        background: #fff;
        color: #ac32e4;
        cursor: default;
        pointer-events: none;
    }

    .list-group-flush:last-child .list-group-item:last-child {
        border-bottom: 0;
    }

    .list-group-flush .list-group-item {
        border-right: 0 !important;
        border-left: 0 !important;
    }

    .list-group-flush .list-group-item {
        border-right: 0;
        border-left: 0;
        border-radius: 0;
    }

    .list-group-item.active {
        z-index: 2;
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }

    .list-group-item:last-child {
        margin-bottom: 0;
        border-bottom-right-radius: .25rem;
        border-bottom-left-radius: .25rem;
    }

    a.list-group-item,
    .list-group-item-action {
        color: #404040;
        font-weight: 600;
    }

    .list-group-item {
        padding-top: 16px;
        padding-bottom: 16px;
        -webkit-transition: all .3s;
        transition: all .3s;
        border: 1px solid #e7e7e7 !important;
        border-radius: 0 !important;
        color: #404040;
        font-size: 12px;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
        text-decoration: none;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: .75rem 1.25rem;
        margin-bottom: -1px;
        background-color: #fff;
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .list-group-item.active:not(.disabled)::before {
        background-color: #ac32e4;
    }

    .list-group-item::before {
        display: block;
        position: absolute;
        top: 0;
        left: 0;
        width: 3px;
        height: 100%;
        background-color: transparent;
        content: '';
    }
</style>
<?= $this->endSection() ?>