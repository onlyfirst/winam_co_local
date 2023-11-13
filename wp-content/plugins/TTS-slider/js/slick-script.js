/**
 *  @name slider
 *  @description description
 *  @version 1.0
 *  @methods
 *    init
 *    destroy
 */
;(function($, window, undefined) {
  'use strict';

  var pluginName = 'slick-slider';
  var win = $(window),
      breakPoint = 991;

  function Plugin(element, options) {
    this.element = $(element);
    this.options = $.extend({}, $.fn[pluginName].defaults, this.element.data(), options);
    this.init();
  }

  var getUID = (function(){
    var id = 0;
    return function(){
      return pluginName + '-' + id++;
    };
  })();

  Plugin.prototype = {
    init: function() {
      var that = this;
      var elm = that.element,
          opts = that.options,
          items = elm.find('.slider-item') ;

      elm.slick(opts);

    },

    destroy: function() {
      $.removeData(this.element[0], pluginName);
    }
  };

  $.fn[pluginName] = function(options, params) {
    return this.each(function() {
      var instance = $.data(this, pluginName);
      if (!instance) {
        $.data(this, pluginName, new Plugin(this, options));
      } else if (instance[options]) {
        instance[options](params);
      }
    });
  };

  $.fn[pluginName].defaults = {
    autoplay: false,
    arrows: true,
    dots: true,
    pauseOnHover: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    reinitSlt: false
  };

  $(function() {
   $('[data-' + pluginName + ']')[pluginName]();
  });

}(jQuery, window));