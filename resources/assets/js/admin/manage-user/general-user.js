$('.btn-edit').on('click', function() {
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-edit').html(res.data);
            $('#editUser').modal('show');
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
        text: 'User account will be deleted!',
    }).then((result) => {
        if (result['isConfirmed']) {
            window.location.href = $(this).data('href');
        }
    });
});