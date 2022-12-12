try {
    var oTable;
    jQuery(document).ready(function ($) {

        oTable = $('#dataTable').DataTable({
            processing: false,
            serverSide: false,
            // scrollY: '52vh',
            // scrollX: true,
            pageLength: 25,
            bFilter: true,
            bSort: true,
            order: [
                [0, "asc"]
            ],
            ajax: {
                url: requestUrl, // Change this URL to where your json data comes from
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
                "data": "name"
            },
            {
                "data": "showing_name"
            },
            {
                "data": "guard_name"
            },
            {
                "data": "group_name"
            },
            {
                "data": "feature_name"
            },
            {
                "data": "description"
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

    $(document).on('click', '#addPermission', function () {
        $('#modelForm')[0].reset();
        $('#modal-add').modal('show');
    })
    
    //Form validation 
    $("#modelForm").validate({
        rules: {
            name: "required",
            showing_name: "required",
            guard_name: "required",
            group_name: "required",
            feature_id: "required",
            is_default: "required",
            //   email: {
            //     required: true,
            //     email: true
            //   }
        },
        messages: {
            name: "Permission Name is required!",
            showing_name: "Showing Permission Name is required!",
            guard_name: "Guard Name required!",
            group_name: "Group Name is required!",
            feature_id: "Feature Name is required!",
            is_default: "Is default is required!",
            //   email: {
            //     required: "We need your email address to contact you",
            //     email: "Your email address must be in the format of name@domain.com"
            //   }
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

    function Submit() {
        var formData = $("#modelForm").serializeArray();
        console.log(formData);
        $.ajax({
            type: "POST",
            url: storeUrl,
            data: formData,
            dataType: "json",
            success: (res) => {
                $('#modal-add').modal('hide');
                oTable.draw();
                // const { action, msg, status } = data;
                // Swal.fire({ title: msg, icon: status, showConfirmButton: false, timer: 1500 });
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

    //Start of function by ajax get the particular route data on click of Edit Icon
    $(document).on('click', '.custom_edit', function () {
        $('#modelForm')[0].reset();
        let permission_id = $(this).data('permission_id');
        $.ajax({
            "url": getEditUrl, // json datasource
            type: 'post',
            datatype: "json",
            async: "true",
            data: { permission_id: permission_id, _token: token },
            success: function (res) {
                if (res.status) {
                    $.each(res.route, function (field_name, value) {
                        $("#" + field_name).val(value);
                    });
                    $('#modal-add').modal('show');
                }
            },
            complete: function (data) {
                // $(".docLoader").hide();
            }
        });
    })
})