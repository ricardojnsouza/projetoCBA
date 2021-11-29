
<div class="container">
    <div class="row">
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
        <div class="col-xxl-6 col-xl-8 col-lg-8 align-self-center">


            <div class="card m-5 shadow mb-5">
                <img src="assets/imagens/banner-login.jpg" class="card-img-top" alt="...">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="#">Acessar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?link=registrar">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="true" href="?link=recuperar">Recuperar Acesso</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type='hidden' name='metodo' value='acessar'>
                        <div class="form-floating mb-3">
                            <input type="text" name="user" class="form-control" id="field-user" placeholder="Digite aqui seu nome" value="<?php print($post['user'] ?? "") ?>">
                            <label for="field-user">Usuário</label>
                            </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="pass" class="form-control" id="field-pass" value="<?php print($post['pass'] ?? "") ?>" placeholder="Digite aqui sua senha">
                            <label for="field-pass">Senha</label>
                        </div>
                        <div class="mb-1 text-center">
                            <button type="submit" class="btn btn-dark">Acessar</button>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-2 col-lg-2"></div>
    </div>
</div>
