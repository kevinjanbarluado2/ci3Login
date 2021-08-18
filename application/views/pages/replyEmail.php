<?php
    $timestamp;
    $sender_name;
    $class;
    $alignment;

    if(isset($adviser) && sizeof($adviser) > 0) {
        $adviser_name = $adviser->first_name." ".$adviser->last_name;
        $adviser_id = $adviser->idusers;
    } else {
        $adviser_name = "";
        $adviser_id = 0;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Reply Notes - EliteInsure</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<style>
    .container-chat {
        border: 2px solid #dedede;
        background-color: #f1f1f1;
        border-radius: 5px;
        padding: 10px;
        margin: 10px 2px;
    }

    .darker {
        border-color: #ccc;
        background-color: #ddd;
    }

    .container-chat::after {
        content: "";
        clear: both;
        display: table;
    }

    .time-right {
        float: right;
        color: #aaa;
        font-size: 11px;
    }

    .p-left {
        color: #999;
        font-size: 11px;
    }

    .msg-left {
        float: left;
    }

    .flexContainer {
        display: flex;
    }

    .inputField {
        flex: 1;
    }

    .chat-holder {
        border-style: inset; 
        padding: 5px;
        height: 220px;
        max-height: 220px;
        overflow-y: scroll;
    }
</style>
<body style="background-color: #f5f5f5;">
    A new window for formatted compliance messenger will open. If the messenger doesn't open, kindly click this
    <a id="redirect-link" href="http://onlineinsure.co.nz/compliance-messenger/app?u=<?php echo $adviser; ?>&v=1&w=<?php echo $token; ?>" onclick="window.open(this.href,'newwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=600'); return false;"><strong>LINK</strong></a> to manually open it.

   <!--  A new window for formatted compliance messenger will open. If the messenger doesn't open, kindly click this
    <a id="redirect-link" href="http://localhost/compliance-messenger/app?u=<?php echo $adviser; ?>&v=1&w=<?php echo $token; ?>" onclick="window.open(this.href,'newwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=600'); return false;">link</a> to manually open it. -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#redirect-link').click();
    </script>
</body>
</html>