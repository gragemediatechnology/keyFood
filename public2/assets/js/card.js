document.addEventListener('DOMContentLoaded', function () {
    const dropdownButtons = document.querySelectorAll('.dropdown-button');
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');

    dropdownButtons.forEach((button, index) => {
        button.addEventListener('click', function () {
            const dropdownMenu = dropdownMenus[index];
            dropdownMenu.style.top = `${button.offsetTop + button.offsetHeight}px`;
            dropdownMenu.style.left = `${button.offsetLeft - dropdownMenu.offsetWidth + 25}px`; // Adjust position to the left
            dropdownMenu.classList.toggle('show');
        });
    });

    document.addEventListener('click', function (e) {
        dropdownButtons.forEach((button, index) => {
            const dropdownMenu = dropdownMenus[index];
            if (!button.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
});