<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DonaturModel;

class Register extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->donaturModel = new DonaturModel();
        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public function index()
    {
        return view('register');
    }

    public function save()
    {

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validate the incoming request
            $user = $this->request->getPost();

            $validate = [
                'first_name' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'First Name harus diisi',
                        'min_length' => 'First Name minimal 2 karakter',
                        'max_length' => 'First Name maksimal 50 karakter'
                    ]
                ],
                'last_name' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Last Name harus diisi',
                        'min_length' => 'Last Name minimal 2 karakter',
                        'max_length' => 'Last Name maksimal 50 karakter'
                    ]
                ],
                'username' => [
                    'rules' => 'required|min_length[3]|max_length[30]|is_unique[users.username]',
                    'errors' => [
                        'required' => 'Username harus diisi',
                        'min_length' => 'Username minimal 3 karakter',
                        'max_length' => 'Username maksimal 30 karakter',
                        'is_unique' => 'Username Sudah Digunakan'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Password harus diisi',
                        'min_length' => 'Password minimal 6 karakter'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email harus diisi',
                        'valid_email' => 'Format email tidak valid',
                        'is_unique' => 'Email Sudah Digunakan'
                    ]
                ]
            ];

            if (!$this->validate($validate)) {
                if ($this->validator->hasError('first_name')) {
                    $message = $this->validator->getError('first_name');
                } elseif ($this->validator->hasError('last_name')) {
                    $message = $this->validator->getError('last_name');
                } elseif ($this->validator->hasError('username')) {
                    $message = $this->validator->getError('username');
                } elseif ($this->validator->hasError('password')) {
                    $message = $this->validator->getError('password');
                } elseif ($this->validator->hasError('email')) {
                    $message = $this->validator->getError('email');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);
                return redirect()->to(base_url('register'))->withInput();
            }


            // Hash password
            $password = password_hash($user['password'], PASSWORD_BCRYPT);
            $user['password'] = $password;
            $user['level'] = 'donatur';
            $user['photo'] = 'default.png';
            $user['created_at'] = date('Y-m-d H:i:s');
            $user['updated_at'] = date('Y-m-d H:i:s');

            // Simpan user ke database
            if (!$this->donaturModel->save($user)) {
                throw new \RuntimeException('Gagal menyimpan data');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Donatur Berhasil disimpan'
            ]);
            return redirect()->to(base_url('login'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Donatur Gagal disimpan: ' . $e->getMessage()
            ]);
            return redirect()->to(base_url('register'))->withInput();
        }
    }
}
