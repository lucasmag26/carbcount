<?php

use \App\Http\Response;
use \App\Controller\Pages;


//ROTE HOME
$obRouter->get('/',[
    function(){
        return new Response(200,Pages\Home::getHome());
    }
]);

//ROTE HOME
$obRouter->get('/sobre',[
    function(){
        return new Response(200,Pages\Sobre::getSobre());
    }
]);




?>