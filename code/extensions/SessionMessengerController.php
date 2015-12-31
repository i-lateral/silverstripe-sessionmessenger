<?php

/**
 * Add additional methods to controller
 *
 * @author ilateral http://www.ilateral.co.uk
 * @package SessionMessenger
 */
class SessionMessengerController extends Extension
{

    /**
     * Set a flash message that will appear in your templates
     *
     * The site styling currently accepts the following message types
     *
     * - success: Rendered green
     * - error: Rendered red
     * - info: Rendered blue
     * 
     * This method also collects extra classes and any classes that
     * apply to the type of message set and send them to the template
     *
     * @param $type Type of message
     * @param $message message to send
     * @return Controller
     */
    public function setSessionMessage($type, $message)
    {
        $extra_classes = SessionMessenger::config()->extra_classes;
        
        if ($type == "success" || $type == "good") {
            $type_classes = SessionMessenger::config()->success_classes;
        } elseif ($type == "error" || $type == "bad") {
            $type_classes = SessionMessenger::config()->error_classes;
        } elseif ($type == "info") {
            $type_classes = SessionMessenger::config()->info_classes;
        } else {
            $type_classes = "";
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
        
        Session::set('Site.Message', array(
            "Type" => $type,
            "ExtraClasses" => $classes,
            "Message" => $message
        ));

        return $this;
    }

    /**
     * Get a flash message that is rendered into a template
     *
     * @return String
     */
    public function getSessionMessage()
    {
        if ($message = Session::get('Site.Message')) {
            Session::clear('Site.Message');
            $array = new ArrayData($message);
            return $array->renderWith('SessionMessage');
        }
    }
}
