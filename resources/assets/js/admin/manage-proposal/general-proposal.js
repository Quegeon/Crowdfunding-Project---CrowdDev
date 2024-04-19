$('.btn-edit').on('click', function() {
   $.ajax({
        url: $(this).data('href'),
        method: 'GET',
        success: function(res) {
            $('#content-edit').html(res.data)
            $('#editProposal').modal('show');
        },
        error: function(err) {
            console.log(err);
        }
   });
});