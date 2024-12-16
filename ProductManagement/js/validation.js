function validateDOB() {
  const dob = document.getElementById('dob').value;
  const dobDate = new Date(dob);
  const today = new Date();
  const age = today.getFullYear() - dobDate.getFullYear();
  const monthDifference = today.getMonth() - dobDate.getMonth();

  if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dobDate.getDate())) {
    age--;
  }

  if (age < 18) {
    alert('You must be at least 18 years old to sign up.');
    return false;
  }

  return true;
}

function validateForm() {
  if (!validateDOB()) {
    return false;
  }

  const firstName = document.forms["signupForm"]["firstname"].value;
  const lastName = document.forms["signupForm"]["lastname"].value;
  const email = document.forms["signupForm"]["email"].value;
  const password = document.forms["signupForm"]["password"].value;
  const cpass = document.forms["signupForm"]["cpass"].value;
  const profilePicture = document.forms["signupForm"]["profile_picture"].files[0];

  if (!/^[A-Za-z]+$/.test(firstName)) {
    alert("First Name should contain only letters.");
    return false;
  }

  if (!/^[A-Za-z]+$/.test(lastName)) {
    alert("Last Name should contain only letters.");
    return false;
  }

  const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
  if (!emailPattern.test(email)) {
    alert("Please enter a valid email address.");
    return false;
  }

  if (password.length < 8 || !/[a-zA-Z]/.test(password) || !/[0-9]/.test(password)) {
    alert("Password must be at least 8 characters long and include both letters and numbers.");
    return false;
  }

  if (password !== cpass) {
    alert("Passwords do not match.");
    return false;
  }

  if (profilePicture) {
    const validTypes = ["image/jpeg", "image/png", "image/gif"];
    const maxSize = 2 * 1024 * 1024; // 2 MB
    if (!validTypes.includes(profilePicture.type)) {
      alert("Only JPG, PNG, and GIF files are allowed.");
      return false;
    }
    if (profilePicture.size > maxSize) {
      alert("File size must be less than 2 MB.");
      return false;
    }
  }

  return true;
}
