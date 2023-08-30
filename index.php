<?php

/* echo phpinfo(); */

/* var_dump(getenv('PHP_ENV'), $_SERVER, $_REQUEST); */

$requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestPath = $_SERVER['REQUEST_URI'] ?? '/';

if($requestMethod === 'GET' and $requestPath === '/whoosh/'){
    print <<< html
    <!doctype html>
    <html lang="en">
        <body>
            Hello World
        </body>
    </html>
    html;
} else {
    print "404 not found";
}
$routes = [
            'get' => [
                    '/whoosh/' => fn() =>print <<< html
                        <!doctype html>
                        <html lang="en">
                            <body>
                                Hello World
                            </body>
                        </html>
                        html,
                    ],
            'post' => [],
            'patch' => [],
            'put' => [],
            'delete'=> [],
            'head' => [],
            

        ];

   $paths = array_merge(
    array_keys($routes['get']),
    array_keys($routes['post']),
    array_keys($routes['patch']),
    array_keys($routes['put']),
    array_keys($routes['delete']),
    array_keys($routes['head'])
   );     
  

   if(isset($routes[$requestMethod], $routes[$requestMethod][$requestPath])){
     $routes[$requestMethod][$requestPath];
   }
?>