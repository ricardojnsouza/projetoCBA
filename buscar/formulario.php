<div class="estabelecimentos position-fixed bottom-0 end-0 p-3 m-3  toast align-items-center text-white          bg-success           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body" id='toast-body'>...</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<div class="erro position-fixed bottom-0 end-0 p-3 m-3  toast align-items-center text-white          bg-danger           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body" id='toast-erro'>...</div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>


<div class="container">
    <div class="col-12 bg-light-- p-5 rounded mx-auto d-block">
        <p class="text-center fs-1">Busca</p>
    </div>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Cafés, Bares & Restaurantes" aria-describedby="pesquisar" id="pesquisar_parametro" style='width: 50vw;'>
        <select class="form-select form-select-sm text-center" aria-label=".form-select-sm example" id="pesquisar_segmento">
            <option selected>Segmento</option>
            <option value="cafe">Cafeterias</option>
            <option value="bar">Bares</option>
            <option value="praia">Barracas de Praia</option>
        </select>
        <button class="btn btn-outline-secondary" type="button" id="pesquisar_button">Pesquisar</button>
    </div>
    <div id="map" class="w-100" style='height: 50vh;'></div>
</div>





<div id='cardapioModal' class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cardapio_empresa">Empresa XPTO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4 class="text-center">Cardápio</h4>
                <div id='cardapio_conteudo'></div>

                <h4 class="text-center mt-3">Mesas</h4>
                <div class="input-group mb-3">
                    <select class="form-select form-select-sm text-center" aria-label=".form-select-sm example" id="cardapio_mesa"></select>
                    <input type="text" class="form-control" placeholder="Selecione uma mesa para prosseguir" aria-describedby="pesquisar" id="cardapio_mesa_descricao" style='width: 25vw;' disabled>
                </div>

                <h4 class="text-center mt-3">Observações</h4>
                <div class="input-group mb-3">
                    <textarea class="form-control" id="cardapio_observacao" rows="3"></textarea>
                </div>
                

                <div class="p-3 mt-2 bg-secondary text-dark rounded d-flex justify-content-between text-white">
                    <div id='subtotal_texto'>SUBTOTAL (0 ÍTEMS SELECIONADOS):</div>
                    <div id='subtotal_valor'>0,00</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cardapio-confirmar">Realizar pedido</button>
            </div>
        </div>
    </div>
</div>






<script async src="https://maps.googleapis.com/maps/api/js?key=<?php print($google_api_key ?? ""); ?>&libraries=places&callback=initMap"></script>
<script type='text/javascript'>
    var map;
    var pos;
    // -
    var markers = [];
    var empresas = [];
    var cardapio = {};
    var mesas = {};

    document.getElementById("pesquisar_segmento").value = "<?php print($get['segmento'] ?? "cafe"); ?>";

    // - define um termo de pesquisa genérico
    document.getElementById("pesquisar_parametro").onkeyup = function(e) {
        if (e && (e.keyCode == 10 || e.keyCode == 13)) {
            pesquisar();
        }
    };

    // - acao para o botao de pesquisa
    document.getElementById("pesquisar_button").onclick = function() {
        removerMarcador(markers);
        setTimeout(() => pesquisar(), 1000);
    };
    
    function initMap() {
        // - inicializa o mapa
        map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: -34.397, lng: 150.644 },
            zoom: 12,
        });

        // - tenta identificar a localização atual.
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude,
                };
                map.setCenter(pos);
                // - põe o marcador de localização atual
                let marker = new google.maps.Marker({
                    position: pos,
                    map: map,
                    title: "Localização atual"
                });

                // - executa a pesquisa
                pesquisar();
                
            }, (error) => console.log("erro ao obter a localização atual! => ", error));
        }
    }

    function pesquisar() {
        // - monta a query para busca por texto
        let segmento = document.getElementById("pesquisar_segmento").value;
        let parametro = document.getElementById("pesquisar_parametro").value;

        // -

        $.ajax({
			'url'		: "buscar/pesquisarLocais.php",
			'method'	: "POST",
			'dataType'	: "json",
			'data'		: {
				'parametro'	: parametro,
				'segmento'	: segmento
			},
			'success'	: (response) => {
                console.log("response => ", response);
                removerMarcador(markers);
                markers = [];
                if (response.ocorrencias > 0) {
                    Object.keys(empresas = response.empresas).forEach((k) => {
                        let empresa = response.empresas[k];
                        // ->
                        let marker = new google.maps.Marker({
                            position: {
                                lat: empresa.lat,
                                lng: empresa.lng,
                            },
                            map: map,
                            title: empresa.nome,
                            icon: {
                                url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                            },
                            // - custom data...
                            idEmpresa: k
                        });
                        marker.addListener("click", function(e) {
                            if (marker.getAnimation() !== null) {
                                marker.setAnimation(null);
                            } else {
                                marker.setAnimation(google.maps.Animation.BOUNCE);
                            }
                            // -
                            if (this && this.idEmpresa) {
                                obterCardapio(this.idEmpresa);
                            }
                        });
                        markers.push(marker);
                        // <-
                        console.log("markers.push ", marker);
                    });
                    if (markers.length > 0) {
                        map.setCenter(markers[0].position);
                    }

                    // - exibe o toast (bootstrap) com o número de estabelecimentos localizadoss
                    [].slice.call(document.querySelectorAll('.toast.estabelecimentos')).map((toastEl)  => {
                        document.getElementById("toast-body").innerText = markers.length + " estabelecimentos localizados";
                        return new bootstrap.Toast(toastEl);
                    }).forEach((toast) => toast.show());
                }
            },
			'error'		: (error, a, b, c) => {
                console.error(error, a, b, c);
            }
		});
    }

    function removerMarcador(marcador) {
        if (Array.isArray(marcador)) {
            marcador.forEach((marker) => {
                // -> recursividade aqui!
                removerMarcador(marker);
            });
        }
        else if (marcador) {
            marcador.setMap(null);
        }
    }

    function obterCardapio(idEmpresa) {
        let modal = new bootstrap.Modal(document.getElementById('cardapioModal'), {});
        // -
        $("#cardapio_empresa").html(empresas[idEmpresa].nome);
        // =
        $.ajax({
			'url'		: "buscar/obterCardapio.php",
			'method'	: "POST",
			'dataType'	: "json",
            //'dataType': "text",
			'data'		: {
                'idEmpresa': idEmpresa
			},
			'success'	: (response) => {
                console.log("response - ", response)
                if (response && response.cardapio && response.ocorrencias > 0) {
                    
                    let $container = $("#cardapio_conteudo");
                    if ($container.length) {
                        $container.contents().off().remove();
                        cardapio = {};
                    }

                    // - monta o acordeon 'base'
                    let $accordion = $(`<div class="accordion" id="accordion_cardapio"></div>`);
                    // -
                    Object.keys(response.cardapio).forEach((categoria, i) => {
                        let produtos = response.cardapio[categoria];
                        // =
                        let $categoria = $(`<div class="accordion-item">
                                                <h2 class="accordion-header" id="heading_${i}">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_${i}" aria-expanded="true" aria-controls="collapse_${i}">
                                                        <strong>${categoria}</strong>
                                                    </button>
                                                </h2>
                                                <div id="collapse_${i}" class="accordion-collapse collapse" aria-labelledby="heading_${i}" data-bs-parent="#accordion_cardapio">
                                                    <div class="accordion-body">
                                                        <ul class="list-group"></ul>
                                                    </div>
                                                </div>
                                            </div>`)
                        if (produtos && produtos.length > 0) {
                            $categoria.find("ul.list-group").each(function(){
                                let $el = $(this);
                                // -
                                produtos.forEach((produto) => {
                                    cardapio[produto.id] = produto;
                                    // -
                                    let $li = $(`<li class="list-group-item" data-id="${produto.id}" data-value="${produto.valor}" data-quantity="0"          data-bs-trigger="focus" data-title="${produto.produto}" data-content="${produto.descricao}">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="d-flex align-items-center text-truncate">
                                                            ${produto.produto}
                                                        </div>
                                                        <div class="d-flex justify-content-around">
                                                            <select class="item-quantity  form-select" aria-label="Default select example" style="width: 67px;">
                                                                <option selected value="0">0</option>
                                                            </select>
                                                            <div class="item-value   d-flex align-items-center float-end" style="width: 80px;justify-content: end;">
                                                                ${toCurrency(produto.valor)}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>`);
                                    // -
                                    let $select = $li.find("select").on("change", function() {
                                        let $el = $(this);
                                        let $li = $el.closest(".list-group-item").data("quantity", $el.val()).attr("data-quantity", $el.val());
                                        $li.find(".item-value").html( toCurrency($li.data("value") * Math.max($li.data("quantity"), 1)) );
                                        // - 
                                        if ($li.data("quantity") > 0) {
                                            $li.addClass("active");
                                        }
                                        else {
                                            $li.removeClass("active");
                                        }
                                        obterPedido(false);
                                    });
                                    // =
                                    for (let i = 1; i <= produto.quantidade; i++) {
                                        $select.append($(`<option value='${i}'>${i}</option>`));
                                    }
                                    // -
                                    $el.append($li);
                                });
                            });
                            // -
                            $accordion.append($categoria);
                        }
                    });
                    let $mesas = $("#cardapio_mesa").off().on("change", function(){
                        let $el = $(this);
                        $("#cardapio_mesa_descricao").val(mesas[$el.val()].descricao);
                        obterPedido(false);
                    });
                    $mesas.contents().remove();
                    $mesas.append($("<option value=''>- SELECIONE -</option>"));
                    if ($mesas.length > 0 && response.mesas.length > 0) {
                        mesas = {};
                        response.mesas.forEach((mesa, i) => {
                            mesas[mesa.id] = mesa;
                            $mesas.append($(`<option value="${mesa.id}">${mesa.codigo} (${mesa.lugares} LUGARES)</option>`));
                        });
                    }
                    // =
                    $container.append($accordion);
                    $container.find(".accordion-collapse").first().addClass("collapse show");
                    /*
                    $container.find(".list-group-item").on("click", function() {
                        let $el = $(this);
                        if ($el.hasClass("active")) {
                            $el.removeClass("active");
                        }
                        else {
                            $el.addClass("active");
                        }
                    });
                    */
                    // -
                    modal.show();
                }
                
            },
			'error'		: (error, a, b, c) => {
                console.error(error, a, b, c);
            }
		});
        // -
        $("#cardapio-confirmar").off().on("click", function() {
            let pedido = obterPedido(true);
            if (pedido) {
                $.ajax({
                    url: "pedido/registrarPedido.php",
                    data: pedido,  
                    method: "POST",
                    dataType: "json",
                    success: (response) => {
                        
                        console.log("response registrarPedido => ", response);

                        if (response && response.status == 1) {
                            bootstrap.Modal.getInstance($("#cardapioModal").get(0)).hide();
                    
                            // - exibe o toast (bootstrap) com aviso de pedido registrado com sucesso!
                            [].slice.call(document.querySelectorAll('.toast.estabelecimentos')).map((toastEl)  => {
                                document.getElementById("toast-body").innerText = `Pedido ${response.id} registrado com sucesso!`;
                                return new bootstrap.Toast(toastEl);
                            }).forEach((toast) => toast.show());

                            // -> pedido.appendIndex.php
                            atualizarPedidosAtivos();
                        }
                    },
                    error: (error, a, b, c) => {
                        console.error(error, a, b, c);
                    }
                });
            }
        });
    }

    function obterPedido(criticar = true) {
        let pedido = {
            items: [],
            mesa: 0,
            subtotal: 0,
            observacao: null,
            situacao: "Solicitado"
        };
        
        // - obtem os ítens inclusos no pedido
        $("#cardapio_conteudo").find("li.list-group-item[data-id][data-value][data-quantity]").each((i, el) => {
            let $el = $(el);
            // -
            if ($el.data("id") > 0 && $el.data("quantity") > 0 && $el.data("value") > 0) {
                pedido.items.push({
                    produto: $el.data("id"),
                    quantidade: $el.data("quantity"),
                    valor: $el.data("value") * $el.data("quantity")
                });
            }
        });

        // - calcula o subtotal do pedido
        pedido.items.forEach((item) => pedido.subtotal += item.valor);

        // - define a mesa
        pedido.mesa = $("#cardapio_mesa").val();

        // - define as observações
        pedido.observacao = $("#cardapio_observacao").val();

        // - plota os dados do pedido nos campos correspondentes...
        $("#subtotal_texto").html($(pedido.items.length > 0 ? `<span>SUBTOTAL (<strong>${pedido.items.length}</strong> ÍTEMS SELECIONADOS):</span>` : `<span>SUBTOTAL (NENHUM ÍTEM SELECIONADO):</span>`));
        $("#subtotal_valor").html($(`<span>${toCurrency(pedido.subtotal)}</span>`));

        // - exibe o toast (bootstrap) com as críticas eventualmente detectadas
        if (criticar) {
            let critica = null;
            if (!pedido.mesa) {
                critica = "Selecione a mesa!";
            }
            if (pedido.items.length == 0) {
                critica = "Nenhum ítem do cardápio foi selecionado!";
            }
            if (critica) {
                [].slice.call(document.querySelectorAll('.toast.erro')).map((toastEl)  => {
                    document.getElementById("toast-erro").innerText = critica;
                    return new bootstrap.Toast(toastEl);
                }).forEach((toast) => toast.show());
                // -
                return null;
            }
        }

        return pedido;
    }


    function toCurrency(valor) {
        return parseFloat(valor).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

</script>


