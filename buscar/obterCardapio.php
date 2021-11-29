<?php

    session_start();

    include_once '../assets/config.php';
    include_once '../assets/funcoes.php';
    include_once '../assets/classes/conexao.php';

    /*
    if (!isSet($_SESSION) || !isSet($_SESSION['auth_token'])) {
        die("0,Sessão inválida!");
    }
    $user = getUserByToken($_SESSION['auth_token']);
    if (empty($user)) {
        die("0,Usuário inválido");
    }
    */

    $post = array_change_key_case($_POST, CASE_LOWER);

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
        $empresa = $post['idempresa'] ?? 0;
        $cardapio = [
            'status' => 1,
            'empresa' => $empresa,
            'cardapio' => [],
            'mesas' => [],
            'ocorrencias' => 0
        ];

        // =

        $data = [ $empresa ];
        
        // - obtém cardapio
        
        $query = "SELECT
                        a.nomeCategoria,
                        b.nomeProduto,
                        b.valor,
                        b.descricao,
                        b.quantidade,
                        b.idProduto
                    FROM
                        empresa e
                            LEFT JOIN
                        funcionario f
                            ON (
                                e.idEmpresa = f.idEmpresa
                            )
                            LEFT JOIN
                        produto b
                            ON (
                                f.idFuncionario = b.idFuncionario
                            )
                            LEFT JOIN
                        categoria a
                            ON (
                                b.idCategoria = a.idCategoria
                            )
                            
                    WHERE
                        e.idEmpresa = ?
                    ORDER BY
                        a.nomeCategoria,
                        b.nomeProduto,
                        b.valor";
        //print($query);
        $ps = $mysql->prepare( $query );
        $result = $ps->execute( $data );
        if ($result === true) {
            $results = $ps->fetchAll();
            foreach ($results as $result) {
                /*
                $cardapio = [
                    'empresa' => $empresa,
                    'cardapio' => []
                ];
                */
                $id = $result['idProduto'];
                $categoria = $result['nomeCategoria'];
                $produto = $result['nomeProduto'];
                $valor = floatval($result['valor']);
                $descricao = $result['descricao'];
                $quantidade = $result['quantidade'];
                // -
                if (!isSet($cardapio['cardapio'][$categoria])) {
                    $cardapio['cardapio'][$categoria] = [];
                }
                // -
                $cardapio['cardapio'][$categoria][] = [
                    'quantidade' => $quantidade,
                    'descricao' => $descricao,
                    'produto' => $produto,
                    'valor' => $valor,
                    'id' => $id
                ];
                $cardapio['ocorrencias'] ++;
            }
        }

        // - obtém mesas
        
        $query = "SELECT
                        b.idMesa,
                        b.codigo,
                        b.lugares,
                        b.descricao
                    FROM
                        empresa e
                            LEFT JOIN
                        funcionario f
                            ON (
                                e.idEmpresa = f.idEmpresa
                            )
                            LEFT JOIN
                        mesa b
                            ON (
                                f.idFuncionario = b.idFuncionario
                            )
                            
                    WHERE
                        e.idEmpresa = ?
                        AND
                        b.idMesa NOT IN (
                            SELECT
                                idMesa
                            FROM
                                pedido
                            WHERE
                                situacaoPedido NOT IN ('Solicitado', 'Em produção', 'Entregue')
                        )
                    ORDER BY
                        b.codigo, b.lugares";
        $ps = $mysql->prepare( $query );
        $result = $ps->execute( $data );
        if ($result === true) {
            $results = $ps->fetchAll();
            foreach ($results as $result) {
                $id = $result['idMesa'];
                $codigo = $result['codigo'];
                $lugares = $result['lugares'];
                $descricao = $result['descricao'];
                // -
                $cardapio['mesas'][] = [
                    'descricao' => $descricao,
                    'lugares' => $lugares,
                    'codigo' => $codigo,
                    'id' => $id
                ];
            }
        }

    }
    catch (Exception $e) {
        print("$query<br><pre>");
        print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
        print("<strong>StackTrace</strong>:<pre>");
        print($e->getTraceAsString());
        print("</pre>");
    }

    print(json_encode($cardapio));
?>