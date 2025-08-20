<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
    <!-- Main content -->
    <div class="content">
      <div class="row mb-3">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="text-center mb-3">SELAMAT DATANG</h4>
              <p>Selamat datang di Yayasan Bina Insani Grobogan!
Terima kasih telah menjadi bagian dari perubahan nyata melalui donasi Anda. Setiap kontribusi akan membantu pendidikan anak kurang mampu dan pendistribusian Al-Quran di wilayah Grobogan.</p>
            </div>
          </div>
        </div>
      </div>
      <!-- /.row --> 
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
                                echo $p['total_amount']/$p['target_donate']*100 . '%';
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
    </div>
</div>

<?= $this->endSection(); ?>

