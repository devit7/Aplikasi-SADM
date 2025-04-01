<div>
    <header class='flex border-b py-4 px-4 sm:px-10 bg-white font-sans min-h-[70px] tracking-wide relative z-50'>
        <div class='flex flex-wrap items-center gap-4 w-full'>
            <a href="/walas">
                <img src="{{ asset('img/loginlogo.png') }}" class="w-[50px]" alt="">
            </a>

            <div class='flex items-center ml-auto space-x-6'>
                <div class="relative">
                    <button id="dropdownButton" class="flex items-center space-x-2 focus:outline-none">
                        <img src="{{ asset('img/wallpaper sunday.png') }}" alt="" class="w-[55px] h-[55px]">
                        <div class="flex flex-col text-left">
                            <p class="font-semibold">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-600">{{ Auth::user()->role }}</p>
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
                        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logoutWalas') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</button>
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
