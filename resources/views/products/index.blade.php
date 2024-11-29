<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <x-navbar />
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Product Inventory</h1>
        <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-left bg-gray-100 border-b text-gray-600 font-medium">SKU</th>
                    <th class="py-3 px-4 text-left bg-gray-100 border-b text-gray-600 font-medium">Name</th>
                    <th class="py-3 px-4 text-left bg-gray-100 border-b text-gray-600 font-medium">Stock</th>
                    <th class="py-3 px-4 text-left bg-gray-100 border-b text-gray-600 font-medium">Action Edit</th>
                    <th class="py-3 px-4 text-left bg-gray-100 border-b text-gray-600 font-medium">Action Delete</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $product->sku }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $product->name }}</td>
                        <td class="py-3 px-4 border-b text-gray-700">{{ $product->stock }}</td>
                        <td class="py-3 px-4 border-b">
                            <!-- Edit Button -->
                            <a href="{{ route('products.edit', $product->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        </td>
                        <td class="py-3 px-4 border-b text-gray-700">
                            <!-- Delete Button -->
                            <button 
                                class="delete-btn text-red-500 hover:text-red-700"
                                data-id="{{ $product->id }}"
                                onclick="deleteProduct({{ $product->id }})">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center text-gray-700">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`/products/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message); // Show success or error message
                        location.reload(); // Reload the page to reflect the changes
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>
