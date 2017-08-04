<?php

namespace Controller;

use Silex\Application;

class DemoController
{
	public function helloWorldAction(Application $app)
	{
		return $app['twig']->render('helloworld.html.twig');
	}

	/*
		le paramètre $name correspond à ce que contient {name} dans la route

		@param Application $app L'instance de Silex\Application
		@param string $name La variable venant de l'url	
	 */	
	 
	public function helloAction(Application $app, $name)
	{
		return $app['twig']->render(
			'hello.html.twig',
			[
				'name' => $name
			]
			);
	}
}