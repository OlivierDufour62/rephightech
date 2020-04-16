$(document).ready(function () {

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
            async: true,
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
            async: true,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        })
    })

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
            async: true,
            success: function (data) {
                if (data === true) {
                    $(".successsend").removeClass("d-none");
                    setTimeout(function () {
                        $(".successsend").addClass("d-none");
                    }, 1500);
                }
            }
        })
    })

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
                }else{
                    $('#tache_client_genre_1').attr("checked", "checked");
                }
            }
        })
    })
});