<body>
    <div class="w3-container">
        <div class="w3-card-4 w3-margin w3-padding w3-round-small w3-flat-midnight-blue w3-mobile" >
            <div id="adu_login_errors" class="w3-container w3-panel w3-round-small">

            </div>
            <form action="<?php echo base_url() ?>App/login" method="post" id="adu_login_form">
                
                <label for="adu_name">CDU Name:</label>
                <input type="text" name="adu_name" id="adu_name" class="w3-input w3-round-small">
                <br>
                <label for="adu_password">One Time Password:</label>
                <input type="password" name="adu_password" id="adu_password" class="w3-input w3-round-small">
                <br>
                <input type="submit" value="Login" class="w3-input w3-button w3-round-small w3-black w3-hover-red">
            </form>
        </div>

    </div>
</body>
<script>
    $("#adu_login_form").on('submit',function(e){
        e.preventDefault();
        var data  = $("#adu_login_form").serialize();
        $.ajax({
            url:'<?php echo base_url();?>App/login',
            data: data,
            type: 'post',
            dataType: 'json',
            success: function(data)
            {
                if(data.status == 'success')
                {
                    window.location.assign('<?php echo base_url();?>App/play_interface');
                }
                else if(data.status == 'error')
                {
                    $("#adu_login_errors").html(data.message);
                }
            },
            error: function(data, status,err)
            {
                alert("Error Callback Says: "+ err);
            }
        });
    });
</script>