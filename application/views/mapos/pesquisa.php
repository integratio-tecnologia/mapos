 <div class="span12" style="margin-left: 0; margin-top: 0">
    <div class="span12" style="margin-left: 0">
        <form action="<?php echo current_url() ?>">
            <div class="span10" style="margin-left: 0">
                <input type="text" class="span12" name="termo" value="<?php echo $termo;?>"
                onfocus="this.selectionStart = this.selectionEnd = this.value.length;" autofocus autocomplete="off" placeholder="Digite o termo a pesquisar"/>
            </div>
            <div class="span2">
                <button class="button btn btn-mini btn-warning">
                  <span class="button__icon"><i class='bx bx-search-alt'></i></span> <span class="button__text2">Pesquisar</span></button>
            </div>
        </form>
    </div>
    <div class="span12" style="margin-left: 0; margin-top: 0">
        <!--Produtoss-->
        <?php if ($produtos != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) : ?>
            <div class="span6" style="margin-left: 0; margin-top: 0">
                <div class="widget-box" style="min-height: 200px">
                    <div class="widget-title" style="margin: -20px 0 0">
                        <span class="icon">
                            <i class="fas fa-shopping-bag"></i>
                        </span>
                        <h5>Produtos</h5>
                    </div>
                    <div class="widget-content nopadding tab-content">
                        <table class="table table-bordered ">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nome</th>
                                <th style="width: 10%; text-align: right;">Preço</th>
                                <th style="width: 10%; text-align: center;">Estoque</th>
                                <th style="width: 10%; text-align: center;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($produtos == null) {
                                echo '<tr><td colspan="5">Nenhum produto foi encontrado.</td></tr>';
                            }
                            foreach ($produtos as $r) {
                                echo '<tr>';
                                echo '<td>' . $r->idProdutos . '</td>';
                                echo '<td>' . $r->descricao . '</td>';
                                echo '<td style="text-align:right;">' . $r->precoVenda . '</td>';
                                echo '<td style="text-align:center">' . $r->estoque . '</td>';
                                echo '<td style="text-align:center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vProduto')) {
                                    echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/produtos/visualizar/' . $r->idProdutos . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eProduto')) {
                                    echo '<a href="' . base_url() . 'index.php/produtos/editar/' . $r->idProdutos . '" class="btn-nwe3" title="Editar produto"><i class="bx bx-edit"></i></a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!--Clientes-->
        <?php if ($clientes != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) : ?>
            <div class="span6">
                <div class="widget-box" style="min-height: 200px">
                    <div class="widget-title" style="margin: -20px 0 0">
                        <span class="icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <h5>Clientes</h5>
                    </div>
                    <div class="widget-content nopadding tab-content">
                        <table class="table table-bordered ">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nome</th>
                                <th>CPF/CNPJ</th>
                                <th style="width: 20%; text-align: center;">Cliente / Fornecedor</th>
                                <th style="width: 10%; text-align: center;">Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($clientes == null) {
                                echo '<tr><td colspan="5">Nenhum cliente foi encontrado.</td></tr>';
                            }
                            foreach ($clientes as $r) {
                                echo '<tr>';
                                echo '<td>' . $r->idClientes . '</td>';
                                echo '<td>' . $r->nomeCliente . '</td>';
                                echo '<td>' . $r->documento . '</td>';
                                $cor = ($r->fornecedor ? '#9FA4A8' : '#5DB789');
                                echo '<td style="text-align:center"><span class="badge" style="background-color: ' . $cor . '; border-color: ' . $cor . '">' . ($r->fornecedor ? 'Fornecedor' : 'Cliente') . '</span> </td>';
                                echo '<td style="text-align:center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
                                    echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/clientes/visualizar/' . $r->idClientes . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
                                    echo '<a href="' . base_url() . 'index.php/clientes/editar/' . $r->idClientes . '" class="btn-nwe3" title="Editar Cliente"><i class="bx bx-edit"></i></a>';
                                }
                                echo '</td>';
                                echo '</tr>';
                            } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <!--Serviços-->
    <?php if ($servicos != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) : ?>
        <div class="span6" style="margin-left: 0">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <span class="icon">
                        <i class="fas fa-wrench"></i>
                    </span>
                    <h5>Serviços</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th style="width: 10%; text-align: right;">Preço</th>
                            <th style="width: 10%; text-align: center;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($servicos == null) {
                            echo '<tr><td colspan="4">Nenhum serviço foi encontrado.</td></tr>';
                        }
                        foreach ($servicos as $r) {
                            echo '<tr>';
                            echo '<td>' . $r->idServicos . '</td>';
                            echo '<td>' . $r->nome . '</td>';
                            echo '<td>' . $r->descricao . '</td>';
                            echo '<td style="text-align:right">' . $r->preco . '</td>';
                            echo '<td style="text-align:center">';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
                                echo '<a href="' . base_url() . 'index.php/servicos/editar/' . $r->idServicos . '" class="btn-nwe3" title="Editar Serviço"><i class="bx bx-edit"></i></a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--Ordens de Serviço-->
    <?php if ($os != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) : ?>
        <div class="span6">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <span class="icon">
                        <i class="fas fa-diagnoses"></i>
                    </span>
                    <h5>Ordens de Serviço</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Data Inicial</th>
                            <th>Descrição</th>
                            <th>Defeito</th>
                            <th width="10%">Data Final</th>
                            <th style="width: 10%; text-align: center;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($os == null) {
                            echo '<tr><td colspan="5">Nenhuma O.S. foi encontrado.</td></tr>';
                        }
                        foreach ($os as $r) {
                            $dataInicial = date(('d/m/Y'), strtotime($r->dataInicial));
                            $dataFinal = date(('d/m/Y'), strtotime($r->dataFinal));
                            echo '<tr>';
                            echo '<td>' . $r->idOs . '</td>';
                            echo '<td>' . $dataInicial . '</td>';
                            echo '<td>' . $r->descricaoProduto . '</td>';
                            echo '<td>' . $r->defeito . '</td>';
                            echo '<td>' . $dataFinal . '</td>';
                            echo '<td style="text-align:center">';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                                echo '<a href="' . base_url() . 'index.php/os/editar/' . $r->idOs . '" class="btn-nwe3" title="Editar OS"><i class="bx bx-edit"></i></a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--Vendas-->
    <?php if ($vendas != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vVenda')) : ?>
        <div class="span6" style="margin-left: 0">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <span class="icon">
                        <i class="fas fa-shopping-cart"></i>
                    </span>
                    <h5>Vendas</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="10%">Data</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th style="width:10%; text-align:center">Venc. Garantia</th>
                            <th style="width:10%; text-align:center">Status</th>
                            <th style="width:10%; text-align:center">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($vendas == null) {
                            echo '<tr><td colspan="7">Nenhuma venda foi encontrada.</td></tr>';
                        } else {
                            foreach ($vendas as $r) {
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
                                $desconto = $r->tipo_desconto == 'porcento' ? $r->desconto . '%' : 'R$ ' . number_format($r->desconto, 2, ',', '.');
                                
                                echo '<tr>';
                                echo '<td>' . $r->idVendas . '</td>';
                                echo '<td>' . $dataVenda . '</td>';
                                echo '<td>' . $r->nomeCliente . '</td>';
                                echo '<td>' . $r->nome . '</td>';
                                echo '<td style="text-align:center"><span class="badge" style="background-color: ' . $corGarantia . '; border-color: ' . $corGarantia . '">' . $vencGarantia . '</span> </td>';

                                echo '<td style="text-align:center"><span class="badge" style="background-color: ' . $corStatus . '; border-color: ' . $corStatus . '">' . $r->status . '</span> </td>';
                                echo '<td style="text-align:center">';

                                // Não verifica permissão para visualizar pois foi verificada para exibir este bloco
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimir/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir A4"><i class="bx bx-printer bx-xs"></i></a>';
                                
                                $editavel = $r->faturado == 1 ? $this->data['configuration']['control_edit_vendas'] == '1' : true;
                                
                                if ($r->faturado != 1 || $editavel) {
                                    if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eVenda')) {
                                        echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="btn-nwe3" title="Editar venda"><i class="bx bx-edit bx-xs"></i></a>';
                                    }
                                }
                                echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/vendas/imprimirTermica/' . $r->idVendas . '" target="_blank" class="btn-nwe6" title="Imprimir Não Fiscal"><i class="bx bx-printer bx-xs"></i></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--Equipamentos-->
    <?php if ($equipamentos != null && $this->permission->checkPermission($this->session->userdata('permissao'), 'vEquipamento')) : ?>
        <div class="span6">
            <div class="widget-box" style="min-height: 200px">
                <div class="widget-title" style="margin: -20px 0 0">
                    <span class="icon">
                        <i class="fas fa-tools"></i>
                    </span>
                    <h5>Equipamentos</h5>
                </div>
                <div class="widget-content nopadding tab-content">
                    <table class="table table-bordered ">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Equipamento</th>
                            <th>Nº. Serial</th>
                            <th width="10%">Marca</th>
                            <th width="10%">Modelo</th>
                            <th width="25%">Cliente</th>
                            <th style="width:10%; text-align: center;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($equipamentos == null) {
                            echo '<tr><td colspan="7">Nenhum equipamento foi encontrado.</td></tr>';
                        }
                        foreach ($equipamentos as $r) {
                            echo '<tr>';
                            echo '<td>' . $r->idEquipamentos . '</td>';
                            echo '<td>' . $r->equipamento . '</td>';
                            echo '<td>' . $r->num_serie . '</td>';
                            echo '<td>' . $r->marca . '</td>';
                            echo '<td>' . $r->modelo . '</td>';
                            echo '<td>' . $r->nomeCliente . '</td>';
                            echo '<td style="text-align:center">';
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vEquipamento')) {
                                echo '<a href="' . base_url() . 'index.php/equipamentos/visualizar/' . $r->idEquipamentos . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show"></i></a>';
                            }
                            if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eEquipamento')) {
                                echo '<a href="' . base_url() . 'index.php/equipamentos/editar/' . $r->idEquipamentos . '" style="margin-right: 1%" class="btn-nwe3" title="Editar Equipamento"><i class="bx bx-edit"></i></a>';
                            }
                            echo '</td>';
                            echo '</tr>';
                        } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
