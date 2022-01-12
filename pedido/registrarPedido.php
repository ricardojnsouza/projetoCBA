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
    $post['status'] = 1;
 
    // => executa de fato os comandos SQL armazenados em $commands utilizando uma transação ativa.
    $conn = $mysql->getConnection();
    if ($conn === false) {
        die(
            json_encode([
                'status' => 0, 
                'mensagem' => "A conexão não está ativa"
            ])
        );
    }
    try {
        if ($conn !== false) {
            $conn->beginTransaction();
        }

        $id_pedido = $post['id'] ?? 0;
        $result = false;

        // ///////////////
        // PEDIDO
        // ///////////////

        // - avalia se é preciso realizar um [insert] ou [update] na tabela de 'pedido'
        $query = "SELECT COUNT(*) AS `cnt` FROM pedido WHERE idPedido = " . $id_pedido;
        $rs = $conexao->getQueryData($query);

        // - insert
        if ($rs[0]['cnt'] == 0) {
            $query = "INSERT INTO pedido (idUsuario, idMesa, subtotal, observacao, situacaoPedido) VALUES (?, ?, ?, ?, ?)";
            $data = [
                $user['idusuario'],
                $post['mesa'],
                $post['subtotal'],
                $post['observacao'],
                $post['situacao']
            ];
            // -
            $ps = $mysql->prepare( $query );
            $result = $ps->execute( $data );
            // -
            if ($result) {
                $id_pedido = $mysql->getLastInsertID();
            }
            else {
                $post['status'] = 0;
            }

        }

        // - update
        else {
            $query = "UPDATE pedido SET idUsuario = ?, idMesa = ?, subtotal = ?, observacao = ?, situacaoPedido = ? WHERE idPedido = ?";
            $data = [
                $user['idusuario'],
                $post['mesa'],
                $post['subtotal'],
                $post['observacao'],
                $post['situacao'],
                // -
                $id_pedido
            ];
            // -
            $ps = $mysql->prepare( $query );
            $result = $ps->execute( $data );
            if ($result == false) {
                $post['status'] = 0;
            }
        }
        // -
        $post['id'] = $id_pedido;

        // ///////////////
        // ITENSPEDIDO
        // ///////////////

        if ($result === true) {
            $items = $post['items'];
            if (is_array($items)) {
                foreach ($items as $i => $item) {
                    $id_item_pedido = $item['id'] ?? 0;

                    // - avalia se é preciso realizar um [insert] ou [update] na tabela de 'itenspedido'
                    $query = "SELECT COUNT(*) AS `cnt` FROM itenspedido WHERE idItemPedido = " . $id_item_pedido;
                    $rs = $conexao->getQueryData($query);

                    // - insert
                    if ($rs[0]['cnt'] == 0) {
                        $query = "INSERT INTO itenspedido (idPedido, idProduto, idAdicional, quantidade, valor) VALUES (?, ?, ?, ?, ?)";
                        $data = [
                            $id_pedido,
                            // -
                            $item['produto'],
                            null,
                            $item['quantidade'],
                            $item['valor']
                        ];
                        // -
                        $ps = $mysql->prepare( $query );
                        $result = $ps->execute( $data );
                        // -
                        if ($result) {
                            $id_item_pedido = $mysql->getLastInsertID();
                            // =
                            $post['items'][$i]['id'] = $item['id'] = $id_item_pedido;
                        }
                        else {
                            $post['status'] = 0;
                        }
                    }

                    // - update
                    else {
                        $query = "UPDATE itenspedido SET idPedido = ?, idProduto = ?, idAdicional = ?, quantidade = ?, valor = ? WHERE idItemPedido = ?";
                        $data = [
                            $id_pedido,
                            // -
                            $item['produto'],
                            null,
                            $item['quantidade'],
                            $item['valor'],
                            // -
                            $id_item_pedido
                        ];
                        // -
                        $ps = $mysql->prepare( $query );
                        $result = $ps->execute( $data );
                        // -
                        if ($result == false) {
                            $post['status'] = 0;
                        }
                    }

                    // - deduz quantidades dos produtos no estoque do cliente
                    $query = "UPDATE produto SET quantidade = quantidade - ? WHERE idProduto = ?";
                    $data = [
                        $item['quantidade'],
                        // -
                        $item['produto']
                    ];
                    // -
                    $ps = $mysql->prepare( $query );
                    $result = $ps->execute( $data );
                    // -
                    if ($result == false) {
                        $post['status'] = 0;
                    }
                }
            }
        }

        if ($conn !== false) {
            $conn->commit();
        }
    }
    catch (Exception $e) {
        if ($conn !== false) {
            $conn->rollback();
        }
        print("$query<br><pre>");
        print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
        print("<strong>StackTrace</strong>:<pre>");
        print($e->getTraceAsString());
        print("</pre>");
    }
    // =
    print(json_encode($post));
?>