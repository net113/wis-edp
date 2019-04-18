<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Page Heading -->

    <div class="card col-lg-7">
        <?php echo $this->session->flashdata('message'); ?>
        <?= form_open_multipart('profile'); ?>
        <div class="form-group row mt-4">
            <label class="col-sm-3 control-label" for="username">NIK</label>
            <input type="text" class="col-sm-6 form-control" id="username" name="username" readonly value="<?= $user['username']; ?>">
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="fullname">Nama</label>
            <input type="text" class="form-control col-sm-8" id="fullname" name="fullname" required value="<?= $user['fullname']; ?>">
        </div>
        <div class="form-group row">
            <label class="col-sm-3 control-label" for="email">Email</label>
            <input type="email" class="form-control col-sm-8" id="email" name="email" required value="<?= $user['email']; ?>">
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-3 control-label">Phone</label>
            <input type="number" class="form-control col-sm-6" id="phone" name="phone" required value="<?= $user['phone']; ?>">
        </div>
        <div class="form-group row">
            <div class="col-sm-3">
                <label for="pict_profile" class=" control-label">Pict Profile</label>
            </div>
            <div class="col-sm-9 row">
                <div class="col-sm-3 pl-0">
                    <img src="<?= base_url('assets/img/profile/') . $user['pict_profile']; ?>" class="  img-thumbnail">
                </div>
                <div class="col-sm-9">
                    <input type="file" id="pict_profile" name="pict_profile">
                </div>
            </div>
        </div>


        <div class="row justify-content-end mb-3">
            <div class="col-lg-9 px-0">
                <button type="submit" class="btn btn-primary" id="btn-aksi" onClick="saveData()">Save changes</button>
            </div>
        </div>
        </form>
    </div>


</div>
<!-- /.container-fluid --> 