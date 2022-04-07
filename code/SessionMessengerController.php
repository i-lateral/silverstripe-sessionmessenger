<?php

namespace ilateral\SilverStripe\SessionMessenger;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Controller;

/**
 * Add additional methods to controller
 *
 * @author ilateral http://www.ilateral.co.uk
 * @package SessionMessenger
 */
class SessionMessengerController extends Extension
{
    public function getSessionMessager()
    {
        /** @var Controller */
        $owner = $this->getOwner();
        $messenger = SessionMessenger::create($owner);
        return $messenger;
    }

    /**
     * Proxy to new session messenger (to retain backwards compatability)
     *
     * @return self
     */
    public function setSessionMessage($type, $message)
    {
        /** @var SessionMessenger */
        $messenger = $this->getOwner()->getSessionMessager();
        $messenger->setSessionMessage($type, $message);

        return $this;
    }

    /**
     * Get a flash message that is rendered into a template
     *
     * @return String
     */
    public function getSessionMessage($name = SessionMessenger::DEFAULT_NAME)
    {
        /** @var SessionMessenger */
        $messenger = $this->getOwner()->getSessionMessager();
        return $messenger->getSessionMessage($name);
    }
}
