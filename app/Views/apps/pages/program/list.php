<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
      <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">LIST PROGRAM</h4>
      </div>
      <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA PROGRAM</th>
                  <th>TARGET</th>
                  <th>TOTAL</th>
                  <th>ACTION</th>
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
                  <td>Rp. <?= number_format($p['target_donate'],0,'.','.') ?></td>
                  <td>Rp. <?= number_format($p['total_donate'],0,'.','.') ?></td>
                  <td>
                    <a href="<?= base_url('apps/program/'.$p['slug']) ?>" class="btn btn-primary btn-sm">Lihat</a>
                  </td>
                </tr>
                <?php
                endforeach;
                ?>
                
                </tbody>
                <tfoot>
                <tr>
                  <th>NO</th>
                  <th>NAMA PROGRAM</th>
                  <th>TARGET</th>
                  <th>TOTAL</th>
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

