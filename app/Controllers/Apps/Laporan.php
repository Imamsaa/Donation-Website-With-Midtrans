<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DonasiModel;
use App\Models\ProgramModel;

class Laporan extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->donasiModel = new DonasiModel;
        $this->programModel = new ProgramModel;
        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index()
    {
        // Get filter parameters
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');
        $programFilter = $this->request->getGet('program_filter');
        
        $referral = session()->get('referral');

        // Build base query
        $query = $this->donasiModel
            ->join('program', 'program.program_id = donasi.program_id')
            ->where('status', 'success');
        
        // Apply date filter if provided
        if ($startDate && $endDate) {
            $query->where('DATE(donasi.created_at) >=', $startDate)
                  ->where('DATE(donasi.created_at) <=', $endDate);
        }
        
        // Apply program filter if provided
        if ($programFilter && !empty($programFilter)) {
            $query->groupStart()
                  ->like('program.title', $programFilter)
                  ->orLike('program.slug', $programFilter)
                  ->groupEnd();
        }
        
        $donasi = $query->findAll();

        // Get all programs for dropdown filter
        $allPrograms = $this->programModel->select('program_id, title, slug')->findAll();

        $data = [
            'donasi' => $donasi,
            'title' => 'Laporan',
            'active' => 'laporan',
            'start_date' => $startDate,
            'end_date' => $endDate,
            'program_filter' => $programFilter,
            'all_programs' => $allPrograms,
        ];
        
        // Load the laporan view
        if (session()->get('level') != 'fundraiser') {
            return view('apps/pages/laporan', $data);
        } else {
            // Build fundraiser specific query
            $fundraiserQuery = $this->donasiModel
                ->select('*, COALESCE(SUM(donasi.amount), 0) AS kontribusi')
                ->join('fundraiser', 'fundraiser.referral = donasi.referral')
                ->join('program', 'program.program_id = donasi.program_id')
                ->where('status', 'success')
                ->where('fundraiser.referral', $referral);
                
            // Apply date filter for fundraiser if provided
            if ($startDate && $endDate) {
                $fundraiserQuery->where('DATE(donasi.created_at) >=', $startDate)
                              ->where('DATE(donasi.created_at) <=', $endDate);
            }
            
            // Apply program filter for fundraiser if provided
            if ($programFilter && !empty($programFilter)) {
                $fundraiserQuery->groupStart()
                              ->like('program.title', $programFilter)
                              ->orLike('program.slug', $programFilter)
                              ->groupEnd();
            }
            
            $donasi = $fundraiserQuery
                ->groupBy('program.program_id, program.title, program.target_donate')
                ->findAll();
                
            $data = [
                'donasi' => $donasi,
                'title' => 'Laporan',
                'active' => 'laporan',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'program_filter' => $programFilter,
                'all_programs' => $allPrograms,
            ];
            return view('apps/pages/laporanfund', $data);
        }
    }

    public function list($slug)
    {
        $data = [
            'title' => 'Detail Laporan',
            'active' => 'laporan',
            'id' => $slug,
        ];
        
        // Load the detail laporan view
        if (session()->get('level') != 'fundraiser') {
            return view('apps/pages/laporan/list', $data);
        }else{
            
            // Get filter parameters
            $startDate = $this->request->getGet('start_date');
            $endDate = $this->request->getGet('end_date');
            $programFilter = $this->request->getGet('program_filter');
            
            $referral = session()->get('referral');

            // Build base query
            $query = $this->donasiModel
                ->join('program', 'program.program_id = donasi.program_id')
                ->where('slug', $slug)
                ->where('referral', $referral)
                ->where('status', 'success');
            
            // Apply date filter if provided
            if ($startDate && $endDate) {
                $query->where('DATE(donasi.created_at) >=', $startDate)
                    ->where('DATE(donasi.created_at) <=', $endDate);
            }
            
            // Apply program filter if provided
            if ($programFilter && !empty($programFilter)) {
                $query->groupStart()
                      ->like('program.title', $programFilter)
                      ->orLike('program.slug', $programFilter)
                      ->groupEnd();
            }
            
            $donasi = $query->findAll();

            // Get all programs for dropdown filter
            $allPrograms = $this->programModel->select('program_id, title, slug')->findAll();

            $data = [
                'donasi' => $donasi,
                'title' => 'Laporan',
                'active' => 'laporan',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'program_filter' => $programFilter,
                'all_programs' => $allPrograms,
                'slug' => $slug
            ];
            
            return view('apps/pages/laporan/listfund', $data);
        }
    }
}