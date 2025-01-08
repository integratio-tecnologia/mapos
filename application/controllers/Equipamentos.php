<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Equipamentos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('equipamentos_model');
        $this->data['menuEquipamentos'] = 'equipamentos';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vEquipamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar equipamentos.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('equipamentos/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->equipamentos_model->count('equipamentos');
        if($pesquisa) {
            $this->data['configuration']['suffix'] = "?pesquisa={$pesquisa}";
            $this->data['configuration']['first_url'] = base_url("index.php/equipamentos")."\?pesquisa={$pesquisa}";
        }

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->equipamentos_model->get('equipamentos', '*', $pesquisa, $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'equipamentos/equipamentos';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vEquipamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar equipamentos.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $data = $this->equipamentos_model->getById($this->uri->segment(3));
        $this->data['result'] = $data['equipamento'];
        $this->data['fotos'] = $data['fotos'];
        $this->data['ordens'] = $data['ordens'];

        $this->data['view'] = 'equipamentos/visualizarEquipamento';

        return $this->layout();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aEquipamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar equipamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('equipamentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $dataFabricacao = $this->input->post('data_fabricacao') != '' ? implode('-', array_reverse(explode('/', $this->input->post('data_fabricacao')))) : null;

            $data = [
                'equipamento' => set_value('equipamento'),
                'num_serie' => set_value('num_serie'),
                'descricao' => set_value('descricao'),
                'modelo' => set_value('modelo'),
                'cor' => set_value('cor'),
                'tensao' => set_value('tensao'),
                'voltagem' => set_value('voltagem'),
                'potencia' => set_value('potencia'),
                'data_fabricacao' => $dataFabricacao,
                'observacoes' => $this->input->post('observacoes'),
                'marcas_id' => set_value('marcas_id'),
                'clientes_id' => set_value('clientes_id')
            ];

            if ($this->equipamentos_model->add('equipamentos', $data)) {
                
                // Executa o upload das fotos do equipamento
                $idEquipamento = $this->db->insert_id();
                
                if ($this->uploadFotos($_FILES['fotos'], $idEquipamento)) {
                    $this->session->set_flashdata('success', 'Equipamento adicionado com sucesso.');
                    log_info('Adicionou um equipamento.');
                    redirect(site_url('equipamentos/'));
                } else {
                    $this->session->set_flashdata('error', 'Erro ao tentar adicionar fotos ao equipamento.');
                    redirect(site_url('equipamentos/'));
                }

            } else {
                print_r($this->db->error());
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['marcas'] = $this->equipamentos_model->getMarcas();
        $this->data['view'] = 'equipamentos/adicionarEquipamento';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }
        
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eEquipamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar equipamentos.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('equipamentos') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $dataFabricacao = $this->input->post('data_fabricacao') != '' ? implode('-', array_reverse(explode('/', $this->input->post('data_fabricacao')))) : null;
            $data = [
                'equipamento' => $this->input->post('equipamento'),
                'num_serie' => $this->input->post('num_serie'),
                'descricao' => $this->input->post('descricao'),
                'modelo' => $this->input->post('modelo'),
                'cor' => $this->input->post('cor'),
                'tensao' => $this->input->post('tensao'),
                'voltagem' => $this->input->post('voltagem'),
                'potencia' => $this->input->post('potencia'),
                'data_fabricacao' => $this->input->post('data_fabricacao'),
                'observacoes' => $this->input->post('observacoes'),
                'marcas_id' => $this->input->post('marcas_id'),
                'clientes_id' => $this->input->post('clientes_id')
            ];

            if ($this->equipamentos_model->edit('equipamentos', $data, 'idEquipamentos', $this->input->post('idEquipamentos')) == true) {
                $this->session->set_flashdata('success', 'Equipamento editado com sucesso.');
                log_info('Alterou um equipamento. ID: ' . $this->input->post('idEquipamentos'));
                redirect(site_url('equipamentos/editar/' . $this->input->post('idEquipamentos')));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['result'] = $this->equipamentos_model->getById($this->uri->segment(3));
        $this->data['marcas'] = $this->equipamentos_model->getMarcas();
        $this->data['view'] = 'equipamentos/editarEquipamento';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dEquipamento')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir equipamentos.');
            redirect(base_url());
        }

        $id = $this->input->post('id');

        if ($id == null || ! is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir equipamento.');
            redirect(site_url('equipamentos/gerenciar/'));
        }

        $this->equipamentos_model->delete('equipamentos', 'idEquipamentos', $id); // Excluir fotos do equipamento e registros na tabela fotos_equipamentos.
        $this->session->set_flashdata('success', 'Equipamento excluído com sucesso.');
        log_info('Removeu um equipamento. ID: ' . $id);
        redirect(site_url('equipamentos/'));
    }

    /*
     * Upload image files and save information files in fotos_equipamentos table
     */
    
    public function uploadFotos(array $files, $id, $upload = true)
    {
        if ($upload) {
            
            //load file helper
            $this->load->helper('file');
            //Load upload helper
            $this->load->library('upload');
            // Load image_lib helper
            $this->load->library('image_lib');

            $directory = FCPATH . 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'equipamentos' . DIRECTORY_SEPARATOR . $this->input->post('equipamento');

            // If it exist, check if it's a directory
            if (! is_dir($directory . DIRECTORY_SEPARATOR . 'thumbs')) {
                // make directory for images and thumbs
                try {
                    mkdir($directory . DIRECTORY_SEPARATOR . 'thumbs', 0755, true);
                } catch (Exception $e) {
                    echo json_encode(['result' => false, 'mensagem' => $e->getMessage()]);
                    log_info('Erro ao tentar criar diretório para fotos do equipamento. Equipamento: ' . $this->input->post('equipamento'));
                    exit();
                }
            }

            $upload_conf = [
                'upload_path' => $directory,
                'allowed_types' => 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|PDF', // formatos permitidos para anexos de os
                'max_size' => 2048, // tamanho máximo permitido (em kb) - 2Mb
            ];

            $this->upload->initialize($upload_conf);

            foreach ($_FILES['fotos'] as $key => $val) {
                $i = 1;
                foreach ($val as $v) {
                    $field_name = 'file_' . $i;
                    $_FILES[$field_name][$key] = $v;
                    $i++;
                }
            }
            unset($_FILES['fotos']);

            // Fazer a validação do tipo de arquivo pelo nome para cada arquivo enviado pelo usuário
            foreach ($_FILES as $field_name => $file) {
                if (strpos($field_name, 'file_') !== false) {
                    $this->form_validation->set_rules('fotos', 'Fotos', 'callback_file_check[' . $_FILES[$field_name]['name'] . ']');
                }
                // Executar a validação do tipo de arquivo
                if ($this->form_validation->run() == false) {
                    $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
                    break; // Interromper o loop se houver erro na validação
                }
            }

            $errors = [];
            $success = [];

            foreach ($_FILES as $field_name => $file) {
                if (! $this->upload->do_upload($field_name)) {
                    $errors['upload'][] = $this->upload->display_errors();
                } else {
                    $upload_data = $this->upload->data();
    
                    // Gera um nome de arquivo aleatório mantendo a extensão original
                    $new_file_name = uniqid() . '.' . pathinfo($upload_data['file_name'], PATHINFO_EXTENSION);
                    $new_file_path = $upload_data['file_path'] . $new_file_name;
    
                    rename($upload_data['full_path'], $new_file_path);

                    if ($upload_data['is_image'] == 1) {
                        $resize_conf = [
                            'source_image' => $new_file_path,
                            'new_image' => $upload_data['file_path'] . 'thumbs' . DIRECTORY_SEPARATOR . 'thumb_' . $new_file_name,
                            'width' => 200,
                            'height' => 125,
                        ];
    
                        $this->image_lib->initialize($resize_conf);
    
                        if (! $this->image_lib->resize()) {
                            $errors['resize'][] = $this->image_lib->display_errors();
                        } else {
                            $success[] = $upload_data;

                            $data = [
                                'foto' => $new_file_name,
                                'thumb' => 'thumb_' . $new_file_name,
                                'url' => base_url('assets' . DIRECTORY_SEPARATOR . 'equipamentos' . DIRECTORY_SEPARATOR . $this->input->post('equipamento')),
                                'path' => 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'equipamentos' . DIRECTORY_SEPARATOR . $this->input->post('equipamento'),
                                'equipamentos_id' => $id
                            ];

                            $result = $this->equipamentos_model->add('fotos_equipamentos', $data);

                            if (! $result) {
                                $errors['db'][] = $this->db->error();
                            }
                        }
                    } elseif ($upload_data['is_image'] == 0) {
                        $success[] = $upload_data;

                        $data = [
                            'foto' => $new_file_name,
                            'thumb' => 'thumb_' . $new_file_name,
                            'url' => base_url('assets' . DIRECTORY_SEPARATOR . 'equipamentos' . DIRECTORY_SEPARATOR . $this->input->post('equipamento')),
                            'path' => 'assets' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'equipamentos' . DIRECTORY_SEPARATOR . $this->input->post('equipamento'),
                            'equipamentos_id' => $id
                        ];

                        $result = $this->equipamentos_model->add('fotos_equipamentos', $data);
                        
                        if (! $result) {
                            $errors['db'][] = $this->db->error();
                        }
                    }
                }
            }
            if (count($errors) > 0) {
                // iterar sobre o array de erros para registrar cada um deles no log
                foreach ($errors as $error) {
                    foreach ($error as $e) {
                        dd($e);
                        log_info('Erro ao tentar fazer upload de fotos do equipamento. Equipamento: ' . $this->input->post('equipamento') . ' | Erro: ' . $e);
                    }
                }
                echo json_encode(['result' => false, 'mensagem' => 'Erro ao processar os arquivos.', 'errors' => implode(',', $error)]);
                return false;
            } else {
                // iterar sobre o array de sucesso para registrar cada um deles no log
                foreach ($success as $s) {
                    log_info('Fotos adicionadas ao equipamento ID (EQUIPAMENTOS): ' . $id . ' | Arquivo: ' . $s->file_name);
                }
                echo json_encode(['result' => true, 'mensagem' => 'Fotos adicionadas com sucesso']);
                return true;
            }
        }
    }

    /*
     * file value and type check during validation
     */
    public function file_check($str){
        $allowed_mime_type_arr = array('application/pdf','image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($str);
        if(isset($str) && $str!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only pdf/gif/jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }

    public function download($id = null)
    {
        if (! $id || ! is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro ao tentar baixar o arquivo.');
            return false;
        }

        $file = $this->equipamentos_model->getFotoById($id);
        $this->load->helper('download');
        if ($file) {
            $path = $file->url;
            $data = file_get_contents($path);
            force_download(pathinfo($path, PATHINFO_BASENAME), $data);
        }

        $this->session->set_flashdata('success', 'Arquivo baixado com sucesso.');

        return true;
    }

    public function excluirFoto()
    {
        $id = $this->input->post('idFotosEquipamentos');
        if ($id == null || ! is_numeric($id)) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir a foto.');
            return false;
        }

        $file = $this->equipamentos_model->getFotoById($id);
        $path = $file->url;
        unlink($path);

        if ($this->equipamentos_model->delete('fotos_equipamentos', 'idFotosEquipamentos', $id)) {
            $this->session->set_flashdata('success', 'Foto excluída com sucesso.');
            log_info('Removeu uma foto de equipamento. ID: ' . $id);
            return true;
        } else {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir a foto.');
            return false;
        }
    }

    public function autoCompleteMarca()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->equipamentos_model->autoCompleteMarca($q);
        }
    }

    public function autoCompleteCliente()
    {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->equipamentos_model->autoCompleteCliente($q);
        }
    }
}