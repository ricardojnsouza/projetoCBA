<?php

    session_start();

    include_once '../assets/config.php';
    include_once '../assets/funcoes.php';
    include_once '../assets/classes/conexao.php';


    if (!isSet($_SESSION) || !isSet($_SESSION['auth_token'])) {
        die("0,Sessão inválida!");
    }
    $user = getUserByToken($_SESSION['auth_token']);
    if (empty($user)) {
        die("0,Usuário inválido");
    }

    $conexao = $GLOBALS['mysql'];

    //print_r($user);

    $post = array_change_key_case($_POST, CASE_LOWER);

    if (isSet($post['id'])) {
        switch(strtolower($post['id'])) {
            case "addpagamentosmodal":
                $data = json_decode($post['data'], true);
                // - de-para
                $de_para = [/*
                    'idproduto'                     => "idProduto",
                    'idcategoria'                   => "idCategoria",
                    'idfuncionario'                 => "idFuncionario",
                    'idcategoria'                   => "idCategoria",
                    'inputnomeproduto'              => "nomeProduto",
                    'inputquantidadeproduto'        => "quantidade",
                    'inputcategoriaproduto'         => "idCategoria",
                    'inputvalorproduto'             => "valor",
                    'inputdescricaoproduto'         => "descricao",
                    'inputdisponibilidadeproduto'   => "disponibilidade"
                */];
                // - campos obrigatórios
                $obrigatorios = [
                    'formapagamento' => "Forma de pagamento",
                    'valorpago'      => "Valor"
                ];

                // = críticas
                $criticas = [];
                // - itera pelos dados de cda funcionário enviado para o backend (apenas para críticas!)
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    // -
                    foreach ($obrigatorios as $j => $campo) {
                        if (!isSet($item[$j]) || empty($item[$j]) || $item[$j] == "Escolha..." || $item[$j] == "Selecione...") {
                            if (!isSet($criticas[0])) {
                                $criticas[0] = [];
                            }
                            $criticas[0][] = ($i + 1) . "-" . $campo;
                        }
                    }
                    if (isSet($criticas[0])) {
                        die("0,Os campos a seguir não foram preenchidos: " . implode(", ", $criticas[0]));
                    }
                    // campos personalizados...
                    //$data['ativos'][$i]['inputdisponibilidadeproduto'] = empty($item['inputdisponibilidadeproduto']) ? 0 : 1;
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    
                    $item['idpedido'] = $post['id_pedido'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idpagamento", $item) && intval($item['idpagamento']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO pagamentos ({0}) VALUES ({1})";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (/*isSet($de_para[$field]) && */strtolower($de_para[$field] ?? $field) !== "idpagamento") {
                                $fields[] = ($de_para[$field] ?? $field);
                                $places[] = "?";
                                $values[] = $value;
                            }
                        }
                        $sql = str_replace("{0}", implode(",", $fields), $sql);
                        $sql = str_replace("{1}", implode(",", $places), $sql);
                        // -
                        $commands[] = [
                            'query' => $sql,
                            'values' => $values
                        ];
                    }
                    // -> update (ignorando a PK)
                    else {
                        $sql = "UPDATE pagamentos SET {0} WHERE idpagamento = ?";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (/*isSet($de_para[$field]) && */strtolower($de_para[$field] ?? $field) !== "idpagamento") {
                                $fields[] = ($de_para[$field] ?? $field) . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idpagamentos'
                        $values[] = $item['idpagamento'];
                        // -
                        $sql = str_replace("{0}", implode(",", $fields), $sql);
                        $sql = str_replace("{1}", implode(",", $places), $sql);
                        // -
                        $commands[] = [
                            'query' => $sql,
                            'values' => $values
                        ];
                    }
                }

                // = prepara comandos para [delete's]
                foreach ($data['excluidos'] as $id) {
                    $sql = "DELETE FROM pagamentos WHERE idpagamento = ?";
                    $values = [ $id ];
                    // -
                    $commands[] = [
                        'query' => $sql,
                        'values' => $values
                    ];
                }

                // => executa de fato os comandos SQL armazenados em $commands utilizando uma transação ativa.
                $conn = $mysql->getConnection();
                if ($conn !== false) {
                    $conn->beginTransaction();
                }
                else {
                    die("0,A conexão não está ativa!");
                }
                try {
                    foreach ($commands as $command) {
                        $sql = $command['query'];
                        $values = $command['values'];
                        // =
                        $ps = $mysql->prepare( $sql );
                        $result = $ps->execute( $values );
                    }
                    // - atualiza a situação do pedido
                    $sql = "UPDATE pedido SET situacaoPedido = (CASE WHEN subtotal = (SELECT SUM(valorPago) FROM pagamentos WHERE idPedido = ?) THEN 'Pago' ELSE situacaoPedido END) WHERE idPedido = ?";
                    // -
                    $ps = $mysql->prepare( $sql );
                    $result = $ps->execute( [ $post['id_pedido'], $post['id_pedido'] ] );

                    // - commit
                    if ($conn !== false && $result === true) {
                        $conn->commit();
                        die("1,Opções de pagamento salvas com sucesso!");
                    }
                    else {
                        $conn->rollback();
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>pagamentos</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
        }
    }
    else {
        die("0,Parâmetros inválidos!");
    }


    print_r($GLOBALS['mysql']);
    // 1,mensagem de sucesso
    // 0,mensagem de erro
?>