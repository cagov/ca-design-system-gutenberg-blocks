
(function() {
    window.addEventListener('load', function(){
        new Glider(document.querySelector('.glider'), {
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: '.dots',
            draggable: true,
        })
      })
})();


