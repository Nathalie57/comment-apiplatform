<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class ValidReportCommentController
{

    /**@var EntityManagerInterface */
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function __invoke(Comment $data)
    {
        $data->setDisplayed(false);
        $this->manager->flush();
    }
}
