<?php
# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Post;
use App\Entity\PostMeta;
use App\Repository\PostMetaRepository;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    public function __construct()
    {
    }

    public static function getSubscribedEvents()
    {
        return [
//            BeforeCrudActionEvent::class => ['BeforeCrudActionEvent'],
//            BeforeEntityUpdatedEvent::class => ['BeforeEntityUpdatedEvent'],
//            AfterEntityBuiltEvent::class => ['AfterEntityBuiltEvent'],
//            AfterEntityDeletedEvent::class => ['AfterEntityDeletedEvent'],
//            AfterEntityPersistedEvent::class => ['AfterEntityPersistedEvent'],
//           // AfterEntityUpdatedEvent::class => ['AfterEntityUpdatedEvent'],
//            BeforeEntityDeletedEvent::class => ['BeforeEntityDeletedEvent'],
////            BeforeEntityPersistedEvent::class => ['BeforeEntityPersistedEvent'],
//            AfterCrudActionEvent::class => ['AfterCrudActionEvent'],
        ];
    }


    public function BeforeCrudActionEvent(BeforeCrudActionEvent $event){
        dd($event);
        $entity = $event->getEntityInstance();
        if (!($entity instanceof PostMeta)) {
            return;
        }
    }

    public function BeforeEntityUpdatedEvent(BeforeEntityUpdatedEvent $event ){
        dd($event);

        $entity = $event->getEntityInstance();

        if (!($entity instanceof PostMeta)) {
            return;
        }
    }

    public function AfterEntityBuiltEvent(AfterEntityBuiltEvent $event){
        dd('AfterEntityBuiltEvent');
        $entity = $event->getEntityInstance();

    }

    public function AfterEntityDeletedEvent(AfterEntityDeletedEvent $event){
        dd('AfterEntityDeletedEvent');
    }

    public function AfterEntitySavedEvent(AfterEntitySavedEvent $event){
        dd('AfterEntityPersistedEvent');
    }

    public function AfterEntityUpdatedEvent(AfterEntityUpdatedEvent $event){
        dd('AfterEntityUpdatedEvent');
    }

    public function BeforeEntityDeletedEvent(BeforeEntityDeletedEvent $event){
        dd('BeforeEntityDeletedEvent');
    }

    public function BeforeEntityPersistedEvent(BeforeEntityPersistedEvent $event){
        dd('BeforeEntityPersistedEvent');
    }

    public function AfterCrudActionEvent(AfterCrudActionEvent $event){
        dd('AfterCrudActionEvent');
    }


}