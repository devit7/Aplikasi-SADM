<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.2/tailwind.min.css">
</head>
<body>
    <section class="flex flex-col md:flex-row h-screen items-center">
        <div class="w-full md:max-w-md lg:max-w-full md:mx-auto md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12 flex items-center justify-center bg-white"
            >
            <div class="w-full h-100">

                <div class="flex justify-center mb-4">
                    <img src="/img/loginlogo.png" alt="Logo" class="w-32 h-32 object-cover">
                    <div class=" py-8">
                        <p class=" text-lg font-bold text-[#577BC1]">Gen-S</p>
                        <p class=" text-lg font-semibold text-[#577BC1]">SD Muhammadiyah 6</p>
                        <p class=" text-lg  text-[#577BC1]">GADUNG - SURABAYA</p>
                    </div>
                </div>

                <form class="mt-6" action="{{ route('staf.login-staf') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div>
                        <label class="block ">NIP</label>
                        <input type="text" name="nip" id="nip" placeholder="Masukan NIP"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none">
                        <p id="nip-error" class="hidden text-red-500 text-sm mt-1">NIP tidak boleh kosong</p>
                    </div>

                    <div class="mt-4">
                        <label class="block ">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukan Password"
                            minlength="6"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none">
                        <p id="password-error" class="hidden text-red-500 text-sm mt-1">Password tidak boleh kosong</p>
                    </div>

                    <button type="submit"
                        class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg px-4 py-3 mt-6">Masuk</button>
                </form>

                <div class="text-right mt-2">
                    <a href="#" class="text-sm font-semibold text-white hover:text-blue-700 focus:text">Lupa
                        Password?</a>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
            <img src="/img/loginwalas.png" alt="" class="w-full h-full object-cover">
        </div>
    
    </section>

    <script>
    function validateForm() {
        const nip = document.getElementById('nip').value.trim();
        const password = document.getElementById('password').value.trim();

        // Reset error messages
        document.getElementById('nip-error').classList.add('hidden');
        document.getElementById('password-error').classList.add('hidden');

        let isValid = true;

        if (nip === "") {
            document.getElementById('nip-error').classList.remove('hidden');
            isValid = false;
        }

        if (password === "") {
            document.getElementById('password-error').classList.remove('hidden');
            isValid = false;
        }

        return isValid;
    }
    </script>
</body>
</html>