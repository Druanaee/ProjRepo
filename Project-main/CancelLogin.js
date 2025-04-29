document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('cancelbtn');
    if (!button) {
        console.error('Button `#cancelbtn` not found.')
        return;
    }
    
    button.addEventListener('click', function() {
        window.location.replace("http://notik.nameless.pw/Project-main/login.html");
    });
})