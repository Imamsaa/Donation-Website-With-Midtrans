<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DonasiModel;

class Riwayat extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->donasiModel = new DonasiModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        // Get date filter parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $donatur_id = session()->get('user_id');
        // Build base query
        $query = $this->donasiModel
            ->join('program', 'program.program_id = donasi.program_id')
            ->where('donatur_id', $donatur_id)
            ->where('status', 'success');
        
        // Apply date filter if provided
        if ($startDate && $endDate) {
            $query->where('DATE(donasi.created_at) >=', $startDate)
                  ->where('DATE(donasi.created_at) <=', $endDate);
        }
        
        $donasi = $query->findAll();

        $data = [
            'donasi' => $donasi,
            'title' => 'Riwayat Donasi',
            'active' => 'riwayat',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        // Load the riwayat view
        return view('apps/pages/riwayat', $data);
    }
}
