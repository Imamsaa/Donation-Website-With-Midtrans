<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="text-black">Laporan</h4>
                <p>Export data to Copy, CSV, Excel & Note</p>
                
                <!-- Date Filter Form -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="<?= base_url('apps/laporan') ?>" class="form-inline">
                            <div class="form-group mr-2">
                                <label for="start_date" class="mr-2">Tanggal Awal:</label>
                                <input type="date" 
                                       id="start_date" 
                                       name="start_date" 
                                       class="form-control" 
                                       value="<?= $start_date ?? '' ?>">
                            </div>
                            <div class="form-group mr-2 ml-3">
                                <label for="end_date" class="mr-2">Tanggal Akhir:</label>
                                <input type="date" 
                                       id="end_date" 
                                       name="end_date" 
                                       class="form-control" 
                                       value="<?= $end_date ?? '' ?>">
                            </div>
                            <div class="form-group ml-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?= base_url('apps/laporan') ?>" class="btn btn-secondary ml-2">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Display filter info if dates are selected -->
                <?php if ($start_date && $end_date): ?>
                <div class="alert alert-info">
                    Menampilkan data dari <strong><?= date('d/m/Y', strtotime($start_date)) ?></strong> 
                    sampai <strong><?= date('d/m/Y', strtotime($end_date)) ?></strong>
                </div>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-hover" data-name="cool-table">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA DONATUR</th>
                                <th>PROGRAM</th>
                                <th>DONASI</th>
                                <th>STATUS</th>
                                <th>WAKTU</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $totalDonasi = 0;
                            foreach($donasi as $d) :
                                $totalDonasi += $d['amount'];
                            ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $d['name'] ?></td>
                                <td><?= $d['title'] ?></td>
                                <td>Rp. <?= number_format($d['amount'], 0, '.', '.') ?></td>
                                <td>
                                    <span class="badge badge-success"><?= $d['status'] ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($d['created_at'])) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>NO</th>
                                <th>NAMA DONATUR</th>
                                <th>PROGRAM</th>
                                <th>DONASI</th>
                                <th>STATUS</th>
                                <th>WAKTU</th>
                            </tr>
                            <tr class="bg-light">
                                <th colspan="3" class="text-right">Total Donasi:</th>
                                <th>Rp. <?= number_format($totalDonasi, 0, '.', '.') ?></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>