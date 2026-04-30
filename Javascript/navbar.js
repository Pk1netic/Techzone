//this script was made from scratch to show and hide the navigation bar when the hamburger menu has been clicked in mobile mode.

const showDropdownResponsive = () => {
    const menu = document.getElementById('menu'); //referes to the menu class attached to the hamburger meny button
    const navbar = document.querySelector('.show-navbar'); //referes to the class attached to the nav element

    //when the hamburger menu has been clicked then the show-navigationbar should execute (it hides or shows it).
    menu.addEventListener('click', () => {
      navbar.classList.toggle('show-navigationbar'); //the style to execute when the menu bar has been clicked
    });
};

//executing the function
showDropdownResponsive();