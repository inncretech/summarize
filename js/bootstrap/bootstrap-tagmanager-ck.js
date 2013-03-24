/* ===================================================
 * bootstrap-tagmanager.js v2.2
 * http://welldonethings.com/tags/manager
 * ===================================================
 * Copyright 2012 Max Favilli
 *
 * Licensed under the Mozilla Public License, Version 2.0 You may not use this work except in compliance with the License.
 *
 * http://www.mozilla.org/MPL/2.0/
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================== */"use strict";

(function(e) {
  if (typeof console == "undefined" || typeof console.log == "undefined") {
    console = {};
    console.log = function() {};
  }
  e.fn.tagsManager = function(t, n) {
    var r = {
      prefilled: null,
      CapitalizeFirstLetter: !1,
      preventSubmitOnEnter: !0,
      typeahead: !1,
      typeaheadAjaxSource: null,
      typeaheadAjaxPolling: !1,
      typeaheadSource: null,
      AjaxPush: null,
      delimeters: [ 44, 188, 13 ],
      backspace: [ 8 ],
      maxTags: 0,
      hiddenTagListName: null,
      deleteTagsOnBackspace: !0,
      tagsContainer: null,
      tagCloseIcon: "x",
      tagClass: ""
    };
    e.extend(r, t);
    r.hiddenTagListName === null && (r.hiddenTagListName = "hidden-" + this.attr("name"));
    var i = this, s = i.attr("name").replace(/[^\w]/g, "_"), o = "", u = r.delimeters, a = r.backspace, f = function() {
      if (!i.typeahead) return;
      if (r.typeaheadSource != null && e.isFunction(r.typeaheadSource)) i.typeahead({
        source: r.typeaheadSource
      }); else if (r.typeaheadSource != null) {
        i.typeahead();
        i.data("active", !0);
        i.data("typeahead").source = r.typeaheadSource;
        i.data("active", !1);
      } else if (r.typeaheadAjaxSource != null) if (!r.typeaheadAjaxPolling) {
        i.typeahead();
        e.getJSON(r.typeaheadAjaxSource, function(t) {
          var n = [];
          if (t != undefined && t.tags != undefined) {
            n.length = 0;
            e.each(t.tags, function(e, t) {
              var r = 1;
              n.push(t.tag);
              i.data("active", !0);
              i.data("typeahead").source = n;
              i.data("active", !1);
            });
          }
        });
      } else r.typeaheadAjaxPolling && i.typeahead({
        source: l
      }); else r.typeaheadDelegate && i.typeahead(r.typeaheadDelegate);
    }, l = function(t, n) {
      e.getJSON(r.typeaheadAjaxSource, function(t) {
        var r = [];
        if (t != undefined && t.tags != undefined) {
          r.length = 0;
          e.each(t.tags, function(e, t) {
            var n = 1;
            r.push(t.tag);
          });
          n(r);
        }
      });
    }, c = function(t) {
      var n = e.trim(t), r = n.length, i = 0;
      for (var s = r - 1; s >= 0; s--) {
        if (-1 == e.inArray(n.charCodeAt(s), u)) break;
        i++;
      }
      n = n.substring(0, r - i);
      r = n.length;
      i = 0;
      for (var s = 0; s < r; s++) {
        if (-1 == e.inArray(n.charCodeAt(s), u)) break;
        i++;
      }
      n = n.substring(i, r);
      return n;
    }, h = function() {
      var t = i.data("tlis"), n = i.data("tlid");
      if (n.length > 0) {
        var r = n.pop();
        t.pop();
        e("#" + s + "_" + r).remove();
        d();
      }
    }, p = function() {
      var t = i.data("tlis"), n = i.data("tlid");
      while (n.length > 0) {
        var r = n.pop();
        t.pop();
        e("#" + s + "_" + r).remove();
        d();
      }
    }, d = function() {
      var t = i.data("tlis"), n = i.data("lhiddenTagList");
      if (n == undefined) return;
      e(n).val(t.join(",")).change();
    }, v = function(t) {
      var n = i.data("tlis"), o = i.data("tlid"), u = e.inArray(t, o);
      if (-1 != u) {
        e("#" + s + "_" + t).remove();
        n.splice(u, 1);
        o.splice(u, 1);
        d();
      }
      r.maxTags > 0 && n.length < r.maxTags && i.show();
    }, m = function(t) {
      if (!t || t.length <= 0) return;
      r.CapitalizeFirstLetter && t.length > 1 && (t = t.charAt(0).toUpperCase() + t.slice(1).toLowerCase());
      if (r.validator !== undefined && r.validator(t) !== !0) return;
      var n = i.data("tlis"), o = i.data("tlid");
      if (r.maxTags > 0 && n.length >= r.maxTags) return;
      var u = !1, a = e.inArray(t, n);
      -1 != a && (u = !0);
      if (u) {
        var f = o[a];
        e("#" + s + "_" + f).stop().animate({
          backgroundColor: r.blinkBGColor_1
        }, 100).animate({
          backgroundColor: r.blinkBGColor_2
        }, 100).animate({
          backgroundColor: r.blinkBGColor_1
        }, 100).animate({
          backgroundColor: r.blinkBGColor_2
        }, 100).animate({
          backgroundColor: r.blinkBGColor_1
        }, 100).animate({
          backgroundColor: r.blinkBGColor_2
        }, 100);
      } else {
        var l = Math.max.apply(null, o);
        l = l == -Infinity ? 0 : l;
        var c = ++l;
        n.push(t);
        o.push(c);
        r.AjaxPush != null && e.post(r.AjaxPush, {
          tag: t
        });
        var h = s + "_" + c, p = s + "_Remover_" + c, m = "", g = r.tagClass ? " " + r.tagClass : "";
        m += '<span class="myTag' + g + '" id="' + h + '"><span>' + t + '&nbsp;&nbsp;</span><a href="#" class="myTagRemover" id="' + p + '" TagIdToRemove="' + c + '" title="Remove">' + r.tagCloseIcon + "</a></span> ";
        r.tagsContainer != null ? e(r.tagsContainer).append(m) : i.before(m);
        e("#" + p).on("click", i, function(t) {
          t.preventDefault();
          var n = parseInt(e(this).attr("TagIdToRemove"));
          v(n, t.data);
        });
        d();
        r.maxTags > 0 && n.length >= r.maxTags && i.hide();
      }
      i.val("");
    };
    return this.each(function() {
      if (typeof t == "string") {
        switch (t) {
         case "empty":
          p();
          break;
         case "popTag":
          h();
          break;
         case "pushTag":
          m(n);
        }
        return;
      }
      var s = new Array, l = new Array;
      i.data("tlis", s);
      i.data("tlid", l);
      var d = "";
      d += "<input name='" + r.hiddenTagListName + "' type='hidden' value=''/>";
      i.after(d);
      i.data("lhiddenTagList", i.siblings("input[name='" + r.hiddenTagListName + "']")[0]);
      r.typeahead && f();
      i.on("focus", function(t) {
        e(this).popover && e(this).popover("hide");
      });
      i.on("keypress", function(t) {
        e(this).popover && e(this).popover("hide");
        if (r.preventSubmitOnEnter && t.which == 13) {
          t.cancelBubble = !0;
          t.returnValue = !1;
          t.stopPropagation();
          t.preventDefault();
        }
      });
      i.on("keyup", i, function(t) {
        var n = e.inArray(t.which, u);
        if (-1 != n) {
          var r = e(this).val();
          r = c(r);
          m(r, t.data);
        }
      });
      r.deleteTagsOnBackspace && i.on("keydown", i, function(t) {
        var n = e.inArray(t.which, a);
        if (-1 != n) {
          var r = e(this).val(), i = r.length;
          if (i <= 0) {
            t.preventDefault();
            h();
          }
        }
      });
      i.change(function(t) {
        t.cancelBubble = !0;
        t.returnValue = !1;
        t.stopPropagation();
        t.preventDefault();
        var n = navigator.userAgent.indexOf("Chrome") > -1, r = navigator.userAgent.indexOf("MSIE") > -1, s = navigator.userAgent.indexOf("Firefox") > -1, u = navigator.userAgent.indexOf("Safari") > -1;
        !n && !u && e(this).focus();
        var a = e(".typeahead:visible");
        if (a[0] != undefined) {
          var f = $(this).data("typeahead").$menu.find(".active").attr("data-value");
          f = c(f);
          if (o == i.val() && o == f) {
            o = "";
            i.val(o);
          } else {
            m(f);
            o = f;
          }
        } else {
          var f = e(this).val();
          f = c(f);
          m(f);
        }
      });
      i.on("blur", function(t) {
        t.cancelBubble = !0;
        t.returnValue = !1;
        t.stopPropagation();
        t.preventDefault();
        var n = !0;
        if (r.typeahead) {
          var i = e(".typeahead:visible");
          i[0] != undefined ? n = !1 : n = !0;
        }
        if (n) {
          var s = e(this).val();
          s = c(s);
          m(s);
        }
      });
      if (r.prefilled != null) if (typeof r.prefilled == "object") {
        var v = r.prefilled;
        e.each(v, function(e, t) {
          var n = 1;
          m(t, i);
        });
      } else if (typeof r.prefilled == "string") {
        var v = r.prefilled.split(",");
        e.each(v, function(e, t) {
          var n = 1;
          m(t, i);
        });
      }
    });
  };
})(jQuery);