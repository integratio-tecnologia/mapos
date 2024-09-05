<?php

class Migration_add_config_observacoes_os extends CI_Migration
{
    public function up()
    {
        $this->db->query("INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (16, 'obs_geral1', '');");
        $this->db->query("INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (17, 'obs_geral2', '');");
        $this->db->query("INSERT INTO `configuracoes` (`idConfig`, `config`, `valor`) VALUES (18, 'obs_geral3', '');");
    }

    public function down()
    {
        $this->db->query('DELETE FROM `configuracoes` WHERE `configuracoes`.`idConfig` = 16');
        $this->db->query('DELETE FROM `configuracoes` WHERE `configuracoes`.`idConfig` = 17');
        $this->db->query('DELETE FROM `configuracoes` WHERE `configuracoes`.`idConfig` = 18');
    }
}
