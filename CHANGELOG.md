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
