<?php

namespace Controller\Admin;

use Entity\Category;
use Controller\ControllerAbstract;

class CategoryController extends ControllerAbstract
{
	public function listAction()
	{
		$categories = $this->app['category.repository']->findAll();

		return $this->render(
			'admin/category/list.html.twig',
			[
				'categories' => $categories
			]
		);
	}

	public function editAction($id = null)
	{
		if(!is_null($id)){
			// on va chercher la catégorie en bdd
			$category = $this->app['category.repository']->find($id);

			if(!$category instanceof Category){
				$this->app->abort(404);
			}
		} else{
			// nouvelle catégorie
			$category = new Category();
		}

		if(!empty($_POST)){
			$category->setName($_POST['name']);

			if(empty($_POST['name'])){
				$errors['name'] = 'Le nom est obligatoire';
			} elseif(strlen($_POST['name']) > 20){
				$errors['name'] = 'Le nom ne doit pas faire plus de 20 caractères';
			}

			if(empty($errors)){
				$this->app['category.repository']->save($category);

				$this->addFlashMessage('La rubrique est enregistrée');
				return $this->redirectRoute('admin_categories');
			} else{
				$message = '<strong>Le formulaire contient des erreurs</strong>';
				$message .= '<br>' . implode('<br>', $errors);
				$this->addFlashMessage($message, 'error');
			}
		}

		return $this->render(
			'admin/category/edit.html.twig',
			[
				'category' => $category
			]
		);
	}

	public function deleteAction($id)
	{
		$category = $this->app['category.repository']->find($id);

		if(!$category instanceof Category){
			$this->app->abort(404);
		}

		$this->app['category.repository']->delete($category);

		$this->addFlashMessage('La rubrique est supprimée');

		return $this->redirectRoute('admin_categories');
	}
}
