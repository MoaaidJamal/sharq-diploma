$('.phase.circle').each(function () {
    let color = '#636363';
    if ($(this).hasClass('p-completed')) {
        color = '#1CD894';
    } else if ($(this).hasClass('p-in-progress')) {
        color = '#FFCE21';
    }
    $(this).circleProgress({
        startAngle: -Math.PI / 2,
        value: $(this).data('prog'),
        thickness: 10,
        fill: color,
        size: 90,
    }).on("circle-animation-progress", function (event, progress) {
        $(this)
            .find("div")
            .html();
    });
});

// range
$(document).ready(function () {
    $('.input-range').each(function () {
        var value = $(this).attr('data-slider-value');
        var separator = value.indexOf(',');
        if (separator !== -1) {
            value = value.split(',');
            value.forEach(function (item, i, arr) {
                arr[i] = parseFloat(item);
            });
        } else {
            value = parseFloat(value);
        }
        $(this).slider({
            formatter: function (value) {
                console.log(value);
                return '$' + value;
            },
            min: parseFloat($(this).attr('data-slider-min')),
            max: parseFloat($(this).attr('data-slider-max')),
            range: $(this).attr('data-slider-range'),
            value: value,
            tooltip_split: $(this).attr('data-slider-tooltip_split'),
            tooltip: $(this).attr('data-slider-tooltip')
        });
    });

});
