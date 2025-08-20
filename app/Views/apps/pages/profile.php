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
        <h4 class="text-black">PROFIL PENGGUNA</h4>
      </div>
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab"><span class="hidden-sm-up"><i class="ti-key"></i></span> <span class="hidden-xs-down">Password</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
                <div class="tab-pane p-20 active" id="profile" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/profile/update') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" value="<?= old('first_name', $user['first_name']) ?>" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" value="<?= old('last_name', $user['last_name']) ?>" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <!-- Username field - conditional berdasarkan user type -->
                    <?php if (isset($user['username'])): ?>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" value="<?= old('username', $user['username']) ?>" class="form-control" id="username" name="username" placeholder="Username" <?= (session()->get('user_type') === 'user' && session()->get('level') !== 'admin') ? 'readonly' : '' ?>>
                        <?php if (session()->get('user_type') === 'user' && session()->get('level') !== 'admin'): ?>
                            <small class="text-muted">Username tidak dapat diubah</small>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?= old('email', $user['email']) ?>" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" value="<?= old('phone', $user['phone']) ?>" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address"><?= old('address', $user['address']) ?></textarea>
                    </div>

                    <!-- Field khusus berdasarkan user type -->
                    <?php if (session()->get('user_type') === 'donatur' && isset($user['status'])): ?>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="active" <?= old('status', $user['status']) === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= old('status', $user['status']) === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            <option value="pending" <?= old('status', $user['status']) === 'pending' ? 'selected' : '' ?>>Pending</option>
                        </select>
                    </div>
                    <?php endif; ?>



                    <div class="form-group">
                        <label for="photo">Foto Profil</label>
                        <input type="file" id="photo" name="photo" class="dropify" data-max-file-size="2M" accept="image/*" />
                        <small class="text-muted">Format: PNG, JPG, JPEG, GIF. Maksimal 2MB</small>
                    </div>
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </form>
                </div>
                <div class="tab-pane p-20" id="password" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/profile/password/change') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="current_password">Password Lama</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Password Lama" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Password Baru" required>
                        <small class="text-muted">Minimal 6 karakter</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password Baru" required>
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
            <?php 
            $photoPath = 'public/uploads/profiles/' . ($user['photo'] ?? 'default.png');
            if (!file_exists($photoPath) || empty($user['photo'])) {
                $photoPath = 'public/assets/img/default.png'; // fallback image
            }
            ?>
            <img src="<?= base_url($photoPath) ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle w-50" id="preview-photo">
            
            <h4 id="preview-name"><?= $user['first_name'] . ' ' . $user['last_name'] ?></h4>
            
            <!-- Status/Level berdasarkan user type -->
            <?php if (session()->get('user_type') === 'user'): ?>
                <p id="preview-role"><?= ucfirst(session()->get('level') ?? 'User') ?></p>
            <?php elseif (session()->get('user_type') === 'donatur'): ?>
                <p id="preview-role">Donatur <span id="preview-status"><?= isset($user['status']) ? '(' . ucfirst($user['status']) . ')' : '' ?></span></p>
            <?php elseif (session()->get('user_type') === 'fundraiser'): ?>
                <p id="preview-role">Fundraiser</p>
            <?php endif; ?>
        </div>
        
        <p>Deskripsi :</p>
        <p id="preview-description">Halo Nama Saya <span id="preview-full-name"><?= $user['first_name'] . ' ' . $user['last_name'] ?></span><span id="preview-address-text"><?= !empty($user['address']) ? ' dengan alamat di ' . $user['address'] : '' ?></span></p>
        
        <p>Contact</p>
        <div class="d-block">
            <span><i class="ti-email"></i> <span id="preview-email"><?= $user['email'] ?></span></span>
        </div>
        <div class="d-block" id="preview-phone-container" <?= empty($user['phone']) ? 'style="display: none;"' : '' ?>>
            <span><i class="ti-tablet"></i> <span id="preview-phone"><?= $user['phone'] ?></span></span>
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
        first_name: '<?= $user['first_name'] ?>',
        last_name: '<?= $user['last_name'] ?>',
        email: '<?= $user['email'] ?>',
        phone: '<?= $user['phone'] ?? '' ?>',
        address: '<?= $user['address'] ?? '' ?>',
        <?php if (session()->get('user_type') === 'donatur' && isset($user['status'])): ?>
        status: '<?= $user['status'] ?>',
        <?php endif; ?>
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

    // Optional elements
    const statusSelect = document.getElementById('status');
    const levelSelect = document.getElementById('level');
    const previewStatus = document.getElementById('preview-status');
    const previewRole = document.getElementById('preview-role');

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
        
        // Update status (untuk donatur)
        <?php if (session()->get('user_type') === 'donatur' && isset($user['status'])): ?>
        if (statusSelect && previewStatus) {
            const status = statusSelect.value || defaultData.status;
            previewStatus.textContent = status ? '(' + status.charAt(0).toUpperCase() + status.slice(1) + ')' : '';
        }
        <?php endif; ?>
        
        // Update level (untuk admin)
        <?php if (session()->get('user_type') === 'user' && session()->get('level') === 'admin' && isset($user['level'])): ?>
        if (levelSelect && previewRole) {
            const level = levelSelect.value || defaultData.level;
            previewRole.textContent = level.charAt(0).toUpperCase() + level.slice(1);
        }
        <?php endif; ?>
    }

    // Event listeners untuk input
    firstNameInput.addEventListener('input', updatePreview);
    lastNameInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    phoneInput.addEventListener('input', updatePreview);
    addressInput.addEventListener('input', updatePreview);
    
    // Event listeners untuk select (jika ada)
    if (statusSelect) {
        statusSelect.addEventListener('change', updatePreview);
    }
    if (levelSelect) {
        levelSelect.addEventListener('change', updatePreview);
    }

    // Photo preview
    if (photoInput) {
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
    }

    // Password validation (existing code)
    const newPassword = document.getElementById('new_password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (newPassword.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Password tidak cocok");
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    if (newPassword && confirmPassword) {
        newPassword.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);
    }
});
</script>

<?= $this->endSection(); ?>