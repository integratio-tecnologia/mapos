<div class="widget-box">
    <div class="widget-title" style="margin: 0;font-size: 1.1em">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Equipamento</a></li>
            <li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>
            <li><a data-toggle="tab" href="#tab3">Contratos</a></li>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <div class="accordion" id="collapse-group">
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title" style="margin-left: 10px;">
                            <a data-parent="#collapse-group" href="#collapseGOne" data-toggle="collapse">
                                <span><i class='bx bxs-devices icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Equipamento</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse in accordion-body" id="collapseGOne">
                        <div class="widget-content">
                            <table class="table table-bordered" style="border: 1px solid #ddd">
                                <tbody>
                                <tr>
                                    <td style="text-align: right; width: 30%"><strong>Equipamento:</strong></td>
                                    <td>
                                        <?php echo $result->equipamento; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Número de Série</strong></td>
                                    <td>
                                        <?php echo $result->num_serie ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Descrição</strong></td>
                                    <td>
                                        <?php echo $result->descricao ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Modelo</strong></td>
                                    <td>
                                        <?php echo $result->modelo ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Cor</strong></td>
                                    <td>
                                        <?php echo $result->cor ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Tensão</strong></td>
                                    <td>
                                        <?php echo $result->tensao ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Voltagem</strong></td>
                                    <td>
                                        <?php echo $result->voltagem ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Potência</strong></td>
                                    <td>
                                        <?php echo $result->potencia ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Data de Fabricação</strong></td>
                                    <td>
                                        <?php echo date(('d/m/Y'), strtotime($result->data_fabricacao)) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Marca</strong></td>
                                    <td>
                                        <?php echo $result->marca ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align: right"><strong>Cliente</strong></td>
                                    <td>
                                        <?php echo $result->cliente ?>
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
                                <span><i class='bx bx-notepad icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Observações</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGTwo">
                        <div class="widget-content">
                            <table class="table table-bordered" style="border: 1px solid #ddd">
                                <tbody>
                                <?php if ($result->observacoes) {
                                    echo '<tr>';
                                    echo '<td>' . nl2br($result->observacoes) . '</td>';
                                    echo '</tr>';
                                } else {
                                    echo '<tr>';
                                    echo '<td style="text-align: center">Nenhuma observação cadastrada</td>';
                                    echo '</tr>';
                                } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="accordion-group widget-box">
                    <div class="accordion-heading">
                        <div class="widget-title" style="margin-left: 10px;">
                            <a data-parent="#collapse-group" href="#collapseGTree" data-toggle="collapse">
                                <span><i class='bx bx-photo-album icon-cli' ></i></span>
                                <h5 style="padding-left: 28px">Fotos</h5>
                            </a>
                        </div>
                    </div>
                    <div class="collapse accordion-body" id="collapseGTree">
                        <div class="widget-content">
                            <table class="table table-bordered" style="border: 1px solid #ddd">
                                <tbody>
                                <?php if ($fotos) {
                                    foreach ($fotos as $foto) {
                                        echo '<tr>';
                                        echo '<td style="text-align: center">';
                                        echo '<img src="' . base_url() . $foto->url . '" style="max-width: 200px;max-height: 200px" />';
                                        echo '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr>';
                                    echo '<td style="text-align: center">Nenhuma foto cadastrada</td>';
                                    echo '</tr>';
                                } ?>
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
                        if (!$ordens) {
                            echo '<tr><td colspan="6">Nenhuma O.S. encontrada</td></tr>';
                        } else {
                            foreach ($ordens as $o) {
                                $dataInicial = date(('d/m/Y'), strtotime($o->dataInicial));
                                $dataFinal = date(('d/m/Y'), strtotime($o->dataFinal));
                                echo '<tr>';
                                echo '<td>' . $o->idOs . '</td>';
                                echo '<td>' . $dataInicial . '</td>';
                                echo '<td>' . $dataFinal . '</td>';
                                echo '<td>' . $o->descricaoProduto . '</td>';
                                echo '<td>' . $o->defeito . '</td>';
                                echo '<td style="text-align: center">';
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $o->idOs . '" style="margin-right: 1%" class="btn-nwe" title="Ver mais detalhes"><i class="bx bx-show bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                                    echo '<a href="' . base_url() . 'index.php/os/editar/' . $o->idOs . '" style="margin-right: 1%" class="btn-nwe3" title="Editar OS"><i class="bx bx-edit bx-xs"></i></a>';
                                }
                                if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dOs')) {
                                    echo '<a href="#modal-excluir" role="button" data-toggle="modal" os="' . $o->idOs . '" style="margin-right: 1%" class="btn-nwe4" title="Excluir OS"><i class="bx bx-trash-alt bx-xs"></i></a>';
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
            
        </div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content: center">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eEquipamento')) {
            echo '<a title="Icon Title" class="button btn btn-mini btn-info" style="min-width: 140px; top:10px" href="' . base_url() . 'index.php/equipamentos/editar/' . $result->clientes_id . '">
                <span class="button__icon"><i class="bx bx-edit"></i></span> <span class="button__text2"> Editar</span></a>';
        } ?>
        <a title="Voltar" class="button btn btn-mini btn-warning" style="min-width: 140px; top:10px" href="<?php echo site_url() ?>/equipamentos">
            <span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span></a>
    </div>
</div>
