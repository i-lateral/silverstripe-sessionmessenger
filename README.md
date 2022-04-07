Silverstripe Session Messanger
==============================

![Travis Support](https://travis-ci.org/i-lateral/silverstripe-sessionmessenger.svg?branch=master)

A simple module that allows adding and rendering of Session based messages to a SilverStripe Controller.

## Author

This module was created by [i-lateral](http://www.ilateral.co.uk).

## Installation

Install this module via composer:

    composer require i-lateral/silverstripe-sessionmessenger

## Usage

Once installed, you can attach a message to the current `Controller` at any time by
using:

    $controller->setSessionMessage("success", "Message text");

This message is then stored against that controller for later use and can be rendered
into a template by using the variable:

    $SessionMessage

**NOTE** Once a message has been rendered, it is wiped from the session.

### Advanced usage via SessionMessenger

In v2, `SessionMessenger` is responsible for handling and rendering messages
directly. You can manaully invoke `SessionMessenger` and add a message to any controller
by using the following

    $messenger = SessionMessenger::create(MyController::class);
    $messenger->setMessage(SessionMessenger::TYPE_INFO, "My message");

You can then retrieve the message in `MyController`'s template using `$SessionMessage`
(as above).

### Multiple messages on one controller

As of v2, you can assign more than one message to a `Controller` by using names.
You can have as many names as you like, each name is stored in a session seperatly
for that controller. For example:

    // DEFAULTS TO `Message`
    $messenger = SessionMessenger::create(MyController::class);
    $messenger->setMessage(SessionMessenger::TYPE_INFO, "My default message");


    // ADDS A SECOND MESSAGE CALLED "Alt"
    $messenger = SessionMessenger::create(MyController::class);
    $messenger->setMessage(SessionMessenger::TYPE_INFO, "Alternate message", "Alt);

The default message can be retrieved as above, you can retrieve the alternate message from the
template via:

    $SessionMessage('Alt)

## Adding extra css classes to your message

By default the message displays the classes "message" and "message-{$Type}"

You can also add extra classes to the message (for custom styling) by
using the following config variables:

    // Added to all messages
    SessionMessenger.extra_classes

    // Added to just success messages
    SessionMessenger.success_classes

    // Added to only error messages
    SessionMessenger.error_classes

    // Added to only info messages
    SessionMessenger.info_classes

Extra Classes adds the classes you specify to all versions of the message

Success Classes adds the classes only when the message's type is set to "success"

Error Classes adds the classes only when the message's type is set to "error"

Info Classes adds the classes only when the message's type is set to "info"
