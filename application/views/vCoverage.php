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



  <script>
      $(document).ready(function() {
          var table = $('#dataTable').DataTable({
              lengthChange: false,
              dom: '<"row btn-group col-lg-12 "<"col-sm-12 col-md-9"B><"col-sm-12 col-md-3 float-right"f>><"row"rt><"row"<"col-sm-12 col-md-6 float-right"i><"col-sm-12 col-md-6 float-right"p>>',
              buttons: [
                  'copy', 'csv', 'colvis', 'pageLength'
              ],
              responsive: true,
              serverSide: true,
              processing: true,
              lengthMenu: [
                  [25, 50, 100, 1000],
                  ['25 rows', '50 rows', '100 rows', 'Show all']
              ],
              fnInitComplete: function() {
                  if ($("#admin_menu").val() != "Y") {
                      $(".admin-menu").hide();
                  }
              },
              fnDrawCallback: function() {
                  if ($("#admin_menu").val() != "Y") {
                      $(".admin-menu").hide();
                  }
              },
              ajax: {
                  "url": "<?php echo base_url() . '/coverage/get_data_json' ?>",
                  "type": "POST"
              },
              columns: [{
                      "data": "KodeToko",
                      "title": "KDTK"
                  },
                  {
                      "data": "NamaToko",
                      "title": "Nama Toko"
                  },
                  {
                      "data": "pic_maintenance",
                      "title": "NIK"
                  },
                  {
                      "data": "personil",
                      "title": "Personil"
                  },
                  {
                      "data": "view",
                      "title": "Options",
                      "orderable": false,
                      "className": "text-center admin-menu"

                  }
              ]
          });

      }); //domready

      function showModals(id) {

          // Untuk Eksekusi Data Yang Ingin di Edit 
          if (id) {

              $.ajax({
                  type: "POST",
                  url: "<?= base_url('coverage/crud') ?>",
                  dataType: 'json',
                  data: {
                      id: id,
                      aksi: "get"
                  },
                  beforeSend: function() {
                      clearModals();
                  },
                  success: function(res) {
                      $("#label").html('Edit Coverage');
                      $("#aksi").val("edit");
                      $("#key").val(id);
                      $('#btn-aksi').html('Update');
                      setModalData(res);
                      $("#modal input[type=text]").attr("readonly", "true");
                      $("#modal").modal("show");
                  }
              });

          }
          // Untuk Tambahkan Data
          else {
              clearModals();
              $("#label").html("Add New User");
              $("#aksi").val("new");
              $('#btn-aksi').html('Save');
              $("#modal").modal("show");


          }
      }

      function clearModals() {
          $('#modal input').removeAttr('readonly', '');
          $('#modal select').removeAttr('disabled', '');
          $('#modal input[type=text]').val('');
          $('#modal select').val('');
          $('#removeWarning').hide();
      }

      function setModalData(res) {

          var list = ['KodeToko', 'NamaToko', 'pic_maintenance'];
          $("#modal input").each(function(index) {
              let name = $(this).attr('name');
              if (list.includes(name)) {
                  $(this).val(res[name]);
              }
          });
          $("#modal select").each(function(index) {
              let name = $(this).attr('name');
              if (list.includes(name)) {
                  $(this).val(res[name]);
              }
          });

      }



      function saveData() {
          var formData = $("#form").serialize();
          $.ajax({
              type: "POST",
              url: "<?= base_url('coverage/crud') ?>",
              dataType: 'html',
              data: formData,
              success: function(res) {
                  window.location.replace('coverage');
              },
              error: function(xhr, textStatus, thrownError) {
                  $("#modal").modal("show");
                  console.log(xhr.responseText);

              }

          })
      }

      function resetPassword(id) {
          swal({
              title: "Are you sure?",
              text: "Apakah anda ingin reset password user dengan NIK : " + id,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn btn-info btn-fill",
              confirmButtonText: "Yes, Reset!",
              cancelButtonClass: "btn btn-danger btn-fill",
              closeOnConfirm: false,
          }, function() {
              $.ajax({
                  type: "POST",
                  url: "<?= base_url('user/reset') ?>",
                  dataType: 'html',
                  data: {
                      username: id
                  },
                  success: function(res) {
                      window.location.replace('user');
                  },
                  error: function(xhr, textStatus, thrownError) {
                      $("#modal").modal("show");
                      console.log(xhr.responseText);

                  }

              })
          });
      }
  </script>