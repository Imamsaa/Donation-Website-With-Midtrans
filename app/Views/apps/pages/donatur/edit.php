<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <div class="content">
      
<div class="row">
    <div class="col-lg-8 col-sm-12 mb-3">
      <div class="card ">
      <div class="card-body">
      <div class="d-flex mb-3">
        <h4 class="text-black">EDIT DONATUR</h4>
      </div>
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab"><span class="hidden-sm-up"><i class="ti-key"></i></span> <span class="hidden-xs-down">Password</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
                <div class="tab-pane p-20 active" id="profile" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/donatur/update/'.$donatur['username']) ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="gender">Status</label>
                        <select class="form-control custom-select" name="status" id="status">
                            <option value="Aktif" <?= (old('status') == 'Aktif' OR $donatur['status'] == 'Aktif') ? 'selected' : '' ?>>Aktif</option>
                            <option value="Tidak Aktif" <?= (old('status') == 'Tidak Aktif' OR $donatur['status'] == 'Tidak Aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
                        </select>
                    </div>
                    
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </form>
                </div>
                <div class="tab-pane p-20" id="password" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/donatur/password/'.$donatur['username']) ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" value="<?= old('password') ?>" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <label for="repassword">RePassword</label>
                        <input type="password" value="<?= old('repassword') ?>" class="form-control" id="repassword" name="repassword" placeholder="RePassword">
                    </div>
                    
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </form>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 mb-3">
        <div class="card ">
      <div class="card-body">
        <div class="d-flex mb-3">
            <h4 class="text-black">PREVIEW</h4>
        </div>
        <div class="text-center">
            <img src="<?= base_url('public/uploads/profiles/'.$donatur['photo']) ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle w-50">
            <h4><?= $donatur['first_name'].' '.$donatur['last_name'] ?></h4>
            <p id="preview-status"><?= ucfirst($donatur['status']) ?></p>
        </div>
        <p>Alamat :</p>
        <p><?= $donatur['address'] ?></p>
        <p>Contact</p>
        <div class="d-block">
            <span><i class="ti-email"></i> <?= $donatur['email'] ?></span>
        </div>
        <div class="d-block">
            <span><i class="ti-tablet"></i> <?= $donatur['phone'] ?></span>
        </div>
    </div>
</div>
</div>
</div>
    </div>
    <!-- /.content --> 
  </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data default dari database
    const defaultData = {
        status: '<?= ucfirst($donatur['status']) ?>'
    };

    // Elements
    const statusSelect = document.getElementById('status');
    
    // Preview elements
    const previewStatus = document.getElementById('preview-status');

    // Function to update preview
    function updatePreview() {
        const status = statusSelect.value || defaultData.status;
        previewStatus.textContent = status;
    }

    // Event listeners
    statusSelect.addEventListener('change', updatePreview);
});
</script>

<?= $this->endSection(); ?>