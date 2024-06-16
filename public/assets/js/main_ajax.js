$(function () {
    var uRL = $('.demo').val();

    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal').on('hidden.bs.modal', function (e) {
        $(this).find('form')[0].reset();
    });

    $('.change-logo').click(function () {
        $('.change-com-img').click();
    });

    // delete data common function
    function destroy_data(name, url) {
        var el = name;
        var id = el.attr('data-id');
        var dltUrl = url + id;
        if (confirm('Are you Sure Want to Delete This')) {
            $.ajax({
                url: dltUrl,
                type: "DELETE",
                cache: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        el.parent().parent('tr').remove();
                    } else {
                        Toast.fire({
                            icon: 'danger',
                            title: dataResult
                        })
                    }
                }
            });
        }
    }

    function show_formAjax_error(data) {
        if (data.status == 422) {
            $('.error').remove();
            $.each(data.responseJSON.errors, function (i, error) {
                var el = $(document).find('[name="' + i + '"]');
                el.after($('<span class="error">' + error[0] + '</span>'));
            });
        }
    }

    // ========================================
    // script for Admin Logout
    // ========================================

    $('.admin-logout').click(function () {
        $.ajax({
            url: uRL + '/admin/logout',
            type: "GET",
            cache: false,
            success: function (dataResult) {
                if (dataResult == '1') {
                    setTimeout(function () {
                        window.location.href = uRL + '/admin';
                    }, 500);
                    Toast.fire({
                        icon: 'success',
                        title: 'Logged Out Succesfully.'
                    })
                }
            }
        });
    });

    // ========================================
    // script for Services module
    // ========================================
    $('#addService').validate({
        rules: {
            title: { required: true },
            price: { required: true },
            duration: { required: true },
            space: { required: true },
        },
        messages: {
            title: { required: "Please Enter Service Title" },
            price: { required: "Please Enter Service Price" },
            duartion: { required: "Please Enter Service Duration" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            formdata.append('gallery', $('input[name^=gallery]').prop('files'));
            $.ajax({
                url: uRL + '/admin/services',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/services'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateService').validate({
        rules: {
            title: { required: true },
            price: { required: true },
            duration: { required: true },
            status: { required: true },
        },
        messages: {
            title: { required: "Please Enter Service Title Name" },
            price: { required: "Please Enter Service Price Name" },
            duartion: { required: "Please Enter Service Duration Name" },
            status: { required: "Please Enter Status" },
        },

        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/services'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-service", function () {
        destroy_data($(this), 'services/')
    });

    $('#showService').submit(function (e) {
        e.preventDefault();
        var show = [];
        $('.service').each(function (i) {
            var id = $(this).attr('id');
            if ($('#' + id).prop('checked') == true) {
                show[i] = [
                    $(this).val(), 1
                ];
            } else {
                show[i] = [
                    $(this).val(), 0
                ];
            }
        })

        $.ajax({
            url: uRL + '/admin/services/homepage_services',
            type: 'POST',
            data: { show: show },
            success: function (dataResult) {
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Updated Succesfully.'
                    });
                    setTimeout(function () { window.location.reload(); }, 1000);
                }
            },
        });

    });

    // ========================================
    // script for Testimonial module
    // ========================================

    $('#addTestimonial').validate({
        rules: {
            user_name: { required: true },
            message: { required: true },
            rating: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/testimonials',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/testimonials'; }, 1000)
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateTestimonial').validate({
        rules: {
            user_name: { required: true },
            message: { required: true },
            rating: { required: true },
        },
        submitHandler: function (form) {
            var id = $('.id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/testimonials/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/testimonials'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-testimonial", function () {
        destroy_data($(this), 'testimonials/')
    });

    // ========================================
    // script for General Setting module
    // ========================================

    $('#updateGeneralSetting').validate({
        rules: {
            com_name: { required: true },
            com_email: { required: true },
            address: { required: true },
            phone: { required: true },
            description: { required: true },
            map: { required: true },
            discount: { required: true },
            currency: { required: true },
            f_address: { required: true },
        },
        messages: {
            com_name: { required: "Company Name is Required" },
            com_email: { required: "Company Email is Required" },
            address: { required: "Company Address is Required" },
            phone: { required: "Company Phone is Required" },
            description: { required: "Company Description is Required" },
            map: { required: "Company Map is Required" },
            discount: { required: "Company Booking Amount Discount is Required" },
            currency: { required: "Company Currency is Required" },
            f_address: { required: "Company Footer Address is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/general-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () {
                            // $('.loader-container').remove();
                            window.location.href = uRL + '/admin/general-settings';
                        }, 1000);
                    } else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.',
                        });
                    }
                },
                error: function (error) {
                    $('.loader-container').remove();
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Admin  module
    // ========================================

    $('#updateProfileSetting').validate({
        rules: {
            admin_name: { required: true },
            email: { required: true },
            username: { required: true },
        },
        messages: {
            admin_name: { required: "Please Enter Your Username" },
            email: { required: "Please Enter Email Address" },
            username: { required: "Please Enter Email Address" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/profile-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // $('#updateProfileSetting').validate({
    //     rules: {
    //         admin_name: { required: true },
    //         email: { required: true },
    //         username: { required: true },
    //     },
    //     messages: {
    //         admin_name: { required: "Please Enter Your Username" },
    //         email: { required: "Please Enter Email Address" },
    //         username: { required: "Please Enter Email Address" },
    //     },
    //     submitHandler: function (form) {
    //         var id = $('.url').val();
    //         var formdata = new FormData(form);
    //         $.ajax({
    //             url: uRL + '/admin/profile-settings/' + id,
    //             type: 'POST',
    //             data: formdata,
    //             processData: false,
    //             contentType: false,
    //             success: function (dataResult) {
    //                 if (dataResult == '1') {
    //                     Toast.fire({
    //                         icon: 'success',
    //                         title: 'Updated Succesfully.'
    //                     });
    //                     setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
    //                 }
    //             },
    //             error: function (error) {
    //                 show_formAjax_error(error);
    //             }
    //         });
    //     }
    // });

    // ========================================
    // script for Banner Setting module
    // ========================================

    $('#addBanner').validate({
        rules: {
            title: { required: true },
        },
        messages: {
            title: { required: "Title is Required" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/banner-slider',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/banner-slider'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateBanner').validate({
        rules: {
            title: { required: true },
            status: { required: true },
        },
        messages: {
            title: { required: "Title is Required" },
            status: { required: "Status is Required" },
        },
        submitHandler: function (form) {
            var id = $('.id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/banner-slider/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/banner-slider'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-banner", function () {
        destroy_data($(this), 'banner-slider/')
    });

    // ========================================
    // script for Social Links  module
    // ========================================

    $('#updateSocialSetting').validate({
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/social-settings',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/social-settings'; }, 1000);
                    } else if (dataResult == '0') {
                        Toast.fire({
                            icon: 'info',
                            title: 'Already Updated.'
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Change Password
    // ========================================

    $('#updatePassword').validate({
        rules: {
            password: { required: true },
            new: { required: true },
            new_confirm: { required: true, equalTo: '#password' },
        },
        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/change-password',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/profile-settings'; }, 1000);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: dataResult
                        });
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    // ========================================
    // script for Agent module
    // ========================================
    $('#addAgent').validate({
        rules: {
            name: { required: true },
            service: { required: true },
            description: { required: true },
            experience: { required: true },
        },
        messages: {
            name: { required: "Please Enter Agent Name" },
            service: { required: "Please Enter Agent Service Name" },
            description: { required: "Please Enter Agent Description Name" },
            experience: { required: "Please Enter Agent Experience Name" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/agents',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    // console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/agents'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateAgent').validate({
        rules: {
            name: { required: true },
            description: { required: true },
            experience: { required: true },
            status: { required: true },
        },
        messages: {
            name: { required: "Please Enter Agent Name" },
            description: { required: "Please Enter Agent Description" },
            experience: { required: "Please Enter Agent Experience" },
            status: { required: "Please Enter Status" },
        },
        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    console.log(dataResult);
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/agents'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-agent", function () {
        destroy_data($(this), 'agents/')
    });

    // ========================================
    // script for GalleryCategory module
    // ========================================

    $('#addGalleryCat').validate({
        rules: { title: { required: true }, },
        messages: { title: { required: "Please Enter Gallery Category Name" }, },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/gallery_cat',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.editGalleryCat', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'gallery_cat/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=title]').val(dataResult[0].title);
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');

            }
        });
    });

    $("#editGalleryCat").validate({
        rules: { title: { required: true }, },
        messages: { title: { required: "Please Enter Gallery Category Name" }, },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/gallery_cat' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-galleryCat", function () {
        destroy_data($(this), 'gallery_cat/')
    });

    // ========================================
    // script for Gallery Image module
    // ========================================
    $('#addGalleryImg').validate({
        rules: {
            title: { required: true },
            category: { required: true },
            description: { required: true },
        },
        messages: {
            title: { required: "Please Enter Gallery Image Name" },
            category: { required: "Please Enter Gallery Image Category" },
            description: { required: "Please Enter Gallery Image Description" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/gallery_img',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/gallery_img'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $("#updateGalleryImg").validate({
        rules: {
            title: { required: true },
            category: { required: true },
            description: { required: true },
            status: { required: true },
        },
        messages: {
            title: { required: "Please Enter Gallery Image Name" },
            category: { required: "Please Enter Gallery Image Category" },
            description: { required: "Please Enter Gallery Image Description" },
            status: { required: "Please Enter Gallery Image Status" },
        },
        submitHandler: function (form) {
            var id = $('.url').val();
            // $('form').append(loader);
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.',
                        });
                        setTimeout(function () {
                            //  $('.loader-container').remove();
                            window.location.href = uRL + '/admin/gallery_img';
                        }, 1000);
                    }
                },
                error: function (error) {
                    $('.loader-container').remove();
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-galleryImg", function () {
        destroy_data($(this), 'gallery_img/')
    });

    // ========================================
    // script for Time Slot module
    // ========================================

    $('#addTimeSlot').validate({
        rules: {
            from_time: { required: true },
            to_time: { required: true },
        },
        messages: {
            from_time: { required: "Please Enter Start Time" },
            to_time: { required: "Please Enter End Time" },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/time_slot',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-default').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on('click', '.editTimeSlot', function () {
        var id = $(this).attr('data-id');
        var dltUrl = 'time_slot/' + id + '/edit';
        $.ajax({
            url: dltUrl,
            type: "GET",
            cache: false,
            success: function (dataResult) {
                $('#modal-info input[name=id]').val(dataResult[0].id);
                $('#modal-info input[name=from_time]').val(dataResult[0].from_time);
                $('#modal-info input[name=to_time]').val(dataResult[0].to_time);
                $('#modal-info input[name=status]').val(dataResult[0].status);
                $("#modal-info select[name=status] option").each(function () {
                    if ($(this).val() == dataResult[0].status) {
                        $(this).attr('selected', true);
                    }
                });
                $('#modal-info .u-url').val($('#modal-info .u-url').val() + '/' + dataResult[0].id);
                $('#modal-info').modal('show');
            }
        });
    });

    $("#editTimeSlot").validate({
        rules: {
            from_time: { required: true },
            to_time: { required: true },
        },
        messages: {
            from_time: { required: "Please Enter Start Time" },
            to_time: { required: "Please Enter End Time" },
        },
        submitHandler: function (form) {
            var id = $('#modal-info input[name=id]').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/time_slot' + '/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        $('#modal-info').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.reload(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".deleteTime", function () {
        destroy_data($(this), 'time_slot/')
    });

    // ========================================
    // script for Page module
    // ========================================
    $('#addPage').validate({
        rules: { title: { required: true }, },
        messages: { title: { required: "Please Enter Page Title Name" }, },
        submitHandler: function (form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#EditPage').validate({
        rules: {
            page_title: { required: true },
        },
        messages: {
            page_title: { required: "Please Enter Page Title Name" },
        },

        submitHandler: function (form) {
            var id = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/pages'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-page", function () {
        destroy_data($(this), 'pages/')
    });

    $(document).on('click', '.show-in-header', function () {
        var id = $(this).attr('id');
        if ($('#' + id).is(':checked')) {
            var status = 1;
        } else {
            var status = 0;
        }
        id = id.replace('head', '');
        $.ajax({
            url: uRL + '/admin/page_showIn_header',
            type: 'POST',
            data: { id: id, status: status },
            success: function (dataResult) {
            }
        });
    })

    $(document).on('click', '.show-in-footer', function () {
        var id = $(this).attr('id');
        if ($('#' + id).is(':checked')) {
            var status = 1;
        } else {
            var status = 0;
        }
        id = id.replace('foot', '');
        $.ajax({
            url: uRL + '/admin/page_showIn_footer',
            type: 'POST',
            data: { id: id, status: status },
            success: function (dataResult) {
            }
        });
    })

    $(document).on('click', '.viewContact', function () {
        $('#modal-info').modal('show');
        var id = $(this).attr('data-id');
        $.ajax({
            url: uRL + '/admin/contact/' + id,
            type: 'POST',
            success: function (dataResult) {
                $('#modal-info .table').html(dataResult);
            },
        });
    });

    $('.add-service-row').click(function () {
        var row_id = $(this).attr('data-id');
        row_id++;
        $(this).attr('data-id', row_id);
        $.ajax({
            url: uRL + '/admin/appointment/get-service-row',
            type: 'POST',
            data: { id: row_id },
            success: function (dataResult) {
                console.log(dataResult);
                $('.service-list tbody').append(dataResult);
            },
        });
    })

    $(document).on('click', '.remove-service-row', function () {
        $(this).parent().parent().remove();
    });

    function grand_total() {
        var total = 0;
        $('.serviceTotal').each(function () {
            var amt = parseInt($(this).text());
            if ($.isNumeric(amt)) {
                total = total + amt;
            }
        })
        $('.grandTotal').html(total);
    }

    function service_total(id, price, qty) {
        $('#' + id).parent().siblings('td').children('.serviceTotal').html(price * qty);
        grand_total();
    }

    $(document).on('change', '.serviceSelect', function () {
        var id = $(this).attr('id');
        console.log('serviceSelect', id);
        var sid = $('#' + id + ' option:selected').val();
        var qty = $('#' + id).parent().siblings('td').children('.serviceQty').val();
        $.ajax({
            url: uRL + '/admin/appointment/get-service-price',
            type: 'POST',
            data: { sid: sid },
            success: function (price) {
                $('#' + id).parent().siblings('td').children('.servicePrice').val(price);
                service_total(id, price, qty);
            },
        });
    })

    $(document).on('keyup change', '.serviceQty', function () {
        var id = $(this).attr('id');
        console.log('serviceQty', id);
        var qty = $('#' + id).val();
        var price = $('#' + id).parent().siblings('td').children('.servicePrice').val();
        service_total(id, price, qty);
    })

    $('#addAppointment').validate({
        rules: {
            c_name: { required: true },
            c_phone: { required: true },
            date: { required: true },
            time: { required: true },
        },
        submitHandler: function (form) {
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/appointment',
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Appointment Added Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/appointment'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $('#updateAppointment').validate({
        rules: {
            date: { required: true },
            time: { required: true },
        },
        submitHandler: function (form) {
            var id = $('.app-id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/appointment/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Appointment Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/appointment'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-appointment", function () {
        destroy_data($(this), 'appointment/')
    });

    $(document).on('click', '.change-appointment-status', function () {
        var id = $(this).attr('data-id');

        $.ajax({
            url: uRL + '/admin/appointment/change_status',
            type: 'POST',
            data: { id: id },
            success: function (dataResult) {
                $('#changeAppointment-status .modal-body').html(dataResult);
                $('#changeAppointment-status').modal('show');
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    })

    $(document).on('click', '.updateAppointment-status', function () {
        var id = $('input[name=app_id]').val();
        var status = $('select[name=status] option:selected').val();
        $.ajax({
            url: uRL + '/admin/appointment/update_status',
            type: 'POST',
            data: { id: id, status: status },
            success: function (dataResult) {
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Status Updated Succesfully.'
                    });
                    setTimeout(function () {
                        $('#changeAppointment-status').modal('hide');
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    })

    $("#updateClient").validate({
        rules: {
            name: { required: true },
            email: { required: true },
            phone: { required: true },
            //password: { required: true }, 
        },
        submitHandler: function (form) {
            var id = $('.id').val();
            var formdata = new FormData(form);
            $.ajax({
                url: uRL + '/admin/client/' + id,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Succesfully.'
                        });
                        setTimeout(function () { window.location.href = uRL + '/admin/client'; }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    $(document).on("click", ".delete-client", function () {
        destroy_data($(this), 'client/')
    });

    $(document).on('click', '.client-status', function () {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        $.ajax({
            url: uRL + '/admin/client/change_status',
            type: 'POST',
            data: { id: id, status: status },
            success: function (dataResult) {
                if (dataResult == '1') {
                    Toast.fire({
                        icon: 'success',
                        title: 'Status Updated Succesfully.'
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                }
            },
            error: function (error) {
                show_formAjax_error(error);
            }
        });
    })

    // ========================================
    // script for Update Payment Method
    // ========================================
    $('#update_payment_method').validate({
        rules: {
            payment_name: { required: true },
            payment_status: { required: true },
        },
        message: {
            payment_name: { required: "Please Enter Payment Method Name" },
            payment_status: { required: "Please Enter Payment Method Status" },
        },
        submitHandler: function (form) {
            var url = $('.url').val();
            var formdata = new FormData(form);
            $.ajax({
                url: url,
                type: 'POST',
                data: formdata,
                processData: false,
                contentType: false,
                success: function (dataResult) {
                    if (dataResult == '1') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Updated Successfully.'
                        });
                        setTimeout(function () { window.location.href = $('.rdt-url').val(); }, 1000);
                    }
                },
                error: function (error) {
                    show_formAjax_error(error);
                }
            });
        }
    });

    //Payment Method Change Status
    $(document).on('click', '.paymentStatus', function () {
        var id = $(this).attr('data-id');
        var status = $(this).attr('data-status');
        console.log(status);
        $.ajax({
            url: uRL + '/admin/payment-method/status',
            type: 'POST',
            data: { payment_id: id, payment_status: status },
            success: function (dataResult) {
                console.log(dataResult);
                location.reload();
            }
        });
    });

});