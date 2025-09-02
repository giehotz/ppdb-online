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
                        Admin Panel
                    </a>
                    <!-- Desktop Nav Links (Diperbarui) -->
                    <div class="hidden md:flex items-center space-x-2">
                        <a href="/admin/dashboard" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-home mr-2"></i> Dashboard
                        </a>
                        <a href="/admin/users" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600">
                            <i class="fas fa-users-cog mr-2"></i> Manajemen User
                        </a>
                        <a href="/admin/settings" class="flex items-center px-3 py-2 rounded-md text-sm font-medium text-gray-500 hover:text-gray-900 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> Pengaturan
                        </a>
                    </div>
                </div>

                <!-- Right Side Items Wrapper -->
                <div class="flex items-center">
                    <!-- Right side: Notifications & User Menu -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <?php if (session()->has('user_id')): ?>
                            <!-- Notification Bell -->
                            <div class="relative" id="notificationBell">
                                <button class="p-1 rounded-full text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-bell text-xl"></i>
                                </button>
                                <span id="notificationCount" class="absolute -top-1 -right-1 bg-red-500 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center hidden">0</span>

                                <div id="notificationDropdown" class="absolute right-0 mt-2 w-72 bg-white rounded-md shadow-lg hidden z-50 ring-1 ring-black ring-opacity-5">
                                    <div class="px-4 py-3 border-b">
                                        <h3 class="font-semibold text-gray-800">Notifikasi</h3>
                                    </div>
                                    <div id="notificationList" class="max-h-96 overflow-y-auto">
                                        <div class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada notifikasi</div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Menu -->
                            <div class="relative" id="userMenu">
                                <button class="flex items-center space-x-2 focus:outline-none">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold text-sm">
                                        <?= strtoupper(substr(session()->get('username'), 0, 1)) ?>
                                    </div>
                                    <span class="hidden sm:inline text-sm text-gray-700 font-medium"><?= session()->get('username') ?></span>
                                    <i class="hidden sm:inline fas fa-chevron-down text-xs text-gray-500"></i>
                                </button>

                                <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden z-50 ring-1 ring-black ring-opacity-5">
                                    <a href="/logout" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-500"></i>Logout
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="hidden md:flex items-center space-x-4">
                                <a href="/login" class="px-3 py-2 rounded-md text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50">Login</a>
                                <a href="/register" class="px-3 py-2 rounded-md text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">Register</a>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center ml-2 sm:ml-4">
                        <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Diperbarui) -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="/admin/dashboard" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="/admin/users" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600">
                    <i class="fas fa-users-cog mr-2"></i> Manajemen User
                </a>
                <a href="/admin/settings" class="flex items-center px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50">
                    <i class="fas fa-cog mr-2"></i> Pengaturan
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main>
        <!-- Di sini konten dari view lain akan dirender -->
        <?= $this->renderSection('content') ?>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            <?php if (session()->has('user_id')): ?>
                const notificationBell = document.getElementById('notificationBell');
                const notificationDropdown = document.getElementById('notificationDropdown');
                const notificationCount = document.getElementById('notificationCount');
                const notificationList = document.getElementById('notificationList');
                const userMenu = document.getElementById('userMenu');
                const userDropdown = document.getElementById('userDropdown');

                userMenu.addEventListener('click', function(e) {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                    notificationDropdown.classList.add('hidden'); // Close other dropdown
                });

                notificationBell.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationDropdown.classList.toggle('hidden');
                    userDropdown.classList.add('hidden'); // Close other dropdown
                    if (!notificationDropdown.classList.contains('hidden')) {
                        loadNotifications();
                    }
                });

                // Close dropdowns when clicking outside
                document.addEventListener('click', function(e) {
                    if (!notificationBell.contains(e.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                    if (!userMenu.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });

                function fetchNotifications() {
                    fetch('/notifications/unread')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success' && data.count > 0) {
                                notificationCount.textContent = data.count;
                                notificationCount.classList.remove('hidden');
                            }
                        })
                        .catch(error => console.error('Error fetching notifications:', error));
                }

                function loadNotifications() {
                    notificationList.innerHTML = '<div class="px-4 py-4 text-sm text-center text-gray-500">Memuat...</div>';
                    fetch('/notifications/all')
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                updateNotificationList(data.data);
                                markAsRead();
                            } else {
                                notificationList.innerHTML = '<div class="px-4 py-4 text-sm text-center text-gray-500">Gagal memuat.</div>';
                            }
                        })
                        .catch(error => {
                            console.error('Error loading notifications:', error);
                            notificationList.innerHTML = '<div class="px-4 py-4 text-sm text-center text-gray-500">Terjadi kesalahan.</div>';
                        });
                }

                function updateNotificationList(notifications) {
                    if (notifications.length === 0) {
                        notificationList.innerHTML = '<div class="px-4 py-4 text-center text-sm text-gray-500">Tidak ada notifikasi</div>';
                        return;
                    }

                    let html = '';
                    notifications.forEach(notification => {
                        html += `
                    <a href="#" class="block px-4 py-3 border-b border-gray-200 hover:bg-gray-50">
                        <div class="flex justify-between items-center">
                            <h4 class="font-medium text-gray-800 text-sm">${notification.title}</h4>
                            <span class="text-xs text-gray-500">${formatDate(notification.created_at)}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 truncate">${notification.message}</p>
                    </a>
                `;
                    });
                    notificationList.innerHTML = html;
                }

                function markAsRead() {
                    fetch('/notifications/mark-as-read', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                notificationCount.classList.add('hidden');
                                notificationCount.textContent = '0';
                            }
                        })
                        .catch(error => console.error('Error marking as read:', error));
                }

                function formatDate(dateString) {
                    const date = new Date(dateString);
                    return date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'short'
                    });
                }

                // Initial fetch for notification count
                fetchNotifications();
            <?php endif; ?>
        });
    </script>
</body>

</html>