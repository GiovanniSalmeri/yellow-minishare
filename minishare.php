<?php
// Minishare plugin
// Copyright (c) 2018-2019 Giovanni Salmeri
// This file may be used and distributed under the terms of the public license.

class YellowMinishare {
    const VERSION = "0.8.9";
    const TYPE = "feature";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("minishareServices", "facebook, twitter, linkedin, email");
        $this->yellow->system->setDefault("minishareTwitterUser", "");
        $this->yellow->system->setDefault("minishareStyle", "plain");
        $this->yellow->system->setDefault("minishareSamePage", "0");
    }
    
    // Handle page content parsing of custom block
    public function onParseContentShortcut($page, $name, $text, $type) {
        $output = null;
        if ($name=="minishare" && ($type=="block" || $type=="inline")) {
            $serv_urls = [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=%s',
                'flattr' => 'https://flattr.com/submit/auto?url=%s&title=%s&category=text',
                // 'googleplus' => 'https://plus.google.com/share?url=%s', // shutting down on 2019-04-02
                'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=%s',
                'email' => 'mailto:?subject=%2$s&body=%1$s',
                'pinterest' => 'https://www.pinterest.com/pin/create/link/?url=%s',
                'reddit' => 'https://reddit.com/submit?url=%s&title=%s',
                'telegram' => 'https://t.me/share/url?url=%s',
                'tumblr' => 'http://tumblr.com/widgets/share/tool?canonicalUrl=%s',
                'twitter' => 'https://twitter.com/intent/tweet?url=%s&text=%s%s',
                'whatsapp' => 'whatsapp://send?text=%2$s%%20%1$s',
            ];
            $norm = [
                // "googleplus" => "Google+",  // shutting down on 2019-04-02
                "linkedin" => "LinkedIn",
            ];
            $services = $this->yellow->toolbox->getTextArgs($text);
            if (empty($services[0])) {
                $services = array_map("trim", explode(",", $this->yellow->system->get("minishareServices")));
            }
            $url = rawurlencode($this->yellow->page->getUrl());
            $title = rawurlencode($this->yellow->page->get("title"));
            $twitteruser = $this->yellow->system->get("minishareTwitterUser");
            $via = $twitteruser ? "&via=" . substr($twitteruser, 1) : ""; // no initial @
            foreach ($services as $service) {
               if ($serv_urls[$service]) {
                   $links[] = "<a class=\"" . $service . "\" href=\"" . sprintf($serv_urls[$service], $url, $title, $via) . "\">" . ($norm[$service] ? $norm[$service] : ucfirst($service)) . "</a>";
               }
            }
            $output = "<div class=\"minishare\"><strong>" . $this->yellow->text->get("minishareLabel") . "</strong> " . implode("<span> | </span>", $links) . "</div>\n";
        }
        return $output;
    }

    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="header") {
            $extensionLocation = $this->yellow->system->get("coreServerBase").$this->yellow->system->get("coreExtensionLocation");
            $style = $this->yellow->system->get("minishareStyle");
            if ($style != "plain") $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$extensionLocation}minishare-{$style}.css\" />\n";
            if (!$this->yellow->system->get("minishareSamePage")) $output .= "<script type=\"text/javascript\" defer=\"defer\" src=\"{$extensionLocation}minishare.js\"></script>\n";
        }
        if ($name=="links") {
            $output .= $this->onParseContentShortcut($page, "minishare", "", true);
        }
        return $output;
    }
}
