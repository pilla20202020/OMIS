var oTable;
try {
    jQuery(document).ready(function ($) {

        oTable = $('#companyTable').DataTable({
            processing: true,
            serverSide: true,
            // scrollY: '52vh',
            // scrollX: true,
            pageLength: 25,
            bFilter: true,
            bSort: true,
            order: [
                [0, "asc"]
            ],
            ajax: {
                url: companyDataUrl, // Change this URL to where your json data comes from
                type: 'post', // This is the default value, could also be POST, or anything you want.
                data: function (d) {
                    d._token = token;
                },
                "error": function () { // error handling
                    $(".companyTable-error").html("");
                    $("#companyTable").append(
                        '<tbody class="companyTable-error"><tr><th colspan="3">' +
                        'data not fount' + '</th></tr></tbody>');
                    $("#companyTable_processing").css("display", "none");
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
                "data": "company_name"
            },
            {
                "data": "owner_name"
            },
            {
                "data": "company_email"
            },
            {
                "data": "company_phone"
            },
            {
                "data": "company_mobile"
            },
            {
                "data": "company_address"
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

    //show modal for Create or Add new Company 
    $(document).on('click', '#createModel', function () {
        validator.resetForm();
        $('#modalForm')[0].reset();
        $('#company_id').val(null);
        $('#modal-add').modal('show');

    })

    // get Data on Edit case.
    $(document).on('click', '.custom_edit', function () {
        validator.resetForm();
        $('#editModalForm')[0].reset();
        let company_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: editUrl,
            data: { company_id: company_id, _token: token },
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $.each(res.data.company, function (field_name, value) {
                        $(`#${field_name}2`).val(value);
                    });

                    $.each(res.data.companyFeature, function (field_name, value) {
                        $(`#feature_${value}`).prop('checked', true);
                    });
                    $('#modal-edit').modal('show');
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

    //Edit Form validation 
     $("#editModalForm").validate({
        rules: {
            company_name: "required",
            company_email: "required",
        },
        messages: {
            company_name: "Company Name is required!",
            company_email: "Company Email is required!",
        },
        onfocusout: function (element) {
            this.element(element);
        },
        submitHandler: function (form) {
            editSubmit();
            return false;
        }
    });
    //End of Form Validation

    // JS function for Feature Update and Create new one
    function editSubmit() {
        let formData = $("#editModalForm").serializeArray();
        $.ajax({
            type: "POST",
            url: updateUrl,
            data: formData,
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $('#modal-edit').modal('hide');
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

    //Form validation 
    let validator = $("#modalForm").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            email: "required",
            mobile: "required",
            company_name: "required",
            company_email: "required",
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }
        },
        messages: {
            first_name: "First Name is required!",
            last_name: "Last Name is required!",
            email: "Email is required!",
            mobile: "Mobile Number is required!",
            password: {
                required: "Password is required!",
                minlength: "Enter at least 8 characters length",
            },
            password_confirmation: {
                required: "Confirmed Password is required!",
                equalTo: "Password does not Matched!"
            },
            company_name: "Company Name is required!",
            company_email: "Company Email is required!",
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
        let company_id = $('#company_id').val();
        let url = company_id ? updateUrl : storeUrl;

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
})
