<?php
function kio_test_update($request) {

    $data = $request->get_json_params();

    update_option('kio_last_update_test', $data);

    return [
        'success' => true,
        'received' => $data
    ];
}
?>