Silverstripe Session Messanger
==============================

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

    Controller->setSessionMessage("success","Message text");

You can then render messages into your template using the varible:

    $SessionMessage
