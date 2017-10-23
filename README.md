# Podcast Plugin

The **Podcast** Plugin is for [Grav CMS](http://github.com/getgrav/grav). This plugin creates the following:
- Page templates for Podcast Channel, Podcast Series, and Podcast Episode
- An iTunes compatible podcast RSS feed, both at the Podcast Channel (all episodes) and Podcast Series (only a series' episodes)

## Installation

Installing the Podcast plugin can be done in one of two ways. The GPM (Grav Package Manager) installation method enables you to quickly and easily install the plugin with a simple terminal command, while the manual method enables you to do so via a zip file.

### GPM Installation (Preferred)

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's terminal (also called the command line).  From the root of your Grav install type:

    bin/gpm install podcast

This will install the Podcast plugin into your `/user/plugins` directory within Grav. Its files can be found under `/your/site/grav/user/plugins/podcast`.

### Manual Installation

To install this plugin, just download the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `podcast`. You can find these files on [GitHub](https://github.com//grav-plugin-podcast) or via [GetGrav.org](http://getgrav.org/downloads/plugins#extras).

You should now have all the plugin files under

    /your/site/grav/user/plugins/podcast

> NOTE: This plugin is a modular component for Grav which requires the following to operate:
* [Auto Date](https://github.com/getgrav/grav-plugin-auto-date)
* [Error](https://github.com/getgrav/grav-plugin-error)
* [Feed](https://github.com/getgrav/grav-plugin-feed)
* [GetId3](https://github.com/jgonyea/grav-plugin-get-id3), along with its accompanying [getID3 php library](http://www.getid3.org/)
* [Grav](http://github.com/getgrav/grav)
* [Problems](https://github.com/getgrav/grav-plugin-problems)

> While technically not required, using the [Admin](https://github.com/getgrav/grav-plugin-admin) plugin will assist in adding new content.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/podcast/podcast.yaml` to `user/config/plugins/podcast.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:


```yaml
enabled: true
```
_Defaults plugin to **enabled** after installation_

## Usage

After installing and enabling the plugins, the admin form will now have three new page templates:
* Podcast Channel
* Podcast Series
* Podcast Episode

The general folder structure using only series will look like this:
* Podcast Channel
  * Podcast Series A
    * Podcast Episode 1
    * Podcast Episode 2
  * Podcast Series B
    * Podcast Episode 3
    * Podcast Episode 4

Using no series will look like this:
* Podcast Channel
  * Podcast Episode 1
  * Podcast Episode 2

Non-series episodes can exist next to series:
* Podcast Channel
  * Podcast Episode 1
  * Podcast Episode 2
  * Podcast Series A
    * Podcast Episode 3
    * Podcast Episode 4


### Podcast Channel

A podcast RSS feed is created at PAGENAME.rss of all episodes underneath the channel, including ones within series.  RSS tags are filled with the appropriate data submitted in the admin form for a podcast channel/ episode.

Example:
If a podcast channel is created at  at http://www.example.com/mypodcast, then the url for the podcast RSS feed is found at http://www.example.com/mypodcast.rss

### Podcast Series
Used to group episodes, a podcast series page should be a child page to a podcast channel.  Multiple series can exist as child pages of a podcast channel.  A podcast RSS feed is also available at SERIESNAME.rss, but it will only contain episodes that are child pages to the series.

Example:
If a podcast series is created at  at http://www.example.com/mypodcast/series1, then the url for the podcast RSS feed is found at http://www.example.com/mypodcast/series1.rss

### Podcast Episode

These should be created as child pages of either a podcast channel or a podcast series.  Note: Episodes won't show up in the RSS feed if there is no podcast audio attached.  Episodes can use the built-in publish_date field to schedule publishing of the page, and the RSS feed will use publish_date, falling back to just date if found.

## Credits

* Thanks to apotropaic for his help with remote file support.
* Thanks to [flaviocopes](https://github.com/flaviocopes) who assisted me with the initial groundwork from the feeds plugin
* RSS structure based on [iTunes RSS Feed Sample](https://help.apple.com/itc/podcasts_connect/#/itcbaf351599)

## To Do
Submit any issues you find to the [issue queue](https://github.com/jgonyea/grav-plugin-podcast/issues).
A Trello board of current progress can be found [here](https://trello.com/b/jIKLMt5K/grav-plugin-podcast).
