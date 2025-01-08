<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-tag"></i>
                </span>
                <h5>Editar Marca</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php echo $custom_error; ?>
                <form action="<?php echo current_url(); ?>" id="formMarca" method="post" class="form-horizontal">
                    <?php echo form_hidden('idMarcas', $result->idMarcas) ?>
                    <div class="control-group">
                        <label for="marca" class="control-label">Marca<span class="required">*</span></label>
                        <div class="controls">
                            <input id="marca" type="text" name="marca" value="<?php echo $result->marca ?>" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="situacao" class="control-label">Situação<span class="required">*</span></label>
                        <div class="controls">
                            <select id="situacao" name="situacao">
                                <option value="1" <?php echo ($result->situacao == 1) ? 'selected' : ''; ?>>Ativo</option>
                                <option value="0" <?php echo ($result->situacao == 0) ? 'selected' : ''; ?>>Inativo</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display:flex;justify-content: center">
                                <button type="submit" class="button btn btn-primary" style="max-width: 160px">
                                  <span class="button__icon"><i class="bx bx-sync"></i></span><span class="button__text2">Atualizar</span></button>
                                <a href="<?php echo base_url() ?>index.php/marcas" id="btnAdicionar" class="button btn btn-mini btn-warning" style="max-width: 160px">
                                  <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formMarca').validate({
            rules: {
                marca: {
                    required: true
                },
                situacao: {
                    required: true
                }
            },
            messages: {
                marca: {
                    required: 'Campo Requerido.'
                },
                situacao: {
                    required: 'Campo Requerido.'
                }
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