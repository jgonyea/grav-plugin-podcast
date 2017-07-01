<?php
namespace Grav\Plugin;

use Grav\Common\Grav;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Class PodcastPlugin
 * @package Grav\Plugin
 */
class PodcastPlugin extends Plugin
{
  /**
   * @return array
   *
   * The getSubscribedEvents() gives the core a list of events
   *     that the plugin wants to listen to. The key of each
   *     array section is the event that the plugin listens to
   *     and the value (in the form of an array) contains the
   *     callable (or function) as well as the priority. The
   *     higher the number the higher the priority.
   */
  public static function getSubscribedEvents()
  {
    return [
      'onPluginsInitialized' => ['onPluginsInitialized', 0],
      'onGetPageTemplates' => ['onGetPageTemplates', 0],  
      ];
  }

  /**
   * Initialize the plugin
   */
  public function onPluginsInitialized()
  {
    // Don't proceed if we are in the admin plugin
    if ($this->isAdmin()) {
      return;
    }

    // Enable the main event we are interested in
    $this->enable([
      'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
    ]);
  }

  /**
   * Add blueprint directory to page templates.
   */
  public function onGetPageTemplates(Event $event)
  {
    $types = $event->types;
    $locator = Grav::instance()['locator'];
    $types->scanBlueprints($locator->findResource('plugin://' . $this->name . '/blueprints'));
  }
    
  /**
   * Add templates directory to twig lookup paths.
   */
  public function onTwigTemplatePaths()
  {
      $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }
  
}
