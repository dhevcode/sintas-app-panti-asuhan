<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareHub Admin - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        @keyframes slide-in { from { transform: translateY(1rem); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .animate-page { animation: slide-in 0.4s ease-out forwards; }
    </style>
</head>
<body class="bg-[#F8FAFC] text-slate-800 selection:bg-blue-100">

    <div class="flex h-screen overflow-hidden">
        
        <aside id="sidebar" class="w-64 fixed md:relative z-50 bg-[#0F172A] h-full transition-all duration-300 overflow-hidden flex flex-col shadow-2xl">
            <div class="p-8 flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-600 rounded-2xl flex items-center justify-center text-white shadow-lg">
                    <i data-lucide="layout-dashboard"></i>
                </div>
                <span class="text-2xl font-black text-white tracking-tighter">CareHub</span>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto scrollbar-hide">
                <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-white/10 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="layout-dashboard" size="20"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Dashboard</span>
                </a>

                <a href="{{ route('anak.index') }}" 
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all {{ request()->routeIs('anak.*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="users" size="20"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Manajemen Anak</span>
                </a>

                <a href="{{ route('keuangan.index') }}" 
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all {{ request()->routeIs('keuangan.*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="wallet" size="20"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Keuangan</span>
                </a>

                <a href="{{ route('inventori.index') }}" 
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all {{ request()->routeIs('inventori.*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="package" size="20"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Inventaris</span>
                </a>

                <a href="{{ route('artikel.index') }}" 
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all {{ request()->routeIs('artikel.*') ? 'bg-white/10 text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <i data-lucide="newspaper" size="20"></i>
                    <span class="font-black text-xs uppercase tracking-widest">Artikel & CMS</span>
                </a>
            </nav>

            <div class="p-6 border-t border-white/10">
                <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-2xl text-rose-400 hover:bg-rose-400/10 transition-all font-black text-[10px] uppercase tracking-widest">
                    <i data-lucide="log-out" size="18"></i> Keluar Sistem
                </button>
            </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-full overflow-hidden">
            <header class="h-16 bg-white border-b px-8 flex items-center justify-between sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <button onclick="toggleSidebar()" class="p-2 text-slate-400 transition-colors hover:bg-gray-50 rounded-xl">
                        <i data-lucide="menu" size="20"></i>
                    </button>
                    <h2 class="font-black text-slate-800 uppercase tracking-widest text-[10px]">CareHub v0.1.2</h2>
                </div>
                
                <div class="flex items-center gap-4">
                    <i data-lucide="bell" size="20" class="text-gray-300 cursor-pointer hover:text-blue-500 transition-colors"></i>
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 border-2 border-white shadow-md overflow-hidden">
                        <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Felix" alt="profile">
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8 scroll-smooth bg-gray-50/50">
                <div class="animate-page">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            if (sidebar.classList.contains('w-64')) {
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-0');
            } else {
                sidebar.classList.remove('w-0');
                sidebar.classList.add('w-64');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>