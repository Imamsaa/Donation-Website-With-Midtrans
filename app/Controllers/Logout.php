<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Logout extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        
        // Hapus semua data session
        $session->destroy();

        // Set flashdata untuk pesan logout sukses
        $session->setFlashdata('kotakok', [
            'status' => 'success',
            'title' => 'Logout Sukses',
            'message' => 'Anda telah berhasil logout.'
        ]);

        // Redirect ke halaman login
        return redirect()->to(base_url('login'));  
    }
}
