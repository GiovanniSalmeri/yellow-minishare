# Minishare plugin 0.7.6

Featherlight and accessible social-sharing links in various styles.

![Screenshot](minishare-screenshot.png?raw=true)

## How to install plugin

1. [Download and install Datenstrom Yellow](https://github.com/datenstrom/yellow/).
2. [Download plugin](../../archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `master.zip` into your `system/plugins` folder.

To uninstall delete the [plugin files](update.ini).

## How to add sharing links

Sharing links are automatically shown on blog and wiki pages. To show links on other pages, create a [minishare] shortcut.

This plugin does not show social statistics, but is much lighter and a bit more accessible than [Shariff](https://github.com/schulle4u/yellow-plugin-shariff). For better results, it is recommended that you install also [Socialtags](https://github.com/schulle4u/yellow-plugin-socialtags) and configure `SocialtagsImage`.

## How to configure social links

The following settings can be configured in file `system/config/config.ini`:

`MinishareServices` (default = `facebook, twitter, linkedin, email`) = comma-separated social sharing services (you can choose between `facebook`, `flattr`, `googleplus`, `linkedin`, `email`, `pinterest`, `reddit`, `telegram`, `tumblr`, `twitter`, `whatsapp`)  
`MinishareStyle` (default = `plain`) = link style (you can choose between `plain`, `squared`, `rounded`) 
`MinishareSamePage` (default = `0`) = opens links in the same page instead than in a pop-up window

If you want to add a new `fancy` style, simply write a `minishare-fancy.css`  file and put into the `system/plugin` folder. Do not modify the standard styles, since they will be overwritten in case of update of the plugin.

## Example

Embedding social links in normal pages:

`[minishare]`

## Developer

Giovanni Salmeri
