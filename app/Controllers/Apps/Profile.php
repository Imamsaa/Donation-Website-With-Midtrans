<?php

namespace App\Controllers\Apps;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsersModel;
use App\Models\DonaturModel;
use App\Models\FundraiserModel;

class Profile extends BaseController
{
    protected $currentModel;
    protected $currentTable;
    protected $primaryKey;

    public function __construct()
    {
        $this->session = \Config\Services::session();

        // Memastikan session sudah dimulai
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Tentukan model dan tabel berdasarkan user_type
        $userType = session()->get('user_type');
        switch ($userType) {
            case 'donatur':
                $this->currentModel = new DonaturModel();
                $this->currentTable = 'donatur';
                $this->primaryKey = 'donatur_id';
                break;
            case 'fundraiser':
                $this->currentModel = new FundraiserModel();
                $this->currentTable = 'fundraiser';
                $this->primaryKey = 'fundraiser_id';
                break;
            case 'user':
            default:
                $this->currentModel = new UsersModel();
                $this->currentTable = 'users';
                $this->primaryKey = 'user_id';
                break;
        }
    }
    
    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            session()->setFlashdata('kotakok', [
                'status' => 'error',
                'title' => 'Access Denied',
                'message' => 'Anda harus login terlebih dahulu'
            ]);
            return redirect()->to(base_url('login'));
        }

        $userId = session()->get('user_id');
        $user = $this->currentModel->find($userId);
        
        $data = [
            'title' => 'Profile',
            'active' => 'profile',
            'user' => $user,
            'user_type' => session()->get('user_type'),
            'level' => session()->get('level')
        ];
        
        // Load the profile view
        return view('apps/pages/profile', $data);
    }

    public function update()
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Mulai transaction
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Cari user yang akan diupdate
            $userId = session()->get('user_id');
            $existingUser = $this->currentModel->find($userId);
            if (!$existingUser) {
                throw new \RuntimeException('User tidak ditemukan');
            }

            // Validate the incoming request
            $userData = $this->request->getPost();
            $photo = $this->request->getFile('photo');

            // Validasi email unique berdasarkan tabel yang sesuai
            $uniqueEmailRule = 'required|valid_email';
            if ($userData['email'] !== $existingUser['email']) {
                $uniqueEmailRule .= "|is_unique[{$this->currentTable}.email]";
            }

            // Validasi username unique berdasarkan tabel yang sesuai (jika ada field username)
            $uniqueUsernameRule = '';
            if (isset($userData['username']) && isset($existingUser['username'])) {
                $uniqueUsernameRule = 'required|min_length[3]|max_length[20]|alpha_numeric';
                if ($userData['username'] !== $existingUser['username']) {
                    $uniqueUsernameRule .= "|is_unique[{$this->currentTable}.username]";
                }
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

            // Tambahkan validasi username jika ada
            if ($uniqueUsernameRule) {
                $validate['username'] = [
                    'rules' => $uniqueUsernameRule,
                    'errors' => [
                        'required' => 'Username harus diisi',
                        'min_length' => 'Username minimal 3 karakter',
                        'max_length' => 'Username maksimal 20 karakter',
                        'alpha_numeric' => 'Username hanya boleh huruf dan angka',
                        'is_unique' => 'Username sudah digunakan'
                    ]
                ];
            }

            // Validasi khusus untuk fundraiser (status field untuk donatur biasanya tidak bisa diedit user)
            if (session()->get('user_type') === 'donatur' && isset($userData['status'])) {
                $validate['status'] = [
                    'rules' => 'permit_empty|in_list[active,inactive,pending]',
                    'errors' => [
                        'in_list' => 'Status harus salah satu dari: active, inactive, pending'
                    ]
                ];
            }

            if (!$this->validate($validate)) {
                // Tentukan pesan error
                $message = '';
                foreach (['first_name', 'last_name', 'email', 'username', 'phone', 'address', 'photo', 'status'] as $field) {
                    if ($this->validator->hasError($field)) {
                        $message = $this->validator->getError($field);
                        break;
                    }
                }

                session()->setFlashdata('kotakok', [
                    'status' => 'warning',
                    'title' => 'Perhatian',
                    'message' => $message
                ]);

                return redirect()->to(base_url('apps/profile'))->withInput();
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
                $this->primaryKey => $userId,
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'] ?? null,
                'address' => $userData['address'] ?? null,
                'photo' => $photoName,
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Tambahkan field khusus berdasarkan user type
            if (isset($userData['username']) && isset($existingUser['username'])) {
                $updateData['username'] = $userData['username'];
            }

            // Field khusus untuk user (level biasanya tidak bisa diedit oleh user sendiri kecuali admin)
            if (session()->get('user_type') === 'user' && session()->get('level') === 'admin' && isset($userData['level'])) {
                $updateData['level'] = $userData['level'];
            }

            // Field khusus untuk donatur
            if (session()->get('user_type') === 'donatur' && isset($userData['status'])) {
                $updateData['status'] = $userData['status'];
            }

            // Field khusus untuk fundraiser (referral biasanya tidak bisa diedit)
            // Referral code biasanya auto-generated dan tidak boleh diubah user

            // Update user ke database
            if (!$this->currentModel->save($updateData)) {
                throw new \RuntimeException('Gagal mengupdate data user');
            }

            // Update session jika ada perubahan data yang tersimpan di session
            if (isset($updateData['username'])) {
                session()->set('username', $updateData['username']);
            }
            session()->set('name', $updateData['first_name'] . ' ' . $updateData['last_name']);
            session()->set('email', $updateData['email']);
            session()->set('photo', $updateData['photo']);
            if (isset($updateData['status'])) {
                session()->set('status', $updateData['status']);
            }

            // Commit transaction jika semua berhasil
            $db->transComplete();

            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Data User Berhasil diupdate'
            ]);
            
            return redirect()->to(base_url('apps/profile'));

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
            
            return redirect()->to(base_url('apps/profile'))->withInput();
        }
    }

    public function password($action = null)
    {
        // Cek apakah user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        if ($this->request->getMethod() === 'POST') {
            return $this->updatePassword();
        }

        $data = [
            'title' => 'Change Password',
            'active' => 'profile',
            'user_type' => session()->get('user_type'),
        ];

        return view('apps/pages/profile', $data);
    }

    private function updatePassword()
    {
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        // Validasi input
        $validate = [
            'current_password' => [
                'rules' => 'required',
                'errors' => ['required' => 'Password lama harus diisi']
            ],
            'new_password' => [
                'rules' => 'required|min_length[6]|max_length[100]',
                'errors' => [
                    'required' => 'Password baru harus diisi',
                    'min_length' => 'Password minimal 6 karakter',
                    'max_length' => 'Password maksimal 100 karakter'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Konfirmasi password harus diisi',
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ]
        ];

        if (!$this->validate($validate)) {
            $message = '';
            foreach (['current_password', 'new_password', 'confirm_password'] as $field) {
                if ($this->validator->hasError($field)) {
                    $message = $this->validator->getError($field);
                    break;
                }
            }

            session()->setFlashdata('kotakok', [
                'status' => 'warning',
                'title' => 'Perhatian',
                'message' => $message
            ]);

            return redirect()->to(base_url('apps/profile'))->withInput();
        }

        // Cek password lama
        $userId = session()->get('user_id');
        $user = $this->currentModel->find($userId);

        if (!password_verify($currentPassword, $user['password'])) {
            session()->setFlashdata('kotakok', [
                'status' => 'error',
                'title' => 'Password Salah',
                'message' => 'Password lama tidak cocok'
            ]);
            return redirect()->to(base_url('apps/profile'))->withInput();
        }

        // Update password
        $updateData = [
            $this->primaryKey => $userId,
            'password' => password_hash($newPassword, PASSWORD_DEFAULT),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->currentModel->save($updateData)) {
            session()->setFlashdata('pojokatas', [
                'status' => 'success',
                'message' => 'Password berhasil diubah'
            ]);
        } else {
            session()->setFlashdata('pojokatas', [
                'status' => 'error',
                'message' => 'Gagal mengubah password'
            ]);
        }

        return redirect()->to(base_url('apps/profile'));
    }
}