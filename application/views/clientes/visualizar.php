<div class="widget-box">
    <div class="widget-title" style="margin: 0;font-size: 1.1em">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Cliente</a></li>
            <li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>
            <li><a data-toggle="tab" href="#tab3">Vendas</a></li>
            <li><a data-toggle="tab" href="#tab4">Equipamentos</a></li>
            <li><a data-toggle="tab" href="#tab5">Cobranças</a></li>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <div class="accordion" id="collapse-group">
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title" style="margin-left: 10px;">
                            <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                <span><i class='bx bx-user icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Dados Pessoais</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse in accordion-body" id="collapseGOne">
                        <div class="widget-content">
                            <table class="table table-bordered" style="border: 1px solid #ddd">
                                <tbody>
                                <!-- Situação -->
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong>Situação:</strong></td>
                                    <td>
                                        <?php if($result->situacao == 1) : ?>
                                            <span class="label label-success">Ativo</span>
                                        <?php else : ?>
                                            <span class="label label-important">Inativo</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <!-- Tipo de Pessoa -->
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong>Tipo de Pessoa:</strong></td>
                                    <td>
                                        <?php if($result->pessoa_fisica == 1) : ?>
                                            <span class="label label-warning">Pessoa Física</span>
                                        <?php else : ?>
                                            <span class="label label-info">Pessoa Jurídica</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong><?= $result->pessoa_fisica ? 'Nome:' : 'Razão Social:'; ?></strong></td>
                                    <td>
                                        <?php echo $result->nomeCliente ?>
                                    </td>
                                </tr>
                                <?php if( ! $result->pessoa_fisica ) : ?>
                                    <tr>
                                        <td style="text-align: right;"><strong>Nome Fantasia:</strong></td>
                                        <td>
                                            <?= $result->nomeFantasia ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="text-align: right"><strong><?= $result->pessoa_fisica ? 'CPF:' : 'CNPJ:'; ?></strong></td>
                                    <td>
                                        <?php echo $result->documento ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong><?= $result->pessoa_fisica ? 'RG:' : 'Inscr. Estadual:'; ?></strong></td>
                                    <td>
                                        <?= $result->rg_ie ?>
                                    </td>
                                </tr>
                                <?php if( $result->pessoa_fisica ) : ?>
                                    <tr>
                                        <td style="text-align: right"><strong>Data de Nascimento:</strong></td>
                                        <td>
                                            <?= date('d/m/Y', strtotime($result->dataNascimento)) ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if( $result->pessoa_fisica ) : ?>
                                    <tr>
                                        <td style="text-align: right"><strong>Sexo:</strong></td>
                                        <td>
                                            <?= $result->sexo ; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td style="text-align: right"><strong>Observações:</strong></td>
                                    <td>
                                        <?= $result->obsCliente ; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Data de Cadastro</strong></td>
                                    <td>
                                        <?php echo date('d/m/Y', strtotime($result->dataCadastro)) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Tipo do Cliente</strong></td>
                                    <td>
                                        <span class="label label-<?= $result->fornecedor ? 'primary' : 'success' ; ?>"><?= $result->fornecedor ? 'Fornecedor' : 'Cliente' ; ?></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title" style="margin-left: 10px;">
                            <a data-parent="#collapse-group" href="#collapseGTwo" data-toggle="collapse">
                                <span><i class='bx bx-phone icon-cli'></i></span>
                                <h5 style="padding-left: 28px">Contatos</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGTwo">
                        <div class="widget-content">
                            <table class="table table-bordered" style="border: 1px solid #ddd">
                                <tbody>
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong>Contato:</strong></td>
                                    <td>
                                        <?php echo $result->contato ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong>Telefone</strong></td>
                                    <td>
                                        <a href="tel:+55<?= preg_replace('/[^0-9]/', '', $result->telefone) ;?>" title="Iniciar ligação telefônica" aria-placeholder="Iniciar ligação telefônica"><?php echo $result->telefone ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Celular</strong></td>
                                    <td>
                                        <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $result->celular) ;?>" target="_blank" title="Iniciar conversa no WhatsApp" aria-placeholder="Iniciar conversa no WhatsApp"><?php echo $result->celular ?></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Email</strong></td>
                                    <td>
                                        <a href="mailto:<?= $result->email ;?>" title="Enviar e-mail" aria-placeholder="Enviar e-mail"><?php echo $result->email ?></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title" style="margin-left: 10px;">
                            <a data-parent="#collapse-group" href="#collapseGThree" data-toggle="collapse">
                                <span><i class='bx bx-map-alt icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Endereço</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGThree">
                        <div class="widget-content">
                            <table class="table table-bordered th" style="border: 1px solid #ddd;border-left: 1px solid #ddd">
                                <tbody>
                                <tr>
                                    <td style="text-align: right; width: 30%;"><strong>Rua</strong></td>
                                    <td>
                                        <?php echo $result->rua ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Número</strong></td>
                                    <td>
                                        <?php echo $result->numero ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Complemento</strong></td>
                                    <td>
                                        <?php echo $result->complemento ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Bairro</strong></td>
                                    <td>
                                        <?php echo $result->bairro ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Cidade</strong></td>
                                    <td>
                                        <?php echo $result->cidade ?> -
                                        <?php echo $result->estado ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>CEP</strong></td>
                                    <td>
                                        <?php echo $result->cep ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Tab 2-->
        <div id="tab2" class="tab-pane" style="min-height: 300px">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <h5 style="margin-top: 30px;">Ordens de Serviço</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">N° OS</th>
                            <th width="10%">Data Inicial</th>
                            <th width="10%">Data Final</th>
                            <th>Descricao</th>
                            <th>Defeito</th>
                            <th style="text-align: center; width: 15%;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!$result_os) {
                            echo '<tr><td colspan="6">Nenhuma O.S. encontrada</td></tr>';
                        } else {
                            foreach ($result_os as $r) {
                                $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                                $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                                echo '<tr>';
                                echo '<td>' . $r->idOs . '</td>';
                                echo '<td>' . $dataInicial . '</td>';
                                echo '<td>' . $dataFinal . '</td>';
                                echo '<td>' . $r->descricaoProduto . '</td>';
                                echo '<td>' . $r->defeito . '</td>';
                                echo '<td style="text-align: center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" style="margin-right: 1%" class="btn-nwe3" title="Editar OS"><i class="bx bx-edit bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $r->idOs . '" style="margin-right: 1%" class="btn-nwe4" title="Excluir OS"><i class="bx bx-trash-alt bx-xs"></i></a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Tab 3-->
        <div id="tab3" class="tab-pane" style="min-height: 300px">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <h5 style="margin-top: 30px;">Vendas</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Data da Venda</th>
                            <th>Vendedor</th>
                            <th style="width:10%; text-align: center;">Venc. Garantia</th>
                            <th style="width:10%; text-align: center;">Status</th>
                            <th style="width:10%; text-align:center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!$result_vendas) {
                            echo '<tr><td colspan="6">Nenhuma venda foi encontrada.</td></tr>';
                        } else {
                            foreach ($result_vendas as $r) {
                                $vencGarantia = '';
                                if ($r->garantia && is_numeric($r->garantia)) {
                                    $vencGarantia = dateInterval($r->dataVenda, $r->garantia);
                                }

                                $corGarantia = '';
                                if (!empty($vencGarantia)) {
                                    $dataGarantia = explode('/', $vencGarantia);
                                    $dataGarantiaFormatada = $dataGarantia[2] . '-' . $dataGarantia[1] . '-' . $dataGarantia[0];
                                    $corGarantia = (strtotime($dataGarantiaFormatada) >= strtotime(date('d-m-Y'))) ? '#4d9c79' : '#f24c6f';
                                } elseif ($r->garantia == "0") {
                                    $vencGarantia = 'Sem Garantia';
                                }

                                $corStatus = match($r->status) {
                                    'Aberto' => '#00cd00',
                                    'Em Andamento' => '#436eee',
                                    'Orçamento' => '#CDB380',
                                    'Negociação' => '#AEB404',
                                    'Cancelado' => '#CD0000',
                                    'Finalizado' => '#256',
                                    'Faturado' => '#B266FF',
                                    'Aguardando Peças' => '#FF7F00',
                                    'Aprovado' => '#808080',
                                    default => '#E0E4CC',
                                };

                                $dataVenda = date(('d/m/Y'), strtotime($r->dataVenda));
                                
                                echo '<tr>';
                                echo '<td>' . $r->idVendas . '</td>';
                                echo '<td>' . $dataVenda . '</td>';
                                echo '<td>' . $r->vendedor . '</td>';
                                echo '<td style="text-align:center"><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';

                                echo '<td style="text-align:center"><span class="badge" style="background-color: ' . $corStatus . '; border-color: ' . $corStatus . '">' . $r->status . '</span> </td>';
                                echo '<td style="text-align: center">';

                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimir/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir A4"><i class="bx bx-printer bx-xs"></i></a>';
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimirTermica/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir Não Fiscal"><i class="bx bx-printer bx-xs"></i></a>';

                                $editavel = $r->faturado == 1 ? $this->data['configuration']['control_edit_vendas'] == '1' : true;

                                if ($r->faturado != 1 || $editavel) {
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
                                        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="btn-nwe3" title="Editar venda"><i class="bx bx-edit bx-xs"></i></a>';
                                    }
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Tab 4-->
        <div id="tab4" class="tab-pane" style="min-height: 300px">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <h5 style="margin-top: 30px;">Equipamentos</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">Cod.</th>
                            <th width="10%">Equipamento</th>
                            <th>Descrição</th>
                            <th width="10%">Marca</th>
                            <th width="10%">Modelo</th>
                            <th width="10%">Número de Série</th>
                            <th style="width:15%; text-align:center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!$result_equipamentos) {
                            echo '<tr><td colspan="7">Nenhum Equipamento Cadastrado</td></tr>';
                        } else {
                            foreach ($result_equipamentos as $r) {
                                echo '<tr>';
                                echo '<td>' . $r->idEquipamentos . '</td>';
                                echo '<td>' . $r->equipamento . '</td>';
                                echo '<td>' . $r->descricao . '</td>';
                                echo '<td>' . $r->marca . '</td>';
                                echo '<td>' . $r->modelo . '</td>';
                                echo '<td>' . $r->num_serie . '</td>';
                                echo '<td style="text-align: center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vEquipamento')) {
                                    echo '<a href="' . base_url() . 'index.php/equipamentos/visualizar/' . $r->idEquipamentos . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eEquipamento')) {
                                    echo '<a href="' . base_url() . 'index.php/equipamentos/editar/' . $r->idEquipamentos . '" style="margin-right: 1%" class="btn-nwe3" title="Editar Equipamento"><i class="bx bx-edit bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dEquipamento')) {
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" equipamento="' . $r->idEquipamentos . '" style="margin-right: 1%" class="btn-nwe4" title="Excluir Equipamento"><i class="bx bx-trash-alt bx-xs"></i></a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--Tab 5-->
        <div id="tab5" class="tab-pane" style="min-height: 300px">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <h5 style="margin-top: 30px;">Cobranças</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">Cod.</th>
                            <th>Descrição</th>
                            <th width="10%">Valor</th>
                            <th width="10%">Vencimento</th>
                            <th width="10%">Tipo</th>
                            <th width="10%">Status</th>
                            <th style="width: 15%; text-align: center;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!$result_cobrancas) {
                            echo '<tr><td colspan="7">Nenhuma Cobrança Cadastrada</td></tr>';
                        } else {
                            foreach ($result_cobrancas as $r) {
                                $cobrancaStatus = getCobrancaTransactionStatus(
                                    $this->config->item('payment_gateways'),
                                    $r->payment_gateway,
                                    $r->status
                                );
                                echo '<tr>';
                                echo '<td>' . $r->idCobranca . '</td>';
                                echo '<td>' . $r->message . '</td>';
                                echo '<td>' . number_format($r->total / 100, 2, ',', '.') . '</td>';
                                echo '<td>' . date('d/m/Y', strtotime($r->expire_at)) . '</td>';
                                echo '<td>' . $r->payment_method . '</td>';
                                echo '<td>' . $cobrancaStatus . '</td>';
                                echo '<td style="text-align: center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCobranca')) {
                                    echo '<a href="' . base_url() . 'index.php/cobrancas/visualizar/' . $r->idCobranca . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCobranca')) {
                                    echo '<a href="' . base_url() . 'index.php/cobrancas/editar/' . $r->idCobranca . '" style="margin
                                    -right: 1%" class="btn-nwe3" title="Editar Cobrança"><i class="bx bx-edit bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dCobranca')) {
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" cobranca="' . $r->idCobranca . '" style="margin-right: 1%" class="btn-nwe4" title="Excluir Cobrança"><i class="bx bx-trash-alt bx-xs"></i></a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                echo '<a title="Icon Title" class="button btn btn-mini btn-info" style="min-width: 140px; top:10px" href="' . base_url() . 'index.php/clientes/editar/' . $result->idClientes . '">
                    <span class="button__icon"><i class="bx bx-edit"></i></span> <span class="button__text2"> Editar</span></a>';
            } ?>
            <a title="Voltar" class="button btn btn-mini btn-warning" style="min-width: 140px; top:10px" href="<?php echo site_url() ?>/clientes">
                <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span>
            </a>
        </div>
    </div>
</div>
