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
	 * @ORM\Column(type="string")
	 * @var
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
