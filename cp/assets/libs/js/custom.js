$(document).ready(function()
{
    // ADMIN LOGIN
    $('#btn-do-login').on('click', function() {

        //var token = $("#token").val().trim();
        var username = $("#loginUsername").val().trim();
        var password = $("#loginPassword").val().trim();
        var dataString = 'username=' + username + '&password=' + password;

        console.log(dataString);

        var isValid = true;

        if (isValid) {

            $.ajax({
                type: "POST",
                url: "do.php?z=doLogin",
                data: dataString,
                cache: false,
                /*beforeSend: function(){ $("#submitLogin").val('Connecting...');},*/
                success: function (rtn) {
                    if (rtn == 1) {
                        //LOGGED IN
                        console.log('Successful');
                        window.location.href = "index.php";
                    }
                    else {
                        console.log(rtn);
                        // FAILED LOGIN
                        var er = 'Incorrect Username and Password.  Try Again!';
                        var ed = $('#inputErrorLogin');

                        $(ed).slideDown(150);
                        $(ed).html('<span style="color: red">'+ er +'</span>');
                    }
                }
            });
        }
    });

    // ADMIN CHANGE PASSWORD
    $('#btn-change-pass').on('click', function() {

        var currentPass = $('#currentPass').val().trim();
        var newPass1 = $('#newPass1').val().trim();
        var newPass2 = $('#newPass2').val().trim();
        var token = $("#token").val().trim();
        var userId = 1;

        var dataString = 'currentPass=' + currentPass + '&newPass1=' + newPass1 + '&newPass2=' + newPass2 + '&userId=' + userId + '&token=' + token;

        if (newPass1 == newPass2 && newPass1.length >= 6 && newPass2.length >= 6) {
            isValid = true;
        }
        else {
            $('#feedback').html('The new password you entered is invalid!');
            $('#feedback').css('color', 'red');
            isValid = false;
        }

        if (isValid) {
             $.ajax({
                 type: "POST",
                 url: "do.php?z=ChangeAdminPassword",
                 data: dataString,
                 cache: false,
                 success: function (rtn) {
                     console.log(rtn);

                     if (rtn == 0) {
                         $('#currentPass').val('');
                         $('#newPass1').val('');
                         $('#newPass2').val('');
                         $('#feedback').html('Your password has been changed!');
                         $('#feedback').css('color', 'green');

                         alert('Password changed successfully');
                     }
                     else {
                         alert('Password was not changed.  Check old password is correct and check new passwords match');
                     }
                 }
             });
        }
    });

    // populate the edit portfolio modal
    $(document).on('show.bs.modal', '#exampleModalCenter', function (e) {
        //$('#exampleModalCenter').on('show.bs.modal', function (e) {

        var clickedId = e.relatedTarget.dataset.portfolioid;
        console.log('Clicked Id: ' + clickedId);

        $.ajax({
            type: "POST",
            url: "do.php?z=GetPortfolioItemById",
            data: { portfolioid:clickedId },
            dataType: 'json',
            cache: false,
            success: function (rtn) {
                console.log(rtn);

                $('#edit-portfolio-custName').val(rtn.name);
                $('#edit-portfolio-caption').val(rtn.title);
                $('#edit-portfolio-body').val(rtn.body);
                $('#portfolio-id').val(rtn.id);


            }
        });

    });

    // save updated portfolio item
    $(document).on('click', '#edit-portfolio-save', function() {

        var newName = $('#edit-portfolio-custName').val().trim();
        var newCaption = $('#edit-portfolio-caption').val().trim();
        var newBody = $('#edit-portfolio-body').val().trim();
        var portfolioId = $('#portfolio-id').val().trim();

        $.ajax({
            type: "POST",
            url: "do.php?z=UpdatePortfolioItemById",
            data: { id:portfolioId, newName:newName, newCaption:newCaption, newBody:newBody },
            cache: false,
            success: function (rtn) {
                console.log(rtn);

                if (rtn == 1) {
                    $('#exampleModalCenter').modal('hide');
                    location.reload();
                }
                else {
                    alert('There was a fatal error.  Please try again');
                }
            }
        });
    });

    // delete portfolio item
    $(document).on('click', '#toggle-delete-portfolio', function() {
        var clickedId = $(this).data('portfolioid');
        var del = $(this); // THE CLICKED ITEM
        var ele = $(this).parent().parent(); // THE TR PARENT ROW ITEM
        $.ajax({
            type: "POST",
            url: "do.php?z=ToggleDeletedPortfolioItem", // CALL STORED PROC TO TOGGLE ISDELETED VALUE
            data: { id:clickedId }, // PASS THE ITEM ID
            cache: false,
            success: function (rtn) {

                // IF RETURN = 1, ITEM WAS UNDELETED
                if (rtn == 1) {
                    del.removeClass('btn-danger');
                    del.removeClass('btn-success');
                    del.addClass('btn-success');
                    ele.css('background-color', 'silver');
                }
                else {
                    // ELSE UNDELETED
                    del.removeClass('btn-danger');
                    del.removeClass('btn-success');
                    del.addClass('btn-danger');
                    ele.css('background-color', 'white');
                }
            }
        });
    });
});