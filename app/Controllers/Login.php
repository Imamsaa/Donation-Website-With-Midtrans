<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\DonaturModel;
use App\Models\FundraiserModel;

class Login extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->usersModel = new UsersModel();
        $this->donaturModel = new DonaturModel();
        $this->fundraiserModel = new FundraiserModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $data = [
            'title' => 'Login Donasi',
            'description' => 'Login Aplikasi Program Donasi',
            'keyword' => 'login, program, active, donasi'
        ];
        return view('login', $data);
    }

    // public function process()
    // {
    //     $username = $this->request->getPost('username');
    //     $password = $this->request->getPost('password');

    //     // Validasi input
    //     if (!$username || !$password) {
    //         session()->setFlashdata('kotakok', [
    //             'status' => 'error',
    //             'title' => 'Login Gagal',
    //             'message' => 'Username dan Password harus diisi'
    //         ]);
    //         return redirect()->to(base_url('login'))->withInput();
    //     }

    //     // Cek kredensial (misalnya dengan model UserModel)
    //     // Contoh sederhana, ganti dengan logika autentikasi yang sesuai
    //     if ($this->usersModel->where('username', $username)->first()) {
    //         $user = $this->usersModel->where('username', $username)->first();
    //         if (password_verify($password, $user['password'])) {
    //             session()->set('isLoggedIn', true);
    //             session()->set('username', $user['username']);
    //             session()->set('name', $user['first_name'].' '.$user['last_name']);
    //             session()->set('user_id', $user['user_id']);
    //             session()->set('photo', $user['photo']);
    //             session()->set('email', $user['email']);
    //             session()->set('level', $user['level']);
    //             session()->setFlashdata('kotakok', [
    //                 'status' => 'success',
    //                 'title' => 'Welcome '.$user['first_name'].' '.$user['last_name'],
    //                 'message' => 'Kami berkomitmen untuk dapat terus membantu menyalurkan kebaikan yang Anda berikan'
    //             ]);
    //             return redirect()->to(base_url('apps'));
    //         } else {
    //             session()->setFlashdata('kotakok', [
    //                 'status' => 'error',
    //                 'title' => 'Login Gagal',
    //                 'message' => 'Username atau Password salah'
    //             ]);
    //             return redirect()->to(base_url('login'))->withInput();
    //         }
    //     }else {
    //         session()->setFlashdata('kotakok', [
    //             'status' => 'error',
    //             'title' => 'Login Gagal',
    //             'message' => 'Username atau Password salah'
    //         ]);
    //         return redirect()->to(base_url('login'))->withInput();
    //     }
    // }

    public function process()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validasi input
        if (!$username || !$password) {
            session()->setFlashdata('kotakok', [
                'status' => 'error',
                'title' => 'Login Gagal',
                'message' => 'Username dan Password harus diisi'
            ]);
            return redirect()->to(base_url('login'))->withInput();
        }

        // Coba login sebagai User
        $user = $this->usersModel->where('username', $username)->first();
        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'username' => $user['username'],
                'name' => $user['first_name'] . ' ' . $user['last_name'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'user_id' => $user['user_id'],
                'photo' => $user['photo'],
                'email' => $user['email'],
                'level' => $user['level'],
                'user_type' => 'user',
                'phone' => $user['phone'] ?? null,
                'address' => $user['address'] ?? null
            ]);
            
            session()->setFlashdata('kotakok', [
                'status' => 'success',
                'title' => 'Welcome ' . $user['first_name'] . ' ' . $user['last_name'],
                'message' => 'Kami berkomitmen untuk dapat terus membantu menyalurkan kebaikan yang Anda berikan'
            ]);
            
            // Redirect berdasarkan level
            if ($user['level'] === 'admin') {
                return redirect()->to(base_url('apps'));
            }
            return redirect()->to(base_url('apps'));
        }

        // Coba login sebagai Donatur
        $donatur = $this->donaturModel->where('username', $username)->first();
        if ($donatur && password_verify($password, $donatur['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'username' => $donatur['username'],
                'name' => $donatur['first_name'] . ' ' . $donatur['last_name'],
                'first_name' => $donatur['first_name'],
                'last_name' =>  $donatur['last_name'],
                'user_id' => $donatur['donatur_id'],
                'photo' => $donatur['photo'],
                'email' => $donatur['email'],
                'level' => 'donatur',
                'user_type' => 'donatur',
                'status' => $donatur['status'] ?? null,
                'phone' => $donatur['phone'] ?? null,
                'address' => $donatur['address'] ?? null
            ]);
            
            session()->setFlashdata('kotakok', [
                'status' => 'success',
                'title' => 'Welcome ' . $donatur['first_name'] . ' ' . $donatur['last_name'],
                'message' => 'Kami berkomitmen untuk dapat terus membantu menyalurkan kebaikan yang Anda berikan'
            ]);
            
            return redirect()->to(base_url('apps'));
        }

        // Coba login sebagai Fundraiser
        $fundraiser = $this->fundraiserModel->where('username', $username)->first();
        if ($fundraiser && password_verify($password, $fundraiser['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'username' => $fundraiser['username'],
                'name' => $fundraiser['first_name'] . ' ' . $fundraiser['last_name'],
                'first_name' => $fundraiser['first_name'],
                'last_name' => $fundraiser['last_name'],
                'user_id' => $fundraiser['fundraiser_id'],
                'photo' => $fundraiser['photo'],
                'email' => $fundraiser['email'],
                'level' => 'fundraiser',
                'user_type' => 'fundraiser',
                'referral' => $fundraiser['referral'] ?? null,
                'phone' => $fundraiser['phone'] ?? null,
                'address' => $fundraiser['address'] ?? null
            ]);
            
            session()->setFlashdata('kotakok', [
                'status' => 'success',
                'title' => 'Welcome ' . $fundraiser['first_name'] . ' ' . $fundraiser['last_name'],
                'message' => 'Kami berkomitmen untuk dapat terus membantu menyalurkan kebaikan yang Anda berikan'
            ]);
            
            return redirect()->to(base_url('apps'));
        }

        // Jika tidak ditemukan di ketiga tabel
        session()->setFlashdata('kotakok', [
            'status' => 'error',
            'title' => 'Login Gagal',
            'message' => 'Username atau Password salah'
        ]);
        return redirect()->to(base_url('login'))->withInput();
    }
}
