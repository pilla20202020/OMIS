var oTable;
try {
    jQuery(document).ready(function ($) {

        oTable = $('#employeeTable').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            bFilter: true,
            bSort: true,
            order: [
                [0, "asc"]
            ],
            ajax: {
                url: listUrl, // Change this URL to where your json data comes from
                type: 'post', // This is the default value, could also be POST, or anything you want.
                data: function (d) {
                    d._token = token;
                }
            },
            // language: {
            //     search: "_INPUT_",
            //     searchPlaceholder: "Search by Name"
            // },
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
            "columns": [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                "data": "first_name"
            },
            {
                "data": "last_name"
            },
            {
                "data": "mobile"
            },
            {
                "data": "email"
            },
            {
                "data": "address"
            },
            {
                "data": "department_name"
            },
            {
                "data": "designation_name"
            },
            {
                "data": "shift_type"
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
                "data": "action",
                orderable: false,
                searchable: false
            },

            ],
            // aoColumnDefs: [{ 'bSortable': true, 'aTargets': [0, 1, 2,3,4,5,6] }],
            // aoColumnDefs: [{ 'bSortable': false, 'aTargets': [7] }]
        });

        // $('#search_data').on('click', function(e) {
        //     oTable.draw();
        //     e.preventDefault();
        // });


        $('body').on('refreshTable', function (e) {
            oTable.reload();
            e.preventDefault();
        });

        /**Function for clear search Inputs */
        $('#btnclear').on('click', function (e) {
            $('#searchForm')[0].reset();
            oTable.draw();
        })

    });
} catch (e) {
    if (typeof console !== 'undefined') {
        console.log(e);
    }
}

$(document).ready(function () {

    $('#is_login').on('click', function () {
        if (this.value == 'YES')
            $('.isLogin').removeClass('d-none');
        else
            $('.isLogin').addClass('d-none');

    })
    //show modal for Create or Add new Feature 
    $(document).on('click', '#createModal', function () {
        $('#modalForm')[0].reset();
        $('#emp_id').val(null);
        $('#modal-add').modal('show');
        $('#is_login').removeAttr('disabled');

    })

    // get Data on Edit case.
    $(document).on('click', '.custom_edit', function () {
        $('#modalForm')[0].reset();
        let emp_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: editUrl,
            data: { emp_id: emp_id, _token: token },
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $('#modal-add').modal('show');
                    $.each(res.data, function (field_name, value) {
                        $("#" + field_name).val(value);
                    });
                    $('.isLogin').addClass('d-none');

                    $('#is_login').attr('disabled', 'disabled');
                    validator.resetForm();
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
    var validator = $("#modalForm").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: {
                required: true,
                email: true
            },
            mobile: "required",
            address: "required",
            dept_id: "required",
            designation_id: "required",
            shift_id: "required",
            is_login: "required",
            password: {
                required: function () {
                    return $('#is_login').val() == 'YES';
                }
            },
            password_confirmation: {
                required: function () {
                    return $('#is_login').val() == 'YES';
                }
            },
            role_id: {
                required: function () {
                    return $('#is_login').val() == 'YES';
                }
            },
        },
        messages: {
            first_name: "First Name is required!",
            last_name: "Last Name is required!",
            password: {
                required: "Password is required!",
            },
            password_confirmation: {
                required: "Confirm Password is required!",
            },
            mobile: "Mobile is required!",
            address: "Address is required!",
            dept_id: "Department is required!",
            designation_id: "Designation is required!",
            shift_id: "Shift is required!",

        },
        // onfocusout: function (element) {
        //     this.element(element);
        // },
        // submitHandler: function (form) {
        //     Submit();
        //     return false;
        // }
    });
    //End of Form Validation

    // JS function for Feature Update and Create new one
    function Submit() {
        let formData = $("#modalForm").serializeArray();
        let emp_id = $('#emp_id').val();
        let url = emp_id ? updateUrl : storeUrl;

        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $('#modal-add').modal('hide');
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

    $('#is_CIT').on('change',function(e){
        if($(this).is(":checked")){
            $('#CIT_Amount').css("visibility", "visible");
        }else{
            $('#CIT_Amount').css("visibility", "hidden");
            
        }
    })

    $('#is_SSF').on('change',function(e){
        if($(this).is(":checked")){
            $('#SSF_Amount').css("visibility", "visible");
        }else{
            $('#SSF_Amount').css("visibility", "hidden");
            
        }
    })

    $('#is_EPF').on('change',function(e){
        if($(this).is(":checked")){
            $('#EPF_Amount').css("visibility", "visible");
        }else{
            $('#EPF_Amount').css("visibility", "hidden");
            
        }
    })
})