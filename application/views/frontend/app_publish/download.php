<?php
// Redirect to the specified URL
header("Location: ".$app_info->url);
// Ensure the script stops execution after the redirect
exit();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Download <?php echo $type; ?> App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .download-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .app-info {
            margin: 20px 0;
            text-align: left;
        }
        .download-button {
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="download-container">
        <h2>Download <?php echo $type; ?> App</h2>
        <div class="app-info">
            <p><strong>Version:</strong> <?php echo $app_info->version_number; ?></p>
            <p><strong>Release Date:</strong> <?php echo date('d-m-Y', strtotime($app_info->date)); ?></p>
            <p><strong>Description:</strong> <?php echo $app_info->description; ?></p>
            <?php if($app_info->remarks): ?>
                <p><strong>Remarks:</strong> <?php echo $app_info->remarks; ?></p>
            <?php endif; ?>
        </div>
        <div class="download-button">
            <a href="<?php echo $app_info->url; ?>" class="btn btn-lg btn-success" id="downloadBtn">
                <i class="glyphicon glyphicon-download-alt"></i> Download Now
            </a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto-trigger download after 2 seconds
            setTimeout(function() {
                //window.location.href = '<?php echo $app_info->url; ?>';
            }, 2000);
        });
    </script>
</body>
</html>