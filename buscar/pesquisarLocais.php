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

    //$conexao = $GLOBALS['mysql'];
    //print_r($user);

    $post = array_change_key_case($_POST, CASE_LOWER);

    //print_r($post);

    $de_para = [
        'cafe'  => "CF", 
        'bar'   => "BA", 
        'praia' => "QP"
    ];

    $resultados = [
        'status' => 1,
        'ocorrencias' => 0,
        'empresas' => []
    ];

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
        $parametro = $post['parametro'] ?? "";
        $segmento = $post['segmento'] ?? "";
        $segmento = array_key_exists($segmento, $de_para) ? $de_para[$segmento] : "";

        // =

        $parametro = "%".str_replace(" ", "_", $parametro)."%";
        // -
        $data = [ $segmento ];
        for ($i = 0; $i < 7; $i ++) {
            $data[] = $parametro;
        }
        // -
        $query = "SELECT 
                    idEmpresa, 
                    nomeEmpresa,
                    lat,
                    lng
                FROM 
                    empresa 
                WHERE 
                    segmento IN (?)
                    AND 
                    (
                        nomeEmpresa LIKE ?
                        OR 
                        razao_social LIKE ?
                        OR 
                        enderecoEmpresa LIKE ? 
                        OR 
                        bairro LIKE ? 
                        OR 
                        uf LIKE ? 
                        OR 
                        idEmpresa IN (
                            SELECT 
                                idEmpresa 
                            FROM 
                                funcionario 
                            WHERE 
                                idFuncionario IN (
                                    SELECT
                                        idFuncionario
                                    FROM
                                        produto
                                    WHERE
                                        quantidade > 0
                                        AND 
                                        disponibilidade > 0 
                                        AND 
                                        (
                                            nomeProduto LIKE ? 
                                            OR 
                                            descricao LIKE ?
                                        )
                                )
                        )
                    )";
        $ps = $mysql->prepare( $query );
        $result = $ps->execute( $data );
        if ($result === true) {
            $results = $ps->fetchAll();
            foreach ($results as $result) {
                if (!empty($result['lat']) && !empty($result['lng'])) {
                    $resultados['ocorrencias'] ++;
                    $resultados['empresas'][$result['idEmpresa']] = [
                        'nome' => $result['nomeEmpresa'],
                        'lat' => doubleval($result['lat']),
                        'lng' => doubleval($result['lng'])
                    ];
                }
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
    // =
    print(json_encode($resultados));
?>