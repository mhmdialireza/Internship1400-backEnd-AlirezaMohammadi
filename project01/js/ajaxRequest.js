$(document).ready(function() {
    $("button").click(function() {
        $.ajax({
            data: { polynomial: $('#polynomial').val() },
            url: "./ajax/ajaxHandler.php",
            method: 'get',
            success: function(result) {
                $("#answer").html(result);
            }
        });
    });
});