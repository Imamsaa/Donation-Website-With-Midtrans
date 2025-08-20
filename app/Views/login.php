<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title :'Website Donasi' ?></title>
    <meta name="description" content="<?= isset($description) ? $description :'Login Website Donasi' ?>">
    <meta name="keywords" content="<?= isset($keyword) ? $keyword :'Login Website Donasi' ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Tambahkan ikon dari Heroicons (Tailwind) -->
    <script src="https://unpkg.com/@heroicons/react@2.0.16/dist/index.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold text-center text-green-600 mb-6">Login</h1>
        
        <form class="space-y-4" action="<?= base_url('login') ?>" method="post">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" id="username" name="username" value="<?= old('username') ?>" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Masukkan username">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <div class="relative">
                    <input 
                        name="password" value="<?= old('password') ?>"
                        type="password" 
                        id="password" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent pr-10" 
                        placeholder="•••••••"
                    >
                    <button 
                        type="button" 
                        onclick="togglePassword()" 
                        class="absolute inset-y-0 right-0 flex items-center pr-3"
                    >
                        <!-- Ikon mata (disesuaikan agar sejajar sempurna) -->
                        <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 hover:text-gray-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-400 hover:text-gray-600 hidden">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <button type="submit" class="w-full bg-green-600 text-white py-2 px-4 rounded-md hover:bg-green-700 transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                Login
            </button>

            <div class="text-center text-sm mt-4">
                <span class="text-gray-600">Belum punya akun?</span>
                <a href="<?= base_url('register') ?>" class="text-green-600 hover:text-green-800 font-medium ml-1">Daftar disini</a>
            </div>
        </form>
    </div>

    <!-- SweetAlert2 -->
    <script src="<?= base_url('public/plugins/sweetalert2/dist/sweetalert2.all.min.js') ?>"></script>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeSlashIcon = document.getElementById('eye-slash-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeSlashIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeSlashIcon.classList.add('hidden');
            }
        }
    </script>
    <script>
        // Notification handling
        <?php if (session()->has('kotakok')) : ?>
            const notif = <?= json_encode(session('kotakok')) ?>;
            Swal.fire({
                icon: notif.status,
                title: notif.title,
                text: notif.message
            });
        <?php endif; ?>

        <?php if (session()->has('pojokatas')) : ?>
            const toast = <?= json_encode(session('pojokatas')) ?>;
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            Toast.fire({
                icon: toast.status,
                title: toast.message
            });
        <?php endif; ?>
    </script>
</body>
</html>