<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InstansiModel;

class Instansi extends BaseController
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
            'title' => 'Instansi',
            'active' => 'instansi',
            'ins' => $instansi,
        ];
        
        // Load the instansi view
        return view('apps/pages/instansi', $data);
    }

    public function update()
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // Validate the incoming request
            $request = $this->request->getPost();
            $logo = $this->request->getFile('logo');
            $oldSetting = $this->instansiModel->first();

            $validate = [
                'email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email harus diisi',
                        'valid_email' => 'Format email tidak valid',
                    ]
                ],
                'phone' => [
                    'rules' => 'permit_empty|numeric|min_length[10]|max_length[15]',
                    'errors' => [
                        'numeric' => 'Phone hanya boleh berisi angka',
                        'min_length' => 'Phone minimal 10 digit',
                        'max_length' => 'Phone maksimal 15 digit'
                    ]
                ],
                'address' => [
                    'rules' => 'permit_empty|max_length[500]',
                    'errors' => [
                        'max_length' => 'Address maksimal 500 karakter'
                    ]
                ],
                'logo' => [
                    'rules' => 'max_size[logo,2048]|ext_in[logo,png,jpg,jpeg,gif]|is_image[logo]',
                    'errors' => [
                        'max_size' => 'Ukuran file maksimal 2MB',
                        'ext_in' => 'Mohon Masukan file Gambar',
                        'is_image' => 'Mohon Masukan file Gambar Yang benar'
                    ]
                ]
            ];

            if (!$this->validate($validate)) {
                // Tentukan pesan error
                $message = '';
                if ($this->validator->hasError('email')) {
                    $message = $this->validator->getError('email');
                } elseif ($this->validator->hasError('phone')) {
                    $message = $this->validator->getError('phone');
                } elseif ($this->validator->hasError('address')) {
                    $message = $this->validator->getError('address');
                } elseif ($this->validator->hasError('logo')) {
                    $message = $this->validator->getError('logo');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/instansi'))->withInput();
            }

            // Handle logo upload
            $logoName = $oldSetting['logo']; // Default gunakan foto lama
            
            if ($logo->getError() !== 4) {
                // Ada file baru yang diupload
                $logoName = $logo->getRandomName();
                if (!$logo->move('public/uploads/', $logoName)) {
                    throw new \RuntimeException('Gagal mengupload gambar');
                }
                
                // Hapus foto lama jika bukan default
                if ($oldSetting['logo'] !== 'logo.png' && file_exists('public/uploads/' . $oldSetting['logo'])) {
                    unlink('public/uploads/' . $oldSetting['logo']);
                }
            }

            // Prepare data untuk update
            $updateData = [
                'instansi_id' => 1,
                'name' => $request['name'],
                'description' => $request['description'],
                'address' => $request['address'],
                'phone' => $request['phone'],
                'email' => $request['email'],
                'facebook' => $request['facebook'] ?? null,
                'instagram' => $request['instagram'] ?? null,
                'website' => $request['website'] ?? null,
                'logo' => $logoName,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update user ke database
            if (!$this->instansiModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data instansi');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Instansi Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/instansi'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($logoName) && $logoName !== $oldSetting['logo'] && $logoName !== "logo.png" && file_exists('public/uploads/' . $logoName)) {
                unlink('public/uploads/' . $logoName);
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Instansi Gagal diupdate: ' . $e->getMessage()
            ]);
            
            return redirect()->to(base_url('apps/instansi'))->withInput();
        }
    }
}
