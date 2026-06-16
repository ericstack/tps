/*! AdminLTE app.js
* ================
* Main JS application file for AdminLTE v2. This file
* should be included in all pages. It controls some layout
* options and implements exclusive AdminLTE plugins.
*
* @Author  Almsaeed Studio
* @Support <https://www.almsaeedstudio.com>
* @Email   <abdullah@almsaeedstudio.com>
<<<<<<< HEAD
* @version 2.4.5
=======
* @version 2.4.0
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
* @repository git://github.com/almasaeed2010/AdminLTE.git
* @license MIT <http://opensource.org/licenses/MIT>
*/

// Make sure jQuery has been loaded
if (typeof jQuery === 'undefined') {
throw new Error('AdminLTE requires jQuery')
}

/* BoxRefresh()
 * =========
 * Adds AJAX content control to a box.
 *
 * @Usage: $('#my-box').boxRefresh(options)
 *         or add [data-widget="box-refresh"] to the box element
 *         Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.boxrefresh';
=======
  'use strict'

  var DataKey = 'lte.boxrefresh'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Default = {
    source         : '',
    params         : {},
    trigger        : '.refresh-btn',
    content        : '.box-body',
    loadInContent  : true,
    responseType   : '',
    overlayTemplate: '<div class="overlay"><div class="fa fa-refresh fa-spin"></div></div>',
    onLoadStart    : function () {
    },
    onLoadDone     : function (response) {
<<<<<<< HEAD
      return response;
    }
  };

  var Selector = {
    data: '[data-widget="box-refresh"]'
  };
=======
      return response
    }
  }

  var Selector = {
    data: '[data-widget="box-refresh"]'
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // BoxRefresh Class Definition
  // =========================
  var BoxRefresh = function (element, options) {
<<<<<<< HEAD
    this.element  = element;
    this.options  = options;
    this.$overlay = $(options.overlay);

    if (options.source === '') {
      throw new Error('Source url was not defined. Please specify a url in your BoxRefresh source option.');
    }

    this._setUpListeners();
    this.load();
  };

  BoxRefresh.prototype.load = function () {
    this._addOverlay();
    this.options.onLoadStart.call($(this));

    $.get(this.options.source, this.options.params, function (response) {
      if (this.options.loadInContent) {
        $(this.options.content).html(response);
      }
      this.options.onLoadDone.call($(this), response);
      this._removeOverlay();
    }.bind(this), this.options.responseType !== '' && this.options.responseType);
  };
=======
    this.element  = element
    this.options  = options
    this.$overlay = $(options.overlay)

    if (options.source === '') {
      throw new Error('Source url was not defined. Please specify a url in your BoxRefresh source option.')
    }

    this._setUpListeners()
    this.load()
  }

  BoxRefresh.prototype.load = function () {
    this._addOverlay()
    this.options.onLoadStart.call($(this))

    $.get(this.options.source, this.options.params, function (response) {
      if (this.options.loadInContent) {
        $(this.options.content).html(response)
      }
      this.options.onLoadDone.call($(this), response)
      this._removeOverlay()
    }.bind(this), this.options.responseType !== '' && this.options.responseType)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Private

  BoxRefresh.prototype._setUpListeners = function () {
    $(this.element).on('click', Selector.trigger, function (event) {
<<<<<<< HEAD
      if (event) event.preventDefault();
      this.load();
    }.bind(this));
  };

  BoxRefresh.prototype._addOverlay = function () {
    $(this.element).append(this.$overlay);
  };

  BoxRefresh.prototype._removeOverlay = function () {
    $(this.element).remove(this.$overlay);
  };
=======
      if (event) event.preventDefault()
      this.load()
    }.bind(this))
  }

  BoxRefresh.prototype._addOverlay = function () {
    $(this.element).append(this.$overlay)
  }

  BoxRefresh.prototype._removeOverlay = function () {
    $(this.element).remove(this.$overlay)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new BoxRefresh($this, options)));
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, (data = new BoxRefresh($this, options)))
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
      }

      if (typeof data == 'string') {
        if (typeof data[option] == 'undefined') {
<<<<<<< HEAD
          throw new Error('No method named ' + option);
        }
        data[option]();
      }
    });
  }

  var old = $.fn.boxRefresh;

  $.fn.boxRefresh             = Plugin;
  $.fn.boxRefresh.Constructor = BoxRefresh;
=======
          throw new Error('No method named ' + option)
        }
        data[option]()
      }
    })
  }

  var old = $.fn.boxRefresh

  $.fn.boxRefresh             = Plugin
  $.fn.boxRefresh.Constructor = BoxRefresh
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.boxRefresh.noConflict = function () {
<<<<<<< HEAD
    $.fn.boxRefresh = old;
    return this;
  };
=======
    $.fn.boxRefresh = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // BoxRefresh Data API
  // =================
  $(window).on('load', function () {
    $(Selector.data).each(function () {
<<<<<<< HEAD
      Plugin.call($(this));
    });
  });

}(jQuery);
=======
      Plugin.call($(this))
    })
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* BoxWidget()
 * ======
 * Adds box widget functions to boxes.
 *
 * @Usage: $('.my-box').boxWidget(options)
 *         This plugin auto activates on any element using the `.box` class
 *         Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.boxwidget';
=======
  'use strict'

  var DataKey = 'lte.boxwidget'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Default = {
    animationSpeed : 500,
    collapseTrigger: '[data-widget="collapse"]',
    removeTrigger  : '[data-widget="remove"]',
    collapseIcon   : 'fa-minus',
    expandIcon     : 'fa-plus',
    removeIcon     : 'fa-times'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    data     : '.box',
    collapsed: '.collapsed-box',
<<<<<<< HEAD
    header   : '.box-header',
    body     : '.box-body',
    footer   : '.box-footer',
    tools    : '.box-tools'
  };

  var ClassName = {
    collapsed: 'collapsed-box'
  };
=======
    body     : '.box-body',
    footer   : '.box-footer',
    tools    : '.box-tools'
  }

  var ClassName = {
    collapsed: 'collapsed-box'
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Event = {
    collapsed: 'collapsed.boxwidget',
    expanded : 'expanded.boxwidget',
    removed  : 'removed.boxwidget'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // BoxWidget Class Definition
  // =====================
  var BoxWidget = function (element, options) {
<<<<<<< HEAD
    this.element = element;
    this.options = options;

    this._setUpListeners();
  };

  BoxWidget.prototype.toggle = function () {
    var isOpen = !$(this.element).is(Selector.collapsed);

    if (isOpen) {
      this.collapse();
    } else {
      this.expand();
    }
  };

  BoxWidget.prototype.expand = function () {
    var expandedEvent = $.Event(Event.expanded);
    var collapseIcon  = this.options.collapseIcon;
    var expandIcon    = this.options.expandIcon;

    $(this.element).removeClass(ClassName.collapsed);

    $(this.element)
      .children(Selector.header + ', ' + Selector.body + ', ' + Selector.footer)
      .children(Selector.tools)
      .find('.' + expandIcon)
      .removeClass(expandIcon)
      .addClass(collapseIcon);

    $(this.element).children(Selector.body + ', ' + Selector.footer)
      .slideDown(this.options.animationSpeed, function () {
        $(this.element).trigger(expandedEvent);
      }.bind(this));
  };

  BoxWidget.prototype.collapse = function () {
    var collapsedEvent = $.Event(Event.collapsed);
    var collapseIcon   = this.options.collapseIcon;
    var expandIcon     = this.options.expandIcon;

    $(this.element)
      .children(Selector.header + ', ' + Selector.body + ', ' + Selector.footer)
      .children(Selector.tools)
      .find('.' + collapseIcon)
      .removeClass(collapseIcon)
      .addClass(expandIcon);

    $(this.element).children(Selector.body + ', ' + Selector.footer)
      .slideUp(this.options.animationSpeed, function () {
        $(this.element).addClass(ClassName.collapsed);
        $(this.element).trigger(collapsedEvent);
      }.bind(this));
  };

  BoxWidget.prototype.remove = function () {
    var removedEvent = $.Event(Event.removed);

    $(this.element).slideUp(this.options.animationSpeed, function () {
      $(this.element).trigger(removedEvent);
      $(this.element).remove();
    }.bind(this));
  };
=======
    this.element = element
    this.options = options

    this._setUpListeners()
  }

  BoxWidget.prototype.toggle = function () {
    var isOpen = !$(this.element).is(Selector.collapsed)

    if (isOpen) {
      this.collapse()
    } else {
      this.expand()
    }
  }

  BoxWidget.prototype.expand = function () {
    var expandedEvent = $.Event(Event.expanded)
    var collapseIcon  = this.options.collapseIcon
    var expandIcon    = this.options.expandIcon

    $(this.element).removeClass(ClassName.collapsed)

    $(this.element)
      .find(Selector.tools)
      .find('.' + expandIcon)
      .removeClass(expandIcon)
      .addClass(collapseIcon)

    $(this.element).find(Selector.body + ', ' + Selector.footer)
      .slideDown(this.options.animationSpeed, function () {
        $(this.element).trigger(expandedEvent)
      }.bind(this))
  }

  BoxWidget.prototype.collapse = function () {
    var collapsedEvent = $.Event(Event.collapsed)
    var collapseIcon   = this.options.collapseIcon
    var expandIcon     = this.options.expandIcon

    $(this.element)
      .find(Selector.tools)
      .find('.' + collapseIcon)
      .removeClass(collapseIcon)
      .addClass(expandIcon)

    $(this.element).find(Selector.body + ', ' + Selector.footer)
      .slideUp(this.options.animationSpeed, function () {
        $(this.element).addClass(ClassName.collapsed)
        $(this.element).trigger(collapsedEvent)
      }.bind(this))
  }

  BoxWidget.prototype.remove = function () {
    var removedEvent = $.Event(Event.removed)

    $(this.element).slideUp(this.options.animationSpeed, function () {
      $(this.element).trigger(removedEvent)
      $(this.element).remove()
    }.bind(this))
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Private

  BoxWidget.prototype._setUpListeners = function () {
<<<<<<< HEAD
    var that = this;

    $(this.element).on('click', this.options.collapseTrigger, function (event) {
      if (event) event.preventDefault();
      that.toggle($(this));
      return false;
    });

    $(this.element).on('click', this.options.removeTrigger, function (event) {
      if (event) event.preventDefault();
      that.remove($(this));
      return false;
    });
  };
=======
    var that = this

    $(this.element).on('click', this.options.collapseTrigger, function (event) {
      if (event) event.preventDefault()
      that.toggle()
    })

    $(this.element).on('click', this.options.removeTrigger, function (event) {
      if (event) event.preventDefault()
      that.remove()
    })
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new BoxWidget($this, options)));
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, (data = new BoxWidget($this, options)))
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
      }

      if (typeof option == 'string') {
        if (typeof data[option] == 'undefined') {
<<<<<<< HEAD
          throw new Error('No method named ' + option);
        }
        data[option]();
      }
    });
  }

  var old = $.fn.boxWidget;

  $.fn.boxWidget             = Plugin;
  $.fn.boxWidget.Constructor = BoxWidget;
=======
          throw new Error('No method named ' + option)
        }
        data[option]()
      }
    })
  }

  var old = $.fn.boxWidget

  $.fn.boxWidget             = Plugin
  $.fn.boxWidget.Constructor = BoxWidget
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.boxWidget.noConflict = function () {
<<<<<<< HEAD
    $.fn.boxWidget = old;
    return this;
  };
=======
    $.fn.boxWidget = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // BoxWidget Data API
  // ==================
  $(window).on('load', function () {
    $(Selector.data).each(function () {
<<<<<<< HEAD
      Plugin.call($(this));
    });
  });
}(jQuery);
=======
      Plugin.call($(this))
    })
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* ControlSidebar()
 * ===============
 * Toggles the state of the control sidebar
 *
 * @Usage: $('#control-sidebar-trigger').controlSidebar(options)
 *         or add [data-toggle="control-sidebar"] to the trigger
 *         Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.controlsidebar';

  var Default = {
    slide: true
  };
=======
  'use strict'

  var DataKey = 'lte.controlsidebar'

  var Default = {
    slide: true
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    sidebar: '.control-sidebar',
    data   : '[data-toggle="control-sidebar"]',
    open   : '.control-sidebar-open',
    bg     : '.control-sidebar-bg',
    wrapper: '.wrapper',
    content: '.content-wrapper',
    boxed  : '.layout-boxed'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var ClassName = {
    open : 'control-sidebar-open',
    fixed: 'fixed'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Event = {
    collapsed: 'collapsed.controlsidebar',
    expanded : 'expanded.controlsidebar'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // ControlSidebar Class Definition
  // ===============================
  var ControlSidebar = function (element, options) {
<<<<<<< HEAD
    this.element         = element;
    this.options         = options;
    this.hasBindedResize = false;

    this.init();
  };
=======
    this.element         = element
    this.options         = options
    this.hasBindedResize = false

    this.init()
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  ControlSidebar.prototype.init = function () {
    // Add click listener if the element hasn't been
    // initialized using the data API
    if (!$(this.element).is(Selector.data)) {
<<<<<<< HEAD
      $(this).on('click', this.toggle);
    }

    this.fix();
    $(window).resize(function () {
      this.fix();
    }.bind(this));
  };

  ControlSidebar.prototype.toggle = function (event) {
    if (event) event.preventDefault();

    this.fix();

    if (!$(Selector.sidebar).is(Selector.open) && !$('body').is(Selector.open)) {
      this.expand();
    } else {
      this.collapse();
    }
  };

  ControlSidebar.prototype.expand = function () {
    if (!this.options.slide) {
      $('body').addClass(ClassName.open);
    } else {
      $(Selector.sidebar).addClass(ClassName.open);
    }

    $(this.element).trigger($.Event(Event.expanded));
  };

  ControlSidebar.prototype.collapse = function () {
    $('body, ' + Selector.sidebar).removeClass(ClassName.open);
    $(this.element).trigger($.Event(Event.collapsed));
  };

  ControlSidebar.prototype.fix = function () {
    if ($('body').is(Selector.boxed)) {
      this._fixForBoxed($(Selector.bg));
    }
  };
=======
      $(this).on('click', this.toggle)
    }

    this.fix()
    $(window).resize(function () {
      this.fix()
    }.bind(this))
  }

  ControlSidebar.prototype.toggle = function (event) {
    if (event) event.preventDefault()

    this.fix()

    if (!$(Selector.sidebar).is(Selector.open) && !$('body').is(Selector.open)) {
      this.expand()
    } else {
      this.collapse()
    }
  }

  ControlSidebar.prototype.expand = function () {
    if (!this.options.slide) {
      $('body').addClass(ClassName.open)
    } else {
      $(Selector.sidebar).addClass(ClassName.open)
    }

    $(this.element).trigger($.Event(Event.expanded))
  }

  ControlSidebar.prototype.collapse = function () {
    $('body, ' + Selector.sidebar).removeClass(ClassName.open)
    $(this.element).trigger($.Event(Event.collapsed))
  }

  ControlSidebar.prototype.fix = function () {
    if ($('body').is(Selector.boxed)) {
      this._fixForBoxed($(Selector.bg))
    }
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Private

  ControlSidebar.prototype._fixForBoxed = function (bg) {
    bg.css({
      position: 'absolute',
      height  : $(Selector.wrapper).height()
<<<<<<< HEAD
    });
  };
=======
    })
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new ControlSidebar($this, options)));
      }

      if (typeof option == 'string') data.toggle();
    });
  }

  var old = $.fn.controlSidebar;

  $.fn.controlSidebar             = Plugin;
  $.fn.controlSidebar.Constructor = ControlSidebar;
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, (data = new ControlSidebar($this, options)))
      }

      if (typeof option == 'string') data.toggle()
    })
  }

  var old = $.fn.controlSidebar

  $.fn.controlSidebar             = Plugin
  $.fn.controlSidebar.Constructor = ControlSidebar
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.controlSidebar.noConflict = function () {
<<<<<<< HEAD
    $.fn.controlSidebar = old;
    return this;
  };
=======
    $.fn.controlSidebar = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // ControlSidebar Data API
  // =======================
  $(document).on('click', Selector.data, function (event) {
<<<<<<< HEAD
    if (event) event.preventDefault();
    Plugin.call($(this), 'toggle');
  });

}(jQuery);
=======
    if (event) event.preventDefault()
    Plugin.call($(this), 'toggle')
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* DirectChat()
 * ===============
 * Toggles the state of the control sidebar
 *
 * @Usage: $('#my-chat-box').directChat()
 *         or add [data-widget="direct-chat"] to the trigger
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.directchat';
=======
  'use strict'

  var DataKey = 'lte.directchat'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    data: '[data-widget="chat-pane-toggle"]',
    box : '.direct-chat'
<<<<<<< HEAD
  };

  var ClassName = {
    open: 'direct-chat-contacts-open'
  };
=======
  }

  var ClassName = {
    open: 'direct-chat-contacts-open'
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // DirectChat Class Definition
  // ===========================
  var DirectChat = function (element) {
<<<<<<< HEAD
    this.element = element;
  };

  DirectChat.prototype.toggle = function ($trigger) {
    $trigger.parents(Selector.box).first().toggleClass(ClassName.open);
  };
=======
    this.element = element
  }

  DirectChat.prototype.toggle = function ($trigger) {
    $trigger.parents(Selector.box).first().toggleClass(ClassName.open)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        $this.data(DataKey, (data = new DirectChat($this)));
      }

      if (typeof option == 'string') data.toggle($this);
    });
  }

  var old = $.fn.directChat;

  $.fn.directChat             = Plugin;
  $.fn.directChat.Constructor = DirectChat;
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        $this.data(DataKey, (data = new DirectChat($this)))
      }

      if (typeof option == 'string') data.toggle($this)
    })
  }

  var old = $.fn.directChat

  $.fn.directChat             = Plugin
  $.fn.directChat.Constructor = DirectChat
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.directChat.noConflict = function () {
<<<<<<< HEAD
    $.fn.directChat = old;
    return this;
  };
=======
    $.fn.directChat = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // DirectChat Data API
  // ===================
  $(document).on('click', Selector.data, function (event) {
<<<<<<< HEAD
    if (event) event.preventDefault();
    Plugin.call($(this), 'toggle');
  });

}(jQuery);
=======
    if (event) event.preventDefault()
    Plugin.call($(this), 'toggle')
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* Layout()
 * ========
 * Implements AdminLTE layout.
 * Fixes the layout height in case min-height fails.
 *
 * @usage activated automatically upon window load.
 *        Configure any options by passing data-option="value"
 *        to the body tag.
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.layout';
=======
  'use strict'

  var DataKey = 'lte.layout'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Default = {
    slimscroll : true,
    resetHeight: true
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    wrapper       : '.wrapper',
    contentWrapper: '.content-wrapper',
    layoutBoxed   : '.layout-boxed',
    mainFooter    : '.main-footer',
    mainHeader    : '.main-header',
    sidebar       : '.sidebar',
    controlSidebar: '.control-sidebar',
    fixed         : '.fixed',
    sidebarMenu   : '.sidebar-menu',
    logo          : '.main-header .logo'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var ClassName = {
    fixed         : 'fixed',
    holdTransition: 'hold-transition'
<<<<<<< HEAD
  };

  var Layout = function (options) {
    this.options      = options;
    this.bindedResize = false;
    this.activate();
  };

  Layout.prototype.activate = function () {
    this.fix();
    this.fixSidebar();

    $('body').removeClass(ClassName.holdTransition);
=======
  }

  var Layout = function (options) {
    this.options      = options
    this.bindedResize = false
    this.activate()
  }

  Layout.prototype.activate = function () {
    this.fix()
    this.fixSidebar()

    $('body').removeClass(ClassName.holdTransition)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

    if (this.options.resetHeight) {
      $('body, html, ' + Selector.wrapper).css({
        'height'    : 'auto',
        'min-height': '100%'
<<<<<<< HEAD
      });
=======
      })
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
    }

    if (!this.bindedResize) {
      $(window).resize(function () {
<<<<<<< HEAD
        this.fix();
        this.fixSidebar();

        $(Selector.logo + ', ' + Selector.sidebar).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
          this.fix();
          this.fixSidebar();
        }.bind(this));
      }.bind(this));

      this.bindedResize = true;
    }

    $(Selector.sidebarMenu).on('expanded.tree', function () {
      this.fix();
      this.fixSidebar();
    }.bind(this));

    $(Selector.sidebarMenu).on('collapsed.tree', function () {
      this.fix();
      this.fixSidebar();
    }.bind(this));
  };

  Layout.prototype.fix = function () {
    // Remove overflow from .wrapper if layout-boxed exists
    $(Selector.layoutBoxed + ' > ' + Selector.wrapper).css('overflow', 'hidden');

    // Get window height and the wrapper height
    var footerHeight = $(Selector.mainFooter).outerHeight() || 0;
    var headerHeight  = $(Selector.mainHeader).outerHeight() || 0;
    var neg           = headerHeight + footerHeight;
    var windowHeight  = $(window).height();
    var sidebarHeight = $(Selector.sidebar).height() || 0;
=======
        this.fix()
        this.fixSidebar()

        $(Selector.logo + ', ' + Selector.sidebar).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
          this.fix()
          this.fixSidebar()
        }.bind(this))
      }.bind(this))

      this.bindedResize = true
    }

    $(Selector.sidebarMenu).on('expanded.tree', function () {
      this.fix()
      this.fixSidebar()
    }.bind(this))

    $(Selector.sidebarMenu).on('collapsed.tree', function () {
      this.fix()
      this.fixSidebar()
    }.bind(this))
  }

  Layout.prototype.fix = function () {
    // Remove overflow from .wrapper if layout-boxed exists
    $(Selector.layoutBoxed + ' > ' + Selector.wrapper).css('overflow', 'hidden')

    // Get window height and the wrapper height
    var footerHeight  = $(Selector.mainFooter).outerHeight() || 0
    var neg           = $(Selector.mainHeader).outerHeight() + footerHeight
    var windowHeight  = $(window).height()
    var sidebarHeight = $(Selector.sidebar).height() || 0
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

    // Set the min-height of the content and sidebar based on
    // the height of the document.
    if ($('body').hasClass(ClassName.fixed)) {
<<<<<<< HEAD
      $(Selector.contentWrapper).css('min-height', windowHeight - footerHeight);
    } else {
      var postSetHeight;

      if (windowHeight >= sidebarHeight) {
        $(Selector.contentWrapper).css('min-height', windowHeight - neg);
        postSetHeight = windowHeight - neg;
      } else {
        $(Selector.contentWrapper).css('min-height', sidebarHeight);
        postSetHeight = sidebarHeight;
      }

      // Fix for the control sidebar height
      var $controlSidebar = $(Selector.controlSidebar);
      if (typeof $controlSidebar !== 'undefined') {
        if ($controlSidebar.height() > postSetHeight)
          $(Selector.contentWrapper).css('min-height', $controlSidebar.height());
      }
    }
  };
=======
      $(Selector.contentWrapper).css('min-height', windowHeight - footerHeight)
    } else {
      var postSetHeight

      if (windowHeight >= sidebarHeight) {
        $(Selector.contentWrapper).css('min-height', windowHeight - neg)
        postSetHeight = windowHeight - neg
      } else {
        $(Selector.contentWrapper).css('min-height', sidebarHeight)
        postSetHeight = sidebarHeight
      }

      // Fix for the control sidebar height
      var $controlSidebar = $(Selector.controlSidebar)
      if (typeof $controlSidebar !== 'undefined') {
        if ($controlSidebar.height() > postSetHeight)
          $(Selector.contentWrapper).css('min-height', $controlSidebar.height())
      }
    }
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  Layout.prototype.fixSidebar = function () {
    // Make sure the body tag has the .fixed class
    if (!$('body').hasClass(ClassName.fixed)) {
      if (typeof $.fn.slimScroll !== 'undefined') {
<<<<<<< HEAD
        $(Selector.sidebar).slimScroll({ destroy: true }).height('auto');
      }
      return;
=======
        $(Selector.sidebar).slimScroll({ destroy: true }).height('auto')
      }
      return
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
    }

    // Enable slimscroll for fixed layout
    if (this.options.slimscroll) {
      if (typeof $.fn.slimScroll !== 'undefined') {
        // Destroy if it exists
        // $(Selector.sidebar).slimScroll({ destroy: true }).height('auto')

        // Add slimscroll
        $(Selector.sidebar).slimScroll({
<<<<<<< HEAD
          height: ($(window).height() - $(Selector.mainHeader).height()) + 'px'
        });
      }
    }
  };
=======
          height: ($(window).height() - $(Selector.mainHeader).height()) + 'px',
          color : 'rgba(0,0,0,0.2)',
          size  : '3px'
        })
      }
    }
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option === 'object' && option);
        $this.data(DataKey, (data = new Layout(options)));
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option === 'object' && option)
        $this.data(DataKey, (data = new Layout(options)))
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
      }

      if (typeof option === 'string') {
        if (typeof data[option] === 'undefined') {
<<<<<<< HEAD
          throw new Error('No method named ' + option);
        }
        data[option]();
      }
    });
  }

  var old = $.fn.layout;

  $.fn.layout            = Plugin;
  $.fn.layout.Constuctor = Layout;
=======
          throw new Error('No method named ' + option)
        }
        data[option]()
      }
    })
  }

  var old = $.fn.layout

  $.fn.layout            = Plugin
  $.fn.layout.Constuctor = Layout
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No conflict mode
  // ================
  $.fn.layout.noConflict = function () {
<<<<<<< HEAD
    $.fn.layout = old;
    return this;
  };
=======
    $.fn.layout = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Layout DATA-API
  // ===============
  $(window).on('load', function () {
<<<<<<< HEAD
    Plugin.call($('body'));
  });
}(jQuery);
=======
    Plugin.call($('body'))
  })
}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* PushMenu()
 * ==========
 * Adds the push menu functionality to the sidebar.
 *
 * @usage: $('.btn').pushMenu(options)
 *          or add [data-toggle="push-menu"] to any button
 *          Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.pushmenu';
=======
  'use strict'

  var DataKey = 'lte.pushmenu'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Default = {
    collapseScreenSize   : 767,
    expandOnHover        : false,
    expandTransitionDelay: 200
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    collapsed     : '.sidebar-collapse',
    open          : '.sidebar-open',
    mainSidebar   : '.main-sidebar',
    contentWrapper: '.content-wrapper',
    searchInput   : '.sidebar-form .form-control',
    button        : '[data-toggle="push-menu"]',
    mini          : '.sidebar-mini',
    expanded      : '.sidebar-expanded-on-hover',
    layoutFixed   : '.fixed'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var ClassName = {
    collapsed    : 'sidebar-collapse',
    open         : 'sidebar-open',
    mini         : 'sidebar-mini',
    expanded     : 'sidebar-expanded-on-hover',
    expandFeature: 'sidebar-mini-expand-feature',
    layoutFixed  : 'fixed'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Event = {
    expanded : 'expanded.pushMenu',
    collapsed: 'collapsed.pushMenu'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // PushMenu Class Definition
  // =========================
  var PushMenu = function (options) {
<<<<<<< HEAD
    this.options = options;
    this.init();
  };
=======
    this.options = options
    this.init()
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  PushMenu.prototype.init = function () {
    if (this.options.expandOnHover
      || ($('body').is(Selector.mini + Selector.layoutFixed))) {
<<<<<<< HEAD
      this.expandOnHover();
      $('body').addClass(ClassName.expandFeature);
=======
      this.expandOnHover()
      $('body').addClass(ClassName.expandFeature)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
    }

    $(Selector.contentWrapper).click(function () {
      // Enable hide menu when clicking on the content-wrapper on small screens
      if ($(window).width() <= this.options.collapseScreenSize && $('body').hasClass(ClassName.open)) {
<<<<<<< HEAD
        this.close();
      }
    }.bind(this));

    // __Fix for android devices
    $(Selector.searchInput).click(function (e) {
      e.stopPropagation();
    });
  };

  PushMenu.prototype.toggle = function () {
    var windowWidth = $(window).width();
    var isOpen      = !$('body').hasClass(ClassName.collapsed);

    if (windowWidth <= this.options.collapseScreenSize) {
      isOpen = $('body').hasClass(ClassName.open);
    }

    if (!isOpen) {
      this.open();
    } else {
      this.close();
    }
  };

  PushMenu.prototype.open = function () {
    var windowWidth = $(window).width();

    if (windowWidth > this.options.collapseScreenSize) {
      $('body').removeClass(ClassName.collapsed)
        .trigger($.Event(Event.expanded));
    }
    else {
      $('body').addClass(ClassName.open)
        .trigger($.Event(Event.expanded));
    }
  };

  PushMenu.prototype.close = function () {
    var windowWidth = $(window).width();
    if (windowWidth > this.options.collapseScreenSize) {
      $('body').addClass(ClassName.collapsed)
        .trigger($.Event(Event.collapsed));
    } else {
      $('body').removeClass(ClassName.open + ' ' + ClassName.collapsed)
        .trigger($.Event(Event.collapsed));
    }
  };
=======
        this.close()
      }
    }.bind(this))

    // __Fix for android devices
    $(Selector.searchInput).click(function (e) {
      e.stopPropagation()
    })
  }

  PushMenu.prototype.toggle = function () {
    var windowWidth = $(window).width()
    var isOpen      = !$('body').hasClass(ClassName.collapsed)

    if (windowWidth <= this.options.collapseScreenSize) {
      isOpen = $('body').hasClass(ClassName.open)
    }

    if (!isOpen) {
      this.open()
    } else {
      this.close()
    }
  }

  PushMenu.prototype.open = function () {
    var windowWidth = $(window).width()

    if (windowWidth > this.options.collapseScreenSize) {
      $('body').removeClass(ClassName.collapsed)
        .trigger($.Event(Event.expanded))
    }
    else {
      $('body').addClass(ClassName.open)
        .trigger($.Event(Event.expanded))
    }
  }

  PushMenu.prototype.close = function () {
    var windowWidth = $(window).width()
    if (windowWidth > this.options.collapseScreenSize) {
      $('body').addClass(ClassName.collapsed)
        .trigger($.Event(Event.collapsed))
    } else {
      $('body').removeClass(ClassName.open + ' ' + ClassName.collapsed)
        .trigger($.Event(Event.collapsed))
    }
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  PushMenu.prototype.expandOnHover = function () {
    $(Selector.mainSidebar).hover(function () {
      if ($('body').is(Selector.mini + Selector.collapsed)
        && $(window).width() > this.options.collapseScreenSize) {
<<<<<<< HEAD
        this.expand();
      }
    }.bind(this), function () {
      if ($('body').is(Selector.expanded)) {
        this.collapse();
      }
    }.bind(this));
  };
=======
        this.expand()
      }
    }.bind(this), function () {
      if ($('body').is(Selector.expanded)) {
        this.collapse()
      }
    }.bind(this))
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  PushMenu.prototype.expand = function () {
    setTimeout(function () {
      $('body').removeClass(ClassName.collapsed)
<<<<<<< HEAD
        .addClass(ClassName.expanded);
    }, this.options.expandTransitionDelay);
  };
=======
        .addClass(ClassName.expanded)
    }, this.options.expandTransitionDelay)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  PushMenu.prototype.collapse = function () {
    setTimeout(function () {
      $('body').removeClass(ClassName.expanded)
<<<<<<< HEAD
        .addClass(ClassName.collapsed);
    }, this.options.expandTransitionDelay);
  };
=======
        .addClass(ClassName.collapsed)
    }, this.options.expandTransitionDelay)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // PushMenu Plugin Definition
  // ==========================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new PushMenu(options)));
      }

      if (option === 'toggle') data.toggle();
    });
  }

  var old = $.fn.pushMenu;

  $.fn.pushMenu             = Plugin;
  $.fn.pushMenu.Constructor = PushMenu;
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, (data = new PushMenu(options)))
      }

      if (option === 'toggle') data.toggle()
    })
  }

  var old = $.fn.pushMenu

  $.fn.pushMenu             = Plugin
  $.fn.pushMenu.Constructor = PushMenu
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.pushMenu.noConflict = function () {
<<<<<<< HEAD
    $.fn.pushMenu = old;
    return this;
  };
=======
    $.fn.pushMenu = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Data API
  // ========
  $(document).on('click', Selector.button, function (e) {
<<<<<<< HEAD
    e.preventDefault();
    Plugin.call($(this), 'toggle');
  });
  $(window).on('load', function () {
    Plugin.call($(Selector.button));
  });
}(jQuery);
=======
    e.preventDefault()
    Plugin.call($(this), 'toggle')
  })
  $(window).on('load', function () {
    Plugin.call($(Selector.button))
  })
}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* TodoList()
 * =========
 * Converts a list into a todoList.
 *
 * @Usage: $('.my-list').todoList(options)
 *         or add [data-widget="todo-list"] to the ul element
 *         Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.todolist';

  var Default = {
    onCheck  : function (item) {
      return item;
    },
    onUnCheck: function (item) {
      return item;
    }
  };

  var Selector = {
    data: '[data-widget="todo-list"]'
  };

  var ClassName = {
    done: 'done'
  };
=======
  'use strict'

  var DataKey = 'lte.todolist'

  var Default = {
    onCheck  : function (item) {
      return item
    },
    onUnCheck: function (item) {
      return item
    }
  }

  var Selector = {
    data: '[data-widget="todo-list"]'
  }

  var ClassName = {
    done: 'done'
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // TodoList Class Definition
  // =========================
  var TodoList = function (element, options) {
<<<<<<< HEAD
    this.element = element;
    this.options = options;

    this._setUpListeners();
  };

  TodoList.prototype.toggle = function (item) {
    item.parents(Selector.li).first().toggleClass(ClassName.done);
    if (!item.prop('checked')) {
      this.unCheck(item);
      return;
    }

    this.check(item);
  };

  TodoList.prototype.check = function (item) {
    this.options.onCheck.call(item);
  };

  TodoList.prototype.unCheck = function (item) {
    this.options.onUnCheck.call(item);
  };
=======
    this.element = element
    this.options = options

    this._setUpListeners()
  }

  TodoList.prototype.toggle = function (item) {
    item.parents(Selector.li).first().toggleClass(ClassName.done)
    if (!item.prop('checked')) {
      this.unCheck(item)
      return
    }

    this.check(item)
  }

  TodoList.prototype.check = function (item) {
    this.options.onCheck.call(item)
  }

  TodoList.prototype.unCheck = function (item) {
    this.options.onUnCheck.call(item)
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Private

  TodoList.prototype._setUpListeners = function () {
<<<<<<< HEAD
    var that = this;
    $(this.element).on('change ifChanged', 'input:checkbox', function () {
      that.toggle($(this));
    });
  };
=======
    var that = this
    $(this.element).on('change ifChanged', 'input:checkbox', function () {
      that.toggle($(this))
    })
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, (data = new TodoList($this, options)));
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, (data = new TodoList($this, options)))
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
      }

      if (typeof data == 'string') {
        if (typeof data[option] == 'undefined') {
<<<<<<< HEAD
          throw new Error('No method named ' + option);
        }
        data[option]();
      }
    });
  }

  var old = $.fn.todoList;

  $.fn.todoList             = Plugin;
  $.fn.todoList.Constructor = TodoList;
=======
          throw new Error('No method named ' + option)
        }
        data[option]()
      }
    })
  }

  var old = $.fn.todoList

  $.fn.todoList         = Plugin
  $.fn.todoList.Constructor = TodoList
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.todoList.noConflict = function () {
<<<<<<< HEAD
    $.fn.todoList = old;
    return this;
  };
=======
    $.fn.todoList = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // TodoList Data API
  // =================
  $(window).on('load', function () {
    $(Selector.data).each(function () {
<<<<<<< HEAD
      Plugin.call($(this));
    });
  });

}(jQuery);
=======
      Plugin.call($(this))
    })
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b


/* Tree()
 * ======
 * Converts a nested list into a multilevel
 * tree view menu.
 *
 * @Usage: $('.my-menu').tree(options)
 *         or add [data-widget="tree"] to the ul element
 *         Pass any option as data-option="value"
 */
+function ($) {
<<<<<<< HEAD
  'use strict';

  var DataKey = 'lte.tree';
=======
  'use strict'

  var DataKey = 'lte.tree'
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Default = {
    animationSpeed: 500,
    accordion     : true,
    followLink    : false,
    trigger       : '.treeview a'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Selector = {
    tree        : '.tree',
    treeview    : '.treeview',
    treeviewMenu: '.treeview-menu',
    open        : '.menu-open, .active',
    li          : 'li',
    data        : '[data-widget="tree"]',
    active      : '.active'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var ClassName = {
    open: 'menu-open',
    tree: 'tree'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  var Event = {
    collapsed: 'collapsed.tree',
    expanded : 'expanded.tree'
<<<<<<< HEAD
  };
=======
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Tree Class Definition
  // =====================
  var Tree = function (element, options) {
<<<<<<< HEAD
    this.element = element;
    this.options = options;

    $(this.element).addClass(ClassName.tree);

    $(Selector.treeview + Selector.active, this.element).addClass(ClassName.open);

    this._setUpListeners();
  };

  Tree.prototype.toggle = function (link, event) {
    var treeviewMenu = link.next(Selector.treeviewMenu);
    var parentLi     = link.parent();
    var isOpen       = parentLi.hasClass(ClassName.open);

    if (!parentLi.is(Selector.treeview)) {
      return;
    }

    if (!this.options.followLink || link.attr('href') === '#') {
      event.preventDefault();
    }

    if (isOpen) {
      this.collapse(treeviewMenu, parentLi);
    } else {
      this.expand(treeviewMenu, parentLi);
    }
  };

  Tree.prototype.expand = function (tree, parent) {
    var expandedEvent = $.Event(Event.expanded);

    if (this.options.accordion) {
      var openMenuLi = parent.siblings(Selector.open);
      var openTree   = openMenuLi.children(Selector.treeviewMenu);
      this.collapse(openTree, openMenuLi);
    }

    parent.addClass(ClassName.open);
    tree.slideDown(this.options.animationSpeed, function () {
      $(this.element).trigger(expandedEvent);
    }.bind(this));
  };

  Tree.prototype.collapse = function (tree, parentLi) {
    var collapsedEvent = $.Event(Event.collapsed);

    //tree.find(Selector.open).removeClass(ClassName.open);
    parentLi.removeClass(ClassName.open);
    tree.slideUp(this.options.animationSpeed, function () {
      //tree.find(Selector.open + ' > ' + Selector.treeview).slideUp();
      $(this.element).trigger(collapsedEvent);
    }.bind(this));
  };
=======
    this.element = element
    this.options = options

    $(this.element).addClass(ClassName.tree)

    $(Selector.treeview + Selector.active, this.element).addClass(ClassName.open)

    this._setUpListeners()
  }

  Tree.prototype.toggle = function (link, event) {
    var treeviewMenu = link.next(Selector.treeviewMenu)
    var parentLi     = link.parent()
    var isOpen       = parentLi.hasClass(ClassName.open)

    if (!parentLi.is(Selector.treeview)) {
      return
    }

    if (!this.options.followLink || link.attr('href') === '#') {
      event.preventDefault()
    }

    if (isOpen) {
      this.collapse(treeviewMenu, parentLi)
    } else {
      this.expand(treeviewMenu, parentLi)
    }
  }

  Tree.prototype.expand = function (tree, parent) {
    var expandedEvent = $.Event(Event.expanded)

    if (this.options.accordion) {
      var openMenuLi = parent.siblings(Selector.open)
      var openTree   = openMenuLi.children(Selector.treeviewMenu)
      this.collapse(openTree, openMenuLi)
    }

    parent.addClass(ClassName.open)
    tree.slideDown(this.options.animationSpeed, function () {
      $(this.element).trigger(expandedEvent)
    }.bind(this))
  }

  Tree.prototype.collapse = function (tree, parentLi) {
    var collapsedEvent = $.Event(Event.collapsed)

    tree.find(Selector.open).removeClass(ClassName.open)
    parentLi.removeClass(ClassName.open)
    tree.slideUp(this.options.animationSpeed, function () {
      tree.find(Selector.open + ' > ' + Selector.treeview).slideUp()
      $(this.element).trigger(collapsedEvent)
    }.bind(this))
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Private

  Tree.prototype._setUpListeners = function () {
<<<<<<< HEAD
    var that = this;

    $(this.element).on('click', this.options.trigger, function (event) {
      that.toggle($(this), event);
    });
  };
=======
    var that = this

    $(this.element).on('click', this.options.trigger, function (event) {
      that.toggle($(this), event)
    })
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
<<<<<<< HEAD
      var $this = $(this);
      var data  = $this.data(DataKey);

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option);
        $this.data(DataKey, new Tree($this, options));
      }
    });
  }

  var old = $.fn.tree;

  $.fn.tree             = Plugin;
  $.fn.tree.Constructor = Tree;
=======
      var $this = $(this)
      var data  = $this.data(DataKey)

      if (!data) {
        var options = $.extend({}, Default, $this.data(), typeof option == 'object' && option)
        $this.data(DataKey, new Tree($this, options))
      }
    })
  }

  var old = $.fn.tree

  $.fn.tree             = Plugin
  $.fn.tree.Constructor = Tree
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // No Conflict Mode
  // ================
  $.fn.tree.noConflict = function () {
<<<<<<< HEAD
    $.fn.tree = old;
    return this;
  };
=======
    $.fn.tree = old
    return this
  }
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b

  // Tree Data API
  // =============
  $(window).on('load', function () {
    $(Selector.data).each(function () {
<<<<<<< HEAD
      Plugin.call($(this));
    });
  });

}(jQuery);
=======
      Plugin.call($(this))
    })
  })

}(jQuery)
>>>>>>> 348c139e2bbd18748e499cc4d7f20e1f2b097a4b
