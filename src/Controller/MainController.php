<?php

namespace App\Controller;

use App\Service\PostParserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    /**
     * @Route("/main", name="main")
     */
    public function index()
    {
        // replace this line with your own code!
        /**
         * @var PostParserService $postParser
         */
        $postParser = $this->container->get('app.PostParser');
        
        return $this->json($postParser->parcePost(123));
    }
}
