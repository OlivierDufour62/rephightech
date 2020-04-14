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
});