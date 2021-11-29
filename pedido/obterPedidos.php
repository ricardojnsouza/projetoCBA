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
        $pedidos = [
            'status' => 1,
            'pedidos' => [
                /**
                'id' => 0,
                'usuario' => 0,
                'mesa' => 0,
                'subtotal' => 0.00,
                'observacao' => null,
                'situacao' => 'Solicitado'
                // -
                'items' => [
                    'id' => 0,
                    'id_produto' => 0
                    'produto' => 'nome do produto',
                    'quantidade' => 0,
                    'valor' => 0
                ]
                */
            ]
        ];

        // - obtém lista de pedidos ativos!
        $query = "SELECT idPedido FROM pedido WHERE idUsuario = ? AND situacaoPedido IN ('Solicitado', 'Em Produção', 'Entregue')";
        $data = [ $user['idusuario'] ];
        // -

        //print_r($data);
        //var_dump($data);

        $ps = $mysql->prepare( $query );
        $result = $ps->execute( $data );
        // -
        if ($result === true) {
            $results = $ps->fetchAll();
            foreach ($results as $result) {

                $pedido = [ 'items' => [] ];

                // - obtem dados do pedido
                $sql = "SELECT
                            idPedido,
                            idUsuario,
                            idMesa,
                            subtotal,
                            observacao,
                            situacaoPedido
                        FROM
                            pedido
                        WHERE 
                            idPedido = ?";
                $data = [ $result['idPedido'] ];
                // -
                $ps_A = $mysql->prepare( $sql );
                $result_A = $ps_A->execute( $data );
                // -
                if ($result_A === true) {
                    $results_A = $ps_A->fetchAll();
                    foreach ($results_A as $result_A) {
                        $pedido = [
                            'id'         => $result_A['idPedido'],
                            'id_usuario' => $result_A['idUsuario'],
                            'id_mesa'    => $result_A['idMesa'],
                            'subtotal'   => $result_A['subtotal'],
                            'observacao' => $result_A['observacao'],
                            'situacao'   => $result_A['situacaoPedido'],
                            'items'      => []
                        ];

                        // - obtem dados dos ítens do pedido
                        $sql = "SELECT
                                    a.idItemPedido,
                                    a.idProduto,
                                    a.idAdicional,
                                    a.quantidade,
                                    a.valor,
                                    b.nomeProduto,
                                    c.nome AS `nomeAdicional`
                                FROM
                                    itenspedido a
                                        LEFT JOIN
                                    produto b
                                        ON (
                                            a.idProduto = b.idProduto
                                        )
                                        LEFT JOIN
                                    adicionais c
                                        ON (
                                            a.idAdicional = c.idAdicional
                                        )
                                WHERE 
                                    a.idPedido = ?";
                        $data = [ $result['idPedido'] ];
                        // -
                        $ps_B = $mysql->prepare( $sql );
                        $result_B = $ps_B->execute( $data );
                        // -
                        if ($result_B === true) {
                            $results_B = $ps_B->fetchAll();
                            foreach ($results_B as $result_B) {
                                $item = [
                                    'id'           => $result_B['idItemPedido'],
                                    'id_produto'   => $result_B['idProduto'],
                                    'id_adicional' => $result_B['idAdicional'],
                                    'produto'      => $result_B['nomeProduto'],
                                    'adicional'    => $result_B['nomeAdicional'],
                                    'quantidade'   => $result_B['quantidade'],
                                    'valor'        => $result_B['valor']
                                ];
                                // -
                                $pedido['items'][] = $item;
                            }
                        }
                        // = adiciona o pedido ao array de retorno
                        if (count($pedido['items']) > 0) {
                            $pedidos['pedidos'][] = $pedido;
                        }

                    }
                }
            }
        }
    }
    catch (Exception $e) {
        $pedidos['status'] = 0;
        print("$query<br><pre>");
        print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
        print("<strong>StackTrace</strong>:<pre>");
        print($e->getTraceAsString());
        print("</pre>");
    }

    print(json_encode($pedidos));
?>