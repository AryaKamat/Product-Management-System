function validateLoginForm() {
    const email = document.forms["loginForm"]["email"].value;
    const password = document.forms["loginForm"]["password"].value;

    if (!email) {
        alert("Email is required.");
        return false;
    }

    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email address.");
        return false;
    }

    if (!password) {
        alert("Password is required.");
        return false;
    }

    if (password.length < 8) {
        alert("Password must be at least 8 characters long.");
        return false;
    }

    return true;
}
