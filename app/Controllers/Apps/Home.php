<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\DonasiModel;
use App\Models\DonaturModel;
use App\Models\ProgramModel;

class Home extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->usersModel = new UsersModel();
        $this->donasiModel = new DonasiModel();
        $this->donaturModel = new DonaturModel();
        $this->programModel = new ProgramModel();
        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
        ];
        // Load the view for the home page
        $sesi = session()->get('level');
        if ($sesi == 'admin') {
            $data['total_user'] = $this->usersModel->countAll();
            $data['total_donatur'] = $this->donaturModel->countAll();
            $data['total_program'] = $this->programModel->countAll();
            $donasi_masuk = $this->donasiModel
                    ->selectSum('amount', 'total_amount')
                    ->where('status', 'success')
                    ->get()
                    ->getRow();
            $data['total_donasi'] = $donasi_masuk->total_amount ?? 0;
            $program = $this->programModel->findAll();
            $data['program'] = $program;
            return view('apps/pages/home/admin', $data);
        }
        else if($sesi == 'ketua'){
            $data['total_user'] = $this->usersModel->countAll();
            $data['total_donatur'] = $this->donaturModel->countAll();
            $data['total_program'] = $this->programModel->countAll();
            $donasi_masuk = $this->donasiModel
                    ->selectSum('amount', 'total_amount')
                    ->where('status', 'success')
                    ->get()
                    ->getRow();
            $data['total_donasi'] = $donasi_masuk->total_amount ?? 0;
            $program = $this->programModel->findAll();
            $data['program'] = $program;
            return view('apps/pages/home/ketua', $data);
        }
        else if($sesi == 'bendahara'){
            $data['total_user'] = $this->usersModel->countAll();
            $data['total_donatur'] = $this->donaturModel->countAll();
            $data['total_program'] = $this->programModel->countAll();
            $donasi_masuk = $this->donasiModel
                    ->selectSum('amount', 'total_amount')
                    ->where('status', 'success')
                    ->get()
                    ->getRow();
            $data['total_donasi'] = $donasi_masuk->total_amount ?? 0;
            $program = $this->programModel->findAll();
            $data['program'] = $program;
            return view('apps/pages/home/bendahara', $data);
        }
        else if($sesi == 'fundraiser'){
            $data['total_donatur'] = $this->donaturModel->countAll();
            $data['total_program'] = $this->programModel->countAll();
            $donasi_masuk = $this->donasiModel
                    ->selectSum('amount', 'total_amount')
                    ->where('status', 'success')
                    ->get()
                    ->getRow();
            $data['total_donasi'] = $donasi_masuk->total_amount ?? 0;
            $donasi_bulan_ini = $this->donasiModel
            ->selectSum('amount', 'total_amount')
            ->where('status', 'success')
            ->where('MONTH(created_at)', date('m'))
            ->where('YEAR(created_at)', date('Y'))
            ->get()
            ->getRow();

            $data['total_donasi_bulan_ini'] = $donasi_bulan_ini->total_amount ?? 0;
            $program = $this->programModel->findAll();
            $data['program'] = $program;
            return view('apps/pages/home/fundraiser', $data);
        }
        else if($sesi == 'donatur'){
            $donatur = session()->get('user_id');
            $data['program'] = $this->programModel
                ->select('program.*, SUM(donasi.amount) as total_amount')
                ->join('donasi', 'donasi.program_id = program.program_id')
                ->where('donatur_id', $donatur)
                ->groupBy('program.program_id')
                ->findAll();
            return view('apps/pages/home/donatur', $data);
        }
    }
}
