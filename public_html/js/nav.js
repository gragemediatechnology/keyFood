document.addEventListener('DOMContentLoaded', function () {
    const dropdownButtons = document.querySelectorAll('.profile-button');
    const dropdownMenus = document.querySelectorAll('.profile-menu');

    dropdownButtons.forEach((button, index) => {
        button.addEventListener('click', function () {
            const dropdownMenu = dropdownMenus[index];
            dropdownMenu.style.top = `${button.offsetTop + button.offsetHeight}px`;
            dropdownMenu.style.left = `${button.offsetLeft - dropdownMenu.offsetWidth + 200 - 120 }px`; // Adjust position to the left
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

/*=============== SHOW MENU ===============*/
const showMenu = (toggleId, navId) =>{
    const toggle = document.getElementById(toggleId),
          nav = document.getElementById(navId)
 
    toggle.addEventListener('click', () =>{
        // Add show-menu class to nav menu
        nav.classList.toggle('show-menu')
        // Add show-icon to show and hide menu icon
        toggle.classList.toggle('show-icon')
    })
 }
 
 showMenu('nav-toggle','nav-menu')