<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Backup extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Backup',
            'active' => 'backup',
            'backupFiles' => $this->getBackupFiles()
        ];
        
        // Load the backup view
        return view('apps/pages/backup', $data);
    }

    /**
     * Membuat backup database (method asli yang diperbaiki)
     */
    public function create()
    {
        try {
            helper(['filesystem', 'download']);

            // Buat direktori backup jika belum ada
            $savePath = WRITEPATH . 'uploads/backups/';
            if (!is_dir($savePath)) {
                mkdir($savePath, 0777, true);
            }

            // Ambil koneksi database
            $db = \Config\Database::connect();

            // Coba gunakan DB Utility jika tersedia
            try {
                // Load DB Utility
                $forge = \Config\Database::forge($db);
                
                // Method alternatif untuk backup
                $tables = $db->listTables();
                if (empty($tables)) {
                    return redirect()->back()->with('error', 'Tidak ada tabel yang ditemukan untuk di-backup');
                }

                // Generate backup content manually
                $backup = $this->generateSQLBackup($tables, $db);
                $fileName = 'backup-' . date('Y-m-d-His') . '.sql';

            } catch (\Exception $e) {
                // Fallback jika DB Utility tidak tersedia
                log_message('info', 'DB Utility not available, using manual method: ' . $e->getMessage());
                
                $tables = $db->listTables();
                if (empty($tables)) {
                    return redirect()->back()->with('error', 'Tidak ada tabel yang ditemukan untuk di-backup');
                }

                $backup = $this->generateSQLBackup($tables, $db);
                $fileName = 'backup-' . date('Y-m-d-His') . '.sql';
            }

            $file = $savePath . $fileName;

            // Simpan file backup
            if (write_file($file, $backup)) {
                // Log aktivitas
                log_message('info', 'Backup created: ' . $fileName);
                
                // Cek apakah diminta download langsung
                if ($this->request->getPost('download') === 'true') {
                    // Download langsung ke browser
                    return $this->response
                        ->download($file, null)
                        ->setFileName($fileName);
                } else {
                    // Redirect dengan pesan sukses
                    return redirect()->back()->with('success', 'Backup berhasil dibuat: ' . $fileName);
                }
            } else {
                return redirect()->back()->with('error', 'Gagal menyimpan file backup');
            }

        } catch (\Exception $e) {
            log_message('error', 'Backup error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat backup: ' . $e->getMessage());
        }
    }

    /**
     * Download file backup
     */
    public function download($filename = null)
    {
        if (!$filename) {
            return redirect()->back()->with('error', 'Nama file tidak valid');
        }

        $backupPath = WRITEPATH . 'uploads/backups/';
        $filepath = $backupPath . $filename;

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan');
        }

        return $this->response->download($filepath, null);
    }

    /**
     * Restore database dari file backup
     */
    public function restore()
    {
        try {
            $file = $this->request->getFile('backup_file');

            // Validasi file
            if (!$file || !$file->isValid()) {
                return redirect()->back()->with('error', 'File tidak valid atau tidak ditemukan');
            }

            // Validasi ekstensi file
            if (strtolower($file->getExtension()) !== 'sql') {
                return redirect()->back()->with('error', 'Hanya file SQL yang diizinkan');
            }

            // Validasi ukuran file (maksimal 10MB)
            if ($file->getSizeByUnit('mb') > 10) {
                return redirect()->back()->with('error', 'Ukuran file terlalu besar (maksimal 10MB)');
            }

            // Baca konten file
            $sqlContent = file_get_contents($file->getTempName());
            
            if (empty($sqlContent)) {
                return redirect()->back()->with('error', 'File backup kosong atau tidak dapat dibaca');
            }

            // Backup database saat ini sebelum restore
            $this->createAutoBackup();

            // Proses restore
            if ($this->executeSqlRestore($sqlContent)) {
                log_message('info', 'Database restored from file: ' . $file->getName());
                return redirect()->back()->with('success', 'Data berhasil di-restore dari file: ' . $file->getName());
            } else {
                return redirect()->back()->with('error', 'Gagal melakukan restore data');
            }

        } catch (\Exception $e) {
            log_message('error', 'Restore error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat restore: ' . $e->getMessage());
        }
    }

    /**
     * Hapus file backup
     */
    public function delete($filename = null)
    {
        if (!$filename) {
            return redirect()->back()->with('error', 'Nama file tidak valid');
        }

        $backupPath = WRITEPATH . 'uploads/backups/';
        $filepath = $backupPath . $filename;

        if (!file_exists($filepath)) {
            return redirect()->back()->with('error', 'File backup tidak ditemukan');
        }

        if (unlink($filepath)) {
            log_message('info', 'Backup file deleted: ' . $filename);
            return redirect()->back()->with('success', 'File backup berhasil dihapus');
        } else {
            return redirect()->back()->with('error', 'Gagal menghapus file backup');
        }
    }

    /**
     * Generate SQL backup content manually
     */
    private function generateSQLBackup($tables, $db)
    {
        $backup = "-- Database Backup\n";
        $backup .= "-- Generated on: " . date('Y-m-d H:i:s') . "\n";
        $backup .= "-- Database: " . $db->getDatabase() . "\n\n";
        
        $backup .= "SET foreign_key_checks = 0;\n\n";

        foreach ($tables as $table) {
            // Skip tabel sessions dan cache jika ada
            if (in_array($table, ['ci_sessions', 'cache'])) {
                continue;
            }

            try {
                $backup .= "-- Table structure for table `{$table}`\n";
                $backup .= "DROP TABLE IF EXISTS `{$table}`;\n";
                
                // Get create table statement
                $createTable = $db->query("SHOW CREATE TABLE `{$table}`")->getRowArray();
                if ($createTable) {
                    $backup .= $createTable['Create Table'] . ";\n\n";
                }
                
                // Get table data
                $query = $db->table($table)->get();
                $rows = $query->getResultArray();
                
                if (!empty($rows)) {
                    $backup .= "-- Dumping data for table `{$table}`\n";
                    
                    foreach ($rows as $row) {
                        $values = array_map(function($value) {
                            if ($value === null) {
                                return 'NULL';
                            }
                            return "'" . addslashes($value) . "'";
                        }, $row);
                        
                        $columns = '`' . implode('`, `', array_keys($row)) . '`';
                        $valuesStr = implode(', ', $values);
                        
                        $backup .= "INSERT INTO `{$table}` ({$columns}) VALUES ({$valuesStr});\n";
                    }
                    $backup .= "\n";
                }
            } catch (\Exception $e) {
                log_message('error', "Error backing up table {$table}: " . $e->getMessage());
                $backup .= "-- Error backing up table {$table}: " . $e->getMessage() . "\n\n";
            }
        }
        
        $backup .= "SET foreign_key_checks = 1;\n";
        
        return $backup;
    }

    /**
     * Execute SQL restore
     */
    private function executeSqlRestore($sqlContent)
    {
        try {
            $db = \Config\Database::connect();
            
            // Split SQL commands
            $commands = array_filter(
                array_map('trim', explode(';', $sqlContent)),
                function($cmd) {
                    return !empty($cmd) && !preg_match('/^--/', $cmd);
                }
            );

            // Begin transaction
            $db->transStart();

            foreach ($commands as $command) {
                if (!empty(trim($command))) {
                    $db->query($command);
                }
            }

            // Complete transaction
            $db->transComplete();

            return $db->transStatus();

        } catch (\Exception $e) {
            log_message('error', 'SQL Restore error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Create automatic backup before restore
     */
    private function createAutoBackup()
    {
        try {
            $backupPath = WRITEPATH . 'uploads/backups/';
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $db = \Config\Database::connect();
            $tables = $db->listTables();
            
            $timestamp = date('Y-m-d_H-i-s');
            $filename = 'auto_backup_before_restore_' . $timestamp . '.sql';
            $filepath = $backupPath . $filename;

            $backupContent = $this->generateSQLBackup($tables, $db);
            write_file($filepath, $backupContent);
            
            log_message('info', 'Auto backup created: ' . $filename);
            
        } catch (\Exception $e) {
            log_message('error', 'Auto backup error: ' . $e->getMessage());
        }
    }

    /**
     * Get list of backup files
     */
    private function getBackupFiles()
    {
        $backupPath = WRITEPATH . 'uploads/backups/';
        
        if (!is_dir($backupPath)) {
            return [];
        }

        $files = [];
        
        try {
            $directory = new \DirectoryIterator($backupPath);
            
            foreach ($directory as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->getExtension() === 'sql') {
                    $files[] = [
                        'name' => $fileinfo->getFilename(),
                        'size' => $this->formatBytes($fileinfo->getSize()),
                        'date' => date('Y-m-d H:i:s', $fileinfo->getMTime()),
                        'path' => $fileinfo->getPathname()
                    ];
                }
            }

            // Sort by date, newest first
            usort($files, function($a, $b) {
                return strcmp($b['date'], $a['date']);
            });

        } catch (\Exception $e) {
            log_message('error', 'Error reading backup files: ' . $e->getMessage());
        }

        return $files;
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}