console.log('Menu File working');

document.addEventListener('DOMContentLoaded', function() {
    const dropdownToggle = document.querySelectorAll('.dropdown-toggle');
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');

    dropdownToggle.forEach(navlink => {
        navlink.addEventListener('click', () => {
            const parentDropdownMenu = navlink.nextElementSibling;
            parentDropdownMenu.classList.toggle('show');
        });
    });
});