<div class="container-fluid">
    <?php if ($this->session->flashdata('error_msg')) : ?>
    <div class="alert alert-danger">
        <?= $this->session->flashdata('error_msg'); ?>
    </div>
    <?php endif; ?>


    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Data Karya Anda</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('karyaku') ?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Karya Anda</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" enctype="multipart/form-data"
                action="<?= base_url('karyaku/edit/' . $karya->uuid); ?>">
                <input type="hidden" name="uuid" value="<?= $karya->uuid; ?>">

                <!-- Judul -->
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Judul <span class="text-danger">*</span></label>
                        <input type="text" name="judul" id="judul" class="form-control" placeholder="Masukkan Judul"
                            value="<?= set_value('judul', $karya->judul); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('judul')) ? 'd-block' : ''; ?>">
                            <?= form_error('judul') ?>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                            placeholder="Masukkan Deskripsi" value="<?= set_value('deskripsi', $karya->deskripsi); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('deskripsi')) ? 'd-block' : ''; ?>">
                            <?= form_error('deskripsi') ?>
                        </div>
                    </div>
                </div>

                <!-- Jenis Karya -->
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Jenis Karya <span
                                class="text-danger">*</span></label>
                        <div class="d-flex">
                            <div class="form-check mr-3">
                                <input class="form-check-input" type="radio" name="tipe_upload" id="tipe_file" value="1"
                                    <?= set_radio('tipe_upload', '1', $karya->tipe_upload == 1); ?>>
                                <label class="form-check-label" for="tipe_file">Upload File</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tipe_upload" id="tipe_link" value="2"
                                    <?= set_radio('tipe_upload', '2', $karya->tipe_upload == 2); ?>>
                                <label class="form-check-label" for="tipe_link">Sematkan Link</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload File -->
                <div class="form-group row <?= ($karya->tipe_upload == 2) ? 'd-none' : ''; ?>" id="uploadFileGroup">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Upload File
                            <?= ($karya->tipe_upload == 1) ? '<span class="text-danger">*</span>' : ''; ?></label>
                        <?php if (!empty($karya->berkas)): ?>
                        <p class="mb-2">
                            <small>File saat ini:
                                <a href="<?= base_url('uploads/karya/' . $karya->berkas); ?>" target="_blank">
                                    <?= htmlspecialchars($karya->berkas, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </small>
                        </p>
                        <?php endif; ?>
                        <input type="file" name="berkas" id="berkas" class="form-control">
                        <small class="form-text text-muted">Format: PDF, DOCX, PPTX, MP4. Max 50MB</small>
                        <div class="invalid-feedback <?= !empty(form_error('berkas')) ? 'd-block' : ''; ?>">
                            <?= form_error('berkas') ?>
                        </div>
                    </div>
                </div>

                <!-- Sematkan Link -->
                <div class="form-group row <?= ($karya->tipe_upload == 1) ? 'd-none' : ''; ?>" id="uploadLinkGroup">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Link Karya <span class="text-danger">*</span></label>
                        <input type="url" name="link" id="link" class="form-control"
                            placeholder="https://contoh.com/karya" value="<?= set_value('link', $karya->link); ?>">
                        <small class="form-text text-muted">Masukkan link ke karya online (misalnya YouTube, Google
                            Drive, dsb)</small>
                        <div class="invalid-feedback <?= !empty(form_error('link')) ? 'd-block' : ''; ?>">
                            <?= form_error('link') ?>
                        </div>
                    </div>
                </div>

                <!-- Tombol -->
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="<?= base_url('karyaku'); ?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('input[name="tipe_upload"]').change(function() {
        if ($(this).val() === '1') {
            $('#uploadFileGroup').removeClass('d-none');
            $('#uploadLinkGroup').addClass('d-none');
            $('#link').val('');
        } else {
            $('#uploadFileGroup').addClass('d-none');
            $('#uploadLinkGroup').removeClass('d-none');
            $('#berkas').val('');
        }
    });
});
</script>