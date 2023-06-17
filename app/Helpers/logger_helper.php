<?php

function logger($type = null, $data = null, $metode = null)
{
    $logs = new \App\Models\LogsModel();
    $request = $request = \Config\Services::request();
    $router = service('router');
    $item = [
        'type' => $type,
        'jemaat_id' => session()->get('jemaat_id') ? session()->get('jemaat_id') : "",
        'user_id' => session()->get('uid'),
        'ip_address' => $request->getIPAddress(),
        'router' => $router->controllerName(),
        'status' => is_null($metode) ? get_method($router->methodName()) : $metode,
        'data' => json_encode($data)
    ];
    $logs->insert($item);
    // log_message($type, json_encode($item));
}

function get_method($param)
{
    switch ($param) {
        case 'read':
            return "mengambil";
            break;

        case 'post':
            return "menambah";
            break;

        case 'put':
            return "mengubah";
            break;

        case 'delete':
            return "menghapus";
            break;

        default:
            return "index";
            break;
    }
}
