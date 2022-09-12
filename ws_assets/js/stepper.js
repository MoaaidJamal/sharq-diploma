(function ($) {
  $(document).ready(function () {
    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function () {
      current_fs = $(this).parent().parent();
      next_fs = $(this).parent().parent().next();

      //Add Class Active
        $("#progressbar li").removeClass('active');
      $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

      //show the next fieldset
      next_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative",
            });
            next_fs.css({ opacity: opacity });
          },
          duration: 600,
        }
      );
    });

    $(".previous").click(function () {
      current_fs = $(this).parent().parent();
      previous_fs = $(this).parent().parent().prev();

      //Add Class Active
        $("#progressbar li").removeClass('active');
      $("#progressbar li").eq($("fieldset").index(previous_fs)).addClass("active");

      //show the previous fieldset
      previous_fs.show();
      //hide the current fieldset with style
      current_fs.animate(
        { opacity: 0 },
        {
          step: function (now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
              display: "none",
              position: "relative",
            });
            previous_fs.css({ opacity: opacity });
          },
          duration: 600,
        }
      );
    });
  });
})(jQuery);
