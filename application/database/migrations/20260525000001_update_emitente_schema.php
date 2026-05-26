<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Migration_update_emitente_schema extends CI_Migration
{
    public function up()
    {
        // 1. Atualizar tamanhos de colunas existentes
        $this->dbforge->modify_column('emitente', [
            'rua' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'bairro' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'cidade' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
            ],
            'numero' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'cep' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
            ],
            'telefone' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => true,
            ],
            'cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => '18',
                'null' => true,
            ],
            'ie' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
        ]);

        // 2. Adicionar novas colunas se não existirem
        $columns_to_add = [
            'complemento' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'numero',
            ],
            'im' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
                'after' => 'ie',
            ],
            'cnae' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => true,
                'after' => 'im',
            ],
            'atividade_principal' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'cnae',
            ],
            'situacao' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'after' => 'atividade_principal',
            ],
            'data_situacao' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'situacao',
            ],
            'data_abertura' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'data_situacao',
            ],
            'natureza_juridica' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true,
                'after' => 'data_abertura',
            ],
            'porte' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
                'after' => 'natureza_juridica',
            ],
            'capital_social' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => true,
                'after' => 'porte',
            ],
            'qsa' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'capital_social',
            ],
            'email_contador' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE,
                'after' => 'email'
            ],
            'codigo_ibge' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
                'null' => TRUE,
                'after' => 'cep'
            ],
            'numero_nfe' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0,
                'after' => 'codigo_ibge'
            ],
            'numero_nfce' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => FALSE,
                'default' => 0,
                'after' => 'numero_nfe'
            ],
            'latitude' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'longitude' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
        ];

        foreach ($columns_to_add as $column => $config) {
            if (!$this->db->field_exists($column, 'emitente')) {
                $this->dbforge->add_column('emitente', [$column => $config]);
            }
        }
    }

    public function down()
    {
        // Reverter colunas adicionadas
        $columns_to_drop = [
            'complemento', 'im', 'cnae', 'atividade_principal', 'situacao',
            'data_situacao', 'data_abertura', 'natureza_juridica', 'porte',
            'capital_social', 'qsa', 'email_contador', 'codigo_ibge',
            'numero_nfe', 'numero_nfce', 'latitude', 'longitude'
        ];

        foreach ($columns_to_drop as $column) {
            if ($this->db->field_exists($column, 'emitente')) {
                $this->dbforge->drop_column('emitente', $column);
            }
        }

        // Reverter tamanhos de colunas (aproximadamente aos valores anteriores conhecidos)
        $this->dbforge->modify_column('emitente', [
            'rua' => ['type' => 'VARCHAR', 'constraint' => '70', 'null' => true],
            'bairro' => ['type' => 'VARCHAR', 'constraint' => '45', 'null' => true],
            'cidade' => ['type' => 'VARCHAR', 'constraint' => '45', 'null' => true],
            'numero' => ['type' => 'VARCHAR', 'constraint' => '15', 'null' => true],
            'cep' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'telefone' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'cnpj' => ['type' => 'VARCHAR', 'constraint' => '45', 'null' => true],
            'ie' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
        ]);
    }
}
