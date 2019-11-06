<?php

/**
 * @file
 * Contains \DrupalProject\composer\ScriptHandler.
 */

namespace DrupalProject\node;

use Composer\Script\Event;
use Symfony\Component\Process\Process;

class ScriptHandler {

  /**
   * Checks if the installed version of Node & NPM is compatible.
   *
   * Node & NPM are installed into the ./bin directory automatically by the
   * mouf/nodejs-installer composer package.
   *
   * This method checks that they are executable and
   */
  public static function checkNodeNpmVersion(Event $event) {
    $event->getIo()->write('node: ' . (new Process('which node && node --version'))->mustRun()->getOutput());
    $event->getIo()->write('npm: ' . (new Process('which npm && npm --version'))->mustRun()->getOutput());
  }
}
