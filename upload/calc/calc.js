var EIInit = {};
(function (EIInit) {

    'use strict';

    var locationRequest = 'http://www.euro-ins.ru/calc/postmessage.js';
    var iframeSrc = "http://www.euro-ins.ru/calc/health/index.php";
    var scriptId = "euro-ins-calc";

    function main() {

        function run(url) {
            iframeSrc = url;
            run.sendRequest();
        }

        //add css and js

        run.sendRequest = function(){
            if (!document.getElementById( scriptId )){
                var oHead = document.getElementsByTagName('HEAD').item(0);
                var oScript = document.createElement( "script" );
                oScript.language = "javascript";
                oScript.type = "text/javascript";
                oScript.id = scriptId;
                oScript.defer = true;
                oScript.src = locationRequest;
                oScript.onload = function(){
                    run.init();
                };
                oHead.appendChild( oScript );
                run.ieLoadBugFix(oScript, function(){
                    run.init();
                });
            }
        };

        run.ieLoadBugFix = function(scriptElement, callback){
            if (scriptElement.readyState=='loaded' || scriptElement.readyState=='completed') {
                callback();
            }else {
                setTimeout(function() {run.ieLoadBugFix(scriptElement, callback); }, 100);
            }
        };

        run.init = function() {

                var if_height;
                var if_width;
                var src = iframeSrc+'#' + encodeURIComponent( document.location.href);
                var iframe = document.getElementById("calcFrame");
                iframe.src = src;
                XD.receiveMessage(function(event){
                    var sizes = event.data.split(",");

                    var h = Number( sizes[0] );
                    var w = Number( sizes[1] );

                    if ( !isNaN( h ) && h > 0 && h !== if_height ) iframe.style.height = if_height = h +"px" ;
                    if ( !isNaN( w ) && w > 0 && w !== if_width ) iframe.style.width = if_width = w +"px" ;
                });

        };

        return run;
    }

    EIInit.run = main();
})(EIInit);
