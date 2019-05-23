<html>
<head>

</head>
<body>

    <?php
    $amount = $_GET['amount'];
    $pin = "AEC55CBE2F112EC7D10E";#your pin
    $callback = "http://localhost/game-poker/account/addmoney3.php";#your callback url
    $address = "http://panel.ariyapal.com/api/create/";#api address
    $bank = "";#bank name


    $url = $_SERVER['REQUEST_URI']; //returns the current URL
    $parts = explode('/', $url);
    $callback = $_SERVER['SERVER_NAME'];
    for ($i = 0; $i < count($parts) - 1; $i++) {
        $callback .= $parts[$i] . "/";
    }
    $callback .= "addmoney2.php";

    if (!Empty($_GET)) {
        $url = 'http://panel.ariyapal.com/api/create/'; // don't change
        $description = "";
        if (!Empty($_GET["name"])) {
            $description .= "نام و نام خانوادگی : " . $_GET["name"] . "\n";
        }
        if (!Empty($_GET["email"])) {
            $description .= "ادرس ایمیل : " . $_GET["email"] . "\n";
        }
        if (!Empty($_GET["phone"])) {
            $description .= "شماره موبایل : " . $_GET["phone"] . "\n";
        }
        if (!Empty($_GET["details"])) {
            $description .= "توضیحات کاربر : " . $_GET["details"] . "\n";
        }
        if (Empty($_GET["amount"]) or $_GET["amount"] < 100) {
            $_GET["amount"] = '100';
        }

        $callback .= "?amount=" . $_GET["amount"];
        $fields = array(
            'amount' => urlencode($_GET["amount"]),
            'pin' => urlencode($pin),
            'description' => urlencode($description),
            'callback' => urlencode($callback),
        );
        $fields_string = "";
        foreach ($fields as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);


        if (is_numeric($result)) {
            echo '
    <span style="color:red">ارور : ' . $result . '</span>';
        } else {
            echo $result;
            header('Location: http://panel.ariyapal.com/startpay/' . $result);
        }
    }
    ?>
</body>
</html>
