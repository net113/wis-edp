<link rel="stylesheet" href="<?= base_url("assets/"); ?>css/styletodolist.css">
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow border-left-primary">
                <div class="container">
                    <div class="input-group mb-3 mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Pilih Toko :</span>
                        </div>
                        <input type="text" class="form-control" id="pilihToko" list="listToko" value="">
                        <datalist id="listToko">
                            <?php
                            $tokos = $this->db->get('tb_toko')->result_object();
                            foreach ($tokos as $toko) {
                                echo '<option value="' . $toko->KodeToko . '">' . $toko->KodeToko . ' - ' . $toko->NamaToko . '</option>';
                            }
                            ?>
                        </datalist>
                    </div>
                    <div id="hasil">
                        <label>Nama : <b>XXX - XXXXXXX</b></label><br>
                        <label>Koneksi Utama : <b>ASTINET</b> </label> <label class="ml-5">Koneksi Backup : <b>ASTINET</b> </label><br>
                        <label>No Telp : <b>08XXX</b> </label> <label class="ml-5">SID : <b>08XXX</b> </label><br>
                        <label>Alamat : <b>XXX</b> </label><br>
                        <label>EDP OPR : <b>XXX</b> </label><br>
                        <label>ASPV : <a href="#" onclick="showAspv('XXX')"><b>XXX</b></a> </label> <label class="ml-5">AMGR : <a href="#" onclick="showAspv('XXX')"><b>XXX</b></a> </label><br>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="TypeToko24">Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="TypeToko24" name="TypeToko24" value="">
                                <label class="custom-control-label" for="TypeToko24">Toko 24jam</label>
                            </div>
                            <div class="ml-2 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="TokoApka" name="TokoApka" value="">
                                <label class="custom-control-label" for="TokoApka">Toko Apka</label>
                            </div>
                            <div class="ml-2 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isIkiosk" name="isIkiosk" value="">
                                <label class="custom-control-label" for="isIkiosk">Ikiosk</label>
                            </div>
                        </div>
                        <div class="input-group mb-2 col-lg-8 ">
                            <div class="input-group-prepend">
                                <div class="input-group-text">IP Router</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroup" readonly value="10.42.xx">
                        </div>
                        <div class="input-group mb-2 col-lg-6">
                            <div class="input-group-prepend">
                                <div class="input-group-text">IP Induk</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroup" readonly value="10.42.xx">
                        </div>
                        <div class="input-group mb-2 ">
                            <div class="input-group-prepend">
                                <div class="input-group-text">IP Anak</div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroup" readonly value="10.42.xx">
                        </div>
                    </div>



                </div>
            </div>
        </div>
        <div class="col-lg-5">

            <div class="list-wrapper border-left-danger">
                <h1 class="heading">Don't Forget To...</h1>
                <div class="add">
                    <input class="txtAdd" type="text" placeholder="Add task here...">
                    <button class="btnAdd" type="button">DELETE</button>
                </div>
                <div class="list">
                </div>
                <div class="switchMessage" ng-switch="allTasks">
                    <h3 class="count">{{completedTasks}} out of {{taskList.length}} tasks completed</h3>
                </div>
            </div>
            <div class="card  shadow border-left-success">
                <div class="card-header ">
                    <h4 class="card-title">List Call Center</h4>
                    <p class="card-category">A number you shoud call when something went wrong</p>
                </div>
                <div class="card-body ">
                    <ul>
                        <li>Telkom Coorporate DES : <b>0800-1835566 ext 112</b></li>
                        <li>Telkom Coorporate DBS : <b>1500250</b></li>
                        <li> Eos HO : <b>02129135568 </b></li>
                        <li> ASTINET BB : <b>4700709-0030794689</b></li>
                        <li> ASTINET BM : <b>553501104</b></li>
                        <li> SPEEDY : <b>122363205497</b></li>
                        <li> IPP : <b>4700709-0031030812</b></li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#pilihToko').on('keyup', function(e) {
        if (e.keyCode === 13) {
            let val = $(this).val().toUpperCase();
            let list = $(this).attr("list");
            let cek = $("#" + list).find("option[value='" + val + "']");
            if (cek != null && cek.length == 0) {
                swal({
                    title: `KodeToko ${val} Salah!!!`,
                    type: 'error',
                    timer: 1000
                });
            } else {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<?= base_url('dashboard/getToko') ?>",
                    data: {
                        kdtk: val

                    },
                    success: function(res) {
                        //console.log(res);
                        let ipToko = ['ip_router', 'ip_backup', 'ip_induk', 'ip_anak1', 'ip_anak2', 'ip_anak3', 'ip_anak4', 'ip_anak5', 'ip_anak6', 'ip_anak7', 'ip_apka', 'ip_ikios', 'ip_stb', 'ip_router_edc', 'ip_pointcafe', 'ip_telemetri'];
                        let hasilip;
                        ipToko.forEach(function(ip) {
                            if (res[ip] != '') {
                                if (res[ip] != null) {

                                    hasilip += `<div class="input-group mb-2 col-lg-7 ">
                            <div class="input-group-prepend">
                                <div class="input-group-text">${ip} </div>
                            </div>
                            <input type="text" class="form-control" id="inlineFormInputGroup" readonly value="${res[ip]}">
                        </div>`;
                                }


                            }
                        });
                        $('#hasil').html(`<label>Nama : <b>${res.KodeToko} - ${res.NamaToko}</b></label><br>
                        <label>Koneksi Utama : <b>${res.tipe_koneksi_primary}</b> </label> ${(res.tipe_koneksi_secondary == "" ? `<br>`:  `<label class="ml-5">Koneksi Backup : <b> ${res.tipe_koneksi_secondary}</b> </label><br>` )}
                        <label>No Telp : <b>${res.NoTelpToko}</b><br>
                        <label>IP WAN : <b>${res.ip_wan}</b><br> </label> ${(res.sid == "" ? `<br>`:  `<label class="ml-5">SID : <b> ${res.sid}</b> </label><br>` )}
                        <label>Alamat : <b>${res.AlamatToko} , Kel: ${res.TOK_KELURAHAN} , Kec: ${res.TOK_KECAMATAN}, ${res.KotaToko} </b> </label><br>
                        <label>EDP OPR : <b>${res.personil}</b> </label><br>
                        <label>ASPV : <a href="#" onclick="showAspv('${res.aspv}')"><b>${res.aspv}</b></a> </label> <label class="ml-5">AMGR : <a href="#" onclick="showAspv('${res.amgr}')"><b>${res.amgr}</b></a> </label><br>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label" for="TypeToko24">Status</label>
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="TypeToko24" name="TypeToko24" value="" ${res.TypeToko24 == 'Y' ? `checked` : ``}>
                                <label class="custom-control-label" for="TypeToko24">Toko 24jam</label>
                            </div>
                            <div class="ml-2 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="TokoApka" name="TokoApka" value="" ${res.TokoApka == 'Y' ? `checked` : ``}>
                                <label class="custom-control-label" for="TokoApka">Toko Apka</label>
                            </div>
                            <div class="ml-2 custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="isIkiosk" name="isIkiosk" value="" ${res.isIkiosk == 'Y' ? `checked` : ``}>
                                <label class="custom-control-label" for="isIkiosk">Ikiosk</label>
                            </div>
                            ${hasilip}
                        `);

                        $('#hasil input').on('click', function() {
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
                            type: 'error'
                        });
                    }
                });
            }
        }
    });
</script>
<script src="<?= base_url('assets/js/todolist.js') ?>"></script>