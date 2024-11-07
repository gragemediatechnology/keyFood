@extends('admin.layouts.main-admin')
@section('container-admin')
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });

        setTimeout(function() {
            window.location.reload();
        }, 2000);
    </script>
@endif

<main class="h-screen pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid py-4 mb-8">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            CMS
        </h2>

        <!-- Tabel Baru -->
        <div class="w-full overflow-hidden rounded-lg shadow-xs">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                            <th class="px-3 py-3">Img Home 1</th>
                            <th class="px-3 py-3">Img Home 2</th>
                            <th class="px-2 py-3">Img Home 3</th>
                            <th class="px-4 py-3">Logo</th>
                            <th class="px-4 py-3">Nama Perusahaan</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Lokasi</th>
                            <th class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        @foreach ($companys as $company)
                            <tr class="text-gray-700 dark:text-gray-400">
                                <td class="px-6 py-3">
                                    <div class="flex items-center text-sm">
                                        <!-- Avatar dengan bayangan -->
                                        <div class="relative w-8 h-8 mr-3 rounded-full"> <!-- Menghapus class hidden -->
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="https://lapakkbk.online/{{ $company->gambar_home_1 }}"
                                                alt="Gambar Home 1" loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-8 h-8 mr-3 rounded-full"> <!-- Menghapus class hidden -->
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="https://lapakkbk.online/{{ $company->gambar_home_2 }}"
                                                alt="Gambar Home 2" loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-8 h-8 mr-3 rounded-full"> <!-- Menghapus class hidden -->
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="https://lapakkbk.online/{{ $company->gambar_home_3 }}"
                                                alt="Gambar Home 3" loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-8 h-8 mr-3 rounded-full"> <!-- Menghapus class hidden -->
                                            <img class="object-cover w-full h-full rounded-full"
                                                src="https://lapakkbk.online/{{ $company->logo }}"
                                                alt="Logo Perusahaan" loading="lazy" />
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <p class="font-semibold">{{$company->company_name}}</p>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <p class="font-semibold">{{$company->email}}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-sm">
                                    <p class="font-semibold">{{$company->lokasi}}</p>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center space-x-4 text-sm">
                                        <a href="/admin/company/edit/{{ $company->id }}">
                                            <button
                                                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                                aria-label="Edit">
                                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection