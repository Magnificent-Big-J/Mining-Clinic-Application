(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["/js/pod"],{

/***/ "./node_modules/iviewer/jquery.iviewer.js":
/*!************************************************!*\
  !*** ./node_modules/iviewer/jquery.iviewer.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(jQuery) {/*
 * iviewer Widget for jQuery UI
 * https://github.com/can3p/iviewer
 *
 * Copyright (c) 2009 - 2013 Dmitry Petrov
 * Dual licensed under the MIT license.
 *  - http://www.opensource.org/licenses/mit-license.php
 *
 * Author: Dmitry Petrov
 * Version: 0.7.11
 */

( function( $, undefined ) {

//this code was taken from the https://github.com/furf/jquery-ui-touch-punch
var mouseEvents = {
        touchstart: 'mousedown',
        touchmove: 'mousemove',
        touchend: 'mouseup'
    },
    gesturesSupport = 'ongesturestart' in document.createElement('div');


/**
 * Convert a touch event to a mouse-like
 */
function makeMouseEvent (event) {
    var touch = event.originalEvent.changedTouches[0];

    return $.extend(event, {
        type:    mouseEvents[event.type],
        which:   1,
        pageX:   touch.pageX,
        pageY:   touch.pageY,
        screenX: touch.screenX,
        screenY: touch.screenY,
        clientX: touch.clientX,
        clientY: touch.clientY,
        isTouchEvent: true
    });
}

var mouseProto = $.ui.mouse.prototype,
    _mouseInit = $.ui.mouse.prototype._mouseInit;

mouseProto._mouseInit = function() {
    var self = this;
    self._touchActive = false;

    this.element.bind( 'touchstart.' + this.widgetName, function(event) {
        if (gesturesSupport && event.originalEvent.touches.length > 1) { return; }
        self._touchActive = true;
        return self._mouseDown(makeMouseEvent(event));
    });

    // these delegates are required to keep context
    this._mouseMoveDelegate = function(event) {
        if (gesturesSupport && event.originalEvent.touches && event.originalEvent.touches.length > 1) { return; }
        if (self._touchActive) {
            return self._mouseMove(makeMouseEvent(event));
        }
    };
    this._mouseUpDelegate = function(event) {
        if (self._touchActive) {
            self._touchActive = false;
            return self._mouseUp(makeMouseEvent(event));
        }
    };

    $(document)
        .bind('touchmove.'+ this.widgetName, this._mouseMoveDelegate)
        .bind('touchend.' + this.widgetName, this._mouseUpDelegate);

    _mouseInit.apply(this);
};

/**
 * Simple implementation of jQuery like getters/setters
 * var val = something();
 * something(val);
 */
var setter = function(setter, getter) {
    return function(val) {
        if (arguments.length === 0) {
            return getter.apply(this);
        } else {
            setter.apply(this, arguments);
        }
    }
};

/**
 * Internet explorer rotates image relative left top corner, so we should
 * shift image when it's rotated.
 */
var ieTransforms = {
        '0': {
            marginLeft: 0,
            marginTop: 0,
            filter: 'progid:DXImageTransform.Microsoft.Matrix(M11=1, M12=0, M21=0, M22=1, SizingMethod="auto expand")'
        },

        '90': {
            marginLeft: -1,
            marginTop: 1,
            filter: 'progid:DXImageTransform.Microsoft.Matrix(M11=0, M12=-1, M21=1, M22=0, SizingMethod="auto expand")'
        },

        '180': {
            marginLeft: 0,
            marginTop: 0,
            filter: 'progid:DXImageTransform.Microsoft.Matrix(M11=-1, M12=0, M21=0, M22=-1, SizingMethod="auto expand")'
        },

        '270': {
            marginLeft: -1,
            marginTop: 1,
            filter: 'progid:DXImageTransform.Microsoft.Matrix(M11=0, M12=1, M21=-1, M22=0, SizingMethod="auto expand")'
        }
    },
    // this test is the inversion of the css filters test from the modernizr project
    useIeTransforms = function() {
        var modElem = document.createElement('modernizr'),
            mStyle = modElem.style,
            omPrefixes = 'Webkit Moz O ms',
            domPrefixes = omPrefixes.toLowerCase().split(' '),
            props = ("transform" + ' ' + domPrefixes.join("Transform ") + "Transform").split(' ');
        /*using 'for' loop instead of 'for in' to avoid issues in IE8*/
        for ( var i=0; i< props.length;i++ ) {
            var prop = props[i];
            if ( prop.indexOf("-") == -1 && mStyle[prop] !== undefined ) {
                return false;
            }
        }
        return true;
    }();

$.widget( "ui.iviewer", $.ui.mouse, {
    widgetEventPrefix: "iviewer",
    options : {
        /**
        * start zoom value for image, not used now
        * may be equal to "fit" to fit image into container or scale in %
        **/
        zoom: "fit",
        /**
        * base value to scale image
        **/
        zoom_base: 100,
        /**
        * maximum zoom
        **/
        zoom_max: 800,
        /**
        * minimum zoom
        **/
        zoom_min: 25,
        /**
        * base of rate multiplier.
        * zoom is calculated by formula: zoom_base * zoom_delta^rate
        **/
        zoom_delta: 1.4,
        /**
        * whether the zoom should be animated.
        */
        zoom_animation: true,
        /**
        * if true plugin doesn't add its own controls
        **/
        ui_disabled: false,
        /**
         * If false mousewheel will be disabled
         */
        mousewheel: true,
        /**
        * if false, plugin doesn't bind resize event on window and this must
        * be handled manually
        **/
        update_on_resize: true,
        /**
        * whether to provide zoom on doubleclick functionality
        */
        zoom_on_dblclick: true,
        /**
        * if true the image will fill the container and the image will be distorted
        */
        fill_container: false,
        /**
        * event is triggered when zoom value is changed
        * @param int new zoom value
        * @return boolean if false zoom action is aborted
        **/
        onZoom: jQuery.noop,
        /**
        * event is triggered when zoom value is changed after image is set to the new dimensions
        * @param int new zoom value
        * @return boolean if false zoom action is aborted
        **/
        onAfterZoom: jQuery.noop,
        /**
        * event is fired on drag begin
        * @param object coords mouse coordinates on the image
        * @return boolean if false is returned, drag action is aborted
        **/
        onStartDrag: jQuery.noop,
        /**
        * event is fired on drag action
        * @param object coords mouse coordinates on the image
        **/
        onDrag: jQuery.noop,
        /**
        * event is fired on drag stop
        * @param object coords mouse coordinates on the image
        **/
        onStopDrag: jQuery.noop,
        /**
        * event is fired when mouse moves over image
        * @param object coords mouse coordinates on the image
        **/
        onMouseMove: jQuery.noop,
        /**
        * mouse click event
        * @param object coords mouse coordinates on the image
        **/
        onClick: jQuery.noop,
        /**
        * mouse double click event. If used will delay each click event.
        * If double click event was fired, clicks will not.
        *
        * @param object coords mouse coordinates on the image
        **/
        onDblClick: null,
        /**
        * event is fired when image starts to load
        */
        onStartLoad: null,
        /**
        * event is fired, when image is loaded and initially positioned
        */
        onFinishLoad: null,
        /**
        * event is fired when image load error occurs
        */
        onErrorLoad: null
    },

    _create: function() {
        var me = this;

        //drag variables
        this.dx = 0;
        this.dy = 0;

        /* object containing actual information about image
        *   @img_object.object - jquery img object
        *   @img_object.orig_{width|height} - original dimensions
        *   @img_object.display_{width|height} - actual dimensions
        */
        this.img_object = {};

        this.zoom_object = {}; //object to show zoom status

        this._angle = 0;

        this.current_zoom = this.options.zoom;

        if(this.options.src === null){
            return;
        }

        this.container = this.element;

        this._updateContainerInfo();

        //init container
        this.container.css("overflow","hidden");

        if (this.options.update_on_resize == true) {
            $(window).resize(function() {
                me.update();
            });
        }

        this.img_object = new $.ui.iviewer.ImageObject(this.options.zoom_animation);

        if (this.options.mousewheel) {
            this.activateMouseWheel(this.options.mousewheel);
        }

        //bind doubleclick only if callback is not falsy
        var useDblClick = !!this.options.onDblClick || this.options.zoom_on_dblclick,
            dblClickTimer = null,
            clicksNumber = 0;

        //init object
        this.img_object.object()
            .prependTo(this.container);

        //all these tricks are needed to fire either click
        //or doubleclick events at the same time
        if (useDblClick) {
            this.img_object.object()
                //bind mouse events
                .click(function(e){
                    clicksNumber++;
                    clearTimeout(dblClickTimer);

                    dblClickTimer = setTimeout(function() {
                        clicksNumber = 0;
                        me._click(e);
                    }, 300);
                })
                .dblclick(function(e){
                    if (clicksNumber !== 2) return;

                    clearTimeout(dblClickTimer);
                    clicksNumber = 0;
                    me._dblclick(e);
                });
        } else {
            this.img_object.object()
                .click(function(e){ me._click(e); });
        }

        this.container.bind('mousemove.iviewer', function(ev) { me._handleMouseMove(ev); });

        this.loadImage(this.options.src);

        if(!this.options.ui_disabled)
        {
            this.createui();
        }
        this.controls = this.container.find('.iviewer_common') || {};
        this._mouseInit();
    },

    destroy: function() {
        $.Widget.prototype.destroy.call( this );
        this._mouseDestroy();
        this.img_object.object().remove();
        /*removing the controls on destroy*/
        this.controls.remove();
        this.container.off('.iviewer');
        this.container.css('overflow', ''); //cleanup styles on destroy
    },

    _updateContainerInfo: function()
    {
        this.options.height = this.container.height();
        this.options.width = this.container.width();
    },

    /**
     * Add or remove the mousewheel effect on the viewer
     * @param {boolean} isActive
     * Sample : $('#viewer').iviewer('activateMouseWheel', true);
     */
    activateMouseWheel: function(isActive){
        // Remove all the previous event bind on the mousewheel
        this.container.unbind('mousewheel.iviewer');
        if (gesturesSupport) {
            this.img_object.object().unbind('touchstart').unbind('gesturechange.iviewer').unbind('gestureend.iviewer');
        }

        if (isActive) {
            var me = this;

            this.container.bind('mousewheel.iviewer', function(ev, delta)
                {
                    //this event is there instead of containing div, because
                    //at opera it triggers many times on div
                    var zoom = (delta > 0)?1:-1,
                        container_offset = me.container.offset(),
                        mouse_pos = {
                            //jquery.mousewheel 3.1.0 uses strange MozMousePixelScroll event
                            //which is not being fixed by jQuery.Event
                            x: (ev.pageX || ev.originalEvent.pageX) - container_offset.left,
                            y: (ev.pageY || ev.originalEvent.pageX) - container_offset.top
                        };
                    me.zoom_by(zoom, mouse_pos);
                    return false;
                });

            if (gesturesSupport) {
                var gestureThrottle = +new Date();
                var originalScale, originalCenter;
                this.img_object.object()
                    .bind('touchstart', function(ev) {
                        originalScale = me.current_zoom;
                        var touches = ev.originalEvent.touches,
                            container_offset;
                        if (touches.length == 2) {
                            container_offset = me.container.offset();
                            originalCenter = {
                                x: (touches[0].pageX + touches[1].pageX) / 2  - container_offset.left,
                                y: (touches[0].pageY + touches[1].pageY) / 2 - container_offset.top
                            };
                        } else {
                            originalCenter = null;
                        }
                    }).bind('gesturechange.iviewer', function(ev) {
                        //do not want to import throttle function from underscore
                        var d = +new Date();
                        if ((d - gestureThrottle) < 50) { return; }
                        gestureThrottle = d;
                        var zoom = originalScale * ev.originalEvent.scale;
                        me.set_zoom(zoom, originalCenter);
                        ev.preventDefault();
                    }).bind('gestureend.iviewer', function(ev) {
                        originalCenter = null;
                    });
            }
        }
    },

    update: function()
    {
        this._updateContainerInfo();
        this.setCoords(this.img_object.x(), this.img_object.y());
    },

    loadImage: function( src )
    {
        this.current_zoom = this.options.zoom;
        var me = this;

        this._trigger('onStartLoad', 0, src);

        this.container.addClass("iviewer_loading");
        this.img_object.load(src, function() {
            me._fill_orig_dimensions = { width: me.img_object.orig_width(), height: me.img_object.orig_height() };
            me._imageLoaded(src);
        }, function() {
            me._trigger("onErrorLoad", 0, src);
        });
    },

    _imageLoaded: function(src) {
        this.container.removeClass("iviewer_loading");
        this.container.addClass("iviewer_cursor");

        if(this.options.zoom == "fit"){
            this.fit(true);
        }
        else {
            this.set_zoom(this.options.zoom, true);
        }

        this._trigger('onFinishLoad', 0, src);

        if(this.options.fill_container)
        {
          this.fill_container(true);
        }
    },

    /**
    * fits image in the container
    *
    * @param {boolean} skip_animation
    **/
    fit: function(skip_animation)
    {
        var aspect_ratio = this.img_object.orig_width() / this.img_object.orig_height();
        var window_ratio = this.options.width /  this.options.height;
        var choose_left = (aspect_ratio > window_ratio);
        var new_zoom = 0;

        if(choose_left){
            new_zoom = this.options.width / this.img_object.orig_width() * 100;
        }
        else {
            new_zoom = this.options.height / this.img_object.orig_height() * 100;
        }

      this.set_zoom(new_zoom, skip_animation);
    },

    /**
    * center image in container
    **/
    center: function()
    {
        this.setCoords(-Math.round((this.img_object.display_width() - this.options.width)/2),
                -Math.round((this.img_object.display_height() - this.options.height)/2));
    },

    /**
    *   move a point in container to the center of display area
    *   @param x a point in container
    *   @param y a point in container
    **/
    moveTo: function(x, y)
    {
        var dx = x-Math.round(this.options.width/2);
        var dy = y-Math.round(this.options.height/2);

        var new_x = this.img_object.x() - dx;
        var new_y = this.img_object.y() - dy;

        this.setCoords(new_x, new_y);
    },

    /**
     * Get container offset object.
     */
    getContainerOffset: function() {
        return jQuery.extend({}, this.container.offset());
    },

    /**
    * set coordinates of upper left corner of image object
    **/
    setCoords: function(x,y)
    {
        //do nothing while image is being loaded
        if(!this.img_object.loaded()) { return; }

        var coords = this._correctCoords(x,y);
        this.img_object.x(coords.x);
        this.img_object.y(coords.y);
    },

    _correctCoords: function( x, y )
    {
        x = parseInt(x, 10);
        y = parseInt(y, 10);

        //check new coordinates to be correct (to be in rect)
        if(y > 0){
            y = 0;
        }
        if(x > 0){
            x = 0;
        }
        if(y + this.img_object.display_height() < this.options.height){
            y = this.options.height - this.img_object.display_height();
        }
        if(x + this.img_object.display_width() < this.options.width){
            x = this.options.width - this.img_object.display_width();
        }
        if(this.img_object.display_width() <= this.options.width){
            x = -(this.img_object.display_width() - this.options.width)/2;
        }
        if(this.img_object.display_height() <= this.options.height){
            y = -(this.img_object.display_height() - this.options.height)/2;
        }

        return { x: x, y:y };
    },


    /**
    * convert coordinates on the container to the coordinates on the image (in original size)
    *
    * @return object with fields x,y according to coordinates or false
    * if initial coords are not inside image
    **/
    containerToImage : function (x,y)
    {
        var coords = { x : x - this.img_object.x(),
                 y :  y - this.img_object.y()
        };

        coords = this.img_object.toOriginalCoords(coords);

        return { x :  util.descaleValue(coords.x, this.current_zoom),
                 y :  util.descaleValue(coords.y, this.current_zoom)
        };
    },

    /**
    * convert coordinates on the image (in original size, and zero angle) to the coordinates on the container
    *
    * @return object with fields x,y according to coordinates
    **/
    imageToContainer : function (x,y)
    {
        var coords = {
                x : util.scaleValue(x, this.current_zoom),
                y : util.scaleValue(y, this.current_zoom)
            };

        return this.img_object.toRealCoords(coords);
    },

    /**
    * get mouse coordinates on the image
    * @param e - object containing pageX and pageY fields, e.g. mouse event object
    *
    * @return object with fields x,y according to coordinates or false
    * if initial coords are not inside image
    **/
    _getMouseCoords : function(e)
    {
        var containerOffset = this.container.offset(),
            coords = this.containerToImage(e.pageX - containerOffset.left, e.pageY - containerOffset.top);

        return coords;
    },

    /**
    * fills container entirely by distorting image
    *
    * @param {boolean} fill wether to fill the container entirely or not.
    **/
    fill_container: function(fill)
    {
        this.options.fill_container = fill;
        if(fill)
        {
            var ratio = this.options.width / this.options.height;
            if (ratio > 1)
                this.img_object.orig_width(this.img_object.orig_height() * ratio);
            else
                this.img_object.orig_height(this.img_object.orig_width() * ratio);
        }
        else
        {
            this.img_object.orig_width(this._fill_orig_dimensions.width);
            this.img_object.orig_height(this._fill_orig_dimensions.height);
        }
        this.set_zoom(this.current_zoom);
    },

    /**
    * set image scale to the new_zoom
    *
    * @param {number} new_zoom image scale in %
    * @param {boolean} skip_animation
    * @param {x: number, y: number} Coordinates of point the should not be moved on zoom. The default is the center of image.
    **/
    set_zoom: function(new_zoom, skip_animation, zoom_center)
    {
        if (this._trigger('onZoom', 0, new_zoom) == false) {
            return;
        }

        //do nothing while image is being loaded
        if(!this.img_object.loaded()) { return; }

        zoom_center = zoom_center || {
            x: Math.round(this.options.width/2),
            y: Math.round(this.options.height/2)
        };

        if(new_zoom <  this.options.zoom_min)
        {
            new_zoom = this.options.zoom_min;
        }
        else if(new_zoom > this.options.zoom_max)
        {
            new_zoom = this.options.zoom_max;
        }

        /* we fake these values to make fit zoom properly work */
        var old_x, old_y;
        if(this.current_zoom == "fit")
        {
            old_x = zoom_center.x + Math.round(this.img_object.orig_width()/2);
            old_y = zoom_center.y + Math.round(this.img_object.orig_height()/2);
            this.current_zoom = 100;
        }
        else {
            old_x = -this.img_object.x() + zoom_center.x;
            old_y = -this.img_object.y() + zoom_center.y;
        }

        var new_width = util.scaleValue(this.img_object.orig_width(), new_zoom);
        var new_height = util.scaleValue(this.img_object.orig_height(), new_zoom);
        var new_x = util.scaleValue( util.descaleValue(old_x, this.current_zoom), new_zoom);
        var new_y = util.scaleValue( util.descaleValue(old_y, this.current_zoom), new_zoom);

        new_x = zoom_center.x - new_x;
        new_y = zoom_center.y - new_y;

        new_width = Math.floor(new_width);
        new_height = Math.floor(new_height);
        new_x = Math.floor(new_x);
        new_y = Math.floor(new_y);

        this.img_object.display_width(new_width);
        this.img_object.display_height(new_height);

        var coords = this._correctCoords( new_x, new_y ),
            self = this;

        this.img_object.setImageProps(new_width, new_height, coords.x, coords.y,
                                        skip_animation, function() {
            self._trigger('onAfterZoom', 0, new_zoom );
        });
        this.current_zoom = new_zoom;

        this.update_status();
    },
    /**
     * shows or hides the controls
     * controls are shown/hidden based on user input
     * @param Boolean flag that specifies whether to show or hide the controls
     **/
    showControls: function(flag) {
        if(flag) {
            this.controls.fadeIn();
        } else {
            this.controls.fadeOut();
        }
    },
    /**
    * changes zoom scale by delta
    * zoom is calculated by formula: zoom_base * zoom_delta^rate
    * @param Integer delta number to add to the current multiplier rate number
    * @param {x: number, y: number=} Coordinates of point the should not be moved on zoom.
    **/
    zoom_by: function(delta, zoom_center)
    {
        var closest_rate = this.find_closest_zoom_rate(this.current_zoom);

        var next_rate = closest_rate + delta;
        var next_zoom = this.options.zoom_base * Math.pow(this.options.zoom_delta, next_rate);
        if(delta > 0 && next_zoom < this.current_zoom)
        {
            next_zoom *= this.options.zoom_delta;
        }

        if(delta < 0 && next_zoom > this.current_zoom)
        {
            next_zoom /= this.options.zoom_delta;
        }

        this.set_zoom(next_zoom, undefined, zoom_center);
    },

    /**
    * Rotate image
    * @param {num} deg Degrees amount to rotate. Positive values rotate image clockwise.
    *     Currently 0, 90, 180, 270 and -90, -180, -270 values are supported
    *
    * @param {boolean} abs If the flag is true if, the deg parameter will be considered as
    *     a absolute value and relative otherwise.
    * @return {num|null} Method will return current image angle if called without any arguments.
    **/
    angle: function(deg, abs) {
        if (arguments.length === 0) { return this.img_object.angle(); }

        if (deg < -270 || deg > 270 || deg % 90 !== 0) { return; }
        if (!abs) { deg += this.img_object.angle(); }
        if (deg < 0) { deg += 360; }
        if (deg >= 360) { deg -= 360; }

        if (deg === this.img_object.angle()) { return; }

        this.img_object.angle(deg);
        //the rotate behavior is different in all editors. For now we  just center the
        //image. However, it will be better to try to keep the position.
        this.center();
        this._trigger('angle', 0, { angle: this.img_object.angle() });
    },

    /**
    * finds closest multiplier rate for value
    * basing on zoom_base and zoom_delta values from settings
    * @param Number value zoom value to examine
    **/
    find_closest_zoom_rate: function(value)
    {
        if(value == this.options.zoom_base)
        {
            return 0;
        }

        function div(val1,val2) { return val1 / val2; };
        function mul(val1,val2) { return val1 * val2; };

        var func = (value > this.options.zoom_base)?mul:div;
        var sgn = (value > this.options.zoom_base)?1:-1;

        var mltplr = this.options.zoom_delta;
        var rate = 1;

        while(Math.abs(func(this.options.zoom_base, Math.pow(mltplr,rate)) - value) >
              Math.abs(func(this.options.zoom_base, Math.pow(mltplr,rate+1)) - value))
        {
            rate++;
        }

        return sgn * rate;
    },

    /* update scale info in the container */
    update_status: function()
    {
        if(!this.options.ui_disabled)
        {
            var percent = Math.round(100*this.img_object.display_height()/this.img_object.orig_height());
            if(percent)
            {
                this.zoom_object.html(percent + "%");
            }
        }
    },

    /**
     * Get some information about the image.
     *     Currently orig_(width|height), display_(width|height), angle, zoom and src params are supported.
     *
     *  @param {string} parameter to check
     *  @param {boolean} withoutRotation if param is orig_width or orig_height and this flag is set to true,
     *      method will return original image width without considering rotation.
     *
     */
    info: function(param, withoutRotation) {
        if (!param) { return; }

        switch (param) {
            case 'orig_width':
            case 'orig_height':
                if (withoutRotation) {
                    return (this.img_object.angle() % 180 === 0 ? this.img_object[param]() :
                            param === 'orig_width' ? this.img_object.orig_height() :
                                                        this.img_object.orig_width());
                } else {
                    return this.img_object[param]();
                }
            case 'display_width':
            case 'display_height':
            case 'angle':
                return this.img_object[param]();
            case 'zoom':
                return this.current_zoom;
            case 'options':
                return this.options;
            case 'src':
                return this.img_object.object().attr('src');
            case 'coords':
                return {
                    x: this.img_object.x(),
                    y: this.img_object.y()
                };
        }
    },

    /**
    *   callback for handling mousdown event to start dragging image
    **/
    _mouseStart: function( e )
    {
        $.ui.mouse.prototype._mouseStart.call(this, e);
        if (this._trigger('onStartDrag', 0, this._getMouseCoords(e)) === false) {
            return false;
        }

        /* start drag event*/
        this.container.addClass("iviewer_drag_cursor");

        //#10: fix movement quirks for ipad
        this._dragInitialized = !(e.originalEvent.changedTouches && e.originalEvent.changedTouches.length==1);

        this.dx = e.pageX - this.img_object.x();
        this.dy = e.pageY - this.img_object.y();
        return true;
    },

    _mouseCapture: function( e ) {
        return true;
    },

    /**
     * Handle mouse move if needed. User can avoid using this callback, because
     *    he can get the same information through public methods.
     *  @param {jQuery.Event} e
     */
    _handleMouseMove: function(e) {
        this._trigger('onMouseMove', e, this._getMouseCoords(e));
    },

    /**
    *   callback for handling mousemove event to drag image
    **/
    _mouseDrag: function(e)
    {
        $.ui.mouse.prototype._mouseDrag.call(this, e);

        //#10: imitate mouseStart, because we can get here without it on iPad for some reason
        if (!this._dragInitialized) {
            this.dx = e.pageX - this.img_object.x();
            this.dy = e.pageY - this.img_object.y();
            this._dragInitialized = true;
        }

        var ltop =  e.pageY - this.dy;
        var lleft = e.pageX - this.dx;

        this.setCoords(lleft, ltop);
        this._trigger('onDrag', e, this._getMouseCoords(e));
        return false;
    },

    /**
    *   callback for handling stop drag
    **/
    _mouseStop: function(e)
    {
        $.ui.mouse.prototype._mouseStop.call(this, e);
        this.container.removeClass("iviewer_drag_cursor");
        this._trigger('onStopDrag', 0, this._getMouseCoords(e));
    },

    _click: function(e)
    {
        this._trigger('onClick', 0, this._getMouseCoords(e));
    },

    _dblclick: function(ev)
    {
      if (this.options.onDblClick) {
        this._trigger('onDblClick', 0, this._getMouseCoords(ev));
      }

      if (this.options.zoom_on_dblclick) {
        var container_offset = this.container.offset()
          , mouse_pos = {
            x: ev.pageX - container_offset.left,
            y: ev.pageY - container_offset.top
          };

        this.zoom_by(1, mouse_pos);
      }
    },

    /**
    *   create zoom buttons info box
    **/
    createui: function()
    {
        var me=this;

        $("<div>", { 'class': "iviewer_zoom_in iviewer_common iviewer_button"})
                    .bind('mousedown touchstart',function(){me.zoom_by(1); return false;})
                    .appendTo(this.container);

        $("<div>", { 'class': "iviewer_zoom_out iviewer_common iviewer_button"})
                    .bind('mousedown touchstart',function(){me.zoom_by(- 1); return false;})
                    .appendTo(this.container);

        $("<div>", { 'class': "iviewer_zoom_zero iviewer_common iviewer_button"})
                    .bind('mousedown touchstart',function(){me.set_zoom(100); return false;})
                    .appendTo(this.container);

        $("<div>", { 'class': "iviewer_zoom_fit iviewer_common iviewer_button"})
                    .bind('mousedown touchstart',function(){me.fit(this); return false;})
                    .appendTo(this.container);

        this.zoom_object = $("<div>").addClass("iviewer_zoom_status iviewer_common")
                                    .appendTo(this.container);

        $("<div>", { 'class': "iviewer_rotate_left iviewer_common iviewer_button"})
                    .bind('mousedown touchstart',function(){me.angle(-90); return false;})
                    .appendTo(this.container);

        $("<div>", { 'class': "iviewer_rotate_right iviewer_common iviewer_button" })
                    .bind('mousedown touchstart',function(){me.angle(90); return false;})
                    .appendTo(this.container);

        this.update_status(); //initial status update
    }

} );

/**
 * @class $.ui.iviewer.ImageObject Class represents image and provides public api without
 *     extending image prototype.
 * @constructor
 * @param {boolean} do_anim Do we want to animate image on dimension changes?
 */
$.ui.iviewer.ImageObject = function(do_anim) {
    this._img = $("<img>")
            //this is needed, because chromium sets them auto otherwise
            .css({ position: "absolute", top :"0px", left: "0px"});

    this._loaded = false;
    this._swapDimensions = false;
    this._do_anim = do_anim || false;
    this.x(0, true);
    this.y(0, true);
    this.angle(0);
};


/** @lends $.ui.iviewer.ImageObject.prototype */
(function() {
    /**
     * Restore initial object state.
     *
     * @param {number} w Image width.
     * @param {number} h Image height.
     */
    this._reset = function(w, h) {
        this._angle = 0;
        this._swapDimensions = false;
        this.x(0);
        this.y(0);

        this.orig_width(w);
        this.orig_height(h);
        this.display_width(w);
        this.display_height(h);
    };

    /**
     * Check if image is loaded.
     *
     * @return {boolean}
     */
    this.loaded = function() { return this._loaded; };

    /**
     * Load image.
     *
     * @param {string} src Image url.
     * @param {Function=} loaded Function will be called on image load.
     */
    this.load = function(src, loaded, error) {
        var self = this;
        loaded = loaded || jQuery.noop;
        this._loaded = false;

        // #67: don't use image object for loading in case naturalWidth is supported
        // because later assigning to self._img[0] may result in additional image requesrts.
        var supportsNaturalWidth = 'naturalWidth' in new Image();
        var img = supportsNaturalWidth ? self._img[0] : new Image();

        img.onload = function() {
            self._loaded = true;
            if (supportsNaturalWidth) {
              self._reset(this.naturalWidth, this.naturalHeight);
            } else {
              self._reset(this.width, this.height);
            }

            self._img
                .removeAttr("width")
                .removeAttr("height")
                .removeAttr("style")
                //max-width is reset, because plugin breaks in the twitter bootstrap otherwise
                .css({ position: "absolute", top :"0px", left: "0px", maxWidth: "none"});

            if (!supportsNaturalWidth) {
                self._img[0].src = src;
            }

            loaded();
        };
        img.onerror = error;

        //we need this because sometimes internet explorer 8 fires onload event
        //right after assignment (synchronously)
        setTimeout(function() {
            img.src = src;
        }, 0);
        this.angle(0);
    };
    this._dimension = function(prefix, name) {
        var horiz = '_' + prefix + '_' + name,
            vert = '_' + prefix + '_' + (name === 'height' ? 'width' : 'height');
        return setter(function(val) {
                this[this._swapDimensions ? horiz: vert] = val;
            },
            function() {
                return this[this._swapDimensions ? horiz: vert];
            });
    };

    /**
     * Getters and setter for common image dimensions.
     *    display_ means real image tag dimensions
     *    orig_ means physical image dimensions.
     *  Note, that dimensions are swapped if image is rotated. It necessary,
     *  because as little as possible code should know about rotation.
     */
    this.display_width = this._dimension('display', 'width'),
    this.display_height = this._dimension('display', 'height'),
    this.display_diff = function() { return Math.floor( this.display_width() - this.display_height() ); };
    this.orig_width = this._dimension('orig', 'width'),
    this.orig_height = this._dimension('orig', 'height'),

    /**
     * Setter for  X coordinate. If image is rotated we need to additionaly shift an
     *     image to map image coordinate to the visual position.
     *
     * @param {number} val Coordinate value.
     * @param {boolean} skipCss If true, we only set the value and do not touch the dom.
     */
    this.x = setter(function(val, skipCss) {
            this._x = val;
            if (!skipCss) {
                this._finishAnimation();
                this._img.css("left",this._x + (this._swapDimensions ? this.display_diff() / 2 : 0) + "px");
            }
        },
        function() {
            return this._x;
        });

    /**
     * Setter for  Y coordinate. If image is rotated we need to additionaly shift an
     *     image to map image coordinate to the visual position.
     *
     * @param {number} val Coordinate value.
     * @param {boolean} skipCss If true, we only set the value and do not touch the dom.
     */
    this.y = setter(function(val, skipCss) {
            this._y = val;
            if (!skipCss) {
                this._finishAnimation();
                this._img.css("top",this._y - (this._swapDimensions ? this.display_diff() / 2 : 0) + "px");
            }
        },
       function() {
            return this._y;
       });

    /**
     * Perform image rotation.
     *
     * @param {number} deg Absolute image angle. The method will work with values 0, 90, 180, 270 degrees.
     */
    this.angle = setter(function(deg) {
            var prevSwap = this._swapDimensions;

            this._angle = deg;
            this._swapDimensions = deg % 180 !== 0;

            if (prevSwap !== this._swapDimensions) {
                var verticalMod = this._swapDimensions ? -1 : 1;
                this.x(this.x() - verticalMod * this.display_diff() / 2, true);
                this.y(this.y() + verticalMod * this.display_diff() / 2, true);
            };

            var cssVal = 'rotate(' + deg + 'deg)',
                img = this._img;

            jQuery.each(['', '-webkit-', '-moz-', '-o-', '-ms-'], function(i, prefix) {
                img.css(prefix + 'transform', cssVal);
            });

            if (useIeTransforms) {
                jQuery.each(['-ms-', ''], function(i, prefix) {
                    img.css(prefix + 'filter', ieTransforms[deg].filter);
                });

                img.css({
                    marginLeft: ieTransforms[deg].marginLeft * this.display_diff() / 2,
                    marginTop: ieTransforms[deg].marginTop * this.display_diff() / 2
                });
            }
        },
       function() { return this._angle; });

    /**
     * Map point in the container coordinates to the point in image coordinates.
     *     You will get coordinates of point on image with respect to rotation,
     *     but will be set as if image was not rotated.
     *     So, if image was rotated 90 degrees, it's (0,0) point will be on the
     *     top right corner.
     *
     * @param {{x: number, y: number}} point Point in container coordinates.
     * @return  {{x: number, y: number}}
     */
    this.toOriginalCoords = function(point) {
        switch (this.angle()) {
            case 0: return { x: point.x, y: point.y };
            case 90: return { x: point.y, y: this.display_width() - point.x };
            case 180: return { x: this.display_width() - point.x, y: this.display_height() - point.y };
            case 270: return { x: this.display_height() - point.y, y: point.x };
        }
    };

    /**
     * Map point in the image coordinates to the point in container coordinates.
     *     You will get coordinates of point on container with respect to rotation.
     *     Note, if image was rotated 90 degrees, it's (0,0) point will be on the
     *     top right corner.
     *
     * @param {{x: number, y: number}} point Point in container coordinates.
     * @return  {{x: number, y: number}}
     */
    this.toRealCoords = function(point) {
        switch (this.angle()) {
            case 0: return { x: this.x() + point.x, y: this.y() + point.y };
            case 90: return { x: this.x() + this.display_width() - point.y, y: this.y() + point.x};
            case 180: return { x: this.x() + this.display_width() - point.x, y: this.y() + this.display_height() - point.y};
            case 270: return { x: this.x() + point.y, y: this.y() + this.display_height() - point.x};
        }
    };

    /**
     * @return {jQuery} Return image node. this is needed to add event handlers.
     */
    this.object = setter(jQuery.noop,
                           function() { return this._img; });

    /**
     * Change image properties.
     *
     * @param {number} disp_w Display width;
     * @param {number} disp_h Display height;
     * @param {number} x
     * @param {number} y
     * @param {boolean} skip_animation If true, the animation will be skiped despite the
     *     value set in constructor.
     * @param {Function=} complete Call back will be fired when zoom will be complete.
     */
    this.setImageProps = function(disp_w, disp_h, x, y, skip_animation, complete) {
        complete = complete || jQuery.noop;

        this.display_width(disp_w);
        this.display_height(disp_h);
        this.x(x, true);
        this.y(y, true);

        var w = this._swapDimensions ? disp_h : disp_w;
        var h = this._swapDimensions ? disp_w : disp_h;

        var params = {
            width: w,
            height: h,
            top: y - (this._swapDimensions ? this.display_diff() / 2 : 0) + "px",
            left: x + (this._swapDimensions ? this.display_diff() / 2 : 0) + "px"
        };

        if (useIeTransforms) {
            jQuery.extend(params, {
                marginLeft: ieTransforms[this.angle()].marginLeft * this.display_diff() / 2,
                marginTop: ieTransforms[this.angle()].marginTop * this.display_diff() / 2
            });
        }

        var swapDims = this._swapDimensions,
            img = this._img;

        //here we come: another IE oddness. If image is rotated 90 degrees with a filter, than
        //width and height getters return real width and height of rotated image. The bad news
        //is that to set height you need to set a width and vice versa. Fuck IE.
        //So, in this case we have to animate width and height manually.
        if(useIeTransforms && swapDims) {
            var ieh = this._img.width(),
                iew = this._img.height(),
                iedh = params.height - ieh;
                iedw = params.width - iew;

            delete params.width;
            delete params.height;
        }

        if (this._do_anim && !skip_animation) {
            this._img.stop(true)
                .animate(params, {
                    duration: 200,
                    complete: complete,
                    step: function(now, fx) {
                        if(useIeTransforms && swapDims && (fx.prop === 'top')) {
                            var percent = (now - fx.start) / (fx.end - fx.start);

                            img.height(ieh + iedh * percent);
                            img.width(iew + iedw * percent);
                            img.css('top', now);
                        }
                    }
                });
        } else {
            this._img.css(params);
            setTimeout(complete, 0); //both if branches should behave equally.
        }
    };

    //if we set image coordinates we need to be sure that no animation is active atm
    this._finishAnimation = function() {
      this._img.stop(true, true);
    };

}).apply($.ui.iviewer.ImageObject.prototype);



var util = {
    scaleValue: function(value, toZoom)
    {
        return value * toZoom / 100;
    },

    descaleValue: function(value, fromZoom)
    {
        return value * 100 / fromZoom;
    }
};

 } )( jQuery, undefined );

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./node_modules/jquery-mousewheel/jquery.mousewheel.js":
/*!*************************************************************!*\
  !*** ./node_modules/jquery-mousewheel/jquery.mousewheel.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery Mousewheel 3.1.13
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 */

(function (factory) {
    if ( true ) {
        // AMD. Register as an anonymous module.
        !(__WEBPACK_AMD_DEFINE_ARRAY__ = [__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
    } else {}
}(function ($) {

    var toFix  = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'],
        toBind = ( 'onwheel' in document || document.documentMode >= 9 ) ?
                    ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'],
        slice  = Array.prototype.slice,
        nullLowestDeltaTimeout, lowestDelta;

    if ( $.event.fixHooks ) {
        for ( var i = toFix.length; i; ) {
            $.event.fixHooks[ toFix[--i] ] = $.event.mouseHooks;
        }
    }

    var special = $.event.special.mousewheel = {
        version: '3.1.12',

        setup: function() {
            if ( this.addEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.addEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
            // Store the line height and page height for this particular element
            $.data(this, 'mousewheel-line-height', special.getLineHeight(this));
            $.data(this, 'mousewheel-page-height', special.getPageHeight(this));
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.removeEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
            // Clean up the data we added to the element
            $.removeData(this, 'mousewheel-line-height');
            $.removeData(this, 'mousewheel-page-height');
        },

        getLineHeight: function(elem) {
            var $elem = $(elem),
                $parent = $elem['offsetParent' in $.fn ? 'offsetParent' : 'parent']();
            if (!$parent.length) {
                $parent = $('body');
            }
            return parseInt($parent.css('fontSize'), 10) || parseInt($elem.css('fontSize'), 10) || 16;
        },

        getPageHeight: function(elem) {
            return $(elem).height();
        },

        settings: {
            adjustOldDeltas: true, // see shouldAdjustOldDeltas() below
            normalizeOffset: true  // calls getBoundingClientRect for each event
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind('mousewheel', fn) : this.trigger('mousewheel');
        },

        unmousewheel: function(fn) {
            return this.unbind('mousewheel', fn);
        }
    });


    function handler(event) {
        var orgEvent   = event || window.event,
            args       = slice.call(arguments, 1),
            delta      = 0,
            deltaX     = 0,
            deltaY     = 0,
            absDelta   = 0,
            offsetX    = 0,
            offsetY    = 0;
        event = $.event.fix(orgEvent);
        event.type = 'mousewheel';

        // Old school scrollwheel delta
        if ( 'detail'      in orgEvent ) { deltaY = orgEvent.detail * -1;      }
        if ( 'wheelDelta'  in orgEvent ) { deltaY = orgEvent.wheelDelta;       }
        if ( 'wheelDeltaY' in orgEvent ) { deltaY = orgEvent.wheelDeltaY;      }
        if ( 'wheelDeltaX' in orgEvent ) { deltaX = orgEvent.wheelDeltaX * -1; }

        // Firefox < 17 horizontal scrolling related to DOMMouseScroll event
        if ( 'axis' in orgEvent && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
            deltaX = deltaY * -1;
            deltaY = 0;
        }

        // Set delta to be deltaY or deltaX if deltaY is 0 for backwards compatabilitiy
        delta = deltaY === 0 ? deltaX : deltaY;

        // New school wheel delta (wheel event)
        if ( 'deltaY' in orgEvent ) {
            deltaY = orgEvent.deltaY * -1;
            delta  = deltaY;
        }
        if ( 'deltaX' in orgEvent ) {
            deltaX = orgEvent.deltaX;
            if ( deltaY === 0 ) { delta  = deltaX * -1; }
        }

        // No change actually happened, no reason to go any further
        if ( deltaY === 0 && deltaX === 0 ) { return; }

        // Need to convert lines and pages to pixels if we aren't already in pixels
        // There are three delta modes:
        //   * deltaMode 0 is by pixels, nothing to do
        //   * deltaMode 1 is by lines
        //   * deltaMode 2 is by pages
        if ( orgEvent.deltaMode === 1 ) {
            var lineHeight = $.data(this, 'mousewheel-line-height');
            delta  *= lineHeight;
            deltaY *= lineHeight;
            deltaX *= lineHeight;
        } else if ( orgEvent.deltaMode === 2 ) {
            var pageHeight = $.data(this, 'mousewheel-page-height');
            delta  *= pageHeight;
            deltaY *= pageHeight;
            deltaX *= pageHeight;
        }

        // Store lowest absolute delta to normalize the delta values
        absDelta = Math.max( Math.abs(deltaY), Math.abs(deltaX) );

        if ( !lowestDelta || absDelta < lowestDelta ) {
            lowestDelta = absDelta;

            // Adjust older deltas if necessary
            if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
                lowestDelta /= 40;
            }
        }

        // Adjust older deltas if necessary
        if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
            // Divide all the things by 40!
            delta  /= 40;
            deltaX /= 40;
            deltaY /= 40;
        }

        // Get a whole, normalized value for the deltas
        delta  = Math[ delta  >= 1 ? 'floor' : 'ceil' ](delta  / lowestDelta);
        deltaX = Math[ deltaX >= 1 ? 'floor' : 'ceil' ](deltaX / lowestDelta);
        deltaY = Math[ deltaY >= 1 ? 'floor' : 'ceil' ](deltaY / lowestDelta);

        // Normalise offsetX and offsetY properties
        if ( special.settings.normalizeOffset && this.getBoundingClientRect ) {
            var boundingRect = this.getBoundingClientRect();
            offsetX = event.clientX - boundingRect.left;
            offsetY = event.clientY - boundingRect.top;
        }

        // Add information to the event object
        event.deltaX = deltaX;
        event.deltaY = deltaY;
        event.deltaFactor = lowestDelta;
        event.offsetX = offsetX;
        event.offsetY = offsetY;
        // Go ahead and set deltaMode to 0 since we converted to pixels
        // Although this is a little odd since we overwrite the deltaX/Y
        // properties with normalized deltas.
        event.deltaMode = 0;

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        // Clearout lowestDelta after sometime to better
        // handle multiple device types that give different
        // a different lowestDelta
        // Ex: trackpad = 3 and mouse wheel = 120
        if (nullLowestDeltaTimeout) { clearTimeout(nullLowestDeltaTimeout); }
        nullLowestDeltaTimeout = setTimeout(nullLowestDelta, 200);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

    function nullLowestDelta() {
        lowestDelta = null;
    }

    function shouldAdjustOldDeltas(orgEvent, absDelta) {
        // If this is an older event and the delta is divisable by 120,
        // then we are assuming that the browser is treating this as an
        // older mouse wheel event and that we should divide the deltas
        // by 40 to try and get a more usable deltaFactor.
        // Side note, this actually impacts the reported scroll distance
        // in older browsers and can cause scrolling to be slower than native.
        // Turn this off by setting $.event.special.mousewheel.settings.adjustOldDeltas to false.
        return special.settings.adjustOldDeltas && orgEvent.type === 'mousewheel' && absDelta % 120 === 0;
    }

}));


/***/ }),

/***/ "./node_modules/jquery-ui/ui/ie.js":
/*!*****************************************!*\
  !*** ./node_modules/jquery-ui/ui/ie.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {

// This file is deprecated
return $.ui.ie = !!/msie [\w.]+/.exec( navigator.userAgent.toLowerCase() );
} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/version.js":
/*!**********************************************!*\
  !*** ./node_modules/jquery-ui/ui/version.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
} ( function( $ ) {

$.ui = $.ui || {};

return $.ui.version = "1.12.1";

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widget.js":
/*!*********************************************!*\
  !*** ./node_modules/jquery-ui/ui/widget.js ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Widget 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: Widget
//>>group: Core
//>>description: Provides a factory for creating stateful widgets with a common API.
//>>docs: http://api.jqueryui.com/jQuery.widget/
//>>demos: http://jqueryui.com/widget/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [ __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"), __webpack_require__(/*! ./version */ "./node_modules/jquery-ui/ui/version.js") ], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}( function( $ ) {

var widgetUuid = 0;
var widgetSlice = Array.prototype.slice;

$.cleanData = ( function( orig ) {
	return function( elems ) {
		var events, elem, i;
		for ( i = 0; ( elem = elems[ i ] ) != null; i++ ) {
			try {

				// Only trigger remove when necessary to save time
				events = $._data( elem, "events" );
				if ( events && events.remove ) {
					$( elem ).triggerHandler( "remove" );
				}

			// Http://bugs.jquery.com/ticket/8235
			} catch ( e ) {}
		}
		orig( elems );
	};
} )( $.cleanData );

$.widget = function( name, base, prototype ) {
	var existingConstructor, constructor, basePrototype;

	// ProxiedPrototype allows the provided prototype to remain unmodified
	// so that it can be used as a mixin for multiple widgets (#8876)
	var proxiedPrototype = {};

	var namespace = name.split( "." )[ 0 ];
	name = name.split( "." )[ 1 ];
	var fullName = namespace + "-" + name;

	if ( !prototype ) {
		prototype = base;
		base = $.Widget;
	}

	if ( $.isArray( prototype ) ) {
		prototype = $.extend.apply( null, [ {} ].concat( prototype ) );
	}

	// Create selector for plugin
	$.expr[ ":" ][ fullName.toLowerCase() ] = function( elem ) {
		return !!$.data( elem, fullName );
	};

	$[ namespace ] = $[ namespace ] || {};
	existingConstructor = $[ namespace ][ name ];
	constructor = $[ namespace ][ name ] = function( options, element ) {

		// Allow instantiation without "new" keyword
		if ( !this._createWidget ) {
			return new constructor( options, element );
		}

		// Allow instantiation without initializing for simple inheritance
		// must use "new" keyword (the code above always passes args)
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};

	// Extend with the existing constructor to carry over any static properties
	$.extend( constructor, existingConstructor, {
		version: prototype.version,

		// Copy the object used to create the prototype in case we need to
		// redefine the widget later
		_proto: $.extend( {}, prototype ),

		// Track widgets that inherit from this widget in case this widget is
		// redefined after a widget inherits from it
		_childConstructors: []
	} );

	basePrototype = new base();

	// We need to make the options hash a property directly on the new instance
	// otherwise we'll modify the options hash on the prototype that we're
	// inheriting from
	basePrototype.options = $.widget.extend( {}, basePrototype.options );
	$.each( prototype, function( prop, value ) {
		if ( !$.isFunction( value ) ) {
			proxiedPrototype[ prop ] = value;
			return;
		}
		proxiedPrototype[ prop ] = ( function() {
			function _super() {
				return base.prototype[ prop ].apply( this, arguments );
			}

			function _superApply( args ) {
				return base.prototype[ prop ].apply( this, args );
			}

			return function() {
				var __super = this._super;
				var __superApply = this._superApply;
				var returnValue;

				this._super = _super;
				this._superApply = _superApply;

				returnValue = value.apply( this, arguments );

				this._super = __super;
				this._superApply = __superApply;

				return returnValue;
			};
		} )();
	} );
	constructor.prototype = $.widget.extend( basePrototype, {

		// TODO: remove support for widgetEventPrefix
		// always use the name + a colon as the prefix, e.g., draggable:start
		// don't prefix for widgets that aren't DOM-based
		widgetEventPrefix: existingConstructor ? ( basePrototype.widgetEventPrefix || name ) : name
	}, proxiedPrototype, {
		constructor: constructor,
		namespace: namespace,
		widgetName: name,
		widgetFullName: fullName
	} );

	// If this widget is being redefined then we need to find all widgets that
	// are inheriting from it and redefine all of them so that they inherit from
	// the new version of this widget. We're essentially trying to replace one
	// level in the prototype chain.
	if ( existingConstructor ) {
		$.each( existingConstructor._childConstructors, function( i, child ) {
			var childPrototype = child.prototype;

			// Redefine the child widget using the same prototype that was
			// originally used, but inherit from the new version of the base
			$.widget( childPrototype.namespace + "." + childPrototype.widgetName, constructor,
				child._proto );
		} );

		// Remove the list of existing child constructors from the old constructor
		// so the old child constructors can be garbage collected
		delete existingConstructor._childConstructors;
	} else {
		base._childConstructors.push( constructor );
	}

	$.widget.bridge( name, constructor );

	return constructor;
};

$.widget.extend = function( target ) {
	var input = widgetSlice.call( arguments, 1 );
	var inputIndex = 0;
	var inputLength = input.length;
	var key;
	var value;

	for ( ; inputIndex < inputLength; inputIndex++ ) {
		for ( key in input[ inputIndex ] ) {
			value = input[ inputIndex ][ key ];
			if ( input[ inputIndex ].hasOwnProperty( key ) && value !== undefined ) {

				// Clone objects
				if ( $.isPlainObject( value ) ) {
					target[ key ] = $.isPlainObject( target[ key ] ) ?
						$.widget.extend( {}, target[ key ], value ) :

						// Don't extend strings, arrays, etc. with objects
						$.widget.extend( {}, value );

				// Copy everything else by reference
				} else {
					target[ key ] = value;
				}
			}
		}
	}
	return target;
};

$.widget.bridge = function( name, object ) {
	var fullName = object.prototype.widgetFullName || name;
	$.fn[ name ] = function( options ) {
		var isMethodCall = typeof options === "string";
		var args = widgetSlice.call( arguments, 1 );
		var returnValue = this;

		if ( isMethodCall ) {

			// If this is an empty collection, we need to have the instance method
			// return undefined instead of the jQuery instance
			if ( !this.length && options === "instance" ) {
				returnValue = undefined;
			} else {
				this.each( function() {
					var methodValue;
					var instance = $.data( this, fullName );

					if ( options === "instance" ) {
						returnValue = instance;
						return false;
					}

					if ( !instance ) {
						return $.error( "cannot call methods on " + name +
							" prior to initialization; " +
							"attempted to call method '" + options + "'" );
					}

					if ( !$.isFunction( instance[ options ] ) || options.charAt( 0 ) === "_" ) {
						return $.error( "no such method '" + options + "' for " + name +
							" widget instance" );
					}

					methodValue = instance[ options ].apply( instance, args );

					if ( methodValue !== instance && methodValue !== undefined ) {
						returnValue = methodValue && methodValue.jquery ?
							returnValue.pushStack( methodValue.get() ) :
							methodValue;
						return false;
					}
				} );
			}
		} else {

			// Allow multiple hashes to be passed on init
			if ( args.length ) {
				options = $.widget.extend.apply( null, [ options ].concat( args ) );
			}

			this.each( function() {
				var instance = $.data( this, fullName );
				if ( instance ) {
					instance.option( options || {} );
					if ( instance._init ) {
						instance._init();
					}
				} else {
					$.data( this, fullName, new object( options, this ) );
				}
			} );
		}

		return returnValue;
	};
};

$.Widget = function( /* options, element */ ) {};
$.Widget._childConstructors = [];

$.Widget.prototype = {
	widgetName: "widget",
	widgetEventPrefix: "",
	defaultElement: "<div>",

	options: {
		classes: {},
		disabled: false,

		// Callbacks
		create: null
	},

	_createWidget: function( options, element ) {
		element = $( element || this.defaultElement || this )[ 0 ];
		this.element = $( element );
		this.uuid = widgetUuid++;
		this.eventNamespace = "." + this.widgetName + this.uuid;

		this.bindings = $();
		this.hoverable = $();
		this.focusable = $();
		this.classesElementLookup = {};

		if ( element !== this ) {
			$.data( element, this.widgetFullName, this );
			this._on( true, this.element, {
				remove: function( event ) {
					if ( event.target === element ) {
						this.destroy();
					}
				}
			} );
			this.document = $( element.style ?

				// Element within the document
				element.ownerDocument :

				// Element is window or document
				element.document || element );
			this.window = $( this.document[ 0 ].defaultView || this.document[ 0 ].parentWindow );
		}

		this.options = $.widget.extend( {},
			this.options,
			this._getCreateOptions(),
			options );

		this._create();

		if ( this.options.disabled ) {
			this._setOptionDisabled( this.options.disabled );
		}

		this._trigger( "create", null, this._getCreateEventData() );
		this._init();
	},

	_getCreateOptions: function() {
		return {};
	},

	_getCreateEventData: $.noop,

	_create: $.noop,

	_init: $.noop,

	destroy: function() {
		var that = this;

		this._destroy();
		$.each( this.classesElementLookup, function( key, value ) {
			that._removeClass( value, key );
		} );

		// We can probably remove the unbind calls in 2.0
		// all event bindings should go through this._on()
		this.element
			.off( this.eventNamespace )
			.removeData( this.widgetFullName );
		this.widget()
			.off( this.eventNamespace )
			.removeAttr( "aria-disabled" );

		// Clean up events and states
		this.bindings.off( this.eventNamespace );
	},

	_destroy: $.noop,

	widget: function() {
		return this.element;
	},

	option: function( key, value ) {
		var options = key;
		var parts;
		var curOption;
		var i;

		if ( arguments.length === 0 ) {

			// Don't return a reference to the internal hash
			return $.widget.extend( {}, this.options );
		}

		if ( typeof key === "string" ) {

			// Handle nested keys, e.g., "foo.bar" => { foo: { bar: ___ } }
			options = {};
			parts = key.split( "." );
			key = parts.shift();
			if ( parts.length ) {
				curOption = options[ key ] = $.widget.extend( {}, this.options[ key ] );
				for ( i = 0; i < parts.length - 1; i++ ) {
					curOption[ parts[ i ] ] = curOption[ parts[ i ] ] || {};
					curOption = curOption[ parts[ i ] ];
				}
				key = parts.pop();
				if ( arguments.length === 1 ) {
					return curOption[ key ] === undefined ? null : curOption[ key ];
				}
				curOption[ key ] = value;
			} else {
				if ( arguments.length === 1 ) {
					return this.options[ key ] === undefined ? null : this.options[ key ];
				}
				options[ key ] = value;
			}
		}

		this._setOptions( options );

		return this;
	},

	_setOptions: function( options ) {
		var key;

		for ( key in options ) {
			this._setOption( key, options[ key ] );
		}

		return this;
	},

	_setOption: function( key, value ) {
		if ( key === "classes" ) {
			this._setOptionClasses( value );
		}

		this.options[ key ] = value;

		if ( key === "disabled" ) {
			this._setOptionDisabled( value );
		}

		return this;
	},

	_setOptionClasses: function( value ) {
		var classKey, elements, currentElements;

		for ( classKey in value ) {
			currentElements = this.classesElementLookup[ classKey ];
			if ( value[ classKey ] === this.options.classes[ classKey ] ||
					!currentElements ||
					!currentElements.length ) {
				continue;
			}

			// We are doing this to create a new jQuery object because the _removeClass() call
			// on the next line is going to destroy the reference to the current elements being
			// tracked. We need to save a copy of this collection so that we can add the new classes
			// below.
			elements = $( currentElements.get() );
			this._removeClass( currentElements, classKey );

			// We don't use _addClass() here, because that uses this.options.classes
			// for generating the string of classes. We want to use the value passed in from
			// _setOption(), this is the new value of the classes option which was passed to
			// _setOption(). We pass this value directly to _classes().
			elements.addClass( this._classes( {
				element: elements,
				keys: classKey,
				classes: value,
				add: true
			} ) );
		}
	},

	_setOptionDisabled: function( value ) {
		this._toggleClass( this.widget(), this.widgetFullName + "-disabled", null, !!value );

		// If the widget is becoming disabled, then nothing is interactive
		if ( value ) {
			this._removeClass( this.hoverable, null, "ui-state-hover" );
			this._removeClass( this.focusable, null, "ui-state-focus" );
		}
	},

	enable: function() {
		return this._setOptions( { disabled: false } );
	},

	disable: function() {
		return this._setOptions( { disabled: true } );
	},

	_classes: function( options ) {
		var full = [];
		var that = this;

		options = $.extend( {
			element: this.element,
			classes: this.options.classes || {}
		}, options );

		function processClassString( classes, checkOption ) {
			var current, i;
			for ( i = 0; i < classes.length; i++ ) {
				current = that.classesElementLookup[ classes[ i ] ] || $();
				if ( options.add ) {
					current = $( $.unique( current.get().concat( options.element.get() ) ) );
				} else {
					current = $( current.not( options.element ).get() );
				}
				that.classesElementLookup[ classes[ i ] ] = current;
				full.push( classes[ i ] );
				if ( checkOption && options.classes[ classes[ i ] ] ) {
					full.push( options.classes[ classes[ i ] ] );
				}
			}
		}

		this._on( options.element, {
			"remove": "_untrackClassesElement"
		} );

		if ( options.keys ) {
			processClassString( options.keys.match( /\S+/g ) || [], true );
		}
		if ( options.extra ) {
			processClassString( options.extra.match( /\S+/g ) || [] );
		}

		return full.join( " " );
	},

	_untrackClassesElement: function( event ) {
		var that = this;
		$.each( that.classesElementLookup, function( key, value ) {
			if ( $.inArray( event.target, value ) !== -1 ) {
				that.classesElementLookup[ key ] = $( value.not( event.target ).get() );
			}
		} );
	},

	_removeClass: function( element, keys, extra ) {
		return this._toggleClass( element, keys, extra, false );
	},

	_addClass: function( element, keys, extra ) {
		return this._toggleClass( element, keys, extra, true );
	},

	_toggleClass: function( element, keys, extra, add ) {
		add = ( typeof add === "boolean" ) ? add : extra;
		var shift = ( typeof element === "string" || element === null ),
			options = {
				extra: shift ? keys : extra,
				keys: shift ? element : keys,
				element: shift ? this.element : element,
				add: add
			};
		options.element.toggleClass( this._classes( options ), add );
		return this;
	},

	_on: function( suppressDisabledCheck, element, handlers ) {
		var delegateElement;
		var instance = this;

		// No suppressDisabledCheck flag, shuffle arguments
		if ( typeof suppressDisabledCheck !== "boolean" ) {
			handlers = element;
			element = suppressDisabledCheck;
			suppressDisabledCheck = false;
		}

		// No element argument, shuffle and use this.element
		if ( !handlers ) {
			handlers = element;
			element = this.element;
			delegateElement = this.widget();
		} else {
			element = delegateElement = $( element );
			this.bindings = this.bindings.add( element );
		}

		$.each( handlers, function( event, handler ) {
			function handlerProxy() {

				// Allow widgets to customize the disabled handling
				// - disabled as an array instead of boolean
				// - disabled class as method for disabling individual parts
				if ( !suppressDisabledCheck &&
						( instance.options.disabled === true ||
						$( this ).hasClass( "ui-state-disabled" ) ) ) {
					return;
				}
				return ( typeof handler === "string" ? instance[ handler ] : handler )
					.apply( instance, arguments );
			}

			// Copy the guid so direct unbinding works
			if ( typeof handler !== "string" ) {
				handlerProxy.guid = handler.guid =
					handler.guid || handlerProxy.guid || $.guid++;
			}

			var match = event.match( /^([\w:-]*)\s*(.*)$/ );
			var eventName = match[ 1 ] + instance.eventNamespace;
			var selector = match[ 2 ];

			if ( selector ) {
				delegateElement.on( eventName, selector, handlerProxy );
			} else {
				element.on( eventName, handlerProxy );
			}
		} );
	},

	_off: function( element, eventName ) {
		eventName = ( eventName || "" ).split( " " ).join( this.eventNamespace + " " ) +
			this.eventNamespace;
		element.off( eventName ).off( eventName );

		// Clear the stack to avoid memory leaks (#10056)
		this.bindings = $( this.bindings.not( element ).get() );
		this.focusable = $( this.focusable.not( element ).get() );
		this.hoverable = $( this.hoverable.not( element ).get() );
	},

	_delay: function( handler, delay ) {
		function handlerProxy() {
			return ( typeof handler === "string" ? instance[ handler ] : handler )
				.apply( instance, arguments );
		}
		var instance = this;
		return setTimeout( handlerProxy, delay || 0 );
	},

	_hoverable: function( element ) {
		this.hoverable = this.hoverable.add( element );
		this._on( element, {
			mouseenter: function( event ) {
				this._addClass( $( event.currentTarget ), null, "ui-state-hover" );
			},
			mouseleave: function( event ) {
				this._removeClass( $( event.currentTarget ), null, "ui-state-hover" );
			}
		} );
	},

	_focusable: function( element ) {
		this.focusable = this.focusable.add( element );
		this._on( element, {
			focusin: function( event ) {
				this._addClass( $( event.currentTarget ), null, "ui-state-focus" );
			},
			focusout: function( event ) {
				this._removeClass( $( event.currentTarget ), null, "ui-state-focus" );
			}
		} );
	},

	_trigger: function( type, event, data ) {
		var prop, orig;
		var callback = this.options[ type ];

		data = data || {};
		event = $.Event( event );
		event.type = ( type === this.widgetEventPrefix ?
			type :
			this.widgetEventPrefix + type ).toLowerCase();

		// The original event may come from any element
		// so we need to reset the target on the new event
		event.target = this.element[ 0 ];

		// Copy original event properties over to the new event
		orig = event.originalEvent;
		if ( orig ) {
			for ( prop in orig ) {
				if ( !( prop in event ) ) {
					event[ prop ] = orig[ prop ];
				}
			}
		}

		this.element.trigger( event, data );
		return !( $.isFunction( callback ) &&
			callback.apply( this.element[ 0 ], [ event ].concat( data ) ) === false ||
			event.isDefaultPrevented() );
	}
};

$.each( { show: "fadeIn", hide: "fadeOut" }, function( method, defaultEffect ) {
	$.Widget.prototype[ "_" + method ] = function( element, options, callback ) {
		if ( typeof options === "string" ) {
			options = { effect: options };
		}

		var hasOptions;
		var effectName = !options ?
			method :
			options === true || typeof options === "number" ?
				defaultEffect :
				options.effect || defaultEffect;

		options = options || {};
		if ( typeof options === "number" ) {
			options = { duration: options };
		}

		hasOptions = !$.isEmptyObject( options );
		options.complete = callback;

		if ( options.delay ) {
			element.delay( options.delay );
		}

		if ( hasOptions && $.effects && $.effects.effect[ effectName ] ) {
			element[ method ]( options );
		} else if ( effectName !== method && element[ effectName ] ) {
			element[ effectName ]( options.duration, options.easing, callback );
		} else {
			element.queue( function( next ) {
				$( this )[ method ]();
				if ( callback ) {
					callback.call( element[ 0 ] );
				}
				next();
			} );
		}
	};
} );

return $.widget;

} ) );


/***/ }),

/***/ "./node_modules/jquery-ui/ui/widgets/mouse.js":
/*!****************************************************!*\
  !*** ./node_modules/jquery-ui/ui/widgets/mouse.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * jQuery UI Mouse 1.12.1
 * http://jqueryui.com
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */

//>>label: Mouse
//>>group: Widgets
//>>description: Abstracts mouse-based interactions to assist in creating certain widgets.
//>>docs: http://api.jqueryui.com/mouse/

( function( factory ) {
	if ( true ) {

		// AMD. Register as an anonymous module.
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [
			__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js"),
			__webpack_require__(/*! ../ie */ "./node_modules/jquery-ui/ui/ie.js"),
			__webpack_require__(/*! ../version */ "./node_modules/jquery-ui/ui/version.js"),
			__webpack_require__(/*! ../widget */ "./node_modules/jquery-ui/ui/widget.js")
		], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
				__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
				(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {}
}( function( $ ) {

var mouseHandled = false;
$( document ).on( "mouseup", function() {
	mouseHandled = false;
} );

return $.widget( "ui.mouse", {
	version: "1.12.1",
	options: {
		cancel: "input, textarea, button, select, option",
		distance: 1,
		delay: 0
	},
	_mouseInit: function() {
		var that = this;

		this.element
			.on( "mousedown." + this.widgetName, function( event ) {
				return that._mouseDown( event );
			} )
			.on( "click." + this.widgetName, function( event ) {
				if ( true === $.data( event.target, that.widgetName + ".preventClickEvent" ) ) {
					$.removeData( event.target, that.widgetName + ".preventClickEvent" );
					event.stopImmediatePropagation();
					return false;
				}
			} );

		this.started = false;
	},

	// TODO: make sure destroying one instance of mouse doesn't mess with
	// other instances of mouse
	_mouseDestroy: function() {
		this.element.off( "." + this.widgetName );
		if ( this._mouseMoveDelegate ) {
			this.document
				.off( "mousemove." + this.widgetName, this._mouseMoveDelegate )
				.off( "mouseup." + this.widgetName, this._mouseUpDelegate );
		}
	},

	_mouseDown: function( event ) {

		// don't let more than one widget handle mouseStart
		if ( mouseHandled ) {
			return;
		}

		this._mouseMoved = false;

		// We may have missed mouseup (out of window)
		( this._mouseStarted && this._mouseUp( event ) );

		this._mouseDownEvent = event;

		var that = this,
			btnIsLeft = ( event.which === 1 ),

			// event.target.nodeName works around a bug in IE 8 with
			// disabled inputs (#7620)
			elIsCancel = ( typeof this.options.cancel === "string" && event.target.nodeName ?
				$( event.target ).closest( this.options.cancel ).length : false );
		if ( !btnIsLeft || elIsCancel || !this._mouseCapture( event ) ) {
			return true;
		}

		this.mouseDelayMet = !this.options.delay;
		if ( !this.mouseDelayMet ) {
			this._mouseDelayTimer = setTimeout( function() {
				that.mouseDelayMet = true;
			}, this.options.delay );
		}

		if ( this._mouseDistanceMet( event ) && this._mouseDelayMet( event ) ) {
			this._mouseStarted = ( this._mouseStart( event ) !== false );
			if ( !this._mouseStarted ) {
				event.preventDefault();
				return true;
			}
		}

		// Click event may never have fired (Gecko & Opera)
		if ( true === $.data( event.target, this.widgetName + ".preventClickEvent" ) ) {
			$.removeData( event.target, this.widgetName + ".preventClickEvent" );
		}

		// These delegates are required to keep context
		this._mouseMoveDelegate = function( event ) {
			return that._mouseMove( event );
		};
		this._mouseUpDelegate = function( event ) {
			return that._mouseUp( event );
		};

		this.document
			.on( "mousemove." + this.widgetName, this._mouseMoveDelegate )
			.on( "mouseup." + this.widgetName, this._mouseUpDelegate );

		event.preventDefault();

		mouseHandled = true;
		return true;
	},

	_mouseMove: function( event ) {

		// Only check for mouseups outside the document if you've moved inside the document
		// at least once. This prevents the firing of mouseup in the case of IE<9, which will
		// fire a mousemove event if content is placed under the cursor. See #7778
		// Support: IE <9
		if ( this._mouseMoved ) {

			// IE mouseup check - mouseup happened when mouse was out of window
			if ( $.ui.ie && ( !document.documentMode || document.documentMode < 9 ) &&
					!event.button ) {
				return this._mouseUp( event );

			// Iframe mouseup check - mouseup occurred in another document
			} else if ( !event.which ) {

				// Support: Safari <=8 - 9
				// Safari sets which to 0 if you press any of the following keys
				// during a drag (#14461)
				if ( event.originalEvent.altKey || event.originalEvent.ctrlKey ||
						event.originalEvent.metaKey || event.originalEvent.shiftKey ) {
					this.ignoreMissingWhich = true;
				} else if ( !this.ignoreMissingWhich ) {
					return this._mouseUp( event );
				}
			}
		}

		if ( event.which || event.button ) {
			this._mouseMoved = true;
		}

		if ( this._mouseStarted ) {
			this._mouseDrag( event );
			return event.preventDefault();
		}

		if ( this._mouseDistanceMet( event ) && this._mouseDelayMet( event ) ) {
			this._mouseStarted =
				( this._mouseStart( this._mouseDownEvent, event ) !== false );
			( this._mouseStarted ? this._mouseDrag( event ) : this._mouseUp( event ) );
		}

		return !this._mouseStarted;
	},

	_mouseUp: function( event ) {
		this.document
			.off( "mousemove." + this.widgetName, this._mouseMoveDelegate )
			.off( "mouseup." + this.widgetName, this._mouseUpDelegate );

		if ( this._mouseStarted ) {
			this._mouseStarted = false;

			if ( event.target === this._mouseDownEvent.target ) {
				$.data( event.target, this.widgetName + ".preventClickEvent", true );
			}

			this._mouseStop( event );
		}

		if ( this._mouseDelayTimer ) {
			clearTimeout( this._mouseDelayTimer );
			delete this._mouseDelayTimer;
		}

		this.ignoreMissingWhich = false;
		mouseHandled = false;
		event.preventDefault();
	},

	_mouseDistanceMet: function( event ) {
		return ( Math.max(
				Math.abs( this._mouseDownEvent.pageX - event.pageX ),
				Math.abs( this._mouseDownEvent.pageY - event.pageY )
			) >= this.options.distance
		);
	},

	_mouseDelayMet: function( /* event */ ) {
		return this.mouseDelayMet;
	},

	// These are placeholder methods, to be overriden by extending plugin
	_mouseStart: function( /* event */ ) {},
	_mouseDrag: function( /* event */ ) {},
	_mouseStop: function( /* event */ ) {},
	_mouseCapture: function( /* event */ ) { return true; }
} );

} ) );


/***/ }),

/***/ "./node_modules/spin.js/spin.js":
/*!**************************************!*\
  !*** ./node_modules/spin.js/spin.js ***!
  \**************************************/
/*! exports provided: Spinner */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "Spinner", function() { return Spinner; });
var __assign = (undefined && undefined.__assign) || function () {
    __assign = Object.assign || function(t) {
        for (var s, i = 1, n = arguments.length; i < n; i++) {
            s = arguments[i];
            for (var p in s) if (Object.prototype.hasOwnProperty.call(s, p))
                t[p] = s[p];
        }
        return t;
    };
    return __assign.apply(this, arguments);
};
var defaults = {
    lines: 12,
    length: 7,
    width: 5,
    radius: 10,
    scale: 1.0,
    corners: 1,
    color: '#000',
    fadeColor: 'transparent',
    animation: 'spinner-line-fade-default',
    rotate: 0,
    direction: 1,
    speed: 1,
    zIndex: 2e9,
    className: 'spinner',
    top: '50%',
    left: '50%',
    shadow: '0 0 1px transparent',
    position: 'absolute',
};
var Spinner = /** @class */ (function () {
    function Spinner(opts) {
        if (opts === void 0) { opts = {}; }
        this.opts = __assign(__assign({}, defaults), opts);
    }
    /**
     * Adds the spinner to the given target element. If this instance is already
     * spinning, it is automatically removed from its previous target by calling
     * stop() internally.
     */
    Spinner.prototype.spin = function (target) {
        this.stop();
        this.el = document.createElement('div');
        this.el.className = this.opts.className;
        this.el.setAttribute('role', 'progressbar');
        css(this.el, {
            position: this.opts.position,
            width: 0,
            zIndex: this.opts.zIndex,
            left: this.opts.left,
            top: this.opts.top,
            transform: "scale(" + this.opts.scale + ")",
        });
        if (target) {
            target.insertBefore(this.el, target.firstChild || null);
        }
        drawLines(this.el, this.opts);
        return this;
    };
    /**
     * Stops and removes the Spinner.
     * Stopped spinners may be reused by calling spin() again.
     */
    Spinner.prototype.stop = function () {
        if (this.el) {
            if (typeof requestAnimationFrame !== 'undefined') {
                cancelAnimationFrame(this.animateId);
            }
            else {
                clearTimeout(this.animateId);
            }
            if (this.el.parentNode) {
                this.el.parentNode.removeChild(this.el);
            }
            this.el = undefined;
        }
        return this;
    };
    return Spinner;
}());

/**
 * Sets multiple style properties at once.
 */
function css(el, props) {
    for (var prop in props) {
        el.style[prop] = props[prop];
    }
    return el;
}
/**
 * Returns the line color from the given string or array.
 */
function getColor(color, idx) {
    return typeof color == 'string' ? color : color[idx % color.length];
}
/**
 * Internal method that draws the individual lines.
 */
function drawLines(el, opts) {
    var borderRadius = (Math.round(opts.corners * opts.width * 500) / 1000) + 'px';
    var shadow = 'none';
    if (opts.shadow === true) {
        shadow = '0 2px 4px #000'; // default shadow
    }
    else if (typeof opts.shadow === 'string') {
        shadow = opts.shadow;
    }
    var shadows = parseBoxShadow(shadow);
    for (var i = 0; i < opts.lines; i++) {
        var degrees = ~~(360 / opts.lines * i + opts.rotate);
        var backgroundLine = css(document.createElement('div'), {
            position: 'absolute',
            top: -opts.width / 2 + "px",
            width: (opts.length + opts.width) + 'px',
            height: opts.width + 'px',
            background: getColor(opts.fadeColor, i),
            borderRadius: borderRadius,
            transformOrigin: 'left',
            transform: "rotate(" + degrees + "deg) translateX(" + opts.radius + "px)",
        });
        var delay = i * opts.direction / opts.lines / opts.speed;
        delay -= 1 / opts.speed; // so initial animation state will include trail
        var line = css(document.createElement('div'), {
            width: '100%',
            height: '100%',
            background: getColor(opts.color, i),
            borderRadius: borderRadius,
            boxShadow: normalizeShadow(shadows, degrees),
            animation: 1 / opts.speed + "s linear " + delay + "s infinite " + opts.animation,
        });
        backgroundLine.appendChild(line);
        el.appendChild(backgroundLine);
    }
}
function parseBoxShadow(boxShadow) {
    var regex = /^\s*([a-zA-Z]+\s+)?(-?\d+(\.\d+)?)([a-zA-Z]*)\s+(-?\d+(\.\d+)?)([a-zA-Z]*)(.*)$/;
    var shadows = [];
    for (var _i = 0, _a = boxShadow.split(','); _i < _a.length; _i++) {
        var shadow = _a[_i];
        var matches = shadow.match(regex);
        if (matches === null) {
            continue; // invalid syntax
        }
        var x = +matches[2];
        var y = +matches[5];
        var xUnits = matches[4];
        var yUnits = matches[7];
        if (x === 0 && !xUnits) {
            xUnits = yUnits;
        }
        if (y === 0 && !yUnits) {
            yUnits = xUnits;
        }
        if (xUnits !== yUnits) {
            continue; // units must match to use as coordinates
        }
        shadows.push({
            prefix: matches[1] || '',
            x: x,
            y: y,
            xUnits: xUnits,
            yUnits: yUnits,
            end: matches[8],
        });
    }
    return shadows;
}
/**
 * Modify box-shadow x/y offsets to counteract rotation
 */
function normalizeShadow(shadows, degrees) {
    var normalized = [];
    for (var _i = 0, shadows_1 = shadows; _i < shadows_1.length; _i++) {
        var shadow = shadows_1[_i];
        var xy = convertOffset(shadow.x, shadow.y, degrees);
        normalized.push(shadow.prefix + xy[0] + shadow.xUnits + ' ' + xy[1] + shadow.yUnits + shadow.end);
    }
    return normalized.join(', ');
}
function convertOffset(x, y, degrees) {
    var radians = degrees * Math.PI / 180;
    var sin = Math.sin(radians);
    var cos = Math.cos(radians);
    return [
        Math.round((x * cos + y * sin) * 1000) / 1000,
        Math.round((-x * sin + y * cos) * 1000) / 1000,
    ];
}


/***/ }),

/***/ "./node_modules/webpack/buildin/amd-define.js":
/*!***************************************!*\
  !*** (webpack)/buildin/amd-define.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function() {
	throw new Error("define cannot be used indirect");
};


/***/ }),

/***/ "./resources/assets/js/components/pod/main.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/components/pod/main.js ***!
  \****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(jQuery) {/* harmony import */ var _plugins_processAjaxErrorResponse__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../../plugins/processAjaxErrorResponse */ "./resources/assets/js/plugins/processAjaxErrorResponse.js");


__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

__webpack_require__(/*! ../../vendor/iviewer.js */ "./resources/assets/js/vendor/iviewer.js");

__webpack_require__(/*! ../../plugins/showLoading */ "./resources/assets/js/plugins/showLoading.js");

(function ($) {
  var defaultOptions = {
    queryLink: '',
    downloadsLink: '',
    reAssignLink: '',
    fetchResultsLink: '',
    imageLink: '',
    pdfLink: '',
    loading: ''
  };
  var loading, options;

  $.fn.podScripts = function (customOptions) {
    options = $.extend({}, defaultOptions, customOptions);
    loading = options.loading;

    var queryForResults = function queryForResults(waybillNumber, type) {
      $.ajax({
        type: "GET",
        url: options.queryLink,
        data: {
          waybill_number: waybillNumber
        },
        success: function success(data) {
          $(data).each(function (index, waybill) {
            fetchResults(waybill.id, waybill.type);
          });
        },
        error: function error(jqXHR) {
          loading.stop();
          Object(_plugins_processAjaxErrorResponse__WEBPACK_IMPORTED_MODULE_0__["default"])(jqXHR);
        }
      });
    };

    var fetchResults = function fetchResults(id, type) {
      var resultsArea = $('#podResult'),
          resultTabs = $('#resultTabs');
      $.ajax({
        type: "GET",
        url: options.fetchResultsLink,
        data: {
          waybill_number: id
        },
        beforeSend: function beforeSend() {
          resultsArea.empty();
          resultTabs.empty();
        },
        success: function success(data) {
          var id, imgArea, imgNav, imgNavA, downloadLink, reAssignLink;
          loading.stop();
          enableButtons();
          $(data).each(function (index, result) {
            index = index + 1;

            for (var page = 1; page <= result.pages; page++) {
              var _document = window.document;
              id = "result-".concat(index, "-").concat(page);
              imgArea = _document.createElement('div');
              imgNav = _document.createElement('li');
              imgNavA = _document.createElement('a');
              downloadLink = _document.createElement('a');
              reAssignLink = _document.createElement('a');
              imgArea.id = id;
              imgArea.className = index == 1 && page === 1 ? "viewer active" : "viewer";
              imgNavA.className = index == 1 && page == 1 ? "nav-link active" : "nav-link";
              imgNavA.setAttribute('data-toggle', 'tab');
              imgNavA.setAttribute('href', '#' + id);
              imgNavA.textContent = "Image ".concat(index, " - Page ").concat(page);
              imgNav.className = "nav-item";
              imgNav.appendChild(imgNavA);
              resultTabs.append(imgNav);
              resultsArea.append(imgArea);
              $("#" + id).iviewer({
                src: options.imageLink.replace('-1', result.id).replace('-1', page),
                zoom: 50
              });
              downloadLink.setAttribute('href', changeUrlResource(options.downloadsLink, result.id));
              downloadLink.setAttribute('target', '_blank');
              downloadLink.setAttribute('class', 'pod__download-link btn btn-sm btn-success');
              downloadLink.textContent = "Download";
              reAssignLink.setAttribute('href', options.reAssignLink + '?imageName=' + result.imageName + '&type=' + result.type);
              reAssignLink.setAttribute('target', '_blank');
              reAssignLink.setAttribute('class', 'pod__reassign-link btn btn-sm btn-primary');
              reAssignLink.textContent = "Re-Assign Type";
              imgArea.appendChild(downloadLink);
              imgArea.appendChild(reAssignLink);
            }
          });
        },
        error: function error(jqXHR) {
          loading.stop();
          Object(_plugins_processAjaxErrorResponse__WEBPACK_IMPORTED_MODULE_0__["default"])(jqXHR);
        },
        statusCode: {
          404: function _() {
            fetchPDF(id);
          }
        }
      });
    };

    var fetchPDF = function fetchPDF(id) {
      var resultsArea = $('#podResult');
      resultsArea.empty();
      loading.stop();
      enableButtons();
      var imgArea = document.createElement('iframe');
      imgArea.src = options.pdfLink + '/?waybill_number=' + id;
      imgArea.className = "pdf-viewer";
      resultsArea.append(imgArea);
    };

    var enableButtons = function enableButtons() {
      $('#podAssignButton').prop('disabled', false);
      $('#podReplaceButton').prop('disabled', false);
      $('#podUploadButton').prop('disabled', false);
    };

    return {
      queryForResults: queryForResults,
      fetchResults: fetchResults,
      fetchPdf: fetchPDF
    };
  };
})(jQuery);
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./resources/assets/js/plugins/createAlert.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/plugins/createAlert.js ***!
  \****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
var createAlert = function createAlert() {
  var customOptions = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
  var defaultOptions = {
    message: "",
    type: "danger",
    dismissable: true,
    html: false
  };
  var options = Object.assign({}, defaultOptions, customOptions);
  var closeButton = document.createElement('a'),
      alert = document.createElement('div'),
      wrapper = document.getElementById('alerts');
  closeButton.className = 'close';
  closeButton.setAttribute('data-dismiss', 'alert');
  closeButton.innerText = '×';
  alert.className = 'alert alert-' + options.type;

  if (options.html) {
    alert.innerHTML = options.message;
  } else {
    alert.innerText = options.message;
  }

  if (options.dismissable) {
    alert.appendChild(closeButton);
  }

  wrapper.appendChild(alert);
};

/* harmony default export */ __webpack_exports__["default"] = (createAlert);

/***/ }),

/***/ "./resources/assets/js/plugins/processAjaxErrorResponse.js":
/*!*****************************************************************!*\
  !*** ./resources/assets/js/plugins/processAjaxErrorResponse.js ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _createAlert__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./createAlert */ "./resources/assets/js/plugins/createAlert.js");
/* harmony import */ var toastr__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! toastr */ "./node_modules/toastr/toastr.js");
/* harmony import */ var toastr__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(toastr__WEBPACK_IMPORTED_MODULE_1__);
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }




var processAjaxResponse = function processAjaxResponse(response, useToastr) {
  "use strict";

  useToastr = useToastr || false;

  var showError = function showError(message) {
    if (useToastr) {
      toastr__WEBPACK_IMPORTED_MODULE_1___default.a.error(message);
    } else {
      Object(_createAlert__WEBPACK_IMPORTED_MODULE_0__["default"])({
        type: 'danger',
        message: message
      });
    }
  };

  if (typeof response !== 'undefined') {
    // Handle TokenMismatch
    if (response.status === 419) {
      showError("Your request timed out, please refresh the page and try again.");
      return;
    }

    var error = {};

    if (response.hasOwnProperty('responseText')) {
      // The web server (apache, haproxy) returned an error page
      if (response.responseText.substr(0, 1) === '<') {
        error = ['Server error'];
      } else {
        var text = JSON.parse(response.responseText);
        error = text.hasOwnProperty('error') ? text.error : [text.message];
      }
    }

    if (_typeof(error) === 'object' && error.length) {
      var _iterator = _createForOfIteratorHelper(error),
          _step;

      try {
        for (_iterator.s(); !(_step = _iterator.n()).done;) {
          var value = _step.value;
          showError(value);
        }
      } catch (err) {
        _iterator.e(err);
      } finally {
        _iterator.f();
      }
    } else {
      var messages = error.message.split(/\. |,/).reverse();

      var _iterator2 = _createForOfIteratorHelper(messages),
          _step2;

      try {
        for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
          var message = _step2.value;
          showError(message.trim());
        }
      } catch (err) {
        _iterator2.e(err);
      } finally {
        _iterator2.f();
      }
    }
  }
};

/* harmony default export */ __webpack_exports__["default"] = (processAjaxResponse);

/***/ }),

/***/ "./resources/assets/js/plugins/showLoading.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/plugins/showLoading.js ***!
  \****************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* WEBPACK VAR INJECTION */(function(jQuery) {/* harmony import */ var spin_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! spin.js */ "./node_modules/spin.js/spin.js");


__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

(function ($) {
  var defaultOptions = {
    lines: 15,
    // The number of lines to draw
    length: 40,
    // The length of each line
    width: 10,
    // The line thickness
    radius: 45,
    // The radius of the inner circle
    corners: 1,
    // Corner roundness (0..1)
    rotate: 0,
    // The rotation offset
    direction: 1,
    // 1: clockwise, -1: counterclockwise
    color: '#848484',
    // #rgb or #rrggbb or array of colors
    speed: 1,
    // Rounds per second
    shadow: true,
    // Whether to render a shadow
    className: 'spinner',
    // The CSS class to assign to the spinner
    zIndex: 20000000,
    // The z-index (defaults to 2000000000)
    top: '50%',
    // Top position relative to parent
    left: '50%',
    // Left position relative to parent
    position: 'fixed'
  };

  $.fn.showLoading = function (customOptions) {
    var options = $.extend({}, defaultOptions, customOptions);
    var element = this[0] || document.body;
    var spinner = new spin_js__WEBPACK_IMPORTED_MODULE_0__["Spinner"](options).spin(element);
    return spinner;
  };
})(jQuery);
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js")))

/***/ }),

/***/ "./resources/assets/js/vendor/iviewer.js":
/*!***********************************************!*\
  !*** ./resources/assets/js/vendor/iviewer.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");

__webpack_require__(/*! jquery-ui/ui/widget */ "./node_modules/jquery-ui/ui/widget.js");

__webpack_require__(/*! jquery-ui/ui/widgets/mouse */ "./node_modules/jquery-ui/ui/widgets/mouse.js");

__webpack_require__(/*! jquery-mousewheel */ "./node_modules/jquery-mousewheel/jquery.mousewheel.js");

__webpack_require__(/*! iviewer/jquery.iviewer */ "./node_modules/iviewer/jquery.iviewer.js");

/***/ }),

/***/ 13:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/components/pod/main.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /var/www/collivery_net/resources/assets/js/components/pod/main.js */"./resources/assets/js/components/pod/main.js");


/***/ })

},[[13,"/js/manifest","/js/vendor"]]]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvaXZpZXdlci9qcXVlcnkuaXZpZXdlci5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LW1vdXNld2hlZWwvanF1ZXJ5Lm1vdXNld2hlZWwuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS9pZS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvanF1ZXJ5LXVpL3VpL3ZlcnNpb24uanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS93aWRnZXQuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2pxdWVyeS11aS91aS93aWRnZXRzL21vdXNlLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9zcGluLmpzL3NwaW4uanMiLCJ3ZWJwYWNrOi8vLyh3ZWJwYWNrKS9idWlsZGluL2FtZC1kZWZpbmUuanMiLCJ3ZWJwYWNrOi8vLy4vcmVzb3VyY2VzL2Fzc2V0cy9qcy9jb21wb25lbnRzL3BvZC9tYWluLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvcGx1Z2lucy9jcmVhdGVBbGVydC5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3BsdWdpbnMvcHJvY2Vzc0FqYXhFcnJvclJlc3BvbnNlLmpzIiwid2VicGFjazovLy8uL3Jlc291cmNlcy9hc3NldHMvanMvcGx1Z2lucy9zaG93TG9hZGluZy5qcyIsIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvYXNzZXRzL2pzL3ZlbmRvci9pdmlld2VyLmpzIl0sIm5hbWVzIjpbInJlcXVpcmUiLCIkIiwiZGVmYXVsdE9wdGlvbnMiLCJxdWVyeUxpbmsiLCJkb3dubG9hZHNMaW5rIiwicmVBc3NpZ25MaW5rIiwiZmV0Y2hSZXN1bHRzTGluayIsImltYWdlTGluayIsInBkZkxpbmsiLCJsb2FkaW5nIiwib3B0aW9ucyIsImZuIiwicG9kU2NyaXB0cyIsImN1c3RvbU9wdGlvbnMiLCJleHRlbmQiLCJxdWVyeUZvclJlc3VsdHMiLCJ3YXliaWxsTnVtYmVyIiwidHlwZSIsImFqYXgiLCJ1cmwiLCJkYXRhIiwid2F5YmlsbF9udW1iZXIiLCJzdWNjZXNzIiwiZWFjaCIsImluZGV4Iiwid2F5YmlsbCIsImZldGNoUmVzdWx0cyIsImlkIiwiZXJyb3IiLCJqcVhIUiIsInN0b3AiLCJwcm9jZXNzQWpheEVycm9yUmVzcG9uc2UiLCJyZXN1bHRzQXJlYSIsInJlc3VsdFRhYnMiLCJiZWZvcmVTZW5kIiwiZW1wdHkiLCJpbWdBcmVhIiwiaW1nTmF2IiwiaW1nTmF2QSIsImRvd25sb2FkTGluayIsImVuYWJsZUJ1dHRvbnMiLCJyZXN1bHQiLCJwYWdlIiwicGFnZXMiLCJkb2N1bWVudCIsIndpbmRvdyIsImNyZWF0ZUVsZW1lbnQiLCJjbGFzc05hbWUiLCJzZXRBdHRyaWJ1dGUiLCJ0ZXh0Q29udGVudCIsImFwcGVuZENoaWxkIiwiYXBwZW5kIiwiaXZpZXdlciIsInNyYyIsInJlcGxhY2UiLCJ6b29tIiwiY2hhbmdlVXJsUmVzb3VyY2UiLCJpbWFnZU5hbWUiLCJzdGF0dXNDb2RlIiwiZmV0Y2hQREYiLCJwcm9wIiwiZmV0Y2hQZGYiLCJqUXVlcnkiLCJjcmVhdGVBbGVydCIsIm1lc3NhZ2UiLCJkaXNtaXNzYWJsZSIsImh0bWwiLCJPYmplY3QiLCJhc3NpZ24iLCJjbG9zZUJ1dHRvbiIsImFsZXJ0Iiwid3JhcHBlciIsImdldEVsZW1lbnRCeUlkIiwiaW5uZXJUZXh0IiwiaW5uZXJIVE1MIiwicHJvY2Vzc0FqYXhSZXNwb25zZSIsInJlc3BvbnNlIiwidXNlVG9hc3RyIiwic2hvd0Vycm9yIiwidG9hc3RyIiwic3RhdHVzIiwiaGFzT3duUHJvcGVydHkiLCJyZXNwb25zZVRleHQiLCJzdWJzdHIiLCJ0ZXh0IiwiSlNPTiIsInBhcnNlIiwibGVuZ3RoIiwidmFsdWUiLCJtZXNzYWdlcyIsInNwbGl0IiwicmV2ZXJzZSIsInRyaW0iLCJsaW5lcyIsIndpZHRoIiwicmFkaXVzIiwiY29ybmVycyIsInJvdGF0ZSIsImRpcmVjdGlvbiIsImNvbG9yIiwic3BlZWQiLCJzaGFkb3ciLCJ6SW5kZXgiLCJ0b3AiLCJsZWZ0IiwicG9zaXRpb24iLCJzaG93TG9hZGluZyIsImVsZW1lbnQiLCJib2R5Iiwic3Bpbm5lciIsIlNwaW5uZXIiLCJzcGluIl0sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7OztBQUdBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxLQUFLO0FBQ0w7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSx3RUFBd0UsUUFBUTtBQUNoRjtBQUNBO0FBQ0EsS0FBSzs7QUFFTDtBQUNBO0FBQ0EsdUdBQXVHLFFBQVE7QUFDL0c7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUztBQUNUO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLFNBQVM7O0FBRVQ7QUFDQTtBQUNBO0FBQ0E7QUFDQSxTQUFTOztBQUVUO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsU0FBUzs7QUFFVDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsS0FBSztBQUNMO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxzQkFBc0IsaUJBQWlCO0FBQ3ZDO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEtBQUs7O0FBRUw7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBLDhCQUE4QixhQUFhO0FBQzNDLGlDQUFpQyxhQUFhO0FBQzlDO0FBQ0E7O0FBRUEsOEJBQThCOztBQUU5Qjs7QUFFQTs7QUFFQTtBQUNBO0FBQ0E7O0FBRUE7O0FBRUE7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxhQUFhO0FBQ2I7O0FBRUE7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBLHFCQUFxQjtBQUNyQixpQkFBaUI7QUFDakI7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQSxpQkFBaUI7QUFDakIsU0FBUztB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QTtBQUNBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0EsR0FBRzs7QUFFSDtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQSxFQUFFOztBQUVGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSDtBQUNBO0FBQ0E7O0FBRUE7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQSxJQUFJO0FBQ0o7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLEVBQUU7O0FBRUY7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBLElBQUk7QUFDSjtBQUNBO0FBQ0E7QUFDQSxHQUFHO0FBQ0gsRUFBRTs7QUFFRjtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EsSUFBSTtBQUNKO0FBQ0E7QUFDQTtBQUNBLEdBQUc7QUFDSCxFQUFFOztBQUVGO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBO0FBQ0E7QUFDQTs7QUFFQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FBRUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQUVBLFNBQVMsa0NBQWtDO0FBQzND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QUFsQztBQUNBLFFBQUlDLE9BQU8sR0FBRyxJQUFJQywrQ0FBSixDQUFZcEcsT0FBWixFQUFxQnFHLElBQXJCLENBQTBCSixPQUExQixDQUFkO0FBRUEsV0FBT0UsT0FBUDtBQUNILEdBUkQ7QUFXRCxDQTlCRCxFQThCRy9DLE1BOUJILEU7Ozs7Ozs7Ozs7OztBQ0hBOUQsbUJBQU8sQ0FBQyxvREFBRCxDQUFQOztBQUNBQSxtQkFBTyxDQUFDLGtFQUFELENBQVA7O0FBQ0FBLG1CQUFPLENBQUMsZ0ZBQUQsQ0FBUDs7QUFDQUEsbUJBQU8sQ0FBQyxnRkFBRCxDQUFQOztBQUNBQSxtQkFBTyxDQUFDLHdFQUFELENBQVAsQyIsImZpbGUiOiIvanMvcG9kLmpzIiwic291cmNlc0NvbnRlbnQiOlsiLypcbiAqIGl2aWV3ZXIgV2lkZ2V0IGZvciBqUXVlcnkgVUlcbiAqIGh0dHBzOi8vZ2l0aHViLmNvbS9jYW4zcC9pdmlld2VyXG4gKlxuICogQ29weXJpZ2h0IChjKSAyMDA5IC0gMjAxMyBEbWl0cnkgUGV0cm92XG4gKiBEdWFsIGxpY2Vuc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqICAtIGh0dHA6Ly93d3cub3BlbnNvdXJjZS5vcmcvbGljZW5zZXMvbWl0LWxpY2Vuc2UucGhwXG4gKlxuICogQXV0aG9yOiBEbWl0cnkgUGV0cm92XG4gKiBWZXJzaW9uOiAwLjcuMTFcbiAqL1xuXG4oIGZ1bmN0aW9uKCAkLCB1bmRlZmluZWQgKSB7XG5cbi8vdGhpcyBjb2RlIHdhcyB0YWtlbiBmcm9tIHRoZSBodHRwczovL2dpdGh1Yi5jb20vZnVyZi9qcXVlcnktdWktdG91Y2gtcHVuY2hcbnZhciBtb3VzZUV2ZW50cyA9IHtcbiAgICAgICAgdG91Y2hzdGFydDogJ21vdXNlZG93bicsXG4gICAgICAgIHRvdWNobW92ZTogJ21vdXNlbW92ZScsXG4gICAgICAgIHRvdWNoZW5kOiAnbW91c2V1cCdcbiAgICB9LFxuICAgIGdlc3R1cmVzU3VwcG9ydCA9ICdvbmdlc3R1cmVzdGFydCcgaW4gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2Jyk7XG5cblxuLyoqXG4gKiBDb252ZXJ0IGEgdG91Y2ggZXZlbnQgdG8gYSBtb3VzZS1saWtlXG4gKi9cbmZ1bmN0aW9uIG1ha2VNb3VzZUV2ZW50IChldmVudCkge1xuICAgIHZhciB0b3VjaCA9IGV2ZW50Lm9yaWdpbmFsRXZlbnQuY2hhbmdlZFRvdWNoZXNbMF07XG5cbiAgICByZXR1cm4gJC5leHRlbmQoZXZlbnQsIHtcbiAgICAgICAgdHlwZTogICAgbW91c2VFdmVudHNbZXZlbnQudHlwZV0sXG4gICAgICAgIHdoaWNoOiAgIDEsXG4gICAgICAgIHBhZ2VYOiAgIHRvdWNoLnBhZ2VYLFxuICAgICAgICBwYWdlWTogICB0b3VjaC5wYWdlWSxcbiAgICAgICAgc2NyZWVuWDogdG91Y2guc2NyZWVuWCxcbiAgICAgICAgc2NyZWVuWTogdG91Y2guc2NyZWVuWSxcbiAgICAgICAgY2xpZW50WDogdG91Y2guY2xpZW50WCxcbiAgICAgICAgY2xpZW50WTogdG91Y2guY2xpZW50WSxcbiAgICAgICAgaXNUb3VjaEV2ZW50OiB0cnVlXG4gICAgfSk7XG59XG5cbnZhciBtb3VzZVByb3RvID0gJC51aS5tb3VzZS5wcm90b3R5cGUsXG4gICAgX21vdXNlSW5pdCA9ICQudWkubW91c2UucHJvdG90eXBlLl9tb3VzZUluaXQ7XG5cbm1vdXNlUHJvdG8uX21vdXNlSW5pdCA9IGZ1bmN0aW9uKCkge1xuICAgIHZhciBzZWxmID0gdGhpcztcbiAgICBzZWxmLl90b3VjaEFjdGl2ZSA9IGZhbHNlO1xuXG4gICAgdGhpcy5lbGVtZW50LmJpbmQoICd0b3VjaHN0YXJ0LicgKyB0aGlzLndpZGdldE5hbWUsIGZ1bmN0aW9uKGV2ZW50KSB7XG4gICAgICAgIGlmIChnZXN0dXJlc1N1cHBvcnQgJiYgZXZlbnQub3JpZ2luYWxFdmVudC50b3VjaGVzLmxlbmd0aCA+IDEpIHsgcmV0dXJuOyB9XG4gICAgICAgIHNlbGYuX3RvdWNoQWN0aXZlID0gdHJ1ZTtcbiAgICAgICAgcmV0dXJuIHNlbGYuX21vdXNlRG93bihtYWtlTW91c2VFdmVudChldmVudCkpO1xuICAgIH0pO1xuXG4gICAgLy8gdGhlc2UgZGVsZWdhdGVzIGFyZSByZXF1aXJlZCB0byBrZWVwIGNvbnRleHRcbiAgICB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSA9IGZ1bmN0aW9uKGV2ZW50KSB7XG4gICAgICAgIGlmIChnZXN0dXJlc1N1cHBvcnQgJiYgZXZlbnQub3JpZ2luYWxFdmVudC50b3VjaGVzICYmIGV2ZW50Lm9yaWdpbmFsRXZlbnQudG91Y2hlcy5sZW5ndGggPiAxKSB7IHJldHVybjsgfVxuICAgICAgICBpZiAoc2VsZi5fdG91Y2hBY3RpdmUpIHtcbiAgICAgICAgICAgIHJldHVybiBzZWxmLl9tb3VzZU1vdmUobWFrZU1vdXNlRXZlbnQoZXZlbnQpKTtcbiAgICAgICAgfVxuICAgIH07XG4gICAgdGhpcy5fbW91c2VVcERlbGVnYXRlID0gZnVuY3Rpb24oZXZlbnQpIHtcbiAgICAgICAgaWYgKHNlbGYuX3RvdWNoQWN0aXZlKSB7XG4gICAgICAgICAgICBzZWxmLl90b3VjaEFjdGl2ZSA9IGZhbHNlO1xuICAgICAgICAgICAgcmV0dXJuIHNlbGYuX21vdXNlVXAobWFrZU1vdXNlRXZlbnQoZXZlbnQpKTtcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICAkKGRvY3VtZW50KVxuICAgICAgICAuYmluZCgndG91Y2htb3ZlLicrIHRoaXMud2lkZ2V0TmFtZSwgdGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUpXG4gICAgICAgIC5iaW5kKCd0b3VjaGVuZC4nICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUpO1xuXG4gICAgX21vdXNlSW5pdC5hcHBseSh0aGlzKTtcbn07XG5cbi8qKlxuICogU2ltcGxlIGltcGxlbWVudGF0aW9uIG9mIGpRdWVyeSBsaWtlIGdldHRlcnMvc2V0dGVyc1xuICogdmFyIHZhbCA9IHNvbWV0aGluZygpO1xuICogc29tZXRoaW5nKHZhbCk7XG4gKi9cbnZhciBzZXR0ZXIgPSBmdW5jdGlvbihzZXR0ZXIsIGdldHRlcikge1xuICAgIHJldHVybiBmdW5jdGlvbih2YWwpIHtcbiAgICAgICAgaWYgKGFyZ3VtZW50cy5sZW5ndGggPT09IDApIHtcbiAgICAgICAgICAgIHJldHVybiBnZXR0ZXIuYXBwbHkodGhpcyk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBzZXR0ZXIuYXBwbHkodGhpcywgYXJndW1lbnRzKTtcbiAgICAgICAgfVxuICAgIH1cbn07XG5cbi8qKlxuICogSW50ZXJuZXQgZXhwbG9yZXIgcm90YXRlcyBpbWFnZSByZWxhdGl2ZSBsZWZ0IHRvcCBjb3JuZXIsIHNvIHdlIHNob3VsZFxuICogc2hpZnQgaW1hZ2Ugd2hlbiBpdCdzIHJvdGF0ZWQuXG4gKi9cbnZhciBpZVRyYW5zZm9ybXMgPSB7XG4gICAgICAgICcwJzoge1xuICAgICAgICAgICAgbWFyZ2luTGVmdDogMCxcbiAgICAgICAgICAgIG1hcmdpblRvcDogMCxcbiAgICAgICAgICAgIGZpbHRlcjogJ3Byb2dpZDpEWEltYWdlVHJhbnNmb3JtLk1pY3Jvc29mdC5NYXRyaXgoTTExPTEsIE0xMj0wLCBNMjE9MCwgTTIyPTEsIFNpemluZ01ldGhvZD1cImF1dG8gZXhwYW5kXCIpJ1xuICAgICAgICB9LFxuXG4gICAgICAgICc5MCc6IHtcbiAgICAgICAgICAgIG1hcmdpbkxlZnQ6IC0xLFxuICAgICAgICAgICAgbWFyZ2luVG9wOiAxLFxuICAgICAgICAgICAgZmlsdGVyOiAncHJvZ2lkOkRYSW1hZ2VUcmFuc2Zvcm0uTWljcm9zb2Z0Lk1hdHJpeChNMTE9MCwgTTEyPS0xLCBNMjE9MSwgTTIyPTAsIFNpemluZ01ldGhvZD1cImF1dG8gZXhwYW5kXCIpJ1xuICAgICAgICB9LFxuXG4gICAgICAgICcxODAnOiB7XG4gICAgICAgICAgICBtYXJnaW5MZWZ0OiAwLFxuICAgICAgICAgICAgbWFyZ2luVG9wOiAwLFxuICAgICAgICAgICAgZmlsdGVyOiAncHJvZ2lkOkRYSW1hZ2VUcmFuc2Zvcm0uTWljcm9zb2Z0Lk1hdHJpeChNMTE9LTEsIE0xMj0wLCBNMjE9MCwgTTIyPS0xLCBTaXppbmdNZXRob2Q9XCJhdXRvIGV4cGFuZFwiKSdcbiAgICAgICAgfSxcblxuICAgICAgICAnMjcwJzoge1xuICAgICAgICAgICAgbWFyZ2luTGVmdDogLTEsXG4gICAgICAgICAgICBtYXJnaW5Ub3A6IDEsXG4gICAgICAgICAgICBmaWx0ZXI6ICdwcm9naWQ6RFhJbWFnZVRyYW5zZm9ybS5NaWNyb3NvZnQuTWF0cml4KE0xMT0wLCBNMTI9MSwgTTIxPS0xLCBNMjI9MCwgU2l6aW5nTWV0aG9kPVwiYXV0byBleHBhbmRcIiknXG4gICAgICAgIH1cbiAgICB9LFxuICAgIC8vIHRoaXMgdGVzdCBpcyB0aGUgaW52ZXJzaW9uIG9mIHRoZSBjc3MgZmlsdGVycyB0ZXN0IGZyb20gdGhlIG1vZGVybml6ciBwcm9qZWN0XG4gICAgdXNlSWVUcmFuc2Zvcm1zID0gZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBtb2RFbGVtID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnbW9kZXJuaXpyJyksXG4gICAgICAgICAgICBtU3R5bGUgPSBtb2RFbGVtLnN0eWxlLFxuICAgICAgICAgICAgb21QcmVmaXhlcyA9ICdXZWJraXQgTW96IE8gbXMnLFxuICAgICAgICAgICAgZG9tUHJlZml4ZXMgPSBvbVByZWZpeGVzLnRvTG93ZXJDYXNlKCkuc3BsaXQoJyAnKSxcbiAgICAgICAgICAgIHByb3BzID0gKFwidHJhbnNmb3JtXCIgKyAnICcgKyBkb21QcmVmaXhlcy5qb2luKFwiVHJhbnNmb3JtIFwiKSArIFwiVHJhbnNmb3JtXCIpLnNwbGl0KCcgJyk7XG4gICAgICAgIC8qdXNpbmcgJ2ZvcicgbG9vcCBpbnN0ZWFkIG9mICdmb3IgaW4nIHRvIGF2b2lkIGlzc3VlcyBpbiBJRTgqL1xuICAgICAgICBmb3IgKCB2YXIgaT0wOyBpPCBwcm9wcy5sZW5ndGg7aSsrICkge1xuICAgICAgICAgICAgdmFyIHByb3AgPSBwcm9wc1tpXTtcbiAgICAgICAgICAgIGlmICggcHJvcC5pbmRleE9mKFwiLVwiKSA9PSAtMSAmJiBtU3R5bGVbcHJvcF0gIT09IHVuZGVmaW5lZCApIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gZmFsc2U7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgICAgcmV0dXJuIHRydWU7XG4gICAgfSgpO1xuXG4kLndpZGdldCggXCJ1aS5pdmlld2VyXCIsICQudWkubW91c2UsIHtcbiAgICB3aWRnZXRFdmVudFByZWZpeDogXCJpdmlld2VyXCIsXG4gICAgb3B0aW9ucyA6IHtcbiAgICAgICAgLyoqXG4gICAgICAgICogc3RhcnQgem9vbSB2YWx1ZSBmb3IgaW1hZ2UsIG5vdCB1c2VkIG5vd1xuICAgICAgICAqIG1heSBiZSBlcXVhbCB0byBcImZpdFwiIHRvIGZpdCBpbWFnZSBpbnRvIGNvbnRhaW5lciBvciBzY2FsZSBpbiAlXG4gICAgICAgICoqL1xuICAgICAgICB6b29tOiBcImZpdFwiLFxuICAgICAgICAvKipcbiAgICAgICAgKiBiYXNlIHZhbHVlIHRvIHNjYWxlIGltYWdlXG4gICAgICAgICoqL1xuICAgICAgICB6b29tX2Jhc2U6IDEwMCxcbiAgICAgICAgLyoqXG4gICAgICAgICogbWF4aW11bSB6b29tXG4gICAgICAgICoqL1xuICAgICAgICB6b29tX21heDogODAwLFxuICAgICAgICAvKipcbiAgICAgICAgKiBtaW5pbXVtIHpvb21cbiAgICAgICAgKiovXG4gICAgICAgIHpvb21fbWluOiAyNSxcbiAgICAgICAgLyoqXG4gICAgICAgICogYmFzZSBvZiByYXRlIG11bHRpcGxpZXIuXG4gICAgICAgICogem9vbSBpcyBjYWxjdWxhdGVkIGJ5IGZvcm11bGE6IHpvb21fYmFzZSAqIHpvb21fZGVsdGFecmF0ZVxuICAgICAgICAqKi9cbiAgICAgICAgem9vbV9kZWx0YTogMS40LFxuICAgICAgICAvKipcbiAgICAgICAgKiB3aGV0aGVyIHRoZSB6b29tIHNob3VsZCBiZSBhbmltYXRlZC5cbiAgICAgICAgKi9cbiAgICAgICAgem9vbV9hbmltYXRpb246IHRydWUsXG4gICAgICAgIC8qKlxuICAgICAgICAqIGlmIHRydWUgcGx1Z2luIGRvZXNuJ3QgYWRkIGl0cyBvd24gY29udHJvbHNcbiAgICAgICAgKiovXG4gICAgICAgIHVpX2Rpc2FibGVkOiBmYWxzZSxcbiAgICAgICAgLyoqXG4gICAgICAgICAqIElmIGZhbHNlIG1vdXNld2hlZWwgd2lsbCBiZSBkaXNhYmxlZFxuICAgICAgICAgKi9cbiAgICAgICAgbW91c2V3aGVlbDogdHJ1ZSxcbiAgICAgICAgLyoqXG4gICAgICAgICogaWYgZmFsc2UsIHBsdWdpbiBkb2Vzbid0IGJpbmQgcmVzaXplIGV2ZW50IG9uIHdpbmRvdyBhbmQgdGhpcyBtdXN0XG4gICAgICAgICogYmUgaGFuZGxlZCBtYW51YWxseVxuICAgICAgICAqKi9cbiAgICAgICAgdXBkYXRlX29uX3Jlc2l6ZTogdHJ1ZSxcbiAgICAgICAgLyoqXG4gICAgICAgICogd2hldGhlciB0byBwcm92aWRlIHpvb20gb24gZG91YmxlY2xpY2sgZnVuY3Rpb25hbGl0eVxuICAgICAgICAqL1xuICAgICAgICB6b29tX29uX2RibGNsaWNrOiB0cnVlLFxuICAgICAgICAvKipcbiAgICAgICAgKiBpZiB0cnVlIHRoZSBpbWFnZSB3aWxsIGZpbGwgdGhlIGNvbnRhaW5lciBhbmQgdGhlIGltYWdlIHdpbGwgYmUgZGlzdG9ydGVkXG4gICAgICAgICovXG4gICAgICAgIGZpbGxfY29udGFpbmVyOiBmYWxzZSxcbiAgICAgICAgLyoqXG4gICAgICAgICogZXZlbnQgaXMgdHJpZ2dlcmVkIHdoZW4gem9vbSB2YWx1ZSBpcyBjaGFuZ2VkXG4gICAgICAgICogQHBhcmFtIGludCBuZXcgem9vbSB2YWx1ZVxuICAgICAgICAqIEByZXR1cm4gYm9vbGVhbiBpZiBmYWxzZSB6b29tIGFjdGlvbiBpcyBhYm9ydGVkXG4gICAgICAgICoqL1xuICAgICAgICBvblpvb206IGpRdWVyeS5ub29wLFxuICAgICAgICAvKipcbiAgICAgICAgKiBldmVudCBpcyB0cmlnZ2VyZWQgd2hlbiB6b29tIHZhbHVlIGlzIGNoYW5nZWQgYWZ0ZXIgaW1hZ2UgaXMgc2V0IHRvIHRoZSBuZXcgZGltZW5zaW9uc1xuICAgICAgICAqIEBwYXJhbSBpbnQgbmV3IHpvb20gdmFsdWVcbiAgICAgICAgKiBAcmV0dXJuIGJvb2xlYW4gaWYgZmFsc2Ugem9vbSBhY3Rpb24gaXMgYWJvcnRlZFxuICAgICAgICAqKi9cbiAgICAgICAgb25BZnRlclpvb206IGpRdWVyeS5ub29wLFxuICAgICAgICAvKipcbiAgICAgICAgKiBldmVudCBpcyBmaXJlZCBvbiBkcmFnIGJlZ2luXG4gICAgICAgICogQHBhcmFtIG9iamVjdCBjb29yZHMgbW91c2UgY29vcmRpbmF0ZXMgb24gdGhlIGltYWdlXG4gICAgICAgICogQHJldHVybiBib29sZWFuIGlmIGZhbHNlIGlzIHJldHVybmVkLCBkcmFnIGFjdGlvbiBpcyBhYm9ydGVkXG4gICAgICAgICoqL1xuICAgICAgICBvblN0YXJ0RHJhZzogalF1ZXJ5Lm5vb3AsXG4gICAgICAgIC8qKlxuICAgICAgICAqIGV2ZW50IGlzIGZpcmVkIG9uIGRyYWcgYWN0aW9uXG4gICAgICAgICogQHBhcmFtIG9iamVjdCBjb29yZHMgbW91c2UgY29vcmRpbmF0ZXMgb24gdGhlIGltYWdlXG4gICAgICAgICoqL1xuICAgICAgICBvbkRyYWc6IGpRdWVyeS5ub29wLFxuICAgICAgICAvKipcbiAgICAgICAgKiBldmVudCBpcyBmaXJlZCBvbiBkcmFnIHN0b3BcbiAgICAgICAgKiBAcGFyYW0gb2JqZWN0IGNvb3JkcyBtb3VzZSBjb29yZGluYXRlcyBvbiB0aGUgaW1hZ2VcbiAgICAgICAgKiovXG4gICAgICAgIG9uU3RvcERyYWc6IGpRdWVyeS5ub29wLFxuICAgICAgICAvKipcbiAgICAgICAgKiBldmVudCBpcyBmaXJlZCB3aGVuIG1vdXNlIG1vdmVzIG92ZXIgaW1hZ2VcbiAgICAgICAgKiBAcGFyYW0gb2JqZWN0IGNvb3JkcyBtb3VzZSBjb29yZGluYXRlcyBvbiB0aGUgaW1hZ2VcbiAgICAgICAgKiovXG4gICAgICAgIG9uTW91c2VNb3ZlOiBqUXVlcnkubm9vcCxcbiAgICAgICAgLyoqXG4gICAgICAgICogbW91c2UgY2xpY2sgZXZlbnRcbiAgICAgICAgKiBAcGFyYW0gb2JqZWN0IGNvb3JkcyBtb3VzZSBjb29yZGluYXRlcyBvbiB0aGUgaW1hZ2VcbiAgICAgICAgKiovXG4gICAgICAgIG9uQ2xpY2s6IGpRdWVyeS5ub29wLFxuICAgICAgICAvKipcbiAgICAgICAgKiBtb3VzZSBkb3VibGUgY2xpY2sgZXZlbnQuIElmIHVzZWQgd2lsbCBkZWxheSBlYWNoIGNsaWNrIGV2ZW50LlxuICAgICAgICAqIElmIGRvdWJsZSBjbGljayBldmVudCB3YXMgZmlyZWQsIGNsaWNrcyB3aWxsIG5vdC5cbiAgICAgICAgKlxuICAgICAgICAqIEBwYXJhbSBvYmplY3QgY29vcmRzIG1vdXNlIGNvb3JkaW5hdGVzIG9uIHRoZSBpbWFnZVxuICAgICAgICAqKi9cbiAgICAgICAgb25EYmxDbGljazogbnVsbCxcbiAgICAgICAgLyoqXG4gICAgICAgICogZXZlbnQgaXMgZmlyZWQgd2hlbiBpbWFnZSBzdGFydHMgdG8gbG9hZFxuICAgICAgICAqL1xuICAgICAgICBvblN0YXJ0TG9hZDogbnVsbCxcbiAgICAgICAgLyoqXG4gICAgICAgICogZXZlbnQgaXMgZmlyZWQsIHdoZW4gaW1hZ2UgaXMgbG9hZGVkIGFuZCBpbml0aWFsbHkgcG9zaXRpb25lZFxuICAgICAgICAqL1xuICAgICAgICBvbkZpbmlzaExvYWQ6IG51bGwsXG4gICAgICAgIC8qKlxuICAgICAgICAqIGV2ZW50IGlzIGZpcmVkIHdoZW4gaW1hZ2UgbG9hZCBlcnJvciBvY2N1cnNcbiAgICAgICAgKi9cbiAgICAgICAgb25FcnJvckxvYWQ6IG51bGxcbiAgICB9LFxuXG4gICAgX2NyZWF0ZTogZnVuY3Rpb24oKSB7XG4gICAgICAgIHZhciBtZSA9IHRoaXM7XG5cbiAgICAgICAgLy9kcmFnIHZhcmlhYmxlc1xuICAgICAgICB0aGlzLmR4ID0gMDtcbiAgICAgICAgdGhpcy5keSA9IDA7XG5cbiAgICAgICAgLyogb2JqZWN0IGNvbnRhaW5pbmcgYWN0dWFsIGluZm9ybWF0aW9uIGFib3V0IGltYWdlXG4gICAgICAgICogICBAaW1nX29iamVjdC5vYmplY3QgLSBqcXVlcnkgaW1nIG9iamVjdFxuICAgICAgICAqICAgQGltZ19vYmplY3Qub3JpZ197d2lkdGh8aGVpZ2h0fSAtIG9yaWdpbmFsIGRpbWVuc2lvbnNcbiAgICAgICAgKiAgIEBpbWdfb2JqZWN0LmRpc3BsYXlfe3dpZHRofGhlaWdodH0gLSBhY3R1YWwgZGltZW5zaW9uc1xuICAgICAgICAqL1xuICAgICAgICB0aGlzLmltZ19vYmplY3QgPSB7fTtcblxuICAgICAgICB0aGlzLnpvb21fb2JqZWN0ID0ge307IC8vb2JqZWN0IHRvIHNob3cgem9vbSBzdGF0dXNcblxuICAgICAgICB0aGlzLl9hbmdsZSA9IDA7XG5cbiAgICAgICAgdGhpcy5jdXJyZW50X3pvb20gPSB0aGlzLm9wdGlvbnMuem9vbTtcblxuICAgICAgICBpZih0aGlzLm9wdGlvbnMuc3JjID09PSBudWxsKXtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuY29udGFpbmVyID0gdGhpcy5lbGVtZW50O1xuXG4gICAgICAgIHRoaXMuX3VwZGF0ZUNvbnRhaW5lckluZm8oKTtcblxuICAgICAgICAvL2luaXQgY29udGFpbmVyXG4gICAgICAgIHRoaXMuY29udGFpbmVyLmNzcyhcIm92ZXJmbG93XCIsXCJoaWRkZW5cIik7XG5cbiAgICAgICAgaWYgKHRoaXMub3B0aW9ucy51cGRhdGVfb25fcmVzaXplID09IHRydWUpIHtcbiAgICAgICAgICAgICQod2luZG93KS5yZXNpemUoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICAgICAgbWUudXBkYXRlKCk7XG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuaW1nX29iamVjdCA9IG5ldyAkLnVpLml2aWV3ZXIuSW1hZ2VPYmplY3QodGhpcy5vcHRpb25zLnpvb21fYW5pbWF0aW9uKTtcblxuICAgICAgICBpZiAodGhpcy5vcHRpb25zLm1vdXNld2hlZWwpIHtcbiAgICAgICAgICAgIHRoaXMuYWN0aXZhdGVNb3VzZVdoZWVsKHRoaXMub3B0aW9ucy5tb3VzZXdoZWVsKTtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vYmluZCBkb3VibGVjbGljayBvbmx5IGlmIGNhbGxiYWNrIGlzIG5vdCBmYWxzeVxuICAgICAgICB2YXIgdXNlRGJsQ2xpY2sgPSAhIXRoaXMub3B0aW9ucy5vbkRibENsaWNrIHx8IHRoaXMub3B0aW9ucy56b29tX29uX2RibGNsaWNrLFxuICAgICAgICAgICAgZGJsQ2xpY2tUaW1lciA9IG51bGwsXG4gICAgICAgICAgICBjbGlja3NOdW1iZXIgPSAwO1xuXG4gICAgICAgIC8vaW5pdCBvYmplY3RcbiAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9iamVjdCgpXG4gICAgICAgICAgICAucHJlcGVuZFRvKHRoaXMuY29udGFpbmVyKTtcblxuICAgICAgICAvL2FsbCB0aGVzZSB0cmlja3MgYXJlIG5lZWRlZCB0byBmaXJlIGVpdGhlciBjbGlja1xuICAgICAgICAvL29yIGRvdWJsZWNsaWNrIGV2ZW50cyBhdCB0aGUgc2FtZSB0aW1lXG4gICAgICAgIGlmICh1c2VEYmxDbGljaykge1xuICAgICAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9iamVjdCgpXG4gICAgICAgICAgICAgICAgLy9iaW5kIG1vdXNlIGV2ZW50c1xuICAgICAgICAgICAgICAgIC5jbGljayhmdW5jdGlvbihlKXtcbiAgICAgICAgICAgICAgICAgICAgY2xpY2tzTnVtYmVyKys7XG4gICAgICAgICAgICAgICAgICAgIGNsZWFyVGltZW91dChkYmxDbGlja1RpbWVyKTtcblxuICAgICAgICAgICAgICAgICAgICBkYmxDbGlja1RpbWVyID0gc2V0VGltZW91dChmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIGNsaWNrc051bWJlciA9IDA7XG4gICAgICAgICAgICAgICAgICAgICAgICBtZS5fY2xpY2soZSk7XG4gICAgICAgICAgICAgICAgICAgIH0sIDMwMCk7XG4gICAgICAgICAgICAgICAgfSlcbiAgICAgICAgICAgICAgICAuZGJsY2xpY2soZnVuY3Rpb24oZSl7XG4gICAgICAgICAgICAgICAgICAgIGlmIChjbGlja3NOdW1iZXIgIT09IDIpIHJldHVybjtcblxuICAgICAgICAgICAgICAgICAgICBjbGVhclRpbWVvdXQoZGJsQ2xpY2tUaW1lcik7XG4gICAgICAgICAgICAgICAgICAgIGNsaWNrc051bWJlciA9IDA7XG4gICAgICAgICAgICAgICAgICAgIG1lLl9kYmxjbGljayhlKTtcbiAgICAgICAgICAgICAgICB9KTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHRoaXMuaW1nX29iamVjdC5vYmplY3QoKVxuICAgICAgICAgICAgICAgIC5jbGljayhmdW5jdGlvbihlKXsgbWUuX2NsaWNrKGUpOyB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuY29udGFpbmVyLmJpbmQoJ21vdXNlbW92ZS5pdmlld2VyJywgZnVuY3Rpb24oZXYpIHsgbWUuX2hhbmRsZU1vdXNlTW92ZShldik7IH0pO1xuXG4gICAgICAgIHRoaXMubG9hZEltYWdlKHRoaXMub3B0aW9ucy5zcmMpO1xuXG4gICAgICAgIGlmKCF0aGlzLm9wdGlvbnMudWlfZGlzYWJsZWQpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHRoaXMuY3JlYXRldWkoKTtcbiAgICAgICAgfVxuICAgICAgICB0aGlzLmNvbnRyb2xzID0gdGhpcy5jb250YWluZXIuZmluZCgnLml2aWV3ZXJfY29tbW9uJykgfHwge307XG4gICAgICAgIHRoaXMuX21vdXNlSW5pdCgpO1xuICAgIH0sXG5cbiAgICBkZXN0cm95OiBmdW5jdGlvbigpIHtcbiAgICAgICAgJC5XaWRnZXQucHJvdG90eXBlLmRlc3Ryb3kuY2FsbCggdGhpcyApO1xuICAgICAgICB0aGlzLl9tb3VzZURlc3Ryb3koKTtcbiAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9iamVjdCgpLnJlbW92ZSgpO1xuICAgICAgICAvKnJlbW92aW5nIHRoZSBjb250cm9scyBvbiBkZXN0cm95Ki9cbiAgICAgICAgdGhpcy5jb250cm9scy5yZW1vdmUoKTtcbiAgICAgICAgdGhpcy5jb250YWluZXIub2ZmKCcuaXZpZXdlcicpO1xuICAgICAgICB0aGlzLmNvbnRhaW5lci5jc3MoJ292ZXJmbG93JywgJycpOyAvL2NsZWFudXAgc3R5bGVzIG9uIGRlc3Ryb3lcbiAgICB9LFxuXG4gICAgX3VwZGF0ZUNvbnRhaW5lckluZm86IGZ1bmN0aW9uKClcbiAgICB7XG4gICAgICAgIHRoaXMub3B0aW9ucy5oZWlnaHQgPSB0aGlzLmNvbnRhaW5lci5oZWlnaHQoKTtcbiAgICAgICAgdGhpcy5vcHRpb25zLndpZHRoID0gdGhpcy5jb250YWluZXIud2lkdGgoKTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgICogQWRkIG9yIHJlbW92ZSB0aGUgbW91c2V3aGVlbCBlZmZlY3Qgb24gdGhlIHZpZXdlclxuICAgICAqIEBwYXJhbSB7Ym9vbGVhbn0gaXNBY3RpdmVcbiAgICAgKiBTYW1wbGUgOiAkKCcjdmlld2VyJykuaXZpZXdlcignYWN0aXZhdGVNb3VzZVdoZWVsJywgdHJ1ZSk7XG4gICAgICovXG4gICAgYWN0aXZhdGVNb3VzZVdoZWVsOiBmdW5jdGlvbihpc0FjdGl2ZSl7XG4gICAgICAgIC8vIFJlbW92ZSBhbGwgdGhlIHByZXZpb3VzIGV2ZW50IGJpbmQgb24gdGhlIG1vdXNld2hlZWxcbiAgICAgICAgdGhpcy5jb250YWluZXIudW5iaW5kKCdtb3VzZXdoZWVsLml2aWV3ZXInKTtcbiAgICAgICAgaWYgKGdlc3R1cmVzU3VwcG9ydCkge1xuICAgICAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9iamVjdCgpLnVuYmluZCgndG91Y2hzdGFydCcpLnVuYmluZCgnZ2VzdHVyZWNoYW5nZS5pdmlld2VyJykudW5iaW5kKCdnZXN0dXJlZW5kLml2aWV3ZXInKTtcbiAgICAgICAgfVxuXG4gICAgICAgIGlmIChpc0FjdGl2ZSkge1xuICAgICAgICAgICAgdmFyIG1lID0gdGhpcztcblxuICAgICAgICAgICAgdGhpcy5jb250YWluZXIuYmluZCgnbW91c2V3aGVlbC5pdmlld2VyJywgZnVuY3Rpb24oZXYsIGRlbHRhKVxuICAgICAgICAgICAgICAgIHtcbiAgICAgICAgICAgICAgICAgICAgLy90aGlzIGV2ZW50IGlzIHRoZXJlIGluc3RlYWQgb2YgY29udGFpbmluZyBkaXYsIGJlY2F1c2VcbiAgICAgICAgICAgICAgICAgICAgLy9hdCBvcGVyYSBpdCB0cmlnZ2VycyBtYW55IHRpbWVzIG9uIGRpdlxuICAgICAgICAgICAgICAgICAgICB2YXIgem9vbSA9IChkZWx0YSA+IDApPzE6LTEsXG4gICAgICAgICAgICAgICAgICAgICAgICBjb250YWluZXJfb2Zmc2V0ID0gbWUuY29udGFpbmVyLm9mZnNldCgpLFxuICAgICAgICAgICAgICAgICAgICAgICAgbW91c2VfcG9zID0ge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIC8vanF1ZXJ5Lm1vdXNld2hlZWwgMy4xLjAgdXNlcyBzdHJhbmdlIE1vek1vdXNlUGl4ZWxTY3JvbGwgZXZlbnRcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAvL3doaWNoIGlzIG5vdCBiZWluZyBmaXhlZCBieSBqUXVlcnkuRXZlbnRcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB4OiAoZXYucGFnZVggfHwgZXYub3JpZ2luYWxFdmVudC5wYWdlWCkgLSBjb250YWluZXJfb2Zmc2V0LmxlZnQsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgeTogKGV2LnBhZ2VZIHx8IGV2Lm9yaWdpbmFsRXZlbnQucGFnZVgpIC0gY29udGFpbmVyX29mZnNldC50b3BcbiAgICAgICAgICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgICAgIG1lLnpvb21fYnkoem9vbSwgbW91c2VfcG9zKTtcbiAgICAgICAgICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICBpZiAoZ2VzdHVyZXNTdXBwb3J0KSB7XG4gICAgICAgICAgICAgICAgdmFyIGdlc3R1cmVUaHJvdHRsZSA9ICtuZXcgRGF0ZSgpO1xuICAgICAgICAgICAgICAgIHZhciBvcmlnaW5hbFNjYWxlLCBvcmlnaW5hbENlbnRlcjtcbiAgICAgICAgICAgICAgICB0aGlzLmltZ19vYmplY3Qub2JqZWN0KClcbiAgICAgICAgICAgICAgICAgICAgLmJpbmQoJ3RvdWNoc3RhcnQnLCBmdW5jdGlvbihldikge1xuICAgICAgICAgICAgICAgICAgICAgICAgb3JpZ2luYWxTY2FsZSA9IG1lLmN1cnJlbnRfem9vbTtcbiAgICAgICAgICAgICAgICAgICAgICAgIHZhciB0b3VjaGVzID0gZXYub3JpZ2luYWxFdmVudC50b3VjaGVzLFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbnRhaW5lcl9vZmZzZXQ7XG4gICAgICAgICAgICAgICAgICAgICAgICBpZiAodG91Y2hlcy5sZW5ndGggPT0gMikge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIGNvbnRhaW5lcl9vZmZzZXQgPSBtZS5jb250YWluZXIub2Zmc2V0KCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgb3JpZ2luYWxDZW50ZXIgPSB7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHg6ICh0b3VjaGVzWzBdLnBhZ2VYICsgdG91Y2hlc1sxXS5wYWdlWCkgLyAyICAtIGNvbnRhaW5lcl9vZmZzZXQubGVmdCxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgeTogKHRvdWNoZXNbMF0ucGFnZVkgKyB0b3VjaGVzWzFdLnBhZ2VZKSAvIDIgLSBjb250YWluZXJfb2Zmc2V0LnRvcFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIH07XG4gICAgICAgICAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICAgICAgICAgIG9yaWdpbmFsQ2VudGVyID0gbnVsbDtcbiAgICAgICAgICAgICAgICAgICAgICAgIH1cbiAgICAgICAgICAgICAgICAgICAgfSkuYmluZCgnZ2VzdHVyZWNoYW5nZS5pdmlld2VyJywgZnVuY3Rpb24oZXYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIC8vZG8gbm90IHdhbnQgdG8gaW1wb3J0IHRocm90dGxlIGZ1bmN0aW9uIGZyb20gdW5kZXJzY29yZVxuICAgICAgICAgICAgICAgICAgICAgICAgdmFyIGQgPSArbmV3IERhdGUoKTtcbiAgICAgICAgICAgICAgICAgICAgICAgIGlmICgoZCAtIGdlc3R1cmVUaHJvdHRsZSkgPCA1MCkgeyByZXR1cm47IH1cbiAgICAgICAgICAgICAgICAgICAgICAgIGdlc3R1cmVUaHJvdHRsZSA9IGQ7XG4gICAgICAgICAgICAgICAgICAgICAgICB2YXIgem9vbSA9IG9yaWdpbmFsU2NhbGUgKiBldi5vcmlnaW5hbEV2ZW50LnNjYWxlO1xuICAgICAgICAgICAgICAgICAgICAgICAgbWUuc2V0X3pvb20oem9vbSwgb3JpZ2luYWxDZW50ZXIpO1xuICAgICAgICAgICAgICAgICAgICAgICAgZXYucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICAgICAgICAgICAgfSkuYmluZCgnZ2VzdHVyZWVuZC5pdmlld2VyJywgZnVuY3Rpb24oZXYpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgIG9yaWdpbmFsQ2VudGVyID0gbnVsbDtcbiAgICAgICAgICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICB9LFxuXG4gICAgdXBkYXRlOiBmdW5jdGlvbigpXG4gICAge1xuICAgICAgICB0aGlzLl91cGRhdGVDb250YWluZXJJbmZvKCk7XG4gICAgICAgIHRoaXMuc2V0Q29vcmRzKHRoaXMuaW1nX29iamVjdC54KCksIHRoaXMuaW1nX29iamVjdC55KCkpO1xuICAgIH0sXG5cbiAgICBsb2FkSW1hZ2U6IGZ1bmN0aW9uKCBzcmMgKVxuICAgIHtcbiAgICAgICAgdGhpcy5jdXJyZW50X3pvb20gPSB0aGlzLm9wdGlvbnMuem9vbTtcbiAgICAgICAgdmFyIG1lID0gdGhpcztcblxuICAgICAgICB0aGlzLl90cmlnZ2VyKCdvblN0YXJ0TG9hZCcsIDAsIHNyYyk7XG5cbiAgICAgICAgdGhpcy5jb250YWluZXIuYWRkQ2xhc3MoXCJpdmlld2VyX2xvYWRpbmdcIik7XG4gICAgICAgIHRoaXMuaW1nX29iamVjdC5sb2FkKHNyYywgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBtZS5fZmlsbF9vcmlnX2RpbWVuc2lvbnMgPSB7IHdpZHRoOiBtZS5pbWdfb2JqZWN0Lm9yaWdfd2lkdGgoKSwgaGVpZ2h0OiBtZS5pbWdfb2JqZWN0Lm9yaWdfaGVpZ2h0KCkgfTtcbiAgICAgICAgICAgIG1lLl9pbWFnZUxvYWRlZChzcmMpO1xuICAgICAgICB9LCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIG1lLl90cmlnZ2VyKFwib25FcnJvckxvYWRcIiwgMCwgc3JjKTtcbiAgICAgICAgfSk7XG4gICAgfSxcblxuICAgIF9pbWFnZUxvYWRlZDogZnVuY3Rpb24oc3JjKSB7XG4gICAgICAgIHRoaXMuY29udGFpbmVyLnJlbW92ZUNsYXNzKFwiaXZpZXdlcl9sb2FkaW5nXCIpO1xuICAgICAgICB0aGlzLmNvbnRhaW5lci5hZGRDbGFzcyhcIml2aWV3ZXJfY3Vyc29yXCIpO1xuXG4gICAgICAgIGlmKHRoaXMub3B0aW9ucy56b29tID09IFwiZml0XCIpe1xuICAgICAgICAgICAgdGhpcy5maXQodHJ1ZSk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICB0aGlzLnNldF96b29tKHRoaXMub3B0aW9ucy56b29tLCB0cnVlKTtcbiAgICAgICAgfVxuXG4gICAgICAgIHRoaXMuX3RyaWdnZXIoJ29uRmluaXNoTG9hZCcsIDAsIHNyYyk7XG5cbiAgICAgICAgaWYodGhpcy5vcHRpb25zLmZpbGxfY29udGFpbmVyKVxuICAgICAgICB7XG4gICAgICAgICAgdGhpcy5maWxsX2NvbnRhaW5lcih0cnVlKTtcbiAgICAgICAgfVxuICAgIH0sXG5cbiAgICAvKipcbiAgICAqIGZpdHMgaW1hZ2UgaW4gdGhlIGNvbnRhaW5lclxuICAgICpcbiAgICAqIEBwYXJhbSB7Ym9vbGVhbn0gc2tpcF9hbmltYXRpb25cbiAgICAqKi9cbiAgICBmaXQ6IGZ1bmN0aW9uKHNraXBfYW5pbWF0aW9uKVxuICAgIHtcbiAgICAgICAgdmFyIGFzcGVjdF9yYXRpbyA9IHRoaXMuaW1nX29iamVjdC5vcmlnX3dpZHRoKCkgLyB0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKTtcbiAgICAgICAgdmFyIHdpbmRvd19yYXRpbyA9IHRoaXMub3B0aW9ucy53aWR0aCAvICB0aGlzLm9wdGlvbnMuaGVpZ2h0O1xuICAgICAgICB2YXIgY2hvb3NlX2xlZnQgPSAoYXNwZWN0X3JhdGlvID4gd2luZG93X3JhdGlvKTtcbiAgICAgICAgdmFyIG5ld196b29tID0gMDtcblxuICAgICAgICBpZihjaG9vc2VfbGVmdCl7XG4gICAgICAgICAgICBuZXdfem9vbSA9IHRoaXMub3B0aW9ucy53aWR0aCAvIHRoaXMuaW1nX29iamVjdC5vcmlnX3dpZHRoKCkgKiAxMDA7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICBuZXdfem9vbSA9IHRoaXMub3B0aW9ucy5oZWlnaHQgLyB0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKSAqIDEwMDtcbiAgICAgICAgfVxuXG4gICAgICB0aGlzLnNldF96b29tKG5ld196b29tLCBza2lwX2FuaW1hdGlvbik7XG4gICAgfSxcblxuICAgIC8qKlxuICAgICogY2VudGVyIGltYWdlIGluIGNvbnRhaW5lclxuICAgICoqL1xuICAgIGNlbnRlcjogZnVuY3Rpb24oKVxuICAgIHtcbiAgICAgICAgdGhpcy5zZXRDb29yZHMoLU1hdGgucm91bmQoKHRoaXMuaW1nX29iamVjdC5kaXNwbGF5X3dpZHRoKCkgLSB0aGlzLm9wdGlvbnMud2lkdGgpLzIpLFxuICAgICAgICAgICAgICAgIC1NYXRoLnJvdW5kKCh0aGlzLmltZ19vYmplY3QuZGlzcGxheV9oZWlnaHQoKSAtIHRoaXMub3B0aW9ucy5oZWlnaHQpLzIpKTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgKiAgIG1vdmUgYSBwb2ludCBpbiBjb250YWluZXIgdG8gdGhlIGNlbnRlciBvZiBkaXNwbGF5IGFyZWFcbiAgICAqICAgQHBhcmFtIHggYSBwb2ludCBpbiBjb250YWluZXJcbiAgICAqICAgQHBhcmFtIHkgYSBwb2ludCBpbiBjb250YWluZXJcbiAgICAqKi9cbiAgICBtb3ZlVG86IGZ1bmN0aW9uKHgsIHkpXG4gICAge1xuICAgICAgICB2YXIgZHggPSB4LU1hdGgucm91bmQodGhpcy5vcHRpb25zLndpZHRoLzIpO1xuICAgICAgICB2YXIgZHkgPSB5LU1hdGgucm91bmQodGhpcy5vcHRpb25zLmhlaWdodC8yKTtcblxuICAgICAgICB2YXIgbmV3X3ggPSB0aGlzLmltZ19vYmplY3QueCgpIC0gZHg7XG4gICAgICAgIHZhciBuZXdfeSA9IHRoaXMuaW1nX29iamVjdC55KCkgLSBkeTtcblxuICAgICAgICB0aGlzLnNldENvb3JkcyhuZXdfeCwgbmV3X3kpO1xuICAgIH0sXG5cbiAgICAvKipcbiAgICAgKiBHZXQgY29udGFpbmVyIG9mZnNldCBvYmplY3QuXG4gICAgICovXG4gICAgZ2V0Q29udGFpbmVyT2Zmc2V0OiBmdW5jdGlvbigpIHtcbiAgICAgICAgcmV0dXJuIGpRdWVyeS5leHRlbmQoe30sIHRoaXMuY29udGFpbmVyLm9mZnNldCgpKTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgKiBzZXQgY29vcmRpbmF0ZXMgb2YgdXBwZXIgbGVmdCBjb3JuZXIgb2YgaW1hZ2Ugb2JqZWN0XG4gICAgKiovXG4gICAgc2V0Q29vcmRzOiBmdW5jdGlvbih4LHkpXG4gICAge1xuICAgICAgICAvL2RvIG5vdGhpbmcgd2hpbGUgaW1hZ2UgaXMgYmVpbmcgbG9hZGVkXG4gICAgICAgIGlmKCF0aGlzLmltZ19vYmplY3QubG9hZGVkKCkpIHsgcmV0dXJuOyB9XG5cbiAgICAgICAgdmFyIGNvb3JkcyA9IHRoaXMuX2NvcnJlY3RDb29yZHMoeCx5KTtcbiAgICAgICAgdGhpcy5pbWdfb2JqZWN0LngoY29vcmRzLngpO1xuICAgICAgICB0aGlzLmltZ19vYmplY3QueShjb29yZHMueSk7XG4gICAgfSxcblxuICAgIF9jb3JyZWN0Q29vcmRzOiBmdW5jdGlvbiggeCwgeSApXG4gICAge1xuICAgICAgICB4ID0gcGFyc2VJbnQoeCwgMTApO1xuICAgICAgICB5ID0gcGFyc2VJbnQoeSwgMTApO1xuXG4gICAgICAgIC8vY2hlY2sgbmV3IGNvb3JkaW5hdGVzIHRvIGJlIGNvcnJlY3QgKHRvIGJlIGluIHJlY3QpXG4gICAgICAgIGlmKHkgPiAwKXtcbiAgICAgICAgICAgIHkgPSAwO1xuICAgICAgICB9XG4gICAgICAgIGlmKHggPiAwKXtcbiAgICAgICAgICAgIHggPSAwO1xuICAgICAgICB9XG4gICAgICAgIGlmKHkgKyB0aGlzLmltZ19vYmplY3QuZGlzcGxheV9oZWlnaHQoKSA8IHRoaXMub3B0aW9ucy5oZWlnaHQpe1xuICAgICAgICAgICAgeSA9IHRoaXMub3B0aW9ucy5oZWlnaHQgLSB0aGlzLmltZ19vYmplY3QuZGlzcGxheV9oZWlnaHQoKTtcbiAgICAgICAgfVxuICAgICAgICBpZih4ICsgdGhpcy5pbWdfb2JqZWN0LmRpc3BsYXlfd2lkdGgoKSA8IHRoaXMub3B0aW9ucy53aWR0aCl7XG4gICAgICAgICAgICB4ID0gdGhpcy5vcHRpb25zLndpZHRoIC0gdGhpcy5pbWdfb2JqZWN0LmRpc3BsYXlfd2lkdGgoKTtcbiAgICAgICAgfVxuICAgICAgICBpZih0aGlzLmltZ19vYmplY3QuZGlzcGxheV93aWR0aCgpIDw9IHRoaXMub3B0aW9ucy53aWR0aCl7XG4gICAgICAgICAgICB4ID0gLSh0aGlzLmltZ19vYmplY3QuZGlzcGxheV93aWR0aCgpIC0gdGhpcy5vcHRpb25zLndpZHRoKS8yO1xuICAgICAgICB9XG4gICAgICAgIGlmKHRoaXMuaW1nX29iamVjdC5kaXNwbGF5X2hlaWdodCgpIDw9IHRoaXMub3B0aW9ucy5oZWlnaHQpe1xuICAgICAgICAgICAgeSA9IC0odGhpcy5pbWdfb2JqZWN0LmRpc3BsYXlfaGVpZ2h0KCkgLSB0aGlzLm9wdGlvbnMuaGVpZ2h0KS8yO1xuICAgICAgICB9XG5cbiAgICAgICAgcmV0dXJuIHsgeDogeCwgeTp5IH07XG4gICAgfSxcblxuXG4gICAgLyoqXG4gICAgKiBjb252ZXJ0IGNvb3JkaW5hdGVzIG9uIHRoZSBjb250YWluZXIgdG8gdGhlIGNvb3JkaW5hdGVzIG9uIHRoZSBpbWFnZSAoaW4gb3JpZ2luYWwgc2l6ZSlcbiAgICAqXG4gICAgKiBAcmV0dXJuIG9iamVjdCB3aXRoIGZpZWxkcyB4LHkgYWNjb3JkaW5nIHRvIGNvb3JkaW5hdGVzIG9yIGZhbHNlXG4gICAgKiBpZiBpbml0aWFsIGNvb3JkcyBhcmUgbm90IGluc2lkZSBpbWFnZVxuICAgICoqL1xuICAgIGNvbnRhaW5lclRvSW1hZ2UgOiBmdW5jdGlvbiAoeCx5KVxuICAgIHtcbiAgICAgICAgdmFyIGNvb3JkcyA9IHsgeCA6IHggLSB0aGlzLmltZ19vYmplY3QueCgpLFxuICAgICAgICAgICAgICAgICB5IDogIHkgLSB0aGlzLmltZ19vYmplY3QueSgpXG4gICAgICAgIH07XG5cbiAgICAgICAgY29vcmRzID0gdGhpcy5pbWdfb2JqZWN0LnRvT3JpZ2luYWxDb29yZHMoY29vcmRzKTtcblxuICAgICAgICByZXR1cm4geyB4IDogIHV0aWwuZGVzY2FsZVZhbHVlKGNvb3Jkcy54LCB0aGlzLmN1cnJlbnRfem9vbSksXG4gICAgICAgICAgICAgICAgIHkgOiAgdXRpbC5kZXNjYWxlVmFsdWUoY29vcmRzLnksIHRoaXMuY3VycmVudF96b29tKVxuICAgICAgICB9O1xuICAgIH0sXG5cbiAgICAvKipcbiAgICAqIGNvbnZlcnQgY29vcmRpbmF0ZXMgb24gdGhlIGltYWdlIChpbiBvcmlnaW5hbCBzaXplLCBhbmQgemVybyBhbmdsZSkgdG8gdGhlIGNvb3JkaW5hdGVzIG9uIHRoZSBjb250YWluZXJcbiAgICAqXG4gICAgKiBAcmV0dXJuIG9iamVjdCB3aXRoIGZpZWxkcyB4LHkgYWNjb3JkaW5nIHRvIGNvb3JkaW5hdGVzXG4gICAgKiovXG4gICAgaW1hZ2VUb0NvbnRhaW5lciA6IGZ1bmN0aW9uICh4LHkpXG4gICAge1xuICAgICAgICB2YXIgY29vcmRzID0ge1xuICAgICAgICAgICAgICAgIHggOiB1dGlsLnNjYWxlVmFsdWUoeCwgdGhpcy5jdXJyZW50X3pvb20pLFxuICAgICAgICAgICAgICAgIHkgOiB1dGlsLnNjYWxlVmFsdWUoeSwgdGhpcy5jdXJyZW50X3pvb20pXG4gICAgICAgICAgICB9O1xuXG4gICAgICAgIHJldHVybiB0aGlzLmltZ19vYmplY3QudG9SZWFsQ29vcmRzKGNvb3Jkcyk7XG4gICAgfSxcblxuICAgIC8qKlxuICAgICogZ2V0IG1vdXNlIGNvb3JkaW5hdGVzIG9uIHRoZSBpbWFnZVxuICAgICogQHBhcmFtIGUgLSBvYmplY3QgY29udGFpbmluZyBwYWdlWCBhbmQgcGFnZVkgZmllbGRzLCBlLmcuIG1vdXNlIGV2ZW50IG9iamVjdFxuICAgICpcbiAgICAqIEByZXR1cm4gb2JqZWN0IHdpdGggZmllbGRzIHgseSBhY2NvcmRpbmcgdG8gY29vcmRpbmF0ZXMgb3IgZmFsc2VcbiAgICAqIGlmIGluaXRpYWwgY29vcmRzIGFyZSBub3QgaW5zaWRlIGltYWdlXG4gICAgKiovXG4gICAgX2dldE1vdXNlQ29vcmRzIDogZnVuY3Rpb24oZSlcbiAgICB7XG4gICAgICAgIHZhciBjb250YWluZXJPZmZzZXQgPSB0aGlzLmNvbnRhaW5lci5vZmZzZXQoKSxcbiAgICAgICAgICAgIGNvb3JkcyA9IHRoaXMuY29udGFpbmVyVG9JbWFnZShlLnBhZ2VYIC0gY29udGFpbmVyT2Zmc2V0LmxlZnQsIGUucGFnZVkgLSBjb250YWluZXJPZmZzZXQudG9wKTtcblxuICAgICAgICByZXR1cm4gY29vcmRzO1xuICAgIH0sXG5cbiAgICAvKipcbiAgICAqIGZpbGxzIGNvbnRhaW5lciBlbnRpcmVseSBieSBkaXN0b3J0aW5nIGltYWdlXG4gICAgKlxuICAgICogQHBhcmFtIHtib29sZWFufSBmaWxsIHdldGhlciB0byBmaWxsIHRoZSBjb250YWluZXIgZW50aXJlbHkgb3Igbm90LlxuICAgICoqL1xuICAgIGZpbGxfY29udGFpbmVyOiBmdW5jdGlvbihmaWxsKVxuICAgIHtcbiAgICAgICAgdGhpcy5vcHRpb25zLmZpbGxfY29udGFpbmVyID0gZmlsbDtcbiAgICAgICAgaWYoZmlsbClcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyIHJhdGlvID0gdGhpcy5vcHRpb25zLndpZHRoIC8gdGhpcy5vcHRpb25zLmhlaWdodDtcbiAgICAgICAgICAgIGlmIChyYXRpbyA+IDEpXG4gICAgICAgICAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9yaWdfd2lkdGgodGhpcy5pbWdfb2JqZWN0Lm9yaWdfaGVpZ2h0KCkgKiByYXRpbyk7XG4gICAgICAgICAgICBlbHNlXG4gICAgICAgICAgICAgICAgdGhpcy5pbWdfb2JqZWN0Lm9yaWdfaGVpZ2h0KHRoaXMuaW1nX29iamVjdC5vcmlnX3dpZHRoKCkgKiByYXRpbyk7XG4gICAgICAgIH1cbiAgICAgICAgZWxzZVxuICAgICAgICB7XG4gICAgICAgICAgICB0aGlzLmltZ19vYmplY3Qub3JpZ193aWR0aCh0aGlzLl9maWxsX29yaWdfZGltZW5zaW9ucy53aWR0aCk7XG4gICAgICAgICAgICB0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQodGhpcy5fZmlsbF9vcmlnX2RpbWVuc2lvbnMuaGVpZ2h0KTtcbiAgICAgICAgfVxuICAgICAgICB0aGlzLnNldF96b29tKHRoaXMuY3VycmVudF96b29tKTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgKiBzZXQgaW1hZ2Ugc2NhbGUgdG8gdGhlIG5ld196b29tXG4gICAgKlxuICAgICogQHBhcmFtIHtudW1iZXJ9IG5ld196b29tIGltYWdlIHNjYWxlIGluICVcbiAgICAqIEBwYXJhbSB7Ym9vbGVhbn0gc2tpcF9hbmltYXRpb25cbiAgICAqIEBwYXJhbSB7eDogbnVtYmVyLCB5OiBudW1iZXJ9IENvb3JkaW5hdGVzIG9mIHBvaW50IHRoZSBzaG91bGQgbm90IGJlIG1vdmVkIG9uIHpvb20uIFRoZSBkZWZhdWx0IGlzIHRoZSBjZW50ZXIgb2YgaW1hZ2UuXG4gICAgKiovXG4gICAgc2V0X3pvb206IGZ1bmN0aW9uKG5ld196b29tLCBza2lwX2FuaW1hdGlvbiwgem9vbV9jZW50ZXIpXG4gICAge1xuICAgICAgICBpZiAodGhpcy5fdHJpZ2dlcignb25ab29tJywgMCwgbmV3X3pvb20pID09IGZhbHNlKSB7XG4gICAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cblxuICAgICAgICAvL2RvIG5vdGhpbmcgd2hpbGUgaW1hZ2UgaXMgYmVpbmcgbG9hZGVkXG4gICAgICAgIGlmKCF0aGlzLmltZ19vYmplY3QubG9hZGVkKCkpIHsgcmV0dXJuOyB9XG5cbiAgICAgICAgem9vbV9jZW50ZXIgPSB6b29tX2NlbnRlciB8fCB7XG4gICAgICAgICAgICB4OiBNYXRoLnJvdW5kKHRoaXMub3B0aW9ucy53aWR0aC8yKSxcbiAgICAgICAgICAgIHk6IE1hdGgucm91bmQodGhpcy5vcHRpb25zLmhlaWdodC8yKVxuICAgICAgICB9O1xuXG4gICAgICAgIGlmKG5ld196b29tIDwgIHRoaXMub3B0aW9ucy56b29tX21pbilcbiAgICAgICAge1xuICAgICAgICAgICAgbmV3X3pvb20gPSB0aGlzLm9wdGlvbnMuem9vbV9taW47XG4gICAgICAgIH1cbiAgICAgICAgZWxzZSBpZihuZXdfem9vbSA+IHRoaXMub3B0aW9ucy56b29tX21heClcbiAgICAgICAge1xuICAgICAgICAgICAgbmV3X3pvb20gPSB0aGlzLm9wdGlvbnMuem9vbV9tYXg7XG4gICAgICAgIH1cblxuICAgICAgICAvKiB3ZSBmYWtlIHRoZXNlIHZhbHVlcyB0byBtYWtlIGZpdCB6b29tIHByb3Blcmx5IHdvcmsgKi9cbiAgICAgICAgdmFyIG9sZF94LCBvbGRfeTtcbiAgICAgICAgaWYodGhpcy5jdXJyZW50X3pvb20gPT0gXCJmaXRcIilcbiAgICAgICAge1xuICAgICAgICAgICAgb2xkX3ggPSB6b29tX2NlbnRlci54ICsgTWF0aC5yb3VuZCh0aGlzLmltZ19vYmplY3Qub3JpZ193aWR0aCgpLzIpO1xuICAgICAgICAgICAgb2xkX3kgPSB6b29tX2NlbnRlci55ICsgTWF0aC5yb3VuZCh0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKS8yKTtcbiAgICAgICAgICAgIHRoaXMuY3VycmVudF96b29tID0gMTAwO1xuICAgICAgICB9XG4gICAgICAgIGVsc2Uge1xuICAgICAgICAgICAgb2xkX3ggPSAtdGhpcy5pbWdfb2JqZWN0LngoKSArIHpvb21fY2VudGVyLng7XG4gICAgICAgICAgICBvbGRfeSA9IC10aGlzLmltZ19vYmplY3QueSgpICsgem9vbV9jZW50ZXIueTtcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciBuZXdfd2lkdGggPSB1dGlsLnNjYWxlVmFsdWUodGhpcy5pbWdfb2JqZWN0Lm9yaWdfd2lkdGgoKSwgbmV3X3pvb20pO1xuICAgICAgICB2YXIgbmV3X2hlaWdodCA9IHV0aWwuc2NhbGVWYWx1ZSh0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKSwgbmV3X3pvb20pO1xuICAgICAgICB2YXIgbmV3X3ggPSB1dGlsLnNjYWxlVmFsdWUoIHV0aWwuZGVzY2FsZVZhbHVlKG9sZF94LCB0aGlzLmN1cnJlbnRfem9vbSksIG5ld196b29tKTtcbiAgICAgICAgdmFyIG5ld195ID0gdXRpbC5zY2FsZVZhbHVlKCB1dGlsLmRlc2NhbGVWYWx1ZShvbGRfeSwgdGhpcy5jdXJyZW50X3pvb20pLCBuZXdfem9vbSk7XG5cbiAgICAgICAgbmV3X3ggPSB6b29tX2NlbnRlci54IC0gbmV3X3g7XG4gICAgICAgIG5ld195ID0gem9vbV9jZW50ZXIueSAtIG5ld195O1xuXG4gICAgICAgIG5ld193aWR0aCA9IE1hdGguZmxvb3IobmV3X3dpZHRoKTtcbiAgICAgICAgbmV3X2hlaWdodCA9IE1hdGguZmxvb3IobmV3X2hlaWdodCk7XG4gICAgICAgIG5ld194ID0gTWF0aC5mbG9vcihuZXdfeCk7XG4gICAgICAgIG5ld195ID0gTWF0aC5mbG9vcihuZXdfeSk7XG5cbiAgICAgICAgdGhpcy5pbWdfb2JqZWN0LmRpc3BsYXlfd2lkdGgobmV3X3dpZHRoKTtcbiAgICAgICAgdGhpcy5pbWdfb2JqZWN0LmRpc3BsYXlfaGVpZ2h0KG5ld19oZWlnaHQpO1xuXG4gICAgICAgIHZhciBjb29yZHMgPSB0aGlzLl9jb3JyZWN0Q29vcmRzKCBuZXdfeCwgbmV3X3kgKSxcbiAgICAgICAgICAgIHNlbGYgPSB0aGlzO1xuXG4gICAgICAgIHRoaXMuaW1nX29iamVjdC5zZXRJbWFnZVByb3BzKG5ld193aWR0aCwgbmV3X2hlaWdodCwgY29vcmRzLngsIGNvb3Jkcy55LFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNraXBfYW5pbWF0aW9uLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIHNlbGYuX3RyaWdnZXIoJ29uQWZ0ZXJab29tJywgMCwgbmV3X3pvb20gKTtcbiAgICAgICAgfSk7XG4gICAgICAgIHRoaXMuY3VycmVudF96b29tID0gbmV3X3pvb207XG5cbiAgICAgICAgdGhpcy51cGRhdGVfc3RhdHVzKCk7XG4gICAgfSxcbiAgICAvKipcbiAgICAgKiBzaG93cyBvciBoaWRlcyB0aGUgY29udHJvbHNcbiAgICAgKiBjb250cm9scyBhcmUgc2hvd24vaGlkZGVuIGJhc2VkIG9uIHVzZXIgaW5wdXRcbiAgICAgKiBAcGFyYW0gQm9vbGVhbiBmbGFnIHRoYXQgc3BlY2lmaWVzIHdoZXRoZXIgdG8gc2hvdyBvciBoaWRlIHRoZSBjb250cm9sc1xuICAgICAqKi9cbiAgICBzaG93Q29udHJvbHM6IGZ1bmN0aW9uKGZsYWcpIHtcbiAgICAgICAgaWYoZmxhZykge1xuICAgICAgICAgICAgdGhpcy5jb250cm9scy5mYWRlSW4oKTtcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHRoaXMuY29udHJvbHMuZmFkZU91dCgpO1xuICAgICAgICB9XG4gICAgfSxcbiAgICAvKipcbiAgICAqIGNoYW5nZXMgem9vbSBzY2FsZSBieSBkZWx0YVxuICAgICogem9vbSBpcyBjYWxjdWxhdGVkIGJ5IGZvcm11bGE6IHpvb21fYmFzZSAqIHpvb21fZGVsdGFecmF0ZVxuICAgICogQHBhcmFtIEludGVnZXIgZGVsdGEgbnVtYmVyIHRvIGFkZCB0byB0aGUgY3VycmVudCBtdWx0aXBsaWVyIHJhdGUgbnVtYmVyXG4gICAgKiBAcGFyYW0ge3g6IG51bWJlciwgeTogbnVtYmVyPX0gQ29vcmRpbmF0ZXMgb2YgcG9pbnQgdGhlIHNob3VsZCBub3QgYmUgbW92ZWQgb24gem9vbS5cbiAgICAqKi9cbiAgICB6b29tX2J5OiBmdW5jdGlvbihkZWx0YSwgem9vbV9jZW50ZXIpXG4gICAge1xuICAgICAgICB2YXIgY2xvc2VzdF9yYXRlID0gdGhpcy5maW5kX2Nsb3Nlc3Rfem9vbV9yYXRlKHRoaXMuY3VycmVudF96b29tKTtcblxuICAgICAgICB2YXIgbmV4dF9yYXRlID0gY2xvc2VzdF9yYXRlICsgZGVsdGE7XG4gICAgICAgIHZhciBuZXh0X3pvb20gPSB0aGlzLm9wdGlvbnMuem9vbV9iYXNlICogTWF0aC5wb3codGhpcy5vcHRpb25zLnpvb21fZGVsdGEsIG5leHRfcmF0ZSk7XG4gICAgICAgIGlmKGRlbHRhID4gMCAmJiBuZXh0X3pvb20gPCB0aGlzLmN1cnJlbnRfem9vbSlcbiAgICAgICAge1xuICAgICAgICAgICAgbmV4dF96b29tICo9IHRoaXMub3B0aW9ucy56b29tX2RlbHRhO1xuICAgICAgICB9XG5cbiAgICAgICAgaWYoZGVsdGEgPCAwICYmIG5leHRfem9vbSA+IHRoaXMuY3VycmVudF96b29tKVxuICAgICAgICB7XG4gICAgICAgICAgICBuZXh0X3pvb20gLz0gdGhpcy5vcHRpb25zLnpvb21fZGVsdGE7XG4gICAgICAgIH1cblxuICAgICAgICB0aGlzLnNldF96b29tKG5leHRfem9vbSwgdW5kZWZpbmVkLCB6b29tX2NlbnRlcik7XG4gICAgfSxcblxuICAgIC8qKlxuICAgICogUm90YXRlIGltYWdlXG4gICAgKiBAcGFyYW0ge251bX0gZGVnIERlZ3JlZXMgYW1vdW50IHRvIHJvdGF0ZS4gUG9zaXRpdmUgdmFsdWVzIHJvdGF0ZSBpbWFnZSBjbG9ja3dpc2UuXG4gICAgKiAgICAgQ3VycmVudGx5IDAsIDkwLCAxODAsIDI3MCBhbmQgLTkwLCAtMTgwLCAtMjcwIHZhbHVlcyBhcmUgc3VwcG9ydGVkXG4gICAgKlxuICAgICogQHBhcmFtIHtib29sZWFufSBhYnMgSWYgdGhlIGZsYWcgaXMgdHJ1ZSBpZiwgdGhlIGRlZyBwYXJhbWV0ZXIgd2lsbCBiZSBjb25zaWRlcmVkIGFzXG4gICAgKiAgICAgYSBhYnNvbHV0ZSB2YWx1ZSBhbmQgcmVsYXRpdmUgb3RoZXJ3aXNlLlxuICAgICogQHJldHVybiB7bnVtfG51bGx9IE1ldGhvZCB3aWxsIHJldHVybiBjdXJyZW50IGltYWdlIGFuZ2xlIGlmIGNhbGxlZCB3aXRob3V0IGFueSBhcmd1bWVudHMuXG4gICAgKiovXG4gICAgYW5nbGU6IGZ1bmN0aW9uKGRlZywgYWJzKSB7XG4gICAgICAgIGlmIChhcmd1bWVudHMubGVuZ3RoID09PSAwKSB7IHJldHVybiB0aGlzLmltZ19vYmplY3QuYW5nbGUoKTsgfVxuXG4gICAgICAgIGlmIChkZWcgPCAtMjcwIHx8IGRlZyA+IDI3MCB8fCBkZWcgJSA5MCAhPT0gMCkgeyByZXR1cm47IH1cbiAgICAgICAgaWYgKCFhYnMpIHsgZGVnICs9IHRoaXMuaW1nX29iamVjdC5hbmdsZSgpOyB9XG4gICAgICAgIGlmIChkZWcgPCAwKSB7IGRlZyArPSAzNjA7IH1cbiAgICAgICAgaWYgKGRlZyA+PSAzNjApIHsgZGVnIC09IDM2MDsgfVxuXG4gICAgICAgIGlmIChkZWcgPT09IHRoaXMuaW1nX29iamVjdC5hbmdsZSgpKSB7IHJldHVybjsgfVxuXG4gICAgICAgIHRoaXMuaW1nX29iamVjdC5hbmdsZShkZWcpO1xuICAgICAgICAvL3RoZSByb3RhdGUgYmVoYXZpb3IgaXMgZGlmZmVyZW50IGluIGFsbCBlZGl0b3JzLiBGb3Igbm93IHdlICBqdXN0IGNlbnRlciB0aGVcbiAgICAgICAgLy9pbWFnZS4gSG93ZXZlciwgaXQgd2lsbCBiZSBiZXR0ZXIgdG8gdHJ5IHRvIGtlZXAgdGhlIHBvc2l0aW9uLlxuICAgICAgICB0aGlzLmNlbnRlcigpO1xuICAgICAgICB0aGlzLl90cmlnZ2VyKCdhbmdsZScsIDAsIHsgYW5nbGU6IHRoaXMuaW1nX29iamVjdC5hbmdsZSgpIH0pO1xuICAgIH0sXG5cbiAgICAvKipcbiAgICAqIGZpbmRzIGNsb3Nlc3QgbXVsdGlwbGllciByYXRlIGZvciB2YWx1ZVxuICAgICogYmFzaW5nIG9uIHpvb21fYmFzZSBhbmQgem9vbV9kZWx0YSB2YWx1ZXMgZnJvbSBzZXR0aW5nc1xuICAgICogQHBhcmFtIE51bWJlciB2YWx1ZSB6b29tIHZhbHVlIHRvIGV4YW1pbmVcbiAgICAqKi9cbiAgICBmaW5kX2Nsb3Nlc3Rfem9vbV9yYXRlOiBmdW5jdGlvbih2YWx1ZSlcbiAgICB7XG4gICAgICAgIGlmKHZhbHVlID09IHRoaXMub3B0aW9ucy56b29tX2Jhc2UpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHJldHVybiAwO1xuICAgICAgICB9XG5cbiAgICAgICAgZnVuY3Rpb24gZGl2KHZhbDEsdmFsMikgeyByZXR1cm4gdmFsMSAvIHZhbDI7IH07XG4gICAgICAgIGZ1bmN0aW9uIG11bCh2YWwxLHZhbDIpIHsgcmV0dXJuIHZhbDEgKiB2YWwyOyB9O1xuXG4gICAgICAgIHZhciBmdW5jID0gKHZhbHVlID4gdGhpcy5vcHRpb25zLnpvb21fYmFzZSk/bXVsOmRpdjtcbiAgICAgICAgdmFyIHNnbiA9ICh2YWx1ZSA+IHRoaXMub3B0aW9ucy56b29tX2Jhc2UpPzE6LTE7XG5cbiAgICAgICAgdmFyIG1sdHBsciA9IHRoaXMub3B0aW9ucy56b29tX2RlbHRhO1xuICAgICAgICB2YXIgcmF0ZSA9IDE7XG5cbiAgICAgICAgd2hpbGUoTWF0aC5hYnMoZnVuYyh0aGlzLm9wdGlvbnMuem9vbV9iYXNlLCBNYXRoLnBvdyhtbHRwbHIscmF0ZSkpIC0gdmFsdWUpID5cbiAgICAgICAgICAgICAgTWF0aC5hYnMoZnVuYyh0aGlzLm9wdGlvbnMuem9vbV9iYXNlLCBNYXRoLnBvdyhtbHRwbHIscmF0ZSsxKSkgLSB2YWx1ZSkpXG4gICAgICAgIHtcbiAgICAgICAgICAgIHJhdGUrKztcbiAgICAgICAgfVxuXG4gICAgICAgIHJldHVybiBzZ24gKiByYXRlO1xuICAgIH0sXG5cbiAgICAvKiB1cGRhdGUgc2NhbGUgaW5mbyBpbiB0aGUgY29udGFpbmVyICovXG4gICAgdXBkYXRlX3N0YXR1czogZnVuY3Rpb24oKVxuICAgIHtcbiAgICAgICAgaWYoIXRoaXMub3B0aW9ucy51aV9kaXNhYmxlZClcbiAgICAgICAge1xuICAgICAgICAgICAgdmFyIHBlcmNlbnQgPSBNYXRoLnJvdW5kKDEwMCp0aGlzLmltZ19vYmplY3QuZGlzcGxheV9oZWlnaHQoKS90aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKSk7XG4gICAgICAgICAgICBpZihwZXJjZW50KVxuICAgICAgICAgICAge1xuICAgICAgICAgICAgICAgIHRoaXMuem9vbV9vYmplY3QuaHRtbChwZXJjZW50ICsgXCIlXCIpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9XG4gICAgfSxcblxuICAgIC8qKlxuICAgICAqIEdldCBzb21lIGluZm9ybWF0aW9uIGFib3V0IHRoZSBpbWFnZS5cbiAgICAgKiAgICAgQ3VycmVudGx5IG9yaWdfKHdpZHRofGhlaWdodCksIGRpc3BsYXlfKHdpZHRofGhlaWdodCksIGFuZ2xlLCB6b29tIGFuZCBzcmMgcGFyYW1zIGFyZSBzdXBwb3J0ZWQuXG4gICAgICpcbiAgICAgKiAgQHBhcmFtIHtzdHJpbmd9IHBhcmFtZXRlciB0byBjaGVja1xuICAgICAqICBAcGFyYW0ge2Jvb2xlYW59IHdpdGhvdXRSb3RhdGlvbiBpZiBwYXJhbSBpcyBvcmlnX3dpZHRoIG9yIG9yaWdfaGVpZ2h0IGFuZCB0aGlzIGZsYWcgaXMgc2V0IHRvIHRydWUsXG4gICAgICogICAgICBtZXRob2Qgd2lsbCByZXR1cm4gb3JpZ2luYWwgaW1hZ2Ugd2lkdGggd2l0aG91dCBjb25zaWRlcmluZyByb3RhdGlvbi5cbiAgICAgKlxuICAgICAqL1xuICAgIGluZm86IGZ1bmN0aW9uKHBhcmFtLCB3aXRob3V0Um90YXRpb24pIHtcbiAgICAgICAgaWYgKCFwYXJhbSkgeyByZXR1cm47IH1cblxuICAgICAgICBzd2l0Y2ggKHBhcmFtKSB7XG4gICAgICAgICAgICBjYXNlICdvcmlnX3dpZHRoJzpcbiAgICAgICAgICAgIGNhc2UgJ29yaWdfaGVpZ2h0JzpcbiAgICAgICAgICAgICAgICBpZiAod2l0aG91dFJvdGF0aW9uKSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiAodGhpcy5pbWdfb2JqZWN0LmFuZ2xlKCkgJSAxODAgPT09IDAgPyB0aGlzLmltZ19vYmplY3RbcGFyYW1dKCkgOlxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIHBhcmFtID09PSAnb3JpZ193aWR0aCcgPyB0aGlzLmltZ19vYmplY3Qub3JpZ19oZWlnaHQoKSA6XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIHRoaXMuaW1nX29iamVjdC5vcmlnX3dpZHRoKCkpO1xuICAgICAgICAgICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICAgICAgICAgIHJldHVybiB0aGlzLmltZ19vYmplY3RbcGFyYW1dKCk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgY2FzZSAnZGlzcGxheV93aWR0aCc6XG4gICAgICAgICAgICBjYXNlICdkaXNwbGF5X2hlaWdodCc6XG4gICAgICAgICAgICBjYXNlICdhbmdsZSc6XG4gICAgICAgICAgICAgICAgcmV0dXJuIHRoaXMuaW1nX29iamVjdFtwYXJhbV0oKTtcbiAgICAgICAgICAgIGNhc2UgJ3pvb20nOlxuICAgICAgICAgICAgICAgIHJldHVybiB0aGlzLmN1cnJlbnRfem9vbTtcbiAgICAgICAgICAgIGNhc2UgJ29wdGlvbnMnOlxuICAgICAgICAgICAgICAgIHJldHVybiB0aGlzLm9wdGlvbnM7XG4gICAgICAgICAgICBjYXNlICdzcmMnOlxuICAgICAgICAgICAgICAgIHJldHVybiB0aGlzLmltZ19vYmplY3Qub2JqZWN0KCkuYXR0cignc3JjJyk7XG4gICAgICAgICAgICBjYXNlICdjb29yZHMnOlxuICAgICAgICAgICAgICAgIHJldHVybiB7XG4gICAgICAgICAgICAgICAgICAgIHg6IHRoaXMuaW1nX29iamVjdC54KCksXG4gICAgICAgICAgICAgICAgICAgIHk6IHRoaXMuaW1nX29iamVjdC55KClcbiAgICAgICAgICAgICAgICB9O1xuICAgICAgICB9XG4gICAgfSxcblxuICAgIC8qKlxuICAgICogICBjYWxsYmFjayBmb3IgaGFuZGxpbmcgbW91c2Rvd24gZXZlbnQgdG8gc3RhcnQgZHJhZ2dpbmcgaW1hZ2VcbiAgICAqKi9cbiAgICBfbW91c2VTdGFydDogZnVuY3Rpb24oIGUgKVxuICAgIHtcbiAgICAgICAgJC51aS5tb3VzZS5wcm90b3R5cGUuX21vdXNlU3RhcnQuY2FsbCh0aGlzLCBlKTtcbiAgICAgICAgaWYgKHRoaXMuX3RyaWdnZXIoJ29uU3RhcnREcmFnJywgMCwgdGhpcy5fZ2V0TW91c2VDb29yZHMoZSkpID09PSBmYWxzZSkge1xuICAgICAgICAgICAgcmV0dXJuIGZhbHNlO1xuICAgICAgICB9XG5cbiAgICAgICAgLyogc3RhcnQgZHJhZyBldmVudCovXG4gICAgICAgIHRoaXMuY29udGFpbmVyLmFkZENsYXNzKFwiaXZpZXdlcl9kcmFnX2N1cnNvclwiKTtcblxuICAgICAgICAvLyMxMDogZml4IG1vdmVtZW50IHF1aXJrcyBmb3IgaXBhZFxuICAgICAgICB0aGlzLl9kcmFnSW5pdGlhbGl6ZWQgPSAhKGUub3JpZ2luYWxFdmVudC5jaGFuZ2VkVG91Y2hlcyAmJiBlLm9yaWdpbmFsRXZlbnQuY2hhbmdlZFRvdWNoZXMubGVuZ3RoPT0xKTtcblxuICAgICAgICB0aGlzLmR4ID0gZS5wYWdlWCAtIHRoaXMuaW1nX29iamVjdC54KCk7XG4gICAgICAgIHRoaXMuZHkgPSBlLnBhZ2VZIC0gdGhpcy5pbWdfb2JqZWN0LnkoKTtcbiAgICAgICAgcmV0dXJuIHRydWU7XG4gICAgfSxcblxuICAgIF9tb3VzZUNhcHR1cmU6IGZ1bmN0aW9uKCBlICkge1xuICAgICAgICByZXR1cm4gdHJ1ZTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgICogSGFuZGxlIG1vdXNlIG1vdmUgaWYgbmVlZGVkLiBVc2VyIGNhbiBhdm9pZCB1c2luZyB0aGlzIGNhbGxiYWNrLCBiZWNhdXNlXG4gICAgICogICAgaGUgY2FuIGdldCB0aGUgc2FtZSBpbmZvcm1hdGlvbiB0aHJvdWdoIHB1YmxpYyBtZXRob2RzLlxuICAgICAqICBAcGFyYW0ge2pRdWVyeS5FdmVudH0gZVxuICAgICAqL1xuICAgIF9oYW5kbGVNb3VzZU1vdmU6IGZ1bmN0aW9uKGUpIHtcbiAgICAgICAgdGhpcy5fdHJpZ2dlcignb25Nb3VzZU1vdmUnLCBlLCB0aGlzLl9nZXRNb3VzZUNvb3JkcyhlKSk7XG4gICAgfSxcblxuICAgIC8qKlxuICAgICogICBjYWxsYmFjayBmb3IgaGFuZGxpbmcgbW91c2Vtb3ZlIGV2ZW50IHRvIGRyYWcgaW1hZ2VcbiAgICAqKi9cbiAgICBfbW91c2VEcmFnOiBmdW5jdGlvbihlKVxuICAgIHtcbiAgICAgICAgJC51aS5tb3VzZS5wcm90b3R5cGUuX21vdXNlRHJhZy5jYWxsKHRoaXMsIGUpO1xuXG4gICAgICAgIC8vIzEwOiBpbWl0YXRlIG1vdXNlU3RhcnQsIGJlY2F1c2Ugd2UgY2FuIGdldCBoZXJlIHdpdGhvdXQgaXQgb24gaVBhZCBmb3Igc29tZSByZWFzb25cbiAgICAgICAgaWYgKCF0aGlzLl9kcmFnSW5pdGlhbGl6ZWQpIHtcbiAgICAgICAgICAgIHRoaXMuZHggPSBlLnBhZ2VYIC0gdGhpcy5pbWdfb2JqZWN0LngoKTtcbiAgICAgICAgICAgIHRoaXMuZHkgPSBlLnBhZ2VZIC0gdGhpcy5pbWdfb2JqZWN0LnkoKTtcbiAgICAgICAgICAgIHRoaXMuX2RyYWdJbml0aWFsaXplZCA9IHRydWU7XG4gICAgICAgIH1cblxuICAgICAgICB2YXIgbHRvcCA9ICBlLnBhZ2VZIC0gdGhpcy5keTtcbiAgICAgICAgdmFyIGxsZWZ0ID0gZS5wYWdlWCAtIHRoaXMuZHg7XG5cbiAgICAgICAgdGhpcy5zZXRDb29yZHMobGxlZnQsIGx0b3ApO1xuICAgICAgICB0aGlzLl90cmlnZ2VyKCdvbkRyYWcnLCBlLCB0aGlzLl9nZXRNb3VzZUNvb3JkcyhlKSk7XG4gICAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9LFxuXG4gICAgLyoqXG4gICAgKiAgIGNhbGxiYWNrIGZvciBoYW5kbGluZyBzdG9wIGRyYWdcbiAgICAqKi9cbiAgICBfbW91c2VTdG9wOiBmdW5jdGlvbihlKVxuICAgIHtcbiAgICAgICAgJC51aS5tb3VzZS5wcm90b3R5cGUuX21vdXNlU3RvcC5jYWxsKHRoaXMsIGUpO1xuICAgICAgICB0aGlzLmNvbnRhaW5lci5yZW1vdmVDbGFzcyhcIml2aWV3ZXJfZHJhZ19jdXJzb3JcIik7XG4gICAgICAgIHRoaXMuX3RyaWdnZXIoJ29uU3RvcERyYWcnLCAwLCB0aGlzLl9nZXRNb3VzZUNvb3JkcyhlKSk7XG4gICAgfSxcblxuICAgIF9jbGljazogZnVuY3Rpb24oZSlcbiAgICB7XG4gICAgICAgIHRoaXMuX3RyaWdnZXIoJ29uQ2xpY2snLCAwLCB0aGlzLl9nZXRNb3VzZUNvb3JkcyhlKSk7XG4gICAgfSxcblxuICAgIF9kYmxjbGljazogZnVuY3Rpb24oZXYpXG4gICAge1xuICAgICAgaWYgKHRoaXMub3B0aW9ucy5vbkRibENsaWNrKSB7XG4gICAgICAgIHRoaXMuX3RyaWdnZXIoJ29uRGJsQ2xpY2snLCAwLCB0aGlzLl9nZXRNb3VzZUNvb3JkcyhldikpO1xuICAgICAgfVxuXG4gICAgICBpZiAodGhpcy5vcHRpb25zLnpvb21fb25fZGJsY2xpY2spIHtcbiAgICAgICAgdmFyIGNvbnRhaW5lcl9vZmZzZXQgPSB0aGlzLmNvbnRhaW5lci5vZmZzZXQoKVxuICAgICAgICAgICwgbW91c2VfcG9zID0ge1xuICAgICAgICAgICAgeDogZXYucGFnZVggLSBjb250YWluZXJfb2Zmc2V0LmxlZnQsXG4gICAgICAgICAgICB5OiBldi5wYWdlWSAtIGNvbnRhaW5lcl9vZmZzZXQudG9wXG4gICAgICAgICAgfTtcblxuICAgICAgICB0aGlzLnpvb21fYnkoMSwgbW91c2VfcG9zKTtcbiAgICAgIH1cbiAgICB9LFxuXG4gICAgLyoqXG4gICAgKiAgIGNyZWF0ZSB6b29tIGJ1dHRvbnMgaW5mbyBib3hcbiAgICAqKi9cbiAgICBjcmVhdGV1aTogZnVuY3Rpb24oKVxuICAgIHtcbiAgICAgICAgdmFyIG1lPXRoaXM7XG5cbiAgICAgICAgJChcIjxkaXY+XCIsIHsgJ2NsYXNzJzogXCJpdmlld2VyX3pvb21faW4gaXZpZXdlcl9jb21tb24gaXZpZXdlcl9idXR0b25cIn0pXG4gICAgICAgICAgICAgICAgICAgIC5iaW5kKCdtb3VzZWRvd24gdG91Y2hzdGFydCcsZnVuY3Rpb24oKXttZS56b29tX2J5KDEpOyByZXR1cm4gZmFsc2U7fSlcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZFRvKHRoaXMuY29udGFpbmVyKTtcblxuICAgICAgICAkKFwiPGRpdj5cIiwgeyAnY2xhc3MnOiBcIml2aWV3ZXJfem9vbV9vdXQgaXZpZXdlcl9jb21tb24gaXZpZXdlcl9idXR0b25cIn0pXG4gICAgICAgICAgICAgICAgICAgIC5iaW5kKCdtb3VzZWRvd24gdG91Y2hzdGFydCcsZnVuY3Rpb24oKXttZS56b29tX2J5KC0gMSk7IHJldHVybiBmYWxzZTt9KVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kVG8odGhpcy5jb250YWluZXIpO1xuXG4gICAgICAgICQoXCI8ZGl2PlwiLCB7ICdjbGFzcyc6IFwiaXZpZXdlcl96b29tX3plcm8gaXZpZXdlcl9jb21tb24gaXZpZXdlcl9idXR0b25cIn0pXG4gICAgICAgICAgICAgICAgICAgIC5iaW5kKCdtb3VzZWRvd24gdG91Y2hzdGFydCcsZnVuY3Rpb24oKXttZS5zZXRfem9vbSgxMDApOyByZXR1cm4gZmFsc2U7fSlcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZFRvKHRoaXMuY29udGFpbmVyKTtcblxuICAgICAgICAkKFwiPGRpdj5cIiwgeyAnY2xhc3MnOiBcIml2aWV3ZXJfem9vbV9maXQgaXZpZXdlcl9jb21tb24gaXZpZXdlcl9idXR0b25cIn0pXG4gICAgICAgICAgICAgICAgICAgIC5iaW5kKCdtb3VzZWRvd24gdG91Y2hzdGFydCcsZnVuY3Rpb24oKXttZS5maXQodGhpcyk7IHJldHVybiBmYWxzZTt9KVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kVG8odGhpcy5jb250YWluZXIpO1xuXG4gICAgICAgIHRoaXMuem9vbV9vYmplY3QgPSAkKFwiPGRpdj5cIikuYWRkQ2xhc3MoXCJpdmlld2VyX3pvb21fc3RhdHVzIGl2aWV3ZXJfY29tbW9uXCIpXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAuYXBwZW5kVG8odGhpcy5jb250YWluZXIpO1xuXG4gICAgICAgICQoXCI8ZGl2PlwiLCB7ICdjbGFzcyc6IFwiaXZpZXdlcl9yb3RhdGVfbGVmdCBpdmlld2VyX2NvbW1vbiBpdmlld2VyX2J1dHRvblwifSlcbiAgICAgICAgICAgICAgICAgICAgLmJpbmQoJ21vdXNlZG93biB0b3VjaHN0YXJ0JyxmdW5jdGlvbigpe21lLmFuZ2xlKC05MCk7IHJldHVybiBmYWxzZTt9KVxuICAgICAgICAgICAgICAgICAgICAuYXBwZW5kVG8odGhpcy5jb250YWluZXIpO1xuXG4gICAgICAgICQoXCI8ZGl2PlwiLCB7ICdjbGFzcyc6IFwiaXZpZXdlcl9yb3RhdGVfcmlnaHQgaXZpZXdlcl9jb21tb24gaXZpZXdlcl9idXR0b25cIiB9KVxuICAgICAgICAgICAgICAgICAgICAuYmluZCgnbW91c2Vkb3duIHRvdWNoc3RhcnQnLGZ1bmN0aW9uKCl7bWUuYW5nbGUoOTApOyByZXR1cm4gZmFsc2U7fSlcbiAgICAgICAgICAgICAgICAgICAgLmFwcGVuZFRvKHRoaXMuY29udGFpbmVyKTtcblxuICAgICAgICB0aGlzLnVwZGF0ZV9zdGF0dXMoKTsgLy9pbml0aWFsIHN0YXR1cyB1cGRhdGVcbiAgICB9XG5cbn0gKTtcblxuLyoqXG4gKiBAY2xhc3MgJC51aS5pdmlld2VyLkltYWdlT2JqZWN0IENsYXNzIHJlcHJlc2VudHMgaW1hZ2UgYW5kIHByb3ZpZGVzIHB1YmxpYyBhcGkgd2l0aG91dFxuICogICAgIGV4dGVuZGluZyBpbWFnZSBwcm90b3R5cGUuXG4gKiBAY29uc3RydWN0b3JcbiAqIEBwYXJhbSB7Ym9vbGVhbn0gZG9fYW5pbSBEbyB3ZSB3YW50IHRvIGFuaW1hdGUgaW1hZ2Ugb24gZGltZW5zaW9uIGNoYW5nZXM/XG4gKi9cbiQudWkuaXZpZXdlci5JbWFnZU9iamVjdCA9IGZ1bmN0aW9uKGRvX2FuaW0pIHtcbiAgICB0aGlzLl9pbWcgPSAkKFwiPGltZz5cIilcbiAgICAgICAgICAgIC8vdGhpcyBpcyBuZWVkZWQsIGJlY2F1c2UgY2hyb21pdW0gc2V0cyB0aGVtIGF1dG8gb3RoZXJ3aXNlXG4gICAgICAgICAgICAuY3NzKHsgcG9zaXRpb246IFwiYWJzb2x1dGVcIiwgdG9wIDpcIjBweFwiLCBsZWZ0OiBcIjBweFwifSk7XG5cbiAgICB0aGlzLl9sb2FkZWQgPSBmYWxzZTtcbiAgICB0aGlzLl9zd2FwRGltZW5zaW9ucyA9IGZhbHNlO1xuICAgIHRoaXMuX2RvX2FuaW0gPSBkb19hbmltIHx8IGZhbHNlO1xuICAgIHRoaXMueCgwLCB0cnVlKTtcbiAgICB0aGlzLnkoMCwgdHJ1ZSk7XG4gICAgdGhpcy5hbmdsZSgwKTtcbn07XG5cblxuLyoqIEBsZW5kcyAkLnVpLml2aWV3ZXIuSW1hZ2VPYmplY3QucHJvdG90eXBlICovXG4oZnVuY3Rpb24oKSB7XG4gICAgLyoqXG4gICAgICogUmVzdG9yZSBpbml0aWFsIG9iamVjdCBzdGF0ZS5cbiAgICAgKlxuICAgICAqIEBwYXJhbSB7bnVtYmVyfSB3IEltYWdlIHdpZHRoLlxuICAgICAqIEBwYXJhbSB7bnVtYmVyfSBoIEltYWdlIGhlaWdodC5cbiAgICAgKi9cbiAgICB0aGlzLl9yZXNldCA9IGZ1bmN0aW9uKHcsIGgpIHtcbiAgICAgICAgdGhpcy5fYW5nbGUgPSAwO1xuICAgICAgICB0aGlzLl9zd2FwRGltZW5zaW9ucyA9IGZhbHNlO1xuICAgICAgICB0aGlzLngoMCk7XG4gICAgICAgIHRoaXMueSgwKTtcblxuICAgICAgICB0aGlzLm9yaWdfd2lkdGgodyk7XG4gICAgICAgIHRoaXMub3JpZ19oZWlnaHQoaCk7XG4gICAgICAgIHRoaXMuZGlzcGxheV93aWR0aCh3KTtcbiAgICAgICAgdGhpcy5kaXNwbGF5X2hlaWdodChoKTtcbiAgICB9O1xuXG4gICAgLyoqXG4gICAgICogQ2hlY2sgaWYgaW1hZ2UgaXMgbG9hZGVkLlxuICAgICAqXG4gICAgICogQHJldHVybiB7Ym9vbGVhbn1cbiAgICAgKi9cbiAgICB0aGlzLmxvYWRlZCA9IGZ1bmN0aW9uKCkgeyByZXR1cm4gdGhpcy5fbG9hZGVkOyB9O1xuXG4gICAgLyoqXG4gICAgICogTG9hZCBpbWFnZS5cbiAgICAgKlxuICAgICAqIEBwYXJhbSB7c3RyaW5nfSBzcmMgSW1hZ2UgdXJsLlxuICAgICAqIEBwYXJhbSB7RnVuY3Rpb249fSBsb2FkZWQgRnVuY3Rpb24gd2lsbCBiZSBjYWxsZWQgb24gaW1hZ2UgbG9hZC5cbiAgICAgKi9cbiAgICB0aGlzLmxvYWQgPSBmdW5jdGlvbihzcmMsIGxvYWRlZCwgZXJyb3IpIHtcbiAgICAgICAgdmFyIHNlbGYgPSB0aGlzO1xuICAgICAgICBsb2FkZWQgPSBsb2FkZWQgfHwgalF1ZXJ5Lm5vb3A7XG4gICAgICAgIHRoaXMuX2xvYWRlZCA9IGZhbHNlO1xuXG4gICAgICAgIC8vICM2NzogZG9uJ3QgdXNlIGltYWdlIG9iamVjdCBmb3IgbG9hZGluZyBpbiBjYXNlIG5hdHVyYWxXaWR0aCBpcyBzdXBwb3J0ZWRcbiAgICAgICAgLy8gYmVjYXVzZSBsYXRlciBhc3NpZ25pbmcgdG8gc2VsZi5faW1nWzBdIG1heSByZXN1bHQgaW4gYWRkaXRpb25hbCBpbWFnZSByZXF1ZXNydHMuXG4gICAgICAgIHZhciBzdXBwb3J0c05hdHVyYWxXaWR0aCA9ICduYXR1cmFsV2lkdGgnIGluIG5ldyBJbWFnZSgpO1xuICAgICAgICB2YXIgaW1nID0gc3VwcG9ydHNOYXR1cmFsV2lkdGggPyBzZWxmLl9pbWdbMF0gOiBuZXcgSW1hZ2UoKTtcblxuICAgICAgICBpbWcub25sb2FkID0gZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBzZWxmLl9sb2FkZWQgPSB0cnVlO1xuICAgICAgICAgICAgaWYgKHN1cHBvcnRzTmF0dXJhbFdpZHRoKSB7XG4gICAgICAgICAgICAgIHNlbGYuX3Jlc2V0KHRoaXMubmF0dXJhbFdpZHRoLCB0aGlzLm5hdHVyYWxIZWlnaHQpO1xuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgc2VsZi5fcmVzZXQodGhpcy53aWR0aCwgdGhpcy5oZWlnaHQpO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBzZWxmLl9pbWdcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cihcIndpZHRoXCIpXG4gICAgICAgICAgICAgICAgLnJlbW92ZUF0dHIoXCJoZWlnaHRcIilcbiAgICAgICAgICAgICAgICAucmVtb3ZlQXR0cihcInN0eWxlXCIpXG4gICAgICAgICAgICAgICAgLy9tYXgtd2lkdGggaXMgcmVzZXQsIGJlY2F1c2UgcGx1Z2luIGJyZWFrcyBpbiB0aGUgdHdpdHRlciBib290c3RyYXAgb3RoZXJ3aXNlXG4gICAgICAgICAgICAgICAgLmNzcyh7IHBvc2l0aW9uOiBcImFic29sdXRlXCIsIHRvcCA6XCIwcHhcIiwgbGVmdDogXCIwcHhcIiwgbWF4V2lkdGg6IFwibm9uZVwifSk7XG5cbiAgICAgICAgICAgIGlmICghc3VwcG9ydHNOYXR1cmFsV2lkdGgpIHtcbiAgICAgICAgICAgICAgICBzZWxmLl9pbWdbMF0uc3JjID0gc3JjO1xuICAgICAgICAgICAgfVxuXG4gICAgICAgICAgICBsb2FkZWQoKTtcbiAgICAgICAgfTtcbiAgICAgICAgaW1nLm9uZXJyb3IgPSBlcnJvcjtcblxuICAgICAgICAvL3dlIG5lZWQgdGhpcyBiZWNhdXNlIHNvbWV0aW1lcyBpbnRlcm5ldCBleHBsb3JlciA4IGZpcmVzIG9ubG9hZCBldmVudFxuICAgICAgICAvL3JpZ2h0IGFmdGVyIGFzc2lnbm1lbnQgKHN5bmNocm9ub3VzbHkpXG4gICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBpbWcuc3JjID0gc3JjO1xuICAgICAgICB9LCAwKTtcbiAgICAgICAgdGhpcy5hbmdsZSgwKTtcbiAgICB9O1xuICAgIHRoaXMuX2RpbWVuc2lvbiA9IGZ1bmN0aW9uKHByZWZpeCwgbmFtZSkge1xuICAgICAgICB2YXIgaG9yaXogPSAnXycgKyBwcmVmaXggKyAnXycgKyBuYW1lLFxuICAgICAgICAgICAgdmVydCA9ICdfJyArIHByZWZpeCArICdfJyArIChuYW1lID09PSAnaGVpZ2h0JyA/ICd3aWR0aCcgOiAnaGVpZ2h0Jyk7XG4gICAgICAgIHJldHVybiBzZXR0ZXIoZnVuY3Rpb24odmFsKSB7XG4gICAgICAgICAgICAgICAgdGhpc1t0aGlzLl9zd2FwRGltZW5zaW9ucyA/IGhvcml6OiB2ZXJ0XSA9IHZhbDtcbiAgICAgICAgICAgIH0sXG4gICAgICAgICAgICBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgICAgICByZXR1cm4gdGhpc1t0aGlzLl9zd2FwRGltZW5zaW9ucyA/IGhvcml6OiB2ZXJ0XTtcbiAgICAgICAgICAgIH0pO1xuICAgIH07XG5cbiAgICAvKipcbiAgICAgKiBHZXR0ZXJzIGFuZCBzZXR0ZXIgZm9yIGNvbW1vbiBpbWFnZSBkaW1lbnNpb25zLlxuICAgICAqICAgIGRpc3BsYXlfIG1lYW5zIHJlYWwgaW1hZ2UgdGFnIGRpbWVuc2lvbnNcbiAgICAgKiAgICBvcmlnXyBtZWFucyBwaHlzaWNhbCBpbWFnZSBkaW1lbnNpb25zLlxuICAgICAqICBOb3RlLCB0aGF0IGRpbWVuc2lvbnMgYXJlIHN3YXBwZWQgaWYgaW1hZ2UgaXMgcm90YXRlZC4gSXQgbmVjZXNzYXJ5LFxuICAgICAqICBiZWNhdXNlIGFzIGxpdHRsZSBhcyBwb3NzaWJsZSBjb2RlIHNob3VsZCBrbm93IGFib3V0IHJvdGF0aW9uLlxuICAgICAqL1xuICAgIHRoaXMuZGlzcGxheV93aWR0aCA9IHRoaXMuX2RpbWVuc2lvbignZGlzcGxheScsICd3aWR0aCcpLFxuICAgIHRoaXMuZGlzcGxheV9oZWlnaHQgPSB0aGlzLl9kaW1lbnNpb24oJ2Rpc3BsYXknLCAnaGVpZ2h0JyksXG4gICAgdGhpcy5kaXNwbGF5X2RpZmYgPSBmdW5jdGlvbigpIHsgcmV0dXJuIE1hdGguZmxvb3IoIHRoaXMuZGlzcGxheV93aWR0aCgpIC0gdGhpcy5kaXNwbGF5X2hlaWdodCgpICk7IH07XG4gICAgdGhpcy5vcmlnX3dpZHRoID0gdGhpcy5fZGltZW5zaW9uKCdvcmlnJywgJ3dpZHRoJyksXG4gICAgdGhpcy5vcmlnX2hlaWdodCA9IHRoaXMuX2RpbWVuc2lvbignb3JpZycsICdoZWlnaHQnKSxcblxuICAgIC8qKlxuICAgICAqIFNldHRlciBmb3IgIFggY29vcmRpbmF0ZS4gSWYgaW1hZ2UgaXMgcm90YXRlZCB3ZSBuZWVkIHRvIGFkZGl0aW9uYWx5IHNoaWZ0IGFuXG4gICAgICogICAgIGltYWdlIHRvIG1hcCBpbWFnZSBjb29yZGluYXRlIHRvIHRoZSB2aXN1YWwgcG9zaXRpb24uXG4gICAgICpcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gdmFsIENvb3JkaW5hdGUgdmFsdWUuXG4gICAgICogQHBhcmFtIHtib29sZWFufSBza2lwQ3NzIElmIHRydWUsIHdlIG9ubHkgc2V0IHRoZSB2YWx1ZSBhbmQgZG8gbm90IHRvdWNoIHRoZSBkb20uXG4gICAgICovXG4gICAgdGhpcy54ID0gc2V0dGVyKGZ1bmN0aW9uKHZhbCwgc2tpcENzcykge1xuICAgICAgICAgICAgdGhpcy5feCA9IHZhbDtcbiAgICAgICAgICAgIGlmICghc2tpcENzcykge1xuICAgICAgICAgICAgICAgIHRoaXMuX2ZpbmlzaEFuaW1hdGlvbigpO1xuICAgICAgICAgICAgICAgIHRoaXMuX2ltZy5jc3MoXCJsZWZ0XCIsdGhpcy5feCArICh0aGlzLl9zd2FwRGltZW5zaW9ucyA/IHRoaXMuZGlzcGxheV9kaWZmKCkgLyAyIDogMCkgKyBcInB4XCIpO1xuICAgICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgICBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIHJldHVybiB0aGlzLl94O1xuICAgICAgICB9KTtcblxuICAgIC8qKlxuICAgICAqIFNldHRlciBmb3IgIFkgY29vcmRpbmF0ZS4gSWYgaW1hZ2UgaXMgcm90YXRlZCB3ZSBuZWVkIHRvIGFkZGl0aW9uYWx5IHNoaWZ0IGFuXG4gICAgICogICAgIGltYWdlIHRvIG1hcCBpbWFnZSBjb29yZGluYXRlIHRvIHRoZSB2aXN1YWwgcG9zaXRpb24uXG4gICAgICpcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gdmFsIENvb3JkaW5hdGUgdmFsdWUuXG4gICAgICogQHBhcmFtIHtib29sZWFufSBza2lwQ3NzIElmIHRydWUsIHdlIG9ubHkgc2V0IHRoZSB2YWx1ZSBhbmQgZG8gbm90IHRvdWNoIHRoZSBkb20uXG4gICAgICovXG4gICAgdGhpcy55ID0gc2V0dGVyKGZ1bmN0aW9uKHZhbCwgc2tpcENzcykge1xuICAgICAgICAgICAgdGhpcy5feSA9IHZhbDtcbiAgICAgICAgICAgIGlmICghc2tpcENzcykge1xuICAgICAgICAgICAgICAgIHRoaXMuX2ZpbmlzaEFuaW1hdGlvbigpO1xuICAgICAgICAgICAgICAgIHRoaXMuX2ltZy5jc3MoXCJ0b3BcIix0aGlzLl95IC0gKHRoaXMuX3N3YXBEaW1lbnNpb25zID8gdGhpcy5kaXNwbGF5X2RpZmYoKSAvIDIgOiAwKSArIFwicHhcIik7XG4gICAgICAgICAgICB9XG4gICAgICAgIH0sXG4gICAgICAgZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICByZXR1cm4gdGhpcy5feTtcbiAgICAgICB9KTtcblxuICAgIC8qKlxuICAgICAqIFBlcmZvcm0gaW1hZ2Ugcm90YXRpb24uXG4gICAgICpcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gZGVnIEFic29sdXRlIGltYWdlIGFuZ2xlLiBUaGUgbWV0aG9kIHdpbGwgd29yayB3aXRoIHZhbHVlcyAwLCA5MCwgMTgwLCAyNzAgZGVncmVlcy5cbiAgICAgKi9cbiAgICB0aGlzLmFuZ2xlID0gc2V0dGVyKGZ1bmN0aW9uKGRlZykge1xuICAgICAgICAgICAgdmFyIHByZXZTd2FwID0gdGhpcy5fc3dhcERpbWVuc2lvbnM7XG5cbiAgICAgICAgICAgIHRoaXMuX2FuZ2xlID0gZGVnO1xuICAgICAgICAgICAgdGhpcy5fc3dhcERpbWVuc2lvbnMgPSBkZWcgJSAxODAgIT09IDA7XG5cbiAgICAgICAgICAgIGlmIChwcmV2U3dhcCAhPT0gdGhpcy5fc3dhcERpbWVuc2lvbnMpIHtcbiAgICAgICAgICAgICAgICB2YXIgdmVydGljYWxNb2QgPSB0aGlzLl9zd2FwRGltZW5zaW9ucyA/IC0xIDogMTtcbiAgICAgICAgICAgICAgICB0aGlzLngodGhpcy54KCkgLSB2ZXJ0aWNhbE1vZCAqIHRoaXMuZGlzcGxheV9kaWZmKCkgLyAyLCB0cnVlKTtcbiAgICAgICAgICAgICAgICB0aGlzLnkodGhpcy55KCkgKyB2ZXJ0aWNhbE1vZCAqIHRoaXMuZGlzcGxheV9kaWZmKCkgLyAyLCB0cnVlKTtcbiAgICAgICAgICAgIH07XG5cbiAgICAgICAgICAgIHZhciBjc3NWYWwgPSAncm90YXRlKCcgKyBkZWcgKyAnZGVnKScsXG4gICAgICAgICAgICAgICAgaW1nID0gdGhpcy5faW1nO1xuXG4gICAgICAgICAgICBqUXVlcnkuZWFjaChbJycsICctd2Via2l0LScsICctbW96LScsICctby0nLCAnLW1zLSddLCBmdW5jdGlvbihpLCBwcmVmaXgpIHtcbiAgICAgICAgICAgICAgICBpbWcuY3NzKHByZWZpeCArICd0cmFuc2Zvcm0nLCBjc3NWYWwpO1xuICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgIGlmICh1c2VJZVRyYW5zZm9ybXMpIHtcbiAgICAgICAgICAgICAgICBqUXVlcnkuZWFjaChbJy1tcy0nLCAnJ10sIGZ1bmN0aW9uKGksIHByZWZpeCkge1xuICAgICAgICAgICAgICAgICAgICBpbWcuY3NzKHByZWZpeCArICdmaWx0ZXInLCBpZVRyYW5zZm9ybXNbZGVnXS5maWx0ZXIpO1xuICAgICAgICAgICAgICAgIH0pO1xuXG4gICAgICAgICAgICAgICAgaW1nLmNzcyh7XG4gICAgICAgICAgICAgICAgICAgIG1hcmdpbkxlZnQ6IGllVHJhbnNmb3Jtc1tkZWddLm1hcmdpbkxlZnQgKiB0aGlzLmRpc3BsYXlfZGlmZigpIC8gMixcbiAgICAgICAgICAgICAgICAgICAgbWFyZ2luVG9wOiBpZVRyYW5zZm9ybXNbZGVnXS5tYXJnaW5Ub3AgKiB0aGlzLmRpc3BsYXlfZGlmZigpIC8gMlxuICAgICAgICAgICAgICAgIH0pO1xuICAgICAgICAgICAgfVxuICAgICAgICB9LFxuICAgICAgIGZ1bmN0aW9uKCkgeyByZXR1cm4gdGhpcy5fYW5nbGU7IH0pO1xuXG4gICAgLyoqXG4gICAgICogTWFwIHBvaW50IGluIHRoZSBjb250YWluZXIgY29vcmRpbmF0ZXMgdG8gdGhlIHBvaW50IGluIGltYWdlIGNvb3JkaW5hdGVzLlxuICAgICAqICAgICBZb3Ugd2lsbCBnZXQgY29vcmRpbmF0ZXMgb2YgcG9pbnQgb24gaW1hZ2Ugd2l0aCByZXNwZWN0IHRvIHJvdGF0aW9uLFxuICAgICAqICAgICBidXQgd2lsbCBiZSBzZXQgYXMgaWYgaW1hZ2Ugd2FzIG5vdCByb3RhdGVkLlxuICAgICAqICAgICBTbywgaWYgaW1hZ2Ugd2FzIHJvdGF0ZWQgOTAgZGVncmVlcywgaXQncyAoMCwwKSBwb2ludCB3aWxsIGJlIG9uIHRoZVxuICAgICAqICAgICB0b3AgcmlnaHQgY29ybmVyLlxuICAgICAqXG4gICAgICogQHBhcmFtIHt7eDogbnVtYmVyLCB5OiBudW1iZXJ9fSBwb2ludCBQb2ludCBpbiBjb250YWluZXIgY29vcmRpbmF0ZXMuXG4gICAgICogQHJldHVybiAge3t4OiBudW1iZXIsIHk6IG51bWJlcn19XG4gICAgICovXG4gICAgdGhpcy50b09yaWdpbmFsQ29vcmRzID0gZnVuY3Rpb24ocG9pbnQpIHtcbiAgICAgICAgc3dpdGNoICh0aGlzLmFuZ2xlKCkpIHtcbiAgICAgICAgICAgIGNhc2UgMDogcmV0dXJuIHsgeDogcG9pbnQueCwgeTogcG9pbnQueSB9O1xuICAgICAgICAgICAgY2FzZSA5MDogcmV0dXJuIHsgeDogcG9pbnQueSwgeTogdGhpcy5kaXNwbGF5X3dpZHRoKCkgLSBwb2ludC54IH07XG4gICAgICAgICAgICBjYXNlIDE4MDogcmV0dXJuIHsgeDogdGhpcy5kaXNwbGF5X3dpZHRoKCkgLSBwb2ludC54LCB5OiB0aGlzLmRpc3BsYXlfaGVpZ2h0KCkgLSBwb2ludC55IH07XG4gICAgICAgICAgICBjYXNlIDI3MDogcmV0dXJuIHsgeDogdGhpcy5kaXNwbGF5X2hlaWdodCgpIC0gcG9pbnQueSwgeTogcG9pbnQueCB9O1xuICAgICAgICB9XG4gICAgfTtcblxuICAgIC8qKlxuICAgICAqIE1hcCBwb2ludCBpbiB0aGUgaW1hZ2UgY29vcmRpbmF0ZXMgdG8gdGhlIHBvaW50IGluIGNvbnRhaW5lciBjb29yZGluYXRlcy5cbiAgICAgKiAgICAgWW91IHdpbGwgZ2V0IGNvb3JkaW5hdGVzIG9mIHBvaW50IG9uIGNvbnRhaW5lciB3aXRoIHJlc3BlY3QgdG8gcm90YXRpb24uXG4gICAgICogICAgIE5vdGUsIGlmIGltYWdlIHdhcyByb3RhdGVkIDkwIGRlZ3JlZXMsIGl0J3MgKDAsMCkgcG9pbnQgd2lsbCBiZSBvbiB0aGVcbiAgICAgKiAgICAgdG9wIHJpZ2h0IGNvcm5lci5cbiAgICAgKlxuICAgICAqIEBwYXJhbSB7e3g6IG51bWJlciwgeTogbnVtYmVyfX0gcG9pbnQgUG9pbnQgaW4gY29udGFpbmVyIGNvb3JkaW5hdGVzLlxuICAgICAqIEByZXR1cm4gIHt7eDogbnVtYmVyLCB5OiBudW1iZXJ9fVxuICAgICAqL1xuICAgIHRoaXMudG9SZWFsQ29vcmRzID0gZnVuY3Rpb24ocG9pbnQpIHtcbiAgICAgICAgc3dpdGNoICh0aGlzLmFuZ2xlKCkpIHtcbiAgICAgICAgICAgIGNhc2UgMDogcmV0dXJuIHsgeDogdGhpcy54KCkgKyBwb2ludC54LCB5OiB0aGlzLnkoKSArIHBvaW50LnkgfTtcbiAgICAgICAgICAgIGNhc2UgOTA6IHJldHVybiB7IHg6IHRoaXMueCgpICsgdGhpcy5kaXNwbGF5X3dpZHRoKCkgLSBwb2ludC55LCB5OiB0aGlzLnkoKSArIHBvaW50Lnh9O1xuICAgICAgICAgICAgY2FzZSAxODA6IHJldHVybiB7IHg6IHRoaXMueCgpICsgdGhpcy5kaXNwbGF5X3dpZHRoKCkgLSBwb2ludC54LCB5OiB0aGlzLnkoKSArIHRoaXMuZGlzcGxheV9oZWlnaHQoKSAtIHBvaW50Lnl9O1xuICAgICAgICAgICAgY2FzZSAyNzA6IHJldHVybiB7IHg6IHRoaXMueCgpICsgcG9pbnQueSwgeTogdGhpcy55KCkgKyB0aGlzLmRpc3BsYXlfaGVpZ2h0KCkgLSBwb2ludC54fTtcbiAgICAgICAgfVxuICAgIH07XG5cbiAgICAvKipcbiAgICAgKiBAcmV0dXJuIHtqUXVlcnl9IFJldHVybiBpbWFnZSBub2RlLiB0aGlzIGlzIG5lZWRlZCB0byBhZGQgZXZlbnQgaGFuZGxlcnMuXG4gICAgICovXG4gICAgdGhpcy5vYmplY3QgPSBzZXR0ZXIoalF1ZXJ5Lm5vb3AsXG4gICAgICAgICAgICAgICAgICAgICAgICAgICBmdW5jdGlvbigpIHsgcmV0dXJuIHRoaXMuX2ltZzsgfSk7XG5cbiAgICAvKipcbiAgICAgKiBDaGFuZ2UgaW1hZ2UgcHJvcGVydGllcy5cbiAgICAgKlxuICAgICAqIEBwYXJhbSB7bnVtYmVyfSBkaXNwX3cgRGlzcGxheSB3aWR0aDtcbiAgICAgKiBAcGFyYW0ge251bWJlcn0gZGlzcF9oIERpc3BsYXkgaGVpZ2h0O1xuICAgICAqIEBwYXJhbSB7bnVtYmVyfSB4XG4gICAgICogQHBhcmFtIHtudW1iZXJ9IHlcbiAgICAgKiBAcGFyYW0ge2Jvb2xlYW59IHNraXBfYW5pbWF0aW9uIElmIHRydWUsIHRoZSBhbmltYXRpb24gd2lsbCBiZSBza2lwZWQgZGVzcGl0ZSB0aGVcbiAgICAgKiAgICAgdmFsdWUgc2V0IGluIGNvbnN0cnVjdG9yLlxuICAgICAqIEBwYXJhbSB7RnVuY3Rpb249fSBjb21wbGV0ZSBDYWxsIGJhY2sgd2lsbCBiZSBmaXJlZCB3aGVuIHpvb20gd2lsbCBiZSBjb21wbGV0ZS5cbiAgICAgKi9cbiAgICB0aGlzLnNldEltYWdlUHJvcHMgPSBmdW5jdGlvbihkaXNwX3csIGRpc3BfaCwgeCwgeSwgc2tpcF9hbmltYXRpb24sIGNvbXBsZXRlKSB7XG4gICAgICAgIGNvbXBsZXRlID0gY29tcGxldGUgfHwgalF1ZXJ5Lm5vb3A7XG5cbiAgICAgICAgdGhpcy5kaXNwbGF5X3dpZHRoKGRpc3Bfdyk7XG4gICAgICAgIHRoaXMuZGlzcGxheV9oZWlnaHQoZGlzcF9oKTtcbiAgICAgICAgdGhpcy54KHgsIHRydWUpO1xuICAgICAgICB0aGlzLnkoeSwgdHJ1ZSk7XG5cbiAgICAgICAgdmFyIHcgPSB0aGlzLl9zd2FwRGltZW5zaW9ucyA/IGRpc3BfaCA6IGRpc3BfdztcbiAgICAgICAgdmFyIGggPSB0aGlzLl9zd2FwRGltZW5zaW9ucyA/IGRpc3BfdyA6IGRpc3BfaDtcblxuICAgICAgICB2YXIgcGFyYW1zID0ge1xuICAgICAgICAgICAgd2lkdGg6IHcsXG4gICAgICAgICAgICBoZWlnaHQ6IGgsXG4gICAgICAgICAgICB0b3A6IHkgLSAodGhpcy5fc3dhcERpbWVuc2lvbnMgPyB0aGlzLmRpc3BsYXlfZGlmZigpIC8gMiA6IDApICsgXCJweFwiLFxuICAgICAgICAgICAgbGVmdDogeCArICh0aGlzLl9zd2FwRGltZW5zaW9ucyA/IHRoaXMuZGlzcGxheV9kaWZmKCkgLyAyIDogMCkgKyBcInB4XCJcbiAgICAgICAgfTtcblxuICAgICAgICBpZiAodXNlSWVUcmFuc2Zvcm1zKSB7XG4gICAgICAgICAgICBqUXVlcnkuZXh0ZW5kKHBhcmFtcywge1xuICAgICAgICAgICAgICAgIG1hcmdpbkxlZnQ6IGllVHJhbnNmb3Jtc1t0aGlzLmFuZ2xlKCldLm1hcmdpbkxlZnQgKiB0aGlzLmRpc3BsYXlfZGlmZigpIC8gMixcbiAgICAgICAgICAgICAgICBtYXJnaW5Ub3A6IGllVHJhbnNmb3Jtc1t0aGlzLmFuZ2xlKCldLm1hcmdpblRvcCAqIHRoaXMuZGlzcGxheV9kaWZmKCkgLyAyXG4gICAgICAgICAgICB9KTtcbiAgICAgICAgfVxuXG4gICAgICAgIHZhciBzd2FwRGltcyA9IHRoaXMuX3N3YXBEaW1lbnNpb25zLFxuICAgICAgICAgICAgaW1nID0gdGhpcy5faW1nO1xuXG4gICAgICAgIC8vaGVyZSB3ZSBjb21lOiBhbm90aGVyIElFIG9kZG5lc3MuIElmIGltYWdlIGlzIHJvdGF0ZWQgOTAgZGVncmVlcyB3aXRoIGEgZmlsdGVyLCB0aGFuXG4gICAgICAgIC8vd2lkdGggYW5kIGhlaWdodCBnZXR0ZXJzIHJldHVybiByZWFsIHdpZHRoIGFuZCBoZWlnaHQgb2Ygcm90YXRlZCBpbWFnZS4gVGhlIGJhZCBuZXdzXG4gICAgICAgIC8vaXMgdGhhdCB0byBzZXQgaGVpZ2h0IHlvdSBuZWVkIHRvIHNldCBhIHdpZHRoIGFuZCB2aWNlIHZlcnNhLiBGdWNrIElFLlxuICAgICAgICAvL1NvLCBpbiB0aGlzIGNhc2Ugd2UgaGF2ZSB0byBhbmltYXRlIHdpZHRoIGFuZCBoZWlnaHQgbWFudWFsbHkuXG4gICAgICAgIGlmKHVzZUllVHJhbnNmb3JtcyAmJiBzd2FwRGltcykge1xuICAgICAgICAgICAgdmFyIGllaCA9IHRoaXMuX2ltZy53aWR0aCgpLFxuICAgICAgICAgICAgICAgIGlldyA9IHRoaXMuX2ltZy5oZWlnaHQoKSxcbiAgICAgICAgICAgICAgICBpZWRoID0gcGFyYW1zLmhlaWdodCAtIGllaDtcbiAgICAgICAgICAgICAgICBpZWR3ID0gcGFyYW1zLndpZHRoIC0gaWV3O1xuXG4gICAgICAgICAgICBkZWxldGUgcGFyYW1zLndpZHRoO1xuICAgICAgICAgICAgZGVsZXRlIHBhcmFtcy5oZWlnaHQ7XG4gICAgICAgIH1cblxuICAgICAgICBpZiAodGhpcy5fZG9fYW5pbSAmJiAhc2tpcF9hbmltYXRpb24pIHtcbiAgICAgICAgICAgIHRoaXMuX2ltZy5zdG9wKHRydWUpXG4gICAgICAgICAgICAgICAgLmFuaW1hdGUocGFyYW1zLCB7XG4gICAgICAgICAgICAgICAgICAgIGR1cmF0aW9uOiAyMDAsXG4gICAgICAgICAgICAgICAgICAgIGNvbXBsZXRlOiBjb21wbGV0ZSxcbiAgICAgICAgICAgICAgICAgICAgc3RlcDogZnVuY3Rpb24obm93LCBmeCkge1xuICAgICAgICAgICAgICAgICAgICAgICAgaWYodXNlSWVUcmFuc2Zvcm1zICYmIHN3YXBEaW1zICYmIChmeC5wcm9wID09PSAndG9wJykpIHtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICB2YXIgcGVyY2VudCA9IChub3cgLSBmeC5zdGFydCkgLyAoZnguZW5kIC0gZnguc3RhcnQpO1xuXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaW1nLmhlaWdodChpZWggKyBpZWRoICogcGVyY2VudCk7XG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgaW1nLndpZHRoKGlldyArIGllZHcgKiBwZXJjZW50KTtcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBpbWcuY3NzKCd0b3AnLCBub3cpO1xuICAgICAgICAgICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgfSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICB0aGlzLl9pbWcuY3NzKHBhcmFtcyk7XG4gICAgICAgICAgICBzZXRUaW1lb3V0KGNvbXBsZXRlLCAwKTsgLy9ib3RoIGlmIGJyYW5jaGVzIHNob3VsZCBiZWhhdmUgZXF1YWxseS5cbiAgICAgICAgfVxuICAgIH07XG5cbiAgICAvL2lmIHdlIHNldCBpbWFnZSBjb29yZGluYXRlcyB3ZSBuZWVkIHRvIGJlIHN1cmUgdGhhdCBubyBhbmltYXRpb24gaXMgYWN0aXZlIGF0bVxuICAgIHRoaXMuX2ZpbmlzaEFuaW1hdGlvbiA9IGZ1bmN0aW9uKCkge1xuICAgICAgdGhpcy5faW1nLnN0b3AodHJ1ZSwgdHJ1ZSk7XG4gICAgfTtcblxufSkuYXBwbHkoJC51aS5pdmlld2VyLkltYWdlT2JqZWN0LnByb3RvdHlwZSk7XG5cblxuXG52YXIgdXRpbCA9IHtcbiAgICBzY2FsZVZhbHVlOiBmdW5jdGlvbih2YWx1ZSwgdG9ab29tKVxuICAgIHtcbiAgICAgICAgcmV0dXJuIHZhbHVlICogdG9ab29tIC8gMTAwO1xuICAgIH0sXG5cbiAgICBkZXNjYWxlVmFsdWU6IGZ1bmN0aW9uKHZhbHVlLCBmcm9tWm9vbSlcbiAgICB7XG4gICAgICAgIHJldHVybiB2YWx1ZSAqIDEwMCAvIGZyb21ab29tO1xuICAgIH1cbn07XG5cbiB9ICkoIGpRdWVyeSwgdW5kZWZpbmVkICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBNb3VzZXdoZWVsIDMuMS4xM1xuICpcbiAqIENvcHlyaWdodCBqUXVlcnkgRm91bmRhdGlvbiBhbmQgb3RoZXIgY29udHJpYnV0b3JzXG4gKiBSZWxlYXNlZCB1bmRlciB0aGUgTUlUIGxpY2Vuc2VcbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4oZnVuY3Rpb24gKGZhY3RvcnkpIHtcbiAgICBpZiAoIHR5cGVvZiBkZWZpbmUgPT09ICdmdW5jdGlvbicgJiYgZGVmaW5lLmFtZCApIHtcbiAgICAgICAgLy8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuICAgICAgICBkZWZpbmUoWydqcXVlcnknXSwgZmFjdG9yeSk7XG4gICAgfSBlbHNlIGlmICh0eXBlb2YgZXhwb3J0cyA9PT0gJ29iamVjdCcpIHtcbiAgICAgICAgLy8gTm9kZS9Db21tb25KUyBzdHlsZSBmb3IgQnJvd3NlcmlmeVxuICAgICAgICBtb2R1bGUuZXhwb3J0cyA9IGZhY3Rvcnk7XG4gICAgfSBlbHNlIHtcbiAgICAgICAgLy8gQnJvd3NlciBnbG9iYWxzXG4gICAgICAgIGZhY3RvcnkoalF1ZXJ5KTtcbiAgICB9XG59KGZ1bmN0aW9uICgkKSB7XG5cbiAgICB2YXIgdG9GaXggID0gWyd3aGVlbCcsICdtb3VzZXdoZWVsJywgJ0RPTU1vdXNlU2Nyb2xsJywgJ01vek1vdXNlUGl4ZWxTY3JvbGwnXSxcbiAgICAgICAgdG9CaW5kID0gKCAnb253aGVlbCcgaW4gZG9jdW1lbnQgfHwgZG9jdW1lbnQuZG9jdW1lbnRNb2RlID49IDkgKSA/XG4gICAgICAgICAgICAgICAgICAgIFsnd2hlZWwnXSA6IFsnbW91c2V3aGVlbCcsICdEb21Nb3VzZVNjcm9sbCcsICdNb3pNb3VzZVBpeGVsU2Nyb2xsJ10sXG4gICAgICAgIHNsaWNlICA9IEFycmF5LnByb3RvdHlwZS5zbGljZSxcbiAgICAgICAgbnVsbExvd2VzdERlbHRhVGltZW91dCwgbG93ZXN0RGVsdGE7XG5cbiAgICBpZiAoICQuZXZlbnQuZml4SG9va3MgKSB7XG4gICAgICAgIGZvciAoIHZhciBpID0gdG9GaXgubGVuZ3RoOyBpOyApIHtcbiAgICAgICAgICAgICQuZXZlbnQuZml4SG9va3NbIHRvRml4Wy0taV0gXSA9ICQuZXZlbnQubW91c2VIb29rcztcbiAgICAgICAgfVxuICAgIH1cblxuICAgIHZhciBzcGVjaWFsID0gJC5ldmVudC5zcGVjaWFsLm1vdXNld2hlZWwgPSB7XG4gICAgICAgIHZlcnNpb246ICczLjEuMTInLFxuXG4gICAgICAgIHNldHVwOiBmdW5jdGlvbigpIHtcbiAgICAgICAgICAgIGlmICggdGhpcy5hZGRFdmVudExpc3RlbmVyICkge1xuICAgICAgICAgICAgICAgIGZvciAoIHZhciBpID0gdG9CaW5kLmxlbmd0aDsgaTsgKSB7XG4gICAgICAgICAgICAgICAgICAgIHRoaXMuYWRkRXZlbnRMaXN0ZW5lciggdG9CaW5kWy0taV0sIGhhbmRsZXIsIGZhbHNlICk7XG4gICAgICAgICAgICAgICAgfVxuICAgICAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgICAgICB0aGlzLm9ubW91c2V3aGVlbCA9IGhhbmRsZXI7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICAvLyBTdG9yZSB0aGUgbGluZSBoZWlnaHQgYW5kIHBhZ2UgaGVpZ2h0IGZvciB0aGlzIHBhcnRpY3VsYXIgZWxlbWVudFxuICAgICAgICAgICAgJC5kYXRhKHRoaXMsICdtb3VzZXdoZWVsLWxpbmUtaGVpZ2h0Jywgc3BlY2lhbC5nZXRMaW5lSGVpZ2h0KHRoaXMpKTtcbiAgICAgICAgICAgICQuZGF0YSh0aGlzLCAnbW91c2V3aGVlbC1wYWdlLWhlaWdodCcsIHNwZWNpYWwuZ2V0UGFnZUhlaWdodCh0aGlzKSk7XG4gICAgICAgIH0sXG5cbiAgICAgICAgdGVhcmRvd246IGZ1bmN0aW9uKCkge1xuICAgICAgICAgICAgaWYgKCB0aGlzLnJlbW92ZUV2ZW50TGlzdGVuZXIgKSB7XG4gICAgICAgICAgICAgICAgZm9yICggdmFyIGkgPSB0b0JpbmQubGVuZ3RoOyBpOyApIHtcbiAgICAgICAgICAgICAgICAgICAgdGhpcy5yZW1vdmVFdmVudExpc3RlbmVyKCB0b0JpbmRbLS1pXSwgaGFuZGxlciwgZmFsc2UgKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgIHRoaXMub25tb3VzZXdoZWVsID0gbnVsbDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIC8vIENsZWFuIHVwIHRoZSBkYXRhIHdlIGFkZGVkIHRvIHRoZSBlbGVtZW50XG4gICAgICAgICAgICAkLnJlbW92ZURhdGEodGhpcywgJ21vdXNld2hlZWwtbGluZS1oZWlnaHQnKTtcbiAgICAgICAgICAgICQucmVtb3ZlRGF0YSh0aGlzLCAnbW91c2V3aGVlbC1wYWdlLWhlaWdodCcpO1xuICAgICAgICB9LFxuXG4gICAgICAgIGdldExpbmVIZWlnaHQ6IGZ1bmN0aW9uKGVsZW0pIHtcbiAgICAgICAgICAgIHZhciAkZWxlbSA9ICQoZWxlbSksXG4gICAgICAgICAgICAgICAgJHBhcmVudCA9ICRlbGVtWydvZmZzZXRQYXJlbnQnIGluICQuZm4gPyAnb2Zmc2V0UGFyZW50JyA6ICdwYXJlbnQnXSgpO1xuICAgICAgICAgICAgaWYgKCEkcGFyZW50Lmxlbmd0aCkge1xuICAgICAgICAgICAgICAgICRwYXJlbnQgPSAkKCdib2R5Jyk7XG4gICAgICAgICAgICB9XG4gICAgICAgICAgICByZXR1cm4gcGFyc2VJbnQoJHBhcmVudC5jc3MoJ2ZvbnRTaXplJyksIDEwKSB8fCBwYXJzZUludCgkZWxlbS5jc3MoJ2ZvbnRTaXplJyksIDEwKSB8fCAxNjtcbiAgICAgICAgfSxcblxuICAgICAgICBnZXRQYWdlSGVpZ2h0OiBmdW5jdGlvbihlbGVtKSB7XG4gICAgICAgICAgICByZXR1cm4gJChlbGVtKS5oZWlnaHQoKTtcbiAgICAgICAgfSxcblxuICAgICAgICBzZXR0aW5nczoge1xuICAgICAgICAgICAgYWRqdXN0T2xkRGVsdGFzOiB0cnVlLCAvLyBzZWUgc2hvdWxkQWRqdXN0T2xkRGVsdGFzKCkgYmVsb3dcbiAgICAgICAgICAgIG5vcm1hbGl6ZU9mZnNldDogdHJ1ZSAgLy8gY2FsbHMgZ2V0Qm91bmRpbmdDbGllbnRSZWN0IGZvciBlYWNoIGV2ZW50XG4gICAgICAgIH1cbiAgICB9O1xuXG4gICAgJC5mbi5leHRlbmQoe1xuICAgICAgICBtb3VzZXdoZWVsOiBmdW5jdGlvbihmbikge1xuICAgICAgICAgICAgcmV0dXJuIGZuID8gdGhpcy5iaW5kKCdtb3VzZXdoZWVsJywgZm4pIDogdGhpcy50cmlnZ2VyKCdtb3VzZXdoZWVsJyk7XG4gICAgICAgIH0sXG5cbiAgICAgICAgdW5tb3VzZXdoZWVsOiBmdW5jdGlvbihmbikge1xuICAgICAgICAgICAgcmV0dXJuIHRoaXMudW5iaW5kKCdtb3VzZXdoZWVsJywgZm4pO1xuICAgICAgICB9XG4gICAgfSk7XG5cblxuICAgIGZ1bmN0aW9uIGhhbmRsZXIoZXZlbnQpIHtcbiAgICAgICAgdmFyIG9yZ0V2ZW50ICAgPSBldmVudCB8fCB3aW5kb3cuZXZlbnQsXG4gICAgICAgICAgICBhcmdzICAgICAgID0gc2xpY2UuY2FsbChhcmd1bWVudHMsIDEpLFxuICAgICAgICAgICAgZGVsdGEgICAgICA9IDAsXG4gICAgICAgICAgICBkZWx0YVggICAgID0gMCxcbiAgICAgICAgICAgIGRlbHRhWSAgICAgPSAwLFxuICAgICAgICAgICAgYWJzRGVsdGEgICA9IDAsXG4gICAgICAgICAgICBvZmZzZXRYICAgID0gMCxcbiAgICAgICAgICAgIG9mZnNldFkgICAgPSAwO1xuICAgICAgICBldmVudCA9ICQuZXZlbnQuZml4KG9yZ0V2ZW50KTtcbiAgICAgICAgZXZlbnQudHlwZSA9ICdtb3VzZXdoZWVsJztcblxuICAgICAgICAvLyBPbGQgc2Nob29sIHNjcm9sbHdoZWVsIGRlbHRhXG4gICAgICAgIGlmICggJ2RldGFpbCcgICAgICBpbiBvcmdFdmVudCApIHsgZGVsdGFZID0gb3JnRXZlbnQuZGV0YWlsICogLTE7ICAgICAgfVxuICAgICAgICBpZiAoICd3aGVlbERlbHRhJyAgaW4gb3JnRXZlbnQgKSB7IGRlbHRhWSA9IG9yZ0V2ZW50LndoZWVsRGVsdGE7ICAgICAgIH1cbiAgICAgICAgaWYgKCAnd2hlZWxEZWx0YVknIGluIG9yZ0V2ZW50ICkgeyBkZWx0YVkgPSBvcmdFdmVudC53aGVlbERlbHRhWTsgICAgICB9XG4gICAgICAgIGlmICggJ3doZWVsRGVsdGFYJyBpbiBvcmdFdmVudCApIHsgZGVsdGFYID0gb3JnRXZlbnQud2hlZWxEZWx0YVggKiAtMTsgfVxuXG4gICAgICAgIC8vIEZpcmVmb3ggPCAxNyBob3Jpem9udGFsIHNjcm9sbGluZyByZWxhdGVkIHRvIERPTU1vdXNlU2Nyb2xsIGV2ZW50XG4gICAgICAgIGlmICggJ2F4aXMnIGluIG9yZ0V2ZW50ICYmIG9yZ0V2ZW50LmF4aXMgPT09IG9yZ0V2ZW50LkhPUklaT05UQUxfQVhJUyApIHtcbiAgICAgICAgICAgIGRlbHRhWCA9IGRlbHRhWSAqIC0xO1xuICAgICAgICAgICAgZGVsdGFZID0gMDtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIFNldCBkZWx0YSB0byBiZSBkZWx0YVkgb3IgZGVsdGFYIGlmIGRlbHRhWSBpcyAwIGZvciBiYWNrd2FyZHMgY29tcGF0YWJpbGl0aXlcbiAgICAgICAgZGVsdGEgPSBkZWx0YVkgPT09IDAgPyBkZWx0YVggOiBkZWx0YVk7XG5cbiAgICAgICAgLy8gTmV3IHNjaG9vbCB3aGVlbCBkZWx0YSAod2hlZWwgZXZlbnQpXG4gICAgICAgIGlmICggJ2RlbHRhWScgaW4gb3JnRXZlbnQgKSB7XG4gICAgICAgICAgICBkZWx0YVkgPSBvcmdFdmVudC5kZWx0YVkgKiAtMTtcbiAgICAgICAgICAgIGRlbHRhICA9IGRlbHRhWTtcbiAgICAgICAgfVxuICAgICAgICBpZiAoICdkZWx0YVgnIGluIG9yZ0V2ZW50ICkge1xuICAgICAgICAgICAgZGVsdGFYID0gb3JnRXZlbnQuZGVsdGFYO1xuICAgICAgICAgICAgaWYgKCBkZWx0YVkgPT09IDAgKSB7IGRlbHRhICA9IGRlbHRhWCAqIC0xOyB9XG4gICAgICAgIH1cblxuICAgICAgICAvLyBObyBjaGFuZ2UgYWN0dWFsbHkgaGFwcGVuZWQsIG5vIHJlYXNvbiB0byBnbyBhbnkgZnVydGhlclxuICAgICAgICBpZiAoIGRlbHRhWSA9PT0gMCAmJiBkZWx0YVggPT09IDAgKSB7IHJldHVybjsgfVxuXG4gICAgICAgIC8vIE5lZWQgdG8gY29udmVydCBsaW5lcyBhbmQgcGFnZXMgdG8gcGl4ZWxzIGlmIHdlIGFyZW4ndCBhbHJlYWR5IGluIHBpeGVsc1xuICAgICAgICAvLyBUaGVyZSBhcmUgdGhyZWUgZGVsdGEgbW9kZXM6XG4gICAgICAgIC8vICAgKiBkZWx0YU1vZGUgMCBpcyBieSBwaXhlbHMsIG5vdGhpbmcgdG8gZG9cbiAgICAgICAgLy8gICAqIGRlbHRhTW9kZSAxIGlzIGJ5IGxpbmVzXG4gICAgICAgIC8vICAgKiBkZWx0YU1vZGUgMiBpcyBieSBwYWdlc1xuICAgICAgICBpZiAoIG9yZ0V2ZW50LmRlbHRhTW9kZSA9PT0gMSApIHtcbiAgICAgICAgICAgIHZhciBsaW5lSGVpZ2h0ID0gJC5kYXRhKHRoaXMsICdtb3VzZXdoZWVsLWxpbmUtaGVpZ2h0Jyk7XG4gICAgICAgICAgICBkZWx0YSAgKj0gbGluZUhlaWdodDtcbiAgICAgICAgICAgIGRlbHRhWSAqPSBsaW5lSGVpZ2h0O1xuICAgICAgICAgICAgZGVsdGFYICo9IGxpbmVIZWlnaHQ7XG4gICAgICAgIH0gZWxzZSBpZiAoIG9yZ0V2ZW50LmRlbHRhTW9kZSA9PT0gMiApIHtcbiAgICAgICAgICAgIHZhciBwYWdlSGVpZ2h0ID0gJC5kYXRhKHRoaXMsICdtb3VzZXdoZWVsLXBhZ2UtaGVpZ2h0Jyk7XG4gICAgICAgICAgICBkZWx0YSAgKj0gcGFnZUhlaWdodDtcbiAgICAgICAgICAgIGRlbHRhWSAqPSBwYWdlSGVpZ2h0O1xuICAgICAgICAgICAgZGVsdGFYICo9IHBhZ2VIZWlnaHQ7XG4gICAgICAgIH1cblxuICAgICAgICAvLyBTdG9yZSBsb3dlc3QgYWJzb2x1dGUgZGVsdGEgdG8gbm9ybWFsaXplIHRoZSBkZWx0YSB2YWx1ZXNcbiAgICAgICAgYWJzRGVsdGEgPSBNYXRoLm1heCggTWF0aC5hYnMoZGVsdGFZKSwgTWF0aC5hYnMoZGVsdGFYKSApO1xuXG4gICAgICAgIGlmICggIWxvd2VzdERlbHRhIHx8IGFic0RlbHRhIDwgbG93ZXN0RGVsdGEgKSB7XG4gICAgICAgICAgICBsb3dlc3REZWx0YSA9IGFic0RlbHRhO1xuXG4gICAgICAgICAgICAvLyBBZGp1c3Qgb2xkZXIgZGVsdGFzIGlmIG5lY2Vzc2FyeVxuICAgICAgICAgICAgaWYgKCBzaG91bGRBZGp1c3RPbGREZWx0YXMob3JnRXZlbnQsIGFic0RlbHRhKSApIHtcbiAgICAgICAgICAgICAgICBsb3dlc3REZWx0YSAvPSA0MDtcbiAgICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIC8vIEFkanVzdCBvbGRlciBkZWx0YXMgaWYgbmVjZXNzYXJ5XG4gICAgICAgIGlmICggc2hvdWxkQWRqdXN0T2xkRGVsdGFzKG9yZ0V2ZW50LCBhYnNEZWx0YSkgKSB7XG4gICAgICAgICAgICAvLyBEaXZpZGUgYWxsIHRoZSB0aGluZ3MgYnkgNDAhXG4gICAgICAgICAgICBkZWx0YSAgLz0gNDA7XG4gICAgICAgICAgICBkZWx0YVggLz0gNDA7XG4gICAgICAgICAgICBkZWx0YVkgLz0gNDA7XG4gICAgICAgIH1cblxuICAgICAgICAvLyBHZXQgYSB3aG9sZSwgbm9ybWFsaXplZCB2YWx1ZSBmb3IgdGhlIGRlbHRhc1xuICAgICAgICBkZWx0YSAgPSBNYXRoWyBkZWx0YSAgPj0gMSA/ICdmbG9vcicgOiAnY2VpbCcgXShkZWx0YSAgLyBsb3dlc3REZWx0YSk7XG4gICAgICAgIGRlbHRhWCA9IE1hdGhbIGRlbHRhWCA+PSAxID8gJ2Zsb29yJyA6ICdjZWlsJyBdKGRlbHRhWCAvIGxvd2VzdERlbHRhKTtcbiAgICAgICAgZGVsdGFZID0gTWF0aFsgZGVsdGFZID49IDEgPyAnZmxvb3InIDogJ2NlaWwnIF0oZGVsdGFZIC8gbG93ZXN0RGVsdGEpO1xuXG4gICAgICAgIC8vIE5vcm1hbGlzZSBvZmZzZXRYIGFuZCBvZmZzZXRZIHByb3BlcnRpZXNcbiAgICAgICAgaWYgKCBzcGVjaWFsLnNldHRpbmdzLm5vcm1hbGl6ZU9mZnNldCAmJiB0aGlzLmdldEJvdW5kaW5nQ2xpZW50UmVjdCApIHtcbiAgICAgICAgICAgIHZhciBib3VuZGluZ1JlY3QgPSB0aGlzLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgICAgICAgICAgb2Zmc2V0WCA9IGV2ZW50LmNsaWVudFggLSBib3VuZGluZ1JlY3QubGVmdDtcbiAgICAgICAgICAgIG9mZnNldFkgPSBldmVudC5jbGllbnRZIC0gYm91bmRpbmdSZWN0LnRvcDtcbiAgICAgICAgfVxuXG4gICAgICAgIC8vIEFkZCBpbmZvcm1hdGlvbiB0byB0aGUgZXZlbnQgb2JqZWN0XG4gICAgICAgIGV2ZW50LmRlbHRhWCA9IGRlbHRhWDtcbiAgICAgICAgZXZlbnQuZGVsdGFZID0gZGVsdGFZO1xuICAgICAgICBldmVudC5kZWx0YUZhY3RvciA9IGxvd2VzdERlbHRhO1xuICAgICAgICBldmVudC5vZmZzZXRYID0gb2Zmc2V0WDtcbiAgICAgICAgZXZlbnQub2Zmc2V0WSA9IG9mZnNldFk7XG4gICAgICAgIC8vIEdvIGFoZWFkIGFuZCBzZXQgZGVsdGFNb2RlIHRvIDAgc2luY2Ugd2UgY29udmVydGVkIHRvIHBpeGVsc1xuICAgICAgICAvLyBBbHRob3VnaCB0aGlzIGlzIGEgbGl0dGxlIG9kZCBzaW5jZSB3ZSBvdmVyd3JpdGUgdGhlIGRlbHRhWC9ZXG4gICAgICAgIC8vIHByb3BlcnRpZXMgd2l0aCBub3JtYWxpemVkIGRlbHRhcy5cbiAgICAgICAgZXZlbnQuZGVsdGFNb2RlID0gMDtcblxuICAgICAgICAvLyBBZGQgZXZlbnQgYW5kIGRlbHRhIHRvIHRoZSBmcm9udCBvZiB0aGUgYXJndW1lbnRzXG4gICAgICAgIGFyZ3MudW5zaGlmdChldmVudCwgZGVsdGEsIGRlbHRhWCwgZGVsdGFZKTtcblxuICAgICAgICAvLyBDbGVhcm91dCBsb3dlc3REZWx0YSBhZnRlciBzb21ldGltZSB0byBiZXR0ZXJcbiAgICAgICAgLy8gaGFuZGxlIG11bHRpcGxlIGRldmljZSB0eXBlcyB0aGF0IGdpdmUgZGlmZmVyZW50XG4gICAgICAgIC8vIGEgZGlmZmVyZW50IGxvd2VzdERlbHRhXG4gICAgICAgIC8vIEV4OiB0cmFja3BhZCA9IDMgYW5kIG1vdXNlIHdoZWVsID0gMTIwXG4gICAgICAgIGlmIChudWxsTG93ZXN0RGVsdGFUaW1lb3V0KSB7IGNsZWFyVGltZW91dChudWxsTG93ZXN0RGVsdGFUaW1lb3V0KTsgfVxuICAgICAgICBudWxsTG93ZXN0RGVsdGFUaW1lb3V0ID0gc2V0VGltZW91dChudWxsTG93ZXN0RGVsdGEsIDIwMCk7XG5cbiAgICAgICAgcmV0dXJuICgkLmV2ZW50LmRpc3BhdGNoIHx8ICQuZXZlbnQuaGFuZGxlKS5hcHBseSh0aGlzLCBhcmdzKTtcbiAgICB9XG5cbiAgICBmdW5jdGlvbiBudWxsTG93ZXN0RGVsdGEoKSB7XG4gICAgICAgIGxvd2VzdERlbHRhID0gbnVsbDtcbiAgICB9XG5cbiAgICBmdW5jdGlvbiBzaG91bGRBZGp1c3RPbGREZWx0YXMob3JnRXZlbnQsIGFic0RlbHRhKSB7XG4gICAgICAgIC8vIElmIHRoaXMgaXMgYW4gb2xkZXIgZXZlbnQgYW5kIHRoZSBkZWx0YSBpcyBkaXZpc2FibGUgYnkgMTIwLFxuICAgICAgICAvLyB0aGVuIHdlIGFyZSBhc3N1bWluZyB0aGF0IHRoZSBicm93c2VyIGlzIHRyZWF0aW5nIHRoaXMgYXMgYW5cbiAgICAgICAgLy8gb2xkZXIgbW91c2Ugd2hlZWwgZXZlbnQgYW5kIHRoYXQgd2Ugc2hvdWxkIGRpdmlkZSB0aGUgZGVsdGFzXG4gICAgICAgIC8vIGJ5IDQwIHRvIHRyeSBhbmQgZ2V0IGEgbW9yZSB1c2FibGUgZGVsdGFGYWN0b3IuXG4gICAgICAgIC8vIFNpZGUgbm90ZSwgdGhpcyBhY3R1YWxseSBpbXBhY3RzIHRoZSByZXBvcnRlZCBzY3JvbGwgZGlzdGFuY2VcbiAgICAgICAgLy8gaW4gb2xkZXIgYnJvd3NlcnMgYW5kIGNhbiBjYXVzZSBzY3JvbGxpbmcgdG8gYmUgc2xvd2VyIHRoYW4gbmF0aXZlLlxuICAgICAgICAvLyBUdXJuIHRoaXMgb2ZmIGJ5IHNldHRpbmcgJC5ldmVudC5zcGVjaWFsLm1vdXNld2hlZWwuc2V0dGluZ3MuYWRqdXN0T2xkRGVsdGFzIHRvIGZhbHNlLlxuICAgICAgICByZXR1cm4gc3BlY2lhbC5zZXR0aW5ncy5hZGp1c3RPbGREZWx0YXMgJiYgb3JnRXZlbnQudHlwZSA9PT0gJ21vdXNld2hlZWwnICYmIGFic0RlbHRhICUgMTIwID09PSAwO1xuICAgIH1cblxufSkpO1xuIiwiKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSAoIGZ1bmN0aW9uKCAkICkge1xuXG4vLyBUaGlzIGZpbGUgaXMgZGVwcmVjYXRlZFxucmV0dXJuICQudWkuaWUgPSAhIS9tc2llIFtcXHcuXSsvLmV4ZWMoIG5hdmlnYXRvci51c2VyQWdlbnQudG9Mb3dlckNhc2UoKSApO1xufSApICk7XG4iLCIoIGZ1bmN0aW9uKCBmYWN0b3J5ICkge1xuXHRpZiAoIHR5cGVvZiBkZWZpbmUgPT09IFwiZnVuY3Rpb25cIiAmJiBkZWZpbmUuYW1kICkge1xuXG5cdFx0Ly8gQU1ELiBSZWdpc3RlciBhcyBhbiBhbm9ueW1vdXMgbW9kdWxlLlxuXHRcdGRlZmluZSggWyBcImpxdWVyeVwiIF0sIGZhY3RvcnkgKTtcblx0fSBlbHNlIHtcblxuXHRcdC8vIEJyb3dzZXIgZ2xvYmFsc1xuXHRcdGZhY3RvcnkoIGpRdWVyeSApO1xuXHR9XG59ICggZnVuY3Rpb24oICQgKSB7XG5cbiQudWkgPSAkLnVpIHx8IHt9O1xuXG5yZXR1cm4gJC51aS52ZXJzaW9uID0gXCIxLjEyLjFcIjtcblxufSApICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBXaWRnZXQgMS4xMi4xXG4gKiBodHRwOi8vanF1ZXJ5dWkuY29tXG4gKlxuICogQ29weXJpZ2h0IGpRdWVyeSBGb3VuZGF0aW9uIGFuZCBvdGhlciBjb250cmlidXRvcnNcbiAqIFJlbGVhc2VkIHVuZGVyIHRoZSBNSVQgbGljZW5zZS5cbiAqIGh0dHA6Ly9qcXVlcnkub3JnL2xpY2Vuc2VcbiAqL1xuXG4vLz4+bGFiZWw6IFdpZGdldFxuLy8+Pmdyb3VwOiBDb3JlXG4vLz4+ZGVzY3JpcHRpb246IFByb3ZpZGVzIGEgZmFjdG9yeSBmb3IgY3JlYXRpbmcgc3RhdGVmdWwgd2lkZ2V0cyB3aXRoIGEgY29tbW9uIEFQSS5cbi8vPj5kb2NzOiBodHRwOi8vYXBpLmpxdWVyeXVpLmNvbS9qUXVlcnkud2lkZ2V0L1xuLy8+PmRlbW9zOiBodHRwOi8vanF1ZXJ5dWkuY29tL3dpZGdldC9cblxuKCBmdW5jdGlvbiggZmFjdG9yeSApIHtcblx0aWYgKCB0eXBlb2YgZGVmaW5lID09PSBcImZ1bmN0aW9uXCIgJiYgZGVmaW5lLmFtZCApIHtcblxuXHRcdC8vIEFNRC4gUmVnaXN0ZXIgYXMgYW4gYW5vbnltb3VzIG1vZHVsZS5cblx0XHRkZWZpbmUoIFsgXCJqcXVlcnlcIiwgXCIuL3ZlcnNpb25cIiBdLCBmYWN0b3J5ICk7XG5cdH0gZWxzZSB7XG5cblx0XHQvLyBCcm93c2VyIGdsb2JhbHNcblx0XHRmYWN0b3J5KCBqUXVlcnkgKTtcblx0fVxufSggZnVuY3Rpb24oICQgKSB7XG5cbnZhciB3aWRnZXRVdWlkID0gMDtcbnZhciB3aWRnZXRTbGljZSA9IEFycmF5LnByb3RvdHlwZS5zbGljZTtcblxuJC5jbGVhbkRhdGEgPSAoIGZ1bmN0aW9uKCBvcmlnICkge1xuXHRyZXR1cm4gZnVuY3Rpb24oIGVsZW1zICkge1xuXHRcdHZhciBldmVudHMsIGVsZW0sIGk7XG5cdFx0Zm9yICggaSA9IDA7ICggZWxlbSA9IGVsZW1zWyBpIF0gKSAhPSBudWxsOyBpKysgKSB7XG5cdFx0XHR0cnkge1xuXG5cdFx0XHRcdC8vIE9ubHkgdHJpZ2dlciByZW1vdmUgd2hlbiBuZWNlc3NhcnkgdG8gc2F2ZSB0aW1lXG5cdFx0XHRcdGV2ZW50cyA9ICQuX2RhdGEoIGVsZW0sIFwiZXZlbnRzXCIgKTtcblx0XHRcdFx0aWYgKCBldmVudHMgJiYgZXZlbnRzLnJlbW92ZSApIHtcblx0XHRcdFx0XHQkKCBlbGVtICkudHJpZ2dlckhhbmRsZXIoIFwicmVtb3ZlXCIgKTtcblx0XHRcdFx0fVxuXG5cdFx0XHQvLyBIdHRwOi8vYnVncy5qcXVlcnkuY29tL3RpY2tldC84MjM1XG5cdFx0XHR9IGNhdGNoICggZSApIHt9XG5cdFx0fVxuXHRcdG9yaWcoIGVsZW1zICk7XG5cdH07XG59ICkoICQuY2xlYW5EYXRhICk7XG5cbiQud2lkZ2V0ID0gZnVuY3Rpb24oIG5hbWUsIGJhc2UsIHByb3RvdHlwZSApIHtcblx0dmFyIGV4aXN0aW5nQ29uc3RydWN0b3IsIGNvbnN0cnVjdG9yLCBiYXNlUHJvdG90eXBlO1xuXG5cdC8vIFByb3hpZWRQcm90b3R5cGUgYWxsb3dzIHRoZSBwcm92aWRlZCBwcm90b3R5cGUgdG8gcmVtYWluIHVubW9kaWZpZWRcblx0Ly8gc28gdGhhdCBpdCBjYW4gYmUgdXNlZCBhcyBhIG1peGluIGZvciBtdWx0aXBsZSB3aWRnZXRzICgjODg3Nilcblx0dmFyIHByb3hpZWRQcm90b3R5cGUgPSB7fTtcblxuXHR2YXIgbmFtZXNwYWNlID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMCBdO1xuXHRuYW1lID0gbmFtZS5zcGxpdCggXCIuXCIgKVsgMSBdO1xuXHR2YXIgZnVsbE5hbWUgPSBuYW1lc3BhY2UgKyBcIi1cIiArIG5hbWU7XG5cblx0aWYgKCAhcHJvdG90eXBlICkge1xuXHRcdHByb3RvdHlwZSA9IGJhc2U7XG5cdFx0YmFzZSA9ICQuV2lkZ2V0O1xuXHR9XG5cblx0aWYgKCAkLmlzQXJyYXkoIHByb3RvdHlwZSApICkge1xuXHRcdHByb3RvdHlwZSA9ICQuZXh0ZW5kLmFwcGx5KCBudWxsLCBbIHt9IF0uY29uY2F0KCBwcm90b3R5cGUgKSApO1xuXHR9XG5cblx0Ly8gQ3JlYXRlIHNlbGVjdG9yIGZvciBwbHVnaW5cblx0JC5leHByWyBcIjpcIiBdWyBmdWxsTmFtZS50b0xvd2VyQ2FzZSgpIF0gPSBmdW5jdGlvbiggZWxlbSApIHtcblx0XHRyZXR1cm4gISEkLmRhdGEoIGVsZW0sIGZ1bGxOYW1lICk7XG5cdH07XG5cblx0JFsgbmFtZXNwYWNlIF0gPSAkWyBuYW1lc3BhY2UgXSB8fCB7fTtcblx0ZXhpc3RpbmdDb25zdHJ1Y3RvciA9ICRbIG5hbWVzcGFjZSBdWyBuYW1lIF07XG5cdGNvbnN0cnVjdG9yID0gJFsgbmFtZXNwYWNlIF1bIG5hbWUgXSA9IGZ1bmN0aW9uKCBvcHRpb25zLCBlbGVtZW50ICkge1xuXG5cdFx0Ly8gQWxsb3cgaW5zdGFudGlhdGlvbiB3aXRob3V0IFwibmV3XCIga2V5d29yZFxuXHRcdGlmICggIXRoaXMuX2NyZWF0ZVdpZGdldCApIHtcblx0XHRcdHJldHVybiBuZXcgY29uc3RydWN0b3IoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cblx0XHQvLyBBbGxvdyBpbnN0YW50aWF0aW9uIHdpdGhvdXQgaW5pdGlhbGl6aW5nIGZvciBzaW1wbGUgaW5oZXJpdGFuY2Vcblx0XHQvLyBtdXN0IHVzZSBcIm5ld1wiIGtleXdvcmQgKHRoZSBjb2RlIGFib3ZlIGFsd2F5cyBwYXNzZXMgYXJncylcblx0XHRpZiAoIGFyZ3VtZW50cy5sZW5ndGggKSB7XG5cdFx0XHR0aGlzLl9jcmVhdGVXaWRnZXQoIG9wdGlvbnMsIGVsZW1lbnQgKTtcblx0XHR9XG5cdH07XG5cblx0Ly8gRXh0ZW5kIHdpdGggdGhlIGV4aXN0aW5nIGNvbnN0cnVjdG9yIHRvIGNhcnJ5IG92ZXIgYW55IHN0YXRpYyBwcm9wZXJ0aWVzXG5cdCQuZXh0ZW5kKCBjb25zdHJ1Y3RvciwgZXhpc3RpbmdDb25zdHJ1Y3Rvciwge1xuXHRcdHZlcnNpb246IHByb3RvdHlwZS52ZXJzaW9uLFxuXG5cdFx0Ly8gQ29weSB0aGUgb2JqZWN0IHVzZWQgdG8gY3JlYXRlIHRoZSBwcm90b3R5cGUgaW4gY2FzZSB3ZSBuZWVkIHRvXG5cdFx0Ly8gcmVkZWZpbmUgdGhlIHdpZGdldCBsYXRlclxuXHRcdF9wcm90bzogJC5leHRlbmQoIHt9LCBwcm90b3R5cGUgKSxcblxuXHRcdC8vIFRyYWNrIHdpZGdldHMgdGhhdCBpbmhlcml0IGZyb20gdGhpcyB3aWRnZXQgaW4gY2FzZSB0aGlzIHdpZGdldCBpc1xuXHRcdC8vIHJlZGVmaW5lZCBhZnRlciBhIHdpZGdldCBpbmhlcml0cyBmcm9tIGl0XG5cdFx0X2NoaWxkQ29uc3RydWN0b3JzOiBbXVxuXHR9ICk7XG5cblx0YmFzZVByb3RvdHlwZSA9IG5ldyBiYXNlKCk7XG5cblx0Ly8gV2UgbmVlZCB0byBtYWtlIHRoZSBvcHRpb25zIGhhc2ggYSBwcm9wZXJ0eSBkaXJlY3RseSBvbiB0aGUgbmV3IGluc3RhbmNlXG5cdC8vIG90aGVyd2lzZSB3ZSdsbCBtb2RpZnkgdGhlIG9wdGlvbnMgaGFzaCBvbiB0aGUgcHJvdG90eXBlIHRoYXQgd2UncmVcblx0Ly8gaW5oZXJpdGluZyBmcm9tXG5cdGJhc2VQcm90b3R5cGUub3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZCgge30sIGJhc2VQcm90b3R5cGUub3B0aW9ucyApO1xuXHQkLmVhY2goIHByb3RvdHlwZSwgZnVuY3Rpb24oIHByb3AsIHZhbHVlICkge1xuXHRcdGlmICggISQuaXNGdW5jdGlvbiggdmFsdWUgKSApIHtcblx0XHRcdHByb3hpZWRQcm90b3R5cGVbIHByb3AgXSA9IHZhbHVlO1xuXHRcdFx0cmV0dXJuO1xuXHRcdH1cblx0XHRwcm94aWVkUHJvdG90eXBlWyBwcm9wIF0gPSAoIGZ1bmN0aW9uKCkge1xuXHRcdFx0ZnVuY3Rpb24gX3N1cGVyKCkge1xuXHRcdFx0XHRyZXR1cm4gYmFzZS5wcm90b3R5cGVbIHByb3AgXS5hcHBseSggdGhpcywgYXJndW1lbnRzICk7XG5cdFx0XHR9XG5cblx0XHRcdGZ1bmN0aW9uIF9zdXBlckFwcGx5KCBhcmdzICkge1xuXHRcdFx0XHRyZXR1cm4gYmFzZS5wcm90b3R5cGVbIHByb3AgXS5hcHBseSggdGhpcywgYXJncyApO1xuXHRcdFx0fVxuXG5cdFx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHRcdHZhciBfX3N1cGVyID0gdGhpcy5fc3VwZXI7XG5cdFx0XHRcdHZhciBfX3N1cGVyQXBwbHkgPSB0aGlzLl9zdXBlckFwcGx5O1xuXHRcdFx0XHR2YXIgcmV0dXJuVmFsdWU7XG5cblx0XHRcdFx0dGhpcy5fc3VwZXIgPSBfc3VwZXI7XG5cdFx0XHRcdHRoaXMuX3N1cGVyQXBwbHkgPSBfc3VwZXJBcHBseTtcblxuXHRcdFx0XHRyZXR1cm5WYWx1ZSA9IHZhbHVlLmFwcGx5KCB0aGlzLCBhcmd1bWVudHMgKTtcblxuXHRcdFx0XHR0aGlzLl9zdXBlciA9IF9fc3VwZXI7XG5cdFx0XHRcdHRoaXMuX3N1cGVyQXBwbHkgPSBfX3N1cGVyQXBwbHk7XG5cblx0XHRcdFx0cmV0dXJuIHJldHVyblZhbHVlO1xuXHRcdFx0fTtcblx0XHR9ICkoKTtcblx0fSApO1xuXHRjb25zdHJ1Y3Rvci5wcm90b3R5cGUgPSAkLndpZGdldC5leHRlbmQoIGJhc2VQcm90b3R5cGUsIHtcblxuXHRcdC8vIFRPRE86IHJlbW92ZSBzdXBwb3J0IGZvciB3aWRnZXRFdmVudFByZWZpeFxuXHRcdC8vIGFsd2F5cyB1c2UgdGhlIG5hbWUgKyBhIGNvbG9uIGFzIHRoZSBwcmVmaXgsIGUuZy4sIGRyYWdnYWJsZTpzdGFydFxuXHRcdC8vIGRvbid0IHByZWZpeCBmb3Igd2lkZ2V0cyB0aGF0IGFyZW4ndCBET00tYmFzZWRcblx0XHR3aWRnZXRFdmVudFByZWZpeDogZXhpc3RpbmdDb25zdHJ1Y3RvciA/ICggYmFzZVByb3RvdHlwZS53aWRnZXRFdmVudFByZWZpeCB8fCBuYW1lICkgOiBuYW1lXG5cdH0sIHByb3hpZWRQcm90b3R5cGUsIHtcblx0XHRjb25zdHJ1Y3RvcjogY29uc3RydWN0b3IsXG5cdFx0bmFtZXNwYWNlOiBuYW1lc3BhY2UsXG5cdFx0d2lkZ2V0TmFtZTogbmFtZSxcblx0XHR3aWRnZXRGdWxsTmFtZTogZnVsbE5hbWVcblx0fSApO1xuXG5cdC8vIElmIHRoaXMgd2lkZ2V0IGlzIGJlaW5nIHJlZGVmaW5lZCB0aGVuIHdlIG5lZWQgdG8gZmluZCBhbGwgd2lkZ2V0cyB0aGF0XG5cdC8vIGFyZSBpbmhlcml0aW5nIGZyb20gaXQgYW5kIHJlZGVmaW5lIGFsbCBvZiB0aGVtIHNvIHRoYXQgdGhleSBpbmhlcml0IGZyb21cblx0Ly8gdGhlIG5ldyB2ZXJzaW9uIG9mIHRoaXMgd2lkZ2V0LiBXZSdyZSBlc3NlbnRpYWxseSB0cnlpbmcgdG8gcmVwbGFjZSBvbmVcblx0Ly8gbGV2ZWwgaW4gdGhlIHByb3RvdHlwZSBjaGFpbi5cblx0aWYgKCBleGlzdGluZ0NvbnN0cnVjdG9yICkge1xuXHRcdCQuZWFjaCggZXhpc3RpbmdDb25zdHJ1Y3Rvci5fY2hpbGRDb25zdHJ1Y3RvcnMsIGZ1bmN0aW9uKCBpLCBjaGlsZCApIHtcblx0XHRcdHZhciBjaGlsZFByb3RvdHlwZSA9IGNoaWxkLnByb3RvdHlwZTtcblxuXHRcdFx0Ly8gUmVkZWZpbmUgdGhlIGNoaWxkIHdpZGdldCB1c2luZyB0aGUgc2FtZSBwcm90b3R5cGUgdGhhdCB3YXNcblx0XHRcdC8vIG9yaWdpbmFsbHkgdXNlZCwgYnV0IGluaGVyaXQgZnJvbSB0aGUgbmV3IHZlcnNpb24gb2YgdGhlIGJhc2Vcblx0XHRcdCQud2lkZ2V0KCBjaGlsZFByb3RvdHlwZS5uYW1lc3BhY2UgKyBcIi5cIiArIGNoaWxkUHJvdG90eXBlLndpZGdldE5hbWUsIGNvbnN0cnVjdG9yLFxuXHRcdFx0XHRjaGlsZC5fcHJvdG8gKTtcblx0XHR9ICk7XG5cblx0XHQvLyBSZW1vdmUgdGhlIGxpc3Qgb2YgZXhpc3RpbmcgY2hpbGQgY29uc3RydWN0b3JzIGZyb20gdGhlIG9sZCBjb25zdHJ1Y3RvclxuXHRcdC8vIHNvIHRoZSBvbGQgY2hpbGQgY29uc3RydWN0b3JzIGNhbiBiZSBnYXJiYWdlIGNvbGxlY3RlZFxuXHRcdGRlbGV0ZSBleGlzdGluZ0NvbnN0cnVjdG9yLl9jaGlsZENvbnN0cnVjdG9ycztcblx0fSBlbHNlIHtcblx0XHRiYXNlLl9jaGlsZENvbnN0cnVjdG9ycy5wdXNoKCBjb25zdHJ1Y3RvciApO1xuXHR9XG5cblx0JC53aWRnZXQuYnJpZGdlKCBuYW1lLCBjb25zdHJ1Y3RvciApO1xuXG5cdHJldHVybiBjb25zdHJ1Y3Rvcjtcbn07XG5cbiQud2lkZ2V0LmV4dGVuZCA9IGZ1bmN0aW9uKCB0YXJnZXQgKSB7XG5cdHZhciBpbnB1dCA9IHdpZGdldFNsaWNlLmNhbGwoIGFyZ3VtZW50cywgMSApO1xuXHR2YXIgaW5wdXRJbmRleCA9IDA7XG5cdHZhciBpbnB1dExlbmd0aCA9IGlucHV0Lmxlbmd0aDtcblx0dmFyIGtleTtcblx0dmFyIHZhbHVlO1xuXG5cdGZvciAoIDsgaW5wdXRJbmRleCA8IGlucHV0TGVuZ3RoOyBpbnB1dEluZGV4KysgKSB7XG5cdFx0Zm9yICgga2V5IGluIGlucHV0WyBpbnB1dEluZGV4IF0gKSB7XG5cdFx0XHR2YWx1ZSA9IGlucHV0WyBpbnB1dEluZGV4IF1bIGtleSBdO1xuXHRcdFx0aWYgKCBpbnB1dFsgaW5wdXRJbmRleCBdLmhhc093blByb3BlcnR5KCBrZXkgKSAmJiB2YWx1ZSAhPT0gdW5kZWZpbmVkICkge1xuXG5cdFx0XHRcdC8vIENsb25lIG9iamVjdHNcblx0XHRcdFx0aWYgKCAkLmlzUGxhaW5PYmplY3QoIHZhbHVlICkgKSB7XG5cdFx0XHRcdFx0dGFyZ2V0WyBrZXkgXSA9ICQuaXNQbGFpbk9iamVjdCggdGFyZ2V0WyBrZXkgXSApID9cblx0XHRcdFx0XHRcdCQud2lkZ2V0LmV4dGVuZCgge30sIHRhcmdldFsga2V5IF0sIHZhbHVlICkgOlxuXG5cdFx0XHRcdFx0XHQvLyBEb24ndCBleHRlbmQgc3RyaW5ncywgYXJyYXlzLCBldGMuIHdpdGggb2JqZWN0c1xuXHRcdFx0XHRcdFx0JC53aWRnZXQuZXh0ZW5kKCB7fSwgdmFsdWUgKTtcblxuXHRcdFx0XHQvLyBDb3B5IGV2ZXJ5dGhpbmcgZWxzZSBieSByZWZlcmVuY2Vcblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHR0YXJnZXRbIGtleSBdID0gdmFsdWU7XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cdH1cblx0cmV0dXJuIHRhcmdldDtcbn07XG5cbiQud2lkZ2V0LmJyaWRnZSA9IGZ1bmN0aW9uKCBuYW1lLCBvYmplY3QgKSB7XG5cdHZhciBmdWxsTmFtZSA9IG9iamVjdC5wcm90b3R5cGUud2lkZ2V0RnVsbE5hbWUgfHwgbmFtZTtcblx0JC5mblsgbmFtZSBdID0gZnVuY3Rpb24oIG9wdGlvbnMgKSB7XG5cdFx0dmFyIGlzTWV0aG9kQ2FsbCA9IHR5cGVvZiBvcHRpb25zID09PSBcInN0cmluZ1wiO1xuXHRcdHZhciBhcmdzID0gd2lkZ2V0U2xpY2UuY2FsbCggYXJndW1lbnRzLCAxICk7XG5cdFx0dmFyIHJldHVyblZhbHVlID0gdGhpcztcblxuXHRcdGlmICggaXNNZXRob2RDYWxsICkge1xuXG5cdFx0XHQvLyBJZiB0aGlzIGlzIGFuIGVtcHR5IGNvbGxlY3Rpb24sIHdlIG5lZWQgdG8gaGF2ZSB0aGUgaW5zdGFuY2UgbWV0aG9kXG5cdFx0XHQvLyByZXR1cm4gdW5kZWZpbmVkIGluc3RlYWQgb2YgdGhlIGpRdWVyeSBpbnN0YW5jZVxuXHRcdFx0aWYgKCAhdGhpcy5sZW5ndGggJiYgb3B0aW9ucyA9PT0gXCJpbnN0YW5jZVwiICkge1xuXHRcdFx0XHRyZXR1cm5WYWx1ZSA9IHVuZGVmaW5lZDtcblx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdHRoaXMuZWFjaCggZnVuY3Rpb24oKSB7XG5cdFx0XHRcdFx0dmFyIG1ldGhvZFZhbHVlO1xuXHRcdFx0XHRcdHZhciBpbnN0YW5jZSA9ICQuZGF0YSggdGhpcywgZnVsbE5hbWUgKTtcblxuXHRcdFx0XHRcdGlmICggb3B0aW9ucyA9PT0gXCJpbnN0YW5jZVwiICkge1xuXHRcdFx0XHRcdFx0cmV0dXJuVmFsdWUgPSBpbnN0YW5jZTtcblx0XHRcdFx0XHRcdHJldHVybiBmYWxzZTtcblx0XHRcdFx0XHR9XG5cblx0XHRcdFx0XHRpZiAoICFpbnN0YW5jZSApIHtcblx0XHRcdFx0XHRcdHJldHVybiAkLmVycm9yKCBcImNhbm5vdCBjYWxsIG1ldGhvZHMgb24gXCIgKyBuYW1lICtcblx0XHRcdFx0XHRcdFx0XCIgcHJpb3IgdG8gaW5pdGlhbGl6YXRpb247IFwiICtcblx0XHRcdFx0XHRcdFx0XCJhdHRlbXB0ZWQgdG8gY2FsbCBtZXRob2QgJ1wiICsgb3B0aW9ucyArIFwiJ1wiICk7XG5cdFx0XHRcdFx0fVxuXG5cdFx0XHRcdFx0aWYgKCAhJC5pc0Z1bmN0aW9uKCBpbnN0YW5jZVsgb3B0aW9ucyBdICkgfHwgb3B0aW9ucy5jaGFyQXQoIDAgKSA9PT0gXCJfXCIgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm4gJC5lcnJvciggXCJubyBzdWNoIG1ldGhvZCAnXCIgKyBvcHRpb25zICsgXCInIGZvciBcIiArIG5hbWUgK1xuXHRcdFx0XHRcdFx0XHRcIiB3aWRnZXQgaW5zdGFuY2VcIiApO1xuXHRcdFx0XHRcdH1cblxuXHRcdFx0XHRcdG1ldGhvZFZhbHVlID0gaW5zdGFuY2VbIG9wdGlvbnMgXS5hcHBseSggaW5zdGFuY2UsIGFyZ3MgKTtcblxuXHRcdFx0XHRcdGlmICggbWV0aG9kVmFsdWUgIT09IGluc3RhbmNlICYmIG1ldGhvZFZhbHVlICE9PSB1bmRlZmluZWQgKSB7XG5cdFx0XHRcdFx0XHRyZXR1cm5WYWx1ZSA9IG1ldGhvZFZhbHVlICYmIG1ldGhvZFZhbHVlLmpxdWVyeSA/XG5cdFx0XHRcdFx0XHRcdHJldHVyblZhbHVlLnB1c2hTdGFjayggbWV0aG9kVmFsdWUuZ2V0KCkgKSA6XG5cdFx0XHRcdFx0XHRcdG1ldGhvZFZhbHVlO1xuXHRcdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSApO1xuXHRcdFx0fVxuXHRcdH0gZWxzZSB7XG5cblx0XHRcdC8vIEFsbG93IG11bHRpcGxlIGhhc2hlcyB0byBiZSBwYXNzZWQgb24gaW5pdFxuXHRcdFx0aWYgKCBhcmdzLmxlbmd0aCApIHtcblx0XHRcdFx0b3B0aW9ucyA9ICQud2lkZ2V0LmV4dGVuZC5hcHBseSggbnVsbCwgWyBvcHRpb25zIF0uY29uY2F0KCBhcmdzICkgKTtcblx0XHRcdH1cblxuXHRcdFx0dGhpcy5lYWNoKCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dmFyIGluc3RhbmNlID0gJC5kYXRhKCB0aGlzLCBmdWxsTmFtZSApO1xuXHRcdFx0XHRpZiAoIGluc3RhbmNlICkge1xuXHRcdFx0XHRcdGluc3RhbmNlLm9wdGlvbiggb3B0aW9ucyB8fCB7fSApO1xuXHRcdFx0XHRcdGlmICggaW5zdGFuY2UuX2luaXQgKSB7XG5cdFx0XHRcdFx0XHRpbnN0YW5jZS5faW5pdCgpO1xuXHRcdFx0XHRcdH1cblx0XHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0XHQkLmRhdGEoIHRoaXMsIGZ1bGxOYW1lLCBuZXcgb2JqZWN0KCBvcHRpb25zLCB0aGlzICkgKTtcblx0XHRcdFx0fVxuXHRcdFx0fSApO1xuXHRcdH1cblxuXHRcdHJldHVybiByZXR1cm5WYWx1ZTtcblx0fTtcbn07XG5cbiQuV2lkZ2V0ID0gZnVuY3Rpb24oIC8qIG9wdGlvbnMsIGVsZW1lbnQgKi8gKSB7fTtcbiQuV2lkZ2V0Ll9jaGlsZENvbnN0cnVjdG9ycyA9IFtdO1xuXG4kLldpZGdldC5wcm90b3R5cGUgPSB7XG5cdHdpZGdldE5hbWU6IFwid2lkZ2V0XCIsXG5cdHdpZGdldEV2ZW50UHJlZml4OiBcIlwiLFxuXHRkZWZhdWx0RWxlbWVudDogXCI8ZGl2PlwiLFxuXG5cdG9wdGlvbnM6IHtcblx0XHRjbGFzc2VzOiB7fSxcblx0XHRkaXNhYmxlZDogZmFsc2UsXG5cblx0XHQvLyBDYWxsYmFja3Ncblx0XHRjcmVhdGU6IG51bGxcblx0fSxcblxuXHRfY3JlYXRlV2lkZ2V0OiBmdW5jdGlvbiggb3B0aW9ucywgZWxlbWVudCApIHtcblx0XHRlbGVtZW50ID0gJCggZWxlbWVudCB8fCB0aGlzLmRlZmF1bHRFbGVtZW50IHx8IHRoaXMgKVsgMCBdO1xuXHRcdHRoaXMuZWxlbWVudCA9ICQoIGVsZW1lbnQgKTtcblx0XHR0aGlzLnV1aWQgPSB3aWRnZXRVdWlkKys7XG5cdFx0dGhpcy5ldmVudE5hbWVzcGFjZSA9IFwiLlwiICsgdGhpcy53aWRnZXROYW1lICsgdGhpcy51dWlkO1xuXG5cdFx0dGhpcy5iaW5kaW5ncyA9ICQoKTtcblx0XHR0aGlzLmhvdmVyYWJsZSA9ICQoKTtcblx0XHR0aGlzLmZvY3VzYWJsZSA9ICQoKTtcblx0XHR0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwID0ge307XG5cblx0XHRpZiAoIGVsZW1lbnQgIT09IHRoaXMgKSB7XG5cdFx0XHQkLmRhdGEoIGVsZW1lbnQsIHRoaXMud2lkZ2V0RnVsbE5hbWUsIHRoaXMgKTtcblx0XHRcdHRoaXMuX29uKCB0cnVlLCB0aGlzLmVsZW1lbnQsIHtcblx0XHRcdFx0cmVtb3ZlOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdFx0aWYgKCBldmVudC50YXJnZXQgPT09IGVsZW1lbnQgKSB7XG5cdFx0XHRcdFx0XHR0aGlzLmRlc3Ryb3koKTtcblx0XHRcdFx0XHR9XG5cdFx0XHRcdH1cblx0XHRcdH0gKTtcblx0XHRcdHRoaXMuZG9jdW1lbnQgPSAkKCBlbGVtZW50LnN0eWxlID9cblxuXHRcdFx0XHQvLyBFbGVtZW50IHdpdGhpbiB0aGUgZG9jdW1lbnRcblx0XHRcdFx0ZWxlbWVudC5vd25lckRvY3VtZW50IDpcblxuXHRcdFx0XHQvLyBFbGVtZW50IGlzIHdpbmRvdyBvciBkb2N1bWVudFxuXHRcdFx0XHRlbGVtZW50LmRvY3VtZW50IHx8IGVsZW1lbnQgKTtcblx0XHRcdHRoaXMud2luZG93ID0gJCggdGhpcy5kb2N1bWVudFsgMCBdLmRlZmF1bHRWaWV3IHx8IHRoaXMuZG9jdW1lbnRbIDAgXS5wYXJlbnRXaW5kb3cgKTtcblx0XHR9XG5cblx0XHR0aGlzLm9wdGlvbnMgPSAkLndpZGdldC5leHRlbmQoIHt9LFxuXHRcdFx0dGhpcy5vcHRpb25zLFxuXHRcdFx0dGhpcy5fZ2V0Q3JlYXRlT3B0aW9ucygpLFxuXHRcdFx0b3B0aW9ucyApO1xuXG5cdFx0dGhpcy5fY3JlYXRlKCk7XG5cblx0XHRpZiAoIHRoaXMub3B0aW9ucy5kaXNhYmxlZCApIHtcblx0XHRcdHRoaXMuX3NldE9wdGlvbkRpc2FibGVkKCB0aGlzLm9wdGlvbnMuZGlzYWJsZWQgKTtcblx0XHR9XG5cblx0XHR0aGlzLl90cmlnZ2VyKCBcImNyZWF0ZVwiLCBudWxsLCB0aGlzLl9nZXRDcmVhdGVFdmVudERhdGEoKSApO1xuXHRcdHRoaXMuX2luaXQoKTtcblx0fSxcblxuXHRfZ2V0Q3JlYXRlT3B0aW9uczogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHt9O1xuXHR9LFxuXG5cdF9nZXRDcmVhdGVFdmVudERhdGE6ICQubm9vcCxcblxuXHRfY3JlYXRlOiAkLm5vb3AsXG5cblx0X2luaXQ6ICQubm9vcCxcblxuXHRkZXN0cm95OiBmdW5jdGlvbigpIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cblx0XHR0aGlzLl9kZXN0cm95KCk7XG5cdFx0JC5lYWNoKCB0aGlzLmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdHRoYXQuX3JlbW92ZUNsYXNzKCB2YWx1ZSwga2V5ICk7XG5cdFx0fSApO1xuXG5cdFx0Ly8gV2UgY2FuIHByb2JhYmx5IHJlbW92ZSB0aGUgdW5iaW5kIGNhbGxzIGluIDIuMFxuXHRcdC8vIGFsbCBldmVudCBiaW5kaW5ncyBzaG91bGQgZ28gdGhyb3VnaCB0aGlzLl9vbigpXG5cdFx0dGhpcy5lbGVtZW50XG5cdFx0XHQub2ZmKCB0aGlzLmV2ZW50TmFtZXNwYWNlIClcblx0XHRcdC5yZW1vdmVEYXRhKCB0aGlzLndpZGdldEZ1bGxOYW1lICk7XG5cdFx0dGhpcy53aWRnZXQoKVxuXHRcdFx0Lm9mZiggdGhpcy5ldmVudE5hbWVzcGFjZSApXG5cdFx0XHQucmVtb3ZlQXR0ciggXCJhcmlhLWRpc2FibGVkXCIgKTtcblxuXHRcdC8vIENsZWFuIHVwIGV2ZW50cyBhbmQgc3RhdGVzXG5cdFx0dGhpcy5iaW5kaW5ncy5vZmYoIHRoaXMuZXZlbnROYW1lc3BhY2UgKTtcblx0fSxcblxuXHRfZGVzdHJveTogJC5ub29wLFxuXG5cdHdpZGdldDogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuZWxlbWVudDtcblx0fSxcblxuXHRvcHRpb246IGZ1bmN0aW9uKCBrZXksIHZhbHVlICkge1xuXHRcdHZhciBvcHRpb25zID0ga2V5O1xuXHRcdHZhciBwYXJ0cztcblx0XHR2YXIgY3VyT3B0aW9uO1xuXHRcdHZhciBpO1xuXG5cdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAwICkge1xuXG5cdFx0XHQvLyBEb24ndCByZXR1cm4gYSByZWZlcmVuY2UgdG8gdGhlIGludGVybmFsIGhhc2hcblx0XHRcdHJldHVybiAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnMgKTtcblx0XHR9XG5cblx0XHRpZiAoIHR5cGVvZiBrZXkgPT09IFwic3RyaW5nXCIgKSB7XG5cblx0XHRcdC8vIEhhbmRsZSBuZXN0ZWQga2V5cywgZS5nLiwgXCJmb28uYmFyXCIgPT4geyBmb286IHsgYmFyOiBfX18gfSB9XG5cdFx0XHRvcHRpb25zID0ge307XG5cdFx0XHRwYXJ0cyA9IGtleS5zcGxpdCggXCIuXCIgKTtcblx0XHRcdGtleSA9IHBhcnRzLnNoaWZ0KCk7XG5cdFx0XHRpZiAoIHBhcnRzLmxlbmd0aCApIHtcblx0XHRcdFx0Y3VyT3B0aW9uID0gb3B0aW9uc1sga2V5IF0gPSAkLndpZGdldC5leHRlbmQoIHt9LCB0aGlzLm9wdGlvbnNbIGtleSBdICk7XG5cdFx0XHRcdGZvciAoIGkgPSAwOyBpIDwgcGFydHMubGVuZ3RoIC0gMTsgaSsrICkge1xuXHRcdFx0XHRcdGN1ck9wdGlvblsgcGFydHNbIGkgXSBdID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF0gfHwge307XG5cdFx0XHRcdFx0Y3VyT3B0aW9uID0gY3VyT3B0aW9uWyBwYXJ0c1sgaSBdIF07XG5cdFx0XHRcdH1cblx0XHRcdFx0a2V5ID0gcGFydHMucG9wKCk7XG5cdFx0XHRcdGlmICggYXJndW1lbnRzLmxlbmd0aCA9PT0gMSApIHtcblx0XHRcdFx0XHRyZXR1cm4gY3VyT3B0aW9uWyBrZXkgXSA9PT0gdW5kZWZpbmVkID8gbnVsbCA6IGN1ck9wdGlvblsga2V5IF07XG5cdFx0XHRcdH1cblx0XHRcdFx0Y3VyT3B0aW9uWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0aWYgKCBhcmd1bWVudHMubGVuZ3RoID09PSAxICkge1xuXHRcdFx0XHRcdHJldHVybiB0aGlzLm9wdGlvbnNbIGtleSBdID09PSB1bmRlZmluZWQgPyBudWxsIDogdGhpcy5vcHRpb25zWyBrZXkgXTtcblx0XHRcdFx0fVxuXHRcdFx0XHRvcHRpb25zWyBrZXkgXSA9IHZhbHVlO1xuXHRcdFx0fVxuXHRcdH1cblxuXHRcdHRoaXMuX3NldE9wdGlvbnMoIG9wdGlvbnMgKTtcblxuXHRcdHJldHVybiB0aGlzO1xuXHR9LFxuXG5cdF9zZXRPcHRpb25zOiBmdW5jdGlvbiggb3B0aW9ucyApIHtcblx0XHR2YXIga2V5O1xuXG5cdFx0Zm9yICgga2V5IGluIG9wdGlvbnMgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb24oIGtleSwgb3B0aW9uc1sga2V5IF0gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uOiBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRpZiAoIGtleSA9PT0gXCJjbGFzc2VzXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25DbGFzc2VzKCB2YWx1ZSApO1xuXHRcdH1cblxuXHRcdHRoaXMub3B0aW9uc1sga2V5IF0gPSB2YWx1ZTtcblxuXHRcdGlmICgga2V5ID09PSBcImRpc2FibGVkXCIgKSB7XG5cdFx0XHR0aGlzLl9zZXRPcHRpb25EaXNhYmxlZCggdmFsdWUgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gdGhpcztcblx0fSxcblxuXHRfc2V0T3B0aW9uQ2xhc3NlczogZnVuY3Rpb24oIHZhbHVlICkge1xuXHRcdHZhciBjbGFzc0tleSwgZWxlbWVudHMsIGN1cnJlbnRFbGVtZW50cztcblxuXHRcdGZvciAoIGNsYXNzS2V5IGluIHZhbHVlICkge1xuXHRcdFx0Y3VycmVudEVsZW1lbnRzID0gdGhpcy5jbGFzc2VzRWxlbWVudExvb2t1cFsgY2xhc3NLZXkgXTtcblx0XHRcdGlmICggdmFsdWVbIGNsYXNzS2V5IF0gPT09IHRoaXMub3B0aW9ucy5jbGFzc2VzWyBjbGFzc0tleSBdIHx8XG5cdFx0XHRcdFx0IWN1cnJlbnRFbGVtZW50cyB8fFxuXHRcdFx0XHRcdCFjdXJyZW50RWxlbWVudHMubGVuZ3RoICkge1xuXHRcdFx0XHRjb250aW51ZTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gV2UgYXJlIGRvaW5nIHRoaXMgdG8gY3JlYXRlIGEgbmV3IGpRdWVyeSBvYmplY3QgYmVjYXVzZSB0aGUgX3JlbW92ZUNsYXNzKCkgY2FsbFxuXHRcdFx0Ly8gb24gdGhlIG5leHQgbGluZSBpcyBnb2luZyB0byBkZXN0cm95IHRoZSByZWZlcmVuY2UgdG8gdGhlIGN1cnJlbnQgZWxlbWVudHMgYmVpbmdcblx0XHRcdC8vIHRyYWNrZWQuIFdlIG5lZWQgdG8gc2F2ZSBhIGNvcHkgb2YgdGhpcyBjb2xsZWN0aW9uIHNvIHRoYXQgd2UgY2FuIGFkZCB0aGUgbmV3IGNsYXNzZXNcblx0XHRcdC8vIGJlbG93LlxuXHRcdFx0ZWxlbWVudHMgPSAkKCBjdXJyZW50RWxlbWVudHMuZ2V0KCkgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCBjdXJyZW50RWxlbWVudHMsIGNsYXNzS2V5ICk7XG5cblx0XHRcdC8vIFdlIGRvbid0IHVzZSBfYWRkQ2xhc3MoKSBoZXJlLCBiZWNhdXNlIHRoYXQgdXNlcyB0aGlzLm9wdGlvbnMuY2xhc3Nlc1xuXHRcdFx0Ly8gZm9yIGdlbmVyYXRpbmcgdGhlIHN0cmluZyBvZiBjbGFzc2VzLiBXZSB3YW50IHRvIHVzZSB0aGUgdmFsdWUgcGFzc2VkIGluIGZyb21cblx0XHRcdC8vIF9zZXRPcHRpb24oKSwgdGhpcyBpcyB0aGUgbmV3IHZhbHVlIG9mIHRoZSBjbGFzc2VzIG9wdGlvbiB3aGljaCB3YXMgcGFzc2VkIHRvXG5cdFx0XHQvLyBfc2V0T3B0aW9uKCkuIFdlIHBhc3MgdGhpcyB2YWx1ZSBkaXJlY3RseSB0byBfY2xhc3NlcygpLlxuXHRcdFx0ZWxlbWVudHMuYWRkQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIHtcblx0XHRcdFx0ZWxlbWVudDogZWxlbWVudHMsXG5cdFx0XHRcdGtleXM6IGNsYXNzS2V5LFxuXHRcdFx0XHRjbGFzc2VzOiB2YWx1ZSxcblx0XHRcdFx0YWRkOiB0cnVlXG5cdFx0XHR9ICkgKTtcblx0XHR9XG5cdH0sXG5cblx0X3NldE9wdGlvbkRpc2FibGVkOiBmdW5jdGlvbiggdmFsdWUgKSB7XG5cdFx0dGhpcy5fdG9nZ2xlQ2xhc3MoIHRoaXMud2lkZ2V0KCksIHRoaXMud2lkZ2V0RnVsbE5hbWUgKyBcIi1kaXNhYmxlZFwiLCBudWxsLCAhIXZhbHVlICk7XG5cblx0XHQvLyBJZiB0aGUgd2lkZ2V0IGlzIGJlY29taW5nIGRpc2FibGVkLCB0aGVuIG5vdGhpbmcgaXMgaW50ZXJhY3RpdmVcblx0XHRpZiAoIHZhbHVlICkge1xuXHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoIHRoaXMuaG92ZXJhYmxlLCBudWxsLCBcInVpLXN0YXRlLWhvdmVyXCIgKTtcblx0XHRcdHRoaXMuX3JlbW92ZUNsYXNzKCB0aGlzLmZvY3VzYWJsZSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0fVxuXHR9LFxuXG5cdGVuYWJsZTogZnVuY3Rpb24oKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3NldE9wdGlvbnMoIHsgZGlzYWJsZWQ6IGZhbHNlIH0gKTtcblx0fSxcblxuXHRkaXNhYmxlOiBmdW5jdGlvbigpIHtcblx0XHRyZXR1cm4gdGhpcy5fc2V0T3B0aW9ucyggeyBkaXNhYmxlZDogdHJ1ZSB9ICk7XG5cdH0sXG5cblx0X2NsYXNzZXM6IGZ1bmN0aW9uKCBvcHRpb25zICkge1xuXHRcdHZhciBmdWxsID0gW107XG5cdFx0dmFyIHRoYXQgPSB0aGlzO1xuXG5cdFx0b3B0aW9ucyA9ICQuZXh0ZW5kKCB7XG5cdFx0XHRlbGVtZW50OiB0aGlzLmVsZW1lbnQsXG5cdFx0XHRjbGFzc2VzOiB0aGlzLm9wdGlvbnMuY2xhc3NlcyB8fCB7fVxuXHRcdH0sIG9wdGlvbnMgKTtcblxuXHRcdGZ1bmN0aW9uIHByb2Nlc3NDbGFzc1N0cmluZyggY2xhc3NlcywgY2hlY2tPcHRpb24gKSB7XG5cdFx0XHR2YXIgY3VycmVudCwgaTtcblx0XHRcdGZvciAoIGkgPSAwOyBpIDwgY2xhc3Nlcy5sZW5ndGg7IGkrKyApIHtcblx0XHRcdFx0Y3VycmVudCA9IHRoYXQuY2xhc3Nlc0VsZW1lbnRMb29rdXBbIGNsYXNzZXNbIGkgXSBdIHx8ICQoKTtcblx0XHRcdFx0aWYgKCBvcHRpb25zLmFkZCApIHtcblx0XHRcdFx0XHRjdXJyZW50ID0gJCggJC51bmlxdWUoIGN1cnJlbnQuZ2V0KCkuY29uY2F0KCBvcHRpb25zLmVsZW1lbnQuZ2V0KCkgKSApICk7XG5cdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0Y3VycmVudCA9ICQoIGN1cnJlbnQubm90KCBvcHRpb25zLmVsZW1lbnQgKS5nZXQoKSApO1xuXHRcdFx0XHR9XG5cdFx0XHRcdHRoYXQuY2xhc3Nlc0VsZW1lbnRMb29rdXBbIGNsYXNzZXNbIGkgXSBdID0gY3VycmVudDtcblx0XHRcdFx0ZnVsbC5wdXNoKCBjbGFzc2VzWyBpIF0gKTtcblx0XHRcdFx0aWYgKCBjaGVja09wdGlvbiAmJiBvcHRpb25zLmNsYXNzZXNbIGNsYXNzZXNbIGkgXSBdICkge1xuXHRcdFx0XHRcdGZ1bGwucHVzaCggb3B0aW9ucy5jbGFzc2VzWyBjbGFzc2VzWyBpIF0gXSApO1xuXHRcdFx0XHR9XG5cdFx0XHR9XG5cdFx0fVxuXG5cdFx0dGhpcy5fb24oIG9wdGlvbnMuZWxlbWVudCwge1xuXHRcdFx0XCJyZW1vdmVcIjogXCJfdW50cmFja0NsYXNzZXNFbGVtZW50XCJcblx0XHR9ICk7XG5cblx0XHRpZiAoIG9wdGlvbnMua2V5cyApIHtcblx0XHRcdHByb2Nlc3NDbGFzc1N0cmluZyggb3B0aW9ucy5rZXlzLm1hdGNoKCAvXFxTKy9nICkgfHwgW10sIHRydWUgKTtcblx0XHR9XG5cdFx0aWYgKCBvcHRpb25zLmV4dHJhICkge1xuXHRcdFx0cHJvY2Vzc0NsYXNzU3RyaW5nKCBvcHRpb25zLmV4dHJhLm1hdGNoKCAvXFxTKy9nICkgfHwgW10gKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZnVsbC5qb2luKCBcIiBcIiApO1xuXHR9LFxuXG5cdF91bnRyYWNrQ2xhc3Nlc0VsZW1lbnQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHR2YXIgdGhhdCA9IHRoaXM7XG5cdFx0JC5lYWNoKCB0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwLCBmdW5jdGlvbigga2V5LCB2YWx1ZSApIHtcblx0XHRcdGlmICggJC5pbkFycmF5KCBldmVudC50YXJnZXQsIHZhbHVlICkgIT09IC0xICkge1xuXHRcdFx0XHR0aGF0LmNsYXNzZXNFbGVtZW50TG9va3VwWyBrZXkgXSA9ICQoIHZhbHVlLm5vdCggZXZlbnQudGFyZ2V0ICkuZ2V0KCkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0X3JlbW92ZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEgKSB7XG5cdFx0cmV0dXJuIHRoaXMuX3RvZ2dsZUNsYXNzKCBlbGVtZW50LCBrZXlzLCBleHRyYSwgZmFsc2UgKTtcblx0fSxcblxuXHRfYWRkQ2xhc3M6IGZ1bmN0aW9uKCBlbGVtZW50LCBrZXlzLCBleHRyYSApIHtcblx0XHRyZXR1cm4gdGhpcy5fdG9nZ2xlQ2xhc3MoIGVsZW1lbnQsIGtleXMsIGV4dHJhLCB0cnVlICk7XG5cdH0sXG5cblx0X3RvZ2dsZUNsYXNzOiBmdW5jdGlvbiggZWxlbWVudCwga2V5cywgZXh0cmEsIGFkZCApIHtcblx0XHRhZGQgPSAoIHR5cGVvZiBhZGQgPT09IFwiYm9vbGVhblwiICkgPyBhZGQgOiBleHRyYTtcblx0XHR2YXIgc2hpZnQgPSAoIHR5cGVvZiBlbGVtZW50ID09PSBcInN0cmluZ1wiIHx8IGVsZW1lbnQgPT09IG51bGwgKSxcblx0XHRcdG9wdGlvbnMgPSB7XG5cdFx0XHRcdGV4dHJhOiBzaGlmdCA/IGtleXMgOiBleHRyYSxcblx0XHRcdFx0a2V5czogc2hpZnQgPyBlbGVtZW50IDoga2V5cyxcblx0XHRcdFx0ZWxlbWVudDogc2hpZnQgPyB0aGlzLmVsZW1lbnQgOiBlbGVtZW50LFxuXHRcdFx0XHRhZGQ6IGFkZFxuXHRcdFx0fTtcblx0XHRvcHRpb25zLmVsZW1lbnQudG9nZ2xlQ2xhc3MoIHRoaXMuX2NsYXNzZXMoIG9wdGlvbnMgKSwgYWRkICk7XG5cdFx0cmV0dXJuIHRoaXM7XG5cdH0sXG5cblx0X29uOiBmdW5jdGlvbiggc3VwcHJlc3NEaXNhYmxlZENoZWNrLCBlbGVtZW50LCBoYW5kbGVycyApIHtcblx0XHR2YXIgZGVsZWdhdGVFbGVtZW50O1xuXHRcdHZhciBpbnN0YW5jZSA9IHRoaXM7XG5cblx0XHQvLyBObyBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgZmxhZywgc2h1ZmZsZSBhcmd1bWVudHNcblx0XHRpZiAoIHR5cGVvZiBzdXBwcmVzc0Rpc2FibGVkQ2hlY2sgIT09IFwiYm9vbGVhblwiICkge1xuXHRcdFx0aGFuZGxlcnMgPSBlbGVtZW50O1xuXHRcdFx0ZWxlbWVudCA9IHN1cHByZXNzRGlzYWJsZWRDaGVjaztcblx0XHRcdHN1cHByZXNzRGlzYWJsZWRDaGVjayA9IGZhbHNlO1xuXHRcdH1cblxuXHRcdC8vIE5vIGVsZW1lbnQgYXJndW1lbnQsIHNodWZmbGUgYW5kIHVzZSB0aGlzLmVsZW1lbnRcblx0XHRpZiAoICFoYW5kbGVycyApIHtcblx0XHRcdGhhbmRsZXJzID0gZWxlbWVudDtcblx0XHRcdGVsZW1lbnQgPSB0aGlzLmVsZW1lbnQ7XG5cdFx0XHRkZWxlZ2F0ZUVsZW1lbnQgPSB0aGlzLndpZGdldCgpO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbGVtZW50ID0gZGVsZWdhdGVFbGVtZW50ID0gJCggZWxlbWVudCApO1xuXHRcdFx0dGhpcy5iaW5kaW5ncyA9IHRoaXMuYmluZGluZ3MuYWRkKCBlbGVtZW50ICk7XG5cdFx0fVxuXG5cdFx0JC5lYWNoKCBoYW5kbGVycywgZnVuY3Rpb24oIGV2ZW50LCBoYW5kbGVyICkge1xuXHRcdFx0ZnVuY3Rpb24gaGFuZGxlclByb3h5KCkge1xuXG5cdFx0XHRcdC8vIEFsbG93IHdpZGdldHMgdG8gY3VzdG9taXplIHRoZSBkaXNhYmxlZCBoYW5kbGluZ1xuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGFzIGFuIGFycmF5IGluc3RlYWQgb2YgYm9vbGVhblxuXHRcdFx0XHQvLyAtIGRpc2FibGVkIGNsYXNzIGFzIG1ldGhvZCBmb3IgZGlzYWJsaW5nIGluZGl2aWR1YWwgcGFydHNcblx0XHRcdFx0aWYgKCAhc3VwcHJlc3NEaXNhYmxlZENoZWNrICYmXG5cdFx0XHRcdFx0XHQoIGluc3RhbmNlLm9wdGlvbnMuZGlzYWJsZWQgPT09IHRydWUgfHxcblx0XHRcdFx0XHRcdCQoIHRoaXMgKS5oYXNDbGFzcyggXCJ1aS1zdGF0ZS1kaXNhYmxlZFwiICkgKSApIHtcblx0XHRcdFx0XHRyZXR1cm47XG5cdFx0XHRcdH1cblx0XHRcdFx0cmV0dXJuICggdHlwZW9mIGhhbmRsZXIgPT09IFwic3RyaW5nXCIgPyBpbnN0YW5jZVsgaGFuZGxlciBdIDogaGFuZGxlciApXG5cdFx0XHRcdFx0LmFwcGx5KCBpbnN0YW5jZSwgYXJndW1lbnRzICk7XG5cdFx0XHR9XG5cblx0XHRcdC8vIENvcHkgdGhlIGd1aWQgc28gZGlyZWN0IHVuYmluZGluZyB3b3Jrc1xuXHRcdFx0aWYgKCB0eXBlb2YgaGFuZGxlciAhPT0gXCJzdHJpbmdcIiApIHtcblx0XHRcdFx0aGFuZGxlclByb3h5Lmd1aWQgPSBoYW5kbGVyLmd1aWQgPVxuXHRcdFx0XHRcdGhhbmRsZXIuZ3VpZCB8fCBoYW5kbGVyUHJveHkuZ3VpZCB8fCAkLmd1aWQrKztcblx0XHRcdH1cblxuXHRcdFx0dmFyIG1hdGNoID0gZXZlbnQubWF0Y2goIC9eKFtcXHc6LV0qKVxccyooLiopJC8gKTtcblx0XHRcdHZhciBldmVudE5hbWUgPSBtYXRjaFsgMSBdICsgaW5zdGFuY2UuZXZlbnROYW1lc3BhY2U7XG5cdFx0XHR2YXIgc2VsZWN0b3IgPSBtYXRjaFsgMiBdO1xuXG5cdFx0XHRpZiAoIHNlbGVjdG9yICkge1xuXHRcdFx0XHRkZWxlZ2F0ZUVsZW1lbnQub24oIGV2ZW50TmFtZSwgc2VsZWN0b3IsIGhhbmRsZXJQcm94eSApO1xuXHRcdFx0fSBlbHNlIHtcblx0XHRcdFx0ZWxlbWVudC5vbiggZXZlbnROYW1lLCBoYW5kbGVyUHJveHkgKTtcblx0XHRcdH1cblx0XHR9ICk7XG5cdH0sXG5cblx0X29mZjogZnVuY3Rpb24oIGVsZW1lbnQsIGV2ZW50TmFtZSApIHtcblx0XHRldmVudE5hbWUgPSAoIGV2ZW50TmFtZSB8fCBcIlwiICkuc3BsaXQoIFwiIFwiICkuam9pbiggdGhpcy5ldmVudE5hbWVzcGFjZSArIFwiIFwiICkgK1xuXHRcdFx0dGhpcy5ldmVudE5hbWVzcGFjZTtcblx0XHRlbGVtZW50Lm9mZiggZXZlbnROYW1lICkub2ZmKCBldmVudE5hbWUgKTtcblxuXHRcdC8vIENsZWFyIHRoZSBzdGFjayB0byBhdm9pZCBtZW1vcnkgbGVha3MgKCMxMDA1Nilcblx0XHR0aGlzLmJpbmRpbmdzID0gJCggdGhpcy5iaW5kaW5ncy5ub3QoIGVsZW1lbnQgKS5nZXQoKSApO1xuXHRcdHRoaXMuZm9jdXNhYmxlID0gJCggdGhpcy5mb2N1c2FibGUubm90KCBlbGVtZW50ICkuZ2V0KCkgKTtcblx0XHR0aGlzLmhvdmVyYWJsZSA9ICQoIHRoaXMuaG92ZXJhYmxlLm5vdCggZWxlbWVudCApLmdldCgpICk7XG5cdH0sXG5cblx0X2RlbGF5OiBmdW5jdGlvbiggaGFuZGxlciwgZGVsYXkgKSB7XG5cdFx0ZnVuY3Rpb24gaGFuZGxlclByb3h5KCkge1xuXHRcdFx0cmV0dXJuICggdHlwZW9mIGhhbmRsZXIgPT09IFwic3RyaW5nXCIgPyBpbnN0YW5jZVsgaGFuZGxlciBdIDogaGFuZGxlciApXG5cdFx0XHRcdC5hcHBseSggaW5zdGFuY2UsIGFyZ3VtZW50cyApO1xuXHRcdH1cblx0XHR2YXIgaW5zdGFuY2UgPSB0aGlzO1xuXHRcdHJldHVybiBzZXRUaW1lb3V0KCBoYW5kbGVyUHJveHksIGRlbGF5IHx8IDAgKTtcblx0fSxcblxuXHRfaG92ZXJhYmxlOiBmdW5jdGlvbiggZWxlbWVudCApIHtcblx0XHR0aGlzLmhvdmVyYWJsZSA9IHRoaXMuaG92ZXJhYmxlLmFkZCggZWxlbWVudCApO1xuXHRcdHRoaXMuX29uKCBlbGVtZW50LCB7XG5cdFx0XHRtb3VzZWVudGVyOiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRcdHRoaXMuX2FkZENsYXNzKCAkKCBldmVudC5jdXJyZW50VGFyZ2V0ICksIG51bGwsIFwidWktc3RhdGUtaG92ZXJcIiApO1xuXHRcdFx0fSxcblx0XHRcdG1vdXNlbGVhdmU6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1ob3ZlclwiICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF9mb2N1c2FibGU6IGZ1bmN0aW9uKCBlbGVtZW50ICkge1xuXHRcdHRoaXMuZm9jdXNhYmxlID0gdGhpcy5mb2N1c2FibGUuYWRkKCBlbGVtZW50ICk7XG5cdFx0dGhpcy5fb24oIGVsZW1lbnQsIHtcblx0XHRcdGZvY3VzaW46IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fYWRkQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0XHR9LFxuXHRcdFx0Zm9jdXNvdXQ6IGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0dGhpcy5fcmVtb3ZlQ2xhc3MoICQoIGV2ZW50LmN1cnJlbnRUYXJnZXQgKSwgbnVsbCwgXCJ1aS1zdGF0ZS1mb2N1c1wiICk7XG5cdFx0XHR9XG5cdFx0fSApO1xuXHR9LFxuXG5cdF90cmlnZ2VyOiBmdW5jdGlvbiggdHlwZSwgZXZlbnQsIGRhdGEgKSB7XG5cdFx0dmFyIHByb3AsIG9yaWc7XG5cdFx0dmFyIGNhbGxiYWNrID0gdGhpcy5vcHRpb25zWyB0eXBlIF07XG5cblx0XHRkYXRhID0gZGF0YSB8fCB7fTtcblx0XHRldmVudCA9ICQuRXZlbnQoIGV2ZW50ICk7XG5cdFx0ZXZlbnQudHlwZSA9ICggdHlwZSA9PT0gdGhpcy53aWRnZXRFdmVudFByZWZpeCA/XG5cdFx0XHR0eXBlIDpcblx0XHRcdHRoaXMud2lkZ2V0RXZlbnRQcmVmaXggKyB0eXBlICkudG9Mb3dlckNhc2UoKTtcblxuXHRcdC8vIFRoZSBvcmlnaW5hbCBldmVudCBtYXkgY29tZSBmcm9tIGFueSBlbGVtZW50XG5cdFx0Ly8gc28gd2UgbmVlZCB0byByZXNldCB0aGUgdGFyZ2V0IG9uIHRoZSBuZXcgZXZlbnRcblx0XHRldmVudC50YXJnZXQgPSB0aGlzLmVsZW1lbnRbIDAgXTtcblxuXHRcdC8vIENvcHkgb3JpZ2luYWwgZXZlbnQgcHJvcGVydGllcyBvdmVyIHRvIHRoZSBuZXcgZXZlbnRcblx0XHRvcmlnID0gZXZlbnQub3JpZ2luYWxFdmVudDtcblx0XHRpZiAoIG9yaWcgKSB7XG5cdFx0XHRmb3IgKCBwcm9wIGluIG9yaWcgKSB7XG5cdFx0XHRcdGlmICggISggcHJvcCBpbiBldmVudCApICkge1xuXHRcdFx0XHRcdGV2ZW50WyBwcm9wIF0gPSBvcmlnWyBwcm9wIF07XG5cdFx0XHRcdH1cblx0XHRcdH1cblx0XHR9XG5cblx0XHR0aGlzLmVsZW1lbnQudHJpZ2dlciggZXZlbnQsIGRhdGEgKTtcblx0XHRyZXR1cm4gISggJC5pc0Z1bmN0aW9uKCBjYWxsYmFjayApICYmXG5cdFx0XHRjYWxsYmFjay5hcHBseSggdGhpcy5lbGVtZW50WyAwIF0sIFsgZXZlbnQgXS5jb25jYXQoIGRhdGEgKSApID09PSBmYWxzZSB8fFxuXHRcdFx0ZXZlbnQuaXNEZWZhdWx0UHJldmVudGVkKCkgKTtcblx0fVxufTtcblxuJC5lYWNoKCB7IHNob3c6IFwiZmFkZUluXCIsIGhpZGU6IFwiZmFkZU91dFwiIH0sIGZ1bmN0aW9uKCBtZXRob2QsIGRlZmF1bHRFZmZlY3QgKSB7XG5cdCQuV2lkZ2V0LnByb3RvdHlwZVsgXCJfXCIgKyBtZXRob2QgXSA9IGZ1bmN0aW9uKCBlbGVtZW50LCBvcHRpb25zLCBjYWxsYmFjayApIHtcblx0XHRpZiAoIHR5cGVvZiBvcHRpb25zID09PSBcInN0cmluZ1wiICkge1xuXHRcdFx0b3B0aW9ucyA9IHsgZWZmZWN0OiBvcHRpb25zIH07XG5cdFx0fVxuXG5cdFx0dmFyIGhhc09wdGlvbnM7XG5cdFx0dmFyIGVmZmVjdE5hbWUgPSAhb3B0aW9ucyA/XG5cdFx0XHRtZXRob2QgOlxuXHRcdFx0b3B0aW9ucyA9PT0gdHJ1ZSB8fCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiA/XG5cdFx0XHRcdGRlZmF1bHRFZmZlY3QgOlxuXHRcdFx0XHRvcHRpb25zLmVmZmVjdCB8fCBkZWZhdWx0RWZmZWN0O1xuXG5cdFx0b3B0aW9ucyA9IG9wdGlvbnMgfHwge307XG5cdFx0aWYgKCB0eXBlb2Ygb3B0aW9ucyA9PT0gXCJudW1iZXJcIiApIHtcblx0XHRcdG9wdGlvbnMgPSB7IGR1cmF0aW9uOiBvcHRpb25zIH07XG5cdFx0fVxuXG5cdFx0aGFzT3B0aW9ucyA9ICEkLmlzRW1wdHlPYmplY3QoIG9wdGlvbnMgKTtcblx0XHRvcHRpb25zLmNvbXBsZXRlID0gY2FsbGJhY2s7XG5cblx0XHRpZiAoIG9wdGlvbnMuZGVsYXkgKSB7XG5cdFx0XHRlbGVtZW50LmRlbGF5KCBvcHRpb25zLmRlbGF5ICk7XG5cdFx0fVxuXG5cdFx0aWYgKCBoYXNPcHRpb25zICYmICQuZWZmZWN0cyAmJiAkLmVmZmVjdHMuZWZmZWN0WyBlZmZlY3ROYW1lIF0gKSB7XG5cdFx0XHRlbGVtZW50WyBtZXRob2QgXSggb3B0aW9ucyApO1xuXHRcdH0gZWxzZSBpZiAoIGVmZmVjdE5hbWUgIT09IG1ldGhvZCAmJiBlbGVtZW50WyBlZmZlY3ROYW1lIF0gKSB7XG5cdFx0XHRlbGVtZW50WyBlZmZlY3ROYW1lIF0oIG9wdGlvbnMuZHVyYXRpb24sIG9wdGlvbnMuZWFzaW5nLCBjYWxsYmFjayApO1xuXHRcdH0gZWxzZSB7XG5cdFx0XHRlbGVtZW50LnF1ZXVlKCBmdW5jdGlvbiggbmV4dCApIHtcblx0XHRcdFx0JCggdGhpcyApWyBtZXRob2QgXSgpO1xuXHRcdFx0XHRpZiAoIGNhbGxiYWNrICkge1xuXHRcdFx0XHRcdGNhbGxiYWNrLmNhbGwoIGVsZW1lbnRbIDAgXSApO1xuXHRcdFx0XHR9XG5cdFx0XHRcdG5leHQoKTtcblx0XHRcdH0gKTtcblx0XHR9XG5cdH07XG59ICk7XG5cbnJldHVybiAkLndpZGdldDtcblxufSApICk7XG4iLCIvKiFcbiAqIGpRdWVyeSBVSSBNb3VzZSAxLjEyLjFcbiAqIGh0dHA6Ly9qcXVlcnl1aS5jb21cbiAqXG4gKiBDb3B5cmlnaHQgalF1ZXJ5IEZvdW5kYXRpb24gYW5kIG90aGVyIGNvbnRyaWJ1dG9yc1xuICogUmVsZWFzZWQgdW5kZXIgdGhlIE1JVCBsaWNlbnNlLlxuICogaHR0cDovL2pxdWVyeS5vcmcvbGljZW5zZVxuICovXG5cbi8vPj5sYWJlbDogTW91c2Vcbi8vPj5ncm91cDogV2lkZ2V0c1xuLy8+PmRlc2NyaXB0aW9uOiBBYnN0cmFjdHMgbW91c2UtYmFzZWQgaW50ZXJhY3Rpb25zIHRvIGFzc2lzdCBpbiBjcmVhdGluZyBjZXJ0YWluIHdpZGdldHMuXG4vLz4+ZG9jczogaHR0cDovL2FwaS5qcXVlcnl1aS5jb20vbW91c2UvXG5cbiggZnVuY3Rpb24oIGZhY3RvcnkgKSB7XG5cdGlmICggdHlwZW9mIGRlZmluZSA9PT0gXCJmdW5jdGlvblwiICYmIGRlZmluZS5hbWQgKSB7XG5cblx0XHQvLyBBTUQuIFJlZ2lzdGVyIGFzIGFuIGFub255bW91cyBtb2R1bGUuXG5cdFx0ZGVmaW5lKCBbXG5cdFx0XHRcImpxdWVyeVwiLFxuXHRcdFx0XCIuLi9pZVwiLFxuXHRcdFx0XCIuLi92ZXJzaW9uXCIsXG5cdFx0XHRcIi4uL3dpZGdldFwiXG5cdFx0XSwgZmFjdG9yeSApO1xuXHR9IGVsc2Uge1xuXG5cdFx0Ly8gQnJvd3NlciBnbG9iYWxzXG5cdFx0ZmFjdG9yeSggalF1ZXJ5ICk7XG5cdH1cbn0oIGZ1bmN0aW9uKCAkICkge1xuXG52YXIgbW91c2VIYW5kbGVkID0gZmFsc2U7XG4kKCBkb2N1bWVudCApLm9uKCBcIm1vdXNldXBcIiwgZnVuY3Rpb24oKSB7XG5cdG1vdXNlSGFuZGxlZCA9IGZhbHNlO1xufSApO1xuXG5yZXR1cm4gJC53aWRnZXQoIFwidWkubW91c2VcIiwge1xuXHR2ZXJzaW9uOiBcIjEuMTIuMVwiLFxuXHRvcHRpb25zOiB7XG5cdFx0Y2FuY2VsOiBcImlucHV0LCB0ZXh0YXJlYSwgYnV0dG9uLCBzZWxlY3QsIG9wdGlvblwiLFxuXHRcdGRpc3RhbmNlOiAxLFxuXHRcdGRlbGF5OiAwXG5cdH0sXG5cdF9tb3VzZUluaXQ6IGZ1bmN0aW9uKCkge1xuXHRcdHZhciB0aGF0ID0gdGhpcztcblxuXHRcdHRoaXMuZWxlbWVudFxuXHRcdFx0Lm9uKCBcIm1vdXNlZG93bi5cIiArIHRoaXMud2lkZ2V0TmFtZSwgZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0XHRyZXR1cm4gdGhhdC5fbW91c2VEb3duKCBldmVudCApO1xuXHRcdFx0fSApXG5cdFx0XHQub24oIFwiY2xpY2suXCIgKyB0aGlzLndpZGdldE5hbWUsIGZ1bmN0aW9uKCBldmVudCApIHtcblx0XHRcdFx0aWYgKCB0cnVlID09PSAkLmRhdGEoIGV2ZW50LnRhcmdldCwgdGhhdC53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApICkge1xuXHRcdFx0XHRcdCQucmVtb3ZlRGF0YSggZXZlbnQudGFyZ2V0LCB0aGF0LndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiICk7XG5cdFx0XHRcdFx0ZXZlbnQuc3RvcEltbWVkaWF0ZVByb3BhZ2F0aW9uKCk7XG5cdFx0XHRcdFx0cmV0dXJuIGZhbHNlO1xuXHRcdFx0XHR9XG5cdFx0XHR9ICk7XG5cblx0XHR0aGlzLnN0YXJ0ZWQgPSBmYWxzZTtcblx0fSxcblxuXHQvLyBUT0RPOiBtYWtlIHN1cmUgZGVzdHJveWluZyBvbmUgaW5zdGFuY2Ugb2YgbW91c2UgZG9lc24ndCBtZXNzIHdpdGhcblx0Ly8gb3RoZXIgaW5zdGFuY2VzIG9mIG1vdXNlXG5cdF9tb3VzZURlc3Ryb3k6IGZ1bmN0aW9uKCkge1xuXHRcdHRoaXMuZWxlbWVudC5vZmYoIFwiLlwiICsgdGhpcy53aWRnZXROYW1lICk7XG5cdFx0aWYgKCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApIHtcblx0XHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdFx0Lm9mZiggXCJtb3VzZW1vdmUuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlTW92ZURlbGVnYXRlIClcblx0XHRcdFx0Lm9mZiggXCJtb3VzZXVwLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUgKTtcblx0XHR9XG5cdH0sXG5cblx0X21vdXNlRG93bjogZnVuY3Rpb24oIGV2ZW50ICkge1xuXG5cdFx0Ly8gZG9uJ3QgbGV0IG1vcmUgdGhhbiBvbmUgd2lkZ2V0IGhhbmRsZSBtb3VzZVN0YXJ0XG5cdFx0aWYgKCBtb3VzZUhhbmRsZWQgKSB7XG5cdFx0XHRyZXR1cm47XG5cdFx0fVxuXG5cdFx0dGhpcy5fbW91c2VNb3ZlZCA9IGZhbHNlO1xuXG5cdFx0Ly8gV2UgbWF5IGhhdmUgbWlzc2VkIG1vdXNldXAgKG91dCBvZiB3aW5kb3cpXG5cdFx0KCB0aGlzLl9tb3VzZVN0YXJ0ZWQgJiYgdGhpcy5fbW91c2VVcCggZXZlbnQgKSApO1xuXG5cdFx0dGhpcy5fbW91c2VEb3duRXZlbnQgPSBldmVudDtcblxuXHRcdHZhciB0aGF0ID0gdGhpcyxcblx0XHRcdGJ0bklzTGVmdCA9ICggZXZlbnQud2hpY2ggPT09IDEgKSxcblxuXHRcdFx0Ly8gZXZlbnQudGFyZ2V0Lm5vZGVOYW1lIHdvcmtzIGFyb3VuZCBhIGJ1ZyBpbiBJRSA4IHdpdGhcblx0XHRcdC8vIGRpc2FibGVkIGlucHV0cyAoIzc2MjApXG5cdFx0XHRlbElzQ2FuY2VsID0gKCB0eXBlb2YgdGhpcy5vcHRpb25zLmNhbmNlbCA9PT0gXCJzdHJpbmdcIiAmJiBldmVudC50YXJnZXQubm9kZU5hbWUgP1xuXHRcdFx0XHQkKCBldmVudC50YXJnZXQgKS5jbG9zZXN0KCB0aGlzLm9wdGlvbnMuY2FuY2VsICkubGVuZ3RoIDogZmFsc2UgKTtcblx0XHRpZiAoICFidG5Jc0xlZnQgfHwgZWxJc0NhbmNlbCB8fCAhdGhpcy5fbW91c2VDYXB0dXJlKCBldmVudCApICkge1xuXHRcdFx0cmV0dXJuIHRydWU7XG5cdFx0fVxuXG5cdFx0dGhpcy5tb3VzZURlbGF5TWV0ID0gIXRoaXMub3B0aW9ucy5kZWxheTtcblx0XHRpZiAoICF0aGlzLm1vdXNlRGVsYXlNZXQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZURlbGF5VGltZXIgPSBzZXRUaW1lb3V0KCBmdW5jdGlvbigpIHtcblx0XHRcdFx0dGhhdC5tb3VzZURlbGF5TWV0ID0gdHJ1ZTtcblx0XHRcdH0sIHRoaXMub3B0aW9ucy5kZWxheSApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VEaXN0YW5jZU1ldCggZXZlbnQgKSAmJiB0aGlzLl9tb3VzZURlbGF5TWV0KCBldmVudCApICkge1xuXHRcdFx0dGhpcy5fbW91c2VTdGFydGVkID0gKCB0aGlzLl9tb3VzZVN0YXJ0KCBldmVudCApICE9PSBmYWxzZSApO1xuXHRcdFx0aWYgKCAhdGhpcy5fbW91c2VTdGFydGVkICkge1xuXHRcdFx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHRcdFx0XHRyZXR1cm4gdHJ1ZTtcblx0XHRcdH1cblx0XHR9XG5cblx0XHQvLyBDbGljayBldmVudCBtYXkgbmV2ZXIgaGF2ZSBmaXJlZCAoR2Vja28gJiBPcGVyYSlcblx0XHRpZiAoIHRydWUgPT09ICQuZGF0YSggZXZlbnQudGFyZ2V0LCB0aGlzLndpZGdldE5hbWUgKyBcIi5wcmV2ZW50Q2xpY2tFdmVudFwiICkgKSB7XG5cdFx0XHQkLnJlbW92ZURhdGEoIGV2ZW50LnRhcmdldCwgdGhpcy53aWRnZXROYW1lICsgXCIucHJldmVudENsaWNrRXZlbnRcIiApO1xuXHRcdH1cblxuXHRcdC8vIFRoZXNlIGRlbGVnYXRlcyBhcmUgcmVxdWlyZWQgdG8ga2VlcCBjb250ZXh0XG5cdFx0dGhpcy5fbW91c2VNb3ZlRGVsZWdhdGUgPSBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0XHRyZXR1cm4gdGhhdC5fbW91c2VNb3ZlKCBldmVudCApO1xuXHRcdH07XG5cdFx0dGhpcy5fbW91c2VVcERlbGVnYXRlID0gZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdFx0cmV0dXJuIHRoYXQuX21vdXNlVXAoIGV2ZW50ICk7XG5cdFx0fTtcblxuXHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdC5vbiggXCJtb3VzZW1vdmUuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlTW92ZURlbGVnYXRlIClcblx0XHRcdC5vbiggXCJtb3VzZXVwLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZVVwRGVsZWdhdGUgKTtcblxuXHRcdGV2ZW50LnByZXZlbnREZWZhdWx0KCk7XG5cblx0XHRtb3VzZUhhbmRsZWQgPSB0cnVlO1xuXHRcdHJldHVybiB0cnVlO1xuXHR9LFxuXG5cdF9tb3VzZU1vdmU6IGZ1bmN0aW9uKCBldmVudCApIHtcblxuXHRcdC8vIE9ubHkgY2hlY2sgZm9yIG1vdXNldXBzIG91dHNpZGUgdGhlIGRvY3VtZW50IGlmIHlvdSd2ZSBtb3ZlZCBpbnNpZGUgdGhlIGRvY3VtZW50XG5cdFx0Ly8gYXQgbGVhc3Qgb25jZS4gVGhpcyBwcmV2ZW50cyB0aGUgZmlyaW5nIG9mIG1vdXNldXAgaW4gdGhlIGNhc2Ugb2YgSUU8OSwgd2hpY2ggd2lsbFxuXHRcdC8vIGZpcmUgYSBtb3VzZW1vdmUgZXZlbnQgaWYgY29udGVudCBpcyBwbGFjZWQgdW5kZXIgdGhlIGN1cnNvci4gU2VlICM3Nzc4XG5cdFx0Ly8gU3VwcG9ydDogSUUgPDlcblx0XHRpZiAoIHRoaXMuX21vdXNlTW92ZWQgKSB7XG5cblx0XHRcdC8vIElFIG1vdXNldXAgY2hlY2sgLSBtb3VzZXVwIGhhcHBlbmVkIHdoZW4gbW91c2Ugd2FzIG91dCBvZiB3aW5kb3dcblx0XHRcdGlmICggJC51aS5pZSAmJiAoICFkb2N1bWVudC5kb2N1bWVudE1vZGUgfHwgZG9jdW1lbnQuZG9jdW1lbnRNb2RlIDwgOSApICYmXG5cdFx0XHRcdFx0IWV2ZW50LmJ1dHRvbiApIHtcblx0XHRcdFx0cmV0dXJuIHRoaXMuX21vdXNlVXAoIGV2ZW50ICk7XG5cblx0XHRcdC8vIElmcmFtZSBtb3VzZXVwIGNoZWNrIC0gbW91c2V1cCBvY2N1cnJlZCBpbiBhbm90aGVyIGRvY3VtZW50XG5cdFx0XHR9IGVsc2UgaWYgKCAhZXZlbnQud2hpY2ggKSB7XG5cblx0XHRcdFx0Ly8gU3VwcG9ydDogU2FmYXJpIDw9OCAtIDlcblx0XHRcdFx0Ly8gU2FmYXJpIHNldHMgd2hpY2ggdG8gMCBpZiB5b3UgcHJlc3MgYW55IG9mIHRoZSBmb2xsb3dpbmcga2V5c1xuXHRcdFx0XHQvLyBkdXJpbmcgYSBkcmFnICgjMTQ0NjEpXG5cdFx0XHRcdGlmICggZXZlbnQub3JpZ2luYWxFdmVudC5hbHRLZXkgfHwgZXZlbnQub3JpZ2luYWxFdmVudC5jdHJsS2V5IHx8XG5cdFx0XHRcdFx0XHRldmVudC5vcmlnaW5hbEV2ZW50Lm1ldGFLZXkgfHwgZXZlbnQub3JpZ2luYWxFdmVudC5zaGlmdEtleSApIHtcblx0XHRcdFx0XHR0aGlzLmlnbm9yZU1pc3NpbmdXaGljaCA9IHRydWU7XG5cdFx0XHRcdH0gZWxzZSBpZiAoICF0aGlzLmlnbm9yZU1pc3NpbmdXaGljaCApIHtcblx0XHRcdFx0XHRyZXR1cm4gdGhpcy5fbW91c2VVcCggZXZlbnQgKTtcblx0XHRcdFx0fVxuXHRcdFx0fVxuXHRcdH1cblxuXHRcdGlmICggZXZlbnQud2hpY2ggfHwgZXZlbnQuYnV0dG9uICkge1xuXHRcdFx0dGhpcy5fbW91c2VNb3ZlZCA9IHRydWU7XG5cdFx0fVxuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZVN0YXJ0ZWQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZURyYWcoIGV2ZW50ICk7XG5cdFx0XHRyZXR1cm4gZXZlbnQucHJldmVudERlZmF1bHQoKTtcblx0XHR9XG5cblx0XHRpZiAoIHRoaXMuX21vdXNlRGlzdGFuY2VNZXQoIGV2ZW50ICkgJiYgdGhpcy5fbW91c2VEZWxheU1ldCggZXZlbnQgKSApIHtcblx0XHRcdHRoaXMuX21vdXNlU3RhcnRlZCA9XG5cdFx0XHRcdCggdGhpcy5fbW91c2VTdGFydCggdGhpcy5fbW91c2VEb3duRXZlbnQsIGV2ZW50ICkgIT09IGZhbHNlICk7XG5cdFx0XHQoIHRoaXMuX21vdXNlU3RhcnRlZCA/IHRoaXMuX21vdXNlRHJhZyggZXZlbnQgKSA6IHRoaXMuX21vdXNlVXAoIGV2ZW50ICkgKTtcblx0XHR9XG5cblx0XHRyZXR1cm4gIXRoaXMuX21vdXNlU3RhcnRlZDtcblx0fSxcblxuXHRfbW91c2VVcDogZnVuY3Rpb24oIGV2ZW50ICkge1xuXHRcdHRoaXMuZG9jdW1lbnRcblx0XHRcdC5vZmYoIFwibW91c2Vtb3ZlLlwiICsgdGhpcy53aWRnZXROYW1lLCB0aGlzLl9tb3VzZU1vdmVEZWxlZ2F0ZSApXG5cdFx0XHQub2ZmKCBcIm1vdXNldXAuXCIgKyB0aGlzLndpZGdldE5hbWUsIHRoaXMuX21vdXNlVXBEZWxlZ2F0ZSApO1xuXG5cdFx0aWYgKCB0aGlzLl9tb3VzZVN0YXJ0ZWQgKSB7XG5cdFx0XHR0aGlzLl9tb3VzZVN0YXJ0ZWQgPSBmYWxzZTtcblxuXHRcdFx0aWYgKCBldmVudC50YXJnZXQgPT09IHRoaXMuX21vdXNlRG93bkV2ZW50LnRhcmdldCApIHtcblx0XHRcdFx0JC5kYXRhKCBldmVudC50YXJnZXQsIHRoaXMud2lkZ2V0TmFtZSArIFwiLnByZXZlbnRDbGlja0V2ZW50XCIsIHRydWUgKTtcblx0XHRcdH1cblxuXHRcdFx0dGhpcy5fbW91c2VTdG9wKCBldmVudCApO1xuXHRcdH1cblxuXHRcdGlmICggdGhpcy5fbW91c2VEZWxheVRpbWVyICkge1xuXHRcdFx0Y2xlYXJUaW1lb3V0KCB0aGlzLl9tb3VzZURlbGF5VGltZXIgKTtcblx0XHRcdGRlbGV0ZSB0aGlzLl9tb3VzZURlbGF5VGltZXI7XG5cdFx0fVxuXG5cdFx0dGhpcy5pZ25vcmVNaXNzaW5nV2hpY2ggPSBmYWxzZTtcblx0XHRtb3VzZUhhbmRsZWQgPSBmYWxzZTtcblx0XHRldmVudC5wcmV2ZW50RGVmYXVsdCgpO1xuXHR9LFxuXG5cdF9tb3VzZURpc3RhbmNlTWV0OiBmdW5jdGlvbiggZXZlbnQgKSB7XG5cdFx0cmV0dXJuICggTWF0aC5tYXgoXG5cdFx0XHRcdE1hdGguYWJzKCB0aGlzLl9tb3VzZURvd25FdmVudC5wYWdlWCAtIGV2ZW50LnBhZ2VYICksXG5cdFx0XHRcdE1hdGguYWJzKCB0aGlzLl9tb3VzZURvd25FdmVudC5wYWdlWSAtIGV2ZW50LnBhZ2VZIClcblx0XHRcdCkgPj0gdGhpcy5vcHRpb25zLmRpc3RhbmNlXG5cdFx0KTtcblx0fSxcblxuXHRfbW91c2VEZWxheU1ldDogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge1xuXHRcdHJldHVybiB0aGlzLm1vdXNlRGVsYXlNZXQ7XG5cdH0sXG5cblx0Ly8gVGhlc2UgYXJlIHBsYWNlaG9sZGVyIG1ldGhvZHMsIHRvIGJlIG92ZXJyaWRlbiBieSBleHRlbmRpbmcgcGx1Z2luXG5cdF9tb3VzZVN0YXJ0OiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7fSxcblx0X21vdXNlRHJhZzogZnVuY3Rpb24oIC8qIGV2ZW50ICovICkge30sXG5cdF9tb3VzZVN0b3A6IGZ1bmN0aW9uKCAvKiBldmVudCAqLyApIHt9LFxuXHRfbW91c2VDYXB0dXJlOiBmdW5jdGlvbiggLyogZXZlbnQgKi8gKSB7IHJldHVybiB0cnVlOyB9XG59ICk7XG5cbn0gKSApO1xuIiwidmFyIF9fYXNzaWduID0gKHRoaXMgJiYgdGhpcy5fX2Fzc2lnbikgfHwgZnVuY3Rpb24gKCkge1xyXG4gICAgX19hc3NpZ24gPSBPYmplY3QuYXNzaWduIHx8IGZ1bmN0aW9uKHQpIHtcclxuICAgICAgICBmb3IgKHZhciBzLCBpID0gMSwgbiA9IGFyZ3VtZW50cy5sZW5ndGg7IGkgPCBuOyBpKyspIHtcclxuICAgICAgICAgICAgcyA9IGFyZ3VtZW50c1tpXTtcclxuICAgICAgICAgICAgZm9yICh2YXIgcCBpbiBzKSBpZiAoT2JqZWN0LnByb3RvdHlwZS5oYXNPd25Qcm9wZXJ0eS5jYWxsKHMsIHApKVxyXG4gICAgICAgICAgICAgICAgdFtwXSA9IHNbcF07XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHJldHVybiB0O1xyXG4gICAgfTtcclxuICAgIHJldHVybiBfX2Fzc2lnbi5hcHBseSh0aGlzLCBhcmd1bWVudHMpO1xyXG59O1xyXG52YXIgZGVmYXVsdHMgPSB7XHJcbiAgICBsaW5lczogMTIsXHJcbiAgICBsZW5ndGg6IDcsXHJcbiAgICB3aWR0aDogNSxcclxuICAgIHJhZGl1czogMTAsXHJcbiAgICBzY2FsZTogMS4wLFxyXG4gICAgY29ybmVyczogMSxcclxuICAgIGNvbG9yOiAnIzAwMCcsXHJcbiAgICBmYWRlQ29sb3I6ICd0cmFuc3BhcmVudCcsXHJcbiAgICBhbmltYXRpb246ICdzcGlubmVyLWxpbmUtZmFkZS1kZWZhdWx0JyxcclxuICAgIHJvdGF0ZTogMCxcclxuICAgIGRpcmVjdGlvbjogMSxcclxuICAgIHNwZWVkOiAxLFxyXG4gICAgekluZGV4OiAyZTksXHJcbiAgICBjbGFzc05hbWU6ICdzcGlubmVyJyxcclxuICAgIHRvcDogJzUwJScsXHJcbiAgICBsZWZ0OiAnNTAlJyxcclxuICAgIHNoYWRvdzogJzAgMCAxcHggdHJhbnNwYXJlbnQnLFxyXG4gICAgcG9zaXRpb246ICdhYnNvbHV0ZScsXHJcbn07XHJcbnZhciBTcGlubmVyID0gLyoqIEBjbGFzcyAqLyAoZnVuY3Rpb24gKCkge1xyXG4gICAgZnVuY3Rpb24gU3Bpbm5lcihvcHRzKSB7XHJcbiAgICAgICAgaWYgKG9wdHMgPT09IHZvaWQgMCkgeyBvcHRzID0ge307IH1cclxuICAgICAgICB0aGlzLm9wdHMgPSBfX2Fzc2lnbihfX2Fzc2lnbih7fSwgZGVmYXVsdHMpLCBvcHRzKTtcclxuICAgIH1cclxuICAgIC8qKlxyXG4gICAgICogQWRkcyB0aGUgc3Bpbm5lciB0byB0aGUgZ2l2ZW4gdGFyZ2V0IGVsZW1lbnQuIElmIHRoaXMgaW5zdGFuY2UgaXMgYWxyZWFkeVxyXG4gICAgICogc3Bpbm5pbmcsIGl0IGlzIGF1dG9tYXRpY2FsbHkgcmVtb3ZlZCBmcm9tIGl0cyBwcmV2aW91cyB0YXJnZXQgYnkgY2FsbGluZ1xyXG4gICAgICogc3RvcCgpIGludGVybmFsbHkuXHJcbiAgICAgKi9cclxuICAgIFNwaW5uZXIucHJvdG90eXBlLnNwaW4gPSBmdW5jdGlvbiAodGFyZ2V0KSB7XHJcbiAgICAgICAgdGhpcy5zdG9wKCk7XHJcbiAgICAgICAgdGhpcy5lbCA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xyXG4gICAgICAgIHRoaXMuZWwuY2xhc3NOYW1lID0gdGhpcy5vcHRzLmNsYXNzTmFtZTtcclxuICAgICAgICB0aGlzLmVsLnNldEF0dHJpYnV0ZSgncm9sZScsICdwcm9ncmVzc2JhcicpO1xyXG4gICAgICAgIGNzcyh0aGlzLmVsLCB7XHJcbiAgICAgICAgICAgIHBvc2l0aW9uOiB0aGlzLm9wdHMucG9zaXRpb24sXHJcbiAgICAgICAgICAgIHdpZHRoOiAwLFxyXG4gICAgICAgICAgICB6SW5kZXg6IHRoaXMub3B0cy56SW5kZXgsXHJcbiAgICAgICAgICAgIGxlZnQ6IHRoaXMub3B0cy5sZWZ0LFxyXG4gICAgICAgICAgICB0b3A6IHRoaXMub3B0cy50b3AsXHJcbiAgICAgICAgICAgIHRyYW5zZm9ybTogXCJzY2FsZShcIiArIHRoaXMub3B0cy5zY2FsZSArIFwiKVwiLFxyXG4gICAgICAgIH0pO1xyXG4gICAgICAgIGlmICh0YXJnZXQpIHtcclxuICAgICAgICAgICAgdGFyZ2V0Lmluc2VydEJlZm9yZSh0aGlzLmVsLCB0YXJnZXQuZmlyc3RDaGlsZCB8fCBudWxsKTtcclxuICAgICAgICB9XHJcbiAgICAgICAgZHJhd0xpbmVzKHRoaXMuZWwsIHRoaXMub3B0cyk7XHJcbiAgICAgICAgcmV0dXJuIHRoaXM7XHJcbiAgICB9O1xyXG4gICAgLyoqXHJcbiAgICAgKiBTdG9wcyBhbmQgcmVtb3ZlcyB0aGUgU3Bpbm5lci5cclxuICAgICAqIFN0b3BwZWQgc3Bpbm5lcnMgbWF5IGJlIHJldXNlZCBieSBjYWxsaW5nIHNwaW4oKSBhZ2Fpbi5cclxuICAgICAqL1xyXG4gICAgU3Bpbm5lci5wcm90b3R5cGUuc3RvcCA9IGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBpZiAodGhpcy5lbCkge1xyXG4gICAgICAgICAgICBpZiAodHlwZW9mIHJlcXVlc3RBbmltYXRpb25GcmFtZSAhPT0gJ3VuZGVmaW5lZCcpIHtcclxuICAgICAgICAgICAgICAgIGNhbmNlbEFuaW1hdGlvbkZyYW1lKHRoaXMuYW5pbWF0ZUlkKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBlbHNlIHtcclxuICAgICAgICAgICAgICAgIGNsZWFyVGltZW91dCh0aGlzLmFuaW1hdGVJZCk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgaWYgKHRoaXMuZWwucGFyZW50Tm9kZSkge1xyXG4gICAgICAgICAgICAgICAgdGhpcy5lbC5wYXJlbnROb2RlLnJlbW92ZUNoaWxkKHRoaXMuZWwpO1xyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIHRoaXMuZWwgPSB1bmRlZmluZWQ7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIHJldHVybiB0aGlzO1xyXG4gICAgfTtcclxuICAgIHJldHVybiBTcGlubmVyO1xyXG59KCkpO1xyXG5leHBvcnQgeyBTcGlubmVyIH07XHJcbi8qKlxyXG4gKiBTZXRzIG11bHRpcGxlIHN0eWxlIHByb3BlcnRpZXMgYXQgb25jZS5cclxuICovXHJcbmZ1bmN0aW9uIGNzcyhlbCwgcHJvcHMpIHtcclxuICAgIGZvciAodmFyIHByb3AgaW4gcHJvcHMpIHtcclxuICAgICAgICBlbC5zdHlsZVtwcm9wXSA9IHByb3BzW3Byb3BdO1xyXG4gICAgfVxyXG4gICAgcmV0dXJuIGVsO1xyXG59XHJcbi8qKlxyXG4gKiBSZXR1cm5zIHRoZSBsaW5lIGNvbG9yIGZyb20gdGhlIGdpdmVuIHN0cmluZyBvciBhcnJheS5cclxuICovXHJcbmZ1bmN0aW9uIGdldENvbG9yKGNvbG9yLCBpZHgpIHtcclxuICAgIHJldHVybiB0eXBlb2YgY29sb3IgPT0gJ3N0cmluZycgPyBjb2xvciA6IGNvbG9yW2lkeCAlIGNvbG9yLmxlbmd0aF07XHJcbn1cclxuLyoqXHJcbiAqIEludGVybmFsIG1ldGhvZCB0aGF0IGRyYXdzIHRoZSBpbmRpdmlkdWFsIGxpbmVzLlxyXG4gKi9cclxuZnVuY3Rpb24gZHJhd0xpbmVzKGVsLCBvcHRzKSB7XHJcbiAgICB2YXIgYm9yZGVyUmFkaXVzID0gKE1hdGgucm91bmQob3B0cy5jb3JuZXJzICogb3B0cy53aWR0aCAqIDUwMCkgLyAxMDAwKSArICdweCc7XHJcbiAgICB2YXIgc2hhZG93ID0gJ25vbmUnO1xyXG4gICAgaWYgKG9wdHMuc2hhZG93ID09PSB0cnVlKSB7XHJcbiAgICAgICAgc2hhZG93ID0gJzAgMnB4IDRweCAjMDAwJzsgLy8gZGVmYXVsdCBzaGFkb3dcclxuICAgIH1cclxuICAgIGVsc2UgaWYgKHR5cGVvZiBvcHRzLnNoYWRvdyA9PT0gJ3N0cmluZycpIHtcclxuICAgICAgICBzaGFkb3cgPSBvcHRzLnNoYWRvdztcclxuICAgIH1cclxuICAgIHZhciBzaGFkb3dzID0gcGFyc2VCb3hTaGFkb3coc2hhZG93KTtcclxuICAgIGZvciAodmFyIGkgPSAwOyBpIDwgb3B0cy5saW5lczsgaSsrKSB7XHJcbiAgICAgICAgdmFyIGRlZ3JlZXMgPSB+figzNjAgLyBvcHRzLmxpbmVzICogaSArIG9wdHMucm90YXRlKTtcclxuICAgICAgICB2YXIgYmFja2dyb3VuZExpbmUgPSBjc3MoZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2JyksIHtcclxuICAgICAgICAgICAgcG9zaXRpb246ICdhYnNvbHV0ZScsXHJcbiAgICAgICAgICAgIHRvcDogLW9wdHMud2lkdGggLyAyICsgXCJweFwiLFxyXG4gICAgICAgICAgICB3aWR0aDogKG9wdHMubGVuZ3RoICsgb3B0cy53aWR0aCkgKyAncHgnLFxyXG4gICAgICAgICAgICBoZWlnaHQ6IG9wdHMud2lkdGggKyAncHgnLFxyXG4gICAgICAgICAgICBiYWNrZ3JvdW5kOiBnZXRDb2xvcihvcHRzLmZhZGVDb2xvciwgaSksXHJcbiAgICAgICAgICAgIGJvcmRlclJhZGl1czogYm9yZGVyUmFkaXVzLFxyXG4gICAgICAgICAgICB0cmFuc2Zvcm1PcmlnaW46ICdsZWZ0JyxcclxuICAgICAgICAgICAgdHJhbnNmb3JtOiBcInJvdGF0ZShcIiArIGRlZ3JlZXMgKyBcImRlZykgdHJhbnNsYXRlWChcIiArIG9wdHMucmFkaXVzICsgXCJweClcIixcclxuICAgICAgICB9KTtcclxuICAgICAgICB2YXIgZGVsYXkgPSBpICogb3B0cy5kaXJlY3Rpb24gLyBvcHRzLmxpbmVzIC8gb3B0cy5zcGVlZDtcclxuICAgICAgICBkZWxheSAtPSAxIC8gb3B0cy5zcGVlZDsgLy8gc28gaW5pdGlhbCBhbmltYXRpb24gc3RhdGUgd2lsbCBpbmNsdWRlIHRyYWlsXHJcbiAgICAgICAgdmFyIGxpbmUgPSBjc3MoZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2JyksIHtcclxuICAgICAgICAgICAgd2lkdGg6ICcxMDAlJyxcclxuICAgICAgICAgICAgaGVpZ2h0OiAnMTAwJScsXHJcbiAgICAgICAgICAgIGJhY2tncm91bmQ6IGdldENvbG9yKG9wdHMuY29sb3IsIGkpLFxyXG4gICAgICAgICAgICBib3JkZXJSYWRpdXM6IGJvcmRlclJhZGl1cyxcclxuICAgICAgICAgICAgYm94U2hhZG93OiBub3JtYWxpemVTaGFkb3coc2hhZG93cywgZGVncmVlcyksXHJcbiAgICAgICAgICAgIGFuaW1hdGlvbjogMSAvIG9wdHMuc3BlZWQgKyBcInMgbGluZWFyIFwiICsgZGVsYXkgKyBcInMgaW5maW5pdGUgXCIgKyBvcHRzLmFuaW1hdGlvbixcclxuICAgICAgICB9KTtcclxuICAgICAgICBiYWNrZ3JvdW5kTGluZS5hcHBlbmRDaGlsZChsaW5lKTtcclxuICAgICAgICBlbC5hcHBlbmRDaGlsZChiYWNrZ3JvdW5kTGluZSk7XHJcbiAgICB9XHJcbn1cclxuZnVuY3Rpb24gcGFyc2VCb3hTaGFkb3coYm94U2hhZG93KSB7XHJcbiAgICB2YXIgcmVnZXggPSAvXlxccyooW2EtekEtWl0rXFxzKyk/KC0/XFxkKyhcXC5cXGQrKT8pKFthLXpBLVpdKilcXHMrKC0/XFxkKyhcXC5cXGQrKT8pKFthLXpBLVpdKikoLiopJC87XHJcbiAgICB2YXIgc2hhZG93cyA9IFtdO1xyXG4gICAgZm9yICh2YXIgX2kgPSAwLCBfYSA9IGJveFNoYWRvdy5zcGxpdCgnLCcpOyBfaSA8IF9hLmxlbmd0aDsgX2krKykge1xyXG4gICAgICAgIHZhciBzaGFkb3cgPSBfYVtfaV07XHJcbiAgICAgICAgdmFyIG1hdGNoZXMgPSBzaGFkb3cubWF0Y2gocmVnZXgpO1xyXG4gICAgICAgIGlmIChtYXRjaGVzID09PSBudWxsKSB7XHJcbiAgICAgICAgICAgIGNvbnRpbnVlOyAvLyBpbnZhbGlkIHN5bnRheFxyXG4gICAgICAgIH1cclxuICAgICAgICB2YXIgeCA9ICttYXRjaGVzWzJdO1xyXG4gICAgICAgIHZhciB5ID0gK21hdGNoZXNbNV07XHJcbiAgICAgICAgdmFyIHhVbml0cyA9IG1hdGNoZXNbNF07XHJcbiAgICAgICAgdmFyIHlVbml0cyA9IG1hdGNoZXNbN107XHJcbiAgICAgICAgaWYgKHggPT09IDAgJiYgIXhVbml0cykge1xyXG4gICAgICAgICAgICB4VW5pdHMgPSB5VW5pdHM7XHJcbiAgICAgICAgfVxyXG4gICAgICAgIGlmICh5ID09PSAwICYmICF5VW5pdHMpIHtcclxuICAgICAgICAgICAgeVVuaXRzID0geFVuaXRzO1xyXG4gICAgICAgIH1cclxuICAgICAgICBpZiAoeFVuaXRzICE9PSB5VW5pdHMpIHtcclxuICAgICAgICAgICAgY29udGludWU7IC8vIHVuaXRzIG11c3QgbWF0Y2ggdG8gdXNlIGFzIGNvb3JkaW5hdGVzXHJcbiAgICAgICAgfVxyXG4gICAgICAgIHNoYWRvd3MucHVzaCh7XHJcbiAgICAgICAgICAgIHByZWZpeDogbWF0Y2hlc1sxXSB8fCAnJyxcclxuICAgICAgICAgICAgeDogeCxcclxuICAgICAgICAgICAgeTogeSxcclxuICAgICAgICAgICAgeFVuaXRzOiB4VW5pdHMsXHJcbiAgICAgICAgICAgIHlVbml0czogeVVuaXRzLFxyXG4gICAgICAgICAgICBlbmQ6IG1hdGNoZXNbOF0sXHJcbiAgICAgICAgfSk7XHJcbiAgICB9XHJcbiAgICByZXR1cm4gc2hhZG93cztcclxufVxyXG4vKipcclxuICogTW9kaWZ5IGJveC1zaGFkb3cgeC95IG9mZnNldHMgdG8gY291bnRlcmFjdCByb3RhdGlvblxyXG4gKi9cclxuZnVuY3Rpb24gbm9ybWFsaXplU2hhZG93KHNoYWRvd3MsIGRlZ3JlZXMpIHtcclxuICAgIHZhciBub3JtYWxpemVkID0gW107XHJcbiAgICBmb3IgKHZhciBfaSA9IDAsIHNoYWRvd3NfMSA9IHNoYWRvd3M7IF9pIDwgc2hhZG93c18xLmxlbmd0aDsgX2krKykge1xyXG4gICAgICAgIHZhciBzaGFkb3cgPSBzaGFkb3dzXzFbX2ldO1xyXG4gICAgICAgIHZhciB4eSA9IGNvbnZlcnRPZmZzZXQoc2hhZG93LngsIHNoYWRvdy55LCBkZWdyZWVzKTtcclxuICAgICAgICBub3JtYWxpemVkLnB1c2goc2hhZG93LnByZWZpeCArIHh5WzBdICsgc2hhZG93LnhVbml0cyArICcgJyArIHh5WzFdICsgc2hhZG93LnlVbml0cyArIHNoYWRvdy5lbmQpO1xyXG4gICAgfVxyXG4gICAgcmV0dXJuIG5vcm1hbGl6ZWQuam9pbignLCAnKTtcclxufVxyXG5mdW5jdGlvbiBjb252ZXJ0T2Zmc2V0KHgsIHksIGRlZ3JlZXMpIHtcclxuICAgIHZhciByYWRpYW5zID0gZGVncmVlcyAqIE1hdGguUEkgLyAxODA7XHJcbiAgICB2YXIgc2luID0gTWF0aC5zaW4ocmFkaWFucyk7XHJcbiAgICB2YXIgY29zID0gTWF0aC5jb3MocmFkaWFucyk7XHJcbiAgICByZXR1cm4gW1xyXG4gICAgICAgIE1hdGgucm91bmQoKHggKiBjb3MgKyB5ICogc2luKSAqIDEwMDApIC8gMTAwMCxcclxuICAgICAgICBNYXRoLnJvdW5kKCgteCAqIHNpbiArIHkgKiBjb3MpICogMTAwMCkgLyAxMDAwLFxyXG4gICAgXTtcclxufVxyXG4iLCJtb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uKCkge1xuXHR0aHJvdyBuZXcgRXJyb3IoXCJkZWZpbmUgY2Fubm90IGJlIHVzZWQgaW5kaXJlY3RcIik7XG59O1xuIiwiaW1wb3J0IHByb2Nlc3NBamF4RXJyb3JSZXNwb25zZSBmcm9tIFwiLi4vLi4vcGx1Z2lucy9wcm9jZXNzQWpheEVycm9yUmVzcG9uc2VcIjtcblxucmVxdWlyZSgnanF1ZXJ5Jyk7XG5yZXF1aXJlKCcuLi8uLi92ZW5kb3IvaXZpZXdlci5qcycpO1xucmVxdWlyZSgnLi4vLi4vcGx1Z2lucy9zaG93TG9hZGluZycpO1xuXG4oZnVuY3Rpb24gKCQpIHtcbiAgdmFyIGRlZmF1bHRPcHRpb25zID0ge1xuICAgIHF1ZXJ5TGluazogJycsXG4gICAgZG93bmxvYWRzTGluazogJycsXG4gICAgcmVBc3NpZ25MaW5rOiAnJyxcbiAgICBmZXRjaFJlc3VsdHNMaW5rOiAnJyxcbiAgICBpbWFnZUxpbms6ICcnLFxuICAgIHBkZkxpbms6ICcnLFxuICAgIGxvYWRpbmc6ICcnXG4gIH1cblxuICB2YXIgbG9hZGluZywgb3B0aW9ucztcblxuICAkLmZuLnBvZFNjcmlwdHMgPSBmdW5jdGlvbiAoY3VzdG9tT3B0aW9ucykge1xuICAgIG9wdGlvbnMgPSAkLmV4dGVuZCh7fSwgZGVmYXVsdE9wdGlvbnMsIGN1c3RvbU9wdGlvbnMpO1xuICAgIGxvYWRpbmcgPSBvcHRpb25zLmxvYWRpbmc7XG5cbiAgICB2YXIgcXVlcnlGb3JSZXN1bHRzID0gZnVuY3Rpb24gKHdheWJpbGxOdW1iZXIsIHR5cGUpIHtcblxuICAgICAgJC5hamF4KHtcbiAgICAgICAgdHlwZTogXCJHRVRcIixcbiAgICAgICAgdXJsOiBvcHRpb25zLnF1ZXJ5TGluayxcbiAgICAgICAgZGF0YToge3dheWJpbGxfbnVtYmVyOiB3YXliaWxsTnVtYmVyfSxcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24gKGRhdGEpIHtcbiAgICAgICAgICAkKGRhdGEpLmVhY2goZnVuY3Rpb24oaW5kZXgsIHdheWJpbGwpIHtcbiAgICAgICAgICAgIGZldGNoUmVzdWx0cyh3YXliaWxsLmlkLCB3YXliaWxsLnR5cGUpO1xuICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuICAgICAgICBlcnJvcjogZnVuY3Rpb24gKGpxWEhSKSB7XG4gICAgICAgICAgbG9hZGluZy5zdG9wKCk7XG4gICAgICAgICAgcHJvY2Vzc0FqYXhFcnJvclJlc3BvbnNlKGpxWEhSKTtcbiAgICAgICAgfVxuICAgICAgfSk7XG4gICAgfVxuXG4gICAgdmFyIGZldGNoUmVzdWx0cyA9IGZ1bmN0aW9uIChpZCwgdHlwZSkge1xuICAgICAgdmFyIHJlc3VsdHNBcmVhID0gJCgnI3BvZFJlc3VsdCcpLFxuICAgICAgICByZXN1bHRUYWJzID0gJCgnI3Jlc3VsdFRhYnMnKTtcbiAgICAgICQuYWpheCh7XG4gICAgICAgIHR5cGU6IFwiR0VUXCIsXG4gICAgICAgIHVybDogb3B0aW9ucy5mZXRjaFJlc3VsdHNMaW5rLFxuICAgICAgICBkYXRhOiB7d2F5YmlsbF9udW1iZXI6IGlkfSxcbiAgICAgICAgYmVmb3JlU2VuZDogZnVuY3Rpb24gKCkge1xuICAgICAgICAgIHJlc3VsdHNBcmVhLmVtcHR5KCk7XG4gICAgICAgICAgcmVzdWx0VGFicy5lbXB0eSgpO1xuICAgICAgICB9LFxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbiAoZGF0YSkge1xuICAgICAgICAgIHZhciBpZCwgaW1nQXJlYSwgaW1nTmF2LCBpbWdOYXZBLCBkb3dubG9hZExpbmssIHJlQXNzaWduTGluaztcblxuICAgICAgICAgIGxvYWRpbmcuc3RvcCgpO1xuICAgICAgICAgIGVuYWJsZUJ1dHRvbnMoKTtcblxuICAgICAgICAgICQoZGF0YSkuZWFjaChmdW5jdGlvbiAoaW5kZXgsIHJlc3VsdCkge1xuICAgICAgICAgICAgaW5kZXggPSBpbmRleCArIDE7XG4gICAgICAgICAgICBmb3IgKGxldCBwYWdlID0gMTsgcGFnZSA8PSByZXN1bHQucGFnZXM7IHBhZ2UrKykge1xuICAgICAgICAgICAgICBsZXQgZG9jdW1lbnQgPSB3aW5kb3cuZG9jdW1lbnQ7XG4gICAgICAgICAgICAgIGlkID0gYHJlc3VsdC0ke2luZGV4fS0ke3BhZ2V9YDtcbiAgICAgICAgICAgICAgaW1nQXJlYSA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2RpdicpO1xuICAgICAgICAgICAgICBpbWdOYXYgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdsaScpO1xuICAgICAgICAgICAgICBpbWdOYXZBID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnYScpO1xuICAgICAgICAgICAgICBkb3dubG9hZExpbmsgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdhJyk7XG4gICAgICAgICAgICAgIHJlQXNzaWduTGluayA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2EnKTtcblxuICAgICAgICAgICAgICBpbWdBcmVhLmlkID0gaWQ7XG4gICAgICAgICAgICAgIGltZ0FyZWEuY2xhc3NOYW1lID0gKGluZGV4ID09IDEgJiYgcGFnZSA9PT0gMSkgPyBcInZpZXdlciBhY3RpdmVcIiA6IFwidmlld2VyXCI7XG5cbiAgICAgICAgICAgICAgaW1nTmF2QS5jbGFzc05hbWUgPSAoaW5kZXggPT0gMSAmJiBwYWdlID09IDEpID8gXCJuYXYtbGluayBhY3RpdmVcIiA6IFwibmF2LWxpbmtcIjtcbiAgICAgICAgICAgICAgaW1nTmF2QS5zZXRBdHRyaWJ1dGUoJ2RhdGEtdG9nZ2xlJywgJ3RhYicpO1xuICAgICAgICAgICAgICBpbWdOYXZBLnNldEF0dHJpYnV0ZSgnaHJlZicsICcjJyArIGlkKTtcbiAgICAgICAgICAgICAgaW1nTmF2QS50ZXh0Q29udGVudCA9IGBJbWFnZSAke2luZGV4fSAtIFBhZ2UgJHtwYWdlfWA7XG5cbiAgICAgICAgICAgICAgaW1nTmF2LmNsYXNzTmFtZSA9IFwibmF2LWl0ZW1cIjtcbiAgICAgICAgICAgICAgaW1nTmF2LmFwcGVuZENoaWxkKGltZ05hdkEpO1xuXG4gICAgICAgICAgICAgIHJlc3VsdFRhYnMuYXBwZW5kKGltZ05hdik7XG4gICAgICAgICAgICAgIHJlc3VsdHNBcmVhLmFwcGVuZChpbWdBcmVhKTtcblxuICAgICAgICAgICAgICAkKFwiI1wiICsgaWQpLml2aWV3ZXIoe1xuICAgICAgICAgICAgICAgIHNyYzogb3B0aW9ucy5pbWFnZUxpbmsucmVwbGFjZSgnLTEnLCByZXN1bHQuaWQpLnJlcGxhY2UoJy0xJywgcGFnZSksXG4gICAgICAgICAgICAgICAgem9vbTogNTBcbiAgICAgICAgICAgICAgfSk7XG5cbiAgICAgICAgICAgICAgZG93bmxvYWRMaW5rLnNldEF0dHJpYnV0ZSgnaHJlZicsIGNoYW5nZVVybFJlc291cmNlKG9wdGlvbnMuZG93bmxvYWRzTGluaywgcmVzdWx0LmlkKSk7XG4gICAgICAgICAgICAgIGRvd25sb2FkTGluay5zZXRBdHRyaWJ1dGUoJ3RhcmdldCcsICdfYmxhbmsnKTtcbiAgICAgICAgICAgICAgZG93bmxvYWRMaW5rLnNldEF0dHJpYnV0ZSgnY2xhc3MnLCAncG9kX19kb3dubG9hZC1saW5rIGJ0biBidG4tc20gYnRuLXN1Y2Nlc3MnKTtcbiAgICAgICAgICAgICAgZG93bmxvYWRMaW5rLnRleHRDb250ZW50ID0gXCJEb3dubG9hZFwiO1xuXG4gICAgICAgICAgICAgIHJlQXNzaWduTGluay5zZXRBdHRyaWJ1dGUoJ2hyZWYnLCBvcHRpb25zLnJlQXNzaWduTGluayArICc/aW1hZ2VOYW1lPScgKyByZXN1bHQuaW1hZ2VOYW1lICsgJyZ0eXBlPScgKyByZXN1bHQudHlwZSk7XG4gICAgICAgICAgICAgIHJlQXNzaWduTGluay5zZXRBdHRyaWJ1dGUoJ3RhcmdldCcsICdfYmxhbmsnKTtcbiAgICAgICAgICAgICAgcmVBc3NpZ25MaW5rLnNldEF0dHJpYnV0ZSgnY2xhc3MnLCAncG9kX19yZWFzc2lnbi1saW5rIGJ0biBidG4tc20gYnRuLXByaW1hcnknKTtcbiAgICAgICAgICAgICAgcmVBc3NpZ25MaW5rLnRleHRDb250ZW50ID0gXCJSZS1Bc3NpZ24gVHlwZVwiO1xuXG4gICAgICAgICAgICAgIGltZ0FyZWEuYXBwZW5kQ2hpbGQoZG93bmxvYWRMaW5rKTtcbiAgICAgICAgICAgICAgaW1nQXJlYS5hcHBlbmRDaGlsZChyZUFzc2lnbkxpbmspO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH0pO1xuICAgICAgICB9LFxuICAgICAgICBlcnJvcjogZnVuY3Rpb24gKGpxWEhSKSB7XG4gICAgICAgICAgbG9hZGluZy5zdG9wKCk7XG4gICAgICAgICAgcHJvY2Vzc0FqYXhFcnJvclJlc3BvbnNlKGpxWEhSKTtcbiAgICAgICAgfSwgc3RhdHVzQ29kZToge1xuICAgICAgICAgIDQwNDogZnVuY3Rpb24oKSB7XG4gICAgICAgICAgICBmZXRjaFBERihpZClcbiAgICAgICAgICB9XG4gICAgICAgIH1cbiAgICAgIH0pO1xuICAgIH1cblxuICAgIHZhciBmZXRjaFBERiA9IGZ1bmN0aW9uIChpZCkge1xuICAgICAgdmFyIHJlc3VsdHNBcmVhID0gJCgnI3BvZFJlc3VsdCcpO1xuXG4gICAgICByZXN1bHRzQXJlYS5lbXB0eSgpO1xuICAgICAgbG9hZGluZy5zdG9wKCk7XG4gICAgICBlbmFibGVCdXR0b25zKCk7XG5cbiAgICAgIHZhciBpbWdBcmVhID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnaWZyYW1lJyk7XG4gICAgICBpbWdBcmVhLnNyYyA9IG9wdGlvbnMucGRmTGluayArICcvP3dheWJpbGxfbnVtYmVyPScgKyBpZDtcbiAgICAgIGltZ0FyZWEuY2xhc3NOYW1lID0gXCJwZGYtdmlld2VyXCI7XG4gICAgICByZXN1bHRzQXJlYS5hcHBlbmQoaW1nQXJlYSk7XG4gICAgfTtcblxuXG4gICAgdmFyIGVuYWJsZUJ1dHRvbnMgPSBmdW5jdGlvbigpIHtcbiAgICAgICQoJyNwb2RBc3NpZ25CdXR0b24nKS5wcm9wKCdkaXNhYmxlZCcsIGZhbHNlKTtcbiAgICAgICQoJyNwb2RSZXBsYWNlQnV0dG9uJykucHJvcCgnZGlzYWJsZWQnLCBmYWxzZSk7XG4gICAgICAkKCcjcG9kVXBsb2FkQnV0dG9uJykucHJvcCgnZGlzYWJsZWQnLCBmYWxzZSk7XG4gICAgfTtcblxuICAgIHJldHVybiB7XG4gICAgICBxdWVyeUZvclJlc3VsdHM6IHF1ZXJ5Rm9yUmVzdWx0cyxcbiAgICAgIGZldGNoUmVzdWx0czogZmV0Y2hSZXN1bHRzLFxuICAgICAgZmV0Y2hQZGY6IGZldGNoUERGLFxuICAgIH07XG4gIH1cbn0pKGpRdWVyeSk7XG4iLCJsZXQgY3JlYXRlQWxlcnQgPSBmdW5jdGlvbiAoY3VzdG9tT3B0aW9ucyA9IHt9KSB7XG4gIHZhciBkZWZhdWx0T3B0aW9ucyA9IHtcbiAgICBtZXNzYWdlOiBcIlwiLFxuICAgIHR5cGU6IFwiZGFuZ2VyXCIsXG4gICAgZGlzbWlzc2FibGU6IHRydWUsXG4gICAgaHRtbDogZmFsc2UsXG4gIH07XG5cbiAgdmFyIG9wdGlvbnMgPSBPYmplY3QuYXNzaWduKHt9LCBkZWZhdWx0T3B0aW9ucywgY3VzdG9tT3B0aW9ucyk7XG5cbiAgdmFyIGNsb3NlQnV0dG9uID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnYScpLFxuICAgIGFsZXJ0ID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnZGl2JyksXG4gICAgd3JhcHBlciA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdhbGVydHMnKTtcblxuICBjbG9zZUJ1dHRvbi5jbGFzc05hbWUgPSAnY2xvc2UnO1xuICBjbG9zZUJ1dHRvbi5zZXRBdHRyaWJ1dGUoJ2RhdGEtZGlzbWlzcycsICdhbGVydCcpO1xuICBjbG9zZUJ1dHRvbi5pbm5lclRleHQgPSAnw5cnO1xuICBhbGVydC5jbGFzc05hbWUgPSAnYWxlcnQgYWxlcnQtJytvcHRpb25zLnR5cGU7XG5cbiAgaWYgKG9wdGlvbnMuaHRtbCkge1xuICAgIGFsZXJ0LmlubmVySFRNTCA9IG9wdGlvbnMubWVzc2FnZTtcbiAgfSBlbHNlIHtcbiAgICBhbGVydC5pbm5lclRleHQgPSBvcHRpb25zLm1lc3NhZ2U7XG4gIH1cblxuICBpZihvcHRpb25zLmRpc21pc3NhYmxlKSB7XG4gICAgYWxlcnQuYXBwZW5kQ2hpbGQoY2xvc2VCdXR0b24pO1xuICB9XG5cbiAgd3JhcHBlci5hcHBlbmRDaGlsZChhbGVydCk7XG59O1xuXG5leHBvcnQgZGVmYXVsdCBjcmVhdGVBbGVydDtcbiIsImltcG9ydCBjcmVhdGVBbGVydCBmcm9tIFwiLi9jcmVhdGVBbGVydFwiO1xuaW1wb3J0IHRvYXN0ciBmcm9tIFwidG9hc3RyXCI7XG5cbmxldCBwcm9jZXNzQWpheFJlc3BvbnNlID0gZnVuY3Rpb24gKHJlc3BvbnNlLCB1c2VUb2FzdHIpIHtcbiAgXCJ1c2Ugc3RyaWN0XCJcbiAgdXNlVG9hc3RyID0gdXNlVG9hc3RyIHx8IGZhbHNlO1xuXG4gIHZhciBzaG93RXJyb3IgPSBmdW5jdGlvbiAobWVzc2FnZSkge1xuICAgIGlmICh1c2VUb2FzdHIpIHtcbiAgICAgIHRvYXN0ci5lcnJvcihtZXNzYWdlKTtcbiAgICB9IGVsc2Uge1xuICAgICAgY3JlYXRlQWxlcnQoe3R5cGU6ICdkYW5nZXInLCBtZXNzYWdlOiBtZXNzYWdlfSk7XG4gICAgfVxuICB9XG5cbiAgaWYodHlwZW9mIHJlc3BvbnNlICE9PSAndW5kZWZpbmVkJykge1xuICAgIC8vIEhhbmRsZSBUb2tlbk1pc21hdGNoXG4gICAgaWYgKHJlc3BvbnNlLnN0YXR1cyA9PT0gNDE5KSB7XG4gICAgICBzaG93RXJyb3IoXCJZb3VyIHJlcXVlc3QgdGltZWQgb3V0LCBwbGVhc2UgcmVmcmVzaCB0aGUgcGFnZSBhbmQgdHJ5IGFnYWluLlwiKTtcblxuICAgICAgcmV0dXJuO1xuICAgIH1cbiAgICB2YXIgZXJyb3IgPSB7fTtcbiAgICBpZiAocmVzcG9uc2UuaGFzT3duUHJvcGVydHkoJ3Jlc3BvbnNlVGV4dCcpKSB7XG4gICAgICAvLyBUaGUgd2ViIHNlcnZlciAoYXBhY2hlLCBoYXByb3h5KSByZXR1cm5lZCBhbiBlcnJvciBwYWdlXG4gICAgICBpZiAocmVzcG9uc2UucmVzcG9uc2VUZXh0LnN1YnN0cigwLDEpID09PSAnPCcpIHtcbiAgICAgICAgZXJyb3IgPSBbJ1NlcnZlciBlcnJvciddO1xuICAgICAgfSBlbHNlIHtcbiAgICAgICAgdmFyIHRleHQgPSBKU09OLnBhcnNlKHJlc3BvbnNlLnJlc3BvbnNlVGV4dCk7XG4gICAgICAgIGVycm9yID0gdGV4dC5oYXNPd25Qcm9wZXJ0eSgnZXJyb3InKSA/IHRleHQuZXJyb3IgOiBbdGV4dC5tZXNzYWdlXTtcbiAgICAgIH1cbiAgICB9XG5cbiAgICBpZiAodHlwZW9mIGVycm9yID09PSAnb2JqZWN0JyAmJiBlcnJvci5sZW5ndGgpIHtcbiAgICAgIGZvciAobGV0IHZhbHVlIG9mIGVycm9yKSB7XG4gICAgICAgIHNob3dFcnJvcih2YWx1ZSk7XG4gICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgIGxldCBtZXNzYWdlcyA9IGVycm9yLm1lc3NhZ2Uuc3BsaXQoL1xcLiB8LC8pLnJldmVyc2UoKTtcbiAgICAgIGZvcihsZXQgbWVzc2FnZSBvZiBtZXNzYWdlcyl7XG4gICAgICAgICAgc2hvd0Vycm9yKG1lc3NhZ2UudHJpbSgpKTtcbiAgICAgIH1cbiAgICB9XG4gIH1cbn07XG5cbmV4cG9ydCBkZWZhdWx0IHByb2Nlc3NBamF4UmVzcG9uc2U7XG4iLCJpbXBvcnQge1NwaW5uZXJ9IGZyb20gXCJzcGluLmpzXCI7XG5yZXF1aXJlKCdqcXVlcnknKTtcblxuKGZ1bmN0aW9uICgkKSB7XG4gIHZhciBkZWZhdWx0T3B0aW9ucyA9IHtcbiAgICBsaW5lczogMTUsIC8vIFRoZSBudW1iZXIgb2YgbGluZXMgdG8gZHJhd1xuICAgIGxlbmd0aDogNDAsIC8vIFRoZSBsZW5ndGggb2YgZWFjaCBsaW5lXG4gICAgd2lkdGg6IDEwLCAvLyBUaGUgbGluZSB0aGlja25lc3NcbiAgICByYWRpdXM6IDQ1LCAvLyBUaGUgcmFkaXVzIG9mIHRoZSBpbm5lciBjaXJjbGVcbiAgICBjb3JuZXJzOiAxLCAvLyBDb3JuZXIgcm91bmRuZXNzICgwLi4xKVxuICAgIHJvdGF0ZTogMCwgLy8gVGhlIHJvdGF0aW9uIG9mZnNldFxuICAgIGRpcmVjdGlvbjogMSwgLy8gMTogY2xvY2t3aXNlLCAtMTogY291bnRlcmNsb2Nrd2lzZVxuICAgIGNvbG9yOiAnIzg0ODQ4NCcsIC8vICNyZ2Igb3IgI3JyZ2diYiBvciBhcnJheSBvZiBjb2xvcnNcbiAgICBzcGVlZDogMSwgLy8gUm91bmRzIHBlciBzZWNvbmRcbiAgICBzaGFkb3c6IHRydWUsIC8vIFdoZXRoZXIgdG8gcmVuZGVyIGEgc2hhZG93XG4gICAgY2xhc3NOYW1lOiAnc3Bpbm5lcicsIC8vIFRoZSBDU1MgY2xhc3MgdG8gYXNzaWduIHRvIHRoZSBzcGlubmVyXG4gICAgekluZGV4OiAyMDAwMDAwMCwgLy8gVGhlIHotaW5kZXggKGRlZmF1bHRzIHRvIDIwMDAwMDAwMDApXG4gICAgdG9wOiAnNTAlJywgLy8gVG9wIHBvc2l0aW9uIHJlbGF0aXZlIHRvIHBhcmVudFxuICAgIGxlZnQ6ICc1MCUnLCAvLyBMZWZ0IHBvc2l0aW9uIHJlbGF0aXZlIHRvIHBhcmVudFxuICAgIHBvc2l0aW9uIDogJ2ZpeGVkJyxcbiAgfTtcblxuICAkLmZuLnNob3dMb2FkaW5nID0gZnVuY3Rpb24gKGN1c3RvbU9wdGlvbnMpIHtcblxuICAgIHZhciBvcHRpb25zID0gJC5leHRlbmQoe30sIGRlZmF1bHRPcHRpb25zLCBjdXN0b21PcHRpb25zKTtcblxuICAgICAgdmFyIGVsZW1lbnQgPSB0aGlzWzBdIHx8IGRvY3VtZW50LmJvZHk7XG4gICAgICB2YXIgc3Bpbm5lciA9IG5ldyBTcGlubmVyKG9wdGlvbnMpLnNwaW4oZWxlbWVudCk7XG5cbiAgICAgIHJldHVybiBzcGlubmVyO1xuICB9O1xuXG5cbn0pKGpRdWVyeSk7XG4iLCJyZXF1aXJlKCdqcXVlcnknKTtcbnJlcXVpcmUoJ2pxdWVyeS11aS91aS93aWRnZXQnKTtcbnJlcXVpcmUoJ2pxdWVyeS11aS91aS93aWRnZXRzL21vdXNlJyk7XG5yZXF1aXJlKCdqcXVlcnktbW91c2V3aGVlbCcpO1xucmVxdWlyZSgnaXZpZXdlci9qcXVlcnkuaXZpZXdlcicpO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==