<div>
    <div>
        <div class="relative flex flex-col bg-white h-screen w-64 border-r border-gray-200 shadow-lg">        
            <!-- Navigation -->
            <div class="flex flex-col flex-grow p-4 overflow-y-auto">
                <span class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    MANAJEMEN
                </span>
                
                <!-- Siswa Menu Item -->
                <a href="{{ route('staff.dashboard') }}" 
                   class="mt-2 flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 hover:text-blue-600 transition-colors duration-200 
                   {{ request()->routeIs('walas.index') || request()->routeIs('walas.list-siswa') ? 'bg-blue-100 text-blue-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-3">
                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Siswa</span>
                </a>
                
                <!-- Absen Menu Item -->
                <a href="{{ route('staff.manajemen-absen.index') }}" 
                   class="mt-1 flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 hover:text-blue-600 transition-colors duration-200 {{ request()->routeIs('walas.manajemen-absen.*') ? 'bg-blue-100 text-blue-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-3">
                        <path fill-rule="evenodd" d="M7.5 6v.75H5.513c-.96 0-1.764.724-1.865 1.679l-1.263 12A1.875 1.875 0 004.25 22.5h15.5a1.875 1.875 0 001.865-2.071l-1.263-12a1.875 1.875 0 00-1.865-1.679H16.5V6a4.5 4.5 0 10-9 0zM12 3a3 3 0 00-3 3v.75h6V6a3 3 0 00-3-3zm-3 8.25a3 3 0 106 0v-.75a.75.75 0 011.5 0v.75a4.5 4.5 0 11-9 0v-.75a.75.75 0 011.5 0v.75z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Absensi</span>
                </a>
                
                <!-- Nilai Menu Item -->
                <a href="{{ route('staff.manajemen-nilai.index') }}" 
                   class="mt-1 flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-blue-100 hover:text-blue-600 transition-colors duration-200 {{ request()->is('walas/manajemen-nilai*') ? 'bg-blue-100 text-blue-600' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-3">
                        <path fill-rule="evenodd" d="M2.25 2.25a.75.75 0 000 1.5H3v10.5a3 3 0 003 3h1.21l-1.172 3.513a.75.75 0 001.424.474l.329-.987h8.418l.33.987a.75.75 0 001.422-.474l-1.17-3.513H18a3 3 0 003-3V3.75h.75a.75.75 0 000-1.5H2.25zm6.04 16.5l.5-1.5h6.42l.5 1.5H8.29zm7.46-12a.75.75 0 00-1.5 0v6a.75.75 0 001.5 0v-6zm-3 2.25a.75.75 0 00-1.5 0v3.75a.75.75 0 001.5 0V9zm-3 2.25a.75.75 0 00-1.5 0v1.5a.75.75 0 001.5 0v-1.5z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Nilai</span>
                </a>
            </div>
        </div>
    </div>
    
</div>