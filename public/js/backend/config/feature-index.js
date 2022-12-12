var oTable;
try {
    jQuery(document).ready(function ($) {

        oTable = $('#featureTable').DataTable({
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
                url: requestUrl, // Change this URL to where your json data comes from
                type: 'post', // This is the default value, could also be POST, or anything you want.
                data: function (d) {
                    d._token = token;
                },
                "error": function () { // error handling
                    $(".featureTable-error").html("");
                    $("#featureTable").append(
                        '<tbody class="featureTable-error"><tr><th colspan="3">' +
                        'data not fount' + '</th></tr></tbody>');
                    $("#featureTable_processing").css("display", "none");
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

    //show modal for Create or Add new Feature 
    $(document).on('click','#createFeature',function(){
        $('#modelForm')[0].reset();
        $('#feature_id').val(null);
        $('#modal-add').modal('show');

    })

    // get Data on Edit case.
    $(document).on('click', '.custom_edit', function () {
        $('#modelForm')[0].reset();
        let feature_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: editUrl,
            data: { feature_id: feature_id, _token: token },
            dataType: "json",
            success: (res) => {
                if (res.status) {
                    $.each(res.data, function (field_name, value) {
                        $("#" + field_name).val(value);
                    });
                    $('#modal-add').modal('show');
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
        $('#modal-add').modal('show');
    })

    //Form validation 
    $("#modelForm").validate({
        rules: {
            feature_name: "required",
        },
        messages: {
            feature_name: "Feature Name is required!",

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
        let formData = $("#modelForm").serializeArray();
        let feature_id = $('#feature_id').val();
        let url = feature_id ? updateUrl : storeUrl;

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
