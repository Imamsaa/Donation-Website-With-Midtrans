<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProgramModel;

class Program extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        helper('text');
        $this->programModel = new ProgramModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $program = $this->programModel->paginate(6);
        $pager = $this->programModel->pager;
        $data = [
            'program' => $program,
            'pager' => $pager,
            'title' => 'Program Kami',
            'description' => 'Program Donasi',
            'keyword' => 'program, active, donasi'
        ];
        // Load the view for the program page
        return view('pages/program',$data);
    }

    public function detail($slug, $referral = '')
    {
        $program = $this->programModel->where('slug', $slug)->first();
        $data = [
            'referral' => $referral,
            'program' => $program,
            'title' => 'Detail Program Donasi',
            'description' => 'Detail Program Donasi',
            'keyword' => 'detail, program, active, donasi'
        ];
        // Load the view for the program detail page
        return view('pages/detail', $data);
    }
}
