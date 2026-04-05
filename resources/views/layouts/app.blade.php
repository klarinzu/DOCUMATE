<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DocuMate</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- VITE ONLY (important: do NOT add asset css again) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    {{-- ICONS --}}
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-white">

<div class="layout">
    @php
        $inactive = auth()->check() && auth()->user()->account_status !== 'active';
    @endphp

    {{-- SIDEBAR --}}
    <aside class="sidebar {{ $inactive ? 'pointer-events-none opacity-50' : '' }}" id="sidebar">

        {{-- HEADER --}}
        <div class="sidebar-header">

            <div class="header-left">
                <img src="{{ asset('images/favicon.png') }}" class="logo">
                <span class="logo-text">DocuMate</span>
            </div>

        </div>

        

        <div class="sidebar-content">

            {{-- STUDENT --}}
            @php
                $role = auth()->user()->role->role_name ?? null;
            @endphp

            @if($role === 'Student')

                <div class="sidebar-section">
                    <p class="section-title">Student</p>

                    <a href="{{ route('student.new-transaction') }}" class="sidebar-link">
                        <i class='bx bx-plus-circle'></i>
                        <span>New Transaction</span>
                    </a>

                    <a href="/appointments" class="sidebar-link">
                        <i class='bx bx-calendar'></i>
                        <span>Appointments</span>
                    </a>

                    <a href="/documents" class="sidebar-link">
                        <i class='bx bx-folder'></i>
                        <span>Documents</span>
                    </a>

                    <a href="/clearance-status" class="sidebar-link">
                        <i class='bx bx-check-circle'></i>
                        <span>Clearance Status</span>
                    </a>

                    <a href="/handbook" class="sidebar-link">
                        <i class='bx bx-book'></i>
                        <span>Handbook</span>
                    </a>
                </div>

            @endif


            {{-- STUDENT OFFICER --}}
            @php
                $role = auth()->user()->role->role_name ?? null;
            @endphp

            @if($role === 'Officer')

                <div class="sidebar-section">
                    <p class="section-title">Student Officer</p>

                    <a href="{{ route('student.new-transaction') }}" class="sidebar-link" data-tooltip="New Transaction">
                        <i class='bx bx-plus-circle'></i>
                        <span>New Transaction</span>
                    </a>

                    <a href="/appointments" class="sidebar-link" data-tooltip="Appointments">
                        <i class='bx bx-calendar'></i>
                        <span>Appointments</span>
                    </a>

                    <a href="/documents" class="sidebar-link" data-tooltip="Documents">
                        <i class='bx bx-folder'></i>
                        <span>Documents</span>
                    </a>

                    <a href="/clearance-status" class="sidebar-link" data-tooltip="Clearance Status">
                        <i class='bx bx-check-circle'></i>
                        <span>Clearance Status</span>
                    </a>

                    <a href="/clearance-tagging" class="sidebar-link" data-tooltip="Clearance Tagging">
                        <i class='bx bx-check-shield'></i>
                        <span>Clearance Tagging</span>
                    </a>

                    <a href="/handbook" class="sidebar-link" data-tooltip="Handbook">
                        <i class='bx bx-book'></i>
                        <span>Handbook</span>
                    </a>
                </div>

            @endif


            {{-- ADMIN --}}
            @php
                $role = auth()->user()->role->role_name ?? null;
            @endphp

            @if($role === 'Admin')

                <div class="sidebar-section">
                    <p class="section-title">Admin</p>

                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link" data-tooltip="Dashboard">
                        <i class='bx bx-home'></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="/admin/transactions" class="sidebar-link" data-tooltip="Transactions">
                        <i class='bx bx-transfer'></i>
                        <span>Transactions</span>
                    </a>

                    <a href="/admin/appointments" class="sidebar-link" data-tooltip="Appointments">
                        <i class='bx bx-calendar'></i>
                        <span>Appointments</span>
                    </a>

                    <a href="/admin/clearance-monitoring" class="sidebar-link" data-tooltip="Clearance Monitoring">
                        <i class='bx bx-shield'></i>
                        <span>Clearance Monitoring</span>
                    </a>

                    <a href="/admin/reports" class="sidebar-link" data-tooltip="Reports">
                        <i class='bx bx-bar-chart'></i>
                        <span>Reports</span>
                    </a>

                    <a href="{{ route('admin.users') }}" class="sidebar-link" data-tooltip="Manage Users">
                        <i class='bx bx-group'></i>
                        <span>Manage Users</span>
                    </a>

                    <a href="{{ route('admin.templates') }}" class="sidebar-link" data-tooltip="Document Templates">
                        <i class='bx bx-file'></i>
                        <span>Document Templates</span>
                    </a>
                </div>

            @endif

        </div>
        {{-- PROFILE --}}
        <div class="sidebar-profile">
            <a href="{{ auth()->user()->role->role_name === 'admin' ? '/admin/profile' : '/profile' }}" class="profile-row" data-tooltip="Profile">

                <img src="{{ auth()->user()->profile_picture 
                    ? asset('storage/' . auth()->user()->profile_picture) 
                    : asset('images/backdrop.jpg') }}" 
                class="profile-img">

                <div class="profile-info">
                    <p class="name">{{ auth()->user()->first_name }}</p>

                    @if(auth()->user()->role->role_name === 'admin')
                        <p class="sub">{{ auth()->user()->email }}</p>
                    @else
                        <p class="sub">{{ auth()->user()->student_number }}</p>
                    @endif
                </div>
            </a>
        </div>

    </aside>

    {{-- MAIN --}}
    <main class="main-content flex flex-col h-screen overflow-hidden">

        <div class="topbar bg-white border-b border-gray-200 sticky top-0 z-50">

            {{-- LEFT --}}
            <div class="topbar-left">
                <button id="toggleSidebar" class="collapse-btn" data-tooltip="expand/collapse sidebar">
                    <img width="20" height="20"
                        src="https://img.icons8.com/parakeet-line/48/sidebar-menu.png">
                </button>

                <h3>{{ $title ?? 'Dashboard' }}</h3>
            </div>

            {{-- RIGHT --}}
            <div class="topbar-right">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-icon">
                        <i class='bx bx-log-out'></i>
                    </button>
                </form>

            </div>

        </div>
        <div>

            {{-- RIGHT: USER --}}
            <div class="user-info">
                {{ auth()->user()->firstname }}
            </div>

        </div>
        @if($inactive)
            <div class="p-3 text-center text-sm text-red-600 font-semibold">
                Account locked! Please verify your enrollment.
            </div>
        @endif

        <div class="content flex-1 overflow-y-auto p-6">
            {{ $slot }}
        </div>


        {{-- CHATBOT BUTTON --}}
        <div class="chatbot-btn" id="chatbotBtn" data-tooltip="AI Assistant">
            <i class='bx bx-message-dots'></i>
        </div>

        {{-- FLOATING CHAT PANEL --}}
        <div class="chatbot-panel" id="chatbotPanel">

            <div class="chatbot-header">
                <span>DocuMate Assistant</span>
                <button id="closeChatbot">&times;</button>
            </div>

            <div class="chatbot-body">
                <p>Hello! How can I help you?</p>
            </div>

            <div class="chatbot-input">
                <input type="text" placeholder="Ask something...">
                <button>Send</button>
            </div>

        </div>

    </main>

</div>

<div id="tooltip"></div>
@livewireScripts

{{-- JS --}}
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
        });
    }

    const chatbotBtn = document.getElementById('chatbotBtn');
    const chatbotPanel = document.getElementById('chatbotPanel');
    const closeChatbot = document.getElementById('closeChatbot');

    chatbotBtn.addEventListener('click', () => {
        chatbotPanel.style.display =
            chatbotPanel.style.display === 'flex' ? 'none' : 'flex';
    });

    closeChatbot.addEventListener('click', () => {
        chatbotPanel.style.display = 'none';
    });
    const tooltip = document.getElementById('tooltip');

    document.querySelectorAll('[data-tooltip]').forEach(el => {

        el.addEventListener('mouseenter', (e) => {
            tooltip.textContent = el.getAttribute('data-tooltip');
            tooltip.style.opacity = '1';
        });

        el.addEventListener('mousemove', (e) => {
            tooltip.style.left = (e.clientX + 12) + 'px';
            tooltip.style.top = (e.clientY + 12) + 'px';
        });

        el.addEventListener('mouseleave', () => {
            tooltip.style.opacity = '0';
        });

    });
</script>

</body>
</html>