<?php

namespace Repository;

use Entity\Category;

class CategoryRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'category';
	}

	public function findAll()
	{
		$dbCategories = $this->db->fetchAll('SELECT * FROM category');

		$categories = [];

		foreach($dbCategories as $dbCategory){
			$category = $this->buildEntity($dbCategory);

			$categories[] = $category;
		}

		return $categories;
	}

	public function find($id)
	{
		$dbCategory = $this->db->fetchAssoc(
			'SELECT * FROM category WHERE id = :id',
			[
				':id' => $id
			]
		);
		if(!empty($dbCategory)){
			return $this->buildEntity($dbCategory);
		}
	}

	public function save(Category $category)
	{
		// les données à enregistrer en bdd
		$data = ['name' => $category->getName()];

		// si la catégorie a un id, on est en update
		// sinon en insert
		$where = !empty($category->getId())
			? ['id' => $category->getId()]
			: null
		;

		// appel à la méthode de RepositoryAbstract pour enregistrer
		$this->persist($data, $where);

		// on set l'id quand on est en insert
		if(empty($category->getId())){
			$category->setId($this->db->lastInsertId());
		}
	}

	public function delete(Category $category)
	{
		$this->db->delete(
			'category',
			['id' => $category->getId()]
		);
	}

	private function buildEntity(array $data)
	{
		$category = new Category();

			$category
				->setId($data['id'])
				->setName($data['name'])
			;

			return $category;
	}
}
