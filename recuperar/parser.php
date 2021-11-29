<?php
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    //require 'vendor/autoload.php';
    require 'recuperar/vendor/autoload.php';

    $post = array_change_key_case($_POST, CASE_LOWER);

    if (isSet($post['metodo']) && $post['metodo'] == "recuperar") {

        //print_r($post);

        // - localiza o usuário a partir do email...
        $email = $post['emailusuario'];
        $id = 0;

        try {
            $pedido = [ 'items' => [] ];
    
            // - obtem dados do usuario
            $sql = "SELECT
                        idUsuario
                    FROM
                        usuario
                    WHERE 
                        emailUsuario = ?";
            $data = [ $email ];
            // -
            $ps = $mysql->prepare( $sql );
            $result = $ps->execute( $data );
            // -
            if ($result === true) {
                $results = $ps->fetchAll();
                foreach ($results as $result) {
                    $id = $result['idUsuario'];
                    //print("--- <pre>");
                    //print_r($result);
                    //print("</pre>");
                }
            }

            // - atualliza o token de sessão
            if ($id > 0 && !empty($email)) {

                // - define o tolen para recuperação de email...
                $token = hash("sha256", $email . round(microtime(true) * 1000) . $id);

                 // - obtem dados do usuario
                $sql = "UPDATE
                            usuario
                        SET
                            token = ?,
                            bloqueado = 1,
                            inicio_bloqueio = NOW()
                        WHERE 
                            idUsuario = ?";
                $data = [ $token, $id ];
                // -
                $ps = $mysql->prepare( $sql );
                $result = $ps->execute( $data );
                // -
                if ($result === true) {
                    enviarEmail($email, $token);
                }
            }


        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }

        

    }

    

    
    function enviarEmail($email, $token) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            $url = "http://localhost/web/?link=recuperacao&token=$token";

            //Server settings
            //$mail->SMTPDebug  = SMTP::DEBUG_SERVER;                     //Enable verbose debug output
            $mail->SMTPDebug  = 0;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'williamsartiman5@gmail.com';                     //SMTP username
            $mail->Password   = '';                           //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('williamsartiman5@gmail.com', 'Mailer');
            $mail->addAddress($email, $email);     //Add a recipient
            //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@cba.com.br', 'Informações');
            //$mail->addCC('cc@example.com');
            //$mail->addBCC('bcc@example.com');

            //Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperação de senha do CBA';
            $mail->Body    = 'Olá, para recuperar a sua senha acesse o link: <a href="'.$url.'">'.$url.'</a>';
            $mail->AltBody = 'Para recuperar a sua senha acesse o link: ' . $url;

            $mail->send();
            //echo 'Message has been sent';
            print('<div class="toast sucessos align-items-center text-white bg-success text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            E-mail de recuperação enviado!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>');
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            // -
            print('<div class="toast erro align-items-center text-white bg-danger text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            '.$mail->ErrorInfo.'
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>');
        }
    }
?>

<script type='text/javascript'>
    setTimeout(() => $(".toast").toast("show"), 1000);
</script>