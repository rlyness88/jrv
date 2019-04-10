$(function() {
    "use strict";

    var tkn = $("#token").val().trim();

    $(document).ready(function() {
        $('#calendar1').fullCalendar({
            header: {
                left: 'prev,next today',
                right: 'title'
            },
            /*defaultDate: '2018-03-12',*/
            navLinks: false,
            editable: false,
            droppable: true, // this allows things to be dropped onto the calendar
            data: { token:$("#token").val().trim() },
            drop: function() {
                // is the "remove after drop" checkbox checked?
                if ($('#drop-remove').is(':checked')) {
                    // if so, remove the element from the "Draggable Events" list
                    $(this).remove();
                }
            },
            eventLimit: false,
            eventSources: [
                {
                    url: 'do.php?z=GetCalendarItems',
                    type: 'POST',
                    data: {
                        token: tkn
                    },
                    error: function() {
                        alert('there was an error while fetching events!');
                    },
                    color: '#2f8aca'/*,   // a non-ajax option
                    textColor: 'black' // a non-ajax option*/
                }
            ]
        });
    });

    $(document).ready(function() {
        /* initialize the external events
        -----------------------------------------------------------------*/

        $('.fc-event').each(function() {

            // store data so the calendar knows to render an event upon drop
            $(this).data('event', {
                title: $.trim($(this).text()), // use the element's text as the event title
                stick: true // maintain when user navigates (see docs on the renderEvent method)
            });

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true, // will cause the event to go back to its
                revertDuration: 0 //  original position after the drag
            });
        });
    });

    $(document).ready(function() {

        var calendar = $('#calendar1').fullCalendar('getCalendar');

        calendar.on('drop', function(date, jsEvent, ui, resourceId) {
            /*console.log(date);
            console.log(jsEvent);
            console.log(ui);
            console.log(resourceId);
            console.log($(this));*/

            var ele = $(this);

            var month = date._d.getMonth()+1;
            var day = date._d.getDate();

            var output = date._d.getFullYear() + '-' +
                ((''+month).length<2 ? '0' : '') + month + '-' +
                ((''+day).length<2 ? '0' : '') + day;

            //console.log(output);
            var time = ele[0].textContent;

            $.ajax({
                type: "POST",
                url: "do.php?z=AdminAddNewCalendarItem",
                data: { date:output, time:time },
                cache: false,
                success: function(rtn)
                {
                    console.log(rtn);
                }
            });
        });
    });
 });