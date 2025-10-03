<?php

return [
    // Setiap 'key' adalah NAMA PERMISSION dari Spatie
    'read-users' => [ // <-- Pastikan SAMA PERSIS dengan nama permission
        'name'       => 'Manage Users',
        'route_name' => 'users.index', // <-- Pastikan SAMA PERSIS dengan nama route
        'icon'       => '<svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.7 0 3-1.3 3-3S17.7 5 16 5s-3 1.3-3 3 1.3 3 3 3zM8 11c1.7 0 3-1.3 3-3S9.7 5 8 5 5 6.3 5 8s1.3 3 3 3zm0 2c-2.2 0-6 1.1-6 3.3V20h12v-3.7C14 14.1 10.2 13 8 13zm8 0c-.3 0-.7 0-1 .1 1.2.9 2 2.1 2 3.2V20h6v-3.7c0-2.2-3.8-3.3-7-3.3z"/>
                        </svg>',
    ],
    'read-roles' => [
        'name'       => 'Manage Role',
        'route_name' => 'roles.index',
        'icon'       => '<svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M16 11c1.7 0 3-1.3 3-3S17.7 5 16 5s-3 1.3-3 3 1.3 3 3 3zM8 11c1.7 0 3-1.3 3-3S9.7 5 8 5 5 6.3 5 8s1.3 3 3 3zm0 2c-2.2 0-6 1.1-6 3.3V20h12v-3.7C14 14.1 10.2 13 8 13zm8 0c-.3 0-.7 0-1 .1 1.2.9 2 2.1 2 3.2V20h6v-3.7c0-2.2-3.8-3.3-7-3.3z"/>
                        </svg>', // Ganti dengan ikon yang sesuai
    ],
];