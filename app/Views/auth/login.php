<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div ng-controller="loginController">
    <form class="user" ng-submit="login()">
        <div class="form-group">
            <input type="text" class="form-control form-control-user" ng-model="model.username" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user" ng-model="model.password" id="exampleInputPassword" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="role" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Masuk sebagai?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li ng-repeat="item in roles" ng-click="setRole(item)">{{item.role}}</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>