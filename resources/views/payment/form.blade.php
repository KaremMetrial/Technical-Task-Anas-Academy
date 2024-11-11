<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('payment.process') }}" method="POST" id="payment-form">
                        @csrf
                        <div class="mb-6">
                            <label for="card-element" class="block text-lg font-medium text-gray-700">
                                Credit or Debit Card
                            </label>
                            <div id="card-element" class="mt-2 p-4 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div id="card-errors" class="mt-2 text-red-500 text-sm" role="alert"></div>
                            <div>
                                <h4>Price: {{ $product_price }}</h4>
                                <h4>Product Name: {{ $product_name }}</h4>
                            </div>
                            <input type="hidden" disabled name="product_price" id="product_price" value="{{ $product_price }}">
                            <input type="hidden" disabled name="product_name" id="product_name" value="{{ $product_name }}">
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product_id }}">
                        </div>

                        <x-primary-button type="submit" class="ms-4">
                            Submit Payment
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe("{{ config('services.stripe.key') }}");
        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        var form = document.getElementById("payment-form");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            stripe.createToken(card).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById("card-errors");
                    errorElement.textContent = result.error.message;
                } else {
                    var token = result.token.id;
                    var hiddenInput = document.createElement("input");
                    hiddenInput.setAttribute("type", "hidden");
                    hiddenInput.setAttribute("name", "stripeToken");
                    hiddenInput.setAttribute("value", token);
                    form.appendChild(hiddenInput);

                    var productPriceInput = document.createElement("input");
                    productPriceInput.setAttribute("type", "hidden");
                    productPriceInput.setAttribute("name", "product_price");
                    productPriceInput.setAttribute("value", document.getElementById("product_price").value);
                    form.appendChild(productPriceInput);

                    var productNameInput = document.createElement("input");
                    productNameInput.setAttribute("type", "hidden");
                    productNameInput.setAttribute("name", "product_name");
                    productNameInput.setAttribute("value", document.getElementById("product_name").value);
                    form.appendChild(productNameInput);

                    var productIdInput = document.createElement("input");
                    productIdInput.setAttribute("type", "hidden");
                    productIdInput.setAttribute("name", "product_id");
                    productIdInput.setAttribute("value", document.getElementById("product_id").value);
                    form.appendChild(productIdInput);

                    form.submit();
                }
            });
        });
    </script>
</x-app-layout>
