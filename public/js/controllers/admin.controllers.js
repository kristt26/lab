angular.module('adminctrl', [])
    // Admin
    .controller('dashboardController', dashboardController)
    .controller('laboranController', laboranController)
    .controller('jurusanController', jurusanController)
    .controller('kelasController', kelasController)
    .controller('matakuliahController', matakuliahController)
    .controller('jadwalController', jadwalController)
    .controller('modulController', modulController)
    .controller('taController', taController)

    ;
sd
function dashboardController($scope, dashboardServices) {
    $scope.$emit("SendUp", "Dashboard");
    $scope.datas = {};
    $scope.title = "Dashboard";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function laboranController($scope, laboranServices, pesan) {
    $scope.$emit("SendUp", "Jenis Kamar");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    laboranServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
        pesan.success(res.Testing);
    })

    $scope.setInisial = (item) => {
        $scope.model.inisial = item.substring(0, 3).toUpperCase();
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if ($scope.model.id) {
                laboranServices.put($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                laboranServices.post($scope.model).then(res => {
                    $scope.model = {};
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.saveFasilitas = (item) => {
        pesan.dialog('Yakin ingin?', 'Yes', 'Tidak').then(res => {
            if (item.id) {
                fasilitasServices.put(item).then(res => {
                    $scope.dataKamar = {};
                    pesan.Success("Berhasil mengubah data");
                })
            } else {
                fasilitasServices.post(item).then(res => {
                    $scope.dataKamar.fasilitas.push(res);
                    var id = angular.copy($scope.modell.jenis_kamar_id);
                    $scope.modell = {};
                    $scope.modell.jenis_kamar_id = id;
                    pesan.Success("Berhasil menambah data");
                })
            }
        })
    }

    $scope.edit = (item) => {
        $scope.model = angular.copy(item);
    }

    $scope.setDetail = (item) => {
        $scope.dataKamar = item;
        $scope.modell = {};
        $scope.modell.jenis_kamar_id = item.id;
        console.log($scope.modell);
    }

    $scope.itemFasilitas = (item) => {
        $scope.modell = item;
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin?', 'Ya', 'Tidak').then(res => {
            wijkServices.deleted(param).then(res => {
                pesan.Success("Berhasil menghapus data");
            })
        });
    }
}

function jurusanController($scope, jurusanServices, pesan) {
    $scope.$emit("SendUp", "Jurusan");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    jurusanServices.get().then(res=>{
        $scope.datas = res;
    })

    $scope.pesan = (param)=>{
        pesan.success(param);
    }

    $scope.edit = (param)=>{
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.save = ()=>{
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x=>{
            if($scope.model.id){
                jurusanServices.put($scope.model).then(res=>{
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }else{
                jurusanServices.post($scope.model).then(res=>{
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }
        })
    }

    $scope.delete = (param)=>{
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x=>{
            jurusanServices.deleted(param).then(res=>{
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function kelasController($scope, kelasServices, pesan) {
    $scope.$emit("SendUp", "Kelas");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    kelasServices.get().then(res => {
        $scope.datas = res;
    })

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            if ($scope.model.id) {
                kelasServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            } else {
                kelasServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            kelasServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function matakuliahController($scope, matakuliahServices, pesan) {
    $scope.$emit("SendUp", "Matakuliah");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    matakuliahServices.get().then(res => {
        $scope.datas = res;
    })


    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            if ($scope.model.id) {
                matakuliahServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            } else {
                matakuliahServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }
        })
    }

    $scope.showMatakuliah = (param) => {
        $scope.matakuliah = param.matakuliah;
    };

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            matakuliahServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

}

function jadwalController($scope, jadwalServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Jadwal");
    $scope.datas = {};
    $scope.jurusan = {};
    $scope.model = {};
    $scope.jadwals = [];
    $scope.hari = helperServices.hari;
    $scope.dataKamar = {};
    jadwalServices.get().then(res => {
        $scope.datas = res;
        $scope.jadwals = $scope.datas.jurusan[0];
        console.log(res);
    })

    $scope.setNilai = (id) => {
        $scope.jadwals = $scope.datas.jurusan.find(x => x.id == id);
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            if ($scope.model.id) {
                jadwalServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            } else {
                $scope.model.ta_id = $scope.datas.ta.id;
                $scope.model.tahun_akademik = $scope.datas.ta.tahun_akademik;
                $scope.model.jam_mulai = $scope.model.jam_mulai.getHours() + ":" + $scope.model.jam_mulai.getMinutes();
                $scope.model.jam_selesai = $scope.model.jam_selesai.getHours() + ":" + $scope.model.jam_selesai.getMinutes();
                jadwalServices.post($scope.model).then(res => {
                    var item = $scope.datas.jurusan.find(x=>x.id = $scope.jurusan.id)
                    item.jadwal.push(res);
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }
        })
    }

    // $scope.showMatakuliah = (param) => {
    //     $scope.matakuliah = param.matakuliah;
    // };

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            jadwalServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

}

function modulController($scope, modulServices, pesan) {
    $scope.$emit("SendUp", "Modul");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    modulServices.get().then(res => {
        $scope.datas = res;
    })


    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            if ($scope.model.id) {
                modulServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            } else {
                modulServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            }
        })
    }

    $scope.showModul = (param) => {
        $scope.modul = param.modul;
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            modulServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

}

function taController($scope, taServices, pesan) {
    $scope.$emit("SendUp", "Tahun Akademik");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    taServices.get().then(res=>{
        $scope.datas = res;
    })

    $scope.pesan = (param)=>{
        pesan.success(param);
    }

    $scope.edit = (param)=>{
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.save = ()=>{
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x=>{
            var item = $scope.datas.find(x=>x.tahun_akademik==$scope.model.tahun_akademik && x.semester==$scope.model.semester);
            if(! item){
                if($scope.model.id){
                    taServices.put($scope.model).then(res=>{
                        $scope.model = {};
                        $("#add").modal('hide');
                    })
                }else{
                    taServices.post($scope.model).then(res=>{
                        $scope.model = {};
                        $("#add").modal('hide');
                    })
                }
            }else{
                pesan.error('Tahun akademik yang diinput telah ada pada list')
            }
        })
    }

    $scope.delete = (param)=>{
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x=>{
            taServices.deleted(param).then(res=>{
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}
