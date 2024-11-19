 const buttons = document.querySelectorAll('.button-primary');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        var spanElement = document.querySelector('.icon-cart span');
        var currentCount = parseInt(spanElement.textContent);
        spanElement.textContent = currentCount + 1;
      });
    });