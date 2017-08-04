<?php

namespace Controller\Admin;

use Entity\Article;
use Entity\Category;
use Controller\ControllerAbstract;

class ArticleController extends ControllerAbstract
{
	public function listAction()
	{
		$articles = $this->app['article.repository']->findAll();

		return $this->render(
			'admin/article/list.html.twig',
			[
				'articles' => $articles
			]
		);
	}

	public function editAction($id = null)
	{
		if(!is_null($id)){
			// on va chercher la catégorie en bdd
			$article = $this->app['article.repository']->find($id);

			if(!$article instanceof Article){
				$this->app->abort(404);
			}
		} else{
			// nouvelle catégorie
			$article = new Article();
			$article->setCategory(new Category());
		}

		// on a besoin de la liste des rubriques pour construire le select dans le formulaire
		$categories = $this->app['category.repository']->findAll();
		$errors = [];

		if(!empty($_POST)){
			$article
			->setTitle($_POST['title'])
			->setHeader($_POST['header'])
			->setContent($_POST['content']);

			$article->getCategory()->setId($_POST['category']);

			if(empty($_POST['title'])){
				$errors['title'] = 'Le titre est obligatoire';
			} elseif(strlen($_POST['title']) > 100){
				$errors['title'] = 'Le titre ne doit pas faire plus de 100 caractères';
			}

			if(empty($_POST['category'])){
				$errors['category'] = 'La rubrique est obligatoire';
			}

			if(empty($errors)){
				$this->app['article.repository']->save($article);

				$this->addFlashMessage('L\'article est enregistré');
				return $this->redirectRoute('admin_articles');
			} else{
				$message = '<strong>Le formulaire contient des erreurs</strong>';
				$message .= '<br>' . implode('<br>', $errors);
				$this->addFlashMessage($message, 'error');
			}
		}

		return $this->render(
			'admin/article/edit.html.twig',
			[
				'article' => $article,
				'categories' => $categories
			]
		);
	}

	public function deleteAction($id)
	{
		$article = $this->app['article.repository']->find($id);

		if(!$article instanceof Article){
			$this->app->abort(404);
		}

		$this->app['article.repository']->delete($article);

		$this->addFlashMessage('L\'article est supprimé');

		return $this->redirectRoute('admin_articles');
	}
}