$(document).ready(function() {
    // Initialize navgoco with default options
    $("#menu").navgoco({
        caretHtml: '',
        accordion: false,
        openClass: 'open',
        save: true,
        cookie: {
            name: 'navgoco',
            expires: false,
            path: '/'
        },
        slide: {
            duration: 400,
            easing: 'swing'
        },
        // Add Active class to clicked menu item
        onClickAfter: active_menu_cb,
    });

    $("#collapseAll").click(function(e) {
        e.preventDefault();
        $("#menu").navgoco('toggle', false);
    });

    $("#expandAll").click(function(e) {
        e.preventDefault();
        $("#menu").navgoco('toggle', true);
    });
});