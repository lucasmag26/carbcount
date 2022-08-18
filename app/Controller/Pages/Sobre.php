<?php
namespace App\Controller\Pages;

use \App\Utils\View;

class Sobre extends Page {

    /**
     * Método Responsável por retornar o conteúdo (view) da nosso Sobre
     * @return string
     */
    public static function getSobre(){

        // VIEW DA SOBRE
       $content =  View::render('pages/sobre', [
            'name'        => 'Sobre',
            'description' => 'Página de Sobre'
            
        ]);

        //RETORNA A VIEW DA PAGINA
        return parent::getPage('Sobre', $content);

    }
}