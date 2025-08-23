<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content">
        <div class="card">
            <div class="card-body">
                <h4 class="text-black">Laporan</h4>
                <p>Export data to Copy, CSV, Excel & Note</p>
                
                <!-- Filter Form -->
                <div class="row mb-3">
                    <div class="col-md-12">
                        <form method="GET" action="<?= base_url('apps/laporan') ?>" class="form-inline">
                            <!-- Date Filters -->
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
                            
                            <!-- Program Filter -->
                            <div class="form-group mr-2 ml-3">
                                <label for="program_filter" class="mr-2">Program:</label>
                                <select id="program_filter" 
                                        name="program_filter" 
                                        class="form-control">
                                    <option value="">-- Semua Program --</option>
                                    <?php foreach($all_programs as $program): ?>
                                        <option value="<?= $program['title'] ?>" 
                                                <?= (isset($program_filter) && $program_filter == $program['title']) ? 'selected' : '' ?>>
                                            <?= $program['title'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <!-- Search by Program Name/Slug -->
                            <div class="form-group mr-2 ml-3">
                                <label for="program_search" class="mr-2">Cari Program:</label>
                                <input type="text" 
                                       id="program_search" 
                                       name="program_filter" 
                                       class="form-control" 
                                       placeholder="Nama atau slug program..."
                                       value="<?= $program_filter ?? '' ?>">
                            </div>
                            
                            <div class="form-group ml-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="<?= base_url('apps/laporan') ?>" class="btn btn-secondary ml-2">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Display filter info -->
                <?php 
                $hasFilters = false;
                $filterInfo = [];
                
                if ($start_date && $end_date) {
                    $filterInfo[] = 'Tanggal: <strong>' . date('d/m/Y', strtotime($start_date)) . '</strong> sampai <strong>' . date('d/m/Y', strtotime($end_date)) . '</strong>';
                    $hasFilters = true;
                }
                
                if ($program_filter && !empty($program_filter)) {
                    $filterInfo[] = 'Program: <strong>' . $program_filter . '</strong>';
                    $hasFilters = true;
                }
                
                if ($hasFilters): ?>
                <div class="alert alert-info">
                    Filter aktif - <?= implode(' | ', $filterInfo) ?>
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
                
                <!-- Summary Info -->
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Total Transaksi:</strong> <?= count($donasi) ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Total Donasi:</strong> Rp. <?= number_format($totalDonasi, 0, '.', '.') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Rata-rata Donasi:</strong> 
                                        <?php if (count($donasi) > 0): ?>
                                            Rp. <?= number_format($totalDonasi / count($donasi), 0, '.', '.') ?>
                                        <?php else: ?>
                                            Rp. 0
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Hide search input when dropdown is used
    $('#program_filter').on('change', function() {
        if ($(this).val() !== '') {
            $('#program_search').hide();
        } else {
            $('#program_search').show();
        }
    });
    
    // Hide dropdown when search input is used
    $('#program_search').on('input', function() {
        if ($(this).val() !== '') {
            $('#program_filter').hide();
        } else {
            $('#program_filter').show();
        }
    });
    
    // Initialize visibility based on current values
    if ($('#program_filter').val() !== '') {
        $('#program_search').hide();
    } else if ($('#program_search').val() !== '') {
        $('#program_filter').hide();
    }
});
</script>

<?= $this->endSection(); ?>