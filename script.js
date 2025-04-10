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





