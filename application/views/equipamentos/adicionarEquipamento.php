<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.mask.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/trumbowyg/ui/trumbowyg.css">
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/trumbowyg.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/trumbowyg/langs/pt_br.js"></script>
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<link
  rel="stylesheet"
  href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
  type="text/css"
/>
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

    .controls.observacoes,
    .trumbowyg-box,
    .trumbowyg-editor {
        max-width: calc(100% - 5px);
        overflow: hidden;
        min-width: fit-content;
        min-height: 20vh;
    }

    .trumbowyg-box {
        border: 1px solid !important;
        border-radius: 5px;
    }

    /* Inserir no css matrix-style.css */
    select:focus, .dropzone:focus, .trumbowyg-box:focus, input:focus, textarea:focus {
        outline: none !important;
        border-color: rgba(82, 168, 236, 0.8) !important;
        box-shadow: inset 0 1px 1px rgba(0,0,0,0.075),0 0 8px rgba(82,168,236,0.6) !important;
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
                        <div class="control-group fotos">
                            <div tabindex="0" class="controls dropzone"></div>
                            <div id="preview-template" style="display: none;">
                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-image"><IMG data-dz-thumbnail=""></div>
                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size=""></span></div>
                                        <div class="dz-filename"><span data-dz-name=""></span></div>
                                    </div>
                                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                    <div class="dz-error-message"><span data-dz-errormessage=""></span></div>
                                    <div class="dz-success-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                            <title>Check</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs></defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                            <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </svg>
                                        </div>
                                        <div class="dz-error-mark">
                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                            <title>error</title>
                                            <desc>Created with Sketch.</desc>
                                            <defs></defs>
                                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                                                <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                                <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
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

        Dropzone.autoDiscover = false;

        $("div.dropzone").dropzone({ 
            url: "/file/post",
            autoProccessQueue: false,
            addRemoveLinks: true,
            dictRemoveFile: "Remover",
            dictDefaultMessage: "Arraste os arquivos aqui para fazer o upload",
            dictMaxFilesExceeded: "Atingiu o limite máximo de arquivos",
            dictFileTooBig: "O arquivo é muito grande ({{filesize}}mb). Tamanho máximo de arquivo: {{maxFilesize}}mb.",
            dictInvalidFileType: "Tipo de arquivo inválido",
            dictResponseError: "Erro no servidor {{statusCode}}",
            dictCancelUpload: "Cancelar envio",
            dictCancelUploadConfirmation: "Tem certeza que deseja cancelar o envio?",
            dictUploadCanceled: "Envio cancelado",
            capture: "camera",
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 100,
            maxFiles: 100,
            uploadMultiple: true,
            acceptedFiles: 'image/*, application/pdf',
            thumbnailHeight: 120,
            thumbnailWidth: 120,
            maxFilesize: 3,
            filesizeBase: 1000,
            thumbnail: function(file, dataUrl) {
                if (file.previewElement) {
                file.previewElement.classList.remove("dz-file-preview");
                var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                for (var i = 0; i < images.length; i++) {
                    var thumbnailElement = images[i];
                    thumbnailElement.alt = file.name;
                    thumbnailElement.src = dataUrl;
                }
                setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
                }
            },
            // The setting up of the dropzone
            init: function() {
                var myDropzone = this;

                // First change the button to actually tell Dropzone to process the queue.
                $("button[type=submit]").on("click", function(e) {
                    // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    e.stopPropagation();
                    myDropzone.processQueue();
                });

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
                });
                this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                });
                this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                });
            }

        });

        // Now fake the file upload, since GitHub does not handle file uploads
        // and returns a 404

        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;

            $("div.dropzone").uploadFiles = function(files) {
            var self = this;

            for (var i = 0; i < files.length; i++) {

                var file = files[i];
                totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

                for (var step = 0; step < totalSteps; step++) {
                var duration = timeBetweenSteps * (step + 1);
                setTimeout(function(file, totalSteps, step) {
                    return function() {
                    file.upload = {
                        progress: 100 * (step + 1) / totalSteps,
                        total: file.size,
                        bytesSent: (step + 1) * file.size / totalSteps
                    };

                    self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
                    if (file.upload.progress == 100) {
                        file.status = Dropzone.SUCCESS;
                        self.emit("success", file, 'success', null);
                        self.emit("complete", file);
                        self.processQueue();
                        //document.getElementsByClassName("dz-success-mark").style.opacity = "1";
                    }
                    };
                }(file, totalSteps, step), duration);
                }
            }
        }
        /* dropzone.on('sending', function(file, xhr, formData) {
            // Will send the filesize along with the file as POST data.
            formData.append('filesize', file.size);
        });
        dropzone.on('addedfile', function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() { dropzone.enqueueFile(file); };
        });
        dropzone.on('totaluploadprogress', function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        });
        dropzone.on('sending', function(file) {
            // Shows the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        });
        // Hide the total progress bar when nothing's uploading anymore
        dropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0";
        });
        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            dropzone.enqueueFiles(dropzone.getFilesWithStatus(Dropzone.ADDED));
        };
        document.querySelector("#actions .cancel").onclick = function() {
            dropzone.removeAllFiles(true);
        }; */

        console.log($("div.dropzone"));

        // Form validation and mask input fields

        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy'
        }).mask('00/00/0000');

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