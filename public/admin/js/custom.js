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

$(document).on('click', '#deleteProfileImage', function () {
    const admin_id = $(this).data('admin-id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to delete your profile image?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: 'delete-admin-image',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    admin_id: admin_id
                },
                success: function (resp) {
                    if (resp.success) {
                        $('#profileImageBlock').remove();
                        Swal.fire("Deleted!", "Profile image deleted successfully.", "success")
                            .then(() => {
                                location.reload();
                            });
                    } else {
                        Swal.fire("Error!", "Failed to delete profile image.", "error");
                    }
                },
                error: function () {
                    Swal.fire("Error!", "An error occured while deleting the image.", "error");

                }
            });
        }
    });
});

$(document).on('click', '.updateSubadminStatus', function () {
    var subadminId = $(this).data('id');
    var $icon = $(this).find('i');

    $.ajax({
        url: 'update-subadmin-status',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: subadminId
        },
        success: function (response) {
            if (response.status == 1) {
                $icon.attr('class', 'fas fa-toggle-on text-success fa-lg');
            } else {
                $icon.attr('class', 'fas fa-toggle-off text-danger fa-lg');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error updating status:", error);
        }
    });
});
$(document).on('click', '.deleteSubadmin', function () {
    let subadminId = $(this).data('id');

    Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the subadmin.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel",

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete-subadmin',
                type: 'POST',
                data: {
                    _token: $('meta[name= "csrf-token"]').attr('content'),
                    id: subadminId
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire('Deleted!', response.message, 'success').then(() => {
                            $('#subamdin-row-' + subadminId).fadeOut();
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error!', 'Server error occured.', 'error');
                    }
                }

            });
        }
    });
});
