document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.getElementById('menu-toggle');
    const contactToggle = document.getElementById('contact-toggle');
    const menuDropdown = document.getElementById('menu-dropdown');
    const contactDropdown = document.getElementById('contact-dropdown');

    menuToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        contactDropdown.classList.remove('active');
        contactToggle.classList.remove('active');

        this.classList.toggle('active');
        menuDropdown.classList.toggle('active');
    });

    contactToggle.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        menuDropdown.classList.remove('active');
        menuToggle.classList.remove('active');

        this.classList.toggle('active');
        contactDropdown.classList.toggle('active');
    });

    document.addEventListener('click', function (e) {
        if (!menuDropdown.contains(e.target) && e.target !== menuToggle) {
            menuDropdown.classList.remove('active');
            menuToggle.classList.remove('active');
        }
        if (!contactDropdown.contains(e.target) && e.target !== contactToggle) {
            contactDropdown.classList.remove('active');
            contactToggle.classList.remove('active');
        }
    });

    const menuDropdownItems = menuDropdown.querySelectorAll('a');
    menuDropdownItems.forEach(item => {
        item.addEventListener('click', function () {
            menuDropdown.classList.remove('active');
            menuToggle.classList.remove('active');
        });
    });

    const contactDropdownItems = contactDropdown.querySelectorAll('a');
    contactDropdownItems.forEach(item => {
        item.addEventListener('click', function () {
            contactDropdown.classList.remove('active');
            contactToggle.classList.remove('active');
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            menuDropdown.classList.remove('active');
            menuToggle.classList.remove('active');
            contactDropdown.classList.remove('active');
            contactToggle.classList.remove('active');
        }
    });
});