<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clientes extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('clientes_model');
        $this->data['menuClientes'] = 'clientes';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar clientes.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisa');

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('clientes/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->clientes_model->count('clientes');
        if($pesquisa) {
            $this->data['configuration']['suffix'] = "?pesquisa={$pesquisa}";
            $this->data['configuration']['first_url'] = base_url("index.php/clientes")."\?pesquisa={$pesquisa}";
        }

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->clientes_model->get('clientes', '*', $pesquisa, $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'clientes/clientes';

        return $this->layout();
    }

    public function adicionar()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'aCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $senhaCliente = $this->input->post('senha') ? $this->input->post('senha') : preg_replace('/[^\p{L}\p{N}\s]/', '', set_value('documento'));

        $cpf_cnpj = preg_replace('/[^\p{L}\p{N}\s]/', '', set_value('documento'));

        if (strlen($cpf_cnpj) == 11) {
            $pessoa_fisica = true;
        } else {
            $pessoa_fisica = false;
        }

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $data = [
                'nomeCliente' => set_value('nomeCliente'),
                'nomeFantasia' => set_value('nomeFantasia'),
                'contato' => set_value('contato'),
                'pessoa_fisica' => $pessoa_fisica,
                'documento' => set_value('documento'),
                'ie' => set_value('ie'),
                'telefone' => set_value('telefone'),
                'celular' => set_value('celular'),
                'email' => set_value('email'),
                'senha' => password_hash($senhaCliente, PASSWORD_DEFAULT),
                'rua' => set_value('rua'),
                'numero' => set_value('numero'),
                'complemento' => set_value('complemento'),
                'bairro' => set_value('bairro'),
                'cidade' => set_value('cidade'),
                'estado' => set_value('estado'),
                'cep' => set_value('cep'),
                'observacoes' => set_value('observacoes'),
                'dataCadastro' => date('Y-m-d'),
                'fornecedor' => (set_value('fornecedor') == true ? 1 : 0),
            ];

            if ($this->clientes_model->add('clientes', $data) == true) {
                $this->session->set_flashdata('success', 'Cliente adicionado com sucesso!');
                log_info('Adicionou um cliente.');
                redirect(site_url('clientes/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }

        $this->data['view'] = 'clientes/adicionarCliente';

        return $this->layout();
    }

    public function editar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('clientes') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $senha = $this->input->post('senha');
            if ($senha != null) {
                $senha = password_hash($senha, PASSWORD_DEFAULT);

                $data = [
                    'nomeCliente' => $this->input->post('nomeCliente'),
                    'nomeFantasia' => $this->input->post('nomeFantasia'),
                    'contato' => $this->input->post('contato'),
                    'documento' => $this->input->post('documento'),
                    'ie' => $this->input->post('ie'),
                    'telefone' => $this->input->post('telefone'),
                    'celular' => $this->input->post('celular'),
                    'email' => $this->input->post('email'),
                    'senha' => $senha,
                    'rua' => $this->input->post('rua'),
                    'numero' => $this->input->post('numero'),
                    'complemento' => $this->input->post('complemento'),
                    'bairro' => $this->input->post('bairro'),
                    'cidade' => $this->input->post('cidade'),
                    'estado' => $this->input->post('estado'),
                    'cep' => $this->input->post('cep'),
                    'observacoes' => $this->input->post('observacoes'),
                    'fornecedor' => (set_value('fornecedor') == true ? 1 : 0),
                ];
            } else {
                $data = [
                    'nomeCliente' => $this->input->post('nomeCliente'),
                    'nomeFantasia' => $this->input->post('nomeFantasia'),
                    'contato' => $this->input->post('contato'),
                    'documento' => $this->input->post('documento'),
                    'ie' => $this->input->post('ie'),
                    'telefone' => $this->input->post('telefone'),
                    'celular' => $this->input->post('celular'),
                    'email' => $this->input->post('email'),
                    'rua' => $this->input->post('rua'),
                    'numero' => $this->input->post('numero'),
                    'complemento' => $this->input->post('complemento'),
                    'bairro' => $this->input->post('bairro'),
                    'cidade' => $this->input->post('cidade'),
                    'estado' => $this->input->post('estado'),
                    'cep' => $this->input->post('cep'),
                    'observacoes' => $this->input->post('observacoes'),
                    'fornecedor' => (set_value('fornecedor') == true ? 1 : 0),
                ];
            }

            if ($this->clientes_model->edit('clientes', $data, 'idClientes', $this->input->post('idClientes')) == true) {
                $this->session->set_flashdata('success', 'Cliente editado com sucesso!');
                log_info('Alterou um cliente. ID' . $this->input->post('idClientes'));
                redirect(site_url('clientes/editar/') . $this->input->post('idClientes'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro</p></div>';
            }
        }

        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['contatos'] = $this->clientes_model->getAllContatosByClient($this->uri->segment(3));
        $this->data['filiais'] = $this->clientes_model->getAllFiliaisByClient($this->uri->segment(3));
        $this->data['view'] = 'clientes/editarCliente';

        return $this->layout();
    }

    public function visualizar()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'vCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar clientes.');
            redirect(base_url());
        }

        $this->data['custom_error'] = '';
        $this->data['result'] = $this->clientes_model->getById($this->uri->segment(3));
        $this->data['result_os'] = $this->clientes_model->getOsByCliente($this->uri->segment(3));
        $this->data['result_vendas'] = $this->clientes_model->getAllVendasByClient($this->uri->segment(3));
        $this->data['result_contatos'] = $this->clientes_model->getAllContatosByClient($this->uri->segment(3));
        $this->data['result_filiais'] = $this->clientes_model->getAllFiliaisByClient($this->uri->segment(3));
        $this->data['texto_de_notificacao'] = $this->data['configuration']['notifica_whats'];
        $this->data['view'] = 'clientes/visualizar';

        return $this->layout();
    }

    public function excluir()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'dCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir clientes.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir cliente.');
            redirect(site_url('clientes/gerenciar/'));
        }

        // excluir OS's vinculadas ao cliente
        $os = $this->clientes_model->getAllOsByClient($id);
        if ($os != null) {
            $this->clientes_model->removeClientOs($os);
        }

        // excluir Vendas vinculadas ao cliente
        $vendas = $this->clientes_model->getAllVendasByClient($id);
        if ($vendas != null) {
            $this->clientes_model->removeClientVendas($vendas);
        }

        // excluir Contatos vinculados ao cliente
        $contatos = $this->clientes_model->getAllContatosByClient($id);
        if ($contatos != null) {
            $this->clientes_model->removeClientContatos($contatos);
        }

        // excluir Filiais vinculadas ao cliente
        $filiais = $this->clientes_model->getAllFiliaisByClient($id);
        if ($filiais != null) {
            $this->clientes_model->removeClientFiliais($contatos);
        }

        $this->clientes_model->delete('clientes', 'idClientes', $id);
        log_info('Removeu um cliente. ID' . $id);

        $this->session->set_flashdata('success', 'Cliente excluido com sucesso!');
        redirect(site_url('clientes/gerenciar/'));
    }

    public function adicionarContato()
    {
        $this->load->library('form_validation');

        if ($this->form_validation->run('adicionar_contato_clientes') === false) {
            $errors = validation_errors();

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($errors));
        }

        //$idContato = $this->input->post('idContatos');
        $nome = $this->input->post('nomeContato');
        $telefone = $this->input->post('telefoneContato');
        $celular = $this->input->post('celularContato');
        $email = $this->input->post('emailContato');
        $data = [
            //'idContatos' => $idContato,
            'nomeContato' => $nome,
            'telefone' => $telefone,
            'celular' => $celular,
            'email' => $email,
            'clientes_id' => $this->input->post('idClientes'),
        ];

        $id = $this->input->post('idClientes');
        $cliente = $this->clientes_model->getById($id);
        if ($cliente == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar inserir contato ao cadastro do cliente.');
            redirect(base_url() . 'index.php/clientes/');
        }

        if ($this->clientes_model->add('contatos', $data) == true) {
            log_info('Adicionou contato ao cadastro do Cliente: ' . $this->input->post('idClientes'));

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['result' => true]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['result' => false]));
        }
    }

    public function excluirContato()
    {
        $id = $this->input->post('idContatos');
        $idCliente = $this->input->post('idClientes');
        //print_r($idCliente);

        $cliente = $this->clientes_model->getById($idCliente);
        if ($cliente == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir contato.');
            redirect(base_url() . 'index.php/clientes/');
        }

        if ($this->clientes_model->delete('contatos', 'idContatos', $id) == true) {
            
            log_info('Removeu contato do cliente código: ' . $idCliente);

            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }

    public function pesquisarFiliais()
    {
        if (! $this->uri->segment(3) || ! is_numeric($this->uri->segment(3))) {
            $this->session->set_flashdata('error', 'Item não pode ser encontrado, parâmetro não foi passado corretamente.');
            redirect('mapos');
        }

        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $pesquisa = $this->input->get('pesquisaFilial');

        $this->load->library('pagination');

        //$this->data['configuration']['base_url'] = site_url('clientes/editar');
        $this->data['configuration']['total_rows'] = $this->clientes_model->count('filiais');
        if ($pesquisa) {
            $this->data['configuration']['suffix'] = "?pesquisa={$pesquisa}";
            //$this->data['configuration']['first_url'] = base_url("index.php/clientes")."\?pesquisa={$pesquisa}";
        }

        $this->pagination->initialize($this->data['configuration']);

        //$this->data['results'] = $this->clientes_model->get('clientes', '*', $pesquisa, $this->data['configuration']['per_page'], $this->uri->segment(3));
    }

    public function adicionarFilial()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('adicionar_filial_clientes') === false) {
            $errors = validation_errors();
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . $errors . '</div>' : false);

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($errors));
        }

        // verificar se existe filial com o CNPJ informado, exceto a filial editada, caso exista:
        // exibir alerta de que existe filial já cadastrada com este CNPJ.
        $cnpjFilial = $this->clientes_model->getFilialByCnpj($this->input->post('cnpjFilial'));
        
        if ($cnpjFilial) {
            $this->session->set_flashdata('error', 'Este CNPJ já está cadastrado!');

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode([$this->data['custom_error'], 'result' => false]));
        }

        $idFilial = $this->input->post('idFiliais');
        $nome = $this->input->post('nomeFilial');
        $nomeFantasia = $this->input->post('nomeFantasiaFilial');
        $cnpj = $this->input->post('cnpjFilial');
        $ie = $this->input->post('ieFilial');
        $telefone = $this->input->post('telefoneFilial');
        $celular = $this->input->post('celularFilial');
        $email = $this->input->post('emailFilial');
        $rua = $this->input->post('ruaFilial');
        $numero = $this->input->post('numeroFilial');
        $complemento = $this->input->post('complementoFilial');
        $bairro = $this->input->post('bairroFilial');
        $cidade = $this->input->post('cidadeFilial');
        $estado = $this->input->post('estadoFilial');
        $cep = $this->input->post('cepFilial');
        $obs = $this->input->post('observacoesFilial');
        $cliente_id = $this->input->post('idClientes');
        $data = [
            'idFiliais' => $idFilial,
            'nome' => $nome,
            'nomeFantasia' => $nomeFantasia,
            'cnpj' => $cnpj,
            'ie' => $ie,
            'telefone' => $telefone,
            'celular' => $celular,
            'email' => $email,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep,
            'complemento' => $complemento,
            'observacoes' => $obs,
            'clientes_id' => $cliente_id,
        ];

        $id = $this->input->post('idClientes');
        $cliente = $this->clientes_model->getById($id);
        if ($cliente == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar inserir filial ao cadastro do cliente.');
            redirect(base_url() . 'index.php/clientes/');
        }

        if ($this->clientes_model->add('filiais', $data) == true) {
            $this->session->set_flashdata('success', 'Filial adicionada com sucesso!');
            log_info('Adicionou filial ao cadastro do Cliente: ' . $this->input->post('idClientes'));

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['result' => true]));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['result' => false]));
        }
            

    }

    public function editarFilial()
    {
        if (! $this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar clientes.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('adicionar_filial_clientes') === false) {
            $errors = validation_errors();
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . $errors . '</div>' : false);

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode($errors));
        }

        // verificar se existe filial com o CNPJ informado, exceto a filial editada, caso exista:
        // exibir alerta de que existe filial já cadastrada com este CNPJ.
        $cnpjFilial = $this->clientes_model->getFilialByCnpj($this->input->post('cnpjFilial'));
        
        if ($cnpjFilial != null && $cnpjFilial->idFiliais <> $this->input->post('idFiliais')) {
            $this->session->set_flashdata('error', 'Este CNPJ já está cadastrado.');
            $this->data['custom_error'] = '<div class="form_error">' . 'Este CNPJ já está cadastrado!' . '</div>';
            
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(400)
                ->set_output(json_encode('Este CNPJ já está cadastrado!'));
        }

        $idFilial = $this->input->post('idFiliais');
        $nome = $this->input->post('nomeFilial');
        $nomeFantasia = $this->input->post('nomeFantasiaFilial');
        $cnpj = $this->input->post('cnpjFilial');
        $ie = $this->input->post('ieFilial');
        $telefone = $this->input->post('telefoneFilial');
        $celular = $this->input->post('celularFilial');
        $email = $this->input->post('emailFilial');
        $rua = $this->input->post('ruaFilial');
        $numero = $this->input->post('numeroFilial');
        $complemento = $this->input->post('complementoFilial');
        $bairro = $this->input->post('bairroFilial');
        $cidade = $this->input->post('cidadeFilial');
        $estado = $this->input->post('estadoFilial');
        $cep = $this->input->post('cepFilial');
        $obs = $this->input->post('observacoesFilial');
        $cliente_id = $this->input->post('idClientes');
        $data = [
            'idFiliais' => $idFilial,
            'nome' => $nome,
            'nomeFantasia' => $nomeFantasia,
            'cnpj' => $cnpj,
            'ie' => $ie,
            'telefone' => $telefone,
            'celular' => $celular,
            'email' => $email,
            'rua' => $rua,
            'numero' => $numero,
            'bairro' => $bairro,
            'cidade' => $cidade,
            'estado' => $estado,
            'cep' => $cep,
            'observacoes' => $obs,
            'complemento' => $complemento,
            'clientes_id' => $cliente_id,
        ];

        $id = $this->input->post('idClientes');
        $cliente = $this->clientes_model->getById($id);
        if ($cliente == null) {
            $this->session->set_flashdata('error', 'Erro ao editar filial.');
            redirect(base_url() . 'index.php/clientes/');
        }

        if ($this->clientes_model->edit('filiais', $data, 'idFiliais', $idFilial) == true) {
            $this->session->set_flashdata('success', 'Filial editada com sucesso!');
            log_info('Alterou uma filial. ID' . $this->input->post('idFiliais'));

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(['result' => true]));
        } else {
            $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro ao editar a Filial.</p></div>';

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(500)
                ->set_output(json_encode(['result' => false]));
        }

    }

    public function excluirFilial()
    {
        $id = $this->input->post('idFiliais');
        $idCliente = $this->input->post('idClientes');

        $cliente = $this->clientes_model->getById($idCliente);
        if ($cliente == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir filial.');
            redirect(base_url() . 'index.php/clientes/');
        }

        if ($this->clientes_model->delete('filiais', 'idFiliais', $id) == true) {
            
            log_info('Removeu filial do cliente código: ' . $idCliente);

            echo json_encode(['result' => true]);
        } else {
            echo json_encode(['result' => false]);
        }
    }
}
