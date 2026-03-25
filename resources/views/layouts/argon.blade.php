<!--

=========================================================
* Argon Dashboard 2 Tailwind - v1.0.1
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-tailwind
* Copyright 2022 Creative Tim (https://www.creative-tim.com)

* Coded by www.creative-tim.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="apple-touch-icon" sizes="76x76" href="/assets/img/apple-icon.png" />
        <link rel="icon" type="image/png" href="/assets/img/favicon.png" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
        <!-- Font Awesome Icons -->
        <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
        <!-- Nucleo Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="/assets/css/nucleo-svg.css" rel="stylesheet" />
        <!-- Popper -->
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        <!-- Main Styling -->
        <link href="/assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
        <link href="/assets/css/custom.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/js/app.js'])
        <style>
            [x-cloak] { display: none !important; }
            .custom-modal-backdrop {
                position: fixed;
                inset: 0;
                background: rgba(0,0,0,0.6);
                backdrop-filter: blur(3px);
                z-index: 998;
            }
            .custom-modal-wrapper {
                position: relative;
            }
            .custom-modal-container {
                position: fixed;
                inset: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
                z-index: 999;
            }
            .custom-modal-box {
                background: #ffffff;
                color: #333;
                width: 100%;
                max-width: 500px;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0,0,0,0.25);
                overflow: hidden;
            }
            .custom-modal-header {
                padding: 1rem;
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid #eee;
            }
            .custom-modal-title {
                font-size: 1.2rem;
                font-weight: 600;
            }
            .custom-modal-close {
                background: none;
                border: none;
                font-size: 1.4rem;
                cursor: pointer;
                opacity: 0.6;
            }
            .custom-modal-close:hover {
                opacity: 1;
            }
            .custom-modal-body {
                padding: 1rem;
            }
            .custom-modal-input {
                width: 100%;
                padding: .5rem .75rem;
                border: 1px solid #ccc;
                border-radius: 6px;
            }
            .custom-modal-footer {
                padding: 1rem 0;
                display: flex;
                justify-content: flex-end;
                gap: .5rem;
                border-top: 1px solid #eee;
            }
            .custom-modal-btn {
                padding: .5rem 1rem;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                font-size: .85rem;
            }
            .custom-modal-btn-primary {
                background: #2563eb;
                color: #fff;
            }
            .custom-modal-btn-primary:hover {
                background: #1d4ed8;
            }
            .custom-modal-btn-secondary {
                background: #9ca3af;
                color: #fff;
            }
            .custom-modal-btn-secondary:hover {
                background: #6b7280;
            }
            .custom-modal-enter {
                transition: all 0.3s ease-out;
            }
            .custom-modal-enter-start {
                opacity: 0;
                transform: scale(0.9) translateY(10px);
            }
            .custom-modal-enter-end {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            .custom-modal-leave {
                transition: all 0.2s ease-in;
            }
            .custom-modal-leave-start {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
            .custom-modal-leave-end {
                opacity: 0;
                transform: scale(0.9) translateY(10px);
            }
        </style>
    </head>

    <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
        <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
        @include('shared.argon.partials.sidebar')

        <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
            @include('shared.argon.partials.navbar')
            @yield('content')
        </main>
        @stack('scripts')
    </body>
    <!-- plugin for charts  -->
    <script src="/assets/js/plugins/chartjs.min.js" async></script>
    <!-- plugin for scrollbar  -->
    <script src="/assets/js/plugins/perfect-scrollbar.min.js" async></script>
    <!-- main script file  -->
    <script src="/assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>
</html>