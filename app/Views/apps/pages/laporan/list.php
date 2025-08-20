<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
            <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">LIST LAPORAN</h4>
      </div>
      <div class="table-responsive">
                  <table id="example2" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA DONATUR</th>
                  <th>PROGRAM</th>
                  <th>DONASI</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($donasi as $d) :
                  ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $d['name'] ?></td>
                  <td>Sedekah Al Quran</td>
                  <td>Rp. 10.000.000</td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>NO</th>
                  <th>NAMA DONATUR</th>
                  <th>PROGRAM</th>
                  <th>DONASI</th>
                </tr>
                </tfoot>
              </table>
                  </div>
      </div></div>

      
    </div>
    <!-- /.content --> 
  </div>
<?= $this->endSection(); ?>

