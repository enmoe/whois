$(document).ready(function() {
    $('#whois-form').submit(function(event) {
        event.preventDefault();
        var domain = $('#domain').val().trim();
        $.ajax({
            type: 'POST',
            url: 'whois.php',
            data: { domain: domain },
            success: function(response) {
                $('#result-container').html('<pre>' + response + '</pre>');
                $('#result-container').addClass('center'); // 添加居中对齐的类
            },
            error: function() {
                $('#result-container').text('查询失败');
            }
        });
    });
});
