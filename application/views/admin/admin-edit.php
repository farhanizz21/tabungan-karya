<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Data Admin</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('admin')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Admin</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" action="<?= base_url('admin/edit/'.$admin->uuid);?>">
                <input type="hidden" name="uuid" value="<?= $admin->uuid ?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Nama Lengkap<span
                                class="text-danger">*</span></label>
                        <input type="text" name="namaLengkap" id="namaLengkap" class="form-control"
                            placeholder="Masukkan Nama Lengkap" value="<?= $admin->nama; ?>">
                        <div class="invalid-feedback <?= !empty(form_error('namaLengkap')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('namaLengkap') ?>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Username<span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control"
                            placeholder="Masukkan Username" value="<?= $admin->username; ?>">
                        <div class="invalid-feedback <?= !empty(form_error('username')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('username') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Jenis Kelamin<span
                                class="text-danger">*</span></label>
                        <select class="form-control" name="jenisKelamin">
                            <option disabled selected>Pilih Jenis Kelamin</option>
                            <option value="1" <?= $admin->jenis_kelamin==1?'selected':'';?>>Laki-Laki</option>
                            <option value="2" <?= $admin->jenis_kelamin==2?'selected':'';?>>Perempuan</option>
                        </select>
                        <div class="invalid-feedback <?= !empty(form_error('jenisKelamin')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('jenisKelamin') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('admin')?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
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