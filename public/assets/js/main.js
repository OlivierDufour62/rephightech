//admin js

$(document).ready(function () {
    $('.dropdown').click(function () {
        $('.dropdowntoggle').toggle()
    });

    $(".hamb").click(function () {
        $(".menu").toggle();
    });

    $('.send').on('click', function () {
        $("#dialog").dialog();
    });

    $('.sendprovider').on('click', function() {
        let id = $(this).attr('id');
        $('#provider_device_repair_id').val(id);
    })

    $('#save').on('click', function (e) {
        e.preventDefault();
        let data = {};
        const id = $('.ajaxform').attr('employeeid');
        $('.ajaxform')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/editemployee/${id}`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('#editprovider').on('click', function (e) {
        e.preventDefault();
        let data = {};
        const id = $('.ajaxeditprovider').attr('providerid');
        $('.ajaxeditprovider')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/editprovider/${id}`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('#savecustomer').on('click', function (e) {
        e.preventDefault();
        let data = {};
        const id = $('.ajaxcustomer').attr('customerid');
        $('.ajaxcustomer')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/editcustomer/${id}`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('#addemployee').on('click', function (e) {
        e.preventDefault();
        let data = {};
        $('.ajaxaddemployee')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/addemployee`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('#addprovider').on('click', function (e) {
        e.preventDefault();
        let data = {};
        $('.ajaxaddprovider')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/addprovider`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('#addtache').on('click', function (e) {
        e.preventDefault();
        let data = {};
        let data2 = new FormData($('.ajaxaddtache')[0]);
        $("ajaxaddtache")
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/admin/addtache`,
            data: data2,
            contentType: false,
            processData: false,
            success: function (data) {
                $(".successsend").removeClass("d-none");
                setTimeout(function () {
                    $(".successsend").addClass("d-none");
                }, 1500);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    //search customer on admin part
    $('#search').on('click', function (e) {
        e.preventDefault()
        let email = $('.searchbar').val()
        $.ajax({
            type: 'GET',
            url: `/admin/searchcustomer`,
            data: { email: email },
            success: function (data) {
                $('#tache_client_lastname').val(data.lastname);
                $('#tache_client_firstname').val(data.firstname);
                $('#tache_client_email').val(data.email);
                $('#tache_client_phonenumber').val(data.phonenumber);
                if (data.genre == true) {
                    $('#tache_client_genre_0').attr("checked", "checked");
                } else {
                    $('#tache_client_genre_1').attr("checked", "checked");
                }
            }
        });
    });

    $('.customerswitches').on('change', function () {
        const id = $(this).attr('customerswitches');
        $('.customerswitches')
        $.ajax({
            url: `/admin/customerisactive/${id}`,
        }).done();
    });

    $('.employeeswitches').on('change', function () {
        const id = $(this).attr('employeeswitches');
        $('.employeeswitches')
        $.ajax({
            url: `/admin/employeeisactive/${id}`,
        }).done();
    });

    $('.repairswitches').on('change', function () {
        const id = $(this).attr('repairswitches');
        $('.repairswitches')
        $.ajax({
            url: `/admin/repairisactive/${id}`,
        }).done();
    });

    $('.providerswitches').on('change', function () {
        const id = $(this).attr('providerswitches');
        $('.provderswitches')
        $.ajax({
            url: `/admin/providerisactive/${id}`,
        }).done();
    });

    $('.addcomment').on('click', function (e) {
        e.preventDefault();
        let data = {};
        const id = $('.ajaxcomment').attr('repairid');
        $('.ajaxcomment')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        let comment = $('.resize').val();
        $.ajax({
            type: 'POST',
            url: `/admin/details/${id}`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
                $('.bg').append(comment) //ajout commentaire sans actualisation
            }
        });
    });

    //front js

    //search customer on public part
    $('#searchcustomer').on('click', function (e) {
        e.preventDefault()
        let email = $('.searchbarfront').val()
        $.ajax({
            type: 'GET',
            url: `/searchcustomer`,
            data: { email: email },
            success: function (data) {
                $('#tache_client_lastname').val(data.lastname);
                $('#tache_client_firstname').val(data.firstname);
                $('#tache_client_email').val(data.email);
                $('#tache_client_phonenumber').val(data.phonenumber);
                if (data.genre == true) {
                    $('#tache_client_genre_0').attr("checked", "checked");
                } else {
                    $('#tache_client_genre_1').attr("checked", "checked");
                }
            }
        });
    });

    $('#addtachefront').on('click', function (e) {
        e.preventDefault();
        let data = {};
        let data2 = new FormData($('.ajaxaddtachefront')[0]);
        $("ajaxaddtachefront")
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/addtache`,
            data: data2,
            contentType: false,
            processData: false,
            success: function (data) {
                console.log(data == true)
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('.addcommentfront').on('click', function (e) {
        e.preventDefault();
        let data = {};
        const id = $('.ajaxcommentfront').attr('repairid');
        $('.ajaxcommentfront')
            .serializeArray()
            .forEach((object) => {
                data[object.name] = object.value
            });
        $.ajax({
            type: 'POST',
            url: `/details/${id}`,
            data: data,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        });
    });

    $('.js-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
});