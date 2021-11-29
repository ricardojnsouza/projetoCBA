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

    // [ campos => ['a','b','c'], tabela => 'nome_da_tabela' ] //
    



    //print_r($post);

    if (isSet($post['campos']) && isSet($post['tabela'])) {

        // ////////////////// //
        // BLOCO DE VALIDAÇÃO //
        // ////////////////// //

        $campos = [];
        $tabela = $post['tabela'];
        // - verificação dos tipos de campos da tabela...
        $sql = "SELECT * FROM $tabela WHERE 1 = 0";
        $result = null;
        try {
            $result = $mysql->query($sql);
        }
        catch (Exception $e) {
            print("$sql<br><pre>");
            print("</pre>Falha ao consultar dados em <font color='red'>empresa</font>: '" . $e->getMessage() . "'<br>");
            print("<strong>StackTrace</strong>:<pre>");
            print($e->getTraceAsString());
            print("</pre>");
        }
        // -
        $col_count = $result->columnCount();
        if ($col_count > 0) {
            
            // - variaveis de controle para saber como aplicar o filtro corretamente!
            $idFuncionario = false;
            $idEmpresa = false;

            // - de-para
            $de_para = [];
            switch ($tabela) {
                case "produto":
                    $de_para = [
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
                    ];
                    break;
                case "adicionais":
                    $de_para = [
                        'idadicional'               => "idAdicional",
                        'idfuncionario'             => "idFuncionario",
                        'inputnomeadicional'        => "nome",
                        'inputquantidadeadicional'  => "quantidade",
                        'inputdescricaoadicional'   => "descricao"
                    ];
                    break;
                case "ingredientes":
                    $de_para = [
                        'idingrediente'                     => "idIngrediente",
                        'idfuncionario'                     => "idFuncionario",
                        'inputnomeingrediente'              => "nomeIngredientes",
                        'inputquantidadeingrediente'        => "quantidadeIngredientes",
                        'inputdataentradaingrediente'       => "dataEntrada",
                        'inputdatavencimentoingrediente'    => "dataValidade",
                        'inputunidadequantidadeingrediente' => "unidadeQuantidade"
                    ];
                    break;
                case "categoria":
                    $de_para = [
                        'idcategoria'               => "idCategoria",
                        'idfuncionario'             => "idFuncionario",
                        'inputcategorianome'        => "nomeCategoria",
                        'inputcategoriadescricao'   => "descricaoCategoria",
                    ];
                    break;
                case "mesa":
                    $de_para = [
                        'idmesa'                        => "idMesa",
                        'idfuncionario'                 => "idFuncionario",
                        'inputmesascadeirascodigo'      => "codigo",
                        'inputmesascadeiraquantidade'   => "lugares",
                        'inputmesasdescricao'           => "descricao"
                    ];
                    break;
                case "funcionario":
                    $de_para = [
                        'idFuncionario'     => "idFuncionario",
                        'inputUserFuncao'   => "idFuncao",
                        'idEmpresa'         => "idEmpresa",
                        'inputUserName'     => "nomeFuncionario",
                        'inputUserEmail'    => "emailFuncionario",
                        'inputUserPassword' => "senhaFuncionario",
                        'inputUserLogin'    => "loginFuncionario",
                        'bloqueado'         => "bloqueado",
                        'inicio_bloqueio'   => "inicio_bloqueio",
                        'inputUserCel'      => "telefone"
                    ];
                    $de_para = array_change_key_case($de_para, CASE_LOWER);
                    break;
            }
            

            // - passa por cada campo enviado pelo front
            foreach ($post['campos'] as $campo) {
                $campo = strtolower($campo);
                $campo = array_key_exists($campo, $de_para) ? strtolower($de_para[$campo]) : $campo;
                // - passa por cada campo obtido pelo metadata direto da estrutura da tabela, 
                // com objetivo de validar os campos e descartar eventuais campos inválidos
                for ($i = 0; $i < $col_count; $i++) {
                    $metadata = $result->getColumnMeta($i);
                    $metadata['name'] = strtolower($metadata['name']);
                    if ($metadata['name'] === $campo && strpos($campo, "senha") === false) {
                        $campos[] = $metadata['name'];
                    }
                    // -
                    if ($metadata['name'] == "idfuncionario") {
                        $idFuncionario = true;
                    }
                    if ($metadata['name'] == "idempresa") {
                        $idEmpresa = true;
                    }
                }
            }
            if (count($campos) > 0) {
                // - consulta definitiva... 
                // SELECT a, b, c FROM tabela WHERE idfuncionario = xpto OR idempresa IN (select idempresa from empresa where idfuncionario = xpto)
                // SELECT a, b, c FROM tabela WHERE idfuncionario = xpto
                $sql  = "SELECT " . implode(",", $campos) . " FROM $tabela WHERE ";
                $sql .= ($idFuncionario && $idEmpresa ? "idfuncionario = ? OR idempresa IN (SELECT idEmpresa FROM empresa WHERE idFuncionario = ?)" : "idfuncionario = ? OR idfuncionario = ? OR idfuncionario = 0");
                // -
                //print($sql."<br>".$user['idusuario']."<br>");
                try {
                    $ps = $mysql->prepare($sql);
                    $result = $ps->execute([ $user['idusuario'], $user['idusuario'] ]);
                }
                catch (Exception $e) {
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>empresa</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                }
                // -
                if ($result === true) {
                    $results = $ps->fetchAll();
                    $saida = [];
                    $de_para = array_change_key_case(array_flip($de_para), CASE_LOWER);
                    foreach ($results as $reg) {
                        $row = [];
                        foreach ($reg as $col => $val) {
                            if (!is_numeric($col)) {
                                $col = array_key_exists($col, $de_para) ? strtolower($de_para[$col]) : $col;
                                $row[$col] = $val;
                            }
                        }
                        $saida[] = $row;
                    }
                }
                // -
                die("1," . json_encode($saida));
            }
        }
    }
    else {
        die("0,Parâmetros inválidos!");
    }


    //print_r($GLOBALS['mysql']);
    // 1,mensagem de sucesso
    // 0,mensagem de erro
?>