# Minishare 0.8.2

Light and accessible social sharing links.

![Screenshot](minishare-screenshot.png?raw=true)

## How to install extension

1. [Download and install Datenstrom Yellow](https://github.com/datenstrom/yellow/).
2. [Download extension](../../archive/master.zip). If you are using Safari, right click and select 'Download file as'.
3. Copy `master.zip` into your `system/extensions` folder.

To uninstall delete the [extension files](extension.ini).

## How to add sharing links

Sharing links are automatically shown on blog and wiki pages. To show links on other pages, create a [minishare] shortcut.

This extension does not show social statistics, but is much lighter and a bit more accessible than [Shariff](https://github.com/schulle4u/yellow-extension-shariff). For better results, it is recommended that you install also [Socialtags](https://github.com/schulle4u/yellow-extensions-schulle4u/tree/master/socialtags) and configure `SocialtagsImage`.

## How to configure social links

The following settings can be configured in file `system/settings/system.ini`:

`MinishareServices` (default = `facebook, twitter, linkedin, email`) = comma-separated social sharing services (you can choose between `facebook`, `flattr`, `linkedin`, `email`, `pinterest`, `reddit`, `telegram`, `tumblr`, `twitter`, `whatsapp`)  
`MinishareStyle` (default = `plain`) = link style (you can choose between `plain`, `squared`, `rounded`)  
`MinishareSamePage` (default = `0`) = links open in the same page rather than in a pop-up window  

If you want to add a new `fancy` style, simply write a `minishare-fancy.css`  file and put into the `system/settings` folder. Do not modify the standard styles, since they will be overwritten in case of update of the extension.

## Example

Embedding social links in normal pages:

`[minishare]`

## Developer

Giovanni Salmeri
