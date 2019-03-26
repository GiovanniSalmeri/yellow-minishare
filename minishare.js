document.addEventListener("DOMContentLoaded", function() {
    var links = document.getElementsByClassName("minishare")[0].getElementsByTagName('a');
    for (var i = 0; i < links.length; i++) {
        if (/^https?:\/\//.test(links[i].href)) { // ignore mailto: ecc.
            links[i].addEventListener("click", popupHandler);
        }
    }
//    If more than one minishare for page is allowed:
//    var minishare = document.getElementsByClassName("minishare");
//    for (var j = 0; j < minishare.length; j++) {
//        var links = minishare[j].getElementsByTagName('a');
//        for (var i = 0; i < links.length; i++) {
//            if (/^https?:\/\//.test(links[i].href)) {
//                links[i].addEventListener("click", popupHandler);
//            }
//        }
//    }
});
// see https://www.sitepoint.com/social-media-button-links/
var popupHandler = popupHandler || function(e) {
    e = e || window.event;
    var t = e.target || e.srcElement;
    var popup = window.open(t.href, "_blank", "width=600, height=450, left=0, top=0, menubar=0, toolbar=0, status=0");
    if (popup) {
        if (popup.focus) popup.focus();
        if (e.preventDefault) e.preventDefault();
        e.returnValue = false;
    }
    return !!popup;
}
