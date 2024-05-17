<?php
// Minishare extension, https://github.com/GiovanniSalmeri/yellow-minishare

class YellowMinishare {
    const VERSION = "0.9.1";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("minishareServices", "facebook, twitter, linkedin, email");
        $this->yellow->system->setDefault("minishareTwitterUser", "");
        $this->yellow->system->setDefault("minishareStyle", "plain");
        $this->yellow->language->setDefaults(array(
            "Language: en",
            "MinishareLabel: Share this article:",
            "MinishareCustomMastodon: Your Mastodon instance",
            "Language: de",
            "MinishareLabel: Diesen Artikel teilen:",
            "MinishareCustomMastodon: Deine Mastodon-Instanz",
            "Language: fr",
            "MinishareLabel: Partager cet article:",
            "MinishareCustomMastodon: Votre instance Mastodon",
            "Language: it",
            "MinishareLabel: Condividi questo articolo:",
            "MinishareCustomMastodon: La tua istanza Mastodon",
            "Language: es",
            "MinishareLabel: Compartir este artículo:",
            "MinishareCustomMastodon: Tu instancia Mastodon",
            "Language: pt",
            "MinishareLabel: Compartilhe este artigo:",
            "MinishareCustomMastodon: Su instância Mastodon",
            "Language: nl",
            "MinishareLabel: Deel dit artikel:",
            "MinishareCustomMastodon: Je Mastodon-instance"
        ));
    }
    
    // Handle page content element
    public function onParseContentElement($page, $name, $text, $attributes, $type) {
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
            if (is_string_empty($services[0])) {
                $services = preg_split('/\s*,\s*/', $this->yellow->system->get("minishareServices"));
            }
            $twitteruser = $this->yellow->system->get("minishareTwitterUser");
            $values = [
                "{url}"=>rawurlencode($this->yellow->page->getUrl(true)),
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
            $assetLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreAssetLocation");
            $style = $this->yellow->system->get("minishareStyle");
            $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$assetLocation}minishare-{$style}.css\" />\n";
            $output .= "<script type=\"text/javascript\" defer=\"defer\" src=\"{$assetLocation}minishare.js\"></script>\n";
        }
        if ($name=="minishare" || $name=="link") {
            $output = $this->onParseContentElement($page, "minishare", "", "", "block");
        }
        return $output;
    }
}
