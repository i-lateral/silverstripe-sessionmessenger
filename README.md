Silverstripe Session Messanger
==============================

![Travis Support](https://travis-ci.org/i-lateral/silverstripe-sessionmessenger.svg?branch=master)

Session based messaging module for Silverstripe (framework and CMS).

## Author
This module was created by [i-lateral](http://www.i-lateral.com).

## Installation
Install this module either by downloading and adding to:

[silverstripe-root]/sessionmessenger

Then run: http://yoursiteurl.com/dev/build/

Or alternativly add to your projects composer.json

## Usage
Once installed, you send a session message at any time using:

    Controller->setSessionMessage("success", "Message text");

You can then render messages into your template using the varible:

    $SessionMessage

## Adding extra css classes to your message

By default the message displays the classes "message" and "message-{$Type}"

You can also add extra classes to the message (for custom styling) by
using the following config variables:

    SessionMessenger.extra_classes
    SessionMessenger.success_classes
    SessionMessenger.error_classes
    SessionMessenger.info_classes

Extra Classes adds the classes you specify to all versions of the message

Success Classes adds the classes only when the message's type is set to "success"

Error Classes adds the classes only when the message's type is set to "error"

Info Classes adds the classes only when the message's type is set to "info"
