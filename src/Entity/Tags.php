<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TagsRepository")
 */
class Tags
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	private $name;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\WatchingGroups", mappedBy="tag")
	 */
	private $watchingGroups;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\UserGroups", mappedBy="tag")
	 */
	private $userGroups;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\Post", mappedBy="tag")
	 */
	private $posts;
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}
	
	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * @return mixed
	 */
	public function getWatchingGroups()
	{
		return $this->watchingGroups;
	}
	
	/**
	 * @param mixed $watchingGroups
	 */
	public function setWatchingGroups($watchingGroups)
	{
		$this->watchingGroups = $watchingGroups;
	}
	
	/**
	 * @return mixed
	 */
	public function getUserGroups()
	{
		return $this->userGroups;
	}
	
	/**
	 * @param mixed $userGroups
	 */
	public function setUserGroups($userGroups)
	{
		$this->userGroups = $userGroups;
	}
	
	/**
	 * @return mixed
	 */
	public function getPosts()
	{
		return $this->posts;
	}
	
	/**
	 * @param mixed $posts
	 */
	public function setPosts($posts)
	{
		$this->posts = $posts;
	}
	
	public function __toString()
	{
		return $this->getName();
	}
	
	
	// add your own fields
}
