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
                            <h4 class="text-black">TAMBAH FUNDRAISER</h4>
                        </div>
                        <form class="form" action="<?= base_url('apps/fundraiser/save') ?>" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="form-control" value="<?= old('first_name') ?>" id="first_name" name="first_name" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" value="<?= old('last_name') ?>" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" value="<?= old('username') ?>" id="username" name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="<?= old('password') ?>" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="<?= old('email') ?>" class="form-control" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="phone" class="form-control" value="<?= old('phone') ?>" id="phone" name="phone" placeholder="Phone">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address"><?= old('address') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="photo">Foto Profil</label>
                                <input type="file" id="photo" name="photo" class="dropify" data-max-file-size="2M" />
                            </div>
                            <button class="btn btn-success" type="submit">SUBMIT</button>
                        </form>
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
                            <img src="<?= base_url('public/uploads/profiles/default.png') ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle" id="preview-image">
                            <h4 id="preview-name">Nama Pengguna</h4>
                            <p id="preview-username">Privilege</p>
                        </div>
                        <p>Deskripsi :</p>
                        <p id="preview-address"></p>
                        <p>Contact</p>
                        <div class="d-block">
                            <span><i class="ti-email"></i> <span id="preview-email"></span></span>
                        </div>
                        <div class="d-block">
                            <span><i class="ti-tablet"></i> <span id="preview-phone"></span></span>
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
    // Real-time preview for name (first name + last name)
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const previewName = document.getElementById('preview-name');
    
    function updateName() {
        const firstName = firstNameInput.value.trim();
        const lastName = lastNameInput.value.trim();
        const fullName = (firstName + ' ' + lastName).trim();
        previewName.textContent = fullName || 'Nama Pengguna';
    }
    
    firstNameInput.addEventListener('input', updateName);
    lastNameInput.addEventListener('input', updateName);

    // Real-time preview for username
    const usernameInput = document.getElementById('username');
    const previewUsername = document.getElementById('preview-username');
    
    usernameInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewUsername.textContent = value || 'Privilege';
    });

    // Real-time preview for email
    const emailInput = document.getElementById('email');
    const previewEmail = document.getElementById('preview-email');
    
    emailInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewEmail.textContent = value || '';
    });

    // Real-time preview for phone
    const phoneInput = document.getElementById('phone');
    const previewPhone = document.getElementById('preview-phone');
    
    phoneInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewPhone.textContent = value || '';
    });

    // Real-time preview for address
    const addressInput = document.getElementById('address');
    const previewAddress = document.getElementById('preview-address');
    
    addressInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewAddress.textContent = value || '';
    });

    // Real-time preview for image
    const photoInput = document.getElementById('photo');
    const previewImage = document.getElementById('preview-image');
    
    photoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?= $this->endSection(); ?>