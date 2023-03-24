<?= $this->extend('template') ?>
<?= $this->section('content') ?>
<div ng-controller="registerController">
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="First Name">
        </div>
        <div class="col-sm-6">
            <input type="text" class="form-control form-control-user" id="exampleLastName" placeholder="Last Name">
        </div>
    </div>
    <div class="form-group">
        <input type="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
    </div>
    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <input type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="NPM">
        </div>
        <div class="form-group">
            <select class="form-control" ng-options="item as item.jurusan for item in jurusan" ng-model="itemjurusan"></select>
        </div>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user" id="exampleInputEmail" placeholder="Alamat">
    </div>

    <a href="login.html" class="btn btn-primary btn-user btn-block">
        Register Account
    </a>
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