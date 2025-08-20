<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">LIST DONASI</h4>
        <div class="ml-auto">
          <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal<?= $program['slug'] ?>">Tambah Donasi</button>
        </div>
      </div>
      <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>NAMA DONATUR</th>
                  <th>DONASI</th>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach($listDonasi as $ld) :
                  ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= $ld['name'] ?></td>
                  <td>Rp. <?= $ld['amount'] ?></td>
                  <td><?= $ld['status'] ?></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModalEdit<?= $ld['donasi_id'] ?>">Edit</button></div>
                    <form action="<?= base_url('apps/donasi/'.$program['slug'].'/delete'.'/'.$ld['donasi_id']) ?>" method="post" class="d-inline">
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
                  <th>NAMA DONATUR</th>
                  <th>DONASI</th>
                  <th>STATUS</th>
                  <th>ACTION</th>
                </tr>
                </tfoot>
              </table>
                  </div>
      </div></div>

        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card ">
                <div class="card-body">
                  <div class="d-flex mb-3">
                      <h4 class="text-black">PREVIEW</h4>
                  </div>
                  <div class="text-center">
                      <img src="<?= base_url('public/uploads/programs/'.$program['photo']) ?>" alt="Foto Profil" class="mb-2 w-full img-thumbnail">
                  </div>
                  <h4><?= $program['title'] ?></h4>
                  <div class="progress mb-3" style="height: 15px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?= $program['total_donate']/$program['target_donate']*100 ?>%; height: 15px;" aria-valuenow="<?= $program['total_donate']/$program['target_donate']*100 ?>" aria-valuemin="0" aria-valuemax="100"><?= $program['total_donate']/$program['target_donate']*100 ?>%</div>
                  </div>
                  <div class="d-flex justify-content-between mb-3">
                      <div class="mb-3 text-center">
                          <span class="mr-2 d-block"></i> Target :</span>
                          <span class="mr-2 d-block"></i>Rp. <?= $program['target_donate'] ?></span>
                      </div>
                      <div class="mb-3 text-center">
                          <span class="mr-2 d-block"></i> Total :</span>
                          <span class="mr-2 d-block"></i>Rp. <?= $program['total_donate'] ?></span>
                      </div>
                  </div>
                  <p><?= $program['description'] ?></p>
                  
              </div>
          </div>
        </div>
      </div>
      
    </div>
    <!-- /.content --> 
  </div>
<?= $this->endSection(); ?>

