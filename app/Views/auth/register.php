<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Register' ?> - PPDB MIN 2 Tanggamus</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">PPDB MIN 2 Tanggamus</h1>
                <p class="text-gray-600">Silakan daftar untuk membuat akun</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/attempt-register" method="post">
                <?= csrf_field() ?>
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username"
                            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('username') ? 'border-red-500' : 'border-gray-300' ?>"
                            value="<?= old('username') ?>" required>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('username')) : ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('username') ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email"
                            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('email') ? 'border-red-500' : 'border-gray-300' ?>"
                            value="<?= old('email') ?>" required>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('email')) : ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('email') ?></p>
                    <?php endif; ?>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password"
                            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('password') ? 'border-red-500' : 'border-gray-300' ?>"
                            required>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password')) : ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('password') ?></p>
                    <?php endif; ?>
                </div>

                <div class="px-4 md:px-8 lg:px-12 py-6">
                    <label for="password_confirm" class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password_confirm" name="password_confirm"
                            class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 <?= isset($validation) && $validation->hasError('password_confirm') ? 'border-red-500' : 'border-gray-300' ?>"
                            required>
                    </div>
                    <?php if (isset($validation) && $validation->hasError('password_confirm')) : ?>
                        <p class="text-red-500 text-xs italic mt-1"><?= $validation->getError('password_confirm') ?></p>
                    <?php endif; ?>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-600">
                    Sudah punya akun?
                    <a href="/login" class="text-blue-500 hover:text-blue-700 font-bold">Login</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>