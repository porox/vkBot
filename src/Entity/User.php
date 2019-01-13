<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
	private $token;
	/**
	 * @ORM\Column(type="integer")
	 */
	private $vkUserId;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\UserGroups", mappedBy="userId")
	 */
	private $userGroups;
	/**
	 * @ORM\OneToMany(targetEntity="App\Entity\WatchingGroups", mappedBy="userId")
	 */
	private $watchingGroups;
	/**
	 * @return integer
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @param integer $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}
	
	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}
	
	/**
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}
	
	/**
	 * @return integer
	 */
	public function getVkUserId()
	{
		return $this->vkUserId;
	}
	
	/**
	 * @param integer $vkUserId
	 */
	public function setVkUserId($vkUserId)
	{
		$this->vkUserId = $vkUserId;
	}
	
	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string) $this->getVkUserId();
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
	
	
}
