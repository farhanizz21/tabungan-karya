<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Edit Mapel</h1>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="<?= base_url('mapel')?>">
                    <i class="fas fa-arrow-left">
                    </i> Daftar Mata Pelajaran</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form class="user" method="post" action="<?= base_url('mapel/edit/'.$mapel->uuid);?>">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <label class="form-label font-weight-bold">Nama<span class="text-danger">*</span></label>
                        <input type="text" name="namaMapel" id="namaMapel"
                            class="form-control <?= form_error('namaMapel') ? 'invalid' : '' ?>"
                            value="<?= $mapel->nama; ?>" placeholder="Masukkan Nama Mata Pelajaran"
                            value="<?= set_value('namaMapel'); ?>">
                        <div class="invalid-feedback <?= !empty(form_error('namaMapel')) ? 'd-block' : '' ; ?> ">
                            <?= form_error('namaMapel') ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="btn btn-md btn-success mr-2">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                        <a href="<?= base_url('mapel')?>" class="btn btn-md btn-danger">
                            <i class="fa fa-times"></i> Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>