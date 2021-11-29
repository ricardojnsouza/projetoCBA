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


    //print_r($post);

    if (isSet($post['id'])) {
        switch(strtolower($post['id'])) {
            case "addprodutosmodal":
                $data = json_decode($post['data'], true);
                // - de-para
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
                // - campos obrigatórios
                $obrigatorios = [
                    'inputnomeproduto'        => "Nome",
                    'inputquantidadeproduto'  => "Quantidade",
                    'inputvalorproduto'       => "Valor"
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
                    $data['ativos'][$i]['inputdisponibilidadeproduto'] = empty($item['inputdisponibilidadeproduto']) ? 0 : 1;
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    
                    $item['idfuncionario'] = $user['idusuario'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idproduto", $item) && intval($item['idproduto']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO produto ({0}) VALUES ({1})";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idproduto") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE produto SET {0} WHERE idproduto = ?";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idproduto") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idproduto'
                        $values[] = $item['idproduto'];
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
                    $sql = "DELETE FROM produto WHERE idproduto = ?";
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

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Adicionais salvas com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>adicionais</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addadicionaismodal":
                $data = json_decode($post['data'], true);
                // - de-para
                $de_para = [
                    'idadicional'               => "idAdicional",
                    'idfuncionario'             => "idFuncionario",
                    'inputnomeadicional'        => "nome",
                    'inputquantidadeadicional'  => "quantidade",
                    'inputdescricaoadicional'   => "descricao"
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputnomeadicional'        => "Nome",
                    'inputquantidadeadicional'  => "Quantidade"
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
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    
                    $item['idfuncionario'] = $user['idusuario'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idadicional", $item) && intval($item['idadicional']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO adicionais ({0}) VALUES ({1})";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idadicional") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE adicionais SET {0} WHERE idadicional = ?";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idadicional") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idadicional'
                        $values[] = $item['idadicional'];
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
                    $sql = "DELETE FROM adicionais WHERE idadicional = ?";
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

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Adicionais salvas com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>adicionais</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addingredientesmodal":
                $data = json_decode($post['data'], true);
                // - de-para
                //['idIngrediente','idFuncionario','inputNomeIngrediente', 'inputQuantidadeIngrediente', 'inputDataEntradaIngrediente', 'inputDataVencimentoIngrediente', 'inputUnidadeQuantidadeIngrediente']
                $de_para = [
                    'idingrediente'                     => "idIngrediente",
                    'idfuncionario'                     => "idFuncionario",
                    'inputnomeingrediente'              => "nomeIngredientes",
                    'inputquantidadeingrediente'        => "quantidadeIngredientes",
                    'inputdataentradaingrediente'       => "dataEntrada",
                    'inputdatavencimentoingrediente'    => "dataValidade",
                    'inputunidadequantidadeingrediente' => "unidadeQuantidade"
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputnomeingrediente'             => "Nome",
                    'inputquantidadeingrediente'       => "Quantidade"
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
                    // datas
                    if (!empty($item['inputdataentradaingrediente'])) {
                        $dt = $item['inputdataentradaingrediente'];
                        if (isDatetimeValid($dt, false, "d/m/Y")) {
                            $dt = CtoD($item['inputdataentradaingrediente']);
                            $data['ativos'][$i]['inputdataentradaingrediente'] = $dt;
                        }
                        else {
                            die("0,Data de entrada inválida!");
                        }
                    }
                    if (!empty($item['inputdatavencimentoingrediente'])) {
                        $dt = $item['inputdatavencimentoingrediente'];
                        if (isDatetimeValid($dt, false, "d/m/Y")) {
                            $dt = CtoD($item['inputdatavencimentoingrediente']);
                            $data['ativos'][$i]['inputdatavencimentoingrediente'] = $dt;
                        }
                        else {
                            die("0,Data de vencimento inválida!");
                        }
                    }
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    
                    $item['idfuncionario'] = $user['idusuario'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idingrediente", $item) && intval($item['idingrediente']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO ingredientes ({0}) VALUES ({1})";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idingrediente") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE ingredientes SET {0} WHERE idingrediente = ?";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idingrediente") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idingrediente'
                        $values[] = $item['idingrediente'];
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
                    $sql = "DELETE FROM ingredientes WHERE idingrediente = ?";
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

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Ingredientes salvas com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>ingredientes</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addcategoriasmodal":
                $data = json_decode($post['data'], true);
                // - de-para
                //campos: ['idCategoria','idFuncionario','inputCategoriaNome', 'inputCategoriaDescricao']
                $de_para = [
                    'idcategoria'                   => "idCategoria",
                    'idfuncionario'                 => "idFuncionario",
                    'inputcategorianome'            => "nomeCategoria",
                    'inputcategoriadescricao'       => "descricaoCategoria"
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputcategorianome'            => "Nome",
                    'inputcategoriadescricao'       => "Descrição",
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
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $item) {
                    $item = array_change_key_case($item, CASE_LOWER);
                    
                    $item['idfuncionario'] = $user['idusuario'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idcategoria", $item) && intval($item['idcategoria']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO categoria ({0}) VALUES ({1})";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idcategoria") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE categoria SET {0} WHERE idcategoria = ?";
                        foreach ($item as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idcategoria") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idcategoria'
                        $values[] = $item['idcategoria'];
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
                    $sql = "DELETE FROM categoria WHERE idcategoria = ?";
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

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Categorias salvas com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>categoria</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addmesasmodal":
                $data = json_decode($post['data'], true);
                // - de-para
                $de_para = [
                    'idmesa'                        => "idMesa",
                    'idfuncionario'                 => "idFuncionario",
                    'inputmesascadeirascodigo'      => "codigo",
                    'inputmesascadeiraquantidade'   => "lugares",
                    'inputmesasdescricao'           => "descricao"
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputmesascadeirascodigo'      => "Codigo",
                    'inputmesascadeiraquantidade'   => "Nº de Lugares",
                ];

                // = críticas
                $criticas = [];
                // - itera pelos dados de cda funcionário enviado para o backend (apenas para críticas!)
                foreach ($data['ativos'] as $i => $mesa) {
                    $mesa = array_change_key_case($mesa, CASE_LOWER);
                    // -
                    foreach ($obrigatorios as $j => $campo) {
                        if (!isSet($mesa[$j]) || empty($mesa[$j]) || $mesa[$j] == "Escolha..." || $mesa[$j] == "Selecione...") {
                            if (!isSet($criticas[0])) {
                                $criticas[0] = [];
                            }
                            $criticas[0][] = ($i + 1) . "-" . $campo;
                        }
                    }
                    if (isSet($criticas[0])) {
                        die("0,Os campos a seguir não foram preenchidos: " . implode(", ", $criticas[0]));
                    }
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $mesa) {
                    $mesa = array_change_key_case($mesa, CASE_LOWER);
                    
                    $mesa['idfuncionario'] = $user['idusuario'];

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idmesa", $mesa) && intval($mesa['idmesa']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO mesa ({0}) VALUES ({1})";
                        foreach ($mesa as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idmesa") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE mesa SET {0} WHERE idmesa = ?";
                        foreach ($mesa as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idmesa") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idmesa'
                        $values[] = $mesa['idmesa'];
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
                    $sql = "DELETE FROM mesa WHERE idmesa = ?";
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

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Mesas salvas com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addfuncionariosmodal":
                $data = json_decode($post['data'], true);
                // - de-para
                $de_para = [
                    'idfuncionario'     => "idFuncionario",
                    'inputuserfuncao'   => "idFuncao",
                    'idempresa'         => "idEmpresa",
                    'inputusername'     => "nomeFuncionario",
                    'inputuseremail'    => "emailFuncionario",
                    'inputuserpassword' => "senhaFuncionario",
                    'inputuserlogin'    => "loginFuncionario",
                    'bloqueado'         => "bloqueado",
                    'inicio_bloqueio'   => "inicio_bloqueio",
                    'inputusercel'      => "telefone"
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputuserfuncao'   => "Função",
                    'inputusername'     => "Nome",
                    'inputuseremail'    => "E-mail"
                ];

                // = críticas
                $criticas = [];
                // - itera pelos dados de cda funcionário enviado para o backend (apenas para críticas!)
                foreach ($data['ativos'] as $i => $funcionario) {
                    $funcionario = array_change_key_case($funcionario, CASE_LOWER);
                    // -
                    foreach ($obrigatorios as $j => $campo) {
                        if (!isSet($funcionario[$j]) || empty($funcionario[$j]) || $funcionario[$j] == "Escolha..." || $funcionario[$j] == "Selecione...") {
                            if (!isSet($criticas[0])) {
                                $criticas[0] = [];
                            }
                            $criticas[0][] = ($i + 1) . "-" . $campo;
                        }
                    }
                    if (isSet($criticas[0])) {
                        die("0,Os campos a seguir não foram preenchidos: " . implode(", ", $criticas[0]));
                    }
                }

                
                $commands = [];
                // = prepara comandos para [insert's] ou [update's]
                foreach ($data['ativos'] as $i => $funcionario) {
                    $funcionario = array_change_key_case($funcionario, CASE_LOWER);
                    
                    // - adiciona obrigatoriamente o campo 'idEmpreesa'
                    $sql = "SELECT idempresa FROM empresa WHERE idfuncionario = ?";
                    try {
                        $ps = $mysql->prepare($sql);
                        $result = $ps->execute([ $user['idusuario'] ]);
                    }
                    catch (Exception $e) {
                        print("$sql<br><pre>");
                        print("</pre>Falha ao consultar dados em <font color='red'>empresa</font>: '" . $e->getMessage() . "'<br>");
                        print("<strong>StackTrace</strong>:<pre>");
                        print($e->getTraceAsString());
                        print("</pre>");
                        die();
                    }
                    // -
                    if ($result === true) {
                        $results = $ps->fetchAll();
                        foreach ($results as $result) {
                            $funcionario['idempresa'] = $result['idempresa'];
                        }
                    }

                    // - define se tratamos de uma inserção ou atualização!
                    $tipo = array_key_exists("idfuncionario", $funcionario) && intval($funcionario['idfuncionario']) > 0 ? "update" : "insert";

                    $fields = [];
                    $places = [];
                    $values = [];

                    // -> insert (ignorando a PK)
                    if ($tipo == "insert") {
                        $sql = "INSERT INTO funcionario ({0}) VALUES ({1})";
                        foreach ($funcionario as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idfuncionario") {
                                $fields[] = $de_para[$field];
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
                        $sql = "UPDATE funcionario SET {0} WHERE idfuncionario = ?";
                        foreach ($funcionario as $field => $value) {
                            // - o campo deve existir no DE-PARA
                            if (isSet($de_para[$field]) && strtolower($de_para[$field]) !== "idfuncionario") {
                                $fields[] = $de_para[$field] . " = ?";
                                $values[] = $value;
                            }
                        }
                        // - adiciona obrigatoriamente o campo 'idFuncionario'
                        $values[] = $funcionario['idfuncionario'];
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
                    $sql = "DELETE FROM funcionario WHERE idfuncionario = ?";
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

                        // - pós INSERT!

                        if (substr($sql, 0, 6) === "INSERT") {

                            // - ultimo id gerado
                            $id = $mysql->getLastInsertID();
                            $pass = null;

                            // - obtem a senha sem criptografia.
                            $sql = "SELECT senhaFuncionario FROM funcionario WHERE idfuncionario = ?";
                            $ps = $mysql->prepare( $sql );
                            $result = $ps->execute( [ $id ] );
                            if ($result === true) {
                                $results = $ps->fetchAll();
                                foreach ($results as $result) {
                                    $pass = hash("sha256", $result['senhaFuncionario']);
                                }
                            }

                            // - aplica a senha com criptografia.
                            $sql = "UPDATE funcionario SET senhaFuncionario = ? WHERE idfuncionario = ?";
                            $ps = $mysql->prepare( $sql );
                            $result = $ps->execute( [ $pass, $id ] );

                        }
                    }

                    // - commit
                    if ($conn !== false) {
                        //$conn->rollBack();
                        $conn->commit();
                        die("1,Funcionários salvos com sucesso!");
                    }
                }
                catch (Exception $e) {
                    if ($conn !== false) {
                        $conn->rollBack();
                    }
                    print("$sql<br><pre>");
                    print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
                    print("<strong>StackTrace</strong>:<pre>");
                    print($e->getTraceAsString());
                    print("</pre>");
                    die();
                }
                print_r($commands);
                break;
            case "addempresamodal":
                // - de-para
                $de_para = [
                    'inputempcpfcnpj'       => "cpf_cnpj",
                    'inputempsegmento'      => "segmento",
                    'inputempnomefantasia'  => "nomeEmpresa",
                    'inputemprazaosocial'   => "razao_social",
                    'inputempendereco'      => "enderecoEmpresa",
                    'inputempbairro'        => "bairro",
                    'inputempcidade'        => "municipio",
                    'inputempestado'        => "uf",
                    'inputempcep'           => "cep",
                    'inputempcel'           => "celular",
                    'inputempemail'         => "email",
                    'inputemplat'           => "lat",
                    'inputemplng'           => "lng",
                ];
                // - campos obrigatórios
                $obrigatorios = [
                    'inputempcpfcnpj'       => "CPF/CNPJ", 
                    'inputempsegmento'      => "Segmento", 
                    'inputempnomefantasia'  => "Nome Fantasia", 
                    'inputemprazaosocial'   => "Razão Social", 
                    'inputempendereco'      => "Endereço", 
                    'inputempbairro'        => "Bairro", 
                    'inputempcidade'        => "Cidade", 
                    'inputempestado'        => "Estado", 
                    'inputempcep'           => "Cep", 
                    'inputempcel'           => "Celular", 
                    'inputempemail'         => "E-mail",
                    'inputemplat'           => "Coordenadas não definidas!"
                ];

                // = criticas
                $criticas = [];
                foreach ($obrigatorios as $i => $campo) {
                    if (!isSet($post[$i]) || empty($post[$i]) || $post[$i] == "Escolha...") {
                        if (!isSet($criticas[0])) {
                            $criticas[0] = [];
                        }
                        $criticas[0][] = $campo;
                    }
                }
                if (isSet($criticas[0])) {
                    die("0,Os campos a seguir não foram preenchidos: " . implode(", ", $criticas[0]));
                }

                // - seguindo sem críticas
                $tipo = "insert";
                $result = null;
                // => conferindo se já existe registro na tabela empresa para o respectivo usuário logado!
                $sql = "SELECT idfuncionario FROM empresa WHERE idfuncionario = ?";
                try {
                    $ps = $mysql->prepare($sql);
                    $result = $ps->execute([ $user['idusuario'] ]);
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
                    if (count($results) > 0) {
                        $tipo = "update";
                    }
                    // - converte o usuário em funcionário administrador / necessário para validar algumas FK's!
                    else {
                        $sql = "INSERT INTO funcionario (idFuncionario,idFuncao,idEmpresa,nomeFuncionario,emailFuncionario,senhaFuncionario) SELECT idUsuario,0,0,nomeUsuario,emailUsuario,senhaUsuario FROM usuario WHERE idUsuario = ? AND idUsuario NOT IN (SELECT idFuncionario FROM funcionario)";
                        try {
                            $ps = $mysql->prepare($sql);
                            $result = $ps->execute([ $user['idusuario'] ]);
                        }
                        catch (Exception $e) {
                            print("$sql<br><pre>");
                            print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
                            print("<strong>StackTrace</strong>:<pre>");
                            print($e->getTraceAsString());
                            print("</pre>");
                        }
                    }
                }
                // -
                $sql = null;
                $values = [];
                // - insert
                if ($tipo == "insert") {
                    $sql = "INSERT INTO empresa ({0}) VALUES ({1})";
                    $fields = ['idfuncionario'];
                    $places = ['?'];
                    $values = [$user['idusuario']];
                    foreach ($post as $field => $value) {
                        // - o campo deve existir no DE-PARA
                        if (isSet($de_para[$field])) {
                            $fields[] = $de_para[$field];
                            $places[] = "?";
                            $values[] = $value;
                        }
                    }
                    $sql = str_replace("{0}", implode(",", $fields), $sql);
                    $sql = str_replace("{1}", implode(",", $places), $sql);
                }
                else {
                    $sql = "UPDATE empresa SET {0} WHERE idfuncionario = ?";
                    foreach ($post as $field => $value) {
                        // - o campo deve existir no DE-PARA
                        if (isSet($de_para[$field])) {
                            $fields[] = $de_para[$field] . " = ?";
                            $values[] = $value;
                        }
                    }
                    $values[] = $user['idusuario'];
                    $sql = str_replace("{0}", implode(",", $fields), $sql);
                }
                // - executa o insert/update
                if (!empty($sql) && !empty($values)) {
                    try {
                        $ps = $mysql->prepare($sql);
                        $result = $ps->execute($values);
                        die("1,Empresa salva com sucesso!");
                    }
                    catch (Exception $e) {
                        die("0,Erro ao salvar os dados da empresa: ".$e->getMessage());
                    }
                }
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