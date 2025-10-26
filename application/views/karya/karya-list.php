<!-- Begin Page Content -->
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Daftar Karya</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('karya')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Guru</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Karya Guru</li>
        </ol>
    </nav>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <span class="text-muted d-block">
                Dibuat oleh: <strong><?= $guru_nama; ?></strong><br>
                Total karya: <strong><?= $total_karya; ?></strong>
            </span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1%">No.</th>
                            <th width="15%">Nama Karya</th>
                            <th width="40%">Deskripsi</th>
                            <th width="15%">File</th>
                            <th width="15%">Update Terakhir</th>
                            <th width="4%">Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($karya_guru as $row): ?>
                        <tr>
                            <td align="center">
                                <?= $no++; ?>
                            </td>
                            <td>
                                <?= $row->judul; ?>
                            </td>
                            <td>
                                <?php if ($row->deskripsi != NULL): ?>
                                <div class="scroll-deskripsi">
                                    <?=$row->deskripsi;?>
                                </div>
                                <?php else: ?>
                                <span class="text-muted"><i>Tidak ada deskripsi</i></span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <?php if ($row->tipe_upload === '1' && !empty($row->berkas)): ?>
                                <a href="<?= base_url('uploads/karya/' . $row->berkas) ?>" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-file-alt mr-1"></i> Lihat File
                                </a>
                                <?php elseif ($row->tipe_upload === '2' && !empty($row->link)): ?>
                                <a href="<?= $row->link ?>" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-external-link-alt mr-1"></i> Kunjungi Link
                                </a>
                                <?php else: ?>
                                <span class="text-muted"><i>Tidak ada file atau link</i></span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= $row->modified_at; ?>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-sm btn-info position-relative btn-komentar"
                                    data-karya_uuid="<?= $row->uuid; ?>"
                                    data-judul="<?= htmlspecialchars($row->judul, ENT_QUOTES, 'UTF-8'); ?>"
                                    title="Lihat Komentar">
                                    <i class="fas fa-comments"></i>
                                    <?php if (!empty($row->total_komentar)): ?>
                                    <span
                                        class="badge badge-light position-absolute top-0 start-100 translate-middle rounded-pill text-dark border">
                                        <?= $row->total_komentar; ?>
                                    </span>
                                    <?php endif; ?>
                                </a>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="text-left mt-3">
                <a href="<?= base_url('karya') ?>" class="btn btn-danger btn-md shadow-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Modal Komentar -->
<div class="modal fade" id="modalKomentar" tabindex="-1" role="dialog" aria-labelledby="komentarModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="komentarModalLabel">
                    <i class="fas fa-comments"></i> Komentar
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap align-items-center">
                    <span class="text-dark mr-2">Judul Karya :</span>
                    <h6 id="judulKarya" class="font-weight-bold text-primary mb-0" style="word-break: break-word;"></h6>
                </div>
                <hr class="my-3">
                <!-- Daftar komentar -->
                <div id="daftarKomentar" class="mb-3" style="max-height: 300px; overflow-y: auto;">
                    <div class="text-center text-muted">Memuat komentar...</div>
                </div>

                <!-- Form tambah komentar -->
                <form id="formKomentar">
                    <div class="form-group">
                        <textarea name="komentar" id="komentar" rows="3" class="form-control"
                            placeholder="Tulis komentar..."></textarea>
                        <input type="hidden" name="karya_uuid" id="karya_uuid">
                        <div id="komentarError"></div>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-paper-plane"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- /.container-fluid -->

</div>

<script>
$(document).ready(function() {

    // Saat tombol komentar diklik
    $('.btn-komentar').on('click', function() {
        let karya_uuid = $(this).data('karya_uuid');
        let judul = $(this).data('judul');
        console.log("DEBUG Karya UUID:", karya_uuid); // 🧠 Tambahkan ini

        $('#karya_uuid').val(karya_uuid);
        $('#judulKarya').text(judul);
        $('#modalKomentar').modal('show');

        $('#daftarKomentar').html('<div class="text-center text-muted">Memuat komentar...</div>');

        $.get('<?= base_url('komentar/get_by_karya_uuid/'); ?>' + karya_uuid, function(data) {
            console.log("DEBUG Response:", data); // 🧠 Tambahkan ini
            $('#daftarKomentar').html(data);
        });
    });


    // Submit komentar baru
    $('#formKomentar').on('submit', function(e) {
        e.preventDefault();

        // hapus pesan error sebelumnya
        $('#komentarError').html('');

        $.post('<?= base_url('komentar/tambah'); ?>', $(this).serialize(), function(response) {
            try {
                const res = JSON.parse(response);

                if (res.status === 'success') {
                    $('#komentar').val('');
                    $('#daftarKomentar').html(res.html);
                } else if (res.status === 'validation_error') {
                    // tampilkan error di bawah textarea
                    $('#komentarError').html(res.message);
                } else {
                    alert(res.message);
                }
            } catch (err) {
                console.error('Response Error:', response);
            }
        });
    });


});
</script>