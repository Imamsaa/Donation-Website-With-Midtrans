<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ProgramModel;

class Program extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->programModel = new ProgramModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $program = $this->programModel->findAll();
        $data = [
            'title' => 'Program',
            'active' => 'program',
            'program' => $program
        ];

        // Load the program view
        if (session()->get('level') == 'donatur') {
            return view('apps/pages/program/list', $data);
        }else if(session()->get('level') != 'fundraiser'){
            return view('apps/pages/program', $data);
        }else{
            return view('apps/pages/program/listfund', $data);
        }
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Program',
            'active' => 'program',
        ];

        // Load the add program view
        return view('apps/pages/program/add', $data);
    }

    public function save()
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validate the incoming request
            $request = $this->request->getPost();
            $photo = $this->request->getFile('photo');

            $validate = [
                'title' => [
                    'rules' => 'required|min_length[2]|max_length[50]',
                    'errors' => [
                        'required' => 'Judul program harus diisi',
                        'min_length' => 'Judul program minimal 2 karakter',
                        'max_length' => 'Judul program maksimal 50 karakter'
                    ]
                ],
                'description' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'Deskripsi program harus diisi',
                        'min_length' => 'Deskripsi program minimal 2 karakter',
                    ]
                ],
                'target_donate' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'Target donasi harus diisi',
                        'min_length' => 'Target donasi minimal 2 karakter',
                    ]
                ],
                'photo' => [
                    'rules' => 'max_size[photo,2048]|ext_in[photo,png,jpg,jpeg,gif]|is_image[photo]',
                    'errors' => [
                        'max_size' => 'Ukuran file maksimal 2MB',
                        'ext_in' => 'Mohon Masukan file Gambar',
                        'is_image' => 'Mohon Masukan file Gambar Yang benar'
                    ]
                ]
            ];

            if (!$this->validate($validate)) {
                if ($this->validator->hasError('title')) {
                    $message = $this->validator->getError('title');
                } elseif ($this->validator->hasError('description')) {
                    $message = $this->validator->getError('description');
                } elseif ($this->validator->hasError('total_donate')) {
                    $message = $this->validator->getError('total_donate');
                } elseif ($this->validator->hasError('target_donate')) {
                    $message = $this->validator->getError('target_donate');
                } elseif ($this->validator->hasError('photo')) {
                    $message = $this->validator->getError('photo');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);
                return redirect()->to(base_url('apps/program/add'))->withInput();
            }

            // Handle photo upload
            if ($photo->getError() == 4) {
                $name = "img1.jpg";
            } else {
                $name = $photo->getRandomName();
                if (!$photo->move('public/uploads/programs/', $name)) {
                    throw new \RuntimeException('Gagal mengupload foto');
                }
            }

            // Hash password
            $request['slug'] = url_title($request['title']);
            $request['photo'] = $name;
            $request['created_at'] = date('Y-m-d H:i:s');
            $request['updated_at'] = date('Y-m-d H:i:s');

            // Simpan request ke database
            if (!$this->programModel->save($request)) {
                throw new \RuntimeException('Gagal menyimpan data program');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Program Berhasil disimpan'
            ]);
            return redirect()->to(base_url('apps/program'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($name) && $name !== "img1.jpg" && file_exists('public/uploads/programs/' . $name)) {
                unlink('public/uploads/programs/' . $name);
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Program Gagal disimpan: ' . $e->getMessage()
            ]);
            return redirect()->to(base_url('apps/program/add'))->withInput();
        }
    }


    public function edit($slug)
    {
        $program = $this->programModel->where('slug',$slug)->first();
        $data = [
            'title' => 'Edit Program',
            'active' => 'program',
            'program' => $program,
        ];

        // Load the add program view
        return view('apps/pages/program/edit', $data);
    }

    public function update($slug)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari user yang akan diupdate
            $existingProgram = $this->programModel->where('slug', $slug)->first();
            if (!$existingProgram) {
                throw new \RuntimeException('Program tidak ditemukan');
            }

            // Validate the incoming request
            $programData = $this->request->getPost();
            $photo = $this->request->getFile('photo');

            $validate = [
                'title' => [
                    'rules' => 'required|min_length[2]',
                    'errors' => [
                        'required' => 'Judul program harus diisi',
                        'min_length' => 'Judul program minimal 2 karakter',
                    ]
                ],
                'description' => [
                    'rules' => 'permit_empty|max_length[500]',
                    'errors' => [
                        'max_length' => 'Deskripsi Program maksimal 500 karakter'
                    ]
                ],
                'target_donate' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Target donasi program harus diisi',
                    ]
                ],
                'photo' => [
                    'rules' => 'max_size[photo,2048]|ext_in[photo,png,jpg,jpeg,gif]|is_image[photo]',
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
                if ($this->validator->hasError('title')) {
                    $message = $this->validator->getError('title');
                } elseif ($this->validator->hasError('description')) {
                    $message = $this->validator->getError('description');
                } elseif ($this->validator->hasError('target_donate')) {
                    $message = $this->validator->getError('target_donate');
                } elseif ($this->validator->hasError('photo')) {
                    $message = $this->validator->getError('photo');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/program/edit/' . $slug))->withInput();
            }

            // Handle photo upload
            $photoName = $existingProgram['photo']; // Default gunakan foto lama
            
            if ($photo->getError() !== 4) {
                // Ada file baru yang diupload
                $photoName = $photo->getRandomName();
                if (!$photo->move('public/uploads/programs/', $photoName)) {
                    throw new \RuntimeException('Gagal mengupload foto');
                }
                
                // Hapus foto lama jika bukan default
                if ($existingProgram['photo'] !== 'img1.jpg' && file_exists('public/uploads/programs/' . $existingProgram['photo'])) {
                    unlink('public/uploads/programs/' . $existingProgram['photo']);
                }
            }

            // Prepare data untuk update

            $updateData = [
                'program_id' => $existingProgram['program_id'],
                'title' => $programData['title'],
                'slug' => url_title($programData['title']),
                'description' => $programData['description'],
                'target_donate' => $programData['target_donate'],
                'photo' => $photoName,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update user ke database
            if (!$this->programModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data program');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data Program Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/program'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($photoName) && $photoName !== $existingProgram['photo'] && $photoName !== "img1.jpg" && file_exists('public/uploads/programs/' . $photoName)) {
                unlink('public/uploads/programs/' . $photoName);
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data Program Gagal diupdate: ' . $e->getMessage()
            ]);
            
            return redirect()->to(base_url('apps/program/edit/' . $slug))->withInput();
        }
    }

    public function detail($slug)
    {
        $program = $this->programModel->where('slug', $slug)->first();
        $data = [
            'title' => 'Detail Program',
            'active' => 'program',
            'program' => $program,
        ];

        // Load the detail program view
        return view('apps/pages/program/detail', $data);
    }
}
