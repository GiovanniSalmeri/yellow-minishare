Minishare 0.8.10
================
Light and accessible social sharing links.

![Screenshot](minishare-screenshot.png?raw=true)

## How to add sharing links

Sharing links are automatically shown on blog and wiki pages. To show links on other pages, create a [minishare] shortcut.

For better results, it is recommended that you install also [the Meta extension](https://github.com/datenstrom/yellow-extensions/tree/master/source/meta) (default in new Yellow installations) and configure `metaDefaultImage`.

## Example

Embedding social links in normal pages:

`[minishare]`

## Settings

The following settings can be configured in file `system/extensions/yellow-system.ini`:

`MinishareServices` (default = `facebook, twitter, linkedin, email`) = comma-separated social sharing services (you can choose between `facebook`, `flattr`, `linkedin`, `email`, `pinterest`, `reddit`, `telegram`, `tumblr`, `twitter`, `whatsapp`)  
`MinishareTwitterUser` = Your site's twitter `@username`, will show up in tweets for shared posts.  
`MinishareStyle` (default = `plain`) = link style (you can choose between `plain`, `squared`, `rounded`)  
`MinishareSamePage` (default = `0`) = links open in the same page rather than in a pop-up window  

If you want to add a new `fancy` style, write a `minishare-fancy.css`  file and put into the `system/extensions` folder.

## Installation

[Download extension](https://github.com/GiovanniSalmeri/yellow-minishare/archive/master.zip) and copy zip file into your `system/extensions` folder. Right click if you use Safari.

## Developer

Giovanni Salmeri. [Get help](https://github.com/GiovanniSalmeri/yellow-minishare/issues).
