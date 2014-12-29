<?php

namespace Nietonfir\Google\ReCaptchaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NietonfirGoogleReCaptchaBundle:Default:index.html.twig', array('name' => $name));
    }
}
