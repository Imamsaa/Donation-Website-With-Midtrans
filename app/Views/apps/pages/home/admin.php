<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Main content -->
    <div class="content">
      <div class="row">
        <div class="col-lg-3 col-xs-6 m-b-3">
          <div class="card">
            <div class="card-body"><span class="info-box-icon bg-aqua"><i class="icon-plane"></i></span>
              <div class="info-box-content"> <span class="info-box-number"><?= $total_program ?></span> <span class="info-box-text">Jumlah Program</span> </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 m-b-3">
          <div class="card">
            <div class="card-body"><span class="info-box-icon bg-green"><i class="icon-user"></i></span>
              <div class="info-box-content"> <span class="info-box-number"><?= $total_donatur ?></span> <span class="info-box-text">Jumlah Donatur</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 m-b-3">
          <div class="card">
            <div class="card-body"><span class="info-box-icon bg-yellow"><i class="icon-wallet"></i></span>
              <div class="info-box-content"> <span class="info-box-number">Rp. <?= number_format($total_donasi,0,'.','.') ?></span> <span class="info-box-text">Jumlah Donasi</span></div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-6 m-b-3">
          <div class="card">
            <div class="card-body"><span class="info-box-icon bg-red"><i class="icon-people"></i></span>
              <div class="info-box-content"> <span class="info-box-number"><?= $total_user ?></span> <span class="info-box-text">Jumlah Pengguna</span></div>
            </div>
          </div>
        </div>
      </div>

        <div class="info-box">
          <div class="col-12">
            <div class="d-flex flex-wrap">
              <div>
                <h5>Grafik Donasi</h5>
              </div>
            </div>
          </div>
          <div>
            <canvas id="bar-chart" height="200"></canvas>
          </div>
        </div>

      <div class="row">
        <div class="col-12">
          <div class="card ">
      <div class="card-body">
      <h4 class="text-black">Laporan</h4>
      <p>Export data to Copy, CSV, Excel & Note</p>
      <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-hover" data-name="cool-table">
                    <thead>
                      <tr>
                        <th>NO</th>
                        <th>PROGRAM</th>
                        <th>PRESENTASE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;
                      foreach($program as $p) :
                      ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $p['title'] ?></td>
                        <td>
                          <?php
                            if (!empty($p['total_donate']) && $p['total_donate'] != 0) {
                                echo $p['total_donate'] / $p['target_donate'] * 100 . '%';
                            } else {
                                echo '0%';
                            }
                          ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <tr>
                        <th>NO</th>
                        <th>PROGRAM</th>
                        <th>PRESENTASE</th>
                      </tr>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                  </div>
              </div>
        </div>
      </div>
      <!-- /.row --> 
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk chart
    var barChartData = {
    labels: [
        <?php
        $labels = [];
        foreach ($program as $p) {
            $labels[] = '"' . $p['title'] . '"';
        }
        echo implode(',', $labels);
        ?>
    ],
    datasets: [
        {
            label: "JUmlah Donasi",
            backgroundColor: "#00c0ef",
            data: [
                <?php
                $data = [];
                foreach ($program as $p) {
                    $data[] = $p['total_donate'];
                }
                echo implode(',', $data);
                ?>
            ]
        }
    ]
};


    // Konfigurasi chart
    var barChartConfig = {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: false,
                },
                y: {
                    stacked: false,
                    beginAtZero: true
                }
            }
        }
    };

    // Inisialisasi chart
    var barChartCtx = document.getElementById('bar-chart').getContext('2d');
    new Chart(barChartCtx, barChartConfig);
});
</script>
<?= $this->endSection(); ?>

