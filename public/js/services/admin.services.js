angular.module('admin.service', [])
    // admin
    .factory('dashboardServices', dashboardServices)
    .factory('laboranServices', laboranServices)
    .factory('jurusanServices', jurusanServices)
    .factory('kelasServices', kelasServices)
    .factory('jadwalServices', jadwalServices)
    .factory('modulServices', modulServices)
    .factory('matakuliahServices', matakuliahServices)
    .factory('regisServices', regisServices)
    .factory('taServices', taServices)
    .factory('mahasiswaServices', mahasiswaServices)
    .factory('getMacServices', getMacServices)
    .factory('componenServices', componenServices)
    .factory('dosenServices', dosenServices)
    // mahasiswa
    .factory('kontrakServices', kontrakServices)
    .factory('daftarLaboranServices', daftarLaboranServices)
    .factory('praktikumServices', praktikumServices)
    .factory('profileServices', profileServices)
    // Laboran
    .factory('mengawasServices', mengawasServices)
    .factory('absenRoomsServices', absenRoomsServices)
    .factory('nilaiServices', nilaiServices)

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

function getMacServices($http, $q, helperServices, AuthService) {
    var controller = "http://localhost:5555/macaddress";
    var service = {};
    service.data = [];
    service.instance = false;
    return {
        get: get,
    };

    function get() {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller,
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
                service.data.laboran.push(res.data);
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
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.message)
                def.reject(err);
                $.LoadingOverlay("hide");
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
        byJurusanId: byJurusanId,
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
    function byJurusanId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'by_jurusan/' + id,
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
                        matkul.semester = param.semester;
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

function jadwalServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'jadwal/';
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
                def.resolve(res.data);
            },
            (err) => {
                $.LoadingOverlay('hide')
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
                var jurusan = service.data.jurusan.find(x => x.id == param.jurusan_id);
                if (jurusan) {
                    var data = jurusan.jadwal.find(x=>x.id == param.id);
                    if(data){
                        data.kelas = param.kelas;
                        data.kelas_id = param.kelas_id;
                        data.hari = param.hari;
                        data.jam_mulai = param.jam_mulai;
                        data.jam_selesai = param.jam_selesai;
                        data.ruang = param.ruang;
                        data.shift = param.shift;
                        data.dosen_id = param.dosen_id;
                        data.nama_dosen = param.nama_dosen;
                    }
                }
                def.resolve(res.data);
            },
            (err) => {
                $.LoadingOverlay('hide');
                pesan.error(err.data.messages.error);
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
        byMatakuliahId: byMatakuliahId,
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

    function byMatakuliahId(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'by_matakuliah/' + id,
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
                $.LoadingOverlay('hide');
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
                def.resolve(res.data);
            },
            (err) => {
                $.LoadingOverlay('hide');
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
            url: controller + 'daftar',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                    def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
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
                if(param.status=='1'){
                    service.data.forEach(element => {
                        element.status = '0';
                    });
                }
                var data = service.data.find(x => x.id == param.id);
                if (data) {
                    data.tahun_akademik = param.tahun_akademik;
                    data.semester = param.semester;
                    data.tgl_mulai = param.tgl_mulai;
                    data.tgl_selesai = param.tgl_selesai;
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

function mahasiswaServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'mahasiswa/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        post: post,
        put: put,
        reset: reset,
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

    function byId(id, status) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read/'+id+'/'+status,
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
                
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function reset(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'reset',
            data: param,
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

function componenServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'komponen_nilai/';
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
                $.LoadingOverlay('hide');
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
                var item = service.data.find((x)=>x.id == param.id);
                if(item){
                    item.komponen = param.komponen;
                    item.persentase = param.persentase;
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

function dosenServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'dosen/';
    var service = {};
    service.data = [];
    return {
        get: get,
        post: post,
        put: put,
        reset: reset,
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
                $.LoadingOverlay('hide');
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
                var item = service.data.find((x)=>x.id == param.id);
                if(item){
                    item.nama_dosen = param.nama_dosen;
                }
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function reset(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'reset',
            data: param,
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

    function deleted(param) {
        var def = $q.defer();
        $http({
            method: 'delete',
            url: controller + "/delete/" + param.user_id,
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

function kontrakServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'registration/';
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
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
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
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                $.LoadingOverlay("hide");
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function daftarLaboranServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'daftar_laboran/';
    var service = {};
    service.data = [];
    return {
        get: get,
        post: post,
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

    function post(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
                def.reject(err);
            }
        );
        return def.promise;
    }
}

function praktikumServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'praktikum/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        getAbsen: getAbsen,
        getNilai: getNilai,
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

    function getAbsen(id, rooms_id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'absenbyid/'+id+'/'+rooms_id,
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

    function getNilai(id, rooms_id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'nilaibyid/'+id+'/'+rooms_id,
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
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
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
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                $.LoadingOverlay("hide");
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function profileServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'profile/';
    var service = {};
    service.data = [];
    return {
        get: get,
        read: read,
        put: put,
        reset: reset,
        upload: upload
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
                $.LoadingOverlay('hide');
                def.reject(err);
            }
        );
        return def.promise;
    }

    function read() {
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
                pesan.error(err.data.message);
                $.LoadingOverlay('hide');
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
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
            }
        );
        return def.promise;
    }

    function reset(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'reset',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error)
                def.reject(err);
                $.LoadingOverlay('hide');
            }
        );
        return def.promise;
    }

    function upload(param) {
        var def = $q.defer();
        $http({
            method: 'put',
            url: controller + 'upload',
            data: param,
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

function mengawasServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'mengawas/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        getMahasiswa: getMahasiswa,
        post: post,
        open: open,
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

    function getMahasiswa(param) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'read_mahasiswa/'+param.id,
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
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
                def.reject(err);
            }
        );
        return def.promise;
    }

    function open(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'pertemuan',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                // pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
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
                def.resolve(res.data);
            },
            (err) => {
                def.reject(err);
                $.LoadingOverlay("hide");
                pesan.error(err.data.message)
            }
        );
        return def.promise;
    }

}

function absenRoomsServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'absen_rooms/';
    var service = {};
    service.data = [];
    return {
        get: get,
        getByPertemuan:getByPertemuan,
        absen:absen
    };

    function get(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'store/' + id,
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

    function getByPertemuan(param) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'by_pertemuan/' + param.id + "/" + param.jadwal_id,
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

    function absen(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'post',
            data: param,
            headers: AuthService.getHeader()
        }).then(
            (res) => {
                def.resolve(res.data);
            },
            (err) => {
                pesan.error(err.data.messages.error);
                $.LoadingOverlay("hide");
                def.reject(err);
            }
        );
        return def.promise;
    }
}

function nilaiServices($http, $q, helperServices, AuthService, pesan) {
    var controller = helperServices.url + 'nilai/';
    var service = {};
    service.data = [];
    return {
        get: get,
        byId: byId,
        getTugas: getTugas,
        getUas: getUas,
        postTugas: postTugas,
        postNilai: postNilai,
        postUas: postUas,
        set: set,
        post: post,
        put: put,
        deleted: deleted,
        excel:excel
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
                $.LoadingOverlay('hide');
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

    function getTugas(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'getTugas/'+id,
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
    
    function getUas(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'getUas/'+id,
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

    function set(id) {
        var def = $q.defer();
        $http({
            method: 'get',
            url: controller + 'set/'+id,
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

    function postTugas(param) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'tambahTugas',
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

    function postNilai(param, id) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'postNilai/' + id,
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

    function postUas(param, id) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'postUas/' + id,
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
                var item = service.data.find((x)=>x.id == param.id);
                if(item){
                    item.komponen = param.komponen;
                    item.persentase = param.persentase;
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

    function excel(param, set) {
        var def = $q.defer();
        $http({
            method: 'post',
            url: controller + 'excel/' + set,
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
}
