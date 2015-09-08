jQuery.easing["jswing"] = jQuery.easing["swing"]; jQuery.extend(jQuery.easing, { def: "easeOutQuad", swing: function (e, t, n, r, i) { return jQuery.easing[jQuery.easing.def](e, t, n, r, i) }, easeInQuad: function (e, t, n, r, i) { return r * (t /= i) * t + n }, easeOutQuad: function (e, t, n, r, i) { return -r * (t /= i) * (t - 2) + n }, easeInOutQuad: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t + n; return -r / 2 * (--t * (t - 2) - 1) + n }, easeInCubic: function (e, t, n, r, i) { return r * (t /= i) * t * t + n }, easeOutCubic: function (e, t, n, r, i) { return r * ((t = t / i - 1) * t * t + 1) + n }, easeInOutCubic: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t + n; return r / 2 * ((t -= 2) * t * t + 2) + n }, easeInQuart: function (e, t, n, r, i) { return r * (t /= i) * t * t * t + n }, easeOutQuart: function (e, t, n, r, i) { return -r * ((t = t / i - 1) * t * t * t - 1) + n }, easeInOutQuart: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t * t + n; return -r / 2 * ((t -= 2) * t * t * t - 2) + n }, easeInQuint: function (e, t, n, r, i) { return r * (t /= i) * t * t * t * t + n }, easeOutQuint: function (e, t, n, r, i) { return r * ((t = t / i - 1) * t * t * t * t + 1) + n }, easeInOutQuint: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return r / 2 * t * t * t * t * t + n; return r / 2 * ((t -= 2) * t * t * t * t + 2) + n }, easeInSine: function (e, t, n, r, i) { return -r * Math.cos(t / i * (Math.PI / 2)) + r + n }, easeOutSine: function (e, t, n, r, i) { return r * Math.sin(t / i * (Math.PI / 2)) + n }, easeInOutSine: function (e, t, n, r, i) { return -r / 2 * (Math.cos(Math.PI * t / i) - 1) + n }, easeInExpo: function (e, t, n, r, i) { return t == 0 ? n : r * Math.pow(2, 10 * (t / i - 1)) + n }, easeOutExpo: function (e, t, n, r, i) { return t == i ? n + r : r * (-Math.pow(2, -10 * t / i) + 1) + n }, easeInOutExpo: function (e, t, n, r, i) { if (t == 0) return n; if (t == i) return n + r; if ((t /= i / 2) < 1) return r / 2 * Math.pow(2, 10 * (t - 1)) + n; return r / 2 * (-Math.pow(2, -10 * --t) + 2) + n }, easeInCirc: function (e, t, n, r, i) { return -r * (Math.sqrt(1 - (t /= i) * t) - 1) + n }, easeOutCirc: function (e, t, n, r, i) { return r * Math.sqrt(1 - (t = t / i - 1) * t) + n }, easeInOutCirc: function (e, t, n, r, i) { if ((t /= i / 2) < 1) return -r / 2 * (Math.sqrt(1 - t * t) - 1) + n; return r / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + n }, easeInElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i) == 1) return n + r; if (!o) o = i * .3; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); return -(u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o)) + n }, easeOutElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i) == 1) return n + r; if (!o) o = i * .3; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); return u * Math.pow(2, -10 * t) * Math.sin((t * i - s) * 2 * Math.PI / o) + r + n }, easeInOutElastic: function (e, t, n, r, i) { var s = 1.70158; var o = 0; var u = r; if (t == 0) return n; if ((t /= i / 2) == 2) return n + r; if (!o) o = i * .3 * 1.5; if (u < Math.abs(r)) { u = r; var s = o / 4 } else var s = o / (2 * Math.PI) * Math.asin(r / u); if (t < 1) return -.5 * u * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) + n; return u * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * i - s) * 2 * Math.PI / o) * .5 + r + n }, easeInBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; return r * (t /= i) * t * ((s + 1) * t - s) + n }, easeOutBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; return r * ((t = t / i - 1) * t * ((s + 1) * t + s) + 1) + n }, easeInOutBack: function (e, t, n, r, i, s) { if (s == undefined) s = 1.70158; if ((t /= i / 2) < 1) return r / 2 * t * t * (((s *= 1.525) + 1) * t - s) + n; return r / 2 * ((t -= 2) * t * (((s *= 1.525) + 1) * t + s) + 2) + n }, easeInBounce: function (e, t, n, r, i) { return r - jQuery.easing.easeOutBounce(e, i - t, 0, r, i) + n }, easeOutBounce: function (e, t, n, r, i) { if ((t /= i) < 1 / 2.75) { return r * 7.5625 * t * t + n } else if (t < 2 / 2.75) { return r * (7.5625 * (t -= 1.5 / 2.75) * t + .75) + n } else if (t < 2.5 / 2.75) { return r * (7.5625 * (t -= 2.25 / 2.75) * t + .9375) + n } else { return r * (7.5625 * (t -= 2.625 / 2.75) * t + .984375) + n } }, easeInOutBounce: function (e, t, n, r, i) { if (t < i / 2) return jQuery.easing.easeInBounce(e, t * 2, 0, r, i) * .5 + n; return jQuery.easing.easeOutBounce(e, t * 2 - i, 0, r, i) * .5 + r * .5 + n } })

CRPTiledLayerType = {};
CRPTiledLayerType.Puzzle = 1;
CRPTiledLayerType.Masonry = 2;
CRPTiledLayerType.Square = 3;


;(function ($) {

  $.fn.visible = function(partial) {

    	if(! $(this).offset())
    		return true;

      var $t            = $(this),
          $w            = $(window),
          viewTop       = $w.scrollTop(),
          viewBottom    = viewTop + $w.height(),
          _top          = $t.offset().top,
          _bottom       = _top + $t.height(),
          compareTop    = partial === true ? _bottom : _top,
          compareBottom = partial === true ? _top : _bottom;

    return ((compareBottom <= viewBottom) && (compareTop >= viewTop));

  };

    $.crpTiledLayer = function (element, options) {
        if(options.approxTileWidth < options.minTileWidth){
            options.approxTileWidth = options.minTileWidth;
        }

        function supportsTransitions() {

            var b = document.body || document.documentElement;
            var s = b.style;
            var p = 'transition';
            if (typeof s[p] == 'string') { return true; }

            // Tests for vendor specific prop
            v = ['Moz', 'Webkit', 'Khtml', 'O', 'ms'],
            p = p.charAt(0).toUpperCase() + p.substr(1);
            for (var i = 0; i < v.length; i++) {
                if (typeof s[v[i] + p] == 'string') { return true; }
            }
            return false;
        }

        var Slot = function (cell_size, width, height) {
            this.position = { x: 0, y: 0 };
            this.blocks = { h: Math.floor(width / cell_size), v: Math.floor(height / cell_size) };
            this.size = { width: this.blocks.h * cell_size, height: this.blocks.v * cell_size };
            this.px = { width: width, height: height };
            this.cell_size = cell_size;
            this.edge_right = false;
        }

        Slot.prototype.resize = function (blocks, onlyWidth) {
            //nw : nh = w : h => nh = nw * h / w
            var new_width = blocks * this.cell_size;
            var new_height = (new_width * this.px.height) / this.px.width;
            var bv = this.blocks.v;
            this.blocks.h = blocks;
            if(!onlyWidth && plugin.settings.layoutType != CRPTiledLayerType.Square)
	            this.blocks.v = Math.floor(new_height / this.cell_size);
            }

        var Grid = function (cell_size, margin, min_tile_width, width) {
            this.slots = [];
            this.cells = [];
            this.margin = margin;
            this.min_tile_width = min_tile_width;
            this.cell_size = cell_size;
            this.width = width;
            this.hor_size = Math.floor(width / cell_size);
            this.init();
        }

        Grid.prototype.init = function () {
            this.slots.length = 0;
            this.cells.length = 0;
            for (var i = 0; i < this.hor_size * 100; i++) {
                this.cells[i] = 0;
            }
        }

        Grid.prototype.add_slot = function (slot) {
            for (var j = 0; j < slot.blocks.v; j++) {
                for (var i = 0; i < slot.blocks.h; i++) {
                    var row = slot.position.y + j;
                    var column = slot.position.x + i;
                    //if (this.cells.length < row * this.hor_size + column)

                    this.cells[row * this.hor_size + column] = 1;
                    this.cells.push(0);
                }
            }

            this.slots.push(slot);
        }

        Grid.prototype.count_free_cells_on_right = function (index) {
            var line = Math.floor(index / this.hor_size);
            var line_end = (line + 1) * this.hor_size;

            var length = 0;

            for (; index < line_end; index++, length++) {
                if (this.cells[index] == 1) {
                    break;
                }
            }

            return length;
        }

        Grid.prototype.insert = function (width, height, allowEnlargement) {

            /* Hack */
            var sW = width;
            var sH = height;
            if(plugin.settings.layoutType == CRPTiledLayerType.Masonry || plugin.settings.layoutType == CRPTiledLayerType.Square){
                var _slotWidth = plugin.settings.approxTileWidth + plugin.settings.margin;
                var _wrapperWidth = $element.width();
                if(_slotWidth > _wrapperWidth - plugin.settings.margin){
                    _slotWidth = _wrapperWidth - plugin.settings.margin;
                }

                var _itemsPerRow = parseInt( _wrapperWidth / _slotWidth );
                var _delta = _wrapperWidth - _itemsPerRow * _slotWidth;
                var _deltaPerCell = Math.floor(_delta / _itemsPerRow);
                _slotWidth += _deltaPerCell;

                var _ratio = height / width;
                sW = _slotWidth;
                sH = plugin.settings.layoutType == CRPTiledLayerType.Masonry ? sW * _ratio : sW;
            }

            var slot = new Slot(this.cell_size, sW, sH);
            var av_blocks = 0;
            var free_cell = 0;
            var line = 0;

            if (this.slots.length == 0) {
                av_blocks = this.hor_size;
                slot.position.x = 0;
                slot.position.y = 0;
            } else {

                //find first available cell
                var exit = false;
                for (; free_cell < this.cells.length; free_cell++) {
                    if (this.cells[free_cell] == 0) {

                        line = Math.floor(free_cell / this.hor_size);
                        var line_end = (line + 1) * this.hor_size;

                        //available blocks
                        av_blocks = 0;
                        for (var k = 0; k <= line_end - free_cell; k++) {
                            av_blocks = k;
                            if (this.cells[free_cell + k] == 1) {
                                //there's another slot on the right
                                break;
                            }
                        }
                        break;
                    }
                }
            }
            //the slot need to be shrinked
            if (av_blocks < slot.blocks.h) {
                slot.resize(av_blocks);
            } else {
                var free_on_right = this.count_free_cells_on_right(free_cell + slot.blocks.h);
                if (free_on_right * this.cell_size - plugin.settings.margin < this.min_tile_width &&
                		free_on_right > 0) {
                    slot.resize(av_blocks, !allowEnlargement);
                    slot.enlarged = true;
                }
                if (free_on_right == 0)
                    slot.edge_right = true;
            }

            slot.position.x = free_cell % this.hor_size;
            slot.position.y = Math.floor(free_cell / this.hor_size);

            this.add_slot(slot);
            return slot;
        }

        //for debug purpouses
        Grid.prototype.print = function () {
            var log = "";
            for (var i = 1; i <= this.cells.length; i++) {
                log += this.cells[i - 1] == 1 ? "██" : "__";
                if (i > 0 && i % this.hor_size == 0)
                    log += "\n";
            }
            $("pre").text(log);
        }

        var defaults = {
            layoutType: CRPTiledLayerType.Square,
            approxTileWidth: 220,
            margin: 5,
            minTileWidth: 200,
            autoLoadURL: null,
            autoLoadOffset: 50,
            gridCellSize: 10,
            scrollEffect: '',
            allowEnlargement: true,
            hoverEffect: 'fade',
            hoverEasing: 'swing',
            socialIconType: 'standard',
            hoverEffectDuration: 250,
            ignoreImageAttributes: true,
            imageSizeFactor: 1,
            onComplete: function () { },
            onUpdate: function () { },
            onProgress: function () { }
        }

        var plugin = this;
        var grid = null;
        var transitions = supportsTransitions();
        var animateTiles = false;
        var isLoading = false;
        var currentPage = 1;
        var maxHeight = 0;

        plugin.settings = {}

        var $element = $(element),
             element = element;

        var currentWidth = $element.width();
        var completed = false;


        plugin.addElements = function (html) {
            var $hidden = $("<div />").hide();
            $hidden.append(html);
            var $tiles = $hidden.find(".tile");
            styleTiles($tiles, { top: $(window).scrollTop() + 500 });
            setupSocial($tiles);
            $("body").append($hidden);

            $tiles.appendTo($element.find(".ftg-items"));
            $hidden.remove();
            preloadImages($tiles);
        }

        plugin.showLoading = function () {
            var panel = $("<div class='ftg-loading-panel' />");
            panel.append("<p>Loading</p>");
            panel.hide();
            $("body").append(panel);
            panel.fadeIn();
        }

        plugin.hideLoading = function () {
            $(".ftg-loading-panel").fadeOut("fast", function () {
                $(this).remove();
            });
        }

        plugin.init = function () {
            plugin.settings = $.extend({}, defaults, options);

            $element.find(".ftg-items").css({
                position: "relative",
                minWidth: plugin.settings.minTileWidth
            });
            var $tiles = $element.find(".tile");
            styleTiles($tiles);
            preloadImages($tiles);


            var resTo = 0;

            $(window).resize(function () {
                clearTimeout(resTo);
                if (currentWidth != $element.width())
                {
                    resTo = setTimeout(function () {
                        grid = null;
                        maxHeight = 0;
                        animateTiles = true;
                        entile($element.find(".tile"));
                    }, 200);
                }
            });

            var $modules = $('.tile');
			$(window).scroll(function(event) {
			  $modules.each(function(i, el) {
			    var $el = $modules.eq(i);
			    if ($el.visible(true)) {
			      $modules
			        .splice(i, 1);
			      $el
			        .addClass("effect-" + plugin.settings.scrollEffect)
			        .removeClass('module');
			    }
			  });
			});


            var ajaxComplete = false;
            if (plugin.settings.autoLoadURL) {
                $(window).scroll(function () {
                    if (!ajaxComplete && !isLoading && $(window).scrollTop() >= $(document).height() - $(window).height() - plugin.settings.autoLoadOffset) {
                        isLoading = true;
                        plugin.showLoading();
                        $.get(plugin.settings.autoLoadURL, { page: ++currentPage }, function (html) {
                            if ($.trim(html).length == 0) {
                                ajaxComplete = true;
                            } else {
                                plugin.addElements(html);
                            }
                        });
                    }
                });
            }
        }

        var styleTiles = function ($tiles, styles) {
            $tiles.css({
                position: "absolute",
                left: "50%"
            });

            if (styles) {
                for (var style in styles) {
                    $tiles.css(style, styles[style]);
                }
            }

            $tiles.find('.tile-inner').css({ position: "relative" });

            $tiles.find(".item").css({
                width: "100%",
                display: "none"
            });
        }

        var loadImages = function (stack) {
            var $tile = $(stack.shift());
            if ($tile.data("type") == null || $tile.data("type") == "image") {

                var image = $tile.find(".item");
                var img = new Image();

                if (image.attr("width") && image.attr("height") && !plugin.settings.ignoreImageAttributes) {
                    assignImagesSize($tile);
                    entile($tile);
                    assignHover($tile);
                    if (stack.length > 0)
                        loadImages(stack);
                } else {
                    img.onload = function () {
                        $tile.find(".item")
                                .data("width", this.width * plugin.settings.imageSizeFactor)
                                .data("height", this.height * plugin.settings.imageSizeFactor);

                        assignImagesSize($tile);
                        entile($tile);
                        assignHover($tile);
                        if (stack.length > 0)
                            loadImages(stack);
                    };
                    img.onerror = function () {
                        assignImagesSize($tile);
                        entile($tile);
                        assignHover($tile);
                        if (stack.length > 0)
                            loadImages(stack);
                    };

                    img.src = image.attr("src");
                }
            } else {
                assignImagesSize($tile);
                entile($tile);
                assignHover($tile);
                if (stack.length > 0)
                    loadImages(stack);
            }
        }

        var preloadImages = function ($tiles) {
            var preloadStack = [];
            $tiles.each(function (i, tile) {
                preloadStack.push(tile);
            });

            loadImages(preloadStack);
        }

        var assignHover = function ($tile) {
            var $caption = $tile.find(".caption");

            if($caption.length > 0) {
            	$caption.css({
                    position: "absolute",
                    width: "100%",
                    height: "100%",
 					opacity: 0
            	});
            	var props = {
                	enter : {},
                	leave : {}
            	};
                switch(plugin.settings.hoverEffect) {
                    default:
                    case "fade":
                        $caption.css({
                            left: 0,
                            top: 0
                        });
                        props.enter.opacity = 1;
	                    props.leave.opacity = 0;
                        break;
                    case "slide-top":
                        $caption.css({
                            left: 0,
                            top: 0 - $tile.find(".item").data('size').height
                        });
                        props.enter.top = 0;
	                    props.leave.top = 0 - $tile.find(".item").data('size').height;
	                    props.enter.opacity = 1;
	                    props.leave.opacity = 0;
                        break;
                    case "slide-bottom":
                        $caption.css({
                            left: 0,
                            bottom: 0 - $tile.find(".item").data('size').height
                        });
                        props.enter.bottom = 0;
	                    props.leave.bottom = 0 - $tile.find(".item").data('size').height;
	                    props.enter.opacity = 1;
	                    props.leave.opacity = 0;
                        break;
                    case "slide-left":
                        $caption.css({
                            left: 0 - $tile.find(".item").data('size').width,
                            top: 0
                        });
                        props.enter.left = 0;
	                    props.leave.left = 0 - $tile.find(".item").data('size').width;
	                    props.enter.opacity = 1;
	                    props.leave.opacity = 0;
                        break;
                    case "slide-right":
                        $caption.css({
                            right: 0 - $tile.find(".item").data('size').width,
                            top: 0
                        });
                        props.enter.right = 0;
	                    props.leave.right = 0 - $tile.find(".item").data('size').width;
	                    props.enter.opacity = 1;
	                    props.leave.opacity = 0;
                        break;
                }
                $tile.mouseenter(function () {
                	$caption.css('display', 'block');
                    $caption.animate(props.enter,
                    		plugin.settings.hoverEffectDuration,
                    		plugin.settings.hoverEasing,
                    		function() {});
                });
                $tile.mouseleave(function () {
                    $caption.animate(props.leave,
                    		plugin.settings.hoverEffectDuration,
                    		plugin.settings.hoverEasing,
                    		function() {});
                });
            }
        }

        var assignImagesSize = function ($tiles) {
            $tiles.each(function () {
                var size = {};
                var $item = $(this).find(".item");
                if ($(this).data("type") == null || $(this).data("type") == "image") {
                    if ($item.attr("width")) {
                        size = {
                            width: parseInt($item.attr("width")),
                            height: parseInt($item.attr("height"))
                        }
                    } else {
                        $item.show();
                        size = {
                            width: $item.data("width"),
                            height: $item.data("height")
                        };
                    }
                    $item.hide();
                }
                if ($(this).data("type") == "video") {
                    size = {
                        width: parseInt($(this).find("iframe").attr("width")),
                        height: parseInt($(this).find("iframe").attr("height")),
                    }
                }

                //if (size.width < plugin.settings.minTileWidth) {
                //    //w : h = w1 : h1 => h1 = h * w1 / w
                //    size.height = size.height * plugin.settings.minTileWidth / size.width;
                //    size.width = plugin.settings.minTileWidth;
                //}
                $item.data("size", size);
            });
        }

        var entile = function ($tiles) {
            if (!grid)
                grid = new Grid(plugin.settings.gridCellSize, plugin.settings.margin, plugin.settings.minTileWidth, $element.width());

            var transition = animateTiles ? "all .5s" : "none";

            $tiles.css({
                transition: transition
            });
            $tiles.find(".item").css({
                display: "block"
            });

            $tiles.each(function () {
                if ($(this).hasClass("ftg-hidden"))
                    return;

                $(this).show();
                var size = $(this).find(".item").data("size");

                var slot = grid.insert(
                		size.width + plugin.settings.margin,
                		size.height + plugin.settings.margin,
                		plugin.settings.allowEnlargement);

				$(this).data("enlarged", slot.enlarged);

                $(this).find(".caption").css({
                    width: "100%"
                });

                var top = slot.cell_size * slot.position.y;
                var height = slot.cell_size * slot.blocks.v;

                var tileWidth = slot.cell_size * slot.blocks.h - plugin.settings.margin;
                var tileHeight = slot.cell_size * slot.blocks.v - plugin.settings.margin;

                if (top + tileHeight > maxHeight)
                    maxHeight = top + height + plugin.settings.margin;

                if (supportsTransitions() || !animateTiles) {
                    $(this).css({
                        top: top,
                        left: slot.cell_size * slot.position.x,
                        width: slot.cell_size * slot.blocks.h,
                        height: height
                    }, 500);
                    $(this).find('.tile-inner').css({
                        display: "block",
                        overflow: "hidden"
                    }).css({
                        width: tileWidth,
                        height: tileHeight
                    })
                    .data("width", tileWidth)
                    .data("height", tileHeight);
                } else {
                    $(this).animate({
                        top: top,
                        left: slot.cell_size * slot.position.x,
                        width: slot.cell_size * slot.blocks.h,
                        height: height
                    }, 500);
                    $(this).find('.tile-inner').css({
                        display: "block",
                        overflow: "hidden"
                    }).animate({
                        width: tileWidth,
                        height: tileHeight
                    })
                    .data("width", tileWidth)
                    .data("height", tileHeight);
                }

                $element.find(".ftg-items").height(maxHeight);
            });
            $tiles.find("img.item").each(function (i, item) {
                var $item = $(item);
                var size = $item.data("size");

                $item.css({
                    marginTop: 0,
                    marginLeft: 0,
                    width: "100%",
                    display: "block",
                    fontSize: 10, //against weird rules in some reset.css
                    margin: "auto",
                    maxWidth: "9999em"
                });


                //TODO controllo se aspect ratio parent > aspect ratio img
                var ratioImg = size.width / size.height;
                var ratioTile = $item.parent().data("width") / $item.parent().data("height");

                if($item.parent().parent().data("enlarged") && !plugin.settings.allowEnlargement) {
					$item.css({
						height: $item.parent().data("height") ,
						width: size.width,
						marginTop: 0
					});
				}

                else if (ratioImg == ratioTile) {
                    $item.css({
                        width: $item.parent().data("width"),
                        height: $item.parent().data("height")
                    });
                    $item.attr("case", "0");
                    return;//continue $.each loop
                }

                else if (ratioImg >= ratioTile) {
                    $item.css({
                        width: "auto",
                        height: $item.parent().data("height")
                    });

                    $item.attr("case", "2");

                    var diff = $item.width() - $item.parent().data("width");
                    $item.css("margin-left", diff / -2);
                } else {

                    //ratioImg < ratioTile
                    $item.css({
                        width: $item.parent().data("width"),
                        height: "auto"
                    });

                    $item.attr("case", "4");

                    var diff = $item.height() - $item.parent().data("height");
                    $item.css("margin-top", diff / -2);
                }

            });
            $tiles.each(function () {
                var el = $(this);
                if (el.visible(true)) {
                    el.addClass("already-visible");
                }
            });
            //grid.print();

            currentWidth = $element.width();
            if (!completed) {
                completed = true;
                plugin.settings.onComplete.call(plugin);
            } else {
                plugin.settings.onUpdate.call(plugin);
            }

            isLoading = false;
            plugin.hideLoading();
        }

        plugin.init();
    }

    $.fn.crpTiledLayer = function (options) {
        return this.each(function () {
            if (undefined == $(this).data('crpTiledLayer')) {
                var plugin = new $.crpTiledLayer(this, options);
                $(this).data('crpTiledLayer', plugin);
            }
        });
    }
})(jQuery);

