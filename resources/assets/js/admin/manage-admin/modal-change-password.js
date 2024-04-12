$(document).on("click", "#toggle_visibility", function() {
    const $this = $(this);
    const $currentPass = $('#current_password');
    const $icon = $('#icon-visibility');

    if ($this.attr('data-visibility') === 'hide') {
        $.ajax({
            url: '/management/admin/visibility/password/' + $this.data('id'),
            method: 'GET',
            success: function(res) {
                $currentPass.text(res.data);
                $icon.removeClass('fa-eye-slash').addClass('fa-eye');
                $this.attr('data-visibility', 'unhide');
            },
            error: function (err) {
                console.log(err);            
            }
        });

    } else {
        $currentPass.html('&#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022; &#x2022;');
        $icon.removeClass('fa-eye').addClass('fa-eye-slash');
        $this.attr('data-visibility', 'hide');
    }
});