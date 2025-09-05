<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?> - PPDB MIN 2 Tanggamus</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200 w-full max-w-md">
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto mb-4 bg-indigo-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-circle text-3xl text-indigo-600"></i>
                </div>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Login Akun</h1>
                <p class="text-gray-500">Silakan masuk untuk melanjutkan proses pendaftaran</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 text-sm">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')) : ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 text-sm">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="/login" method="post" class="space-y-6">
                <?= csrf_field() ?>
                <div>
                    <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?= isset($validation) && $validation->hasError('email') ? 'border-red-500' : '' ?>"
                            value="<?= old('email') ?>" required>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('email')) : ?>
                        <p class="text-red-500 text-xs italic mt-2"><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?= isset($validation) && $validation->hasError('password') ? 'border-red-500' : '' ?>"
                            required>
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password')) : ?>
                        <p class="text-red-500 text-xs italic mt-2"><?= $validation->getError('password') ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl transition-colors duration-200 shadow-md">
                        Login
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    Belum punya akun?
                    <a href="/register" class="text-indigo-600 hover:text-indigo-800 font-bold transition-colors duration-200">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function() {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the eye icon
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        });
    </script>
</body>

</html>