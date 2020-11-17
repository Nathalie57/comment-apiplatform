<?php

namespace App\Events;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Comment;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class CommentDisplayedSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setDisplayedForComment', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setDisplayedForComment(ViewEvent $event)
    {
        $comment = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($comment instanceof Comment && $method==="POST") {
            $comment->setDisplayed(true);
        }
    }
}
