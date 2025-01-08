<?php

class Equipamentos_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        //Pesquisar equipamentos incluindo a marca e o cliente relacionado ao equipamento
        $this->db->select($fields . ', marcas.marca as marca, clientes.nomeCliente as cliente');
        $this->db->from($table);
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->join('clientes', 'clientes.idClientes = equipamentos.clientes_id', 'left');
        $this->db->order_by('idEquipamentos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('idEquipamentos', $where);
            $this->db->or_like('equipamento', $where);
            $this->db->or_like('num_serie', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $data = [];

        $this->db->select('equipamentos.*, marcas.marca as marca, clientes.nomeCliente as cliente');
        $this->db->from('equipamentos');
        $this->db->join('marcas', 'marcas.idMarcas = equipamentos.marcas_id', 'left');
        $this->db->join('clientes', 'clientes.idClientes = equipamentos.clientes_id', 'left');
        $this->db->where('idEquipamentos', $id);
        $this->db->limit(1);
        $data['equipamento'] = $this->db->get()->row();

        $this->db->select('fotos_equipamentos.*');
        $this->db->from('fotos_equipamentos');
        $this->db->where('equipamentos_id', $id);
        $this->db->order_by('idFotosEquipamentos', 'asc');
        $data['fotos'] = $this->db->get()->result();

        $this->db->select('os.*');
        $this->db->from('os');
        $this->db->where('equipamentos_id', $id);
        $this->db->order_by('idOS', 'asc');
        $data['ordens'] = $this->db->get()->result();
        
        return $data;
    }
    
    public function getMarcas($id = null)
    {
        $this->db->select('marcas.*');
        $this->db->order_by('marca', 'asc');
        if ($id) {
            $this->db->where('idMarcas', $id);
        }
        return $this->db->get('marcas')->result();

    }

    # Pesquisa fotos do equipamento
    public function getFotos($id)
    {
        $this->db->select('fotos_equipamentos.*');
        $this->db->from('fotos_equipamentos');
        $this->db->where('equipamentos_id', $id);
        $this->db->order_by('idFotosEquipamentos', 'asc');
        $result = $this->db->get()->result();

        return $result;
    }

    public function getFotosById($id)
    {
        $this->db->select('fotos_equipamentos.*');
        $this->db->from('fotos_equipamentos');
        $this->db->where('idFotosEquipamentos', $id);
        $this->db->limit(1);
        $result = $this->db->get()->row();

        return $result;
    }

    #
    # CRUD
    #

    public function add($table, $data)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            return $this->db->insert_id($table);
        }

        return false;
    }

    public function edit($table, $data, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->update($table, $data);

        if ($this->db->affected_rows() >= 0) {
            return true;
        }

        return false;
    }

    public function delete($table, $fieldID, $ID)
    {
        $this->db->where($fieldID, $ID);
        $this->db->delete($table);
        if ($this->db->affected_rows() == '1') {
            return true;
        }

        return false;
    }

    /* public function addImages($id, $foto, $url, $thumb, $path)
    {
        $this->db->set('foto', $foto);
        $this->db->set('url', $url);
        $this->db->set('thumb', $thumb);
        $this->db->set('path', $path);
        $this->db->set('equipamentos_id', $id);

        return $this->db->insert('fotos_equipamentos');
    } */

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function autoCompleteCliente($q)
    {
        $this->db->select('*');
        $this->db->limit(25);
        $this->db->like('idClientes', $q);
        $this->db->or_like('nomeCliente', $q);
        $this->db->or_like('nomeFantasia', $q);
        $this->db->or_like('contato', $q);
        $this->db->or_like('telefone', $q);
        $this->db->or_like('celular', $q);
        $this->db->or_like('email', $q);
        $this->db->or_like('bairro', $q);
        $this->db->or_like('cidade', $q);
        $this->db->or_like('cep', $q);
        $this->db->or_like('documento', $q);
        $query = $this->db->get('clientes');
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row_set[] = ['label' => 'Cód.: ' . $row['idClientes'] . ' | ' . $row['nomeCliente'] . ' | Telefone: ' . $row['telefone'] . ' | Documento: ' . $row['documento'], 'id' => $row['idClientes']];
            }
            echo json_encode($row_set);
        }
    }
}
