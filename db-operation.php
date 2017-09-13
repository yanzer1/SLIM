<?php

require 'vendor/autoload.php';
require 'lib/mysql.php';

$app = new Slim\App();

$app->get('/','get_user');

$app->get('/user/{id}', function($request, $response, $args){
   get_user_id($args['id']);
});

$app->post('/user_add', function($request, $response, $args){
   add_user($request->getParsedBody());
});

$app->put('/update_user', function($request, $response, $args){
   update_user($request->getParsedBody());
});

$app->delete('/delete_user', function ($request, $response, $args){
    delete_user($request->getParsedBody());
});

$app->run();



function get_user(){
    $db = connect_db();
    $sql = 'SELECT * FROM terra_user ORDER BY `nom`';
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQL_ASSOC);
    $db = null;
    echo json_encode($data);
}

function get_user_id($user_id) {
    $db = connect_db();
    $sql = "SELECT * FROM terra_user WHERE `id_user` = '$user_id'";
    $exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;
    echo json_encode($data);
}

function add_user($data) {
    $db = connect_db();
    $sql = "insert into terra_user (nom,prenom,ville,adresse,cp,sexe,mail,tel,mdp)"
        . " VALUES('$data[nom]','$data[prenom]','$data[ville]','$data[adresse]','$data[cp]','$data[sexe]','$data[mail]','$data[tel]','$data[mdp]')";
    $exe = $db->query($sql);
    $last_id = $db->insert_id;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function update_user($data) {
    $db = connect_db();
    $sql = "update terra_user SET nom = '$data[nom]',prenom = '$data[prenom]',ville ='$data[ville]',adresse='$data[adresse]',cp='$data[cp]',mail='$data[mail]',tel='$data[tel]',mdp='$data[mdp]'"
        . " WHERE id_user = '$data[id_user]'";
    $exe = $db->query($sql);
    $last_id = $db->affected_rows;
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}

function delete_user($user) {
    $db = connect_db();
    $sql = "DELETE FROM terra_user WHERE id_user = '$user[id_user]'";
    $exe = $db->query($sql);
    $db = null;
    if (!empty($last_id))
        echo $last_id;
    else
        echo false;
}