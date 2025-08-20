<?= $this->extend('apps/index'); ?>
<?= $this->section('content'); ?>

<div class="content-wrapper"> 
  <div class="content">
    <div class="card">
      <div class="card-body">
        <div class="d-flex mb-3">
          <h4 class="text-black">LIST PROGRAM</h4>
        </div>
        <div class="table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>NO</th>
                <th>NAMA PROGRAM</th>
                <th>TARGET</th>
                <th>TOTAL</th>
                <th>ACTION</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              foreach($program as $p) :
                  $link = base_url('program/detail/'.$p['slug'].'/'.session()->get('referral'));
              ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['title'] ?></td>
                <td>Rp. <?= number_format($p['target_donate'],0,'.','.') ?></td>
                <td>Rp. <?= number_format($p['total_donate'],0,'.','.') ?></td>
                <td>
                  <button 
                    type="button"
                    class="btn btn-primary btn-sm copy-btn" 
                    data-link="<?= $link ?>"
                  >Copy Link</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th>NO</th>
                <th>NAMA PROGRAM</th>
                <th>TARGET</th>
                <th>TOTAL</th>
                <th>ACTION</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
  const buttons = document.querySelectorAll(".copy-btn");

  buttons.forEach(btn => {
    btn.addEventListener("click", function(){
      const link = this.getAttribute("data-link");

      navigator.clipboard.writeText(link).then(() => {
        // Tampilkan SweetAlert Toast
        const toast = {
          status: 'success',
          message: 'Link berhasil disalin!'
        };
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toastEl) => {
            toastEl.addEventListener('mouseenter', Swal.stopTimer)
            toastEl.addEventListener('mouseleave', Swal.resumeTimer)
          }
        });
        Toast.fire({
          icon: toast.status,
          title: toast.message
        });
      }).catch(err => {
        console.error("Gagal menyalin link: ", err);
      });
    });
  });
});
</script>

<?= $this->endSection(); ?>
