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




