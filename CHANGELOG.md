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
