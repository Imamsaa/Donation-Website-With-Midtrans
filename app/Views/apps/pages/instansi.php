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
        <h4 class="text-black">PROFIL INSTANSI</h4>
      </div>
                <form class="form" action="<?= base_url('apps/instansi/update') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name">Nama Instansi</label>
                    <input type="text" value="<?= old('name', $ins['name']) ?>" class="form-control" id="name" name="name" placeholder="Nama Instansi">
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi</label>
                    <textarea class="form-control" name="description" id="description" rows="10" placeholder="Deskripsi"><?= old('description', $ins['description']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="address">Alamat</label>
                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat"><?= old('address', $ins['address']) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" value="<?= old('email', $ins['email']) ?>" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" value="<?= old('phone', $ins['phone']) ?>" name="phone" placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="facebook">Facebook</label>
                    <input type="text" class="form-control" id="facebook" value="<?= old('facebook', $ins['facebook']) ?>" name="facebook" placeholder="Facebook">
                </div>
                <div class="form-group">
                    <label for="instagram">Instagram</label>
                    <input type="text" class="form-control" id="instagram" value="<?= old('instagram', $ins['instagram']) ?>" name="instagram" placeholder="Instagram">
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" class="form-control" id="website" value="<?= old('website', $ins['website']) ?>" name="website" placeholder="Website">
                </div>
                
                <div class="form-group">
                    <label for="logo" >Logo Instansi</label>
                    <input type="file" id="logo" name="logo" class="dropify" data-max-file-size="2M" />
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
            <img src="<?= base_url('public/uploads/'.$ins['logo']) ?>" alt="Logo Instansi" class="mb-2 img-fluid img-circle w-50" id="preview-logo">
            <h4 id="preview-name"><?= $ins['name'] ?></h4>
        </div>
        <p>Deskripsi :</p>
        <p id="preview-description"><?= $ins['description'] ?></p>
        <p>Contact :</p>
        <div class="d-block">
            <span><i class="ti-email"></i> <span id="preview-email"><?= $ins['email'] ?></span></span>
        </div>
        <div class="d-block" id="preview-phone-container" <?= empty($ins['phone']) ? 'style="display: none;"' : '' ?>>
            <span><i class="ti-tablet"></i> <span id="preview-phone"><?= $ins['phone'] ?></span></span>
        </div>
        <p class="mt-2">Sosial Media :</p>
        <a href="#" class="text-black mt-1 mr-2" id="preview-facebook-link" <?= empty($ins['facebook']) ? 'style="display: none;"' : '' ?>><span><i class="ti-facebook"></i></span></a>
        <a href="#" class="text-black mt-1 mr-2" id="preview-instagram-link" <?= empty($ins['instagram']) ? 'style="display: none;"' : '' ?>><span><i class="ti-instagram"></i></span></a>
        <a href="#" class="text-black mt-1 mr-2" id="preview-website-link" <?= empty($ins['website']) ? 'style="display: none;"' : '' ?>><span><i class="ti-wordpress"></i></span></a>
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
        name: '<?= $ins['name'] ?>',
        description: `<?= str_replace(["\r\n", "\n", "\r"], "\\n", addslashes($ins['description'])) ?>`,
        email: '<?= $ins['email'] ?>',
        phone: '<?= $ins['phone'] ?? '' ?>',
        facebook: '<?= $ins['facebook'] ?? '' ?>',
        instagram: '<?= $ins['instagram'] ?? '' ?>',
        website: '<?= $ins['website'] ?? '' ?>'
    };

    // Elements
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const facebookInput = document.getElementById('facebook');
    const instagramInput = document.getElementById('instagram');
    const websiteInput = document.getElementById('website');
    const logoInput = document.getElementById('logo');
    
    // Preview elements
    const previewName = document.getElementById('preview-name');
    const previewDescription = document.getElementById('preview-description');
    const previewEmail = document.getElementById('preview-email');
    const previewPhone = document.getElementById('preview-phone');
    const previewPhoneContainer = document.getElementById('preview-phone-container');
    const previewFacebookLink = document.getElementById('preview-facebook-link');
    const previewInstagramLink = document.getElementById('preview-instagram-link');
    const previewWebsiteLink = document.getElementById('preview-website-link');
    const previewLogo = document.getElementById('preview-logo');

    // Function to update preview
    function updatePreview() {
        // Update nama
        const name = nameInput.value.trim() || defaultData.name;
        previewName.textContent = name;
        
        // Update deskripsi
        const description = descriptionInput.value.trim() || defaultData.description.replace(/\\n/g, '\n');
        previewDescription.textContent = description;
        
        // Update email
        const email = emailInput.value.trim() || defaultData.email;
        previewEmail.textContent = email;
        
        // Update phone
        const phone = phoneInput.value.trim() || defaultData.phone;
        if (phone) {
            previewPhone.textContent = phone;
            previewPhoneContainer.style.display = 'block';
        } else {
            previewPhoneContainer.style.display = 'none';
        }
        
        // Update social media links
        const facebook = facebookInput.value.trim() || defaultData.facebook;
        const instagram = instagramInput.value.trim() || defaultData.instagram;
        const website = websiteInput.value.trim() || defaultData.website;
        
        // Show/hide social media icons
        previewFacebookLink.style.display = facebook ? 'inline-block' : 'none';
        previewInstagramLink.style.display = instagram ? 'inline-block' : 'none';
        previewWebsiteLink.style.display = website ? 'inline-block' : 'none';
        
        // Update href attributes
        if (facebook) previewFacebookLink.href = facebook;
        if (instagram) previewInstagramLink.href = instagram;
        if (website) previewWebsiteLink.href = website;
    }

    // Event listeners untuk input
    nameInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    emailInput.addEventListener('input', updatePreview);
    phoneInput.addEventListener('input', updatePreview);
    facebookInput.addEventListener('input', updatePreview);
    instagramInput.addEventListener('input', updatePreview);
    websiteInput.addEventListener('input', updatePreview);

    // Logo preview
    logoInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewLogo.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>

<?= $this->endSection(); ?>