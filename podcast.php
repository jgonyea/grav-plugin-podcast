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
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 1],
            'onTwigSiteVariables' => ['onTwigSiteVariables', 0],
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

    public function onTwigSiteVariables()
    {
     $this->grav['assets']
            ->addCss('plugin://podcast/assets/css/podcast.css');
    }
    
    /**
     * Set metadata in header for podcast if audio file is attached.
     */
    public function onPageInitialized($event)
    {
        $page = $this->grav['page'];
        $header = $page->header();

        // Only working with podcast episodes pages
        if($page->name() == 'podcast-episode.md'){
            // Only process podcast pages with audio attached
            if (!empty($header->podcast['audio'])){
                //extracting the audio array so we can modify it later
                $audio = array_shift($header->podcast['audio']);
                
                // Checking for uploaded audio file duration
                if (!isset($audio['duration']))
                {
                    $file = $page->file();
                    $path = $audio['path'];

                    $duration = $this->retreiveAudioDuration($path);

                    //adding duration to our extracted array and then putting our array back into the header object the way we found it
                    $audio["duration"] = $duration;
                    $header->podcast['audio'][$path] = $audio;

                    $page->save();
                    $this->grav['log']->info("Added duration to ". $page->title());
                }
            }

            // Adding this in here as a secondary if statement in case someone wants to use both, CDN file and local mp3 as a redundancy.
            // They can both be stored in the header

            // Checking for external file audio duration
            if (!empty($header->podcast['audio_url'])){
                if(!isset($header->podcast['audio_duration'])){
                    $file = $page->file();

                    // Download the remote file temporarily 
                    $path = $this->getRemoteAudio($header->podcast['audio_url']);

                    if($path){

                        $duration = $this->retreiveAudioDuration($path);
                        $length = $this->retreiveAudioLength($path);
                        
                        //adding duration to our extracted array and then putting our array back into the header object the way we found it
                        $header->podcast["duration"] = $duration;
                        $header->podcast["length"] = $length;

                        $page->save();
                        $this->grav['log']->info("Added duration and length to ". $page->title());

                        // Delete temporary remote file
                        unlink($path);
                    }
                    
                }
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
