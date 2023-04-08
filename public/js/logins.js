angular.module('loginsApp', ['auth.service', 'helper.service', 'message.service', 'swangular', 'admin.service'])
    .controller('loginController', loginController)
    .controller('registerController', registerController)
    .controller('indexController', indexController);

function indexController($scope, AuthService, helperServices, pesan) {
    $scope.role = [];
    $scope.model = {};
    $scope.roles = [];
    $scope.title = "Login";
    $scope.$on("SendUp", function (evt, data) {
        $scope.title = data;
    });
}

function loginController($scope, AuthService, helperServices, pesan) {
    $scope.role = [];
    $scope.model = {};
    $scope.roles = [];
    $scope.title = "Login";
    $scope.$emit("SendUp", $scope.title);
    sessionStorage.clear();
    $scope.login = ()=>{
        $.LoadingOverlay("show");
        AuthService.login($scope.model).then((res)=>{
            if(res.length==1){
                document.location.href= helperServices.url;
            }else{
                $scope.roles = res;
                $.LoadingOverlay("hide");
                $scope.role = res;
                $(".modal").modal('show');
            }
        })
    }
    $scope.setRole = (item)=>{
        AuthService.setRole(item).then((res)=>{
            document.location.href= helperServices.url;
        })
    }
}

function registerController($scope, AuthService, helperServices, pesan, regisServices) {
    $scope.role = [];
    $scope.model = {};
    $scope.roles = [];
    $scope.jurusan = [];
    $scope.title = "Register";
    $scope.$emit("SendUp", $scope.title);
    sessionStorage.clear();

    regisServices.get().then(res => {
        $scope.datas = res;
        console.log(res);
    })

    $scope.save = () => {
        pesan.dialog('Pastikan data sudah benar! \n Yakin ingin menyimpan', 'Ya', 'Tidak').then(x=>{
            console.log($scope.model);
            $.LoadingOverlay("show");
            regisServices.post($scope.model).then(res=>{
                $scope.model = {};
                pesan.success("Proses berhasil \n silahkan hubungi laboratorium untuk mengaktifkan akun!")
                $.LoadingOverlay("hide");
            })
        })
    }
    $scope.setRole = (item) => {
        AuthService.setRole(item).then((res) => {
            document.location.href = helperServices.url;
        })
    }

}
