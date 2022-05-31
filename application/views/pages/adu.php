<div class="w3-container">
    <!--ADD ADU CODE-->
    <div class="w3-flat-silver w3-container w3-margin w3-small-round w3-padding" id="adu">
        <button onclick="document.getElementById('add_adu_modal').style.display='block'" class="w3-button w3-black w3-hover-red w3-round-small">Add ADU <span class="fas fa-plus-circle"></span></button>
    </div>
    <!--ADD ADU MODAL CODE-->
    <div class="w3-modal " id="add_adu_modal">
        <div class="w3-modal-content w3-flat-silver">
            <div class="w3-container w3-padding w3-card-4 w3-round-small">
                <h4 class="w3-large-xxx w3-panel w3-flat-midnight-blue w3-round-small" style="width: 14%">ADD ADU</h4>
                <span class="w3-button w3-margin w3-small w3-round-small w3-black w3-hover-red w3-display-topright" onclick="document.getElementById('add_adu_modal').style.display='none'">&times;</span>
                <br>
                <br>
                <div id="add_adu_errors" class="w3-container">

                </div>
                <div class="w3-container">
                    <form action="" method="post" id="add_adu_form">
                        <input type="hidden" name="adu_owner" value="<?php echo $this->session->user_id; ?>">
                        <label for="adu_name">Name of ADU</label>
                        <input type="text" name="adu_name" id="adu_name" class="w3-input w3-small-round">
                        <br>
                        <label for="adu_password">Password: (One-Time Login Password)</label>
                        <input type="password" name="adu_password" id="adu_password" class="w3-input w3-small-round">
                        <br>
                        <label for="adu_confirm_password">Confirm Password</label>
                        <input type="password" name="adu_confirm_password" id="adu_confirm_password" class="w3-input w3-small-round">
                        <br>
                        <input type="submit" value="Add" class="w3-button w3-black w3-hover-red w3-round-small">
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="w3-container-w3-flat-silver w3-round-small">
        <div class="w3-container w3-flat-silver w3-padding">
            <?php if ($adus) : ?>
                
                <!--PUSH MASS CONTENT-->
                <button onclick="document.getElementById('push_mass_content_modal').style.display = 'block' " class="w3-button w3-black w3-hover-red w3-margin w3-round-small">Schedule Push <span class="fas fa-play-circle"></span></button>
                <!--PUSH MASS CONTENT MODAL-->
                <div class="w3-modal" id="push_mass_content_modal">
                    <div class="w3-modal-content">
                        <div class="w3-container w3-card-4 w3-round-small w3-padding w3-flat-silver">
                            <span onclick="document.getElementById('push_mass_content_modal').style.display='none'" class="w3-button w3-right w3-black w3-hover-red w3-round-small">&times;</span>
                            <h2>Schedule a Push:</h2>
                            <div id="schedule_mass_push_errors">

                            </div>

                            <form action="<?php echo base_url(); ?>adu/schedule_mass_push" method="post" id="schedule_mass_push_form" enctype="multipart/form-data">
                                <br>
                                <label for="adu">ADU:</label><br>
                                <?php foreach ($adus as $adu) : ?>
                                    <p style="display: inline" class="w3-black w3-round-small"><?php echo $adu['adu_name']; ?> :</p> <input checked class="w3-black" type="checkbox" name="adus[]" id="adus" value="<?php echo $adu['adu_id']; ?>"> <br>
                                <?php endforeach; ?>
                                <br>
                                <label for="mass_push_name">Name of Mass Push:</label><br>
                                <input type="text" class="w3-input w3-round-small" name="mass_push_name" id="mass_push_name">
                                <br>
                                <label for="mass_content">Upload Your Content: </label>
                                <input type="file" name="mass_content" id="mass_content">
                                <br>
                                <br>
                                <label for="mass_start_time">Start Time:</label><br>
                                <input type="time" name="mass_start_time" class="w3-input w3-round-small" id="mass_start_time">
                                <br>
                                <label for="mass_end_time">End Time:</label><br>
                                <input type="time" class="w3-input w3-round-small" name="mass_end_time" id="mass_end_time">
                                <br>
                                <br>
                                <label for="mass_start_date">Start Date:</label>
                                <input type="date" class="w3-input w3-round-small" name="mass_start_date" id="mass_start_date" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>">
                                <br>
                                <label for="mass_end_date">End Date:</label><br>
                                <input class="w3-input w3-round-small" type="date" name="mass_end_date" id="mass_end_date" value="<?php echo date('Y-m-d') ?>" min="<?php echo date('Y-m-d') ?>">
                                <br>

                                <input type="submit" value="Schedule Push" class="w3-button w3-block w3-black w3-hover-red">
                            </form>
                        </div>
                    </div>
                </div>

                <!--ADU POPULATION-->
                <h4>Your ADUS:</h4>
                <?php foreach ($adus as $adu) : ?>
                    <div id="<?php echo $adu['adu_id']; ?>_status" onclick="myFunction('<?php echo $adu['adu_id']; ?>')"  class="w3-block w3-button status_check  w3-black w3-hover-red w3-dropdown-click">
                        <p style="display: inline"><?php echo $adu['adu_name']; ?>.</p> <span class="fas fa-tv"></span>
                    </div>

                    <div class="w3-hide w3-container w3-flat-midnight-blue w3-padding" id="<?php echo $adu['adu_id']; ?>">
                        
                        <button id="<?php echo $adu['adu_id'] ?>_fill" onclick="dropSchedule('<?php echo $adu['adu_id'] ?>_schedule')" class="dropschedule w3-button w3-round-small w3-block w3-black w3-hover-red">Schedule <span class="fas fa-calendar"></span></button>
                        <div id="<?php echo $adu['adu_id']; ?>_schedule" class="w3-container w3-flat-silver w3-hide">
                            <table class="w3-table-all " style="margin-top:16px " id="<?php echo $adu['adu_id']; ?>_schedule_table">
                                <tr>
                                    <th>Push Name</th>
                                    <th>Push Type</th>
                                    <th>Content Type</th>
                                    <th>Time Scheduled</th>
                                    <th>Day Scheduled</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    
                                </tr>

                            </table>
                            
                            <a class=" schedule_download w3-button w3-margin w3-center w3-round-small w3-black w3-hover-red" href='<?php echo base_url() ?>adu/download_report/<?php echo $adu['adu_id']?>' id="<?php echo $adu['adu_id']; ?>_schedule_download">Download Report <span class="fas fa-file-download"></span></a>
                        </div>
                      

                    </div>
                    <br>
                    <br>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if (!$adus) : ?>
                <p class=" w3-panel w3-red w3-round-small" style="width: 27%">You Have Not Registered Any ADUS !</p>

            <?php endif; ?>
        </div>
    </div>



</div>
</body>

<script>
   
    function dropSchedule(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
    $("delete_push").on('click',function(){
        alert("Clicked");
    });
    $(".dropschedule").one('click',function(){
        var adu_id = event.srcElement.id;
        adu_id = adu_id.replace("_fill", "");
        $.ajax({
            url: '<?php echo base_url() ?>adu/return_schedule  ',
            method: 'post',
            data: {
                adu_id: adu_id
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    var schedule_data = data.message;
                    var html = '';
                    var index;
                    for (index = 0; index < schedule_data.length; index++) {

                        html += '<tr>' +
                            '<td>' + schedule_data[index].push_name + '</td>' +
                            '<td>' + schedule_data[index].push_type + '</td>' +
                            '<td>' + schedule_data[index].content_type + '</td>' +
                            '<td>' + schedule_data[index].time_scheduled + '</td>' +
                            '<td>' + schedule_data[index].day_scheduled + '</td>' +
                            '<td>' + schedule_data[index].start_time + '</td>' +
                            '<td>' + schedule_data[index].end_time + '</td>' +
                            '<td>' + schedule_data[index].start_date + '</td>' +
                            '<td>' + schedule_data[index].end_date + '</td>'    ;

                    }
                    var table_schedule = adu_id+"_schedule_table";  
                    $("#"+table_schedule).append(html);
                } else {
                    alert(data.message);
                }
            },
            error: function(data, status, err) {
                alert("Error Callback Says: " + err);
            }
        });
    });
    $("#mass_start_date").on('change', function() {
        var new_val = $("#mass_start_date").val();

        $("#mass_end_date").attr('min', new_val);
        $("#mass_end_date").attr('value', new_val);

    });
    $("#mass_end_date").on('change', function() {
        var new_val = $("#mass_end_date").val();
        $("#mass_start_date").attr('max', new_val);
        $("#mass_start_date").attr('value', new_val);
    });
    $("#start_date").on('change', function() {
        var new_val = $("#start_date").val();

        $("#end_date").attr('min', new_val);
        $("#end_date").attr('value', new_val);

    });
    $("#end_date").on('change', function() {
        var new_val = $("#end_date").val();
        $("#start_date").attr('max', new_val);
        $("#start_date").attr('value', new_val);
    });                 
    $("#schedule_mass_push_form").on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '<?php echo base_url(); ?>adu/schedule_mass_push',
            data: new FormData(this),
            dataType: 'json',
            processData: false,
            contentType: false,
            cache: false,
            async:false,
            type: 'post',
            success: function(data) {
                if (data.status == 'success') {
                    $("#adus").val(" ");
                    $("#mass_push_name").val(" ");

                    $("#schedule_mass_push_errors").html(data.message);
                } else if (data.status == 'error') {
                    $("#schedule_mass_push_errors").html(data.message);
                }
            },
            error: function(data, status, err) {
                alert("Error Callback Says : " + err);
            }
        });
    });
    
    $(".status_check").one('click',function(){
        var adu_id = event.srcElement.id;
        adu_id = adu_id.replace("_status", "");
        $.ajax({
            url: '<?php echo base_url() ?>adu/check_status',
            method: 'post',
            data: {adu_id:adu_id},
            dataType: 'json',
            success: function(data) {
                if (data.status == 'online') {
                    var place = adu_id+"_adu_status";
                    $("#"+place).html("Online");
                } else if (data.status == 'offline') {
                    var place = adu_id+"_adu_status";
                    $("#"+place).html("Offline");
                }
            },
            error: function(data, status, err) {
                alert("Error Callback Says: " + err);
            }
        });
    });
    function myFunction(id) {
        var adu_id = id;

        
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }
    $("#add_adu_form").on('submit', function(e) {
        e.preventDefault();

        var data = $("#add_adu_form").serialize();

        $.ajax({
            url: '<?php echo base_url(); ?>adu/add_cdu',
            data: data,
            method: 'post',
            dataType: 'json',
            success: function(data) {
                if (data.status == 'success') {
                    window.location.assign('<?php echo base_url(); ?>adu/index');
                } else if (data.status == 'error') {
                    $("#add_adu_errors").html(data.message);
                }
            },
            error: function(data, status, err) {
                alert("Callback Says: " + err);
            }
        });
    });
    $(".delete_push").on('click',function(){
        alery("Clicked");
    });
</script>

</html>