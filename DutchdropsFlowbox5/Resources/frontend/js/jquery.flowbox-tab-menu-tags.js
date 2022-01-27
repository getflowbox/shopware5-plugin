(function ($, window) {

    /**
     * Flowbox Tab Menu Tags Plugin
     *
     * This plugin sets up a menu with tags you can switch between.
     */
    $.plugin('flowboxTabMenuTags', {

        defaults: {

            /**
             *
             * @property flowboxKey
             * @type {String}
             */
            'flowboxKey': '',

            /**
             * Selector for a tab navigation item
             *
             * @property tabSelector
             * @type {String}
             */
            'tabSelector': '.flowbox-tag',

            /**
             * Class that should be set on an active tab navigation item
             *
             * @property activeTabClass
             * @type {String}
             */
            'activeTabClass': 'is--active',
        },

        /**
         * Initializes the plugin and register its events
         *
         * @public
         * @method init
         */
        init: function () {
            var me = this,
                opts = me.opts,
                $el = me.$el;

            me.applyDataAttributes();

            me.$tabs = $el.find(opts.tabSelector);

            me._index = null;

            me.registerEventListeners();
        },

        /**
         * This method registers the event listeners when when clicking
         * or tapping a tag.
         *
         * @public
         * @method registerEvents
         */
        registerEventListeners: function () {
            var me = this;

            me.$tabs.each(function (i, el) {
                me._on(el, 'click touchstart', $.proxy(me.changeTag, me, i));
            });

            $.publish('plugin/flowboxTabMenuTags/onRegisterEvents', [ me ]);
        },

        /**
         * This method switches to a new tag depending on the passed index
         * If the give index is the same as the current active one, nothing happens.
         *
         * @public
         * @method changeTag
         * @param {Number} index
         * @param {jQuery.Event} event
         */
        changeTag: function (index, event) {
            var me = this,
                opts = me.opts,
                activeTabClass = opts.activeTabClass,
                $tab;

            if (event) {
                event.preventDefault();
            }

            if (index === me._index) {
                return;
            }

            me._index = index;

            $tab = $(me.$tabs.get(index));

            window.flowbox('update', {
                key: me.opts.flowboxKey,
                tags: [$tab.attr('data-tag')],
            });

            me.$el
                .find('.' + activeTabClass)
                .removeClass(activeTabClass);

            $tab.addClass(activeTabClass);

            $.publish('plugin/flowboxTabMenuTags/onchangeTag', [ me, index ]);
        },

        /**
         * This method removes all registered events.
         *
         * @public
         * @method destroy
         */
        destroy: function () {
            var me = this;

            me._destroy();
        }
    });

    // Initialize the plugin when the default emotion plugin is ready
    $.subscribe('plugin/swEmotion/onInitElements', function (event, emotion) {
        $('.flowbox-tags').flowboxTabMenuTags();
    });

})(jQuery, window);
