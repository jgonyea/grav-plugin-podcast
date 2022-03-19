# v3.0.7
## 03/19/2021

1. [](#new)

2. [](#improved)
    * Some minor PSR2 fixes.
    * Updated a few hardcoded paths to use Grav's locator instead.
    * Remote files are now downloaded to Grav's tmp folder instead of the system's /tmp folder.

3. [](#bugfix)
    * Bandaid fixed feed.rss.twig override clobbering regular rss feeds.

# v3.0.6
## 03/16/2021

1. [](#new)

2. [](#improved)
    * French and Portugese languages added.

3. [](#bugfix)
    * Fixed a harcoded text string.

# v3.0.5
## 02/05/2021

1. [](#new)

2. [](#improved)
    * Removed admin plugin as dependency.

3. [](#bugfix)
    * Fixed an h3 closing tag

# v3.0.4
## 10/04/2021

1. [](#new)

2. [](#improved)
    * Issue #44 Series and Episode author information is prepopulated based on info in the currently signed in Grav user.

3. [](#bugfix)


# v3.0.3
## 10/02/2021

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Fix for Series and Channel pages rss feeds.
    * Fix for incorrect publish date time calculations.

# v3.0.2
## 10/01/2021

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Invalid "Explicit content" flag validation check removed

# v3.0.1
## 01/25/2021

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Series images now loading properly
    * Subtitle field label now say "Subtitle" vs "Title" in languages.yaml
    * Small fix for mini list of episodes if no parent series (e.g. parent page is a channel page)
# v3.0.0
## 01/25/2021

1. [](#new)
    * Grav v1.7 support.  Grav v1.6 is no longer supported.
    * Individual file field uploads are no longer supported in Grav v1.7.  Instead, use the general media upoader and then the filepicker fields to select the appropriate audio/ image files.
2. [](#improved)
    * Better multi-language support while creating new content via the admin plugin.
    * Twig theming is improved considerably.
    * Updated README to indicate that admin is now required.  If this becomes a problem, I can revisit the requirements.
    * Removed `max_upload` audio file size value from plugin configuration.
3. [](#bugfix)
    * Episode subtitle in the rss feed now points to the correct field in the admin form.  You may need to re-save this data on v2 Podcast episodes to update them to the v3 Podcast format.

# v2.1.10
## 01/21/2021

1. [](#new)

2. [](#improved)
    * Changed some more settings in the plugin blueprint to utilize the core's ML labels.
3. [](#bugfix)
    * Fixes for 0byte sized feeds for RSS feeds by using `page.template` vs `page.name`

# v2.1.9
## 01/20/2021

1. [](#new)
    * Adding a languages.yaml file to begin work on multi-language support.
2. [](#improved)

3. [](#bugfix)
    * Multilanguage fixes for RSS feeds.

# v2.1.8
## 01/20/2021

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Grav 1.7 compatibility fix for podcast-episode content field.

# v2.1.7
## 10/19/2020

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Added missing twig brackets (thanks to [PalmTreeVI](https://github.com/PalmTreeVI))

# v2.1.6
## 09/20/2020

1. [](#new)
    * Added podcast episode number to feed.

2. [](#improved)
    * Updated News category options

3. [](#bugfix)
    * Updated field name to disable page media upload field on channels, series, and episodes.

# v2.1.5
## 01/28/2020

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Fixed multi-language support while saving a podcast episode
    * Fixed incompatibility with Spotify ellipsis support
    * Added check for image on channel page if no image exists

# v2.1.4
## 02/11/2019

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Updated gemfiles.  Fixes ffi security warning.

# v2.1.3
## 05/25/2018

1. [](#new)

2. [](#improved)

3. [](#bugfix)
    * Fixed remote media urls in the media player.

# v2.1.2
## 05/14/2018

1. [](#new)
    * New podcast configuration field for max podcast filesize.

2. [](#improved)
    * More audio tags supported (audio/* vs. just mp3).

3. [](#bugfix)
    * Fixed various typos.
    * Fixed media paths for episodes to use base_url's.
    * Fixed truncation of summaries.

# v2.1.1
## 08/05/2017

1. [](#new)
    * No new features.

2. [](#improved)
    * No new improvements.

3. [](#bugfix)
    * Removed broken podcast-host blueprint

# v2.1.0
## 10/23/2017
1. [](#new)
    * External hosting of audio is now supported. (Thanks to apotropaic)

2. [](#improved)
    * Audio metadata calculated on page save rather than initial page view.  Defaults to local for calculations.

3. [](#bugfix)


# v2.0.0
## 10/03/2017
1. [](#new)
    * New page type for podcast-series.  Folder structure follows Channel->Series->Episode. (Issue #4)
    * New RSS feed available at podcast-series for child episodes of a series.

2. [](#improved)
    * Vastly improved Twig templates for all three page types

3. [](#bugfix)
    * Removed references to "speaker" (Issue #5)


# v1.0.1
## 08/05/2017

1. [](#new)
    * No new features.

2. [](#improved)
    * Cleaned up code for media display of individual podcast.

3. [](#bugfix)
    * Version number in blueprints updated correctly.


# v1.0.0
## 07/12/2017

1. [](#new)
    * Audio duration now calculated via get-id3 Grav plugin
    * Dependencies added to blueprints.yaml

2. [](#improved)
    * Unessential GUID PHP functions removed

3. [](#bugfix)
    * Spacing for duration meta data insertion fixed

# v0.9.2
## 07/11/2017

1. [](#new)

2. [](#improved)
    * GUID now properly defined

3. [](#bugfix)
    * Fixed typo in README file
    * Spacing issue on rss feed item tag
    * Updated blueprints.yaml to match correct version
    * Added sub categories underneath some of the entries in iTunesCategories.yaml

# v0.9.1
## 07/06/2017

1. [](#new)
    * Language selection now follows the codes found [here](http://www.loc.gov/standards/iso639-2/php/code_list.php)
2. [](#improved)
    * Podcast category and sub-categories now populate into the RSS feed.
3. [](#bugfix)
    * Removed non-working call in podcast channel blueprint.

# v0.9.0
## 07/05/2017

1. [](#new)
    * Groundwork for calculating episode duration.
    * CSS striping added to podcast_archive_list.html.twig partial.
2. [](#improved)
    * Rss feed as well as the partial render an episode's duration.
3. [](#bugfix)
    * Added self-referencing atom tag for rss feed.
    * Collections now use the correct header date for published date.  Falls back to header.date if header.publish_date is not avilable.
    * Removed a few debug lines.
    * Removed auto-generated 'text_var' from podcast.yaml

# v0.1.0
##  06/30/2017

1. [](#new)
    * ChangeLog started...
