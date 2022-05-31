<!DOCTYPE html>
<html>
<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta charset="utf-8">
    <title>Create PDF from View in CodeIgniter Example</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css" rel="stylesheet" />
</head>
<body>
<h1 class="text-center bg-info">Schedule List</h1>
<table class="table table-striped table-hover">
    <thead>
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
    </thead>
    <tbody>
        <?php foreach ($schedule_list as $schedule):?>
           <tr>
           <td><?php echo $schedule->push_name;?></td>
            <td><?php echo $schedule->push_type;?></td>
            <td><?php echo $schedule->content_type;?></td>
            <td><?php echo $schedule->time_scheduled;?></td>
            <td><?php echo $schedule->day_scheduled;?></td>
            <td><?php echo $schedule->start_time;?></td>
            <td><?php echo $schedule->end_time;?></td>
            <td><?php echo $schedule->start_date;?></td>
            <td><?php echo $schedule->end_time;?></td>
           </tr>
        <?php endforeach?>
    </tbody>
</table>
</body>
</html>