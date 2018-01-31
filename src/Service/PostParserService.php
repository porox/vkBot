<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PostParserService
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    
    private $vkInst;
    /**
     * As2Log constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, VkService $vk)
    {
        $this->em = $entityManager;
        $this->vkInst = $vk;
    }
    
    public function parcePost($groupId)
    {
        $this->vkInst->getVkInstanse();
     return $this->vkInst->getToken();
    }
    
    public function postSave($post)
    {
    
    }
}