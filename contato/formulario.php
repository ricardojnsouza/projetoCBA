<!--
<div class="container">
    <div class="row">
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
        <div class="col-xxl-6 col-xl-8 col-lg-8 align-self-center">
        -->
<div class="container">
    <div class="col-12 bg-light-- p-5 rounded mx-auto d-block">
        <p class="text-center fs-1">Contato</p>
    </div>
    <div class="col-12 bg-light shadow p-5 mb-5">

        <p>Morbi vulputate est ac commodo vulputate. Fusce est est, rutrum sit amet turpis vitae, faucibus ultricies magna. Quisque venenatis magna congue, tincidunt sem in, iaculis tortor. Ut tincidunt turpis nunc, in eleifend erat faucibus sed. Quisque consectetur dui est, et mollis nunc facilisis id. Quisque sed cursus ligula, quis aliquam odio. Aliquam vestibulum nibh lorem, id sodales mi imperdiet sed.</p>
        <form method="post">
            <div class="form-floating mb-3">
                <input type="text" name="nome" class="form-control" id="field-nome" placeholder="Digite aqui seu nome" value="<?php print($post['nome'] ?? "") ?>">
                <label for="field-nome">Nome</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="field-email" value="<?php print($post['email'] ?? "") ?>" placeholder="Digite aqui seu email, no formato: email@dominio.com.br">
                <label for="field-email">E-mail</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="assunto" class="form-control" id="nome-assunto" value="<?php print($post['assunto'] ?? "") ?>" placeholder="Digite aqui o assunto da sua mensagem">
                <label for="field-assunto">Assunto</label>
            </div>
            <div class="form-floating mb-3">
                <textarea name="mensagem" class="form-control" id="field-mensagem" style='height: 200px;'><?php print(empty($post['mensagem'] ?? "Digite aqui sua mensagem") ? "Digite aqui sua mensagem" : $post['mensagem'] ?? "Digite aqui sua mensagem") ?></textarea>
                <label for="field-mensagem">Mensagem</label>
            </div>
            <div class="mb-0 text-center">
                <button type="submit" class="btn btn-dark">Enviar</button>
            </div>
        </form>

    </div>
</div>