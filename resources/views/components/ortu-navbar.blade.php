<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-[#ffffff] shadow-sm p-1 px-3">
        <div class="flex justify-between align-middle w-full">
            <a href="/ortu">
                <img src="{{ asset('img/loginlogo.png') }}" alt="Logo" class="w-[64px] h-[64px]"/>
            </a>
            <div class="flex items-center space-x-3">

                <div class="rounded-full bg-[#eb2a2a] size-14">
                    <a href="{{ route('ortu.profile') }}">
                        <img src="{{ asset('img/1.png') }}" alt="">
                    </a>
                </div>
                <div>
                    <h3>
                        @if (session()->has('siswa'))
                            {{ session('siswa')->nama }}
                        @endif
                    </h3>
                    <p class="text-xs">Murid</p>
                </div>
                <div class='flex items-center ml-auto space-x-6'>
                    <div class="relative">
                        <button id="dropdownButton" class="flex items-center space-x-2 focus:outline-none">
                            <svg class="w-4 h-4 ml-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdownMenu"
                            class="hidden absolute right-0 mt-2 w-48 bg-white border rounded-lg shadow-lg">
                            {{-- <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a> --}}
                            <form method="POST" action="{{ route('ortu.logout') }}">
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