document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('logo');
    if (!button) {
        console.error('Button `#logo` not found.')
        return;
    }
    
    button.addEventListener('click', function() {
        window.location.replace("http://notik.nameless.pw/Project-main/index.html");
    });
})