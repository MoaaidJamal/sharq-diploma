// toggle navbar
document.querySelectorAll(".dropdown-toggle").forEach((item) => {
  item.addEventListener("click", (event) => {
    if (event.target.classList.contains("dropdown-toggle")) {
      event.target.classList.toggle("toggle-change");
    } else if (
      event.target.parentElement.classList.contains("dropdown-toggle")
    ) {
      event.target.parentElement.classList.toggle("toggle-change");
    }
  });
});


// modal
function onClick(element) {
  document.getElementById("img-modal").src = element.src;
}

// change color

function changColor(item) {
  if (item.style.backgroundColor === "white") {
    item.style.backgroundColor = "gray";
    item.style.color = "white";
  } else {
    item.style.backgroundColor = "white";
    item.style.color = "black";
  }
}

// Modal
$(function () {
  $("label.lightbox-thumbnail").on('click', function () {
    // Grabs the src information from the label > img
    var showImage = $(this).children().attr("src");
    console.log(showImage);
    // Places the information into the img src of the lightbox picture
    $(".lightbox-img").attr("src", showImage);
  })
})
