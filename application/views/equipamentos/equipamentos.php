<style>
    select {
        width: 70px;
    }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-cogs"></i>
        </span>
        <h5>Equipamentos</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aEquipamento')) { ?>
            <div class="span3">
                <a href="<?= base_url() ?>index.php/equipamentos/adicionar" class="button btn btn-mini btn-success"
                    style="max-width: 165px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">
                        Equipamento
                    </span>
                </a>
            </div>
        <?php } ?>
        <form class="span9" method="get" action="<?= base_url() ?>index.php/equipamentos"
            style="display: flex; justify-content: flex-end;">
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa"
                    placeholder="Buscar por Nome, Número de Série..." class="span12"
                    value="<?= $this->input->get('pesquisa') ?>">
            </div>
            <div class="span1">
                <button class="button btn btn-mini btn-warning" style="min-width: 30px">
                    <span class="button__icon"><i class='bx bx-search-alt'></i></span></button>
            </div>
        </form>
    </div>

    <div class="widget-box">
        <h5 style="padding: 3px 0"></h5>
        <div class="widget-content nopadding tab-content">
            <table id="tabela" class="table table-bordered ">
                <thead>
                    <tr>
                        <th width="5%">Cod.</th>
                        <th>Equipamento</th>
                        <th class="ph1">Descrição</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th style="text-align: center;">Número de Série</th>
                        <th style="text-align: center;" class="ph1">Tensão</th>
                        <th style="text-align: center;" class="ph1">Voltagem</th>
                        <th style="text-align: center;" class="ph1">Potência</th>
                        <th>Cliente</th>
                        <th style="width: 10%; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr>
                    <td colspan="5">Nenhum Equipamento Cadastrado</td>
                  </tr>';
                    }
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td>' . $r->idEquipamentos . '</td>';
                        echo '<td>' . $r->equipamento . '</td>';
                        echo '<td class="ph1">' . $r->descricao . '</td>';
                        echo '<td>' . $r->marca . '</td>';
                        echo '<td>' . $r->modelo . '</td>';
                        echo '<td style="text-align:center">' . $r->num_serie . '</td>';
                        echo '<td style="text-align:center" class="ph1">' . $r->tensao . '</td>';
                        echo '<td style="text-align:center" class="ph1">' . $r->voltagem . '</td>';
                        echo '<td style="text-align:center" class="ph1">' . $r->potencia . '</td>';
                        echo '<td>' . $r->cliente . '</td>';
                        echo '<td style="text-align:center">';
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
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php echo $this->pagination->create_links(); ?>

<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/equipamentos/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Equipamento</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idEquipamentos" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir este equipamento?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i
                        class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span
                    class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', 'a', function (event) {
            var equipamento = $(this).attr('equipamento');
            $('#idEquipamentos').val(equipamento);
        });
    });
</script>