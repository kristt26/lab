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
                    <ul class="jss239 jss240">
                        <div ng-repeat="item in roles" ng-click="setRole(item)" class="jss66 jss243 jss246 jss247 jss250 jss251">
                            <div class="jss265">
                                <span class="jss204 jss211 jss268 option">{{item.role}}</span>
                            </div>
                        </div>
                        <!-- <a href="" ng-repeat="item in roles" ng-click="setRole(item)">{{item.role}}</a> -->
                        <!-- <li >{{item.role}}</li> -->
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn-sm" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .jss240 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .jss239 {
            margin: 0;
            padding: 0;
            position: relative;
            list-style: none;
        }

        .jss251 {
            transition: background-color 150ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
        }

        @media (min-width: 600px) {
            .jss250 {
                padding-left: 24px;
                padding-right: 24px;
            }

        }

        .jss250 {
            padding-left: 16px;
            padding-right: 16px;
        }

        .jss247 {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .jss243 {
            width: 100%;
            display: flex;
            position: relative;
            box-sizing: border-box;
            text-align: left;
            align-items: center;
            padding-top: 12px;
            padding-bottom: 12px;
            justify-content: flex-start;
            text-decoration: none;
        }

        .jss66 {
            color: inherit;
            border: 0;
            margin: 0;
            cursor: pointer;
            display: inline-flex;
            outline: none;
            padding: 0;
            position: relative;
            align-items: center;
            user-select: none;
            border-radius: 0;
            vertical-align: middle;
            justify-content: center;
            -moz-appearance: none;
            text-decoration: none;
            background-color: transparent;
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
        }

        .jss265 {
            flex: 1 1 auto;
            padding: 0 16px;
            min-width: 0;
        }

        .jss211 {
            color: rgba(0, 0, 0, 0.87);
            font-size: 1rem;
            font-weight: 400;
            font-family: "Roboto", "Helvetica", "Arial", sans-serif;
            line-height: 1.5em;
        }

        .jss204 {
            margin: 0;
            display: block;
        }

        .option {
            color: #212625;
            /* cursor: pointer; */
        }

        .option:hover {
            color: #4e73df;
        }
    </style>
</div>

<?= $this->endSection() ?>