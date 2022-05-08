function effect_msg(elem) {
    $(elem).show(1000);
    setTimeout(function() { $(elem).fadeOut(1000); }, 3000);
}

function scrollToTopOfElement(element) {
    if (element.hash !== "") {
      var hash = element.hash;

      $('html, body').animate({
        scrollTop: $(element).offset().top
      }, 800, function(){
        window.location.hash = hash;
      });
    }
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(';').shift();
}
