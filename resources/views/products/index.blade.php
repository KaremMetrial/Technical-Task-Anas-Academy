<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-3xl text-gray-800">
                {{ __('Products') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <form id="productForm" method="POST">
                    @csrf
                    <div class="p-6 bg-gray-50 text-gray-900">
                        <div class="flex space-x-6">
                            <div class="flex-1">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name"
                                    class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-300"
                                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-500" />
                            </div>
                        </div>

                        <div class="flex space-x-6">
                            <div class="flex-1">
                                <x-input-label for="quantity" :value="__('Quantity')" />
                                <x-text-input id="quantity"
                                    class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-300"
                                    type="number" name="quantity" :value="old('quantity')" required autocomplete="quantity" />
                                <x-input-error :messages="$errors->get('quantity')" class="mt-2 text-sm text-red-500" />
                            </div>

                            <div class="flex-1">
                                <x-input-label for="price" :value="__('Price')" />
                                <x-text-input id="price"
                                    class="block mt-1 w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-300"
                                    type="number" name="price" :value="old('price')" required autocomplete="price" />
                                <x-input-error :messages="$errors->get('price')" class="mt-2 text-sm text-red-500" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button type="submit" class="ms-4">
                                {{ __('Add Product') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>

                <div class="p-6 bg-gray-50 text-gray-900">
                    <h4 class="text-2xl font-semibold text-gray-700 mb-6">Product List</h4>
                    <div id="productList">
                        @foreach ($products as $product)
                            <div class="flex justify-between items-center py-4 border-b border-gray-200">
                                <div>
                                    <h5 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h5>
                                    <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
                                </div>

                                <div class="flex space-x-4">
                                    <div class="col p-2">
                                        <form method="GET" action="{{ route('payment.show') }}">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="product_name" value="{{ $product->name }}">
                                            <input type="hidden" name="product_price" value="{{ $product->price }}">
                                            <x-primary-button type="submit" class="ms-4">
                                               Checkout
                                            </x-primary-button>
                                        </form>
                                    </div>
                                    @can('delete', $product)
                                        <div class="col p-2">
                                            <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button type="submit">
                                                    Delete
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Use full jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#productForm').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                $.ajax({
                    url: '{{ route('products.store') }}',
                    method: 'POST',
                    data: $(this).serialize(), // Serialize the form data
                    success: function(response) {
                        alert('Product added successfully');

                        let productHTML = `
                            <div class="flex justify-between items-center py-4 border-b border-gray-200">
                                <div>
                                    <h5 class="text-xl font-semibold text-gray-800">${response.product.name}</h5>
                                    <p class="text-gray-600">${response.product.price}</p>
                                </div>
                            </div>
                        `;
                        $('#productList').append(productHTML);
                        $('#productForm')[0].reset();
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
</x-app-layout>
