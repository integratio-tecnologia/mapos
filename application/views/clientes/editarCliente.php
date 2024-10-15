<script src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/funcoes.js"></script>
<style>
    #imgSenha {
        width: 18px;
        cursor: pointer;
    }

    /* Hiding the checkbox, but allowing it to be focused */
    .badgebox {
        opacity: 0;
    }

    .badgebox+.badge {
        /* Move the check mark away when unchecked */
        text-indent: -999999px;
        /* Makes the badge's width stay the same checked and unchecked */
        width: 27px;
    }

    .badgebox:focus+.badge {
        /* Set something to make the badge looks focused */
        /* This really depends on the application, in my case it was: */
        /* Adding a light border */
        box-shadow: inset 0px 0px 5px;
        /* Taking the difference out of the padding */
    }

    .badgebox:checked+.badge {
        /* Move the check mark back when checked */
        text-indent: 0;
    }

    .control-group.error .help-inline {
        display: flex;
    }

    .form-horizontal .control-group {
        border-bottom: 1px solid #ffffff;
    }

    .form-horizontal .controls {
        margin-left: 20px;
        padding-bottom: 8px 0;
    }

    .form-horizontal .control-label {
        text-align: left;
        padding-top: 15px;
    }

    .nopadding {
        padding: 0 20px !important;
        margin-right: 20px;
    }

    .widget-title h5 {
        padding-bottom: 30px;
        text-align-last: left;
        font-size: 2em;
        font-weight: 500;
    }

    @media (max-width: 480px) {
        form {
            display: contents !important;
        }

        .form-horizontal .control-label {
            margin-bottom: -6px;
        }

        .btn-xs {
            position: initial !important;
        }
    }
</style>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-user"></i>
                </span>
                <h5>Editar Cliente</h5>
            </div>
            <?php if ($custom_error != '') {
                echo '<div class="alert alert-danger">' . $custom_error . '</div>';
            } ?>
            <div class="widget-content nopadding">
                <div id="divCliente">
                    <ul class="nav nav-tabs">
                        <li class="active" id="tabDados"><a href="#tab1" data-toggle="tab">Dados do Cliente</a></li>
                        <li id="tabContatos"><a href="#tab2" data-toggle="tab">Contatos</a></li>
                        <li id="tabFiliais"><a href="#tab3" data-toggle="tab">Filiais</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <div id="divCadastrarCliente">
                                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal">
                                    <?php echo form_hidden('idClientes', $result->idClientes) ?>

                                    <div class="span6" style="margin-left: 0; padding-top: 1%">
                                        <div class="control-group">
                                            <label for="documento" class="control-label">CPF/CNPJ</label>
                                            <div class="controls">
                                                <input id="documento" class="cpfcnpj" type="text" name="documento" value="<?php echo $result->documento; ?>" />
                                                <button id="buscar_info_cnpj" class="btn btn-xs" type="button">Buscar(CNPJ)</button>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="ie" class="control-label">Inscr.Est.</label>
                                            <div class="controls">
                                                <input id="ie" type="text" name="ie" value="<?php echo $result->ie; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="nomeCliente" class="control-label">Nome/Razão Social<span class="required">*</span></label>
                                            <div class="controls">
                                                <input id="nomeCliente" type="text" name="nomeCliente" value="<?php echo $result->nomeCliente; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="nomeFantasia" class="control-label">Nome Fantasia</label>
                                            <div class="controls">
                                                <input id="nomeFantasia" type="text" name="nomeFantasia" value="<?php echo $result->nomeFantasia; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="contato" class="control-label">Contato</label>
                                            <div class="controls">
                                                <input class="contato" type="text" name="contato" value="<?php echo $result->contato; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="telefone" class="control-label">Telefone</label>
                                            <div class="controls">
                                                <input id="telefone" type="text" name="telefone" value="<?php echo $result->telefone; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="celular" class="control-label">Celular</label>
                                            <div class="controls">
                                                <input id="celular" type="text" name="celular" value="<?php echo $result->celular; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="email" class="control-label">Email</label>
                                            <div class="controls">
                                                <input id="email" type="text" autocomplete="off" aria-autocomplete="none" name="email" value="<?php echo $result->email; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="senha" class="control-label">Senha</label>
                                            <div class="controls">
                                                <input id="senha" type="password" autocomplete="off" aria-autocomplete="none" name="senha" value="" placeholder="Não preencha se não quiser alterar." />
                                                <img id="imgSenha" src="<?php echo base_url() ?>assets/img/eye.svg" alt="">
                                            </div>
                                        </div>
                                    </div>
                
                                    <div class="span6" style="padding-top: 1%;">
                                        <div class="control-group" class="control-label">
                                            <label for="cep" class="control-label">CEP</label>
                                            <div class="controls">
                                                <input id="cep" type="text" name="cep" value="<?php echo $result->cep; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group" class="control-label">
                                            <label for="rua" class="control-label">Rua</label>
                                            <div class="controls">
                                                <input id="rua" type="text" name="rua" value="<?php echo $result->rua; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="numero" class="control-label">Número</label>
                                            <div class="controls">
                                                <input id="numero" type="text" name="numero" value="<?php echo $result->numero; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="complemento" class="control-label">Complemento</label>
                                            <div class="controls">
                                                <input id="complemento" type="text" name="complemento" value="<?php echo $result->complemento; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="bairro" class="control-label">Bairro</label>
                                            <div class="controls">
                                                <input id="bairro" type="text" name="bairro" value="<?php echo $result->bairro; ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="cidade" class="control-label">Cidade</label>
                                            <div class="controls">
                                                <input id="cidade" type="text" name="cidade" value="<?php echo $result->cidade ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="estado" class="control-label">Estado</label>
                                            <div class="controls">
                                                <select id="estado" name="estado" class="">
                                                    <option value="">Selecione...</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label for="observacoes" class="control-label">Observações</label>
                                            <div class="controls">
                                                <input id="observacoes" type="text" name="observacoes" value="<?php echo $result->observacoes ?>" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Tipo de Cliente</label>
                                            <div class="controls">
                                                <label for="fornecedor" class="btn btn-default">Fornecedor
                                                    <input type="checkbox" id="fornecedor" name="fornecedor" class="badgebox" value="1" <?= ($result->fornecedor == 1) ? 'checked' : '' ?>>
                                                    <span class="badge">&check;</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="span12">
                                            <div class="span6 offset3" style="display:flex;justify-content: center">
                                                <button type="submit" class="button btn btn-primary" style="max-width: 160px">
                                                    <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
                                                <a title="Voltar" class="button btn btn-warning" href="<?php echo site_url() ?>/clientes"><span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <div class="span12" id="divCadastrarContatos" style="padding-top: 2%">
                                <form id="formContato" action="<?php echo base_url() ?>index.php/clientes/adicionarContato" method="post" class="form-horizontal">
                                    <?php echo form_hidden('idClientes', $result->idClientes) ?>
                                    <div class="span3" style="margin-left: 0;">
                                        <input type="hidden" name="idContatos" id="idContatos" />
                                        <label for="">Nome</label>
                                        <input type="text" class="span12" name="nomeContato" id="nomeContato" placeholder="Digite o nome do contato" />
                                    </div>
                                    <div class="span2">
                                        <label for="">Telefone</label>
                                        <input type="text" class="span12" name="telefoneContato" id="telefoneContato" placeholder="Telefone" />
                                    </div>
                                    <div class="span2">
                                        <label for="">Celular</label>
                                        <input type="text" class="span12" name="celularContato" id="celularContato" placeholder="Celular" />
                                    </div>
                                    <div class="span3">
                                        <label for="">Email</label>
                                        <input type="text" class="span12" name="emailContato" id="emailContato" placeholder="Email" />
                                    </div>
                                    <div class="span2">
                                        <label for="">&nbsp;</label>
                                        <button class="button btn btn-success" id="btnAdicionarContato">
                                            <span class="button__icon"><i class='bx bx-plus-circle'></i></span> <span class="button__text2">Adicionar</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="widget-box" id="divContatos">
                                <div class="widget-content nopadding tab-content">
                                    <!-- Incluir paginação na tabela Contatos -->
                                    <table width="100%" class="table table-bordered" id="tblContatos">
                                        <thead>
                                            <tr>
                                                <th>Contato</th>
                                                <th width="10%">Telefone</th>
                                                <th width="10%">Celular</th>
                                                <th width="20%">Email</th>
                                                <th width="6%">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($contatos as $c) {
                                                echo '<tr>';
                                                echo '<td>' . $c->nomeContato . '</td>';
                                                echo '<td>' . $c->telefone . '</td>';
                                                echo '<td>' . $c->celular . '</td>';
                                                echo '<td>' . $c->email . '</td>';
                                                echo '<td><div align="center"><span idAcao="' . $c->idContatos . '" title="Excluir Contato" class="btn-nwe4 contato"><i class="bx bx-trash-alt"></i></span></div></td>';
                                                echo '</tr>';
                                            } ?>
                                        </tbody>
                                        <!-- <tfoot>
                                            <tr>
                                                <td colspan="4" style="text-align: center">Quantidade de Contatos: <?php echo count($contatos); ?></td>
                                            </tr>
                                        </tfoot> -->
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <div class="span12" id="divCadastrarFiliais" style="padding-top: 2%; margin-left: 0">
                                <!-- Incluir botão de adicionar acima da tabela de exibição paginada -->
                                <!-- <div class="widget-title" style="margin: -20px 0 0">
                                    <span class="icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <h5>Filiais: <?php echo count($filiais); ?></h5>
                                </div> -->
                                <div class="span12" style="margin-left: 0">
                                    <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) { ?>
                                        <div class="span3">
                                            <a href="#modal-filial" id="btn-add-filial" role="button" data-toggle="modal" class="button btn btn-mini btn-success"
                                                style="max-width: 165px" action="<?php echo base_url() ?>index.php/clientes/adicionarFilial">
                                                <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">
                                                    Adicionar Filial
                                                </span>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <!-- <form class="span9" method="get" action="<?= base_url() ?>index.php/clientes/filiais"
                                        style="display: flex; justify-content: flex-end;">
                                        <div class="span3">
                                            <input type="text" name="pesquisaFilial" id="pesquisaFilial"
                                                placeholder="Buscar por Nome, Doc, Email ou Telefone..." class="span12"
                                                value="<?= $this->input->get('pesquisaFilial') ?>">
                                        </div>
                                        <div class="span1">
                                            <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                                                <span class="button__icon"><i class='bx bx-search-alt'></i></span></button>
                                        </div>
                                    </form> -->
                                </div>

                                <div class="widget-box" id="divFiliais">
                                    <div class="widget-content nopadding tab-content">
                                        <table id="tblFiliais" class="table table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%">Cod.</th>
                                                    <th width="20%">Razão Social</th>
                                                    <th width="20%">Nome Fantasia</th>
                                                    <th width="15%">CNPJ</th>
                                                    <th width="15%">I.E.</th>
                                                    <th>Telefone</th>
                                                    <th>Celular</th>
                                                    <th>Email</th>
                                                    <th>Endereço</th>
                                                    <th>Número</th>
                                                    <th>Complemento</th>
                                                    <th>Bairro</th>
                                                    <th>Cidade</th>
                                                    <th>Estado</th>
                                                    <th>CEP</th>
                                                    <th>Observações</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!$filiais) {
                                                    echo '<tr>
                                                <td colspan="9">Nenhuma Filial Cadastrada</td>
                                            </tr>';
                                                }
                                                foreach ($filiais as $f) {
                                                    echo '<tr>';
                                                    echo '<td style="text-align: center;">' . $f->idFiliais . '</td>';
                                                    echo '<td>' . $f->nome . '</td>';
                                                    echo '<td>' . $f->nomeFantasia . '</td>';
                                                    echo '<td>' . $f->cnpj . '</td>';
                                                    echo '<td>' . $f->ie . '</td>';
                                                    echo '<td>' . $f->telefone . '</td>';
                                                    echo '<td>' . $f->celular . '</td>';
                                                    echo '<td>' . $f->email . '</td>';
                                                    echo '<td>' . $f->rua . '</td>';
                                                    echo '<td>' . $f->numero . '</td>';
                                                    echo '<td>' . $f->complemento . '</td>';
                                                    echo '<td>' . $f->bairro . '</td>';
                                                    echo '<td>' . $f->cidade . '</td>';
                                                    echo '<td>' . $f->estado . '</td>';
                                                    echo '<td>' . $f->cep . '</td>';
                                                    echo '<td>' . $f->observacoes . '</td>';
                                                    echo '<td>';
                                                    // incluir botão de editar filial no modal
                                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                                                        echo '<a href="#modal-filial" style="margin-right: 1%" data-toggle="modal" role="button" idFiliais="' . $f->idFiliais . '" nomeFilial="' . $f->nome . '" nomeFantasiaFilial="' . $f->nomeFantasia . '" cnpjFilial="' . $f->cnpj . '" ieFilial="' . $f->ie . '" telefoneFilial="' . $f->telefone . '" celularFilial="' . $f->celular . '" emailFilial="' . $f->email . '" ruaFilial="' . $f->rua . '" numeroFilial="' . $f->numero . '" complementoFilial="' . $f->complemento . '" bairroFilial="' . $f->bairro . '" cidadeFilial="' . $f->cidade . '" estadoFilial="' . $f->estado . '" cepFilial="' . $f->cep . '" observacoesFilial="' . $f->observacoes . '" class="btn-nwe3 editarFilial" title="Editar Filial"><i class="bx bx-edit"></i></a>';
                                                    }
                                                    echo '<a href="#modal-excluir-filial" data-toggle="modal" role="button" idAcao="' . $f->idFiliais . '" class="btn-nwe4 btn-del-filial" title="Excluir Filial"><i class="bx bx-trash-alt"></i></a>';
                                                    // echo '<div align="center"><span idAcao="' . $f->idFiliais . '" title="Excluir Filial" class="btn-nwe4 excluirfilial"><i class="bx bx-trash-alt"></i></span></div>';
                                                    echo '</td>';
                                                    echo '</tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cadastrar Filial -->
<div id="modal-filial" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
    <form id="formFilial" action="" method="post" class="form-horizontal">
        <?php echo form_hidden('idClientes', $result->idClientes) ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3 id="modalLabelFilial"></h3>
        </div>
        <div class="modal-body">
            <div class="span12 alert alert-info" style="margin-left: 0"> Obrigatório o preenchimento dos campos com asterisco.</div>
            <input type="hidden" name="idFiliais" id="idFiliais" />
            <div class="span6" style="margin-left: 0;">
                <div class="control-group">
                    <label for="cnpjFilial" class="control-label">CNPJ</label>
                    <div class="controls">
                        <input id="cnpjFilial" class="cpfcnpj" type="text" name="cnpjFilial" onblur="" placeholder="Insira o CNPJ da filial" aria-placeholder="Insira o CNPJ da filial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="ieFilial" class="control-label">Inscr. Estadual</label>
                    <div class="controls">
                        <input id="ieFilial" type="text" name="ieFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="nomeFilial" class="control-label">Razão Social<span class="required">*</span></label>
                    <div class="controls">
                        <input id="nomeFilial" type="text" name="nomeFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="nomeFantasiaFilial" class="control-label">Nome Fantasia</label>
                    <div class="controls">
                        <input id="nomeFantasiaFilial" type="text" name="nomeFantasiaFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="telefoneFilial" class="control-label">Telefone</label>
                    <div class="controls">
                        <input id="telefoneFilial" type="text" name="telefoneFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="celularFilial" class="control-label">Celular</label>
                    <div class="controls">
                        <input id="celularFilial" type="text" name="celularFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="emailFilial" class="control-label">Email</label>
                    <div class="controls">
                        <input id="emailFilial" type="text" name="emailFilial" />
                    </div>
                </div>
            </div>
            <div class="span6" style="margin-left: 0;">
                <div class="control-group">
                    <label for="cepFilial" class="control-label">CEP</label>
                    <div class="controls">
                        <input id="cepFilial" type="text" name="cepFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="ruaFilial" class="control-label">Rua</label>
                    <div class="controls">
                        <input id="ruaFilial" type="text" name="ruaFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="numeroFilial" class="control-label">Número</label>
                    <div class="controls">
                        <input id="numeroFilial" type="text" name="numeroFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="complementoFilial" class="control-label">Complemento</label>
                    <div class="controls">
                        <input id="complementoFilial" type="text" name="complementoFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="bairroFilial" class="control-label">Bairro</label>
                    <div class="controls">
                        <input id="bairroFilial" type="text" name="bairroFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="cidadeFilial" class="control-label">Cidade</label>
                    <div class="controls">
                        <input id="cidadeFilial" type="text" name="cidadeFilial" />
                    </div>
                </div>
                <div class="control-group">
                    <label for="estadoFilial" class="control-label">Estado</label>
                    <div class="controls">
                        <select id="estadoFilial" name="estadoFilial" class="">
                            <option value="">Selecione...</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label for="observacoesFilial" class="control-label">Observações</label>
                    <div class="controls">
                        <input id="observacoesFilial" type="text" name="observacoesFilial" />
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" 
                id="btn-cancelar-filial"><span class="button__icon"><i class="bx bx-x"></i></span><span
                    class="button__text2">Cancelar</span></button>
            <button class="button btn btn-mini btn-success"><span class="button__icon"><i class='bx bx-save'></i></span><span
                    class="button__text2">Salvar</span></button>
        </div>
    </form>
</div>
<!-- FIM - Modal Cadastrar Filial -->

<!-- Modal Excluir Filial -->
<div id="modal-excluir-filial" class="modal hide fade" role="dialog" aria-labelledby="myModalLabel">
    <form action="<?php echo base_url() ?>index.php/clientes/excluirFilial" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h5 id="myModalLabel"><i class="fas fa-trash-alt"></i> Excluir Filial</h5>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Deseja realmente excluir esta Filial?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button type="button" class="button btn btn-warning" data-dismiss="modal"
              id="btn-cancel-del-filial"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button type="button" class="button btn btn-danger excluirFilial"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>
<!-- FIM - Modal Excluir Filial -->

<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let container = document.querySelector('div');
        let input = document.querySelector('#senha');
        let icon = document.querySelector('#imgSenha');

        icon.addEventListener('click', function() {
            container.classList.toggle('visible');
            if (container.classList.contains('visible')) {
                icon.src = '<?php echo base_url() ?>assets/img/eye-off.svg';
                input.type = 'text';
            } else {
                icon.src = '<?php echo base_url() ?>assets/img/eye.svg'
                input.type = 'password';
            }
        });

        $.getJSON('<?php echo base_url() ?>assets/json/estados.json', function(data) {
            for (i in data.estados) {
                $('#estado').append(new Option(data.estados[i].nome, data.estados[i].sigla));
                $('#estadoFilial').append(new Option(data.estados[i].nome, data.estados[i].sigla));
            }
            var curState = '<?php echo $result->estado; ?>';
            if (curState) {
                $("#estado option[value=" + curState + "]").prop("selected", true);
                $("#estadoFilial option[value=" + curState + "]").prop("selected", true);
            }

        });

        $(document).on('click', '#btn-add-filial', function (event) {
            $('#modalLabelFilial').text('Cadastrar Filial');
            $('#formFilial').attr('action', '<?php echo base_url() ?>index.php/clientes/adicionarFilial');
            $("#idFiliais").val('');
            $("#nomeFilial").val('');
            $("#nomeFantasiaFilial").val('');
            $("#ieFilial").val('');
            $("#telefoneFilial").val('');
            $("#celularFilial").val('');
            $("#emailFilial").val('');
            $("#ruaFilial").val('');
            $("#numeroFilial").val('');
            $("#complementoFilial").val('');
            $("#bairroFilial").val('');
            $("#cidadeFilial").val('');
            $("#estadoFilial").val('');
            $("#cepFilial").val('');
            $("#observacoesFilial").val('');
            $('#modal-filial').show();
            $("#cnpjFilial").val('').focus();
        });

        $(document).on('click', '.btn-del-filial', function (event) {
            var idFilial = $(this).attr('idAcao');
            $('.excluirFilial').attr('idAcao', idFilial);
        });

        $('#formCliente').validate({
            rules: {
                nomeCliente: {
                    required: true
                },
            },
            messages: {
                nomeCliente: {
                    required: 'Campo Requerido.'
                },
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });

        $('#formContato').validate({
            rules: {
                nomeContato: {
                    required: true
                },
            },
            messages: {
                nomeContato: {
                    required: 'Campo Requerido.'
                },
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            },

            submitHandler: function (form) {
                var dados = $(form).serialize();
                $("#divContatos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/clientes/adicionarContato",
                    data: dados,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true) {
                            $("#divContatos").load("<?php echo current_url(); ?> #divContatos");
                            $("#telefoneContato").val('');
                            $("#celularContato").val('');
                            $("#emailContato").val('');
                            $("#nomeContato").val('').focus();
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar adicionar contato."
                            });
                        }
                    }
                });
                return false;
            }
        });

        $('#formFilial').validate({
            rules: {
                nomeFilial: {
                    required: true
                },
            },
            messages: {
                nomeFilial: {
                    required: 'Campo Requerido.'
                },
            },
            rules: {
                cnpjFilial: {
                    required: true
                },
            },
            messages: {
                cnpjFilial: {
                    required: 'Campo Requerido.'
                },
            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            },

            submitHandler: function (form) {
                var dados = $(form).serialize();
                var action = $(form).attr('action')
                $("#divFiliais").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: action,
                    data: dados,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true) {
                            $("#divFiliais").load("<?php echo current_url(); ?> #divFiliais");
                            $("#idFiliais").val('');
                            $("#ieFilial").val('');
                            $("#telefoneFilial").val('');
                            $("#celularFilial").val('');
                            $("#emailFilial").val('');
                            $("#ruaFilial").val('');
                            $("#numeroFilial").val('');
                            $("#bairroFilial").val('');
                            $("#cidadeFilial").val('');
                            $("#estadoFilial").val('');
                            $("#complementoFilial").val('');
                            $("#cepFilial").val('');
                            $("#observacoesFilial").val('');
                            $("#nomeFantasiaFilial").val('');
                            $("#nomeFilial").val('');
                            $("#cnpjFilial").val('');
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "<?php echo $custom_error ?>"
                            });
                        }
                    }
                });
                $('#btn-cancelar-filial').trigger('click');
                return false
            }
        });

        $(document).on('click', '.contato', function (event) {
            var idContato = $(this).attr('idAcao');
            var idCliente = "<?php echo $result->idClientes ?>"
            if ((idCliente % 1) == 0) {
                $("#divContatos").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/clientes/excluirContato",
                    data: "idContatos=" + idContato + "&idClientes=" + idCliente,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true) {
                            $("#divContatos").load("<?php echo current_url(); ?> #divContatos");
                            $("#telefoneContato").val('');
                            $("#celularContato").val('');
                            $("#emailContato").val('');
                            $("#nomeContato").val('');

                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar excluir o contato."
                            });
                        }
                    }
                });
                return false;
            }

        });

        $(document).on('click', '.excluirFilial', function (event) {
            var idFilial = $(this).attr('idAcao');
            var idCliente = "<?php echo $result->idClientes ?>"
            $('#btn-cancel-del-filial').trigger('click');
            if ((idCliente % 1) == 0) {
                $("#divFiliais").html("<div class='progress progress-info progress-striped active'><div class='bar' style='width: 100%'></div></div>");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>index.php/clientes/excluirFilial",
                    data: "idFiliais=" + idFilial + "&idClientes=" + idCliente,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result == true) {
                            $("#divFiliais").load("<?php echo current_url(); ?> #divFiliais");
                        } else {
                            Swal.fire({
                                type: "error",
                                title: "Atenção",
                                text: "Ocorreu um erro ao tentar excluir a filial."
                            });
                        }
                    }
                });
                return false;
            }

        });

        $(document).on('click', '.editarFilial', function(event) {
            $('#modalLabelFilial').text('Editar Filial');
            $('#formFilial').attr('action', '<?php echo base_url() ?>index.php/clientes/editarFilial');
            $("#idFiliais").val($(this).attr('idFiliais'));
            $("#nomeFilial").val($(this).attr('nomeFilial'));
            $("#nomeFantasiaFilial").val($(this).attr('nomeFantasiaFilial'));
            $("#ieFilial").val($(this).attr('ieFilial'));
            $("#telefoneFilial").val($(this).attr('telefoneFilial'));
            $("#celularFilial").val($(this).attr('celularFilial'));
            $("#emailFilial").val($(this).attr('emailFilial'));
            $("#ruaFilial").val($(this).attr('ruaFilial'));
            $("#numeroFilial").val($(this).attr('numeroFilial'));
            $("#complementoFilial").val($(this).attr('complementoFilial'));
            $("#bairroFilial").val($(this).attr('bairroFilial'));
            $("#cidadeFilial").val($(this).attr('cidadeFilial'));
            $("#estadoFilial").val($(this).attr('estadoFilial'));
            $("#cepFilial").val($(this).attr('cepFilial'));
            $("#observacoesFilial").val($(this).attr('observacoesFilial'));
            $('#modal-filial').show();
            $("#cnpjFilial").val($(this).attr('cnpjFilial')).focus();
        });
    });
</script>
