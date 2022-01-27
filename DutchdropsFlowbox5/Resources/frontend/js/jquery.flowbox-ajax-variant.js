(function ($, window) {
  $.plugin('flowboxAjaxVariant', {
    defaults: {
      flowboxKey: '',
    },

    init: function () {
      var me = this;

      me.applyDataAttributes();
      $.subscribe(me.getEventName('plugin/swAjaxVariant/onRequestData'), $.proxy(me.onVariantChange, me));
    },

    onVariantChange: function () {
      var me = this;
      // Update the flowbox flow accordingly
      if (window.flowbox) {
        ordernumber = $.trim($('.entry--sku .entry--content').text());
        window.flowbox('update', {
          key: me.opts.flowboxKey,
          productId: ordernumber,
        });
      }
    },

    destroy: function () {
      var me = this;

      $.unsubscribe(me.getEventName('plugin/swAjaxVariant/onRequestData'));

      me._destroy();
    }
  });

  $('.flowbox-widget-container').flowboxAjaxVariant();
}(jQuery, window));
