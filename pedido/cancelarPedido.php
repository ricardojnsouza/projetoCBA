<?php

    session_start();

    include_once '../assets/config.php';
    include_once '../assets/funcoes.php';
    include_once '../assets/classes/conexao.php';

    if (!isSet($_SESSION) || !isSet($_SESSION['auth_token'])) {
        //die("0,Sessão inválida!");
        die(
            json_encode([
                'status' => 0, 
                'mensagem' => "Sessão inválida"
            ])
        );
    }
    $user = getUserByToken($_SESSION['auth_token']);
    if (empty($user)) {
        //die("0,Usuário inválido");
        die(
            json_encode([
                'status' => 0, 
                'mensagem' => "Usuário inválido"
            ])
        );
    }

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

    $post = array_change_key_case($_POST, CASE_LOWER);

    try {

        if ($conn !== false) {
            $conn->beginTransaction();
        }

        $status = false;

        // - obtém lista de pedidos ativos!
        $query = "SELECT idPedido FROM pedido WHERE idUsuario = ? AND idPedido = ? AND situacaoPedido IN ('Solicitado')";
        $data = [ $user['idusuario'], $post['id'] ?? 0 ];
        // -
        $ps = $mysql->prepare( $query );
        $result = $ps->execute( $data );
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            foreach ($results as $result) {
                $id = $result['idPedido'];
                if ($id > 0) {
                    $query = "UPDATE pedido SET situacaoPedido = 'Cancelado' WHERE idUsuario = ? AND idPedido = ?";
                    $data = [ $user['idusuario'], $id ];
                    // -
                    $ps = $mysql->prepare( $query );
                    $result = $ps->execute( $data );
                    // -
                    if ($result === true) {
                        $query = "UPDATE produto a INNER JOIN itenspedido b ON (a.idProduto = b.idProduto) SET a.quantidade = a.quantidade + b.quantidade WHERE b.idPedido = ?";
                        $data = [ $id ];
                        // -
                        $ps = $mysql->prepare( $query );
                        $result = $ps->execute( $data );
                        if ($result === true) {
                            $status = true;
                        }
                    }
                }
            }
        }

        if ($conn !== false) {
            if ($status) {
                $conn->commit();
            }
            else {
                $conn->rollback();
            }
        }
    }
    catch (Exception $e) {
        if ($conn !== false) {
            $conn->rollback();
        }
        $status = false;
        print("$query<br><pre>");
        print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
        print("<strong>StackTrace</strong>:<pre>");
        print($e->getTraceAsString());
        print("</pre>");
    }

    

    print(json_encode([
        'status' => $status ? 1 : 0, 
        'mensagem' => $status ? "Pedido cancelado!" : "Não foi possível cancelar o pedido!"
    ]));
?>