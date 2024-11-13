document.querySelectorAll('.category-box').forEach(box => {
    box.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior
        document.querySelectorAll('.category-box').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('.showall').forEach(item => item.classList.remove('active'));
        this.classList.add('active');
    });
});

document.querySelectorAll('.showall').forEach(box => {
    box.addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelectorAll('.category-box').forEach(item => item.classList.remove('active'));
        this.classList.add('active');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Get the modal
    var modal = document.getElementById("product-modal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("product-modal-close")[0];

    // Get all view buttons
    var viewButtons = document.getElementsByClassName("view-btn");

    // Loop through all view buttons
    for (var i = 0; i < viewButtons.length; i++) {
        viewButtons[i].onclick = function(event) {
            event.preventDefault();
            // Open the modal
            modal.style.display = "block";
        };
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

// //ini function untuk memilih product berdasarkan category
// document.addEventListener('DOMContentLoaded', function () {
//     const categoryBoxes = document.querySelectorAll('.category-box');
//     const productBoxes = document.querySelectorAll('.product-box');
//     const showAllLink = document.querySelector('.showall');

//     categoryBoxes.forEach(box => {
//         box.addEventListener('click', function (e) {
//             e.preventDefault();
//             const category = box.dataset.category;
//             productBoxes.forEach(product => {
//                 if (product.dataset.category === category) {
//                     product.style.display = 'flex';
//                 } else {
//                     product.style.display = 'none';
//                 }
//             });
//         });
//     });

//     showAllLink.addEventListener('click', function (e) {
//         e.preventDefault();
//         productBoxes.forEach(product => {
//             product.style.display = 'flex';
//         });
//     });
// });