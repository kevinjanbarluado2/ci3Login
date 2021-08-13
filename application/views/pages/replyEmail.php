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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<?php if($page == 'actual-page') : ?>
    <input type="hidden" value="<?= base_url(); ?>" id="base_url" />
    <input type="hidden" class="token" name="token" value="<?php echo $token; ?>">
    <input type="hidden" name="adviser_id" value="<?php echo $adviser_id; ?>">
    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
    <input type="hidden" name="adviser_name" value="<?php echo $adviser_name; ?>">
    
    <div class="container-fluid">
        <img src="https://onlineinsure.co.nz/compliance/img/img.png" style="width:150px;" class="mx-auto d-block pt-3">
        <div class="row">
            <div class="col py-3">
                <h3 class="h3 mb-3 font-weight-normal text-center" style="color:#858796">Compliance App</h3>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="chat-holder">
                <?php 
                    if($chat != '') : 
                        foreach ($chat as $k => $v) : 
                            $datetime = date_format(date_create($chat[$k]['timestamp']),"d F Y - h:i:s A"); 
                            $timestamp = $chat[$k]['timestamp'];
                            $sender = $chat[$k]['sender'];

                            if($sender == 0) {
                                $sender_name = $chat[$k]['user_name'];
                                $class= "darker";
                                $alignment = "left";
                            } else {
                                $sender_name = $adviser_name;
                                $class= "";
                                $alignment = "right";
                            }
                ?>

                    <div class="container-chat <?php echo $class; ?>">
                        <p class="p-left"><?php echo $sender_name; ?><span class="time-right"><?php echo $datetime; ?></span></p>
                        <span class="msg-left" style="float:<?php echo $alignment; ?>"><?php echo $chat[$k]['message']; ?></span>
                    </div>
                <?php 
                        endforeach; 
                    endif; 
                ?>         
                </div>
                <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?>">   
            </div>
        </div>

        <div class="fixed-bottom px-3">
            <textarea class="form-control inputField" name="" id="" cols="10" rows="5" placeholder="Reply..."></textarea>
            <button id="sendChat" class="btn btn-primary btn-block text-white" type="button">Send</button>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <!-- Plugin for the momentJs  -->
    <script src="../assets/js/plugins/moment.min.js"></script>
    <script src="../assets/js/addons/replyEmail.js"></script>

<?php else : ?>
    A new window for formatted compliance messenger will open. If the messenger doesn't open, kindly click this
    <a id="redirect-link" href="<?php echo base_url() ?>Compliance/loadChatBox?v=<?php echo $token; ?>&adviser=<?php echo $adviser; ?>" onclick="window.open(this.href,'newwindow','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=600'); return false;">link</a> to manually open it.
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $('#redirect-link').click();
    </script>
<?php endif; ?>
</body>
</html>