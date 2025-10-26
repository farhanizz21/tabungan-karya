<div class="container-fluid">
    <!-- <h1 class="h3 mb-4 text-gray-800">Dashboard</h1> -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <h5 class="font-weight-bold text-primary">Selamat Datang di Tabungan Karya</h5>
            <p class="text-muted mb-0">
                <strong>Tabungan Karya</strong> adalah platform digital untuk mendokumentasikan, mengelola,
                dan menampilkan karya para guru dalam satu sistem terpadu.
                Melalui website ini, guru dapat mengunggah karya inovatif, berbagi inspirasi,
                serta membangun portofolio profesional yang berkelanjutan.
            </p>
        </div>
    </div>


    <!-- Statistik Utama -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Guru</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_guru ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Karya</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_karya ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Guru dengan Karya Terbanyak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $guru_terbanyak ? $guru_terbanyak->nama : '-' ?></div>
                            <small><?= $guru_terbanyak ? $guru_terbanyak->total_karya . ' karya' : '' ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Guru dengan Karya Tersedikit</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $guru_tersedikit ? $guru_tersedikit->nama : '-' ?></div>
                            <small><?= $guru_tersedikit ? $guru_tersedikit->total_karya . ' karya' : '' ?></small>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Jumlah Karya per Guru -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Distribusi Jumlah Karya per Guru</h6>
        </div>
        <div class="card-body">
            <canvas id="chartKaryaGuru" height="120"></canvas>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">📂 Karya Terbaru</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($karya_terbaru)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>Judul</th>
                            <th>Pembuat</th>
                            <th>Waktu Upload</th>
                            <th>Lihat</th>
                            <th>Komentar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($karya_terbaru as $k): ?>
                        <tr>
                            <td><?= htmlspecialchars($k->judul, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= htmlspecialchars($k->nama ?? 'Tidak diketahui', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?= date('d M Y, H:i', strtotime($k->modified_at)); ?> WIB</td>
                            <td class="text-center">
                                <?php if ($k->tipe_upload == 1): ?>
                                <a href="<?= base_url('uploads/karya/' . $k->berkas); ?>" target="_blank"
                                    class="btn btn-sm btn-primary">
                                    <i class="fas fa-file"></i> Lihat File
                                </a>
                                <?php else: ?>
                                <a href="<?= $k->link; ?>" target="_blank" class="btn btn-sm btn-success">
                                    <i class="fas fa-link"></i> Lihat Link
                                </a>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="btn btn-sm btn-info btn-komentar"
                                    data-karya_uuid="<?= $k->uuid; ?>" data-judul="<?= htmlspecialchars($k->judul); ?>">
                                    <i class="fas fa-comments"></i> Komentar
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
            <div class="text-center text-muted py-3">Belum ada karya yang diunggah.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Komentar Terbaru -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Komentar Terbaru</h6>
        </div>
        <div class="card-body">
            <?php if (!empty($komentar_terbaru)) : ?>
            <ul class="list-group">
                <?php foreach ($komentar_terbaru as $komen): ?>
                <li class="list-group-item">
                    <strong><?= $komen->guru_nama; ?></strong>
                    <small><?= date('d M Y H:i', strtotime($komen->modified_at)); ?></small><br>
                    <?= $komen->komentar; ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p class="text-muted">Belum ada komentar.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartKaryaGuru').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($karya_chart, 'nama')); ?>,
        datasets: [{
            label: 'Jumlah Karya',
            data: <?= json_encode(array_column($karya_chart, 'total')); ?>,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>