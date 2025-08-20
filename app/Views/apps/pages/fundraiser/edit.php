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
        <h4 class="text-black">EDIT FUNDRAISER</h4>
      </div>
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab"><span class="hidden-sm-up"><i class="ti-key"></i></span> <span class="hidden-xs-down">Password</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
                <div class="tab-pane p-20 active" id="profile" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/fundraiser/update/'.$fundraiser['username']) ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control" id="first_name" value="<?= old('first_name', $fundraiser['first_name']) ?>" name="first_name" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" value="<?= old('last_name', $fundraiser['last_name']) ?>" id="last_name" name="last_name" placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" value="<?= old('username', $fundraiser['username']) ?>" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?= old('email', $fundraiser['email']) ?>" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="phone" value="<?= old('phone', $fundraiser['phone']) ?>" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address"><?= old('address', $fundraiser['address']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Profil</label>
                        <input type="file" name="photo" id="photo" class="dropify" data-max-file-size="2M" />
                    </div>
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </form>
                </div>
                <div class="tab-pane p-20" id="password" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/fundraiser/password/'.$fundraiser['username']) ?>" method="post" enctype="multipart/form-data">
                    
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
            <img src="<?= base_url('public/uploads/profiles/'.$fundraiser['photo']) ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle w-50" id="preview-photo">
            <h4 id="preview-name"><?= $fundraiser['first_name'] . ' ' . $fundraiser['last_name'] ?></h4>
            <p>Fundraiser</p>
        </div>
        <p>Deskripsi :</p>
        <p id="preview-description">Halo Nama Saya <span id="preview-full-name"><?= $fundraiser['first_name'] . ' ' . $fundraiser['last_name'] ?></span><span id="preview-address-text"><?= !empty($fundraiser['address']) ? ' dengan alamat di ' . $fundraiser['address'] : '' ?></span></p>
        <p>Contact</p>
        <div class="d-block">
            <span><i class="ti-email"></i> <span id="preview-email"><?= $fundraiser['email'] ?></span></span>
        </div>
        <div class="d-block" id="preview-phone-container" <?= empty($fundraiser['phone']) ? 'style="display: none;"' : '' ?>>
            <span><i class="ti-tablet"></i> <span id="preview-phone"><?= $fundraiser['phone'] ?></span></span>
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
        first_name: '<?= $fundraiser['first_name'] ?>',
        last_name: '<?= $fundraiser['last_name'] ?>',
        email: '<?= $fundraiser['email'] ?>',
        phone: '<?= $fundraiser['phone'] ?? '' ?>',
        address: '<?= addslashes($fundraiser['address'] ?? '') ?>'
    };

    // Elements
    const firstNameInput = document.getElementById('first_name');
    const lastNameInput = document.getElementById('last_name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const photoInput = document.getElementById('photo');
    
    // Preview elements
    const previewName = document.getElementById('preview-name');
    const previewFullName = document.getElementById('preview-full-name');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    const previewPhoneContainer = document.getElementById('preview-phone-container');
    const previewAddressText = document.getElementById('preview-address-text');
    const previewPhoto = document.getElementById('preview-photo');

    // Function to update preview
    function updatePreview() {
        const firstName = firstNameInput.value.trim() || defaultData.first_name;
        const lastName = lastNameInput.value.trim() || defaultData.last_name;
        const email = emailInput.value.trim() || defaultData.email;
        const phone = phoneInput.value.trim() || defaultData.phone;
        const address = addressInput.value.trim() || defaultData.address;
        
        // Update nama
        const fullName = firstName + ' ' + lastName;
        previewName.textContent = fullName;
        previewFullName.textContent = fullName;
        
        // Update email
        previewEmail.textContent = email;
        
        // Update phone
        if (phone) {
            previewPhone.textContent = phone;
            previewPhoneContainer.style.display = 'block';
        } else {
            previewPhoneContainer.style.display = 'none';
        }
        
        // Update address
        if (address) {
            previewAddressText.textContent = ' dengan alamat di ' + address;
        } else {
            previewAddressText.textContent = '';
        }
    }

    // Event listeners untuk input
    firstNameInput.addEventListener('input', updatePreview);
    lastNameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    phoneInput.addEventListener('input', updatePreview);
    addressInput.addEventListener('input', updatePreview);

    // Photo preview
    photoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewPhoto.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?= $this->endSection(); ?>