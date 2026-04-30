//a function that hides and shows the dropdown box when clicked. The function was taken from 
// "https://www.youtube.com/watch?v=U04TFalv4h0&t=1018s" to toggle when to show and hide my dropdown menu.
const showDropdown = (dropdownId) =>{
    const dropdown = document.getElementById(dropdownId) //referes to the id attached to the account name.
    
    //when clicked the element attached to "show-dropdown" class should execute (it hides or shows it).
    dropdown.addEventListener('click', () =>{
        dropdown.classList.toggle('show-dropdown')
    })
}

//executing the function
showDropdown('dropdown');
