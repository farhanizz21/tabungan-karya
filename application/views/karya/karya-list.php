<!-- Begin Page Content -->
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

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('materi')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Mata Pelajaran</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Daftar Materi</li>
        </ol>
    </nav>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Materi</h1>

        <?php if($pengampu == true){?>
        <a href="<?=base_url('materi/tambah/'.$mapel->uuid)?>" class="btn btn-md btn-primary shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50"></i> Tambah
            Data</a>
        <?php } ?>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header">
            <span><i class="fa fa-book"></i> Mata Pelajaran: <span
                    class="text-primary font-weight-bold"><?= $mapel->nama ?></span></span>
        </div>

        <div class="card-body">
            <div class="row">
                <?php if(!empty($materi)) : ?>
                <?php foreach($materi as $val) :  ?>
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm">
                        <!-- <div class="card-header">
                            <span>Mata Pelajaran :</span>
                            <span class="text-primary font-weight-bold"><?= $val->mapel ?></span>
                        </div> -->
                        <?php if (!empty($val->thumbnail)) : ?>
                        <img src="<?= base_url('uploads/thumbnail/'.$val->thumbnail) ?>" class="card-img-top"
                            height="200px;">
                        <?php else : ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                            style="height: 200px;">
                            <span class="text-muted">No Image Available</span>
                        </div>
                        <?php endif; ?>

                        <div class="card-body">
                            <!-- <p class="text-muted">06 November 2024</p> -->
                            <h5 class="card-title medium"><?=$val->judul?></h5>
                            <p class="small"><i class="fas fa-user"></i> <?=$val->nama?></p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <a href="<?= base_url('uploads/materi/' . $val->berkas) ?>" target="_blank"
                                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i>
                                    Klik untuk Melihat
                                </a>
                                <?php if($pengampu == true ){?>
                                <a href="<?= base_url('materi/hapus/' . $val->uuid) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus materi <?= $val->judul; ?>?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p class="text-center">Belum ada data materi</p> <!-- Jika array kosong, tampilkan pesan -->
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a href="<?= base_url('materi')?>" class="btn btn-md btn-danger">
        <i class="fa fa-left-arrow"></i> Kembali
    </a>

</div>
<!-- /.container-fluid -->

</div>