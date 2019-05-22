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
<script src="<?= base_url('appjs/dashboard.js') ?>"></script>
<script src="<?= base_url('appjs/todolist.js') ?>"></script>