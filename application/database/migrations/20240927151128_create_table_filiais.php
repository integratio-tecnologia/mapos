<?php

class Migration_create_table_filiais extends CI_Migration
{
    public function up()
    {
        // Cria a tabela filiais
        $this->db->query('CREATE TABLE IF NOT EXISTS `filiais` (`idFiliais` INT NOT NULL AUTO_INCREMENT, `asaas_id` VARCHAR(255) DEFAULT NULL,
            `nome` VARCHAR(255) NOT NULL, `nomeFantasia` VARCHAR(100) NULL DEFAULT NULL, `cnpj` VARCHAR(20) NOT NULL,
            `ie` VARCHAR(20) NULL DEFAULT NULL, `telefone` VARCHAR(20) NULL DEFAULT NULL, `celular` VARCHAR(20) NOT NULL,
            `email` VARCHAR(100) NOT NULL, `rua` VARCHAR(100) NULL DEFAULT NULL, `numero` VARCHAR(15) NULL DEFAULT NULL,
            `bairro` VARCHAR(100) NULL DEFAULT NULL, `cidade` VARCHAR(100) NULL DEFAULT NULL, `estado` VARCHAR(20) NULL DEFAULT NULL,
            `cep` VARCHAR(20) NULL DEFAULT NULL, `complemento` VARCHAR(45) NULL DEFAULT NULL, `observacoes` VARCHAR(200) NULL DEFAULT NULL,
            `dataCadastro` DATE NULL DEFAULT NULL, `senha` VARCHAR(200) NOT NULL, `clientes_id` INT NOT NULL, PRIMARY KEY (`idFiliais`),
            INDEX `fk_filiais_clientes_idx` (`clientes_id` ASC),
            CONSTRAINT `fk_filiais_clientes`
            FOREIGN KEY (`clientes_id`)
            REFERENCES `clientes` (`idClientes`) ON DELETE NO ACTION ON UPDATE NO ACTION)
            ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;');
    }

    public function down()
    {
        $this->dbforge->drop_table('filiais');
    }
}
