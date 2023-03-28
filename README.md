Minishare 0.8.20
================
Social sharing links.

<p align="center"><img src="minishare-screenshot.png?raw=true" alt="Screenshot"></p>

## How to install an extension

[Download ZIP file](https://github.com/GiovanniSalmeri/yellow-minishare/archive/main.zip) and copy it into your `system/extensions` folder. [Learn more about extensions](https://github.com/annaesvensson/yellow-update).

## How to show sharing links

This extension adds sharing links for popular social media sites. Links are shown on blog and wiki pages. To show links on other pages use a `[minishare]` shortcut. It's recommended to install the [meta extension](https://github.com/annaesvensson/yellow-meta), it allows you to set additional meta data for social media sites.

If you want to customise sharing links with CSS, write a `minishare-custom.css` file, put it into your `system/extensions` folder, open file `system/extensions/yellow-system.ini` and change `MinishareStyle: custom`. Another option to customise sharing links with CSS is editing the files in your `system/themes` folder. It's recommended to use the later option.

## Examples

Content file with sharing links:

    ---
    Title: Example page
    ---
    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut 
    labore et dolore magna pizza. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris 
    nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit 
    esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt 
    in culpa qui officia deserunt mollit anim id est laborum.

    [minishare]

Layout file with sharing links:

    <?php $this->yellow->layout("header") ?>
    <div class="content">
    <div class="main" role="main">
    <h1><?php echo $this->yellow->page->getHtml("titleContent") ?></h1>
    <?php echo $this->yellow->page->getContent() ?>
    <?php echo $this->yellow->page->getExtra("minishare") ?>
    </div>
    </div>
    <?php $this->yellow->layout("footer") ?>

Configuring different sharing services in the settings:

```
MinishareServices: facebook, twitter, linkedin, email
MinishareServices: mastodon, facebook, twitter, linkedin, email
```

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`MinishareServices` = social sharing services, [supported sharing services](#settings-services)  
`MinishareTwitterUser` = your Twitter user name, e.g. `@dog_feelings`  
`MinishareStyle` = link style, e.g. `plain`, `squared`, `rounded`  

<a id="settings-services"></a>The following sharing services are supported:

`email` = share via email  
`facebook` = share on [Facebook](https://facebook.com)  
`flipboard` = share on [Flipboard](https://flipboard.com)  
`linkedin` = share on [LinkedIn](https://linkedin.com)  
`mastodon` = share on [Mastodon](https://joinmastodon.org)  
`pinterest` = share on [Pinterest](https://www.pinterest.com)  
`reddit` = share on [Reddit](https://reddit.com)  
`telegram` = share on [Telegram](https://telegram.org)  
`tumblr` = share on [Tumblr](https://tumblr.com)  
`twitter` = share on [Twitter](https://twitter.com)  
`vk` = share on [VK](https://vk.com)  
`whatsapp` = share on [Whatsapp](https://whatsapp.com)  

## Developer

Giovanni Salmeri. [Get help](https://datenstrom.se/yellow/help/).
