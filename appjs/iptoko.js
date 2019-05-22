$.fn.dataTable.ext.buttons.download = {
  className: "admin-menu",

  action: function(e, dt, node, config) {
    downloadCSV();
  }
};
$(document).ready(function() {
  var table = $("#dataTable").DataTable({
    lengthChange: false,
    dom:
      '<"row btn-group col-lg-12 "<"col-sm-12 col-md-9"B><"col-sm-12 col-md-3 float-right"f>><"row"rt><"row"<"col-sm-12 col-md-6 float-right"i><"col-sm-12 col-md-6 float-right"p>>',
    buttons: [
      "copy",
      "pageLength",
      {
        extend: "download",
        text: '<i class="fas fa-fw fa-download"></i> Download Master'
      }
    ],
    responsive: true,
    serverSide: true,
    processing: true,
    lengthMenu: [
      [25, 50, 100, 1000],
      ["25 rows", "50 rows", "100 rows", "Show all"]
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
        data: "tipe_koneksi_primary",
        title: "KONEKSI"
      },
      {
        data: "ip_router",
        title: "IP Utama"
      },
      {
        data: "ip_induk",
        title: "IP Induk"
      },
      {
        data: "ip_anak1",
        title: "IP Anak"
      },
      {
        data: "ip_ikios",
        title: "IP Ikios"
      },
      {
        data: "ip_stb",
        title: "IP STB"
      },
      {
        data: "ip_router_edc",
        title: "IP RB Wifi"
      },
      {
        data: "view",
        title: "Options",
        className: "text-center",
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
  $("#dataTable").css("cursor", "pointer");
  $("#dataTable").on("click", "td", function() {
    let cek = $(this).text();
    if (cek.includes("10.")) {
      copyToClipboard(this);
      swal({
        //title: res.tipe.toUpperCase(),
        text: "Success copying " + $(this).text(),
        timer: 1000,
        type: "success"
      });
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
        $("#btn-aksi")
          .addClass("btn-warning")
          .show();
        setModalData(res);
        $("#KodeToko").attr("readonly", true);
        $("#NamaToko").attr("readonly", true);
        $("#modal").modal("show");
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
  // Untuk Tambahkan Data
  else {
    clearModals();
    $("#label").html("Add New Toko");
    $("#aksi").val("new");
    $("#btn-aksi").html("Save");
    $("#btn-aksi").addClass("btn-success");
    $("#modal").modal("show");
  }
}

function viewModals(id) {
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
        $("#label").html("Detail Toko");
        $("#aksi").val("edit");
        $("#key").val(id);
        $("#btn-aksi").hide();
        setModalData(res);
        $("#KodeToko").attr("readonly", true);
        $("#NamaToko").attr("readonly", true);
        $("#modal").modal("show");
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

function copyToClipboard(element) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(element).text()).select();
  document.execCommand("copy");
  $temp.remove();
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
  var list = [
    "KodeToko",
    "NamaToko",
    "tipe_koneksi_primary",
    "tipe_koneksi_secondary",
    "ip_router",
    "ip_backup",
    "ip_induk",
    "ip_anak1",
    "ip_apka",
    "ip_ikios",
    "ip_stb",
    "ip_router_edc",
    "ip_anak2",
    "ip_anak3",
    "ip_anak4",
    "ip_anak5",
    "ip_anak6",
    "ip_anak7",
    "ip_pointcafe",
    "ip_telemetri"
  ];
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
      $("#removeWarning").show();
      $("#label").html("Delete Toko");
      $("#aksi").val("delete");
      setModalData(res);
      $("#key").val(res.KodeToko);
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

function downloadCSV() {
  window.open(window.location.pathname + "/downloadmaster", "_blank");
}
