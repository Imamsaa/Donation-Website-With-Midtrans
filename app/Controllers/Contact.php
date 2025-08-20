<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InstansiModel;

class Contact extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->instansiModel = new InstansiModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index()
    {
        $instansi = $this->instansiModel->first();
        $data = [
            'its' => $instansi,
            'title' => 'Our Contact',
            'description' => 'Contact Person Instansi',
            'keyword' => 'contact,peson'
        ];
        // Load the view for the contact page
        return view('pages/contact', $data);
    }
}
