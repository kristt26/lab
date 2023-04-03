angular.module('admin.service', [])
    // admin
    .factory('dashboardServices', dashboardServices)
    .factory('laboranServices', laboranServices)
    .factory('jurusanServices', jurusanServices)
    .factory('kelasServices', kelasServices)
    .factory('modulServices', modulServices)
    .factory('matakuliahServices', matakuliahServices)
    .factory('regisServices', regisServices)
    .factory('taServices', taServices)
    ;

function dashboardServices($http, $q, helperServices, AuthService) {
    var controller = helperServices.url + 'home/';
    var service = {};
    service.data = [];
    service.instance = false;
    return {
        get: get,
        getLayanan:getLayanan
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function getLayanan() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'get_layanan',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }
}


function laboranServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'laboran/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/'+id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.nama = param.nama;
                    data.ukuran = param.ukuran;
                    data.kapasitas = param.kapasitas;
                    data.bad = param.bad;
                    data.service = param.service;
                    data.price = param.price;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(id) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function jurusanServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'jurusan/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/'+id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.jurusan = param.jurusan;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function kelasServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'kelas/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.kelas = param.kelas;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function matakuliahServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'matakuliah/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.jurusan_id);
                if (data) {
                    data.matakuliah.push(res.data);
                }
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.jurusan_id);
                if (data) {
                    var matkul = data.matakuliah.find(x => x.id == param.id);
                    if (matkul) {
                        matkul.kode = param.kode;
                        matkul.nama_matakuliah = param.nama_matakuliah;
                    }
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.jurusan_id);
                if (data) {
                    var index = data.matakuliah.indexOf(param);
                    data.matakuliah.splice(index, 1);
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function modulServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'modul/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.matakuliah_id);
                if (data) {
                    data.modul.push(res.data);
                }
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.matakuliah_id);
                if (data) {
                    var moduls = data.modul.find(x => x.id == param.id);
                    if (moduls) {
                        modul.judul = param.judul;
                        modul.modul = param.modul;
                    }
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.matakuliah_id);
                if (data) {
                    var index = data.modul.indexOf(param);
                    data.modul.splice(index, 1);
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function regisServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'auth/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'getdataregis',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/' + id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.jurusan = param.jurusan;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function taServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'ta/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        deleted: deleted
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store',
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                service.data = res.data;
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function byId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/'+id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                if(param.status=='1'){
                    var data = service.data.find(x=>x.status=='1');
                    if(data) data.status='0';
                }
                service.data.push(res.data);
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                def.reject(err);
            }
        );
        return def.promise;
    }

    function put(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'put',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.tahun_akademik = param.tahun_akademik;
                    data.semester = param.semester;
                    data.status = param.status;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.id,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                var index = service.data.indexOf(param);
                service.data.splice(index, 1);
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}
