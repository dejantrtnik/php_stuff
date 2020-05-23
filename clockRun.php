<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function()
{
    setInterval(timestamp, 1000);
});
function timestamp()
{
    $.ajax({
        url: 'clock.php',
        success: function(data)
        {
            $('#zapis_casa').html(data);
        },
    });
}
</script>

<html>
<body>
<div style="font-size: 50px; color: red" id="zapis_casa"> </div>
</body>
</html>
