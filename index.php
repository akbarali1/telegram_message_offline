<?php
require 'core.php';

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';
$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->async(true);
$MadelineProto->loop(function () use ($MadelineProto) {
    yield $MadelineProto->start();
    $me = yield $MadelineProto->getSelf();
    $MadelineProto->logger($me);
    if (!$me['bot']) {
        //Bu yerga Avtomatik chiqib turishi uchun kanal yoki foydalanuvchi usernamesini kiritasiz namuna mavjud
        $massiv = [
            //Guruhga
            'UzGeeksGroup'     => 'UzGeeks - Oʻqing, oʻrganing!',
            //Menga yani foydalanuvchiga jo`natish
            'akbarali0511'     => 'Akbarali',

        ];
        if (empty($_POST['ajax'])) {
?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="assets/style.css">
                <!-- <script src="assets/javascript.js"></script> -->
                <title>Telegramga habar jo`natish</title>
            </head>

            <body>
                <?php
                if (empty($_POST['group']) and empty($_POST['select'])) { ?>
                    <div class="contaakb">
                        <h2>Telegramga habar yozish</h2>
                        <p>Guruhlarga habar yozish uchun qilingan modul</p>
                    </div>
                    <div class="container">
                        <form action="?" method="post">
                            <div class="row">
                                <div class="col-25">
                                    <label for="fname">Guruh nomi</label>
                                </div>
                                <div class="col-75">
                                    <input type="text" id="group" name="group" placeholder="Telegram guruhning nomini yozing" value="<?= $r = (isset($_GET['group'])) ? $_GET['group'] : ''; ?>" <?= $autof = (isset($_GET['group'])) ? '' : 'autofocus'; ?>>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-25">
                                    <label for="country">Guruh (ixtiyoriy)</label>
                                </div>
                                <div class="col-75">
                                    <select id="select" name="select" onchange="getComboA(this)">
                                        <option selected value="tanlang">Tanlang</option>
                                        <?php
                                        foreach ($massiv as $key => $value) {
                                            echo "<option value=\"$key\">$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="subject">Habar matni</label>
                                </div>
                                <div class="col-75">
                                    <textarea id="message" name="message" placeholder="Habar matnini yozing" style="height:200px" <?= $raa = (isset($_GET['group'])) ? '' : 'autofocus'; ?>></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <button type="submit" onclick="loadDoc(event)">
                                    Jo'natish
                                </button>
                            </div>
                        </form>
                    </div>
                <?php  } ?>
                <script type="text/javascript">
                    function getComboA(selectObject) {
                        document.getElementById("group").disabled = true;
                        document.getElementById("message").focus();
                        console.log('group disabled');
                    }

                    function loadDoc(event) {
                        document.getElementById("message").disabled = true;
                        document.getElementById("select").disabled = true;
                        document.getElementById("group").disabled = true;
                        var params = 'message=' + document.getElementById('message').value + '&select=' + document.getElementById('select').value + '&group=' + document.getElementById('group').value + '&ajax=yes';
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", "?", true);
                        xhttp.onreadystatechange = function() {
                            if (this.readyState == 4 && this.status == 200) {
                                document.getElementById("demo").innerHTML = this.responseText;
                            }
                        }
                        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        xhttp.onreadystatechange = function() { //Call a function when the state changes.
                            if (xhttp.readyState == 4 && xhttp.status == 200) {
                                alert(xhttp.responseText);
                                document.getElementById("message").disabled = false;
                                document.getElementById("select").disabled = false;
                                document.getElementById("group").disabled = false;
                            }
                        }
                        xhttp.send(params);
                        event.preventDefault();
                    }
                </script>
            </body>

            </html>
<?php
        }
        if (!empty($_POST['group'])) {
            $group = $_POST['group'];
            $message = $_POST['message'];
        } elseif (!empty($_POST['select']) || $_POST['select'] != 'tanlang') {
            $group = $_POST['select'];
            $message = $_POST['message'];
        }
        yield $MadelineProto->messages->sendMessage(
            [
                'peer' => 'https://t.me/' . $group,
                'message' => $message
            ]
        );
    }
    if (!empty($_POST['ajax'])) {
        die('Habar ajax orqali belgilangan manzilga yuborildi!');
    } else if (!empty($_POST['group'])) {
        $textresp = '<div class="container"><h1>Habar yuborildi! </h1><a href="http://f0563085.xsph.ru/telegram/index.php?">Orqaga</a></div>';
    } else if (!empty($_POST['select'])) {
        $textresp = '<div class="container"><h1>Habar yuborildi! </h1><a href="http://f0563085.xsph.ru/telegram/index.php?">Orqaga</a></div>';
    }
    yield $MadelineProto->echo($textresp);
});
