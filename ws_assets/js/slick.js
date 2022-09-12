$('.carousel-slide').slick({
  speed: 500,
  slidesToShow: 4,
  slidesToScroll: 4,
  autoplay: true,
  autoplaySpeed: 2000,
  dots: true,
  centerMode: true,
  responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        centerMode: true,

      }

    }, {
      breakpoint: 1000,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 3,
        dots: true,
        infinite: false,

      }
    }, {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
      },

    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 2000,
      },

    }
  ]
});