<?php
    /*
    session_start();

    include_once '../assets/config.php';
    include_once '../assets/funcoes.php';
    include_once '../assets/classes/conexao.php';
    */
    if (!isSet($_SESSION) || !isSet($_SESSION['auth_token'])) {
        die("0,Sessão inválida!");
    }
    $user = getUserByToken($_SESSION['auth_token']);
    if (empty($user)) {
        die("0,Usuário inválido");
    }

    $id = $_GET['id'] ?? 0;

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
                    idPedido = ?
                    AND
                    idUsuario = ?";
        $data = [ $id, $user['idusuario'] ];
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
                    'items'      => [],
                    'pagamentos' => []
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
                $data = [ $id ];
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

                // - obtem os dados do pagamento
                $sql = "SELECT
                            idPagamento,
                            valorPago,
                            formaPagamento
                        FROM
                            pagamentos
                        WHERE 
                            idPedido = ?";
                $data = [ $id ];
                // -
                $ps_C = $mysql->prepare( $sql );
                $result_C = $ps_C->execute( $data );
                // -
                if ($result_C === true) {
                    $results_C = $ps_C->fetchAll();
                    foreach ($results_C as $result_C) {
                        $pagamento = [
                            'id'           => $result_C['idPagamento'],
                            'valor'        => $result_C['valorPago'],
                            'forma'        => $result_C['formaPagamento']
                        ];
                        // -
                        $pedido['pagamentos'][] = $pagamento;
                    }
                }
            }
        }
        //print("<pre>");
        //print_r($pedido);
        //print("</pre>");
    }
    catch (Exception $e) {
        $pedido['status'] = 0;
        print("$query<br><pre>");
        print("</pre>Falha ao consultar dados em <font color='red'>funcionario</font>: '" . $e->getMessage() . "'<br>");
        print("<strong>StackTrace</strong>:<pre>");
        print($e->getTraceAsString());
        print("</pre>");
    }
?>

<div class="container">
    <div class="col-12 bg-light-- p-5 rounded mx-auto d-block">
        <p class="text-center fs-1">Pedido <?php print(sprintf('#<strong>%05d</strong>', $pedido['id']) . " <sup>(" . $pedido['situacao'] . ")</sup>"); ?></p>
    </div>

    <div class="col-12 bg-light shadow p-5 mb-5">
        
        <input type='hidden' id='id_pedido' value="<?php print($pedido['id']); ?>">
        <input type='hidden' id='valor_pedido' value="<?php print($pedido['subtotal']); ?>">

        <div class="accordion --accordion-flush" id="accordionFlushExample">
            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Produtos
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <ul class="list-group m-2">
                                <?php
                                    foreach ($pedido['items'] as $item) {
                                        print(
                                            "<li class='list-group-item'>
                                                <div class='d-flex justify-content-between'>
                                                    <div class='d-flex align-items-center text-truncate'>
                                                        ".$item['produto']."&nbsp;<sup>(x".$item['quantidade'].")</sup>
                                                    </div>
                                                    <div class='d-flex justify-content-around'>
                                                        <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                                            ".$item['valor']."
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>"
                                        );
                                    }
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button --bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Mesa
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="flush-headingTwo" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <ul class="list-group m-2">
                                <?php
                                    $mesas = $mysql->getQueryData("SELECT codigo, descricao, lugares FROM mesa WHERE idMesa = " . $pedido['id_mesa']);
                                    foreach ($mesas as $mesa) {
                                        print(
                                            "<li class='list-group-item'>
                                                <div class='d-flex justify-content-between'>
                                                    <div class='d-flex align-items-center text-truncate'>
                                                        ".$mesa['codigo']."&nbsp;<sup>(".$mesa['lugares']." lugares)</sup>
                                                    </div>
                                                    <div class='d-flex justify-content-around'>
                                                        <div class='item-value   d-flex align-items-center float-end text-nowrap' style='width: 80px;justify-content: end;'>
                                                            ".$mesa['descricao']."
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>"
                                        );
                                    }
                                ?>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>

            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Observações
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse show" aria-labelledby="flush-headingThree" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <ul class="list-group m-2">
                                <?php print("<li class='list-group-item'>".(empty($pedido['observacao']) ? "- SEM OBSERVAÇÕES -" : $pedido['observacao'])."</li>"); ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="p-3 mt-2 bg-secondary text-dark rounded d-flex justify-content-between text-white">
            <div class='text-nowrap'>
                <?php
                    $items = count($pedido['items']);
                    print($items > 1 ? "SUBTOTAL (<strong>$items</strong> ÍTEMS)" : "SUBTOTAL:");
                ?>
            </div>
            <div class='text-nowrap'>
                <?php
                    print($pedido['subtotal']);
                ?>
            </div>
        </div>

        <div class="mt-3 d-flex flex-row-reverse">
        <?php
            if (!in_array($pedido['situacao'], ['Cancelado', 'Pago'])) {
                print('<button type="button" class="btn btn-primary" id="pedido_pagamento"  data-bs-toggle="modal" data-bs-target="#addPagamentosModal">Efetuar Pagamento</button>');
            }
            if (in_array($pedido['situacao'], ['Solicitado'])) {
                print('<button type="button" class="btn bg-danger text-white --btn-secondary me-2" id="pedido_cancelar" data-bs-toggle="modal" data-bs-target="#cancelar_pedido">Cancelar Pedido</button>');
            }

        ?>
        </div>

    </div>
</div>


<div class="modal" id="cancelar_pedido" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cancelar Pedido</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Deseja realmente cancelar o pedido <?php print(sprintf('#<strong>%05d</strong>', $pedido['id']) . " <sup>(" . $pedido['situacao'] . ")</sup>"); ?></p>
        <p><strong class="text-danger">OBS.:</strong> <span class="fw-lighter">Apenas pedidos com situação: 'Solicitado' podem ser cancelados, caso já tenham sido aceitos pela cozinha não poderão ser cancelados!</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">&nbsp;&nbsp;&nbsp;Sair&nbsp;&nbsp;&nbsp;</button>
        <button type="button" class="btn btn-primary" id="fazer_cancelamento_pedido">Cancelar Pedido</button>
      </div>
    </div>
  </div>
</div>


<div id="addPagamentosModal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pagamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                Confirme os detalhes do seu pedido e entre com a forma de pagamento desejada!
                            </h6>
                        </div>
                    </div>
                    <!-- -->
                    <div class="p-2 bg-light border rounded">
                        <!-- -->
                        <div class="row g-1 mb-4">
                            <div class="col-md">
                                
                            <div class="accordion --accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item bg-transparent">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Produtos
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" --data-bs-parent="#accordionFlushExample">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <ul class="list-group m-2">
                                                    <?php
                                                        foreach ($pedido['items'] as $item) {
                                                            print(
                                                                "<li class='list-group-item'>
                                                                    <div class='d-flex justify-content-between'>
                                                                        <div class='d-flex align-items-center text-truncate'>
                                                                            ".$item['produto']."&nbsp;<sup>(x".$item['quantidade'].")</sup>
                                                                        </div>
                                                                        <div class='d-flex justify-content-around'>
                                                                            <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                                                                ".$item['valor']."
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>"
                                                            );
                                                        }
                                                    ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="accordion-item bg-transparent">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Subtotais
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" --data-bs-parent="#accordionFlushExample">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <ul class="list-group m-2">

                                                    <li class='list-group-item'>
                                                        <div class='d-flex justify-content-between'>
                                                            <div class='d-flex align-items-center text-truncate'>
                                                                TOTAL DO PEDIDO&nbsp;<sup>(<?php print(count($pedido['items']) . (count($pedido['items']) > 1 ? " PRODUTOS" : " PRODUTO")); ?>)</sup>
                                                            </div>
                                                            <div class='d-flex justify-content-around'>
                                                                <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                                                    <?php print($pedido['subtotal']); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class='list-group-item'>
                                                        <div class='d-flex justify-content-between'>
                                                            <div class='d-flex align-items-center text-truncate'>
                                                                PAGAMENTO JÁ REALIZADO</sup>
                                                            </div>
                                                            <div class='d-flex justify-content-around'>
                                                                <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                                                    <?php
                                                                        $valor_pagamento = 0;
                                                                        // -
                                                                        foreach ($pedido['pagamentos'] as $pagamento) {
                                                                            $valor_pagamento += $pagamento['valor'];
                                                                        }
                                                                        // -
                                                                        print($valor_pagamento);
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <li class='list-group-item'>
                                                        <div class='d-flex justify-content-between'>
                                                            <div class='d-flex align-items-center text-truncate'>
                                                                SALDO A PAGAR
                                                            </div>
                                                            <div class='d-flex justify-content-around'>
                                                                <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                                                    <?php 
                                                                        $saldo_pagamento = $pedido['subtotal'] - $valor_pagamento;
                                                                        // -
                                                                        print($saldo_pagamento); 
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>

                            </div>
                        </div>
                        <!-- -->
                        <div class="row g-1 mb-4">
                            <div class="col-md">
                                <div class="list-group mb-1 shadow" id='listaPagamentos'>
                                    <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                        <span class='text-white'>Nenhum <strong>pagamento</strong> cadastrado!</span>
                                    </button>
                                </div>

                            </div>
                        </div>
                        <!-- -->
                        <div class="row g-2 mb-2">
                            <div class="col-md-8">
                                <div class="form-floating">
                                    <select id="formapagamento" class="form-select">
                                        <option value='Em Espécie'>Em Espécie</option>
                                        <option value='PIX'>PIX</option>
                                        <option value='Cartão Crédito'>Cartão Débito</option>
                                        <option value='Cartão Crédito'>Cartão Crédito</option>
                                    </select>
                                    <label for="formapagamento">Forma de pagamento</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="valorPago" maxlength="8" data-type="decimal">
                                    <label for="valorPago">Valor</label>
                                </div>
                            </div>
                        </div>
                        <!-- -->
                        <?php
                            if ($saldo_pagamento > 0) {
                                print('
                                    <div class="text-end mb-0 border-top pt-1">
                                        <span class="small float-start text-black-50"><strong>*</strong> <span id="saldo_pagamento"></span></span>
                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addPagamentosModal">Incluir valor</button>
                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addPagamentosModal">Excluir valor</button>
                                    </div>
                                ');
                            }
                        ?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="submit_addPagamentosModal">Confirmar Pagamento</button>
            </div>
        </div>
    </div>
</div>


<div class="sucesso position-fixed bottom-0 end-0 p-3 m-3  toast align-items-center text-white          bg-success           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body" id='toast-sucesso-body'>...</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>


<div class="erro position-fixed bottom-0 end-0 p-3 m-3  toast align-items-center text-white          bg-danger           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body" id='toast-erro-body'>...</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>


<script type='text/javascript'>

    $(document).ready(function(){
        // - ação de cancelamento de pedido (modal de confirmação)
        $("#fazer_cancelamento_pedido").on("click", () => cancelarPedido());

        // - 
        let modais = $("[id*='add'][id*='Modal']")
        modais.each((i, modal) => $("[id]", modal).each((i, componente) => $(componente).attr("name", componente.id)));


        // ~ adicioona a ação de envio dos formulários para o back via ajax.
        modais.find("button[id^='submit']").on("click", function() {
            let id = ((`${this.id}`).indexOf("_") >= 0 ? `${this.id}`.split("_")[1] : null);
            let form = $(this).closest(".modal-content").find("form");
            let data = ((`${this.id}`).indexOf("_") >= 0 ? `id=${(`${this.id}`).split("_")[1]}&` : "");
            switch (id) {
                case "addPagamentosModal":
                    data += "id_pedido=" + $("#id_pedido").val() + "&";
                    data += "data=" + JSON.stringify(window.pagamentosMetadata);
                    break;
                default:
                    data += form.serialize();
            }
            // -
            $.ajax({
                method: "POST",
                url: "pedido/registrarPagamento.php",
                data: data
            })
            .done(function(response) {
                console.log("==> parser.response => ", response)
                //return;
                let i = response.indexOf(",");
                let j = parseInt(response.substring(0, i));
                if (j === 1) {
                    let $toast = $(".toast.sucesso");
                    $toast.find(".toast-body").html(response.substring(i + 1));
                    $toast.toast('show');
                    // - fecha a modal
                    form.closest(".modal").modal('hide');
                    // - atualiza a página!
                    setTimeout(() => location.reload(), 1000);
                }
                else {
                    let $toast = $(".toast.erro");
                    $toast.find(".toast-body").html(response.substring(i + 1));
                    $toast.toast('show');
                }
                //console.log( response );
            });
        });

        modais.on('shown.bs.modal', function() {
            let modal = $(this);

            // - controle do campo 'decimal'
            $("input[data-type='decimal']", modal).off().on("keydown", function(e) {
                switch (e.keyCode) {
                    case 8:
                    case 9:
                    case 48: case 49: case 50: case 51: case 52: case 53: case 54: case 55: case 56: case 57:
                    case 190:
                    case 96: case 97: case 98: case 99: case 100: case 101: case 102: case 103: case 104: case 105:
                    case 110:
                    case 35: case 36:
                    case 37: case 38: case 39: case 40:
                        break;
                    default:
                        e.preventDefault();
                }
            });
            
            let data = window[this.id];
            // -
            $(`a.list-group-item-dark[data-bs-toggle='modal']`).removeClass("list-group-item-dark");
            $(`a[data-bs-toggle='modal'][data-bs-target='#${this.id}']`).addClass("list-group-item-dark");
            // -
            if (data) {
                switch (this.id) {
                    case "addPagamentosModal":
                        obterPagamentos();
                        break;
                }
            }
        });
    });

    function cancelarPedido() {
        $.ajax({
            url: "pedido/cancelarPedido.php",
            data: {
                id: $("#id_pedido").val()
            },
            method: "POST",
            dataType: "json",
            success: (response) => {
                if (response && response.status == 1) {
                    bootstrap.Modal.getInstance($("#cancelar_pedido").get(0)).hide();
            
                    // - exibe o toast (bootstrap) com aviso de sucesso!
                    [].slice.call(document.querySelectorAll('.toast.sucesso')).map((toastEl)  => {
                        document.getElementById("toast-sucesso-body").innerText = response.mensagem;
                        return new bootstrap.Toast(toastEl);
                    }).forEach((toast) => toast.show());

                    setTimeout(() => location.reload(), 1000);
                }
                else {
                    // - exibe o toast (bootstrap) com aviso de erro!
                    [].slice.call(document.querySelectorAll('.toast.erro')).map((toastEl)  => {
                        document.getElementById("toast-erro-body").innerText = response.mensagem;
                        return new bootstrap.Toast(toastEl);
                    }).forEach((toast) => toast.show());
                }
            },
            error: (error, a, b, c) => {
                console.error(error, a, b, c);
            }
        });
    }


    // = PAGAMENTOS = 

    var obterPagamentos = function() {
        console.log("fn.obterPagamentos()");
        if (!window.pagamentosMetadata) {
            window.pagamentosMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addIngredentesModal] => #listaIngredentes => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "pedido/obterPagamentos.php",
            data: {
                tabela: "pagamentos",
                campos: ['idPagamento','idPedido', 'valorPago', 'formaPagamento'],
                id: $("#id_pedido").val()
            }
        })
        .done(function(response) {
            console.log("obterPagamentos => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.pagamentosMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarPagamentos(0);
                carregaPagamento(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarPagamentos = function(id = -1) {
        let $list = $("#listaPagamentos");
        // -
        $list.off().contents().remove();
        // -
        if (window.pagamentosMetadata && window.pagamentosMetadata.ativos && window.pagamentosMetadata.ativos.length > 0) {
            window.pagamentosMetadata.ativos.forEach((pagamento, i) => {
                $list.append(
                    $(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action">
                        <div class='d-flex justify-content-between'>
                            <div class='d-flex align-items-center text-truncate'>
                                <strong>${pagamento.formapagamento || "Forma de pagamento <strong>não definida</strong>"}</strong>        
                            </div>
                            <div class='d-flex justify-content-around'>
                                <div class='item-value   d-flex align-items-center float-end' style='width: 80px;justify-content: end;'>
                                    ${pagamento.valorpago || "0.00"}
                                </div>
                            </div>
                        </div>
                    </button>`)
                );
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary"><span class='text-white'>Nenhum <strong>pagamento</strong> cadastrado!</span></button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaPagamento(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaPagamento(id);
        }
        
        // - adiciona a ação
        $("#add_addPagamentosModal").off().on("click", function() {
            incluirPagamento();
        });
        $("#del_addPagamentosModal").off().on("click", function() {
            excluirPagamento();
        });
    };
    var carregaPagamento = function(id = -1) {
        if (window.pagamentosMetadata && window.pagamentosMetadata.ativos) {
            let pagamento = window.pagamentosMetadata.ativos[id];
            // -
            $("#addPagamentosModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (pagamento) {
                    let forcar = false;
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = pagamento[nome];
                    if ($elemento.attr("type") == "checkbox") {
                        $elemento.prop("checked", valor == 1 ? true : false);
                    }
                    $elemento.val(valor).keydown().prop("disabled", false);
                    if (forcar) {
                        setTimeout(() => $elemento.change(), 100);
                    }
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.pagamentosMetadata && window.pagamentosMetadata.ativos) {
                    let id = parseInt($("#listaPagamentos").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    if ($elemento.attr("type") == "checkbox") {
                        $elemento.val($elemento.is(":checked") ? 1 : 0);
                    }
                    // =
                    let ativo = window.pagamentosMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.pagamentosMetadata.ativos[id] = ativo;
                        // -
                        atualizarPagamentos(id);
                    }
                    // -
                    $("#saldo_pagamento").html(
                        $(`<span>Saldo a pagar R$ ${parseFloat($("#valor_pedido").val()) - window.pagamentosMetadata.ativos.concat([{},{}]).reduce((a, b) => parseFloat(typeof(a) == "object" ? a.valorpago || 0 : a || 0) + parseFloat(b.valorpago || 0))}</span>`)
                    );
                }
            }).keyup();
        }
    };
    var incluirPagamento = function() {
        if (window.pagamentosMetadata && window.pagamentosMetadata.ativos) {
            // -
            window.pagamentosMetadata.ativos.push({
                formapagamento: null,
                valorpago: parseFloat($("#valor_pedido").val()) - window.pagamentosMetadata.ativos.concat([{},{}]).reduce((a, b) => parseFloat(typeof(a) == "object" ? a.valorpago || 0 : a || 0) + parseFloat(b.valorpago || 0))
            });
            
            let max = 0;
            window.pagamentosMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarPagamentos(max);
            carregaPagamento(max);
        }
    };
    var excluirPagamento = function() {
        if (window.pagamentosMetadata && window.pagamentosMetadata.ativos) {
            let ativos = window.pagamentosMetadata.ativos;
            // -
            let i = parseInt($("#listaPagamentos").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idpagamento || -1);
                if (i > 0) {
                    window.pagamentosMetadata.excluidos.push(i);
                }
                // -
                window.pagamentosMetadata.ativos = ativos;
                // -
                atualizarPagamentos();
                $("#addPagamentosModal").find("input,select,textarea").val("");
            }
        }
    };

</script>