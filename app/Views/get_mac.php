<!doctype html>
<html lang="en" ng-app="apps" ng-controller="ctrl">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body ng-init="init()">
      <div class="form-group col-md-3">
        <label for="">Mac Address</label>
        <input type="text"
          class="form-control" readonly ng-model = "model.mac" aria-describedby="helpId" placeholder="">
        </div>
        <button class="btn btn-primary btn-sm" ng-click="save()">Simpan</button>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>libs/angular/angular.min.js"></script>
    <script src="<?= base_url() ?>js/services/helper.services.js"></script>
    <script>
        angular.module('apps', ['helper.service'])
        .controller('ctrl', ctrl);

        function ctrl($http, $scope, helperServices) {
            $scope.model = {};
            $scope.init = ()=>{
                $http({
                    method: 'get',
                    url: 'http://localhost:5555/macaddress'
                }).then((res)=>{
                    $scope.model.mac = res.data;
                    console.log(res.data);
                })
            }

            $scope.save = ()=>{
                $http({
                    method: "post",
                    url: helperServices.url + "getmac/post",
                    data: $scope.model
                }).then((res)=>{
                    alert("Berhasil")
                }, (err)=>{
                    if(err.data.messages.error==1062){
                        alert("Data sudah ada");
                    }else{
                        alert("Gagal menyimpan");
                    }
                })
            }
        }
    </script>
  </body>
</html>
