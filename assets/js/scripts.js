$(document).ready(function() {
    $('form').submit(function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'text',
            data: {
                url: $('#url').val()
            },

            success (data) {
                $('.response').css({
                    'display': 'block',
                }).text(data);
            },
            error: function () {
                alert('Request error');
            },
        });
    });
});