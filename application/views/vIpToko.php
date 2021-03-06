  <!-- Custom styles for this page -->

  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet">


  <div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header pb-0 pt-3">
              <div class="row">
                  <div class="col-lg-7">
                      <h5 class="m-0  text-primary">List All Toko Cabang Bogor 1 G113</h5>
                      <span class="badge badge-warning">VSAT : <?= getTokoKoneksi("VSAT") ?> Toko</span>
                      <span class="badge badge-info">XL HOME : <?= getTokoKoneksi('XL HOME') ?> Toko</span>
                      <span class="badge badge-success">ASTINET: <?= getTokoKoneksi('ASTINET') ?> Toko</span>
                      <span class="badge badge-primary">ASTINET: <?= getTokoKoneksi('FIBERSTAR') ?> Toko</span>
                      <span class="badge badge-danger">GSM: <?= getTokoKoneksi('GSM') ?> Toko</span>
                  </div>
                  <div class="col-lg-5">
                      <?= $this->session->flashdata('message'); ?>
                  </div>
              </div>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered " id="dataTable" width="100%" cellspacing="0">
                      <thead class="thead-dark">
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

  </div>


  <!-- Modal -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="label">Add New Menu</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body pb-0">
                  <div class="alert alert-danger" role="alert" id="removeWarning">
                      <span class="fas fa-fw fa-exclamation-circle" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                      Are you sure ??
                  </div>
                  <form id="form" class="form-horizontal">
                      <input type="hidden" class="form-control" id="aksi" name="aksi">
                      <input type="hidden" class="form-control" id="key" name="key">
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="KodeToko">Nama</label>
                          <input type="text" class="col-sm-2 form-control  form-control-sm mr-1" id="KodeToko" name="KodeToko" placeholder="KDTK" required>
                          <input type="text" class="col-sm-6 form-control form-control-sm" id="NamaToko" name="NamaToko" placeholder="NAMA" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="tipe_koneksi_primary">Koneksi</label>
                          <input list="list_koneksi_primary" value="" class="mr-2 col-sm-4 custom-select custom-select-sm" placeholder="Jenis Koneksi Utama" id="tipe_koneksi_primary" name="tipe_koneksi_primary" required>
                          <datalist id="list_koneksi_primary">
                              <?php
                                $role = $this->db->get('tb_tipe_koneksi')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['jenis'] . '">' . $ic['jenis'] . '</option>';
                                }
                                ?>
                          </datalist>
                          <input value="" class="col-sm-4 form-control form-control-sm" id="ip_router" name="ip_router" placeholder="IP Router Utama" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="tipe_koneksi_secondary">Backup</label>
                          <input list="list_koneksi_secondary" value="" class="mr-2 col-sm-4 custom-select custom-select-sm" placeholder="Jenis Koneksi Backup" id="tipe_koneksi_secondary" name="tipe_koneksi_secondary">
                          <datalist id="list_koneksi_secondary">
                              <?php
                                $role = $this->db->get('tb_tipe_koneksi')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['jenis'] . '">' . $ic['jenis'] . '</option>';
                                }
                                ?>
                          </datalist>
                          <input value="" class="col-sm-4 form-control form-control-sm" id="ip_backup" name="ip_backup" placeholder="IP Router Backup">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_induk">IP Induk</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_induk" name="ip_induk" placeholder="IP Induk +1">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_anak1">IP Anak1</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak1" name="ip_anak1" placeholder="IP Anak1 + 2">

                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_apka">IP Apka</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_apka" name="ip_apka" placeholder="IP Apka +3">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_ikios">IP Ikios</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_ikios" name="ip_ikios" placeholder="IP Ikios + 20">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_stb">IP STB</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_stb" name="ip_stb" placeholder="IP STB +17">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_router_edc">IP RB EDC</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_router_edc" name="ip_router_edc" placeholder="IP RB EDC + 19">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_anak2">IP Anak2</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak2" name="ip_anak2" placeholder="IP Induk + 4">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_anak3">IP Anak3</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak3" name="ip_anak3" placeholder="IP Anak3 + 5">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_anak4">IP Anak4</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak4" name="ip_anak4" placeholder="IP Anak4 + 6">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_anak5">IP Anak5</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak5" name="ip_anak5" placeholder="IP Anak5 + 7">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_anak6">IP Anak6</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak6" name="ip_anak6" placeholder="IP Anak6 + 8">
                          <label class="col-sm-3 control-label-sm" style="max-width: 20%;" for="ip_anak7">IP Anak7</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_anak7" name="ip_anak7" placeholder="IP Anak7 + 9">
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="ip_pointcafe">IP P Cafe</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_pointcafe" name="ip_pointcafe" placeholder="IP P Cafe + 9">
                          <label class="col-sm-3 control-label-sm" style="max-width: 22%;" for="ip_telemetri">IP Telemetri</label>
                          <input value="" class="col-sm-3 form-control form-control-sm" id="ip_telemetri" name="ip_telemetri" placeholder="IP Telemetri + 10">
                      </div>

              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" id="btn-aksi" onClick="saveData()">Save changes</button>
              </div>
              </form>
          </div>
      </div>
  </div>


  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/buttons.bootstrap4.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/buttons.html5.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/buttons.print.min.js"></script>
  <script type="text/javascript" src="<?= base_url('assets/') ?>vendor/datatables/js/buttons.colVis.min.js"></script>



<script src="<?= base_url('appjs/iptoko.js') ?>"></script>