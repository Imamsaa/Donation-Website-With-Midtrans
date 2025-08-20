<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
      <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">LIST FUNDRAISER</h4>
        <div class="ml-auto">
          <a href="<?= base_url('apps/fundraiser/add') ?>" class="btn btn-primary btn-sm">Tambah Fundraiser</a>
        </div>
      </div>
      <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA FUNDRAISER</th>
                  <th>PRIVILEGE</th>
                  <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($fundraiser as $f) :
                  ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $f['first_name'].' '.$f['last_name'] ?></td>
                  <td>Fundraiser</td>
                  <td>
                    <a href="<?= base_url('apps/fundraiser/edit/'.$f['username']) ?>" class="btn btn-primary btn-sm">Edit</a>
                    <form action="<?= base_url('apps/fundraiser/delete/'.$f['username']) ?>" method="post" class="d-inline">
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
                  <th>NAMA FUNDRAISER</th>
                  <th>PRIVILEGE</th>
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

