  <!-- Custom styles for this page -->

  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet">


  <div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header pb-0 pt-3">
              <div class="row">
                  <div class="col-lg-6 text-primary">
                      <h5>Data Pembagian Area Coverage Tim EDP Operasional</h5>

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
                      <span class="fas fa-fw fa-exclamation-circle" aria-hidden="true"></span>
                      <span class="sr-only">Error:</span>
                      Are you sure ??
                  </div>
                  <form id="form" class="form-horizontal">
                      <input type="hidden" class="form-control" id="aksi" name="aksi">
                      <input type="hidden" class="form-control" id="key" name="key">
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="KodeToko">KDTK</label>
                          <input type="text" class="col-sm-8 form-control" id="KodeToko" name="KodeToko" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="NamaToko">Nama</label>
                          <input type="text" class="form-control col-sm-8" id="NamaToko" name="NamaToko" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="pic_maintenance">Personil</label>
                          <input list="personil" value="" class="col-sm-6 custom-select custom-select-sm" id="pic_maintenance" name="pic_maintenance">
                          <datalist id="personil">
                              <option> - </option>
                              <?php
                                $role = $this->db->get_where('tb_user', ['role_id' => 13])->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['username'] . '">' . $ic['fullname'] . '</option>';
                                }
                                ?>
                          </datalist>
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


  <script src="<?= base_url('appjs/coverage.js') ?>"></script>
  