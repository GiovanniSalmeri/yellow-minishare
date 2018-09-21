<?php
// Minishare plugin
// Copyright (c) 2018 Giovanni Salmeri
// This file may be used and distributed under the terms of the public license.

class YellowMinishare {
    const VERSION = "0.7.6";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->config->setDefault("minishareServices", "facebook, twitter, linkedin, email");
        $this->yellow->config->setDefault("minishareStyle", "plain");
        $this->yellow->config->setDefault("minishareSamePage", "0");
    }
    
    // Handle page content parsing of custom block
    public function onParseContentBlock($page, $name, $text, $shortcut) {
        $output = null;
        if ($name=="minishare" && $shortcut) {
            $serv_urls = [
                'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=%s',
                'flattr' => 'https://flattr.com/submit/auto?url=%s&title=%s&category=text',
                'googleplus' => 'https://plus.google.com/share?url=%s',
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
                "googleplus" => "Google+",
                "linkedin" => "LinkedIn",
            ];
            $services = $this->yellow->toolbox->getTextArgs($text); // undocumented
            if (empty($services[0])) {
                $services = array_map("trim", explode(",", $this->yellow->config->get("minishareServices")));
            }
            $url = rawurlencode($this->yellow->page->getUrl());
            $title = rawurlencode($this->yellow->page->get("title"));
            $twitteruser = $this->yellow->config->get("socialtagsTwitterUser");
            $via = $twitteruser ? "&via=" . substr($twitteruser, 1) : ""; // no initial @
            foreach ($services as $service) {
               if ($serv_urls[$service]) {
                   $links[] = "<a class=\"" . $service . "\" href=\"" . sprintf($serv_urls[$service], $url, $title, $via) . "\">" . ($norm[$service] ? $norm[$service] : ucfirst($service)) . "</a>";
               }
            }
            $output = "<div class=\"minishare\"><strong>" . $this->yellow->text->get("minishareLabel") . "</strong> " . implode(" | ", $links) . "</div>\n";
        }
        return $output;
    }

    // Handle page extra data
    public function onParsePageExtra($page, $name) {
        $output = null;
        if ($name=="header") {
            $pluginLocation = $this->yellow->config->get("serverBase").$this->yellow->config->get("pluginLocation");
            $style = $this->yellow->config->get("minishareStyle");
            if ($style != "plain") $output .= "<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"{$pluginLocation}minishare-{$style}.css\" />\n";
            if (!$this->yellow->config->get("minishareSamePage")) $output .= "<script type=\"text/javascript\" defer=\"defer\" src=\"{$pluginLocation}minishare.js\"></script>\n";
        }
        if ($name=="links") {
            $output .= $this->onParseContentBlock($page, "minishare", "", true);
        }
        return $output;
    }
}

$yellow->plugins->register("minishare", "YellowMinishare", YellowMinishare::VERSION);
