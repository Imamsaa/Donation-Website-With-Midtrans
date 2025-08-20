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
                            <h4 class="text-black">EDIT PROGRAM</h4>       
                        </div>                 
                        <form class="form" action="<?= base_url('apps/program/update/'.$program['slug']) ?>" method="post" enctype="multipart/form-data">                 
                            <div class="form-group">                     
                                <label for="title">Judul Program</label>                     
                                <input type="text" class="form-control" value="<?= old('title', $program['title']) ?>" id="title" name="title" placeholder="Judul Program">                 
                            </div>                 
                            <div class="form-group">                     
                                <label for="description">Deskripsi</label>                     
                                <textarea class="form-control" name="description" id="description" rows="3" placeholder="Deskripsi"><?= old('description', $program['description']) ?></textarea>                 
                            </div>                 
                            <div class="form-group">                     
                                <label for="target_donate">Target Donasi</label>                     
                                <input type="text" class="form-control" value="<?= old('target_donate', $program['target_donate']) ?>" id="target_donate" name="target_donate" placeholder="Target Donasi">                 
                            </div>                                  
                            <div class="form-group">                     
                                <label for="photo">Gambar Program</label>                     
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
                            <img src="<?= base_url('public/uploads/programs/'.$program['photo']) ?>" alt="Foto Profil" class="mb-2 w-full img-thumbnail" id="preview-photo">         
                        </div>         
                        <h4 id="preview-title"><?= $program['title'] ?></h4>         
                        <div class="progress mb-3" style="height: 15px;">             
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= ($program['total_donate']/$program['target_donate']*100) ?>%; height: 15px;" aria-valuenow="<?= ($program['total_donate']/$program['target_donate']*100) ?>" aria-valuemin="0" aria-valuemax="100"><?= ($program['total_donate']/$program['target_donate']*100) ?>%</div>         
                        </div>         
                        <div class="d-flex justify-content-between mb-3">             
                            <div class="mb-3 text-center">                 
                                <span class="mr-2 d-block"></i> Target :</span>                 
                                <span class="mr-2 d-block" id="preview-target">Rp. <?= number_format($program['target_donate'],0,'.','.') ?></span>             
                            </div>             
                            <div class="mb-3 text-center">                 
                                <span class="mr-2 d-block"></i> Total :</span>                 
                                <span class="mr-2 d-block"></i>Rp. <?= number_format($program['target_donate'],0,'.','.') ?></span>             
                            </div>         
                        </div>         
                        <p id="preview-description"><?= $program['description'] ?></p>              
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
        title: '<?= $program['title'] ?>',
        description: '<?= addslashes($program['description']) ?>',
        target_donate: '<?= number_format($program['target_donate'],0,'.','.') ?>'
    };

    // Elements
    const titleInput = document.getElementById('title');
    const descriptionInput = document.getElementById('description');
    const targetDonateInput = document.getElementById('target_donate');
    const photoInput = document.getElementById('photo');
    
    // Preview elements
    const previewTitle = document.getElementById('preview-title');
    const previewDescription = document.getElementById('preview-description');
    const previewTarget = document.getElementById('preview-target');
    const previewPhoto = document.getElementById('preview-photo');

    // Function to update preview
    function updatePreview() {
        // Update title
        const title = titleInput.value.trim() || defaultData.title;
        previewTitle.textContent = title;
        
        // Update description
        const description = descriptionInput.value.trim() || defaultData.description;
        previewDescription.textContent = description;
        
        // Update target donate
        const target = targetDonateInput.value.trim() || defaultData.target_donate;
        previewTarget.textContent = 'Rp. ' + target;
    }

    // Event listeners
    titleInput.addEventListener('input', updatePreview);
    descriptionInput.addEventListener('input', updatePreview);
    targetDonateInput.addEventListener('input', updatePreview);

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