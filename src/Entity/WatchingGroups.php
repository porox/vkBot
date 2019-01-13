<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WatchingGroupsRepository")
 */
class WatchingGroups
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    
	/**
	 * @ORM\Column(type="string")
	 * @var
	 */
    private $shortName;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Tags", inversedBy="watchingGroups")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
    private $tag;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="watchingGroups")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
	private $userId;
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
	public function getShortName()
	{
		return $this->shortName;
	}
	
	/**
	 * @param mixed $shortName
	 */
	public function setShortName($shortName)
	{
		$this->shortName = $shortName;
	}
	
	/**
	 * @return Tags
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
	
	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}
	
	/**
	 * @param mixed $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}
	
	public function __toString()
	{
		return $this->getShortName();
	}
	
	
}
