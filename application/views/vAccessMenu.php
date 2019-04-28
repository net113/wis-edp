<div class="container-fluid">
    <div class="col-lg-7">
        <?= $this->session->flashdata('message'); ?>
        <div class="row">
            <div class="col-lg-10">
                <?php

                $role_id = $user_role['role_id'];

                echo '<h4>Akses menu untuk : ' . $user_role['role_name'] . '</h4>';
                ?>
            </div>
            <div class="col-lg-2 mb-2">
                <a href="<?= base_url('userRole'); ?>" class="btn btn-primary float-right">Back</a>
            </div>
        </div>


        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Menu Name</th>
                    <th scope="col">Access</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($tbmenu as $menu) : ?>
                    <tr>
                        <td><?= $i; ?></td>
                        <td><?= $menu['nama_menu'] ?></td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" <?= cekAkses($role_id, $menu['id']); ?> data-role="<?= $role_id ?>" data-menu="<?= $menu['id'] ?>">

                            </div>
                        </td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $('.form-check-input').on('click', function() {
        let idMenu = $(this).data('menu');
        let idRole = $(this).data('role');
        $.ajax({
            type: "POST",
            url: "<?= base_url('userRole/changeAccess') ?>",
            dataType: "json",
            data: {
                idMenu: idMenu,
                idRole: idRole
            },
            success: function(res) {
                // document.location.href = "<?= base_url('userRole/accessMenu/') ?>" + idRole;

                swal({
                    title: res.tipe.toUpperCase(),
                    text: res.data,
                    timer: 2500,
                    type: res.tipe
                });
            }

        });
    });
</script>