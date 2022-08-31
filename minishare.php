<?php
// Minishare extension, https://github.com/GiovanniSalmeri/yellow-minishare

class YellowMinishare {
    const VERSION = "0.8.20";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("minishareServices", "facebook, twitter, linkedin, email");
        $this->yellow->system->setDefault("minishareTwitterUser", "");
        $this->yellow->system->setDefault("minishareStyle", "plain");
    }
    
    // Handle page content parsing of custom block
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="minishare" && ($type=="block" || $type=="inline")) {
            $shareUrls = [
                'email' => 'mailto:?subject={title}&body={url}',
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u={url}',
                'flipboard' => 'https://share.flipboard.com/bookmarklet/popout?v=2&title={title}&url={url}',
                'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url={url}',
                'mastodon' => 'https://___custom___/share?text={title}%20{url}',
                'pinterest' => 'https://www.pinterest.com/pin/create/link/?url={url}',
                'reddit' => 'https://reddit.com/submit?url={url}&title={title}',
                'telegram' => 'https://t.me/share/url?url={url}',
                'tumblr' => 'http://tumblr.com/widgets/share/tool?canonicalUrl={url}',
                'twitter' => 'https://twitter.com/intent/tweet?url={url}&text={title}{via}',
                'vk' => 'http://vk.com/share.php?url={url}&title={title}',
                'whatsapp' => 'whatsapp://send?text={title}%20{url}',
                // see others: https://github.com/bradvin/social-share-urls
            ];
            $styling = [
                "linkedin" => "LinkedIn",
                "whatsapp" => "WhatsApp",
                "vk" => "VK",
            ];
            $services = $this->yellow->toolbox->getTextArguments($text);
            if (empty($services[0])) {
                $services = preg_split('/\s*,\s*/', $this->yellow->system->get("minishareServices"));
            }
            $twitteruser = $this->yellow->system->get("minishareTwitterUser");
            $values = [
                "{url}"=>rawurlencode($this->yellow->page->getUrl()),
                "{title}"=>rawurlencode($this->yellow->page->get("title")),
                "{via}"=>$twitteruser ? "&via=".substr($twitteruser, 1) : "", // no initial @
            ];
            foreach ($services as $service) {
               if (isset($shareUrls[$service])) {
                    $isCustom = strpos($shareUrls[$service], "___custom___")!==false;
                    $dataCustom = $isCustom ? " data-prompt=\"".htmlspecialchars($this->yellow->language->getText("minishareCustom".ucfirst($service)))."\"" : "";
                    $links[] = "<a class=\"minishare-".$service."\" href=\"".htmlspecialchars($this->interpolate($shareUrls[$service], $values))."\"".$dataCustom."\">".htmlspecialchars($styling[$service] ?? ucfirst($service))."</a>";
               }
            }
            $output = "<div class=\"minishare\"><strong>".$this->yellow->language->getText("minishareLabel")."</strong> ".implode("<span> | </span>", $links)."</div>\n";
        }
        return $output;
    }

    // Interpolate string from associative array
    private function interpolate($string, $values) {
        $string = str_replace(array_keys($values), $values, $string);
        return $string;
    }

    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="header") {
            $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
            $style = $this->yellow->system->get("minishareStyle");
            $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}minishare-{$style}.css\" />\n";
            $output .= "<script type=\"text/javascript\" defer=\"defer\" src=\"{$extensionLocation}minishare.js\"></script>\n";
        }
        if ($name=="links") {
            $output .= $this->onParseContentShortcut($page, "minishare", "", true);
        }
        return $output;
    }
}
