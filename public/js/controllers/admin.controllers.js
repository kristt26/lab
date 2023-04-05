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
    .controller('mahasiswaController', mahasiswaController)

    // Mahasiswa
    .controller('kontrakController', kontrakController)
    .controller('daftarLaboranController', daftarLaboranController)
    
    // Laboran
    .controller('mengawasController', mengawasController)
    ;

function dashboardController($scope, dashboardServices) {
    $scope.$emit("SendUp", "Dashboard");
    $scope.datas = {};
    $scope.title = "Dashboard";
    // dashboardServices.get().then(res=>{
    //     $scope.datas = res;
    // })
}

function laboranController($scope, laboranServices, pesan) {
    $scope.$emit("SendUp", "Laboran");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $.LoadingOverlay('show');
    laboranServices.get().then((res) => {
        $scope.datas = res;
        console.log(res);
        $.LoadingOverlay('hide');
    })

    $scope.approve = (param) => {
        $.LoadingOverlay('show');
        pesan.dialog('Yakin ingin menerima ?', 'Ya', 'Tidak').then(x => {
            laboranServices.post(param).then(res => {
                var index = $scope.datas.daftar.indexOf(param);
                $scope.datas.daftar.splice(index, 1);
                $scope.datas.laboran.push(angular.copy(param));
                pesan.Success("Process Success");
                $.LoadingOverlay('hide');
            })
        })
    }

}

function jurusanController($scope, jurusanServices, pesan) {
    $scope.$emit("SendUp", "Jurusan");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $.LoadingOverlay('show');
    jurusanServices.get().then(res => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
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
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                jurusanServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            } else {
                jurusanServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            jurusanServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
                $.LoadingOverlay('hide');
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
                    var item = $scope.datas.jurusan.find(x => x.id = $scope.jurusan.id)
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

function taController($scope, taServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Tahun Akademik");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    taServices.get().then(res => {
        $scope.datas = res;
    })

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        var data = angular.copy(param);
        data.tgl_mulai = new Date(data.tgl_mulai);
        data.tgl_selesai = new Date(data.tgl_selesai);
        $scope.model = angular.copy(data)
        $("#add").modal('show');
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            var item = $scope.datas.find(x => x.tahun_akademik == $scope.model.tahun_akademik && x.semester == $scope.model.semester);
            var data = angular.copy($scope.model);
            data.tgl_mulai = helperServices.dateToString(data.tgl_mulai);
            data.tgl_selesai = helperServices.dateToString(data.tgl_selesai);
            if ($scope.model.id) {
                taServices.put(data).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                })
            } else {
                if (!item) {
                    taServices.post(data).then(res => {
                        $scope.model = {};
                        $("#add").modal('hide');
                    })
                } else {
                    pesan.error('Tahun akademik yang diinput telah ada pada list')
                }
            }

            
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            taServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function mahasiswaController($scope, mahasiswaServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Mahasiswa");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};
    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    mahasiswaServices.get().then(res => {
        $scope.datas = res;
        $scope.datas.jurusan.forEach(element => {
            element.dataMahasiswa = element.mahasiswa.filter(x => x.status == '1')
            element.dataPengajuan = element.mahasiswa.filter(x => x.status == '0')
        });
        $scope.jurusans = $scope.datas.jurusan[0];
        console.log($scope.jurusans);
    })


    $scope.clear = () => {
        $scope.jurusans = null;
        console.log($scope.jurusans);
    }

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.approve = (param) => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            mahasiswaServices.put(param).then(res => {
                var jurusan = $scope.datas.jurusan.find(x => x.id == param.jurusan_id);
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            mahasiswaServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function kontrakController($scope, kontrakServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Mahasiswa");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};
    $scope.jadwals = [];
    $scope.rooms = [];
    $scope.kontrak = [];
    $scope.ta = {};
    $scope.setView = false;
    $.LoadingOverlay("show");
    kontrakServices.get().then(res => {
        $scope.datas = res;
        $scope.ta = $scope.datas.ta;
        if((new Date($scope.ta.tgl_mulai)<= new Date()) && (new Date($scope.ta.tgl_selesai)>= new Date())) $scope.setView = true;
        else $scope.setView = false;
        console.log(new Date);
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.rooms = $scope.datas.rooms;
        $scope.rooms.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        $.LoadingOverlay("hide");
    })


    $scope.pilih = (item) => {
        $.LoadingOverlay("show");
        kontrakServices.post({ jadwal_id: item.id }).then((res) => {
            $scope.rooms.push(angular.copy(res));
            var temp = $scope.jadwals.find((x) => x.id == item.id);
            $scope.kontrak.push(angular.copy(temp));
            var index = $scope.jadwals.indexOf(temp);
            $scope.jadwals.splice(index, 1);
            $.LoadingOverlay("hide");
        })
    }
    $scope.hapus = (item) => {
        $.LoadingOverlay("show");
        var rooms_id = $scope.rooms.find((x) => x.jadwal_id == item.id);
        kontrakServices.deleted(rooms_id).then((res) => {
            $scope.jadwals.push(angular.copy(item));
            var index = $scope.kontrak.indexOf(item);
            $scope.kontrak.splice(index, 1);
            $.LoadingOverlay("hide");
        })
    }

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.approve = (param) => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            kontrakServices.put(param).then(res => {
                var jurusan = $scope.datas.jurusan.find(x => x.id == param.jurusan_id);
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            kontrakServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function daftarLaboranController($scope, daftarLaboranServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Pendaftaran Laboran");
    $scope.datas = {};
    $scope.model = {};
    daftarLaboranServices.get().then((res)=>{
        $scope.datas = res;
        console.log(res);
    })
    $scope.save = () => {
        pesan.dialog('Yakin ingin mendaftar?', 'YA', 'Tidak').then(x => {
            daftarLaboranServices.post($scope.model).then(res => {
                
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            kontrakServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function mengawasController($scope, mengawasServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Mengawas");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};
    $scope.jadwals = [];
    $scope.mengawas = [];
    $scope.kontrak = [];
    $scope.ta = {};
    $scope.setView = false;
    $.LoadingOverlay("show");
    mengawasServices.get().then(res => {
        $scope.datas = res;
        $scope.ta = $scope.datas.ta;
        if((new Date($scope.ta.tgl_mulai)<= new Date()) && (new Date($scope.ta.tgl_selesai)>= new Date())) $scope.setView = true;
        else $scope.setView = false;
        console.log(new Date);
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.mengawas = $scope.datas.mengawas;
        $scope.mengawas.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        console.log(res);
        $.LoadingOverlay("hide");
    })


    $scope.pilih = (item) => {
        $.LoadingOverlay("show");
        mengawasServices.post({ jadwal_id: item.id }).then((res) => {
            $scope.mengawas.push(angular.copy(res));
            var temp = $scope.jadwals.find((x) => x.id == item.id);
            $scope.kontrak.push(angular.copy(temp));
            var index = $scope.jadwals.indexOf(temp);
            $scope.jadwals.splice(index, 1);
            $.LoadingOverlay("hide");
        })
    }
    $scope.hapus = (item) => {
        $.LoadingOverlay("show");
        var mengawas_id = $scope.mengawas.find((x) => x.jadwal_id == item.id);
        mengawasServices.deleted(mengawas_id).then((res) => {
            $scope.jadwals.push(angular.copy(item));
            var index = $scope.kontrak.indexOf(item);
            $scope.kontrak.splice(index, 1);
            $.LoadingOverlay("hide");
        })
    }

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.approve = (param) => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            mengawasServices.put(param).then(res => {
                var jurusan = $scope.datas.jurusan.find(x => x.id == param.jurusan_id);
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            mengawasServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}
