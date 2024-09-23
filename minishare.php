<?php
// Minishare extension, https://github.com/GiovanniSalmeri/yellow-minishare

class YellowMinishare {
    const VERSION = "0.9.2";
    public $yellow;         //access to API
    
    // Handle initialisation
    public function onLoad($yellow) {
        $this->yellow = $yellow;
        $this->yellow->system->setDefault("minishareServices", "facebook, whatsapp, linkedin, telegram, email");
        $this->yellow->system->setDefault("minishareStyle", "plain");
        $this->yellow->language->setDefaults(array(
            "Language: en",
            "MinishareLabel: Share this article:",
            "MinishareCustom: Your @service instance",
            "Language: de",
            "MinishareLabel: Diesen Artikel teilen:",
            "MinishareCustom: Deine @service-Instanz",
            "Language: fr",
            "MinishareLabel: Partager cet article:",
            "MinishareCustom: Votre instance @service",
            "Language: it",
            "MinishareLabel: Condividi questo articolo:",
            "MinishareCustom: La tua istanza @service",
            "Language: es",
            "MinishareLabel: Compartir este artículo:",
            "MinishareCustom: Tu instancia @service",
            "Language: pt",
            "MinishareLabel: Compartilhe este artigo:",
            "MinishareCustom: Su instância @service",
            "Language: nl",
            "MinishareLabel: Deel dit artikel:",
            "MinishareCustom: Je @service-instance"
        ));
    }
    
    // Handle page content element
    public function onParseContentElement($page, $name, $text, $attributes, $type) {
        $output = null;
        if ($name=="minishare" && ($type=="block" || $type=="inline")) {
            $shareUrls = [];
            $iniLines = file($this->yellow->system->get("coreExtensionDirectory")."minishare.ini");
            foreach ($iniLines as $iniLine) {
                if (trim($iniLine)=="" || $iniLine[0]=="#") continue;
                if (preg_match("/^\s*(.*?)\s*:\s*(.*?)\s*$/", $iniLine, $matches)) {
                    $shareUrls[strtolower($matches[1])] = [ $matches[1], $matches[2] ];
                }
            }
            $services = preg_split('/\s*,\s*/', $this->yellow->system->get("minishareServices"));
            $values = [
                "@url"=>rawurlencode($this->yellow->page->getUrl(true)),
                "@title"=>rawurlencode($this->yellow->page->get("title")),
            ];
            $links = [];
            foreach ($services as $service) {
               if (isset($shareUrls[$service])) {
                    $isCustom = strpos($shareUrls[$service][1], "___instance___")!==false;
                    $dataCustom = $isCustom ? " data-prompt=\"".htmlspecialchars(str_replace("@service", $shareUrls[$service][0], $this->yellow->language->getText("minishareCustom")))."\"" : "";
                    $links[] = "<a class=\"minishare-".$service."\" href=\"".htmlspecialchars(strtr($shareUrls[$service][1], $values))."\"".$dataCustom."\">".htmlspecialchars($shareUrls[$service][0])."</a>";
               }
            }
            $output = "<div class=\"minishare\"><strong>".$this->yellow->language->getText("minishareLabel")."</strong> ".implode("<span> | </span>", $links)."</div>\n";
        }
        return $output;
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
