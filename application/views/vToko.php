  <!-- Custom styles for this page -->

  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet">


  <div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header pb-0 pt-3">
              <div class="row">
                  <div class="col-lg-6">
                      <h5 class="m-0  text-primary">List All Toko Cabang Bogor 1 G113</h5>
                      <span class="badge badge-danger">Franchise : <?= getTipeToko('F') ?> Toko</span>
                      <span class="badge badge-warning">Reguler: <?= getTipeToko('T') ?> Toko</span>
                      <span class="badge badge-success">Ceriamart: <?= getTipeToko('R') ?> Toko</span>
                  </div>
                  <div class="col-lg-6">
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
              <div class="modal-body">
                  <div class="alert alert-danger" role="alert" id="removeWarning">
                      <span class="fas fa-fw fa-exclamation-circle"></span>
                      Are you sure ??
                  </div>
                  <form id="form" class="form-horizontal">
                      <input type="hidden" class="form-control" id="aksi" name="aksi">
                      <input type="hidden" class="form-control" id="key" name="key">
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="KodeToko">Nama</label>
                          <input type="text" class="col-sm-2 form-control mr-1" id="KodeToko" name="KodeToko" placeholder="KDTK" required>
                          <input type="text" class="col-sm-6 form-control" id="NamaToko" name="NamaToko" placeholder="NAMA" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="tipe_koneksi_primary">Koneksi</label>
                          <input list="list_koneksi_primary" value="" class="datalist mr-2 col-sm-4 custom-select custom-select-sm" id="tipe_koneksi_primary" name="tipe_koneksi_primary" required placeholder="Koneksi Utama">
                          <datalist id="list_koneksi_primary">
                              <?php
                                $role = $this->db->get('tb_tipe_koneksi')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['jenis'] . '">' . $ic['jenis'] . '</option>';
                                }
                                ?>
                          </datalist>
                          <input list="list_koneksi_secondary" value="" class="datalist col-sm-4 custom-select custom-select-sm" id="tipe_koneksi_secondary" name="tipe_koneksi_secondary" placeholder="Koneksi Backup">
                          <datalist id="list_koneksi_secondary">
                              <option> - </option>
                              <?php
                                $role = $this->db->get('tb_tipe_koneksi')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['jenis'] . '">' . $ic['jenis'] . '</option>';
                                }
                                ?>
                          </datalist>
                      </div>
                      <div class="form-group row">
                          <label for="NoTelpToko" class="col-sm-3 control-label">Telp</label>
                          <input type="text" class="form-control col-sm-6" id="NoTelpToko" name="NoTelpToko" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="aspv">Area</label>
                          <input list="list_aspv" value="" class="mr-2 col-sm-4 custom-select custom-select-sm datalist" id="aspv" name="aspv" required placeholder="ASPV">
                          <datalist id="list_aspv">
                              <?php
                                $role = $this->db->get_where('tb_area', ['jabatan' => 'aspv'])->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['initial'] . '">' . $ic['initial'] . ' - ' . $ic['nama'] . '</option>';
                                }
                                ?>
                          </datalist>
                          <input list="list_amgr" value="" class="col-sm-4 custom-select custom-select-sm datalist" id="amgr" name="amgr" required placeholder="AMGR">
                          <datalist id="list_amgr">
                              <?php
                                $role = $this->db->get_where('tb_area', ['jabatan' => 'amgr'])->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['initial'] . '">' . $ic['initial'] . ' - ' . $ic['nama'] . '</option>';
                                }
                                ?>
                          </datalist>
                      </div>
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



<script src="<?= base_url('appjs/toko.js') ?>"></script>