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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Daftar Karya</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div> -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="1px">No.</th>
                            <th>Nama Guru</th>
                            <th>Jumlah Karya</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center"></td>
                            <td></td>
                            <td></td>

                            <td>
                                <a href="" class="btn btn-sm btn-succes" data-toggle="tooltip" data-placement="top"
                                    title="Lihat Karya">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->

</div>