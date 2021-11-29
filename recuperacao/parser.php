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

    //print("<pre>");
    //print_r($post);
    //print("</pre>");

    if (isSet($post['metodo']) && $post['metodo'] == "recriar") {

        $status = false;

        if ($post['senhausuario'] !== $post['senhausuario2']) {
            print('<div class="toast erro align-items-center text-white bg-danger text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                A senha não confere!
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>');
        }
        else {
            $status = true;
        }

        //print_r($post);

        // - localiza o usuário a partir do email...
        $token = $post['token'];
        $id = 0;

        try {
            if ($status) {
                // - obtem dados do usuario
                $sql = "SELECT
                            idUsuario
                        FROM
                            usuario
                        WHERE 
                            token = ?";
                $data = [ $token ];
                // -
                $ps = $mysql->prepare( $sql );
                $result = $ps->execute( $data );
                // -
                if ($result === true) {
                    $results = $ps->fetchAll();
                    foreach ($results as $result) {
                        $id = $result['idUsuario'];
                    }
                }

                if ($id == 0) {
                    print('<div class="toast erro align-items-center text-white bg-danger text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                Token inválido!
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>');
                }

                // - atualliza o token de sessão
                if ($id > 0 && !empty($token)) {

                    $senha = hash("sha256", $post['senhausuario']);

                    // - obtem dados do usuario
                    $sql = "UPDATE
                                usuario
                            SET
                                senhaUsuario = ?,
                                bloqueado = 0,
                                inicio_bloqueio = null,
                                token = null
                            WHERE 
                                idUsuario = ?";
                    $data = [ $senha, $id ];
                    // -
                    $ps = $mysql->prepare( $sql );
                    $result = $ps->execute( $data );
                    // -
                    if ($result === true) {
                        print('<div class="toast sucessos align-items-center text-white bg-success text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            Senha atualizada!
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>');
                    }
                }
            }
        }
        catch (Exception $e) {
            /*
            print("$sql<br><pre>");
            print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
            */
            print('<div class="toast erro align-items-center text-white bg-danger text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                Não foi possível atualizar a senha: '.$e->getMessage().'
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