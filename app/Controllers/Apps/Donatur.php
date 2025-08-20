<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DonaturModel;

class Donatur extends BaseController
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
        $donatur = $this->donaturModel->findAll();
        $data = [
            'title' => 'Donatur',
            'active' => 'donatur',
            'donatur' => $donatur
        ];

        // Load the donatur view
        return view('apps/pages/donatur', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Donatur',
            'active' => 'donatur',
        ];

        // Load the add donatur view
        return view('apps/pages/donatur/add', $data);
    }

    public function edit($username)
    {
        $donatur = $this->donaturModel->where('username', $username)->first();
        $data = [
            'title' => 'Edit Donatur',
            'active' => 'donatur',
            'donatur' => $donatur,
        ];

        // Load the edit donatur view
        return view('apps/pages/donatur/edit', $data);
    }

    public function update($username)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari user yang akan diupdate
            $existingDonatur = $this->donaturModel->where('username', $username)->first();
            if (!$existingDonatur) {
                throw new \RuntimeException('Donatur tidak ditemukan');
            }

            // Validate the incoming request
            $donaturData = $this->request->getPost();

            $validate = [
                'status' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Status donatur harus diisi',
                    ]
                ],
            ];

            if (!$this->validate($validate)) {
                // Tentukan pesan error
                $message = '';
                if ($this->validator->hasError('status')) {
                    $message = $this->validator->getError('status');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/donatur/edit/' . $username))->withInput();
            }

            // Prepare data untuk update
            $updateData = [
                'donatur_id' => $existingDonatur['donatur_id'],
                'status'  => $donaturData['status'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update user ke database
            if (!$this->donaturModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data donatur');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Donatur Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/donatur'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Donatur Gagal diupdate: ' . $e->getMessage()
            ]);
            
            return redirect()->to(base_url('apps/donatur/edit/' . $username))->withInput();
        }
    }

    public function password($username)
    {
        try {
            // Cari user berdasarkan username
            $existingDonatur = $this->donaturModel->where('username', $username)->first();
            if (!$existingDonatur) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            // Validate password
            $validate = [
                'password' => [
                    'rules' => 'required|min_length[6]',
                    'errors' => [
                        'required' => 'Password harus diisi',
                        'min_length' => 'Password minimal 6 karakter'
                    ]
                ],
                'repassword' => [
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => 'Konfirmasi Password harus diisi',
                        'matches' => 'Konfirmasi Password tidak sama dengan Password'
                    ]
                ]
            ];

            if (!$this->validate($validate)) {
                $message = '';
                if ($this->validator->hasError('password')) {
                    $message = $this->validator->getError('password');
                } elseif ($this->validator->hasError('repassword')) {
                    $message = $this->validator->getError('repassword');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/donatur/edit/' . $username))->withInput();
            }

            // Hash password baru
            $newPassword = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

            // Update password
            $updateData = [
                'donatur_id' => $existingDonatur['donatur_id'],
                'password' => $newPassword,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->donaturModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate password');
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ]);

            return redirect()->to(base_url('apps/donatur/edit/' . $username));

        } catch (\Exception $e) {
            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Gagal mengubah password: ' . $e->getMessage()
            ]);

            return redirect()->to(base_url('apps/donatur/edit/' . $username))->withInput();
        }
    }

    public function delete($donatur_id)
    {
        // Logic to delete the donatur data
        // This is just a placeholder, implement your logic here
        return redirect()->to(base_url('apps/donatur'));
    }
}
