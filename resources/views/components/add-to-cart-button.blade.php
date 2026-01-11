<!-- Sử dụng trong trang danh sách sản phẩm hoặc chi tiết sản phẩm -->

<!-- Form đơn giản -->
<form action="{{ route('cart.add', $product->id) }}" method="POST" class="inline-block">
    @csrf
    <input type="hidden" name="quantity" value="1">
    <button type="submit" 
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Thêm vào giỏ
    </button>
</form>

<!-- Form với chọn số lượng -->
<form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
    @csrf
    <div class="flex items-center space-x-4">
        <label class="font-medium">Số lượng:</label>
        <div class="flex items-center border rounded-lg">
            <button type="button" 
                    onclick="decrementQuantity()" 
                    class="px-3 py-2 hover:bg-gray-100">
                -
            </button>
            <input type="number" 
                   id="quantity" 
                   name="quantity" 
                   value="1" 
                   min="1" 
                   max="{{ $product->quantity }}"
                   class="w-16 text-center border-x py-2 focus:outline-none">
            <button type="button" 
                    onclick="incrementQuantity({{ $product->quantity }})" 
                    class="px-3 py-2 hover:bg-gray-100">
                +
            </button>
        </div>
        <span class="text-sm text-gray-500">{{ $product->quantity }} sản phẩm có sẵn</span>
    </div>
    
    <button type="submit" 
            class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-medium">
        <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
        Thêm vào giỏ hàng
    </button>
</form>

<script>
function incrementQuantity(max) {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}
</script>