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
    .controller('componenController', componenController)
    .controller('dosenController', dosenController)
    // Mahasiswa
    .controller('kontrakController', kontrakController)
    .controller('daftarLaboranController', daftarLaboranController)
    .controller('praktikumController', praktikumController)
    .controller('profileController', profileController)
    // Laboran
    .controller('mengawasController', mengawasController)
    .controller('jadwalMengawasController', jadwalMengawasController)
    .controller('absenRoomsController', absenRoomsController)
    .controller('setKomponenController', setKomponenController)
    .controller('setNilaiController', setNilaiController)
    .controller('laporanController', laporanController)
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
        $.LoadingOverlay('hide');
    })

    $scope.approve = (param) => {
        pesan.dialog('Yakin ingin menerima ?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            laboranServices.post(param).then(res => {
                var index = $scope.datas.daftar.indexOf(param);
                $scope.datas.daftar.splice(index, 1);
                $scope.datas.laboran.push(angular.copy(param));
                pesan.Success("Process Success");
                $.LoadingOverlay('hide');
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin membatalkan ?', 'Ya', 'Tidak').then((x) => {
            $.LoadingOverlay('show');
            laboranServices.deleted(param.pendaftaran_laboran_id).then(res => {
                var index = $scope.datas.daftar.indexOf(param);
                $scope.datas.daftar.splice(index, 1);
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
                $.LoadingOverlay('hide');
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
    $.LoadingOverlay('show');
    kelasServices.get().then(res => {
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
                kelasServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            } else {
                kelasServices.post($scope.model).then(res => {
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
            kelasServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
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
    $.LoadingOverlay('show');
    matakuliahServices.get().then(res => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
    })


    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                matakuliahServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            } else {
                matakuliahServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    $scope.showMatakuliah = (param) => {
        $scope.matakuliah = param.matakuliah;
    };

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            matakuliahServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

}

function jadwalController($scope, jadwalServices, pesan, helperServices, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Jadwal");
    $scope.datas = {};
    $scope.jurusan = {};
    $scope.model = {};
    $scope.jadwals = [];
    $scope.hari = helperServices.hari;
    $scope.dataKamar = {};
    $scope.jurusan = {};
    $scope.matakuliah = {};
    $scope.kelas = {};
    $scope.jurusan = {};
    $scope.smt = undefined;
    $scope.kelas = {};
    $scope.matakuliah = {};
    $scope.dosen = {};
    $.LoadingOverlay('show');
    $scope.dtOptions = DTOptionsBuilder.newOptions()
        // .withPaginationType('full_numbers')
        // .withBootstrap()
        .withButtons([
            'excel', 'pdf','print']);
    jadwalServices.get().then(res => {
        $scope.datas = res;
        $scope.datas.jurusan.forEach(element => {
            $scope.datas.dup.forEach(dup => {
                var item = null;
                var item = element.jadwal.find(x => x.id == dup.id);
                if (item) {
                    item.dup = true;
                }
            });
        });
        $scope.jadwals = $scope.datas.jurusan[0];
        console.log($scope.datas);
        $.LoadingOverlay('hide');
    })

    $scope.setNilai = (id) => {
        $scope.jadwals = $scope.datas.jurusan.find(x => x.id == id);
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            $scope.model.ta_id = $scope.datas.ta.id;
            $scope.model.tahun_akademik = $scope.datas.ta.tahun_akademik;
            $scope.model.jam_mulai = $scope.model.jam_mulai.getHours() + ":" + $scope.model.jam_mulai.getMinutes();
            $scope.model.jam_selesai = $scope.model.jam_selesai.getHours() + ":" + $scope.model.jam_selesai.getMinutes();
            if ($scope.model.id) {
                jadwalServices.put($scope.model).then(res => {
                    $scope.model = {};
                    $scope.jurusan = {};
                    $scope.smt = undefined;
                    $scope.kelas = {};
                    $scope.matakuliah = {};
                    $scope.dosen = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            } else {
                jadwalServices.post($scope.model).then(res => {
                    var item = $scope.datas.jurusan.find(x => x.id = $scope.jurusan.id)
                    item.jadwal.push(res);
                    $scope.model = {};
                    $scope.jurusan = {};
                    $scope.smt = undefined;
                    $scope.kelas = {};
                    $scope.matakuliah = {};
                    $scope.dosen = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    // $scope.showMatakuliah = (param) => {
    //     $scope.matakuliah = param.matakuliah;
    // };

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            jadwalServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.edit = (param) => {
        $scope.$applyAsync(x => {
            $("#add").modal('show');
            $scope.jurusan = $scope.datas.jurusan.find(x => x.id == param.jurusan_id);
            $scope.matakuliah = $scope.jurusan.matakuliah.find(x => x.id == param.matakuliah_id);
            $scope.kelas = $scope.datas.kelas.find(x => x.id == param.kelas_id);
            $scope.dosen = $scope.datas.dosen.find(x => x.id == param.dosen_id);
            var item = angular.copy(param);
            item.jam_mulai = new Date("1970-01-01T" + param.jam_mulai);
            item.jam_selesai = new Date("1970-01-01T" + param.jam_selesai);
            $scope.model = angular.copy(item)
        })
    }

}

function modulController($scope, modulServices, pesan, jurusanServices, matakuliahServices) {
    $scope.$emit("SendUp", "Modul");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.tambah = false;
    $scope.matakuliah;
    $.LoadingOverlay('show');
    jurusanServices.get().then((res) => {
        $scope.jurusans = res;
        $.LoadingOverlay('hide');
    })
    // modulServices.get().then(res => {
    //     $scope.datas = res;
    // })

    $scope.showMatakuliah = (param) => {
        $.LoadingOverlay('show');
        matakuliahServices.byJurusanId(param.id).then((res) => {
            $scope.matakuliahs = res
            $.LoadingOverlay('hide');
        })
    }

    $scope.showModul = (param) => {
        $.LoadingOverlay('show');
        $scope.model.matakuliah_id = param.id;
        modulServices.byMatakuliahId(param.id).then((res) => {
            $scope.moduls = res
            $.LoadingOverlay('hide');
        })
    }

    $scope.setTambah = () => {
        $scope.tambah = true;
    }


    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                modulServices.put($scope.model).then(res => {
                    $("#tambah").modal('hide');
                    var item = $scope.moduls.find(x => x.id == $scope.model.id);
                    item.judul = $scope.model.judul;
                    item.modul = $scope.model.modul;
                    item.status = $scope.model.status;
                    $scope.model = {};
                    $.LoadingOverlay('hide');
                })
            } else {
                modulServices.post($scope.model).then(res => {
                    $scope.model = {};
                    $scope.moduls.push(res);
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    $scope.clear = () => {
        $scope.model = {};
        $scope.model.matakuliah_id = $scope.matakuliah.id;
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param);
        $("#tambah").modal('show')
    }
}

function taController($scope, taServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Tahun Akademik");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $.LoadingOverlay('show');
    taServices.get().then(res => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
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
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                taServices.put(data).then(res => {
                    $scope.model = {};
                    $("#add").modal('hide');
                    $.LoadingOverlay('hide');
                })
            } else {
                if (!item) {
                    taServices.post(data).then(res => {
                        $scope.model = {};
                        $("#add").modal('hide');
                        $.LoadingOverlay('hide');
                    })
                } else {
                    pesan.error('Tahun akademik yang diinput telah ada pada list')
                }
            }


        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            taServices.deleted(param).then(res => {
                pesan.Success('Berhasil menghapus');
                $.LoadingOverlay('hide');
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
    $.LoadingOverlay('show');
    mahasiswaServices.get().then(res => {
        $scope.datas = res;
        // $scope.datas.jurusan.forEach(element => {
        //     element.dataMahasiswa = element.mahasiswa.filter(x => x.status == '1')
        //     element.dataPengajuan = element.mahasiswa.filter(x => x.status == '0')
        // });
        $scope.jurusans = $scope.datas.jurusan[0];
        $scope.getMahasiswa($scope.jurusans.id, '1');
        $.LoadingOverlay('hide');
    })

    $scope.getMahasiswa = (id, status) => {
        $.LoadingOverlay('show');
        mahasiswaServices.byId(id, status).then(res => {
            $scope.dataMahasiswa = res;
            $.LoadingOverlay('hide');
        })
    }

    $scope.clear = () => {
        $scope.jurusans = null;
    }

    $scope.pesan = (param) => {
        pesan.success(param);
    }

    $scope.edit = (param) => {
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.reset = (param) => {
        pesan.dialog('Yakin ingin mereset password?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            mahasiswaServices.reset(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.approve = (param) => {
        pesan.dialog('Yakin ingin menyimpan', 'YA', 'Tidak').then(x => {
            mahasiswaServices.put(param).then(res => {
                var jurusan = $scope.datas.jurusan.find(x => x.id == param.jurusan_id);
                $.LoadingOverlay('show');
                if (jurusan) {
                    param.status = "1";
                    var index = $scope.dataMahasiswa.indexOf(param);
                    $scope.dataMahasiswa.splice(index, 1);
                    param.user_id = res;
                }
                $.LoadingOverlay('hide');
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            mahasiswaServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function componenController($scope, componenServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Mahasiswa");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};

    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $.LoadingOverlay('show');
    componenServices.get().then(res => {
        $scope.datas = res;
        $scope.hitungPersentase();
        $.LoadingOverlay('hide');
    })

    $scope.hitungPersentase = () => {
        $scope.total = 0;
        $scope.datas.forEach(element => {
            $scope.total += parseFloat(element.persentase);
        });
    }

    $scope.edit = (param) => {
        param.persentase = parseFloat(param.persentase);
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.save = (param) => {
        pesan.dialog('Yakin ingin menyimpan?', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                componenServices.put($scope.model).then(res => {
                    $scope.hitungPersentase();
                    pesan.Success("Proses berhasil");
                    $scope.model = {};
                    $.LoadingOverlay('hide');
                })
            } else {
                componenServices.post($scope.model).then(res => {
                    $scope.hitungPersentase();
                    pesan.Success("Proses berhasil");
                    $scope.model = {};
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            componenServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function dosenController($scope, dosenServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Dosen");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};

    $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('scrollX', '100%');
    $.LoadingOverlay('show');
    dosenServices.get().then(res => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
    })

    $scope.edit = (param) => {
        param.persentase = parseFloat(param.persentase);
        $scope.model = angular.copy(param)
        $("#add").modal('show');
    }

    $scope.reset = (param) => {
        pesan.dialog('Yakin ingin mereset password?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            dosenServices.reset(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.save = (param) => {
        pesan.dialog('Yakin ingin menyimpan?', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            if ($scope.model.id) {
                dosenServices.put($scope.model).then(res => {
                    $scope.hitungPersentase();
                    pesan.Success("Proses berhasil");
                    $scope.model = {};
                    $.LoadingOverlay('hide');
                })
            } else {
                dosenServices.post($scope.model).then(res => {
                    $scope.hitungPersentase();
                    pesan.Success("Proses berhasil");
                    $scope.model = {};
                    $.LoadingOverlay('hide');
                })
            }
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            dosenServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function kontrakController($scope, kontrakServices, pesan, DTOptionsBuilder, getMacServices) {
    $scope.$emit("SendUp", "Mahasiswa");
    $scope.datas = {};
    $scope.model = {};
    $scope.dataKamar = {};
    $scope.jurusans = {};
    $scope.jadwals = [];
    $scope.rooms = [];
    $scope.kontrak = [];
    $scope.ta = {};
    $scope.setView = true;
    $scope.showQrcode = false;
    var qrcode = new QRCode("qrcode");
    $.LoadingOverlay("show");
    kontrakServices.get().then(res => {
        $scope.datas = res;
        $scope.ta = $scope.datas.ta;
        // if ((new Date($scope.ta.tgl_mulai) >= new Date()) && (new Date($scope.ta.tgl_selesai) <= new Date())) $scope.setView = true;
        // else $scope.setView = false;
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.rooms = $scope.datas.rooms;
        $scope.rooms.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            item.rooms_id = element.id;
            item.mahasiswa_id = element.mahasiswa_id;
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        getMacServices.get().then((res) => {
            $scope.showQrcode = true;
        })
        $scope.jadwals.forEach(element => {
            element.jumlah = parseFloat(element.jumlah);
            element.kapasitas = parseFloat(element.kapasitas);
        });
        console.log(res);
        $.LoadingOverlay("hide");
    })

    $scope.qrcode = (param) => {
        if (param.pertemuan_id) {
            var item = angular.copy(param);
            delete item.jurusan_id;
            delete item.kelas_id;
            delete item.matakuliah_id;
            delete item.ta_id;
            delete item.initial;
            delete item.$$hashKey;
            $scope.matakuliah = param;
            qrcode.clear();
            qrcode.makeCode(JSON.stringify(item))
            $("#showQrcode").modal('show');
        } else {
            pesan.error("Tidak ada pertemuan hari ini atau kelas belum dibuka");
        }
    }

    $scope.pilih = (item) => {
        $.LoadingOverlay("show");
        kontrakServices.post({ jadwal_id: item.id, kapasitas: item.kapasitas, matakuliah_id: item.matakuliah_id }).then((res) => {
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
                $.LoadingOverlay('show');
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                $.LoadingOverlay('hide');
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            kontrakServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }


}

function daftarLaboranController($scope, daftarLaboranServices, pesan, DTOptionsBuilder) {
    $scope.$emit("SendUp", "Pendaftaran Laboran");
    $scope.datas = [];
    $scope.model = {};
    $.LoadingOverlay('show');
    daftarLaboranServices.get().then((res) => {
        $scope.datas = res;
        $.LoadingOverlay('hide');
    })
    $scope.save = () => {
        pesan.dialog('Yakin ingin mendaftar?', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            daftarLaboranServices.post($scope.model).then(res => {
                $scope.datas = [];
                $scope.datas.push(angular.copy($scope.model));
                $.LoadingOverlay('hide');
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            kontrakServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function praktikumController($scope, praktikumServices, pesan, DTOptionsBuilder, getMacServices, helperServices) {
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
    $scope.showQrcode = false;
    var qrcode = new QRCode("qrcode");
    $.LoadingOverlay("show");
    praktikumServices.get().then(res => {
        $scope.datas = res;
        $scope.ta = $scope.datas.ta;
        if ((new Date($scope.ta.tgl_mulai) <= new Date()) && (new Date($scope.ta.tgl_selesai) >= new Date())) $scope.setView = true;
        else $scope.setView = false;
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.rooms = $scope.datas.rooms;
        $scope.rooms.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            item.rooms_id = element.id;
            item.mahasiswa_id = element.mahasiswa_id;
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        getMacServices.get().then((res) => {
            $scope.showQrcode = true;
        })
        $.LoadingOverlay("hide");
    })

    $scope.qrcode = (param) => {
        if (param.pertemuan_id) {
            var item = angular.copy(param);
            delete item.jurusan_id;
            delete item.kelas_id;
            delete item.matakuliah_id;
            delete item.ta_id;
            delete item.initial;
            delete item.$$hashKey;
            $scope.matakuliah = param;
            qrcode.clear();
            qrcode.makeCode(JSON.stringify(item))
            $("#showQrcode").modal('show');
        } else {
            pesan.error("Tidak ada pertemuan hari ini atau kelas belum dibuka");
        }
    }

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
                $.LoadingOverlay('show');
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                $.LoadingOverlay('hide');
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            kontrakServices.deleted(param).then(res => {
                $.LoadingOverlay('hide');
                pesan.Success('Berhasil menghapus');
            })
        })
    }

    $scope.daftarAbsen = (item) => {
        if (($scope.itemData && $scope.itemData.id != item.id) || !$scope.itemData) {
            $.LoadingOverlay('show')
            $scope.itemData = item;
            praktikumServices.getAbsen(item.id, item.rooms_id).then((res) => {
                $scope.dataAbsen = res;
                var h = $scope.dataAbsen.filter(x => x.status == 'H').length;
                var s = $scope.dataAbsen.filter(x => x.status == 'S').length;
                var i = $scope.dataAbsen.filter(x => x.status == 'I').length;
                s = s * 0.5;
                i = i * 0.25;
                $scope.persen = ((h + s + i) / $scope.dataAbsen.filter(x => x.status != null).length * 100).toFixed(2);
                $.LoadingOverlay('hide')
                $("#showAbsen").modal('show');
            })
        } else $("#showAbsen").modal('show');
    }

    $scope.daftarNilai = (item) => {
        if (($scope.itemNilai && $scope.itemNilai.id != item.id) || !$scope.itemNilai) {
            $.LoadingOverlay('show');
            $scope.itemNilai = item;
            praktikumServices.getNilai(item.id, item.rooms_id).then(res => {
                $scope.nilai = res;
                $scope.sum = ($scope.nilai.tugas.reduce((accumulator, object) => {
                    return accumulator + parseFloat(object.nilai);
                }, 0) / $scope.nilai.tugas.length).toFixed(2);
                $("#showNilai").modal('show');
                $.LoadingOverlay('hide');
            })
        } else $("#showNilai").modal('show');

    }
}

function profileController($scope, profileServices, pesan, helperServices) {
    $scope.$emit("SendUp", "Profile");
    $scope.datas = [];
    $scope.ubah = false;
    $scope.kelass = [];
    $scope.jurusans = [];
    $scope.password = {};

    profileServices.get().then(res => {
        $scope.datas = res;
        if ($scope.datas.photo) $scope.photo = helperServices.url + "assets/berkas/" + $scope.datas.photo;
        else $scope.photo = "https://bootdey.com/img/Content/avatar/avatar1.png";
        $scope.model = angular.copy($scope.datas);
        console.log(res);
    })

    $scope.edit = (param) => {
        $.LoadingOverlay('show');
        profileServices.read().then(res => {
            $scope.jurusans = res.jurusans;
            $scope.jurusan = $scope.jurusans.find(x => x.id == $scope.model.jurusan_id);
            $scope.kelass = res.kelass;
            $scope.kelas = $scope.kelass.find(x => x.id == $scope.model.kelas_id);
            $scope.ubah = true;
            $.LoadingOverlay('hide');
        })
    }

    $scope.save = () => {
        pesan.dialog('Yakin ingin menyimpan?', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            profileServices.put($scope.model).then(res => {
                $scope.datas = angular.copy($scope.model);
                $scope.kelas = {};
                $scope.jurusan = {};
                $scope.ubah = false;
                pesan.Success("Proses berhasil");
                $.LoadingOverlay('hide');
            })
        })
    }

    $scope.reset = () => {
        pesan.dialog('Yakin ingin mengubah password?', 'YA', 'Tidak').then(x => {
            $.LoadingOverlay('show');
            profileServices.reset($scope.password).then(res => {
                $scope.password = {};
                pesan.Success("Proses berhasil");
                $.LoadingOverlay('hide');
                setTimeout(() => {
                    document.location.href = helperServices.url + "auth";
                }, 500);
            })
        })
    }

    $scope.openFile = () => {
        $("input[id='my_file']").click();
    }

    $scope.uploadFoto = (param) => {
        $.LoadingOverlay('show');
        console.log(param);
        profileServices.upload(param).then(res => {
            pesan.Success("Proses berhasil");
            setTimeout(() => {
                document.location.href = helperServices.url + "auth";
            }, 500);
            $.LoadingOverlay('hide');
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
    $scope.setView = true;
    $.LoadingOverlay("show");
    mengawasServices.get().then(res => {
        $scope.datas = res;
        $scope.ta = $scope.datas.ta;
        // if ((new Date($scope.ta.tgl_mulai) <= new Date()) && (new Date($scope.ta.tgl_selesai) >= new Date())) $scope.setView = true;
        // else $scope.setView = false;
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.mengawas = $scope.datas.mengawas;
        $scope.mengawas.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        $.LoadingOverlay("hide");
    })


    $scope.pilih = (item) => {
        $.LoadingOverlay("show");
        mengawasServices.post({ jadwal_id: item.id }).then((res) => {
            $scope.mengawas.push(angular.copy(res));
            var temp = $scope.jadwals.find((x) => x.id == item.id);
            temp.mengawas_id = res.id;
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
            item.mengawas_id = "";
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
                $.LoadingOverlay("show");
                if (jurusan) {
                    var index = jurusan.dataPengajuan.indexOf(param);
                    jurusan.dataPengajuan.splice(index, 1);
                    param.user_id = res;
                    jurusan.dataMahasiswa.push(angular.copy(param));
                }
                $.LoadingOverlay("hide");
                pesan.Success("Process Success");
            })
        })
    }

    $scope.delete = (param) => {
        pesan.dialog('Yakin ingin menghapus?', 'Ya', 'Tidak').then(x => {
            $.LoadingOverlay("show");
            mengawasServices.deleted(param).then(res => {
                $.LoadingOverlay("hide");
                pesan.Success('Berhasil menghapus');
            })
        })
    }
}

function jadwalMengawasController($scope, mengawasServices, pesan, DTOptionsBuilder, helperServices) {
    $scope.$emit("SendUp", "Jadwal Mengawas");
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
        $scope.jadwals = angular.copy($scope.datas.jadwal);
        $scope.mengawas = $scope.datas.mengawas;
        $scope.mengawas.forEach(element => {
            var item = $scope.jadwals.find((x) => x.id == element.jadwal_id);
            item.jmlmahasiswa = parseInt(item.jmlmahasiswa);
            $scope.kontrak.push(angular.copy(item));
            var index = $scope.jadwals.indexOf(item);
            $scope.jadwals.splice(index, 1);
        });
        $.LoadingOverlay("hide");
    })

    $scope.showModul = (param) => {
        $("modul").modal('show');
    }

    $scope.openPertemuan = (param) => {
        param.jumlahPertemuan = parseInt(param.jumlahPertemuan);
        pesan.dialog('Anda ingin membuka pertemuan?', 'Ya', 'Tidak').then((x) => {
            param.tgl = helperServices.dateTimeToString(new Date());
            mengawasServices.open(param).then((res) => {
                param.jumlahPertemuan += 1;
                pesan.Success("Proses Berhasil");
            }, (err) => {
                pesan.dialog('Anda sudah membuka kelas hari ini yakin akan membuka kelas lagi?', 'Ya', 'Tidak', 'error').then(xx => {
                    param.again = true;
                    mengawasServices.open(param).then((again) => {
                        param.jumlahPertemuan += 1;
                        pesan.Success("Proses Berhasil");
                    })
                })
            })
        })
    }

    $scope.showMahasiswa = (param) => {
        $.LoadingOverlay("show");
        $scope.model = param;
        mengawasServices.getMahasiswa(param).then(res => {
            console.log(res);
            $scope.mahasiswas = res;
            $("#showMahasiswa").modal('show');
            $.LoadingOverlay("hide");
        })
    }
}

function absenRoomsController($scope, absenRoomsServices, pesan, DTOptionsBuilder, helperServices) {
    $scope.$emit("SendUp", "Absen Mahasiswa");
    $scope.model = {};
    $scope.ta = {};
    $scope.setView = false;
    $.LoadingOverlay("show");
    absenRoomsServices.get(helperServices.lastPath).then(res => {
        $scope.pertemuans = res;
        $.LoadingOverlay("hide");
    })
    $scope.showMahasiswa = (param) => {
        $.LoadingOverlay("show");
        absenRoomsServices.getByPertemuan(param).then((res) => {
            param.mahasiswas = res;
            $.LoadingOverlay("hide");
        })
    }

    $scope.absenMahasiswa = (param) => {
        absenRoomsServices.absen(param).then((res) => {
            param.absen_id = res.absen_id;
            param.by = res.by;
            pesan.Success("NPM: " + param.npm + (param.status == 'H' ? ' Hadir' : param.status == 'I' ? " Izin" : param.status == 'S' ? " Sakit" : " Tidak Hadir"));
        })
    }
}

function setKomponenController($scope, nilaiServices, jurusanServices, pesan, DTOptionsBuilder, helperServices) {
    $scope.$emit("SendUp", "Komponen Penilaian");
    $scope.model = {};
    $scope.ta = {};
    $scope.dataKomponen;
    $scope.setView = false;
    $scope.total = 0;
    $scope.showButton = false;
    $.LoadingOverlay("show");
    jurusanServices.get().then(res => {
        $scope.jurusans = res;
        $.LoadingOverlay('hide');
    })
    // nilaiServices.get().then((res) => {
    //     $scope.datas = res;
    //     $.LoadingOverlay('hide');
    // });
    $scope.getData = (param) => {
        $.LoadingOverlay('show');
        nilaiServices.byId(param.jadwal_id).then((res) => {
            $scope.dataKomponen = res;
            $scope.total = 0;
            $scope.dataKomponen.komponen.forEach(element => {
                if (element.detail_id) {
                    element.bobot = parseFloat(element.bobot);
                    $scope.total += element.bobot;
                }
                element.jadwal_id = param.jadwal_id;
            });
            if ($scope.total > 0) $scope.showButton = true;
            console.log(res);
            $.LoadingOverlay('hide');
        })
    }

    $scope.calculate = () => {
        $scope.total = 0;
        $scope.dataKomponen.komponen.forEach(element => {
            $scope.total += element.bobot ? element.bobot : 0;
        });
    }

    $scope.setNilai = (param) => {
        pesan.dialog("Yakin ingin set nilai?", "Ya", "Tidak").then(x => {
            $.LoadingOverlay('show');
            nilaiServices.set(param.jadwal_id).then(res => {
                $scope.dataKomponen = res;
                $scope.dataKomponen.komponen.forEach(element => {
                    if (element.detail_id) {
                        element.bobot = parseFloat(element.bobot);
                        // $scope.total += element.bobot;
                    }
                    element.jadwal_id = param.jadwal_id;
                });
                $.LoadingOverlay('hide');
            })

        })
    }

    $scope.saveKomponen = () => {
        pesan.dialog("Yakin ingin menyimpan komponen", "Ya", "Tidak").then(x => {
            nilaiServices.post($scope.dataKomponen.komponen).then(res => {
                pesan.Success("Berhasil");
                $scope.showButton = true;
            })
        })
    }

    $scope.inputTugas = (param) => {
        document.location.href = helperServices.url + "set_nilai/" + helperServices.encript("tugas@" + param.jadwal_id);
    }

    $scope.inputUas = (param) => {
        document.location.href = helperServices.url + "set_nilai/" + helperServices.encript("uas@" + param.jadwal_id);
    }

    $scope.toExcel = (set, Matkul) => {
        var item = Matkul;
        item.mahasiswa = $scope.dataKomponen.mahasiswa;
        nilaiServices.excel(item, set).then(res => {

        })
    }
}

function setNilaiController($scope, nilaiServices, pesan, DTOptionsBuilder, helperServices) {
    $scope.model = {};
    $scope.ta = {};
    $scope.dataKomponen;
    $scope.setView = false;
    $scope.total = 0;
    $.LoadingOverlay("show");
    var url = helperServices.decript(helperServices.lastPath);
    if (url[0] == "uas") {
        $scope.$emit("SendUp", "Input UAS");
        nilaiServices.getUas(parseInt(url[1])).then((res) => {
            $scope.datas = res;
            $.LoadingOverlay('hide');
        });
    } else {
        $scope.$emit("SendUp", "Input Tuags");
        nilaiServices.getTugas(parseInt(url[1])).then((res) => {
            $scope.datas = res;
            $.LoadingOverlay('hide');
        });
    }

    $scope.tambahJumlah = () => {
        pesan.dialog("Tugas yang ditambahkan tidak dapat di hapus \nYakin ingin menambah?").then(x => {
            $.LoadingOverlay("show");
            nilaiServices.postTugas(parseInt(url[1])).then(res => {
                $scope.datas.tugas.push(res);
                $scope.datas.mahasiswa.forEach(element => {
                    var item = angular.copy(res);
                    item.rooms_id = element.id;
                    element.tugas.push(angular.copy(item));
                });
                pesan.Success("Success");
                $.LoadingOverlay("hide");
            })
        })
    }

    $scope.save = (param) => {
        nilaiServices.postNilai(param, parseInt(url[1])).then(res => {
            if (!param.id) param.id = res.id
            pesan.Success("Berhasil");
        })
    }

    $scope.saveUas = (param) => {
        nilaiServices.postUas(param, parseInt(url[1])).then(res => {
            if (!param.id) param.id = res.id
            pesan.Success("Berhasil");
        })
    }

    $scope.setOrder = true;
    $scope.order = "-nama_mahasiswa";
    $scope.dataOrder = (param) => {
        if ($scope.setOrder) {
            $scope.setOrder = false;
            $scope.order = param;
            console.log($scope.order);
        } else {
            $scope.setOrder = true;
            $scope.order = "-" + param;
            console.log($scope.order);
        }
    }

}

function laporanController($scope, nilaiServices, pesan, DTOptionsBuilder, helperServices) {
    $scope.$emit("SendUp", "Laporan");
}
