$(document).ready(function(){
    // Read a page's GET URL variables and return them as an associative array.
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
    var adsource = getUrlVars()["utm_source"];
    var adlink;
    switch(adsource) {
        case 'fb_paid':
            adlink = 'http://www.jenu.com/ft00324?utm_source=fof_beauty&utm_medium=advertorial&utm_content=Vogue&utm_campaign=fof_beauty_vogue_adv_cpa_fbad';
            break;
        default:
            adlink = 'http://www.jenu.com/ft00324?utm_source=fof_beauty&utm_medium=advertorial&utm_content=Vogue&utm_campaign=fof_beauty_vogue_adv_cpa';
    }
    $(".linkto").attr("href", adlink);
});