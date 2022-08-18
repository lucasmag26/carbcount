<?php

    require __DIR__.'/vendor/autoload.php';

    use \App\Http\Router;
    
    define('URL', 'http://localhost/carbcount');

    $obRouter = new Router(URL);


    //INCLUI AS ROTAS DAS PÁGINAS
    include __DIR__.'/routes/pages.php';

    //IMPRIME O RESPONSE DA ROTA
    $obRouter->run()
             ->sendResponse();

    
?>