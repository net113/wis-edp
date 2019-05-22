$.fn.dataTable.ext.buttons.tambah = {
  className: "buttons-tambah admin-menu",

  action: function(e, dt, node, config) {
    showModals();
  }
};
$(document).ready(function() {
  var table = $("#dataTable").DataTable({
    lengthChange: false,
    dom:
      '<"row btn-group col-lg-12 "<"col-sm-12 col-md-9"B><"col-sm-12 col-md-3 float-right"f>><"row"rt><"row"<"col-sm-12 col-md-6 float-right"i><"col-sm-12 col-md-6 float-right"p>>',
    buttons: [
      {
        extend: "tambah",
        text: '<i class="fas fa-fw fa-plus-circle"></i>Tambah'
      },
      "copy",
      "csv",
      "colvis",
      "pageLength"
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
      ["25 rows", "50 rows", "100 rows", "Show all"]
    ],
    ajax: {
      url: window.location.pathname + "/get_data_json",
      type: "POST"
    },
    columns: [
      {
        data: "KodeToko",
        title: "KDTK"
      },
      {
        data: "NamaToko",
        title: "Nama"
      },
      {
        data: "id_pel",
        title: "ID PELANGGAN"
      },
      {
        data: "pass",
        title: "PASS PPOE"
      },

      {
        data: "tanggal",
        title: "TGL AKTIF"
      },
      {
        data: "stat",
        title: "STATUS"
      },

      {
        data: "view",
        title: "Options",
        className: "text-center admin-menu",
        orderable: false
      }
    ]
  });

  $("#modal input[type=checkbox]").change(function() {
    if (this.checked) {
      $(this).val("Y");
    } else {
      $(this).val("N");
    }
  });

  $(".datalist").blur(function() {
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
      url: window.location.pathname + "/crud",
      dataType: "json",
      data: {
        id: id,
        aksi: "get"
      },
      beforeSend: function() {
        clearModals();
      },
      success: function(res) {
        $("#label").html("Edit Toko");
        $("#aksi").val("edit");
        $("#key").val(id);
        $("#btn-aksi").html("Update");
        $("#btn-aksi").addClass("btn-warning");
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
    $("#btn-aksi").html("Save");
    $("#btn-aksi").addClass("btn-success");
    $("#modal").modal("show");
  }
}

function clearModals() {
  $("#modal input").removeAttr("readonly", "");
  $("#modal input[type=checkbox]").removeAttr("checked", "");
  $("#modal select").removeAttr("disabled", "");
  $("#modal input").val("");
  $("#btn-aksi").removeClass("btn-warning");
  $("#btn-aksi").removeClass("btn-danger");
  $("#modal select").val("");
  $("#removeWarning").hide();
}

function setModalData(res) {
  var list = ["KodeToko", "NamaToko", "id_pel", "pass", "tanggal", "stat"];
  $("#modal input").each(function(index) {
    let name = $(this).attr("name");
    if (list.includes(name)) {
      $(this).val(res[name]);
    }
  });
  $("#modal select").each(function(index) {
    let name = $(this).attr("name");
    if (list.includes(name)) {
      $(this).val(res[name]);
    }
  });
}

function deleteID(id) {
  $.ajax({
    type: "POST",
    url: window.location.pathname + "/crud",
    dataType: "json",
    data: {
      id: id,
      aksi: "get"
    },
    beforeSend: function() {
      clearModals();
    },
    success: function(res) {
      $("#removeWarning").html(
        '<span class="fas fa-fw fa-exclamation-circle" ></span> Are You Sure???'
      );
      $("#removeWarning").show();
      $("#label").html("Delete Toko");
      $("#aksi").val("delete");
      setModalData(res);
      $("#key").val(res.KodeToko);
      $("#modal input").attr("readonly", "true");
      $("#modal select").attr("disabled", "true");
      $("#btn-aksi").html("Delete");
      $("#btn-aksi").addClass("btn-danger");
      $("#modal").modal("show");
    }
  });
}

function saveData() {
  let kekurangan = 0;
  $("#form input[required]").each(function() {
    if ($(this).val() == "") {
      $("#removeWarning").html(
        '<span class="fas fa-fw fa-exclamation-circle" ></span> Harap isi field : ' +
          $(this).attr("name")
      );
      $("#removeWarning").show();
      kekurangan += 1;
    }
  });
  if (kekurangan == 0) {
    var formData = $("#form").serialize();
    $.ajax({
      type: "POST",
      url: window.location.pathname + "/crud",
      dataType: "json",
      data: formData,
      success: function(res) {
        $("#modal").modal("hide");
        swal({
          title: res.tipe.toUpperCase(),
          text: res.data,
          timer: 2500,
          type: res.tipe
        });
        $("#dataTable")
          .DataTable()
          .ajax.reload();
      },
      error: function(xhr, textStatus, thrownError) {
        $("#modal").modal("show");
        swal({
          title: "FAILED",
          text: xhr.responseText,
          type: "error"
        });
      }
    });
  }
}
