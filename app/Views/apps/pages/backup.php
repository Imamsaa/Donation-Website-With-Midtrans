<?= $this->extend('apps/index'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content">
        
        <!-- Alert Messages -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Backup Section -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <h4 class="text-black">BACKUP DATA</h4>
                </div>
                <p>Backup dapat dilakukan kapan saja melalui antarmuka ini sebelum maintenance sistem.</p>
                
                <div class="d-flex gap-2">
                    <!-- Form untuk backup biasa -->
                    <form id="backupForm" action="<?= base_url('apps/backup/create') ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-primary mx-1 mb-3" onclick="return confirmBackup()">
                            Backup Sekarang
                        </button>
                    </form>
                    
                    <!-- Form untuk backup dan download langsung -->
                    <form id="backupDownloadForm" action="<?= base_url('apps/backup/create') ?>" method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <input type="hidden" name="download" value="true">
                        <button type="submit" class="btn btn-success mx-1 mb-3" onclick="return confirmBackupDownload()">
                            Backup & Download
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-info mx-1 mb-3" onclick="refreshBackupList()">
                        Refresh List
                    </button>
                </div>
            </div>
        </div>

        <!-- Backup Files List -->
        <?php if (isset($backupFiles) && !empty($backupFiles)): ?>
        <div class="card">
            <div class="card-body">
                <div class="d-flex mb-3">
                    <h4 class="text-black">DAFTAR FILE BACKUP</h4>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="backupTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>anggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($backupFiles as $index => $file): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <span class="badge badge-primary me-1">SQL</span>
                                        <?= esc($file['name']) ?>
                                    </td>
                                    <td><?= esc($file['size']) ?></td>
                                    <td>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($file['date'])) ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('apps/backup/download/' . $file['name']) ?>" 
                                               class="btn btn-success btn-sm" 
                                               title="Download">
                                                Download
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-danger btn-sm" 
                                                    onclick="deleteBackup('<?= $file['name'] ?>')"
                                                    title="Hapus">
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h5 id="loadingText">Memproses...</h5>
                <p class="text-muted mb-0">Mohon tunggu, jangan tutup halaman ini.</p>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize dropify
$(document).ready(function() {
    $('.dropify').dropify({
        messages: {
            'default': 'Drag dan drop file atau klik untuk memilih',
            'replace': 'Drag dan drop atau klik untuk mengganti',
            'remove': 'Hapus',
            'error': 'Error, file tidak valid.'
        },
        error: {
            'fileSize': 'Ukuran file terlalu besar (maksimal 10MB)',
            'fileExtension': 'Format file tidak diizinkan (hanya SQL)'
        }
    });

    // Initialize DataTable if exists
    if ($('#backupTable').length) {
        $('#backupTable').DataTable({
            "pageLength": 10,
            "ordering": true,
            "searching": true,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ data per halaman",
                "zeroRecords": "Data tidak ditemukan",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(difilter dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    }
});

// Function to confirm backup
function confirmBackup() {
    $('#loadingText').text('Membuat backup database...');
    $('#loadingModal').modal('show');
    return true;
}

// Function to confirm backup and download
function confirmBackupDownload() {
    $('#loadingText').text('Membuat backup database dan mempersiapkan download...');
    $('#loadingModal').modal('show');
    return true;
}

// Function to confirm restore
function confirmRestore() {
    event.preventDefault();
    
    const fileInput = document.getElementById('backup_file');
    if (!fileInput.files.length) {
        Swal.fire('Error!', 'Silakan pilih file backup terlebih dahulu.', 'error');
        return false;
    }

    Swal.fire({
        title: 'Konfirmasi Restore',
        html: `
            <p>Apakah Anda yakin ingin melakukan restore database?</p>
            <div class="alert alert-warning text-start mt-3">
                <strong>Peringatan:</strong>
                <ul class="mb-0">
                    <li>Seluruh data saat ini akan digantikan</li>
                    <li>Backup otomatis akan dibuat sebelum restore</li>
                    <li>Proses ini tidak dapat dibatalkan</li>
                </ul>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f39c12',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Restore!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#loadingText').text('Melakukan restore database...');
            $('#loadingModal').modal('show');
            document.getElementById('restoreForm').submit();
        }
    });
    
    return false;
}

// Function to delete backup
function deleteBackup(filename) {
    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: `Apakah Anda yakin ingin menghapus file backup "${filename}"?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `<?= base_url('apps/backup/delete/') ?>${filename}`;
        }
    });
}

// Function to refresh backup list
function refreshBackupList() {
    location.reload();
}

// Hide loading modal when page loads
$(window).on('load', function() {
    $('#loadingModal').modal('hide');
});

// Show loading on form submission
$('#backupForm, #backupDownloadForm').on('submit', function() {
    $('#loadingModal').modal('show');
});
</script>

<?= $this->endSection(); ?>