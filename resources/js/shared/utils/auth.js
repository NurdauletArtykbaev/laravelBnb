export function isLoggedIn(){
    return localStorage.getItem('isLoggedIn') = 'true';
}

export function logIn(){
    localStorage.setItem('isLoggedIn', true);
}

export function logged(){
    localStorage.setItem('isLoggedIn', false);
}
