<?php
namespace App\Controller\Pages;

use \App\Utils\View;

class Home extends Page {

    /**
     * Método Responsável por retornar o conteúdo (view) da nossa home
     * @return string
     */
    public static function getHome(){

        // VIEW DA HOME
       $content =  View::render('pages/home', [
            'name'=> 'Lucas Magno',
            'description' => 'Projeto TG'
            
        ]);

        //RETORNA A VIEW DA PAGINA
        return parent::getPage('Teste', $content);

    }
}