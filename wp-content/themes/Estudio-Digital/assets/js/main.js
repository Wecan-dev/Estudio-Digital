let ubicationP = window.pageYOffset;
window.onscroll = function(){
  let ScrollA = window.pageYOffset;
  if(ubicationP >= ScrollA){
    document.getElementById('header').style.top = '0';
  }
  else{
    document.getElementById('header').style.top = '-150px';
  }
  ubicationP = ScrollA;
}



$(function () {
  'use strict'

  $('[data-toggle="offcanvas"]').on('click', function () {
    $('.offcanvas-collapse').toggleClass('open');
    $('body').toggleClass('over')
  })
})

$(function () {
  'use strict'

  $('.nav-link__mobile').on('click', function () {
    $('.offcanvas-collapse').removeClass('open')
    $('.hamburger').removeClass("is-active");
    $('body').removeClass("over");
  })
})

// menu hambuger

$(".hamburger").on("click", function () {
  if (!$(this).hasClass("is-active")) {
    $(this).addClass("is-active")
    $('.navbar-fixed-js').addClass('fixed');
    $('.hamburger-inner').addClass('js-hamburger');
    $('.nav-link').addClass('fixed-color');
  } else {
    $(this).removeClass("is-active")
    if ($(document).scrollTop() <= 70 && ($(window).width() >= 0)) {
      $('.navbar-fixed-js').removeClass('fixed');
      $('.hamburger-inner').removeClass('js-hamburger');
      $('.nav-link').removeClass('fixed-color');

    }
  }
});

// Menú fixed
$(window).scroll(function () {
  if ($(document).scrollTop() > 70 && ($(window).width() >= 0)) {
    $('#header').addClass('fixed');
  } else {
    $('#header').removeClass('fixed');
  }
});


wow = new WOW();
wow.init();

const $video = document.querySelector('#videohome')
const options = {
  // root: document.querySelector('body'),
  rootMargin: '0px 0px 0px 0px',
  threshold: .5,
}
function callback(entries, observer) {
  console.log('se llamó al callback')
  if (entries[0].isIntersecting) {
    $video.play()
  } else {
    $video.pause()
  }
}
const observer = new IntersectionObserver(callback, options)
observer.observe($video)

function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  document.getElementById("myModal").style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
