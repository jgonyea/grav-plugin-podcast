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
                'onAdminSave' => ['onAdminSave', 0],
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

    public function onAdminSave($event)
    {
        $obj = $event['object'];
        // Process only podcast episodes with podcast audio filled out.
        if (!($obj instanceof Page) || $obj->name() != 'podcast-episode.md') {
            return;
        }

        $header = $obj->header();

        
        
        if (!isset($header->podcast['audio']['local'])) {
            // Use local file for meta calculations, if present.
            $header->testJD['internal'] = true ;// Need to create a temporary array to perform the array_shift on.
            $temp = $header->podcast['audio']['local'];
            $temp = array_shift($temp);
            
            $audio_meta['guid'] = $temp['path'];
            $audio_meta['duration'] = $this->retreiveAudioDuration($audio_meta['guid']);
            $audio_meta['enclosure_length'] = filesize($audio_meta['guid']);
        } elseif (isset($header->podcast['audio']['remote'])) {
            // Use external URL field if no local file is present.
            $handle = fopen($header->podcast['audio']['remote']);
            
            // Download fle from external url to temporary location.
        } else {
            // todo: check if I need to remove the meta field.
        }

        

        $fh = fopen('k:\Documents\Projects\public_html\grav-pluginDev\logs\debug.log', 'w');
        fwrite($fh, print_r($header, true));
        fwrite($fh, print_r($this->config()['remote'], true));
        fclose($fh);
        
        // Determine if remote file is configured.
        if (isset($header->podcast['remoteURL'])) {
            
        }
        
        // Prepare $obj to return new header data.
        if (isset($audio_meta)) {
            $header->podcast['audio']['meta'] = $audio_meta;
        }
        $obj->header($header);
        
        return $obj;
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

    public static function getRemoteAudio($url)
    {
        // Making sure the url is not 404.
        if ($remote_file = fopen($url, 'rb')) {
            $local_file = tempnam('/tmp', 'podcast');
            $handle = fopen($local_file, "w");
            $contents = stream_get_contents($remote_file);
 
            fwrite($handle, $contents);
            fclose($remote_file);
            fclose($handle);
 
            return $local_file;
        }
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
