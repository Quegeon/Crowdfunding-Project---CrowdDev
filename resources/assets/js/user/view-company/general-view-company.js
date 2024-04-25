$('.datatable').DataTable({});

$('.btn-detail').on('click', function(){
    $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-detail').html(res.data);
            $('#detailCompany').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
});