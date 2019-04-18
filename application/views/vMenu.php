                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="col-lg-9">
                        <?= form_error('role_name', '<div class="alert alert-danger" role="alert">', '</div>');
                        echo $this->session->flashdata('message');
                        ?>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" onClick="showModals()">
                            Add New Menu
                        </button>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nama Menu</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Menu Parent</th>
                                    <th scope="col">Urutan</th>

                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tbmenu as $tb) : ?>
                                    <tr>
                                        <td><?= $tb['id'] ?></td>
                                        <td><?= $tb['nama_menu'] ?></td>
                                        <td><?= $tb['link'] ?></td>
                                        <td><span class="<?= $tb['icon'] ?>"></span></td>
                                        <td><?= $tb['menu_parent'] ?></td>
                                        <td><?= $tb['urutan_menu'] ?></td>
                                        <td>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit Role">
                                                <a href="#" onClick="showModals(<?= $tb['id']; ?>)" class="btn btn-warning btn-circle btn-sm">
                                                    <i class="fas fa-fw fa-edit"></i>
                                                </a>
                                            </span>
                                            <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete Role ">
                                                <a href="#" onClick="deleteID(<?= $tb['id']; ?>)" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-fw fa-trash-restore-alt"></i>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.container-fluid -->

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
                                <form id="form">
                                    <input type="hidden" class="form-control" id="aksi" name="aksi">
                                    <input type="hidden" class="form-control" id="key" name="key">
                                    <div class="form-group">
                                        <label for="nama_menu">Nama Menu</label>
                                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="text" class="form-control" id="link" name="link" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="icon">Icon</label>
                                        <input type="text" class="form-control" id="icon" name="icon" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_main_menu">Menu Parent</label>
                                        <select class="form-control" id="is_main_menu" name="is_main_menu">
                                            <option value="0"> - </option>
                                            <?php
                                            $menu = $this->db->get_where('tb_menu', ['is_main_menu' => 0])->result_array();
                                            foreach ($menu as $mn) {
                                                echo '<option value="' . $mn['id'] . '">' . $mn['nama_menu'] . '</option>';
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="urutan_menu">Urutan</label>
                                        <input type="number" class="form-control" id="urutan_menu" name="urutan_menu" required>
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


                <script>
                    function showModals(id) {

                        // Untuk Eksekusi Data Yang Ingin di Edit 
                        if (id) {

                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('menu/crud') ?>",
                                dataType: 'json',
                                data: {
                                    id: id,
                                    aksi: "get"
                                },
                                beforeSend: function() {
                                    clearModals();
                                },
                                success: function(res) {
                                    $("#label").html('Edit Menu');
                                    $("#aksi").val("edit");
                                    $("#key").val(id);
                                    $('#btn-aksi').html('Update');
                                    setModalData(res);
                                    $("#modal").modal("show");
                                }
                            });

                        }
                        // Untuk Tambahkan Data
                        else {
                            clearModals();
                            $("#label").html("Add New Menu");
                            $("#aksi").val("new");
                            $('#btn-aksi').html('Save');
                            $("#modal").modal("show");


                        }
                    }

                    function setModalData(res) {

                        var list = ['nama_menu', 'link', 'urutan_menu', 'icon', 'is_main_menu'];
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

                    function clearModals() {
                        $('#modal input').removeAttr('readonly', '');
                        $('#modal select').removeAttr('disabled', '');
                        $('#modal input[type=text]').val('');
                        $('#modal select').val('');
                        $('#removeWarning').hide();
                    }

                    function saveData() {
                        var formData = $("#form").serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('menu/crud') ?>",
                            dataType: 'html',
                            data: formData,
                            success: function(res) {
                                window.location.replace('menu');
                            },
                            error: function(xhr, textStatus, thrownError) {
                                $("#modal").modal("show");
                                console.log(xhr.responseText);

                            }
                        });
                    }

                    function deleteID(id) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('menu/crud') ?>",
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
                                $("#label").html("Delete Role");
                                $("#aksi").val("delete");
                                setModalData(res);
                                $('#key').val(res.id);
                                $("#modal input").attr("readonly", "true");
                                $("#modal select").attr("disabled", "true");
                                $('#btn-aksi').html('Delete');
                                $("#modal").modal("show");

                            }
                        });
                    }
                </script>