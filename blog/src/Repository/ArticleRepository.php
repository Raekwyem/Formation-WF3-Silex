<?php

namespace Repository;

use Entity\Article;
use Entity\Category;

class ArticleRepository extends RepositoryAbstract
{
	protected function getTable()
	{
		return 'article';
	}

	public function findAll()
	{
		$query = 'SELECT * FROM article a' . ' JOIN category c ON a.category_id = c.id';
		
		$dbArticles = $this->db->fetchAll($query);

		$articles = [];

		foreach($dbArticles as $dbArticle){
			$article = $this->buildEntity($dbArticle);

			$articles[] = $article;
		}

		return $articles;
	}

	public function find($id)
	{
		$query = 'SELECT a.*, c.name FROM article a' 
				. ' JOIN category c ON a.category_id = c.id'
				. ' WHERE id = :id'
		;
		$dbArticle = $this->db->fetchAssoc(
			$query,
			[':id' => $id]
		);

		if(!empty($dbArticle)){
			return $this->buildEntity($dbArticle);
		}
	}

	public function save(Article $article)
	{
		// les données à enregistrer en bdd
		$data = [
					'title' => $article->getTitle(),
					'header' => $article->getHeader(),
					'content' => $article->getContent(),
					'category_id' => $article->getCategoryId()
				];

		// si la catégorie a un id, on est en update
		// sinon en insert
		$where = !empty($article->getId())
			? ['id' => $article->getId()]
			: null
		;

		// appel à la méthode de RepositoryAbstract pour enregistrer
		$this->persist($data, $where);

		// on set l'id quand on est en insert
		if(empty($article->getId())){
			$article->setId($this->db->lastInsertId());
		}
	}

	public function delete(Article $article)
	{
		$this->db->delete(
			'article',
			['id' => $article->getId()]
		);
	}

	private function buildEntity(array $data)
	{
		$category = new Category();

		$category
			->setId($data['category_id'])
			->setName($data['name'])
		;

		$article = new Article();

			$article
				->setId($data['id'])
				->setTitle($data['title'])
				->setHeader($data['header'])
				->setContent($data['content'])
				->setCategory($category)
			;

			return $article;
	}
}
