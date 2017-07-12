<?php
namespace Grav\Plugin;

use Grav\Common\Grav;
use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;
use RocketTheme\Toolbox\File\File;
use Symfony\Component\Yaml\Yaml;
use Grav\Plugin\GetID3Plugin;

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
     *         that the plugin wants to listen to. The key of each
     *         array section is the event that the plugin listens to
     *         and the value (in the form of an array) contains the
     *         callable (or function) as well as the priority. The
     *         higher the number the higher the priority.
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
    public function onPageInitialized($event)
    {
        $page = $this->grav['page'];
        $header = $page->header();
        // Only process podcast pages with audio attached.
        if (!empty($header->podcast['audio']) && $page->name() == 'podcast-episode.md') {
            // Find array key for podcast audio.
            $key = array_keys($header->podcast['audio']);

            if (!isset($header->podcast['audio'][$key[0]]['duration'])) {
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
     *     Path to audio file.
     * @return string
     *     Audio file duration.
     */
    public static function retreiveAudioDuration($file)
    {
        $id3 = GetID3Plugin::analyzeFile($file);
        return ($id3['playtime_string']);
    }

    /**
     * Finds list of available iTunes categories.
     *
     * @return array
     *     Array of options for select list.
     */
    public static function getCategoryOptions()
    {
        $options = array();
        $data_file_path = __DIR__ . DS . 'data' . DS . 'iTunesCategories.yaml';
        $file = File::instance($data_file_path);
        $data = Yaml::parse($file->content());
        $keys = array_keys($data);

        foreach ($keys as $option) {
            $options[$option] = $option;
        }

        return $options;
    }

    /**
     * Finds list of available iTunes subcategories.
     *
     * @return array
     *     Array of options for select list.
     */
    public static function getSubCategoryOptions()
    {
        $options = array();
        $data_file_path = __DIR__ . DS . 'data' . DS . 'iTunesCategories.yaml';
        $file = File::instance($data_file_path);
        $data = Yaml::parse($file->content());
        foreach ($data as $key => $category) {
            if ($category != null) {
                foreach ($category as $sub) {
                    $options[$sub] = $sub;
                }
            } else {
                $options[$key] = $key;
            }
        }

        return $options;
    }

    /**
     * Finds list of available language options.
     *
     * @return array
     *     Array of options for select list.
     */
    public static function getLanguageOptions()
    {
        $options = array();
        $data_file_path = __DIR__ . DS . 'data' . DS . 'languages.yaml';
        $file = File::instance($data_file_path);
        $languages = Yaml::parse($file->content());
        foreach ($languages as $language) {
            $options[$language['ISO 639 Code']] = $language['English Name'] . " (" . $language['ISO 639 Code'] . ")";
        }
        return $options;
    }
}
