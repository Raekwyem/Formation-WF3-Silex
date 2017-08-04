<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/******************** FRONT *****************************/

$app
    ->get('/', 'index.controller:indexAction')
    ->bind('homepage')
;

$app
    ->get('/rubrique/liste', 'category.controller:listAction')
    ->bind('category_list')
;

$app
    ->get('/item/liste', 'article.controller:listAction')
    ->bind('article_list')
;


$app
    ->match('/utilisateur/inscription', 'user.controller:registerAction')
    ->bind('user_register')
;
/******************** BACK ******************************/

// crée un groupe de routes
$admin = $app['controllers_factory'];

// toutes les routes définies par $admin
// auront une URL commençant par /admin sans avoir à l'ajouter dans chaque route
$app->mount('/admin', $admin);

// l'URL de cette route est /admin/rubriques
$admin
    ->get('/rubriques', 'admin.category.controller:listAction')
    ->bind('admin_categories')
;

// la route matche à la fois /rubrique/edition et /rubrique/edition/1
$admin
    ->match('/rubrique/edition/{id}', 'admin.category.controller:editAction')
    ->value('id', null) // valeur par défaut pour l'id
    ->bind('admin_category_edit')
;

$admin
    ->get('/rubrique/suppression/{id}', 'admin.category.controller:deleteAction')
    ->value('id', '\d+')
    ->bind('admin_category_delete')
;

// URL /admin/items
$admin
    ->get('/items', 'admin.article.controller:listAction')
    ->bind('admin_articles')
;

// la route matche à la fois /item/edition et /item/edition/1
$admin
    ->match('/item/edition/{id}', 'admin.article.controller:editAction')
    ->value('id', null) // valeur par défaut pour l'id
    ->bind('admin_article_edit')
;

$admin
    ->get('/item/suppression/{id}', 'admin.article.controller:deleteAction')
    ->value('id', '\d+')
    ->bind('admin_article_delete')
;
/*
Créer la partie admin pour les articles:
- créer le contrôleur Admin\ArticleController qui hérite de ControllerAbstract
- le définir en service dans src/app.php
- y ajouter la méthode listeAction() qui va rendre la vue admin/article/list.html.twig
- créer la vue
- créer la route qui pointe sur l'action de controleur
- ajouter un lien vers cette route dans la navbar admin
- créer l'entity Article et le repository ArticleRepository qui hérite de RepositoryAbstract
- déclarer le repository en service dans src/app.php
- remplir la méthode listAction() en utilisant ArticleRepository
- faire l'affichage en tableau HTML dans la vue
 */

$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
