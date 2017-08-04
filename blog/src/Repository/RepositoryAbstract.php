<?php

namespace Repository;

use Silex\Application;

abstract class RepositoryAbstract
{
	protected $db;

	public function __construct(Application $app)
	{
		$this->db = $app['db'];
	}

	public function persist(array $data, array $where = null)
	{
		if(is_null($where)){
			// insertion
			$this->db->insert($this->getTable(), $data);
		} else{
			// modification
			$this->db->update($this->getTable(), $data, $where);
		}
	}

	/*
	oblige les classes filles à définir cette méthode
	qui renvoit le nom de la table à laquelle elles font référence
	 */
	abstract protected function getTable();
}
