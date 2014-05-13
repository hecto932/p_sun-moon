/*jshint multistr:true */
/*global G1 */
/*global jQuery */
/*global alert */

(function ($) {
    "use strict";

    var themeBodyClasses = [
        // fonts
        'g1-font-regular-xs',
        'g1-font-regular-s',
        'g1-font-regular-m',
        'g1-font-regular-l',
        'g1-font-regular-xl',
        'g1-font-important-xs',
        'g1-font-important-s',
        'g1-font-important-m',
        'g1-font-important-l',
        'g1-font-important-xl',
        // ui
        'g1-tl-square',
        'g1-tr-square',
        'g1-bl-square',
        'g1-br-square',
        'g1-tl-squircle',
        'g1-tr-squircle',
        'g1-bl-squircle',
        'g1-br-squircle',
        'g1-tl-circle',
        'g1-tr-circle',
        'g1-bl-circle',
        'g1-br-circle',
        // preheader
        'g1-preheader-space-before',
        'g1-preheader-space-after',
        'g1-preheader-open-overlay',
        'g1-preheader-open-expanded',
        'g1-preheader-layout-wide-wide',
        'g1-preheader-layout-wide-semi',
        'g1-preheader-layout-wide-standard',
        'g1-preheader-layout-wide-narrow',
        'g1-preheader-layout-semi-standard',
        'g1-preheader-layout-semi-narrow',
        'g1-preheader-layout-standard-narrow',
        'g1-preheader-tl-square',
        'g1-preheader-tr-square',
        'g1-preheader-bl-square',
        'g1-preheader-br-square',
        'g1-preheader-tl-squircle',
        'g1-preheader-tr-squircle',
        'g1-preheader-bl-squircle',
        'g1-preheader-br-squircle',
        'g1-preheader-tl-circle',
        'g1-preheader-tr-circle',
        'g1-preheader-bl-circle',
        'g1-preheader-br-circle',
        // header
        'g1-header-space-before',
        'g1-header-space-after',
        'g1-header-position-static',
        'g1-header-position-fixed',
        'g1-header-layout-wide-wide',
        'g1-header-layout-wide-semi',
        'g1-header-layout-wide-standard',
        'g1-header-layout-wide-narrow',
        'g1-header-layout-semi-standard',
        'g1-header-layout-semi-narrow',
        'g1-header-layout-standard-narrow',
        'g1-header-comp-left-right',
        'g1-header-comp-right-left',
        'g1-header-comp-top-left',
        'g1-header-comp-top-center',
        'g1-header-comp-top-right',
        'g1-header-comp-bottom-left',
        'g1-header-comp-bottom-center',
        'g1-header-comp-bottom-right',
        'g1-primary-nav--unstyled',
        'g1-primary-nav--simple',
        'g1-primary-nav--solid',
        'g1-header-tl-square',
        'g1-header-tr-square',
        'g1-header-bl-square',
        'g1-header-br-square',
        'g1-header-tl-squircle',
        'g1-header-tr-squircle',
        'g1-header-bl-squircle',
        'g1-header-br-squircle',
        'g1-header-tl-circle',
        'g1-header-tr-circle',
        'g1-header-bl-circle',
        'g1-header-br-circle',
        'g1-header-search-form-none',
        'g1-header-search-form-standard',
        // precontent
        'g1-precontent-space-before',
        'g1-precontent-space-after',
        'g1-precontent-layout-wide-wide',
        'g1-precontent-layout-wide-semi',
        'g1-precontent-layout-wide-standard',
        'g1-precontent-layout-wide-narrow',
        'g1-precontent-layout-semi-standard',
        'g1-precontent-layout-semi-narrow',
        'g1-precontent-layout-standard-narrow',
        'g1-precontent-tl-square',
        'g1-precontent-tr-square',
        'g1-precontent-bl-square',
        'g1-precontent-br-square',
        'g1-precontent-tl-squircle',
        'g1-precontent-tr-squircle',
        'g1-precontent-bl-squircle',
        'g1-precontent-br-squircle',
        'g1-precontent-tl-circle',
        'g1-precontent-tr-circle',
        'g1-precontent-bl-circle',
        'g1-precontent-br-circle',
        // content
        'g1-content-space-before',
        'g1-content-space-after',
        'g1-content-layout-wide-wide',
        'g1-content-layout-wide-semi',
        'g1-content-layout-wide-standard',
        'g1-content-layout-wide-narrow',
        'g1-content-layout-semi-standard',
        'g1-content-layout-semi-narrow',
        'g1-content-layout-standard-narrow',
        'g1-content-tl-square',
        'g1-content-tr-square',
        'g1-content-bl-square',
        'g1-content-br-square',
        'g1-content-tl-squircle',
        'g1-content-tr-squircle',
        'g1-content-bl-squircle',
        'g1-content-br-squircle',
        'g1-content-tl-circle',
        'g1-content-tr-circle',
        'g1-content-bl-circle',
        'g1-content-br-circle',
        // prefooter
        'g1-prefooter-space-before',
        'g1-prefooter-space-after',
        'g1-prefooter-layout-wide-wide',
        'g1-prefooter-layout-wide-semi',
        'g1-prefooter-layout-wide-standard',
        'g1-prefooter-layout-wide-narrow',
        'g1-prefooter-layout-semi-standard',
        'g1-prefooter-layout-semi-narrow',
        'g1-prefooter-layout-standard-narrow',
        'g1-prefooter-tl-square',
        'g1-prefooter-tr-square',
        'g1-prefooter-bl-square',
        'g1-prefooter-br-square',
        'g1-prefooter-tl-squircle',
        'g1-prefooter-tr-squircle',
        'g1-prefooter-bl-squircle',
        'g1-prefooter-br-squircle',
        'g1-prefooter-tl-circle',
        'g1-prefooter-tr-circle',
        'g1-prefooter-bl-circle',
        'g1-prefooter-br-circle',
        // footer
        'g1-footer-space-before',
        'g1-footer-space-after',
        'g1-footer-layout-wide-wide',
        'g1-footer-layout-wide-semi',
        'g1-footer-layout-wide-standard',
        'g1-footer-layout-wide-narrow',
        'g1-footer-layout-semi-standard',
        'g1-footer-layout-semi-narrow',
        'g1-footer-layout-standard-narrow',
        'g1-footer-tl-square',
        'g1-footer-tr-square',
        'g1-footer-bl-square',
        'g1-footer-br-square',
        'g1-footer-tl-squircle',
        'g1-footer-tr-squircle',
        'g1-footer-bl-squircle',
        'g1-footer-br-squircle',
        'g1-footer-tl-circle',
        'g1-footer-tr-circle',
        'g1-footer-bl-circle',
        'g1-footer-br-circle',
        'g1-footer-comp-01',
        'g1-footer-comp-02',
        'g1-footer-comp-03'
    ];

    var regexp = new RegExp("https?:\/\/(www.)?", "ig");

    var domainUrl = window.location.hostname;
    domainUrl.replace(regexp, "");

    var baseUrl = 'http://' + domainUrl;

    var demos = [
        {
            'name': '01',
            'desc': 'Test description',
            'func': function () {

            },
            'link': baseUrl + '/' + '?demo=1'
        },
        {
            'name': '02',
            'desc': 'Lorem ipsum dolor',
            'func': function () {

                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-square',
                    'g1-tr-square',
                    'g1-bl-square',
                    'g1-br-square',

                    'g1-preheader-open-overlay',
                    'g1-preheader-layout-wide-semi',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-position-static',
                    'g1-header-layout-semi-narrow',
                    'g1-header-comp-left-right',
                    'g1-primary-nav--simple',,
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',

                    // precontent
                    'g1-precontent-layout-wide-narrow',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-semi-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-semi-narrow',
                    'g1-prefooter-tl-square',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',

                    // footer
                    'g1-footer-layout-wide-semi',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-02'
                ];

                ui.moveSearchFromHeaderToPreheader();

                ui.setPrimaryNavClass('g1-nav--simple');


                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                //ui.removePreheader();
                ui.removeTwitterFromPrefooter();
                ui.removeMapFromPrefooter();
                ui.loadDemoCssFile('02');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_7_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_7_hdpi_v01.png',
                    null,
                    null,
                    164,
                    50
                );

//                var newStyleConfig = {
//                    invert_lightness: '0',
//                    marker: 'standard',
//                    marker_icon: '',
//                    type: 'rich',
//                    color: '#006652',
//                    color_hue: '#006652',
//                    color_saturation: '100',
//                    color_lightness: '-60'
//                };
//
//                ui.changeMapStyle(newStyleConfig);

                ui.replaceGoogleFonts({
                    'google_font_google_Open+Sans:300-css': 'http://fonts.googleapis.com/css?family=Open+Sans:300',
                    'google_font_google_Open+Sans-css': 'http://fonts.googleapis.com/css?family=Open+Sans'
                });
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-6/' + '?demo=2'
        },
        {
            'name': '03',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-square',
                    'g1-tr-square',
                    'g1-bl-square',
                    'g1-br-square',

                    // preheader
                    'g1-preheader-open-expanded',
                    'g1-preheader-layout-semi-narrow',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-position-static',
                    'g1-header-layout-wide-semi',
                    'g1-header-comp-left-right',
                    'g1-primary-nav--solid',
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',

                    // precontent
                    'g1-precontent-layout-semi-narrow',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-semi-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-semi-narrow',
                    'g1-prefooter-tl-square',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',

                    // footer
                    'g1-footer-layout-semi-narrow',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-02'
                ];

                ui.setPrimaryNavClass('g1-nav--solid');

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                //ui.removePreheader();
                ui.removeTwitterFromPrefooter();
                //ui.removeMapFromPrefooter();
                ui.loadDemoCssFile('03');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_7_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_7_hdpi_v01.png',
                    null,
                    null,
                    164,
                    50
                );

//                var newStyleConfig = {
//                    invert_lightness: '0',
//                    marker: 'standard',
//                    marker_icon: '',
//                    type: 'rich',
//                    color: '#006652',
//                    color_hue: '#006652',
//                    color_saturation: '100',
//                    color_lightness: '-60'
//                };
//
//                ui.changeMapStyle(newStyleConfig);

                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-5/' + '?demo=3'
        },
        {
            'name': '04',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-squircle',
                    'g1-tr-squircle',
                    'g1-bl-squircle',
                    'g1-br-squircle',

                    // preheader
                    'g1-preheader-open-expanded',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-position-fixed',
                    'g1-header-layout-wide-wide',
                    'g1-header-comp-left-right',
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',
                    'g1-header-search-form-none',

                    // precontent
                    'g1-precontent-layout-wide-narrow',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-wide-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-wide-narrow',
                    'g1-prefooter-tl-square',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',

                    // footer
                    'g1-footer-layout-wide-wide',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-02'
                ];

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                ui.removePreheader();
                ui.removeTwitterFromPrefooter();
                ui.loadDemoCssFile('04');

                ui.replaceGoogleFonts({
                    g1_google_font_1:'http://fonts.googleapis.com/css?family=Varela+Round',
                    g1_google_font_2:'http://fonts.googleapis.com/css?family=Open+Sans'
                });

                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_13_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_13_hdpi_v01.png',
                    null,
                    null,
                    250,
                    30
                );

                var newStyleConfig = {
                            invert_lightness: '0',
                            marker: 'standard',
                            marker_icon: '',
                    type: 'rich',
                            color: '#006652',
                            color_hue: '#006652',
                            color_saturation: '100',
                            color_lightness: '-60'
                };

                ui.changeMapStyle(newStyleConfig);
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/' + '?demo=4'
        },
        {
            'name': '05',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tr-square',
                    'g1-bl-square',
                    'g1-tl-circle',
                    'g1-br-circle',

                    // preheader
                    'g1-preheader-space-before',
                    'g1-preheader-open-expanded',
                    'g1-preheader-layout-semi-narrow',
                    'g1-preheader-tr-square',
                    'g1-preheader-tl-circle',

                    // header
                    'g1-header-space-after',
                    'g1-header-position-static',
                    'g1-header-layout-semi-narrow',
                    'g1-header-comp-right-left',
                    'g1-primary-nav--unstyled',
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-circle',
                    'g1-header-search-form-none',

                    // precontent
                    'g1-precontent-layout-wide-standard',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-wide-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-semi-narrow',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-tl-circle',
                    'g1-prefooter-br-circle',


                    // footer
                    'g1-footer-layout-semi-narrow',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-03'
                ];

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                ui.removeTwitterFromPrefooter();
                ui.removeMapFromPrefooter();
                ui.loadDemoCssFile('05');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_25_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_25_hdpi_v01.png',
                    null,
                    null,
                    170,
                    50
                );

                var newStyleConfig = {
                    invert_lightness: '0',
                    marker: 'standard',
                    marker_icon: '',
                    type: 'rich',
                    color: '#006652',
                    color_hue: '#006652',
                    color_saturation: '100',
                    color_lightness: '-60'
                };

                ui.changeMapStyle(newStyleConfig);
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-5/' + '?demo=5'
        },
        {
            'name': '06',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-squircle',
                    'g1-tr-squircle',
                    'g1-bl-squircle',
                    'g1-br-squircle',

                    // preheader
                    'g1-preheader-open-overlay',
                    'g1-preheader-layout-wide-wide',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-position-fixed',
                    'g1-header-layout-wide-wide',
                    'g1-header-comp-left-right',
                    'g1-primary-nav--simple',
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',
                    'g1-header-search-form-standard',

                    // precontent
                    'g1-precontent-layout-wide-narrow',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-wide-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-wide-narrow',
                    'g1-prefooter-tl-square',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',

                    // footer
                    'g1-footer-space-after',
                    'g1-footer-layout-wide-narrow',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-01'
                ];

                ui.setPrimaryNavClass('g1-nav--simple');

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                ui.removePreheader();
                ui.loadDemoCssFile('06');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_24_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_24_hdpi_v01.png',
                    null,
                    null,
                    180,
                    40
                );

                var newStyleConfig = {
                    //invert_lightness: '0',
                    //marker: 'standard',
                    marker_icon: ''
                    //type: 'rich',
                    //color: '#8080802',
                    //color_hue: '#808080',
                    //color_saturation: '100',
                    //color_lightness: '-50'
                };
                ui.changeMapStyle(newStyleConfig);
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-3/' + '?demo=6'
        },
        {
            'name': '07',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-squircle',
                    'g1-tr-squircle',
                    'g1-bl-squircle',
                    'g1-br-squircle',

                    // preheader
                    'g1-preheader-open-overlay',
                    'g1-preheader-layout-wide-narrow',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-space-after',
                    'g1-header-position-static',
                    'g1-header-layout-wide-narrow',
                    'g1-header-comp-left-right',
                    'g1-primary-nav--simple',,
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',
                    'g1-header-search-form-none',

                    // precontent
                    'g1-precontent-layout-semi-narrow',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',
                    'g1-precontent-tl-squircle',
                    'g1-precontent-tr-squircle',

                    // content
                    'g1-content-space-after',
                    'g1-content-layout-semi-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-squircle',
                    'g1-content-br-squircle',

                    // prefooter
                    'g1-prefooter-layout-semi-narrow',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',
                    'g1-prefooter-tl-squircle',
                    'g1-prefooter-tr-squircle',

                    // footer
                    'g1-footer-space-after',
                    'g1-footer-layout-semi-narrow',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-squircle',
                    'g1-footer-br-squircle',
                    'g1-footer-comp-01'
                ];

                ui.replaceGoogleFonts({
                    g1_google_font_1:'http://fonts.googleapis.com/css?family=Lato'
                });

                ui.moveSearchFromHeaderToPreheader();

                ui.setPrimaryNavClass('g1-nav--simple');

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                ui.removeTwitterFromPrefooter();
                ui.removeMapFromPrefooter();
                ui.loadDemoCssFile('07');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_13_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_13_hdpi_v01.png',
                    null,
                    null,
                    250,
                    30
                );

//                var newStyleConfig = {
//                    invert_lightness: '0',
//                    marker: 'standard',
//                    marker_icon: '',
//                    type: 'rich',
//                    color: '#808080',
//                    color_hue: '#808080',
//                    color_saturation: '100',
//                    color_lightness: '-50'
//                };
//
//                ui.changeMapStyle(newStyleConfig);
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-4/' + '?demo=8'
        },
        {
            'name': '08',
            'func': function () {
                var demoBodyClasses = [
                    // fonts
                    'g1-font-regular-m',
                    'g1-font-important-m',

                    // ui
                    'g1-tl-circle',
                    'g1-tr-circle',
                    'g1-bl-circle',
                    'g1-br-circle',

                    // preheader
                    'g1-preheader-open-expanded',
                    'g1-preheader-layout-wide-narrow',
                    'g1-preheader-tl-square',
                    'g1-preheader-tr-square',
                    'g1-preheader-bl-square',
                    'g1-preheader-br-square',

                    // header
                    'g1-header-position-static',
                    'g1-header-layout-wide-narrow',
                    'g1-header-comp-left-right',
                    'g1-header-tl-square',
                    'g1-header-tr-square',
                    'g1-header-bl-square',
                    'g1-header-br-square',
                    'g1-header-search-form-none',

                    // precontent
                    'g1-precontent-layout-wide-narrow',
                    'g1-precontent-tl-square',
                    'g1-precontent-tr-square',
                    'g1-precontent-bl-square',
                    'g1-precontent-br-square',

                    // content
                    'g1-content-layout-wide-narrow',
                    'g1-content-tl-square',
                    'g1-content-tr-square',
                    'g1-content-bl-square',
                    'g1-content-br-square',

                    // prefooter
                    'g1-prefooter-layout-wide-narrow',
                    'g1-prefooter-tl-square',
                    'g1-prefooter-tr-square',
                    'g1-prefooter-bl-square',
                    'g1-prefooter-br-square',

                    // footer
                    'g1-footer-layout-wide-narrow',
                    'g1-footer-tl-square',
                    'g1-footer-tr-square',
                    'g1-footer-bl-square',
                    'g1-footer-br-square',
                    'g1-footer-comp-02'
                ];

                ui.replaceGoogleFonts({
                    g1_google_font_1:'http://fonts.googleapis.com/css?family=Varela+Round',
                    g1_google_font_2:'http://fonts.googleapis.com/css?family=Open+Sans'
                });

                ui.moveSearchFromHeaderToPreheader();

                ui.setPrimaryNavClass('g1-nav--unstyled');

                ui.replaceBaseDemoBodyClassesWithClasses(demoBodyClasses);
                ui.removeTwitterFromPrefooter();
                ui.removeMapFromPrefooter();
                ui.loadDemoCssFile('08');
                ui.changeLogo(
                    '/wp-content/uploads/2013/06/theme_logo_25_v01.png',
                    '/wp-content/uploads/2013/06/theme_logo_25_hdpi_v01.png',
                    null,
                    null,
                    170,
                    50
                );

//                var newStyleConfig = {
//                    invert_lightness: '0',
//                    marker: 'standard',
//                    marker_icon: '',
//                    type: 'rich',
//                    color: '#006652',
//                    color_hue: '#006652',
//                    color_saturation: '100',
//                    color_lightness: '-60'
//                };
//
//                ui.changeMapStyle(newStyleConfig);
                ui.removeDemoPageLoader();
            },
            'link': baseUrl + '/home/home-6/' + '?demo=9'
        }
    ];

    G1.theme.loadDemoSwitcher = function() {
        addLangSelector();
        handleShopRequests();

        var $container = $('<div>').attr('id', 'g1-demo-container');
        $container.addClass('g1-on');

        var $closeButton = $('<a>').attr('id', 'g1-demo-toggle').text('on/off');
        $closeButton.appendTo($container);

        $closeButton.click(function(e) {
            e.preventDefault();
            $container.toggleClass('g1-on g1-off');
            createCookie('g1_demo_switcher_state', $container.hasClass('g1-off') ? 'off' : 'on');
        });

        var $intro = $('<div>').attr('id', 'g1-demo-intro');
        $intro.append('<p>Choose From</p>');
        $intro.append('<strong>8 Built-in Demos</strong>');
        $intro.append('<p>or <a id="g1-demo-create" href="#">create your own</a>.</p>');
        $intro.appendTo($container);

        var $demoSelector = $('<div>').attr('id', 'g1-demo-selector');
        $demoSelector.appendTo($container);

        var $selectedDemoNumber = $('<div>').attr('id', 'g1-selected-demo-number');
        $selectedDemoNumber.appendTo($demoSelector);

        var $demoList = $('<div>').attr('id', 'g1-demo-list');
        $demoList.appendTo($demoSelector);

        var $selectedDemoDesc = $('<p>').attr('id', 'g1-selected-demo-desc');
        $selectedDemoDesc.appendTo($demoSelector);

        var $demoListSwitch = $('<a>').addClass('g1-switch');

        $demoListSwitch.appendTo($demoList);

        var $demoItems = $('<ul>');

        for (var i = 0; i <  demos.length; i += 1) {
            var demo = demos[i];
            var $demoButton = $('<li data-g1-value="'+ i +'">').html('<a href="#">'+ demo.name +'</a>');
            $demoButton.appendTo($demoItems);
        }

        $demoList.append($('<div>').append($demoItems));


        $demoItems.children('li').click(function(e) {
            e.preventDefault();

            var index = $(this).attr('data-g1-value');
            var demo = demos[index];

            createCookie('g1_demo', index);

            if (typeof demo.link !== 'undefined') {
                var link = demo.link;

                window.location.href = link;
            } else {
                window.location.reload();
            }
        });

        var $prevNextWrapper = $('<ul>').attr('id', 'g1-demo-next-prev');
        var $prev = $('<a>').text('prev').attr('id', 'g1-demo-prev');
        var $next = $('<a>').text('next').attr('id', 'g1-demo-next');
        $prevNextWrapper
            .append($('<li>').append($prev))
            .append($('<li>').append($next));
        $prevNextWrapper.appendTo($container);

        $prev.click(function(e) {
            e.preventDefault();

            var demoIndex = readCookie('g1_demo') || 0;
            demoIndex--;

            if (typeof demos[demoIndex] === 'undefined') {
                demoIndex = demos.length - 1;
            }

            $demoItems.children('li:eq('+ demoIndex +')').trigger('click');
        });

        $next.click(function(e) {
            e.preventDefault();

            var demoIndex = readCookie('g1_demo') || 0;
            demoIndex++;

            if (typeof demos[demoIndex] === 'undefined') {
                demoIndex = 0;
            }

            $demoItems.children('li:eq('+ demoIndex +')').trigger('click');
        });

        $container.prependTo('body');

        var demoIndex = readCookie('g1_demo');
        var demoSwitcherState = readCookie('g1_demo_switcher_state');

        var demoModeDisabled = readCookie('g1_dont_use_js');

        if ( demoModeDisabled === null ) {
            if (demoIndex !== null) {
                selectDemo(demoIndex);
            } else {
                createCookie('g1_demo', 0);
                selectDemo(0);
            }
        } else {
            ui.removeDemoPageLoader();
        }

        if (demoSwitcherState !== null) {
            if (demoSwitcherState === 'off') {
                $closeButton.trigger('click');
            }
        } else {
            if (G1.isPhone) {
                $closeButton.trigger('click');
            }
        }
    };

    /* ==============
     * UI helpers
     ============== */
    var ui = {};

    ui.replaceBaseDemoBodyClassesWithClasses = function (classes) {
        var currentClasses = $('body').prop('class');
        var parts = currentClasses.split(' ');
        var out = [];

        // remove all classes related to theme
        for (var i = 0; i < parts.length; i += 1) {


            if ($.inArray(parts[i], themeBodyClasses) === -1) {
                out.push(parts[i]);
            }
        }

        // merge with demo related classes
        out = out.concat(classes);

        $('body').attr('class', out.join(' '));
    };

    ui.replaceGoogleFonts = function ( newFonts ) {
        var out = '';

        for (var id in newFonts) {
            if (newFonts.hasOwnProperty(id)) {
                var fontHref = newFonts[id];

                out += '<link rel="stylesheet" id="'+ id +'" href="'+ fontHref +'" media="all" />';
            }
        }

        $('link#google_font_490ee25e-css').remove();
        $('link#google_font_7b2b4c23-css').replaceWith(out);
    };

    ui.moveSearchFromHeaderToPreheader = function(){
        $('#g1-primary-nav .g1-searchbox').insertAfter('#g1-secondary-nav');
    };

    ui.setPrimaryNavClass = function( classname ) {
        $('#g1-primary-nav').removeClass('g1-nav--unstyled g1-nav--simple g1-nav--solid').addClass( classname );
    };

    ui.removeDemoPageLoader = function() {
        setTimeout(function(){
            $('#g1-demo-page-loader').remove();
        }, 500);
    };

    ui.removeSearchFromPreheader = function () {
        $('#g1-preheader .g1-searchform').remove();
    };

    ui.removeSearchFromHeader = function () {
        $('#g1-header .g1-searchform').remove();
    };

    ui.removePreheader = function () {
        $('#g1-preheader').remove();
    };

    ui.removeSocialIconsFromPreheader = function () {
        $('#g1-preheader .g1-social-icons').remove();
    };

    ui.removeTwitterFromPrefooter = function () {
        $('#g1-prefooter .g1-twitter-toolbar').remove();
    };

    ui.removeMapFromPrefooter = function () {
        $('#g1-prefooter .g1-gmap-wrapper').remove();
    };

    ui.removeTagline = function () {
        $('#g1-id .site-description').remove();
    };

    ui.removePrefooter = function () {
        $('#g1-prefooter').remove();
    };

    ui.loadDemoCssFile = function (skinName) {
        var basePath = $('head').find('#g1_screen-css').attr('href').replace(/g1-screen\.css.*$/, '');
        var skinPath = basePath + 'demos/' + skinName + '.css';

        $('link#g1_dynamic_style-css').replaceWith("<link rel='stylesheet' id='g1_demo_style-css'  href='" + skinPath + "' type='text/css' media='screen' />");

    };

    ui.changeLogo = function ( desktopPath, desktopHdpiPath, mobilePath, mobileHdpiPath, width, height, widthMobile, heightMobile ) {
        var $logo = $('#g1-logo');
        var $logoMobile = $('#g1-mobile-logo');

        // config
        mobileHdpiPath = mobileHdpiPath || mobilePath || desktopHdpiPath || desktopPath;
        mobilePath = mobilePath || desktopPath;
        desktopHdpiPath = desktopHdpiPath || desktopPath;

        width = width || null;
        height = height || null;
        widthMobile = widthMobile || null;
        heightMobile = heightMobile || null;

        // desktop
        $logo.attr('data-g1-src-desktop', desktopPath);
        $logo.attr('data-g1-src-desktop-hdpi', desktopHdpiPath);

        if ( width && height ) {
            $logo.attr('width', width);
            $logo.attr('height', height);
        }

        // mobile
        $logoMobile.attr('data-g1-src-mobile', mobilePath);
        $logoMobile.attr('data-g1-src-mobile-hdpi', mobileHdpiPath);

        if ( widthMobile && heightMobile ) {
            $logoMobile.attr('width', widthMobile);
            $logoMobile.attr('height', heightMobile);
        } else if ( width && height ) {
            $logoMobile.attr('width', width);
            $logoMobile.attr('height', height);
        }
    };

    ui.changeMapStyle = function (newStyleConfig) {
        /*
        ----------
        properties
        ----------
        newStyleConfig = {
            invert_lightness: '1',
            marker: 'standard',
            marker_icon: '',
            color: '#1e73be',
            color_hue: '#1e73be',
            color_saturation: '45.454545454545',
            color_lightness: '-13.725490196078'
        };
        */

        $('.g1-gmap').each(function () {
            var $this = $(this);
            var oldStyleConfig = $this.metadata({ type: 'attr', name: 'data-g1-gmap-config' });

            newStyleConfig = $.extend(oldStyleConfig, newStyleConfig);

            $this.attr('data-g1-gmap-config', JSON.stringify(newStyleConfig));
        });
    };

    /* ==============
     * DEMO helpers
     ============== */
    function selectDemo (index) {
        var $demoItems = $('#g1-demo-container #g1-demo-list ul li');

        $demoItems.removeClass('g1-selected');
        $demoItems.eq(index).addClass('g1-selected');

        var strPad = function(i,l,s) {
            var o = i.toString();
            if (!s) { s = '0'; }
            while (o.length < l) {
                o = s + o;
            }
            return o;
        };

        var demoNumber = strPad((parseInt(index,10) + 1), 2, '0');
        var demoDesc = typeof demos[index].desc !== 'undefined' ? demos[index].desc : null;

        $('#g1-demo-container').find('#g1-selected-demo-number').text(demoNumber);

        if (demoDesc) {
            $('#g1-demo-container').find('#g1-selected-demo-desc').html(demoDesc);
        }

        (demos[index].func)();
    }

    function createCookie (name,value,hours) {
        var expires;
        hours = hours || 1;

        if (hours) {
            var date = new Date();
            date.setTime(date.getTime() + (hours*60*60*1000));
            expires = '; expires=' + date.toGMTString();
        }
        else {
            expires = '';
        }

        document.cookie = name + '=' + value + expires + '; path=/';
    }

    function readCookie (name) {
        var nameEQ = name + '=';
        var ca = document.cookie.split(';');

        for(var i = 0; i < ca.length; i += 1) {
            var c = ca[i];
            while (c.charAt(0) === ' ') {
                c = c.substring(1,c.length);
            }

            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length,c.length);
            }
        }

        return null;
    }

    function handleShopRequests () {
        var useShop = readCookie('g1_use_shop');

        if ( useShop !== null ) {
            return;
        }

        // prevents ajax request on product list
        $('article.product').on('click', '.add_to_cart_button', function (e) {
            e.stopImmediatePropagation(); // stops other handlers from firing

            var $this = $(this);
            var $viewCartLink = $('<a title="View Cart →" class="added_to_cart" href="/cart/">View Cart →</a>');

            if ( $this.next('.added_to_cart').length === 0 ) {
                $this.after($viewCartLink);
            }

            return false; // equals to e.stopPropagation() and e.preventDefault()
        });

        // prevents ajax request on single product page
        $('form.cart').on('submit', function (e) {
            e.stopImmediatePropagation();

            var productName = $('#content h1.product_title').text();
            var $message = '<div class="woocommerce-message"><a class="button" href="/cart/">View Cart →</a> "'+ productName +'" was successfully added to your cart.</div>';

            if ( $('#content').find('.woocommerce-message').length === 0 ) {
                $('#content').prepend($message);
            }

            return false;
        });

        // prevents all submits on woocommerce forms (cart table)
        $('.woocommerce form').on('submit', function(e) {
            e.stopImmediatePropagation();

            alert('Function disabled in demo version');

            return false;
        });

        // redirects from cart table to checkout page (Checkout button - other buttons on this form are disabled)
        $('.woocommerce form').on('click', 'input.checkout-button', function() {
            window.location.href = '/checkout/';

            return false;
        });

        // prevents remove action
        $('.woocommerce form').on('click', 'a.remove', function(e) {
            e.stopImmediatePropagation();

            alert('Function disabled in demo version');

            return false;
        });

        // Event for updating the checkout
        $('body').bind('update_checkout', function(e) {
            e.stopImmediatePropagation();

            return false;
        });
    }

    function addLangSelector() {
        var markup = '<div id="lang_sel">\
            <ul>\
                <li><a class="lang_sel_sel icl-en" href="#" onclick="return false;">\
                    <img title="English" alt="en" src="/wp-content/themes/3clicks/images/flags/en.png" class="iclflag">&nbsp;<span class="icl_lang_sel_current">English</span></a>\
                    <ul>\
                        <li class="icl-pl">\
                            <a href="http://wpml.org" class="g1-new-window">\
                                    <span class="icl_lang_sel_native">WPML Widget Demo</span> <span class="icl_lang_sel_translated"><span class="icl_lang_sel_native">(</span>WPML Widget Demo<span class="icl_lang_sel_native">)</span></span>\
                            </a>\
                        </li>\
                        <li class="icl-pl">\
                            <a href="#" onclick="return false;" hreflang="es" rel="alternate">\
                                <img title="Spanish" alt="de" src="/wp-content/themes/3clicks/images/flags/es.png" class="iclflag">&nbsp;\
                                    <span class="icl_lang_sel_native">Spanish</span> <span class="icl_lang_sel_translated"><span class="icl_lang_sel_native">(</span>Spanish<span class="icl_lang_sel_native">)</span></span>\
                            </a>\
                        </li>\
                        <li class="icl-pl">\
                            <a href="#" onclick="return false;" hreflang="fr" rel="alternate">\
                                <img title="French" alt="de" src="/wp-content/themes/3clicks/images/flags/fr.png" class="iclflag">&nbsp;\
                                    <span class="icl_lang_sel_native">French</span> <span class="icl_lang_sel_translated"><span class="icl_lang_sel_native">(</span>French<span class="icl_lang_sel_native">)</span></span>\
                            </a>\
                        </li>\
                        <li class="icl-pl">\
                            <a href="#" onclick="return false;" hreflang="de" rel="alternate">\
                                <img title="German" alt="de" src="/wp-content/themes/3clicks/images/flags/de.png" class="iclflag">&nbsp;\
                                    <span class="icl_lang_sel_native">German</span> <span class="icl_lang_sel_translated"><span class="icl_lang_sel_native">(</span>German<span class="icl_lang_sel_native">)</span></span>\
                            </a>\
                        </li>\
                        <li class="icl-pl">\
                            <a href="#" onclick="return false;" hreflang="ru" rel="alternate">\
                                <img title="Russian" alt="de" src="/wp-content/themes/3clicks/images/flags/ru.png" class="iclflag">&nbsp;\
                                    <span class="icl_lang_sel_native">Russian</span> <span class="icl_lang_sel_translated"><span class="icl_lang_sel_native">(</span>Russian<span class="icl_lang_sel_native">)</span></span>\
                            </a>\
                        </li>\
                    </ul>\
                </li>\
            </ul>\
        </div>';

        var $lang = $(markup);

        $('#g1-preheader-bar').append($lang);
    }
})(jQuery);