<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'PPDB MIN 2 Tanggamus' ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-40">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Nav Links -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="/" class="flex-shrink-0 font-bold text-xl text-gray-800">
                        PPDB MIN 2 Tanggamus
                    </a>
                    <!-- Desktop Nav Links -->
                    <div class="hidden md:flex items-center space-x-4">
                        <a href="/" class="px-3 py-2 rounded-md text-sm font-medium <?= (service('uri')->getPath() == '/') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' ?>">
                            Beranda
                        </a>
                        <a href="/announcements" class="px-3 py-2 rounded-md text-sm font-medium <?= (service('uri')->getPath() == '/announcements') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' ?>">
                            Pengumuman
                        </a>
                        <a href="/pages/profil-madrasah" class="px-3 py-2 rounded-md text-sm font-medium <?= (service('uri')->getPath() == '/pages/profil-madrasah') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' ?>">
                            Profil Madrasah
                        </a>
                        <a href="/pages/kontak" class="px-3 py-2 rounded-md text-sm font-medium <?= (service('uri')->getPath() == '/pages/kontak') ? 'text-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-100' ?>">
                            Kontak
                        </a>
                    </div>
                </div>

                <!-- Auth Links -->
                <div class="flex items-center space-x-2">
                    <?php if (session()->has('user_id')): ?>
                        <a href="/<?= session()->get('role') ?>/dashboard"
                            class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            Dashboard
                        </a>
                        <a href="/logout"
                            class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="/login"
                            class="text-sm font-medium text-gray-700 hover:text-gray-900">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center text-gray-500 text-sm">
                <p>&copy; <?= date('Y') ?> PPDB MIN 2 Tanggamus. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>
</body>

</html>