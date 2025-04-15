<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Ortu Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.2/tailwind.min.css">
</head>

<body>
    <section class="flex flex-col md:flex-row h-screen items-center">

        <div class="bg-blue-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
            <img src="/img/loginortu.png" alt="" class="w-full h-full object-cover">
        </div>

        <div class="w-full md:max-w-md lg:max-w-full md:mx-auto md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12 flex items-center justify-center"
            style="background: linear-gradient(to bottom, #577BC1 0%, #5375B8 74%, #293A5B 100%);">
            <div class="w-full h-100">

                <div class="flex justify-center mb-4">
                    <img src="/img/loginlogo.png" alt="Logo" class="w-32 h-32 object-cover">
                </div>

                <form class="mt-6" action="{{ route('ortu.login-ortu') }}" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div>
                        <label class="block text-white">NISN</label>
                        <input type="text" name="nisn" id="nisn" placeholder="Masukan NISN"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none"
                            autofocus autocomplete>
                        <p id="nisn-error" class="hidden text-red-500 text-sm mt-1">NISN tidak boleh kosong</p>
                    </div>

                    <div class="mt-4">
                        <label class="block text-white">NIS</label>
                        <input type="text" name="nis" id="nis" placeholder="Masukan NIS" 
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none">
                        <p id="nis-error" class="hidden text-red-500 text-sm mt-1">NIS tidak boleh kosong</p>
                    </div>

                    <button type="submit"
                        class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg px-4 py-3 mt-6">Masuk</button>
                </form>

                <div class="text-right mt-2">
                    <a href="#" class="text-sm font-semibold text-white hover:text-blue-700 focus:text">Lupa Password?</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        function validateForm() {
            const nisn = document.getElementById('nisn').value.trim();
            const nis = document.getElementById('nis').value.trim();

            // Reset pesan error
            document.getElementById('nisn-error').classList.add('hidden');
            document.getElementById('nis-error').classList.add('hidden');

            let isValid = true;

            if (nisn === "") {
                document.getElementById('nisn-error').classList.remove('hidden');
                isValid = false;
            }

            if (nis === "") {
                document.getElementById('nis-error').classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }
    </script>
</body>

</html>
