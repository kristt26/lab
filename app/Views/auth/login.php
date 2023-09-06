<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div ng-controller="loginController">
    <form class="user" ng-submit="login()">
        <div class="form-group">
            <input type="text" class="form-control form-control-user" ng-model="model.username" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="NPM/NIDN">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user" ng-model="model.password" id="exampleInputPassword" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
    </form>

    <hr>
    <div class="text-center">
        <a class="small" href="forgot-password.html">Forgot Password?</a>
    </div>
    <div class="text-center">
        <a class="small" href="<?= base_url('auth/register') ?>">Create an Account!</a>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="role" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6>Masuk sebagai?</h6>
                </div>
                <div class="modal-body">
                    <button type="button" ng-repeat="item in roles" ng-click="setRole(item)" class="btn btn-primary btn-user btn-block">{{item.role}}</button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>