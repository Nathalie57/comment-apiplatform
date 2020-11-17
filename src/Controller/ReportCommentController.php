<?php

namespace App\Controller;

use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class ReportCommentController
{

    /**@var EntityManagerInterface */
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    
    public function __invoke(Comment $data)
    {
        $data->setReported(true);
        $this->manager->flush();
    }
}
