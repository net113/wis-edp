                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="col-lg-6">
                        <?= form_error('role_name', '<div class="alert alert-danger" role="alert">', '</div>');
                        echo $this->session->flashdata('message');
                        ?>

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary mb-3" onClick="showModals()">
                            Add New Role
                        </button>


                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ID Role</th>
                                    <th scope="col">Role Name</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tbrole as $tb) : ?>
                                <tr>
                                    <td><?= $tb['role_id'] ?></td>
                                    <td><?= $tb['role_name'] ?></td>
                                    <td>
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Give Acces to Menu">
                                            <a href="<?= base_url('userRole/accessMenu/' . $tb['role_id']); ?>" class="btn btn-success btn-circle btn-sm">
                                                <i class="fas fa-fw fa-check"></i>
                                            </a>
                                        </span>
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Edit Role">
                                            <a href="#" onClick="showModals(<?= $tb['role_id']; ?>)" class="btn btn-warning btn-circle btn-sm">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                        </span>
                                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="Delete Role ">
                                            <a href="#" onClick="deleteID(<?= $tb['role_id']; ?>)" class="btn btn-danger btn-circle btn-sm">
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
                <div class="modal fade" id="modalRole" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="label">Add New Role</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger" role="alert" id="removeWarning">
                                    <span class="fa fa-warning fa-2x" aria-hidden="true"></span>
                                    <span class="sr-only">Error:</span>
                                    Are you sure ??
                                </div>
                                <form id="formRole">
                                    <input type="hidden" class="form-control" id="aksi" name="aksi">
                                    <input type="hidden" class="form-control" id="key" name="key">
                                    <div class="form-group">
                                        <label for="role_name">Role Name</label>
                                        <input type="text" class="form-control" id="role_name" name="role_name" placeholder="Enter Role Name" required>
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
                    function showModals(role_id) {

                        // Untuk Eksekusi Data Yang Ingin di Edit 
                        if (role_id) {

                            $.ajax({
                                type: "POST",
                                url: "<?= base_url('userRole/crud') ?>",
                                dataType: 'json',
                                data: {
                                    role_id: role_id,
                                    aksi: "get"
                                },
                                beforeSend: function() {
                                    clearModals();
                                },
                                success: function(res) {
                                    $("#label").html('Edit Role');
                                    $("#aksi").val("edit");
                                    $("#key").val(role_id);
                                    $('#btn-aksi').html('Update');
                                    $('#role_name').val(res.role_name);
                                    $("#modalRole").modal("show");
                                }
                            });

                        }
                        // Untuk Tambahkan Data
                        else {
                            clearModals();
                            $("#label").html("Add New Role");
                            $("#aksi").val("new");
                            $('#btn-aksi').html('Save');
                            $("#modalRole").modal("show");


                        }
                    }

                    function clearModals() {
                        $('#modalRole input').removeAttr('readonly', '');
                        $('#modalRole input[type=text]').val('');
                        $('#removeWarning').hide();
                    }

                    function saveData() {
                        var formData = $("#formRole").serialize();
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('userRole/crud') ?>",
                            dataType: 'html',
                            data: formData,
                            success: function(res) {
                                window.location.replace('userRole');
                            },
                            error: function(xhr, textStatus, thrownError) {
                                console.log(xhr.responseText);

                            }
                        });
                    }

                    function deleteID(role_id) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('userRole/crud') ?>",
                            dataType: 'json',
                            data: {
                                role_id: role_id,
                                aksi: "get"
                            },
                            beforeSend: function() {
                                clearModals();
                            },
                            success: function(res) {
                                $("#removeWarning").show();
                                $("#label").html("Delete Role");
                                $("#aksi").val("delete");
                                $('#role_name').val(res.role_name);
                                $('#key').val(res.role_id);
                                $("#role_name").attr("readonly", "true");
                                $('#btn-aksi').html('Delete');
                                $("#modalRole").modal("show");

                            }
                        });
                    }
                </script> 