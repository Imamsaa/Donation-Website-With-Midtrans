<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
<div class="row">
    <div class="col-12 mb-3">
      <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">PENGATURAN</h4>
      </div>
                <form class="form" action="<?= base_url('apps/pengaturan/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <!-- <div class="form-group">
                    <label for="name">EndPoint</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="First Name">
                </div> -->

                <div class="form-group">
                    <label for="server_key">Server Key</label>
                    <input type="text" class="form-control" value="<?= old('server_key', $setting['server_key']) ?>" id="server_key" name="server_key" placeholder="Server Key">
                </div>

                <div class="form-group">
                    <label for="client_key">Client Key</label>
                    <input type="text" class="form-control" value="<?= old('client_key', $setting['client_key']) ?>" id="client_key" name="client_key" placeholder="Client Key">
                </div>
                
                <button class="btn btn-success" type="submit">SUBMIT</button>
            </form>
            </div>
        </div>
        </div>
       
</div>
    </div>
    <!-- /.content --> 
  </div>
<?= $this->endSection(); ?>

