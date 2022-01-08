<?php

use App\Controller\Ajouter;
use App\Controller\Connect;
use App\Controller\Contact;
use App\Controller\Gestion;
use App\Controller\Homepage;
use App\Controller\About;
use App\Controller\Faq;
use App\Controller\Homesession;
use App\Controller\Modifier;
use App\Controller\Register;
use App\Controller\Supprimer;
use App\Controller\Deconnect;
use Framework\Routing\Route;

return [
    new Route('GET', '/', Homepage::class),
    new Route(['GET', 'POST'], '/home', Homesession::class),
    new Route('GET', '/faq', Faq::class),
    new Route(['GET', 'POST'], '/gestion', Gestion::class),
    new Route(['GET', 'POST'], '/ajouter', Ajouter::class),
    new Route(['GET', 'POST'], '/modifier/{id}', Modifier::class),
    new Route(['GET', 'POST'], '/supprimer/{id}', Supprimer::class),
    new Route('GET', '/about', About::class),
    new Route('GET', '/contact', Contact::class),
    new Route(['GET', 'POST'], '/inscription', Register::class),
    new Route(['GET', 'POST'], '/connexion', Connect::class),
    new Route(['GET', 'POST'], '/deconnexion', Deconnect::class),
];
