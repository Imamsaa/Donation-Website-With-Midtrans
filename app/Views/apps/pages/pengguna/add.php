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
        <h4 class="text-black">TAMBAH PENGGUNA</h4>
      </div>
                <form class="form" action="<?= base_url('apps/pengguna/save') ?>" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" value="<?= old('first_name') ?>" class="form-control" id="first_name" name="first_name" placeholder="First Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" value="<?= old('last_name') ?>" id="last_name" name="last_name" placeholder="Last Name">
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
                    <label for="level">Privilege</label>
                    <select class="form-control custom-select" id="level" name="level">
                        <option selected disabled></option>
                        <option value="admin" <?= old('level') == 'admin' ? 'selected' : '' ?>>Administrator</option>
                        <option value="ketua" <?= old('level') == 'ketua' ? 'selected' : '' ?>>Ketua</option>
                        <option value="bendahara" <?= old('level') == 'bendahara' ? 'selected' : '' ?>>Bendahara</option>
                        <option value="fundraiser" <?= old('level') == 'fundraiser' ? 'selected' : '' ?>>Fundraiser</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control custom-select" id="status" name="status">
                        <option selected disabled></option>
                        <option value="Aktif" <?= old('status') == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                        <option value="Tidak Aktif" <?= old('status') == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" value="<?= old('email') ?>" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="phone" value="<?= old('phone') ?>" class="form-control" id="phone" name="phone" placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Address"><?= old('address') ?></textarea>
                </div>
                <div class="form-group">
                    <label for="photo">Foto Profil</label>
                    <input type="file" name="photo" id="photo" class="dropify" data-max-file-size="2M" />
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
            <img src="<?= base_url('public/assets/img/default.png') ?>" alt="Foto Profil" class="mb-2 img-fluid img-circle" id="preview-image">
            <h4 id="preview-name">Nama Pengguna</h4>
            <p id="preview-level">Privilege</p>
        </div>
        <p>Deskripsi :</p>
        <p id="preview-description">Halo Nama Saya Nama Pengguna dengan alamat di Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi</p>
        <p>Contact</p>
        <div class="d-block">
            <span id="preview-email"><i class="ti-email"></i> email@example.com</span>
        </div>
        <div class="d-block">
            <span id="preview-phone"><i class="ti-tablet"></i> 0000-0000-0000</span>
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
    const username = document.getElementById('username');
    const level = document.getElementById('level');
    const status = document.getElementById('status');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    const address = document.getElementById('address');
    const fotoInput = document.getElementById('photo');
    
    // Preview elements - menggunakan ID yang spesifik
    const previewImg = document.getElementById('preview-image');
    const previewNama = document.getElementById('preview-name');
    const previewLevel = document.getElementById('preview-level');
    const previewDescription = document.getElementById('preview-description');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    
    // Default image path
    const defaultImage = '<?= base_url('public/assets/img/default.png') ?>';
    
    // Function to update name
    function updateName() {
        const fullName = (firstName.value + ' ' + lastName.value).trim();
        const displayName = fullName || 'Nama Pengguna';
        previewNama.textContent = displayName;
        
        // Update description with name
        updateDescription(displayName);
    }
    
    // Function to update description
    function updateDescription(name = null) {
        const displayName = name || ((firstName.value + ' ' + lastName.value).trim()) || 'Nama Pengguna';
        const addressValue = address.value.trim();
        
        if (addressValue) {
            previewDescription.textContent = `Halo Nama Saya ${displayName} dengan alamat di ${addressValue}`;
        } else {
            previewDescription.textContent = `Halo Nama Saya ${displayName} dengan alamat di Jalan Taman Makam Pahlawan No. 19, Purwodadi, Kecamatan Purwodadi`;
        }
    }
    
    // Function to update level with proper text
    function updateLevel() {
        const levelValue = level.value;
        let levelText = 'Privilege';
        
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
        const emailValue = email.value || 'email@example.com';
        previewEmail.innerHTML = '<i class="ti-email"></i> ' + emailValue;
    }
    
    // Function to update phone
    function updatePhone() {
        const phoneValue = phone.value || '0000-0000-0000';
        previewPhone.innerHTML = '<i class="ti-tablet"></i> ' + phoneValue;
    }
    
    // Function to update address
    function updateAddress() {
        updateDescription();
    }
    
    // Function to handle image preview
    function handleImagePreview() {
        const file = fotoInput.files[0];
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                fotoInput.value = '';
                previewImg.src = defaultImage;
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                fotoInput.value = '';
                previewImg.src = defaultImage;
                return;
            }
            
            // Create preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            previewImg.src = defaultImage;
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
    
    // Initialize preview with existing values (for old() function)
    updateName();
    updateLevel();
    updateEmail();
    updatePhone();
    updateAddress();
});
</script>
<?= $this->endSection(); ?>