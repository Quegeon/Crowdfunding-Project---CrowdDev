
$('.btn-edit').on('click', function() {
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-edit').html(res.data);
            $('#editAdmin').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
});

$('.btn-delete').on('click', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        titleText: 'Delete Confirmation',
        text: 'Admin account will be deleted!',
    }).then((result) => {
        if (result['isConfirmed']) {
            window.location.href = $(this).data('href');
        }
    });
});

$('.btn-change-password').on('click', function() {
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-change-password').html(res.data);
            $('#changePasswordAdmin').modal('show');
        },
        error: function(err) {
            console.log(err);            
        }
    });
});