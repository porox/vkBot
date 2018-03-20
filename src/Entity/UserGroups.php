<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserGroupsRepository")
 */
class UserGroups
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
	/**
	 *@ORM\Column(type="integer")
	 */
    private $groupId;
    
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userGroups")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
    private $userId;
	
	/**
	 * @ORM\ManyToOne(targetEntity="App\Entity\Tags", inversedBy="userGroups")
	 * @ORM\JoinColumn(referencedColumnName="id")
	 */
	private $tag;
	
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
	public function getGroupId()
	{
		return $this->groupId;
	}
	
	/**
	 * @param mixed $groupId
	 */
	public function setGroupId($groupId)
	{
		$this->groupId = $groupId;
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
		return (string) $this->getGroupId();
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
	
	
}
