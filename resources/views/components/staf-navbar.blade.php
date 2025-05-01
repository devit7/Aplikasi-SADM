<div>
    <header class='flex border-b py-2 px-2 sm:px-10 bg-white font-sans min-h-[60px] tracking-wide relative z-50'>
        <div class='flex flex-wrap items-center gap-4 w-full'>
            <a href="{{ route('staff.dashboard') }}">
                <img src="{{ asset('img/loginlogo.png') }}" class="w-[80px]" alt="Logo SD MUSIX">
            </a>

            <div class='flex items-center ml-auto space-x-6'>
                <div class="relative">
                    <button id="dropdownButton" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ asset('img/1.png') }}" alt="" class="w-[60px]">
                        <div class="flex flex-col text-left">
                            <p class="font-semibold"> 
                                <p class="font-semibold">{{ session('staff')->nama }}</p>
                                <p class="text-xs font-medium text-gray-500">Staff</p>
                            </p>
                        </div>
                        <svg class="w-4 h-4 ml-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="dropdownMenu"
                        class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg">
                        <form method="POST" action="{{ route('staf.logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-700 rounded-lg hover:bg-red-100 hover:text-red-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-3">
                                    <path fill-rule="evenodd" d="M12 2.25a.75.75 0 01.75.75v9a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM6.166 5.106a.75.75 0 010 1.06 8.25 8.25 0 1011.668 0 .75.75 0 111.06-1.06c3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788a.75.75 0 011.06 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Log Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
</div>

<script>
    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownButton.addEventListener('click', () => {
        dropdownMenu.classList.toggle('hidden');
    });

    // Menutup dropdown jika klik di luar
    document.addEventListener('click', (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
