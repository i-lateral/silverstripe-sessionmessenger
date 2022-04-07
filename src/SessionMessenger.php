<?php

namespace ilateral\SilverStripe\SessionMessenger;

use LogicException;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Session;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;

/**
 * Centeral config holder for SessionMessenger
 *
 * @author ilateral http://www.ilateral.co.uk
 * @package SessionMessenger
 */
class SessionMessenger
{
    use Injectable, Configurable;

    const TYPE_SUCCESS = 'success';

    const TYPE_INFO = 'info';

    const TYPE_ERROR = 'error';

    const DEFAULT_NAME = 'Message';

    /**
     * Extra css classes that can will be loaded to all messages
     *
     * @var string
     * @config
     */
    private static $extra_classes;

    /**
     * Extra css classes that can will be loaded to success messages
     *
     * @var string
     * @config
     */
    private static $success_classes;

    /**
     * Extra css classes that can will be loaded to error messages
     *
     * @var string
     * @config
     */
    private static $error_classes;

    /**
     * Extra css classes that can will be loaded to info messages
     *
     * @var string
     * @config
     */
    private static $info_classes;

    /**
     * The currently active controller to save the message against
     *
     * @var Controller
     */
    protected $curr_controller;

    public function __construct(Controller $controller)
    {
        $this->setCurrController($controller);
    }

    protected function getSession(): Session
    {
        return $this
            ->getCurrController()
            ->getRequest()
            ->getSession();
    }

    /**
     * Sanitise a model class' name for inclusion in a link
     *
     * @param string $class
     * @return string
     */
    protected function sanitiseClassName($class)
    {
        return str_replace('\\', '-', $class);
    }

    protected function getSessionIdent(string $name)
    {
        $classname = $this->sanitiseClassName(get_class($this->getCurrController()));
        return $classname . '.' . $name;
    }

    /**
     * Get a session message for the current controller using the provided name
     *
     * @return String
     */
    public function getSessionMessage(string $name = self::DEFAULT_NAME): string
    {
        $session = $this->getSession();
        $session_ident = $this->getSessionIdent($name);
        $message = $session->get($session_ident);

        if (!empty($message) && is_array($message)) {
            $session->clear($session_ident);
            $array = ArrayData::create($message);
            return $array->renderWith(static::class);
        }

        return "";
    }
    
    /**
     * Set a flash message that will be rendered via a template
     *
     * You can overwrite message classes for the following message types:
     *
     * - success: Rendered green
     * - error: Rendered red
     * - info: Rendered blue
     *
     * This method also collects extra classes and any classes that
     * apply to the type of message set and send them to the template
     *
     * @param string $type Type of message
     * @param string $message message to send
     * @return self
     */
    public function setSessionMessage(
        string $type,
        string $message,
        string $name = self::DEFAULT_NAME
    ): self {
        // Ensure the message is the correct type
        $valid_types = [
            self::TYPE_ERROR,
            self::TYPE_INFO,
            self::TYPE_SUCCESS
        ];

        if (!in_array($type, $valid_types)) {
            throw new LogicException("Invalid message type '{$type}' provided");
        }

        $session = $this->getSession();
        $session_ident = $this->getSessionIdent($name);
        $type_classes = "";
        $extra_classes = Config::inst()
            ->get(static::class, 'extra_classes');

        if ($type == static::TYPE_SUCCESS) {
            $type_classes = Config::inst()
                ->get(static::class, 'success_classes');
        } elseif ($type == static::TYPE_ERROR) {
            $type_classes = Config::inst()
                ->get(static::class, 'error_classes');
        } elseif ($type == static::TYPE_INFO) {
            $type_classes = Config::inst()
                ->get(static::class, 'info_classes');
        }

        if ($extra_classes && $type_classes) {
            $classes = $extra_classes . " " . $type_classes;
        } elseif ($extra_classes && !$type_classes) {
            $classes = $extra_classes;
        } elseif (!$extra_classes && $type_classes) {
            $classes = $type_classes;
        } else {
            $classes = "";
        }

        $session->set(
            $session_ident,
            [
                "Type" => $type,
                "ExtraClasses" => $classes,
                "Message" => $message
            ]
        );

        return $this;
    }

    /**
     * Get the currently active controller
     *
     * @return  Controller
     */ 
    public function getCurrController()
    {
        return $this->curr_controller;
    }

    /**
     * @param Controller $curr_controller
     *
     * @return self
     */ 
    public function setCurrController(Controller $controller)
    {
        $this->curr_controller = $controller;
        return $this;
    }
}