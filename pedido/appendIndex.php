<script type='text/javascript'>
    
    //alert("atualizarPedidosAtivos");

    function atualizarPedidosAtivos() {
        $.ajax({
            url: "pedido/obterPedidos.php",
            //data: pedido,  
            method: "GET",
            dataType: "json",
            success: (response) => {
                
                console.log("response => ", response);

                if (response && response.status == 1) {
                    let $ul = $("#pedidos_ativos");
                    if ($ul.length) {
                        $ul.contents().remove();
                        if (response.pedidos.length > 0) {
                            response.pedidos.forEach((pedido) => $ul.append($(`<li><a href="?link=pedido&id=${pedido.id}" class="nav-link text-nowrap">Pedido ${("00000" + pedido.id).slice (-5)}</a></li>`)));
                            
                        }
                        else {
                            $ul.append($(`<li><a class="nav-link text-nowrap">Nenhum pedido ativo</a></li>`))
                        }
                    }
                }
                
                /*
                if (response && response.status == 1) {
                    bootstrap.Modal.getInstance($("#cardapioModal").get(0)).hide();
            
                    // - exibe o toast (bootstrap) com aviso de pedido registrado com sucesso!
                    [].slice.call(document.querySelectorAll('.toast.estabelecimentos')).map((toastEl)  => {
                        document.getElementById("toast-body").innerText = `Pedido <strong>${response.id}</strong> registrado com sucesso!`;
                        return new bootstrap.Toast(toastEl);
                    }).forEach((toast) => toast.show());
                }
                */
            },
            error: (error, a, b, c) => {
                console.error(error, a, b, c);
            }
        });
    }
    atualizarPedidosAtivos();
</script>