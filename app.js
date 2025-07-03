// Google Sign-In
window.onload = function () {
    google.accounts.id.initialize({
        client_id: "785690845890-f98v41ao7r87f8olu190nc31eppu4joq.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
        document.getElementById("loginBtn"),
        { theme: "outline", size: "large" }
    );
};

function handleCredentialResponse(response) {
    console.log("Encoded JWT ID token: " + response.credential);
    alert("Login Successful! Token: " + response.credential);
    // Redirect or store token as needed
}

// Service Worker for PWA
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('sw.js')
        .then(() => console.log('Service Worker Registered'))
        .catch(err => console.error('Service Worker Error', err));
}
