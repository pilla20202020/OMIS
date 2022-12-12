var oTable;
try {
    jQuery(document).ready(function ($) {

        oTable = $('#branchTable').DataTable({
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
                    d.company_id = $('select[name=company_id]').val();
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
                "data": "branch_name"
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

        $('#btnsearch').on('click', function(e) {
            oTable.draw();
            e.preventDefault();
        });


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
    $(document).on('click','#createModal',function(){
        $('#modalForm')[0].reset();
        $('#branch_id').val(null);
        $('#modal-add').modal('show');

    })

    // get Data on Edit case.
    $(document).on('click', '.custom_edit', function () {
        $('#modalForm')[0].reset();
        let branch_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: editUrl,
            data: { branch_id: branch_id, _token: token },
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
    })

    //Form validation 
    $("#modalForm").validate({
        rules: {
            branch_name: "required",
        },
        messages: {
            branch_name: "Branch Name is required!",
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
        let branch_id = $('#branch_id').val();
        let url = branch_id ? updateUrl : storeUrl;

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
                    // console.log(obj);
                    $.each(obj, function (key, value) {
                        $(`#${key}-error`).html(value);
                        $(`#${key}-error`).css('display', 'block');
                    });
                }
                else if (errors.responseJSON.status == "error") {
                    $(`#${errors.responseJSON.field}-error`).html(errors.responseJSON.msg);
                    $(`#${errors.responseJSON.field}-error`).css('display', 'block');
                }

                // if( reject.status === 422 ) {
                //     var errors = $.parseJSON(reject.responseText);
                //     console.log(errors);
                //     $.each(errors, function (key, val) {
                //         $("#" + key + "_error").text(val[0]);
                //     });
                // }
            }
        });
    }
})