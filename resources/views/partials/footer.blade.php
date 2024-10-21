<footer class="footer mt-5" id="footer">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
            <div class="mb-6 md:mb-0">
                @foreach ($cms as $company)
                    <a href="/home" class="flex items-center">
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap text-gray-500">{{ $company->company_name }}</span>
                        <img src="https://lapakkbk.online/{{ $company->logo }}" class="h-8 me-2" alt="KeyFood Logo" />
                    </a>
            </div>
            <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-2">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Kontak</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="/contact-us" class="hover:underline">Hubungi Kami</a>
                        </li>
                        <li class="mb-4">
                            <a href="{{ auth()->check() ? '/live-chat/1' : '/log-reg' }}" class="hover:underline">Chat
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
                    <h2 class="mb-6 text-sm font-semibold text-gray-400 uppercase">Lapak KBK</h2>
                    <ul class="text-gray-500 font-medium">
                        <li class="mb-4">
                            <a href="https://maps.app.goo.gl/jPYA3x3XgB3pXWSYA"
                                class="hover:underline ">{{ $company->company_name }}
                                {{ $company->lokasi }}</a>
                        </li>
                        <li class="mb-4">
                            <a href="mailto:gragemediatechnology@gmail.com"
                                class="hover:underline">{{ $company->email }}</a>
                        </li>
                        <li>
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
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M23.5 6.25a3.002 3.002 0 0 0-2.106-2.122C19.17 3.5 12 3.5 12 3.5s-7.171 0-9.395.63A3.002 3.002 0 0 0 .5 6.25 29.208 29.208 0 0 0 0 12c.005 1.937.111 3.875.5 5.75a3.002 3.002 0 0 0 2.106 2.122C4.83 20.5 12 20.5 12 20.5s7.171 0 9.395-.63A3.002 3.002 0 0 0 23.5 17.75c.39-1.875.495-3.813.5-5.75a29.208 29.208 0 0 0-.5-5.75ZM9.75 15.25v-6l6 3-6 3Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">YouTube channel</span>
                </a>
                <a href="https://www.instagram.com/pandaidigital_idn?igsh=MXM4aDBxcnprbDR1eQ=="
                    class="text-gray-500 hover:text-gray-700 ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 0a7.838 7.838 0 0 0-7.853 7.853v8.294A7.838 7.838 0 0 0 12 24a7.838 7.838 0 0 0 7.853-7.853V7.853A7.838 7.838 0 0 0 12 0Zm0 1.5a6.338 6.338 0 0 1 6.353 6.353v8.294A6.338 6.338 0 0 1 12 22.5a6.338 6.338 0 0 1-6.353-6.353V7.853A6.338 6.338 0 0 1 12 1.5ZM12 5.25a6.75 6.75 0 1 1 0 13.5 6.75 6.75 0 0 1 0-13.5Zm5.053-1.125a1.125 1.125 0 1 0 0 2.25 1.125 1.125 0 0 0 0-2.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Instagram page</span>
                </a>
                <a href="https://grageweb.online" class="text-gray-500 hover:text-gray-700 ms-5">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2.25a9.75 9.75 0 1 0 0 19.5 9.75 9.75 0 0 0 0-19.5ZM12 3.75c.664 0 1.331.087 1.985.248a12.179 12.179 0 0 0-1.853 3.933c-.044.13-.084.257-.123.384h-2.018a12.179 12.179 0 0 0-1.853-3.933c.654-.161 1.32-.248 1.985-.248Zm3.682 1.07A8.252 8.252 0 0 1 18.403 9h-2.547a11.726 11.726 0 0 0-1.726-4.18c.521.268 1.018.603 1.552 1.001Zm-7.364 0A11.726 11.726 0 0 0 6.865 9H4.318a8.252 8.252 0 0 1 2.721-4.18c.534-.398 1.03-.733 1.552-1.001ZM12 8.25c.313 0 .626.049.935.147a9.711 9.711 0 0 0-.935 3.228 9.711 9.711 0 0 0-.935-3.228c.309-.098.622-.147.935-.147ZM9.41 9c.123.257.24.525.347.803.38 1.033.616 2.25.66 3.447H7.043c.05-1.197.279-2.414.66-3.447a8.737 8.737 0 0 1 .346-.803Zm4.938 0a8.737 8.737 0 0 1 .347.803c.38 1.033.611 2.25.66 3.447H14.07c-.045-1.197-.279-2.414-.66-3.447a8.737 8.737 0 0 1-.347-.803ZM12 17.25a7.329 7.329 0 0 0 1.518-.147 10.243 10.243 0 0 1-3.034-2.957c.506.178 1.07.291 1.516.291ZM12 20.25a8.181 8.181 0 0 1-1.946-.257c.906-.545 1.772-1.247 2.517-2.08.745.833 1.611 1.535 2.517 2.08A8.181 8.181 0 0 1 12 20.25Z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Official Website</span>
                </a>
            </div>
        </div>

    </div>
    @endforeach
</footer>
