<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <x-navbar />

    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Edit Product</h1>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Product Edit Form -->
        <form action="{{ route('products.update', $product->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="sku" class="block text-gray-700">SKU</label>
                <input 
                    type="text" 
                    name="sku" 
                    id="sku" 
                    class="w-full p-2 border border-gray-300 rounded" 
                    value="{{ old('sku', $product->sku) }}" 
                    required
                >
            </div>

            <div class="mb-4">
                <label for="name" class="block text-gray-700">Product Name</label>
                <input 
                    type="text" 
                    name="name" 
                    id="name" 
                    class="w-full p-2 border border-gray-300 rounded" 
                    value="{{ old('name', $product->name) }}" 
                    required
                >
            </div>

            <div class="mb-4">
                <label for="stock" class="block text-gray-700">Stock</label>
                <input 
                    type="number" 
                    name="stock" 
                    id="stock" 
                    class="w-full p-2 border border-gray-300 rounded" 
                    value="{{ old('stock', $product->stock) }}" 
                    required
                >
            </div>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">
                Update Product
            </button>
        </form>
    </div>
</body>
</html>
