  <!-- Custom styles for this page -->

  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet">


  <div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header pb-0 pt-3">
              <div class="row">
                  <div class="col-lg-6">
                      <h5 class="m-0  text-primary">Total User Active : <?= $this->mUser->get_user_active(); ?> Orang
                          </h4>
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
                          <label class="col-sm-3 control-label" for="username">NIK</label>
                          <input type="text" class="col-sm-8 form-control" id="username" name="username" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="fullname">Nama</label>
                          <input type="text" class="form-control col-sm-8" id="fullname" name="fullname" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="email">Email</label>
                          <input type="email" class="form-control col-sm-8" id="email" name="email" required>
                      </div>
                      <div class="form-group row">
                          <label for="phone" class="col-sm-3 control-label">Phone</label>
                          <input type="number" class="form-control col-sm-6" id="phone" name="phone" required>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="role_id">Role</label>
                          <select class="form-control col-sm-6" id="role_id" name="role_id">
                              <option> - </option>
                              <?php
                                $role = $this->db->get('tb_user_role')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['role_id'] . '">' . $ic['role_name'] . '</option>';
                                }
                                ?>

                          </select>
                      </div>
                      <div class="form-group row">
                          <label class="col-sm-3 control-label" for="is_active">Status</label>
                          <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="">
                              <label class="custom-control-label" for="is_active">Active</label>
                          </div>
                          <div class="ml-4 custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="admin_menu" name="admin_menu" value="">
                              <label class="custom-control-label" for="admin_menu">Admin Menu</label>
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



  <script>
      $.fn.dataTable.ext.buttons.tambah = {
          className: 'buttons-tambah',

          action: function(e, dt, node, config) {
              showModals();
          }
      };
      $(document).ready(function() {
          var table = $('#dataTable').DataTable({
              lengthChange: false,
              dom: '<"row btn-group col-lg-12 "<"col-sm-12 col-md-9"B><"col-sm-12 col-md-3 float-right"f>><"row"rt><"row"<"col-sm-12 col-md-6 float-right"i><"col-sm-12 col-md-6 float-right"p>>',
              buttons: [{
                      extend: 'tambah',
                      text: '<i class="fas fa-fw fa-plus-circle"></i>Tambah'
                  },
                  'copy', 'csv', 'colvis', 'pageLength'
              ],
              responsive: true,
              serverSide: true,
              processing: true,
              lengthMenu: [
                  [25, 50, 100, 1000],
                  ['25 rows', '50 rows', '100 rows', 'Show all']
              ],
              ajax: {
                  "url": "<?php echo base_url() . '/user/get_data_json' ?>",
                  "type": "POST"
              },
              columns: [{
                      "data": "username",
                      "title": "NIK"
                  },
                  {
                      "data": "fullname",
                      "title": "Nama"
                  },
                  {
                      "data": "email",
                      "title": "Email"
                  },
                  {
                      "data": "phone",
                      "title": "Phone"
                  },
                  {
                      "data": "role_name",
                      "title": "Role"
                  },
                  {
                      "data": "admin_menu",
                      "title": "Mod",
                      "className": "text-center",
                      render: function(data, type, row) {
                          if (data === 'Y') {
                              return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"  checked >  <label class="custom-control-label" "></label></div>';
                          } else {
                              return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"  >  <label class="custom-control-label" "></label></div>';
                          }
                          return data;
                      }
                  },
                  {
                      "data": "is_active",
                      "title": "Active",
                      "className": "text-center",
                      render: function(data, type, row) {
                          if (data === 'Y') {
                              return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"  checked >  <label class="custom-control-label" ></label></div>';
                          } else {
                              return '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input"  >  <label class="custom-control-label" ></label></div>';
                          }
                          return data;
                      }
                  },
                  {
                      "data": "view",
                      "title": "Options",
                      "orderable": false
                  }
              ]
          });
          $("#modal input[type=checkbox]").change(function() {
              if ($(this).prop("checked")) {
                  $(this).val("Y");
              } else {
                  $(this).val("N");

              }
          });
      }); //domready

      function showModals(id) {

          // Untuk Eksekusi Data Yang Ingin di Edit 
          if (id) {

              $.ajax({
                  type: "POST",
                  url: "<?= base_url('user/crud') ?>",
                  dataType: 'json',
                  data: {
                      id: id,
                      aksi: "get"
                  },
                  beforeSend: function() {
                      clearModals();
                  },
                  success: function(res) {
                      $("#label").html('Edit User');
                      $("#aksi").val("edit");
                      $("#key").val(id);
                      $('#btn-aksi').html('Update');
                      $('#btn-aksi').addClass('btn-warning');
                      setModalData(res);
                      if (res.is_active == "Y") {
                          $("#is_active").attr("checked", true);
                      }
                      if (res.admin_menu == "Y") {
                          $("#admin_menu").attr("checked", true);
                      }
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
              $('#btn-aksi').addClass('btn-success');
              $("#modal").modal("show");


          }
      }

      function clearModals() {
          $('#modal input').removeAttr('readonly', '');
          $('#modal input[type=checkbox]').removeAttr('checked', '');
          $('#modal select').removeAttr('disabled', '');
          $('#modal input[type=text]').val('');
          $('#modal input[type=email]').val('');
          $('#modal input[type=number]').val('');
          $('#modal input[type=checkbox]').val('');
          $('#btn-aksi').removeClass('btn-warning');
          $('#btn-aksi').removeClass('btn-danger');
          $('#modal select').val('');
          $('#removeWarning').hide();
      }

      function setModalData(res) {

          var list = ['username', 'fullname', 'email', 'phone', 'role_id', 'is_active', 'admin_menu'];
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

      function deleteID(id) {
          $.ajax({
              type: "POST",
              url: "<?= base_url('user/crud') ?>",
              dataType: 'json',
              data: {
                  id: id,
                  aksi: "get"
              },
              beforeSend: function() {
                  clearModals();
              },
              success: function(res) {
                  $("#removeWarning").show();
                  $("#label").html("Delete User");
                  $("#aksi").val("delete");
                  setModalData(res);
                  $('#key').val(res.username);
                  $("#modal input").attr("readonly", "true");
                  $("#modal select").attr("disabled", "true");
                  $('#btn-aksi').html('Delete');
                  $('#btn-aksi').addClass('btn-danger');
                  $("#modal").modal("show");

              }
          });
      }

      function saveData() {
          var formData = $("#form").serialize();
          $.ajax({
              type: "POST",
              url: "<?= base_url('user/crud') ?>",
              dataType: 'html',
              data: formData,
              success: function(res) {
                  window.location.replace('user');
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