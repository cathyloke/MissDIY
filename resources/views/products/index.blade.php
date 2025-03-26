<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products List</title>
    <link rel="stylesheet" href="{{ asset('css/pages/product.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"/>
    <script src="https://kit.fontawesome.com/25b5310acf.js" crossorigin="anonymous"></script>
</head>
<body>
    <x-header/>
    <!-- Catogory -->
    <div class="category-breadcrumb">
        <span class="font-semibold">Category</span>
        <span class="mx-2">>></span>
        @if(isset($category) && $category)
            <span class="font-semibold">{{ $category->name }}</span>
        @else
            <span class="font-semibold">All Categories</span>
        @endif
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
    </script>
</body>
</html>