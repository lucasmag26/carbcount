<?php

    require __DIR__.'/vendor/autoload.php';

    use \App\Http\Router;
    use \App\Http\Response;
    use \App\Controller\Pages\Home;
    
    define('URL', 'http://localhost/carbcount');

    $obRouter = new Router(URL);

    //ROTE HOME
    $obRouter->get('/',[
        function(){
            return new Response(200,Home::getHome());
        }
    ]);

    //ROTE HOME
    $obRouter->get('/sobre',[
        function(){
            return new Response(200,Home::getHome());
        }
    ]);


    //INCLUI AS ROTAS DAS PÁGINAS
    //include __DIR__.'/routes/pages.php';

    //IMPRIME O RESPONSE DA ROTA
    $obRouter->run()
             ->sendResponse();

    
?>