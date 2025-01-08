<style>
    select {
        width: 70px;
    }
</style>
<div class="new122">
    <div class="widget-title" style="margin: -20px 0 0">
        <span class="icon">
            <i class="fas fa-tags"></i>
        </span>
        <h5>Marcas</h5>
    </div>
    <div class="span12" style="margin-left: 0">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aMarca')) : ?>
            <div class="span3 flexxn" style="display: flex;">
                <a href="<?= base_url() ?>index.php/marcas/adicionar" class="button btn btn-mini btn-success" style="max-width: 160px">
                    <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2"> Marcas</span>
                </a>
            </div>
        <?php endif; ?>
        <form class="span9" method="get" action="<?= base_url() ?>index.php/marcas" style="display: flex; justify-content: flex-end;">
            <div class="span3">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Buscar por Nome..." class="span12" value="<?=$this->input->get('pesquisa')?>">
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
                        <th>Nome</th>
                        <th style="width: 10%; text-align: center;">Data de Cadastro</th>
                        <th style="width:10%; text-align: center;">Situação</th>
                        <th style="width: 5%; text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!$results) {
                        echo '<tr><td colspan="5">Nenhuma Marca Cadastrada</td></tr>';
                    }
                    foreach ($results as $r) {
                        echo '<tr>';
                        echo '<td>' . $r->idMarcas . '</td>';
                        echo '<td>' . $r->marca . '</td>';
                        echo '<td style="text-align:center">' . date('d/m/Y', strtotime($r->cadastro)) . '</td>';
                        echo '<td style="text-align:center">' . ($r->situacao ? 'Ativo' : 'Inativo') . '</td>';
                        echo '<td style="text-align:center">';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eMarca')) {
                            echo '<a style="margin-right: 1%" href="' . base_url() . 'index.php/marcas/editar/' . $r->idMarcas . '" class="btn-nwe3" title="Editar Marca"><i class="bx bx-edit bx-xs"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'dMarca')) {
                            echo '<a href="#modal-excluir" role="button" data-toggle="modal" marca="' . $r->idMarcas . '" class="btn-nwe4" title="Excluir Marca"><i class="bx bx-trash-alt bx-xs"></i></a>  ';
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
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="<?php echo base_url() ?>index.php/marcas/excluir" method="post">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5 id="myModalLabel">Excluir Marca</h5>
        </div>
        <div class="modal-body">
            <input type="hidden" id="idMarca" name="id" value="" />
            <h5 style="text-align: center">Deseja realmente excluir esta marca?</h5>
        </div>
        <div class="modal-footer" style="display:flex;justify-content: center">
            <button class="button btn btn-warning" data-dismiss="modal" aria-hidden="true"><span class="button__icon"><i class="bx bx-x"></i></span><span class="button__text2">Cancelar</span></button>
            <button class="button btn btn-danger"><span class="button__icon"><i class='bx bx-trash'></i></span> <span class="button__text2">Excluir</span></button>
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', 'a', function(event) {
            var marca = $(this).attr('marca');
            $('#idMarca').val(marca);
        });
    });
</script>