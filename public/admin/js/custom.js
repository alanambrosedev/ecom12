$(document).ready(function () {
    $("#current_password").keyup(function () {
        var current_password = $("#current_password").val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/admin/verify-password',
            data: { current_password: current_password },
            success: function (resp) {
                if (resp === "false") {
                    $("#verifyPwd").html("<font color='red'>Current Password is incorrect</font>");
                } else if (resp === "true") {
                    $("#verifyPwd").html("<font color='green'>Current Password is correct</font>");
                }
            },
            error: function (xhr, status, error) {
                $("#verifyPwd").html(
                    `<div class="alert alert-danger" role="alert">
                        An error occurred while verifying the password.<br>
                        <strong>Status:</strong> ${status}<br>
                        <strong>Error:</strong> ${error}
                    </div>`
                );
                console.error("AJAX Error:", xhr.responseText);
            }
        });
    });
});
