<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;

class Pengguna extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->usersModel = new UsersModel();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        $users = $this->usersModel->findAll();
        $data = [
            'title' => 'Pengguna',
            'active' => 'pengguna',
            'users' => $users
        ];
        // Load the pengguna view
        return view('apps/pages/pengguna', $data);
    }

    public function add()
    {
        $data = [
            'title' => 'Tambah Pengguna',
            'active' => 'pengguna',
        ];
        // Logic to show the form for adding a new user
        return view('apps/pages/pengguna/add', $data);
    }

    public function save()
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Validate the incoming request
            $user = $this->request->getPost();
            $photo = $this->request->getFile('photo');

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
                'level' => [
                    'rules' => 'required|in_list[admin,ketua,bendahara,fundraiser]',
                    'errors' => [
                        'required' => 'Privilege harus dipilih',
                        'in_list' => 'Privilege tidak valid'
                    ]
                ],
                'status' => [
                    'rules' => 'required|in_list[Aktif,Tidak Aktif]',
                    'errors' => [
                        'required' => 'Status harus dipilih',
                        'in_list' => 'Status tidak valid'
                    ]
                ],
                'email' => [
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required' => 'Email harus diisi',
                        'valid_email' => 'Format email tidak valid',
                        'is_unique' => 'Email Sudah Digunakan'
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
                if ($this->validator->hasError('first_name')) {
                    $message = $this->validator->getError('first_name');
                } elseif ($this->validator->hasError('last_name')) {
                    $message = $this->validator->getError('last_name');
                } elseif ($this->validator->hasError('username')) {
                    $message = $this->validator->getError('username');
                } elseif ($this->validator->hasError('password')) {
                    $message = $this->validator->getError('password');
                } elseif ($this->validator->hasError('level')) {
                    $message = $this->validator->getError('level');
                } elseif ($this->validator->hasError('status')) {
                    $message = $this->validator->getError('status');
                } elseif ($this->validator->hasError('email')) {
                    $message = $this->validator->getError('email');
                } elseif ($this->validator->hasError('phone')) {
                    $message = $this->validator->getError('phone');
                } elseif ($this->validator->hasError('photo')) {
                    $message = $this->validator->getError('photo');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);
                return redirect()->to(base_url('apps/pengguna/add'))->withInput();
            }

            // Handle photo upload
            if ($photo->getError() == 4) {
                $name = "default.png";
            } else {
                $name = $photo->getRandomName();
                if (!$photo->move('public/uploads/profiles/', $name)) {
                    throw new \RuntimeException('Gagal mengupload foto');
                }
            }

            // Hash password
            $password = password_hash($user['password'], PASSWORD_BCRYPT);
            $user['password'] = $password;
            $user['photo'] = $name;
            $user['created_at'] = date('Y-m-d H:i:s');
            $user['updated_at'] = date('Y-m-d H:i:s');

            // Simpan user ke database
            if (!$this->usersModel->save($user)) {
                throw new \RuntimeException('Gagal menyimpan data user');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data User Berhasil disimpan'
            ]);
            return redirect()->to(base_url('apps/pengguna'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($name) && $name !== "default.png" && file_exists('public/uploads/profiles/' . $name)) {
                unlink('public/uploads/profiles/' . $name);
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data User Gagal disimpan: ' . $e->getMessage()
            ]);
            return redirect()->to(base_url('apps/pengguna/add'))->withInput();
        }
    }

    public function edit($username)
    {
        $user = $this->usersModel->where('username', $username)->first();
        $data = [
            'title' => 'Edit Pengguna',
            'active' => 'pengguna',
            'user' => $user
        ];
        // Logic to show the form for editing an existing user
        return view('apps/pages/pengguna/edit', $data);
    }

    public function update($username)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari user yang akan diupdate
            $existingUser = $this->usersModel->where('username', $username)->first();
            if (!$existingUser) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            // Validate the incoming request
            $userData = $this->request->getPost();
            $photo = $this->request->getFile('photo');

            // Dynamic validation rules
            $uniqueUsernameRule = 'required|min_length[3]|max_length[30]';
            $uniqueEmailRule = 'required|valid_email';
            
            // Jika username tidak berubah, tidak perlu validasi is_unique
            if ($userData['username'] !== $existingUser['username']) {
                $uniqueUsernameRule .= '|is_unique[users.username]';
            }
            
            // Jika email tidak berubah, tidak perlu validasi is_unique
            if ($userData['email'] !== $existingUser['email']) {
                $uniqueEmailRule .= '|is_unique[users.email]';
            }

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
                    'rules' => $uniqueUsernameRule,
                    'errors' => [
                        'required' => 'Username harus diisi',
                        'min_length' => 'Username minimal 3 karakter',
                        'max_length' => 'Username maksimal 30 karakter',
                        'is_unique' => 'Username Sudah Digunakan'
                    ]
                ],
                'level' => [
                    'rules' => 'required|in_list[admin,ketua,bendahara,fundraiser]',
                    'errors' => [
                        'required' => 'Privilege harus dipilih',
                        'in_list' => 'Privilege tidak valid'
                    ]
                ],
                'email' => [
                    'rules' => $uniqueEmailRule,
                    'errors' => [
                        'required' => 'Email harus diisi',
                        'valid_email' => 'Format email tidak valid',
                        'is_unique' => 'Email Sudah Digunakan'
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
                if ($this->validator->hasError('first_name')) {
                    $message = $this->validator->getError('first_name');
                } elseif ($this->validator->hasError('last_name')) {
                    $message = $this->validator->getError('last_name');
                } elseif ($this->validator->hasError('username')) {
                    $message = $this->validator->getError('username');
                } elseif ($this->validator->hasError('level')) {
                    $message = $this->validator->getError('level');
                } elseif ($this->validator->hasError('email')) {
                    $message = $this->validator->getError('email');
                } elseif ($this->validator->hasError('phone')) {
                    $message = $this->validator->getError('phone');
                } elseif ($this->validator->hasError('address')) {
                    $message = $this->validator->getError('address');
                } elseif ($this->validator->hasError('photo')) {
                    $message = $this->validator->getError('photo');
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/pengguna/edit/' . $username))->withInput();
            }

            // Handle photo upload
            $photoName = $existingUser['photo']; // Default gunakan foto lama
            
            if ($photo->getError() !== 4) {
                // Ada file baru yang diupload
                $photoName = $photo->getRandomName();
                if (!$photo->move('public/uploads/profiles/', $photoName)) {
                    throw new \RuntimeException('Gagal mengupload foto');
                }
                
                // Hapus foto lama jika bukan default
                if ($existingUser['photo'] !== 'default.png' && file_exists('public/uploads/profiles/' . $existingUser['photo'])) {
                    unlink('public/uploads/profiles/' . $existingUser['photo']);
                }
            }

            // Prepare data untuk update
            $updateData = [
                'user_id' => $existingUser['user_id'],
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'username' => $userData['username'],
                'level' => $userData['level'],
                'email' => $userData['email'],
                'phone' => $userData['phone'] ?? null,
                'address' => $userData['address'] ?? null,
                'photo' => $photoName,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Update user ke database
            if (!$this->usersModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data user');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data User Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/pengguna'));

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            // Hapus file yang sudah terupload jika ada error
            if (isset($photoName) && $photoName !== $existingUser['photo'] && $photoName !== "default.png" && file_exists('public/uploads/profiles/' . $photoName)) {
                unlink('public/uploads/profiles/' . $photoName);
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Data User Gagal diupdate: ' . $e->getMessage()
            ]);
            
            return redirect()->to(base_url('apps/pengguna/edit/' . $username))->withInput();
        }
    }

    /**
     * Update password user
     */
    public function password($username)
    {
        try {
            // Cari user berdasarkan username
            $existingUser = $this->usersModel->where('username', $username)->first();
            if (!$existingUser) {
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

                return redirect()->to(base_url('apps/pengguna/edit/' . $username))->withInput();
            }

            // Hash password baru
            $newPassword = password_hash($this->request->getPost('password'), PASSWORD_BCRYPT);

            // Update password
            $updateData = [
                'user_id' => $existingUser['user_id'],
                'password' => $newPassword,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->usersModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate password');
            }

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ]);

            return redirect()->to(base_url('apps/pengguna/edit/' . $username));

        } catch (\Exception $e) {
            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Gagal mengubah password: ' . $e->getMessage()
            ]);

            return redirect()->to(base_url('apps/pengguna/edit/' . $username))->withInput();
        }
    }

    public function delete($username)
    {
        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari data user yang akan dihapus
            $user = $this->usersModel->where('username', $username)->first();
            
            if (!$user) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            // Hapus foto jika bukan default.jpg
            if ($user['photo'] !== "default.jpg" && file_exists('public/uploads/profiles/' . $user['photo'])) {
                unlink('public/uploads/profiles/' . $user['photo']);
            }

            // Hapus data dari database
            if (!$this->usersModel->where('username', $username)->delete()) {
                throw new \RuntimeException('Gagal menghapus data user');
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data User berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            $db->transRollback();

            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Gagal menghapus data user: ' . $e->getMessage()
            ]);
        }

        return redirect()->to(base_url('apps/pengguna'));
    }
}
