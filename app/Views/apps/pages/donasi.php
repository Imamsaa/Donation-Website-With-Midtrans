<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
      <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">LIST DONASI</h4>
      </div>
      <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA PROGRAM</th>
                  <th>TARGET</th>
                  <th>TOTAL</th>
                  <th>PRESENTASI</th>
                  <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $no =1;
                  foreach($program as $p) :
                    ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $p['title'] ?></td>
                  <td>Rp. <?= number_format($p['target_donate'],0,'.','.') ?></td>
                  <td>Rp. <?= number_format($p['total_donate'],0,'.','.') ?></td>
                  <td>
                    <div class="progress mb-3" style="height: 15px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $p['total_donate']/$p['target_donate']*100 ?>%; height: 15px;" aria-valuenow="<?= $p['total_donate']/$p['target_donate']*100 ?>" aria-valuemin="0" aria-valuemax="100"><?= $p['total_donate']/$p['target_donate']*100 ?>%</div>
                    </div>
                  </td>
                  <td>
                    <a href="<?= base_url('apps/donasi/'.$p['slug']) ?>" class="btn btn-primary btn-sm">Kelola</a>
                  </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>NO</th>
                  <th>NAMA PROGRAM</th>
                  <th>TARGET</th>
                  <th>TOTAL</th>
                  <th>PRESENTASI</th>
                  <th>ACTION</th>
                </tr>
                </tfoot>
              </table>
                  </div>
      </div></div>

    </div>
    <!-- /.content --> 
  </div>
<?= $this->endSection(); ?>

