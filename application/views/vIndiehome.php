  <!-- Custom styles for this page -->

  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="<?= base_url('assets/'); ?>vendor/datatables/css/buttons.bootstrap4.min.css" rel="stylesheet">


  <div class="container-fluid">

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header pb-0 pt-3">
              <div class="row">
                  <div class="col-lg-6">
                      <h5 class="m-0  text-primary">List Toko Indiehome Cabang Bogor 1 G113</h5>
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
                          <input list="list_kdtk" value="" class="datalist mr-1 col-sm-3 custom-select " id="KodeToko" name="KodeToko" required placeholder="KDTK">
                          <datalist id="list_kdtk">
                              <?php
                                $role = $this->db->get('tb_toko')->result_array();
                                foreach ($role as $ic) {
                                    echo '<option value="' . $ic['KodeToko'] . '" data-nama="' . $ic['NamaToko'] . '"> ' . $ic['KodeToko'] . ' - ' . $ic['NamaToko'] . '</option>';
                                }
                                ?>
                          </datalist>
                          <input type="text" class="col-sm-5 form-control" id="NamaToko" name="NamaToko" placeholder="NAMA" required>
                      </div>

                      <div class="form-group row">
                          <label for="id_pel" class="col-sm-3 control-label">ID PELANGGAN</label>
                          <input type="text" class="form-control col-sm-6" id="id_pel" name="id_pel" required>
                      </div>
                      <div class="form-group row">
                          <label for="pass" class="col-sm-3 control-label">PASS PPOE</label>
                          <input type="text" class="form-control col-sm-6" id="pass" name="pass" required>
                      </div>
                      <div class="form-group row">
                          <label for="tanggal" class="col-sm-3 control-label">TGL AKTIF</label>
                          <input type="date" class="form-control col-sm-6" data-date-format="DD MMMM YYYY" id="tanggal" name="tanggal" required>
                      </div>
                      <div class="form-group row">
                          <label for="stat" class="col-sm-3 control-label">STATUS</label>
                          <select type="text" class="form-control col-sm-6 custom-select" id="stat" name="stat" required>
                              <option value="Online">Online</option>
                              <option value="BASO">BASO</option>
                              <option value="Suspend">Suspend</option>
                              <option value="Kendala">Kendala</option>
                          </select>
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
          className: 'buttons-tambah admin-menu',

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
              responsive: true,
              serverSide: true,
              processing: true,
              lengthMenu: [
                  [25, 50, 100, 1000],
                  ['25 rows', '50 rows', '100 rows', 'Show all']
              ],
              ajax: {
                  "url": "<?php echo base_url() . '/indiehome/get_data_json' ?>",
                  "type": "POST"
              },
              columns: [{
                      "data": "KodeToko",
                      "title": "KDTK"
                  },
                  {
                      "data": "NamaToko",
                      "title": "Nama"
                  },
                  {
                      "data": "id_pel",
                      "title": "ID PELANGGAN"
                  },
                  {
                      "data": "pass",
                      "title": "PASS PPOE"
                  },

                  {
                      "data": "tanggal",
                      "title": "TGL AKTIF"
                  },
                  {
                      "data": "stat",
                      "title": "STATUS"
                  },

                  {
                      "data": "view",
                      "title": "Options",
                      "className": "text-center admin-menu",
                      "orderable": false
                  }
              ]
          });

          $("#modal input[type=checkbox]").change(function() {
              if (this.checked) {
                  $(this).val('Y');

              } else {
                  $(this).val('N');

              }
          });

          $('.datalist').blur(function() {
              let val = $(this).val();
              let list = $(this).attr("list");
              let cek = $("#" + list).find("option[value='" + val + "']");

              if (cek != null && cek.length == 0) {
                  $(this).val("");
                  $(this).focus();
              }
          });

          $("#KodeToko").change(function() {
              if ($(this).val() != "") {
                  getnama = $("#list_kdtk").find("option[value='" + $(this).val() + "']");
                  $("#NamaToko").val(getnama.attr("data-nama"));
              }
          });

      }); //domready

      function showModals(id) {

          // Untuk Eksekusi Data Yang Ingin di Edit 
          if (id) {

              $.ajax({
                  type: "POST",
                  url: "<?= base_url('indiehome/crud') ?>",
                  dataType: 'json',
                  data: {
                      id: id,
                      aksi: "get"
                  },
                  beforeSend: function() {
                      clearModals();
                  },
                  success: function(res) {
                      $("#label").html('Edit Toko');
                      $("#aksi").val("edit");
                      $("#key").val(id);
                      $('#btn-aksi').html('Update');
                      $('#btn-aksi').addClass('btn-warning');
                      setModalData(res);
                      $("#KodeToko, #NamaToko").attr("readonly", true);
                      $("#modal").modal("show");
                  }
              });

          }
          // Untuk Tambahkan Data
          else {
              clearModals();
              $("#NamaToko").attr("readonly", true);
              $("#label").html("Add New Toko");
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
          $('#modal input').val('');
          $('#btn-aksi').removeClass('btn-warning');
          $('#btn-aksi').removeClass('btn-danger');
          $('#modal select').val('');
          $('#removeWarning').hide();
      }

      function setModalData(res) {

          var list = ['KodeToko', 'NamaToko', 'id_pel', 'pass', 'tanggal', 'stat'];
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
              url: "<?= base_url('indiehome/crud') ?>",
              dataType: 'json',
              data: {
                  id: id,
                  aksi: "get"
              },
              beforeSend: function() {
                  clearModals();
              },
              success: function(res) {
                  $("#removeWarning").html('<span class="fas fa-fw fa-exclamation-circle" ></span> Are You Sure???');
                  $("#removeWarning").show();
                  $("#label").html("Delete Toko");
                  $("#aksi").val("delete");
                  setModalData(res);
                  $('#key').val(res.KodeToko);
                  $("#modal input").attr("readonly", "true");
                  $("#modal select").attr("disabled", "true");
                  $('#btn-aksi').html('Delete');
                  $('#btn-aksi').addClass('btn-danger');
                  $("#modal").modal("show");

              }
          });
      }

      function saveData() {
          let kekurangan = 0;
          $("#form input[required]").each(function() {
              if ($(this).val() == "") {
                  $("#removeWarning").html('<span class="fas fa-fw fa-exclamation-circle" ></span> Harap isi field : ' + $(this).attr("name"));
                  $("#removeWarning").show();
                  kekurangan += 1;
              }
          });
          if (kekurangan == 0) {
              var formData = $("#form").serialize();
              $.ajax({
                  type: "POST",
                  url: "<?= base_url('indiehome/crud') ?>",
                  dataType: 'json',
                  data: formData,
                  success: function(res) {
                      $("#modal").modal("hide");
                      swal({
                          title: res.tipe.toUpperCase(),
                          text: res.data,
                          timer: 2500,
                          type: res.tipe
                      });
                      $('#dataTable').DataTable().ajax.reload();
                  },
                  error: function(xhr, textStatus, thrownError) {
                      $("#modal").modal("show");
                      swal({
                          title: "FAILED",
                          text: xhr.responseText,
                          type: "error"
                      });

                  }

              })
          }

      }
  </script>