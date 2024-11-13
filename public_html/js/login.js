const sign_in_btn = document.querySelector("#sign-in-btn");
        const sign_up_btn = document.querySelector("#sign-up-btn");
        const container = document.querySelector(".container");
    
        sign_up_btn.addEventListener("click", () => {
          container.classList.add("sign-up-mode");
        });
    
        sign_in_btn.addEventListener("click", () => {
          container.classList.remove("sign-up-mode");
        });
    
        window.addEventListener('load', function () {
          setTimeout(function () {
            document.getElementById('preloader').style.display = 'none';
            document.getElementById('container').style.display = 'block';
          }, 3000); // 5000 milidetik = 5 detik
        });