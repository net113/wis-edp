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
                  if ($("#mod_menu").val() != "Y") {
                      $(".admin-menu").hide();
                  }
              },
              fnDrawCallback: function() {
                  if ($("#mod_menu").val() != "Y") {
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
                  "url": "<?php echo base_url() . '/toko/get_data_json' ?>",
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
                      "data": "tipe_koneksi_primary",
                      "title": "Koneksi"
                  },
                  {
                      "data": "tipe_koneksi_secondary",
                      "title": "Backup"
                  },
                  {
                      "data": "NoTelpToko",
                      "title": "Telp"
                  },
                  {
                      "data": "aspv",
                      "title": "AS"
                  },
                  {
                      "data": "amgr",
                      "title": "AM"
                  },
                  {
                      "data": "TypeToko24",
                      "title": "Toko 24",
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
                      "data": "TokoApka",
                      "title": "Apka",
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
                      "data": "isIkiosk",
                      "title": "Ikiosk",
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

      }); //domready

      function showModals(id) {

          // Untuk Eksekusi Data Yang Ingin di Edit 
          if (id) {

              $.ajax({
                  type: "POST",
                  url: "<?= base_url('toko/crud') ?>",
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
                      if (res.TypeToko24 == "Y") {
                          $("#TypeToko24").attr("checked", true);
                      }
                      if (res.TokoApka == "Y") {
                          $("#TokoApka").attr("checked", true);
                      }
                      if (res.isIkiosk == "Y") {
                          $("#isIkiosk").attr("checked", true);
                      }
                      $("#modal").modal("show");
                  }
              });

          }
          // Untuk Tambahkan Data
          else {
              clearModals();
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

          var list = ['KodeToko', 'NamaToko', 'tipe_koneksi_primary', 'tipe_koneksi_secondary', 'NoTelpToko', 'aspv', 'amgr', 'TypeToko24', 'TokoApka', 'isIkiosk'];
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
              url: "<?= base_url('toko/crud') ?>",
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
                  if (res.TypeToko24 == "Y") {
                      $("#TypeToko24").attr("checked", true);
                  }
                  if (res.TokoApka == "Y") {
                      $("#TokoApka").attr("checked", true);
                  }
                  if (res.isIkiosk == "Y") {
                      $("#isIkiosk").attr("checked", true);
                  }
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
                  url: "<?= base_url('toko/crud') ?>",
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