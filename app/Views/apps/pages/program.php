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
        <div class="ml-auto">
          <a href="<?= base_url('apps/program/add') ?>" class="btn btn-primary btn-sm">Tambah Program</a>
        </div>
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
                  foreach($program as $p) : ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $p['title'] ?></td>
                  <td>Rp. <?= number_format((int)$p['target_donate'],0,'.','.') ?></td>
                  <td>Rp. <?= number_format((int)$p['total_donate'],0,'.','.') ?></td>
                  <td>
                    <a href="<?= base_url('apps/program/edit/'.$p['slug']) ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form action="<?= base_url('apps/program/delete/'.$p['slug']) ?>" method="post" class="d-inline">
                      <?= csrf_field() ?>
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-sm btn-delete">
                          Hapus
                      </button>
                    </form>
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

