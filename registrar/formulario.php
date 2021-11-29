<div class="container">
    <div class="row">
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
        <div class="col-xxl-6 col-xl-8 col-lg-8 align-self-center">

            <div class="card m-5 shadow mb-5">
                <img src="assets/imagens/banner-login.jpg" class="card-img-top" alt="...">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link" href="?link=acessar">Acessar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="?link=registrar">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" href="?link=recuperar">Recuperar Acesso</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type='hidden' name='metodo' value='registrar'>
                        <div class="form-floating mb-3">
                            <input type="text" name="nomeUsuario" class="form-control" id="field-nomeUsuario" placeholder="Digite aqui seu nome" value="<?php print($post['nomeusuario'] ?? "") ?>">
                            <label for="field-nomeUsuario">Nome</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="emailUsuario" class="form-control" id="field-emailUsuario" placeholder="Digite aqui seu E-mail, conforme o exemplo: usuario@dominio.com.br" value="<?php print($post['emailusuario'] ?? "") ?>">
                            <label for="field-nomeUsuario">E-mail</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="senhaUsuario" class="form-control" id="field-senhaUsuario" value="<?php print($post['senhausuario'] ?? "") ?>" placeholder="Digite aqui sua senha">
                            <label for="field-senhaUsuario">Senha</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="senhaUsuario2" class="form-control" id="field-senhaUsuario2" value="<?php print($post['senhausuario2'] ?? "") ?>" placeholder="Digite aqui sua senha">
                            <label for="field-senhaUsuario2">Confirmação de senha</label>
                        </div>
                        <div class="mb-1 text-center">
                            <button type="submit" class="btn btn-dark">Cadastrar</button>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>
</div>