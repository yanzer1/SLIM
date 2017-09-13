<?php
require 'vendor/autoload.php';
require 'lib/mysql.php';

$app = new Slim\App();

$app->get('/','get_assoc');

$app->get('/assoc/{id}', function($request, $response, $args){
    get_assoc_id($args['id']);
});

$app->post('/assoc_add', function($request, $response, $args){
    add_assoc($request->getParsedBody());
});

$app->put('/update_assoc', function($request, $response, $args){
    update_assoc($request->getParsedBody());
});

$app->delete('/delete_assoc', function ($request, $response, $args){
    delete_assoc($request->getParsedBody());
});

$app->run();



function get_assoc(){
    $db = connect_db();
    $sql = 'SELECT * FROM terra_association ORDER BY `nom`';
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQL_ASSOC);
    $db = null;
    echo json_encode($data);
}

function get_assoc_id($assoc_id) {
    $db = connect_db();
    $sql = "SELECT * FROM terra_association WHERE `id_associa` = '$assoc_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function add_assoc($data) {
    $db = connect_db();
    $sql = "insert into terra_association (nom,ville,adresse,cp,site_web,photo,type)"
        . " VALUES('$data[nom]','$data[ville]','$data[adresse]','$data[cp]','$data[site_web]','$data[photo]','$data[type]')";
    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function update_assoc($data) {
    $db = connect_db();
    $sql = "update terra_association SET nom = '$data[nom]',ville = '$data[ville]',adresse ='$data[adresse]',cp='$data[cp]',site_web='$data[site_web]',photo='$data[photo]',type='$data[type]'"
        . " WHERE id_associa = '$data[id_associa]'";
    $exe = $db->query($sql);
    $last_id = $db->affected_rows;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function delete_assoc($assoc) {
    $db = connect_db();
    $sql = "DELETE FROM terra_association WHERE id_associa = '$assoc[id_associa]'";
    $exe = $db->query($sql);
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}