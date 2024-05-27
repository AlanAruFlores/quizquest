<?php  
    class Router{

        private $defaultMethod;
        private $defaultController;
        public function __construct($defaultController, $defaultMethod){
            $this->defaultController = $defaultController;
            $this->defaultMethod = $defaultMethod;
        }

        public function route($controllerName, $methodName)
        {
            $controller = $this->getControllerFrom($controllerName);
            $this->executeMethodFromController($controller, $methodName);
        }
    
        //Llama al controlador
        private function getControllerFrom($module)
        {
            $controllerName = 'get' . ucfirst($module) . 'Controller';
            // Verifica si existe el controlador en el archivo de Configuration, si no existe usa el controlador por defecto
            $validController = method_exists("Configuration", $controllerName) ? $controllerName : $this->defaultController;
            
            return call_user_func(array("Configuration", $validController));
        }
    
        //Ejecuta el metodo del controlador
        private function executeMethodFromController($controller, $method)
        {
            $validMethod = method_exists($controller, $method) ? $method : $this->defaultMethod;
            call_user_func(array($controller, $validMethod));
        }
    }
?>