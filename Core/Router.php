<?php


namespace Core;

class Router 
{
    static function processRequest(Request $request): Response 
    {
        
        $route = $request->getRoute();
        $parameters = $request->getData();
        $method = $request->getMethod();
        $response = new Response();

        if ($route == '/') { 
            return Router::defaultPage($response);
        }

        if (!isset(URL_LIST[$method][$route])) {
            return Router::errorPage404($response);
        }
        
        if (array_keys($parameters) !== URL_LIST[$method][$route]['parameters']) {
            Logger::log(json_encode(array_keys($parameters)) . "!=" . json_encode(URL_LIST[$method][$route]['parameters']));
            return Router::errorPage400($response);
        }

        $controllerName = '\Controllers\\' . URL_LIST[$method][$route]['controller'];
        $action = URL_LIST[$method][$route]['action'];
        
        $controllerObj = new $controllerName();
        
        return URL_LIST[$method][$route]['parameters'] != [] ? 
        $controllerObj->$action($parameters) : $controllerObj->$action();
    }

    static private function defaultPage(Response $response)
    {
        $response->setHeader('Location: http://www.dev-cloud-storage.local/main');
		return $response;
    }

    static private function errorPage404(Response $response)
    {
        $response->setHeader('HTTP/1.1 404 Not Found');
		$response->setHeader("Status: 404 Not Found");
        return $response;
    }

    static private function errorPage400(Response $response)
    {
        $response->setHeader('HTTP/1.1 400 Bad Request');
		$response->setHeader("Status: 400 Bad Request");
        return $response;
    }
}