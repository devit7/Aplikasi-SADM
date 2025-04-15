<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-[#ffffff] shadow-sm p-1 px-3">
        <div class="flex justify-between align-middle w-full">
            <a href="/ortu">
                <img src="{{ asset('img/loginlogo.png') }}" alt="Logo" class="w-[64px] h-[64px]"/>
            </a>
            <div class="flex items-center space-x-3">

                <div class="rounded-full bg-[#eb2a2a] size-14">
                    <a href="#">
                        <img src="https://i.pinimg.com/736x/24/cc/88/24cc88ebbf5e1429ea093e93e0065535.jpg" alt="">
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
                <a href="">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 19.1C15.0258 19.1 19.1 15.0258 19.1 10C19.1 4.97421 15.0258 0.9 10 0.9C4.97421 0.9 0.9 4.97421 0.9 10C0.9 15.0258 4.97421 19.1 10 19.1Z"
                            stroke="#5C5C5C" stroke-width="0.2" />
                        <path
                            d="M10 10.7929L7.73162 8.14645C7.56425 7.95118 7.29289 7.95118 7.12553 8.14645C6.95816 8.34171 6.95816 8.65829 7.12553 8.85355L9.69695 11.8536C9.86432 12.0488 10.1357 12.0488 10.303 11.8536L12.8745 8.85355C13.0418 8.65829 13.0418 8.34171 12.8745 8.14645C12.7071 7.95118 12.4358 7.95118 12.2684 8.14645L10 10.7929Z"
                            fill="#565656" />
                        <mask id="mask0_74_2143" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="7" y="8"
                            width="6" height="4">
                            <path
                                d="M10 10.7929L7.73162 8.14645C7.56425 7.95118 7.29289 7.95118 7.12553 8.14645C6.95816 8.34171 6.95816 8.65829 7.12553 8.85355L9.69695 11.8536C9.86432 12.0488 10.1357 12.0488 10.303 11.8536L12.8745 8.85355C13.0418 8.65829 13.0418 8.34171 12.8745 8.14645C12.7071 7.95118 12.4358 7.95118 12.2684 8.14645L10 10.7929Z"
                                fill="white" />
                        </mask>
                        <g mask="url(#mask0_74_2143)">
                        </g>
                    </svg>

                </a>
            </div>
        </div>
</div>