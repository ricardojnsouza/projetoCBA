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
                            <a class="nav-link" aria-current="true" href="?link=registrar">Cadastrar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="true" href="?link=recuperar">Recuperar Acesso</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <form method="post">
                        <input type='hidden' name='metodo' value='recuperar'>
                        <div class="form-floating mb-3">
                            <input type="email" name="emailUsuario" class="form-control" id="field-emailUsuario" placeholder="Digite aqui seu E-mail, conforme o exemplo: usuario@dominio.com.br" value="<?php print($post['emailusuario'] ?? "") ?>">
                            <label for="field-emailUsuario">E-mail</label>
                        </div>
                        <div class="mb-1 text-center">
                            <button type="submit" class="btn btn-dark">Enviar e-mail de recuperação</button>
                        </div>
                    </form>
                    
                </div>
            </div>

        </div>
    </div>
</div>