<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=32)
     */
	private $hash;
    
    /**
     *
     * @ORM\Column(type="text")
     */
    private $postData;
    
	/**
	 * @ORM\Column(type="boolean", nullable=true)
	 */
    private $published;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Tags", inversedBy="posts")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
	private $tag;
	
    /**
     * @return mixed
     */
    public function getPostData()
    {
        return $this->postData;
    }
    
    /**
     * @param mixed $postData
     */
    public function setPostData($postData)
    {
        $this->postData = $postData;
    }
    
    /**
     * @return mixed
     */
    public function getHash()
    {
        return $this->hash;
    }
    
    /**
     * @param mixed $hash
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
    }
	
	/**
	 * @return mixed
	 */
	public function getPublished()
	{
		return $this->published;
	}
	
	/**
	 * @param mixed $published
	 */
	public function setPublished($published)
	{
		$this->published = $published;
	}
	
	/**
	 * @return mixed
	 */
	public function getTag()
	{
		return $this->tag;
	}
	
	/**
	 * @param mixed $tag
	 */
	public function setTag($tag)
	{
		$this->tag = $tag;
	}
	
	public function __toString()
	{
		return $this->getHash();
	}
	
	
}
