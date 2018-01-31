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
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    
    /**
     *
     * @ORM\Column(type="string", length=150 )
     */
    private $groupId;
    
    /**
     *
     * @ORM\Column(type="text")
     */
    private $postData;
    
    /**
     *
     * @ORM\Column(type="string", length=32)
     */
    private $hash;
    
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
    
    
}
