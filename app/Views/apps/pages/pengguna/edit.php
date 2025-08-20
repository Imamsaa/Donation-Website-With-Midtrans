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
        <h4 class="text-black">EDIT PENGGUNA</h4>
      </div>
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#password" role="tab"><span class="hidden-sm-up"><i class="ti-key"></i></span> <span class="hidden-xs-down">Password</span></a> </li>
            </ul>
            <div class="tab-content tabcontent-border">
                <div class="tab-pane p-20 active" id="profile" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/pengguna/update/'.$user['username']) ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" value="<?= old('first_name', $user['first_name']) ?>" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <input type="text" value="<?= old('last_name', $user['last_name']) ?>" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" value="<?= old('username', $user['username']) ?>" class="form-control" id="username" name="username" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="level">Privilege</label>
                        <select class="form-control custom-select" name="level" id="level">
                            <option disabled></option>
                            <option value="admin" <?= (old('level') == 'admin' OR $user['level'] == 'admin') ? 'selected' : '' ?> >Administrator</option>
                            <option value="ketua" <?= (old('level') == 'ketua' OR $user['level'] == 'ketua') ? 'selected' : '' ?>>Ketua</option>
                            <option value="bendahara" <?= (old('level') == 'bendahara' OR $user['level'] == 'bendahara') ? 'selected' : '' ?>>Bendahara</option>
                            <option value="fundraiser" <?= (old('level') == 'fundraiser' OR $user['level'] == 'fundraiser') ? 'selected' : '' ?>>Fundraiser</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" value="<?= old('email', $user['email']) ?>" class="form-control" id="email" name="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="phone" value="<?= old('phone', $user['phone']) ?>" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea class="form-control" id="address" rows="3" name="address" placeholder="Address"><?= old('address', $user['address']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="photo">Foto Profil</label>
                        <input type="file" id="photo" name="photo" class="dropify" data-max-file-size="2M" />
                    </div>
                    <button class="btn btn-success" type="submit">SUBMIT</button>
                </form>
                </div>
                <div class="tab-pane p-20" id="password" role="tabpanel">
                    <form class="form" action="<?= base_url('apps/pengguna/password/'.$user['username']) ?>" method="post" enctype="multipart/form-data">
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" value="<?= old('password') ?>" id="password" name="password" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <label for="repassword">RePassword</label>
                        <input type="password" class="form-control" id="repassword" value="<?= old('repassword') ?>" name="repassword" placeholder="RePassword">
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
            $previewImage = base_url('public/assets/img/avatar.png');
            if ($user['photo'] && $user['photo'] !== 'default.png') {
                $previewImage = base_url('public/uploads/profiles/' . $user['photo']);
            }
            ?>
            <img src="<?= $previewImage ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle w-50" id="preview-image">
            <h4 id="preview-name"><?= $user['first_name'] . ' ' . $user['last_name'] ?></h4>
            <p id="preview-level">
                <?php
                $levelText = '';
                switch($user['level']) {
                    case 'admin': $levelText = 'Administrator'; break;
                    case 'ketua': $levelText = 'Ketua'; break;
                    case 'bendahara': $levelText = 'Bendahara'; break;
                    case 'fundraiser': $levelText = 'Fundraiser'; break;
                    default: $levelText = 'Privilege'; break;
                }
                echo $levelText;
                ?>
            </p>
        </div>
        <p>Deskripsi :</p>
        <p id="preview-address"><?= $user['address'] ?: 'Halo Nama Saya ' . $user['first_name'] . ' ' . $user['last_name'] . ' dengan alamat di Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi' ?></p>
        <p>Contact</p>
        <div class="d-block">
            <span id="preview-email"><i class="ti-email"></i> <?= $user['email'] ?></span>
        </div>
        <div class="d-block">
            <span id="preview-phone"><i class="ti-tablet"></i> <?= $user['phone'] ?: '+62 123 456' ?></span>
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
    // Elements
    const firstName = document.getElementById('first_name');
    const lastName = document.getElementById('last_name');
    const level = document.getElementById('level');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const address = document.getElementById('address');
    const fotoInput = document.getElementById('photo');
    
    // Preview elements
    const previewImg = document.getElementById('preview-image');
    const previewNama = document.getElementById('preview-name');
    const previewLevel = document.getElementById('preview-level');
    const previewAddress = document.getElementById('preview-address');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    
    // Default image path
    const defaultImage = '<?= base_url('public/assets/img/avatar.png') ?>';
    const currentUserPhoto = '<?= $previewImage ?>';
    
    // Function to update name
    function updateName() {
        const fullName = (firstName.value + ' ' + lastName.value).trim();
        previewNama.textContent = fullName || '<?= $user['first_name'] . ' ' . $user['last_name'] ?>';
        
        // Update default address if no custom address
        if (!address.value.trim()) {
            previewAddress.textContent = `Halo Nama Saya ${fullName || 'User Panel'} dengan alamat di Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi`;
        }
    }
    
    // Function to update level
    function updateLevel() {
        const levelValue = level.value;
        let levelText = 'Administrator';
        
        switch(levelValue) {
            case 'admin':
                levelText = 'Administrator';
                break;
            case 'ketua':
                levelText = 'Ketua';
                break;
            case 'bendahara':
                levelText = 'Bendahara';
                break;
            case 'fundraiser':
                levelText = 'Fundraiser';
                break;
        }
        
        previewLevel.textContent = levelText;
    }
    
    // Function to update email
    function updateEmail() {
        const emailValue = email.value || '<?= $user['email'] ?>';
        previewEmail.innerHTML = '<i class="ti-email"></i> ' + emailValue;
    }
    
    // Function to update phone
    function updatePhone() {
        const phoneValue = phone.value || '<?= $user['phone'] ?: '+62 123 456' ?>';
        previewPhone.innerHTML = '<i class="ti-tablet"></i> ' + phoneValue;
    }
    
    // Function to update address
    function updateAddress() {
        const addressValue = address.value.trim();
        if (addressValue) {
            previewAddress.textContent = addressValue;
        } else {
            const fullName = (firstName.value + ' ' + lastName.value).trim() || '<?= $user['first_name'] . ' ' . $user['last_name'] ?>';
            previewAddress.textContent = `Halo Nama Saya ${fullName} dengan alamat di Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi`;
        }
    }
    
    // Function to handle image preview
    function handleImagePreview() {
        const file = fotoInput.files[0];
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                fotoInput.value = '';
                previewImg.src = currentUserPhoto;
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                fotoInput.value = '';
                previewImg.src = currentUserPhoto;
                return;
            }
            
            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = currentUserPhoto;
        }
    }
    
    // Event listeners for real-time updates
    if (firstName) firstName.addEventListener('input', updateName);
    if (lastName) lastName.addEventListener('input', updateName);
    if (level) level.addEventListener('change', updateLevel);
    if (email) email.addEventListener('input', updateEmail);
    if (phone) phone.addEventListener('input', updatePhone);
    if (address) address.addEventListener('input', updateAddress);
    if (fotoInput) fotoInput.addEventListener('change', handleImagePreview);
    
    // Initialize preview with current values
    updateName();
    updateLevel();
    updateEmail();
    updatePhone();
    updateAddress();
});
</script>
<?= $this->endSection(); ?>

