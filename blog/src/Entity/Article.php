<?php

namespace Entity;

class Article
{
	private $id;

	private $title;

	private $header;

	private $content;
	
	private $category;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     *
     * @return self
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     *
     * @return self
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /*
    @return int not null
     */
    public function getCategoryId()
    {
    	if(!is_null($this->category)){
    		return $this->category->getId();
    	}
    }
    /*
    @return string
     */
    public function getCategoryName()
    {
    	if(!is_null($this->category)){
    		return $this->category->getName();
    	}
    	return '';
    }
    
}
