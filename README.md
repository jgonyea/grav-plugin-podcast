# Podcast Plugin

The **Podcast** Plugin is for [Grav CMS](http://github.com/getgrav/grav). This plugin creates the following:
- Page template for Podcast Channel
- Page template Podcast Episode
- An iTunes compatible podcast RSS feed

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
* [Grav](http://github.com/getgrav/grav)
* [Error](https://github.com/getgrav/grav-plugin-error)
* [Problems](https://github.com/getgrav/grav-plugin-problems)
* [Feed](https://github.com/getgrav/grav-plugin-feed)

> While technically not required, using the [Admin](https://github.com/getgrav/grav-plugin-admin) plugin will assist in adding new content.

## Configuration

Before configuring this plugin, you should copy the `user/plugins/podcast/podcast.yaml` to `user/config/plugins/podcast.yaml` and only edit that copy.

Here is the default configuration and an explanation of available options:

```yaml
enabled: true
```

## Usage

After installing and enabling the plugin, the admin form should now have two new page templates:
- Podcast Channel
- Podcast Episode

### Podcast Channel

A podcast RSS feed is created at PAGENAME.rss.  RSS tags are filled with the appropriate data submitted in the admin form for a podcast channel/ episode.
Example:
If a podcast channel is created at  at http://www.example.com/mypodcast, then the url for the podcast RSS feed is found at http://www.example.com/mypodcast.rss

A partial is included for use on a podcast channel page.  Place the following:
```
{% include 'partials/podcast_archive_list.html.twig' %}
```
in a podcast channel page's markdown for a listing of that channel's latest podcasts.  Ensure to add the following to the header of the podcast channel:
```
process:
    markdown: true
    twig: true
twig_first: true
```

### Podcast Episode

These should be created as child pages of a podcast channel.  Note: Episodes won't show up in the RSS feed or the partial if there is no podcast audio attached.

## Credits

- RSS structure based on [iTunes RSS Feed Sample](https://help.apple.com/itc/podcasts_connect/#/itcbaf351599)
- Thanks to [flaviocopes](https://github.com/flaviocopes) who assisted me with the initial groundwork from the feeds plugin

## To Do

- [ID3 integration](http://getid3.sourceforge.net/)
- Better media player integration (playlist?)
- Fix incorrect <itunes:duration> and partials length calculation
- Set podcast meta field validations as required