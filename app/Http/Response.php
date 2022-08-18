<?php

namespace App\Http;

Class Response{

    /**
     * Código do status http
     * @var integer
     */
    private $httpCode = 200;

     /**
     * Cabeçalho do response
     * @var array
     */
    private $headers = [];


     /**
     * tipo de conteudo do retorno da requisição
     * @var string
     */
    private $contentType = 'text/html';

     /**
     * Conteudo do Response
     * @var mixed
     */
    private $content;


    /**
     * Método responsael por iniciar a classe e definir os valores
     * @param integer $httpCode
     * @param mixed $contet
     * @param string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html'){
        $this->httpCode   = $httpCode;
        $this->content     = $content;
        $this->setContentType($contentType);

    }


    /**
     * Método responsavel por alterar o contet type do response
     * @param string $contetType
     */
    public function setContentType($contentType){
        $this->contentType = $contentType;
        $this->addHeader('Content-Type',$contentType);
    }

    /**
     * Método responsavel por adicionar um registro no cabeçalho de response
     * @param string $key
     * @param string $value
     */
    public function addHeader($key,$value){
        $this->headers[$key] = $value;
    }

    /**
     * Método responsavel por enviar os headers
     */
    private function sendHeaders(){
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach($this->headers as $key=>$value){
            header($key.': '.$value);

        }

    }

    /**
     * Método responsavelpor enviar a resposta para o usuário
     */
    public function sendResponse(){
        //ENVIA HEADDERS
        $this->sendHeaders();
        switch($this->contentType){
            case 'text/html':
                echo $this->content;
            exit;
        }
    }






}