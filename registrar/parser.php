<?php
    //print_r($post);

    // - variáveis globais (vão ser passadas para o javascript para feedback de críticas e sucessos)
    $criticas = [];
    $sucessos = [];

    // - validação dos dados (campos obrigatórios)
    $obrigatorios = [
        'Nome' => "nomeusuario",
        'E-mail' => "emailusuario", 
        'Senha' => "senhausuario"
    ];
    
    foreach ($obrigatorios as $i => $obrigatorio) {
        if (!array_key_exists($obrigatorio, $post)) {
            $criticas[] = "O campo <strong>$i</strong> não foi informado!";
        }
        else if (empty($post[$obrigatorio])) {
            $criticas[] = "O campo <strong>$i</strong> não foi preenchido!";
        }
    }

    // - validação: senha com no mínimo 6 caracteres
    if (count($criticas) === 0 && isSet($post['senhausuario']) && strlen($post['senhausuario']) < 6) {
        $criticas[] = "A <strong>senha</strong> deve ter no mínimo 6 caracteres";
    }

    // - validação: senha igual a confirmação
    if (count($criticas) === 0 && isSet($post['senhausuario']) && isSet($post['senhausuario2']) && $post['senhausuario'] !== $post['senhausuario2']) {
        $criticas[] = "As senhas digitadas não conferem!";
    }

    // - validação: email já cadastrado
    if (count($criticas) === 0 && isSet($post['emailusuario'])) {
        $sql = "SELECT COUNT(*) FROM `usuario` WHERE `emailusuario` = ?";
        try {
            $ps = $mysql->prepare($sql);
            $ps->execute( [ $post['emailusuario'] ] );
            $results = $ps->fetchAll();
            foreach ($results as $reg) {
                if ($reg[0] > 0) {
                    $criticas[] = "O E-mail <strong>".$post['emailusuario']."</strong> já está cadastrado!";
                    break;
                }
            }
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r($values);
            print("</pre>Falha ao validar dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
    }
    

    
    // - se não houverem críticas...
    if (count($criticas) == 0) {
        $sql = "INSERT INTO `usuario` (`{fields}`) VALUES ({places})";
        $places = [];
        $fields = [];
        $values = [];
        // - alimenta os arrays auxiliares para montar o insert...
        foreach ($obrigatorios as $obrigatorio) {
            $value = $post[$obrigatorio];
            // - aplica a codificação adequada ao campo de senha...
            if ($obrigatorio === "senhausuario") {
                $value = hash ("sha256", $value);
            }
            $places[] = "?";
            $fields[] = $obrigatorio;
            $values[] = $value;
        }
        // - prepara o comando base para o pdo::prepare()
        $sql = str_replace("{fields}", implode("`,`", $fields), $sql);
        $sql = str_replace("{places}", implode(",", $places), $sql);
        
        // - inicia o prepare e executa o insert
        try {
            //print("$sql<br><pre>".print_r($values, true)."</pre>");
            
            $ps = $mysql->prepare($sql);
            $result = $ps->execute($values);

            // - executa a função de autenticação e confirma o cadastro!
            if ($result === true && login($post['emailusuario'], $post['senhausuario2']) === true) {
                $sucessos[] = "Cadastro realizado com sucesso!";
            }
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print_r($values);
            print("</pre>Falha ao inserir os dados em <font color='red'>usuario</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }

    }
    // - prepara plotagem das críticas
    if (count($criticas) > 0) {
        // -
        foreach ($criticas as $i => $critica) {
            $criticas[$i] = '<div class="toast criticas align-items-center text-white bg-danger text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        '.$critica.'
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>';
        }
        // -
        print(implode("", $criticas));
        // -
        $criticas = true;
    }

    // - prepara plotagem das mensagens de sucesso!
    if (count($sucessos) > 0) {
        // -
        foreach ($sucessos as $i => $sucesso) {
            $sucessos[$i] = '<div class="toast sucessos align-items-center text-white bg-success text-end border-0 m-1" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="d-flex">
                                    <div class="toast-body">
                                        '.$sucesso.'
                                    </div>
                                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                </div>
                            </div>';
        }
        // -
        print(implode("", $sucessos));
        // -
        $sucessos = true;
    }

?>



