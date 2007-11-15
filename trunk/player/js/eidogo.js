/**
 * EidoGo -- Web-based SGF Replayer
 * Copyright (c) 2006, Justin Kramer <jkkramer@gmail.com>
 * Code licensed under the BSD license:
 * http://www.opensource.org/licenses/bsd-license.php
 *
 * This file sets up the EidoGo framework.
 */

/**
 * Our namespace.
 */
window.eidogo = window.eidogo || {};

/**
 * Search for DIV elements with the class 'eidogo-player-auto' and insert a
 * Player into each.
**/
eidogo.auto = function(autoCfg) {
    autoCfg = autoCfg || {};
    
    eidogo.util.addStyleSheet('player/css/player.css');
    
    eidogo.util.addEvent(window, "load", function() {
        
        eidogo.autoPlayers = [];
        var els = eidogo.util.byClass("div.eidogo-player-auto");
        [].forEach.call(els, function(el) {
            var cfg = {container: el, disableShortcuts: true};
            for (var key in autoCfg) {
                cfg[key] = autoCfg[key];
            }
            var sgfUrl = el.getAttribute('sgf');
            if (sgfUrl) cfg.sgfUrl = sgfUrl;
            else if (el.innerHTML) cfg.sgf = el.innerHTML;
            el.innerHTML = "";
            eidogo.util.show(el);
            var player = new eidogo.Player(cfg);
            eidogo.autoPlayers.push(player);
        });
    });
}