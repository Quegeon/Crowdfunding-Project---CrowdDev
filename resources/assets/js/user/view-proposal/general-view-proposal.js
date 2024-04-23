$('.table').DataTable({});

$('.btn-fund').on('click', function() {
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-fund').html(res.data);
            $('#addFunding').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    })
});