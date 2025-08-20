<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProgramModel;
use App\Models\DonasiModel;

class Donasi extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->programModel = new ProgramModel();
        $this->donasiModel = new DonasiModel();
        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $program = $this->programModel->findAll();
        $data = [
            'title' => 'Donasi',
            'active' => 'donasi',
            'program' => $program,
        ];

        // Load the donasi view
        return view('apps/pages/donasi', $data);
    }

    public function list($slug)
    {
        $program = $this->programModel->where('slug', $slug)->first();
        $listDonasi = $this->donasiModel->where('program_id', $program['program_id'])->findAll();
        $data = [
            'title' => 'List Donasi',
            'active' => 'donasi',
            'listDonasi' => $listDonasi,
            'program' => $program,
        ];

        // Load the list donasi view
        return view('apps/pages/donasi/list', $data);
    }

    public function saveAdmin($slug)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validate the incoming request
            $donasi = $this->request->getPost();
            $program = $this->programModel->where('slug', $slug)->first();

            $validate = [
                'name' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Nama harus diisi',
                        'min_length' => 'Nama minimal 2 karakter',
                        'max_length' => 'Nama maksimal 50 karakter'
                    ]
                ],
                'amount' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Nominal harus diisi',
                        'min_length' => 'Nominal minimal 2 karakter',
                        'max_length' => 'Nominal maksimal 50 karakter'
                    ]
                ],
            ];

            if (!$this->validate($validate)) {
                if ($this->validator->hasError('name')) {
                    $message = $this->validator->getError('name');
                } elseif ($this->validator->hasError('amount')) {
                    $message = $this->validator->getError('amount');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);
                return redirect()->to(base_url('apps/donasi/'.$program['slug']))->withInput();
            }

            if(!isset($donasi['anonim']))
            {
                $donasi['anonim'] = 'tidak';
            }
            $donasi['user_id'] = session()->get('user_id');
            $donasi['program_id'] = $program['program_id'];
            $donasi['created_at'] = date('Y-m-d H:i:s');
            $donasi['updated_at'] = date('Y-m-d H:i:s');
            $donasi['status'] = 'success';

            // Simpan donasi ke database
            $total_donate = (int)$program['total_donate'] + (int)$donasi['amount'];
            // dd($total_donate);
            if (!$this->donasiModel->save($donasi)) {
                throw new \RuntimeException('Gagal menyimpan data donasi');
            }

            if (!$this->programModel->save(['program_id' => $program['program_id'],'total_donate' => $total_donate]))
            {
                throw new \RuntimeException('Gagal menyimpan data program');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Donasi Berhasil disimpan'
            ]);
            return redirect()->to(base_url('apps/donasi/'.$program['slug']));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Donasi Gagal disimpan: ' . $e->getMessage()
            ]);
            return redirect()->to(base_url('apps/donasi/'.$program['slug']))->withInput();
        }
    }

    public function updateAdmin($slug, $donasi_id)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validate the incoming request
            $donasi = $this->request->getPost();
            $program = $this->programModel->where('slug', $slug)->first();
            $oldDonasi = $this->donasiModel->where('donasi_id', $donasi_id)->first();

            $validate = [
                'name' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Nama harus diisi',
                        'min_length' => 'Nama minimal 2 karakter',
                        'max_length' => 'Nama maksimal 50 karakter'
                    ]
                ],
                'amount' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Nominal harus diisi',
                        'min_length' => 'Nominal minimal 2 karakter',
                        'max_length' => 'Nominal maksimal 50 karakter'
                    ]
                ],
            ];

            if (!$this->validate($validate)) {
                if ($this->validator->hasError('name')) {
                    $message = $this->validator->getError('name');
                } elseif ($this->validator->hasError('amount')) {
                    $message = $this->validator->getError('amount');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);
                return redirect()->to(base_url('apps/donasi/'.$slug))->withInput();
            }

            if(!isset($donasi['anonim']))
            {
                $donasi['anonim'] = 'tidak';
            }

            $donasi['donasi_id'] = $donasi_id;
            $donasi['program_id'] = $program['program_id'];
            $donasi['updated_at'] = date('Y-m-d H:i:s');

            // Simpan donasi ke database
            if (!$this->donasiModel->save($donasi)) {
                throw new \RuntimeException('Gagal menyimpan data donasi');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Donasi Berhasil disimpan'
            ]);
            return redirect()->to(base_url('apps/donasi/'.$slug));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Donasi Gagal disimpan: ' . $e->getMessage()
            ]);
            return redirect()->to(base_url('apps/donasi/'.$slug))->withInput();
        }
    }

    public function deleteAdmin($slug, $donasi_id)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari data donasi yang akan dihapus
            $donasi = $this->donasiModel->where('donasi_id', $donasi_id)->first();
            $program = $this->programModel->where('slug', $slug)->first();
            
            if (!$donasi) {
                throw new \RuntimeException('Donasi tidak ditemukan');
            }

            // Hapus data dari database
            $total_donate = $program['total_donate'] - $donasi['amount'];

            if (!$this->programModel->save([
                'program_id' => $program['program_id'],
                'total_donate' => $total_donate,
            ])) {
                throw new \RuntimeException('Gagal melakukan perubahan');
            }

            if (!$this->donasiModel->where('donasi_id', $donasi_id)->delete()) {
                throw new \RuntimeException('Gagal menghapus data donasi');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Donasi berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Gagal menghapus data donasi: ' . $e->getMessage()
            ]);
        }

        return redirect()->to(base_url('apps/donasi/'.$slug));
    }
}
