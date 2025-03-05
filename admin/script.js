document.addEventListener('DOMContentLoaded', function() {
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    question.addEventListener('click', () => {
      const answer = item.querySelector('.faq-answer');
      const isOpen = answer.style.display === 'block';
      answer.style.display = isOpen ? 'none' : 'block';
    });
  });
});


// Get the modal
var modal = document.getElementById("modalLogin");

// Get the button that opens the modal
var btn = document.getElementById("login");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal
btn.onclick = function() {
modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
if (event.target == modal) {
  modal.style.display = "none";
}
}

let attempts = 0;
const maxAttempts = 3;

function login(event) {
  event.preventDefault(); // Prevent form submission

  let username = document.getElementById("exampleInputEmail1").value;
  let password = document.getElementById("exampleInputPassword1").value;

  if (username === "user123@gmail.com" && password === "user") {
    alert("Login Successful!");
      // Hide current modal (if any)
      modal.style.display = "none";
     

      document.getElementById("profile").removeAttribute("hidden")
      document.getElementById("start").setAttribute("hidden",true)
      // modal.style.display = "none";
      
  
    return true;

  } else {
      attempts++;
      alert(`Incorrect credentials! Attempt ${attempts} of ${maxAttempts}`);

      if (attempts >= maxAttempts) {
          document.getElementById("loginBtn").disabled = true;
          alert("Too many failed attempts! Login disabled.");
      }

      return false;
  }
}