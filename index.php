<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$url_root = $_SERVER['DOCUMENT_ROOT'];
$url_server = 'https://' . $_SERVER['HTTP_HOST'];
$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

define("APP_SERVER", $url_server); 
define("APP_ROOT", $url_root);
define("APP_WEB",$base_url);

require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

class Route {
    private function simpleRoute($file, $route){
        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if(!empty($_REQUEST['uri'])){
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
        }else{
            $reqUri = "/";
        }

        if($reqUri == $route){
            $params = [];
            include($file);
            exit();

        }

    }

    function add($route,$file){

        //will store all the parameters value in this array
        $params = [];

        //will store all the parameters names in this array
        $paramKey = [];

        //finding if there is any {?} parameter in $route
        preg_match_all("/(?<={).+?(?=})/", $route, $paramMatches);

        //if the route does not contain any param call simpleRoute();
        if(empty($paramMatches[0])){
            $this->simpleRoute($file,$route);
            return;
        }

        //setting parameters names
        foreach($paramMatches[0] as $key){
            $paramKey[] = $key;
        }

       
        //replacing first and last forward slashes
        //$_REQUEST['uri'] will be empty if req uri is /

        if (!empty($_REQUEST['uri'])){
            $route = preg_replace("/(^\/)|(\/$)/","",$route);
            $reqUri =  preg_replace("/(^\/)|(\/$)/","",$_REQUEST['uri']);
        } else {
            $reqUri = "/";
        }

        //exploding route address
        $uri = explode("/", $route);

        //will store index number where {?} parameter is required in the $route 
        $indexNum = []; 

        //storing index number, where {?} parameter is required with the help of regex
        foreach($uri as $index => $param){
            if(preg_match("/{.*}/", $param)){
                $indexNum[] = $index;
            }
        }

        //exploding request uri string to array to get
        //the exact index number value of parameter from $_REQUEST['uri']
        $reqUri = explode("/", $reqUri);

        //running for each loop to set the exact index number with reg expression
        //this will help in matching route
        foreach($indexNum as $key => $index){

             //in case if req uri with param index is empty then return
            //because url is not valid for this route
            if(empty($reqUri[$index])){
                return;
            }

            //setting params with params names
            $params[$paramKey[$key]] = $reqUri[$index];

            //this is to create a regex for comparing route address
            $reqUri[$index] = "{.*}";
        }

        //converting array to sting
        $reqUri = implode("/",$reqUri);

        //replace all / with \/ for reg expression
        //regex to match route is ready !
        $reqUri = str_replace("/", '\\/', $reqUri);

        //now matching route with regex
        if(preg_match("/$reqUri/", $route))
        {
            include($file);
            exit();

        }
    }

    function notFound($file){
        include($file);
        exit();
    }
}

$route = new Route(); 

// Route for paths containing '/control/'
require_once(APP_ROOT . '/connection.php');
require_once(APP_ROOT . '/public/inc/functions.php');

// API SERVER - GET/POST/PUT/DELETE PETITIONS

// AUTH API
$route->add("/api/auth/post","api/auth/post-login.php");
$route->add("/api/auth/login","api/auth/login.php");

// USERS API
$route->add("/api/users/post","api/users/post-users.php");
$route->add("/api/users/get","api/users/get-users.php");
$route->add("/api/users/put","api/users/put-users.php");

// CLIENTS API
$route->add("/api/clients/get","api/clients/get-clients.php");
$route->add("/api/clients/post","api/clients/post-clients.php");
$route->add("/api/clients/put","api/clients/put-clients.php");
$route->add("/api/clients/delete","api/clients/delete-clients.php");

// JOBS API
$route->add("/api/job/get","api/job/get-job.php");
$route->add("/api/job/post","api/job/post-job.php");
$route->add("/api/job/put","api/job/put-job.php");

// PLANNING TASKS API
$route->add("/api/planning/get","api/planning/get-planning.php");
$route->add("/api/planning/post","api/planning/post-planning.php");
$route->add("/api/planning/put","api/planning/put-planning.php");

// CLIENT FORMS API
$route->add("/api/form/get","api/form/get-form.php");
$route->add("/api/form/post","api/form/post-form.php");
$route->add("/api/form/put","api/form/put-form.php");

// CALENDAR OFFICE API
$route->add("/api/calendar/all","api/calendar/calendar.php");

// PAGES WITHOUT ACCESS RESTRICTED
$route->add("/","public/form_list_form.php");
$route->add("/form","public/form_list/public_website/form.php");
$route->add("/login","public/auth/login.php");
 
// Configurar los parámetros de la cookie de sesión
ini_set('session.cookie_domain', '.finguer.gestionparking.net');
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30); // 30 días en segundos
ini_set('session.cookie_path', '/');
ini_set('session.cookie_secure', true); // Usar true si usas HTTPS
ini_set('session.cookie_httponly', true);
ini_set('session.cookie_samesite', 'Strict');

// Iniciar la sesión
session_set_cookie_params([
    'lifetime' => 60 * 60 * 24 * 30,  // 30 días en segundos
    'path' => '/',
    'domain' => '.finguer.gestionparking.net', // Asegúrate de usar el dominio correcto
    'secure' => true,    // Usar true si usas HTTPS
    'httponly' => true,
    'samesite' => 'Strict' // o 'Lax' dependiendo de tus necesidades
]);

session_start();

        // Obtener el nombre de la cookie de sesión
        $session_name = session_name();

        // Obtener el ID de sesión actual
        $session_id = session_id();

        // Establecer la cookie de sesión con fecha de caducidad de 30 días
        setcookie($session_name, $session_id, time() + 60 * 60 * 24 * 30, '/', $url_server, true, true);

        if (empty($_SESSION['user']) || !session_id()) {

            header('Location: ' . APP_WEB . '/login');
            exit(); 
        
        } else {
            // PRIVATE PAGES - ONLY AUTHORISED USERS CAN ACCESS

            // HEADER FOR ALL PAGES
            require_once(APP_ROOT . '/public/inc/header_html.php');

            // HOMEPAGE
            $route->add("/private","public/private/index.php");
            $route->add("/homepage","public/private/index.php");

            // USERS SECTION
            $route->add("/user-list","public/user_list/index.php");
            $route->add("/user-list/new","public/user_list/new-user.php");
            $route->add("/user-list/{user}/password","public/user_list/password-user.php");

            // CLIENT LIST SECTION
            $route->add("/client-list","public/client_list/index.php");
            $route->add("/client-list/new","public/client_list/new-client.php");
            $route->add("/client-list/view/{id}","public/client_list/view-client.php");
            $route->add("/client-list/update/{id}","public/client_list/update-client.php");

             // JOB LIST SECTION
             $route->add("/job-list","public/job_list/index.php");
             $route->add("/job-list/new","public/job_list/new-job.php");
             $route->add("/job-list/update/{id}","public/job_list/update-job.php");
             $route->add("/job-list/view/{id}","public/job_list/view-job.php");
             $route->add("/job-list/status/{status}","public/job_list/status-job.php");
             $route->add("/job-list/user/{user}","public/job_list/view-job-user.php");
             $route->add("/job-list/notes/new/{id}","public/job_list/new-note.php");
             $route->add("/job-list/notes/update/{id}","public/job_list/update-note.php");

             // FORM LIST SECTION
             $route->add("/form-list","public/form_list/index.php");
             $route->add("/form-list/view/{clientId}","public/form_list/view-client-form.php");

              // PLANNING TASKS LIST SECTION
              $route->add("/planning-list","public/planning_list/index.php");
              $route->add("/planning-list/new/job/{jobId}","public/planning_list/new-planning-job.php");
              $route->add("/planning-list/new/{userId}","public/planning_list/new-planning.php");
              $route->add("/planning-list/new/","public/planning_list/new-planning.php");
              $route->add("/planning-list/view/user/{userId}","public/planning_list/view-user-tasks.php");
        }

        // Error route (404)
        $route->notFound("public/private/404.php");

?>