/*!
* Bootstrap.js by @fat & @mdo
* Copyright 2012 Twitter, Inc.
* http://www.apache.org/licenses/LICENSE-2.0.txt
*/!function(e) {
  "use strict";
  e(function() {
    e.support.transition = function() {
      var e = function() {
        var e, t = document.createElement("bootstrap"), n = {
          WebkitTransition: "webkitTransitionEnd",
          MozTransition: "transitionend",
          OTransition: "oTransitionEnd otransitionend",
          transition: "transitionend"
        };
        for (e in n) if (void 0 !== t.style[e]) return n[e];
      }();
      return e && {
        end: e
      };
    }();
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = '[data-dismiss="alert"]', n = function(n) {
    e(n).on("click", t, this.close);
  };
  n.prototype.close = function(t) {
    function n() {
      r.trigger("closed").remove();
    }
    var r, i = e(this), s = i.attr("data-target");
    s || (s = i.attr("href"), s = s && s.replace(/.*(?=#[^\s]*$)/, "")), r = e(s), t && t.preventDefault(), r.length || (r = i.hasClass("alert") ? i : i.parent()), r.trigger(t = e.Event("close")), t.isDefaultPrevented() || (r.removeClass("in"), e.support.transition && r.hasClass("fade") ? r.on(e.support.transition.end, n) : n());
  };
  var r = e.fn.alert;
  e.fn.alert = function(t) {
    return this.each(function() {
      var r = e(this), i = r.data("alert");
      i || r.data("alert", i = new n(this)), "string" == typeof t && i[t].call(r);
    });
  }, e.fn.alert.Constructor = n, e.fn.alert.noConflict = function() {
    return e.fn.alert = r, this;
  }, e(document).on("click.alert.data-api", t, n.prototype.close);
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.$element = e(t), this.options = e.extend({}, e.fn.button.defaults, n);
  };
  t.prototype.setState = function(e) {
    var t = "disabled", n = this.$element, r = n.data(), i = n.is("input") ? "val" : "html";
    e += "Text", r.resetText || n.data("resetText", n[i]()), n[i](r[e] || this.options[e]), setTimeout(function() {
      "loadingText" == e ? n.addClass(t).attr(t, t) : n.removeClass(t).removeAttr(t);
    }, 0);
  }, t.prototype.toggle = function() {
    var e = this.$element.closest('[data-toggle="buttons-radio"]');
    e && e.find(".active").removeClass("active"), this.$element.toggleClass("active");
  };
  var n = e.fn.button;
  e.fn.button = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("button"), s = "object" == typeof n && n;
      i || r.data("button", i = new t(this, s)), "toggle" == n ? i.toggle() : n && i.setState(n);
    });
  }, e.fn.button.defaults = {
    loadingText: "loading..."
  }, e.fn.button.Constructor = t, e.fn.button.noConflict = function() {
    return e.fn.button = n, this;
  }, e(document).on("click.button.data-api", "[data-toggle^=button]", function(t) {
    var n = e(t.target);
    n.hasClass("btn") || (n = n.closest(".btn")), n.button("toggle");
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.$element = e(t), this.options = n, "hover" == this.options.pause && this.$element.on("mouseenter", e.proxy(this.pause, this)).on("mouseleave", e.proxy(this.cycle, this));
  };
  t.prototype = {
    cycle: function(t) {
      return t || (this.paused = !1), this.options.interval && !this.paused && (this.interval = setInterval(e.proxy(this.next, this), this.options.interval)), this;
    },
    to: function(t) {
      var n = this.$element.find(".item.active"), r = n.parent().children(), i = r.index(n), s = this;
      if (!(t > r.length - 1 || 0 > t)) return this.sliding ? this.$element.one("slid", function() {
        s.to(t);
      }) : i == t ? this.pause().cycle() : this.slide(t > i ? "next" : "prev", e(r[t]));
    },
    pause: function(t) {
      return t || (this.paused = !0), this.$element.find(".next, .prev").length && e.support.transition.end && (this.$element.trigger(e.support.transition.end), this.cycle()), clearInterval(this.interval), this.interval = null, this;
    },
    next: function() {
      return this.sliding ? void 0 : this.slide("next");
    },
    prev: function() {
      return this.sliding ? void 0 : this.slide("prev");
    },
    slide: function(t, n) {
      var r, i = this.$element.find(".item.active"), s = n || i[t](), o = this.interval, u = "next" == t ? "left" : "right", a = "next" == t ? "first" : "last", f = this;
      if (this.sliding = !0, o && this.pause(), s = s.length ? s : this.$element.find(".item")[a](), r = e.Event("slide", {
        relatedTarget: s[0]
      }), !s.hasClass("active")) {
        if (e.support.transition && this.$element.hasClass("slide")) {
          if (this.$element.trigger(r), r.isDefaultPrevented()) return;
          s.addClass(t), s[0].offsetWidth, i.addClass(u), s.addClass(u), this.$element.one(e.support.transition.end, function() {
            s.removeClass([ t, u ].join(" ")).addClass("active"), i.removeClass([ "active", u ].join(" ")), f.sliding = !1, setTimeout(function() {
              f.$element.trigger("slid");
            }, 0);
          });
        } else {
          if (this.$element.trigger(r), r.isDefaultPrevented()) return;
          i.removeClass("active"), s.addClass("active"), this.sliding = !1, this.$element.trigger("slid");
        }
        return o && this.cycle(), this;
      }
    }
  };
  var n = e.fn.carousel;
  e.fn.carousel = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("carousel"), s = e.extend({}, e.fn.carousel.defaults, "object" == typeof n && n), o = "string" == typeof n ? n : s.slide;
      i || r.data("carousel", i = new t(this, s)), "number" == typeof n ? i.to(n) : o ? i[o]() : s.interval && i.cycle();
    });
  }, e.fn.carousel.defaults = {
    interval: 5e3,
    pause: "hover"
  }, e.fn.carousel.Constructor = t, e.fn.carousel.noConflict = function() {
    return e.fn.carousel = n, this;
  }, e(document).on("click.carousel.data-api", "[data-slide]", function(t) {
    var n, r = e(this), i = e(r.attr("data-target") || (n = r.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, "")), s = e.extend({}, i.data(), r.data());
    i.carousel(s), t.preventDefault();
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.$element = e(t), this.options = e.extend({}, e.fn.collapse.defaults, n), this.options.parent && (this.$parent = e(this.options.parent)), this.options.toggle && this.toggle();
  };
  t.prototype = {
    constructor: t,
    dimension: function() {
      var e = this.$element.hasClass("width");
      return e ? "width" : "height";
    },
    show: function() {
      var t, n, r, i;
      if (!this.transitioning) {
        if (t = this.dimension(), n = e.camelCase([ "scroll", t ].join("-")), r = this.$parent && this.$parent.find("> .accordion-group > .in"), r && r.length) {
          if (i = r.data("collapse"), i && i.transitioning) return;
          r.collapse("hide"), i || r.data("collapse", null);
        }
        this.$element[t](0), this.transition("addClass", e.Event("show"), "shown"), e.support.transition && this.$element[t](this.$element[0][n]);
      }
    },
    hide: function() {
      var t;
      this.transitioning || (t = this.dimension(), this.reset(this.$element[t]()), this.transition("removeClass", e.Event("hide"), "hidden"), this.$element[t](0));
    },
    reset: function(e) {
      var t = this.dimension();
      return this.$element.removeClass("collapse")[t](e || "auto")[0].offsetWidth, this.$element[null !== e ? "addClass" : "removeClass"]("collapse"), this;
    },
    transition: function(t, n, r) {
      var i = this, s = function() {
        "show" == n.type && i.reset(), i.transitioning = 0, i.$element.trigger(r);
      };
      this.$element.trigger(n), n.isDefaultPrevented() || (this.transitioning = 1, this.$element[t]("in"), e.support.transition && this.$element.hasClass("collapse") ? this.$element.one(e.support.transition.end, s) : s());
    },
    toggle: function() {
      this[this.$element.hasClass("in") ? "hide" : "show"]();
    }
  };
  var n = e.fn.collapse;
  e.fn.collapse = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("collapse"), s = "object" == typeof n && n;
      i || r.data("collapse", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.collapse.defaults = {
    toggle: !0
  }, e.fn.collapse.Constructor = t, e.fn.collapse.noConflict = function() {
    return e.fn.collapse = n, this;
  }, e(document).on("click.collapse.data-api", "[data-toggle=collapse]", function(t) {
    var n, r = e(this), i = r.attr("data-target") || t.preventDefault() || (n = r.attr("href")) && n.replace(/.*(?=#[^\s]+$)/, ""), s = e(i).data("collapse") ? "toggle" : r.data();
    r[e(i).hasClass("in") ? "addClass" : "removeClass"]("collapsed"), e(i).collapse(s);
  });
}(window.jQuery), !function(e) {
  "use strict";
  function t() {
    e(r).each(function() {
      n(e(this)).removeClass("open");
    });
  }
  function n(t) {
    var n, r = t.attr("data-target");
    return r || (r = t.attr("href"), r = r && /#/.test(r) && r.replace(/.*(?=#[^\s]*$)/, "")), n = e(r), n.length || (n = t.parent()), n;
  }
  var r = "[data-toggle=dropdown]", i = function(t) {
    var n = e(t).on("click.dropdown.data-api", this.toggle);
    e("html").on("click.dropdown.data-api", function() {
      n.parent().removeClass("open");
    });
  };
  i.prototype = {
    constructor: i,
    toggle: function() {
      var r, i, s = e(this);
      if (!s.is(".disabled, :disabled")) return r = n(s), i = r.hasClass("open"), t(), i || r.toggleClass("open"), s.focus(), !1;
    },
    keydown: function(t) {
      var r, i, s, o, u;
      if (/(38|40|27)/.test(t.keyCode) && (r = e(this), t.preventDefault(), t.stopPropagation(), !r.is(".disabled, :disabled"))) {
        if (s = n(r), o = s.hasClass("open"), !o || o && 27 == t.keyCode) return r.click();
        i = e("[role=menu] li:not(.divider):visible a", s), i.length && (u = i.index(i.filter(":focus")), 38 == t.keyCode && u > 0 && u--, 40 == t.keyCode && i.length - 1 > u && u++, ~u || (u = 0), i.eq(u).focus());
      }
    }
  };
  var s = e.fn.dropdown;
  e.fn.dropdown = function(t) {
    return this.each(function() {
      var n = e(this), r = n.data("dropdown");
      r || n.data("dropdown", r = new i(this)), "string" == typeof t && r[t].call(n);
    });
  }, e.fn.dropdown.Constructor = i, e.fn.dropdown.noConflict = function() {
    return e.fn.dropdown = s, this;
  }, e(document).on("click.dropdown.data-api touchstart.dropdown.data-api", t).on("click.dropdown touchstart.dropdown.data-api", ".dropdown form", function(e) {
    e.stopPropagation();
  }).on("touchstart.dropdown.data-api", ".dropdown-menu", function(e) {
    e.stopPropagation();
  }).on("click.dropdown.data-api touchstart.dropdown.data-api", r, i.prototype.toggle).on("keydown.dropdown.data-api touchstart.dropdown.data-api", r + ", [role=menu]", i.prototype.keydown);
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.options = n, this.$element = e(t).delegate('[data-dismiss="modal"]', "click.dismiss.modal", e.proxy(this.hide, this)), this.options.remote && this.$element.find(".modal-body").load(this.options.remote);
  };
  t.prototype = {
    constructor: t,
    toggle: function() {
      return this[this.isShown ? "hide" : "show"]();
    },
    show: function() {
      var t = this, n = e.Event("show");
      this.$element.trigger(n), this.isShown || n.isDefaultPrevented() || (this.isShown = !0, this.escape(), this.backdrop(function() {
        var n = e.support.transition && t.$element.hasClass("fade");
        t.$element.parent().length || t.$element.appendTo(document.body), t.$element.show(), n && t.$element[0].offsetWidth, t.$element.addClass("in").attr("aria-hidden", !1), t.enforceFocus(), n ? t.$element.one(e.support.transition.end, function() {
          t.$element.focus().trigger("shown");
        }) : t.$element.focus().trigger("shown");
      }));
    },
    hide: function(t) {
      t && t.preventDefault(), t = e.Event("hide"), this.$element.trigger(t), this.isShown && !t.isDefaultPrevented() && (this.isShown = !1, this.escape(), e(document).off("focusin.modal"), this.$element.removeClass("in").attr("aria-hidden", !0), e.support.transition && this.$element.hasClass("fade") ? this.hideWithTransition() : this.hideModal());
    },
    enforceFocus: function() {
      var t = this;
      e(document).on("focusin.modal", function(e) {
        t.$element[0] === e.target || t.$element.has(e.target).length || t.$element.focus();
      });
    },
    escape: function() {
      var e = this;
      this.isShown && this.options.keyboard ? this.$element.on("keyup.dismiss.modal", function(t) {
        27 == t.which && e.hide();
      }) : this.isShown || this.$element.off("keyup.dismiss.modal");
    },
    hideWithTransition: function() {
      var t = this, n = setTimeout(function() {
        t.$element.off(e.support.transition.end), t.hideModal();
      }, 500);
      this.$element.one(e.support.transition.end, function() {
        clearTimeout(n), t.hideModal();
      });
    },
    hideModal: function() {
      this.$element.hide().trigger("hidden"), this.backdrop();
    },
    removeBackdrop: function() {
      this.$backdrop.remove(), this.$backdrop = null;
    },
    backdrop: function(t) {
      var n = this.$element.hasClass("fade") ? "fade" : "";
      if (this.isShown && this.options.backdrop) {
        var r = e.support.transition && n;
        this.$backdrop = e('<div class="modal-backdrop ' + n + '" />').appendTo(document.body), this.$backdrop.click("static" == this.options.backdrop ? e.proxy(this.$element[0].focus, this.$element[0]) : e.proxy(this.hide, this)), r && this.$backdrop[0].offsetWidth, this.$backdrop.addClass("in"), r ? this.$backdrop.one(e.support.transition.end, t) : t();
      } else !this.isShown && this.$backdrop ? (this.$backdrop.removeClass("in"), e.support.transition && this.$element.hasClass("fade") ? this.$backdrop.one(e.support.transition.end, e.proxy(this.removeBackdrop, this)) : this.removeBackdrop()) : t && t();
    }
  };
  var n = e.fn.modal;
  e.fn.modal = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("modal"), s = e.extend({}, e.fn.modal.defaults, r.data(), "object" == typeof n && n);
      i || r.data("modal", i = new t(this, s)), "string" == typeof n ? i[n]() : s.show && i.show();
    });
  }, e.fn.modal.defaults = {
    backdrop: !0,
    keyboard: !0,
    show: !0
  }, e.fn.modal.Constructor = t, e.fn.modal.noConflict = function() {
    return e.fn.modal = n, this;
  }, e(document).on("click.modal.data-api", '[data-toggle="modal"]', function(t) {
    var n = e(this), r = n.attr("href"), i = e(n.attr("data-target") || r && r.replace(/.*(?=#[^\s]+$)/, "")), s = i.data("modal") ? "toggle" : e.extend({
      remote: !/#/.test(r) && r
    }, i.data(), n.data());
    t.preventDefault(), i.modal(s).one("hide", function() {
      n.focus();
    });
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(e, t) {
    this.init("tooltip", e, t);
  };
  t.prototype = {
    constructor: t,
    init: function(t, n, r) {
      var i, s;
      this.type = t, this.$element = e(n), this.options = this.getOptions(r), this.enabled = !0, "click" == this.options.trigger ? this.$element.on("click." + this.type, this.options.selector, e.proxy(this.toggle, this)) : "manual" != this.options.trigger && (i = "hover" == this.options.trigger ? "mouseenter" : "focus", s = "hover" == this.options.trigger ? "mouseleave" : "blur", this.$element.on(i + "." + this.type, this.options.selector, e.proxy(this.enter, this)), this.$element.on(s + "." + this.type, this.options.selector, e.proxy(this.leave, this))), this.options.selector ? this._options = e.extend({}, this.options, {
        trigger: "manual",
        selector: ""
      }) : this.fixTitle();
    },
    getOptions: function(t) {
      return t = e.extend({}, e.fn[this.type].defaults, t, this.$element.data()), t.delay && "number" == typeof t.delay && (t.delay = {
        show: t.delay,
        hide: t.delay
      }), t;
    },
    enter: function(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);
      return n.options.delay && n.options.delay.show ? (clearTimeout(this.timeout), n.hoverState = "in", this.timeout = setTimeout(function() {
        "in" == n.hoverState && n.show();
      }, n.options.delay.show), void 0) : n.show();
    },
    leave: function(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);
      return this.timeout && clearTimeout(this.timeout), n.options.delay && n.options.delay.hide ? (n.hoverState = "out", this.timeout = setTimeout(function() {
        "out" == n.hoverState && n.hide();
      }, n.options.delay.hide), void 0) : n.hide();
    },
    show: function() {
      var e, t, n, r, i, s, o;
      if (this.hasContent() && this.enabled) {
        switch (e = this.tip(), this.setContent(), this.options.animation && e.addClass("fade"), s = "function" == typeof this.options.placement ? this.options.placement.call(this, e[0], this.$element[0]) : this.options.placement, t = /in/.test(s), e.detach().css({
          top: 0,
          left: 0,
          display: "block"
        }).insertAfter(this.$element), n = this.getPosition(t), r = e[0].offsetWidth, i = e[0].offsetHeight, t ? s.split(" ")[1] : s) {
         case "bottom":
          o = {
            top: n.top + n.height,
            left: n.left + n.width / 2 - r / 2
          };
          break;
         case "top":
          o = {
            top: n.top - i,
            left: n.left + n.width / 2 - r / 2
          };
          break;
         case "left":
          o = {
            top: n.top + n.height / 2 - i / 2,
            left: n.left - r
          };
          break;
         case "right":
          o = {
            top: n.top + n.height / 2 - i / 2,
            left: n.left + n.width
          };
        }
        e.offset(o).addClass(s).addClass("in");
      }
    },
    setContent: function() {
      var e = this.tip(), t = this.getTitle();
      e.find(".tooltip-inner")[this.options.html ? "html" : "text"](t), e.removeClass("fade in top bottom left right");
    },
    hide: function() {
      function t() {
        var t = setTimeout(function() {
          n.off(e.support.transition.end).detach();
        }, 500);
        n.one(e.support.transition.end, function() {
          clearTimeout(t), n.detach();
        });
      }
      var n = this.tip();
      return n.removeClass("in"), e.support.transition && this.$tip.hasClass("fade") ? t() : n.detach(), this;
    },
    fixTitle: function() {
      var e = this.$element;
      (e.attr("title") || "string" != typeof e.attr("data-original-title")) && e.attr("data-original-title", e.attr("title") || "").removeAttr("title");
    },
    hasContent: function() {
      return this.getTitle();
    },
    getPosition: function(t) {
      return e.extend({}, t ? {
        top: 0,
        left: 0
      } : this.$element.offset(), {
        width: this.$element[0].offsetWidth,
        height: this.$element[0].offsetHeight
      });
    },
    getTitle: function() {
      var e, t = this.$element, n = this.options;
      return e = t.attr("data-original-title") || ("function" == typeof n.title ? n.title.call(t[0]) : n.title);
    },
    tip: function() {
      return this.$tip = this.$tip || e(this.options.template);
    },
    validate: function() {
      this.$element[0].parentNode || (this.hide(), this.$element = null, this.options = null);
    },
    enable: function() {
      this.enabled = !0;
    },
    disable: function() {
      this.enabled = !1;
    },
    toggleEnabled: function() {
      this.enabled = !this.enabled;
    },
    toggle: function(t) {
      var n = e(t.currentTarget)[this.type](this._options).data(this.type);
      n[n.tip().hasClass("in") ? "hide" : "show"]();
    },
    destroy: function() {
      this.hide().$element.off("." + this.type).removeData(this.type);
    }
  };
  var n = e.fn.tooltip;
  e.fn.tooltip = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("tooltip"), s = "object" == typeof n && n;
      i || r.data("tooltip", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.tooltip.Constructor = t, e.fn.tooltip.defaults = {
    animation: !0,
    placement: "top",
    selector: !1,
    template: '<div class="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
    trigger: "hover",
    title: "",
    delay: 0,
    html: !1
  }, e.fn.tooltip.noConflict = function() {
    return e.fn.tooltip = n, this;
  };
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(e, t) {
    this.init("popover", e, t);
  };
  t.prototype = e.extend({}, e.fn.tooltip.Constructor.prototype, {
    constructor: t,
    setContent: function() {
      var e = this.tip(), t = this.getTitle(), n = this.getContent();
      e.find(".popover-title")[this.options.html ? "html" : "text"](t), e.find(".popover-content")[this.options.html ? "html" : "text"](n), e.removeClass("fade top bottom left right in");
    },
    hasContent: function() {
      return this.getTitle() || this.getContent();
    },
    getContent: function() {
      var e, t = this.$element, n = this.options;
      return e = t.attr("data-content") || ("function" == typeof n.content ? n.content.call(t[0]) : n.content);
    },
    tip: function() {
      return this.$tip || (this.$tip = e(this.options.template)), this.$tip;
    },
    destroy: function() {
      this.hide().$element.off("." + this.type).removeData(this.type);
    }
  });
  var n = e.fn.popover;
  e.fn.popover = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("popover"), s = "object" == typeof n && n;
      i || r.data("popover", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.popover.Constructor = t, e.fn.popover.defaults = e.extend({}, e.fn.tooltip.defaults, {
    placement: "right",
    trigger: "click",
    content: "",
    template: '<div class="popover"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>'
  }), e.fn.popover.noConflict = function() {
    return e.fn.popover = n, this;
  };
}(window.jQuery), !function(e) {
  "use strict";
  function t(t, n) {
    var r, i = e.proxy(this.process, this), s = e(t).is("body") ? e(window) : e(t);
    this.options = e.extend({}, e.fn.scrollspy.defaults, n), this.$scrollElement = s.on("scroll.scroll-spy.data-api", i), this.selector = (this.options.target || (r = e(t).attr("href")) && r.replace(/.*(?=#[^\s]+$)/, "") || "") + " .nav li > a", this.$body = e("body"), this.refresh(), this.process();
  }
  t.prototype = {
    constructor: t,
    refresh: function() {
      var t, n = this;
      this.offsets = e([]), this.targets = e([]), t = this.$body.find(this.selector).map(function() {
        var t = e(this), r = t.data("target") || t.attr("href"), i = /^#\w/.test(r) && e(r);
        return i && i.length && [ [ i.position().top + n.$scrollElement.scrollTop(), r ] ] || null;
      }).sort(function(e, t) {
        return e[0] - t[0];
      }).each(function() {
        n.offsets.push(this[0]), n.targets.push(this[1]);
      });
    },
    process: function() {
      var e, t = this.$scrollElement.scrollTop() + this.options.offset, n = this.$scrollElement[0].scrollHeight || this.$body[0].scrollHeight, r = n - this.$scrollElement.height(), i = this.offsets, s = this.targets, o = this.activeTarget;
      if (t >= r) return o != (e = s.last()[0]) && this.activate(e);
      for (e = i.length; e--; ) o != s[e] && t >= i[e] && (!i[e + 1] || i[e + 1] >= t) && this.activate(s[e]);
    },
    activate: function(t) {
      var n, r;
      this.activeTarget = t, e(this.selector).parent(".active").removeClass("active"), r = this.selector + '[data-target="' + t + '"],' + this.selector + '[href="' + t + '"]', n = e(r).parent("li").addClass("active"), n.parent(".dropdown-menu").length && (n = n.closest("li.dropdown").addClass("active")), n.trigger("activate");
    }
  };
  var n = e.fn.scrollspy;
  e.fn.scrollspy = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("scrollspy"), s = "object" == typeof n && n;
      i || r.data("scrollspy", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.scrollspy.Constructor = t, e.fn.scrollspy.defaults = {
    offset: 10
  }, e.fn.scrollspy.noConflict = function() {
    return e.fn.scrollspy = n, this;
  }, e(window).on("load", function() {
    e('[data-spy="scroll"]').each(function() {
      var t = e(this);
      t.scrollspy(t.data());
    });
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t) {
    this.element = e(t);
  };
  t.prototype = {
    constructor: t,
    show: function() {
      var t, n, r, i = this.element, s = i.closest("ul:not(.dropdown-menu)"), o = i.attr("data-target");
      o || (o = i.attr("href"), o = o && o.replace(/.*(?=#[^\s]*$)/, "")), i.parent("li").hasClass("active") || (t = s.find(".active:last a")[0], r = e.Event("show", {
        relatedTarget: t
      }), i.trigger(r), r.isDefaultPrevented() || (n = e(o), this.activate(i.parent("li"), s), this.activate(n, n.parent(), function() {
        i.trigger({
          type: "shown",
          relatedTarget: t
        });
      })));
    },
    activate: function(t, n, r) {
      function i() {
        s.removeClass("active").find("> .dropdown-menu > .active").removeClass("active"), t.addClass("active"), o ? (t[0].offsetWidth, t.addClass("in")) : t.removeClass("fade"), t.parent(".dropdown-menu") && t.closest("li.dropdown").addClass("active"), r && r();
      }
      var s = n.find("> .active"), o = r && e.support.transition && s.hasClass("fade");
      o ? s.one(e.support.transition.end, i) : i(), s.removeClass("in");
    }
  };
  var n = e.fn.tab;
  e.fn.tab = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("tab");
      i || r.data("tab", i = new t(this)), "string" == typeof n && i[n]();
    });
  }, e.fn.tab.Constructor = t, e.fn.tab.noConflict = function() {
    return e.fn.tab = n, this;
  }, e(document).on("click.tab.data-api", '[data-toggle="tab"], [data-toggle="pill"]', function(t) {
    t.preventDefault(), e(this).tab("show");
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.$element = e(t), this.options = e.extend({}, e.fn.typeahead.defaults, n), this.matcher = this.options.matcher || this.matcher, this.sorter = this.options.sorter || this.sorter, this.highlighter = this.options.highlighter || this.highlighter, this.updater = this.options.updater || this.updater, this.source = this.options.source, this.$menu = e(this.options.menu), this.shown = !1, this.listen();
  };
  t.prototype = {
    constructor: t,
    select: function() {
      var e = this.$menu.find(".active").attr("data-value");
      return this.$element.val(this.updater(e)).change(), this.hide();
    },
    updater: function(e) {
      return e;
    },
    show: function() {
      var t = e.extend({}, this.$element.position(), {
        height: this.$element[0].offsetHeight
      });
      return this.$menu.insertAfter(this.$element).css({
        top: t.top + t.height,
        left: t.left
      }).show(), this.shown = !0, this;
    },
    hide: function() {
      return this.$menu.hide(), this.shown = !1, this;
    },
    lookup: function() {
      var t;
      return this.query = this.$element.val(), !this.query || this.query.length < this.options.minLength ? this.shown ? this.hide() : this : (t = e.isFunction(this.source) ? this.source(this.query, e.proxy(this.process, this)) : this.source, t ? this.process(t) : this);
    },
    process: function(t) {
      var n = this;
      return t = e.grep(t, function(e) {
        return n.matcher(e);
      }), t = this.sorter(t), t.length ? this.render(t.slice(0, this.options.items)).show() : this.shown ? this.hide() : this;
    },
    matcher: function(e) {
      return ~e.toLowerCase().indexOf(this.query.toLowerCase());
    },
    sorter: function(e) {
      for (var t, n = [], r = [], i = []; t = e.shift(); ) t.toLowerCase().indexOf(this.query.toLowerCase()) ? ~t.indexOf(this.query) ? r.push(t) : i.push(t) : n.push(t);
      return n.concat(r, i);
    },
    highlighter: function(e) {
      var t = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&");
      return e.replace(RegExp("(" + t + ")", "ig"), function(e, t) {
        return "<strong>" + t + "</strong>";
      });
    },
    render: function(t) {
      var n = this;
      return t = e(t).map(function(t, r) {
        return t = e(n.options.item).attr("data-value", r), t.find("a").html(n.highlighter(r)), t[0];
      }), t.first().addClass("active"), this.$menu.html(t), this;
    },
    next: function() {
      var t = this.$menu.find(".active").removeClass("active"), n = t.next();
      n.length || (n = e(this.$menu.find("li")[0])), n.addClass("active");
    },
    prev: function() {
      var e = this.$menu.find(".active").removeClass("active"), t = e.prev();
      t.length || (t = this.$menu.find("li").last()), t.addClass("active");
    },
    listen: function() {
      this.$element.on("blur", e.proxy(this.blur, this)).on("keypress", e.proxy(this.keypress, this)).on("keyup", e.proxy(this.keyup, this)), this.eventSupported("keydown") && this.$element.on("keydown", e.proxy(this.keydown, this)), this.$menu.on("click", e.proxy(this.click, this)).on("mouseenter", "li", e.proxy(this.mouseenter, this));
    },
    eventSupported: function(e) {
      var t = e in this.$element;
      return t || (this.$element.setAttribute(e, "return;"), t = "function" == typeof this.$element[e]), t;
    },
    move: function(e) {
      if (this.shown) {
        switch (e.keyCode) {
         case 9:
         case 13:
         case 27:
          e.preventDefault();
          break;
         case 38:
          e.preventDefault(), this.prev();
          break;
         case 40:
          e.preventDefault(), this.next();
        }
        e.stopPropagation();
      }
    },
    keydown: function(t) {
      this.suppressKeyPressRepeat = ~e.inArray(t.keyCode, [ 40, 38, 9, 13, 27 ]), this.move(t);
    },
    keypress: function(e) {
      this.suppressKeyPressRepeat || this.move(e);
    },
    keyup: function(e) {
      switch (e.keyCode) {
       case 40:
       case 38:
       case 16:
       case 17:
       case 18:
        break;
       case 9:
       case 13:
        if (!this.shown) return;
        this.select();
        break;
       case 27:
        if (!this.shown) return;
        this.hide();
        break;
       default:
        this.lookup();
      }
      e.stopPropagation(), e.preventDefault();
    },
    blur: function() {
      var e = this;
      setTimeout(function() {
        e.hide();
      }, 150);
    },
    click: function(e) {
      e.stopPropagation(), e.preventDefault(), this.select();
    },
    mouseenter: function(t) {
      this.$menu.find(".active").removeClass("active"), e(t.currentTarget).addClass("active");
    }
  };
  var n = e.fn.typeahead;
  e.fn.typeahead = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("typeahead"), s = "object" == typeof n && n;
      i || r.data("typeahead", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.typeahead.defaults = {
    source: [],
    items: 8,
    menu: '<ul class="typeahead dropdown-menu"></ul>',
    item: '<li><a href="#"></a></li>',
    minLength: 1
  }, e.fn.typeahead.Constructor = t, e.fn.typeahead.noConflict = function() {
    return e.fn.typeahead = n, this;
  }, e(document).on("focus.typeahead.data-api", '[data-provide="typeahead"]', function(t) {
    var n = e(this);
    n.data("typeahead") || (t.preventDefault(), n.typeahead(n.data()));
  });
}(window.jQuery), !function(e) {
  "use strict";
  var t = function(t, n) {
    this.options = e.extend({}, e.fn.affix.defaults, n), this.$window = e(window).on("scroll.affix.data-api", e.proxy(this.checkPosition, this)).on("click.affix.data-api", e.proxy(function() {
      setTimeout(e.proxy(this.checkPosition, this), 1);
    }, this)), this.$element = e(t), this.checkPosition();
  };
  t.prototype.checkPosition = function() {
    if (this.$element.is(":visible")) {
      var t, n = e(document).height(), r = this.$window.scrollTop(), i = this.$element.offset(), s = this.options.offset, o = s.bottom, u = s.top, a = "affix affix-top affix-bottom";
      "object" != typeof s && (o = u = s), "function" == typeof u && (u = s.top()), "function" == typeof o && (o = s.bottom()), t = null != this.unpin && r + this.unpin <= i.top ? !1 : null != o && i.top + this.$element.height() >= n - o ? "bottom" : null != u && u >= r ? "top" : !1, this.affixed !== t && (this.affixed = t, this.unpin = "bottom" == t ? i.top - r : null, this.$element.removeClass(a).addClass("affix" + (t ? "-" + t : "")));
    }
  };
  var n = e.fn.affix;
  e.fn.affix = function(n) {
    return this.each(function() {
      var r = e(this), i = r.data("affix"), s = "object" == typeof n && n;
      i || r.data("affix", i = new t(this, s)), "string" == typeof n && i[n]();
    });
  }, e.fn.affix.Constructor = t, e.fn.affix.defaults = {
    offset: 0
  }, e.fn.affix.noConflict = function() {
    return e.fn.affix = n, this;
  }, e(window).on("load", function() {
    e('[data-spy="affix"]').each(function() {
      var t = e(this), n = t.data();
      n.offset = n.offset || {}, n.offsetBottom && (n.offset.bottom = n.offsetBottom), n.offsetTop && (n.offset.top = n.offsetTop), t.affix(n);
    });
  });
}(window.jQuery);