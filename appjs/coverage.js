$(document).ready(function() {
  var table = $("#dataTable").DataTable({
    lengthChange: false,
    dom:
      '<"row btn-group col-lg-12 "<"col-sm-12 col-md-9"B><"col-sm-12 col-md-3 float-right"f>><"row"rt><"row"<"col-sm-12 col-md-6 float-right"i><"col-sm-12 col-md-6 float-right"p>>',
    buttons: ["copy", "csv", "colvis", "pageLength"],
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
        title: "Nama Toko"
      },
      {
        data: "pic_maintenance",
        title: "NIK"
      },
      {
        data: "personil",
        title: "Personil"
      },
      {
        data: "view",
        title: "Options",
        orderable: false,
        className: "text-center admin-menu"
      }
    ]
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
        $("#label").html("Edit Coverage");
        $("#aksi").val("edit");
        $("#key").val(id);
        $("#btn-aksi").html("Update");
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
    $("#btn-aksi").html("Save");
    $("#modal").modal("show");
  }
}

function clearModals() {
  $("#modal input").removeAttr("readonly", "");
  $("#modal select").removeAttr("disabled", "");
  $("#modal input[type=text]").val("");
  $("#modal select").val("");
  $("#removeWarning").hide();
}

function setModalData(res) {
  var list = ["KodeToko", "NamaToko", "pic_maintenance"];
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

function saveData() {
  var formData = $("#form").serialize();
  $.ajax({
    type: "POST",
    url: window.location.pathname + "/crud",
    dataType: "html",
    data: formData,
    success: function(res) {
      window.location.replace("coverage");
    },
    error: function(xhr, textStatus, thrownError) {
      $("#modal").modal("show");
      console.log(xhr.responseText);
    }
  });
}
