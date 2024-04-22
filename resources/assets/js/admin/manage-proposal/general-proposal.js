$('.table').DataTable({});

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

$('.btn-delete').on('click', function(e) {
    e.preventDefault();
    Swal.fire({
        icon: 'warning',
        titleText: 'Delete Confirmation',
        text: 'Proposal Data will be deleted!',
    }).then((result) => {
        if (result['isConfirmed']) {
            window.location.href = $(this).data('href');
        }
    });
});

$('.btn-detail').on('click', function() {
    $.ajax({
         url: $(this).data('href'),
         method: 'GET',
         success: function(res) {
             $('#content-detail').html(res.data)
             $('#detailProposal').modal('show');
         },
         error: function(err) {
             console.log(err);
         }
    });
 });

$('.btn-select').on('click', function() {
    $.ajax({
         url: $(this).data('href'),
         method: 'GET',
         success: function(res) {
             $('#content-selection').html(res.data)
             $('#selectCompany').modal('show');
         },
         error: function(err) {
             console.log(err);
         }
    });
 });