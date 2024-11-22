<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="bg-white overflow-hidden pl-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5">
                @if($errors->any())
                <div class="alert-alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li class="py-5 bg-red-500 text-white font-bold">
                            {{ $error }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- <a href="{{ route('seller.products.create') }}" class="border rounded-xl w-fit py-3 px-5 bg-indigo-950 text-white"> --}}
                <a href="/seller/products/create" class="border rounded-xl w-fit py-3 px-5 bg-indigo-950 text-white">
                    Add New Product
                </a>

                @forelse($products as $product)
                <div class="item-product flex flex-row justify-between items-center">
                    <img src="{{ asset($product->photo) }}" class="h-[100px] w-auto" alt="{{ $product->name }}" loading="lazy">
                    <div>
                        <h3>{{ $product->name }}</h3>
                        <p>{{ $product->category->name }}</p>
                        <p>{{ $product->creator->name }}</p>
                    </div>
                    <div>
                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex flex-row gap-x-3">
                        {{-- <a href="{{ route('seller.products.edit', $product) }}" class="py-3 px-5 border rounded-xl bg-indigo-500 text-white"> --}}
                        <a href="/seller/products/edit/{{ $product }}" class="py-3 px-5 border rounded-xl bg-indigo-500 text-white">
                            Edit
                        </a>
                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="py-3 px-5 mr-5 border rounded-xl bg-red-500 text-white">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <p>Belum ada produk tersedia</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this product?');
        }
    </script>
</x-app-layout>
