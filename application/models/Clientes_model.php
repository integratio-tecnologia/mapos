<?php

class Clientes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idClientes', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('nomeCliente', $where);
            $this->db->or_like('documento', $where);
            $this->db->or_like('ie', $where);
            $this->db->or_like('email', $where);
            $this->db->or_like('telefone', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getContatos($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idContatos', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('nomeContato', $where);
            $this->db->or_like('telefone', $where);
            $this->db->or_like('email', $where);
            $this->db->or_like('celular', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getFiliais($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
    {
        $this->db->select($fields);
        $this->db->from($table);
        $this->db->order_by('idFiliais', 'desc');
        $this->db->limit($perpage, $start);
        if ($where) {
            $this->db->like('nome', $where);
            $this->db->or_like('cnpj', $where);
            $this->db->or_like('ie', $where);
            $this->db->or_like('telefone', $where);
            $this->db->or_like('celular', $where);
            $this->db->or_like('email', $where);
            $this->db->or_like('rua', $where);
            $this->db->or_like('bairro', $where);
            $this->db->or_like('cidade', $where);
            $this->db->or_like('estado', $where);
            $this->db->or_like('cep', $where);
        }

        $query = $this->db->get();

        $result = ! $one ? $query->result() : $query->row();

        return $result;
    }

    public function getById($id)
    {
        $this->db->where('idClientes', $id);
        $this->db->limit(1);

        return $this->db->get('clientes')->row();
    }

    public function getFilialByCnpj($cnpj)
    {
        $this->db->where('cnpj', $cnpj);
        $this->db->limit(1);

        return $this->db->get('filiais')->row();
    }

    public function add($table, $data, $returnId = false)
    {
        $this->db->insert($table, $data);
        if ($this->db->affected_rows() == '1') {
            if ($returnId == true) {
                return $this->db->insert_id($table);
            }

            return true;
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

    public function count($table)
    {
        return $this->db->count_all($table);
    }

    public function getOsByCliente($id)
    {
        $this->db->where('clientes_id', $id);
        $this->db->order_by('idOs', 'desc');
        $this->db->limit(10);

        return $this->db->get('os')->result();
    }

    /**
     * Retorna todas as OS vinculados ao cliente
     *
     * @param  int  $id
     * @return array
     */
    public function getAllOsByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('os')->result();
    }

    /**
     * Remover todas as OS por cliente
     *
     * @param  array  $os
     * @return bool
     */
    public function removeClientOs($os)
    {
        try {
            foreach ($os as $o) {
                $this->db->where('os_id', $o->idOs);
                $this->db->delete('servicos_os');

                $this->db->where('os_id', $o->idOs);
                $this->db->delete('produtos_os');

                $this->db->where('idOs', $o->idOs);
                $this->db->delete('os');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Retorna todas as Vendas vinculados ao cliente
     *
     * @param  int  $id
     * @return array
     */
    public function getAllVendasByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('vendas')->result();
    }

    /**
     * Remover todas as Vendas por cliente
     *
     * @param  array  $vendas
     * @return bool
     */
    public function removeClientVendas($vendas)
    {
        try {
            foreach ($vendas as $v) {
                $this->db->where('vendas_id', $v->idVendas);
                $this->db->delete('itens_de_vendas');

                $this->db->where('idVendas', $v->idVendas);
                $this->db->delete('vendas');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Retorna todos os contatos por cliente
     * 
     * @param array $id
     * @return array
     */
    public function getAllContatosByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('contatos')->result();
    }

    /**
     * Remover todos os contatos por cliente
     *
     * @param  array  $contatos
     * @return bool
     */
    public function removeClientContatos($contatos)
    {
        try {
            foreach ($contatos as $c) {
                $this->db->where('clientes_id', $c->idContatos);
                $this->db->delete('contatos');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * Retorna todas as filiais por cliente
     * 
     * @param array $id
     * @return array
     */
    public function getAllFiliaisByClient($id)
    {
        $this->db->where('clientes_id', $id);

        return $this->db->get('filiais')->result();
    }

    /**
     * Remover todas as filiais por cliente
     *
     * @param  array  $filiais
     * @return bool
     */
    public function removeClientFiliais($filiais)
    {
        try {
            foreach ($filiais as $f) {
                $this->db->where('clientes_id', $f->idFiliais);
                $this->db->delete('filiais');
            }
        } catch (Exception $e) {
            return false;
        }

        return true;
    }
}
