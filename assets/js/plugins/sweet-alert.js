const flashData = $('.flash-data').data('flashdata');
console.log(flashData);
if (flashData == 'masuk') {
  swal({
    title: "Semangat Pagi!",
    text: "Jangan lupa untuk selalu menjaga jarak, menggunakan masker, rajin mencuci tangan / menggunakan hand sanitizer dan mematuhi protokol kesehatan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-info",
    type: "info"
  }).catch(swal.noop)
} else if (flashData == 'setujudl') {
  swal({
    title: "Terimakasih!",
    text: "Perjalanan ini telah disetujui.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'bataldl') {
  swal({
    title: "Terimakasih!",
    text: "Perjalanan ini telah dibatalkan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'Xunfinishdl') {
  swal({
    title: "Maaf!",
    text: "Perjalanan ini mungkin dibatalkan ataupun belum selesai.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).then((result) => {
    if (result.value) {
      window.close();
    }
  }).catch(swal.noop)
} else if (flashData == 'Xsudahsetujudl') {
  swal({
    title: "Terimakasih!",
    text: "Perjalanan ini telah Telah disetujui oleh Kepala Departemen.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "info"
  }).catch(swal.noop)
} else if (flashData == 'nopolsalah') {
  swal({
    title: "Ooops!",
    text: "Nomor polisi yang kamu masukan tidak terdaftar dalam kendaraan operasional.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'backdate') {
  swal({
    title: "Maaf!",
    text: "Tanggal BERANGKAT tidak boleh lebih kecil dari HARI INI atau tanggal KEMBALI tidak boleh lebih kecil dari tanggal BERANGKAT.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'backjadwal') {
  swal({
    title: "Maaf!",
    text: "Tanggal BERANGKAT harus sesuai dengan range tanggal perjalanan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'tambahwaktudl') {
  swal({
    title: "Yeaayy!!!",
    text: "Waktu keberangkatan kamu RAISA tambah 1 JAM dari rencana waktu keberangkatan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-info",
    type: "info"
  }).catch(swal.noop)
} else if (flashData == 'rsvbaru') {
  swal({
    title: "HOREEE!! Reservasi Berhasil!",
    text: "Nanti RAISA kabarin deh kalo perjalanan kamu sudah disetujui dan siap untuk berangkat.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'rsvgagal') {
  swal({
    title: "Reservasi Gagal!",
    text: "Maaf Kendaraan yang anda pilih telah dipesan oleh orang lain. Silahkan melakukan reservasi kembali",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'berangkat') {
  swal({
    title: "Terimakasih!",
    text: "Perjalanan telah diberangkatkan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'passok') {
  swal({
    title: "Yeayy!",
    text: "Password kamu telah berhasil diubah.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'passng') {
  swal({
    title: "Maaf!",
    text: "Password anda gagal diubah.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'hapus') {
  swal({
    title: "Terimakasih!",
    text: "Aktivitas Telah dihapus.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'berhasilopname') {
  swal({
    title: "Terimakasih!",
    text: "Asset berhasil diopneme.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'gagalopname') {
  swal({
    title: "Maaf!",
    text: "Asset gagal diopname. Foto max 5Mb, catatan harus di isi jika ada perubahan data asset",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'batalbr') {
  swal({
    title: "Terimakasih!",
    text: "Lembur ini telah dibatalkan.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'setujuilbrhr') {
  swal({
    title: "Terimakasih!",
    text: "Lembur ini telah disetujui.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'berhasilverifikasi') {
  swal({
    title: "Terimakasih!",
    text: "Asset Opname telah diverifikasi",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'setujuilbrga') {
  swal({
    title: "Terimakasih!",
    text: "Konsumsi telah dikonfirmasi.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'clockSuccess') {
  swal({
    title: "Terimakasih!",
    text: "Kehadiraan kamu berhasil. \n Tetap #diRumahAja dan jangan kemana-mana ya!",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'clockSuccess2') {
  swal({
    title: "Terimakasih!",
    text: "Submit Kehadiraan kamu cukup 1x aja. \n Tetap #diRumahAja dan jangan kemana-mana ya!",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "info"
  }).catch(swal.noop)
} else if (flashData == 'clockFailed') {
  swal({
    title: "Maaf!",
    text: "Kehadiraan kamu gagal. \n Sabar dan tunggu sesuai jendela waktu yang telah ditentukan ya! \n (Kalo peta tidak muncul, hubungi RAISA/DIO segera!)",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'terimakasih') {
  swal({
    title: "Terimakasih!",
    text: "Data sudah diproses",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-success",
    type: "success"
  }).catch(swal.noop)
} else if (flashData == 'update') {
  swal({
    title: "Waktu Sudah Terlewati.!",
    text: "Silahkan Coba Lagi Dengan Waktu Aktual.",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-danger",
    type: "error"
  }).catch(swal.noop)
} else if (flashData == 'dirumahaja') {
  swal({
    title: "INGAT!",
    text: "Jawablah dengan penuh kejujuran. Karena kejujuran kamu menentukan keselamatan karyawan lainnya",
    buttonsStyling: false,
    confirmButtonClass: "btn btn-warning",
    type: "warning"
  }).catch(swal.noop)
}


$('.btn-bataldl').on('click', function (e) {

  e.preventDefault();
  const href = $(this).attr('href');

  swal({
    title: 'Apakah anda yakin?',
    text: "Anda ingin membatalkan aktivitas ini",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    confirmButtonText: 'YA, BATALKAN AKTIVITAS!',
    cancelButtonText: 'TUTUP',
    buttonsStyling: false
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  }).catch(swal.noop)

});

$('.btn-hapus').on('click', function (e) {

  e.preventDefault();
  const href = $(this).attr('href');

  swal({
    title: 'Apakah anda yakin?',
    text: "Anda ingin menghapus aktivitas ini",
    type: 'warning',
    showCancelButton: true,
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    confirmButtonText: 'YA, BATALKAN AKTIVITAS!',
    cancelButtonText: 'TUTUP',
    buttonsStyling: false
  }).then((result) => {
    if (result.value) {
      document.location.href = href;
    }
  }).catch(swal.noop)

});
sweet = {

  // sweet alert
  showSwal: function (type) {
    if (type == 'basic') {
      swal({
        title: "Here's a message!",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-success"
      }).catch(swal.noop)

    } else if (type == 'tolakdl') {
      swal({
        title: 'Anda yakin?',
        text: "Apakah anda tidak menyetujui perjalanan ini?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Ya, Batalkan perjalanan!',
        buttonsStyling: false
      }).then((result) => {
        if (result.value) {
          swal({
            title: 'Ditolak',
            text: 'Perjalanan ini telah dibatalkan',
            type: 'error',
            // confirmButtonClass: "btn btn-info",
            // buttonsStyling: false,
            timer: 1500,
            onBeforeOpen: () => {
              Swal.showLoading()
              timerInterval = setInterval(() => {
                Swal.getContent().querySelector('strong')
                  .textContent = Swal.getTimerLeft()
              }, 100)
            },
            onClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            if (
              // Read more about handling dismissals
              result.dismiss === Swal.DismissReason.timer
            ) {
              var rsv_id = button.data('rsv_id');
              window.open('tolakdl/' + rsv_id, "_top")
            }
          }).catch(swal.noop)
        }
      })

    } else if (type == 'title-and-text') {
      swal({
        title: "Here's a message!",
        text: "It's pretty, isn't it?",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-info"
      }).catch(swal.noop)

    } else if (type == 'success-message') {
      swal({
        title: "Good job!",
        text: "You clicked the button!",
        buttonsStyling: false,
        confirmButtonClass: "btn btn-success",
        type: "success"
      }).catch(swal.noop)

    } else if (type == 'warning-message-and-confirmation') {
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        confirmButtonText: 'Yes, delete it!',
        buttonsStyling: false
      }).then(function () {
        swal({
          title: 'Deleted!',
          text: 'Your file has been deleted.',
          type: 'success',
          confirmButtonClass: "btn btn-success",
          buttonsStyling: false
        })
      }).catch(swal.noop)
    } else if (type == 'warning-message-and-cancel') {
      swal({
        title: 'Are you sure?',
        text: 'You will not be able to recover this imaginary file!',
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, keep it',
        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false
      }).then(function () {
        swal({
          title: 'Deleted!',
          text: 'Your imaginary file has been deleted.',
          type: 'success',
          confirmButtonClass: "btn btn-success",
          buttonsStyling: false
        }).catch(swal.noop)
      }, function (dismiss) {
        // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
        if (dismiss === 'cancel') {
          swal({
            title: 'Cancelled',
            text: 'Your imaginary file is safe :)',
            type: 'error',
            confirmButtonClass: "btn btn-info",
            buttonsStyling: false
          }).catch(swal.noop)
        }
      })

    } else if (type == 'custom-html') {
      swal({
        title: 'HTML example',
        buttonsStyling: false,
        confirmButtonClass: "btn btn-success",
        html: 'You can use <b>bold text</b>, ' +
          '<a href="http://github.com">links</a> ' +
          'and other HTML tags'
      }).catch(swal.noop)

    } else if (type == 'auto-close') {
      swal({
        title: "Auto close alert!",
        text: "I will close in 2 seconds.",
        timer: 2000,
        showConfirmButton: false
      }).catch(swal.noop)
    } else if (type == 'input-field') {
      swal({
        title: 'Input something',
        html: '<div class="form-group">' +
          '<input id="input-field" type="text" class="form-control" />' +
          '</div>',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function (result) {
        swal({
          type: 'success',
          html: 'You entered: <strong>' +
            $('#input-field').val() +
            '</strong>',
          confirmButtonClass: 'btn btn-success',
          buttonsStyling: false

        })
      }).catch(swal.noop)
    }
  },

  initGoogleMaps: function () {
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 13,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      styles: [{
        "featureType": "water",
        "stylers": [{
          "saturation": 43
        }, {
          "lightness": -11
        }, {
          "hue": "#0088ff"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "hue": "#ff0000"
        }, {
          "saturation": -100
        }, {
          "lightness": 99
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#808080"
        }, {
          "lightness": 54
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ece2d9"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ccdca1"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#767676"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "poi",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#b8cb93"
        }]
      }, {
        "featureType": "poi.park",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.sports_complex",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.medical",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "simplified"
        }]
      }]

    }
    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Hello World!"
    });

    // To add the marker to the map, call setMap();
    marker.setMap(map);
  },

  initSmallGoogleMaps: function () {

    // Regular Map
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 8,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
    }

    var map = new google.maps.Map(document.getElementById("regularMap"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Regular Map!"
    });

    marker.setMap(map);


    // Custom Skin & Settings Map
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 13,
      center: myLatlng,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      disableDefaultUI: true, // a way to quickly hide all controls
      zoomControl: true,
      styles: [{
        "featureType": "water",
        "stylers": [{
          "saturation": 43
        }, {
          "lightness": -11
        }, {
          "hue": "#0088ff"
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.fill",
        "stylers": [{
          "hue": "#ff0000"
        }, {
          "saturation": -100
        }, {
          "lightness": 99
        }]
      }, {
        "featureType": "road",
        "elementType": "geometry.stroke",
        "stylers": [{
          "color": "#808080"
        }, {
          "lightness": 54
        }]
      }, {
        "featureType": "landscape.man_made",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ece2d9"
        }]
      }, {
        "featureType": "poi.park",
        "elementType": "geometry.fill",
        "stylers": [{
          "color": "#ccdca1"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.fill",
        "stylers": [{
          "color": "#767676"
        }]
      }, {
        "featureType": "road",
        "elementType": "labels.text.stroke",
        "stylers": [{
          "color": "#ffffff"
        }]
      }, {
        "featureType": "poi",
        "stylers": [{
          "visibility": "off"
        }]
      }, {
        "featureType": "landscape.natural",
        "elementType": "geometry.fill",
        "stylers": [{
          "visibility": "on"
        }, {
          "color": "#b8cb93"
        }]
      }, {
        "featureType": "poi.park",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.sports_complex",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.medical",
        "stylers": [{
          "visibility": "on"
        }]
      }, {
        "featureType": "poi.business",
        "stylers": [{
          "visibility": "simplified"
        }]
      }]

    }

    var map = new google.maps.Map(document.getElementById("customSkinMap"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Custom Skin & Settings Map!"
    });

    marker.setMap(map);



    // Satellite Map
    var myLatlng = new google.maps.LatLng(40.748817, -73.985428);
    var mapOptions = {
      zoom: 3,
      scrollwheel: false, //we disable de scroll over the map, it is a really annoing when you scroll through page
      center: myLatlng,
      mapTypeId: google.maps.MapTypeId.SATELLITE
    }

    var map = new google.maps.Map(document.getElementById("satelliteMap"), mapOptions);

    var marker = new google.maps.Marker({
      position: myLatlng,
      title: "Satellite Map!"
    });

    marker.setMap(map);


  }

}