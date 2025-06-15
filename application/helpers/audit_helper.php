<?php

// log info
function log_info($task, $user = null)
{
    $ci = &get_instance();
    $ci->load->model('Audit_model');

    $data = [
        'usuario' => empty($user)
            ? $ci->session->userdata('nome_admin')
            : $user,
        'ip' => $ci->input->ip_address(),
        'tarefa' => $task,
        'data' => date('Y-m-d'),
        'hora' => date('H:i:s'),
    ];

    $ci->Audit_model->add($data);
}
