<?php
/**
 * Add additional methods to controller
 *
 * @author morven
 */
class SessionMessengerController extends Extension {

    /**
     * Set a flash message that will appear in your templates
     *
     * The site styling currently accepts the following message types
     *
     * - success: Rendered green
     * - error: Rendered red
     * - info: Rendered blue
     *
     * @param $type Type of message
     * @param $message message to send
     * @return Controller
     */
    public function setSessionMessage($type, $message) {
        Session::set('Site.Message', array(
            'Type' => $type,
            'Message' => $message
        ));

        return $this;
    }

    /**
     * Get a flash message that is rendered into a template
     *
     * @return String
     */
    public function getSessionMessage() {
        if($message = Session::get('Site.Message')){
            Session::clear('Site.Message');
            $array = new ArrayData($message);
            return $array->renderWith('SessionMessage');
        }
    }
}
