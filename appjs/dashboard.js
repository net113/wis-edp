$("#pilihToko").focus(() => $("#pilihToko").val(""));
$("#pilihToko").on("keyup", function(e) {
  if (e.keyCode === 13) {
    let val = $(this)
      .val()
      .toUpperCase();
    let list = $(this).attr("list");
    let cek = $("#" + list).find("option[value='" + val + "']");
    if (cek != null && cek.length == 0) {
      swal({
        title: `KodeToko ${val} Salah!!!`,
        type: "error",
        timer: 1000
      });
    } else {
      $.ajax({
        type: "POST",
        dataType: "json",
        url: window.location.pathname + "/getToko",
        data: {
          kdtk: val
        },
        success: function(res) {
          //console.log(res);
          let ipToko = [
            "ip_router",
            "ip_backup",
            "ip_induk",
            "ip_anak1",
            "ip_anak2",
            "ip_anak3",
            "ip_anak4",
            "ip_anak5",
            "ip_anak6",
            "ip_anak7",
            "ip_apka",
            "ip_ikios",
            "ip_stb",
            "ip_router_edc",
            "ip_pointcafe",
            "ip_telemetri"
          ];
          let hasilip = "";
          ipToko.forEach(function(ip) {
            if (res[ip] != "") {
              if (res[ip] != null) {
                hasilip += `<div class="input-group mb-2 col-lg-7 ">
                        <div class="input-group-prepend">
                            <div class="input-group-text">${ip} </div>
                        </div>
                        <input type="text" class="form-control" id="inlineFormInputGroup" readonly value="${
                          res[ip]
                        }">
                    </div>`;
              }
            }
          });
          $("#hasil").html(`<label>Nama : <b>${res.KodeToko} - ${
            res.NamaToko
          }</b></label><br>
                    <label>Koneksi Utama : <b>${
                      res.tipe_koneksi_primary
                    }</b> </label> ${
            res.tipe_koneksi_secondary == ""
              ? `<br>`
              : `<label class="ml-5">Koneksi Backup : <b> ${
                  res.tipe_koneksi_secondary
                }</b> </label><br>`
          }
                    <label>No Telp : <b>${res.NoTelpToko}</b><br>
                    <label>IP WAN : <b>${res.ip_wan}</b><br> </label> ${
            res.sid == ""
              ? `<br>`
              : `<label class="ml-5">SID : <b> ${res.sid}</b> </label><br>`
          }
                    <label>Alamat : <b>${res.AlamatToko} , Kel: ${
            res.TOK_KELURAHAN
          } , Kec: ${res.TOK_KECAMATAN}, ${res.KotaToko} </b> </label><br>
                    <label>Tagging Lokasi : <b><a href="https://www.google.com/maps/search/?api=1&query=${
                      res.lat_decimal
                    },${
            res.long_decimal
          }" target="_blank">Show on Map</a></b> </label><br>
                    <label>EDP OPR : <b>${res.personil}</b> </label><br>
                    <label>ASPV : <a href="#" onclick="showArea('${
                      res.aspv
                    }')"><b>${
            res.aspv
          }</b></a> </label> <label class="ml-5">AMGR : <a href="#" onclick="showArea('${
            res.amgr
          }')"><b>${res.amgr}</b></a> </label><br>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label" for="TypeToko24">Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="TypeToko24" name="TypeToko24" value="" ${
                              res.TypeToko24 == "Y" ? `checked` : ``
                            }>
                            <label class="custom-control-label" for="TypeToko24s">Toko 24jam</label>
                        </div>
                        <div class="ml-2 custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="TokoApka" name="TokoApka" value="" ${
                              res.TokoApka == "Y" ? `checked` : ``
                            }>
                            <label class="custom-control-label" for="TokoApka">Toko Apka</label>
                        </div>
                        <div class="ml-2 custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isIkiosk" name="isIkiosk" value="" ${
                              res.isIkiosk == "Y" ? `checked` : ``
                            }>
                            <label class="custom-control-label" for="isIkiosk">Ikiosk</label>
                        </div>
                    </div>
                        ${hasilip}
                    `);

          $("#hasil input:text").on("click", function() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(this).val()).select();
            document.execCommand("copy");
            $temp.remove();
            swal({
              text: "Success copying " + $(this).val(),
              timer: 1000,
              type: "success"
            });
          });
        },
        error: function(xhr, textStatus, thrownError) {
          swal({
            title: xhr.responseText,
            type: "error"
          });
        }
      });
    }
  }
});

function showArea(initial) {
  if (initial) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: window.location.pathname + "/getArea",
      data: {
        initial: initial
      },
      success: function(res) {
        swal({
          title: res.nama,
          html: `Jabatan : ${res.jabatan} <br>NIK : ${res.nik} <br> Initial: ${
            res.initial
          } <br> NoTelp: ${res.notelp} <br>`,
          type: "info"
        });
      },
      error: function(xhr, textStatus, thrownError) {
        swal({
          title: xhr.responseText,
          type: "error"
        });
      }
    });
  }
}
