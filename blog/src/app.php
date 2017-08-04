<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});

$app->register(
	new DoctrineServiceProvider(),
	[
		'db.options' => [
			'driver' => 'pdo_mysql',
			'host' => 'localhost',
			'dbname' => 'silex_blog',
			'user' => 'root',
			'password' => '',
			'charset' => 'utf8'
		]
	]
);

$app->register(new Silex\Provider\SessionServiceProvider());

/* CONTROLLERS */

//----------------------------- FRONT ---------------------------------//
$app['index.controller'] = function() use ($app){
	return new \Controller\IndexController($app);
};

$app['category.controller'] = function() use ($app){
	return new \Controller\CategoryController($app);
};

$app['article.controller'] = function() use ($app){
	return new \Controller\ArticleController($app);
};

$app['user.controller'] = function() use ($app){
	return new \Controller\UserController($app);
};

//----------------------------- BACK ---------------------------------//
$app['admin.category.controller'] = function() use ($app){
	return new \Controller\Admin\CategoryController($app);
};

$app['admin.article.controller'] = function() use ($app){
	return new \Controller\Admin\ArticleController($app);
};

//-------------------------REPOSITORIES---------------------------------//
$app['category.repository'] = function() use ($app){
	return new \Repository\CategoryRepository($app);
};

$app['article.repository'] = function() use ($app){
	return new \Repository\ArticleRepository($app);
};

$app['user.repository'] = function() use ($app){
	return new \Repository\UserRepository($app);
};

return $app;
