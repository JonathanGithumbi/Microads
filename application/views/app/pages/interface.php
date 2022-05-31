<?php
date_default_timezone_set('Africa/Nairobi');
    $today = date("Y-m-d");
    $time = date("H:i:s");
    $playlist = array();
    foreach ($schedule as $push) {
      if($today >= $push['start_date'] && $today <= $push['end_date'] && $time >= $push['start_time'] && $time <= $push['end_time'])
      {
           $server_path = $push['content'];
           $server_path = explode('/',$server_path);
           $file_name = $server_path[count($server_path)-1];
           $folder = $server_path[count($server_path)-2];
           $content = implode("/", array($folder,$file_name));
           $push['content'] = $content;
        
           
           array_push($playlist,$push);
      }
    }
    sort($playlist);
    
?>
<body>
    

    <?php  foreach ($playlist as $push):?>
        <?php if($push['content_type'] == 'image/jpeg'):?>
            <div class="w3-container w3-center">
                <img src=<?php echo base_url()?><?php echo $push['content']?> alt="<?php $push['push_name'];?>" style="width: 100%">
            </div>
        <?php endif;?>
        
    <?php endforeach ;?>
</body>
<script>

</script>