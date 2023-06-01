// Temporary code used from the getting started document.
// This doesn't work just yet; fixing ASAP.
// Priority:
//      - login.php
//      - Register.php
//      - AddContact.php
//      - DeleteContact.php
//      - EditContact.php
//      - SearchContacts.php
//          - ListContact.php???

// Coming soon: functions for validating text input based on the form,
// functions for login(), register(), contact-related queries, md5 password
// hashing, and moreeee. Plus rewriting everything below.

document.addEventListener('DOMContentLoaded', function()
{
    // Login
  var loginButton = document.getElementById('buttonLogin');
  //var registerButton = document.getElementById('register-btn');

  loginButton.addEventListener('click', function() {
    var username = document.getElementById('formUsername').value;
    var password = document.getElementById('formPassword').value;

    // To-do, hash password here
    
    // To-do, validate username and password according to regex here

    // Combine username and HASHED (todo) password into object
    let combined = {
    	Username: username,
	Password: password
};

    // Stringify the object for JSON to be sent
    let JSONtext = JSON.stringify(combined);


    // Perform login validation using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'http://146.190.213.251/LAMPAPI/login.php', true);
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Login successful, redirect to main page
          window.location.href = 'contacts.html';
        } else {
          // Login failed, show error message
          alert('Login failed. Please check your username and password.');
          // To-do, update text on errors div in website HTML instead. Dialogue box debug only.
        }
      }
    };
    xhr.send(JSONtext);
  });
  
  // Missing: register.
  
  // Add contact
  var addContactButton = document.getElementById('add-contact-btn');

  addContactButton.addEventListener('click', function() {
    var firstName = document.getElementById('contact-firstname').value;
    var lastName = document.getElementById('contact-lastname').value;
    var phoneNumber = document.getElementById('contact-phone').value;
    var email = document.getElementById('contact-email').value;

    // Perform AJAX request to AddContact.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'AddContact.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Contact added successfully
          alert('Contact added successfully.');
          // Clear input fields
          document.getElementById('contact-firstname').value = '';
          document.getElementById('contact-lastname').value = '';
          document.getElementById('contact-phone').value = '';
          document.getElementById('contact-email').value = '';
        } else {
          // Failed to add contact
          alert('Failed adding contact.');
        }
      }
    };
    xhr.send('firstName=' + encodeURIComponent(firstName) +
             '&lastName=' + encodeURIComponent(lastName) +
             '&phoneNumber=' + encodeURIComponent(phoneNumber) +
             '&email=' + encodeURIComponent(email));
  });

  //registerButton.addEventListener('click', function() {
  //  // Redirect to the registration page
  //  window.location.href = 'register.html';
  //});
});
