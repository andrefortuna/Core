<?php
class Core
{
    public function run()
    {
        $url ='/'; //se o usuário não digitar nada na URL, coloca uma barra
        
        if(isset($_GET['url'])) //se estiver setada a querystring '?url='
        {
            $url .= $_GET['url']; //agrega a querystring '?url=' a barra se estiver setada
        }
        
        $params = array(); //transforma a variável $params em um array
        
        if(!empty($url) && $url != '/') //se a URL não for vazia e diferente da string '/'
        {
            $url = explode('/',$url); //explode a URL em cada barra
            array_shift($url); //tira o primeiro array prque o primeiro parâmetro antes da primeira barra sempre vai ser vazio
            
            $currentController = $url[0].'Controller'; //a variável $currentController pega o primeiro ítem da querystring '?url=' depois da barra e agrega com a string 'Controller' para puxar a classe certa
            array_shift($url); //removemos o primeiro ítem da querystring '?url=' que seria o "'x'Controller" da variável $url
            
            if(isset($url[0]) && !empty($url[0])) //se estiver setada a $url[0] que seria o método ou segundo parâmetro da nossa URL
            {
                $currentAction = $url[0]; //a ação ou o método da URL é atribuída a variável $currentAction
                array_shift($url); //agora a gente remove o método da variável $url
            }
            else //senão
            {
                $currentAction = 'index'; //o método da nossa variável $currentAction se chamará 'index'
            }
            
            if(count($url) > 0) //se a contagem do array $url for maior que zero
            {
                $params = $url; //a variável $params será atribuída da $url restante
            }
        }
        else //senão
        {
            $currentController = 'homeController'; //se a variável $currentController não possuir nenhum valor será atribuída 'homeController' à mesma variável
            $currentAction = 'index'; //se a variável $currentAction não possuir nenhum valor será atribuída 'index' à mesma variável
        }
        
        $c = new $currentController; //instancia a variável $currentController como se fosse uma classe, para pegar o valor correto do valor da classe Controller a ser usada
        call_user_func_array(array($c, $currentAction), $params); //essa função faz com que a classe instanciada junto ao método instanciado no caso respectivamente $c e $currentAction sejam setados só que o método $currentAction poderá receber atributos que serão os $params que também é um array
        //na função call_user_func_array($func, $params) o primeiro parâmetro é tratado como uma variável e o segundo como um array
        //por isso na função acima, por ter três parâmetros, os dois primeiros são tratados dentro da função array e o segundo fora do array
    }
}
