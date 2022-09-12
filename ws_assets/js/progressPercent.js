(function ($) 
{
  

// profile
$(".one.circle")
.circleProgress({
  startAngle: -Math.PI/2,
  value: document.getElementById('profile').getAttribute("data-profile")/100,
  thickness: 15,
  fill: "#F3BD01",
  size:100
})
.on("circle-animation-progress", function (event, progress) {
  $(this)
    .find("strong")
    .html((document.getElementById('profile').getAttribute("data-profile")) + "<i>%</i>");
});
  

})(jQuery);












