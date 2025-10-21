const hamburger = document.getElementById('hamburger');
const x = document.getElementById('x');
const navButtons = document.querySelector('.nav-buttons');

hamburger.addEventListener('click', () => {
  navButtons.classList.add('show');
  hamburger.classList.add('hidden');
  x.classList.add('show');
});

x.addEventListener('click', () => {
  navButtons.classList.remove('show');
  hamburger.classList.remove('hidden');
  x.classList.remove('show');
});

let scrollButton = document.getElementById("scroll");
console.log(scrollButton);
window.addEventListener("scroll", () => {
  console.log("scrollY:", window.scrollY);
    if (window.scrollY > 20) {
      scrollButton.style.display = "block";
    } else {
      scrollButton.style.display = "none";
    }
  });

function scrollToTop() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
} 