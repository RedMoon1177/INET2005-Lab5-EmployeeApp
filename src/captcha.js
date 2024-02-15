// Generate a random string for the CAPTCHA
function generateCaptcha() {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let captchaText = '';

    for (let i = 0; i < 6; i++) {
        const randomIndex = Math.floor(Math.random() * characters.length);
        captchaText += characters.charAt(randomIndex);
    }

    return captchaText;
}

// Display the CAPTCHA as an image
function displayCaptcha() {
    const captchaText = generateCaptcha();
    const captchaElement = document.getElementById('captcha');
    captchaElement.innerHTML = captchaText;
}

// Validate user input
function validateCaptcha() {
    const userInput = document.getElementById('userInput').value;
    const captchaText = document.getElementById('captcha').innerText;
    const resultElement = document.getElementById('result');

    if (userInput === captchaText) {
        resultElement.style.color = "blue";
        resultElement.textContent = 'You are not a robot! Then you can login!';
        document.getElementById('loginBtn').disabled = false;
    } else {
        resultElement.textContent = 'Failed! Please try again.';
    }
}

// Generate and display the CAPTCHA when the page loads
window.onload = displayCaptcha;
