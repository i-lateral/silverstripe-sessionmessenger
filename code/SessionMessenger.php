<?php

/**
 * Centeral config holder for SessionMessenger
 *
 * @author ilateral http://www.ilateral.co.uk
 * @package SessionMessenger
 */
class SessionMessenger extends SS_Object
{
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
}