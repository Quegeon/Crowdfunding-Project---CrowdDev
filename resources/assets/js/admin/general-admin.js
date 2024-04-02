$('.btn-edit').on('click', function() {
    const dataId = $(this).data('id');

    $.ajax({
        url: '/management/admin/show/' + dataId,
        method: 'GET',
        success: function(res) {
            $('#content-edit').replaceWith(res.data);
            
            $('#editAdmin').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
    });
});