$(document).ready(function () {

    var uRL = $('.base-url').val();

    function show_formAjax_error(data) {
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#serviceSelect').change(function () {
        var id = $(this).val();
        var max = $('#serviceSelect option:selected').attr('data-max');
        if (id != '') {
            $('#dateSelect').removeAttr('disabled');
            $('#personSelect').removeAttr('disabled');
            $('#personSelect').attr('max', max);
            $('#timeSelect').removeAttr('disabled');
            if ($('#timeSelect').val() != null) {
                $('#timeSelect').trigger('change');
            }
            if ($('#dateSelect').val() != null) {
                $('#dateSelect').trigger('change');
            }
            $('.agentsList').html('');
        }
    });

    $('#timeSelect').change(function () {
        var date = $('#dateSelect').val();
        var time_id = $(this).val();
        var service_id = $('#serviceSelect option:selected').val();
        $.ajax({
            url: uRL + '/get-clients',
            type: 'POST',
            data: { id: service_id, time_id: time_id, date: date },
            success: function (dataResult) {
                $('.agentsList').html(dataResult);
            },
        });
    })
    $('#dateSelect').change(function () {
        var time_id = $('#timeSelect').val();
        var date = $(this).val();
        var service_id = $('#serviceSelect option:selected').val();
        $.ajax({
            url: uRL + '/get-clients',
            type: 'POST',
            data: { id: service_id, time_id: time_id, date: date },
            success: function (dataResult) {
                $('.agentsList').html(dataResult);
            },
        });
    })

    function showClient_serviceCount() {
        if (localStorage.getItem("client_service") !== null) {
            var client_service = JSON.parse(localStorage.getItem("client_service"));
            var my_service_count = Object.keys(client_service['services']).length;
            $('.my-count').html(my_service_count);
            $('#timeSelect').val(client_service['time']);
        } else {
            $('.my-count').html(0);
        }
    }

    $(window).on('load', function () {
        showClient_serviceCount();
    })

    function grand_total() {
        var total = 0;
        $('.service-total').each(function () {
            var amt = parseInt($(this).text());
            if ($.isNumeric(amt)) {
                total = total + amt;
            }
        })
        $('.grand-total').html(total);
    }

    $(document).on('change', '.change-service-qty', function () {
        var id = $(this).attr('id');
        var val = $('#' + id).val();
        var service = $('#' + id).attr('data-id');
        var price = $(this).siblings('.price').val();
        $(this).parent().siblings('td').children('.service-total').html(val * price);
        grand_total();
    });




    $('#appointmentForm').submit(function (e) {
        e.preventDefault();
        var service = $('select[name=service] option:selected').val();
        var qty = $('input[name=person]').val();
        var date = $('input[name=date]').val();
        var time = $('select[name=time] option:selected').val();
        var agent = $('input[name=agent]:checked').val();
        var s_detail = {
            service: service,
            qty: qty,
            agent: agent,
        };
        var my_services = {};
        my_services['date'] = date;
        my_services['time'] = time;
        my_services['services'] = [];
        my_services['services'].push(s_detail);
        console.log(agent,time,date)
        if (!agent || !time || !date) {
            alert('Please choose agent. If all agent is already booked, please choose other date');
            return false;
        }
        if (localStorage.getItem("client_service") === null) {
            localStorage.setItem('client_service', JSON.stringify(my_services));
        } else {
            var client_service = JSON.parse(localStorage.getItem("client_service"));
            client_service['date'] = my_services['date'];
            client_service['time'] = my_services['time'];
            var c_services = client_service['services'];

            var exist = 0;
            for (var i = 0; i < Object.keys(c_services).length; i++) {
                if (client_service['services'][i]['service'] == service) {
                    exist = 1;
                    client_service['services'][i]['qty'] = qty;
                    client_service['services'][i]['agent'] = agent;
                }
            }
            if (exist == 0) {
                client_service['services'].push(s_detail);
            }
            localStorage.setItem('client_service', JSON.stringify(client_service));
        }
        $('.message').html('<div class="alert alert-success mt-3">Added Successfully to Your Services</div>');
        showClient_serviceCount();
        setTimeout(function () {
            $('.message').html('');
            $('#appointmentForm')[0].reset();
            $('.agentsList').html('');
            $('#singleModal').modal('hide');
        }, 1500);
    });

    $(document).on('click', '.remove-service', function () {
        var id = $(this).attr('data-id');
        var client_service = JSON.parse(localStorage.getItem("client_service"));
        for (var i = 0; i < Object.keys(client_service['services']).length; i++) {
            if (client_service['services'][i]['service'] == id) {
                client_service['services'].splice(i, 1);
            }
        }
        $(this).parent().parent().remove();
        $('.message').html('<div class="alert alert-danger">Service Deleted Successfully</div>');
        setTimeout(function () {
            $('.message').html('');
        }, 1000);
        if (Object.keys(client_service['services']).length > 0) {
            localStorage.setItem("client_service", JSON.stringify(client_service));
        } else {
            setTimeout(function () {
                $('#servicesModal').modal('hide');
            }, 500);
            localStorage.removeItem("client_service");
        }
        showClient_serviceCount();
        grand_total();
    });



    $('.newClient-services').click(function () {
        if (localStorage.getItem("client_service") !== null) {
            var client_service = JSON.parse(localStorage.getItem("client_service"));
            var services = client_service['services'];
            var date = client_service['date'];
            var time = client_service['time'];
            $.ajax({
                url: uRL + '/show-newClient-services',
                type: 'POST',
                data: { services: services, date: date, time_id: time },
                success: function (dataResult) {
                    $('#servicesModal .modal-body').html(dataResult);
                    $('#servicesModal input[name=date]').val(client_service['date']);
                    $('#servicesModal select[name=time]').val(client_service['time']);
                    $('#servicesModal .modal-footer button[type=submit]').attr('disabled', false);
                    $('#servicesModal').modal('show');
                },
            });
        } else {
            $('#servicesModal .modal-footer button[type=submit]').attr('disabled', true);
            $('#servicesModal .modal-body').html('<div class="alert alert-secondary mb-3">No Services Found</div>');
            $('#servicesModal').modal('show');
        }
    })

    $('.home-book-service').click(function () {
        var id = $(this).attr('data-id');
        $('#serviceSelect').val(id);
        $('#personSelect').removeAttr('disabled');
        $('#dateSelect').removeAttr('disabled');
        $('#timeSelect').removeAttr('disabled');
        $('#timeSelect').trigger('change');
    })

    $('.single-service-book').click(function () {
        var service = $(this).attr('data-id');
        var max = $(this).attr('data-max');
        $('#serviceSelect').val(service);
        $('#personSelect').attr('max', max);
        if ($('#timeSelect').val() != null) {
            $('#timeSelect').trigger('change');
        }
        $('#singleModal').modal('show');
    })



    // ========================================
    // script for User ContactUs module
    // ========================================

    $('#addContact').validate({
        rules: {
            client: { required: true },
            email: { required: true },
            phone: { required: true },
            description: { required: true }
        },
        messages: {
            client: { required: "Please Enter Your Client Name" },
            email: { required: "Please Enter Your Email address" },
            phone: { required: "Please Enter Your Phone" },
            description: { required: "Please Enter Your Message" }
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/contact',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success"> Your Message Submitted Successfully.</div>');
                        setTimeout(function () { window.location.href = uRL + '/contact'; }, 2000);
                    } else {
                        setTimeout(function () {
                            $('.loader').remove();
                            $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                        }, 3000);

                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for Confirm Appointment module
    // ========================================

    $('#client_form').validate({
        rules: {
            client: { required: true },
            email: { required: true },
            phone: { required: true },
            password: { required: true },
            con_pass: { required: true, equalTo: '#password' },
        },
        messages: {
            client: { required: "Please Enter Your Name" },
            email: { required: "Please Enter Your Email address" },
            phone: { required: "Please Enter Your Phone Number" },
        },
    });


    // ========================================
    // script for User Login module
    // ========================================

    $('#user-login').validate({
        rules: {
            email: { required: true },
            password: { required: true }
        },
        messages: {
            email: { required: "Email Address is required" },
            password: { required: "Password is required" }
        },
        submitHandler: function (form) {
            $('.message').empty();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/login',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Logged In Succesfully.</div>');
                        setTimeout(function () { window.location.href = document.referrer; }, 2000);
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for Change Password User module
    // ========================================
    $('#updatePassword').validate({
        rules: {
            password: { required: true },
            new_pass: { required: true },
            new_confirm: { required: true }
        },
        messages: {
            password: { required: "Password is required" },
            new_pass: { required: "New Password is required" },
            new_confirm: { required: "New Confirm Password is required" }
        },
        submitHandler: function (form) {
            $('.message').empty();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/change-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Password Changed Succesfully.</div>');
                        setTimeout(function () { window.location.href = uRL + '/'; }, 3000);
                    }
                    else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    // ========================================
    // script for User Forgot Password module
    // ========================================

    $('#client-forgotPassword').validate({
        rules: { email: { required: true } },
        messages: { email: { required: "Email Address is required" } },
        submitHandler: function (form) {
            $('.message').empty();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/forgot-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');

                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

    $('#client-resetPassword').validate({
        rules: {
            password: { required: true },
            confirm_password: { required: true }
        },
        messages: {
            password: { required: "password is required" },
            confirm_password: { required: "Confirm password is required" },
        },
        submitHandler: function (form) {
            $('.message').empty();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/update-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('.message').append('<div class="alert alert-success">Success.</div>');
                        setTimeout(function () { window.location.href = uRL + '/login'; }, 3000);
                    } else {
                        $('.message').append('<div class="alert alert-danger">' + dataResult + '</div>');
                    }
                },
                error: function (data) {
                    show_formAjax_error(data)
                }
            });
        }
    });

});