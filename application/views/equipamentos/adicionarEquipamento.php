<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" /> -->
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<script src="<?php echo base_url() ?>assets/js/sweetalert2.all.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css" />

<style>
    .control-group.error .help-inline {
        display: flex;
    }

    .form-horizontal .control-group {
        border-bottom: 1px solid #ffffff;
    }
    
    .form-horizontal .control-label {
        text-align: left;
        padding-top: 15px;
    }
    
    .form-horizontal .controls {
        margin-left: 20px;
        padding-bottom: 8px;
    }

    .nopadding {
        padding: 0 20px !important;
        margin-right: 20px;
    }

    @media (max-width: 480px) {
        form {
            display: contents !important;
        }

        .form-horizontal .control-label {
            margin-bottom: -6px;
        }

        select, input {
            width: 100% !important;
        }
    }
</style>
<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-cogs"></i>
                </span>
                <h5>Cadastro de Equipamento</h5>
            </div>
            <?php if ($custom_error != '') {
                echo '<div class="alert alert-danger">' . $custom_error . '</div>';
            } ?>
            <form action="<?php echo current_url(); ?>" id="formEquipamento" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="widget-content nopadding tab-content">
                    <div class="span4">
                        <div class="control-group">
                            <label for="equipamento" class="control-label">Equipamento</label>
                            <div class="controls">
                                <input autofocus id="equipamento" type="text" name="equipamento" value="<?php echo set_value('equipamento'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="num_serie" class="control-label">Número de Série</label>
                            <div class="controls">
                                <input id="num_serie" type="text" name="num_serie" value="<?php echo set_value('num_serie'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="descricao" class="control-label">Descrição</label>
                            <div class="controls">
                                <input id="descricao" type="text" name="descricao" value="<?php echo set_value('descricao'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="modelo" class="control-label">Modelo</label>
                            <div class="controls">
                                <input id="modelo" type="text" name="modelo" value="<?php echo set_value('modelo'); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label for="cor" class="control-label">Cor</label>
                            <div class="controls">
                                <input id="cor" type="text" name="cor" value="<?php echo set_value('cor'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="tensao" class="control-label">Corrente Elétrica</label>
                            <div class="controls">
                                <select name="tensao" id="tensao">
                                    <option value="">Selecione...</option>
                                    <option value="Alternada" <?php echo set_select('tensao', 'Alternada'); ?>>Alternada</option>
                                    <option value="Contínua" <?php echo set_select('tensao', 'Contínua'); ?>>Contínua</option>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="voltagem" class="control-label">Voltagem</label>
                            <div class="controls">
                                <input id="voltagem" type="text" name="voltagem" value="<?php echo set_value('voltagem'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="potencia" class="control-label">Potência</label>
                            <div class="controls">
                                <input id="potencia" type="text" name="potencia" value="<?php echo set_value('potencia'); ?>" />
                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <div class="control-group">
                            <label for="data_fabricacao" class="control-label">Data de Fabricação</label>
                            <div class="controls">
                                <input id="data_fabricacao" autocomplete="off" class="datepicker" type="text" name="data_fabricacao" value="<?php echo set_value('data_fabricacao'); ?>" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="marcas_id" class="control-label">Marca</label>
                            <div class="controls">
                                <select name="marcas_id" id="marcas_id">
                                    <option value="">Selecione...</option>
                                    <?php foreach ($marcas as $marca) : ?>
                                        <option value="<?php echo set_value('marcas_id', $marca->idMarcas); ?>" <?php echo set_value('marcas_id', $marca->idMarcas); ?>><?php echo $marca->marca; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="cliente" class="control-label">Cliente</label>
                            <div class="controls">
                                <input id="cliente" type="text" name="cliente" value="" />
                                <input id="clientes_id" type="hidden" name="clientes_id" value="<?php echo set_value('clientes_id'); ?>" />
                            </div>
                        </div>
                    </div>

                    <div class="span12" style="margin-left: 0; padding: 0">
                        <div class="control-group">
                            <label for="observacoes"><h5>Observações</h5></label>
                            <div class="controls observacoes">
                                <textarea id="observacoes" name="observacoes" class="span12 editor" cols="30" rows="5"><?php echo set_value('observacoes'); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Fotos -->
                    <div class="span12" style="margin-left: 0; padding: 0;">
                        <!-- Drag and Drop files preview -->
                        <div class="control-group">
                            <div class="controls">
                                <span id="click_upload">
                                    <span class="btn btn-success fileinput-button">
                                        <i class="fas fa-plus"></i>
                                        <span>Adicionar Fotos</span>
                                        <input id="fileupload" type="file" name="files[]" multiple>
                                    </span>
                                </span>
                                <div class="previews"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="span12">
                        <div class="span6 offset3" style="display:flex;justify-content: center">
                            <button type="submit" class="button btn btn-mini btn-success"><span class="button__icon"><i class='bx bx-save'></i></span> <span class="button__text2">Salvar</span></a></button>
                            <a title="Voltar" class="button btn btn-warning" href="<?php echo site_url() ?>/equipamentos"><span class="button__icon"><i class="bx bx-undo"></i></span> <span class="button__text2">Voltar</span></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

        

        // Form validation and mask input fields

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true,
        }).mask('00/00/0000');

        $( "#anim" ).on( "change", function() {
            $( "#datepicker" ).datepicker( "option", "showAnim", $( this ).val() );
        });

        $(".editor").trumbowyg({
            lang: 'pt_br',
            semantic: { 'strikethrough': 's', }
        });

        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/equipamentos/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });

        $('#formEquipamento').validate({
            rules: {
                equipamento: {
                    required: true
                },
                cliente: {
                    required: true
                },
            },
            messages: {
                equipamento: {
                    required: 'Campo Requerido.'
                },
                cliente: {
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
    });
</script>