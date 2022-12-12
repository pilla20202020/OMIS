$(document).ready(function () {
    $(document).on('change', '#dept_id', function () {
        let dept_id = $(this).val();
        $.ajax({
            type: "POST",
            url: designationByDeptId,
            data: { dept_id: dept_id, _token: token },
            dataType: "json",
            success: (res) => {
                
                    $("#designation_id").find('option').remove().end().val('whatever');
                    $("#designation_id").append('<option value="">Select Designation</option>');
                    $(res).each(function () {
                        $("#designation_id").append("<option value=\"" + this.designation_id + "\">" + this.designation_name + "</option>");
                    });
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
});