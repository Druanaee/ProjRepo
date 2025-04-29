const logout = () => {
    document.cookie = "access_token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}


document.addEventListener('DOMContentLoaded', function() {
    const button = document.getElementById('login');
    if (!button) {
        console.error('Button `#login` not found.')
        return;
    }

    if (document.cookie.includes('access_token')) {
        button.textContent = 'Logout';
    } else {
        button.textContent = 'Login';
    }

    button.addEventListener('click', function() {
        if (document.cookie.includes('access_token')) {
            logout();
            window.location.reload();
        } else {
            window.location.replace("http://notik.nameless.pw/Project-main/index.php");
        }
    });
})
