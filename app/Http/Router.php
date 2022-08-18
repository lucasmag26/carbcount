<?php

namespace App\Http;

use \Closure;
use \Exception;

class Router{


    /**
     * URL completa do projeto (raiz)
     * @var string
     */
    private $url = '';

     /**
     * Prefixo de todas as Rotas
     * @var string
     */
    private $prefix = '';

     /**
     * Indice das rotas
     * @var array
     */
    private $routes = [];


    /**
     * Instancia de Request
     * @var Request
     */
    private $request;

    
    /**
     * Método responsavel por iniciar a classe
     * @param string $url
     */
    public function __construct($url){
        $this->request = new Request();
        $this->url     = $url;
        $this->setPrefix();
    }


    /**
     * Método responsável por definir o prefixo das rotas
     */
    private function setPrefix(){
        //INFORMAÇÕES ATUAIS
        $parseUrl = parse_url($this->url);

        //DEFINE O PREFIXO
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método resposnavel por adicionar uma rota na classe
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route,$params = [])
    {
       //VALIDAÇÃO DOS PARAMETROS
       foreach($params as $key=>$value){
        if($value instanceof Closure){
            $params['controller'] = $value;
            unset($params[$key]);
            continue;
        }
       }

       //PADRÃO DE VALIDAÇÃO DA URL
       $patternRoute = '/^'.str_replace('/','\/', $route).'$/';

       //ADICIONA A ROTA DENTRO DA CLASSE
       $this->routes[$patternRoute][$method] = $params;
       

    }

    /**
     * Método responsavel por definir uma rota de GET
     * @param string $rout
     * @param array $params
     */
    public function get($route,$params = []){
        return $this->addRoute('GET',$route,$params);


    }

    /**
     * Método responsavel por definir uma rota de POST
     * @param string $rout
     * @param array $params
     */
    public function post($route,$params = []){
        return $this->addRoute('POST',$route,$params);


    }

    /**
     * Método responsavel por definir uma rota de PUT
     * @param string $rout
     * @param array $params
     */
    public function put($route,$params = []){
        return $this->addRoute('PUT',$route,$params);


    }


    /**
     * Método responsavel por definir uma rota de DELETE
     * @param string $rout
     * @param array $params
     */
    public function delete($route,$params = []){
        return $this->addRoute('DELETE',$route,$params);


    }




    /**
     * Método responsavel por retornar o uri desconsiderando o prefixo
     * @return string
     */
    private function getUri(){
        //URI DA REQUEST
        $uri = $this->request->getUri();
        
        //FATIA A URI COM PREFIXO
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];
      
        return end($xUri);
    }

    /**
     * Método responsavel por retornar os dados da rota atual
     * @return array
     */
    private function getRoute(){
        //URI
        $uri = $this->getUri();


        //METHOD
        $httpMethod = $this->request->getHttpMethod();
       

        //VALIDA AS ROTAS
        foreach($this->routes as $patternRoute=>$methods){

            //VERIFICA SE A URI BATE O PADRÃO
            if(preg_match($patternRoute,$uri)){
            //VERIFICA O METODO
               if($methods[$httpMethod]){
                return $methods[$httpMethod];
               }
               throw new Exception("Método não permitido", 405);
            } 
        }

        throw new Exception("URL não encontrada", 404);
        
    }


    /**
     * Método reposnavel por executar a rota atual
     * @return Response
     */
    public function run(){
        try{
           
            $route = $this->getRoute();

            //VERIFICA O CONTROLADOR
            if(!isset($route['controller'])){
                throw new Exception("A URL não pode ser processada", 500);
            }
            
            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //RETORNO DA EXECUÇÃO DA FUNÇÃO
            return call_user_func_array($route['controller'],$args);
     
        }catch(Exception $e){
            return new Response($e->getCode(),$e->getMessage());
        }


    }

}