<div class="container-fluid">

    <?php if ($this->session->userdata('success_msg')): ?>
    <div class="alert alert-success">
        <?= $this->session->userdata('success_msg'); ?>
        <?php $this->session->unset_userdata('success_msg'); ?>
        <!-- Hapus setelah ditampilkan -->
    </div>
    <?php endif; ?>

    <?php if ($this->session->userdata('error_msg')): ?>
    <div class="alert alert-danger">
        <?= $this->session->userdata('error_msg'); ?>
        <?php $this->session->unset_userdata('error_msg'); ?>
        <!-- Hapus setelah ditampilkan -->
    </div>
    <?php endif; ?>


    <br>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"></h1>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Reset Password</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" action="<?= base_url('guru/reset-password/' . $guru->uuid); ?>">
                <input type="hidden" name="uuid" value="<?= $guru->uuid ?>">

                <!-- Input Password Baru -->
                <div class="form-group">
                    <label for="password" class="font-weight-bold">Password Baru <span
                            class="text-danger">*</span></label>
                    <input type="password"
                        class="form-control form-control-user <?= form_error('password') ? 'is-invalid' : ''; ?>"
                        name="password" id="password" placeholder="Masukkan password baru"
                        value="<?= set_value('password'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('password'); ?>
                    </div>
                </div>

                <!-- Input Konfirmasi Password -->
                <div class="form-group">
                    <label for="password_confirm" class="font-weight-bold">Ulangi Password <span
                            class="text-danger">*</span></label>
                    <input type="password"
                        class="form-control form-control-user <?= form_error('password_confirm') ? 'is-invalid' : ''; ?>"
                        name="password_confirm" id="password_confirm" placeholder="Ulangi password baru"
                        value="<?= set_value('password_confirm'); ?>">
                    <div class="invalid-feedback">
                        <?= form_error('password_confirm'); ?>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-success btn-user btn-block">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <!-- <a href="<?= base_url('guru'); ?>" class="btn btn-danger btn-user btn-block">
                        <i class="fa fa-times"></i> Batal
                    </a> -->
                </div>
            </form>

        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function() {
    $('.multiple-table').select2({
        placeholder: "Pilih Mata Pelajaran",
        allowClear: true
    });

    $("#namaLengkap").change(function() {
        var namaLengkap = $(this).val().toLowerCase();
        var username = namaLengkap.replace(/\s+/g, '.');
        $('#username').val(username);
    });
});
</script>