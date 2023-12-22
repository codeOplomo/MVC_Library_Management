const mobileMenuButton = document.querySelector('.mobile-menu-button');
const mobileMenu = document.querySelector('.mobile-menu');

mobileMenuButton.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
});

function reserveBook(bookId) {
    // Increment the cart count
    var cartCountElement = document.getElementById('cartCount');
    var currentCount = parseInt(cartCountElement.textContent);
    cartCountElement.textContent = currentCount + 1;

    // Store the reserved book in the session (you can modify this logic based on your needs)
    var reservedBooks = JSON.parse(sessionStorage.getItem('reservedBooks')) || [];
    reservedBooks.push({ id: bookId, title: bookTitle });
    sessionStorage.setItem('reservedBooks', JSON.stringify(reservedBooks));

    // Optionally, you can show a confirmation message
    alert('Book reserved successfully!');
}

async function updateCartCount() {
    try {
        const response = await fetch('path_to_cart_count_endpoint'); // Replace with the actual endpoint to fetch the count
        const countResult = await response.json();

        if (countResult.status) {
            // Update the cart count in the UI
            const cartCountElement = document.getElementById('cartCount');
            cartCountElement.textContent = countResult.count; // Assuming your response has a count property
        } else {
            console.error('Error fetching cart count:', countResult.message);
        }
    } catch (error) {
        console.error('Error fetching cart count:', error);
    }
}


document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
});