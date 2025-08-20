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
                            <h4 class="text-black">TAMBAH PROGRAM</h4>
                        </div>
                        <form class="form" action="<?= base_url('apps/program/save') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Judul Program</label>
                                <input type="text" value="<?= old('title') ?>" class="form-control" id="title" name="title" placeholder="Judul Program">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Deskripsi"><?= old('description') ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="target_donate">Target Donasi</label>
                                <input type="text" class="form-control" name="target_donate" id="target_donate" value="<?= old('target_donate') ?>" name="target" placeholder="Target Donasi">
                            </div>
                            <div class="form-group">
                                <label for="photo">Gambar Program</label>
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
                            <img src="<?= base_url('public/dist/img/img1.jpg') ?>" alt="Foto Profil" class="mb-2 w-full img-thumbnail" id="preview-image">
                        </div>
                        <h4 id="preview-title">Judul Program</h4>
                        <div class="progress mb-3" style="height: 15px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 0%; height: 15px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <div class="mb-3 text-center">
                                <span class="mr-2 d-block"></i> Target :</span>
                                <span class="mr-2 d-block" id="preview-target"></i>Rp. 0</span>
                            </div>
                            <div class="mb-3 text-center">
                                <span class="mr-2 d-block"></i> Total :</span>
                                <span class="mr-2 d-block"></i>Rp. 0</span>
                            </div>
                        </div>
                        <p id="preview-description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Real-time preview for title
    const titleInput = document.getElementById('title');
    const previewTitle = document.getElementById('preview-title');
    
    titleInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewTitle.textContent = value || 'Judul Program';
    });

    // Real-time preview for description
    const descriptionInput = document.getElementById('description');
    const previewDescription = document.getElementById('preview-description');
    
    descriptionInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewDescription.textContent = value || '';
    });

    // Real-time preview for target donation
    const targetInput = document.getElementById('target_donate');
    const previewTarget = document.getElementById('preview-target');
    
    targetInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value) {
            previewTarget.textContent = 'Rp. ' + value;
        } else {
            previewTarget.textContent = 'Rp. 0';
        }
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