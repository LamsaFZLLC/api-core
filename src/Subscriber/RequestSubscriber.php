<?php
/**
 * api-core - RequestSubscriber.php
 *
 * Date: 7/9/18
 * Time: 12:46 PM
 * @author    Abdelhameed Alasbahi <abdkwa92@gmail.com>
 * @copyright Copyright (c) 2018 LamsaWorld (http://www.lamsaworld.com/)
 */

namespace Lamsa\ApiCore\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class RequestSubscriber
 * @package Lamsa\ApiCore\Subscriber
 */
class RequestSubscriber implements EventSubscriberInterface
{
    /**
     * @param ResponseEvent $event
     */
    public function onKernelRequest(ResponseEvent $event)
    {
        $request = $event->getRequest();
        $locale  = $request->headers->get('locale');
        $request->setLocale($locale);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
