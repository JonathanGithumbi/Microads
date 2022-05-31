<div class="w3-container">
    <div class=" w3-card-4 w3-margin w3-flat-silver w3-round-small w3-padding ">
        <div class="w3-bar w3-black">
            <button class="w3-bar-item w3-hover-red w3-round-small w3-button tablink w3-red" onclick="openTab(event,'user_sign_up')">Sign Up</button>
            <button class="w3-bar-item w3-hover-red w3-round-small w3-button tablink" onclick="openTab(event,'user_log_in')">Login</button>
        </div>
        <div class="w3-container tab" id="user_sign_up">
            <h4>User Sign Up Form</h4>

            <div id="user_sign_up_errors">

            </div>
            <form action="<?php echo base_url() ?>home/user_sign_up" method="post" id="user_sign_up_form">
                <label for="user_email_address">Email Address:</label>
                <input type="text" name="user_email_address" id="user_email_address" class="w3-input w3-round-small">
                <br>
                <label for="user_Password">Password:</label>
                <input type="password" name="user_password" id="user_password" class="w3-input w3-round-small">
                <br>
                <label for="confirm_user_password">Confirm Password:</label>
                <input type="password" name="confirm_user_password" id="confirm_user_password" class="w3-input w3-round-small">
                <br>
                <input type="submit" value="Sign Up" class="w3-input w3-button w3-round-small w3-black w3-hover-red">
            </form>
        </div>
        <div class="w3-container tab" id="user_log_in" style="display:none">
            <h4>User Log In Form</h4>

            <div id="user_log_in_errors">

            </div>
            <form action="<?php echo base_url() ?>home/user_log_in" method="post" id="user_log_in_form">
                <label for="user_email_address">Email Address:</label>
                <input type="text" name="user_log_in_email_address" id="user_log_in_email_address" class="w3-input w3-round-small">
                <br>
                <label for="user_Password">Password:</label>
                <input type="password" name="user_log_in_password" id="user_log_in_password" class="w3-input w3-round-small">
                <br>
               
                <input type="submit" value="Log In" class="w3-input w3-button w3-round-small w3-black w3-hover-red">
            </form>
        </div>
    </div>

</div>
</body>
<script>
    $("#user_sign_up_form").on('submit', function(e) {
        e.preventDefault();
        var data = $("#user_sign_up_form").serialize();
        $.ajax({
            url: '<?php echo base_url() ?>home/user_sign_up',
            method: 'post',
            data: data,
            dataType: 'json',
            success: function(data) {
                if (data.status == 'error') {
                    $("#user_sign_up_errors").html(data.message);
                } else if (data.status == 'success') {
                    $("#user_sign_up_errors").html(data.message);
                }
            },
            error: function(data, status, err) {
                alert("Error callback Says: " + err);
            }
        });
    });
    $("#user_log_in_form").on('submit', function(e){
        e.preventDefault();
        var data = $("#user_log_in_form").serialize();
        $.ajax({
                url: '<?php echo base_url();?>home/user_log_in',
                method: 'post',
                data: data,
                dataType: 'json',
                success: function(data){
                    if(data.status == 'error')
                    {
                        $("#user_log_in_errors").html(data.message);
                    }
                    else if(data.status == 'success')
                    {
                        window.location.assign('<?php echo base_url();?>adu/index');
                    }
                },
                error: function(data,status,err)
                {
                    alert("Error Callback Says :" + err);
                }
        });
    });

    function openTab(evt, TabName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("tab");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" w3-red", "");
        }
        document.getElementById(TabName).style.display = "block";
        evt.currentTarget.className += " w3-red";
    }
</script>

</html>