const encrypt = sha256;

const authenticate = async (username, password) => {
    if (!encrypt) {
        alert('ERROR: Hashing algorithm was not loaded correctly.')
        return;
    }

    username = username.trim();
    password = password.trim();

    if (username === '') return 'Username cannot be empty';
    if (password === '') return 'Password cannot be empty';

    if (username.length < 4) return 'Username is too short';
    if (password.length < 6) return 'Password is too short';
    
    let response;
    try {
        response = await fetch('http://notik.nameless.pw/Project-main/api/auth/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                login: username,
                password: await encrypt(password)
            })
        });

    } catch (error) {
        console.error(`Cannot authenticate: ${error}`);
        return 'Request Error';
    }

    let response_json;
    try {
        response_json = await response.json();
    } catch (error) {
        console.error(`Cannot parse response: ${error}`);
        return 'Invalid Response';
    }

    if (response.status != 200 || !response_json || !response_json.access_token) {
        console.error(`Cannot authenticate: status ${response.status}, body: ${response_json}`);
        return 'Bad Response';
    }

    document.cookie = `access_token=${response_json.access_token}; path=/`;
    return null;
}

const authFormCallback = async (event) => {
    event.preventDefault();

    const username = event.target.getElementsByClassName('username');  // Input
    const password = event.target.getElementsByClassName('password');  // Input

    if (username.length === 0 || password.length === 0) {
        console.error('Username or password element not found.');
        return;
    }

    const errorMessage = await authenticate(username[0].value, password[0].value);
    if (errorMessage) {
        console.error(`Cannot authenticate: ${errorMessage}.`);

        const errorElement = event.target.getElementsByClassName('error');
        if (errorElement.length === 0) {
            console.warn('Cannot display error: no element found.');
            return;
        }
        
        errorElement[0].innerText = errorMessage;
        errorElement[0].hidden = false;
        return;
    }

    window.location.href = 'http://notik.nameless.pw/Project-main/index.php';
}
window.authFormCallback = authFormCallback;
