<div class="container">
    <div class="col-12 bg-light-- p-5 rounded mx-auto d-block">
        <p class="text-center fs-1">Painel de Controle</p>
    </div>

    <div class="col-12 bg-light shadow p-5 mb-5">

        <div class="accordion --accordion-flush" id="accordionFlushExample">
            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed --bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Cadastros
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                            <!-- CADASTROS => Dropdown/List -->
                            <div class="list-group m-2 shadow-sm">
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addEmpresaModal">Minha Empresa</a>
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addFuncionariosModal">Funcionários</a>
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addMesasModal">Mesas & Cadeiras</a>
                            </div>

                            <!-- modal ~ empresa 1:1 -->
                            <div id="addEmpresaModal" class="modal" tabindex="-1">
                                <!-- MODAL EMPRESA - INICIO -->
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Minha Empresa</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">

                                            <form>
                                                <input type='hidden' name='inputEmpLat' id='inputEmpLat' />
                                                <input type='hidden' name='inputEmpLng' id='inputEmpLng' />
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control cpf-cnpj" id="inputEmpCPFCNPJ" maxlength="20">
                                                            <label for="inputEmpCPFCNPJ">CPF / CNPJ</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <select id="inputEmpSegmento" class="form-select">
                                                                <option selected>Escolha...</option>
                                                                <option value="CF">Cafeteria</option>
                                                                <option value="BA">Bar</option>
                                                                <option value="QP">Quiosque de Praia</option>
                                                            </select>
                                                            <label for="inputEmpSegmento">Segmento</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpNomeFantasia" maxlength="128">
                                                            <label for="inputEmpNomeFantasia">Nome Fantasia</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpRazaoSocial" maxlength="128">
                                                            <label for="inputEmpRazaoSocial">Razão Social</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpEndereco" maxlength="128">
                                                            <label for="inputEmpEndereco">Endereço</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpBairro" minlength="6" maxlength="64">
                                                            <label for="inputEmpBairro">Bairro</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpCidade" minlength="6" maxlength="64">
                                                            <label for="inputEmpCidade">Cidade</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md">
                                                        <div class="form-floating">
                                                            <select id="inputEmpEstado" class="form-control">
                                                                <option selected>Escolha...</option>
                                                                <option value="AC">Acre</option>
                                                                <option value="AL">Alagoas</option>
                                                                <option value="AP">Amapá</option>
                                                                <option value="AM">Amazonas</option>
                                                                <option value="BA">Bahia</option>
                                                                <option value="CE">Ceará</option>
                                                                <option value="DF">Distrito Federal</option>
                                                                <option value="ES">Espírito Santo</option>
                                                                <option value="GO">Goiás</option>
                                                                <option value="MA">Maranhão</option>
                                                                <option value="MT">Mato Grosso</option>
                                                                <option value="MS">Mato Grosso do Sul</option>
                                                                <option value="MG">Minas Gerais</option>
                                                                <option value="PA">Pará</option>
                                                                <option value="PB">Paraíba</option>
                                                                <option value="PR">Paraná</option>
                                                                <option value="PE">Pernambuco</option>
                                                                <option value="PI">Piauí</option>
                                                                <option value="RJ">Rio de Janeiro</option>
                                                                <option value="RN">Rio Grande do Norte</option>
                                                                <option value="RS">Rio Grande do Sul</option>
                                                                <option value="RO">Rondônia</option>
                                                                <option value="RR">Roraima</option>
                                                                <option value="SC">Santa Catarina</option>
                                                                <option value="SP">São Paulo</option>
                                                                <option value="SE">Sergipe</option>
                                                                <option value="TO">Tocantins</option>
                                                            </select>
                                                            <label for="inputEmpEstado">Estado</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="row g-2 mb-2">
                                                    <div class="col-md-2">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpCEP" minlength="6" maxlength="64" data-mask2="99999-999">
                                                            <label for="inputEmpCEP">CEP</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpCel" minlength="6" maxlength="64" data-mask2="(99) 9999-99999">
                                                            <label for="inputEmpCel">Celular</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control" id="inputEmpEmail" minlength="6" maxlength="64">
                                                            <label for="inputEmpEmail">E-mail</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div id="map" class="w-100" style='height: 25vh;'></div>
                                            </form>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <div>
                                                <button type="button" class="btn btn-info" id="localizar_addEmpresaModal">Localizar</button>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary" id="submit_addEmpresaModal">Salvar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- MODAL EMPRESA - FIM -->
                            </div>

                            <!-- modal ~ funcionários 1:n -->
                            <div id="addFuncionariosModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Funcionários</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione um dos funcionários na lista abaixo
                                                        </h6>
                                                        
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaFuncionarios'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhum <strong>funcionário</strong> cadastrado!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>    
                                                    <!-- -->
                                                    <div class="row g-1 mb-2">
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputUserName" minlength="6" maxlength="64">
                                                                <label for="inputUserName">Nome</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputUserEmail" minlength="4" maxlength="128">
                                                                <label for="inputUserEmail">E-mail</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputUserLogin" minlength="6" maxlength="64">
                                                                <label for="inputUserLogin">Usuário</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <input type="password" class="form-control" id="inputUserPassword" minlength="6" maxlength="32">
                                                                <label for="inputUserPassword">Senha</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <select id="inputUserFuncao" class="form-select">
                                                                    <option selected>Escolha...</option>
                                                                </select>
                                                                <label for="inputUserlogin">Função</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md">
                                                            <div class="form-floating">
                                                                <input type="tel" class="form-control" id="inputUserCel" maxlength="15" data-mask2="(99) 9999-99999">
                                                                <label for="inputUserCel">Celular</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar um novo funcionário</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addFuncionariosModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addFuncionariosModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addFuncionariosModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal ~ mesas e cadeiras 1:n -->
                            <div id="addMesasModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mesas e Cadeiras</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione uma das mesas na lista abaixo
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaMesas'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhuma <strong>mesa</strong> cadastrada!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>    
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-2">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputMesasCadeirasCodigo" minlength="1" maxlength="8">
                                                                <label for="inputUserName">Código</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select id="inputMesasCadeiraQuantidade" class="form-select">
                                                                    <option selected>Selecione...</option>
                                                                    <option value="2">2 lugares</option>
                                                                    <option value="4">4 lugares</option>
                                                                    <option value="6">6 lugares</option>
                                                                    <option value="8">8 lugares</option>
                                                                    <option value="10">10 lugares</option>
                                                                    <option value="12">12 lugares</option>
                                                                    <option value="14">14 lugares</option>
                                                                    <option value="16">16 lugares</option>
                                                                </select>
                                                                <label for="inputMesasCadeiraQuantidade">Nº de Lugares</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputMesasDescricao" maxlength="64">
                                                                <label for="inputMesasDescricao">Descrição</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar uma nova mesa</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addMesasModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addMesasModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addMesasModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed --bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Estoque
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">

                            <!-- ESTOQUE => Dropdown/List -->
                            <div class="list-group m-2 shadow-sm">
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addCategoriasModal">Categorias</a>
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addIngredientesModal">Ingredientes</a>
                            </div>

                            <!-- modal ~ categorias 1:n -->
                            <div id="addCategoriasModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Categorias</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione uma das categorias na lista abaixo
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaCategorias'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhuma <strong>categoria</strong> cadastrada!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>    
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputCategoriaNome" maxlength="128">
                                                                <label for="inputCategoriaNome">Nome</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputCategoriaDescricao" maxlength="128">
                                                                <label for="inputCategoriaDescricao">Descrição</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar uma nova categoria</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addCategoriasModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addCategoriasModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addCategoriasModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal ~ ingredientes 1:n -->
                            <div id="addIngredientesModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ingredientes</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione uma dos ingredientes na lista abaixo
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaIngredientes'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhum <strong>ingrediente</strong> cadastrado!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>    
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-8">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputNomeIngrediente" maxlength="128">
                                                                <label for="inputNomeIngrediente">Nome</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputQuantidadeIngrediente" maxlength="6" data-type="decimal">
                                                                <label for="inputQuantidadeIngrediente">Quantidade</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputDataEntradaIngrediente" maxlength="10" data-type="date" data-mask2="99/99/9999">
                                                                <label for="inputDataEntradaIngrediente">Data de entrada</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputDataVencimentoIngrediente" maxlength="10" data-type="date" data-mask2="99/99/9999">
                                                                <label for="inputDataVencimentoIngrediente">Data de validade</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <select id="inputUnidadeQuantidadeIngrediente" class="form-select">
                                                                    <option value>Selecione...</option>
                                                                    <option value='Un'>Unidade</option>
                                                                    <option value='g'>Grama (g)</option>
                                                                    <option value='Kg'>Quilograma (Kg)</option>
                                                                    <option value='Dz'>Dúzia</option>
                                                                    <option value='mL'>Mililitro (mL)</option>
                                                                    <option value='L'>Litro (L)</option>
                                                                </select>
                                                                <label for="inputUnidadeQuantidadeIngrediente">Quantidade (Unidade)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar uma nova categoria</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addIngredientesModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addIngredientesModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addIngredientesModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>

                    </ul>
                </div>
            </div>

            <div class="accordion-item bg-transparent">
                <h2 class="accordion-header" id="flush-headingThree">
                    <button class="accordion-button collapsed --bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                        Cardápio
                    </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" --data-bs-parent="#accordionFlushExample">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            
                            <!-- ESTOQUE => Dropdown/List -->
                            <div class="list-group m-2 shadow-sm">
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addAdicionaisModal">Adicionais</a>
                                <a href="#" class="list-group-item list-group-item-action"  data-bs-toggle="modal" data-bs-target="#addProdutosModal">Produtos</a>
                            </div>

                            <!-- modal ~ adicionais 1:n -->
                            <div id="addAdicionaisModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Adicionais</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione um dos adicionais na lista abaixo
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaAdicionais'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhum <strong>adicional</strong> cadastrado!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-8">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputNomeAdicional" maxlength="128">
                                                                <label for="inputNomeAdicional">Nome</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputQuantidadeAdicional" maxlength="6" data-type="decimal">
                                                                <label for="inputQuantidadeAdicional">Quantidade</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <textarea class="form-control" placeholder="Descrição" id="inputDescricaoAdicional" style="height: 100px"></textarea>
                                                                <label for="inputDescricaoAdicional">Descrição</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar uma novo ítem adicional</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addAdicionaisModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addAdicionaisModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addAdicionaisModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- modal ~ produto 1:n -->
                            <div id="addProdutosModal" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Produtos</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h6 class="text-primary text-center p-2 border-bottom border-primary -rounded">
                                                            Selecione um dos produtos na lista abaixo
                                                        </h6>
                                                    </div>
                                                </div>
                                                <!-- -->
                                                <div class="p-2 bg-light border rounded">
                                                    <!-- -->
                                                    <div class="row g-1 mb-4">
                                                        <div class="col-md">

                                                            <div class="list-group mb-1 shadow" id='listaProdutos'>
                                                                <button type="button" class="list-group-item list-group-item-action bg-secondary">
                                                                    Nenhum <strong>produto</strong> cadastrado!
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-md-8">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputNomeProduto" maxlength="128">
                                                                <label for="inputNomeProduto">Nome</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputQuantidadeProduto" maxlength="6" data-type="decimal">
                                                                <label for="inputQuantidadeProduto">Quantidade</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="form-floating">
                                                                <select id="inputCategoriaProduto" class="form-select">
                                                                    <option selected>Carregando...</option>
                                                                </select>
                                                                <label for="inputCategoriaProduto">Categoria</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-floating">
                                                                <input type="text" class="form-control" id="inputValorProduto" maxlength="8" data-type="decimal">
                                                                <label for="inputValorProduto">Valor</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <textarea class="form-control" placeholder="Descrição" id="inputDescricaoProduto" style="height: 100px"></textarea>
                                                                <label for="inputDescricaoProduto">Descrição</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <input class="form-check-input" type="checkbox" id="inputDisponibilidadeProduto">
                                                            <label class="form-check-label" for="inputDisponibilidadeProduto">
                                                                Disponível
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <!-- -->
                                                    <div class="text-end mb-0 border-top pt-1">
                                                        <span class="small float-start text-black-50"><strong>*</strong> Clique em 'novo' para adicionar uma novo ítem adicional</span>
                                                        <button type="button" class="btn btn-outline-success lh-1 pt-1 pb-1" id="add_addProdutosModal">Novo</button>
                                                        <button type="button" class="btn btn-outline-danger lh-1 pt-1 pb-1" id="del_addProdutosModal">Excluir</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="button" class="btn btn-primary" id="submit_addProdutosModal">Salvar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

        if (!isSet($_SESSION) || !isSet($_SESSION['auth_token'])) {
            //die("0,Sessão inválida!");
            die();
        }
        $user = getUserByToken($_SESSION['auth_token']);
        if (empty($user)) {
            //die("0,Usuário inválido");

            die();
        }
    
        $conexao = $GLOBALS['mysql'];

        // - Carrega os dados da empresa cadastrada para o usuário logado e armazena os dados em uma variável no JS...

        $addEmpresaModal = [];
        // =
        $sql = "SELECT * FROM empresa WHERE idFuncionario = ?";
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
        if ($result === true) {
            $empresas = $ps->fetchAll();
            if (count($empresas) > 0) {
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
                    'inputemplng'           => "lng"
                ];
                $de_para = array_flip($de_para);
                foreach($empresas as $empresa) {
                    foreach ($empresa as $field => $value) {
                        if (!is_numeric($field)) {
                            $field = strtolower(isSet($de_para[$field]) ? $de_para[$field] : $field);
                            $addEmpresaModal[$field] = $value;
                        }
                    }
                }
            }
        }

?>

<div id='toast_success' class="position-fixed bottom-0 end-0 p-3 m-3  toast align-items-center text-white          bg-success           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body"></div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>
<div id='toast_error' class="position-fixed bottom-0 end-0 p-3 m-3   toast align-items-center text-white          bg-danger           border-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="d-flex">
    <div class="toast-body"></div>
    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
</div>

<script async src="https://maps.googleapis.com/maps/api/js?key=<?php print($google_api_key ?? ""); ?>&libraries=places"></script>
<script type='text/javascript'>
    let map;
    let pos;
    let markers = [];

    // - acao para o botao de pesquisa
    document.getElementById("localizar_addEmpresaModal").onclick = function() {
        removerMarcador(markers);
        setTimeout(() => pesquisar(), 1000);
    };

    function initMap() {
        console.log("obterPosicaoMarcador() => ", obterPosicaoMarcador());
        // - inicializa o mapa
        map = new google.maps.Map(document.getElementById("map"), {
            // - marco zero
            center: obterPosicaoMarcador() || {
                lat: -8.063135030287976,
                lng: -34.8710510373973
            },
            zoom: 15,
        });

        // - tenta identificar a localização atual.
        pos = obterPosicaoMarcador();
        if (pos) {
            adicionaMarcador(pos.lat, pos.lng);
        }
        else if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => adicionaMarcador(position.coords.latitude, position.coords.longitude), 
                (error) => console.log("erro ao obter a localização atual! => ", error)
            );
        }
    }

    function pesquisar() {
        let endereco = "";
        ['inputEmpEndereco','inputEmpBairro','inputEmpCidade','inputEmpEstado'].forEach( (id) => endereco += (endereco ? ", " : "") + document.getElementById(id).value );
        endereco += (endereco ? ", " : "") + "CEP: " + document.getElementById("inputEmpCEP").value;
        // -

        // - monta a query para busca por texto
        let request = {
            query: endereco,
            type: 'address',
            fields: ['name', 'geometry'],
            //location: pos,
            //radius: 7000,
        };
        
        const labels = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        let labelIndex = 0;
        
        let service = new google.maps.places.PlacesService(map);

        // - limpa os marcadores prévios caso existam algum marcador previamente carregado
        //removerMarcador(markers);

        //markers = [];
        service.textSearch(request, function(results, status) {
            if (results.length == 0) {
                alert("nenhum resultado encontrado!");
            }
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                results.forEach((result) => {
                    const svgMarker = {
                        path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                        fillColor: "blue",
                        fillOpacity: 0.6,
                        strokeWeight: 0,
                        rotation: 0,
                        scale: 2,
                        //anchor: new google.maps.Point(15, 30),
                    };
                    adicionaMarcador(
                        result.geometry.location.lat(),
                        result.geometry.location.lng()
                    );
                    /*
                    let marker = new google.maps.Marker({
                        position: {
                            lat: result.geometry.location.lat(),
                            lng: result.geometry.location.lng(),
                        },
                        map: map,
                        draggable: true,
                        //label: labels[labelIndex++ % labels.length],
                        title: result.name,
                        icon: {
                            url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                        }
                    });
                    marker.addListener("click", () => {
                        if (marker.getAnimation() !== null) {
                            marker.setAnimation(null);
                        } else {
                            marker.setAnimation(google.maps.Animation.BOUNCE);
                        }
                    });
                    markers.push(marker);
                    */
                });
                map.setCenter(results[0].geometry.location);
            }

            // - exibe o toast (bootstrap) com o número de estabelecimentos localizadoss
            [].slice.call(document.querySelectorAll('.toast.estabelecimentos')).map((toastEl)  => {
                document.getElementById("toast-body").innerText = markers.length + " estabelecimentos localizados";
                return new bootstrap.Toast(toastEl);
            }).forEach((toast) => toast.show());
        });
    }

    function adicionaMarcador(lat, lng) {
        removerMarcador(markers);
        // -
        registraPosicaoMarcador(lat, lng);
        // -
        let marker = new google.maps.Marker({
            position: {
                lat: lat,
                lng: lng,
            },
            map: map,
            draggable: true,
            title: "Localização",//result.name,
            icon: {
                url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
            }
        });
        // -
        marker.addListener("click", (e) => {
            if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
            } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
            }
        });
        // -
        marker.addListener('dragend', (e) => {
            registraPosicaoMarcador(e.latLng.lat(), e.latLng.lng());
        });
        // -
        markers.push(marker);
    }

    function registraPosicaoMarcador(lat, lng) {
        document.getElementById("inputEmpLat").value = lat;
        document.getElementById("inputEmpLng").value = lng;
    }

    function obterPosicaoMarcador() {
        let lat = document.getElementById("inputEmpLat").value;
        let lng = document.getElementById("inputEmpLng").value;
        if (lat && lng) {
            return { lat: parseFloat(lat), lng: parseFloat(lng) }
        }
        return null;
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
</script>

<script type='text/javascript'>

    var addEmpresaModal = JSON.parse(`<?php print(json_encode($addEmpresaModal)) ?>`);
    //var addEmpresaModal = [1,2,3];

    // -

    $(document).ready(function() {

        // ~ adiciona o atributo [nome] a cada elemento do formulario das modais (ajuste baseado no atributo ID);
        let modais = $("[id*='add'][id*='Modal']")
        modais.each((i, modal) => $("[id]", modal).each((i, componente) => $(componente).attr("name", componente.id)));


        // ~ adicioona a ação de envio dos formulários para o back via ajax.
        modais.find("button[id^='submit']").on("click", function() {
            let id = ((`${this.id}`).indexOf("_") >= 0 ? `${this.id}`.split("_")[1] : null);
            let form = $(this).closest(".modal-content").find("form");
            let data = ((`${this.id}`).indexOf("_") >= 0 ? `id=${(`${this.id}`).split("_")[1]}&` : "");
            switch (id) {
                case "addFuncionariosModal":
                    data += "data=" + JSON.stringify(window.funcionariosMetadata);
                    break;
                case "addMesasModal":
                    data += "data=" + JSON.stringify(window.mesasMetadata);
                    break;
                case "addCategoriasModal":
                    data += "data=" + JSON.stringify(window.categoriasMetadata);
                    break;
                case "addIngredientesModal":
                    data += "data=" + JSON.stringify(window.ingredientesMetadata);
                    break;
                case "addAdicionaisModal":
                    data += "data=" + JSON.stringify(window.adicionaisMetadata);
                    break;
                case "addProdutosModal":
                    data += "data=" + JSON.stringify(window.produtosMetadata);
                    break;
                default:
                    data += form.serialize();
            }
            // -
            $.ajax({
                method: "POST",
                url: "gestao/parser.php",
                data: data
            })
            .done(function(response) {
                console.log("==> parser.response => ", response)
                //return;
                let i = response.indexOf(",");
                let j = parseInt(response.substring(0, i));
                if (j === 1) {
                    let $toast = $("#toast_success");
                    $toast.find(".toast-body").html(response.substring(i + 1));
                    $toast.toast('show');
                    // - fecha a modal
                    form.closest(".modal").modal('hide');
                    // - atualiza a página!
                    setTimeout(() => location.reload(), 1500);
                }
                else {
                    let $toast = $("#toast_error");
                    $toast.find(".toast-body").html(response.substring(i + 1));
                    $toast.toast('show');
                }
                //console.log( response );
            });
        });

        // ~ prepara a carga dos dados para formulários únicos (como empresa que fica vinculada na proporção de 1:1 ou 1:n com o cadastro de usuário...)
        modais.on('shown.bs.modal', function() {
            let modal = $(this);
            let data = window[this.id];
            // -
            $(`a.list-group-item-dark[data-bs-toggle='modal']`).removeClass("list-group-item-dark");
            $(`a[data-bs-toggle='modal'][data-bs-target='#${this.id}']`).addClass("list-group-item-dark");
            // -
            if (data) {
                switch (this.id) {
                    case "addFuncionariosModal":
                        obterFuncionarios();
                        break;
                    case "addMesasModal":
                        obterMesas();
                        break;
                    case "addCategoriasModal":
                        obterCategorias();
                        break;
                    case "addIngredientesModal":
                        obterIngredientes();
                        break;
                    case "addAdicionaisModal":
                        obterAdicionais();
                        break;
                    case "addProdutosModal":
                        // - carrega as categorias
                        $.ajax({
                            method: "POST",
                            url: "gestao/obterLista.php",
                            data: {
                                tabela: "categoria",
                                campos: ['idCategoria','inputCategoriaNome']
                            }
                        })
                        .done(function(response) {
                            let i = response.indexOf(",");
                            let j = parseInt(response.substring(0, i));
                            if (j === 1) {
                                response = JSON.parse(response.substring(j + 1))
                                let $modal = $("#addProdutosModal");
                                let $select = $("#inputCategoriaProduto", $modal);
                                // - 
                                $select.contents().remove();
                                $select.append($(`<option value selected>Selecione...</option>`));
                                (response || []).forEach((categoria) => $select.append($(`<option value="${categoria.idcategoria}">${categoria.inputcategorianome}</option>`)));
                                // =
                                obterProdutos();
                            }
                            else {
                                let $toast = $("#toast_error");
                                $toast.find(".toast-body").html(response.substring(j + 1));
                                $toast.toast('show');
                            }
                        });
                        break;
                }

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
                
                $("input,select,textarea", modal).removeAttr("data-masked").each(function() {
                    let $elemento = $(this);
                    switch ($elemento.prop("tagName")) {
                        case "INPUT":
                        case "SELECT":
                            $elemento.val( data [ ($elemento.attr("name") || "").toLowerCase() ] );
                            break;
                    }

                    // - controla as máscaras

                    if ($elemento.hasClass("cpf-cnpj") || $elemento.data("mask2")) {
                        ajustarMascaras($elemento);
                        $elemento.keydown();
                    }
                });

                if (this.id == "addEmpresaModal") {
                    initMap();
                }
            }
        });
        modais.on('hide.bs.modal', function() {
            let modal = $(this);
            $("input[data-masked]", modal).attr("data-masked", "0").unmask();
            $(`a.list-group-item-dark[data-bs-toggle='modal']`).removeClass("list-group-item-dark");
        });



        // [addFuncionariosModal] => #inputUserFuncao => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "funcao",
                campos: ["idFuncao","idFuncionario","nomeFuncao"]
            }
        })
        .done(function(response) {
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                let json = JSON.parse(response.substring(j + 1));
                // -
                let $select = $("#inputUserFuncao");
                // -
                $select.find("option").remove();
                $select.append($(`<option selected>Selecione...</option>`));
                // -
                Object.values(json).forEach((funcao) => {
                    let $option = $(`<option value="${funcao.idfuncao}">${funcao.nomefuncao}</option>`);
                    $select.append($option);
                });
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });

        // [addFuncionariosModal] => #inputUserFuncao => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "funcao",
                campos: ["idFuncao","idFuncionario","nomeFuncao"]
            }
        })
        .done(function(response) {
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                let json = JSON.parse(response.substring(j + 1));
                // -
                let $select = $("#inputUserFuncao");
                // -
                $select.find("option").remove();
                $select.append($(`<option value=''>Selecione...</option>`));
                // -
                Object.values(json).forEach((funcao) => {
                    let $option = $(`<option value="${funcao.idfuncao}">${funcao.nomefuncao}</option>`);
                    $select.append($option);
                });
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    });

    // = PRODUTOS = 

    var obterProdutos = function() {
        console.log("fn.obterProdutos()");
        if (!window.produtosMetadata) {
            window.produtosMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addIngredentesModal] => #listaIngredentes => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "produto",
                campos: ['idProduto','idFuncionario', 'idCategoria', 'inputNomeProduto', 'inputQuantidadeProduto', 'inputCategoriaProduto', 'inputValorProduto', 'inputDescricaoProduto', 'inputDisponibilidadeProduto']
            }
        })
        .done(function(response) {
            console.log("obterProdutos => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.produtosMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarProdutos(0);
                carregaProduto(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarProdutos = function(id = -1) {
        let $list = $("#listaProdutos");
        // -
        $list.off().contents().remove();
        // -
        if (window.produtosMetadata && window.produtosMetadata.ativos && window.produtosMetadata.ativos.length > 0) {
            window.produtosMetadata.ativos.forEach((produto, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${produto.inputnomeproduto || "-NÃO DEFINIDO-"}</strong>, <u>${produto.inputquantidadeproduto ? `x${produto.inputquantidadeproduto}` : "-NÃO DEFINIDO-"}</u>!!</button>`))
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhum <strong>produto</strong> cadastrado!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaProduto(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaProduto(id);
        }
        
        // - adiciona a ação
        $("#add_addProdutosModal").off().on("click", function() {
            incluirProduto();
        });
        $("#del_addProdutosModal").off().on("click", function() {
            excluirProduto();
        });
    };
    
    var carregaProduto = function(id = -1) {
        if (window.produtosMetadata && window.produtosMetadata.ativos) {
            let produto = window.produtosMetadata.ativos[id];
            // -
            $("#addProdutosModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (produto) {
                    let forcar = false;
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = produto[nome];
                    if ($elemento.attr("type") == "checkbox") {
                        //valor = $elemento.is(":checked") ? 1 : 0;
                        $elemento.prop("checked", valor == 1 ? true : false);
                    }
                    //if (valor && $elemento.data("type") == "date") {
                    //    valor = valor.split("-").reverse().join("/");
                    //    forcar = true;
                    //}
                    $elemento.val(valor).keydown().prop("disabled", false);
                    if (forcar) {
                        setTimeout(() => $elemento.change(), 100);
                    }
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.produtosMetadata && window.produtosMetadata.ativos) {
                    let id = parseInt($("#listaProdutos").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    if ($elemento.attr("type") == "checkbox") {
                        $elemento.val($elemento.is(":checked") ? 1 : 0);
                    }
                    // =
                    let ativo = window.produtosMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.produtosMetadata.ativos[id] = ativo;
                        // -
                        atualizarProdutos(id);
                    }
                }
            });
        }
    };
    var incluirProduto = function() {
        if (window.produtosMetadata && window.produtosMetadata.ativos) {
            window.produtosMetadata.ativos.push({});
            
            let max = 0;
            window.produtosMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarProdutos(max);
            carregaProduto(max);
        }
    };
    var excluirProduto = function() {
        if (window.produtosMetadata && window.produtosMetadata.ativos) {
            let ativos = window.produtosMetadata.ativos;
            // -
            let i = parseInt($("#listaProdutos").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idproduto || -1);
                if (i > 0) {
                    window.produtosMetadata.excluidos.push(i);
                }
                // -
                window.produtosMetadata.ativos = ativos;
                // -
                atualizarProdutos();
                $("#addProdutosModal").find("input,select,textarea").val("");
            }
        }
    };

    // = ADICIONAIS = 

    var obterAdicionais = function() {
        console.log("fn.obterIngredentes()");
        if (!window.adicionaisMetadata) {
            window.adicionaisMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addIngredentesModal] => #listaIngredentes => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "adicionais",
                campos: ['idAdicional','idFuncionario','inputNomeAdicional', 'inputQuantidadeAdicional', 'inputDescricaoAdicional']
            }
        })
        .done(function(response) {
            console.log("obterIngredentes => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.adicionaisMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarAdicionais(0);
                carregaAdicional(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarAdicionais = function(id = -1) {
        let $list = $("#listaAdicionais");
        // -
        $list.off().contents().remove();
        // -
        if (window.adicionaisMetadata && window.adicionaisMetadata.ativos && window.adicionaisMetadata.ativos.length > 0) {
            window.adicionaisMetadata.ativos.forEach((adicional, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${adicional.inputnomeadicional || "-NÃO DEFINIDO-"}</strong>, <u>${adicional.inputquantidadeadicional ? `x${adicional.inputquantidadeadicional}` : "-NÃO DEFINIDO-"}</u>!!</button>`))
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhum <strong>ingrediente</strong> cadastrado!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaAdicional(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaAdicional(id);
        }
        
        // - adiciona a ação
        $("#add_addAdicionaisModal").off().on("click", function() {
            incluirAdicional();
        });
        $("#del_addAdicionaisModal").off().on("click", function() {
            excluirAdicional();
        });
    };
    var carregaAdicional = function(id = -1) {
        if (window.adicionaisMetadata && window.adicionaisMetadata.ativos) {
            let adicional = window.adicionaisMetadata.ativos[id];
            // -
            $("#addAdicionaisModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (adicional) {
                    let forcar = false;
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = adicional[nome];
                    //if (valor && $elemento.data("type") == "date") {
                    //    valor = valor.split("-").reverse().join("/");
                    //    forcar = true;
                    //}
                    $elemento.val(valor).keydown().prop("disabled", false);
                    if (forcar) {
                        setTimeout(() => $elemento.change(), 100);
                    }
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.adicionaisMetadata && window.adicionaisMetadata.ativos) {
                    let id = parseInt($("#listaAdicionais").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    let ativo = window.adicionaisMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.adicionaisMetadata.ativos[id] = ativo;
                        // -
                        atualizarAdicionais(id);
                    }
                }
            });
        }
    };
    var incluirAdicional = function() {
        if (window.adicionaisMetadata && window.adicionaisMetadata.ativos) {
            window.adicionaisMetadata.ativos.push({});
            
            let max = 0;
            window.adicionaisMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarAdicionais(max);
            carregaAdicional(max);
        }
    };
    var excluirAdicional = function() {
        if (window.adicionaisMetadata && window.adicionaisMetadata.ativos) {
            let ativos = window.adicionaisMetadata.ativos;
            // -
            let i = parseInt($("#listaAdicionais").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idadicional || -1);
                if (i > 0) {
                    window.adicionaisMetadata.excluidos.push(i);
                }
                // -
                window.adicionaisMetadata.ativos = ativos;
                // -
                atualizarAdicionais();
                $("#addAdicionaisModal").find("input,select,textarea").val("");
            }
        }
    };

    // = INGREDIENTES = 

    var obterIngredientes = function() {
        console.log("fn.obterIngredentes()");
        if (!window.ingredientesMetadata) {
            window.ingredientesMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addIngredentesModal] => #listaIngredentes => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "ingredientes",
                campos: ['idIngrediente','idFuncionario','inputNomeIngrediente', 'inputQuantidadeIngrediente', 'inputDataEntradaIngrediente', 'inputDataVencimentoIngrediente', 'inputUnidadeQuantidadeIngrediente']
            }
        })
        .done(function(response) {
            console.log("obterIngredentes => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.ingredientesMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarIngredientes(0);
                carregaIngrediente(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarIngredientes = function(id = -1) {
        let $list = $("#listaIngredientes");
        // -
        $list.off().contents().remove();
        // -
        if (window.ingredientesMetadata && window.ingredientesMetadata.ativos && window.ingredientesMetadata.ativos.length > 0) {
            window.ingredientesMetadata.ativos.forEach((ingrediente, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${ingrediente.inputnomeingrediente || "-NÃO DEFINIDO-"}</strong>, <u>${ingrediente.inputquantidadeingrediente || "-NÃO DEFINIDO-"} ${ingrediente.inputunidadequantidadeingrediente || ""}</u>, ${ingrediente.inputdatavencimentoingrediente || "-NÃO DEFINIDO-"}!!</button>`))
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhum <strong>ingrediente</strong> cadastrado!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaIngrediente(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaIngrediente(id);
        }
        
        // - adiciona a ação
        $("#add_addIngredientesModal").off().on("click", function() {
            incluirIngrediente();
        });
        $("#del_addIngredientesModal").off().on("click", function() {
            excluirIngrediente();
        });
    };
    var carregaIngrediente = function(id = -1) {
        if (window.ingredientesMetadata && window.ingredientesMetadata.ativos) {
            let ingrediente = window.ingredientesMetadata.ativos[id];
            // -
            $("#addIngredientesModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (ingrediente) {
                    let forcar = false;
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = ingrediente[nome];
                    if (valor && $elemento.data("type") == "date") {
                        valor = valor.split("-").reverse().join("/");
                        forcar = true;
                    }
                    $elemento.val(valor).keydown().prop("disabled", false);
                    if (forcar) {
                        setTimeout(() => $elemento.change(), 100);
                    }
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.ingredientesMetadata && window.ingredientesMetadata.ativos) {
                    let id = parseInt($("#listaIngredientes").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    let ativo = window.ingredientesMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.ingredientesMetadata.ativos[id] = ativo;
                        // -
                        atualizarIngredientes(id);
                    }
                }
            });
        }
    };
    var incluirIngrediente = function() {
        if (window.ingredientesMetadata && window.ingredientesMetadata.ativos) {
            window.ingredientesMetadata.ativos.push({});
            
            let max = 0;
            window.ingredientesMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarIngredientes(max);
            carregaIngrediente(max);
        }
    };
    var excluirIngrediente = function() {
        if (window.ingredientesMetadata && window.ingredientesMetadata.ativos) {
            let ativos = window.ingredientesMetadata.ativos;
            // -
            let i = parseInt($("#listaIngredientes").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idingrediente || -1);
                if (i > 0) {
                    window.ingredientesMetadata.excluidos.push(i);
                }
                // -
                window.ingredientesMetadata.ativos = ativos;
                // -
                atualizarIngredientes();
                $("#addIngredientesModal").find("input,select,textarea").val("");
            }
        }
    };

    // = CATEGORIAS = 

    var obterCategorias = function() {
        console.log("fn.obterCategorias()");
        if (!window.categoriasMetadata) {
            window.categoriasMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addCategoriasModal] => #listaCategorias => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "categoria",
                campos: ['idCategoria','idFuncionario','inputCategoriaNome', 'inputCategoriaDescricao']
            }
        })
        .done(function(response) {
            console.log("obterCategorias => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.categoriasMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarCategorias(0);
                carregaCategoria(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarCategorias = function(id = -1) {
        let $list = $("#listaCategorias");
        // -
        $list.off().contents().remove();
        // -
        if (window.categoriasMetadata && window.categoriasMetadata.ativos && window.categoriasMetadata.ativos.length > 0) {
            window.categoriasMetadata.ativos.forEach((categoria, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${categoria.inputcategorianome || "-NÃO DEFINIDO-"}</strong>, <u>${categoria.inputcategoriadescricao || "-NÃO DEFINIDO-"}</u>!!</button>`))
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhuma <strong>categoria</strong> cadastrada!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaCategoria(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaCategoria(id);
        }
        
        // - adiciona a ação
        $("#add_addCategoriasModal").off().on("click", function() {
            incluirCategoria();
        });
        $("#del_addCategoriasModal").off().on("click", function() {
            excluirCategoria();
        });
    };
    var carregaCategoria = function(id = -1) {
        if (window.categoriasMetadata && window.categoriasMetadata.ativos) {
            let categoria = window.categoriasMetadata.ativos[id];
            // -
            $("#addCategoriasModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (categoria) {
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = categoria[nome];
                    $elemento.val(valor).keydown().prop("disabled", false);
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.categoriasMetadata && window.categoriasMetadata.ativos) {
                    let id = parseInt($("#listaCategorias").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    let ativo = window.categoriasMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.categoriasMetadata.ativos[id] = ativo;
                        // -
                        atualizarCategorias(id);
                    }
                }
            });
        }
    };
    var incluirCategoria = function() {
        if (window.categoriasMetadata && window.categoriasMetadata.ativos) {
            window.categoriasMetadata.ativos.push({});
            
            let max = 0;
            window.categoriasMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarCategorias(max);
            carregaCategoria(max);
        }
    };
    var excluirCategoria = function() {
        if (window.categoriasMetadata && window.categoriasMetadata.ativos) {
            let ativos = window.categoriasMetadata.ativos;
            // -
            let i = parseInt($("#listaCategorias").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idcategoria || -1);
                if (i > 0) {
                    window.categoriasMetadata.excluidos.push(i);
                }
                // -
                window.categoriasMetadata.ativos = ativos;
                // -
                atualizarCategorias();
                $("#addCategoriasModal").find("input,select,textarea").val("");
            }
        }
    };

    // = FUNCIONÁRIOS =

    var obterFuncionarios = function() {
        console.log("fn.obterFuncionarios()");
        if (!window.funcionariosMetadata) {
            window.funcionariosMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addFuncionariosModal] => #listaFuncionarios => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "funcionario",
                campos: ['idFuncionario','idFuncao','idEmpresa','inputUserName','inputUserEmail','inputUserPassword','inputUserLogin','inputUserCel']
            }
        })
        .done(function(response) {
            console.log("obterFuncionarios => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.funcionariosMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarFuncionarios(0);
                carregaFuncionario(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarFuncionarios = function(id = -1) {
        let $list = $("#listaFuncionarios");
        // -
        $list.off().contents().remove();
        // =
        let funcoes = {};
        $("#inputUserFuncao").find("option").each(function() {
            let $option = $(this);
            if ($option.val()) {
                funcoes[$option.val()] = $option.text();
            }
        });
        // -
        if (window.funcionariosMetadata && window.funcionariosMetadata.ativos && window.funcionariosMetadata.ativos.length > 0) {
            window.funcionariosMetadata.ativos.forEach((funcionario, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${funcionario.inputusername || "Nome não definido"}</strong>, <u>${funcionario.inputuseremail || "e-mail não definido"}</u>, ${funcoes[funcionario.inputuserfuncao] || "função não definida"}!!</button>`))    
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhum <strong>funcionário</strong> cadastrado!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaFuncionario(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaFuncionario(id);
        }
        
        // - adiciona a ação
        $("#add_addFuncionariosModal").off().on("click", function() {
            incluiFuncionario();
        });
        $("#del_addFuncionariosModal").off().on("click", function() {
            excluirFuncionario();
        });
    };
    var carregaFuncionario = function(id = -1) {
        if (window.funcionariosMetadata && window.funcionariosMetadata.ativos) {
            let funcionario = window.funcionariosMetadata.ativos[id];
            // -
            $("#addFuncionariosModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (funcionario) {
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = funcionario[nome];
                    $elemento.val(valor).keydown().prop("disabled", false);
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.funcionariosMetadata && window.funcionariosMetadata.ativos) {
                    let id = parseInt($("#listaFuncionarios").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    let ativo = window.funcionariosMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.funcionariosMetadata.ativos[id] = ativo;
                        // -
                        atualizarFuncionarios(id);
                    }
                }
            });
            // - desabilita os campos #inputUserLogin e #inputUserPassword caso o objeto 'funcionario.idfuncionario' > 0
            //$("#inputUserLogin,#inputUserPassword").prop("disabled", (!funcionario || parseInt(funcionario.idfuncionario) > 0));
            $("#inputUserLogin,#inputUserPassword").closest(".form-floating").removeClass("d-none");
            if (!funcionario || parseInt(funcionario.idfuncionario) > 0) {
                $("#inputUserLogin,#inputUserPassword").closest(".form-floating").addClass("d-none");
            }
        }
    };
    var incluiFuncionario = function() {
        if (window.funcionariosMetadata && window.funcionariosMetadata.ativos) {
            window.funcionariosMetadata.ativos.push({});
            
            let max = 0;
            window.funcionariosMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarFuncionarios(max);
            carregaFuncionario(max);
        }
    };
    var excluirFuncionario = function() {
        if (window.funcionariosMetadata && window.funcionariosMetadata.ativos) {
            let ativos = window.funcionariosMetadata.ativos;
            // -
            let i = parseInt($("#listaFuncionarios").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idfuncionario || -1);
                if (i > 0) {
                    window.funcionariosMetadata.excluidos.push(i);
                }
                // -
                window.funcionariosMetadata.ativos = ativos;
                // -
                atualizarFuncionarios();
                //carregaFuncionario();
                $("#addFuncionariosModal").find("input,select,textarea").val("");
            }
        }
    };

    // = MESAS = 

    var obterMesas = function() {
        console.log("fn.obterMesas()");
        if (!window.mesasMetadata) {
            window.mesasMetadata = {
                ativos: null,
                excluidos: null
            }
        }
        // [addMesasModal] => #listaMesas => chamada ao backend para obter lista de funções pré cadastradas no bd.
        $.ajax({
            method: "POST",
            url: "gestao/obterLista.php",
            data: {
                tabela: "mesa",
                campos: ['idMesa','idFuncionario','codigo', 'lugares','descricao']
            }
        })
        .done(function(response) {
            console.log("obterMesas => ", response);
            let i = response.indexOf(",");
            let j = parseInt(response.substring(0, i));
            if (j === 1) {
                window.mesasMetadata = {
                    ativos: JSON.parse(response.substring(j + 1)),
                    excluidos: []
                };
                atualizarMesas(0);
                carregaMesa(0);
            }
            else {
                let $toast = $("#toast_error");
                $toast.find(".toast-body").html(response.substring(j + 1));
                $toast.toast('show');
            }
        });
    };
    var atualizarMesas = function(id = -1) {
        let $list = $("#listaMesas");
        // -
        $list.off().contents().remove();
        // -
        if (window.mesasMetadata && window.mesasMetadata.ativos && window.mesasMetadata.ativos.length > 0) {
            window.mesasMetadata.ativos.forEach((mesa, i) => {
                $list.append($(`<button type="button" data-id="${i}" class="${id === i ? "active" : ""} list-group-item list-group-item-action"><strong>${mesa.inputmesascadeirascodigo || "-NÃO DEFINIDO-"}</strong>, <u>${mesa.inputmesascadeiraquantidade || 0} lugares</u>, ${mesa.inputmesasdescricao || ""}!!</button>`))
            });
        }
        else {
            $list.append($(`<button type="button" class="list-group-item list-group-item-action bg-secondary">Nenhuma <strong>mesa</strong> cadastrada!!</button>`))
        }
        // -
        $list.on("click", function(e) {
            let $button = $(e.target).closest("button");
            // -
            $button.siblings(".active").removeClass("active");
            $button.addClass("active");
            // -
            carregaMesa(parseInt($button.data("id")));
        });
        // -
        if (id == -1) {
            carregaMesa(id);
        }
        
        // - adiciona a ação
        $("#add_addMesasModal").off().on("click", function() {
            incluiMesa();
        });
        $("#del_addMesasModal").off().on("click", function() {
            excluirMesa();
        });
    };
    var carregaMesa = function(id = -1) {
        if (window.mesasMetadata && window.mesasMetadata.ativos) {
            let mesa = window.mesasMetadata.ativos[id];
            // -
            $("#addMesasModal").find("input,select,textarea").prop("disabled", true).each(function() {
                let $elemento = $(this);
                // -
                if (mesa) {
                    let nome = ($elemento.attr("name") || "").toLowerCase();
                    let valor = mesa[nome];
                    $elemento.val(valor).keydown().prop("disabled", false);
                }
            }).off("keyup change").on("keyup change", function() {
                if (window.mesasMetadata && window.mesasMetadata.ativos) {
                    let id = parseInt($("#listaMesas").find("button.active[data-id]").data("id") || 0);
                    let $elemento = $(this);
                    // -
                    let ativo = window.mesasMetadata.ativos[id];
                    if (ativo) {
                        ativo = ativo || {};
                        ativo[$elemento.attr("name").toLowerCase()] = $elemento.val();
                        window.mesasMetadata.ativos[id] = ativo;
                        // -
                        atualizarMesas(id);
                    }
                }
            });
        }
    };
    var incluiMesa = function() {
        if (window.mesasMetadata && window.mesasMetadata.ativos) {
            window.mesasMetadata.ativos.push({});
            
            let max = 0;
            window.mesasMetadata.ativos.forEach((e, i) => max = Math.max(max, i));
            atualizarMesas(max);
            carregaMesa(max);
        }
    };
    var excluirMesa = function() {
        if (window.mesasMetadata && window.mesasMetadata.ativos) {
            let ativos = window.mesasMetadata.ativos;
            // -
            let i = parseInt($("#listaMesas").find("button.active[data-id]").data("id"));
            if (i > -1) {
                let ativo = ativos[i];
                ativos.splice(i, 1);
                // -
                i = (ativo.idmesa || -1);
                if (i > 0) {
                    window.mesasMetadata.excluidos.push(i);
                }
                // -
                window.mesasMetadata.ativos = ativos;
                // -
                atualizarMesas();
                $("#addMesasModal").find("input,select,textarea").val("");
            }
        }
    };

    // - geral para cada input que eventualmente posua máscara!

    var ajustarMascaras = function($elemento) {
        if ($elemento) {
            $elemento.on("keydown", function(e){
                let $el = $(this).unmask();
                let length = $el.val().length - (!e.keyCode || e.keyCode == 8 ? 1 : 0);
                if ($el.hasClass("cpf-cnpj")) {
                    if (length < 11) {
                        $el.unmask().mask("999.999.999-99");
                    } 
                    else {
                        $el.unmask().mask("99.999.999/9999-99");
                    }
                }
                else if ($el.data("mask2")) {
                    $el.mask($el.data("mask2"));
                }

                // - acerta a posição do cursor
                setTimeout(() => this.selectionStart = this.selectionEnd = 9999, 0);

                // - atualiza o valor para aplicar a máscara correta!
                let value = $el.val();
                $el.val("");
                $el.val(value);
            });
        }
    }

</script>