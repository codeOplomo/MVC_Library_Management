
document.addEventListener('DOMContentLoaded', function () {
    // Get the modal element
    const addBookModal = document.getElementById('addBookModal');

    // Get the button that opens the modal
    const addBookBtn = document.getElementById('addBookBtn');

    // Get the close button in the modal
    const closeModalBtn = document.getElementById('closeModalBtn');

    // Get the form inside the modal
    const addBookForm = document.getElementById('addBookForm');

    // Function to open the modal
    function openModal() {
        addBookModal.style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        addBookModal.style.display = 'none';
    }

    // Event listener to open the modal when the "Add Book" button is clicked
    addBookBtn.addEventListener('click', openModal);

    // Event listener to close the modal when the close button is clicked
    closeModalBtn.addEventListener('click', closeModal);

    // Event listener to close the modal when clicking outside the modal
    window.addEventListener('click', function (event) {
        if (event.target === addBookModal) {
            closeModal();
        }
    });

    // Event listener to close the modal when pressing the 'Esc' key
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });

    // Function to handle the "Add Book" button click inside the modal
    function addBook() {
        // Add your logic to handle the book addition here
        // You can use the addBookForm to get the form data
        // After handling the addition, you may want to close the modal
        closeModal();
    }
});
