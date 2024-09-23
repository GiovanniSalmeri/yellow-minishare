// Minishare extension, https://github.com/GiovanniSalmeri/yellow-minishare

"use strict";
document.addEventListener("DOMContentLoaded", function() {
    var minishares = document.getElementsByClassName("minishare");
    Array.from(minishares).forEach(function(minishare) {
        var links = minishare.getElementsByTagName("a");
        Array.from(links).forEach(function(link){
            if ("prompt" in link.dataset) {
                link.addEventListener("click", makeCustomUrl);
            }
        });
    });

    function makeCustomUrl(e) {
        var promptLabel = e.target.dataset.prompt;
        var instance = prompt(promptLabel);
        if (instance===null || instance.trim()==="") {
            e.preventDefault();
        } else {
            instance = instance.trim().replace(/^https?:\/\//, "");
            e.target.href = e.target.href.replace("___instance___", instance);
        }
    }
});
