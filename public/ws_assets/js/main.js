jQuery(function ($) {
  $(".heroSlider").owlCarousel({
    nav: false,
    loop: true,
    dots: false,
    items: 1

  });
  $(".InstructorsSlider").owlCarousel({
    nav: true,
    loop: false,
    dots: true,
    items: 4,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    margin: 70,
    responsive: {
      0: {
        items: 1
      },
      700: {
        items: 2
      },
      1000: {
        items: 4,
      },

    }
  });
  $(".partnerSlider").owlCarousel({
    nav: true,
    loop: false,
    dots: true,
    navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    items: 4,
    margin: 25,
    responsive: {
      0: {
        items: 2
      },
      1000: {
        items: 4,
      },

    },

  });

  $(".nav-slider").owlCarousel({
    nav: false,
    loop: false,
    dots: false,
    autoplay: true,
    items: 2

  });

  $('.success.chart').easyPieChart({
    size: 68,
    barColor: "#31D894",
    scaleLength: 0,
    lineWidth: 3,
    trackColor: "#E9E9E9",
    lineCap: "circle",
    animate: 2000,
  });
  $('.videoChart.chart').easyPieChart({
    size: 38,
    barColor: "#FFCE21",
    scaleLength: 0,
    lineWidth: 3,
    trackColor: "#E9E9E9",
    lineCap: "circle",
    animate: 2000,
  });
  $('.InProgress.chart').easyPieChart({
    size: 68,
    barColor: "#FFCE21",
    scaleLength: 0,
    lineWidth: 3,
    trackColor: "#E9E9E9",
    lineCap: "circle",
    animate: 2000,
  });

  $(window).scroll(function () {
    scrollTop = $(window).scrollTop();
    if ((scrollTop + $(window).height()) > $(document).height()) {

      $(".up").stop(true).animate({
        opacity: 1
      }, 100);


    } else {

      $(".up").stop(true).animate({
        opacity: 0
      }, 250);

    }



  });


  function onScroll(event) {
    var scrollPosition = $(document).scrollTop();
    $('.courseDetailsBody .coursepage-tabs .nav-link').each(function () {
      console.log($(this).attr('href'));
    });
  }

  $('.courseDetailsBody .coursepage-tabs .nav-link').click(function () {
    var refElement = $(this).attr("href");
    $('html, body').animate({ scrollTop: $(this.hash).offset().top - 5 }, 1000);

    $('.courseDetailsBody .coursepage-tabs .nav-item').removeClass("active");

    $(this).closest('.nav-item').addClass("active");

    return false;

  });

  $(document).on("scroll", onScroll);
  // alert(scrollTop);
  $(".up").on("click", function (e) {
    e.preventDefault()
    $("html, body").animate({ scrollTop: 0 }, "slow");
  });

  $(".langBtn").click(function () {
    $(".langDropDown").toggle()
  });
  $(".showHidePass").click(function () {

    var x = $(this).closest(".form-group").find(".form-control");
    if (x.attr("type") == "text") {
      x.attr("type", "password");
      $(this).closest(".form-group").find(".showPass").css("display", "block");
      $(this).closest(".form-group").find(".hidePass").css("display", "none");
    }
    else {
      x.attr("type", "text");
      $(this).closest(".form-group").find(".hidePass").css("display", "block");
      $(this).closest(".form-group").find(".showPass").css("display", "none");
    }
  });

  // make it as accordion for smaller screens

  $('.dropdown-menu a').click(function (e) {
    if ($(this).next('.submenu').length) {
      $(this).addClass("active")
      $('.submenu').hide();
      $(this).next('.submenu').css("display", "block");
    }
    $('.dropdown').on('hide.bs.dropdown', function () {
      $(this).find('.submenu').hide();
    })
  });


    $('.select').selectric({
      disableOnMobile: false,
      nativeOnMobile: false
    }
    );
  $('.selectric .button').text('');

  $('.selectric .button').append('<i class="lni lni-chevron-down"></i>');
  $('.loginLink').click(function () {
    $('.modal').modal('hide');
    $('#LoginModal').modal('show')
  });
  $('.regBtnLink').click(function () {
    $('.modal').modal('hide');
    $('#regModal').modal('show')
  });
  $('.forgetLink').click(function () {
    $('.modal').modal('hide');
    $('#forgerPassModal').modal('show')
  });
  $('.instructortBtn').click(function () {
    $('.modal').modal('hide');
    $('#InstructorModal').modal('show')
  });

    $(".slider-range-min").each(function () {
        $(this).slider({
            range: "min",
            value: !isNaN($(this).parents('.slidecontainer').find(".amount").val()) ? parseInt($(this).parents('.slidecontainer').find(".amount").val()) : 60,
            min: 1,
            max: 100,
            slide: function (event, ui) {
                $(this).parents('.slidecontainer').find(".amount").val("%" + ui.value);
            }
        });
        $(this).parents('.slidecontainer').find(".amount").val("%" + $(this).slider("value"));
    })

  $(".slider-range").slider({
    range: "min",
    value: 65,
    max: 100,
    min: 1
  });

  /************************ */


  /**************FAQ Collapse */
  $('.accordion-panel').click(function () {
    $(this).not(this).find('span:first').removeClass('lni-chevron-up').addClass('lni-chevron-down');
    $(this).find('span:first').toggleClass('lni lni-chevron-up lni lni-chevron-down');
  })
  $(".CurriculumList .CurriculumLink").click(function () {
    $(this).not(this).find('span:first').removeClass('lni-chevron-down').addClass('lni-chevron-up');
    $(this).find('span:first').toggleClass('lni lni-chevron-down lni lni-chevron-up');
  })
  $(".NoteCollapse .accordion-panel").click(function () {
    $(this).not(this).find('span:first').removeClass('lni-chevron-up').addClass('lni-chevron-down');
    $(this).find('span:first').toggleClass('lni lni-chevron-up lni lni-chevron-down');
  })
  $('.faqHeader').click(function () {
    $(this).parent().find('.faqbody').slideToggle(400);
  });
  $(".faqHeader").on("click", "a", function (e) { e.preventDefault() });

  $('.CurriculumList .CurriculumLink').click(function () {
    $(this).parent('li').find('.innerCurriculumList').toggle(400);
  });
  $(".radioBtnContainer").on("click", "a", function (e) { e.preventDefault() });
  $(".NoteCollapse").on("click", "a", function (e) { e.preventDefault() });
  $(".issueCertificateBtn").click(function () {
    $(this).css("display", "none");
    $(this).parent().find(".MyCoursesCertficateBtns").css("display", "block");
    $(this).parent().parent().find(".MycourseCertificateImg").css("filter", "blur(0)")
  });
  $(".readOnlyRating").starRating({
    starSize: 16,
    activeColor: '#FFD93F',
    hoverColor: '#FFD93F',
    ratedColor: '#FFD93F',
    emptyColor: 'transparent',
    starShape: 'straight',
    strokeColor: '#FFD93F',
    strokeWidth: 9,
    ratedColors: '#FFD93F',
    useGradient: false,
    readOnly: true,
    callback: function (currentRating, $el) {
      // make a server call here
    }
  });
  $(".lectureReviewsReadOnly").starRating({
    starSize: 16,
    activeColor: '#FFD93F',
    hoverColor: '#FFD93F',
    ratedColor: '#FFD93F',
    emptyColor: 'transparent',
    starShape: 'straight',
    strokeColor: '#FFD93F',
    strokeWidth: 9,
    ratedColors: '#FFD93F',
    useGradient: false,
    readOnly: true,
    callback: function (currentRating, $el) {
      // make a server call here
    }
  });
  $(".learnerReviewsReadOnly").starRating({
    starSize: 16,
    rtl: true,
    activeColor: '#FFB13E',
    hoverColor: '#FFB13E',
    ratedColor: '#FFB13E',
    emptyColor: 'transparent',
    starShape: 'straight',
    strokeColor: '#FFB13E',
    strokeWidth: 9,
    ratedColors: '#FFD93F',
    useGradient: false,
    readOnly: true,
    callback: function (currentRating, $el) {
      // make a server call here
    }
  });
  $(".leaveReviewRating").starRating({
    starSize: 16,
    activeColor: '#FFB13E',
    hoverColor: '#FFB13E',
    ratedColor: '#FFB13E',
    emptyColor: 'transparent',
    starShape: 'straight',
    strokeColor: '#FFB13E',
    strokeWidth: 9,
    ratedColors: '#FFD93F',
    useGradient: false,
    disableAfterRate: true,
    useFullStars: true,

    callback: function (currentRating, $el) {
      // make a server call here
    }

  });


});



