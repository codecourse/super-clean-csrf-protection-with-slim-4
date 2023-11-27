<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\{
    ServerRequestInterface as Request,
    ResponseInterface as Response
};

class HomeController extends Controller
{
    /**
     * Render the home page
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function index(Request $request, Response $response, $args)
    {   
        return $this->c->get('view')->render($response, 'home/index.twig');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function store(Request $request, Response $response, $args)
    {
        dump('Success');

        return $response;
    }
}
