@extends('layouts.main')

@section('link')
    <link rel="stylesheet" href="https://rawcdn.githack.com/gragemediatechnology/keyFood/74094528fe5f3ca44c147b06f4c1039768fa9022/public/css/checkout.css">
@endsection

@section('container')
    <section id="home">
        <main class="mt-10">
            <section class="checkout-form">
                <form id="checkout-form" action="/checkout" method="post">
                    @csrf
                    <h2 class="font-manrope font-extrabold text-3xl lead-10 text-black mb-9">Pesanan Anda</h2>

                    @if ($loginType === 'email')
                        <!-- Email Input -->
                        <div class="form-control">
                            <label for="checkout-email">E-mail</label>
                            <div>
                                <span class="icon"><i class='bx bx-envelope'></i></span>
                                <input type="email" id="checkout-email" name="checkout-email"
                                    placeholder="Enter your email.. (opsional)."
                                    value="{{ old('checkout-email', $user->email ?? '') }}">
                            </div>
                        </div>
                        <!-- Phone Input -->
                        <div class="form-control">
                            <label for="checkout-phone">No. Telepon</label>
                            <div>
                                <span class="icon"><i class='bx bx-phone'></i></span>
                                <input type="tel" name="checkout-phone" id="checkout-phone"
                                    placeholder="Enter your phone..."
                                    value="{{ old('checkout-phone', $user->phone ?? '') }}" required>
                            </div>
                        </div>
                    @endif


                    @if ($loginType === 'phone')
                        <!-- Email Input -->
                        <div class="form-control">
                            <label for="checkout-email">E-mail</label>
                            <div>
                                <span class="icon"><i class='bx bx-envelope'></i></span>
                                <input type="email" id="checkout-email" name="checkout-email"
                                    placeholder="Enter your email.. (opsional)."
                                    value="{{ old('checkout-email', $user->email ?? '') }}">
                            </div>
                        </div>
                        <!-- Phone Input -->
                        <div class="form-control">
                            <label for="checkout-phone">No. Telepon</label>
                            <div>
                                <span class="icon"><i class='bx bx-phone'></i></span>
                                <input type="tel" name="checkout-phone" id="checkout-phone"
                                    placeholder="Enter your phone..."
                                    value="{{ old('checkout-phone', $user->phone ?? '') }}" required>
                            </div>
                        </div>
                    @endif

                    <br>
                    <!-- Shipping Address -->
                    <h3>Alamat Pengiriman</h3>
                    <div class="form-control">
                        <label for="checkout-name">Nama Lengkap</label>
                        <div>
                            <span class="icon"><i class='bx bx-user-circle'></i></span>
                            <input type="text" id="checkout-name" name="checkout-name" placeholder="Enter your name..."
                                value="{{ old('checkout-name', $user->name ?? '') }}" required>
                        </div>
                    </div>
                    <!-- Cluster Dropdown -->
                    <div class="form-control">
                        <label for="cluster-select">Pilih Cluster</label>
                        <div>
                            <span class="icon"><i class='bx bx-building'></i></span>
                            <select class="dropdown-alamat" name="cluster_id" id="cluster-select" required>
                                <option value="" disabled selected>Pilih Cluster...</option>
                                @foreach ($clusters as $cluster)
                                    <option value="{{ $cluster->id }}">{{ $cluster->nama_cluster }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Alamat Dropdown -->
                    <div class="form-control">
                        <label for="alamat-select">Pilih Alamat</label>
                        <div>
                            <span class="icon"><i class='bx bx-home'></i></span>
                            <select class="dropdown-alamat" name="alamat_cluster_id" id="alamat-select" required>
                                <option value="" disabled selected>Pilih Alamat...</option>
                            </select>
                        </div>
                    </div>
                    <!-- Nomor Dropdown -->
                    <div class="form-control">
                        <label for="nomor-select">Pilih Nomor</label>
                        <div>

                            <select name="nomor_id" id="nomor-select" required>
                                <option value="" disabled selected>Pilih Nomor...</option>
                            </select>
                        </div>
                    </div>
                    <!-- Notes Input -->
                    <div class="form-control">
                        <label for="checkout-notes">Catatan</label>
                        <div>
                            <span class="icon"><i class='bx bx-edit'></i></span>
                            <input type="text" name="checkout-notes" id="checkout-notes"
                                placeholder="Catatan Anda.. (opsional)" value="{{ old('checkout-notes') }}">
                        </div>
                    </div>
                    <!-- Hidden Inputs for Products and Total Price -->
                    <input type="hidden" name="products" id="products" required>
                    <input type="hidden" name="total_price" id="hidden-total-price" required>
                    <div class="form-control-btn">
                        <button type="submit">Checkout</button>
                    </div>
                </form>
            </section>

            <section class="checkout-details mt-20">
                <div class="checkout-details-inner">
                    <div class="checkout-lists" id="checkout-lists">
                        <!-- Card products will be appended here by JavaScript -->
                    </div>
                    <div class="checkout-total">
                        <h6>Total</h6>
                        <p class="total-price" id="total-price">Rp 0</p>
                    </div>
                </div>
            </section>
        </main>
    </section>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(event) {
            const products = JSON.parse(localStorage.getItem('cart')) || [];
            const totalPrice = document.getElementById('total-price').textContent.replace(/[^\d]/g,
                ''); // Menghilangkan simbol 'Rp' dan koma

            document.getElementById('products').value = JSON.stringify(products);
            document.getElementById('hidden-total-price').value = totalPrice;

            // Menghapus data dari LocalStorage setelah checkout
            // localStorage.removeItem('cart');

        });

        // Event listener for the cluster dropdown change
        document.getElementById('cluster-select').addEventListener('change', function() {
            const clusterId = this.value;
            const alamatSelect = document.getElementById('alamat-select');

            // Clear the alamat dropdown
            alamatSelect.innerHTML = '<option value="" disabled selected>Memuat alamat...</option>';

            fetch(`/get-alamat-by-cluster/${clusterId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data alamat.');
                    }
                    return response.json();
                })
                .then(data => {
                    alamatSelect.innerHTML = '<option value="" disabled selected>Pilih Alamat...</option>';
                    data.forEach(function(alamat) {
                        const option = document.createElement('option');
                        option.value = alamat.id;
                        option.textContent = alamat.alamat;
                        alamatSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengambil data alamat. Silakan coba lagi.');
                });
        });

        // Event listener for the alamat dropdown change
        document.getElementById('alamat-select').addEventListener('change', function() {
            const blokId = this.value;
            const nomorSelect = document.getElementById('nomor-select');

            // Clear the nomor dropdown
            nomorSelect.innerHTML = '<option value="" disabled selected>Memuat nomor...</option>';
            nomorSelect.disabled = true;

            if (blokId) {
                fetch(`/get-nomor-by-blok/${blokId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Gagal mengambil data nomor blok.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        nomorSelect.innerHTML = '<option value="" disabled selected>Pilih Nomor...</option>';
                        data.forEach(function(nomor) {
                            const option = document.createElement('option');
                            option.value = nomor.id;
                            option.textContent = nomor.nomor;
                            nomorSelect.appendChild(option);
                        });
                        nomorSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat mengambil data nomor blok. Silakan coba lagi.');
                    });
            } else {
                nomorSelect.innerHTML = '<option value="" disabled selected>Pilih Nomor...</option>';
                nomorSelect.disabled = true;
            }
        });
    </script>
@endsection

@section('script')
    <script defer src="https://raw.githack.com/gragemediatechnology/keyFood/main/public/js/checkout.js"></script>
@endsection
