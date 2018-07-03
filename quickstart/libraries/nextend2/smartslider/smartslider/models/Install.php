<?php


class N2SmartsliderInstallModel extends N2Model {

    private static $sql = array(
        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_generators` (
          `id`     INT(11)      NOT NULL AUTO_INCREMENT,
          `group`  VARCHAR(254) NOT NULL,
          `type`   VARCHAR(254) NOT NULL,
          `params` TEXT         NOT NULL,
          PRIMARY KEY (`id`)
        ) DEFAULT CHARSET = utf8;",

        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_sliders` (
          `id`     INT(11)      NOT NULL AUTO_INCREMENT,
          `alias`  VARCHAR(255) NULL DEFAULT NULL,
          `title`  VARCHAR(100) NOT NULL,
          `type`   VARCHAR(30)  NOT NULL,
          `params` MEDIUMTEXT   NOT NULL,
          `time`   DATETIME     NOT NULL,
          `thumbnail` VARCHAR( 255 ) NOT NULL,
          `ordering` INT NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`)
        ) DEFAULT CHARSET = utf8;",

        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_sliders_xref` (
          `group_id` int(11) NOT NULL,
          `slider_id` int(11) NOT NULL,
          `ordering` int(11) NOT NULL DEFAULT '0',
          PRIMARY KEY (`group_id`,`slider_id`)
        ) DEFAULT CHARSET = utf8;",

        "CREATE TABLE IF NOT EXISTS `#__nextend2_smartslider3_slides` (
          `id`           INT(11)      NOT NULL AUTO_INCREMENT,
          `title`        VARCHAR(200) NOT NULL,
          `slider`       INT(11)      NOT NULL,
          `publish_up`   DATETIME     NOT NULL,
          `publish_down` DATETIME     NOT NULL,
          `published`    TINYINT(1)   NOT NULL,
          `first`        INT(11)      NOT NULL,
          `slide`        LONGTEXT,
          `description`  TEXT         NOT NULL,
          `thumbnail`    VARCHAR(255) NOT NULL,
          `params`       TEXT         NOT NULL,
          `ordering`     INT(11)      NOT NULL,
          `generator_id` INT(11)      NOT NULL,
          PRIMARY KEY (`id`)
        ) DEFAULT CHARSET = utf8;",

        "UPDATE `#__nextend2_section_storage` SET `value` = 1 WHERE `application` LIKE 'smartslider' AND `section` LIKE 'sliderChanged';"

    );

    public function install() {
        foreach (self::$sql AS $query) {
            $this->db->query($this->db->parsePrefix($query));
        }

        if (!$this->hasColumn('#__nextend2_smartslider3_sliders', 'thumbnail')) {
            $this->db->query($this->db->parsePrefix("ALTER TABLE `#__nextend2_smartslider3_sliders` ADD `thumbnail` VARCHAR( 255 ) NOT NULL"));
        }

        if (!$this->hasColumn('#__nextend2_smartslider3_sliders', 'ordering')) {
            $this->db->query($this->db->parsePrefix("ALTER TABLE `#__nextend2_smartslider3_sliders` ADD `ordering` INT NOT NULL DEFAULT '0'"));
        }

	    if (!$this->hasColumn('#__nextend2_smartslider3_sliders', 'alias')) {
		    $this->db->query($this->db->parsePrefix("ALTER TABLE `#__nextend2_smartslider3_sliders` ADD `alias` VARCHAR( 255 ) NULL DEFAULT NULL"));
	    }

        N2Loader::import('install', 'smartslider.platform');

        $sliders = $this->db->queryAll($this->db->parsePrefix('SELECT * FROM #__nextend2_smartslider3_sliders LIMIT 1'));
        if (empty($sliders)) {

            $sampleSlider = array(
                'INSERT INTO `#__nextend2_smartslider3_sliders` (`id`, `title`, `type`, `params`, `time`, `thumbnail`, `ordering`) VALUES (1, \'Sample Slider\', \'simple\', \'{"controlsScroll":"0","controlsDrag":"1","controlsTouch":"horizontal","controlsKeyboard":"1","controlsTilt":"0","thumbnail":"","align":"normal","backgroundMode":"fill","animation":"horizontal","animation-duration":"600","animation-delay":"0","animation-easing":"easeOutQuad","animation-parallax-overlap":"0","background-animation":"","background-animation-speed":"normal","animation-shifted-background-animation":"auto","kenburns-animation":"50|*|50|*|","kenburns-animation-speed":"default","kenburns-animation-strength":"default","carousel":"1","background":"","background-fixed":"0","background-size":"cover","backgroundVideoMp4":"","backgroundVideoMuted":"1","backgroundVideoLoop":"1","backgroundVideoMode":"fill","dynamic-height":"0","loop-single-slide":"0","padding":"0|*|0|*|0|*|0","border-width":"0","border-color":"3E3E3Eff","border-radius":"0","slider-preset":"","slider-css":"","slide-css":"","width":"1200","height":"600","desktop-portrait-minimum-font-size":"1","desktop-landscape":"0","desktop-landscape-width":"1440","desktop-landscape-height":"0","desktop-landscape-minimum-font-size":"1","fontsize":"16","desktop":"1","tablet":"1","mobile":"1","margin":"0|*|0|*|0|*|0","tablet-portrait":"0","tablet-portrait-width":"800","tablet-portrait-height":"0","tablet-portrait-minimum-font-size":"1","tablet-landscape":"0","tablet-landscape-width":"1024","tablet-landscape-height":"0","tablet-landscape-minimum-font-size":"1","mobile-portrait":"0","mobile-portrait-width":"440","mobile-portrait-height":"0","mobile-portrait-minimum-font-size":"1","mobile-landscape":"0","mobile-landscape-width":"740","mobile-landscape-height":"0","mobile-landscape-minimum-font-size":"1","responsive-mode":"auto","responsiveScaleDown":"1","responsiveScaleUp":"1","responsiveSliderHeightMin":"0","responsiveSliderHeightMax":"3000","responsiveSlideWidthMax":"3000","autoplay":"1","autoplayDuration":"8000","autoplayStart":"1","autoplayfinish":"0|*|loop|*|current","autoplayAllowReStart":"0","autoplayStopClick":"1","autoplayStopMouse":"0","autoplayStopMedia":"1","autoplayResumeClick":"0","autoplayResumeMouse":"0","autoplayResumeMedia":"1","playfirstlayer":"1","playonce":"0","layer-animation-play-in":"end","layer-animation-play-mode":"skippable","parallax-enabled":"1","parallax-enabled-mobile":"0","parallax-3d":"0","parallax-animate":"1","parallax-horizontal":"mouse","parallax-vertical":"mouse","parallax-mouse-origin":"slider","parallax-scroll-move":"both","perspective":"1000","imageload":"0","imageloadNeighborSlides":"0","optimize":"0","optimize-quality":"70","optimize-background-image-custom":"0","optimize-background-image-width":"800","optimize-background-image-height":"600","optimizeThumbnailWidth":"100","optimizeThumbnailHeight":"60","layer-image-optimize":"0","layer-image-tablet":"50","layer-image-mobile":"30","layer-image-base64":"0","layer-image-base64-size":"5","playWhenVisible":"1","fadeOnLoad":"1","fadeOnScroll":"0","spinner":"simpleWhite","custom-spinner":"","custom-spinner-width":"100","custom-spinner-height":"100","custom-display":"1","dependency":"","delay":"0","is-delayed":"0","randomize":"0","randomizeFirst":"0","randomize-cache":"1","variations":"5","maximumslidecount":"1000","global-lightbox":"0","global-lightbox-label":"0","maintain-session":"0","blockrightclick":"0","overflow-hidden-page":"0","scroll-fix":"0","bg-parallax-tablet":"1","bg-parallax-mobile":"1","callbacks":"","widgetarrow":"imageEmpty","widget-arrow-display-desktop":"1","widget-arrow-display-tablet":"1","widget-arrow-display-mobile":"1","widget-arrow-exclude-slides":"","widget-arrow-display-hover":"0","widget-arrow-responsive-desktop":"1","widget-arrow-responsive-tablet":"0.7","widget-arrow-responsive-mobile":"0.5","widget-arrow-previous-image":"","widget-arrow-previous":"$ss$\\/plugins\\/widgetarrow\\/image\\/image\\/previous\\/thin-horizontal.svg","widget-arrow-previous-color":"ffffffcc","widget-arrow-previous-hover":"0","widget-arrow-previous-hover-color":"ffffffcc","widget-arrow-style":"","widget-arrow-previous-position-mode":"simple","widget-arrow-previous-position-area":"6","widget-arrow-previous-position-stack":"1","widget-arrow-previous-position-offset":"15","widget-arrow-previous-position-horizontal":"left","widget-arrow-previous-position-horizontal-position":"0","widget-arrow-previous-position-horizontal-unit":"px","widget-arrow-previous-position-vertical":"top","widget-arrow-previous-position-vertical-position":"0","widget-arrow-previous-position-vertical-unit":"px","widget-arrow-next-position-mode":"simple","widget-arrow-next-position-area":"7","widget-arrow-next-position-stack":"1","widget-arrow-next-position-offset":"15","widget-arrow-next-position-horizontal":"left","widget-arrow-next-position-horizontal-position":"0","widget-arrow-next-position-horizontal-unit":"px","widget-arrow-next-position-vertical":"top","widget-arrow-next-position-vertical-position":"0","widget-arrow-next-position-vertical-unit":"px","widget-arrow-animation":"fade","widget-arrow-mirror":"1","widget-arrow-next-image":"","widget-arrow-next":"$ss$\\/plugins\\/widgetarrow\\/image\\/image\\/next\\/thin-horizontal.svg","widget-arrow-next-color":"ffffffcc","widget-arrow-next-hover":"0","widget-arrow-next-hover-color":"ffffffcc","widgetbullet":"transition","widget-bullet-display-desktop":"1","widget-bullet-display-tablet":"1","widget-bullet-display-mobile":"1","widget-bullet-exclude-slides":"","widget-bullet-display-hover":"0","widget-bullet-thumbnail-show-image":"1","widget-bullet-thumbnail-width":"120","widget-bullet-thumbnail-height":"81","widget-bullet-thumbnail-style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwODAiLCJwYWRkaW5nIjoiM3wqfDN8KnwzfCp8M3wqfHB4IiwiYm94c2hhZG93IjoiMHwqfDB8KnwwfCp8MHwqfDAwMDAwMGZmIiwiYm9yZGVyIjoiMHwqfHNvbGlkfCp8MDAwMDAwZmYiLCJib3JkZXJyYWRpdXMiOiIzIiwiZXh0cmEiOiJtYXJnaW46IDVweDsifV19","widget-bullet-thumbnail-side":"before","widget-bullet-position-mode":"simple","widget-bullet-position-area":"12","widget-bullet-position-stack":"1","widget-bullet-position-offset":"10","widget-bullet-position-horizontal":"left","widget-bullet-position-horizontal-position":"0","widget-bullet-position-horizontal-unit":"px","widget-bullet-position-vertical":"top","widget-bullet-position-vertical-position":"0","widget-bullet-position-vertical-unit":"px","widget-bullet-action":"click","widget-bullet-style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwYWIiLCJwYWRkaW5nIjoiNXwqfDV8Knw1fCp8NXwqfHB4IiwiYm94c2hhZG93IjoiMHwqfDB8KnwwfCp8MHwqfDAwMDAwMGZmIiwiYm9yZGVyIjoiMHwqfHNvbGlkfCp8MDAwMDAwZmYiLCJib3JkZXJyYWRpdXMiOiI1MCIsImV4dHJhIjoibWFyZ2luOiA0cHg7In0seyJleHRyYSI6IiIsImJhY2tncm91bmRjb2xvciI6IjA5YjQ3NGZmIn1dfQ==","widget-bullet-bar":"","widget-bullet-bar-full-size":"0","widget-bullet-align":"center","widget-bullet-orientation":"auto","widget-bullet-overlay":"0","widgetautoplay":"disabled","widget-autoplay-display-desktop":"1","widget-autoplay-display-tablet":"1","widget-autoplay-display-mobile":"1","widget-autoplay-exclude-slides":"","widget-autoplay-display-hover":"0","widgetindicator":"disabled","widget-indicator-display-desktop":"1","widget-indicator-display-tablet":"1","widget-indicator-display-mobile":"1","widget-indicator-exclude-slides":"","widget-indicator-display-hover":"0","widgetbar":"disabled","widget-bar-display-desktop":"1","widget-bar-display-tablet":"1","widget-bar-display-mobile":"1","widget-bar-exclude-slides":"","widget-bar-display-hover":"0","widgetthumbnail":"disabled","widget-thumbnail-display-desktop":"1","widget-thumbnail-display-tablet":"1","widget-thumbnail-display-mobile":"1","widget-thumbnail-exclude-slides":"","widget-thumbnail-display-hover":"0","widget-thumbnail-show-image":"1","widget-thumbnail-width":"100","widget-thumbnail-height":"60","widgetshadow":"disabled","widget-shadow-display-desktop":"1","widget-shadow-display-tablet":"1","widget-shadow-display-mobile":"1","widget-shadow-exclude-slides":"","widgetfullscreen":"disabled","widget-fullscreen-display-desktop":"1","widget-fullscreen-display-tablet":"1","widget-fullscreen-display-mobile":"1","widget-fullscreen-exclude-slides":"","widget-fullscreen-display-hover":"0","widgethtml":"disabled","widget-html-display-desktop":"1","widget-html-display-tablet":"1","widget-html-display-mobile":"1","widget-html-exclude-slides":"","widget-html-display-hover":"0","widgets":"arrow"}\', \'2015-11-01 14:14:20\', \'\', 0);',
                'INSERT INTO `#__nextend2_smartslider3_slides` (`id`, `title`, `slider`, `publish_up`, `publish_down`, `published`, `first`, `slide`, `description`, `thumbnail`, `params`, `ordering`, `generator_id`) VALUES
(1, \'Slide One\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"type":"content","animations":"","desktopportraitfontsize":100,"desktopportraitmaxwidth":0,"desktopportraitinneralign":"inherit","desktopportraitpadding":"10|*|10|*|10|*|10|*|px+","desktopportraitselfalign":"inherit","mobileportraitfontsize":60,"opened":1,"id":null,"class":"","crop":"","parallax":0,"adaptivefont":1,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Content","namesynced":1,"bgimage":"","bgimagex":50,"bgimagey":50,"bgimageparallax":0,"bgcolor":"00000000","bgcolorgradient":"off","bgcolorgradientend":"00000000","verticalalign":"center","layers":[{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"10|*|0|*|10|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Martin Dwyer","namesynced":1,"item":{"type":"heading","values":{"heading":"Martin Dwyer","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"0","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxLjUiLCJib2xkIjowLCJpdGFsaWMiOjAsInVuZGVybGluZSI6MCwiYWxpZ24iOiJjZW50ZXIiLCJsZXR0ZXJzcGFjaW5nIjoiMTBweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6InVwcGVyY2FzZSJ9LHsiZXh0cmEiOiIifSx7ImV4dHJhIjoiIn1dfQ==","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJiYWNrZ3JvdW5kY29sb3IiOiJmZmZmZmZjYyIsIm9wYWNpdHkiOjEwMCwicGFkZGluZyI6IjAuNHwqfDF8KnwwLjR8KnwxfCp8ZW0iLCJib3hzaGFkb3ciOiIwfCp8MHwqfDB8KnwwfCp8MDAwMDAwZmYiLCJib3JkZXIiOiIwfCp8c29saWR8KnwwMDAwMDBmZiIsImJvcmRlcnJhZGl1cyI6IjAifSx7ImV4dHJhIjoiIn1dfQ==","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}},{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"0|*|0|*|0|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Application Developer","namesynced":1,"item":{"type":"heading","values":{"heading":"Application Developer","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"1","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}}]}]\', \'\', \'https://smartslider3.com/sample/developerthumbnail.jpg\', \'{"background-type":"image","backgroundVideoMp4":"","backgroundVideoMuted":"1","backgroundVideoLoop":"1","preload":"auto","backgroundVideoMode":"fill","backgroundImage":"https:\\/\\/smartslider3.com\\/sample\\/programmer.jpg","backgroundFocusX":"50","backgroundFocusY":"50","backgroundImageOpacity":"100","backgroundImageBlur":"0","backgroundAlt":"","backgroundTitle":"","backgroundColor":"ffffff00","backgroundGradient":"off","backgroundColorEnd":"ffffff00","backgroundMode":"default","background-animation":"","background-animation-speed":"default","kenburns-animation":"50|*|50|*|","kenburns-animation-speed":"default","kenburns-animation-strength":"default","thumbnailType":"default","link":"|*|_self","guides":"eyJob3Jpem9udGFsIjpbXSwidmVydGljYWwiOltdfQ==","first":"0","static-slide":"0","slide-duration":"0","version":"3.2.0"}\', 0, 0),
(2, \'Slide Two\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"type":"content","animations":"","desktopportraitfontsize":100,"desktopportraitmaxwidth":0,"desktopportraitinneralign":"inherit","desktopportraitpadding":"10|*|10|*|10|*|10|*|px+","desktopportraitselfalign":"inherit","mobileportraitfontsize":60,"opened":1,"id":null,"class":"","crop":"","parallax":0,"adaptivefont":1,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Content","namesynced":1,"bgimage":"","bgimagex":50,"bgimagey":50,"bgimageparallax":0,"bgcolor":"00000000","bgcolorgradient":"off","bgcolorgradientend":"00000000","verticalalign":"center","layers":[{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"10|*|0|*|10|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Rachel Wright","namesynced":1,"item":{"type":"heading","values":{"heading":"Rachel Wright","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"0","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxLjUiLCJib2xkIjowLCJpdGFsaWMiOjAsInVuZGVybGluZSI6MCwiYWxpZ24iOiJjZW50ZXIiLCJsZXR0ZXJzcGFjaW5nIjoiMTBweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6InVwcGVyY2FzZSJ9LHsiZXh0cmEiOiIifSx7ImV4dHJhIjoiIn1dfQ==","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJiYWNrZ3JvdW5kY29sb3IiOiJmZmZmZmZjYyIsIm9wYWNpdHkiOjEwMCwicGFkZGluZyI6IjAuNHwqfDF8KnwwLjR8KnwxfCp8ZW0iLCJib3hzaGFkb3ciOiIwfCp8MHwqfDB8KnwwfCp8MDAwMDAwZmYiLCJib3JkZXIiOiIwfCp8c29saWR8KnwwMDAwMDBmZiIsImJvcmRlcnJhZGl1cyI6IjAifSx7ImV4dHJhIjoiIn1dfQ==","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}},{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"0|*|0|*|0|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Art Director & Photographer","namesynced":1,"item":{"type":"heading","values":{"heading":"Art Director & Photographer","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"1","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}}]}]\', \'\', \'https://smartslider3.com/sample/artdirectorthumbnail.jpg\', \'{"background-type":"image","backgroundVideoMp4":"","backgroundVideoMuted":"1","backgroundVideoLoop":"1","preload":"auto","backgroundVideoMode":"fill","backgroundImage":"https:\\/\\/smartslider3.com\\/sample\\/free1.jpg","backgroundFocusX":"50","backgroundFocusY":"50","backgroundImageOpacity":"100","backgroundImageBlur":"0","backgroundAlt":"","backgroundTitle":"","backgroundColor":"ffffff00","backgroundGradient":"off","backgroundColorEnd":"ffffff00","backgroundMode":"default","background-animation":"","background-animation-speed":"default","kenburns-animation":"50|*|50|*|","kenburns-animation-speed":"default","kenburns-animation-strength":"default","thumbnailType":"default","link":"|*|_self","guides":"eyJob3Jpem9udGFsIjpbXSwidmVydGljYWwiOltdfQ==","first":"0","static-slide":"0","slide-duration":"0","version":"3.2.0"}\', 1, 0),
(3, \'Slide Three\', 1, \'2015-11-01 12:27:34\', \'2025-11-11 12:27:34\', 1, 0, \'[{"type":"content","animations":"","desktopportraitfontsize":100,"desktopportraitmaxwidth":0,"desktopportraitinneralign":"inherit","desktopportraitpadding":"10|*|10|*|10|*|10|*|px+","desktopportraitselfalign":"inherit","mobileportraitfontsize":60,"opened":1,"id":null,"class":"","crop":"","parallax":0,"adaptivefont":1,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Content","namesynced":1,"bgimage":"","bgimagex":50,"bgimagey":50,"bgimageparallax":0,"bgcolor":"00000000","bgcolorgradient":"off","bgcolorgradientend":"00000000","verticalalign":"center","layers":[{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"10|*|0|*|10|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Andrew Butler","namesynced":1,"item":{"type":"heading","values":{"heading":"Andrew Butler","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"0","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6IjBiMGIwYmZmIiwic2l6ZSI6IjM2fHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxLjUiLCJib2xkIjowLCJpdGFsaWMiOjAsInVuZGVybGluZSI6MCwiYWxpZ24iOiJjZW50ZXIiLCJsZXR0ZXJzcGFjaW5nIjoiMTBweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6InVwcGVyY2FzZSJ9LHsiZXh0cmEiOiIifSx7ImV4dHJhIjoiIn1dfQ==","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJiYWNrZ3JvdW5kY29sb3IiOiJmZmZmZmZjYyIsIm9wYWNpdHkiOjEwMCwicGFkZGluZyI6IjAuNHwqfDF8KnwwLjR8KnwxfCp8ZW0iLCJib3hzaGFkb3ciOiIwfCp8MHwqfDB8KnwwfCp8MDAwMDAwZmYiLCJib3JkZXIiOiIwfCp8c29saWR8KnwwMDAwMDBmZiIsImJvcmRlcnJhZGl1cyI6IjAifSx7ImV4dHJhIjoiIn1dfQ==","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}},{"type":"layer","animations":"","desktopportraitfontsize":100,"desktopportraitmargin":"0|*|0|*|0|*|0|*|px+","desktopportraitheight":0,"desktopportraitmaxwidth":0,"desktopportraitselfalign":"inherit","id":null,"class":"","crop":"visible","parallax":0,"adaptivefont":0,"mouseenter":"","click":"","mouseleave":"","play":"","pause":"","stop":"","generatorvisible":"","desktopportrait":1,"desktoplandscape":1,"tabletportrait":1,"tabletlandscape":1,"mobileportrait":1,"mobilelandscape":1,"name":"Photographer & Illustrator","namesynced":1,"item":{"type":"heading","values":{"heading":"Photographer & Illustrator","link":"#|*|_self","priority":"2","fullwidth":"0","nowrap":"0","title":"","font":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siZXh0cmEiOiIiLCJjb2xvciI6ImZmZmZmZmZmIiwic2l6ZSI6IjIyfHxweCIsInRzaGFkb3ciOiIwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImFmb250IjoiUmFsZXdheSxBcmlhbCIsImxpbmVoZWlnaHQiOiIxIiwiYm9sZCI6MCwiaXRhbGljIjowLCJ1bmRlcmxpbmUiOjAsImFsaWduIjoiY2VudGVyIiwibGV0dGVyc3BhY2luZyI6IjJweCIsIndvcmRzcGFjaW5nIjoibm9ybWFsIiwidGV4dHRyYW5zZm9ybSI6Im5vbmUifSx7ImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","style":"eyJuYW1lIjoiU3RhdGljIiwiZGF0YSI6W3siYmFja2dyb3VuZGNvbG9yIjoiMDAwMDAwY2MiLCJwYWRkaW5nIjoiMC44fCp8MXwqfDAuOHwqfDF8KnxlbSIsImJveHNoYWRvdyI6IjB8KnwwfCp8MHwqfDB8KnwwMDAwMDBmZiIsImJvcmRlciI6IjB8Knxzb2xpZHwqfDAwMDAwMGZmIiwiYm9yZGVycmFkaXVzIjoiMCIsImV4dHJhIjoiIn0seyJleHRyYSI6IiJ9XX0=","split-text-animation-in":"","split-text-delay-in":"0","split-text-animation-out":"","split-text-delay-out":"0","split-text-backface-visibility":"1","split-text-transform-origin":"50|*|50|*|0","class":""}}}]}]\', \'\', \'https://smartslider3.com/sample/photographerthumbnail.jpg\', \'{"background-type":"image","backgroundVideoMp4":"","backgroundVideoMuted":"1","backgroundVideoLoop":"1","preload":"auto","backgroundVideoMode":"fill","backgroundImage":"https:\\/\\/smartslider3.com\\/sample\\/photographer.jpg","backgroundFocusX":"50","backgroundFocusY":"50","backgroundImageOpacity":"100","backgroundImageBlur":"0","backgroundAlt":"","backgroundTitle":"","backgroundColor":"ffffff00","backgroundGradient":"off","backgroundColorEnd":"ffffff00","backgroundMode":"default","background-animation":"","background-animation-speed":"default","kenburns-animation":"50|*|50|*|","kenburns-animation-speed":"default","kenburns-animation-strength":"default","thumbnailType":"default","link":"|*|_self","guides":"eyJob3Jpem9udGFsIjpbXSwidmVydGljYWwiOltdfQ==","first":"0","static-slide":"0","slide-duration":"0","version":"3.2.0"}\', 2, 0);'
            );

            foreach ($sampleSlider AS $query) {
                $this->db->query($this->db->parsePrefix($query));
            }
        }

        N2Settings::set('n2_ss3_version', N2SS3::$version);
    }


    private function hasColumn($table, $col) {
        return !!$this->db->queryRow($this->db->parsePrefix("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $col . "'"));
    }
}