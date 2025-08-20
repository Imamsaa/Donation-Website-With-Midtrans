<?php
use App\Models\InstansiModel;
$this->instansiModel = new InstansiModel();
$ins = $this->instansiModel->select('name')->first();
?>
<footer class="main-footer">
    <div class="pull-right hidden-xs">Version 1.0</div>
    Copyright © 2025 <?= $ins['name'] ?>. All rights reserved.</footer>
  
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark"> 
    <!-- Tab panes -->
    <div class="tab-content"> 
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab"></div>
      <!-- /.tab-pane --> 
    </div>
  </aside>
  <!-- /.control-sidebar --> 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper --> 
<?php
use App\Models\ProgramModel;
$this->programModel = new ProgramModel();
$program = $this->programModel->findAll();
foreach($program as $p) : 
?>
<!-- MODAL -->
<div class="modal fade" id="exampleModal<?= $p['slug'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Donasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form" id="donasi<?= $p['slug'] ?>" name="donasi<?= $p['slug'] ?>" action="<?= base_url('apps/donasi/saveAdmin/'.$p['slug']) ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Donatur</label>
                <input type="text" class="form-control" id="name" value="<?= old('name') ?>" name="name" placeholder="Nama Donatur">
            </div>
            <div class="form-group">
                <label for="amount">Jumlah Donasi</label>
                <input type="text" class="form-control" id="amount" value="<?= old('amount') ?>" name="amount" placeholder="Jumlah Donasi">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="anonim" value="ya">
                    Anonim 
                </label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" form="donasi<?= $p['slug'] ?>" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?php
use App\Models\DonasiModel;
$this->donasiModel = new DonasiModel();
$donasi = $this->donasiModel
    ->join('program AS p', 'p.program_id = donasi.program_id')
    ->findAll();
foreach($donasi as $d) : 
?>
<!-- MODAL -->
<div class="modal fade" id="exampleModalEdit<?= $d['donasi_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Donasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form" id="editdonasi<?= $d['donasi_id'] ?>" name="editdonasi<?= $d['donasi_id'] ?>" action="<?= base_url('apps/donasi/updateAdmin/'.$d['slug']).'/'.$d['donasi_id'] ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nama Donatur</label>
                <input type="text" class="form-control" id="name" value="<?= old('name',$d['name']) ?>" name="name" placeholder="Nama Donatur">
            </div>
            <div class="form-group">
                <label for="amount">Jumlah Donasi</label>
                <input type="text" class="form-control" id="amount" value="<?= old('amount',$d['amount']) ?>" name="amount" placeholder="Jumlah Donasi">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="anonim" value="ya" <?= (old('anonim') == 'ya' OR $d['anonim'] =='ya') ? 'checked' : '' ?> >
                    Anonim 
                </label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Batal</button>
        <button type="submit" form="editdonasi<?= $d['donasi_id'] ?>" class="btn btn-sm btn-primary">Submit</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<!-- jQuery 3 --> 
<script src="<?= base_url('public/dist/js/jquery.min.js') ?>"></script>  
<script src="<?= base_url('public/dist/bootstrap/js/bootstrap.min.js') ?>"></script> 

<!-- template --> 
<script src="<?= base_url('public/dist/js/bizadmin.js') ?>"></script> 

<!-- Jquery Sparklines --> 
<script src="<?= base_url('public/dist/plugins/jquery-sparklines/jquery.sparkline.min.js') ?>"></script> 
<script src="<?= base_url('public/dist/plugins/jquery-sparklines/sparkline-int.js') ?>"></script> 

<!-- Morris JavaScript --> 
<script src="<?= base_url('public/dist/plugins/raphael/raphael-min.js') ?>"></script> 
<script src="<?= base_url('public/dist/plugins/morris/morris.js') ?>"></script> 
<script src="<?= base_url('public/dist/plugins/functions/dashboard1.js') ?>"></script> 


<!-- DataTable --> 
<script src="<?= base_url('public/dist/plugins/datatables/jquery.dataTables.min.js') ?>"></script> 
<script src="<?= base_url('public/dist/plugins/datatables/dataTables.bootstrap.min.js') ?>"></script> 
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>


<!-- Chartjs JavaScript --> 
<script src="<?= base_url('public/dist/plugins/chartjs/chart.min.js') ?>"></script>
<script src="<?= base_url('public/dist/plugins/chartjs/chart-int.js') ?>"></script>

<script src="<?= base_url('public/dist/plugins/table-expo/filesaver.min.js') ?>"></script>
<script src="<?= base_url('public/dist/plugins/table-expo/xls.core.min.js') ?>"></script>
<script src="<?= base_url('public/dist/plugins/table-expo/tableexport.js') ?>"></script>
<script>
$("table").tableExport({formats: ["xlsx","xls", "csv", "txt"],    });
</script>

<!-- form wizard --> 
<script src="<?= base_url('public/dist/plugins/formwizard/jquery-steps.js') ?>"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script> 
<script>
    var frmRes = $('#frmRes');
    var frmResValidator = frmRes.validate();
	
    var frmInfo = $('#frmInfo');
    var frmInfoValidator = frmInfo.validate();

    var frmLogin = $('#frmLogin');
    var frmLoginValidator = frmLogin.validate();

    var frmMobile = $('#frmMobile');
    var frmMobileValidator = frmMobile.validate();

    $('#demo1').steps({
      onChange: function (currentIndex, newIndex, stepDirection) {
        console.log('onChange', currentIndex, newIndex, stepDirection);
        // tab1
        if (currentIndex === 0) {
          if (stepDirection === 'forward') {
            var valid = frmRes.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmResValidator.resetForm();
          }
        }
		
		// tab2
        if (currentIndex === 1) {
          if (stepDirection === 'forward') {
            var valid = frmInfo.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmInfoValidator.resetForm();
          }
        }

        // tab3
        if (currentIndex === 2) {
          if (stepDirection === 'forward') {
            var valid = frmLogin.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmLoginValidator.resetForm();
          }
        }

        // tab4
        if (currentIndex === 3) {
          if (stepDirection === 'forward') {
            var valid = frmMobile.valid();
            return valid;
          }
          if (stepDirection === 'backward') {
            frmMobileValidator.resetForm();
          }
        }

        return true;

      },
      onFinish: function () {
        alert('Wizard Completed');
      }
    });
  </script> 
<script>
    $('#demo').steps({
      onFinish: function () {
        alert('Wizard Completed');
      }
    });
</script>

<!-- dropify --> 
<script src="<?= base_url('public/dist/plugins/dropify/dropify.min.js') ?>"></script> 
<script>
	$(document).ready(function(){
	// Basic
	$('.dropify').dropify();

	// Translated
	 $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
    });
</script>

<!--Start of Tawk.to Script-->
<!-- <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5b7257d2afc2c34e96e78bfc/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script> -->
<!--End of Tawk.to Script-->
 <!-- SweetAlert2 -->
    <script src="<?= base_url('public/plugins/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>
 <script>
$(function () {
  // Logout confirmation
      $('.logout-link').on('click', function(e) {
          e.preventDefault();
          const url = $(this).attr('href');
          
          Swal.fire({
              title: 'Yakin ingin logout?',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya, Logout',
              cancelButtonText: 'Batal'
          }).then((result) => {
              if (result.isConfirmed) {
                  window.location.href = url;
              }
          });
      });
        // Notification handling
        <?php if (session()->has('kotakok')) : ?>
            const notif = <?= json_encode(session('kotakok')) ?>;
            Swal.fire({
                icon: notif.status,
                title: notif.title,
                text: notif.message
            });
        <?php endif; ?>

        <?php if (session()->has('pojokatas')) : ?>
            const toast = <?= json_encode(session('pojokatas')) ?>;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: toast.status,
                title: toast.message
            });
        <?php endif; ?>
          });
    </script>
    <?php if (session()->getFlashdata('snap_url')): ?>
        <script>
            let snapUrl = "<?= session()->getFlashdata('snap_url'); ?>";
            window.open(snapUrl, "_blank"); // buka di tab baru
        </script>
    <?php endif; ?>
</body>
</html>
