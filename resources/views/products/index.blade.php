<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="{{ asset('css/pages/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app2.css') }}"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <x-header/>

    <!-- Catogory -->
    <div class="category-breadcrumb">
        <!-- Plain text for users, and href for admin to edit -->
        @can('isAdmin')
            <a href="{{ route('categories.index') }}">Category</a>
        @endcan
        @can('isCustomer')
            <span class="font-semibold">Category</span>
        @endcan
         
        <span class="mx-2">>></span>
        @if(isset($category) && $category)
            <span class="font-semibold">{{ $category->name }}</span>
        @else
            <span class="font-semibold">All Categories</span>
        @endif

        <button onclick="toggleFilter()"><i class="fa-solid fa-filter"></i></button>
    </div>

    <!-- Create Product Button -->
    @can('isAdmin')
        <div class="create-product-btn-container">
            <a href="{{ route('products.create') }}" class="create-product-btn">
                <i class="fas fa-plus"></i> Create New Product
            </a>
        </div>
    @endcan 

    <!-- Filter Panel -->
    <div id="filterPanel" class="filter-panel hidden">
        <div class="filter-panel-header">
            <div class="back-button-container">
                <button class="back-button" onclick="toggleFilter()" aria-label="Close filter panel">←</button>
            </div>
            <h3 class="filter-title">Filter Options</h3>
        </div>
        
        <div class="filter-options">
            <h5>Category Filtering</h5>
            <div class="category-buttons">
                <button class="category-button {{ !$selectedCategory ? 'active' : '' }}" 
                        data-category="">All Categories</button>
                @foreach($categories as $category)
                    <button class="category-button {{ $selectedCategory && $selectedCategory->id == $category->id ? 'active' : '' }}" 
                            data-category="{{ $category->id }}">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            <h5>Price Sorting</h5>
            <div class="price-sort-options">
                <button class="price-sort-button {{ $sortOrder == 'asc' ? 'active' : '' }}" 
                        data-sort="asc">Low to High</button>
                <button class="price-sort-button {{ $sortOrder == 'desc' ? 'active' : '' }}" 
                        data-sort="desc">High to Low</button>
            </div>
        </div>

        <div class="apply-button-container">
            <button class="apply-button" onclick="applyFilters()">Apply Filters</button>
        </div>
    </div>

    <!-- Product -->
    <div class="product-container">
        @foreach($products as $product)
            <div class="product-card" data-product-id="{{ $product->id }}">
                <img class="product-picture" src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}">
                <p class="product-name">{{ $product->name }}</p>
                <p class="product-price">${{ number_format($product->price, 2) }}</p>
            </div>
        @endforeach
    </div>

    <!-- Product Modal -->
    <div id="productModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        // Handle product card clicks
        document.querySelectorAll('.product-card').forEach(card => {
            card.addEventListener('click', function(e) {
                const productId = this.dataset.productId;
                openModal(productId);
            });
        });

        function openModal(productId) {
            fetch(`/products/${productId}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("modalContent").innerHTML = data;
                    document.getElementById("productModal").style.display = "flex";
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById("modalContent").innerHTML = 
                        `<div class="text-red-500 p-4">Error loading product details</div>`;
                    document.getElementById("productModal").style.display = "flex";
                });
        }

        function closeModal() {
            document.getElementById("productModal").style.display = "none";
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('productModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Close modal with ESC key
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Filter Panel
        function toggleFilter() {
            const panel = document.getElementById('filterPanel');
            panel.classList.toggle('active');
            
            // Toggle overlay if it exists
            const overlay = document.querySelector('.filter-overlay');
            if (overlay) {
                overlay.style.display = panel.classList.contains('active') ? 'block' : 'none';
            }
        }

        function applyFilters() {
            // Get selected category from active button
            const categoryButton = document.querySelector('.category-button.active');
            const categoryId = categoryButton ? categoryButton.dataset.category : '';
            
            // Get selected sort from active button
            const sortButton = document.querySelector('.price-sort-button.active');
            const sort = sortButton ? sortButton.dataset.sort : 'asc';
            
            // Redirect with filters
            window.location.href = `{{ route('products.index') }}?categoryId=${categoryId}&sort=${sort}`;
        }

        // Initialize filter buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Category button click handlers
            document.querySelectorAll('.category-button').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.category-button').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Price sort button click handlers
            document.querySelectorAll('.price-sort-button').forEach(button => {
                button.addEventListener('click', function() {
                    document.querySelectorAll('.price-sort-button').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });
            
            // Close panel when clicking overlay
            const overlay = document.querySelector('.filter-overlay');
            if (overlay) {
                overlay.addEventListener('click', toggleFilter);
            }
        });
    </script>
</body>
</html>