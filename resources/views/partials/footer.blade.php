<footer class="footer mt-5" id="footer">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                @foreach ($cms as $company)
                    <a href="/home" class="flex items-center">
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap text-gray-500">{{ $company->company_name }}</span>
                        <img src="https://teraskabeka.com/{{ $company->logo }}" class="h-8 me-2" alt="KeyFood Logo" />
                    </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Kontak</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="/contact-us" class="hover:underline">Hubungi Kami</a>
                        </li>
                        {{-- <li class="mb-4">
                            <a href="{{ auth()->check() ? '/live-chat/1' : '/log-reg' }}" class="hover:underline">Chat
                                Admin</a>
                        </li> --}}
                        <li class="mb-4">
                            <a href="https://wa.me/6289661110584?text=Saya%20ingin%20bertanya%20tentang%20produk%20di%20website%20Teras KBK">Chat
                                Admin</a>
                        </li>

                        <li class="mb-4">
                            <a href="/faq" class="hover:underline">Pertanyaan Umum</a>
                        </li>
                        <li class="mb-4">
                            <a href="/tutorial" class="hover:underline">Tutorial</a>
                        </li>
                        <li>
                            <a href="/term-condition" class="hover:underline">Persetujuan Pengguna</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Teras KBK</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4 break-words">
                            <a href="https://maps.app.goo.gl/jPYA3x3XgB3pXWSYA"
                                class="hover:underline">{{ $company->company_name }} {{ $company->lokasi }}</a>
                        </li>
                        <li class="mb-4 break-words">
                            <a href="mailto:gragemediatechnology@gmail.com"
                                class="hover:underline">{{ $company->email }}</a>
                        </li>
                        <li class="break-words">
                            <a href="https://wa.me/{{ $company->phone }}"
                                class="hover:underline">+62{{ $company->phone }}</a>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-4">
            <span class="text-sm text-gray-500 text-center sm:text-left">
                © 2024 <a href="#" class="hover:underline">{{ $company->company_name }}™</a>. All Rights Reserved.
            </span>
            <div class="flex mt-4 sm:justify-center sm:mt-0">
                <a href="https://youtube.com/@gragemediatechnology?si=TUzeCE_g9uFOHmda"
                    class="text-gray-500 hover:text-gray-700 ms-5">
                    <i class='bx bxl-youtube'></i>
                    <span class="sr-only">YouTube channel</span>
                </a>
                <a href="https://www.instagram.com/pandaidigital_idn?igsh=MXM4aDBxcnprbDR1eQ=="
                    class="text-gray-500 hover:text-gray-700 ms-5">
                    <i class='bx bxl-instagram-alt' ></i>
                    <span class="sr-only">Instagram page</span>
                </a>
                <a href="https://grageweb.online" class="text-gray-500 hover:text-gray-700 ms-5">
                    <i class='bx bxl-linkedin-square'></i>
                    <span class="sr-only">Official Website</span>
                </a>
            </div>
        </div>

    </div>
    @endforeach
</footer>
