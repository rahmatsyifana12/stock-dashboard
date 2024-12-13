@props(['role'])

<nav class="bg-white shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a href="/dashboard" class="text-2xl font-bold text-blue-600">My Dashboard</a>

        <!-- Navigation Buttons -->
        <div class="flex space-x-4">
            <a 
                href="/" 
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                Home
            </a>
            <a 
                href="/products" 
                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                View Products
            </a>
            @if ($role === 'admin')
                <a 
                    href="/products/create" 
                    class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded shadow hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">
                    Add New Product
                </a>
            @endif
        </div>

        <!-- Profile Dropdown -->
        <div class="relative" id="profileDropdownContainer">
            <button 
                class="flex items-center space-x-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-600 rounded" 
                id="profileDropdownButton">
                <img 
                    src="https://via.placeholder.com/40" 
                    alt="Profile" 
                    class="w-10 h-10 rounded-full border border-gray-300">
                <span class="font-medium">John Doe</span>
                <svg 
                    class="w-5 h-5" 
                    xmlns="http://www.w3.org/2000/svg" 
                    fill="none" 
                    viewBox="0 0 24 24" 
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-md hidden" 
                id="profileDropdown">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                
                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    @csrf
                    <button type="submit" class="w-full text-left">Logout</button>
                </form>
            </div>
        </div>

        <script>
            // Get the button and dropdown elements
            const dropdownButton = document.getElementById('profileDropdownButton');
            const dropdownMenu = document.getElementById('profileDropdown');
            const dropdownContainer = document.getElementById('profileDropdownContainer');

            // Function to toggle the dropdown visibility
            function toggleDropdown() {
                dropdownMenu.classList.toggle('hidden');
            }

            // Open the dropdown when the button is clicked
            dropdownButton.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the click event from propagating to the document
                toggleDropdown();
            });

            // Close the dropdown if clicked outside of the dropdown or profile button
            document.addEventListener('click', function(event) {
                if (!dropdownContainer.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Prevent closing dropdown when clicking inside the dropdown menu
            dropdownMenu.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevents the click event from propagating
            });
        </script>
    </div>
</nav>
