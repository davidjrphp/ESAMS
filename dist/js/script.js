function start_loader() {
    $('body').append('<div id="preloader" class="page-preloader"><div class="loader-holder"><div></div><div></div><div></div><div></div>')
}

function end_loader() {
    $('.page-preloader').fadeOut('fast', function() {
        $('.page-preloader').remove();
    })
}
window.addEventListener('beforeunload', function(e){
    start_loader();
})
// function 
window.alert_toast = function($msg = 'TEST', $bg = 'success', $pos = '') {
    var Toast = Swal.mixin({
        toast: true,
        position: $pos || 'top',
        showConfirmButton: false,
        timer: 5000
    });
    Toast.fire({
        icon: $bg,
        title: $msg
    })
}

$(document).ready(function() {
    // Login form submission
    $('#login-frm').submit(function(e) {
        e.preventDefault();
        start_loader(); // Assuming this shows a loading indicator

        // Remove any existing error messages
        $('.err_msg').remove();

        $.ajax({
            url: '/ESAMS/classes/Login.php?f=login', 
            method: 'POST',
            data: $(this).serialize(), // Form data (username, password)
            error: function(err) {
                console.log('AJAX Error:', err); 
                end_loader();
            },
            success: function(resp) {
                if (resp) {
                    var response = JSON.parse(resp); // Parse JSON response
                    if (response.status === 'success') {
                        // Redirect based on the 'redirect' value from server
                        location.replace(response.redirect);
                    } else if (response.status === 'incorrect') {
                        // Display error message
                        var _frm = $('#login-frm');
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>";
                        _frm.prepend(_msg);
                        _frm.find('input').addClass('is-invalid');
                        $('[name="username"]').focus();
                    } else {
                        // Handle unexpected status (optional)
                        console.log('Unexpected response:', response);
                    }
                    end_loader(); 
                }
            }
        });
    });
});

$(document).ready(function() {
    $('#logout').click(function(e) {
        e.preventDefault();
        $.ajax({
            url: '/ESAMS/classes/Login.php?f=logout', // Path to your Login class
            method: 'GET', // Matches your switch statement using $_GET['f']
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    window.location.replace(response.redirect); // Redirect to /ESAMS/Login/index.php
                } else {
                    alert('Logout failed. Please try again.');
                }
            },
            error: function(err) {
                console.log('Logout Error:', err);
                alert('An error occurred during logout.');
            }
        });
    });
});

        //Establishment Login
    $('#flogin-frm').submit(function(e) {
        e.preventDefault()
        start_loader()
        if ($('.err_msg').length > 0)
            $('.err_msg').remove()
        $.ajax({
            url:'../../classes/Login.php?f=flogin',
            method: 'POST',
            data: $(this).serialize(),
            error: err => {
                console.log(err)

            },
            success: function(resp) {
                if (resp) {
                    resp = JSON.parse(resp)
                    if (resp.status == 'success') {
                        location.replace(_base_url_ + 'faculty');
                    } else if (resp.status == 'incorrect') {
                        var _frm = $('#flogin-frm')
                        var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>"
                        _frm.prepend(_msg)
                        _frm.find('input').addClass('is-invalid')
                        $('[name="username"]').focus()
                    }
                    end_loader()
                }
            }
        })
    })

    //user login
    $('#slogin-frm').submit(function(e) {
            e.preventDefault()
            start_loader()
            if ($('.err_msg').length > 0)
                $('.err_msg').remove()
            $.ajax({
                url:'../../classes/Login.php?f=slogin',
                method: 'POST',
                data: $(this).serialize(),
                error: err => {
                    console.log(err)

                },
                success: function(resp) {
                    if (resp) {
                        resp = JSON.parse(resp)
                        if (resp.status == 'success') {
                            location.replace(_base_url_ + 'student');
                        } else if (resp.status == 'incorrect') {
                            var _frm = $('#slogin-frm')
                            var _msg = "<div class='alert alert-danger text-white err_msg'><i class='fa fa-exclamation-triangle'></i> Incorrect username or password</div>"
                            _frm.prepend(_msg)
                            _frm.find('input').addClass('is-invalid')
                            $('[name="username"]').focus()
                        }
                        end_loader()
                    }
                }
            })
        })
        // System Info
    $('#system-frm').submit(function(e) {
        e.preventDefault()
        start_loader()
        if ($('.err_msg').length > 0)
            $('.err_msg').remove()
        $.ajax({
            url:'../classes/SystemSettings.php?f=update_settings',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            success: function(resp) {
                if (resp.status == 'success') {
                    // alert_toast("Data successfully saved",'success')
                    location.reload()
                } else if (resp.status == 'failed' && !!resp.msg) {
                    $('#msg').html('<div class="alert alert-danger err_msg">' + resp.msg + '</div>')
                    $("html, body").animate({ scrollTop: 0 }, "fast");
                } else {
                    $('#msg').html('<div class="alert alert-danger err_msg">An Error occured</div>')
                }
                end_loader()
            }
        })
    })