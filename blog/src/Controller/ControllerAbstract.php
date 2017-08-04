<?php

namespace Controller;

use Silex\Application;

abstract class ControllerAbstract
{
	/*
	@var Application
 	*/
	protected $app;
	/*
	@var \Twig_Environment
 	*/
	protected $twig;
	/*
	@param Application $app
 	*/
 	protected $session;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->twig = $app['twig'];
		$this->session = $app['session'];
	}

	public function render($view, array $parameters = [])
	{
		return $this->twig->render($view, $parameters);
	}

	public function redirectRoute($routeName, array $parameters = [])
	{
		return $this->app->redirect(
			$this->app['url_generator']->generate($routeName, $parameters)
		);
	}

	public function addFlashMessage($message, $type = 'success')
	{
		$this->session->getFlashBag()->add($type, $message);
	}
}