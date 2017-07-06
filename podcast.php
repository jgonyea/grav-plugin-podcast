<?php
namespace Grav\Plugin;

use Grav\Common\Grav;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use RocketTheme\Toolbox\File\File;

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
      ];
  }

  /**
   * Initialize the plugin
   */
  public function onPluginsInitialized()
  {
    // Don't proceed if we are in the admin plugin
    if ($this->isAdmin()) {
      $this->enable([
        'onGetPageTemplates' => ['onGetPageTemplates', 0],  
      ]);
      return;
    }

    // Enable the main event we are interested in
    $this->enable([      
      'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
      'onPageInitialized' => ['onPageInitialized', 0],
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
    $types->scanTemplates($locator->findResource('plugin://' . $this->name . '/templates'));
  }

  /**
   * Add templates directory to twig lookup paths.
   */
  public function onTwigTemplatePaths()
  {
      $this->grav['twig']->twig_paths[] = __DIR__ . '/templates';
  }

  /**
   * Set metadata in header for podcast if audio file is attached.
   */
  public function onPageInitialized($event){
    $page = $this->grav['page'];
    $header = $page->header();
    // Only process podcast pages with audio attached.
    if( isset($header->podcast['audio']) && $page->name() == 'podcast-episode.md') {

      // Find array key for podcast audio.
      $key = array_keys($header->podcast['audio']);

      if(!isset($header->podcast['audio'][$key[0]]['duration'])){
        $audio = $header->podcast['audio'];
        $dir = $page->path();
        $fullFileName = $dir. DS . 'podcast-episode.md';
        $file = File::instance($fullFileName);

        $duration = $this->retreiveAudioDuration($key[0]);
        $raw = $file->raw();
        $orig = "type: audio/mpeg\n";
        $replace = $orig . "            duration: $duration\n";
        $raw = str_replace($orig, $replace, $raw);

        $file->save($raw);
        $this->grav['log']->info("Added duration to ");

      }
    }
  }

  /**
   * Retrieve audio metadata duration.
   *
   * @param string $file
   *   Path to audio file.
   * @return string
   *   Audio file duration.
   */
  public static function retreiveAudioDuration($file) {
    //todo: change fixed value to calcuated one.
    return "2:30";
  }


  /**
   * Generate GUID for podcast entry.
   */
  public static function generateGuid($length = 20, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ') {
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }
    return $str;
  }
}