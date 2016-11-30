<div style="display:none;" id="myDiv" class="animate-bottom">
    <?php            
        $adminEmail = "admin@example.com";   

        function output_err($num) {
            $err[1] = 'Jak se jmenujete?';
            $err[2] = 'Jaká je Vaše emailová adresa?';
            $err[3] = 'Emailová adresa není ve správném tvaru.';
            echo '<p><strong>'.$err[$num].'</strong> Zpráva nebyla odeslána. <a href="#" onclick="backToForm(' . $num . ')">Zpět na formulář</a>.</p>';
        }  

        if (empty($_GET['name'])) {
            output_err(1);
        } elseif (empty($_GET['email'])) {
            output_err(2);
        } elseif (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $_GET['email'])) {
            output_err(3);
        } else {
            $values = (object) [
                'name' => $_REQUEST['name'],
                'email' => $_REQUEST['email'],
                'phone' => $_REQUEST['phone'],
                'message' => $_REQUEST['message'],
            ];

            $strictDate = Date("j/m/Y H:i:s", Time());
            $date = Date("j/m/Y", Time());

            $webName = "yourwebexample.com";

            $name =  substr(htmlspecialchars(trim($values->name)), 0, 50);
            $email =  substr(htmlspecialchars(trim($values->email)), 0, 50);
            $phone =  substr(htmlspecialchars(trim($values->phone)), 0, 50);
            $message = nl2br(htmlspecialchars($values->message));

            $subjectForUs = 'Rychlý kontakt ' . $webName . ' ' . $strictDate;
            $bodyForUs = '
            Toto je zpráva z webu ' . $webName . ':<br>
            ---<br>
            Jméno: ' . $name . ' <br><br>
            Email: ' . $email . ' <br><br>
            Telefon: ' . $phone . ' <br><br>
            Sdělení: <br><br>' . $message;
            $headersForUs  = 'From: ' . $name . ' <' . $email . '>' . "\r\n" .
                        'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n" .
                        'MIME-Version: 1.0' . "\r\n" .
                        'Content-type: text/html; charset=utf-8' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();

            if (mail($adminEmail, $subjectForUs, $bodyForUs, $headersForUs)) {
                echo 'Zpráva byla odeslána. <a href="#" onclick="backToForm(0)">Odeslat další</a>.';
            } else {
                echo 'Zpráva nebyla odeslána. <a href="#" onclick="backToForm(0)">Odeslat další</a>.';
            }
        }

    ?>
</div>
