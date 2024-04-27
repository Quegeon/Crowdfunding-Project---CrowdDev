$('.table').DataTable({});

$('.btn-edit').on('click', function() {
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-profile').html(res.data);
            $('#editProfile').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    }); 
});