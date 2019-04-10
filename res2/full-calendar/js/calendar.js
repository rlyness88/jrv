$(function() {
    "use strict";

    $(document).ready(function() {

        var tkn = $("#token").val().trim();

        $('#calendar').fullCalendar({
            columnHeader: true,
            contentHeight: 500,
            header: {
                left: 'prev,next today',
                right: 'title'
            },
            /*defaultDate: '2018-03-12',*/
            navLinks: false,
            editable: false,
            eventLimit: false,
            cache: false,
            eventSources: [
                {
                    url: 'do.php?z=GetCalendarItems',
                    type: 'POST',
                    data: {
                        token: tkn
                    },
                    error: function(rtn) {
                        //console.log(rtn);
                        alert('there was an error while fetching events!');
                    },
                    color: '#2f8aca '/*,   // a non-ajax option
                    textColor: 'black' // a non-ajax option*/
                }
            ]
        });

        var calendar = $('#calendar').fullCalendar('getCalendar');

        calendar.on('eventClick', function(calEvent, jsEvent, view) {
            /*console.log(calEvent);*/

            $('#booking-id').val(calEvent.id);

            $.ajax({
                type: "POST",
                url: "do.php?z=CheckBookingAvailability",
                data: { id:calEvent.id },
                dataType: 'json',
                cache: false,
                success: function (rtn) {
                    console.log(rtn);

                    $('#booking-date').val(rtn.isoDate);
                    $('#bookingTitle').text(rtn.start);
                    $('#booking-time').val(calEvent.title);

                    $('#bookingModal').modal('show');
                }
            });
        });

        $(document).on('click', '#make-booking-save', function() {

            var fullName = $('#booking-custName').val().trim();
            var phoneNumber = $('#booking-number').val().trim();
            var emailAddress = $('#booking-email').val().trim();
            var prefTime = $('#booking-time').val().trim();
            var bookingDate = $('#booking-date').val().trim();
            var id = $('#booking-id').val().trim();

            var ele = $(this);

            $.ajax({
                type: "POST",
                url: "do.php?z=MakeBooking",
                data: { id:id, name:fullName, number:phoneNumber, email:emailAddress, time:prefTime, date:bookingDate },
                cache: false,
                success: function (rtn) {
                    console.log(rtn);
                    if (rtn == 1) {
                        $('#booking-custName').val('');
                        $('#booking-number').val('');
                        $('#booking-email').val('');
                        $('#booking-time').val('');
                        $('#booking-id').val('');

                        alert('Thank you for making a booking.  I will contact you shortly to confirm');
                        $('#calendar').fullCalendar('removeEvents', id);
                        $('#bookingModal').modal('hide');
                    }
                    else {
                        alert('There was an error making your booking.  If the problem persists, please use the contact form');
                    }
                }
            });
        })
    });
 });