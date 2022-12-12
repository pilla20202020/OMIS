var oTable;
try {
    jQuery(document).ready(function ($) {

        oTable = $('#userTable').DataTable({
            "ajax": {
                "url": requestUrl,
                "type": "post",
                "dataSrc": "data",
                "processing": true,
                "serverSide": true,
                "scrollX": true,
                "data": {
                    _token: token
                }
            },
            order: [
                [0, "asc"]
            ],
            "columns": [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                "data": "user_name"
            },
            {
                "data": "user_type"
            },
            {
                "data": "role_name",
            },

            {
                "data": "email"
            },
            {
                "data": "mobile"
            },
            {
                "data": "status"
            },
            {
                "data": "created_by"
            },
            {
                "data": "updated_by"
            },
            {
                "data": "created_at"
            },
            {
                "data": "updated_at"
            },
            {
                "data": "action"
            }
            ],
            dom: 'Bfrtip',
            lengthMenu: [
                [25, 50, 100, -1],
                ['25 rows', '50 rows', '100 rows', 'Show all']
            ],
            buttons: [
                'pageLength',
                // 'print',
                // 'excelHtml5',
                // 'pdfHtml5',
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis',

            ],
        });


        $('body').on('refreshTable', function (e) {
            oTable.reload();
            e.preventDefault();
        });





    });
} catch (e) {
    if (typeof console !== 'undefined') {
        console.log(e);
    }

}

$(document).ready(function () {
    // get Data on Edit case.
    $(document).on('click', '.custom_edit', function () {
        $('#modalForm')[0].reset();
        let user_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: editUrl,
            data: { user_id: user_id, _token: token },
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $.each(res.data, function (field_name, value) {
                        $("#" + field_name).val(value);
                    });
                    $('#modalUser').modal('show');
                }
            },
            error: function (errors) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    footer: ''
                })
            }
        });
    })

    //Form validation 
    $("#modalForm").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile: "required",
        },
        messages: {
            first_name: "First Name is required!",
            last_name: "Last Name is required!",

            mobile: "Mobile is required!",
        },
        onfocusout: function (element) {
            this.element(element);
        },
        submitHandler: function (form) {
            Submit();
            return false;
        }
    });
    //End of Form Validation

    // JS function for Feature Update and Create new one
    function Submit() {
        let formData = $("#modalForm").serializeArray();
        let user_id = $('#id').val();
        let url = user_id ? updateUrl : storeUrl;

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $('#modalUser').modal('hide');
                    Swal.fire({
                        position: 'top-end', icon: 'success', title: res.message, showConfirmButton: false, timer: 1500
                    })
                    oTable.draw();
                }
            },
            error: function (errors) {
                if (obj = errors.responseJSON.errors) {
                    $.each(obj, function (key, value) {
                        $(`#${key}-error`).html(value);
                        $(`#${key}-error`).css('display', 'block');
                    });
                }
                else if (errors.responseJSON.status == "error") {
                    $(`#${errors.responseJSON.field}-error`).html(errors.responseJSON.msg);
                    $(`#${errors.responseJSON.field}-error`).css('display', 'block');
                }
            }
        });
    }

    $(document).on('click', '.service_custom_delete', function (e) {
        e.preventDefault();
        var currentrow = $(this).parent().parent();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes ,Active/De-Active!'
        }).then((result) => {
            if (result.value) {
                var service_id = $(this).data('id').split('~');

                $.ajax({
                    "url": messages.change_service_status,
                    type: 'post',
                    datatype: "json",
                    async: "true",
                    data: {
                        service_id: service_id[0],
                        _token: messages.token
                    },
                    success: function (results) {
                        if (results.status == 'success') {
                            if ($("#chk_status" + service_id[1]).prop(
                                "checked") == true) {
                                $("#chk_status" + service_id[1]).prop(
                                    'checked', false);
                            } else {
                                $("#chk_status" + service_id[1]).prop(
                                    'checked', true);
                            }
                            oTable.draw();
                        } else {
                            if ($("#chk_status" + service_id[1]).prop(
                                "checked") == true) {
                                $("#chk_status" + service_id[1]).prop(
                                    'checked', true);
                            } else {
                                $("#chk_status" + service_id[1]).prop(
                                    'checked', false);
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                footer: ''
                            })
                        }

                    },
                });

            }
        })
    })

    /**Function for clear search Inputs */
    $('#btnclear').on('click', function (e) {
        $('#search_status').val('').trigger("change");
        $('#manageService')[0].reset();
        oTable.draw();
    })
    /*End of coding*/
})