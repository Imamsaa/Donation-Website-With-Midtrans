<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
      <div class="card ">
      <div class="card-body">
      <h4 class="text-black">Laporan</h4>
      <p>Export data to Copy, CSV, Excel & Note</p>
      <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-hover" data-name="cool-table">
                    <thead>
                      <tr>
                        <th>NO</th>
                        <th>PROGRAM</th>
                        <th>TARGET</th>
                        <th>DONASI</th>
                        <th>KONTRIBUSI</th>
                        <th>ACTION</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $no = 1;
                      foreach($donasi as $d) :
                      ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $d['title'] ?></td>
                        <td>Rp. <?= number_format($d['target_donate'],0,'.','.') ?></td>
                        <td>Rp. <?= number_format($d['total_donate'],0,'.','.') ?></td>
                        <td>Rp. <?= number_format($d['kontribusi'],0,'.','.') ?></td>
                        <td>
                          <a href="<?= base_url('apps/laporan/'.$d['slug']) ?>" class="btn btn-primary btn-sm">lihat</a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>NO</th>
                        <th>PROGRAM</th>
                        <th>TARGET</th>
                        <th>DONASI</th>
                        <th>KONTRIBUSI</th>
                        <th>ACTION</th>
                      </tr>
                    </tfoot>
                  </table>
                  </div>
                  </div>
              </div>
            </div>

    </div>
<?= $this->endSection(); ?>

