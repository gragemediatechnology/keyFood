@extends('admin.layouts.main-admin')
@section('container-admin')
<main class="h-screen overflow-y-auto">
    <div class="container px-6 mx-auto grid overflow-y-hidden py-4 mb-8">
        <div class="container mt-5">
            <h1 class="dark:text-gray-200 px-2">Backup Manual</h1>
            <button id="backup-btn"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg dark:bg-gray-700 dark:text-white mt-4">Backup
                Sekarang</button>
        </div>
        <center>
            {{-- <h1 class="dark:text-gray-200"><B>HALAMAN INI REFRESH OTOMATIS INTERVAL 5 DETIK!</B></h1> --}}
        </center>
        <h2 class="my-6 text-xl font-semibold text-gray-700 dark:text-gray-200">
            Riwayat Backups
        </h2>
        <div class="overflow-x-auto">
            <table class="w-full mt-4 table-auto text-center dark:text-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nama File</th>
                        <th class="px-4 py-2">Ukuran</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($backups as $backup)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $backup['filename'] }}</td>
                            <td class="px-4 py-2">{{ number_format($backup['size'] / 1048576, 2) }} MB</td>
                            <td class="px-4 py-2">{{ date('Y-m-d H:i:s', $backup['date']) }}</td>
                            <td class="px-4 py-2 text-sm">
                                <div class="flex justify-center gap-2">
                                    {{-- <a href="{{ route('admin.backups.download', $backup['filename']) }}" --}}
                                    <a href="/admin/backups/download/{{ $backup['filename'] }}"
                                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-100 focus:outline-none focus:shadow-outline-gray">
                                        <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M3 12a1 1 0 011-1h2V6a1 1 0 112 0v5h2V6a1 1 0 112 0v5h2a1 1 0 110 2H4a1 1 0 01-1-1zm12.707 3.293l-3-3a1 1 0 10-1.414 1.414L13 14.586V3a1 1 0 112 0v11.586l1.707-1.707a1 1 0 001.414 1.414l-3 3a1 1 0 01-1.414 0z">
                                            </path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Download
                                    </a>
                                    <form method="POST" action="{{ route('admin.backups.delete', $backup['filename']) }}"
                                    // <form method="POST" action="/admin/backups/{{ $backup['filename'] }}"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus backup ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-100 focus:outline-none focus:shadow-outline-gray">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</main>

{{--
<script>
    $('#backup-btn').click(function () {
        Swal.fire({
            title: 'Proses Backup Dimulai',
            text: 'Mohon tunggu, proses backup sedang berlangsung...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false
        });
        $.ajax({
            url: '{{ route('admin.backups.manual') }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Backup Berhasil',
                    text: response.success
                });
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Backup Gagal',
                    text: xhr.responseJSON.error || 'Terjadi kesalahan.'
                });
            }
        });
    });
</script> --}}

<script>
    $('#backup-btn').click(function () {
        Swal.fire({
            title: 'Proses Backup Dimulai',
            text: 'Mohon tunggu, proses backup sedang berlangsung...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false
        });

        $.ajax({
            // url: '{{ route('admin.backups.manual') }}',
            url: 'backups/manual',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                Swal.close();

                // Menampilkan data dari respons JSON
                console.log('Response:', response);

                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Backup Berhasil',
                        text: response.message
                    }).then(() => {
                        // Jika perlu, muat ulang halaman
                        location.reload();
                    });
                } else {
                    // Menampilkan pesan error jika status bukan success
                    Swal.fire({
                        icon: 'error',
                        title: 'Backup Gagal',
                        text: response.message || 'Terjadi kesalahan yang tidak diketahui.'
                    });
                }
            },
            error: function (xhr) {
                Swal.close();
                console.log('AJAX Error:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Backup Gagal',
                    text: 'Terjadi kesalahan saat melakukan backup. Silakan coba lagi nanti.'
                });
            }
        });
    });
    // Set interval untuk refresh halaman setiap 5 detik
    let refreshInterval;

    // function startAutoRefresh() {
    //     // Set interval untuk refresh halaman setiap 3 detik (3000 ms)
    //     refreshInterval = setInterval(function () {
    //         window.location.reload();
    //     }, 5000); // 3000 ms = 3 detik
    // }

    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    }

    // Mulai auto-refresh ketika halaman dimuat
    startAutoRefresh();

    // Cek status visibility halaman

    document.addEventListener('DOMContentLoaded', function () {
        if (document.visibilityState === 'visible') {
            // Halaman terlihat, mulai refresh
            startAutoRefresh();
        } else {
            // Halaman tidak terlihat, berhenti refresh
            stopAutoRefresh();
        }
    });

    // Cek status saat jendela difokuskan atau tidak
    window.addEventListener('focus', function () {
        if (document.visibilityState === 'visible') {
            startAutoRefresh();
        }
    });

    window.addEventListener('blur', function () {
        stopAutoRefresh();
    });
</script>
@endsection