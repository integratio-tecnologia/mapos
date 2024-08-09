<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_contatos_table extends CI_Migration {

    public function up()
    {
        // Cria a tabela contatos
        $this->db->query('CREATE TABLE IF NOT EXISTS `contatos` (`idContatos` INT NOT NULL AUTO_INCREMENT, `nomeContato` VARCHAR(255) NOT NULL, `telefone` VARCHAR(20) NULL DEFAULT NULL, `celular` VARCHAR(20) NOT NULL, `clientes_id` INT NOT NULL, PRIMARY KEY (`idContatos`), INDEX `fk_contatos_clientes_idx` (`clientes_id` ASC), CONSTRAINT `fk_contatos_clientes` FOREIGN KEY (`clientes_id`) REFERENCES `clientes` (`idClientes`) ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARACTER SET utfmb4 COLLATE utf8mb4_general_ci;');

    }

    public function down()
    {
        // Remove a tabela contatos
        $this->dbforge->drop_table('contatos');

    }
}