try {
    var oTable;
    jQuery(document).ready(function ($) {

        oTable = $('#companyTable').DataTable({
            processing: false,
            serverSide: false,
            // scrollY: '52vh',
            // scrollX: true,
            pageLength: 25,
            bFilter: true,
            bSort: true,
            order: [
                [10, "desc"]
            ],
            ajax: {
                url: routeDataUrl, // Change this URL to where your json data comes from
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
                "data": "route_name"
            },
            {
                "data": "show_route_name"
            },
            {
                "data": "route_path"
            },
            {
                "data": "method_name"
            },
            {
                "data": "method_type"
            },
            {
                "data": "controller_name"
            },
            {
                "data": "group_name"
            },
            {
                "data": "feature_name"
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
    //Form validation 
    $("#routeForm").validate({
        rules: {
            route_name: "required",
            show_route_name: "required",
            route_path: "required",
            controller_name: "required",
            group_name: "required",
            method_name: "required",
            //   email: {
            //     required: true,
            //     email: true
            //   }
        },
        messages: {
            route_name: "Route name is required!",
            show_route_name: "Showing Route Name is required!",
            route_path: "Route path is required!",
            controller_name: "Controller Name is required!",
            group_name: "Group Name is required!",
            method_name: "Method Name is required!",
            //   email: {
            //     required: "We need your email address to contact you",
            //     email: "Your email address must be in the format of name@domain.com"
            //   }
        }
    });
    //End of Form Validation

    //Start of function by ajax get the particular route data on click of Edit Icon
    $(document).on('click', '.custom_edit', function () {
        let route_id = $(this).data('route_id');
        $.ajax({
            "url": getEditUrl, // json datasource
            type: 'post',
            datatype: "json",
            async: "true",
            data: { route_id: route_id, _token: token },
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