<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\SettingModel;

class Pengaturan extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->settingModel = new SettingModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $setting = $this->settingModel->first();
        $data = [
            'title' => 'Pengaturan',
            'active' => 'pengaturan',
            'setting' => $setting
        ];

        // Load the pengaturan view
        return view('apps/pages/pengaturan', $data);
    }

    public function update()
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // Validate the incoming request
            $request = $this->request->getPost();

            $validate = [
                'server_key' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'First Name harus diisi',
                        'min_length' => 'First Name minimal 2 karakter',
                    ]
                ],
                'client_key' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'First Name harus diisi',
                        'min_length' => 'First Name minimal 2 karakter',
                    ]
                ],
            ];

            if (!$this->validate($validate)) {
                // Tentukan pesan error
                $message = '';
                if ($this->validator->hasError('server_key')) {
                    $message = $this->validator->getError('server_key');
                } elseif ($this->validator->hasError('client_key')) {
                    $message = $this->validator->getError('client_key');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/pengaturan'))->withInput();
            }

            // Prepare data untuk update
            $updateData = [
                'set_id' => 1,
                'server_key' => $request['server_key'],
                'client_key' => $request['client_key'],
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update user ke database
            if (!$this->settingModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data Midtrans');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Midtras Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/pengaturan'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Midtrans Gagal diupdate: ' . $e->getMessage()
            ]);
            
            return redirect()->to(base_url('apps/pengaturan'))->withInput();
        }
    }
}
