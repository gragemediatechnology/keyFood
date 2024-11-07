@extends('admin.layouts.main-admin')
@section('container-admin')
    <main class="h-screen overflow-y-auto py-4">
        <div class="container px-6 mx-auto grid overflow-y-hidden py-4 mb-8">
            <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                Dashboard Payments
            </h2>

            <!-- Cards -->
            <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Users
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalUser }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Total Payment
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            Rp {{ $paymentTotal }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            New sales
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $totalOrders }}
                        </p>
                    </div>
                </div>
                <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                            Stores
                        </p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                            {{ $stores }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- New Table -->
            <div class="w-full overflow-hidden rounded-lg shadow-xs">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>

                            <tr
                                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">ID Pembayaran</th>
                                <th class="px-4 py-3">ID Toko</th>
                                <th class="px-4 py-3">Users</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Tanggal</th>
                            </tr>

                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($orders as $order)
                                <tr class="text-gray-700 dark:text-gray-400">
                                    <td class="px-4 py-3 text-sm">
                                        {{ $order->no_order }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $order->toko_id }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <!-- Avatar with inset shadow -->
                                            <div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full"
                                                    src="{{ $order->user->name }}" alt="user" loading="lazy" />
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                                                </div>
                                            </div>
                                            <div>
                                                <p class="font-semibold">{{ $order->user->name }}</p>
                                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $order->id_user }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        Rp. {{ $order->harga }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ $order->tanggal_order }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container px-6 mx-auto grid overflow-y-hidden">

                <!-- Charts -->
                <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    Charts
                </h2>
                <div class="grid gap-6 mb-8 md:grid-cols-2 py-4">
                    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                        <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                            Revenue
                        </h4>
                        <canvas id="pie"></canvas>
                        <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                            <!-- Chart legend -->
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 bg-blue-500 rounded-full"></span>
                                <span>Makanan Manis</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 bg-teal-600 rounded-full"></span>
                                <span>Makanan Asin</span>
                            </div>
                            <div class="flex items-center">
                                <span class="inline-block w-3 h-3 mr-1 bg-purple-600 rounded-full"></span>
                                <span>Minuman</span>
                            </div>
                        </div>
                    </div>

                     <div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
                         <div
                            class="relative mx-4 mt-4 flex flex-col gap-4 overflow-hidden rounded-none bg-transparent bg-clip-border text-gray-700 shadow-none md:flex-row md:items-center">
                             <div class="w-max rounded-lg bg-gray-900 p-5 text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3">
                                    </path>
                                </svg>
                                
                            </div>
                             <div>
                                <h6
                                    class="block font-sans text-base font-semibold leading-relaxed tracking-normal text-blue-gray-900 antialiased">
                                    Grafik Pengunjung Web Teras KBK
                                </h6>
                                <p
                                    class="block max-w-sm font-sans text-sm font-normal leading-normal text-gray-700 antialiased">
                                    Ini Adalah Visualisasi Data  Untuk Melihat Data Pengunjung Website
                                </p>
                                
                            </div>
                             <div class="pt-6 px-2 pb-0">
                                <div id="grafik-batang"></div>
                                
                            </div>
                             </div>
                        </div>


                </div>
            </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const visitData = @json($visitData);
            
            const configGrafik = {
                series: [{
                    name: "Kunjungan",
                    data: Object.values(visitData).map(day => day.count)
                }],
                chart: {
                    type: "bar",
                    height: 240,
                    toolbar: {
                        show: false,
                    },
                },
                title: {
                    show: false,
                },
                dataLabels: {
                    enabled: false,
                },
                colors: ["#020617"],
                plotOptions: {
                    bar: {
                        columnWidth: "40%",
                        borderRadius: 2,
                    },
                },
                xaxis: {
                    categories: Object.keys(visitData),
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    labels: {
                        style: {
                            colors: "#616161",
                            fontSize: "12px",
                            fontFamily: "inherit",
                            fontWeight: 400,
                        },
                    },
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: "#616161",
                            fontSize: "12px",
                            fontFamily: "inherit",
                            fontWeight: 400,
                        },
                    },
                },
                grid: {
                    show: true,
                    borderColor: "#dddddd",
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: true,
                        },
                    },
                    padding: {
                        top: 5,
                        right: 20,
                    },
                },
                fill: {
                    opacity: 0.8,
                },
                tooltip: {
                    theme: "dark",
                    y: {
                        formatter: function(val) {
                            return val + " kunjungan";
                        }
                    },
                    x: {
                        formatter: function(val) {
                            const dayData = visitData[val];
                            return dayData.date ? `${val} (${dayData.date})` : val;
                        }
                    }
                }
            };
        
            const chart = new ApexCharts(document.querySelector("#grafik-batang"), configGrafik);
            chart.render();
        });
        </script>
        
    <script>
        const visitData = @json($visitData);
        // Kemudian masukkan konfigurasi grafik yang baru
    </script>



    </div>
    </div>
@endsection
