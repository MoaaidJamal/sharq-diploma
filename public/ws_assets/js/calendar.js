(function ($) 
{
  

var calendarEl = document.getElementById("schedule-calendar");
var eventsData = [
  {
    id: 1,
    title: "mona",
    start: "2020-09-11T08:00",
    classNames: ["", "important-event","customer-setting"],
    description: "1"
  },
  {
    id: 2,
    title: "婚紗拍攝(後台)",
    start: "2020-09-11T14:00",
    classNames: ["backstage-setting"]
  },
  {
    id: 3,
    title: "自訂行程",
    start: "2020-09-11T16:00",
    classNames: ["customer-setting"]
  },
  {
    id: 4,
    title: "婚紗拍攝(後台)",
    start: "2020-09-16T08:00",
    classNames: ["backstage-setting"]
  },
  {
    id: 5,
    title: "婚紗拍攝(後台)",
    start: "2020-09-16T08:00",
    classNames: ["backstage-setting", "important-event"]
  },
  {
    id: 6,
    title: "婚紗拍攝(後台)",
    start: "2020-09-17T08:00",
    classNames: ["backstage-setting", "important-event"]
  },
  {
    id: 7,
    title: "婚紗拍攝(後台)",
    start: "2020-09-17T08:00",
    classNames: ["backstage-setting"]
  },
  {
    id: 8,
    title: "自訂行程",
    start: "2020-09-21T08:00",
    classNames: ["customer-setting"]
  },
  {
    id: 9,
    title: "自訂行程",
    start: "2020-09-22T08:00",
    classNames: ["customer-setting"]
  },
  {
    id: 10,
    title: "自訂行程",
    start: "2020-09-25T08:00",
    classNames: ["customer-setting"]
  }
];
var today = new Date();

// 
function addNewSchedule() {
  var subjectTitle = $("#schedule-subject");
  var datepickerEl = $("#schedule-datepicker");
  var descriptionEl = $("#schedule-description");
  var title = subjectTitle.val();
  var date = new Date(datepickerEl.val());
  var description = descriptionEl.val();
  var year = date.getFullYear();
  var month = date.getMonth() + 1;
  month = month < 10 ? "0" + String(month) : month;
  var day = date.getDate();
  day = day < 10 ? "0" + String(day) : day;
  var hours = date.getHours();
  hours = hours < 10 ? "0" + String(hours) : hours;
  var minutes = date.getMinutes();
  minutes = minutes < 10 ? "0" + String(minutes) : minutes;
  var dateCombine =
    year + "-" + month + "-" + day + "T" + hours + ":" + minutes;
  var timestamp = new Date().getTime();

  var dataObj = {
    id: timestamp,
    title: title,
    start: dateCombine,
    classNames: ["customer-setting"],
    description: description
  };

  calendar.addEvent(dataObj);

  $(".calendar-add-modal").removeClass("modal-in");

  subjectTitle.val("");
  datepickerEl.val("");
  descriptionEl.val("");
}

// 
function resizeCalendarRatio() {
  var currentWindowWidth = $(window).width();

  if (currentWindowWidth >= 768) {
    calendar.setOption("aspectRatio", 1);
  } else if (currentWindowWidth >= 414) {
    calendar.setOption("aspectRatio", 0.6);
  } else if (currentWindowWidth >= 375) {
    calendar.setOption("aspectRatio", 0.55);
  } else {
    calendar.setOption("aspectRatio", 0.5);
  }
}

// fullcalendar
var calendar = new FullCalendar.Calendar(calendarEl, {
  headerToolbar: {
    left: "title",
    center: "",
    right: "today prev,next"
  },
  buttonText: {
    today: "Today"
  },
  initialDate: "2020-09-12",
  navLinks: false, // can click day/week names to navigate views
  businessHours: false, // display business hours
  editable: true,
  selectable: true,
  aspectRatio: 0.55,
  dayMaxEvents: 1, // allow "more" link when too many events
  eventDisplay: "block",
  eventTimeFormat: {
    // like '14:30:00'
    hour: "2-digit",
    minute: "2-digit",
    meridiem: false,
    hour12: false
  },
  events: eventsData,
  eventClick(info) {
    // 
    var title = info.event.title;
    var description = info.event.extendedProps.description;
    var time = new Date(info.event._instance.range.start);
    var hours = time.getUTCHours();
    var minutes = time.getMinutes();
    var unit = "AM";

    if ($(info.jsEvent.path[0]).hasClass("delete-event")) {
      return;
    }

    if (hours > 12) {
      hours = hours - 12;
      unit = "PM";
    }

    if (minutes < 10) {
      minutes = "0" + String(minutes);
    }

    $(".calendar-info-modal").find(".modal-title").text(title);
    $(".calendar-info-modal").find(".modal-info").text(description);
    $(".calendar-info-modal").find(".hour").text(hours);
    $(".calendar-info-modal").find(".minutes").text(minutes);
    $(".calendar-info-modal").find(".unit").text(unit);
    $(".calendar-info-modal").addClass("modal-in");
  },
  eventDidMount(event) {
    var elClassNames = event.event.classNames;
    var el = event.el;
    var id = event.event.id;

    // 
    if (elClassNames.indexOf("customer-setting") !== -1) {
      $(el).append('<button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom">Tooltip on bottom</button>');
    }

    // 
    if (
      elClassNames.indexOf("important-event") !== -1 &&
      elClassNames.indexOf("backstage-setting") !== -1
    ) {
      $(el).addClass("active");
    }
  },
  viewDidMount(el) {
    // 
    $(el.el)
      .unbind()
      .on("click", function (e) {
        var target = $(e.target);
        var id = target.attr("data-id");

        if (target.hasClass("delete-event")) {
          var event = calendar.getEventById(id);
          event.remove();
        }
      });
  },
  windowResize(arg) {
    resizeCalendarRatio();
  }
});

calendar.render();
resizeCalendarRatio();

// 
$("#add-schedule-info").on("click", function () {
  addNewSchedule();
});

 $('[data-toggle="tooltip"]').tooltip();
 
})(jQuery);


