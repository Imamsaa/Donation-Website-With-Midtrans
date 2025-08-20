<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
<div class="row">
    <div class="col-lg-8 col-sm-12 mb-3">
      <div class="card"> <img class="card-img-top img-responsive" src="<?= base_url('public/uploads/programs/'.$program['photo']) ?>" alt="<?= $program['title'] ?>">
              <div class="card-body">
                <h4 class="card-title"><?= $program['title'] ?></h4>
                <p class="card-text"><?= $program['description'] ?></p>
            </div>
        </div>
</div>
        <div class="col-lg-4 col-sm-12 mb-3">
        <div class="card ">
            <div class="card-body">
                <form action="<?= base_url('midtrans') ?>" method="post">
                    <div class="d-flex mb-3 justify-content-center">
                        <h4 class="text-black">DONASI SEKARANG</h4>
                    </div>
                    <div class="form-group">
                        <label for="amount">Nominal</label>
                        <input type="text" class="form-control" value="<?= old('amount') ?>" id="amount" name="amount" placeholder="Nominal">
                    </div>
                    <input type="hidden" name="first_name" value="<?= session()->get('first_name') ?>">
                    <input type="hidden" name="last_name" value="<?= session()->get('last_name') ?>">
                    <input type="hidden" name="email" value="<?= session()->get('email') ?>">
                    <input type="hidden" name="program_id" value="<?= $program['program_id'] ?>">
                    <div class="checkbox">
                    <label>
                        <input type="checkbox" name="anonim" value="ya">
                        Anonim </label>
                    </div>
                    <button class="btn btn-sm btn-block btn-success" type="submit">SUBMIT</button>
                </form>
            </div>
        </div>
</div>
</div>
    </div>
    <!-- /.content --> 
  </div>
<?= $this->endSection(); ?>

