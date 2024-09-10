document.addEventListener("DOMContentLoaded", function() {
    // Event listener untuk tombol "Add to Cart"
    const addToCartButtons = document.querySelectorAll(".button");
    
    addToCartButtons.forEach(button => {
        button.addEventListener("click", function() {
            const productName = this.getAttribute("data-product-name");
            alert(`Product "${productName}" added to cart!`);
        });
    });
    
    // Animasi kecil pada hover untuk elemen kartu produk
    const productCards = document.querySelectorAll(".product-card");
    
    productCards.forEach(card => {
        card.addEventListener("mouseover", function() {
            card.style.boxShadow = "0 4px 20px rgba(0, 0, 0, 0.2)";
        });
        
        card.addEventListener("mouseout", function() {
            card.style.boxShadow = "0 2px 10px rgba(0, 0, 0, 0.1)";
        });
    });
});
