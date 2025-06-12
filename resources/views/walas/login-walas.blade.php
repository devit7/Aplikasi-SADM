<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Landing Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.2/tailwind.min.css">
    <script>
        (function(m, a, z, e) {
            var s, t;
            try {
                t = m.sessionStorage.getItem('maze-us');
            } catch (err) {}

            if (!t) {
                t = new Date().getTime();
                try {
                    m.sessionStorage.setItem('maze-us', t);
                } catch (err) {}
            }

            s = a.createElement('script');
            s.src = z + '?apiKey=' + e;
            s.async = true;
            a.getElementsByTagName('head')[0].appendChild(s);
            m.mazeUniversalSnippetApiKey = e;
        })(window, document, 'https://snippet.maze.co/maze-universal-loader.js', 'db08c225-5ce2-4bf7-9f44-8c88c999648d');
    </script>
</head>

<body>
    <section class="flex flex-col md:flex-row h-screen items-center">

        <div class="bg-blue-600 hidden lg:block w-full md:w-1/2 xl:w-2/3 h-screen">
            <img src="/img/loginwalas.png" alt="" class="w-full h-full object-cover">
        </div>

        <div class="w-full md:max-w-md lg:max-w-full md:mx-auto md:w-1/2 xl:w-1/3 h-screen px-6 lg:px-16 xl:px-12 flex items-center justify-center"
            style="background: linear-gradient(to bottom, #577BC1 0%, #5375B8 74%, #293A5B 100%);">
            <div class="w-full h-100">

                <div class="flex justify-center mb-4">
                    <img src="/img/loginlogo.png" alt="Logo" class="w-32 h-32 object-cover">
                </div>

                <form class="mt-6" action="{{ route('loginWalas') }}" method="POST">
                    @csrf
                    <div>
                        <label class="block text-white">NIP</label>
                        <input required type="number" name="nip" id="nip"
                            placeholder="Contoh: 198507262015051001" value="{{ old('nip') }}"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none @error('nip') border-red-500 @enderror"
                            autofocus autocomplete>
                        @error('nip')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label class="block text-white">Password</label>
                        <input required type="password" name="password" id="password" placeholder="Masukan Password"
                            class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-blue-500 focus:bg-white focus:outline-none @error('password') border-red-500 @enderror">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full block bg-blue-500 hover:bg-blue-400 focus:bg-blue-400 text-white font-semibold rounded-lg px-4 py-3 mt-6">Masuk</button>
                </form>

                <!-- Display general login error -->
                @if ($errors->has('login'))
                    <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <div class="text-right mt-2">
                    <a href="#" class="text-sm font-semibold text-white hover:text-blue-700 focus:text">Lupa
                        Password?</a>
                </div>
            </div>
        </div>
    </section>

</body>

</html>
