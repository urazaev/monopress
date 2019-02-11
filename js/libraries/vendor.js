"use strict";

var cssVarPoly = {
  init: function init() {
    if (window.CSS && window.CSS.supports && window.CSS.supports('(--foo: red)')) {
      console.log('your browser supports CSS variables, aborting and letting the native support handle things.');
      return;
    } else {
      console.log('no support for you! polyfill all (some of) the things!!');
      document.querySelector('body').classList.add('cssvars-polyfilled');
    }

    cssVarPoly.ratifiedVars = {};
    cssVarPoly.varsByBlock = {};
    cssVarPoly.oldCSS = {};
    cssVarPoly.findCSS();
    cssVarPoly.updateCSS();
  },
  findCSS: function findCSS() {
    var styleBlocks = document.querySelectorAll('style:not(.inserted),link[rel="stylesheet"],link[rel="import"]');
    var counter = 1;
    [].forEach.call(styleBlocks, function (block) {
      var theCSS;

      if (block.nodeName === 'STYLE') {
        theCSS = block.innerHTML;
        cssVarPoly.findSetters(theCSS, counter);
      } else if (block.nodeName === 'LINK') {
        cssVarPoly.getLink(block.getAttribute('href'), counter, function (counter, request) {
          cssVarPoly.findSetters(request.responseText, counter);
          cssVarPoly.oldCSS[counter] = request.responseText;
          cssVarPoly.updateCSS();
        });
        theCSS = '';
      }

      cssVarPoly.oldCSS[counter] = theCSS;
      counter++;
    });
  },
  findSetters: function findSetters(theCSS, counter) {
    cssVarPoly.varsByBlock[counter] = theCSS.match(/(--.+:.+;)/g) || [];
  },
  updateCSS: function updateCSS() {
    cssVarPoly.ratifySetters(cssVarPoly.varsByBlock);

    for (var curCSSID in cssVarPoly.oldCSS) {
      var newCSS = cssVarPoly.replaceGetters(cssVarPoly.oldCSS[curCSSID], cssVarPoly.ratifiedVars);

      if (document.querySelector('#inserted' + curCSSID)) {
        document.querySelector('#inserted' + curCSSID).innerHTML = newCSS;
      } else {
        var style = document.createElement('style');
        style.type = 'text/css';
        style.innerHTML = newCSS;
        style.classList.add('inserted');
        style.id = 'inserted' + curCSSID;
        document.getElementsByTagName('head')[0].appendChild(style);
      }
    }
  },
  replaceGetters: function replaceGetters(curCSS, varList) {
    for (var theVar in varList) {
      var getterRegex = new RegExp('var\\(\\s*' + theVar + '\\s*\\)', 'g');
      curCSS = curCSS.replace(getterRegex, varList[theVar]);
      var getterRegex2 = new RegExp('var\\(\\s*.+\\s*,\\s*(.+)\\)', 'g');
      var matches = curCSS.match(getterRegex2);

      if (matches) {
        matches.forEach(function (match) {
          curCSS = curCSS.replace(match, match.match(/var\(.+,\s*(.+)\)/)[1]);
        });
      }
    }

    ;
    return curCSS;
  },
  ratifySetters: function ratifySetters(varList) {
    for (var curBlock in varList) {
      var curVars = varList[curBlock];
      curVars.forEach(function (theVar) {
        var matches = theVar.split(/:\s*/);
        cssVarPoly.ratifiedVars[matches[0]] = matches[1].replace(/;/, '');
      });
    }
  },
  getLink: function getLink(url, counter, success) {
    var request = new XMLHttpRequest();
    request.open('GET', url, !0);
    request.overrideMimeType('text/css;');

    request.onload = function () {
      if (request.status >= 200 && request.status < 400) {
        if (typeof success === 'function') {
          success(counter, request);
        }
      } else {
        console.warn('an error was returned from:', url);
      }
    };

    request.onerror = function () {
      console.warn('we could not get anything from:', url);
    };

    request.send();
  }
};
cssVarPoly.init();
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! jQuery v2.2.4 | (c) jQuery Foundation | jquery.org/license */
!function (a, b) {
  "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && "object" == _typeof(module.exports) ? module.exports = a.document ? b(a, !0) : function (a) {
    if (!a.document) throw new Error("jQuery requires a window with a document");
    return b(a);
  } : b(a);
}("undefined" != typeof window ? window : void 0, function (a, b) {
  var c = [],
      d = a.document,
      e = c.slice,
      f = c.concat,
      g = c.push,
      h = c.indexOf,
      i = {},
      j = i.toString,
      k = i.hasOwnProperty,
      l = {},
      m = "2.2.4",
      n = function n(a, b) {
    return new n.fn.init(a, b);
  },
      o = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
      p = /^-ms-/,
      q = /-([\da-z])/gi,
      r = function r(a, b) {
    return b.toUpperCase();
  };

  n.fn = n.prototype = {
    jquery: m,
    constructor: n,
    selector: "",
    length: 0,
    toArray: function toArray() {
      return e.call(this);
    },
    get: function get(a) {
      return null != a ? 0 > a ? this[a + this.length] : this[a] : e.call(this);
    },
    pushStack: function pushStack(a) {
      var b = n.merge(this.constructor(), a);
      return b.prevObject = this, b.context = this.context, b;
    },
    each: function each(a) {
      return n.each(this, a);
    },
    map: function map(a) {
      return this.pushStack(n.map(this, function (b, c) {
        return a.call(b, c, b);
      }));
    },
    slice: function slice() {
      return this.pushStack(e.apply(this, arguments));
    },
    first: function first() {
      return this.eq(0);
    },
    last: function last() {
      return this.eq(-1);
    },
    eq: function eq(a) {
      var b = this.length,
          c = +a + (0 > a ? b : 0);
      return this.pushStack(c >= 0 && b > c ? [this[c]] : []);
    },
    end: function end() {
      return this.prevObject || this.constructor();
    },
    push: g,
    sort: c.sort,
    splice: c.splice
  }, n.extend = n.fn.extend = function () {
    var a,
        b,
        c,
        d,
        e,
        f,
        g = arguments[0] || {},
        h = 1,
        i = arguments.length,
        j = !1;

    for ("boolean" == typeof g && (j = g, g = arguments[h] || {}, h++), "object" == _typeof(g) || n.isFunction(g) || (g = {}), h === i && (g = this, h--); i > h; h++) {
      if (null != (a = arguments[h])) for (b in a) {
        c = g[b], d = a[b], g !== d && (j && d && (n.isPlainObject(d) || (e = n.isArray(d))) ? (e ? (e = !1, f = c && n.isArray(c) ? c : []) : f = c && n.isPlainObject(c) ? c : {}, g[b] = n.extend(j, f, d)) : void 0 !== d && (g[b] = d));
      }
    }

    return g;
  }, n.extend({
    expando: "jQuery" + (m + Math.random()).replace(/\D/g, ""),
    isReady: !0,
    error: function error(a) {
      throw new Error(a);
    },
    noop: function noop() {},
    isFunction: function isFunction(a) {
      return "function" === n.type(a);
    },
    isArray: Array.isArray,
    isWindow: function isWindow(a) {
      return null != a && a === a.window;
    },
    isNumeric: function isNumeric(a) {
      var b = a && a.toString();
      return !n.isArray(a) && b - parseFloat(b) + 1 >= 0;
    },
    isPlainObject: function isPlainObject(a) {
      var b;
      if ("object" !== n.type(a) || a.nodeType || n.isWindow(a)) return !1;
      if (a.constructor && !k.call(a, "constructor") && !k.call(a.constructor.prototype || {}, "isPrototypeOf")) return !1;

      for (b in a) {
        ;
      }

      return void 0 === b || k.call(a, b);
    },
    isEmptyObject: function isEmptyObject(a) {
      var b;

      for (b in a) {
        return !1;
      }

      return !0;
    },
    type: function type(a) {
      return null == a ? a + "" : "object" == _typeof(a) || "function" == typeof a ? i[j.call(a)] || "object" : _typeof(a);
    },
    globalEval: function globalEval(a) {
      var b,
          c = eval;
      a = n.trim(a), a && (1 === a.indexOf("use strict") ? (b = d.createElement("script"), b.text = a, d.head.appendChild(b).parentNode.removeChild(b)) : c(a));
    },
    camelCase: function camelCase(a) {
      return a.replace(p, "ms-").replace(q, r);
    },
    nodeName: function nodeName(a, b) {
      return a.nodeName && a.nodeName.toLowerCase() === b.toLowerCase();
    },
    each: function each(a, b) {
      var c,
          d = 0;

      if (s(a)) {
        for (c = a.length; c > d; d++) {
          if (b.call(a[d], d, a[d]) === !1) break;
        }
      } else for (d in a) {
        if (b.call(a[d], d, a[d]) === !1) break;
      }

      return a;
    },
    trim: function trim(a) {
      return null == a ? "" : (a + "").replace(o, "");
    },
    makeArray: function makeArray(a, b) {
      var c = b || [];
      return null != a && (s(Object(a)) ? n.merge(c, "string" == typeof a ? [a] : a) : g.call(c, a)), c;
    },
    inArray: function inArray(a, b, c) {
      return null == b ? -1 : h.call(b, a, c);
    },
    merge: function merge(a, b) {
      for (var c = +b.length, d = 0, e = a.length; c > d; d++) {
        a[e++] = b[d];
      }

      return a.length = e, a;
    },
    grep: function grep(a, b, c) {
      for (var d, e = [], f = 0, g = a.length, h = !c; g > f; f++) {
        d = !b(a[f], f), d !== h && e.push(a[f]);
      }

      return e;
    },
    map: function map(a, b, c) {
      var d,
          e,
          g = 0,
          h = [];
      if (s(a)) for (d = a.length; d > g; g++) {
        e = b(a[g], g, c), null != e && h.push(e);
      } else for (g in a) {
        e = b(a[g], g, c), null != e && h.push(e);
      }
      return f.apply([], h);
    },
    guid: 1,
    proxy: function proxy(a, b) {
      var c, d, f;
      return "string" == typeof b && (c = a[b], b = a, a = c), n.isFunction(a) ? (d = e.call(arguments, 2), f = function f() {
        return a.apply(b || this, d.concat(e.call(arguments)));
      }, f.guid = a.guid = a.guid || n.guid++, f) : void 0;
    },
    now: Date.now,
    support: l
  }), "function" == typeof Symbol && (n.fn[Symbol.iterator] = c[Symbol.iterator]), n.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), function (a, b) {
    i["[object " + b + "]"] = b.toLowerCase();
  });

  function s(a) {
    var b = !!a && "length" in a && a.length,
        c = n.type(a);
    return "function" === c || n.isWindow(a) ? !1 : "array" === c || 0 === b || "number" == typeof b && b > 0 && b - 1 in a;
  }

  var t = function (a) {
    var b,
        c,
        d,
        e,
        f,
        g,
        h,
        i,
        j,
        k,
        l,
        m,
        n,
        o,
        p,
        q,
        r,
        s,
        t,
        u = "sizzle" + 1 * new Date(),
        v = a.document,
        w = 0,
        x = 0,
        y = ga(),
        z = ga(),
        A = ga(),
        B = function B(a, b) {
      return a === b && (l = !0), 0;
    },
        C = 1 << 31,
        D = {}.hasOwnProperty,
        E = [],
        F = E.pop,
        G = E.push,
        H = E.push,
        I = E.slice,
        J = function J(a, b) {
      for (var c = 0, d = a.length; d > c; c++) {
        if (a[c] === b) return c;
      }

      return -1;
    },
        K = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
        L = "[\\x20\\t\\r\\n\\f]",
        M = "(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",
        N = "\\[" + L + "*(" + M + ")(?:" + L + "*([*^$|!~]?=)" + L + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + M + "))|)" + L + "*\\]",
        O = ":(" + M + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + N + ")*)|.*)\\)|)",
        P = new RegExp(L + "+", "g"),
        Q = new RegExp("^" + L + "+|((?:^|[^\\\\])(?:\\\\.)*)" + L + "+$", "g"),
        R = new RegExp("^" + L + "*," + L + "*"),
        S = new RegExp("^" + L + "*([>+~]|" + L + ")" + L + "*"),
        T = new RegExp("=" + L + "*([^\\]'\"]*?)" + L + "*\\]", "g"),
        U = new RegExp(O),
        V = new RegExp("^" + M + "$"),
        W = {
      ID: new RegExp("^#(" + M + ")"),
      CLASS: new RegExp("^\\.(" + M + ")"),
      TAG: new RegExp("^(" + M + "|[*])"),
      ATTR: new RegExp("^" + N),
      PSEUDO: new RegExp("^" + O),
      CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + L + "*(even|odd|(([+-]|)(\\d*)n|)" + L + "*(?:([+-]|)" + L + "*(\\d+)|))" + L + "*\\)|)", "i"),
      bool: new RegExp("^(?:" + K + ")$", "i"),
      needsContext: new RegExp("^" + L + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + L + "*((?:-\\d)?\\d*)" + L + "*\\)|)(?=[^-]|$)", "i")
    },
        X = /^(?:input|select|textarea|button)$/i,
        Y = /^h\d$/i,
        Z = /^[^{]+\{\s*\[native \w/,
        $ = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
        _ = /[+~]/,
        aa = /'|\\/g,
        ba = new RegExp("\\\\([\\da-f]{1,6}" + L + "?|(" + L + ")|.)", "ig"),
        ca = function ca(a, b, c) {
      var d = "0x" + b - 65536;
      return d !== d || c ? b : 0 > d ? String.fromCharCode(d + 65536) : String.fromCharCode(d >> 10 | 55296, 1023 & d | 56320);
    },
        da = function da() {
      m();
    };

    try {
      H.apply(E = I.call(v.childNodes), v.childNodes), E[v.childNodes.length].nodeType;
    } catch (ea) {
      H = {
        apply: E.length ? function (a, b) {
          G.apply(a, I.call(b));
        } : function (a, b) {
          var c = a.length,
              d = 0;

          while (a[c++] = b[d++]) {
            ;
          }

          a.length = c - 1;
        }
      };
    }

    function fa(a, b, d, e) {
      var f,
          h,
          j,
          k,
          l,
          o,
          r,
          s,
          w = b && b.ownerDocument,
          x = b ? b.nodeType : 9;
      if (d = d || [], "string" != typeof a || !a || 1 !== x && 9 !== x && 11 !== x) return d;

      if (!e && ((b ? b.ownerDocument || b : v) !== n && m(b), b = b || n, p)) {
        if (11 !== x && (o = $.exec(a))) if (f = o[1]) {
          if (9 === x) {
            if (!(j = b.getElementById(f))) return d;
            if (j.id === f) return d.push(j), d;
          } else if (w && (j = w.getElementById(f)) && t(b, j) && j.id === f) return d.push(j), d;
        } else {
          if (o[2]) return H.apply(d, b.getElementsByTagName(a)), d;
          if ((f = o[3]) && c.getElementsByClassName && b.getElementsByClassName) return H.apply(d, b.getElementsByClassName(f)), d;
        }

        if (c.qsa && !A[a + " "] && (!q || !q.test(a))) {
          if (1 !== x) w = b, s = a;else if ("object" !== b.nodeName.toLowerCase()) {
            (k = b.getAttribute("id")) ? k = k.replace(aa, "\\$&") : b.setAttribute("id", k = u), r = g(a), h = r.length, l = V.test(k) ? "#" + k : "[id='" + k + "']";

            while (h--) {
              r[h] = l + " " + qa(r[h]);
            }

            s = r.join(","), w = _.test(a) && oa(b.parentNode) || b;
          }
          if (s) try {
            return H.apply(d, w.querySelectorAll(s)), d;
          } catch (y) {} finally {
            k === u && b.removeAttribute("id");
          }
        }
      }

      return i(a.replace(Q, "$1"), b, d, e);
    }

    function ga() {
      var a = [];

      function b(c, e) {
        return a.push(c + " ") > d.cacheLength && delete b[a.shift()], b[c + " "] = e;
      }

      return b;
    }

    function ha(a) {
      return a[u] = !0, a;
    }

    function ia(a) {
      var b = n.createElement("div");

      try {
        return !!a(b);
      } catch (c) {
        return !1;
      } finally {
        b.parentNode && b.parentNode.removeChild(b), b = null;
      }
    }

    function ja(a, b) {
      var c = a.split("|"),
          e = c.length;

      while (e--) {
        d.attrHandle[c[e]] = b;
      }
    }

    function ka(a, b) {
      var c = b && a,
          d = c && 1 === a.nodeType && 1 === b.nodeType && (~b.sourceIndex || C) - (~a.sourceIndex || C);
      if (d) return d;
      if (c) while (c = c.nextSibling) {
        if (c === b) return -1;
      }
      return a ? 1 : -1;
    }

    function la(a) {
      return function (b) {
        var c = b.nodeName.toLowerCase();
        return "input" === c && b.type === a;
      };
    }

    function ma(a) {
      return function (b) {
        var c = b.nodeName.toLowerCase();
        return ("input" === c || "button" === c) && b.type === a;
      };
    }

    function na(a) {
      return ha(function (b) {
        return b = +b, ha(function (c, d) {
          var e,
              f = a([], c.length, b),
              g = f.length;

          while (g--) {
            c[e = f[g]] && (c[e] = !(d[e] = c[e]));
          }
        });
      });
    }

    function oa(a) {
      return a && "undefined" != typeof a.getElementsByTagName && a;
    }

    c = fa.support = {}, f = fa.isXML = function (a) {
      var b = a && (a.ownerDocument || a).documentElement;
      return b ? "HTML" !== b.nodeName : !1;
    }, m = fa.setDocument = function (a) {
      var b,
          e,
          g = a ? a.ownerDocument || a : v;
      return g !== n && 9 === g.nodeType && g.documentElement ? (n = g, o = n.documentElement, p = !f(n), (e = n.defaultView) && e.top !== e && (e.addEventListener ? e.addEventListener("unload", da, !1) : e.attachEvent && e.attachEvent("onunload", da)), c.attributes = ia(function (a) {
        return a.className = "i", !a.getAttribute("className");
      }), c.getElementsByTagName = ia(function (a) {
        return a.appendChild(n.createComment("")), !a.getElementsByTagName("*").length;
      }), c.getElementsByClassName = Z.test(n.getElementsByClassName), c.getById = ia(function (a) {
        return o.appendChild(a).id = u, !n.getElementsByName || !n.getElementsByName(u).length;
      }), c.getById ? (d.find.ID = function (a, b) {
        if ("undefined" != typeof b.getElementById && p) {
          var c = b.getElementById(a);
          return c ? [c] : [];
        }
      }, d.filter.ID = function (a) {
        var b = a.replace(ba, ca);
        return function (a) {
          return a.getAttribute("id") === b;
        };
      }) : (delete d.find.ID, d.filter.ID = function (a) {
        var b = a.replace(ba, ca);
        return function (a) {
          var c = "undefined" != typeof a.getAttributeNode && a.getAttributeNode("id");
          return c && c.value === b;
        };
      }), d.find.TAG = c.getElementsByTagName ? function (a, b) {
        return "undefined" != typeof b.getElementsByTagName ? b.getElementsByTagName(a) : c.qsa ? b.querySelectorAll(a) : void 0;
      } : function (a, b) {
        var c,
            d = [],
            e = 0,
            f = b.getElementsByTagName(a);

        if ("*" === a) {
          while (c = f[e++]) {
            1 === c.nodeType && d.push(c);
          }

          return d;
        }

        return f;
      }, d.find.CLASS = c.getElementsByClassName && function (a, b) {
        return "undefined" != typeof b.getElementsByClassName && p ? b.getElementsByClassName(a) : void 0;
      }, r = [], q = [], (c.qsa = Z.test(n.querySelectorAll)) && (ia(function (a) {
        o.appendChild(a).innerHTML = "<a id='" + u + "'></a><select id='" + u + "-\r\\' msallowcapture=''><option selected=''></option></select>", a.querySelectorAll("[msallowcapture^='']").length && q.push("[*^$]=" + L + "*(?:''|\"\")"), a.querySelectorAll("[selected]").length || q.push("\\[" + L + "*(?:value|" + K + ")"), a.querySelectorAll("[id~=" + u + "-]").length || q.push("~="), a.querySelectorAll(":checked").length || q.push(":checked"), a.querySelectorAll("a#" + u + "+*").length || q.push(".#.+[+~]");
      }), ia(function (a) {
        var b = n.createElement("input");
        b.setAttribute("type", "hidden"), a.appendChild(b).setAttribute("name", "D"), a.querySelectorAll("[name=d]").length && q.push("name" + L + "*[*^$|!~]?="), a.querySelectorAll(":enabled").length || q.push(":enabled", ":disabled"), a.querySelectorAll("*,:x"), q.push(",.*:");
      })), (c.matchesSelector = Z.test(s = o.matches || o.webkitMatchesSelector || o.mozMatchesSelector || o.oMatchesSelector || o.msMatchesSelector)) && ia(function (a) {
        c.disconnectedMatch = s.call(a, "div"), s.call(a, "[s!='']:x"), r.push("!=", O);
      }), q = q.length && new RegExp(q.join("|")), r = r.length && new RegExp(r.join("|")), b = Z.test(o.compareDocumentPosition), t = b || Z.test(o.contains) ? function (a, b) {
        var c = 9 === a.nodeType ? a.documentElement : a,
            d = b && b.parentNode;
        return a === d || !(!d || 1 !== d.nodeType || !(c.contains ? c.contains(d) : a.compareDocumentPosition && 16 & a.compareDocumentPosition(d)));
      } : function (a, b) {
        if (b) while (b = b.parentNode) {
          if (b === a) return !0;
        }
        return !1;
      }, B = b ? function (a, b) {
        if (a === b) return l = !0, 0;
        var d = !a.compareDocumentPosition - !b.compareDocumentPosition;
        return d ? d : (d = (a.ownerDocument || a) === (b.ownerDocument || b) ? a.compareDocumentPosition(b) : 1, 1 & d || !c.sortDetached && b.compareDocumentPosition(a) === d ? a === n || a.ownerDocument === v && t(v, a) ? -1 : b === n || b.ownerDocument === v && t(v, b) ? 1 : k ? J(k, a) - J(k, b) : 0 : 4 & d ? -1 : 1);
      } : function (a, b) {
        if (a === b) return l = !0, 0;
        var c,
            d = 0,
            e = a.parentNode,
            f = b.parentNode,
            g = [a],
            h = [b];
        if (!e || !f) return a === n ? -1 : b === n ? 1 : e ? -1 : f ? 1 : k ? J(k, a) - J(k, b) : 0;
        if (e === f) return ka(a, b);
        c = a;

        while (c = c.parentNode) {
          g.unshift(c);
        }

        c = b;

        while (c = c.parentNode) {
          h.unshift(c);
        }

        while (g[d] === h[d]) {
          d++;
        }

        return d ? ka(g[d], h[d]) : g[d] === v ? -1 : h[d] === v ? 1 : 0;
      }, n) : n;
    }, fa.matches = function (a, b) {
      return fa(a, null, null, b);
    }, fa.matchesSelector = function (a, b) {
      if ((a.ownerDocument || a) !== n && m(a), b = b.replace(T, "='$1']"), c.matchesSelector && p && !A[b + " "] && (!r || !r.test(b)) && (!q || !q.test(b))) try {
        var d = s.call(a, b);
        if (d || c.disconnectedMatch || a.document && 11 !== a.document.nodeType) return d;
      } catch (e) {}
      return fa(b, n, null, [a]).length > 0;
    }, fa.contains = function (a, b) {
      return (a.ownerDocument || a) !== n && m(a), t(a, b);
    }, fa.attr = function (a, b) {
      (a.ownerDocument || a) !== n && m(a);
      var e = d.attrHandle[b.toLowerCase()],
          f = e && D.call(d.attrHandle, b.toLowerCase()) ? e(a, b, !p) : void 0;
      return void 0 !== f ? f : c.attributes || !p ? a.getAttribute(b) : (f = a.getAttributeNode(b)) && f.specified ? f.value : null;
    }, fa.error = function (a) {
      throw new Error("Syntax error, unrecognized expression: " + a);
    }, fa.uniqueSort = function (a) {
      var b,
          d = [],
          e = 0,
          f = 0;

      if (l = !c.detectDuplicates, k = !c.sortStable && a.slice(0), a.sort(B), l) {
        while (b = a[f++]) {
          b === a[f] && (e = d.push(f));
        }

        while (e--) {
          a.splice(d[e], 1);
        }
      }

      return k = null, a;
    }, e = fa.getText = function (a) {
      var b,
          c = "",
          d = 0,
          f = a.nodeType;

      if (f) {
        if (1 === f || 9 === f || 11 === f) {
          if ("string" == typeof a.textContent) return a.textContent;

          for (a = a.firstChild; a; a = a.nextSibling) {
            c += e(a);
          }
        } else if (3 === f || 4 === f) return a.nodeValue;
      } else while (b = a[d++]) {
        c += e(b);
      }

      return c;
    }, d = fa.selectors = {
      cacheLength: 50,
      createPseudo: ha,
      match: W,
      attrHandle: {},
      find: {},
      relative: {
        ">": {
          dir: "parentNode",
          first: !0
        },
        " ": {
          dir: "parentNode"
        },
        "+": {
          dir: "previousSibling",
          first: !0
        },
        "~": {
          dir: "previousSibling"
        }
      },
      preFilter: {
        ATTR: function ATTR(a) {
          return a[1] = a[1].replace(ba, ca), a[3] = (a[3] || a[4] || a[5] || "").replace(ba, ca), "~=" === a[2] && (a[3] = " " + a[3] + " "), a.slice(0, 4);
        },
        CHILD: function CHILD(a) {
          return a[1] = a[1].toLowerCase(), "nth" === a[1].slice(0, 3) ? (a[3] || fa.error(a[0]), a[4] = +(a[4] ? a[5] + (a[6] || 1) : 2 * ("even" === a[3] || "odd" === a[3])), a[5] = +(a[7] + a[8] || "odd" === a[3])) : a[3] && fa.error(a[0]), a;
        },
        PSEUDO: function PSEUDO(a) {
          var b,
              c = !a[6] && a[2];
          return W.CHILD.test(a[0]) ? null : (a[3] ? a[2] = a[4] || a[5] || "" : c && U.test(c) && (b = g(c, !0)) && (b = c.indexOf(")", c.length - b) - c.length) && (a[0] = a[0].slice(0, b), a[2] = c.slice(0, b)), a.slice(0, 3));
        }
      },
      filter: {
        TAG: function TAG(a) {
          var b = a.replace(ba, ca).toLowerCase();
          return "*" === a ? function () {
            return !0;
          } : function (a) {
            return a.nodeName && a.nodeName.toLowerCase() === b;
          };
        },
        CLASS: function CLASS(a) {
          var b = y[a + " "];
          return b || (b = new RegExp("(^|" + L + ")" + a + "(" + L + "|$)")) && y(a, function (a) {
            return b.test("string" == typeof a.className && a.className || "undefined" != typeof a.getAttribute && a.getAttribute("class") || "");
          });
        },
        ATTR: function ATTR(a, b, c) {
          return function (d) {
            var e = fa.attr(d, a);
            return null == e ? "!=" === b : b ? (e += "", "=" === b ? e === c : "!=" === b ? e !== c : "^=" === b ? c && 0 === e.indexOf(c) : "*=" === b ? c && e.indexOf(c) > -1 : "$=" === b ? c && e.slice(-c.length) === c : "~=" === b ? (" " + e.replace(P, " ") + " ").indexOf(c) > -1 : "|=" === b ? e === c || e.slice(0, c.length + 1) === c + "-" : !1) : !0;
          };
        },
        CHILD: function CHILD(a, b, c, d, e) {
          var f = "nth" !== a.slice(0, 3),
              g = "last" !== a.slice(-4),
              h = "of-type" === b;
          return 1 === d && 0 === e ? function (a) {
            return !!a.parentNode;
          } : function (b, c, i) {
            var j,
                k,
                l,
                m,
                n,
                o,
                p = f !== g ? "nextSibling" : "previousSibling",
                q = b.parentNode,
                r = h && b.nodeName.toLowerCase(),
                s = !i && !h,
                t = !1;

            if (q) {
              if (f) {
                while (p) {
                  m = b;

                  while (m = m[p]) {
                    if (h ? m.nodeName.toLowerCase() === r : 1 === m.nodeType) return !1;
                  }

                  o = p = "only" === a && !o && "nextSibling";
                }

                return !0;
              }

              if (o = [g ? q.firstChild : q.lastChild], g && s) {
                m = q, l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), j = k[a] || [], n = j[0] === w && j[1], t = n && j[2], m = n && q.childNodes[n];

                while (m = ++n && m && m[p] || (t = n = 0) || o.pop()) {
                  if (1 === m.nodeType && ++t && m === b) {
                    k[a] = [w, n, t];
                    break;
                  }
                }
              } else if (s && (m = b, l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), j = k[a] || [], n = j[0] === w && j[1], t = n), t === !1) while (m = ++n && m && m[p] || (t = n = 0) || o.pop()) {
                if ((h ? m.nodeName.toLowerCase() === r : 1 === m.nodeType) && ++t && (s && (l = m[u] || (m[u] = {}), k = l[m.uniqueID] || (l[m.uniqueID] = {}), k[a] = [w, t]), m === b)) break;
              }

              return t -= e, t === d || t % d === 0 && t / d >= 0;
            }
          };
        },
        PSEUDO: function PSEUDO(a, b) {
          var c,
              e = d.pseudos[a] || d.setFilters[a.toLowerCase()] || fa.error("unsupported pseudo: " + a);
          return e[u] ? e(b) : e.length > 1 ? (c = [a, a, "", b], d.setFilters.hasOwnProperty(a.toLowerCase()) ? ha(function (a, c) {
            var d,
                f = e(a, b),
                g = f.length;

            while (g--) {
              d = J(a, f[g]), a[d] = !(c[d] = f[g]);
            }
          }) : function (a) {
            return e(a, 0, c);
          }) : e;
        }
      },
      pseudos: {
        not: ha(function (a) {
          var b = [],
              c = [],
              d = h(a.replace(Q, "$1"));
          return d[u] ? ha(function (a, b, c, e) {
            var f,
                g = d(a, null, e, []),
                h = a.length;

            while (h--) {
              (f = g[h]) && (a[h] = !(b[h] = f));
            }
          }) : function (a, e, f) {
            return b[0] = a, d(b, null, f, c), b[0] = null, !c.pop();
          };
        }),
        has: ha(function (a) {
          return function (b) {
            return fa(a, b).length > 0;
          };
        }),
        contains: ha(function (a) {
          return a = a.replace(ba, ca), function (b) {
            return (b.textContent || b.innerText || e(b)).indexOf(a) > -1;
          };
        }),
        lang: ha(function (a) {
          return V.test(a || "") || fa.error("unsupported lang: " + a), a = a.replace(ba, ca).toLowerCase(), function (b) {
            var c;

            do {
              if (c = p ? b.lang : b.getAttribute("xml:lang") || b.getAttribute("lang")) return c = c.toLowerCase(), c === a || 0 === c.indexOf(a + "-");
            } while ((b = b.parentNode) && 1 === b.nodeType);

            return !1;
          };
        }),
        target: function target(b) {
          var c = a.location && a.location.hash;
          return c && c.slice(1) === b.id;
        },
        root: function root(a) {
          return a === o;
        },
        focus: function focus(a) {
          return a === n.activeElement && (!n.hasFocus || n.hasFocus()) && !!(a.type || a.href || ~a.tabIndex);
        },
        enabled: function enabled(a) {
          return a.disabled === !1;
        },
        disabled: function disabled(a) {
          return a.disabled === !0;
        },
        checked: function checked(a) {
          var b = a.nodeName.toLowerCase();
          return "input" === b && !!a.checked || "option" === b && !!a.selected;
        },
        selected: function selected(a) {
          return a.parentNode && a.parentNode.selectedIndex, a.selected === !0;
        },
        empty: function empty(a) {
          for (a = a.firstChild; a; a = a.nextSibling) {
            if (a.nodeType < 6) return !1;
          }

          return !0;
        },
        parent: function parent(a) {
          return !d.pseudos.empty(a);
        },
        header: function header(a) {
          return Y.test(a.nodeName);
        },
        input: function input(a) {
          return X.test(a.nodeName);
        },
        button: function button(a) {
          var b = a.nodeName.toLowerCase();
          return "input" === b && "button" === a.type || "button" === b;
        },
        text: function text(a) {
          var b;
          return "input" === a.nodeName.toLowerCase() && "text" === a.type && (null == (b = a.getAttribute("type")) || "text" === b.toLowerCase());
        },
        first: na(function () {
          return [0];
        }),
        last: na(function (a, b) {
          return [b - 1];
        }),
        eq: na(function (a, b, c) {
          return [0 > c ? c + b : c];
        }),
        even: na(function (a, b) {
          for (var c = 0; b > c; c += 2) {
            a.push(c);
          }

          return a;
        }),
        odd: na(function (a, b) {
          for (var c = 1; b > c; c += 2) {
            a.push(c);
          }

          return a;
        }),
        lt: na(function (a, b, c) {
          for (var d = 0 > c ? c + b : c; --d >= 0;) {
            a.push(d);
          }

          return a;
        }),
        gt: na(function (a, b, c) {
          for (var d = 0 > c ? c + b : c; ++d < b;) {
            a.push(d);
          }

          return a;
        })
      }
    }, d.pseudos.nth = d.pseudos.eq;

    for (b in {
      radio: !0,
      checkbox: !0,
      file: !0,
      password: !0,
      image: !0
    }) {
      d.pseudos[b] = la(b);
    }

    for (b in {
      submit: !0,
      reset: !0
    }) {
      d.pseudos[b] = ma(b);
    }

    function pa() {}

    pa.prototype = d.filters = d.pseudos, d.setFilters = new pa(), g = fa.tokenize = function (a, b) {
      var c,
          e,
          f,
          g,
          h,
          i,
          j,
          k = z[a + " "];
      if (k) return b ? 0 : k.slice(0);
      h = a, i = [], j = d.preFilter;

      while (h) {
        c && !(e = R.exec(h)) || (e && (h = h.slice(e[0].length) || h), i.push(f = [])), c = !1, (e = S.exec(h)) && (c = e.shift(), f.push({
          value: c,
          type: e[0].replace(Q, " ")
        }), h = h.slice(c.length));

        for (g in d.filter) {
          !(e = W[g].exec(h)) || j[g] && !(e = j[g](e)) || (c = e.shift(), f.push({
            value: c,
            type: g,
            matches: e
          }), h = h.slice(c.length));
        }

        if (!c) break;
      }

      return b ? h.length : h ? fa.error(a) : z(a, i).slice(0);
    };

    function qa(a) {
      for (var b = 0, c = a.length, d = ""; c > b; b++) {
        d += a[b].value;
      }

      return d;
    }

    function ra(a, b, c) {
      var d = b.dir,
          e = c && "parentNode" === d,
          f = x++;
      return b.first ? function (b, c, f) {
        while (b = b[d]) {
          if (1 === b.nodeType || e) return a(b, c, f);
        }
      } : function (b, c, g) {
        var h,
            i,
            j,
            k = [w, f];

        if (g) {
          while (b = b[d]) {
            if ((1 === b.nodeType || e) && a(b, c, g)) return !0;
          }
        } else while (b = b[d]) {
          if (1 === b.nodeType || e) {
            if (j = b[u] || (b[u] = {}), i = j[b.uniqueID] || (j[b.uniqueID] = {}), (h = i[d]) && h[0] === w && h[1] === f) return k[2] = h[2];
            if (i[d] = k, k[2] = a(b, c, g)) return !0;
          }
        }
      };
    }

    function sa(a) {
      return a.length > 1 ? function (b, c, d) {
        var e = a.length;

        while (e--) {
          if (!a[e](b, c, d)) return !1;
        }

        return !0;
      } : a[0];
    }

    function ta(a, b, c) {
      for (var d = 0, e = b.length; e > d; d++) {
        fa(a, b[d], c);
      }

      return c;
    }

    function ua(a, b, c, d, e) {
      for (var f, g = [], h = 0, i = a.length, j = null != b; i > h; h++) {
        (f = a[h]) && (c && !c(f, d, e) || (g.push(f), j && b.push(h)));
      }

      return g;
    }

    function va(a, b, c, d, e, f) {
      return d && !d[u] && (d = va(d)), e && !e[u] && (e = va(e, f)), ha(function (f, g, h, i) {
        var j,
            k,
            l,
            m = [],
            n = [],
            o = g.length,
            p = f || ta(b || "*", h.nodeType ? [h] : h, []),
            q = !a || !f && b ? p : ua(p, m, a, h, i),
            r = c ? e || (f ? a : o || d) ? [] : g : q;

        if (c && c(q, r, h, i), d) {
          j = ua(r, n), d(j, [], h, i), k = j.length;

          while (k--) {
            (l = j[k]) && (r[n[k]] = !(q[n[k]] = l));
          }
        }

        if (f) {
          if (e || a) {
            if (e) {
              j = [], k = r.length;

              while (k--) {
                (l = r[k]) && j.push(q[k] = l);
              }

              e(null, r = [], j, i);
            }

            k = r.length;

            while (k--) {
              (l = r[k]) && (j = e ? J(f, l) : m[k]) > -1 && (f[j] = !(g[j] = l));
            }
          }
        } else r = ua(r === g ? r.splice(o, r.length) : r), e ? e(null, g, r, i) : H.apply(g, r);
      });
    }

    function wa(a) {
      for (var b, c, e, f = a.length, g = d.relative[a[0].type], h = g || d.relative[" "], i = g ? 1 : 0, k = ra(function (a) {
        return a === b;
      }, h, !0), l = ra(function (a) {
        return J(b, a) > -1;
      }, h, !0), m = [function (a, c, d) {
        var e = !g && (d || c !== j) || ((b = c).nodeType ? k(a, c, d) : l(a, c, d));
        return b = null, e;
      }]; f > i; i++) {
        if (c = d.relative[a[i].type]) m = [ra(sa(m), c)];else {
          if (c = d.filter[a[i].type].apply(null, a[i].matches), c[u]) {
            for (e = ++i; f > e; e++) {
              if (d.relative[a[e].type]) break;
            }

            return va(i > 1 && sa(m), i > 1 && qa(a.slice(0, i - 1).concat({
              value: " " === a[i - 2].type ? "*" : ""
            })).replace(Q, "$1"), c, e > i && wa(a.slice(i, e)), f > e && wa(a = a.slice(e)), f > e && qa(a));
          }

          m.push(c);
        }
      }

      return sa(m);
    }

    function xa(a, b) {
      var c = b.length > 0,
          e = a.length > 0,
          f = function f(_f, g, h, i, k) {
        var l,
            o,
            q,
            r = 0,
            s = "0",
            t = _f && [],
            u = [],
            v = j,
            x = _f || e && d.find.TAG("*", k),
            y = w += null == v ? 1 : Math.random() || .1,
            z = x.length;

        for (k && (j = g === n || g || k); s !== z && null != (l = x[s]); s++) {
          if (e && l) {
            o = 0, g || l.ownerDocument === n || (m(l), h = !p);

            while (q = a[o++]) {
              if (q(l, g || n, h)) {
                i.push(l);
                break;
              }
            }

            k && (w = y);
          }

          c && ((l = !q && l) && r--, _f && t.push(l));
        }

        if (r += s, c && s !== r) {
          o = 0;

          while (q = b[o++]) {
            q(t, u, g, h);
          }

          if (_f) {
            if (r > 0) while (s--) {
              t[s] || u[s] || (u[s] = F.call(i));
            }
            u = ua(u);
          }

          H.apply(i, u), k && !_f && u.length > 0 && r + b.length > 1 && fa.uniqueSort(i);
        }

        return k && (w = y, j = v), t;
      };

      return c ? ha(f) : f;
    }

    return h = fa.compile = function (a, b) {
      var c,
          d = [],
          e = [],
          f = A[a + " "];

      if (!f) {
        b || (b = g(a)), c = b.length;

        while (c--) {
          f = wa(b[c]), f[u] ? d.push(f) : e.push(f);
        }

        f = A(a, xa(e, d)), f.selector = a;
      }

      return f;
    }, i = fa.select = function (a, b, e, f) {
      var i,
          j,
          k,
          l,
          m,
          n = "function" == typeof a && a,
          o = !f && g(a = n.selector || a);

      if (e = e || [], 1 === o.length) {
        if (j = o[0] = o[0].slice(0), j.length > 2 && "ID" === (k = j[0]).type && c.getById && 9 === b.nodeType && p && d.relative[j[1].type]) {
          if (b = (d.find.ID(k.matches[0].replace(ba, ca), b) || [])[0], !b) return e;
          n && (b = b.parentNode), a = a.slice(j.shift().value.length);
        }

        i = W.needsContext.test(a) ? 0 : j.length;

        while (i--) {
          if (k = j[i], d.relative[l = k.type]) break;

          if ((m = d.find[l]) && (f = m(k.matches[0].replace(ba, ca), _.test(j[0].type) && oa(b.parentNode) || b))) {
            if (j.splice(i, 1), a = f.length && qa(j), !a) return H.apply(e, f), e;
            break;
          }
        }
      }

      return (n || h(a, o))(f, b, !p, e, !b || _.test(a) && oa(b.parentNode) || b), e;
    }, c.sortStable = u.split("").sort(B).join("") === u, c.detectDuplicates = !!l, m(), c.sortDetached = ia(function (a) {
      return 1 & a.compareDocumentPosition(n.createElement("div"));
    }), ia(function (a) {
      return a.innerHTML = "<a href='#'></a>", "#" === a.firstChild.getAttribute("href");
    }) || ja("type|href|height|width", function (a, b, c) {
      return c ? void 0 : a.getAttribute(b, "type" === b.toLowerCase() ? 1 : 2);
    }), c.attributes && ia(function (a) {
      return a.innerHTML = "<input/>", a.firstChild.setAttribute("value", ""), "" === a.firstChild.getAttribute("value");
    }) || ja("value", function (a, b, c) {
      return c || "input" !== a.nodeName.toLowerCase() ? void 0 : a.defaultValue;
    }), ia(function (a) {
      return null == a.getAttribute("disabled");
    }) || ja(K, function (a, b, c) {
      var d;
      return c ? void 0 : a[b] === !0 ? b.toLowerCase() : (d = a.getAttributeNode(b)) && d.specified ? d.value : null;
    }), fa;
  }(a);

  n.find = t, n.expr = t.selectors, n.expr[":"] = n.expr.pseudos, n.uniqueSort = n.unique = t.uniqueSort, n.text = t.getText, n.isXMLDoc = t.isXML, n.contains = t.contains;

  var u = function u(a, b, c) {
    var d = [],
        e = void 0 !== c;

    while ((a = a[b]) && 9 !== a.nodeType) {
      if (1 === a.nodeType) {
        if (e && n(a).is(c)) break;
        d.push(a);
      }
    }

    return d;
  },
      v = function v(a, b) {
    for (var c = []; a; a = a.nextSibling) {
      1 === a.nodeType && a !== b && c.push(a);
    }

    return c;
  },
      w = n.expr.match.needsContext,
      x = /^<([\w-]+)\s*\/?>(?:<\/\1>|)$/,
      y = /^.[^:#\[\.,]*$/;

  function z(a, b, c) {
    if (n.isFunction(b)) return n.grep(a, function (a, d) {
      return !!b.call(a, d, a) !== c;
    });
    if (b.nodeType) return n.grep(a, function (a) {
      return a === b !== c;
    });

    if ("string" == typeof b) {
      if (y.test(b)) return n.filter(b, a, c);
      b = n.filter(b, a);
    }

    return n.grep(a, function (a) {
      return h.call(b, a) > -1 !== c;
    });
  }

  n.filter = function (a, b, c) {
    var d = b[0];
    return c && (a = ":not(" + a + ")"), 1 === b.length && 1 === d.nodeType ? n.find.matchesSelector(d, a) ? [d] : [] : n.find.matches(a, n.grep(b, function (a) {
      return 1 === a.nodeType;
    }));
  }, n.fn.extend({
    find: function find(a) {
      var b,
          c = this.length,
          d = [],
          e = this;
      if ("string" != typeof a) return this.pushStack(n(a).filter(function () {
        for (b = 0; c > b; b++) {
          if (n.contains(e[b], this)) return !0;
        }
      }));

      for (b = 0; c > b; b++) {
        n.find(a, e[b], d);
      }

      return d = this.pushStack(c > 1 ? n.unique(d) : d), d.selector = this.selector ? this.selector + " " + a : a, d;
    },
    filter: function filter(a) {
      return this.pushStack(z(this, a || [], !1));
    },
    not: function not(a) {
      return this.pushStack(z(this, a || [], !0));
    },
    is: function is(a) {
      return !!z(this, "string" == typeof a && w.test(a) ? n(a) : a || [], !1).length;
    }
  });

  var A,
      B = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,
      C = n.fn.init = function (a, b, c) {
    var e, f;
    if (!a) return this;

    if (c = c || A, "string" == typeof a) {
      if (e = "<" === a[0] && ">" === a[a.length - 1] && a.length >= 3 ? [null, a, null] : B.exec(a), !e || !e[1] && b) return !b || b.jquery ? (b || c).find(a) : this.constructor(b).find(a);

      if (e[1]) {
        if (b = b instanceof n ? b[0] : b, n.merge(this, n.parseHTML(e[1], b && b.nodeType ? b.ownerDocument || b : d, !0)), x.test(e[1]) && n.isPlainObject(b)) for (e in b) {
          n.isFunction(this[e]) ? this[e](b[e]) : this.attr(e, b[e]);
        }
        return this;
      }

      return f = d.getElementById(e[2]), f && f.parentNode && (this.length = 1, this[0] = f), this.context = d, this.selector = a, this;
    }

    return a.nodeType ? (this.context = this[0] = a, this.length = 1, this) : n.isFunction(a) ? void 0 !== c.ready ? c.ready(a) : a(n) : (void 0 !== a.selector && (this.selector = a.selector, this.context = a.context), n.makeArray(a, this));
  };

  C.prototype = n.fn, A = n(d);
  var D = /^(?:parents|prev(?:Until|All))/,
      E = {
    children: !0,
    contents: !0,
    next: !0,
    prev: !0
  };
  n.fn.extend({
    has: function has(a) {
      var b = n(a, this),
          c = b.length;
      return this.filter(function () {
        for (var a = 0; c > a; a++) {
          if (n.contains(this, b[a])) return !0;
        }
      });
    },
    closest: function closest(a, b) {
      for (var c, d = 0, e = this.length, f = [], g = w.test(a) || "string" != typeof a ? n(a, b || this.context) : 0; e > d; d++) {
        for (c = this[d]; c && c !== b; c = c.parentNode) {
          if (c.nodeType < 11 && (g ? g.index(c) > -1 : 1 === c.nodeType && n.find.matchesSelector(c, a))) {
            f.push(c);
            break;
          }
        }
      }

      return this.pushStack(f.length > 1 ? n.uniqueSort(f) : f);
    },
    index: function index(a) {
      return a ? "string" == typeof a ? h.call(n(a), this[0]) : h.call(this, a.jquery ? a[0] : a) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1;
    },
    add: function add(a, b) {
      return this.pushStack(n.uniqueSort(n.merge(this.get(), n(a, b))));
    },
    addBack: function addBack(a) {
      return this.add(null == a ? this.prevObject : this.prevObject.filter(a));
    }
  });

  function F(a, b) {
    while ((a = a[b]) && 1 !== a.nodeType) {
      ;
    }

    return a;
  }

  n.each({
    parent: function parent(a) {
      var b = a.parentNode;
      return b && 11 !== b.nodeType ? b : null;
    },
    parents: function parents(a) {
      return u(a, "parentNode");
    },
    parentsUntil: function parentsUntil(a, b, c) {
      return u(a, "parentNode", c);
    },
    next: function next(a) {
      return F(a, "nextSibling");
    },
    prev: function prev(a) {
      return F(a, "previousSibling");
    },
    nextAll: function nextAll(a) {
      return u(a, "nextSibling");
    },
    prevAll: function prevAll(a) {
      return u(a, "previousSibling");
    },
    nextUntil: function nextUntil(a, b, c) {
      return u(a, "nextSibling", c);
    },
    prevUntil: function prevUntil(a, b, c) {
      return u(a, "previousSibling", c);
    },
    siblings: function siblings(a) {
      return v((a.parentNode || {}).firstChild, a);
    },
    children: function children(a) {
      return v(a.firstChild);
    },
    contents: function contents(a) {
      return a.contentDocument || n.merge([], a.childNodes);
    }
  }, function (a, b) {
    n.fn[a] = function (c, d) {
      var e = n.map(this, b, c);
      return "Until" !== a.slice(-5) && (d = c), d && "string" == typeof d && (e = n.filter(d, e)), this.length > 1 && (E[a] || n.uniqueSort(e), D.test(a) && e.reverse()), this.pushStack(e);
    };
  });
  var G = /\S+/g;

  function H(a) {
    var b = {};
    return n.each(a.match(G) || [], function (a, c) {
      b[c] = !0;
    }), b;
  }

  n.Callbacks = function (a) {
    a = "string" == typeof a ? H(a) : n.extend({}, a);

    var b,
        c,
        d,
        e,
        f = [],
        g = [],
        h = -1,
        i = function i() {
      for (e = a.once, d = b = !0; g.length; h = -1) {
        c = g.shift();

        while (++h < f.length) {
          f[h].apply(c[0], c[1]) === !1 && a.stopOnFalse && (h = f.length, c = !1);
        }
      }

      a.memory || (c = !1), b = !1, e && (f = c ? [] : "");
    },
        j = {
      add: function add() {
        return f && (c && !b && (h = f.length - 1, g.push(c)), function d(b) {
          n.each(b, function (b, c) {
            n.isFunction(c) ? a.unique && j.has(c) || f.push(c) : c && c.length && "string" !== n.type(c) && d(c);
          });
        }(arguments), c && !b && i()), this;
      },
      remove: function remove() {
        return n.each(arguments, function (a, b) {
          var c;

          while ((c = n.inArray(b, f, c)) > -1) {
            f.splice(c, 1), h >= c && h--;
          }
        }), this;
      },
      has: function has(a) {
        return a ? n.inArray(a, f) > -1 : f.length > 0;
      },
      empty: function empty() {
        return f && (f = []), this;
      },
      disable: function disable() {
        return e = g = [], f = c = "", this;
      },
      disabled: function disabled() {
        return !f;
      },
      lock: function lock() {
        return e = g = [], c || (f = c = ""), this;
      },
      locked: function locked() {
        return !!e;
      },
      fireWith: function fireWith(a, c) {
        return e || (c = c || [], c = [a, c.slice ? c.slice() : c], g.push(c), b || i()), this;
      },
      fire: function fire() {
        return j.fireWith(this, arguments), this;
      },
      fired: function fired() {
        return !!d;
      }
    };

    return j;
  }, n.extend({
    Deferred: function Deferred(a) {
      var b = [["resolve", "done", n.Callbacks("once memory"), "resolved"], ["reject", "fail", n.Callbacks("once memory"), "rejected"], ["notify", "progress", n.Callbacks("memory")]],
          c = "pending",
          d = {
        state: function state() {
          return c;
        },
        always: function always() {
          return e.done(arguments).fail(arguments), this;
        },
        then: function then() {
          var a = arguments;
          return n.Deferred(function (c) {
            n.each(b, function (b, f) {
              var g = n.isFunction(a[b]) && a[b];
              e[f[1]](function () {
                var a = g && g.apply(this, arguments);
                a && n.isFunction(a.promise) ? a.promise().progress(c.notify).done(c.resolve).fail(c.reject) : c[f[0] + "With"](this === d ? c.promise() : this, g ? [a] : arguments);
              });
            }), a = null;
          }).promise();
        },
        promise: function promise(a) {
          return null != a ? n.extend(a, d) : d;
        }
      },
          e = {};
      return d.pipe = d.then, n.each(b, function (a, f) {
        var g = f[2],
            h = f[3];
        d[f[1]] = g.add, h && g.add(function () {
          c = h;
        }, b[1 ^ a][2].disable, b[2][2].lock), e[f[0]] = function () {
          return e[f[0] + "With"](this === e ? d : this, arguments), this;
        }, e[f[0] + "With"] = g.fireWith;
      }), d.promise(e), a && a.call(e, e), e;
    },
    when: function when(a) {
      var b = 0,
          c = e.call(arguments),
          d = c.length,
          f = 1 !== d || a && n.isFunction(a.promise) ? d : 0,
          g = 1 === f ? a : n.Deferred(),
          h = function h(a, b, c) {
        return function (d) {
          b[a] = this, c[a] = arguments.length > 1 ? e.call(arguments) : d, c === i ? g.notifyWith(b, c) : --f || g.resolveWith(b, c);
        };
      },
          i,
          j,
          k;

      if (d > 1) for (i = new Array(d), j = new Array(d), k = new Array(d); d > b; b++) {
        c[b] && n.isFunction(c[b].promise) ? c[b].promise().progress(h(b, j, i)).done(h(b, k, c)).fail(g.reject) : --f;
      }
      return f || g.resolveWith(k, c), g.promise();
    }
  });
  var I;
  n.fn.ready = function (a) {
    return n.ready.promise().done(a), this;
  }, n.extend({
    isReady: !1,
    readyWait: 1,
    holdReady: function holdReady(a) {
      a ? n.readyWait++ : n.ready(!0);
    },
    ready: function ready(a) {
      (a === !0 ? --n.readyWait : n.isReady) || (n.isReady = !0, a !== !0 && --n.readyWait > 0 || (I.resolveWith(d, [n]), n.fn.triggerHandler && (n(d).triggerHandler("ready"), n(d).off("ready"))));
    }
  });

  function J() {
    d.removeEventListener("DOMContentLoaded", J), a.removeEventListener("load", J), n.ready();
  }

  n.ready.promise = function (b) {
    return I || (I = n.Deferred(), "complete" === d.readyState || "loading" !== d.readyState && !d.documentElement.doScroll ? a.setTimeout(n.ready) : (d.addEventListener("DOMContentLoaded", J), a.addEventListener("load", J))), I.promise(b);
  }, n.ready.promise();

  var K = function K(a, b, c, d, e, f, g) {
    var h = 0,
        i = a.length,
        j = null == c;

    if ("object" === n.type(c)) {
      e = !0;

      for (h in c) {
        K(a, b, h, c[h], !0, f, g);
      }
    } else if (void 0 !== d && (e = !0, n.isFunction(d) || (g = !0), j && (g ? (b.call(a, d), b = null) : (j = b, b = function b(a, _b, c) {
      return j.call(n(a), c);
    })), b)) for (; i > h; h++) {
      b(a[h], c, g ? d : d.call(a[h], h, b(a[h], c)));
    }

    return e ? a : j ? b.call(a) : i ? b(a[0], c) : f;
  },
      L = function L(a) {
    return 1 === a.nodeType || 9 === a.nodeType || !+a.nodeType;
  };

  function M() {
    this.expando = n.expando + M.uid++;
  }

  M.uid = 1, M.prototype = {
    register: function register(a, b) {
      var c = b || {};
      return a.nodeType ? a[this.expando] = c : Object.defineProperty(a, this.expando, {
        value: c,
        writable: !0,
        configurable: !0
      }), a[this.expando];
    },
    cache: function cache(a) {
      if (!L(a)) return {};
      var b = a[this.expando];
      return b || (b = {}, L(a) && (a.nodeType ? a[this.expando] = b : Object.defineProperty(a, this.expando, {
        value: b,
        configurable: !0
      }))), b;
    },
    set: function set(a, b, c) {
      var d,
          e = this.cache(a);
      if ("string" == typeof b) e[b] = c;else for (d in b) {
        e[d] = b[d];
      }
      return e;
    },
    get: function get(a, b) {
      return void 0 === b ? this.cache(a) : a[this.expando] && a[this.expando][b];
    },
    access: function access(a, b, c) {
      var d;
      return void 0 === b || b && "string" == typeof b && void 0 === c ? (d = this.get(a, b), void 0 !== d ? d : this.get(a, n.camelCase(b))) : (this.set(a, b, c), void 0 !== c ? c : b);
    },
    remove: function remove(a, b) {
      var c,
          d,
          e,
          f = a[this.expando];

      if (void 0 !== f) {
        if (void 0 === b) this.register(a);else {
          n.isArray(b) ? d = b.concat(b.map(n.camelCase)) : (e = n.camelCase(b), b in f ? d = [b, e] : (d = e, d = d in f ? [d] : d.match(G) || [])), c = d.length;

          while (c--) {
            delete f[d[c]];
          }
        }
        (void 0 === b || n.isEmptyObject(f)) && (a.nodeType ? a[this.expando] = void 0 : delete a[this.expando]);
      }
    },
    hasData: function hasData(a) {
      var b = a[this.expando];
      return void 0 !== b && !n.isEmptyObject(b);
    }
  };
  var N = new M(),
      O = new M(),
      P = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
      Q = /[A-Z]/g;

  function R(a, b, c) {
    var d;
    if (void 0 === c && 1 === a.nodeType) if (d = "data-" + b.replace(Q, "-$&").toLowerCase(), c = a.getAttribute(d), "string" == typeof c) {
      try {
        c = "true" === c ? !0 : "false" === c ? !1 : "null" === c ? null : +c + "" === c ? +c : P.test(c) ? n.parseJSON(c) : c;
      } catch (e) {}

      O.set(a, b, c);
    } else c = void 0;
    return c;
  }

  n.extend({
    hasData: function hasData(a) {
      return O.hasData(a) || N.hasData(a);
    },
    data: function data(a, b, c) {
      return O.access(a, b, c);
    },
    removeData: function removeData(a, b) {
      O.remove(a, b);
    },
    _data: function _data(a, b, c) {
      return N.access(a, b, c);
    },
    _removeData: function _removeData(a, b) {
      N.remove(a, b);
    }
  }), n.fn.extend({
    data: function data(a, b) {
      var c,
          d,
          e,
          f = this[0],
          g = f && f.attributes;

      if (void 0 === a) {
        if (this.length && (e = O.get(f), 1 === f.nodeType && !N.get(f, "hasDataAttrs"))) {
          c = g.length;

          while (c--) {
            g[c] && (d = g[c].name, 0 === d.indexOf("data-") && (d = n.camelCase(d.slice(5)), R(f, d, e[d])));
          }

          N.set(f, "hasDataAttrs", !0);
        }

        return e;
      }

      return "object" == _typeof(a) ? this.each(function () {
        O.set(this, a);
      }) : K(this, function (b) {
        var c, d;

        if (f && void 0 === b) {
          if (c = O.get(f, a) || O.get(f, a.replace(Q, "-$&").toLowerCase()), void 0 !== c) return c;
          if (d = n.camelCase(a), c = O.get(f, d), void 0 !== c) return c;
          if (c = R(f, d, void 0), void 0 !== c) return c;
        } else d = n.camelCase(a), this.each(function () {
          var c = O.get(this, d);
          O.set(this, d, b), a.indexOf("-") > -1 && void 0 !== c && O.set(this, a, b);
        });
      }, null, b, arguments.length > 1, null, !0);
    },
    removeData: function removeData(a) {
      return this.each(function () {
        O.remove(this, a);
      });
    }
  }), n.extend({
    queue: function queue(a, b, c) {
      var d;
      return a ? (b = (b || "fx") + "queue", d = N.get(a, b), c && (!d || n.isArray(c) ? d = N.access(a, b, n.makeArray(c)) : d.push(c)), d || []) : void 0;
    },
    dequeue: function dequeue(a, b) {
      b = b || "fx";

      var c = n.queue(a, b),
          d = c.length,
          e = c.shift(),
          f = n._queueHooks(a, b),
          g = function g() {
        n.dequeue(a, b);
      };

      "inprogress" === e && (e = c.shift(), d--), e && ("fx" === b && c.unshift("inprogress"), delete f.stop, e.call(a, g, f)), !d && f && f.empty.fire();
    },
    _queueHooks: function _queueHooks(a, b) {
      var c = b + "queueHooks";
      return N.get(a, c) || N.access(a, c, {
        empty: n.Callbacks("once memory").add(function () {
          N.remove(a, [b + "queue", c]);
        })
      });
    }
  }), n.fn.extend({
    queue: function queue(a, b) {
      var c = 2;
      return "string" != typeof a && (b = a, a = "fx", c--), arguments.length < c ? n.queue(this[0], a) : void 0 === b ? this : this.each(function () {
        var c = n.queue(this, a, b);
        n._queueHooks(this, a), "fx" === a && "inprogress" !== c[0] && n.dequeue(this, a);
      });
    },
    dequeue: function dequeue(a) {
      return this.each(function () {
        n.dequeue(this, a);
      });
    },
    clearQueue: function clearQueue(a) {
      return this.queue(a || "fx", []);
    },
    promise: function promise(a, b) {
      var c,
          d = 1,
          e = n.Deferred(),
          f = this,
          g = this.length,
          h = function h() {
        --d || e.resolveWith(f, [f]);
      };

      "string" != typeof a && (b = a, a = void 0), a = a || "fx";

      while (g--) {
        c = N.get(f[g], a + "queueHooks"), c && c.empty && (d++, c.empty.add(h));
      }

      return h(), e.promise(b);
    }
  });

  var S = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
      T = new RegExp("^(?:([+-])=|)(" + S + ")([a-z%]*)$", "i"),
      U = ["Top", "Right", "Bottom", "Left"],
      V = function V(a, b) {
    return a = b || a, "none" === n.css(a, "display") || !n.contains(a.ownerDocument, a);
  };

  function W(a, b, c, d) {
    var e,
        f = 1,
        g = 20,
        h = d ? function () {
      return d.cur();
    } : function () {
      return n.css(a, b, "");
    },
        i = h(),
        j = c && c[3] || (n.cssNumber[b] ? "" : "px"),
        k = (n.cssNumber[b] || "px" !== j && +i) && T.exec(n.css(a, b));

    if (k && k[3] !== j) {
      j = j || k[3], c = c || [], k = +i || 1;

      do {
        f = f || ".5", k /= f, n.style(a, b, k + j);
      } while (f !== (f = h() / i) && 1 !== f && --g);
    }

    return c && (k = +k || +i || 0, e = c[1] ? k + (c[1] + 1) * c[2] : +c[2], d && (d.unit = j, d.start = k, d.end = e)), e;
  }

  var X = /^(?:checkbox|radio)$/i,
      Y = /<([\w:-]+)/,
      Z = /^$|\/(?:java|ecma)script/i,
      $ = {
    option: [1, "<select multiple='multiple'>", "</select>"],
    thead: [1, "<table>", "</table>"],
    col: [2, "<table><colgroup>", "</colgroup></table>"],
    tr: [2, "<table><tbody>", "</tbody></table>"],
    td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
    _default: [0, "", ""]
  };
  $.optgroup = $.option, $.tbody = $.tfoot = $.colgroup = $.caption = $.thead, $.th = $.td;

  function _(a, b) {
    var c = "undefined" != typeof a.getElementsByTagName ? a.getElementsByTagName(b || "*") : "undefined" != typeof a.querySelectorAll ? a.querySelectorAll(b || "*") : [];
    return void 0 === b || b && n.nodeName(a, b) ? n.merge([a], c) : c;
  }

  function aa(a, b) {
    for (var c = 0, d = a.length; d > c; c++) {
      N.set(a[c], "globalEval", !b || N.get(b[c], "globalEval"));
    }
  }

  var ba = /<|&#?\w+;/;

  function ca(a, b, c, d, e) {
    for (var f, g, h, i, j, k, l = b.createDocumentFragment(), m = [], o = 0, p = a.length; p > o; o++) {
      if (f = a[o], f || 0 === f) if ("object" === n.type(f)) n.merge(m, f.nodeType ? [f] : f);else if (ba.test(f)) {
        g = g || l.appendChild(b.createElement("div")), h = (Y.exec(f) || ["", ""])[1].toLowerCase(), i = $[h] || $._default, g.innerHTML = i[1] + n.htmlPrefilter(f) + i[2], k = i[0];

        while (k--) {
          g = g.lastChild;
        }

        n.merge(m, g.childNodes), g = l.firstChild, g.textContent = "";
      } else m.push(b.createTextNode(f));
    }

    l.textContent = "", o = 0;

    while (f = m[o++]) {
      if (d && n.inArray(f, d) > -1) e && e.push(f);else if (j = n.contains(f.ownerDocument, f), g = _(l.appendChild(f), "script"), j && aa(g), c) {
        k = 0;

        while (f = g[k++]) {
          Z.test(f.type || "") && c.push(f);
        }
      }
    }

    return l;
  }

  !function () {
    var a = d.createDocumentFragment(),
        b = a.appendChild(d.createElement("div")),
        c = d.createElement("input");
    c.setAttribute("type", "radio"), c.setAttribute("checked", "checked"), c.setAttribute("name", "t"), b.appendChild(c), l.checkClone = b.cloneNode(!0).cloneNode(!0).lastChild.checked, b.innerHTML = "<textarea>x</textarea>", l.noCloneChecked = !!b.cloneNode(!0).lastChild.defaultValue;
  }();
  var da = /^key/,
      ea = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
      fa = /^([^.]*)(?:\.(.+)|)/;

  function ga() {
    return !0;
  }

  function ha() {
    return !1;
  }

  function ia() {
    try {
      return d.activeElement;
    } catch (a) {}
  }

  function ja(a, b, c, d, e, f) {
    var g, h;

    if ("object" == _typeof(b)) {
      "string" != typeof c && (d = d || c, c = void 0);

      for (h in b) {
        ja(a, h, c, d, b[h], f);
      }

      return a;
    }

    if (null == d && null == e ? (e = c, d = c = void 0) : null == e && ("string" == typeof c ? (e = d, d = void 0) : (e = d, d = c, c = void 0)), e === !1) e = ha;else if (!e) return a;
    return 1 === f && (g = e, e = function e(a) {
      return n().off(a), g.apply(this, arguments);
    }, e.guid = g.guid || (g.guid = n.guid++)), a.each(function () {
      n.event.add(this, b, e, d, c);
    });
  }

  n.event = {
    global: {},
    add: function add(a, b, c, d, e) {
      var f,
          g,
          h,
          i,
          j,
          k,
          l,
          m,
          o,
          p,
          q,
          r = N.get(a);

      if (r) {
        c.handler && (f = c, c = f.handler, e = f.selector), c.guid || (c.guid = n.guid++), (i = r.events) || (i = r.events = {}), (g = r.handle) || (g = r.handle = function (b) {
          return "undefined" != typeof n && n.event.triggered !== b.type ? n.event.dispatch.apply(a, arguments) : void 0;
        }), b = (b || "").match(G) || [""], j = b.length;

        while (j--) {
          h = fa.exec(b[j]) || [], o = q = h[1], p = (h[2] || "").split(".").sort(), o && (l = n.event.special[o] || {}, o = (e ? l.delegateType : l.bindType) || o, l = n.event.special[o] || {}, k = n.extend({
            type: o,
            origType: q,
            data: d,
            handler: c,
            guid: c.guid,
            selector: e,
            needsContext: e && n.expr.match.needsContext.test(e),
            namespace: p.join(".")
          }, f), (m = i[o]) || (m = i[o] = [], m.delegateCount = 0, l.setup && l.setup.call(a, d, p, g) !== !1 || a.addEventListener && a.addEventListener(o, g)), l.add && (l.add.call(a, k), k.handler.guid || (k.handler.guid = c.guid)), e ? m.splice(m.delegateCount++, 0, k) : m.push(k), n.event.global[o] = !0);
        }
      }
    },
    remove: function remove(a, b, c, d, e) {
      var f,
          g,
          h,
          i,
          j,
          k,
          l,
          m,
          o,
          p,
          q,
          r = N.hasData(a) && N.get(a);

      if (r && (i = r.events)) {
        b = (b || "").match(G) || [""], j = b.length;

        while (j--) {
          if (h = fa.exec(b[j]) || [], o = q = h[1], p = (h[2] || "").split(".").sort(), o) {
            l = n.event.special[o] || {}, o = (d ? l.delegateType : l.bindType) || o, m = i[o] || [], h = h[2] && new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)"), g = f = m.length;

            while (f--) {
              k = m[f], !e && q !== k.origType || c && c.guid !== k.guid || h && !h.test(k.namespace) || d && d !== k.selector && ("**" !== d || !k.selector) || (m.splice(f, 1), k.selector && m.delegateCount--, l.remove && l.remove.call(a, k));
            }

            g && !m.length && (l.teardown && l.teardown.call(a, p, r.handle) !== !1 || n.removeEvent(a, o, r.handle), delete i[o]);
          } else for (o in i) {
            n.event.remove(a, o + b[j], c, d, !0);
          }
        }

        n.isEmptyObject(i) && N.remove(a, "handle events");
      }
    },
    dispatch: function dispatch(a) {
      a = n.event.fix(a);
      var b,
          c,
          d,
          f,
          g,
          h = [],
          i = e.call(arguments),
          j = (N.get(this, "events") || {})[a.type] || [],
          k = n.event.special[a.type] || {};

      if (i[0] = a, a.delegateTarget = this, !k.preDispatch || k.preDispatch.call(this, a) !== !1) {
        h = n.event.handlers.call(this, a, j), b = 0;

        while ((f = h[b++]) && !a.isPropagationStopped()) {
          a.currentTarget = f.elem, c = 0;

          while ((g = f.handlers[c++]) && !a.isImmediatePropagationStopped()) {
            a.rnamespace && !a.rnamespace.test(g.namespace) || (a.handleObj = g, a.data = g.data, d = ((n.event.special[g.origType] || {}).handle || g.handler).apply(f.elem, i), void 0 !== d && (a.result = d) === !1 && (a.preventDefault(), a.stopPropagation()));
          }
        }

        return k.postDispatch && k.postDispatch.call(this, a), a.result;
      }
    },
    handlers: function handlers(a, b) {
      var c,
          d,
          e,
          f,
          g = [],
          h = b.delegateCount,
          i = a.target;
      if (h && i.nodeType && ("click" !== a.type || isNaN(a.button) || a.button < 1)) for (; i !== this; i = i.parentNode || this) {
        if (1 === i.nodeType && (i.disabled !== !0 || "click" !== a.type)) {
          for (d = [], c = 0; h > c; c++) {
            f = b[c], e = f.selector + " ", void 0 === d[e] && (d[e] = f.needsContext ? n(e, this).index(i) > -1 : n.find(e, this, null, [i]).length), d[e] && d.push(f);
          }

          d.length && g.push({
            elem: i,
            handlers: d
          });
        }
      }
      return h < b.length && g.push({
        elem: this,
        handlers: b.slice(h)
      }), g;
    },
    props: "altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
    fixHooks: {},
    keyHooks: {
      props: "char charCode key keyCode".split(" "),
      filter: function filter(a, b) {
        return null == a.which && (a.which = null != b.charCode ? b.charCode : b.keyCode), a;
      }
    },
    mouseHooks: {
      props: "button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
      filter: function filter(a, b) {
        var c,
            e,
            f,
            g = b.button;
        return null == a.pageX && null != b.clientX && (c = a.target.ownerDocument || d, e = c.documentElement, f = c.body, a.pageX = b.clientX + (e && e.scrollLeft || f && f.scrollLeft || 0) - (e && e.clientLeft || f && f.clientLeft || 0), a.pageY = b.clientY + (e && e.scrollTop || f && f.scrollTop || 0) - (e && e.clientTop || f && f.clientTop || 0)), a.which || void 0 === g || (a.which = 1 & g ? 1 : 2 & g ? 3 : 4 & g ? 2 : 0), a;
      }
    },
    fix: function fix(a) {
      if (a[n.expando]) return a;
      var b,
          c,
          e,
          f = a.type,
          g = a,
          h = this.fixHooks[f];
      h || (this.fixHooks[f] = h = ea.test(f) ? this.mouseHooks : da.test(f) ? this.keyHooks : {}), e = h.props ? this.props.concat(h.props) : this.props, a = new n.Event(g), b = e.length;

      while (b--) {
        c = e[b], a[c] = g[c];
      }

      return a.target || (a.target = d), 3 === a.target.nodeType && (a.target = a.target.parentNode), h.filter ? h.filter(a, g) : a;
    },
    special: {
      load: {
        noBubble: !0
      },
      focus: {
        trigger: function trigger() {
          return this !== ia() && this.focus ? (this.focus(), !1) : void 0;
        },
        delegateType: "focusin"
      },
      blur: {
        trigger: function trigger() {
          return this === ia() && this.blur ? (this.blur(), !1) : void 0;
        },
        delegateType: "focusout"
      },
      click: {
        trigger: function trigger() {
          return "checkbox" === this.type && this.click && n.nodeName(this, "input") ? (this.click(), !1) : void 0;
        },
        _default: function _default(a) {
          return n.nodeName(a.target, "a");
        }
      },
      beforeunload: {
        postDispatch: function postDispatch(a) {
          void 0 !== a.result && a.originalEvent && (a.originalEvent.returnValue = a.result);
        }
      }
    }
  }, n.removeEvent = function (a, b, c) {
    a.removeEventListener && a.removeEventListener(b, c);
  }, n.Event = function (a, b) {
    return this instanceof n.Event ? (a && a.type ? (this.originalEvent = a, this.type = a.type, this.isDefaultPrevented = a.defaultPrevented || void 0 === a.defaultPrevented && a.returnValue === !1 ? ga : ha) : this.type = a, b && n.extend(this, b), this.timeStamp = a && a.timeStamp || n.now(), void (this[n.expando] = !0)) : new n.Event(a, b);
  }, n.Event.prototype = {
    constructor: n.Event,
    isDefaultPrevented: ha,
    isPropagationStopped: ha,
    isImmediatePropagationStopped: ha,
    isSimulated: !1,
    preventDefault: function preventDefault() {
      var a = this.originalEvent;
      this.isDefaultPrevented = ga, a && !this.isSimulated && a.preventDefault();
    },
    stopPropagation: function stopPropagation() {
      var a = this.originalEvent;
      this.isPropagationStopped = ga, a && !this.isSimulated && a.stopPropagation();
    },
    stopImmediatePropagation: function stopImmediatePropagation() {
      var a = this.originalEvent;
      this.isImmediatePropagationStopped = ga, a && !this.isSimulated && a.stopImmediatePropagation(), this.stopPropagation();
    }
  }, n.each({
    mouseenter: "mouseover",
    mouseleave: "mouseout",
    pointerenter: "pointerover",
    pointerleave: "pointerout"
  }, function (a, b) {
    n.event.special[a] = {
      delegateType: b,
      bindType: b,
      handle: function handle(a) {
        var c,
            d = this,
            e = a.relatedTarget,
            f = a.handleObj;
        return e && (e === d || n.contains(d, e)) || (a.type = f.origType, c = f.handler.apply(this, arguments), a.type = b), c;
      }
    };
  }), n.fn.extend({
    on: function on(a, b, c, d) {
      return ja(this, a, b, c, d);
    },
    one: function one(a, b, c, d) {
      return ja(this, a, b, c, d, 1);
    },
    off: function off(a, b, c) {
      var d, e;
      if (a && a.preventDefault && a.handleObj) return d = a.handleObj, n(a.delegateTarget).off(d.namespace ? d.origType + "." + d.namespace : d.origType, d.selector, d.handler), this;

      if ("object" == _typeof(a)) {
        for (e in a) {
          this.off(e, b, a[e]);
        }

        return this;
      }

      return b !== !1 && "function" != typeof b || (c = b, b = void 0), c === !1 && (c = ha), this.each(function () {
        n.event.remove(this, a, c, b);
      });
    }
  });
  var ka = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:-]+)[^>]*)\/>/gi,
      la = /<script|<style|<link/i,
      ma = /checked\s*(?:[^=]|=\s*.checked.)/i,
      na = /^true\/(.*)/,
      oa = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

  function pa(a, b) {
    return n.nodeName(a, "table") && n.nodeName(11 !== b.nodeType ? b : b.firstChild, "tr") ? a.getElementsByTagName("tbody")[0] || a.appendChild(a.ownerDocument.createElement("tbody")) : a;
  }

  function qa(a) {
    return a.type = (null !== a.getAttribute("type")) + "/" + a.type, a;
  }

  function ra(a) {
    var b = na.exec(a.type);
    return b ? a.type = b[1] : a.removeAttribute("type"), a;
  }

  function sa(a, b) {
    var c, d, e, f, g, h, i, j;

    if (1 === b.nodeType) {
      if (N.hasData(a) && (f = N.access(a), g = N.set(b, f), j = f.events)) {
        delete g.handle, g.events = {};

        for (e in j) {
          for (c = 0, d = j[e].length; d > c; c++) {
            n.event.add(b, e, j[e][c]);
          }
        }
      }

      O.hasData(a) && (h = O.access(a), i = n.extend({}, h), O.set(b, i));
    }
  }

  function ta(a, b) {
    var c = b.nodeName.toLowerCase();
    "input" === c && X.test(a.type) ? b.checked = a.checked : "input" !== c && "textarea" !== c || (b.defaultValue = a.defaultValue);
  }

  function ua(a, b, c, d) {
    b = f.apply([], b);
    var e,
        g,
        h,
        i,
        j,
        k,
        m = 0,
        o = a.length,
        p = o - 1,
        q = b[0],
        r = n.isFunction(q);
    if (r || o > 1 && "string" == typeof q && !l.checkClone && ma.test(q)) return a.each(function (e) {
      var f = a.eq(e);
      r && (b[0] = q.call(this, e, f.html())), ua(f, b, c, d);
    });

    if (o && (e = ca(b, a[0].ownerDocument, !1, a, d), g = e.firstChild, 1 === e.childNodes.length && (e = g), g || d)) {
      for (h = n.map(_(e, "script"), qa), i = h.length; o > m; m++) {
        j = e, m !== p && (j = n.clone(j, !0, !0), i && n.merge(h, _(j, "script"))), c.call(a[m], j, m);
      }

      if (i) for (k = h[h.length - 1].ownerDocument, n.map(h, ra), m = 0; i > m; m++) {
        j = h[m], Z.test(j.type || "") && !N.access(j, "globalEval") && n.contains(k, j) && (j.src ? n._evalUrl && n._evalUrl(j.src) : n.globalEval(j.textContent.replace(oa, "")));
      }
    }

    return a;
  }

  function va(a, b, c) {
    for (var d, e = b ? n.filter(b, a) : a, f = 0; null != (d = e[f]); f++) {
      c || 1 !== d.nodeType || n.cleanData(_(d)), d.parentNode && (c && n.contains(d.ownerDocument, d) && aa(_(d, "script")), d.parentNode.removeChild(d));
    }

    return a;
  }

  n.extend({
    htmlPrefilter: function htmlPrefilter(a) {
      return a.replace(ka, "<$1></$2>");
    },
    clone: function clone(a, b, c) {
      var d,
          e,
          f,
          g,
          h = a.cloneNode(!0),
          i = n.contains(a.ownerDocument, a);
      if (!(l.noCloneChecked || 1 !== a.nodeType && 11 !== a.nodeType || n.isXMLDoc(a))) for (g = _(h), f = _(a), d = 0, e = f.length; e > d; d++) {
        ta(f[d], g[d]);
      }
      if (b) if (c) for (f = f || _(a), g = g || _(h), d = 0, e = f.length; e > d; d++) {
        sa(f[d], g[d]);
      } else sa(a, h);
      return g = _(h, "script"), g.length > 0 && aa(g, !i && _(a, "script")), h;
    },
    cleanData: function cleanData(a) {
      for (var b, c, d, e = n.event.special, f = 0; void 0 !== (c = a[f]); f++) {
        if (L(c)) {
          if (b = c[N.expando]) {
            if (b.events) for (d in b.events) {
              e[d] ? n.event.remove(c, d) : n.removeEvent(c, d, b.handle);
            }
            c[N.expando] = void 0;
          }

          c[O.expando] && (c[O.expando] = void 0);
        }
      }
    }
  }), n.fn.extend({
    domManip: ua,
    detach: function detach(a) {
      return va(this, a, !0);
    },
    remove: function remove(a) {
      return va(this, a);
    },
    text: function text(a) {
      return K(this, function (a) {
        return void 0 === a ? n.text(this) : this.empty().each(function () {
          1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = a);
        });
      }, null, a, arguments.length);
    },
    append: function append() {
      return ua(this, arguments, function (a) {
        if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
          var b = pa(this, a);
          b.appendChild(a);
        }
      });
    },
    prepend: function prepend() {
      return ua(this, arguments, function (a) {
        if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
          var b = pa(this, a);
          b.insertBefore(a, b.firstChild);
        }
      });
    },
    before: function before() {
      return ua(this, arguments, function (a) {
        this.parentNode && this.parentNode.insertBefore(a, this);
      });
    },
    after: function after() {
      return ua(this, arguments, function (a) {
        this.parentNode && this.parentNode.insertBefore(a, this.nextSibling);
      });
    },
    empty: function empty() {
      for (var a, b = 0; null != (a = this[b]); b++) {
        1 === a.nodeType && (n.cleanData(_(a, !1)), a.textContent = "");
      }

      return this;
    },
    clone: function clone(a, b) {
      return a = null == a ? !1 : a, b = null == b ? a : b, this.map(function () {
        return n.clone(this, a, b);
      });
    },
    html: function html(a) {
      return K(this, function (a) {
        var b = this[0] || {},
            c = 0,
            d = this.length;
        if (void 0 === a && 1 === b.nodeType) return b.innerHTML;

        if ("string" == typeof a && !la.test(a) && !$[(Y.exec(a) || ["", ""])[1].toLowerCase()]) {
          a = n.htmlPrefilter(a);

          try {
            for (; d > c; c++) {
              b = this[c] || {}, 1 === b.nodeType && (n.cleanData(_(b, !1)), b.innerHTML = a);
            }

            b = 0;
          } catch (e) {}
        }

        b && this.empty().append(a);
      }, null, a, arguments.length);
    },
    replaceWith: function replaceWith() {
      var a = [];
      return ua(this, arguments, function (b) {
        var c = this.parentNode;
        n.inArray(this, a) < 0 && (n.cleanData(_(this)), c && c.replaceChild(b, this));
      }, a);
    }
  }), n.each({
    appendTo: "append",
    prependTo: "prepend",
    insertBefore: "before",
    insertAfter: "after",
    replaceAll: "replaceWith"
  }, function (a, b) {
    n.fn[a] = function (a) {
      for (var c, d = [], e = n(a), f = e.length - 1, h = 0; f >= h; h++) {
        c = h === f ? this : this.clone(!0), n(e[h])[b](c), g.apply(d, c.get());
      }

      return this.pushStack(d);
    };
  });
  var wa,
      xa = {
    HTML: "block",
    BODY: "block"
  };

  function ya(a, b) {
    var c = n(b.createElement(a)).appendTo(b.body),
        d = n.css(c[0], "display");
    return c.detach(), d;
  }

  function za(a) {
    var b = d,
        c = xa[a];
    return c || (c = ya(a, b), "none" !== c && c || (wa = (wa || n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement), b = wa[0].contentDocument, b.write(), b.close(), c = ya(a, b), wa.detach()), xa[a] = c), c;
  }

  var Aa = /^margin/,
      Ba = new RegExp("^(" + S + ")(?!px)[a-z%]+$", "i"),
      Ca = function Ca(b) {
    var c = b.ownerDocument.defaultView;
    return c && c.opener || (c = a), c.getComputedStyle(b);
  },
      Da = function Da(a, b, c, d) {
    var e,
        f,
        g = {};

    for (f in b) {
      g[f] = a.style[f], a.style[f] = b[f];
    }

    e = c.apply(a, d || []);

    for (f in b) {
      a.style[f] = g[f];
    }

    return e;
  },
      Ea = d.documentElement;

  !function () {
    var b,
        c,
        e,
        f,
        g = d.createElement("div"),
        h = d.createElement("div");

    if (h.style) {
      var _i = function _i() {
        h.style.cssText = "-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;display:block;margin:auto;border:1px;padding:1px;top:1%;width:50%", h.innerHTML = "", Ea.appendChild(g);
        var d = a.getComputedStyle(h);
        b = "1%" !== d.top, f = "2px" === d.marginLeft, c = "4px" === d.width, h.style.marginRight = "50%", e = "4px" === d.marginRight, Ea.removeChild(g);
      };

      h.style.backgroundClip = "content-box", h.cloneNode(!0).style.backgroundClip = "", l.clearCloneStyle = "content-box" === h.style.backgroundClip, g.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;padding:0;margin-top:1px;position:absolute", g.appendChild(h);
      n.extend(l, {
        pixelPosition: function pixelPosition() {
          return _i(), b;
        },
        boxSizingReliable: function boxSizingReliable() {
          return null == c && _i(), c;
        },
        pixelMarginRight: function pixelMarginRight() {
          return null == c && _i(), e;
        },
        reliableMarginLeft: function reliableMarginLeft() {
          return null == c && _i(), f;
        },
        reliableMarginRight: function reliableMarginRight() {
          var b,
              c = h.appendChild(d.createElement("div"));
          return c.style.cssText = h.style.cssText = "-webkit-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0", c.style.marginRight = c.style.width = "0", h.style.width = "1px", Ea.appendChild(g), b = !parseFloat(a.getComputedStyle(c).marginRight), Ea.removeChild(g), h.removeChild(c), b;
        }
      });
    }
  }();

  function Fa(a, b, c) {
    var d,
        e,
        f,
        g,
        h = a.style;
    return c = c || Ca(a), g = c ? c.getPropertyValue(b) || c[b] : void 0, "" !== g && void 0 !== g || n.contains(a.ownerDocument, a) || (g = n.style(a, b)), c && !l.pixelMarginRight() && Ba.test(g) && Aa.test(b) && (d = h.width, e = h.minWidth, f = h.maxWidth, h.minWidth = h.maxWidth = h.width = g, g = c.width, h.width = d, h.minWidth = e, h.maxWidth = f), void 0 !== g ? g + "" : g;
  }

  function Ga(a, b) {
    return {
      get: function get() {
        return a() ? void delete this.get : (this.get = b).apply(this, arguments);
      }
    };
  }

  var Ha = /^(none|table(?!-c[ea]).+)/,
      Ia = {
    position: "absolute",
    visibility: "hidden",
    display: "block"
  },
      Ja = {
    letterSpacing: "0",
    fontWeight: "400"
  },
      Ka = ["Webkit", "O", "Moz", "ms"],
      La = d.createElement("div").style;

  function Ma(a) {
    if (a in La) return a;
    var b = a[0].toUpperCase() + a.slice(1),
        c = Ka.length;

    while (c--) {
      if (a = Ka[c] + b, a in La) return a;
    }
  }

  function Na(a, b, c) {
    var d = T.exec(b);
    return d ? Math.max(0, d[2] - (c || 0)) + (d[3] || "px") : b;
  }

  function Oa(a, b, c, d, e) {
    for (var f = c === (d ? "border" : "content") ? 4 : "width" === b ? 1 : 0, g = 0; 4 > f; f += 2) {
      "margin" === c && (g += n.css(a, c + U[f], !0, e)), d ? ("content" === c && (g -= n.css(a, "padding" + U[f], !0, e)), "margin" !== c && (g -= n.css(a, "border" + U[f] + "Width", !0, e))) : (g += n.css(a, "padding" + U[f], !0, e), "padding" !== c && (g += n.css(a, "border" + U[f] + "Width", !0, e)));
    }

    return g;
  }

  function Pa(a, b, c) {
    var d = !0,
        e = "width" === b ? a.offsetWidth : a.offsetHeight,
        f = Ca(a),
        g = "border-box" === n.css(a, "boxSizing", !1, f);

    if (0 >= e || null == e) {
      if (e = Fa(a, b, f), (0 > e || null == e) && (e = a.style[b]), Ba.test(e)) return e;
      d = g && (l.boxSizingReliable() || e === a.style[b]), e = parseFloat(e) || 0;
    }

    return e + Oa(a, b, c || (g ? "border" : "content"), d, f) + "px";
  }

  function Qa(a, b) {
    for (var c, d, e, f = [], g = 0, h = a.length; h > g; g++) {
      d = a[g], d.style && (f[g] = N.get(d, "olddisplay"), c = d.style.display, b ? (f[g] || "none" !== c || (d.style.display = ""), "" === d.style.display && V(d) && (f[g] = N.access(d, "olddisplay", za(d.nodeName)))) : (e = V(d), "none" === c && e || N.set(d, "olddisplay", e ? c : n.css(d, "display"))));
    }

    for (g = 0; h > g; g++) {
      d = a[g], d.style && (b && "none" !== d.style.display && "" !== d.style.display || (d.style.display = b ? f[g] || "" : "none"));
    }

    return a;
  }

  n.extend({
    cssHooks: {
      opacity: {
        get: function get(a, b) {
          if (b) {
            var c = Fa(a, "opacity");
            return "" === c ? "1" : c;
          }
        }
      }
    },
    cssNumber: {
      animationIterationCount: !0,
      columnCount: !0,
      fillOpacity: !0,
      flexGrow: !0,
      flexShrink: !0,
      fontWeight: !0,
      lineHeight: !0,
      opacity: !0,
      order: !0,
      orphans: !0,
      widows: !0,
      zIndex: !0,
      zoom: !0
    },
    cssProps: {
      "float": "cssFloat"
    },
    style: function style(a, b, c, d) {
      if (a && 3 !== a.nodeType && 8 !== a.nodeType && a.style) {
        var e,
            f,
            g,
            h = n.camelCase(b),
            i = a.style;
        return b = n.cssProps[h] || (n.cssProps[h] = Ma(h) || h), g = n.cssHooks[b] || n.cssHooks[h], void 0 === c ? g && "get" in g && void 0 !== (e = g.get(a, !1, d)) ? e : i[b] : (f = _typeof(c), "string" === f && (e = T.exec(c)) && e[1] && (c = W(a, b, e), f = "number"), null != c && c === c && ("number" === f && (c += e && e[3] || (n.cssNumber[h] ? "" : "px")), l.clearCloneStyle || "" !== c || 0 !== b.indexOf("background") || (i[b] = "inherit"), g && "set" in g && void 0 === (c = g.set(a, c, d)) || (i[b] = c)), void 0);
      }
    },
    css: function css(a, b, c, d) {
      var e,
          f,
          g,
          h = n.camelCase(b);
      return b = n.cssProps[h] || (n.cssProps[h] = Ma(h) || h), g = n.cssHooks[b] || n.cssHooks[h], g && "get" in g && (e = g.get(a, !0, c)), void 0 === e && (e = Fa(a, b, d)), "normal" === e && b in Ja && (e = Ja[b]), "" === c || c ? (f = parseFloat(e), c === !0 || isFinite(f) ? f || 0 : e) : e;
    }
  }), n.each(["height", "width"], function (a, b) {
    n.cssHooks[b] = {
      get: function get(a, c, d) {
        return c ? Ha.test(n.css(a, "display")) && 0 === a.offsetWidth ? Da(a, Ia, function () {
          return Pa(a, b, d);
        }) : Pa(a, b, d) : void 0;
      },
      set: function set(a, c, d) {
        var e,
            f = d && Ca(a),
            g = d && Oa(a, b, d, "border-box" === n.css(a, "boxSizing", !1, f), f);
        return g && (e = T.exec(c)) && "px" !== (e[3] || "px") && (a.style[b] = c, c = n.css(a, b)), Na(a, c, g);
      }
    };
  }), n.cssHooks.marginLeft = Ga(l.reliableMarginLeft, function (a, b) {
    return b ? (parseFloat(Fa(a, "marginLeft")) || a.getBoundingClientRect().left - Da(a, {
      marginLeft: 0
    }, function () {
      return a.getBoundingClientRect().left;
    })) + "px" : void 0;
  }), n.cssHooks.marginRight = Ga(l.reliableMarginRight, function (a, b) {
    return b ? Da(a, {
      display: "inline-block"
    }, Fa, [a, "marginRight"]) : void 0;
  }), n.each({
    margin: "",
    padding: "",
    border: "Width"
  }, function (a, b) {
    n.cssHooks[a + b] = {
      expand: function expand(c) {
        for (var d = 0, e = {}, f = "string" == typeof c ? c.split(" ") : [c]; 4 > d; d++) {
          e[a + U[d] + b] = f[d] || f[d - 2] || f[0];
        }

        return e;
      }
    }, Aa.test(a) || (n.cssHooks[a + b].set = Na);
  }), n.fn.extend({
    css: function css(a, b) {
      return K(this, function (a, b, c) {
        var d,
            e,
            f = {},
            g = 0;

        if (n.isArray(b)) {
          for (d = Ca(a), e = b.length; e > g; g++) {
            f[b[g]] = n.css(a, b[g], !1, d);
          }

          return f;
        }

        return void 0 !== c ? n.style(a, b, c) : n.css(a, b);
      }, a, b, arguments.length > 1);
    },
    show: function show() {
      return Qa(this, !0);
    },
    hide: function hide() {
      return Qa(this);
    },
    toggle: function toggle(a) {
      return "boolean" == typeof a ? a ? this.show() : this.hide() : this.each(function () {
        V(this) ? n(this).show() : n(this).hide();
      });
    }
  });

  function Ra(a, b, c, d, e) {
    return new Ra.prototype.init(a, b, c, d, e);
  }

  n.Tween = Ra, Ra.prototype = {
    constructor: Ra,
    init: function init(a, b, c, d, e, f) {
      this.elem = a, this.prop = c, this.easing = e || n.easing._default, this.options = b, this.start = this.now = this.cur(), this.end = d, this.unit = f || (n.cssNumber[c] ? "" : "px");
    },
    cur: function cur() {
      var a = Ra.propHooks[this.prop];
      return a && a.get ? a.get(this) : Ra.propHooks._default.get(this);
    },
    run: function run(a) {
      var b,
          c = Ra.propHooks[this.prop];
      return this.options.duration ? this.pos = b = n.easing[this.easing](a, this.options.duration * a, 0, 1, this.options.duration) : this.pos = b = a, this.now = (this.end - this.start) * b + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), c && c.set ? c.set(this) : Ra.propHooks._default.set(this), this;
    }
  }, Ra.prototype.init.prototype = Ra.prototype, Ra.propHooks = {
    _default: {
      get: function get(a) {
        var b;
        return 1 !== a.elem.nodeType || null != a.elem[a.prop] && null == a.elem.style[a.prop] ? a.elem[a.prop] : (b = n.css(a.elem, a.prop, ""), b && "auto" !== b ? b : 0);
      },
      set: function set(a) {
        n.fx.step[a.prop] ? n.fx.step[a.prop](a) : 1 !== a.elem.nodeType || null == a.elem.style[n.cssProps[a.prop]] && !n.cssHooks[a.prop] ? a.elem[a.prop] = a.now : n.style(a.elem, a.prop, a.now + a.unit);
      }
    }
  }, Ra.propHooks.scrollTop = Ra.propHooks.scrollLeft = {
    set: function set(a) {
      a.elem.nodeType && a.elem.parentNode && (a.elem[a.prop] = a.now);
    }
  }, n.easing = {
    linear: function linear(a) {
      return a;
    },
    swing: function swing(a) {
      return .5 - Math.cos(a * Math.PI) / 2;
    },
    _default: "swing"
  }, n.fx = Ra.prototype.init, n.fx.step = {};
  var Sa,
      Ta,
      Ua = /^(?:toggle|show|hide)$/,
      Va = /queueHooks$/;

  function Wa() {
    return a.setTimeout(function () {
      Sa = void 0;
    }), Sa = n.now();
  }

  function Xa(a, b) {
    var c,
        d = 0,
        e = {
      height: a
    };

    for (b = b ? 1 : 0; 4 > d; d += 2 - b) {
      c = U[d], e["margin" + c] = e["padding" + c] = a;
    }

    return b && (e.opacity = e.width = a), e;
  }

  function Ya(a, b, c) {
    for (var d, e = (_a.tweeners[b] || []).concat(_a.tweeners["*"]), f = 0, g = e.length; g > f; f++) {
      if (d = e[f].call(c, b, a)) return d;
    }
  }

  function Za(a, b, c) {
    var d,
        e,
        f,
        g,
        h,
        i,
        j,
        k,
        l = this,
        m = {},
        o = a.style,
        p = a.nodeType && V(a),
        q = N.get(a, "fxshow");
    c.queue || (h = n._queueHooks(a, "fx"), null == h.unqueued && (h.unqueued = 0, i = h.empty.fire, h.empty.fire = function () {
      h.unqueued || i();
    }), h.unqueued++, l.always(function () {
      l.always(function () {
        h.unqueued--, n.queue(a, "fx").length || h.empty.fire();
      });
    })), 1 === a.nodeType && ("height" in b || "width" in b) && (c.overflow = [o.overflow, o.overflowX, o.overflowY], j = n.css(a, "display"), k = "none" === j ? N.get(a, "olddisplay") || za(a.nodeName) : j, "inline" === k && "none" === n.css(a, "float") && (o.display = "inline-block")), c.overflow && (o.overflow = "hidden", l.always(function () {
      o.overflow = c.overflow[0], o.overflowX = c.overflow[1], o.overflowY = c.overflow[2];
    }));

    for (d in b) {
      if (e = b[d], Ua.exec(e)) {
        if (delete b[d], f = f || "toggle" === e, e === (p ? "hide" : "show")) {
          if ("show" !== e || !q || void 0 === q[d]) continue;
          p = !0;
        }

        m[d] = q && q[d] || n.style(a, d);
      } else j = void 0;
    }

    if (n.isEmptyObject(m)) "inline" === ("none" === j ? za(a.nodeName) : j) && (o.display = j);else {
      q ? "hidden" in q && (p = q.hidden) : q = N.access(a, "fxshow", {}), f && (q.hidden = !p), p ? n(a).show() : l.done(function () {
        n(a).hide();
      }), l.done(function () {
        var b;
        N.remove(a, "fxshow");

        for (b in m) {
          n.style(a, b, m[b]);
        }
      });

      for (d in m) {
        g = Ya(p ? q[d] : 0, d, l), d in q || (q[d] = g.start, p && (g.end = g.start, g.start = "width" === d || "height" === d ? 1 : 0));
      }
    }
  }

  function $a(a, b) {
    var c, d, e, f, g;

    for (c in a) {
      if (d = n.camelCase(c), e = b[d], f = a[c], n.isArray(f) && (e = f[1], f = a[c] = f[0]), c !== d && (a[d] = f, delete a[c]), g = n.cssHooks[d], g && "expand" in g) {
        f = g.expand(f), delete a[d];

        for (c in f) {
          c in a || (a[c] = f[c], b[c] = e);
        }
      } else b[d] = e;
    }
  }

  function _a(a, b, c) {
    var d,
        e,
        f = 0,
        g = _a.prefilters.length,
        h = n.Deferred().always(function () {
      delete i.elem;
    }),
        i = function i() {
      if (e) return !1;

      for (var b = Sa || Wa(), c = Math.max(0, j.startTime + j.duration - b), d = c / j.duration || 0, f = 1 - d, g = 0, i = j.tweens.length; i > g; g++) {
        j.tweens[g].run(f);
      }

      return h.notifyWith(a, [j, f, c]), 1 > f && i ? c : (h.resolveWith(a, [j]), !1);
    },
        j = h.promise({
      elem: a,
      props: n.extend({}, b),
      opts: n.extend(!0, {
        specialEasing: {},
        easing: n.easing._default
      }, c),
      originalProperties: b,
      originalOptions: c,
      startTime: Sa || Wa(),
      duration: c.duration,
      tweens: [],
      createTween: function createTween(b, c) {
        var d = n.Tween(a, j.opts, b, c, j.opts.specialEasing[b] || j.opts.easing);
        return j.tweens.push(d), d;
      },
      stop: function stop(b) {
        var c = 0,
            d = b ? j.tweens.length : 0;
        if (e) return this;

        for (e = !0; d > c; c++) {
          j.tweens[c].run(1);
        }

        return b ? (h.notifyWith(a, [j, 1, 0]), h.resolveWith(a, [j, b])) : h.rejectWith(a, [j, b]), this;
      }
    }),
        k = j.props;

    for ($a(k, j.opts.specialEasing); g > f; f++) {
      if (d = _a.prefilters[f].call(j, a, k, j.opts)) return n.isFunction(d.stop) && (n._queueHooks(j.elem, j.opts.queue).stop = n.proxy(d.stop, d)), d;
    }

    return n.map(k, Ya, j), n.isFunction(j.opts.start) && j.opts.start.call(a, j), n.fx.timer(n.extend(i, {
      elem: a,
      anim: j,
      queue: j.opts.queue
    })), j.progress(j.opts.progress).done(j.opts.done, j.opts.complete).fail(j.opts.fail).always(j.opts.always);
  }

  n.Animation = n.extend(_a, {
    tweeners: {
      "*": [function (a, b) {
        var c = this.createTween(a, b);
        return W(c.elem, a, T.exec(b), c), c;
      }]
    },
    tweener: function tweener(a, b) {
      n.isFunction(a) ? (b = a, a = ["*"]) : a = a.match(G);

      for (var c, d = 0, e = a.length; e > d; d++) {
        c = a[d], _a.tweeners[c] = _a.tweeners[c] || [], _a.tweeners[c].unshift(b);
      }
    },
    prefilters: [Za],
    prefilter: function prefilter(a, b) {
      b ? _a.prefilters.unshift(a) : _a.prefilters.push(a);
    }
  }), n.speed = function (a, b, c) {
    var d = a && "object" == _typeof(a) ? n.extend({}, a) : {
      complete: c || !c && b || n.isFunction(a) && a,
      duration: a,
      easing: c && b || b && !n.isFunction(b) && b
    };
    return d.duration = n.fx.off ? 0 : "number" == typeof d.duration ? d.duration : d.duration in n.fx.speeds ? n.fx.speeds[d.duration] : n.fx.speeds._default, null != d.queue && d.queue !== !0 || (d.queue = "fx"), d.old = d.complete, d.complete = function () {
      n.isFunction(d.old) && d.old.call(this), d.queue && n.dequeue(this, d.queue);
    }, d;
  }, n.fn.extend({
    fadeTo: function fadeTo(a, b, c, d) {
      return this.filter(V).css("opacity", 0).show().end().animate({
        opacity: b
      }, a, c, d);
    },
    animate: function animate(a, b, c, d) {
      var e = n.isEmptyObject(a),
          f = n.speed(b, c, d),
          g = function g() {
        var b = _a(this, n.extend({}, a), f);

        (e || N.get(this, "finish")) && b.stop(!0);
      };

      return g.finish = g, e || f.queue === !1 ? this.each(g) : this.queue(f.queue, g);
    },
    stop: function stop(a, b, c) {
      var d = function d(a) {
        var b = a.stop;
        delete a.stop, b(c);
      };

      return "string" != typeof a && (c = b, b = a, a = void 0), b && a !== !1 && this.queue(a || "fx", []), this.each(function () {
        var b = !0,
            e = null != a && a + "queueHooks",
            f = n.timers,
            g = N.get(this);
        if (e) g[e] && g[e].stop && d(g[e]);else for (e in g) {
          g[e] && g[e].stop && Va.test(e) && d(g[e]);
        }

        for (e = f.length; e--;) {
          f[e].elem !== this || null != a && f[e].queue !== a || (f[e].anim.stop(c), b = !1, f.splice(e, 1));
        }

        !b && c || n.dequeue(this, a);
      });
    },
    finish: function finish(a) {
      return a !== !1 && (a = a || "fx"), this.each(function () {
        var b,
            c = N.get(this),
            d = c[a + "queue"],
            e = c[a + "queueHooks"],
            f = n.timers,
            g = d ? d.length : 0;

        for (c.finish = !0, n.queue(this, a, []), e && e.stop && e.stop.call(this, !0), b = f.length; b--;) {
          f[b].elem === this && f[b].queue === a && (f[b].anim.stop(!0), f.splice(b, 1));
        }

        for (b = 0; g > b; b++) {
          d[b] && d[b].finish && d[b].finish.call(this);
        }

        delete c.finish;
      });
    }
  }), n.each(["toggle", "show", "hide"], function (a, b) {
    var c = n.fn[b];

    n.fn[b] = function (a, d, e) {
      return null == a || "boolean" == typeof a ? c.apply(this, arguments) : this.animate(Xa(b, !0), a, d, e);
    };
  }), n.each({
    slideDown: Xa("show"),
    slideUp: Xa("hide"),
    slideToggle: Xa("toggle"),
    fadeIn: {
      opacity: "show"
    },
    fadeOut: {
      opacity: "hide"
    },
    fadeToggle: {
      opacity: "toggle"
    }
  }, function (a, b) {
    n.fn[a] = function (a, c, d) {
      return this.animate(b, a, c, d);
    };
  }), n.timers = [], n.fx.tick = function () {
    var a,
        b = 0,
        c = n.timers;

    for (Sa = n.now(); b < c.length; b++) {
      a = c[b], a() || c[b] !== a || c.splice(b--, 1);
    }

    c.length || n.fx.stop(), Sa = void 0;
  }, n.fx.timer = function (a) {
    n.timers.push(a), a() ? n.fx.start() : n.timers.pop();
  }, n.fx.interval = 13, n.fx.start = function () {
    Ta || (Ta = a.setInterval(n.fx.tick, n.fx.interval));
  }, n.fx.stop = function () {
    a.clearInterval(Ta), Ta = null;
  }, n.fx.speeds = {
    slow: 600,
    fast: 200,
    _default: 400
  }, n.fn.delay = function (b, c) {
    return b = n.fx ? n.fx.speeds[b] || b : b, c = c || "fx", this.queue(c, function (c, d) {
      var e = a.setTimeout(c, b);

      d.stop = function () {
        a.clearTimeout(e);
      };
    });
  }, function () {
    var a = d.createElement("input"),
        b = d.createElement("select"),
        c = b.appendChild(d.createElement("option"));
    a.type = "checkbox", l.checkOn = "" !== a.value, l.optSelected = c.selected, b.disabled = !0, l.optDisabled = !c.disabled, a = d.createElement("input"), a.value = "t", a.type = "radio", l.radioValue = "t" === a.value;
  }();
  var ab,
      bb = n.expr.attrHandle;
  n.fn.extend({
    attr: function attr(a, b) {
      return K(this, n.attr, a, b, arguments.length > 1);
    },
    removeAttr: function removeAttr(a) {
      return this.each(function () {
        n.removeAttr(this, a);
      });
    }
  }), n.extend({
    attr: function attr(a, b, c) {
      var d,
          e,
          f = a.nodeType;
      if (3 !== f && 8 !== f && 2 !== f) return "undefined" == typeof a.getAttribute ? n.prop(a, b, c) : (1 === f && n.isXMLDoc(a) || (b = b.toLowerCase(), e = n.attrHooks[b] || (n.expr.match.bool.test(b) ? ab : void 0)), void 0 !== c ? null === c ? void n.removeAttr(a, b) : e && "set" in e && void 0 !== (d = e.set(a, c, b)) ? d : (a.setAttribute(b, c + ""), c) : e && "get" in e && null !== (d = e.get(a, b)) ? d : (d = n.find.attr(a, b), null == d ? void 0 : d));
    },
    attrHooks: {
      type: {
        set: function set(a, b) {
          if (!l.radioValue && "radio" === b && n.nodeName(a, "input")) {
            var c = a.value;
            return a.setAttribute("type", b), c && (a.value = c), b;
          }
        }
      }
    },
    removeAttr: function removeAttr(a, b) {
      var c,
          d,
          e = 0,
          f = b && b.match(G);
      if (f && 1 === a.nodeType) while (c = f[e++]) {
        d = n.propFix[c] || c, n.expr.match.bool.test(c) && (a[d] = !1), a.removeAttribute(c);
      }
    }
  }), ab = {
    set: function set(a, b, c) {
      return b === !1 ? n.removeAttr(a, c) : a.setAttribute(c, c), c;
    }
  }, n.each(n.expr.match.bool.source.match(/\w+/g), function (a, b) {
    var c = bb[b] || n.find.attr;

    bb[b] = function (a, b, d) {
      var e, f;
      return d || (f = bb[b], bb[b] = e, e = null != c(a, b, d) ? b.toLowerCase() : null, bb[b] = f), e;
    };
  });
  var cb = /^(?:input|select|textarea|button)$/i,
      db = /^(?:a|area)$/i;
  n.fn.extend({
    prop: function prop(a, b) {
      return K(this, n.prop, a, b, arguments.length > 1);
    },
    removeProp: function removeProp(a) {
      return this.each(function () {
        delete this[n.propFix[a] || a];
      });
    }
  }), n.extend({
    prop: function prop(a, b, c) {
      var d,
          e,
          f = a.nodeType;
      if (3 !== f && 8 !== f && 2 !== f) return 1 === f && n.isXMLDoc(a) || (b = n.propFix[b] || b, e = n.propHooks[b]), void 0 !== c ? e && "set" in e && void 0 !== (d = e.set(a, c, b)) ? d : a[b] = c : e && "get" in e && null !== (d = e.get(a, b)) ? d : a[b];
    },
    propHooks: {
      tabIndex: {
        get: function get(a) {
          var b = n.find.attr(a, "tabindex");
          return b ? parseInt(b, 10) : cb.test(a.nodeName) || db.test(a.nodeName) && a.href ? 0 : -1;
        }
      }
    },
    propFix: {
      "for": "htmlFor",
      "class": "className"
    }
  }), l.optSelected || (n.propHooks.selected = {
    get: function get(a) {
      var b = a.parentNode;
      return b && b.parentNode && b.parentNode.selectedIndex, null;
    },
    set: function set(a) {
      var b = a.parentNode;
      b && (b.selectedIndex, b.parentNode && b.parentNode.selectedIndex);
    }
  }), n.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], function () {
    n.propFix[this.toLowerCase()] = this;
  });
  var eb = /[\t\r\n\f]/g;

  function fb(a) {
    return a.getAttribute && a.getAttribute("class") || "";
  }

  n.fn.extend({
    addClass: function addClass(a) {
      var b,
          c,
          d,
          e,
          f,
          g,
          h,
          i = 0;
      if (n.isFunction(a)) return this.each(function (b) {
        n(this).addClass(a.call(this, b, fb(this)));
      });

      if ("string" == typeof a && a) {
        b = a.match(G) || [];

        while (c = this[i++]) {
          if (e = fb(c), d = 1 === c.nodeType && (" " + e + " ").replace(eb, " ")) {
            g = 0;

            while (f = b[g++]) {
              d.indexOf(" " + f + " ") < 0 && (d += f + " ");
            }

            h = n.trim(d), e !== h && c.setAttribute("class", h);
          }
        }
      }

      return this;
    },
    removeClass: function removeClass(a) {
      var b,
          c,
          d,
          e,
          f,
          g,
          h,
          i = 0;
      if (n.isFunction(a)) return this.each(function (b) {
        n(this).removeClass(a.call(this, b, fb(this)));
      });
      if (!arguments.length) return this.attr("class", "");

      if ("string" == typeof a && a) {
        b = a.match(G) || [];

        while (c = this[i++]) {
          if (e = fb(c), d = 1 === c.nodeType && (" " + e + " ").replace(eb, " ")) {
            g = 0;

            while (f = b[g++]) {
              while (d.indexOf(" " + f + " ") > -1) {
                d = d.replace(" " + f + " ", " ");
              }
            }

            h = n.trim(d), e !== h && c.setAttribute("class", h);
          }
        }
      }

      return this;
    },
    toggleClass: function toggleClass(a, b) {
      var c = _typeof(a);

      return "boolean" == typeof b && "string" === c ? b ? this.addClass(a) : this.removeClass(a) : n.isFunction(a) ? this.each(function (c) {
        n(this).toggleClass(a.call(this, c, fb(this), b), b);
      }) : this.each(function () {
        var b, d, e, f;

        if ("string" === c) {
          d = 0, e = n(this), f = a.match(G) || [];

          while (b = f[d++]) {
            e.hasClass(b) ? e.removeClass(b) : e.addClass(b);
          }
        } else void 0 !== a && "boolean" !== c || (b = fb(this), b && N.set(this, "__className__", b), this.setAttribute && this.setAttribute("class", b || a === !1 ? "" : N.get(this, "__className__") || ""));
      });
    },
    hasClass: function hasClass(a) {
      var b,
          c,
          d = 0;
      b = " " + a + " ";

      while (c = this[d++]) {
        if (1 === c.nodeType && (" " + fb(c) + " ").replace(eb, " ").indexOf(b) > -1) return !0;
      }

      return !1;
    }
  });
  var gb = /\r/g,
      hb = /[\x20\t\r\n\f]+/g;
  n.fn.extend({
    val: function val(a) {
      var b,
          c,
          d,
          e = this[0];
      {
        if (arguments.length) return d = n.isFunction(a), this.each(function (c) {
          var e;
          1 === this.nodeType && (e = d ? a.call(this, c, n(this).val()) : a, null == e ? e = "" : "number" == typeof e ? e += "" : n.isArray(e) && (e = n.map(e, function (a) {
            return null == a ? "" : a + "";
          })), b = n.valHooks[this.type] || n.valHooks[this.nodeName.toLowerCase()], b && "set" in b && void 0 !== b.set(this, e, "value") || (this.value = e));
        });
        if (e) return b = n.valHooks[e.type] || n.valHooks[e.nodeName.toLowerCase()], b && "get" in b && void 0 !== (c = b.get(e, "value")) ? c : (c = e.value, "string" == typeof c ? c.replace(gb, "") : null == c ? "" : c);
      }
    }
  }), n.extend({
    valHooks: {
      option: {
        get: function get(a) {
          var b = n.find.attr(a, "value");
          return null != b ? b : n.trim(n.text(a)).replace(hb, " ");
        }
      },
      select: {
        get: function get(a) {
          for (var b, c, d = a.options, e = a.selectedIndex, f = "select-one" === a.type || 0 > e, g = f ? null : [], h = f ? e + 1 : d.length, i = 0 > e ? h : f ? e : 0; h > i; i++) {
            if (c = d[i], (c.selected || i === e) && (l.optDisabled ? !c.disabled : null === c.getAttribute("disabled")) && (!c.parentNode.disabled || !n.nodeName(c.parentNode, "optgroup"))) {
              if (b = n(c).val(), f) return b;
              g.push(b);
            }
          }

          return g;
        },
        set: function set(a, b) {
          var c,
              d,
              e = a.options,
              f = n.makeArray(b),
              g = e.length;

          while (g--) {
            d = e[g], (d.selected = n.inArray(n.valHooks.option.get(d), f) > -1) && (c = !0);
          }

          return c || (a.selectedIndex = -1), f;
        }
      }
    }
  }), n.each(["radio", "checkbox"], function () {
    n.valHooks[this] = {
      set: function set(a, b) {
        return n.isArray(b) ? a.checked = n.inArray(n(a).val(), b) > -1 : void 0;
      }
    }, l.checkOn || (n.valHooks[this].get = function (a) {
      return null === a.getAttribute("value") ? "on" : a.value;
    });
  });
  var ib = /^(?:focusinfocus|focusoutblur)$/;
  n.extend(n.event, {
    trigger: function trigger(b, c, e, f) {
      var g,
          h,
          i,
          j,
          l,
          m,
          o,
          p = [e || d],
          q = k.call(b, "type") ? b.type : b,
          r = k.call(b, "namespace") ? b.namespace.split(".") : [];

      if (h = i = e = e || d, 3 !== e.nodeType && 8 !== e.nodeType && !ib.test(q + n.event.triggered) && (q.indexOf(".") > -1 && (r = q.split("."), q = r.shift(), r.sort()), l = q.indexOf(":") < 0 && "on" + q, b = b[n.expando] ? b : new n.Event(q, "object" == _typeof(b) && b), b.isTrigger = f ? 2 : 3, b.namespace = r.join("."), b.rnamespace = b.namespace ? new RegExp("(^|\\.)" + r.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, b.result = void 0, b.target || (b.target = e), c = null == c ? [b] : n.makeArray(c, [b]), o = n.event.special[q] || {}, f || !o.trigger || o.trigger.apply(e, c) !== !1)) {
        if (!f && !o.noBubble && !n.isWindow(e)) {
          for (j = o.delegateType || q, ib.test(j + q) || (h = h.parentNode); h; h = h.parentNode) {
            p.push(h), i = h;
          }

          i === (e.ownerDocument || d) && p.push(i.defaultView || i.parentWindow || a);
        }

        g = 0;

        while ((h = p[g++]) && !b.isPropagationStopped()) {
          b.type = g > 1 ? j : o.bindType || q, m = (N.get(h, "events") || {})[b.type] && N.get(h, "handle"), m && m.apply(h, c), m = l && h[l], m && m.apply && L(h) && (b.result = m.apply(h, c), b.result === !1 && b.preventDefault());
        }

        return b.type = q, f || b.isDefaultPrevented() || o._default && o._default.apply(p.pop(), c) !== !1 || !L(e) || l && n.isFunction(e[q]) && !n.isWindow(e) && (i = e[l], i && (e[l] = null), n.event.triggered = q, e[q](), n.event.triggered = void 0, i && (e[l] = i)), b.result;
      }
    },
    simulate: function simulate(a, b, c) {
      var d = n.extend(new n.Event(), c, {
        type: a,
        isSimulated: !0
      });
      n.event.trigger(d, null, b);
    }
  }), n.fn.extend({
    trigger: function trigger(a, b) {
      return this.each(function () {
        n.event.trigger(a, b, this);
      });
    },
    triggerHandler: function triggerHandler(a, b) {
      var c = this[0];
      return c ? n.event.trigger(a, b, c, !0) : void 0;
    }
  }), n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (a, b) {
    n.fn[b] = function (a, c) {
      return arguments.length > 0 ? this.on(b, null, a, c) : this.trigger(b);
    };
  }), n.fn.extend({
    hover: function hover(a, b) {
      return this.mouseenter(a).mouseleave(b || a);
    }
  }), l.focusin = "onfocusin" in a, l.focusin || n.each({
    focus: "focusin",
    blur: "focusout"
  }, function (a, b) {
    var c = function c(a) {
      n.event.simulate(b, a.target, n.event.fix(a));
    };

    n.event.special[b] = {
      setup: function setup() {
        var d = this.ownerDocument || this,
            e = N.access(d, b);
        e || d.addEventListener(a, c, !0), N.access(d, b, (e || 0) + 1);
      },
      teardown: function teardown() {
        var d = this.ownerDocument || this,
            e = N.access(d, b) - 1;
        e ? N.access(d, b, e) : (d.removeEventListener(a, c, !0), N.remove(d, b));
      }
    };
  });
  var jb = a.location,
      kb = n.now(),
      lb = /\?/;
  n.parseJSON = function (a) {
    return JSON.parse(a + "");
  }, n.parseXML = function (b) {
    var c;
    if (!b || "string" != typeof b) return null;

    try {
      c = new a.DOMParser().parseFromString(b, "text/xml");
    } catch (d) {
      c = void 0;
    }

    return c && !c.getElementsByTagName("parsererror").length || n.error("Invalid XML: " + b), c;
  };
  var mb = /#.*$/,
      nb = /([?&])_=[^&]*/,
      ob = /^(.*?):[ \t]*([^\r\n]*)$/gm,
      pb = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
      qb = /^(?:GET|HEAD)$/,
      rb = /^\/\//,
      sb = {},
      tb = {},
      ub = "*/".concat("*"),
      vb = d.createElement("a");
  vb.href = jb.href;

  function wb(a) {
    return function (b, c) {
      "string" != typeof b && (c = b, b = "*");
      var d,
          e = 0,
          f = b.toLowerCase().match(G) || [];
      if (n.isFunction(c)) while (d = f[e++]) {
        "+" === d[0] ? (d = d.slice(1) || "*", (a[d] = a[d] || []).unshift(c)) : (a[d] = a[d] || []).push(c);
      }
    };
  }

  function xb(a, b, c, d) {
    var e = {},
        f = a === tb;

    function g(h) {
      var i;
      return e[h] = !0, n.each(a[h] || [], function (a, h) {
        var j = h(b, c, d);
        return "string" != typeof j || f || e[j] ? f ? !(i = j) : void 0 : (b.dataTypes.unshift(j), g(j), !1);
      }), i;
    }

    return g(b.dataTypes[0]) || !e["*"] && g("*");
  }

  function yb(a, b) {
    var c,
        d,
        e = n.ajaxSettings.flatOptions || {};

    for (c in b) {
      void 0 !== b[c] && ((e[c] ? a : d || (d = {}))[c] = b[c]);
    }

    return d && n.extend(!0, a, d), a;
  }

  function zb(a, b, c) {
    var d,
        e,
        f,
        g,
        h = a.contents,
        i = a.dataTypes;

    while ("*" === i[0]) {
      i.shift(), void 0 === d && (d = a.mimeType || b.getResponseHeader("Content-Type"));
    }

    if (d) for (e in h) {
      if (h[e] && h[e].test(d)) {
        i.unshift(e);
        break;
      }
    }
    if (i[0] in c) f = i[0];else {
      for (e in c) {
        if (!i[0] || a.converters[e + " " + i[0]]) {
          f = e;
          break;
        }

        g || (g = e);
      }

      f = f || g;
    }
    return f ? (f !== i[0] && i.unshift(f), c[f]) : void 0;
  }

  function Ab(a, b, c, d) {
    var e,
        f,
        g,
        h,
        i,
        j = {},
        k = a.dataTypes.slice();
    if (k[1]) for (g in a.converters) {
      j[g.toLowerCase()] = a.converters[g];
    }
    f = k.shift();

    while (f) {
      if (a.responseFields[f] && (c[a.responseFields[f]] = b), !i && d && a.dataFilter && (b = a.dataFilter(b, a.dataType)), i = f, f = k.shift()) if ("*" === f) f = i;else if ("*" !== i && i !== f) {
        if (g = j[i + " " + f] || j["* " + f], !g) for (e in j) {
          if (h = e.split(" "), h[1] === f && (g = j[i + " " + h[0]] || j["* " + h[0]])) {
            g === !0 ? g = j[e] : j[e] !== !0 && (f = h[0], k.unshift(h[1]));
            break;
          }
        }
        if (g !== !0) if (g && a["throws"]) b = g(b);else try {
          b = g(b);
        } catch (l) {
          return {
            state: "parsererror",
            error: g ? l : "No conversion from " + i + " to " + f
          };
        }
      }
    }

    return {
      state: "success",
      data: b
    };
  }

  n.extend({
    active: 0,
    lastModified: {},
    etag: {},
    ajaxSettings: {
      url: jb.href,
      type: "GET",
      isLocal: pb.test(jb.protocol),
      global: !0,
      processData: !0,
      async: !0,
      contentType: "application/x-www-form-urlencoded; charset=UTF-8",
      accepts: {
        "*": ub,
        text: "text/plain",
        html: "text/html",
        xml: "application/xml, text/xml",
        json: "application/json, text/javascript"
      },
      contents: {
        xml: /\bxml\b/,
        html: /\bhtml/,
        json: /\bjson\b/
      },
      responseFields: {
        xml: "responseXML",
        text: "responseText",
        json: "responseJSON"
      },
      converters: {
        "* text": String,
        "text html": !0,
        "text json": n.parseJSON,
        "text xml": n.parseXML
      },
      flatOptions: {
        url: !0,
        context: !0
      }
    },
    ajaxSetup: function ajaxSetup(a, b) {
      return b ? yb(yb(a, n.ajaxSettings), b) : yb(n.ajaxSettings, a);
    },
    ajaxPrefilter: wb(sb),
    ajaxTransport: wb(tb),
    ajax: function ajax(b, c) {
      "object" == _typeof(b) && (c = b, b = void 0), c = c || {};
      var e,
          f,
          g,
          h,
          i,
          j,
          k,
          l,
          m = n.ajaxSetup({}, c),
          o = m.context || m,
          p = m.context && (o.nodeType || o.jquery) ? n(o) : n.event,
          q = n.Deferred(),
          r = n.Callbacks("once memory"),
          s = m.statusCode || {},
          t = {},
          u = {},
          v = 0,
          w = "canceled",
          x = {
        readyState: 0,
        getResponseHeader: function getResponseHeader(a) {
          var b;

          if (2 === v) {
            if (!h) {
              h = {};

              while (b = ob.exec(g)) {
                h[b[1].toLowerCase()] = b[2];
              }
            }

            b = h[a.toLowerCase()];
          }

          return null == b ? null : b;
        },
        getAllResponseHeaders: function getAllResponseHeaders() {
          return 2 === v ? g : null;
        },
        setRequestHeader: function setRequestHeader(a, b) {
          var c = a.toLowerCase();
          return v || (a = u[c] = u[c] || a, t[a] = b), this;
        },
        overrideMimeType: function overrideMimeType(a) {
          return v || (m.mimeType = a), this;
        },
        statusCode: function statusCode(a) {
          var b;
          if (a) if (2 > v) for (b in a) {
            s[b] = [s[b], a[b]];
          } else x.always(a[x.status]);
          return this;
        },
        abort: function abort(a) {
          var b = a || w;
          return e && e.abort(b), z(0, b), this;
        }
      };

      if (q.promise(x).complete = r.add, x.success = x.done, x.error = x.fail, m.url = ((b || m.url || jb.href) + "").replace(mb, "").replace(rb, jb.protocol + "//"), m.type = c.method || c.type || m.method || m.type, m.dataTypes = n.trim(m.dataType || "*").toLowerCase().match(G) || [""], null == m.crossDomain) {
        j = d.createElement("a");

        try {
          j.href = m.url, j.href = j.href, m.crossDomain = vb.protocol + "//" + vb.host != j.protocol + "//" + j.host;
        } catch (y) {
          m.crossDomain = !0;
        }
      }

      if (m.data && m.processData && "string" != typeof m.data && (m.data = n.param(m.data, m.traditional)), xb(sb, m, c, x), 2 === v) return x;
      k = n.event && m.global, k && 0 === n.active++ && n.event.trigger("ajaxStart"), m.type = m.type.toUpperCase(), m.hasContent = !qb.test(m.type), f = m.url, m.hasContent || (m.data && (f = m.url += (lb.test(f) ? "&" : "?") + m.data, delete m.data), m.cache === !1 && (m.url = nb.test(f) ? f.replace(nb, "$1_=" + kb++) : f + (lb.test(f) ? "&" : "?") + "_=" + kb++)), m.ifModified && (n.lastModified[f] && x.setRequestHeader("If-Modified-Since", n.lastModified[f]), n.etag[f] && x.setRequestHeader("If-None-Match", n.etag[f])), (m.data && m.hasContent && m.contentType !== !1 || c.contentType) && x.setRequestHeader("Content-Type", m.contentType), x.setRequestHeader("Accept", m.dataTypes[0] && m.accepts[m.dataTypes[0]] ? m.accepts[m.dataTypes[0]] + ("*" !== m.dataTypes[0] ? ", " + ub + "; q=0.01" : "") : m.accepts["*"]);

      for (l in m.headers) {
        x.setRequestHeader(l, m.headers[l]);
      }

      if (m.beforeSend && (m.beforeSend.call(o, x, m) === !1 || 2 === v)) return x.abort();
      w = "abort";

      for (l in {
        success: 1,
        error: 1,
        complete: 1
      }) {
        x[l](m[l]);
      }

      if (e = xb(tb, m, c, x)) {
        if (x.readyState = 1, k && p.trigger("ajaxSend", [x, m]), 2 === v) return x;
        m.async && m.timeout > 0 && (i = a.setTimeout(function () {
          x.abort("timeout");
        }, m.timeout));

        try {
          v = 1, e.send(t, z);
        } catch (y) {
          if (!(2 > v)) throw y;
          z(-1, y);
        }
      } else z(-1, "No Transport");

      function z(b, c, d, h) {
        var j,
            l,
            t,
            u,
            w,
            y = c;
        2 !== v && (v = 2, i && a.clearTimeout(i), e = void 0, g = h || "", x.readyState = b > 0 ? 4 : 0, j = b >= 200 && 300 > b || 304 === b, d && (u = zb(m, x, d)), u = Ab(m, u, x, j), j ? (m.ifModified && (w = x.getResponseHeader("Last-Modified"), w && (n.lastModified[f] = w), w = x.getResponseHeader("etag"), w && (n.etag[f] = w)), 204 === b || "HEAD" === m.type ? y = "nocontent" : 304 === b ? y = "notmodified" : (y = u.state, l = u.data, t = u.error, j = !t)) : (t = y, !b && y || (y = "error", 0 > b && (b = 0))), x.status = b, x.statusText = (c || y) + "", j ? q.resolveWith(o, [l, y, x]) : q.rejectWith(o, [x, y, t]), x.statusCode(s), s = void 0, k && p.trigger(j ? "ajaxSuccess" : "ajaxError", [x, m, j ? l : t]), r.fireWith(o, [x, y]), k && (p.trigger("ajaxComplete", [x, m]), --n.active || n.event.trigger("ajaxStop")));
      }

      return x;
    },
    getJSON: function getJSON(a, b, c) {
      return n.get(a, b, c, "json");
    },
    getScript: function getScript(a, b) {
      return n.get(a, void 0, b, "script");
    }
  }), n.each(["get", "post"], function (a, b) {
    n[b] = function (a, c, d, e) {
      return n.isFunction(c) && (e = e || d, d = c, c = void 0), n.ajax(n.extend({
        url: a,
        type: b,
        dataType: e,
        data: c,
        success: d
      }, n.isPlainObject(a) && a));
    };
  }), n._evalUrl = function (a) {
    return n.ajax({
      url: a,
      type: "GET",
      dataType: "script",
      async: !1,
      global: !1,
      "throws": !0
    });
  }, n.fn.extend({
    wrapAll: function wrapAll(a) {
      var b;
      return n.isFunction(a) ? this.each(function (b) {
        n(this).wrapAll(a.call(this, b));
      }) : (this[0] && (b = n(a, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && b.insertBefore(this[0]), b.map(function () {
        var a = this;

        while (a.firstElementChild) {
          a = a.firstElementChild;
        }

        return a;
      }).append(this)), this);
    },
    wrapInner: function wrapInner(a) {
      return n.isFunction(a) ? this.each(function (b) {
        n(this).wrapInner(a.call(this, b));
      }) : this.each(function () {
        var b = n(this),
            c = b.contents();
        c.length ? c.wrapAll(a) : b.append(a);
      });
    },
    wrap: function wrap(a) {
      var b = n.isFunction(a);
      return this.each(function (c) {
        n(this).wrapAll(b ? a.call(this, c) : a);
      });
    },
    unwrap: function unwrap() {
      return this.parent().each(function () {
        n.nodeName(this, "body") || n(this).replaceWith(this.childNodes);
      }).end();
    }
  }), n.expr.filters.hidden = function (a) {
    return !n.expr.filters.visible(a);
  }, n.expr.filters.visible = function (a) {
    return a.offsetWidth > 0 || a.offsetHeight > 0 || a.getClientRects().length > 0;
  };
  var Bb = /%20/g,
      Cb = /\[\]$/,
      Db = /\r?\n/g,
      Eb = /^(?:submit|button|image|reset|file)$/i,
      Fb = /^(?:input|select|textarea|keygen)/i;

  function Gb(a, b, c, d) {
    var e;
    if (n.isArray(b)) n.each(b, function (b, e) {
      c || Cb.test(a) ? d(a, e) : Gb(a + "[" + ("object" == _typeof(e) && null != e ? b : "") + "]", e, c, d);
    });else if (c || "object" !== n.type(b)) d(a, b);else for (e in b) {
      Gb(a + "[" + e + "]", b[e], c, d);
    }
  }

  n.param = function (a, b) {
    var c,
        d = [],
        e = function e(a, b) {
      b = n.isFunction(b) ? b() : null == b ? "" : b, d[d.length] = encodeURIComponent(a) + "=" + encodeURIComponent(b);
    };

    if (void 0 === b && (b = n.ajaxSettings && n.ajaxSettings.traditional), n.isArray(a) || a.jquery && !n.isPlainObject(a)) n.each(a, function () {
      e(this.name, this.value);
    });else for (c in a) {
      Gb(c, a[c], b, e);
    }
    return d.join("&").replace(Bb, "+");
  }, n.fn.extend({
    serialize: function serialize() {
      return n.param(this.serializeArray());
    },
    serializeArray: function serializeArray() {
      return this.map(function () {
        var a = n.prop(this, "elements");
        return a ? n.makeArray(a) : this;
      }).filter(function () {
        var a = this.type;
        return this.name && !n(this).is(":disabled") && Fb.test(this.nodeName) && !Eb.test(a) && (this.checked || !X.test(a));
      }).map(function (a, b) {
        var c = n(this).val();
        return null == c ? null : n.isArray(c) ? n.map(c, function (a) {
          return {
            name: b.name,
            value: a.replace(Db, "\r\n")
          };
        }) : {
          name: b.name,
          value: c.replace(Db, "\r\n")
        };
      }).get();
    }
  }), n.ajaxSettings.xhr = function () {
    try {
      return new a.XMLHttpRequest();
    } catch (b) {}
  };
  var Hb = {
    0: 200,
    1223: 204
  },
      Ib = n.ajaxSettings.xhr();
  l.cors = !!Ib && "withCredentials" in Ib, l.ajax = Ib = !!Ib, n.ajaxTransport(function (b) {
    var _c, d;

    return l.cors || Ib && !b.crossDomain ? {
      send: function send(e, f) {
        var g,
            h = b.xhr();
        if (h.open(b.type, b.url, b.async, b.username, b.password), b.xhrFields) for (g in b.xhrFields) {
          h[g] = b.xhrFields[g];
        }
        b.mimeType && h.overrideMimeType && h.overrideMimeType(b.mimeType), b.crossDomain || e["X-Requested-With"] || (e["X-Requested-With"] = "XMLHttpRequest");

        for (g in e) {
          h.setRequestHeader(g, e[g]);
        }

        _c = function c(a) {
          return function () {
            _c && (_c = d = h.onload = h.onerror = h.onabort = h.onreadystatechange = null, "abort" === a ? h.abort() : "error" === a ? "number" != typeof h.status ? f(0, "error") : f(h.status, h.statusText) : f(Hb[h.status] || h.status, h.statusText, "text" !== (h.responseType || "text") || "string" != typeof h.responseText ? {
              binary: h.response
            } : {
              text: h.responseText
            }, h.getAllResponseHeaders()));
          };
        }, h.onload = _c(), d = h.onerror = _c("error"), void 0 !== h.onabort ? h.onabort = d : h.onreadystatechange = function () {
          4 === h.readyState && a.setTimeout(function () {
            _c && d();
          });
        }, _c = _c("abort");

        try {
          h.send(b.hasContent && b.data || null);
        } catch (i) {
          if (_c) throw i;
        }
      },
      abort: function abort() {
        _c && _c();
      }
    } : void 0;
  }), n.ajaxSetup({
    accepts: {
      script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
    },
    contents: {
      script: /\b(?:java|ecma)script\b/
    },
    converters: {
      "text script": function textScript(a) {
        return n.globalEval(a), a;
      }
    }
  }), n.ajaxPrefilter("script", function (a) {
    void 0 === a.cache && (a.cache = !1), a.crossDomain && (a.type = "GET");
  }), n.ajaxTransport("script", function (a) {
    if (a.crossDomain) {
      var b, _c2;

      return {
        send: function send(e, f) {
          b = n("<script>").prop({
            charset: a.scriptCharset,
            src: a.url
          }).on("load error", _c2 = function c(a) {
            b.remove(), _c2 = null, a && f("error" === a.type ? 404 : 200, a.type);
          }), d.head.appendChild(b[0]);
        },
        abort: function abort() {
          _c2 && _c2();
        }
      };
    }
  });
  var Jb = [],
      Kb = /(=)\?(?=&|$)|\?\?/;
  n.ajaxSetup({
    jsonp: "callback",
    jsonpCallback: function jsonpCallback() {
      var a = Jb.pop() || n.expando + "_" + kb++;
      return this[a] = !0, a;
    }
  }), n.ajaxPrefilter("json jsonp", function (b, c, d) {
    var e,
        f,
        g,
        h = b.jsonp !== !1 && (Kb.test(b.url) ? "url" : "string" == typeof b.data && 0 === (b.contentType || "").indexOf("application/x-www-form-urlencoded") && Kb.test(b.data) && "data");
    return h || "jsonp" === b.dataTypes[0] ? (e = b.jsonpCallback = n.isFunction(b.jsonpCallback) ? b.jsonpCallback() : b.jsonpCallback, h ? b[h] = b[h].replace(Kb, "$1" + e) : b.jsonp !== !1 && (b.url += (lb.test(b.url) ? "&" : "?") + b.jsonp + "=" + e), b.converters["script json"] = function () {
      return g || n.error(e + " was not called"), g[0];
    }, b.dataTypes[0] = "json", f = a[e], a[e] = function () {
      g = arguments;
    }, d.always(function () {
      void 0 === f ? n(a).removeProp(e) : a[e] = f, b[e] && (b.jsonpCallback = c.jsonpCallback, Jb.push(e)), g && n.isFunction(f) && f(g[0]), g = f = void 0;
    }), "script") : void 0;
  }), n.parseHTML = function (a, b, c) {
    if (!a || "string" != typeof a) return null;
    "boolean" == typeof b && (c = b, b = !1), b = b || d;
    var e = x.exec(a),
        f = !c && [];
    return e ? [b.createElement(e[1])] : (e = ca([a], b, f), f && f.length && n(f).remove(), n.merge([], e.childNodes));
  };
  var Lb = n.fn.load;
  n.fn.load = function (a, b, c) {
    if ("string" != typeof a && Lb) return Lb.apply(this, arguments);
    var d,
        e,
        f,
        g = this,
        h = a.indexOf(" ");
    return h > -1 && (d = n.trim(a.slice(h)), a = a.slice(0, h)), n.isFunction(b) ? (c = b, b = void 0) : b && "object" == _typeof(b) && (e = "POST"), g.length > 0 && n.ajax({
      url: a,
      type: e || "GET",
      dataType: "html",
      data: b
    }).done(function (a) {
      f = arguments, g.html(d ? n("<div>").append(n.parseHTML(a)).find(d) : a);
    }).always(c && function (a, b) {
      g.each(function () {
        c.apply(this, f || [a.responseText, b, a]);
      });
    }), this;
  }, n.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], function (a, b) {
    n.fn[b] = function (a) {
      return this.on(b, a);
    };
  }), n.expr.filters.animated = function (a) {
    return n.grep(n.timers, function (b) {
      return a === b.elem;
    }).length;
  };

  function Mb(a) {
    return n.isWindow(a) ? a : 9 === a.nodeType && a.defaultView;
  }

  n.offset = {
    setOffset: function setOffset(a, b, c) {
      var d,
          e,
          f,
          g,
          h,
          i,
          j,
          k = n.css(a, "position"),
          l = n(a),
          m = {};
      "static" === k && (a.style.position = "relative"), h = l.offset(), f = n.css(a, "top"), i = n.css(a, "left"), j = ("absolute" === k || "fixed" === k) && (f + i).indexOf("auto") > -1, j ? (d = l.position(), g = d.top, e = d.left) : (g = parseFloat(f) || 0, e = parseFloat(i) || 0), n.isFunction(b) && (b = b.call(a, c, n.extend({}, h))), null != b.top && (m.top = b.top - h.top + g), null != b.left && (m.left = b.left - h.left + e), "using" in b ? b.using.call(a, m) : l.css(m);
    }
  }, n.fn.extend({
    offset: function offset(a) {
      if (arguments.length) return void 0 === a ? this : this.each(function (b) {
        n.offset.setOffset(this, a, b);
      });
      var b,
          c,
          d = this[0],
          e = {
        top: 0,
        left: 0
      },
          f = d && d.ownerDocument;
      if (f) return b = f.documentElement, n.contains(b, d) ? (e = d.getBoundingClientRect(), c = Mb(f), {
        top: e.top + c.pageYOffset - b.clientTop,
        left: e.left + c.pageXOffset - b.clientLeft
      }) : e;
    },
    position: function position() {
      if (this[0]) {
        var a,
            b,
            c = this[0],
            d = {
          top: 0,
          left: 0
        };
        return "fixed" === n.css(c, "position") ? b = c.getBoundingClientRect() : (a = this.offsetParent(), b = this.offset(), n.nodeName(a[0], "html") || (d = a.offset()), d.top += n.css(a[0], "borderTopWidth", !0), d.left += n.css(a[0], "borderLeftWidth", !0)), {
          top: b.top - d.top - n.css(c, "marginTop", !0),
          left: b.left - d.left - n.css(c, "marginLeft", !0)
        };
      }
    },
    offsetParent: function offsetParent() {
      return this.map(function () {
        var a = this.offsetParent;

        while (a && "static" === n.css(a, "position")) {
          a = a.offsetParent;
        }

        return a || Ea;
      });
    }
  }), n.each({
    scrollLeft: "pageXOffset",
    scrollTop: "pageYOffset"
  }, function (a, b) {
    var c = "pageYOffset" === b;

    n.fn[a] = function (d) {
      return K(this, function (a, d, e) {
        var f = Mb(a);
        return void 0 === e ? f ? f[b] : a[d] : void (f ? f.scrollTo(c ? f.pageXOffset : e, c ? e : f.pageYOffset) : a[d] = e);
      }, a, d, arguments.length);
    };
  }), n.each(["top", "left"], function (a, b) {
    n.cssHooks[b] = Ga(l.pixelPosition, function (a, c) {
      return c ? (c = Fa(a, b), Ba.test(c) ? n(a).position()[b] + "px" : c) : void 0;
    });
  }), n.each({
    Height: "height",
    Width: "width"
  }, function (a, b) {
    n.each({
      padding: "inner" + a,
      content: b,
      "": "outer" + a
    }, function (c, d) {
      n.fn[d] = function (d, e) {
        var f = arguments.length && (c || "boolean" != typeof d),
            g = c || (d === !0 || e === !0 ? "margin" : "border");
        return K(this, function (b, c, d) {
          var e;
          return n.isWindow(b) ? b.document.documentElement["client" + a] : 9 === b.nodeType ? (e = b.documentElement, Math.max(b.body["scroll" + a], e["scroll" + a], b.body["offset" + a], e["offset" + a], e["client" + a])) : void 0 === d ? n.css(b, c, g) : n.style(b, c, d, g);
        }, b, f ? d : void 0, f, null);
      };
    });
  }), n.fn.extend({
    bind: function bind(a, b, c) {
      return this.on(a, null, b, c);
    },
    unbind: function unbind(a, b) {
      return this.off(a, null, b);
    },
    delegate: function delegate(a, b, c, d) {
      return this.on(b, a, c, d);
    },
    undelegate: function undelegate(a, b, c) {
      return 1 === arguments.length ? this.off(a, "**") : this.off(b, a || "**", c);
    },
    size: function size() {
      return this.length;
    }
  }), n.fn.andSelf = n.fn.addBack, "function" == typeof define && define.amd && define("jquery", [], function () {
    return n;
  });
  var Nb = a.jQuery,
      Ob = a.$;
  return n.noConflict = function (b) {
    return a.$ === n && (a.$ = Ob), b && a.jQuery === n && (a.jQuery = Nb), n;
  }, b || (a.jQuery = a.$ = n), n;
});
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! picturefill - v3.0.2 - 2016-02-12
 * https://scottjehl.github.io/picturefill/
 * Copyright (c) 2016 https://github.com/scottjehl/picturefill/blob/master/Authors.txt; Licensed MIT
 */
!function (a) {
  var b = navigator.userAgent;
  a.HTMLPictureElement && /ecko/.test(b) && b.match(/rv\:(\d+)/) && RegExp.$1 < 45 && addEventListener("resize", function () {
    var b,
        c = document.createElement("source"),
        d = function d(a) {
      var b,
          d,
          e = a.parentNode;
      "PICTURE" === e.nodeName.toUpperCase() ? (b = c.cloneNode(), e.insertBefore(b, e.firstElementChild), setTimeout(function () {
        e.removeChild(b);
      })) : (!a._pfLastSize || a.offsetWidth > a._pfLastSize) && (a._pfLastSize = a.offsetWidth, d = a.sizes, a.sizes += ",100vw", setTimeout(function () {
        a.sizes = d;
      }));
    },
        e = function e() {
      var a,
          b = document.querySelectorAll("picture > img, img[srcset][sizes]");

      for (a = 0; a < b.length; a++) {
        d(b[a]);
      }
    },
        f = function f() {
      clearTimeout(b), b = setTimeout(e, 99);
    },
        g = a.matchMedia && matchMedia("(orientation: landscape)"),
        h = function h() {
      f(), g && g.addListener && g.addListener(f);
    };

    return c.srcset = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==", /^[c|i]|d$/.test(document.readyState || "") ? h() : document.addEventListener("DOMContentLoaded", h), f;
  }());
}(window), function (a, b, c) {
  "use strict";

  function d(a) {
    return " " === a || "	" === a || "\n" === a || "\f" === a || "\r" === a;
  }

  function e(b, c) {
    var d = new a.Image();
    return d.onerror = function () {
      A[b] = !1, ba();
    }, d.onload = function () {
      A[b] = 1 === d.width, ba();
    }, d.src = c, "pending";
  }

  function f() {
    M = !1, P = a.devicePixelRatio, N = {}, O = {}, s.DPR = P || 1, Q.width = Math.max(a.innerWidth || 0, z.clientWidth), Q.height = Math.max(a.innerHeight || 0, z.clientHeight), Q.vw = Q.width / 100, Q.vh = Q.height / 100, r = [Q.height, Q.width, P].join("-"), Q.em = s.getEmValue(), Q.rem = Q.em;
  }

  function g(a, b, c, d) {
    var e, f, g, h;
    return "saveData" === B.algorithm ? a > 2.7 ? h = c + 1 : (f = b - c, e = Math.pow(a - .6, 1.5), g = f * e, d && (g += .1 * e), h = a + g) : h = c > 1 ? Math.sqrt(a * b) : a, h > c;
  }

  function h(a) {
    var b,
        c = s.getSet(a),
        d = !1;
    "pending" !== c && (d = r, c && (b = s.setRes(c), s.applySetCandidate(b, a))), a[s.ns].evaled = d;
  }

  function i(a, b) {
    return a.res - b.res;
  }

  function j(a, b, c) {
    var d;
    return !c && b && (c = a[s.ns].sets, c = c && c[c.length - 1]), d = k(b, c), d && (b = s.makeUrl(b), a[s.ns].curSrc = b, a[s.ns].curCan = d, d.res || aa(d, d.set.sizes)), d;
  }

  function k(a, b) {
    var c, d, e;
    if (a && b) for (e = s.parseSet(b), a = s.makeUrl(a), c = 0; c < e.length; c++) {
      if (a === s.makeUrl(e[c].url)) {
        d = e[c];
        break;
      }
    }
    return d;
  }

  function l(a, b) {
    var c,
        d,
        e,
        f,
        g = a.getElementsByTagName("source");

    for (c = 0, d = g.length; d > c; c++) {
      e = g[c], e[s.ns] = !0, f = e.getAttribute("srcset"), f && b.push({
        srcset: f,
        media: e.getAttribute("media"),
        type: e.getAttribute("type"),
        sizes: e.getAttribute("sizes")
      });
    }
  }

  function m(a, b) {
    function c(b) {
      var c,
          d = b.exec(a.substring(m));
      return d ? (c = d[0], m += c.length, c) : void 0;
    }

    function e() {
      var a,
          c,
          d,
          e,
          f,
          i,
          j,
          k,
          l,
          m = !1,
          o = {};

      for (e = 0; e < h.length; e++) {
        f = h[e], i = f[f.length - 1], j = f.substring(0, f.length - 1), k = parseInt(j, 10), l = parseFloat(j), X.test(j) && "w" === i ? ((a || c) && (m = !0), 0 === k ? m = !0 : a = k) : Y.test(j) && "x" === i ? ((a || c || d) && (m = !0), 0 > l ? m = !0 : c = l) : X.test(j) && "h" === i ? ((d || c) && (m = !0), 0 === k ? m = !0 : d = k) : m = !0;
      }

      m || (o.url = g, a && (o.w = a), c && (o.d = c), d && (o.h = d), d || c || a || (o.d = 1), 1 === o.d && (b.has1x = !0), o.set = b, n.push(o));
    }

    function f() {
      for (c(T), i = "", j = "in descriptor";;) {
        if (k = a.charAt(m), "in descriptor" === j) {
          if (d(k)) i && (h.push(i), i = "", j = "after descriptor");else {
            if ("," === k) return m += 1, i && h.push(i), void e();
            if ("(" === k) i += k, j = "in parens";else {
              if ("" === k) return i && h.push(i), void e();
              i += k;
            }
          }
        } else if ("in parens" === j) {
          if (")" === k) i += k, j = "in descriptor";else {
            if ("" === k) return h.push(i), void e();
            i += k;
          }
        } else if ("after descriptor" === j) if (d(k)) ;else {
          if ("" === k) return void e();
          j = "in descriptor", m -= 1;
        }
        m += 1;
      }
    }

    for (var g, h, i, j, k, l = a.length, m = 0, n = [];;) {
      if (c(U), m >= l) return n;
      g = c(V), h = [], "," === g.slice(-1) ? (g = g.replace(W, ""), e()) : f();
    }
  }

  function n(a) {
    function b(a) {
      function b() {
        f && (g.push(f), f = "");
      }

      function c() {
        g[0] && (h.push(g), g = []);
      }

      for (var e, f = "", g = [], h = [], i = 0, j = 0, k = !1;;) {
        if (e = a.charAt(j), "" === e) return b(), c(), h;

        if (k) {
          if ("*" === e && "/" === a[j + 1]) {
            k = !1, j += 2, b();
            continue;
          }

          j += 1;
        } else {
          if (d(e)) {
            if (a.charAt(j - 1) && d(a.charAt(j - 1)) || !f) {
              j += 1;
              continue;
            }

            if (0 === i) {
              b(), j += 1;
              continue;
            }

            e = " ";
          } else if ("(" === e) i += 1;else if (")" === e) i -= 1;else {
            if ("," === e) {
              b(), c(), j += 1;
              continue;
            }

            if ("/" === e && "*" === a.charAt(j + 1)) {
              k = !0, j += 2;
              continue;
            }
          }

          f += e, j += 1;
        }
      }
    }

    function c(a) {
      return k.test(a) && parseFloat(a) >= 0 ? !0 : l.test(a) ? !0 : "0" === a || "-0" === a || "+0" === a ? !0 : !1;
    }

    var e,
        f,
        g,
        h,
        i,
        j,
        k = /^(?:[+-]?[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?(?:ch|cm|em|ex|in|mm|pc|pt|px|rem|vh|vmin|vmax|vw)$/i,
        l = /^calc\((?:[0-9a-z \.\+\-\*\/\(\)]+)\)$/i;

    for (f = b(a), g = f.length, e = 0; g > e; e++) {
      if (h = f[e], i = h[h.length - 1], c(i)) {
        if (j = i, h.pop(), 0 === h.length) return j;
        if (h = h.join(" "), s.matchesMedia(h)) return j;
      }
    }

    return "100vw";
  }

  b.createElement("picture");

  var o,
      p,
      q,
      r,
      s = {},
      t = !1,
      u = function u() {},
      v = b.createElement("img"),
      w = v.getAttribute,
      x = v.setAttribute,
      y = v.removeAttribute,
      z = b.documentElement,
      A = {},
      B = {
    algorithm: ""
  },
      C = "data-pfsrc",
      D = C + "set",
      E = navigator.userAgent,
      F = /rident/.test(E) || /ecko/.test(E) && E.match(/rv\:(\d+)/) && RegExp.$1 > 35,
      G = "currentSrc",
      H = /\s+\+?\d+(e\d+)?w/,
      I = /(\([^)]+\))?\s*(.+)/,
      J = a.picturefillCFG,
      K = "position:absolute;left:0;visibility:hidden;display:block;padding:0;border:none;font-size:1em;width:1em;overflow:hidden;clip:rect(0px, 0px, 0px, 0px)",
      L = "font-size:100%!important;",
      M = !0,
      N = {},
      O = {},
      P = a.devicePixelRatio,
      Q = {
    px: 1,
    "in": 96
  },
      R = b.createElement("a"),
      S = !1,
      T = /^[ \t\n\r\u000c]+/,
      U = /^[, \t\n\r\u000c]+/,
      V = /^[^ \t\n\r\u000c]+/,
      W = /[,]+$/,
      X = /^\d+$/,
      Y = /^-?(?:[0-9]+|[0-9]*\.[0-9]+)(?:[eE][+-]?[0-9]+)?$/,
      Z = function Z(a, b, c, d) {
    a.addEventListener ? a.addEventListener(b, c, d || !1) : a.attachEvent && a.attachEvent("on" + b, c);
  },
      $ = function $(a) {
    var b = {};
    return function (c) {
      return c in b || (b[c] = a(c)), b[c];
    };
  },
      _ = function () {
    var a = /^([\d\.]+)(em|vw|px)$/,
        b = function b() {
      for (var a = arguments, b = 0, c = a[0]; ++b in a;) {
        c = c.replace(a[b], a[++b]);
      }

      return c;
    },
        c = $(function (a) {
      return "return " + b((a || "").toLowerCase(), /\band\b/g, "&&", /,/g, "||", /min-([a-z-\s]+):/g, "e.$1>=", /max-([a-z-\s]+):/g, "e.$1<=", /calc([^)]+)/g, "($1)", /(\d+[\.]*[\d]*)([a-z]+)/g, "($1 * e.$2)", /^(?!(e.[a-z]|[0-9\.&=|><\+\-\*\(\)\/])).*/gi, "") + ";";
    });

    return function (b, d) {
      var e;
      if (!(b in N)) if (N[b] = !1, d && (e = b.match(a))) N[b] = e[1] * Q[e[2]];else try {
        N[b] = new Function("e", c(b))(Q);
      } catch (f) {}
      return N[b];
    };
  }(),
      aa = function aa(a, b) {
    return a.w ? (a.cWidth = s.calcListLength(b || "100vw"), a.res = a.w / a.cWidth) : a.res = a.d, a;
  },
      ba = function ba(a) {
    if (t) {
      var c,
          d,
          e,
          f = a || {};

      if (f.elements && 1 === f.elements.nodeType && ("IMG" === f.elements.nodeName.toUpperCase() ? f.elements = [f.elements] : (f.context = f.elements, f.elements = null)), c = f.elements || s.qsa(f.context || b, f.reevaluate || f.reselect ? s.sel : s.selShort), e = c.length) {
        for (s.setupRun(f), S = !0, d = 0; e > d; d++) {
          s.fillImg(c[d], f);
        }

        s.teardownRun(f);
      }
    }
  };

  o = a.console && console.warn ? function (a) {
    console.warn(a);
  } : u, G in v || (G = "src"), A["image/jpeg"] = !0, A["image/gif"] = !0, A["image/png"] = !0, A["image/svg+xml"] = b.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image", "1.1"), s.ns = ("pf" + new Date().getTime()).substr(0, 9), s.supSrcset = "srcset" in v, s.supSizes = "sizes" in v, s.supPicture = !!a.HTMLPictureElement, s.supSrcset && s.supPicture && !s.supSizes && !function (a) {
    v.srcset = "data:,a", a.src = "data:,a", s.supSrcset = v.complete === a.complete, s.supPicture = s.supSrcset && s.supPicture;
  }(b.createElement("img")), s.supSrcset && !s.supSizes ? !function () {
    var a = "data:image/gif;base64,R0lGODlhAgABAPAAAP///wAAACH5BAAAAAAALAAAAAACAAEAAAICBAoAOw==",
        c = "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==",
        d = b.createElement("img"),
        e = function e() {
      var a = d.width;
      2 === a && (s.supSizes = !0), q = s.supSrcset && !s.supSizes, t = !0, setTimeout(ba);
    };

    d.onload = e, d.onerror = e, d.setAttribute("sizes", "9px"), d.srcset = c + " 1w," + a + " 9w", d.src = c;
  }() : t = !0, s.selShort = "picture>img,img[srcset]", s.sel = s.selShort, s.cfg = B, s.DPR = P || 1, s.u = Q, s.types = A, s.setSize = u, s.makeUrl = $(function (a) {
    return R.href = a, R.href;
  }), s.qsa = function (a, b) {
    return "querySelector" in a ? a.querySelectorAll(b) : [];
  }, s.matchesMedia = function () {
    return a.matchMedia && (matchMedia("(min-width: 0.1em)") || {}).matches ? s.matchesMedia = function (a) {
      return !a || matchMedia(a).matches;
    } : s.matchesMedia = s.mMQ, s.matchesMedia.apply(this, arguments);
  }, s.mMQ = function (a) {
    return a ? _(a) : !0;
  }, s.calcLength = function (a) {
    var b = _(a, !0) || !1;
    return 0 > b && (b = !1), b;
  }, s.supportsType = function (a) {
    return a ? A[a] : !0;
  }, s.parseSize = $(function (a) {
    var b = (a || "").match(I);
    return {
      media: b && b[1],
      length: b && b[2]
    };
  }), s.parseSet = function (a) {
    return a.cands || (a.cands = m(a.srcset, a)), a.cands;
  }, s.getEmValue = function () {
    var a;

    if (!p && (a = b.body)) {
      var c = b.createElement("div"),
          d = z.style.cssText,
          e = a.style.cssText;
      c.style.cssText = K, z.style.cssText = L, a.style.cssText = L, a.appendChild(c), p = c.offsetWidth, a.removeChild(c), p = parseFloat(p, 10), z.style.cssText = d, a.style.cssText = e;
    }

    return p || 16;
  }, s.calcListLength = function (a) {
    if (!(a in O) || B.uT) {
      var b = s.calcLength(n(a));
      O[a] = b ? b : Q.width;
    }

    return O[a];
  }, s.setRes = function (a) {
    var b;

    if (a) {
      b = s.parseSet(a);

      for (var c = 0, d = b.length; d > c; c++) {
        aa(b[c], a.sizes);
      }
    }

    return b;
  }, s.setRes.res = aa, s.applySetCandidate = function (a, b) {
    if (a.length) {
      var c,
          d,
          e,
          f,
          h,
          k,
          l,
          m,
          n,
          o = b[s.ns],
          p = s.DPR;
      if (k = o.curSrc || b[G], l = o.curCan || j(b, k, a[0].set), l && l.set === a[0].set && (n = F && !b.complete && l.res - .1 > p, n || (l.cached = !0, l.res >= p && (h = l))), !h) for (a.sort(i), f = a.length, h = a[f - 1], d = 0; f > d; d++) {
        if (c = a[d], c.res >= p) {
          e = d - 1, h = a[e] && (n || k !== s.makeUrl(c.url)) && g(a[e].res, c.res, p, a[e].cached) ? a[e] : c;
          break;
        }
      }
      h && (m = s.makeUrl(h.url), o.curSrc = m, o.curCan = h, m !== k && s.setSrc(b, h), s.setSize(b));
    }
  }, s.setSrc = function (a, b) {
    var c;
    a.src = b.url, "image/svg+xml" === b.set.type && (c = a.style.width, a.style.width = a.offsetWidth + 1 + "px", a.offsetWidth + 1 && (a.style.width = c));
  }, s.getSet = function (a) {
    var b,
        c,
        d,
        e = !1,
        f = a[s.ns].sets;

    for (b = 0; b < f.length && !e; b++) {
      if (c = f[b], c.srcset && s.matchesMedia(c.media) && (d = s.supportsType(c.type))) {
        "pending" === d && (c = d), e = c;
        break;
      }
    }

    return e;
  }, s.parseSets = function (a, b, d) {
    var e,
        f,
        g,
        h,
        i = b && "PICTURE" === b.nodeName.toUpperCase(),
        j = a[s.ns];
    (j.src === c || d.src) && (j.src = w.call(a, "src"), j.src ? x.call(a, C, j.src) : y.call(a, C)), (j.srcset === c || d.srcset || !s.supSrcset || a.srcset) && (e = w.call(a, "srcset"), j.srcset = e, h = !0), j.sets = [], i && (j.pic = !0, l(b, j.sets)), j.srcset ? (f = {
      srcset: j.srcset,
      sizes: w.call(a, "sizes")
    }, j.sets.push(f), g = (q || j.src) && H.test(j.srcset || ""), g || !j.src || k(j.src, f) || f.has1x || (f.srcset += ", " + j.src, f.cands.push({
      url: j.src,
      d: 1,
      set: f
    }))) : j.src && j.sets.push({
      srcset: j.src,
      sizes: null
    }), j.curCan = null, j.curSrc = c, j.supported = !(i || f && !s.supSrcset || g && !s.supSizes), h && s.supSrcset && !j.supported && (e ? (x.call(a, D, e), a.srcset = "") : y.call(a, D)), j.supported && !j.srcset && (!j.src && a.src || a.src !== s.makeUrl(j.src)) && (null === j.src ? a.removeAttribute("src") : a.src = j.src), j.parsed = !0;
  }, s.fillImg = function (a, b) {
    var c,
        d = b.reselect || b.reevaluate;
    a[s.ns] || (a[s.ns] = {}), c = a[s.ns], (d || c.evaled !== r) && ((!c.parsed || b.reevaluate) && s.parseSets(a, a.parentNode, b), c.supported ? c.evaled = r : h(a));
  }, s.setupRun = function () {
    (!S || M || P !== a.devicePixelRatio) && f();
  }, s.supPicture ? (ba = u, s.fillImg = u) : !function () {
    var c,
        d = a.attachEvent ? /d$|^c/ : /d$|^c|^i/,
        e = function e() {
      var a = b.readyState || "";
      f = setTimeout(e, "loading" === a ? 200 : 999), b.body && (s.fillImgs(), c = c || d.test(a), c && clearTimeout(f));
    },
        f = setTimeout(e, b.body ? 9 : 99),
        g = function g(a, b) {
      var c,
          d,
          e = function e() {
        var f = new Date() - d;
        b > f ? c = setTimeout(e, b - f) : (c = null, a());
      };

      return function () {
        d = new Date(), c || (c = setTimeout(e, b));
      };
    },
        h = z.clientHeight,
        i = function i() {
      M = Math.max(a.innerWidth || 0, z.clientWidth) !== Q.width || z.clientHeight !== h, h = z.clientHeight, M && s.fillImgs();
    };

    Z(a, "resize", g(i, 99)), Z(b, "readystatechange", e);
  }(), s.picturefill = ba, s.fillImgs = ba, s.teardownRun = u, ba._ = s, a.picturefillCFG = {
    pf: s,
    push: function push(a) {
      var b = a.shift();
      "function" == typeof s[b] ? s[b].apply(s, a) : (B[b] = a[0], S && s.fillImgs({
        reselect: !0
      }));
    }
  };

  for (; J && J.length;) {
    a.picturefillCFG.push(J.shift());
  }

  a.picturefill = ba, "object" == (typeof module === "undefined" ? "undefined" : _typeof(module)) && "object" == _typeof(module.exports) ? module.exports = ba : "function" == typeof define && define.amd && define("picturefill", function () {
    return ba;
  }), s.supPicture || (A["image/webp"] = e("image/webp", "data:image/webp;base64,UklGRkoAAABXRUJQVlA4WAoAAAAQAAAAAAAAAAAAQUxQSAwAAAABBxAR/Q9ERP8DAABWUDggGAAAADABAJ0BKgEAAQADADQlpAADcAD++/1QAA=="));
}(window, document);
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (e, t) {
  "function" == typeof define && define.amd ? define(t) : "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) ? module.exports = t() : e.ResizeSensor = t();
}("undefined" != typeof window ? window : void 0, function () {
  if ("undefined" == typeof window) return null;

  var m = window.requestAnimationFrame || window.mozRequestAnimationFrame || window.webkitRequestAnimationFrame || function (e) {
    return window.setTimeout(e, 20);
  };

  function n(e, t) {
    var i = Object.prototype.toString.call(e),
        n = "[object Array]" === i || "[object NodeList]" === i || "[object HTMLCollection]" === i || "[object Object]" === i || "undefined" != typeof jQuery && e instanceof jQuery || "undefined" != typeof Elements && e instanceof Elements,
        o = 0,
        s = e.length;
    if (n) for (; o < s; o++) {
      t(e[o]);
    } else t(e);
  }

  var o = function o(t, i) {
    function y() {
      var i,
          n,
          o = [];
      this.add = function (e) {
        o.push(e);
      }, this.call = function () {
        for (i = 0, n = o.length; i < n; i++) {
          o[i].call();
        }
      }, this.remove = function (e) {
        var t = [];

        for (i = 0, n = o.length; i < n; i++) {
          o[i] !== e && t.push(o[i]);
        }

        o = t;
      }, this.length = function () {
        return o.length;
      };
    }

    n(t, function (e) {
      !function (e, t) {
        if (e) if (e.resizedAttached) e.resizedAttached.add(t);else {
          e.resizedAttached = new y(), e.resizedAttached.add(t), e.resizeSensor = document.createElement("div"), e.resizeSensor.className = "resize-sensor";
          var i = "position: absolute; left: 0; top: 0; right: 0; bottom: 0; overflow: hidden; z-index: -1; visibility: hidden;",
              n = "position: absolute; left: 0; top: 0; transition: 0s;";
          e.resizeSensor.style.cssText = i, e.resizeSensor.innerHTML = '<div class="resize-sensor-expand" style="' + i + '"><div style="' + n + '"></div></div><div class="resize-sensor-shrink" style="' + i + '"><div style="' + n + ' width: 200%; height: 200%"></div></div>', e.appendChild(e.resizeSensor), e.resizeSensor.offsetParent !== e && (e.style.position = "relative");

          var o,
              s,
              r,
              d,
              c = e.resizeSensor.childNodes[0],
              l = c.childNodes[0],
              f = e.resizeSensor.childNodes[1],
              a = e.offsetWidth,
              h = e.offsetHeight,
              u = function u() {
            l.style.width = "100000px", l.style.height = "100000px", c.scrollLeft = 1e5, c.scrollTop = 1e5, f.scrollLeft = 1e5, f.scrollTop = 1e5;
          };

          u();

          var z = function z() {
            s = 0, o && (a = r, h = d, e.resizedAttached && e.resizedAttached.call());
          },
              v = function v() {
            r = e.offsetWidth, d = e.offsetHeight, (o = r != a || d != h) && !s && (s = m(z)), u();
          },
              p = function p(e, t, i) {
            e.attachEvent ? e.attachEvent("on" + t, i) : e.addEventListener(t, i);
          };

          p(c, "scroll", v), p(f, "scroll", v);
        }
      }(e, i);
    }), this.detach = function (e) {
      o.detach(t, e);
    };
  };

  return o.detach = function (e, t) {
    n(e, function (e) {
      e && (e.resizedAttached && "function" == typeof t && (e.resizedAttached.remove(t), e.resizedAttached.length()) || e.resizeSensor && (e.contains(e.resizeSensor) && e.removeChild(e.resizeSensor), delete e.resizeSensor, delete e.resizedAttached));
    });
  }, o;
});
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*
     _ _      _       _
 ___| (_) ___| | __  (_)___
/ __| | |/ __| |/ /  | / __|
\__ \ | | (__|   < _ | \__ \
|___/_|_|\___|_|\_(_)/ |___/
                   |__/

 Version: 1.9.0
  Author: Ken Wheeler
 Website: http://kenwheeler.github.io
    Docs: http://kenwheeler.github.io/slick
    Repo: http://github.com/kenwheeler/slick
  Issues: http://github.com/kenwheeler/slick/issues

 */
(function (i) {
  "use strict";

  "function" == typeof define && define.amd ? define(["jquery"], i) : "undefined" != typeof exports ? module.exports = i(require("jquery")) : i(jQuery);
})(function (i) {
  "use strict";

  var e = window.Slick || {};
  e = function () {
    function e(e, o) {
      var s,
          n = this;
      n.defaults = {
        accessibility: !0,
        adaptiveHeight: !1,
        appendArrows: i(e),
        appendDots: i(e),
        arrows: !0,
        asNavFor: null,
        prevArrow: '<button class="slick-prev" aria-label="Previous" type="button">Previous</button>',
        nextArrow: '<button class="slick-next" aria-label="Next" type="button">Next</button>',
        autoplay: !1,
        autoplaySpeed: 3e3,
        centerMode: !1,
        centerPadding: "50px",
        cssEase: "ease",
        customPaging: function customPaging(e, t) {
          return i('<button type="button" />').text(t + 1);
        },
        dots: !1,
        dotsClass: "slick-dots",
        draggable: !0,
        easing: "linear",
        edgeFriction: .35,
        fade: !1,
        focusOnSelect: !1,
        focusOnChange: !1,
        infinite: !0,
        initialSlide: 0,
        lazyLoad: "ondemand",
        mobileFirst: !1,
        pauseOnHover: !0,
        pauseOnFocus: !0,
        pauseOnDotsHover: !1,
        respondTo: "window",
        responsive: null,
        rows: 1,
        rtl: !1,
        slide: "",
        slidesPerRow: 1,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 500,
        swipe: !0,
        swipeToSlide: !1,
        touchMove: !0,
        touchThreshold: 5,
        useCSS: !0,
        useTransform: !0,
        variableWidth: !1,
        vertical: !1,
        verticalSwiping: !1,
        waitForAnimate: !0,
        zIndex: 1e3
      }, n.initials = {
        animating: !1,
        dragging: !1,
        autoPlayTimer: null,
        currentDirection: 0,
        currentLeft: null,
        currentSlide: 0,
        direction: 1,
        $dots: null,
        listWidth: null,
        listHeight: null,
        loadIndex: 0,
        $nextArrow: null,
        $prevArrow: null,
        scrolling: !1,
        slideCount: null,
        slideWidth: null,
        $slideTrack: null,
        $slides: null,
        sliding: !1,
        slideOffset: 0,
        swipeLeft: null,
        swiping: !1,
        $list: null,
        touchObject: {},
        transformsEnabled: !1,
        unslicked: !1
      }, i.extend(n, n.initials), n.activeBreakpoint = null, n.animType = null, n.animProp = null, n.breakpoints = [], n.breakpointSettings = [], n.cssTransitions = !1, n.focussed = !1, n.interrupted = !1, n.hidden = "hidden", n.paused = !0, n.positionProp = null, n.respondTo = null, n.rowCount = 1, n.shouldClick = !0, n.$slider = i(e), n.$slidesCache = null, n.transformType = null, n.transitionType = null, n.visibilityChange = "visibilitychange", n.windowWidth = 0, n.windowTimer = null, s = i(e).data("slick") || {}, n.options = i.extend({}, n.defaults, o, s), n.currentSlide = n.options.initialSlide, n.originalSettings = n.options, "undefined" != typeof document.mozHidden ? (n.hidden = "mozHidden", n.visibilityChange = "mozvisibilitychange") : "undefined" != typeof document.webkitHidden && (n.hidden = "webkitHidden", n.visibilityChange = "webkitvisibilitychange"), n.autoPlay = i.proxy(n.autoPlay, n), n.autoPlayClear = i.proxy(n.autoPlayClear, n), n.autoPlayIterator = i.proxy(n.autoPlayIterator, n), n.changeSlide = i.proxy(n.changeSlide, n), n.clickHandler = i.proxy(n.clickHandler, n), n.selectHandler = i.proxy(n.selectHandler, n), n.setPosition = i.proxy(n.setPosition, n), n.swipeHandler = i.proxy(n.swipeHandler, n), n.dragHandler = i.proxy(n.dragHandler, n), n.keyHandler = i.proxy(n.keyHandler, n), n.instanceUid = t++, n.htmlExpr = /^(?:\s*(<[\w\W]+>)[^>]*)$/, n.registerBreakpoints(), n.init(!0);
    }

    var t = 0;
    return e;
  }(), e.prototype.activateADA = function () {
    var i = this;
    i.$slideTrack.find(".slick-active").attr({
      "aria-hidden": "false"
    }).find("a, input, button, select").attr({
      tabindex: "0"
    });
  }, e.prototype.addSlide = e.prototype.slickAdd = function (e, t, o) {
    var s = this;
    if ("boolean" == typeof t) o = t, t = null;else if (t < 0 || t >= s.slideCount) return !1;
    s.unload(), "number" == typeof t ? 0 === t && 0 === s.$slides.length ? i(e).appendTo(s.$slideTrack) : o ? i(e).insertBefore(s.$slides.eq(t)) : i(e).insertAfter(s.$slides.eq(t)) : o === !0 ? i(e).prependTo(s.$slideTrack) : i(e).appendTo(s.$slideTrack), s.$slides = s.$slideTrack.children(this.options.slide), s.$slideTrack.children(this.options.slide).detach(), s.$slideTrack.append(s.$slides), s.$slides.each(function (e, t) {
      i(t).attr("data-slick-index", e);
    }), s.$slidesCache = s.$slides, s.reinit();
  }, e.prototype.animateHeight = function () {
    var i = this;

    if (1 === i.options.slidesToShow && i.options.adaptiveHeight === !0 && i.options.vertical === !1) {
      var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
      i.$list.animate({
        height: e
      }, i.options.speed);
    }
  }, e.prototype.animateSlide = function (e, t) {
    var o = {},
        s = this;
    s.animateHeight(), s.options.rtl === !0 && s.options.vertical === !1 && (e = -e), s.transformsEnabled === !1 ? s.options.vertical === !1 ? s.$slideTrack.animate({
      left: e
    }, s.options.speed, s.options.easing, t) : s.$slideTrack.animate({
      top: e
    }, s.options.speed, s.options.easing, t) : s.cssTransitions === !1 ? (s.options.rtl === !0 && (s.currentLeft = -s.currentLeft), i({
      animStart: s.currentLeft
    }).animate({
      animStart: e
    }, {
      duration: s.options.speed,
      easing: s.options.easing,
      step: function step(i) {
        i = Math.ceil(i), s.options.vertical === !1 ? (o[s.animType] = "translate(" + i + "px, 0px)", s.$slideTrack.css(o)) : (o[s.animType] = "translate(0px," + i + "px)", s.$slideTrack.css(o));
      },
      complete: function complete() {
        t && t.call();
      }
    })) : (s.applyTransition(), e = Math.ceil(e), s.options.vertical === !1 ? o[s.animType] = "translate3d(" + e + "px, 0px, 0px)" : o[s.animType] = "translate3d(0px," + e + "px, 0px)", s.$slideTrack.css(o), t && setTimeout(function () {
      s.disableTransition(), t.call();
    }, s.options.speed));
  }, e.prototype.getNavTarget = function () {
    var e = this,
        t = e.options.asNavFor;
    return t && null !== t && (t = i(t).not(e.$slider)), t;
  }, e.prototype.asNavFor = function (e) {
    var t = this,
        o = t.getNavTarget();
    null !== o && "object" == _typeof(o) && o.each(function () {
      var t = i(this).slick("getSlick");
      t.unslicked || t.slideHandler(e, !0);
    });
  }, e.prototype.applyTransition = function (i) {
    var e = this,
        t = {};
    e.options.fade === !1 ? t[e.transitionType] = e.transformType + " " + e.options.speed + "ms " + e.options.cssEase : t[e.transitionType] = "opacity " + e.options.speed + "ms " + e.options.cssEase, e.options.fade === !1 ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t);
  }, e.prototype.autoPlay = function () {
    var i = this;
    i.autoPlayClear(), i.slideCount > i.options.slidesToShow && (i.autoPlayTimer = setInterval(i.autoPlayIterator, i.options.autoplaySpeed));
  }, e.prototype.autoPlayClear = function () {
    var i = this;
    i.autoPlayTimer && clearInterval(i.autoPlayTimer);
  }, e.prototype.autoPlayIterator = function () {
    var i = this,
        e = i.currentSlide + i.options.slidesToScroll;
    i.paused || i.interrupted || i.focussed || (i.options.infinite === !1 && (1 === i.direction && i.currentSlide + 1 === i.slideCount - 1 ? i.direction = 0 : 0 === i.direction && (e = i.currentSlide - i.options.slidesToScroll, i.currentSlide - 1 === 0 && (i.direction = 1))), i.slideHandler(e));
  }, e.prototype.buildArrows = function () {
    var e = this;
    e.options.arrows === !0 && (e.$prevArrow = i(e.options.prevArrow).addClass("slick-arrow"), e.$nextArrow = i(e.options.nextArrow).addClass("slick-arrow"), e.slideCount > e.options.slidesToShow ? (e.$prevArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.$nextArrow.removeClass("slick-hidden").removeAttr("aria-hidden tabindex"), e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.prependTo(e.options.appendArrows), e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.appendTo(e.options.appendArrows), e.options.infinite !== !0 && e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true")) : e.$prevArrow.add(e.$nextArrow).addClass("slick-hidden").attr({
      "aria-disabled": "true",
      tabindex: "-1"
    }));
  }, e.prototype.buildDots = function () {
    var e,
        t,
        o = this;

    if (o.options.dots === !0 && o.slideCount > o.options.slidesToShow) {
      for (o.$slider.addClass("slick-dotted"), t = i("<ul />").addClass(o.options.dotsClass), e = 0; e <= o.getDotCount(); e += 1) {
        t.append(i("<li />").append(o.options.customPaging.call(this, o, e)));
      }

      o.$dots = t.appendTo(o.options.appendDots), o.$dots.find("li").first().addClass("slick-active");
    }
  }, e.prototype.buildOut = function () {
    var e = this;
    e.$slides = e.$slider.children(e.options.slide + ":not(.slick-cloned)").addClass("slick-slide"), e.slideCount = e.$slides.length, e.$slides.each(function (e, t) {
      i(t).attr("data-slick-index", e).data("originalStyling", i(t).attr("style") || "");
    }), e.$slider.addClass("slick-slider"), e.$slideTrack = 0 === e.slideCount ? i('<div class="slick-track"/>').appendTo(e.$slider) : e.$slides.wrapAll('<div class="slick-track"/>').parent(), e.$list = e.$slideTrack.wrap('<div class="slick-list"/>').parent(), e.$slideTrack.css("opacity", 0), e.options.centerMode !== !0 && e.options.swipeToSlide !== !0 || (e.options.slidesToScroll = 1), i("img[data-lazy]", e.$slider).not("[src]").addClass("slick-loading"), e.setupInfinite(), e.buildArrows(), e.buildDots(), e.updateDots(), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.options.draggable === !0 && e.$list.addClass("draggable");
  }, e.prototype.buildRows = function () {
    var i,
        e,
        t,
        o,
        s,
        n,
        r,
        l = this;

    if (o = document.createDocumentFragment(), n = l.$slider.children(), l.options.rows > 0) {
      for (r = l.options.slidesPerRow * l.options.rows, s = Math.ceil(n.length / r), i = 0; i < s; i++) {
        var d = document.createElement("div");

        for (e = 0; e < l.options.rows; e++) {
          var a = document.createElement("div");

          for (t = 0; t < l.options.slidesPerRow; t++) {
            var c = i * r + (e * l.options.slidesPerRow + t);
            n.get(c) && a.appendChild(n.get(c));
          }

          d.appendChild(a);
        }

        o.appendChild(d);
      }

      l.$slider.empty().append(o), l.$slider.children().children().children().css({
        width: 100 / l.options.slidesPerRow + "%",
        display: "inline-block"
      });
    }
  }, e.prototype.checkResponsive = function (e, t) {
    var o,
        s,
        n,
        r = this,
        l = !1,
        d = r.$slider.width(),
        a = window.innerWidth || i(window).width();

    if ("window" === r.respondTo ? n = a : "slider" === r.respondTo ? n = d : "min" === r.respondTo && (n = Math.min(a, d)), r.options.responsive && r.options.responsive.length && null !== r.options.responsive) {
      s = null;

      for (o in r.breakpoints) {
        r.breakpoints.hasOwnProperty(o) && (r.originalSettings.mobileFirst === !1 ? n < r.breakpoints[o] && (s = r.breakpoints[o]) : n > r.breakpoints[o] && (s = r.breakpoints[o]));
      }

      null !== s ? null !== r.activeBreakpoint ? (s !== r.activeBreakpoint || t) && (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : (r.activeBreakpoint = s, "unslick" === r.breakpointSettings[s] ? r.unslick(s) : (r.options = i.extend({}, r.originalSettings, r.breakpointSettings[s]), e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e)), l = s) : null !== r.activeBreakpoint && (r.activeBreakpoint = null, r.options = r.originalSettings, e === !0 && (r.currentSlide = r.options.initialSlide), r.refresh(e), l = s), e || l === !1 || r.$slider.trigger("breakpoint", [r, l]);
    }
  }, e.prototype.changeSlide = function (e, t) {
    var o,
        s,
        n,
        r = this,
        l = i(e.currentTarget);

    switch (l.is("a") && e.preventDefault(), l.is("li") || (l = l.closest("li")), n = r.slideCount % r.options.slidesToScroll !== 0, o = n ? 0 : (r.slideCount - r.currentSlide) % r.options.slidesToScroll, e.data.message) {
      case "previous":
        s = 0 === o ? r.options.slidesToScroll : r.options.slidesToShow - o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide - s, !1, t);
        break;

      case "next":
        s = 0 === o ? r.options.slidesToScroll : o, r.slideCount > r.options.slidesToShow && r.slideHandler(r.currentSlide + s, !1, t);
        break;

      case "index":
        var d = 0 === e.data.index ? 0 : e.data.index || l.index() * r.options.slidesToScroll;
        r.slideHandler(r.checkNavigable(d), !1, t), l.children().trigger("focus");
        break;

      default:
        return;
    }
  }, e.prototype.checkNavigable = function (i) {
    var e,
        t,
        o = this;
    if (e = o.getNavigableIndexes(), t = 0, i > e[e.length - 1]) i = e[e.length - 1];else for (var s in e) {
      if (i < e[s]) {
        i = t;
        break;
      }

      t = e[s];
    }
    return i;
  }, e.prototype.cleanUpEvents = function () {
    var e = this;
    e.options.dots && null !== e.$dots && (i("li", e.$dots).off("click.slick", e.changeSlide).off("mouseenter.slick", i.proxy(e.interrupt, e, !0)).off("mouseleave.slick", i.proxy(e.interrupt, e, !1)), e.options.accessibility === !0 && e.$dots.off("keydown.slick", e.keyHandler)), e.$slider.off("focus.slick blur.slick"), e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && (e.$prevArrow && e.$prevArrow.off("click.slick", e.changeSlide), e.$nextArrow && e.$nextArrow.off("click.slick", e.changeSlide), e.options.accessibility === !0 && (e.$prevArrow && e.$prevArrow.off("keydown.slick", e.keyHandler), e.$nextArrow && e.$nextArrow.off("keydown.slick", e.keyHandler))), e.$list.off("touchstart.slick mousedown.slick", e.swipeHandler), e.$list.off("touchmove.slick mousemove.slick", e.swipeHandler), e.$list.off("touchend.slick mouseup.slick", e.swipeHandler), e.$list.off("touchcancel.slick mouseleave.slick", e.swipeHandler), e.$list.off("click.slick", e.clickHandler), i(document).off(e.visibilityChange, e.visibility), e.cleanUpSlideEvents(), e.options.accessibility === !0 && e.$list.off("keydown.slick", e.keyHandler), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().off("click.slick", e.selectHandler), i(window).off("orientationchange.slick.slick-" + e.instanceUid, e.orientationChange), i(window).off("resize.slick.slick-" + e.instanceUid, e.resize), i("[draggable!=true]", e.$slideTrack).off("dragstart", e.preventDefault), i(window).off("load.slick.slick-" + e.instanceUid, e.setPosition);
  }, e.prototype.cleanUpSlideEvents = function () {
    var e = this;
    e.$list.off("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.off("mouseleave.slick", i.proxy(e.interrupt, e, !1));
  }, e.prototype.cleanUpRows = function () {
    var i,
        e = this;
    e.options.rows > 0 && (i = e.$slides.children().children(), i.removeAttr("style"), e.$slider.empty().append(i));
  }, e.prototype.clickHandler = function (i) {
    var e = this;
    e.shouldClick === !1 && (i.stopImmediatePropagation(), i.stopPropagation(), i.preventDefault());
  }, e.prototype.destroy = function (e) {
    var t = this;
    t.autoPlayClear(), t.touchObject = {}, t.cleanUpEvents(), i(".slick-cloned", t.$slider).detach(), t.$dots && t.$dots.remove(), t.$prevArrow && t.$prevArrow.length && (t.$prevArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.prevArrow) && t.$prevArrow.remove()), t.$nextArrow && t.$nextArrow.length && (t.$nextArrow.removeClass("slick-disabled slick-arrow slick-hidden").removeAttr("aria-hidden aria-disabled tabindex").css("display", ""), t.htmlExpr.test(t.options.nextArrow) && t.$nextArrow.remove()), t.$slides && (t.$slides.removeClass("slick-slide slick-active slick-center slick-visible slick-current").removeAttr("aria-hidden").removeAttr("data-slick-index").each(function () {
      i(this).attr("style", i(this).data("originalStyling"));
    }), t.$slideTrack.children(this.options.slide).detach(), t.$slideTrack.detach(), t.$list.detach(), t.$slider.append(t.$slides)), t.cleanUpRows(), t.$slider.removeClass("slick-slider"), t.$slider.removeClass("slick-initialized"), t.$slider.removeClass("slick-dotted"), t.unslicked = !0, e || t.$slider.trigger("destroy", [t]);
  }, e.prototype.disableTransition = function (i) {
    var e = this,
        t = {};
    t[e.transitionType] = "", e.options.fade === !1 ? e.$slideTrack.css(t) : e.$slides.eq(i).css(t);
  }, e.prototype.fadeSlide = function (i, e) {
    var t = this;
    t.cssTransitions === !1 ? (t.$slides.eq(i).css({
      zIndex: t.options.zIndex
    }), t.$slides.eq(i).animate({
      opacity: 1
    }, t.options.speed, t.options.easing, e)) : (t.applyTransition(i), t.$slides.eq(i).css({
      opacity: 1,
      zIndex: t.options.zIndex
    }), e && setTimeout(function () {
      t.disableTransition(i), e.call();
    }, t.options.speed));
  }, e.prototype.fadeSlideOut = function (i) {
    var e = this;
    e.cssTransitions === !1 ? e.$slides.eq(i).animate({
      opacity: 0,
      zIndex: e.options.zIndex - 2
    }, e.options.speed, e.options.easing) : (e.applyTransition(i), e.$slides.eq(i).css({
      opacity: 0,
      zIndex: e.options.zIndex - 2
    }));
  }, e.prototype.filterSlides = e.prototype.slickFilter = function (i) {
    var e = this;
    null !== i && (e.$slidesCache = e.$slides, e.unload(), e.$slideTrack.children(this.options.slide).detach(), e.$slidesCache.filter(i).appendTo(e.$slideTrack), e.reinit());
  }, e.prototype.focusHandler = function () {
    var e = this;
    e.$slider.off("focus.slick blur.slick").on("focus.slick", "*", function (t) {
      var o = i(this);
      setTimeout(function () {
        e.options.pauseOnFocus && o.is(":focus") && (e.focussed = !0, e.autoPlay());
      }, 0);
    }).on("blur.slick", "*", function (t) {
      i(this);
      e.options.pauseOnFocus && (e.focussed = !1, e.autoPlay());
    });
  }, e.prototype.getCurrent = e.prototype.slickCurrentSlide = function () {
    var i = this;
    return i.currentSlide;
  }, e.prototype.getDotCount = function () {
    var i = this,
        e = 0,
        t = 0,
        o = 0;
    if (i.options.infinite === !0) {
      if (i.slideCount <= i.options.slidesToShow) ++o;else for (; e < i.slideCount;) {
        ++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
      }
    } else if (i.options.centerMode === !0) o = i.slideCount;else if (i.options.asNavFor) for (; e < i.slideCount;) {
      ++o, e = t + i.options.slidesToScroll, t += i.options.slidesToScroll <= i.options.slidesToShow ? i.options.slidesToScroll : i.options.slidesToShow;
    } else o = 1 + Math.ceil((i.slideCount - i.options.slidesToShow) / i.options.slidesToScroll);
    return o - 1;
  }, e.prototype.getLeft = function (i) {
    var e,
        t,
        o,
        s,
        n = this,
        r = 0;
    return n.slideOffset = 0, t = n.$slides.first().outerHeight(!0), n.options.infinite === !0 ? (n.slideCount > n.options.slidesToShow && (n.slideOffset = n.slideWidth * n.options.slidesToShow * -1, s = -1, n.options.vertical === !0 && n.options.centerMode === !0 && (2 === n.options.slidesToShow ? s = -1.5 : 1 === n.options.slidesToShow && (s = -2)), r = t * n.options.slidesToShow * s), n.slideCount % n.options.slidesToScroll !== 0 && i + n.options.slidesToScroll > n.slideCount && n.slideCount > n.options.slidesToShow && (i > n.slideCount ? (n.slideOffset = (n.options.slidesToShow - (i - n.slideCount)) * n.slideWidth * -1, r = (n.options.slidesToShow - (i - n.slideCount)) * t * -1) : (n.slideOffset = n.slideCount % n.options.slidesToScroll * n.slideWidth * -1, r = n.slideCount % n.options.slidesToScroll * t * -1))) : i + n.options.slidesToShow > n.slideCount && (n.slideOffset = (i + n.options.slidesToShow - n.slideCount) * n.slideWidth, r = (i + n.options.slidesToShow - n.slideCount) * t), n.slideCount <= n.options.slidesToShow && (n.slideOffset = 0, r = 0), n.options.centerMode === !0 && n.slideCount <= n.options.slidesToShow ? n.slideOffset = n.slideWidth * Math.floor(n.options.slidesToShow) / 2 - n.slideWidth * n.slideCount / 2 : n.options.centerMode === !0 && n.options.infinite === !0 ? n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2) - n.slideWidth : n.options.centerMode === !0 && (n.slideOffset = 0, n.slideOffset += n.slideWidth * Math.floor(n.options.slidesToShow / 2)), e = n.options.vertical === !1 ? i * n.slideWidth * -1 + n.slideOffset : i * t * -1 + r, n.options.variableWidth === !0 && (o = n.slideCount <= n.options.slidesToShow || n.options.infinite === !1 ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow), e = n.options.rtl === !0 ? o[0] ? (n.$slideTrack.width() - o[0].offsetLeft - o.width()) * -1 : 0 : o[0] ? o[0].offsetLeft * -1 : 0, n.options.centerMode === !0 && (o = n.slideCount <= n.options.slidesToShow || n.options.infinite === !1 ? n.$slideTrack.children(".slick-slide").eq(i) : n.$slideTrack.children(".slick-slide").eq(i + n.options.slidesToShow + 1), e = n.options.rtl === !0 ? o[0] ? (n.$slideTrack.width() - o[0].offsetLeft - o.width()) * -1 : 0 : o[0] ? o[0].offsetLeft * -1 : 0, e += (n.$list.width() - o.outerWidth()) / 2)), e;
  }, e.prototype.getOption = e.prototype.slickGetOption = function (i) {
    var e = this;
    return e.options[i];
  }, e.prototype.getNavigableIndexes = function () {
    var i,
        e = this,
        t = 0,
        o = 0,
        s = [];

    for (e.options.infinite === !1 ? i = e.slideCount : (t = e.options.slidesToScroll * -1, o = e.options.slidesToScroll * -1, i = 2 * e.slideCount); t < i;) {
      s.push(t), t = o + e.options.slidesToScroll, o += e.options.slidesToScroll <= e.options.slidesToShow ? e.options.slidesToScroll : e.options.slidesToShow;
    }

    return s;
  }, e.prototype.getSlick = function () {
    return this;
  }, e.prototype.getSlideCount = function () {
    var e,
        t,
        o,
        s,
        n = this;
    return s = n.options.centerMode === !0 ? Math.floor(n.$list.width() / 2) : 0, o = n.swipeLeft * -1 + s, n.options.swipeToSlide === !0 ? (n.$slideTrack.find(".slick-slide").each(function (e, s) {
      var r, l, d;
      if (r = i(s).outerWidth(), l = s.offsetLeft, n.options.centerMode !== !0 && (l += r / 2), d = l + r, o < d) return t = s, !1;
    }), e = Math.abs(i(t).attr("data-slick-index") - n.currentSlide) || 1) : n.options.slidesToScroll;
  }, e.prototype.goTo = e.prototype.slickGoTo = function (i, e) {
    var t = this;
    t.changeSlide({
      data: {
        message: "index",
        index: parseInt(i)
      }
    }, e);
  }, e.prototype.init = function (e) {
    var t = this;
    i(t.$slider).hasClass("slick-initialized") || (i(t.$slider).addClass("slick-initialized"), t.buildRows(), t.buildOut(), t.setProps(), t.startLoad(), t.loadSlider(), t.initializeEvents(), t.updateArrows(), t.updateDots(), t.checkResponsive(!0), t.focusHandler()), e && t.$slider.trigger("init", [t]), t.options.accessibility === !0 && t.initADA(), t.options.autoplay && (t.paused = !1, t.autoPlay());
  }, e.prototype.initADA = function () {
    var e = this,
        t = Math.ceil(e.slideCount / e.options.slidesToShow),
        o = e.getNavigableIndexes().filter(function (i) {
      return i >= 0 && i < e.slideCount;
    });
    e.$slides.add(e.$slideTrack.find(".slick-cloned")).attr({
      "aria-hidden": "true",
      tabindex: "-1"
    }).find("a, input, button, select").attr({
      tabindex: "-1"
    }), null !== e.$dots && (e.$slides.not(e.$slideTrack.find(".slick-cloned")).each(function (t) {
      var s = o.indexOf(t);

      if (i(this).attr({
        role: "tabpanel",
        id: "slick-slide" + e.instanceUid + t,
        tabindex: -1
      }), s !== -1) {
        var n = "slick-slide-control" + e.instanceUid + s;
        i("#" + n).length && i(this).attr({
          "aria-describedby": n
        });
      }
    }), e.$dots.attr("role", "tablist").find("li").each(function (s) {
      var n = o[s];
      i(this).attr({
        role: "presentation"
      }), i(this).find("button").first().attr({
        role: "tab",
        id: "slick-slide-control" + e.instanceUid + s,
        "aria-controls": "slick-slide" + e.instanceUid + n,
        "aria-label": s + 1 + " of " + t,
        "aria-selected": null,
        tabindex: "-1"
      });
    }).eq(e.currentSlide).find("button").attr({
      "aria-selected": "true",
      tabindex: "0"
    }).end());

    for (var s = e.currentSlide, n = s + e.options.slidesToShow; s < n; s++) {
      e.options.focusOnChange ? e.$slides.eq(s).attr({
        tabindex: "0"
      }) : e.$slides.eq(s).removeAttr("tabindex");
    }

    e.activateADA();
  }, e.prototype.initArrowEvents = function () {
    var i = this;
    i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.off("click.slick").on("click.slick", {
      message: "previous"
    }, i.changeSlide), i.$nextArrow.off("click.slick").on("click.slick", {
      message: "next"
    }, i.changeSlide), i.options.accessibility === !0 && (i.$prevArrow.on("keydown.slick", i.keyHandler), i.$nextArrow.on("keydown.slick", i.keyHandler)));
  }, e.prototype.initDotEvents = function () {
    var e = this;
    e.options.dots === !0 && e.slideCount > e.options.slidesToShow && (i("li", e.$dots).on("click.slick", {
      message: "index"
    }, e.changeSlide), e.options.accessibility === !0 && e.$dots.on("keydown.slick", e.keyHandler)), e.options.dots === !0 && e.options.pauseOnDotsHover === !0 && e.slideCount > e.options.slidesToShow && i("li", e.$dots).on("mouseenter.slick", i.proxy(e.interrupt, e, !0)).on("mouseleave.slick", i.proxy(e.interrupt, e, !1));
  }, e.prototype.initSlideEvents = function () {
    var e = this;
    e.options.pauseOnHover && (e.$list.on("mouseenter.slick", i.proxy(e.interrupt, e, !0)), e.$list.on("mouseleave.slick", i.proxy(e.interrupt, e, !1)));
  }, e.prototype.initializeEvents = function () {
    var e = this;
    e.initArrowEvents(), e.initDotEvents(), e.initSlideEvents(), e.$list.on("touchstart.slick mousedown.slick", {
      action: "start"
    }, e.swipeHandler), e.$list.on("touchmove.slick mousemove.slick", {
      action: "move"
    }, e.swipeHandler), e.$list.on("touchend.slick mouseup.slick", {
      action: "end"
    }, e.swipeHandler), e.$list.on("touchcancel.slick mouseleave.slick", {
      action: "end"
    }, e.swipeHandler), e.$list.on("click.slick", e.clickHandler), i(document).on(e.visibilityChange, i.proxy(e.visibility, e)), e.options.accessibility === !0 && e.$list.on("keydown.slick", e.keyHandler), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().on("click.slick", e.selectHandler), i(window).on("orientationchange.slick.slick-" + e.instanceUid, i.proxy(e.orientationChange, e)), i(window).on("resize.slick.slick-" + e.instanceUid, i.proxy(e.resize, e)), i("[draggable!=true]", e.$slideTrack).on("dragstart", e.preventDefault), i(window).on("load.slick.slick-" + e.instanceUid, e.setPosition), i(e.setPosition);
  }, e.prototype.initUI = function () {
    var i = this;
    i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.show(), i.$nextArrow.show()), i.options.dots === !0 && i.slideCount > i.options.slidesToShow && i.$dots.show();
  }, e.prototype.keyHandler = function (i) {
    var e = this;
    i.target.tagName.match("TEXTAREA|INPUT|SELECT") || (37 === i.keyCode && e.options.accessibility === !0 ? e.changeSlide({
      data: {
        message: e.options.rtl === !0 ? "next" : "previous"
      }
    }) : 39 === i.keyCode && e.options.accessibility === !0 && e.changeSlide({
      data: {
        message: e.options.rtl === !0 ? "previous" : "next"
      }
    }));
  }, e.prototype.lazyLoad = function () {
    function e(e) {
      i("img[data-lazy]", e).each(function () {
        var e = i(this),
            t = i(this).attr("data-lazy"),
            o = i(this).attr("data-srcset"),
            s = i(this).attr("data-sizes") || r.$slider.attr("data-sizes"),
            n = document.createElement("img");
        n.onload = function () {
          e.animate({
            opacity: 0
          }, 100, function () {
            o && (e.attr("srcset", o), s && e.attr("sizes", s)), e.attr("src", t).animate({
              opacity: 1
            }, 200, function () {
              e.removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading");
            }), r.$slider.trigger("lazyLoaded", [r, e, t]);
          });
        }, n.onerror = function () {
          e.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), r.$slider.trigger("lazyLoadError", [r, e, t]);
        }, n.src = t;
      });
    }

    var t,
        o,
        s,
        n,
        r = this;
    if (r.options.centerMode === !0 ? r.options.infinite === !0 ? (s = r.currentSlide + (r.options.slidesToShow / 2 + 1), n = s + r.options.slidesToShow + 2) : (s = Math.max(0, r.currentSlide - (r.options.slidesToShow / 2 + 1)), n = 2 + (r.options.slidesToShow / 2 + 1) + r.currentSlide) : (s = r.options.infinite ? r.options.slidesToShow + r.currentSlide : r.currentSlide, n = Math.ceil(s + r.options.slidesToShow), r.options.fade === !0 && (s > 0 && s--, n <= r.slideCount && n++)), t = r.$slider.find(".slick-slide").slice(s, n), "anticipated" === r.options.lazyLoad) for (var l = s - 1, d = n, a = r.$slider.find(".slick-slide"), c = 0; c < r.options.slidesToScroll; c++) {
      l < 0 && (l = r.slideCount - 1), t = t.add(a.eq(l)), t = t.add(a.eq(d)), l--, d++;
    }
    e(t), r.slideCount <= r.options.slidesToShow ? (o = r.$slider.find(".slick-slide"), e(o)) : r.currentSlide >= r.slideCount - r.options.slidesToShow ? (o = r.$slider.find(".slick-cloned").slice(0, r.options.slidesToShow), e(o)) : 0 === r.currentSlide && (o = r.$slider.find(".slick-cloned").slice(r.options.slidesToShow * -1), e(o));
  }, e.prototype.loadSlider = function () {
    var i = this;
    i.setPosition(), i.$slideTrack.css({
      opacity: 1
    }), i.$slider.removeClass("slick-loading"), i.initUI(), "progressive" === i.options.lazyLoad && i.progressiveLazyLoad();
  }, e.prototype.next = e.prototype.slickNext = function () {
    var i = this;
    i.changeSlide({
      data: {
        message: "next"
      }
    });
  }, e.prototype.orientationChange = function () {
    var i = this;
    i.checkResponsive(), i.setPosition();
  }, e.prototype.pause = e.prototype.slickPause = function () {
    var i = this;
    i.autoPlayClear(), i.paused = !0;
  }, e.prototype.play = e.prototype.slickPlay = function () {
    var i = this;
    i.autoPlay(), i.options.autoplay = !0, i.paused = !1, i.focussed = !1, i.interrupted = !1;
  }, e.prototype.postSlide = function (e) {
    var t = this;

    if (!t.unslicked && (t.$slider.trigger("afterChange", [t, e]), t.animating = !1, t.slideCount > t.options.slidesToShow && t.setPosition(), t.swipeLeft = null, t.options.autoplay && t.autoPlay(), t.options.accessibility === !0 && (t.initADA(), t.options.focusOnChange))) {
      var o = i(t.$slides.get(t.currentSlide));
      o.attr("tabindex", 0).focus();
    }
  }, e.prototype.prev = e.prototype.slickPrev = function () {
    var i = this;
    i.changeSlide({
      data: {
        message: "previous"
      }
    });
  }, e.prototype.preventDefault = function (i) {
    i.preventDefault();
  }, e.prototype.progressiveLazyLoad = function (e) {
    e = e || 1;
    var t,
        o,
        s,
        n,
        r,
        l = this,
        d = i("img[data-lazy]", l.$slider);
    d.length ? (t = d.first(), o = t.attr("data-lazy"), s = t.attr("data-srcset"), n = t.attr("data-sizes") || l.$slider.attr("data-sizes"), r = document.createElement("img"), r.onload = function () {
      s && (t.attr("srcset", s), n && t.attr("sizes", n)), t.attr("src", o).removeAttr("data-lazy data-srcset data-sizes").removeClass("slick-loading"), l.options.adaptiveHeight === !0 && l.setPosition(), l.$slider.trigger("lazyLoaded", [l, t, o]), l.progressiveLazyLoad();
    }, r.onerror = function () {
      e < 3 ? setTimeout(function () {
        l.progressiveLazyLoad(e + 1);
      }, 500) : (t.removeAttr("data-lazy").removeClass("slick-loading").addClass("slick-lazyload-error"), l.$slider.trigger("lazyLoadError", [l, t, o]), l.progressiveLazyLoad());
    }, r.src = o) : l.$slider.trigger("allImagesLoaded", [l]);
  }, e.prototype.refresh = function (e) {
    var t,
        o,
        s = this;
    o = s.slideCount - s.options.slidesToShow, !s.options.infinite && s.currentSlide > o && (s.currentSlide = o), s.slideCount <= s.options.slidesToShow && (s.currentSlide = 0), t = s.currentSlide, s.destroy(!0), i.extend(s, s.initials, {
      currentSlide: t
    }), s.init(), e || s.changeSlide({
      data: {
        message: "index",
        index: t
      }
    }, !1);
  }, e.prototype.registerBreakpoints = function () {
    var e,
        t,
        o,
        s = this,
        n = s.options.responsive || null;

    if ("array" === i.type(n) && n.length) {
      s.respondTo = s.options.respondTo || "window";

      for (e in n) {
        if (o = s.breakpoints.length - 1, n.hasOwnProperty(e)) {
          for (t = n[e].breakpoint; o >= 0;) {
            s.breakpoints[o] && s.breakpoints[o] === t && s.breakpoints.splice(o, 1), o--;
          }

          s.breakpoints.push(t), s.breakpointSettings[t] = n[e].settings;
        }
      }

      s.breakpoints.sort(function (i, e) {
        return s.options.mobileFirst ? i - e : e - i;
      });
    }
  }, e.prototype.reinit = function () {
    var e = this;
    e.$slides = e.$slideTrack.children(e.options.slide).addClass("slick-slide"), e.slideCount = e.$slides.length, e.currentSlide >= e.slideCount && 0 !== e.currentSlide && (e.currentSlide = e.currentSlide - e.options.slidesToScroll), e.slideCount <= e.options.slidesToShow && (e.currentSlide = 0), e.registerBreakpoints(), e.setProps(), e.setupInfinite(), e.buildArrows(), e.updateArrows(), e.initArrowEvents(), e.buildDots(), e.updateDots(), e.initDotEvents(), e.cleanUpSlideEvents(), e.initSlideEvents(), e.checkResponsive(!1, !0), e.options.focusOnSelect === !0 && i(e.$slideTrack).children().on("click.slick", e.selectHandler), e.setSlideClasses("number" == typeof e.currentSlide ? e.currentSlide : 0), e.setPosition(), e.focusHandler(), e.paused = !e.options.autoplay, e.autoPlay(), e.$slider.trigger("reInit", [e]);
  }, e.prototype.resize = function () {
    var e = this;
    i(window).width() !== e.windowWidth && (clearTimeout(e.windowDelay), e.windowDelay = window.setTimeout(function () {
      e.windowWidth = i(window).width(), e.checkResponsive(), e.unslicked || e.setPosition();
    }, 50));
  }, e.prototype.removeSlide = e.prototype.slickRemove = function (i, e, t) {
    var o = this;
    return "boolean" == typeof i ? (e = i, i = e === !0 ? 0 : o.slideCount - 1) : i = e === !0 ? --i : i, !(o.slideCount < 1 || i < 0 || i > o.slideCount - 1) && (o.unload(), t === !0 ? o.$slideTrack.children().remove() : o.$slideTrack.children(this.options.slide).eq(i).remove(), o.$slides = o.$slideTrack.children(this.options.slide), o.$slideTrack.children(this.options.slide).detach(), o.$slideTrack.append(o.$slides), o.$slidesCache = o.$slides, void o.reinit());
  }, e.prototype.setCSS = function (i) {
    var e,
        t,
        o = this,
        s = {};
    o.options.rtl === !0 && (i = -i), e = "left" == o.positionProp ? Math.ceil(i) + "px" : "0px", t = "top" == o.positionProp ? Math.ceil(i) + "px" : "0px", s[o.positionProp] = i, o.transformsEnabled === !1 ? o.$slideTrack.css(s) : (s = {}, o.cssTransitions === !1 ? (s[o.animType] = "translate(" + e + ", " + t + ")", o.$slideTrack.css(s)) : (s[o.animType] = "translate3d(" + e + ", " + t + ", 0px)", o.$slideTrack.css(s)));
  }, e.prototype.setDimensions = function () {
    var i = this;
    i.options.vertical === !1 ? i.options.centerMode === !0 && i.$list.css({
      padding: "0px " + i.options.centerPadding
    }) : (i.$list.height(i.$slides.first().outerHeight(!0) * i.options.slidesToShow), i.options.centerMode === !0 && i.$list.css({
      padding: i.options.centerPadding + " 0px"
    })), i.listWidth = i.$list.width(), i.listHeight = i.$list.height(), i.options.vertical === !1 && i.options.variableWidth === !1 ? (i.slideWidth = Math.ceil(i.listWidth / i.options.slidesToShow), i.$slideTrack.width(Math.ceil(i.slideWidth * i.$slideTrack.children(".slick-slide").length))) : i.options.variableWidth === !0 ? i.$slideTrack.width(5e3 * i.slideCount) : (i.slideWidth = Math.ceil(i.listWidth), i.$slideTrack.height(Math.ceil(i.$slides.first().outerHeight(!0) * i.$slideTrack.children(".slick-slide").length)));
    var e = i.$slides.first().outerWidth(!0) - i.$slides.first().width();
    i.options.variableWidth === !1 && i.$slideTrack.children(".slick-slide").width(i.slideWidth - e);
  }, e.prototype.setFade = function () {
    var e,
        t = this;
    t.$slides.each(function (o, s) {
      e = t.slideWidth * o * -1, t.options.rtl === !0 ? i(s).css({
        position: "relative",
        right: e,
        top: 0,
        zIndex: t.options.zIndex - 2,
        opacity: 0
      }) : i(s).css({
        position: "relative",
        left: e,
        top: 0,
        zIndex: t.options.zIndex - 2,
        opacity: 0
      });
    }), t.$slides.eq(t.currentSlide).css({
      zIndex: t.options.zIndex - 1,
      opacity: 1
    });
  }, e.prototype.setHeight = function () {
    var i = this;

    if (1 === i.options.slidesToShow && i.options.adaptiveHeight === !0 && i.options.vertical === !1) {
      var e = i.$slides.eq(i.currentSlide).outerHeight(!0);
      i.$list.css("height", e);
    }
  }, e.prototype.setOption = e.prototype.slickSetOption = function () {
    var e,
        t,
        o,
        s,
        n,
        r = this,
        l = !1;
    if ("object" === i.type(arguments[0]) ? (o = arguments[0], l = arguments[1], n = "multiple") : "string" === i.type(arguments[0]) && (o = arguments[0], s = arguments[1], l = arguments[2], "responsive" === arguments[0] && "array" === i.type(arguments[1]) ? n = "responsive" : "undefined" != typeof arguments[1] && (n = "single")), "single" === n) r.options[o] = s;else if ("multiple" === n) i.each(o, function (i, e) {
      r.options[i] = e;
    });else if ("responsive" === n) for (t in s) {
      if ("array" !== i.type(r.options.responsive)) r.options.responsive = [s[t]];else {
        for (e = r.options.responsive.length - 1; e >= 0;) {
          r.options.responsive[e].breakpoint === s[t].breakpoint && r.options.responsive.splice(e, 1), e--;
        }

        r.options.responsive.push(s[t]);
      }
    }
    l && (r.unload(), r.reinit());
  }, e.prototype.setPosition = function () {
    var i = this;
    i.setDimensions(), i.setHeight(), i.options.fade === !1 ? i.setCSS(i.getLeft(i.currentSlide)) : i.setFade(), i.$slider.trigger("setPosition", [i]);
  }, e.prototype.setProps = function () {
    var i = this,
        e = document.body.style;
    i.positionProp = i.options.vertical === !0 ? "top" : "left", "top" === i.positionProp ? i.$slider.addClass("slick-vertical") : i.$slider.removeClass("slick-vertical"), void 0 === e.WebkitTransition && void 0 === e.MozTransition && void 0 === e.msTransition || i.options.useCSS === !0 && (i.cssTransitions = !0), i.options.fade && ("number" == typeof i.options.zIndex ? i.options.zIndex < 3 && (i.options.zIndex = 3) : i.options.zIndex = i.defaults.zIndex), void 0 !== e.OTransform && (i.animType = "OTransform", i.transformType = "-o-transform", i.transitionType = "OTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.MozTransform && (i.animType = "MozTransform", i.transformType = "-moz-transform", i.transitionType = "MozTransition", void 0 === e.perspectiveProperty && void 0 === e.MozPerspective && (i.animType = !1)), void 0 !== e.webkitTransform && (i.animType = "webkitTransform", i.transformType = "-webkit-transform", i.transitionType = "webkitTransition", void 0 === e.perspectiveProperty && void 0 === e.webkitPerspective && (i.animType = !1)), void 0 !== e.msTransform && (i.animType = "msTransform", i.transformType = "-ms-transform", i.transitionType = "msTransition", void 0 === e.msTransform && (i.animType = !1)), void 0 !== e.transform && i.animType !== !1 && (i.animType = "transform", i.transformType = "transform", i.transitionType = "transition"), i.transformsEnabled = i.options.useTransform && null !== i.animType && i.animType !== !1;
  }, e.prototype.setSlideClasses = function (i) {
    var e,
        t,
        o,
        s,
        n = this;

    if (t = n.$slider.find(".slick-slide").removeClass("slick-active slick-center slick-current").attr("aria-hidden", "true"), n.$slides.eq(i).addClass("slick-current"), n.options.centerMode === !0) {
      var r = n.options.slidesToShow % 2 === 0 ? 1 : 0;
      e = Math.floor(n.options.slidesToShow / 2), n.options.infinite === !0 && (i >= e && i <= n.slideCount - 1 - e ? n.$slides.slice(i - e + r, i + e + 1).addClass("slick-active").attr("aria-hidden", "false") : (o = n.options.slidesToShow + i, t.slice(o - e + 1 + r, o + e + 2).addClass("slick-active").attr("aria-hidden", "false")), 0 === i ? t.eq(t.length - 1 - n.options.slidesToShow).addClass("slick-center") : i === n.slideCount - 1 && t.eq(n.options.slidesToShow).addClass("slick-center")), n.$slides.eq(i).addClass("slick-center");
    } else i >= 0 && i <= n.slideCount - n.options.slidesToShow ? n.$slides.slice(i, i + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false") : t.length <= n.options.slidesToShow ? t.addClass("slick-active").attr("aria-hidden", "false") : (s = n.slideCount % n.options.slidesToShow, o = n.options.infinite === !0 ? n.options.slidesToShow + i : i, n.options.slidesToShow == n.options.slidesToScroll && n.slideCount - i < n.options.slidesToShow ? t.slice(o - (n.options.slidesToShow - s), o + s).addClass("slick-active").attr("aria-hidden", "false") : t.slice(o, o + n.options.slidesToShow).addClass("slick-active").attr("aria-hidden", "false"));

    "ondemand" !== n.options.lazyLoad && "anticipated" !== n.options.lazyLoad || n.lazyLoad();
  }, e.prototype.setupInfinite = function () {
    var e,
        t,
        o,
        s = this;

    if (s.options.fade === !0 && (s.options.centerMode = !1), s.options.infinite === !0 && s.options.fade === !1 && (t = null, s.slideCount > s.options.slidesToShow)) {
      for (o = s.options.centerMode === !0 ? s.options.slidesToShow + 1 : s.options.slidesToShow, e = s.slideCount; e > s.slideCount - o; e -= 1) {
        t = e - 1, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t - s.slideCount).prependTo(s.$slideTrack).addClass("slick-cloned");
      }

      for (e = 0; e < o + s.slideCount; e += 1) {
        t = e, i(s.$slides[t]).clone(!0).attr("id", "").attr("data-slick-index", t + s.slideCount).appendTo(s.$slideTrack).addClass("slick-cloned");
      }

      s.$slideTrack.find(".slick-cloned").find("[id]").each(function () {
        i(this).attr("id", "");
      });
    }
  }, e.prototype.interrupt = function (i) {
    var e = this;
    i || e.autoPlay(), e.interrupted = i;
  }, e.prototype.selectHandler = function (e) {
    var t = this,
        o = i(e.target).is(".slick-slide") ? i(e.target) : i(e.target).parents(".slick-slide"),
        s = parseInt(o.attr("data-slick-index"));
    return s || (s = 0), t.slideCount <= t.options.slidesToShow ? void t.slideHandler(s, !1, !0) : void t.slideHandler(s);
  }, e.prototype.slideHandler = function (i, e, t) {
    var o,
        s,
        n,
        r,
        l,
        d = null,
        a = this;
    if (e = e || !1, !(a.animating === !0 && a.options.waitForAnimate === !0 || a.options.fade === !0 && a.currentSlide === i)) return e === !1 && a.asNavFor(i), o = i, d = a.getLeft(o), r = a.getLeft(a.currentSlide), a.currentLeft = null === a.swipeLeft ? r : a.swipeLeft, a.options.infinite === !1 && a.options.centerMode === !1 && (i < 0 || i > a.getDotCount() * a.options.slidesToScroll) ? void (a.options.fade === !1 && (o = a.currentSlide, t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(r, function () {
      a.postSlide(o);
    }) : a.postSlide(o))) : a.options.infinite === !1 && a.options.centerMode === !0 && (i < 0 || i > a.slideCount - a.options.slidesToScroll) ? void (a.options.fade === !1 && (o = a.currentSlide, t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(r, function () {
      a.postSlide(o);
    }) : a.postSlide(o))) : (a.options.autoplay && clearInterval(a.autoPlayTimer), s = o < 0 ? a.slideCount % a.options.slidesToScroll !== 0 ? a.slideCount - a.slideCount % a.options.slidesToScroll : a.slideCount + o : o >= a.slideCount ? a.slideCount % a.options.slidesToScroll !== 0 ? 0 : o - a.slideCount : o, a.animating = !0, a.$slider.trigger("beforeChange", [a, a.currentSlide, s]), n = a.currentSlide, a.currentSlide = s, a.setSlideClasses(a.currentSlide), a.options.asNavFor && (l = a.getNavTarget(), l = l.slick("getSlick"), l.slideCount <= l.options.slidesToShow && l.setSlideClasses(a.currentSlide)), a.updateDots(), a.updateArrows(), a.options.fade === !0 ? (t !== !0 ? (a.fadeSlideOut(n), a.fadeSlide(s, function () {
      a.postSlide(s);
    })) : a.postSlide(s), void a.animateHeight()) : void (t !== !0 && a.slideCount > a.options.slidesToShow ? a.animateSlide(d, function () {
      a.postSlide(s);
    }) : a.postSlide(s)));
  }, e.prototype.startLoad = function () {
    var i = this;
    i.options.arrows === !0 && i.slideCount > i.options.slidesToShow && (i.$prevArrow.hide(), i.$nextArrow.hide()), i.options.dots === !0 && i.slideCount > i.options.slidesToShow && i.$dots.hide(), i.$slider.addClass("slick-loading");
  }, e.prototype.swipeDirection = function () {
    var i,
        e,
        t,
        o,
        s = this;
    return i = s.touchObject.startX - s.touchObject.curX, e = s.touchObject.startY - s.touchObject.curY, t = Math.atan2(e, i), o = Math.round(180 * t / Math.PI), o < 0 && (o = 360 - Math.abs(o)), o <= 45 && o >= 0 ? s.options.rtl === !1 ? "left" : "right" : o <= 360 && o >= 315 ? s.options.rtl === !1 ? "left" : "right" : o >= 135 && o <= 225 ? s.options.rtl === !1 ? "right" : "left" : s.options.verticalSwiping === !0 ? o >= 35 && o <= 135 ? "down" : "up" : "vertical";
  }, e.prototype.swipeEnd = function (i) {
    var e,
        t,
        o = this;
    if (o.dragging = !1, o.swiping = !1, o.scrolling) return o.scrolling = !1, !1;
    if (o.interrupted = !1, o.shouldClick = !(o.touchObject.swipeLength > 10), void 0 === o.touchObject.curX) return !1;

    if (o.touchObject.edgeHit === !0 && o.$slider.trigger("edge", [o, o.swipeDirection()]), o.touchObject.swipeLength >= o.touchObject.minSwipe) {
      switch (t = o.swipeDirection()) {
        case "left":
        case "down":
          e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide + o.getSlideCount()) : o.currentSlide + o.getSlideCount(), o.currentDirection = 0;
          break;

        case "right":
        case "up":
          e = o.options.swipeToSlide ? o.checkNavigable(o.currentSlide - o.getSlideCount()) : o.currentSlide - o.getSlideCount(), o.currentDirection = 1;
      }

      "vertical" != t && (o.slideHandler(e), o.touchObject = {}, o.$slider.trigger("swipe", [o, t]));
    } else o.touchObject.startX !== o.touchObject.curX && (o.slideHandler(o.currentSlide), o.touchObject = {});
  }, e.prototype.swipeHandler = function (i) {
    var e = this;
    if (!(e.options.swipe === !1 || "ontouchend" in document && e.options.swipe === !1 || e.options.draggable === !1 && i.type.indexOf("mouse") !== -1)) switch (e.touchObject.fingerCount = i.originalEvent && void 0 !== i.originalEvent.touches ? i.originalEvent.touches.length : 1, e.touchObject.minSwipe = e.listWidth / e.options.touchThreshold, e.options.verticalSwiping === !0 && (e.touchObject.minSwipe = e.listHeight / e.options.touchThreshold), i.data.action) {
      case "start":
        e.swipeStart(i);
        break;

      case "move":
        e.swipeMove(i);
        break;

      case "end":
        e.swipeEnd(i);
    }
  }, e.prototype.swipeMove = function (i) {
    var e,
        t,
        o,
        s,
        n,
        r,
        l = this;
    return n = void 0 !== i.originalEvent ? i.originalEvent.touches : null, !(!l.dragging || l.scrolling || n && 1 !== n.length) && (e = l.getLeft(l.currentSlide), l.touchObject.curX = void 0 !== n ? n[0].pageX : i.clientX, l.touchObject.curY = void 0 !== n ? n[0].pageY : i.clientY, l.touchObject.swipeLength = Math.round(Math.sqrt(Math.pow(l.touchObject.curX - l.touchObject.startX, 2))), r = Math.round(Math.sqrt(Math.pow(l.touchObject.curY - l.touchObject.startY, 2))), !l.options.verticalSwiping && !l.swiping && r > 4 ? (l.scrolling = !0, !1) : (l.options.verticalSwiping === !0 && (l.touchObject.swipeLength = r), t = l.swipeDirection(), void 0 !== i.originalEvent && l.touchObject.swipeLength > 4 && (l.swiping = !0, i.preventDefault()), s = (l.options.rtl === !1 ? 1 : -1) * (l.touchObject.curX > l.touchObject.startX ? 1 : -1), l.options.verticalSwiping === !0 && (s = l.touchObject.curY > l.touchObject.startY ? 1 : -1), o = l.touchObject.swipeLength, l.touchObject.edgeHit = !1, l.options.infinite === !1 && (0 === l.currentSlide && "right" === t || l.currentSlide >= l.getDotCount() && "left" === t) && (o = l.touchObject.swipeLength * l.options.edgeFriction, l.touchObject.edgeHit = !0), l.options.vertical === !1 ? l.swipeLeft = e + o * s : l.swipeLeft = e + o * (l.$list.height() / l.listWidth) * s, l.options.verticalSwiping === !0 && (l.swipeLeft = e + o * s), l.options.fade !== !0 && l.options.touchMove !== !1 && (l.animating === !0 ? (l.swipeLeft = null, !1) : void l.setCSS(l.swipeLeft))));
  }, e.prototype.swipeStart = function (i) {
    var e,
        t = this;
    return t.interrupted = !0, 1 !== t.touchObject.fingerCount || t.slideCount <= t.options.slidesToShow ? (t.touchObject = {}, !1) : (void 0 !== i.originalEvent && void 0 !== i.originalEvent.touches && (e = i.originalEvent.touches[0]), t.touchObject.startX = t.touchObject.curX = void 0 !== e ? e.pageX : i.clientX, t.touchObject.startY = t.touchObject.curY = void 0 !== e ? e.pageY : i.clientY, void (t.dragging = !0));
  }, e.prototype.unfilterSlides = e.prototype.slickUnfilter = function () {
    var i = this;
    null !== i.$slidesCache && (i.unload(), i.$slideTrack.children(this.options.slide).detach(), i.$slidesCache.appendTo(i.$slideTrack), i.reinit());
  }, e.prototype.unload = function () {
    var e = this;
    i(".slick-cloned", e.$slider).remove(), e.$dots && e.$dots.remove(), e.$prevArrow && e.htmlExpr.test(e.options.prevArrow) && e.$prevArrow.remove(), e.$nextArrow && e.htmlExpr.test(e.options.nextArrow) && e.$nextArrow.remove(), e.$slides.removeClass("slick-slide slick-active slick-visible slick-current").attr("aria-hidden", "true").css("width", "");
  }, e.prototype.unslick = function (i) {
    var e = this;
    e.$slider.trigger("unslick", [e, i]), e.destroy();
  }, e.prototype.updateArrows = function () {
    var i,
        e = this;
    i = Math.floor(e.options.slidesToShow / 2), e.options.arrows === !0 && e.slideCount > e.options.slidesToShow && !e.options.infinite && (e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false"), 0 === e.currentSlide ? (e.$prevArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$nextArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - e.options.slidesToShow && e.options.centerMode === !1 ? (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")) : e.currentSlide >= e.slideCount - 1 && e.options.centerMode === !0 && (e.$nextArrow.addClass("slick-disabled").attr("aria-disabled", "true"), e.$prevArrow.removeClass("slick-disabled").attr("aria-disabled", "false")));
  }, e.prototype.updateDots = function () {
    var i = this;
    null !== i.$dots && (i.$dots.find("li").removeClass("slick-active").end(), i.$dots.find("li").eq(Math.floor(i.currentSlide / i.options.slidesToScroll)).addClass("slick-active"));
  }, e.prototype.visibility = function () {
    var i = this;
    i.options.autoplay && (document[i.hidden] ? i.interrupted = !0 : i.interrupted = !1);
  }, i.fn.slick = function () {
    var i,
        t,
        o = this,
        s = arguments[0],
        n = Array.prototype.slice.call(arguments, 1),
        r = o.length;

    for (i = 0; i < r; i++) {
      if ("object" == _typeof(s) || "undefined" == typeof s ? o[i].slick = new e(o[i], s) : t = o[i].slick[s].apply(o[i].slick, n), "undefined" != typeof t) return t;
    }

    return o;
  };
});
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (t, e) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? e(exports) : "function" == typeof define && define.amd ? define(["exports"], e) : e(t.StickySidebar = {});
}(void 0, function (t) {
  "use strict";

  "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self && self;
  var e,
      i,
      n = (function (t, e) {
    (function (t) {
      Object.defineProperty(t, "__esModule", {
        value: !0
      });

      var l,
          n,
          e = function () {
        function n(t, e) {
          for (var i = 0; i < e.length; i++) {
            var n = e[i];
            n.enumerable = n.enumerable || !1, n.configurable = !0, "value" in n && (n.writable = !0), Object.defineProperty(t, n.key, n);
          }
        }

        return function (t, e, i) {
          return e && n(t.prototype, e), i && n(t, i), t;
        };
      }(),
          i = (n = {
        topSpacing: 0,
        bottomSpacing: 0,
        containerSelector: !(l = ".stickySidebar"),
        innerWrapperSelector: ".inner-wrapper-sticky",
        stickyClass: "is-affixed",
        resizeSensor: !0,
        minWidth: !1
      }, function () {
        function c(t) {
          var e = this,
              i = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : {};
          if (function (t, e) {
            if (!(t instanceof e)) throw new TypeError("Cannot call a class as a function");
          }(this, c), this.options = c.extend(n, i), this.sidebar = "string" == typeof t ? document.querySelector(t) : t, void 0 === this.sidebar) throw new Error("There is no specific sidebar element.");
          this.sidebarInner = !1, this.container = this.sidebar.parentElement, this.affixedType = "STATIC", this.direction = "down", this.support = {
            transform: !1,
            transform3d: !1
          }, this._initialized = !1, this._reStyle = !1, this._breakpoint = !1, this.dimensions = {
            translateY: 0,
            maxTranslateY: 0,
            topSpacing: 0,
            lastTopSpacing: 0,
            bottomSpacing: 0,
            lastBottomSpacing: 0,
            sidebarHeight: 0,
            sidebarWidth: 0,
            containerTop: 0,
            containerHeight: 0,
            viewportHeight: 0,
            viewportTop: 0,
            lastViewportTop: 0
          }, ["handleEvent"].forEach(function (t) {
            e[t] = e[t].bind(e);
          }), this.initialize();
        }

        return e(c, [{
          key: "initialize",
          value: function value() {
            var i = this;

            if (this._setSupportFeatures(), this.options.innerWrapperSelector && (this.sidebarInner = this.sidebar.querySelector(this.options.innerWrapperSelector), null === this.sidebarInner && (this.sidebarInner = !1)), !this.sidebarInner) {
              var t = document.createElement("div");

              for (t.setAttribute("class", "inner-wrapper-sticky"), this.sidebar.appendChild(t); this.sidebar.firstChild != t;) {
                t.appendChild(this.sidebar.firstChild);
              }

              this.sidebarInner = this.sidebar.querySelector(".inner-wrapper-sticky");
            }

            if (this.options.containerSelector) {
              var e = document.querySelectorAll(this.options.containerSelector);
              if ((e = Array.prototype.slice.call(e)).forEach(function (t, e) {
                t.contains(i.sidebar) && (i.container = t);
              }), !e.length) throw new Error("The container does not contains on the sidebar.");
            }

            "function" != typeof this.options.topSpacing && (this.options.topSpacing = parseInt(this.options.topSpacing) || 0), "function" != typeof this.options.bottomSpacing && (this.options.bottomSpacing = parseInt(this.options.bottomSpacing) || 0), this._widthBreakpoint(), this.calcDimensions(), this.stickyPosition(), this.bindEvents(), this._initialized = !0;
          }
        }, {
          key: "bindEvents",
          value: function value() {
            window.addEventListener("resize", this, {
              passive: !0,
              capture: !1
            }), window.addEventListener("scroll", this, {
              passive: !0,
              capture: !1
            }), this.sidebar.addEventListener("update" + l, this), this.options.resizeSensor && "undefined" != typeof ResizeSensor && (new ResizeSensor(this.sidebarInner, this.handleEvent), new ResizeSensor(this.container, this.handleEvent));
          }
        }, {
          key: "handleEvent",
          value: function value(t) {
            this.updateSticky(t);
          }
        }, {
          key: "calcDimensions",
          value: function value() {
            if (!this._breakpoint) {
              var t = this.dimensions;
              t.containerTop = c.offsetRelative(this.container).top, t.containerHeight = this.container.clientHeight, t.containerBottom = t.containerTop + t.containerHeight, t.sidebarHeight = this.sidebarInner.offsetHeight, t.sidebarWidth = this.sidebarInner.offsetWidth, t.viewportHeight = window.innerHeight, t.maxTranslateY = t.containerHeight - t.sidebarHeight, this._calcDimensionsWithScroll();
            }
          }
        }, {
          key: "_calcDimensionsWithScroll",
          value: function value() {
            var t = this.dimensions;
            t.sidebarLeft = c.offsetRelative(this.sidebar).left, t.viewportTop = document.documentElement.scrollTop || document.body.scrollTop, t.viewportBottom = t.viewportTop + t.viewportHeight, t.viewportLeft = document.documentElement.scrollLeft || document.body.scrollLeft, t.topSpacing = this.options.topSpacing, t.bottomSpacing = this.options.bottomSpacing, "function" == typeof t.topSpacing && (t.topSpacing = parseInt(t.topSpacing(this.sidebar)) || 0), "function" == typeof t.bottomSpacing && (t.bottomSpacing = parseInt(t.bottomSpacing(this.sidebar)) || 0), "VIEWPORT-TOP" === this.affixedType ? t.topSpacing < t.lastTopSpacing && (t.translateY += t.lastTopSpacing - t.topSpacing, this._reStyle = !0) : "VIEWPORT-BOTTOM" === this.affixedType && t.bottomSpacing < t.lastBottomSpacing && (t.translateY += t.lastBottomSpacing - t.bottomSpacing, this._reStyle = !0), t.lastTopSpacing = t.topSpacing, t.lastBottomSpacing = t.bottomSpacing;
          }
        }, {
          key: "isSidebarFitsViewport",
          value: function value() {
            var t = this.dimensions,
                e = "down" === this.scrollDirection ? t.lastBottomSpacing : t.lastTopSpacing;
            return this.dimensions.sidebarHeight + e < this.dimensions.viewportHeight;
          }
        }, {
          key: "observeScrollDir",
          value: function value() {
            var t = this.dimensions;

            if (t.lastViewportTop !== t.viewportTop) {
              var e = "down" === this.direction ? Math.min : Math.max;
              t.viewportTop === e(t.viewportTop, t.lastViewportTop) && (this.direction = "down" === this.direction ? "up" : "down");
            }
          }
        }, {
          key: "getAffixType",
          value: function value() {
            this._calcDimensionsWithScroll();

            var t = this.dimensions,
                e = t.viewportTop + t.topSpacing,
                i = this.affixedType;
            return e <= t.containerTop || t.containerHeight <= t.sidebarHeight ? (t.translateY = 0, i = "STATIC") : i = "up" === this.direction ? this._getAffixTypeScrollingUp() : this._getAffixTypeScrollingDown(), t.translateY = Math.max(0, t.translateY), t.translateY = Math.min(t.containerHeight, t.translateY), t.translateY = Math.round(t.translateY), t.lastViewportTop = t.viewportTop, i;
          }
        }, {
          key: "_getAffixTypeScrollingDown",
          value: function value() {
            var t = this.dimensions,
                e = t.sidebarHeight + t.containerTop,
                i = t.viewportTop + t.topSpacing,
                n = t.viewportBottom - t.bottomSpacing,
                o = this.affixedType;
            return this.isSidebarFitsViewport() ? t.sidebarHeight + i >= t.containerBottom ? (t.translateY = t.containerBottom - e, o = "CONTAINER-BOTTOM") : i >= t.containerTop && (t.translateY = i - t.containerTop, o = "VIEWPORT-TOP") : t.containerBottom <= n ? (t.translateY = t.containerBottom - e, o = "CONTAINER-BOTTOM") : e + t.translateY <= n ? (t.translateY = n - e, o = "VIEWPORT-BOTTOM") : t.containerTop + t.translateY <= i && 0 !== t.translateY && t.maxTranslateY !== t.translateY && (o = "VIEWPORT-UNBOTTOM"), o;
          }
        }, {
          key: "_getAffixTypeScrollingUp",
          value: function value() {
            var t = this.dimensions,
                e = t.sidebarHeight + t.containerTop,
                i = t.viewportTop + t.topSpacing,
                n = t.viewportBottom - t.bottomSpacing,
                o = this.affixedType;
            return i <= t.translateY + t.containerTop ? (t.translateY = i - t.containerTop, o = "VIEWPORT-TOP") : t.containerBottom <= n ? (t.translateY = t.containerBottom - e, o = "CONTAINER-BOTTOM") : this.isSidebarFitsViewport() || t.containerTop <= i && 0 !== t.translateY && t.maxTranslateY !== t.translateY && (o = "VIEWPORT-UNBOTTOM"), o;
          }
        }, {
          key: "_getStyle",
          value: function value(t) {
            if (void 0 !== t) {
              var e = {
                inner: {},
                outer: {}
              },
                  i = this.dimensions;

              switch (t) {
                case "VIEWPORT-TOP":
                  e.inner = {
                    position: "fixed",
                    top: i.topSpacing,
                    left: i.sidebarLeft - i.viewportLeft,
                    width: i.sidebarWidth
                  };
                  break;

                case "VIEWPORT-BOTTOM":
                  e.inner = {
                    position: "fixed",
                    top: "auto",
                    left: i.sidebarLeft,
                    bottom: i.bottomSpacing,
                    width: i.sidebarWidth
                  };
                  break;

                case "CONTAINER-BOTTOM":
                case "VIEWPORT-UNBOTTOM":
                  var n = this._getTranslate(0, i.translateY + "px");

                  e.inner = n ? {
                    transform: n
                  } : {
                    position: "absolute",
                    top: i.translateY,
                    width: i.sidebarWidth
                  };
              }

              switch (t) {
                case "VIEWPORT-TOP":
                case "VIEWPORT-BOTTOM":
                case "VIEWPORT-UNBOTTOM":
                case "CONTAINER-BOTTOM":
                  e.outer = {
                    height: i.sidebarHeight,
                    position: "relative"
                  };
              }

              return e.outer = c.extend({
                height: "",
                position: ""
              }, e.outer), e.inner = c.extend({
                position: "relative",
                top: "",
                left: "",
                bottom: "",
                width: "",
                transform: ""
              }, e.inner), e;
            }
          }
        }, {
          key: "stickyPosition",
          value: function value(t) {
            if (!this._breakpoint) {
              t = this._reStyle || t || !1, this.options.topSpacing, this.options.bottomSpacing;

              var e = this.getAffixType(),
                  i = this._getStyle(e);

              if ((this.affixedType != e || t) && e) {
                var n = "affix." + e.toLowerCase().replace("viewport-", "") + l;

                for (var o in c.eventTrigger(this.sidebar, n), "STATIC" === e ? c.removeClass(this.sidebar, this.options.stickyClass) : c.addClass(this.sidebar, this.options.stickyClass), i.outer) {
                  var s = "number" == typeof i.outer[o] ? "px" : "";
                  this.sidebar.style[o] = i.outer[o] + s;
                }

                for (var r in i.inner) {
                  var a = "number" == typeof i.inner[r] ? "px" : "";
                  this.sidebarInner.style[r] = i.inner[r] + a;
                }

                var p = "affixed." + e.toLowerCase().replace("viewport-", "") + l;
                c.eventTrigger(this.sidebar, p);
              } else this._initialized && (this.sidebarInner.style.left = i.inner.left);

              this.affixedType = e;
            }
          }
        }, {
          key: "_widthBreakpoint",
          value: function value() {
            window.innerWidth <= this.options.minWidth ? (this._breakpoint = !0, this.affixedType = "STATIC", this.sidebar.removeAttribute("style"), c.removeClass(this.sidebar, this.options.stickyClass), this.sidebarInner.removeAttribute("style")) : this._breakpoint = !1;
          }
        }, {
          key: "updateSticky",
          value: function value() {
            var t,
                e = this,
                i = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : {};
            this._running || (this._running = !0, t = i.type, requestAnimationFrame(function () {
              switch (t) {
                case "scroll":
                  e._calcDimensionsWithScroll(), e.observeScrollDir(), e.stickyPosition();
                  break;

                case "resize":
                default:
                  e._widthBreakpoint(), e.calcDimensions(), e.stickyPosition(!0);
              }

              e._running = !1;
            }));
          }
        }, {
          key: "_setSupportFeatures",
          value: function value() {
            var t = this.support;
            t.transform = c.supportTransform(), t.transform3d = c.supportTransform(!0);
          }
        }, {
          key: "_getTranslate",
          value: function value() {
            var t = 0 < arguments.length && void 0 !== arguments[0] ? arguments[0] : 0,
                e = 1 < arguments.length && void 0 !== arguments[1] ? arguments[1] : 0,
                i = 2 < arguments.length && void 0 !== arguments[2] ? arguments[2] : 0;
            return this.support.transform3d ? "translate3d(" + t + ", " + e + ", " + i + ")" : !!this.support.translate && "translate(" + t + ", " + e + ")";
          }
        }, {
          key: "destroy",
          value: function value() {
            window.removeEventListener("resize", this, {
              capture: !1
            }), window.removeEventListener("scroll", this, {
              capture: !1
            }), this.sidebar.classList.remove(this.options.stickyClass), this.sidebar.style.minHeight = "", this.sidebar.removeEventListener("update" + l, this);
            var t = {
              inner: {},
              outer: {}
            };

            for (var e in t.inner = {
              position: "",
              top: "",
              left: "",
              bottom: "",
              width: "",
              transform: ""
            }, t.outer = {
              height: "",
              position: ""
            }, t.outer) {
              this.sidebar.style[e] = t.outer[e];
            }

            for (var i in t.inner) {
              this.sidebarInner.style[i] = t.inner[i];
            }

            this.options.resizeSensor && "undefined" != typeof ResizeSensor && (ResizeSensor.detach(this.sidebarInner, this.handleEvent), ResizeSensor.detach(this.container, this.handleEvent));
          }
        }], [{
          key: "supportTransform",
          value: function value(t) {
            var i = !1,
                e = t ? "perspective" : "transform",
                n = e.charAt(0).toUpperCase() + e.slice(1),
                o = document.createElement("support").style;
            return (e + " " + ["Webkit", "Moz", "O", "ms"].join(n + " ") + n).split(" ").forEach(function (t, e) {
              if (void 0 !== o[t]) return i = t, !1;
            }), i;
          }
        }, {
          key: "eventTrigger",
          value: function value(t, e, i) {
            try {
              var n = new CustomEvent(e, {
                detail: i
              });
            } catch (t) {
              (n = document.createEvent("CustomEvent")).initCustomEvent(e, !0, !0, i);
            }

            t.dispatchEvent(n);
          }
        }, {
          key: "extend",
          value: function value(t, e) {
            var i = {};

            for (var n in t) {
              void 0 !== e[n] ? i[n] = e[n] : i[n] = t[n];
            }

            return i;
          }
        }, {
          key: "offsetRelative",
          value: function value(t) {
            var e = {
              left: 0,
              top: 0
            };

            do {
              var i = t.offsetTop,
                  n = t.offsetLeft;
              isNaN(i) || (e.top += i), isNaN(n) || (e.left += n), t = "BODY" === t.tagName ? t.parentElement : t.offsetParent;
            } while (t);

            return e;
          }
        }, {
          key: "addClass",
          value: function value(t, e) {
            c.hasClass(t, e) || (t.classList ? t.classList.add(e) : t.className += " " + e);
          }
        }, {
          key: "removeClass",
          value: function value(t, e) {
            c.hasClass(t, e) && (t.classList ? t.classList.remove(e) : t.className = t.className.replace(new RegExp("(^|\\b)" + e.split(" ").join("|") + "(\\b|$)", "gi"), " "));
          }
        }, {
          key: "hasClass",
          value: function value(t, e) {
            return t.classList ? t.classList.contains(e) : new RegExp("(^| )" + e + "( |$)", "gi").test(t.className);
          }
        }, {
          key: "defaults",
          get: function get() {
            return n;
          }
        }]), c;
      }());

      t.default = i, window.StickySidebar = i;
    })(e);
  }(e = {
    exports: {}
  }, e.exports), e.exports),
      o = (i = n) && i.__esModule && Object.prototype.hasOwnProperty.call(i, "default") ? i.default : i;
  t.default = o, t.__moduleExports = n, Object.defineProperty(t, "__esModule", {
    value: !0
  });
});
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

!function (a, b) {
  "function" == typeof define && define.amd ? define([], function () {
    return a.svg4everybody = b();
  }) : "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) ? module.exports = b() : a.svg4everybody = b();
}(void 0, function () {
  /*! svg4everybody v2.0.0 | github.com/jonathantneal/svg4everybody */
  function a(a, b) {
    if (b) {
      var c = !a.getAttribute("viewBox") && b.getAttribute("viewBox"),
          d = document.createDocumentFragment(),
          e = b.cloneNode(!0);

      for (c && a.setAttribute("viewBox", c); e.childNodes.length;) {
        d.appendChild(e.firstChild);
      }

      a.appendChild(d);
    }
  }

  function b(b) {
    b.onreadystatechange = function () {
      if (4 === b.readyState) {
        var c = document.createElement("x");
        c.innerHTML = b.responseText, b.s.splice(0).map(function (b) {
          a(b[0], c.querySelector("#" + b[1].replace(/(\W)/g, "\\$1")));
        });
      }
    }, b.onreadystatechange();
  }

  function c(c) {
    function d() {
      for (var c; c = e[0];) {
        var j = c.parentNode;

        if (j && /svg/i.test(j.nodeName)) {
          var k = c.getAttribute("xlink:href");

          if (f && (!g || g(k, j, c))) {
            var l = k.split("#"),
                m = l[0],
                n = l[1];

            if (j.removeChild(c), m.length) {
              var o = i[m] = i[m] || new XMLHttpRequest();
              o.s || (o.s = [], o.open("GET", m), o.send()), o.s.push([j, n]), b(o);
            } else a(j, document.getElementById(n));
          }
        }
      }

      h(d, 17);
    }

    c = c || {};
    var e = document.getElementsByTagName("use"),
        f = "shim" in c ? c.shim : /\bEdge\/12\b|\bTrident\/[567]\b|\bVersion\/7.0 Safari\b/.test(navigator.userAgent) || (navigator.userAgent.match(/AppleWebKit\/(\d+)/) || [])[1] < 537,
        g = c.validate,
        h = window.requestAnimationFrame || setTimeout,
        i = {};
    f && d();
  }

  return c;
});
svg4everybody();
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! UIkit 3.0.0-rc.9 | http://www.getuikit.com | (c) 2014 - 2017 YOOtheme | MIT License */
!function (t, i) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? module.exports = i() : "function" == typeof define && define.amd ? define("uikiticons", i) : t.UIkitIcons = i();
}(void 0, function () {
  "use strict";

  function i(t) {
    i.installed || t.icon.add({
      "500px": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M9.624,11.866c-0.141,0.132,0.479,0.658,0.662,0.418c0.051-0.046,0.607-0.61,0.662-0.664c0,0,0.738,0.719,0.814,0.719\t\tc0.1,0,0.207-0.055,0.322-0.17c0.27-0.269,0.135-0.416,0.066-0.495l-0.631-0.616l0.658-0.668c0.146-0.156,0.021-0.314-0.1-0.449\t\tc-0.182-0.18-0.359-0.226-0.471-0.125l-0.656,0.654l-0.654-0.654c-0.033-0.034-0.08-0.045-0.124-0.045\t\tc-0.079,0-0.191,0.068-0.307,0.181c-0.202,0.202-0.247,0.351-0.133,0.462l0.665,0.665L9.624,11.866z" /> <path d="M11.066,2.884c-1.061,0-2.185,0.248-3.011,0.604c-0.087,0.034-0.141,0.106-0.15,0.205C7.893,3.784,7.919,3.909,7.982,4.066\t\tc0.05,0.136,0.187,0.474,0.452,0.372c0.844-0.326,1.779-0.507,2.633-0.507c0.963,0,1.9,0.191,2.781,0.564\t\tc0.695,0.292,1.357,0.719,2.078,1.34c0.051,0.044,0.105,0.068,0.164,0.068c0.143,0,0.273-0.137,0.389-0.271\t\tc0.191-0.214,0.324-0.395,0.135-0.575c-0.686-0.654-1.436-1.138-2.363-1.533C13.24,3.097,12.168,2.884,11.066,2.884z" /> <path d="M16.43,15.747c-0.092-0.028-0.242,0.05-0.309,0.119l0,0c-0.652,0.652-1.42,1.169-2.268,1.521\t\tc-0.877,0.371-1.814,0.551-2.779,0.551c-0.961,0-1.896-0.189-2.775-0.564c-0.848-0.36-1.612-0.879-2.268-1.53\t\tc-0.682-0.688-1.196-1.455-1.529-2.268c-0.325-0.799-0.471-1.643-0.471-1.643c-0.045-0.24-0.258-0.249-0.567-0.203\t\tc-0.128,0.021-0.519,0.079-0.483,0.36v0.01c0.105,0.644,0.289,1.284,0.545,1.895c0.417,0.969,1.002,1.849,1.756,2.604\t\tc0.757,0.754,1.636,1.34,2.604,1.757C8.901,18.785,9.97,19,11.088,19c1.104,0,2.186-0.215,3.188-0.645\t\tc1.838-0.896,2.604-1.757,2.604-1.757c0.182-0.204,0.227-0.317-0.1-0.643C16.779,15.956,16.525,15.774,16.43,15.747z" /> <path d="M5.633,13.287c0.293,0.71,0.723,1.341,1.262,1.882c0.54,0.54,1.172,0.971,1.882,1.264c0.731,0.303,1.509,0.461,2.298,0.461\t\tc0.801,0,1.578-0.158,2.297-0.461c0.711-0.293,1.344-0.724,1.883-1.264c0.543-0.541,0.971-1.172,1.264-1.882\t\tc0.314-0.721,0.463-1.5,0.463-2.298c0-0.79-0.148-1.569-0.463-2.289c-0.293-0.699-0.721-1.329-1.264-1.881\t\tc-0.539-0.541-1.172-0.959-1.867-1.263c-0.721-0.303-1.5-0.461-2.299-0.461c-0.802,0-1.613,0.159-2.322,0.461\t\tc-0.577,0.25-1.544,0.867-2.119,1.454v0.012V2.108h8.16C15.1,2.104,15.1,1.69,15.1,1.552C15.1,1.417,15.1,1,14.809,1H5.915\t\tC5.676,1,5.527,1.192,5.527,1.384v6.84c0,0.214,0.273,0.372,0.529,0.428c0.5,0.105,0.614-0.056,0.737-0.224l0,0\t\tc0.18-0.273,0.776-0.884,0.787-0.894c0.901-0.905,2.117-1.408,3.416-1.408c1.285,0,2.5,0.501,3.412,1.408\t\tc0.914,0.914,1.408,2.122,1.408,3.405c0,1.288-0.508,2.496-1.408,3.405c-0.9,0.896-2.152,1.406-3.438,1.406\t\tc-0.877,0-1.711-0.229-2.433-0.671v-4.158c0-0.553,0.237-1.151,0.643-1.614c0.462-0.519,1.094-0.799,1.782-0.799\t\tc0.664,0,1.293,0.253,1.758,0.715c0.459,0.459,0.709,1.071,0.709,1.723c0,1.385-1.094,2.468-2.488,2.468\t\tc-0.273,0-0.769-0.121-0.781-0.125c-0.281-0.087-0.405,0.306-0.438,0.436c-0.159,0.496,0.079,0.585,0.123,0.607\t\tc0.452,0.137,0.743,0.157,1.129,0.157c1.973,0,3.572-1.6,3.572-3.57c0-1.964-1.6-3.552-3.572-3.552c-0.97,0-1.872,0.36-2.546,1.038\t\tc-0.656,0.631-1.027,1.487-1.027,2.322v3.438v-0.011c-0.372-0.42-0.732-1.041-0.981-1.682c-0.102-0.248-0.315-0.202-0.607-0.113\t\tc-0.135,0.035-0.519,0.157-0.44,0.439C5.372,12.799,5.577,13.164,5.633,13.287z" /></svg>',
      album: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="5" y="2" width="10" height="1" /> <rect x="3" y="4" width="14" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="6.5" width="17" height="11" /></svg>',
      "arrow-down": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="10.5,16.08 5.63,10.66 6.37,10 10.5,14.58 14.63,10 15.37,10.66" /> <line fill="none" stroke="#000" x1="10.5" y1="4" x2="10.5" y2="15" /></svg>',
      "arrow-left": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="10 14 5 9.5 10 5" /> <line fill="none" stroke="#000" x1="16" y1="9.5" x2="5" y2="9.52" /></svg>',
      "arrow-right": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="10 5 15 9.5 10 14" /> <line fill="none" stroke="#000" x1="4" y1="9.5" x2="15" y2="9.5" /></svg>',
      "arrow-up": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="10.5,4 15.37,9.4 14.63,10.08 10.5,5.49 6.37,10.08 5.63,9.4" /> <line fill="none" stroke="#000" x1="10.5" y1="16" x2="10.5" y2="5" /></svg>',
      ban: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <line fill="none" stroke="#000" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5" /></svg>',
      behance: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M9.5,10.6c-0.4-0.5-0.9-0.9-1.6-1.1c1.7-1,2.2-3.2,0.7-4.7C7.8,4,6.3,4,5.2,4C3.5,4,1.7,4,0,4v12c1.7,0,3.4,0,5.2,0 c1,0,2.1,0,3.1-0.5C10.2,14.6,10.5,12.3,9.5,10.6L9.5,10.6z M5.6,6.1c1.8,0,1.8,2.7-0.1,2.7c-1,0-2,0-2.9,0V6.1H5.6z M2.6,13.8v-3.1 c1.1,0,2.1,0,3.2,0c2.1,0,2.1,3.2,0.1,3.2L2.6,13.8z" /> <path d="M19.9,10.9C19.7,9.2,18.7,7.6,17,7c-4.2-1.3-7.3,3.4-5.3,7.1c0.9,1.7,2.8,2.3,4.7,2.1c1.7-0.2,2.9-1.3,3.4-2.9h-2.2 c-0.4,1.3-2.4,1.5-3.5,0.6c-0.4-0.4-0.6-1.1-0.6-1.7H20C20,11.7,19.9,10.9,19.9,10.9z M13.5,10.6c0-1.6,2.3-2.7,3.5-1.4 c0.4,0.4,0.5,0.9,0.6,1.4H13.5L13.5,10.6z" /> <rect x="13" y="4" width="5" height="1.4" /></svg>',
      bell: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17,15.5 L3,15.5 C2.99,14.61 3.79,13.34 4.1,12.51 C4.58,11.3 4.72,10.35 5.19,7.01 C5.54,4.53 5.89,3.2 7.28,2.16 C8.13,1.56 9.37,1.5 9.81,1.5 L9.96,1.5 C9.96,1.5 11.62,1.41 12.67,2.17 C14.08,3.2 14.42,4.54 14.77,7.02 C15.26,10.35 15.4,11.31 15.87,12.52 C16.2,13.34 17.01,14.61 17,15.5 L17,15.5 Z" /> <path fill="none" stroke="#000" d="M12.39,16 C12.39,17.37 11.35,18.43 9.91,18.43 C8.48,18.43 7.42,17.37 7.42,16" /></svg>',
      bold: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M5,15.3 C5.66,15.3 5.9,15 5.9,14.53 L5.9,5.5 C5.9,4.92 5.56,4.7 5,4.7 L5,4 L8.95,4 C12.6,4 13.7,5.37 13.7,6.9 C13.7,7.87 13.14,9.17 10.86,9.59 L10.86,9.7 C13.25,9.86 14.29,11.28 14.3,12.54 C14.3,14.47 12.94,16 9,16 L5,16 L5,15.3 Z M9,9.3 C11.19,9.3 11.8,8.5 11.85,7 C11.85,5.65 11.3,4.8 9,4.8 L7.67,4.8 L7.67,9.3 L9,9.3 Z M9.185,15.22 C11.97,15 12.39,14 12.4,12.58 C12.4,11.15 11.39,10 9,10 L7.67,10 L7.67,15 L9.18,15 Z" /></svg>',
      bolt: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M4.74,20 L7.73,12 L3,12 L15.43,1 L12.32,9 L17.02,9 L4.74,20 L4.74,20 L4.74,20 Z M9.18,11 L7.1,16.39 L14.47,10 L10.86,10 L12.99,4.67 L5.61,11 L9.18,11 L9.18,11 L9.18,11 Z" /></svg>',
      bookmark: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="5.5 1.5 15.5 1.5 15.5 17.5 10.5 12.5 5.5 17.5" /></svg>',
      calendar: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M 2,3 2,17 18,17 18,3 2,3 Z M 17,16 3,16 3,8 17,8 17,16 Z M 17,7 3,7 3,4 17,4 17,7 Z" /> <rect width="1" height="3" x="6" y="2" /> <rect width="1" height="3" x="13" y="2" /></svg>',
      camera: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10.8" r="3.8" /> <path fill="none" stroke="#000" d="M1,4.5 C0.7,4.5 0.5,4.7 0.5,5 L0.5,17 C0.5,17.3 0.7,17.5 1,17.5 L19,17.5 C19.3,17.5 19.5,17.3 19.5,17 L19.5,5 C19.5,4.7 19.3,4.5 19,4.5 L13.5,4.5 L13.5,2.9 C13.5,2.6 13.3,2.5 13,2.5 L7,2.5 C6.7,2.5 6.5,2.6 6.5,2.9 L6.5,4.5 L1,4.5 L1,4.5 Z" /></svg>',
      cart: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="7.3" cy="17.3" r="1.4" /> <circle cx="13.3" cy="17.3" r="1.4" /> <polyline fill="none" stroke="#000" points="0 2 3.2 4 5.3 12.5 16 12.5 18 6.5 8 6.5" /></svg>',
      check: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.1" points="4,10 8,15 17,4" /></svg>',
      "chevron-down": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="16 7 10 13 4 7" /></svg>',
      "chevron-left": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4" /></svg>',
      "chevron-right": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="7 4 13 10 7 16" /></svg>',
      "chevron-up": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="4 13 10 7 16 13" /></svg>',
      clock: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <rect x="9" y="4" width="1" height="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M13.018,14.197 L9.445,10.625" /></svg>',
      close: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.06" d="M16,16 L4,4" /> <path fill="none" stroke="#000" stroke-width="1.06" d="M16,4 L4,16" /></svg>',
      "cloud-download": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.5,14.61 L3.75,14.61 C1.96,14.61 0.5,13.17 0.5,11.39 C0.5,9.76 1.72,8.41 3.3,8.2 C3.38,5.31 5.75,3 8.68,3 C11.19,3 13.31,4.71 13.89,7.02 C14.39,6.8 14.93,6.68 15.5,6.68 C17.71,6.68 19.5,8.45 19.5,10.64 C19.5,12.83 17.71,14.6 15.5,14.6 L12.5,14.6" /> <polyline fill="none" stroke="#000" points="11.75 16 9.5 18.25 7.25 16" /> <path fill="none" stroke="#000" d="M9.5,18 L9.5,9.5" /></svg>',
      "cloud-upload": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.5,14.61 L3.75,14.61 C1.96,14.61 0.5,13.17 0.5,11.39 C0.5,9.76 1.72,8.41 3.31,8.2 C3.38,5.31 5.75,3 8.68,3 C11.19,3 13.31,4.71 13.89,7.02 C14.39,6.8 14.93,6.68 15.5,6.68 C17.71,6.68 19.5,8.45 19.5,10.64 C19.5,12.83 17.71,14.6 15.5,14.6 L12.5,14.6" /> <polyline fill="none" stroke="#000" points="7.25 11.75 9.5 9.5 11.75 11.75" /> <path fill="none" stroke="#000" d="M9.5,18 L9.5,9.5" /></svg>',
      code: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.01" points="13,4 19,10 13,16" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="7,4 1,10 7,16" /></svg>',
      cog: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" cx="9.997" cy="10" r="3.31" /> <path fill="none" stroke="#000" d="M18.488,12.285 L16.205,16.237 C15.322,15.496 14.185,15.281 13.303,15.791 C12.428,16.289 12.047,17.373 12.246,18.5 L7.735,18.5 C7.938,17.374 7.553,16.299 6.684,15.791 C5.801,15.27 4.655,15.492 3.773,16.237 L1.5,12.285 C2.573,11.871 3.317,10.999 3.317,9.991 C3.305,8.98 2.573,8.121 1.5,7.716 L3.765,3.784 C4.645,4.516 5.794,4.738 6.687,4.232 C7.555,3.722 7.939,2.637 7.735,1.5 L12.263,1.5 C12.072,2.637 12.441,3.71 13.314,4.22 C14.206,4.73 15.343,4.516 16.225,3.794 L18.487,7.714 C17.404,8.117 16.661,8.988 16.67,10.009 C16.672,11.018 17.415,11.88 18.488,12.285 L18.488,12.285 Z" /></svg>',
      comment: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6,18.71 L6,14 L1,14 L1,1 L19,1 L19,14 L10.71,14 L6,18.71 L6,18.71 Z M2,13 L7,13 L7,16.29 L10.29,13 L18,13 L18,2 L2,2 L2,13 L2,13 Z" /></svg>',
      commenting: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="1.5,1.5 18.5,1.5 18.5,13.5 10.5,13.5 6.5,17.5 6.5,13.5 1.5,13.5" /> <circle cx="10" cy="8" r="1" /> <circle cx="6" cy="8" r="1" /> <circle cx="14" cy="8" r="1" /></svg>',
      comments: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="2 0.5 19.5 0.5 19.5 13" /> <path d="M5,19.71 L5,15 L0,15 L0,2 L18,2 L18,15 L9.71,15 L5,19.71 L5,19.71 L5,19.71 Z M1,14 L6,14 L6,17.29 L9.29,14 L17,14 L17,3 L1,3 L1,14 L1,14 L1,14 Z" /></svg>',
      copy: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="2.5" width="12" height="16" /> <polyline fill="none" stroke="#000" points="5 0.5 17.5 0.5 17.5 17" /></svg>',
      "credit-card": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="1.5" y="4.5" width="17" height="12" /> <rect x="1" y="7" width="18" height="3" /></svg>',
      database: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <ellipse fill="none" stroke="#000" cx="10" cy="4.64" rx="7.5" ry="3.14" /> <path fill="none" stroke="#000" d="M17.5,8.11 C17.5,9.85 14.14,11.25 10,11.25 C5.86,11.25 2.5,9.84 2.5,8.11" /> <path fill="none" stroke="#000" d="M17.5,11.25 C17.5,12.99 14.14,14.39 10,14.39 C5.86,14.39 2.5,12.98 2.5,11.25" /> <path fill="none" stroke="#000" d="M17.49,4.64 L17.5,14.36 C17.5,16.1 14.14,17.5 10,17.5 C5.86,17.5 2.5,16.09 2.5,14.36 L2.5,4.64" /></svg>',
      desktop: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="8" y="15" width="1" height="2" /> <rect x="11" y="15" width="1" height="2" /> <rect x="5" y="16" width="10" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="3.5" width="17" height="11" /></svg>',
      download: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="14,10 9.5,14.5 5,10" /> <rect x="3" y="17" width="13" height="1" /> <line fill="none" stroke="#000" x1="9.5" y1="13.91" x2="9.5" y2="3" /></svg>',
      dribbble: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.4" d="M1.3,8.9c0,0,5,0.1,8.6-1c1.4-0.4,2.6-0.9,4-1.9 c1.4-1.1,2.5-2.5,2.5-2.5" /> <path fill="none" stroke="#000" stroke-width="1.4" d="M3.9,16.6c0,0,1.7-2.8,3.5-4.2 c1.8-1.3,4-2,5.7-2.2C16,10,19,10.6,19,10.6" /> <path fill="none" stroke="#000" stroke-width="1.4" d="M6.9,1.6c0,0,3.3,4.6,4.2,6.8 c0.4,0.9,1.3,3.1,1.9,5.2c0.6,2,0.9,4.4,0.9,4.4" /> <circle fill="none" stroke="#000" stroke-width="1.4" cx="10" cy="10" r="9" /></svg>',
      expand: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="13 2 18 2 18 7 17 7 17 3 13 3" /> <polygon points="2 13 3 13 3 17 7 17 7 18 2 18" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M11,9 L17,3" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M3,17 L9,11" /></svg>',
      facebook: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z" /></svg>',
      "file-edit": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M18.65,1.68 C18.41,1.45 18.109,1.33 17.81,1.33 C17.499,1.33 17.209,1.45 16.98,1.68 L8.92,9.76 L8,12.33 L10.55,11.41 L18.651,3.34 C19.12,2.87 19.12,2.15 18.65,1.68 L18.65,1.68 L18.65,1.68 Z" /> <polyline fill="none" stroke="#000" points="16.5 8.482 16.5 18.5 3.5 18.5 3.5 1.5 14.211 1.5" /></svg>',
      file: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="1.5" width="13" height="17" /></svg>',
      flickr: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="5.5" cy="9.5" r="3.5" /> <circle cx="14.5" cy="9.5" r="3.5" /></svg>',
      folder: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="9.5 5.5 8.5 3.5 1.5 3.5 1.5 16.5 18.5 16.5 18.5 5.5" /></svg>',
      forward: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M2.47,13.11 C4.02,10.02 6.27,7.85 9.04,6.61 C9.48,6.41 10.27,6.13 11,5.91 L11,2 L18.89,9 L11,16 L11,12.13 C9.25,12.47 7.58,13.19 6.02,14.25 C3.03,16.28 1.63,18.54 1.63,18.54 C1.63,18.54 1.38,15.28 2.47,13.11 L2.47,13.11 Z M5.3,13.53 C6.92,12.4 9.04,11.4 12,10.92 L12,13.63 L17.36,9 L12,4.25 L12,6.8 C11.71,6.86 10.86,7.02 9.67,7.49 C6.79,8.65 4.58,10.96 3.49,13.08 C3.18,13.7 2.68,14.87 2.49,16 C3.28,15.05 4.4,14.15 5.3,13.53 L5.3,13.53 Z" /></svg>',
      foursquare: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15.23,2 C15.96,2 16.4,2.41 16.5,2.86 C16.57,3.15 16.56,3.44 16.51,3.73 C16.46,4.04 14.86,11.72 14.75,12.03 C14.56,12.56 14.16,12.82 13.61,12.83 C13.03,12.84 11.09,12.51 10.69,13 C10.38,13.38 7.79,16.39 6.81,17.53 C6.61,17.76 6.4,17.96 6.08,17.99 C5.68,18.04 5.29,17.87 5.17,17.45 C5.12,17.28 5.1,17.09 5.1,16.91 C5.1,12.4 4.86,7.81 5.11,3.31 C5.17,2.5 5.81,2.12 6.53,2 L15.23,2 L15.23,2 Z M9.76,11.42 C9.94,11.19 10.17,11.1 10.45,11.1 L12.86,11.1 C13.12,11.1 13.31,10.94 13.36,10.69 C13.37,10.64 13.62,9.41 13.74,8.83 C13.81,8.52 13.53,8.28 13.27,8.28 C12.35,8.29 11.42,8.28 10.5,8.28 C9.84,8.28 9.83,7.69 9.82,7.21 C9.8,6.85 10.13,6.55 10.5,6.55 C11.59,6.56 12.67,6.55 13.76,6.55 C14.03,6.55 14.23,6.4 14.28,6.14 C14.34,5.87 14.67,4.29 14.67,4.29 C14.67,4.29 14.82,3.74 14.19,3.74 L7.34,3.74 C7,3.75 6.84,4.02 6.84,4.33 C6.84,7.58 6.85,14.95 6.85,14.99 C6.87,15 8.89,12.51 9.76,11.42 L9.76,11.42 Z" /></svg>',
      future: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline points="19 2 18 2 18 6 14 6 14 7 19 7 19 2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M18,6.548 C16.709,3.29 13.354,1 9.6,1 C4.6,1 0.6,5 0.6,10 C0.6,15 4.6,19 9.6,19 C14.6,19 18.6,15 18.6,10" /> <rect x="9" y="4" width="1" height="7" /> <path d="M13.018,14.197 L9.445,10.625" fill="none" stroke="#000" stroke-width="1.1" /></svg>',
      "git-branch": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.2" cx="7" cy="3" r="2" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="14" cy="6" r="2" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="7" cy="17" r="2" /> <path fill="none" stroke="#000" stroke-width="2" d="M14,8 C14,10.41 12.43,10.87 10.56,11.25 C9.09,11.54 7,12.06 7,15 L7,5" /></svg>',
      "git-fork": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.2" cx="5.79" cy="2.79" r="1.79" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="14.19" cy="2.79" r="1.79" /> <ellipse fill="none" stroke="#000" stroke-width="1.2" cx="10.03" cy="16.79" rx="1.79" ry="1.79" /> <path fill="none" stroke="#000" stroke-width="2" d="M5.79,4.57 L5.79,6.56 C5.79,9.19 10.03,10.22 10.03,13.31 C10.03,14.86 10.04,14.55 10.04,14.55 C10.04,14.37 10.04,14.86 10.04,13.31 C10.04,10.22 14.2,9.19 14.2,6.56 L14.2,4.57" /></svg>',
      "github-alt": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5 C4.75,0.5 0.5,4.76 0.5,10.01 C0.5,15.26 4.75,19.51 10,19.51 C15.24,19.51 19.5,15.26 19.5,10.01 C19.5,4.76 15.25,0.5 10,0.5 L10,0.5 Z M12.81,17.69 C12.81,17.69 12.81,17.7 12.79,17.69 C12.47,17.75 12.35,17.59 12.35,17.36 L12.35,16.17 C12.35,15.45 12.09,14.92 11.58,14.56 C12.2,14.51 12.77,14.39 13.26,14.21 C13.87,13.98 14.36,13.69 14.74,13.29 C15.42,12.59 15.76,11.55 15.76,10.17 C15.76,9.25 15.45,8.46 14.83,7.8 C15.1,7.08 15.07,6.29 14.75,5.44 L14.51,5.42 C14.34,5.4 14.06,5.46 13.67,5.61 C13.25,5.78 12.79,6.03 12.31,6.35 C11.55,6.16 10.81,6.05 10.09,6.05 C9.36,6.05 8.61,6.15 7.88,6.35 C7.28,5.96 6.75,5.68 6.26,5.54 C6.07,5.47 5.9,5.44 5.78,5.44 L5.42,5.44 C5.06,6.29 5.04,7.08 5.32,7.8 C4.7,8.46 4.4,9.25 4.4,10.17 C4.4,11.94 4.96,13.16 6.08,13.84 C6.53,14.13 7.05,14.32 7.69,14.43 C8.03,14.5 8.32,14.54 8.55,14.55 C8.07,14.89 7.82,15.42 7.82,16.16 L7.82,17.51 C7.8,17.69 7.7,17.8 7.51,17.8 C4.21,16.74 1.82,13.65 1.82,10.01 C1.82,5.5 5.49,1.83 10,1.83 C14.5,1.83 18.17,5.5 18.17,10.01 C18.18,13.53 15.94,16.54 12.81,17.69 L12.81,17.69 Z" /></svg>',
      github: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,1 C5.03,1 1,5.03 1,10 C1,13.98 3.58,17.35 7.16,18.54 C7.61,18.62 7.77,18.34 7.77,18.11 C7.77,17.9 7.76,17.33 7.76,16.58 C5.26,17.12 4.73,15.37 4.73,15.37 C4.32,14.33 3.73,14.05 3.73,14.05 C2.91,13.5 3.79,13.5 3.79,13.5 C4.69,13.56 5.17,14.43 5.17,14.43 C5.97,15.8 7.28,15.41 7.79,15.18 C7.87,14.6 8.1,14.2 8.36,13.98 C6.36,13.75 4.26,12.98 4.26,9.53 C4.26,8.55 4.61,7.74 5.19,7.11 C5.1,6.88 4.79,5.97 5.28,4.73 C5.28,4.73 6.04,4.49 7.75,5.65 C8.47,5.45 9.24,5.35 10,5.35 C10.76,5.35 11.53,5.45 12.25,5.65 C13.97,4.48 14.72,4.73 14.72,4.73 C15.21,5.97 14.9,6.88 14.81,7.11 C15.39,7.74 15.73,8.54 15.73,9.53 C15.73,12.99 13.63,13.75 11.62,13.97 C11.94,14.25 12.23,14.8 12.23,15.64 C12.23,16.84 12.22,17.81 12.22,18.11 C12.22,18.35 12.38,18.63 12.84,18.54 C16.42,17.35 19,13.98 19,10 C19,5.03 14.97,1 10,1 L10,1 Z" /></svg>',
      gitter: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="3.5" y="1" width="1.531" height="11.471" /> <rect x="7.324" y="4.059" width="1.529" height="15.294" /> <rect x="11.148" y="4.059" width="1.527" height="15.294" /> <rect x="14.971" y="4.059" width="1.529" height="8.412" /></svg>',
      "google-plus": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.9,9c0,2.7-0.6,5-3.2,6.3c-3.7,1.8-8.1,0.2-9.4-3.6C-1.1,7.6,1.9,3.3,6.1,3c1.7-0.1,3.2,0.3,4.6,1.3 c0.1,0.1,0.3,0.2,0.4,0.4c-0.5,0.5-1.2,1-1.7,1.6c-1-0.8-2.1-1.1-3.5-0.9C5,5.6,4.2,6,3.6,6.7c-1.3,1.3-1.5,3.4-0.5,5 c1,1.7,2.6,2.3,4.6,1.9c1.4-0.3,2.4-1.2,2.6-2.6H6.9V9H12.9z" /> <polygon points="20,9 20,11 18,11 18,13 16,13 16,11 14,11 14,9 16,9 16,7 18,7 18,9 " /></svg>',
      google: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.86,9.09 C18.46,12.12 17.14,16.05 13.81,17.56 C9.45,19.53 4.13,17.68 2.47,12.87 C0.68,7.68 4.22,2.42 9.5,2.03 C11.57,1.88 13.42,2.37 15.05,3.65 C15.22,3.78 15.37,3.93 15.61,4.14 C14.9,4.81 14.23,5.45 13.5,6.14 C12.27,5.08 10.84,4.72 9.28,4.98 C8.12,5.17 7.16,5.76 6.37,6.63 C4.88,8.27 4.62,10.86 5.76,12.82 C6.95,14.87 9.17,15.8 11.57,15.25 C13.27,14.87 14.76,13.33 14.89,11.75 L10.51,11.75 L10.51,9.09 L17.86,9.09 L17.86,9.09 Z" /></svg>',
      grid: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="2" y="2" width="3" height="3" /> <rect x="8" y="2" width="3" height="3" /> <rect x="14" y="2" width="3" height="3" /> <rect x="2" y="8" width="3" height="3" /> <rect x="8" y="8" width="3" height="3" /> <rect x="14" y="8" width="3" height="3" /> <rect x="2" y="14" width="3" height="3" /> <rect x="8" y="14" width="3" height="3" /> <rect x="14" y="14" width="3" height="3" /></svg>',
      happy: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="13" cy="7" r="1" /> <circle cx="7" cy="7" r="1" /> <circle fill="none" stroke="#000" cx="10" cy="10" r="8.5" /> <path fill="none" stroke="#000" d="M14.6,11.4 C13.9,13.3 12.1,14.5 10,14.5 C7.9,14.5 6.1,13.3 5.4,11.4" /></svg>',
      hashtag: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15.431,8 L15.661,7 L12.911,7 L13.831,3 L12.901,3 L11.98,7 L9.29,7 L10.21,3 L9.281,3 L8.361,7 L5.23,7 L5,8 L8.13,8 L7.21,12 L4.23,12 L4,13 L6.98,13 L6.061,17 L6.991,17 L7.911,13 L10.601,13 L9.681,17 L10.611,17 L11.531,13 L14.431,13 L14.661,12 L11.76,12 L12.681,8 L15.431,8 Z M10.831,12 L8.141,12 L9.061,8 L11.75,8 L10.831,12 Z" /></svg>',
      heart: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.03" d="M10,4 C10,4 8.1,2 5.74,2 C3.38,2 1,3.55 1,6.73 C1,8.84 2.67,10.44 2.67,10.44 L10,18 L17.33,10.44 C17.33,10.44 19,8.84 19,6.73 C19,3.55 16.62,2 14.26,2 C11.9,2 10,4 10,4 L10,4 Z" /></svg>',
      history: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="#000" points="1 2 2 2 2 6 6 6 6 7 1 7 1 2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M2.1,6.548 C3.391,3.29 6.746,1 10.5,1 C15.5,1 19.5,5 19.5,10 C19.5,15 15.5,19 10.5,19 C5.5,19 1.5,15 1.5,10" /> <rect x="9" y="4" width="1" height="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M13.018,14.197 L9.445,10.625" id="Shape" /></svg>',
      home: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="18.65 11.35 10 2.71 1.35 11.35 0.65 10.65 10 1.29 19.35 10.65" /> <polygon points="15 4 18 4 18 7 17 7 17 5 15 5" /> <polygon points="3 11 4 11 4 18 7 18 7 12 12 12 12 18 16 18 16 11 17 11 17 19 11 19 11 13 8 13 8 19 3 19" /></svg>',
      image: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="16.1" cy="6.1" r="1.1" /> <rect fill="none" stroke="#000" x="0.5" y="2.5" width="19" height="15" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="4,13 8,9 13,14" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="11,12 12.5,10.5 16,14" /></svg>',
      info: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.13,11.59 C11.97,12.84 10.35,14.12 9.1,14.16 C6.17,14.2 9.89,9.46 8.74,8.37 C9.3,8.16 10.62,7.83 10.62,8.81 C10.62,9.63 10.12,10.55 9.88,11.32 C8.66,15.16 12.13,11.15 12.14,11.18 C12.16,11.21 12.16,11.35 12.13,11.59 C12.08,11.95 12.16,11.35 12.13,11.59 L12.13,11.59 Z M11.56,5.67 C11.56,6.67 9.36,7.15 9.36,6.03 C9.36,5 11.56,4.54 11.56,5.67 L11.56,5.67 Z" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /></svg>',
      instagram: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M13.55,1H6.46C3.45,1,1,3.44,1,6.44v7.12c0,3,2.45,5.44,5.46,5.44h7.08c3.02,0,5.46-2.44,5.46-5.44V6.44 C19.01,3.44,16.56,1,13.55,1z M17.5,14c0,1.93-1.57,3.5-3.5,3.5H6c-1.93,0-3.5-1.57-3.5-3.5V6c0-1.93,1.57-3.5,3.5-3.5h8 c1.93,0,3.5,1.57,3.5,3.5V14z" /> <circle cx="14.87" cy="5.26" r="1.09" /> <path d="M10.03,5.45c-2.55,0-4.63,2.06-4.63,4.6c0,2.55,2.07,4.61,4.63,4.61c2.56,0,4.63-2.061,4.63-4.61 C14.65,7.51,12.58,5.45,10.03,5.45L10.03,5.45L10.03,5.45z M10.08,13c-1.66,0-3-1.34-3-2.99c0-1.65,1.34-2.99,3-2.99s3,1.34,3,2.99 C13.08,11.66,11.74,13,10.08,13L10.08,13L10.08,13z" /></svg>',
      italic: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.63,5.48 L10.15,14.52 C10,15.08 10.37,15.25 11.92,15.3 L11.72,16 L6,16 L6.2,15.31 C7.78,15.26 8.19,15.09 8.34,14.53 L10.82,5.49 C10.97,4.92 10.63,4.76 9.09,4.71 L9.28,4 L15,4 L14.81,4.69 C13.23,4.75 12.78,4.91 12.63,5.48 L12.63,5.48 Z" /></svg>',
      joomla: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M7.8,13.4l1.7-1.7L5.9,8c-0.6-0.5-0.6-1.5,0-2c0.6-0.6,1.4-0.6,2,0l1.7-1.7c-1-1-2.3-1.3-3.6-1C5.8,2.2,4.8,1.4,3.7,1.4 c-1.3,0-2.3,1-2.3,2.3c0,1.1,0.8,2,1.8,2.3c-0.4,1.3-0.1,2.8,1,3.8L7.8,13.4L7.8,13.4z" /> <path d="M10.2,4.3c1-1,2.5-1.4,3.8-1c0.2-1.1,1.1-2,2.3-2c1.3,0,2.3,1,2.3,2.3c0,1.2-0.9,2.2-2,2.3c0.4,1.3,0,2.8-1,3.8L13.9,8 c0.6-0.5,0.6-1.5,0-2c-0.5-0.6-1.5-0.6-2,0L8.2,9.7L6.5,8" /> <path d="M14.1,16.8c-1.3,0.4-2.8,0.1-3.8-1l1.7-1.7c0.6,0.6,1.5,0.6,2,0c0.5-0.6,0.6-1.5,0-2l-3.7-3.7L12,6.7l3.7,3.7 c1,1,1.3,2.4,1,3.6c1.1,0.2,2,1.1,2,2.3c0,1.3-1,2.3-2.3,2.3C15.2,18.6,14.3,17.8,14.1,16.8" /> <path d="M13.2,12.2l-3.7,3.7c-1,1-2.4,1.3-3.6,1c-0.2,1-1.2,1.8-2.2,1.8c-1.3,0-2.3-1-2.3-2.3c0-1.1,0.8-2,1.8-2.3 c-0.3-1.3,0-2.7,1-3.7l1.7,1.7c-0.6,0.6-0.6,1.5,0,2c0.6,0.6,1.4,0.6,2,0l3.7-3.7" /></svg>',
      laptop: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect y="16" width="20" height="1" /> <rect fill="none" stroke="#000" x="2.5" y="4.5" width="15" height="10" /></svg>',
      lifesaver: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5 C4.76,0.5 0.5,4.76 0.5,10 C0.5,15.24 4.76,19.5 10,19.5 C15.24,19.5 19.5,15.24 19.5,10 C19.5,4.76 15.24,0.5 10,0.5 L10,0.5 Z M10,1.5 C11.49,1.5 12.89,1.88 14.11,2.56 L11.85,4.82 C11.27,4.61 10.65,4.5 10,4.5 C9.21,4.5 8.47,4.67 7.79,4.96 L5.58,2.75 C6.87,1.95 8.38,1.5 10,1.5 L10,1.5 Z M4.96,7.8 C4.67,8.48 4.5,9.21 4.5,10 C4.5,10.65 4.61,11.27 4.83,11.85 L2.56,14.11 C1.88,12.89 1.5,11.49 1.5,10 C1.5,8.38 1.95,6.87 2.75,5.58 L4.96,7.79 L4.96,7.8 L4.96,7.8 Z M10,18.5 C8.25,18.5 6.62,17.97 5.27,17.06 L7.46,14.87 C8.22,15.27 9.08,15.5 10,15.5 C10.79,15.5 11.53,15.33 12.21,15.04 L14.42,17.25 C13.13,18.05 11.62,18.5 10,18.5 L10,18.5 Z M10,14.5 C7.52,14.5 5.5,12.48 5.5,10 C5.5,7.52 7.52,5.5 10,5.5 C12.48,5.5 14.5,7.52 14.5,10 C14.5,12.48 12.48,14.5 10,14.5 L10,14.5 Z M15.04,12.21 C15.33,11.53 15.5,10.79 15.5,10 C15.5,9.08 15.27,8.22 14.87,7.46 L17.06,5.27 C17.97,6.62 18.5,8.25 18.5,10 C18.5,11.62 18.05,13.13 17.25,14.42 L15.04,12.21 L15.04,12.21 Z" /></svg>',
      link: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M10.625,12.375 L7.525,15.475 C6.825,16.175 5.925,16.175 5.225,15.475 L4.525,14.775 C3.825,14.074 3.825,13.175 4.525,12.475 L7.625,9.375" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M9.325,7.375 L12.425,4.275 C13.125,3.575 14.025,3.575 14.724,4.275 L15.425,4.975 C16.125,5.675 16.125,6.575 15.425,7.275 L12.325,10.375" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M7.925,11.875 L11.925,7.975" /></svg>',
      linkedin: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M5.77,17.89 L5.77,7.17 L2.21,7.17 L2.21,17.89 L5.77,17.89 L5.77,17.89 Z M3.99,5.71 C5.23,5.71 6.01,4.89 6.01,3.86 C5.99,2.8 5.24,2 4.02,2 C2.8,2 2,2.8 2,3.85 C2,4.88 2.77,5.7 3.97,5.7 L3.99,5.7 L3.99,5.71 L3.99,5.71 Z" /> <path d="M7.75,17.89 L11.31,17.89 L11.31,11.9 C11.31,11.58 11.33,11.26 11.43,11.03 C11.69,10.39 12.27,9.73 13.26,9.73 C14.55,9.73 15.06,10.71 15.06,12.15 L15.06,17.89 L18.62,17.89 L18.62,11.74 C18.62,8.45 16.86,6.92 14.52,6.92 C12.6,6.92 11.75,7.99 11.28,8.73 L11.3,8.73 L11.3,7.17 L7.75,7.17 C7.79,8.17 7.75,17.89 7.75,17.89 L7.75,17.89 L7.75,17.89 Z" /></svg>',
      list: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="6" y="4" width="12" height="1" /> <rect x="6" y="9" width="12" height="1" /> <rect x="6" y="14" width="12" height="1" /> <rect x="2" y="4" width="2" height="1" /> <rect x="2" y="9" width="2" height="1" /> <rect x="2" y="14" width="2" height="1" /></svg>',
      location: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.01" d="M10,0.5 C6.41,0.5 3.5,3.39 3.5,6.98 C3.5,11.83 10,19 10,19 C10,19 16.5,11.83 16.5,6.98 C16.5,3.39 13.59,0.5 10,0.5 L10,0.5 Z" /> <circle fill="none" stroke="#000" cx="10" cy="6.8" r="2.3" /></svg>',
      lock: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" height="10" width="13" y="8.5" x="3.5" /> <path fill="none" stroke="#000" d="M6.5,8 L6.5,4.88 C6.5,3.01 8.07,1.5 10,1.5 C11.93,1.5 13.5,3.01 13.5,4.88 L13.5,8" /></svg>',
      mail: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5" /> <path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z" /></svg>',
      menu: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="2" y="4" width="16" height="1" /> <rect x="2" y="9" width="16" height="1" /> <rect x="2" y="14" width="16" height="1" /></svg>',
      "minus-circle": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9" /> <line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5" /></svg>',
      minus: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect height="1" width="18" y="9" x="1" /></svg>',
      "more-vertical": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="10" cy="3" r="2" /> <circle cx="10" cy="10" r="2" /> <circle cx="10" cy="17" r="2" /></svg>',
      more: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="3" cy="10" r="2" /> <circle cx="10" cy="10" r="2" /> <circle cx="17" cy="10" r="2" /></svg>',
      move: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="4,5 1,5 1,9 2,9 2,6 4,6 " /> <polygon points="1,16 2,16 2,18 4,18 4,19 1,19 " /> <polygon points="14,16 14,19 11,19 11,18 13,18 13,16 " /> <rect fill="none" stroke="#000" x="5.5" y="1.5" width="13" height="13" /> <rect x="1" y="11" width="1" height="3" /> <rect x="6" y="18" width="3" height="1" /></svg>',
      nut: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="2.5,5.7 10,1.3 17.5,5.7 17.5,14.3 10,18.7 2.5,14.3" /> <circle fill="none" stroke="#000" cx="10" cy="10" r="3.5" /></svg>',
      pagekit: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="3,1 17,1 17,16 10,16 10,13 14,13 14,4 6,4 6,16 10,16 10,19 3,19 " /></svg>',
      "paint-bucket": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10.21,1 L0,11.21 L8.1,19.31 L18.31,9.1 L10.21,1 L10.21,1 Z M16.89,9.1 L15,11 L1.7,11 L10.21,2.42 L16.89,9.1 Z" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.42,2.33 L11.7,7.61" /> <path d="M18.49,12 C18.49,12 20,14.06 20,15.36 C20,16.28 19.24,17 18.49,17 L18.49,17 C17.74,17 17,16.28 17,15.36 C17,14.06 18.49,12 18.49,12 L18.49,12 Z" /></svg>',
      pencil: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M17.25,6.01 L7.12,16.1 L3.82,17.2 L5.02,13.9 L15.12,3.88 C15.71,3.29 16.66,3.29 17.25,3.88 C17.83,4.47 17.83,5.42 17.25,6.01 L17.25,6.01 Z" /> <path fill="none" stroke="#000" d="M15.98,7.268 L13.851,5.148" /></svg>',
      "phone-landscape": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M17,5.5 C17.8,5.5 18.5,6.2 18.5,7 L18.5,14 C18.5,14.8 17.8,15.5 17,15.5 L3,15.5 C2.2,15.5 1.5,14.8 1.5,14 L1.5,7 C1.5,6.2 2.2,5.5 3,5.5 L17,5.5 L17,5.5 L17,5.5 Z" /> <circle cx="3.8" cy="10.5" r="0.8" /></svg>',
      phone: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M15.5,17 C15.5,17.8 14.8,18.5 14,18.5 L7,18.5 C6.2,18.5 5.5,17.8 5.5,17 L5.5,3 C5.5,2.2 6.2,1.5 7,1.5 L14,1.5 C14.8,1.5 15.5,2.2 15.5,3 L15.5,17 L15.5,17 L15.5,17 Z" /> <circle cx="10.5" cy="16.5" r="0.8" /></svg>',
      pinterest: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10.21,1 C5.5,1 3,4.16 3,7.61 C3,9.21 3.85,11.2 5.22,11.84 C5.43,11.94 5.54,11.89 5.58,11.69 C5.62,11.54 5.8,10.8 5.88,10.45 C5.91,10.34 5.89,10.24 5.8,10.14 C5.36,9.59 5,8.58 5,7.65 C5,5.24 6.82,2.91 9.93,2.91 C12.61,2.91 14.49,4.74 14.49,7.35 C14.49,10.3 13,12.35 11.06,12.35 C9.99,12.35 9.19,11.47 9.44,10.38 C9.75,9.08 10.35,7.68 10.35,6.75 C10.35,5.91 9.9,5.21 8.97,5.21 C7.87,5.21 6.99,6.34 6.99,7.86 C6.99,8.83 7.32,9.48 7.32,9.48 C7.32,9.48 6.24,14.06 6.04,14.91 C5.7,16.35 6.08,18.7 6.12,18.9 C6.14,19.01 6.26,19.05 6.33,18.95 C6.44,18.81 7.74,16.85 8.11,15.44 C8.24,14.93 8.79,12.84 8.79,12.84 C9.15,13.52 10.19,14.09 11.29,14.09 C14.58,14.09 16.96,11.06 16.96,7.3 C16.94,3.7 14,1 10.21,1" /></svg>',
      "play-circle": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" stroke-width="1.1" points="8.5 7 13.5 10 8.5 13" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /></svg>',
      play: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="6.5,5 14.5,10 6.5,15" /></svg>',
      "plus-circle": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9" /> <line fill="none" stroke="#000" x1="9.5" y1="5" x2="9.5" y2="14" /> <line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5" /></svg>',
      plus: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="9" y="1" width="1" height="17" /> <rect x="1" y="9" width="17" height="1" /></svg>',
      pull: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="6.85,8 9.5,10.6 12.15,8 12.85,8.7 9.5,12 6.15,8.7" /> <line fill="none" stroke="#000" x1="9.5" y1="11" x2="9.5" y2="2" /> <polyline fill="none" stroke="#000" points="6,5.5 3.5,5.5 3.5,18.5 15.5,18.5 15.5,5.5 13,5.5" /></svg>',
      push: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="12.15,4 9.5,1.4 6.85,4 6.15,3.3 9.5,0 12.85,3.3" /> <line fill="none" stroke="#000" x1="9.5" y1="10" x2="9.5" y2="1" /> <polyline fill="none" stroke="#000" points="6 5.5 3.5 5.5 3.5 18.5 15.5 18.5 15.5 5.5 13 5.5" /></svg>',
      question: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <circle cx="10.44" cy="14.42" r="1.05" /> <path fill="none" stroke="#000" stroke-width="1.2" d="M8.17,7.79 C8.17,4.75 12.72,4.73 12.72,7.72 C12.72,8.67 11.81,9.15 11.23,9.75 C10.75,10.24 10.51,10.73 10.45,11.4 C10.44,11.53 10.43,11.64 10.43,11.75" /></svg>',
      "quote-right": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.27,7.79 C17.27,9.45 16.97,10.43 15.99,12.02 C14.98,13.64 13,15.23 11.56,15.97 L11.1,15.08 C12.34,14.2 13.14,13.51 14.02,11.82 C14.27,11.34 14.41,10.92 14.49,10.54 C14.3,10.58 14.09,10.6 13.88,10.6 C12.06,10.6 10.59,9.12 10.59,7.3 C10.59,5.48 12.06,4 13.88,4 C15.39,4 16.67,5.02 17.05,6.42 C17.19,6.82 17.27,7.27 17.27,7.79 L17.27,7.79 Z" /> <path d="M8.68,7.79 C8.68,9.45 8.38,10.43 7.4,12.02 C6.39,13.64 4.41,15.23 2.97,15.97 L2.51,15.08 C3.75,14.2 4.55,13.51 5.43,11.82 C5.68,11.34 5.82,10.92 5.9,10.54 C5.71,10.58 5.5,10.6 5.29,10.6 C3.47,10.6 2,9.12 2,7.3 C2,5.48 3.47,4 5.29,4 C6.8,4 8.08,5.02 8.46,6.42 C8.6,6.82 8.68,7.27 8.68,7.79 L8.68,7.79 Z" /></svg>',
      receiver: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.01" d="M6.189,13.611C8.134,15.525 11.097,18.239 13.867,18.257C16.47,18.275 18.2,16.241 18.2,16.241L14.509,12.551L11.539,13.639L6.189,8.29L7.313,5.355L3.76,1.8C3.76,1.8 1.732,3.537 1.7,6.092C1.667,8.809 4.347,11.738 6.189,13.611" /></svg>',
      refresh: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17.08,11.15 C17.09,11.31 17.1,11.47 17.1,11.64 C17.1,15.53 13.94,18.69 10.05,18.69 C6.16,18.68 3,15.53 3,11.63 C3,7.74 6.16,4.58 10.05,4.58 C10.9,4.58 11.71,4.73 12.46,5" /> <polyline fill="none" stroke="#000" points="9.9 2 12.79 4.89 9.79 7.9" /></svg>',
      reply: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.7,13.11 C16.12,10.02 13.84,7.85 11.02,6.61 C10.57,6.41 9.75,6.13 9,5.91 L9,2 L1,9 L9,16 L9,12.13 C10.78,12.47 12.5,13.19 14.09,14.25 C17.13,16.28 18.56,18.54 18.56,18.54 C18.56,18.54 18.81,15.28 17.7,13.11 L17.7,13.11 Z M14.82,13.53 C13.17,12.4 11.01,11.4 8,10.92 L8,13.63 L2.55,9 L8,4.25 L8,6.8 C8.3,6.86 9.16,7.02 10.37,7.49 C13.3,8.65 15.54,10.96 16.65,13.08 C16.97,13.7 17.48,14.86 17.68,16 C16.87,15.05 15.73,14.15 14.82,13.53 L14.82,13.53 Z" /></svg>',
      rss: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="3.12" cy="16.8" r="1.85" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,8.2 C1.78,8.18 2.06,8.16 2.35,8.16 C7.57,8.16 11.81,12.37 11.81,17.57 C11.81,17.89 11.79,18.19 11.76,18.5" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,2.52 C1.78,2.51 2.06,2.5 2.35,2.5 C10.72,2.5 17.5,9.24 17.5,17.57 C17.5,17.89 17.49,18.19 17.47,18.5" /></svg>',
      search: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9" cy="9" r="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M14,14 L18,18 L14,14 Z" /></svg>',
      server: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="3" y="3" width="1" height="2" /> <rect x="5" y="3" width="1" height="2" /> <rect x="7" y="3" width="1" height="2" /> <rect x="16" y="3" width="1" height="1" /> <rect x="16" y="10" width="1" height="1" /> <circle fill="none" stroke="#000" cx="9.9" cy="17.4" r="1.4" /> <rect x="3" y="10" width="1" height="2" /> <rect x="5" y="10" width="1" height="2" /> <rect x="9.5" y="14" width="1" height="2" /> <rect x="3" y="17" width="6" height="1" /> <rect x="11" y="17" width="6" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="1.5" width="17" height="5" /> <rect fill="none" stroke="#000" x="1.5" y="8.5" width="17" height="5" /></svg>',
      settings: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <ellipse fill="none" stroke="#000" cx="6.11" cy="3.55" rx="2.11" ry="2.15" /> <ellipse fill="none" stroke="#000" cx="6.11" cy="15.55" rx="2.11" ry="2.15" /> <circle fill="none" stroke="#000" cx="13.15" cy="9.55" r="2.15" /> <rect x="1" y="3" width="3" height="1" /> <rect x="10" y="3" width="8" height="1" /> <rect x="1" y="9" width="8" height="1" /> <rect x="15" y="9" width="3" height="1" /> <rect x="1" y="15" width="3" height="1" /> <rect x="10" y="15" width="8" height="1" /></svg>',
      shrink: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="11 4 12 4 12 8 16 8 16 9 11 9" /> <polygon points="4 11 9 11 9 16 8 16 8 12 4 12" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M12,8 L18,2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M2,18 L8,12" /></svg>',
      "sign-in": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="7 2 17 2 17 17 7 17 7 16 16 16 16 3 7 3" /> <polygon points="9.1 13.4 8.5 12.8 11.28 10 4 10 4 9 11.28 9 8.5 6.2 9.1 5.62 13 9.5" /></svg>',
      "sign-out": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="13.1 13.4 12.5 12.8 15.28 10 8 10 8 9 15.28 9 12.5 6.2 13.1 5.62 17 9.5" /> <polygon points="13 2 3 2 3 17 13 17 13 16 4 16 4 3 13 3" /></svg>',
      social: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <line fill="none" stroke="#000" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7" /> <line fill="none" stroke="#000" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3" /></svg>',
      soundcloud: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.2,9.4c-0.4,0-0.8,0.1-1.101,0.2c-0.199-2.5-2.399-4.5-5-4.5c-0.6,0-1.2,0.1-1.7,0.3C9.2,5.5,9.1,5.6,9.1,5.6V15h8 c1.601,0,2.801-1.2,2.801-2.8C20,10.7,18.7,9.4,17.2,9.4L17.2,9.4z" /> <rect x="6" y="6.5" width="1.5" height="8.5" /> <rect x="3" y="8" width="1.5" height="7" /> <rect y="10" width="1.5" height="5" /></svg>',
      star: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" stroke-width="1.01" points="10 2 12.63 7.27 18.5 8.12 14.25 12.22 15.25 18 10 15.27 4.75 18 5.75 12.22 1.5 8.12 7.37 7.27" /></svg>',
      strikethrough: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6,13.02 L6.65,13.02 C7.64,15.16 8.86,16.12 10.41,16.12 C12.22,16.12 12.92,14.93 12.92,13.89 C12.92,12.55 11.99,12.03 9.74,11.23 C8.05,10.64 6.23,10.11 6.23,7.83 C6.23,5.5 8.09,4.09 10.4,4.09 C11.44,4.09 12.13,4.31 12.72,4.54 L13.33,4 L13.81,4 L13.81,7.59 L13.16,7.59 C12.55,5.88 11.52,4.89 10.07,4.89 C8.84,4.89 7.89,5.69 7.89,7.03 C7.89,8.29 8.89,8.78 10.88,9.45 C12.57,10.03 14.38,10.6 14.38,12.91 C14.38,14.75 13.27,16.93 10.18,16.93 C9.18,16.93 8.17,16.69 7.46,16.39 L6.52,17 L6,17 L6,13.02 L6,13.02 Z" /> <rect x="3" y="10" width="15" height="1" /></svg>',
      table: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="1" y="3" width="18" height="1" /> <rect x="1" y="7" width="18" height="1" /> <rect x="1" y="11" width="18" height="1" /> <rect x="1" y="15" width="18" height="1" /></svg>',
      "tablet-landscape": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M1.5,5 C1.5,4.2 2.2,3.5 3,3.5 L17,3.5 C17.8,3.5 18.5,4.2 18.5,5 L18.5,16 C18.5,16.8 17.8,17.5 17,17.5 L3,17.5 C2.2,17.5 1.5,16.8 1.5,16 L1.5,5 L1.5,5 L1.5,5 Z" /> <circle cx="3.7" cy="10.5" r="0.8" /></svg>',
      tablet: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M5,18.5 C4.2,18.5 3.5,17.8 3.5,17 L3.5,3 C3.5,2.2 4.2,1.5 5,1.5 L16,1.5 C16.8,1.5 17.5,2.2 17.5,3 L17.5,17 C17.5,17.8 16.8,18.5 16,18.5 L5,18.5 L5,18.5 L5,18.5 Z" /> <circle cx="10.5" cy="16.3" r="0.8" /></svg>',
      tag: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17.5,3.71 L17.5,7.72 C17.5,7.96 17.4,8.2 17.21,8.39 L8.39,17.2 C7.99,17.6 7.33,17.6 6.93,17.2 L2.8,13.07 C2.4,12.67 2.4,12.01 2.8,11.61 L11.61,2.8 C11.81,2.6 12.08,2.5 12.34,2.5 L16.19,2.5 C16.52,2.5 16.86,2.63 17.11,2.88 C17.35,3.11 17.48,3.4 17.5,3.71 L17.5,3.71 Z" /> <circle cx="14" cy="6" r="1" /></svg>',
      thumbnails: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="3.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="11.5" y="3.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="11.5" y="11.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="3.5" y="11.5" width="5" height="5" /></svg>',
      trash: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="6.5 3 6.5 1.5 13.5 1.5 13.5 3" /> <polyline fill="none" stroke="#000" points="4.5 4 4.5 18.5 15.5 18.5 15.5 4" /> <rect x="8" y="7" width="1" height="9" /> <rect x="11" y="7" width="1" height="9" /> <rect x="2" y="3" width="16" height="1" /></svg>',
      "triangle-down": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="5 7 15 7 10 12" /></svg>',
      "triangle-left": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="12 5 7 10 12 15" /></svg>',
      "triangle-right": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="8 5 13 10 8 15" /></svg>',
      "triangle-up": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="5 13 10 8 15 13" /></svg>',
      tripadvisor: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M19.021,7.866C19.256,6.862,20,5.854,20,5.854h-3.346C14.781,4.641,12.504,4,9.98,4C7.363,4,4.999,4.651,3.135,5.876H0\tc0,0,0.738,0.987,0.976,1.988c-0.611,0.837-0.973,1.852-0.973,2.964c0,2.763,2.249,5.009,5.011,5.009\tc1.576,0,2.976-0.737,3.901-1.879l1.063,1.599l1.075-1.615c0.475,0.611,1.1,1.111,1.838,1.451c1.213,0.547,2.574,0.612,3.825,0.15\tc2.589-0.963,3.913-3.852,2.964-6.439c-0.175-0.463-0.4-0.876-0.675-1.238H19.021z M16.38,14.594\tc-1.002,0.371-2.088,0.328-3.06-0.119c-0.688-0.317-1.252-0.817-1.657-1.438c-0.164-0.25-0.313-0.52-0.417-0.811\tc-0.124-0.328-0.186-0.668-0.217-1.014c-0.063-0.689,0.037-1.396,0.339-2.043c0.448-0.971,1.251-1.71,2.25-2.079\tc2.075-0.765,4.375,0.3,5.14,2.366c0.762,2.066-0.301,4.37-2.363,5.134L16.38,14.594L16.38,14.594z M8.322,13.066\tc-0.72,1.059-1.935,1.76-3.309,1.76c-2.207,0-4.001-1.797-4.001-3.996c0-2.203,1.795-4.002,4.001-4.002\tc2.204,0,3.999,1.8,3.999,4.002c0,0.137-0.024,0.261-0.04,0.396c-0.067,0.678-0.284,1.313-0.648,1.853v-0.013H8.322z M2.472,10.775\tc0,1.367,1.112,2.479,2.476,2.479c1.363,0,2.472-1.11,2.472-2.479c0-1.359-1.11-2.468-2.472-2.468\tC3.584,8.306,2.473,9.416,2.472,10.775L2.472,10.775z M12.514,10.775c0,1.367,1.104,2.479,2.471,2.479\tc1.363,0,2.474-1.108,2.474-2.479c0-1.359-1.11-2.468-2.474-2.468c-1.364,0-2.477,1.109-2.477,2.468H12.514z M3.324,10.775\tc0-0.893,0.726-1.618,1.614-1.618c0.889,0,1.625,0.727,1.625,1.618c0,0.898-0.725,1.627-1.625,1.627\tc-0.901,0-1.625-0.729-1.625-1.627H3.324z M13.354,10.775c0-0.893,0.726-1.618,1.627-1.618c0.886,0,1.61,0.727,1.61,1.618\tc0,0.898-0.726,1.627-1.626,1.627s-1.625-0.729-1.625-1.627H13.354z M9.977,4.875c1.798,0,3.425,0.324,4.849,0.968\tc-0.535,0.015-1.061,0.108-1.586,0.3c-1.264,0.463-2.264,1.388-2.815,2.604c-0.262,0.551-0.398,1.133-0.448,1.72\tC9.79,7.905,7.677,5.873,5.076,5.82C6.501,5.208,8.153,4.875,9.94,4.875H9.977z" /></svg>',
      tumblr: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6.885,8.598c0,0,0,3.393,0,4.996c0,0.282,0,0.66,0.094,0.942c0.377,1.509,1.131,2.545,2.545,3.11 c1.319,0.472,2.356,0.472,3.676,0c0.565-0.188,1.132-0.659,1.132-0.659l-0.849-2.263c0,0-1.036,0.378-1.603,0.283 c-0.565-0.094-1.226-0.66-1.226-1.508c0-1.603,0-4.902,0-4.902h2.828V5.771h-2.828V2H8.205c0,0-0.094,0.66-0.188,0.942 C7.828,3.791,7.262,4.733,6.603,5.394C5.848,6.147,5,6.43,5,6.43v2.168H6.885z" /></svg>',
      tv: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="7" y="16" width="6" height="1" /> <rect fill="none" stroke="#000" x="0.5" y="3.5" width="19" height="11" /></svg>',
      twitter: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M19,4.74 C18.339,5.029 17.626,5.229 16.881,5.32 C17.644,4.86 18.227,4.139 18.503,3.28 C17.79,3.7 17.001,4.009 16.159,4.17 C15.485,3.45 14.526,3 13.464,3 C11.423,3 9.771,4.66 9.771,6.7 C9.771,6.99 9.804,7.269 9.868,7.539 C6.795,7.38 4.076,5.919 2.254,3.679 C1.936,4.219 1.754,4.86 1.754,5.539 C1.754,6.82 2.405,7.95 3.397,8.61 C2.79,8.589 2.22,8.429 1.723,8.149 L1.723,8.189 C1.723,9.978 2.997,11.478 4.686,11.82 C4.376,11.899 4.049,11.939 3.713,11.939 C3.475,11.939 3.245,11.919 3.018,11.88 C3.49,13.349 4.852,14.419 6.469,14.449 C5.205,15.429 3.612,16.019 1.882,16.019 C1.583,16.019 1.29,16.009 1,15.969 C2.635,17.019 4.576,17.629 6.662,17.629 C13.454,17.629 17.17,12 17.17,7.129 C17.17,6.969 17.166,6.809 17.157,6.649 C17.879,6.129 18.504,5.478 19,4.74" /></svg>',
      uikit: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="14.4,3.1 11.3,5.1 15,7.3 15,12.9 10,15.7 5,12.9 5,8.5 2,6.8 2,14.8 9.9,19.5 18,14.8 18,5.3" /> <polygon points="9.8,4.2 6.7,2.4 9.8,0.4 12.9,2.3" /></svg>',
      unlock: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="8.5" width="13" height="10" /> <path fill="none" stroke="#000" d="M6.5,8.5 L6.5,4.9 C6.5,3 8.1,1.5 10,1.5 C11.9,1.5 13.5,3 13.5,4.9" /></svg>',
      upload: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="5 8 9.5 3.5 14 8 " /> <rect x="3" y="17" width="13" height="1" /> <line fill="none" stroke="#000" x1="9.5" y1="15" x2="9.5" y2="4" /></svg>',
      user: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.9" cy="6.4" r="4.4" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,19 C2.3,14.5 5.8,11.2 10,11.2 C14.2,11.2 17.7,14.6 18.5,19.2" /></svg>',
      users: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="7.7" cy="8.6" r="3.5" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1,18.1 C1.7,14.6 4.4,12.1 7.6,12.1 C10.9,12.1 13.7,14.8 14.3,18.3" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M11.4,4 C12.8,2.4 15.4,2.8 16.3,4.7 C17.2,6.6 15.7,8.9 13.6,8.9 C16.5,8.9 18.8,11.3 19.2,14.1" /></svg>',
      "video-camera": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="18,6 18,14 12,10 " /> <rect x="2" y="5" width="12" height="10" /></svg>',
      vimeo: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M2.065,7.59C1.84,7.367,1.654,7.082,1.468,6.838c-0.332-0.42-0.137-0.411,0.274-0.772c1.026-0.91,2.004-1.896,3.127-2.688 c1.017-0.713,2.365-1.173,3.286-0.039c0.849,1.045,0.869,2.629,1.084,3.891c0.215,1.309,0.421,2.648,0.88,3.901 c0.127,0.352,0.37,1.018,0.81,1.074c0.567,0.078,1.145-0.917,1.408-1.289c0.684-0.987,1.611-2.317,1.494-3.587 c-0.115-1.349-1.572-1.095-2.482-0.773c0.146-1.514,1.555-3.216,2.912-3.792c1.439-0.597,3.579-0.587,4.302,1.036 c0.772,1.759,0.078,3.802-0.763,5.396c-0.918,1.731-2.1,3.333-3.363,4.829c-1.114,1.329-2.432,2.787-4.093,3.422 c-1.897,0.723-3.021-0.686-3.667-2.318c-0.705-1.777-1.056-3.771-1.565-5.621C4.898,8.726,4.644,7.836,4.136,7.191 C3.473,6.358,2.72,7.141,2.065,7.59C1.977,7.502,2.115,7.551,2.065,7.59L2.065,7.59z" /></svg>',
      warning: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="10" cy="14" r="1" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <path d="M10.97,7.72 C10.85,9.54 10.56,11.29 10.56,11.29 C10.51,11.87 10.27,12 9.99,12 C9.69,12 9.49,11.87 9.43,11.29 C9.43,11.29 9.16,9.54 9.03,7.72 C8.96,6.54 9.03,6 9.03,6 C9.03,5.45 9.46,5.02 9.99,5 C10.53,5.01 10.97,5.44 10.97,6 C10.97,6 11.04,6.54 10.97,7.72 L10.97,7.72 Z" /></svg>',
      whatsapp: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M16.7,3.3c-1.8-1.8-4.1-2.8-6.7-2.8c-5.2,0-9.4,4.2-9.4,9.4c0,1.7,0.4,3.3,1.3,4.7l-1.3,4.9l5-1.3c1.4,0.8,2.9,1.2,4.5,1.2 l0,0l0,0c5.2,0,9.4-4.2,9.4-9.4C19.5,7.4,18.5,5,16.7,3.3 M10.1,17.7L10.1,17.7c-1.4,0-2.8-0.4-4-1.1l-0.3-0.2l-3,0.8l0.8-2.9 l-0.2-0.3c-0.8-1.2-1.2-2.7-1.2-4.2c0-4.3,3.5-7.8,7.8-7.8c2.1,0,4.1,0.8,5.5,2.3c1.5,1.5,2.3,3.4,2.3,5.5 C17.9,14.2,14.4,17.7,10.1,17.7 M14.4,11.9c-0.2-0.1-1.4-0.7-1.6-0.8c-0.2-0.1-0.4-0.1-0.5,0.1c-0.2,0.2-0.6,0.8-0.8,0.9 c-0.1,0.2-0.3,0.2-0.5,0.1c-0.2-0.1-1-0.4-1.9-1.2c-0.7-0.6-1.2-1.4-1.3-1.6c-0.1-0.2,0-0.4,0.1-0.5C8,8.8,8.1,8.7,8.2,8.5 c0.1-0.1,0.2-0.2,0.2-0.4c0.1-0.2,0-0.3,0-0.4C8.4,7.6,7.9,6.5,7.7,6C7.5,5.5,7.3,5.6,7.2,5.6c-0.1,0-0.3,0-0.4,0 c-0.2,0-0.4,0.1-0.6,0.3c-0.2,0.2-0.8,0.8-0.8,2c0,1.2,0.8,2.3,1,2.4c0.1,0.2,1.7,2.5,4,3.5c0.6,0.2,1,0.4,1.3,0.5 c0.6,0.2,1.1,0.2,1.5,0.1c0.5-0.1,1.4-0.6,1.6-1.1c0.2-0.5,0.2-1,0.1-1.1C14.8,12.1,14.6,12,14.4,11.9" /></svg>',
      wordpress: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5c-5.2,0-9.5,4.3-9.5,9.5s4.3,9.5,9.5,9.5c5.2,0,9.5-4.3,9.5-9.5S15.2,0.5,10,0.5L10,0.5L10,0.5z M15.6,3.9h-0.1 c-0.8,0-1.4,0.7-1.4,1.5c0,0.7,0.4,1.3,0.8,1.9c0.3,0.6,0.7,1.3,0.7,2.3c0,0.7-0.3,1.5-0.6,2.7L14.1,15l-3-8.9 c0.5,0,0.9-0.1,0.9-0.1C12.5,6,12.5,5.3,12,5.4c0,0-1.3,0.1-2.2,0.1C9,5.5,7.7,5.4,7.7,5.4C7.2,5.3,7.2,6,7.6,6c0,0,0.4,0.1,0.9,0.1 l1.3,3.5L8,15L5,6.1C5.5,6.1,5.9,6,5.9,6C6.4,6,6.3,5.3,5.9,5.4c0,0-1.3,0.1-2.2,0.1c-0.2,0-0.3,0-0.5,0c1.5-2.2,4-3.7,6.9-3.7 C12.2,1.7,14.1,2.6,15.6,3.9L15.6,3.9L15.6,3.9z M2.5,6.6l3.9,10.8c-2.7-1.3-4.6-4.2-4.6-7.4C1.8,8.8,2,7.6,2.5,6.6L2.5,6.6L2.5,6.6 z M10.2,10.7l2.5,6.9c0,0,0,0.1,0.1,0.1C11.9,18,11,18.2,10,18.2c-0.8,0-1.6-0.1-2.3-0.3L10.2,10.7L10.2,10.7L10.2,10.7z M14.2,17.1 l2.5-7.3c0.5-1.2,0.6-2.1,0.6-2.9c0-0.3,0-0.6-0.1-0.8c0.6,1.2,1,2.5,1,4C18.3,13,16.6,15.7,14.2,17.1L14.2,17.1L14.2,17.1z" /></svg>',
      world: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M1,10.5 L19,10.5" /> <path fill="none" stroke="#000" d="M2.35,15.5 L17.65,15.5" /> <path fill="none" stroke="#000" d="M2.35,5.5 L17.523,5.5" /> <path fill="none" stroke="#000" d="M10,19.46 L9.98,19.46 C7.31,17.33 5.61,14.141 5.61,10.58 C5.61,7.02 7.33,3.83 10,1.7 C10.01,1.7 9.99,1.7 10,1.7 L10,1.7 C12.67,3.83 14.4,7.02 14.4,10.58 C14.4,14.141 12.67,17.33 10,19.46 L10,19.46 L10,19.46 L10,19.46 Z" /> <circle fill="none" stroke="#000" cx="10" cy="10.5" r="9" /></svg>',
      xing: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M4.4,4.56 C4.24,4.56 4.11,4.61 4.05,4.72 C3.98,4.83 3.99,4.97 4.07,5.12 L5.82,8.16 L5.82,8.17 L3.06,13.04 C2.99,13.18 2.99,13.33 3.06,13.44 C3.12,13.55 3.24,13.62 3.4,13.62 L6,13.62 C6.39,13.62 6.57,13.36 6.71,13.12 C6.71,13.12 9.41,8.35 9.51,8.16 C9.49,8.14 7.72,5.04 7.72,5.04 C7.58,4.81 7.39,4.56 6.99,4.56 L4.4,4.56 L4.4,4.56 Z" /> <path d="M15.3,1 C14.91,1 14.74,1.25 14.6,1.5 C14.6,1.5 9.01,11.42 8.82,11.74 C8.83,11.76 12.51,18.51 12.51,18.51 C12.64,18.74 12.84,19 13.23,19 L15.82,19 C15.98,19 16.1,18.94 16.16,18.83 C16.23,18.72 16.23,18.57 16.16,18.43 L12.5,11.74 L12.5,11.72 L18.25,1.56 C18.32,1.42 18.32,1.27 18.25,1.16 C18.21,1.06 18.08,1 17.93,1 L15.3,1 L15.3,1 Z" /></svg>',
      yelp: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.175,14.971c-0.112,0.77-1.686,2.767-2.406,3.054c-0.246,0.1-0.487,0.076-0.675-0.069\tc-0.122-0.096-2.446-3.859-2.446-3.859c-0.194-0.293-0.157-0.682,0.083-0.978c0.234-0.284,0.581-0.393,0.881-0.276\tc0.016,0.01,4.21,1.394,4.332,1.482c0.178,0.148,0.263,0.379,0.225,0.646L17.175,14.971L17.175,14.971z M11.464,10.789\tc-0.203-0.307-0.199-0.666,0.009-0.916c0,0,2.625-3.574,2.745-3.657c0.203-0.135,0.452-0.141,0.69-0.025\tc0.691,0.335,2.085,2.405,2.167,3.199v0.027c0.024,0.271-0.082,0.491-0.273,0.623c-0.132,0.083-4.43,1.155-4.43,1.155\tc-0.322,0.096-0.68-0.06-0.882-0.381L11.464,10.789z M9.475,9.563C9.32,9.609,8.848,9.757,8.269,8.817c0,0-3.916-6.16-4.007-6.351\tc-0.057-0.212,0.011-0.455,0.202-0.65C5.047,1.211,8.21,0.327,9.037,0.529c0.27,0.069,0.457,0.238,0.522,0.479\tc0.047,0.266,0.433,5.982,0.488,7.264C10.098,9.368,9.629,9.517,9.475,9.563z M9.927,19.066c-0.083,0.225-0.273,0.373-0.54,0.421\tc-0.762,0.13-3.15-0.751-3.647-1.342c-0.096-0.131-0.155-0.262-0.167-0.394c-0.011-0.095,0-0.189,0.036-0.272\tc0.061-0.155,2.917-3.538,2.917-3.538c0.214-0.272,0.595-0.355,0.952-0.213c0.345,0.13,0.56,0.428,0.536,0.749\tC10.014,14.479,9.977,18.923,9.927,19.066z M3.495,13.912c-0.235-0.009-0.444-0.148-0.568-0.382c-0.089-0.17-0.151-0.453-0.19-0.794\tC2.63,11.701,2.761,10.144,3.07,9.648c0.145-0.226,0.357-0.345,0.592-0.336c0.154,0,4.255,1.667,4.255,1.667\tc0.321,0.118,0.521,0.453,0.5,0.833c-0.023,0.37-0.236,0.655-0.551,0.738L3.495,13.912z" /></svg>',
      youtube: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15,4.1c1,0.1,2.3,0,3,0.8c0.8,0.8,0.9,2.1,0.9,3.1C19,9.2,19,10.9,19,12c-0.1,1.1,0,2.4-0.5,3.4c-0.5,1.1-1.4,1.5-2.5,1.6 c-1.2,0.1-8.6,0.1-11,0c-1.1-0.1-2.4-0.1-3.2-1c-0.7-0.8-0.7-2-0.8-3C1,11.8,1,10.1,1,8.9c0-1.1,0-2.4,0.5-3.4C2,4.5,3,4.3,4.1,4.2 C5.3,4.1,12.6,4,15,4.1z M8,7.5v6l5.5-3L8,7.5z" /></svg>'
    });
  }

  return "undefined" != typeof window && window.UIkit && window.UIkit.use(i), i;
});
"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

/*! UIkit 3.0.0-rc.10 | http://www.getuikit.com | (c) 2014 - 2018 YOOtheme | MIT License */
!function (t, e) {
  "object" == (typeof exports === "undefined" ? "undefined" : _typeof(exports)) && "undefined" != typeof module ? module.exports = e() : "function" == typeof define && define.amd ? define("uikit", e) : t.UIkit = e();
}(void 0, function () {
  "use strict";

  function p(i, n) {
    return function (t) {
      var e = arguments.length;
      return e ? 1 < e ? i.apply(n, arguments) : i.call(n, t) : i.call(n);
    };
  }

  var e = Object.prototype,
      i = e.hasOwnProperty;

  function h(t, e) {
    return i.call(t, e);
  }

  var n = {},
      r = /([a-z\d])([A-Z])/g;

  function m(t) {
    return t in n || (n[t] = t.replace(r, "$1-$2").toLowerCase()), n[t];
  }

  var o = /-(\w)/g;

  function g(t) {
    return t.replace(o, s);
  }

  function s(t, e) {
    return e ? e.toUpperCase() : "";
  }

  function a(t) {
    return t.length ? s(0, t.charAt(0)) + t.slice(1) : "";
  }

  var t = String.prototype,
      l = t.startsWith || function (t) {
    return 0 === this.lastIndexOf(t, 0);
  };

  function v(t, e) {
    return l.call(t, e);
  }

  var c = t.endsWith || function (t) {
    return this.substr(-t.length) === t;
  };

  function u(t, e) {
    return c.call(t, e);
  }

  var d = function d(t) {
    return ~this.indexOf(t);
  },
      f = t.includes || d,
      w = Array.prototype.includes || d;

  function b(t, e) {
    return t && (N(t) ? f : w).call(t, e);
  }

  var y = Array.isArray;

  function x(t) {
    return "function" == typeof t;
  }

  function k(t) {
    return null !== t && "object" == _typeof(t);
  }

  function $(t) {
    return k(t) && Object.getPrototypeOf(t) === e;
  }

  function I(t) {
    return k(t) && t === t.window;
  }

  function S(t) {
    return k(t) && 9 === t.nodeType;
  }

  function T(t) {
    return k(t) && !!t.jquery;
  }

  function E(t) {
    return t instanceof Node || k(t) && 1 === t.nodeType;
  }

  var C = e.toString;

  function _(t) {
    return C.call(t).match(/^\[object (NodeList|HTMLCollection)\]$/);
  }

  function A(t) {
    return "boolean" == typeof t;
  }

  function N(t) {
    return "string" == typeof t;
  }

  function O(t) {
    return "number" == typeof t;
  }

  function M(t) {
    return O(t) || N(t) && !isNaN(t - parseFloat(t));
  }

  function D(t) {
    return void 0 === t;
  }

  function B(t) {
    return A(t) ? t : "true" === t || "1" === t || "" === t || "false" !== t && "0" !== t && t;
  }

  function z(t) {
    var e = Number(t);
    return !isNaN(e) && e;
  }

  function P(t) {
    return parseFloat(t) || 0;
  }

  function H(t) {
    return E(t) || I(t) || S(t) ? t : _(t) || T(t) ? t[0] : y(t) ? H(t[0]) : null;
  }

  var W = Array.prototype;

  function L(t) {
    return E(t) ? [t] : _(t) ? W.slice.call(t) : y(t) ? t.map(H).filter(Boolean) : T(t) ? t.toArray() : [];
  }

  function j(t) {
    return y(t) ? t : N(t) ? t.split(/,(?![^(]*\))/).map(function (t) {
      return M(t) ? z(t) : B(t.trim());
    }) : [t];
  }

  function F(t) {
    return t ? u(t, "ms") ? P(t) : 1e3 * P(t) : 0;
  }

  function V(t, e, i) {
    return t.replace(new RegExp(e + "|" + i, "mg"), function (t) {
      return t === e ? i : e;
    });
  }

  var Y = Object.assign || function (t) {
    for (var e = [], i = arguments.length - 1; 0 < i--;) {
      e[i] = arguments[i + 1];
    }

    t = Object(t);

    for (var n = 0; n < e.length; n++) {
      var r = e[n];
      if (null !== r) for (var o in r) {
        h(r, o) && (t[o] = r[o]);
      }
    }

    return t;
  };

  function R(t, e) {
    for (var i in t) {
      e.call(t[i], t[i], i);
    }
  }

  function q(t, i) {
    return t.sort(function (t, e) {
      return t[i] > e[i] ? 1 : e[i] > t[i] ? -1 : 0;
    });
  }

  function U(t, e, i) {
    return void 0 === e && (e = 0), void 0 === i && (i = 1), Math.min(Math.max(t, e), i);
  }

  function X() {}

  function J(t, e) {
    return t.left < e.right && t.right > e.left && t.top < e.bottom && t.bottom > e.top;
  }

  function K(t, e) {
    return t.x <= r2.right && t.x >= r2.left && t.y <= r2.bottom && t.y >= r2.top;
  }

  var G = {
    ratio: function ratio(t, e, i) {
      var n,
          r = "width" === e ? "height" : "width";
      return (n = {})[r] = t[e] ? Math.round(i * t[r] / t[e]) : t[r], n[e] = i, n;
    },
    contain: function contain(i, n) {
      var r = this;
      return R(i = Y({}, i), function (t, e) {
        return i = i[e] > n[e] ? r.ratio(i, e, n[e]) : i;
      }), i;
    },
    cover: function cover(i, n) {
      var r = this;
      return R(i = this.contain(i, n), function (t, e) {
        return i = i[e] < n[e] ? r.ratio(i, e, n[e]) : i;
      }), i;
    }
  };

  function Z(t, e, i) {
    if (k(e)) for (var n in e) {
      Z(t, n, e[n]);
    } else {
      if (D(i)) return (t = H(t)) && t.getAttribute(e);
      L(t).forEach(function (t) {
        x(i) && (i = i.call(t, Z(t, e))), null === i ? tt(t, e) : t.setAttribute(e, i);
      });
    }
  }

  function Q(t, e) {
    return L(t).some(function (t) {
      return t.hasAttribute(e);
    });
  }

  function tt(t, e) {
    t = L(t), e.split(" ").forEach(function (e) {
      return t.forEach(function (t) {
        return t.removeAttribute(e);
      });
    });
  }

  function et(t, e, i, n) {
    Z(t, e, function (t) {
      return t ? t.replace(i, n) : t;
    });
  }

  function it(t, e) {
    for (var i = 0, n = [e, "data-" + e]; i < n.length; i++) {
      if (Q(t, n[i])) return Z(t, n[i]);
    }
  }

  function nt(t, e) {
    return H(t) || ot(t, ct(t) ? e : document);
  }

  function rt(t, e) {
    var i = L(t);
    return i.length && i || st(t, ct(t) ? e : document);
  }

  function ot(t, e) {
    return H(at(t, e, "querySelector"));
  }

  function st(t, e) {
    return L(at(t, e, "querySelectorAll"));
  }

  function at(t, s, e) {
    if (void 0 === s && (s = document), !t || !N(t)) return null;
    var a;
    ct(t = t.replace(ht, "$1 *")) && (a = [], t = t.split(",").map(function (t, e) {
      var i = s;

      if ("!" === (t = t.trim())[0]) {
        var n = t.substr(1).trim().split(" ");
        i = mt(s.parentNode, n[0]), t = n.slice(1).join(" ").trim();
      }

      if ("-" === t[0]) {
        var r = t.substr(1).trim().split(" "),
            o = (i || s).previousElementSibling;
        i = ft(o, t.substr(1)) ? o : null, t = r.slice(1).join(" ");
      }

      return i ? (i.id || (i.id = "uk-" + Date.now() + e, a.push(function () {
        return tt(i, "id");
      })), "#" + wt(i.id) + " " + t) : null;
    }).filter(Boolean).join(","), s = document);

    try {
      return s[e](t);
    } catch (t) {
      return null;
    } finally {
      a && a.forEach(function (t) {
        return t();
      });
    }
  }

  var lt = /(^|,)\s*[!>+~-]/,
      ht = /([!>+~-])(?=\s+[!>+~-]|\s*$)/g;

  function ct(t) {
    return N(t) && t.match(lt);
  }

  var ut = Element.prototype,
      dt = ut.matches || ut.webkitMatchesSelector || ut.msMatchesSelector;

  function ft(t, e) {
    return L(t).some(function (t) {
      return dt.call(t, e);
    });
  }

  var pt = ut.closest || function (t) {
    var e = this;

    do {
      if (ft(e, t)) return e;
      e = e.parentNode;
    } while (e && 1 === e.nodeType);
  };

  function mt(t, e) {
    return v(e, ">") && (e = e.slice(1)), E(t) ? t.parentNode && pt.call(t, e) : L(t).map(function (t) {
      return t.parentNode && pt.call(t, e);
    }).filter(Boolean);
  }

  function gt(t, e) {
    for (var i = [], n = H(t).parentNode; n && 1 === n.nodeType;) {
      ft(n, e) && i.push(n), n = n.parentNode;
    }

    return i;
  }

  var vt = window.CSS && CSS.escape || function (t) {
    return t.replace(/([^\x7f-\uFFFF\w-])/g, function (t) {
      return "\\" + t;
    });
  };

  function wt(t) {
    return N(t) ? vt.call(null, t) : "";
  }

  var bt = {
    area: !0,
    base: !0,
    br: !0,
    col: !0,
    embed: !0,
    hr: !0,
    img: !0,
    input: !0,
    keygen: !0,
    link: !0,
    menuitem: !0,
    meta: !0,
    param: !0,
    source: !0,
    track: !0,
    wbr: !0
  };

  function yt(t) {
    return L(t).some(function (t) {
      return bt[t.tagName.toLowerCase()];
    });
  }

  function xt(t) {
    return L(t).some(function (t) {
      return t.offsetWidth || t.offsetHeight || t.getClientRects().length;
    });
  }

  var kt = "input,select,textarea,button";

  function $t(t) {
    return L(t).some(function (t) {
      return ft(t, kt);
    });
  }

  function It(t, e) {
    return L(t).filter(function (t) {
      return ft(t, e);
    });
  }

  function St(t, e) {
    return N(e) ? ft(t, e) || mt(t, e) : t === e || (S(e) ? e.documentElement : H(e)).contains(H(t));
  }

  function Tt() {
    for (var t = [], e = arguments.length; e--;) {
      t[e] = arguments[e];
    }

    var i,
        n = Nt(t),
        r = n[0],
        o = n[1],
        s = n[2],
        a = n[3],
        l = n[4];
    return r = Dt(r), s && (a = function (t, n, r) {
      var o = this;
      return function (i) {
        t.forEach(function (t) {
          var e = ">" === n[0] ? st(n, t).reverse().filter(function (t) {
            return St(i.target, t);
          })[0] : mt(i.target, n);
          e && (i.delegate = t, i.current = e, r.call(o, i));
        });
      };
    }(r, s, a)), 1 < a.length && (i = a, a = function a(t) {
      return y(t.detail) ? i.apply(void 0, [t].concat(t.detail)) : i(t);
    }), o.split(" ").forEach(function (e) {
      return r.forEach(function (t) {
        return t.addEventListener(e, a, l);
      });
    }), function () {
      return Et(r, o, a, l);
    };
  }

  function Et(t, e, i, n) {
    void 0 === n && (n = !1), t = Dt(t), e.split(" ").forEach(function (e) {
      return t.forEach(function (t) {
        return t.removeEventListener(e, i, n);
      });
    });
  }

  function Ct() {
    for (var t = [], e = arguments.length; e--;) {
      t[e] = arguments[e];
    }

    var i = Nt(t),
        n = i[0],
        r = i[1],
        o = i[2],
        s = i[3],
        a = i[4],
        l = i[5],
        h = Tt(n, r, o, function (t) {
      var e = !l || l(t);
      e && (h(), s(t, e));
    }, a);
    return h;
  }

  function _t(t, i, n) {
    return Dt(t).reduce(function (t, e) {
      return t && e.dispatchEvent(At(i, !0, !0, n));
    }, !0);
  }

  function At(t, e, i, n) {
    if (void 0 === e && (e = !0), void 0 === i && (i = !1), N(t)) {
      var r = document.createEvent("CustomEvent");
      r.initCustomEvent(t, e, i, n), t = r;
    }

    return t;
  }

  function Nt(t) {
    return x(t[2]) && t.splice(2, 0, !1), t;
  }

  function Ot(t) {
    return "EventTarget" in window ? t instanceof EventTarget : t && "addEventListener" in t;
  }

  function Mt(t) {
    return Ot(t) ? t : H(t);
  }

  function Dt(t) {
    return y(t) ? t.map(Mt).filter(Boolean) : N(t) ? st(t) : Ot(t) ? [t] : L(t);
  }

  function Bt() {
    var e = setTimeout(Ct(document, "click", function (t) {
      t.preventDefault(), t.stopImmediatePropagation(), clearTimeout(e);
    }, !0));

    _t(document, "touchcancel");
  }

  var zt = "Promise" in window ? window.Promise : Lt,
      Pt = function Pt() {
    var i = this;
    this.promise = new zt(function (t, e) {
      i.reject = e, i.resolve = t;
    });
  },
      Ht = 2,
      Wt = "setImmediate" in window ? setImmediate : setTimeout;

  function Lt(t) {
    this.state = Ht, this.value = void 0, this.deferred = [];
    var e = this;

    try {
      t(function (t) {
        e.resolve(t);
      }, function (t) {
        e.reject(t);
      });
    } catch (t) {
      e.reject(t);
    }
  }

  Lt.reject = function (i) {
    return new Lt(function (t, e) {
      e(i);
    });
  }, Lt.resolve = function (i) {
    return new Lt(function (t, e) {
      t(i);
    });
  }, Lt.all = function (s) {
    return new Lt(function (i, t) {
      var n = [],
          r = 0;

      function e(e) {
        return function (t) {
          n[e] = t, (r += 1) === s.length && i(n);
        };
      }

      0 === s.length && i(n);

      for (var o = 0; o < s.length; o += 1) {
        Lt.resolve(s[o]).then(e(o), t);
      }
    });
  }, Lt.race = function (n) {
    return new Lt(function (t, e) {
      for (var i = 0; i < n.length; i += 1) {
        Lt.resolve(n[i]).then(t, e);
      }
    });
  };
  var jt = Lt.prototype;

  function Ft(s, a) {
    return new zt(function (t, e) {
      var i = Y({
        data: null,
        method: "GET",
        headers: {},
        xhr: new XMLHttpRequest(),
        beforeSend: X,
        responseType: ""
      }, a);
      i.beforeSend(i);
      var n = i.xhr;

      for (var r in i) {
        if (r in n) try {
          n[r] = i[r];
        } catch (t) {}
      }

      for (var o in n.open(i.method.toUpperCase(), s), i.headers) {
        n.setRequestHeader(o, i.headers[o]);
      }

      Tt(n, "load", function () {
        0 === n.status || 200 <= n.status && n.status < 300 || 304 === n.status ? t(n) : e(Y(Error(n.statusText), {
          xhr: n,
          status: n.status
        }));
      }), Tt(n, "error", function () {
        return e(Y(Error("Network Error"), {
          xhr: n
        }));
      }), Tt(n, "timeout", function () {
        return e(Y(Error("Network Timeout"), {
          xhr: n
        }));
      }), n.send(i.data);
    });
  }

  function Vt(n, r, o) {
    return new zt(function (t, e) {
      var i = new Image();
      i.onerror = e, i.onload = function () {
        return t(i);
      }, i.src = n, r && (i.srcset = r), o && (i.sizes = o);
    });
  }

  function Yt() {
    return "complete" === document.readyState || "loading" !== document.readyState && !document.documentElement.doScroll;
  }

  function Rt(t) {
    if (Yt()) t();else var e = function e() {
      i(), n(), t();
    },
        i = Tt(document, "DOMContentLoaded", e),
        n = Tt(window, "load", e);
  }

  function qt(t, e) {
    return e ? L(t).indexOf(H(e)) : L((t = H(t)) && t.parentNode.children).indexOf(t);
  }

  function Ut(t, e, i, n) {
    void 0 === i && (i = 0), void 0 === n && (n = !1);
    var r = (e = L(e)).length;
    return t = M(t) ? z(t) : "next" === t ? i + 1 : "previous" === t ? i - 1 : qt(e, t), n ? U(t, 0, r - 1) : (t %= r) < 0 ? t + r : t;
  }

  function Xt(t) {
    return (t = H(t)).innerHTML = "", t;
  }

  function Jt(t, e) {
    return t = H(t), D(e) ? t.innerHTML : Kt(t.hasChildNodes() ? Xt(t) : t, e);
  }

  function Kt(e, t) {
    return e = H(e), Qt(t, function (t) {
      return e.appendChild(t);
    });
  }

  function Gt(e, t) {
    return e = H(e), Qt(t, function (t) {
      return e.parentNode.insertBefore(t, e);
    });
  }

  function Zt(e, t) {
    return e = H(e), Qt(t, function (t) {
      return e.nextSibling ? Gt(e.nextSibling, t) : Kt(e.parentNode, t);
    });
  }

  function Qt(t, e) {
    return (t = N(t) ? se(t) : t) ? "length" in t ? L(t).map(e) : e(t) : null;
  }

  function te(t) {
    L(t).map(function (t) {
      return t.parentNode && t.parentNode.removeChild(t);
    });
  }

  function ee(t, e) {
    for (e = H(Gt(t, e)); e.firstChild;) {
      e = e.firstChild;
    }

    return Kt(e, t), e;
  }

  function ie(t, e) {
    return L(L(t).map(function (t) {
      return t.hasChildNodes ? ee(L(t.childNodes), e) : Kt(t, e);
    }));
  }

  function ne(t) {
    L(t).map(function (t) {
      return t.parentNode;
    }).filter(function (t, e, i) {
      return i.indexOf(t) === e;
    }).forEach(function (t) {
      Gt(t, t.childNodes), te(t);
    });
  }

  jt.resolve = function (t) {
    var e = this;

    if (e.state === Ht) {
      if (t === e) throw new TypeError("Promise settled with itself.");
      var i = !1;

      try {
        var n = t && t.then;
        if (null !== t && k(t) && x(n)) return void n.call(t, function (t) {
          i || e.resolve(t), i = !0;
        }, function (t) {
          i || e.reject(t), i = !0;
        });
      } catch (t) {
        return void (i || e.reject(t));
      }

      e.state = 0, e.value = t, e.notify();
    }
  }, jt.reject = function (t) {
    var e = this;

    if (e.state === Ht) {
      if (t === e) throw new TypeError("Promise settled with itself.");
      e.state = 1, e.value = t, e.notify();
    }
  }, jt.notify = function () {
    var o = this;
    Wt(function () {
      if (o.state !== Ht) for (; o.deferred.length;) {
        var t = o.deferred.shift(),
            e = t[0],
            i = t[1],
            n = t[2],
            r = t[3];

        try {
          0 === o.state ? x(e) ? n(e.call(void 0, o.value)) : n(o.value) : 1 === o.state && (x(i) ? n(i.call(void 0, o.value)) : r(o.value));
        } catch (t) {
          r(t);
        }
      }
    });
  }, jt.then = function (i, n) {
    var r = this;
    return new Lt(function (t, e) {
      r.deferred.push([i, n, t, e]), r.notify();
    });
  }, jt.catch = function (t) {
    return this.then(void 0, t);
  };
  var re = /^\s*<(\w+|!)[^>]*>/,
      oe = /^<(\w+)\s*\/?>(?:<\/\1>)?$/;

  function se(t) {
    var e = oe.exec(t);
    if (e) return document.createElement(e[1]);
    var i = document.createElement("div");
    return re.test(t) ? i.insertAdjacentHTML("beforeend", t.trim()) : i.textContent = t, 1 < i.childNodes.length ? L(i.childNodes) : i.firstChild;
  }

  function ae(t, e) {
    if (t && 1 === t.nodeType) for (e(t), t = t.firstElementChild; t;) {
      ae(t, e), t = t.nextElementSibling;
    }
  }

  function le(t) {
    for (var e = [], i = arguments.length - 1; 0 < i--;) {
      e[i] = arguments[i + 1];
    }

    pe(t, e, "add");
  }

  function he(t) {
    for (var e = [], i = arguments.length - 1; 0 < i--;) {
      e[i] = arguments[i + 1];
    }

    pe(t, e, "remove");
  }

  function ce(t, e) {
    et(t, "class", new RegExp("(^|\\s)" + e + "(?!\\S)", "g"), "");
  }

  function ue(t) {
    for (var e = [], i = arguments.length - 1; 0 < i--;) {
      e[i] = arguments[i + 1];
    }

    e[0] && he(t, e[0]), e[1] && le(t, e[1]);
  }

  function de(t, e) {
    return L(t).some(function (t) {
      return t.classList.contains(e);
    });
  }

  function fe(t) {
    for (var n = [], e = arguments.length - 1; 0 < e--;) {
      n[e] = arguments[e + 1];
    }

    if (n.length) {
      var r = N((n = me(n))[n.length - 1]) ? [] : n.pop();
      n = n.filter(Boolean), L(t).forEach(function (t) {
        for (var e = t.classList, i = 0; i < n.length; i++) {
          ve.Force ? e.toggle.apply(e, [n[i]].concat(r)) : e[(D(r) ? !e.contains(n[i]) : r) ? "add" : "remove"](n[i]);
        }
      });
    }
  }

  function pe(t, i, n) {
    (i = me(i).filter(Boolean)).length && L(t).forEach(function (t) {
      var e = t.classList;
      ve.Multiple ? e[n].apply(e, i) : i.forEach(function (t) {
        return e[n](t);
      });
    });
  }

  function me(t) {
    return t.reduce(function (t, e) {
      return t.concat.call(t, N(e) && b(e, " ") ? e.trim().split(" ") : e);
    }, []);
  }

  var ge,
      ve = {};
  (ge = document.createElement("_").classList) && (ge.add("a", "b"), ge.toggle("c", !1), ve.Multiple = ge.contains("b"), ve.Force = !ge.contains("c"));
  var we = {
    "animation-iteration-count": !(ge = null),
    "column-count": !0,
    "fill-opacity": !0,
    "flex-grow": !0,
    "flex-shrink": !0,
    "font-weight": !0,
    "line-height": !0,
    opacity: !0,
    order: !0,
    orphans: !0,
    widows: !0,
    "z-index": !0,
    zoom: !0
  };

  function be(t, e, r) {
    return L(t).map(function (i) {
      if (N(e)) {
        if (e = Se(e), D(r)) return xe(i, e);
        r || 0 === r ? i.style[e] = M(r) && !we[e] ? r + "px" : r : i.style.removeProperty(e);
      } else {
        if (y(e)) {
          var n = ye(i);
          return e.reduce(function (t, e) {
            return t[e] = n[Se(e)], t;
          }, {});
        }

        k(e) && R(e, function (t, e) {
          return be(i, e, t);
        });
      }

      return i;
    })[0];
  }

  function ye(t, e) {
    return (t = H(t)).ownerDocument.defaultView.getComputedStyle(t, e);
  }

  function xe(t, e, i) {
    return ye(t, i)[e];
  }

  var ke = {};

  function $e(t) {
    if (!(t in ke)) {
      var e = Kt(document.documentElement, document.createElement("div"));
      le(e, "var-" + t);

      try {
        ke[t] = xe(e, "content", ":before").replace(/^["'](.*)["']$/, "$1"), ke[t] = JSON.parse(ke[t]);
      } catch (t) {}

      document.documentElement.removeChild(e);
    }

    return ke[t];
  }

  var Ie = {};

  function Se(t) {
    var e = Ie[t];
    return e || (e = Ie[t] = function (t) {
      if ((t = m(t)) in Ee) return t;
      var e,
          i = Te.length;

      for (; i--;) {
        if ((e = "-" + Te[i] + "-" + t) in Ee) return e;
      }
    }(t) || t), e;
  }

  var Te = ["webkit", "moz", "ms"],
      Ee = document.createElement("_").style;

  function Ce(t, s, a, l) {
    return void 0 === a && (a = 400), void 0 === l && (l = "linear"), zt.all(L(t).map(function (o) {
      return new zt(function (i, n) {
        for (var t in s) {
          var e = be(o, t);
          "" === e && be(o, t, e);
        }

        var r = setTimeout(function () {
          return _t(o, "transitionend");
        }, a);
        Ct(o, "transitionend transitioncanceled", function (t) {
          var e = t.type;
          clearTimeout(r), he(o, "uk-transition"), be(o, {
            "transition-property": "",
            "transition-duration": "",
            "transition-timing-function": ""
          }), "transitioncanceled" === e ? n() : i();
        }, !1, function (t) {
          var e = t.target;
          return o === e;
        }), le(o, "uk-transition"), be(o, Y({
          "transition-property": Object.keys(s).map(Se).join(","),
          "transition-duration": a + "ms",
          "transition-timing-function": l
        }, s));
      });
    }));
  }

  var _e = {
    start: Ce,
    stop: function stop(t) {
      return _t(t, "transitionend"), zt.resolve();
    },
    cancel: function cancel(t) {
      _t(t, "transitioncanceled");
    },
    inProgress: function inProgress(t) {
      return de(t, "uk-transition");
    }
  },
      Ae = "uk-animation-",
      Ne = "uk-cancel-animation";

  function Oe(t, e, i, a, l) {
    var h = arguments;
    return void 0 === i && (i = 200), zt.all(L(t).map(function (s) {
      return new zt(function (n, r) {
        if (de(s, Ne)) requestAnimationFrame(function () {
          return zt.resolve().then(function () {
            return Oe.apply(void 0, h).then(n, r);
          });
        });else {
          var t = e + " " + Ae + (l ? "leave" : "enter");
          v(e, Ae) && (a && (t += " uk-transform-origin-" + a), l && (t += " " + Ae + "reverse")), o(), Ct(s, "animationend animationcancel", function (t) {
            var e = t.type,
                i = !1;
            "animationcancel" === e ? (r(), o()) : (n(), zt.resolve().then(function () {
              i = !0, o();
            })), requestAnimationFrame(function () {
              i || (le(s, Ne), requestAnimationFrame(function () {
                return he(s, Ne);
              }));
            });
          }, !1, function (t) {
            var e = t.target;
            return s === e;
          }), be(s, "animationDuration", i + "ms"), le(s, t);
        }

        function o() {
          be(s, "animationDuration", ""), ce(s, Ae + "\\S*");
        }
      });
    }));
  }

  var Me = new RegExp(Ae + "(enter|leave)"),
      De = {
    in: function _in(t, e, i, n) {
      return Oe(t, e, i, n, !1);
    },
    out: function out(t, e, i, n) {
      return Oe(t, e, i, n, !0);
    },
    inProgress: function inProgress(t) {
      return Me.test(Z(t, "class"));
    },
    cancel: function cancel(t) {
      _t(t, "animationcancel");
    }
  };

  function Be(t, e) {
    return N(t) ? Pe(t) ? H(se(t)) : ot(t, e) : H(t);
  }

  function ze(t, e) {
    return N(t) ? Pe(t) ? L(se(t)) : st(t, e) : L(t);
  }

  function Pe(t) {
    return "<" === t[0] || t.match(/^\s*</);
  }

  var He = {
    width: ["x", "left", "right"],
    height: ["y", "top", "bottom"]
  };

  function We(t, e, c, u, d, i, f, p) {
    c = Xe(c), u = Xe(u);
    var m = {
      element: c,
      target: u
    };
    if (!t || !e) return m;
    var g = je(t),
        v = je(e),
        w = v;
    return Ue(w, c, g, -1), Ue(w, u, v, 1), d = Je(d, g.width, g.height), i = Je(i, v.width, v.height), d.x += i.x, d.y += i.y, w.left += d.x, w.top += d.y, p = je(p || ei(t)), f && R(He, function (t, n) {
      var r = t[0],
          o = t[1],
          s = t[2];

      if (!0 === f || b(f, r)) {
        var e = c[r] === o ? -g[n] : c[r] === s ? g[n] : 0,
            i = u[r] === o ? v[n] : u[r] === s ? -v[n] : 0;

        if (w[o] < p[o] || w[o] + g[n] > p[s]) {
          var a = g[n] / 2,
              l = "center" === u[r] ? -v[n] / 2 : 0;
          "center" === c[r] && (h(a, l) || h(-a, -l)) || h(e, i);
        }
      }

      function h(e, t) {
        var i = w[o] + e + t - 2 * d[r];
        if (i >= p[o] && i + g[n] <= p[s]) return w[o] = i, ["element", "target"].forEach(function (t) {
          m[t][r] = e ? m[t][r] === He[n][1] ? He[n][2] : He[n][1] : m[t][r];
        }), !0;
      }
    }), Le(t, w), m;
  }

  function Le(i, n) {
    if (i = H(i), !n) return je(i);
    var r = Le(i),
        o = be(i, "position");
    ["left", "top"].forEach(function (t) {
      if (t in n) {
        var e = be(i, t);
        be(i, t, n[t] - r[t] + P("absolute" === o && "auto" === e ? Fe(i)[t] : e));
      }
    });
  }

  function je(t) {
    var e,
        i,
        n = ei(t = H(t)),
        r = n.pageYOffset,
        o = n.pageXOffset;

    if (I(t)) {
      var s = t.innerHeight,
          a = t.innerWidth;
      return {
        top: r,
        left: o,
        height: s,
        width: a,
        bottom: r + s,
        right: o + a
      };
    }

    xt(t) || (e = Z(t, "style"), i = Z(t, "hidden"), Z(t, {
      style: (e || "") + ";display:block !important;",
      hidden: null
    }));
    var l = t.getBoundingClientRect();
    return D(e) || Z(t, {
      style: e,
      hidden: i
    }), {
      height: l.height,
      width: l.width,
      top: l.top + r,
      left: l.left + o,
      bottom: l.bottom + r,
      right: l.right + o
    };
  }

  function Fe(n) {
    var r = (n = H(n)).offsetParent || ii(n).documentElement,
        o = Le(r),
        t = ["top", "left"].reduce(function (t, e) {
      var i = a(e);
      return t[e] -= o[e] + P(be(n, "margin" + i)) + P(be(r, "border" + i + "Width")), t;
    }, Le(n));
    return {
      top: t.top,
      left: t.left
    };
  }

  var Ve = Re("height"),
      Ye = Re("width");

  function Re(n) {
    var r = a(n);
    return function (t, e) {
      if (t = H(t), D(e)) {
        if (I(t)) return t["inner" + r];

        if (S(t)) {
          var i = t.documentElement;
          return Math.max(i["offset" + r], i["scroll" + r]);
        }

        return (e = "auto" === (e = be(t, n)) ? t["offset" + r] : P(e) || 0) - qe(n, t);
      }

      be(t, n, e || 0 === e ? +e + qe(n, t) + "px" : "");
    };
  }

  function qe(t, i) {
    return "border-box" === be(i, "boxSizing") ? He[t].slice(1).map(a).reduce(function (t, e) {
      return t + P(be(i, "padding" + e)) + P(be(i, "border" + e + "Width"));
    }, 0) : 0;
  }

  function Ue(o, s, a, l) {
    R(He, function (t, e) {
      var i = t[0],
          n = t[1],
          r = t[2];
      s[i] === r ? o[n] += a[e] * l : "center" === s[i] && (o[n] += a[e] * l / 2);
    });
  }

  function Xe(t) {
    var e = /left|center|right/,
        i = /top|center|bottom/;
    return 1 === (t = (t || "").split(" ")).length && (t = e.test(t[0]) ? t.concat(["center"]) : i.test(t[0]) ? ["center"].concat(t) : ["center", "center"]), {
      x: e.test(t[0]) ? t[0] : "center",
      y: i.test(t[1]) ? t[1] : "center"
    };
  }

  function Je(t, e, i) {
    var n = (t || "").split(" "),
        r = n[0],
        o = n[1];
    return {
      x: r ? P(r) * (u(r, "%") ? e / 100 : 1) : 0,
      y: o ? P(o) * (u(o, "%") ? i / 100 : 1) : 0
    };
  }

  function Ke(t) {
    switch (t) {
      case "left":
        return "right";

      case "right":
        return "left";

      case "top":
        return "bottom";

      case "bottom":
        return "top";

      default:
        return t;
    }
  }

  function Ge(t, e, i, n) {
    if (void 0 === e && (e = 0), void 0 === i && (i = 0), !xt(t)) return !1;
    var r = ei(t = H(t));
    if (n) return J(t.getBoundingClientRect(), {
      top: -e,
      left: -i,
      bottom: e + Ve(r),
      right: i + Ye(r)
    });
    var o = ti(t),
        s = o[0],
        a = o[1],
        l = r.pageYOffset,
        h = r.pageXOffset;
    return J({
      top: s,
      left: a,
      bottom: s + t.offsetHeight,
      right: s + t.offsetWidth
    }, {
      top: l - e,
      left: h - i,
      bottom: l + e + Ve(r),
      right: h + i + Ye(r)
    });
  }

  function Ze(t, e) {
    if (void 0 === e && (e = 0), !xt(t)) return 0;
    var i = ei(t = H(t)),
        n = ii(t),
        r = t.offsetHeight + e,
        o = ti(t)[0],
        s = Ve(i),
        a = s + Math.min(0, o - s),
        l = Math.max(0, s - (Ve(n) + e - (o + r)));
    return U((a + i.pageYOffset - o) / ((a + (r - (l < s ? l : 0))) / 100) / 100);
  }

  function Qe(t, e) {
    if (I(t = H(t)) || S(t)) {
      var i = ei(t);
      (0, i.scrollTo)(i.pageXOffset, e);
    } else t.scrollTop = e;
  }

  function ti(t) {
    var e = [0, 0];

    do {
      if (e[0] += t.offsetTop, e[1] += t.offsetLeft, "fixed" === be(t, "position")) {
        var i = ei(t);
        return e[0] += i.pageYOffset, e[1] += i.pageXOffset, e;
      }
    } while (t = t.offsetParent);

    return e;
  }

  function ei(t) {
    return I(t) ? t : ii(t).defaultView;
  }

  function ii(t) {
    return H(t).ownerDocument;
  }

  var ni = /msie|trident/i.test(window.navigator.userAgent),
      ri = "rtl" === Z(document.documentElement, "dir"),
      oi = "ontouchstart" in window,
      si = window.PointerEvent,
      ai = oi || window.DocumentTouch && document instanceof DocumentTouch || navigator.maxTouchPoints,
      li = ai ? "mousedown " + (oi ? "touchstart" : "pointerdown") : "mousedown",
      hi = ai ? "mousemove " + (oi ? "touchmove" : "pointermove") : "mousemove",
      ci = ai ? "mouseup " + (oi ? "touchend" : "pointerup") : "mouseup",
      ui = ai && si ? "pointerenter" : "mouseenter",
      di = ai && si ? "pointerleave" : "mouseleave",
      fi = {
    reads: [],
    writes: [],
    read: function read(t) {
      return this.reads.push(t), pi(), t;
    },
    write: function write(t) {
      return this.writes.push(t), pi(), t;
    },
    clear: function clear(t) {
      return gi(this.reads, t) || gi(this.writes, t);
    },
    flush: function flush() {
      mi(this.reads), mi(this.writes.splice(0, this.writes.length)), this.scheduled = !1, (this.reads.length || this.writes.length) && pi();
    }
  };

  function pi() {
    fi.scheduled || (fi.scheduled = !0, requestAnimationFrame(fi.flush.bind(fi)));
  }

  function mi(t) {
    for (var e; e = t.shift();) {
      e();
    }
  }

  function gi(t, e) {
    var i = t.indexOf(e);
    return !!~i && !!t.splice(i, 1);
  }

  function vi() {}

  function wi(t, e) {
    return (e.y - t.y) / (e.x - t.x);
  }

  vi.prototype = {
    positions: [],
    position: null,
    init: function init() {
      var n = this;
      this.positions = [], this.position = null;
      var r = !1;
      this.unbind = Tt(document, "mousemove", function (i) {
        r || (setTimeout(function () {
          var t = Date.now(),
              e = n.positions.length;
          e && 100 < t - n.positions[e - 1].time && n.positions.splice(0, e), n.positions.push({
            time: t,
            x: i.pageX,
            y: i.pageY
          }), 5 < n.positions.length && n.positions.shift(), r = !1;
        }, 5), r = !0);
      });
    },
    cancel: function cancel() {
      this.unbind && this.unbind();
    },
    movesTo: function movesTo(t) {
      if (this.positions.length < 2) return !1;
      var e = Le(t),
          i = this.positions[this.positions.length - 1],
          n = this.positions[0];
      if (e.left <= i.x && i.x <= e.right && e.top <= i.y && i.y <= e.bottom) return !1;
      var r = [[{
        x: e.left,
        y: e.top
      }, {
        x: e.right,
        y: e.bottom
      }], [{
        x: e.right,
        y: e.top
      }, {
        x: e.left,
        y: e.bottom
      }]];
      return e.right <= i.x || (e.left >= i.x ? (r[0].reverse(), r[1].reverse()) : e.bottom <= i.y ? r[0].reverse() : e.top >= i.y && r[1].reverse()), !!r.reduce(function (t, e) {
        return t + (wi(n, e[0]) < wi(i, e[0]) && wi(n, e[1]) > wi(i, e[1]));
      }, 0);
    }
  };
  var bi = {};

  function yi(t, e, i) {
    return bi.computed(x(t) ? t.call(i, i) : t, x(e) ? e.call(i, i) : e);
  }

  bi.args = bi.events = bi.init = bi.created = bi.beforeConnect = bi.connected = bi.ready = bi.beforeDisconnect = bi.disconnected = bi.destroy = function (t, e) {
    return t = t && !y(t) ? [t] : t, e ? t ? t.concat(e) : y(e) ? e : [e] : t;
  }, bi.update = function (t, e) {
    return bi.args(t, x(e) ? {
      read: e
    } : e);
  }, bi.props = function (t, e) {
    return y(e) && (e = e.reduce(function (t, e) {
      return t[e] = String, t;
    }, {})), bi.methods(t, e);
  }, bi.computed = bi.methods = function (t, e) {
    return e ? t ? Y({}, t, e) : e : t;
  }, bi.data = function (e, i, t) {
    return t ? yi(e, i, t) : i ? e ? function (t) {
      return yi(e, i, t);
    } : i : e;
  };

  var xi = function xi(t, e) {
    return D(e) ? t : e;
  };

  function ki(e, i, n) {
    var r = {};
    if (x(i) && (i = i.options), i.extends && (e = ki(e, i.extends, n)), i.mixins) for (var t = 0, o = i.mixins.length; t < o; t++) {
      e = ki(e, i.mixins[t], n);
    }

    for (var s in e) {
      l(s);
    }

    for (var a in i) {
      h(e, a) || l(a);
    }

    function l(t) {
      r[t] = (bi[t] || xi)(e[t], i[t], n);
    }

    return r;
  }

  function $i(t, e) {
    var i;
    void 0 === e && (e = []);

    try {
      return t ? v(t, "{") ? JSON.parse(t) : e.length && !b(t, ":") ? ((i = {})[e[0]] = t, i) : t.split(";").reduce(function (t, e) {
        var i = e.split(/:(.*)/),
            n = i[0],
            r = i[1];
        return n && !D(r) && (t[n.trim()] = r.trim()), t;
      }, {}) : {};
    } catch (t) {
      return {};
    }
  }

  var Ii = 0,
      Si = function Si(t) {
    this.id = ++Ii, this.el = H(t);
  };

  function Ti(t, e) {
    try {
      t.contentWindow.postMessage(JSON.stringify(Y({
        event: "command"
      }, e)), "*");
    } catch (t) {}
  }

  Si.prototype.isVideo = function () {
    return this.isYoutube() || this.isVimeo() || this.isHTML5();
  }, Si.prototype.isHTML5 = function () {
    return "VIDEO" === this.el.tagName;
  }, Si.prototype.isIFrame = function () {
    return "IFRAME" === this.el.tagName;
  }, Si.prototype.isYoutube = function () {
    return this.isIFrame() && !!this.el.src.match(/\/\/.*?youtube(-nocookie)?\.[a-z]+\/(watch\?v=[^&\s]+|embed)|youtu\.be\/.*/);
  }, Si.prototype.isVimeo = function () {
    return this.isIFrame() && !!this.el.src.match(/vimeo\.com\/video\/.*/);
  }, Si.prototype.enableApi = function () {
    var e = this;
    if (this.ready) return this.ready;
    var i,
        r = this.isYoutube(),
        o = this.isVimeo();
    return r || o ? this.ready = new zt(function (t) {
      var n;
      Ct(e.el, "load", function () {
        if (r) {
          var t = function t() {
            return Ti(e.el, {
              event: "listening",
              id: e.id
            });
          };

          i = setInterval(t, 100), t();
        }
      }), (n = function n(t) {
        return r && t.id === e.id && "onReady" === t.event || o && Number(t.player_id) === e.id;
      }, new zt(function (i) {
        Ct(window, "message", function (t, e) {
          return i(e);
        }, !1, function (t) {
          var e = t.data;

          if (e && N(e)) {
            try {
              e = JSON.parse(e);
            } catch (t) {
              return;
            }

            return e && n(e);
          }
        });
      })).then(function () {
        t(), i && clearInterval(i);
      }), Z(e.el, "src", e.el.src + (b(e.el.src, "?") ? "&" : "?") + (r ? "enablejsapi=1" : "api=1&player_id=" + e.id));
    }) : zt.resolve();
  }, Si.prototype.play = function () {
    var t = this;
    if (this.isVideo()) if (this.isIFrame()) this.enableApi().then(function () {
      return Ti(t.el, {
        func: "playVideo",
        method: "play"
      });
    });else if (this.isHTML5()) try {
      var e = this.el.play();
      e && e.catch(X);
    } catch (t) {}
  }, Si.prototype.pause = function () {
    var t = this;
    this.isVideo() && (this.isIFrame() ? this.enableApi().then(function () {
      return Ti(t.el, {
        func: "pauseVideo",
        method: "pause"
      });
    }) : this.isHTML5() && this.el.pause());
  }, Si.prototype.mute = function () {
    var t = this;
    this.isVideo() && (this.isIFrame() ? this.enableApi().then(function () {
      return Ti(t.el, {
        func: "mute",
        method: "setVolume",
        value: 0
      });
    }) : this.isHTML5() && (this.el.muted = !0, Z(this.el, "muted", "")));
  };

  var Ei,
      Ci,
      _i,
      Ai,
      Ni = {};

  function Oi() {
    Ei && clearTimeout(Ei), Ci && clearTimeout(Ci), _i && clearTimeout(_i), Ei = Ci = _i = null, Ni = {};
  }

  Rt(function () {
    Tt(document, "click", function () {
      return Ai = !0;
    }, !0), Tt(document, li, function (t) {
      var e = t.target,
          i = Bi(t),
          n = i.x,
          r = i.y,
          o = Date.now(),
          s = zi(t.type);
      Ni.type && Ni.type !== s || (Ni.el = "tagName" in e ? e : e.parentNode, Ei && clearTimeout(Ei), Ni.x1 = n, Ni.y1 = r, Ni.last && o - Ni.last <= 250 && (Ni = {}), Ni.type = s, Ni.last = o, Ai = 0 < t.button);
    }), Tt(document, hi, function (t) {
      if (!t.defaultPrevented) {
        var e = Bi(t),
            i = e.x,
            n = e.y;
        Ni.x2 = i, Ni.y2 = n;
      }
    }), Tt(document, ci, function (t) {
      var e = t.type,
          i = t.target;
      Ni.type === zi(e) && (Ni.x2 && 30 < Math.abs(Ni.x1 - Ni.x2) || Ni.y2 && 30 < Math.abs(Ni.y1 - Ni.y2) ? Ci = setTimeout(function () {
        var t, e, i, n, r;
        Ni.el && (_t(Ni.el, "swipe"), _t(Ni.el, "swipe" + (e = (t = Ni).x1, i = t.x2, n = t.y1, r = t.y2, Math.abs(e - i) >= Math.abs(n - r) ? 0 < e - i ? "Left" : "Right" : 0 < n - r ? "Up" : "Down"))), Ni = {};
      }) : "last" in Ni ? (_i = setTimeout(function () {
        return _t(Ni.el, "tap");
      }), Ni.el && "mouseup" !== e && St(i, Ni.el) && (Ei = setTimeout(function () {
        Ei = null, Ni.el && !Ai && _t(Ni.el, "click"), Ni = {};
      }, 350))) : Ni = {});
    }), Tt(document, "touchcancel", Oi), Tt(window, "scroll", Oi);
  });
  var Mi = !1;

  function Di(t) {
    return Mi || "touch" === t.pointerType;
  }

  function Bi(t) {
    var e = t.touches,
        i = t.changedTouches,
        n = e && e[0] || i && i[0] || t;
    return {
      x: n.pageX,
      y: n.pageY
    };
  }

  function zi(t) {
    return t.slice(0, 5);
  }

  function Pi(t) {
    return !(!v(t, "uk-") && !v(t, "data-uk-")) && g(t.replace("data-uk-", "").replace("uk-", ""));
  }

  Tt(document, "touchstart", function () {
    return Mi = !0;
  }, !0), Tt(document, "click", function () {
    Mi = !1;
  }), Tt(document, "touchcancel", function () {
    return Mi = !1;
  }, !0);

  var Hi,
      Wi,
      Li,
      ji,
      Fi = function Fi(t) {
    this._init(t);
  };

  Fi.util = Object.freeze({
    ajax: Ft,
    getImage: Vt,
    transition: Ce,
    Transition: _e,
    animate: Oe,
    Animation: De,
    attr: Z,
    hasAttr: Q,
    removeAttr: tt,
    filterAttr: et,
    data: it,
    addClass: le,
    removeClass: he,
    removeClasses: ce,
    replaceClass: ue,
    hasClass: de,
    toggleClass: fe,
    $: Be,
    $$: ze,
    positionAt: We,
    offset: Le,
    position: Fe,
    height: Ve,
    width: Ye,
    flipPosition: Ke,
    isInView: Ge,
    scrolledOver: Ze,
    scrollTop: Qe,
    isReady: Yt,
    ready: Rt,
    index: qt,
    getIndex: Ut,
    empty: Xt,
    html: Jt,
    prepend: function prepend(e, t) {
      return (e = H(e)).hasChildNodes() ? Qt(t, function (t) {
        return e.insertBefore(t, e.firstChild);
      }) : Kt(e, t);
    },
    append: Kt,
    before: Gt,
    after: Zt,
    remove: te,
    wrapAll: ee,
    wrapInner: ie,
    unwrap: ne,
    fragment: se,
    apply: ae,
    isIE: ni,
    isRtl: ri,
    hasTouch: ai,
    pointerDown: li,
    pointerMove: hi,
    pointerUp: ci,
    pointerEnter: ui,
    pointerLeave: di,
    on: Tt,
    off: Et,
    once: Ct,
    trigger: _t,
    createEvent: At,
    toEventTargets: Dt,
    preventClick: Bt,
    fastdom: fi,
    isVoidElement: yt,
    isVisible: xt,
    selInput: kt,
    isInput: $t,
    filter: It,
    within: St,
    bind: p,
    hasOwn: h,
    hyphenate: m,
    camelize: g,
    ucfirst: a,
    startsWith: v,
    endsWith: u,
    includes: b,
    isArray: y,
    isFunction: x,
    isObject: k,
    isPlainObject: $,
    isWindow: I,
    isDocument: S,
    isJQuery: T,
    isNode: E,
    isNodeCollection: _,
    isBoolean: A,
    isString: N,
    isNumber: O,
    isNumeric: M,
    isUndefined: D,
    toBoolean: B,
    toNumber: z,
    toFloat: P,
    toNode: H,
    toNodes: L,
    toList: j,
    toMs: F,
    swap: V,
    assign: Y,
    each: R,
    sortBy: q,
    clamp: U,
    noop: X,
    intersectRect: J,
    pointInRect: K,
    Dimensions: G,
    MouseTracker: vi,
    mergeOptions: ki,
    parseOptions: $i,
    Player: Si,
    Promise: zt,
    Deferred: Pt,
    query: nt,
    queryAll: rt,
    find: ot,
    findAll: st,
    matches: ft,
    closest: mt,
    parents: gt,
    escape: wt,
    css: be,
    getStyles: ye,
    getStyle: xe,
    getCssVar: $e,
    propName: Se,
    isTouch: Di,
    getPos: Bi
  }), Fi.data = "__uikit__", Fi.prefix = "uk-", Fi.options = {}, function (i) {
    var e,
        n = i.data;

    function r(t, e) {
      if (t) for (var i in t) {
        t[i]._isReady && t[i]._callUpdate(e);
      }
    }

    i.use = function (t) {
      if (!t.installed) return t.call(null, this), t.installed = !0, this;
    }, i.mixin = function (t, e) {
      e = (N(e) ? i.component(e) : e) || this, (t = ki({}, t)).mixins = e.options.mixins, delete e.options.mixins, e.options = ki(t, e.options);
    }, i.extend = function (t) {
      t = t || {};

      var e = function e(t) {
        this._init(t);
      };

      return ((e.prototype = Object.create(this.prototype)).constructor = e).options = ki(this.options, t), e.super = this, e.extend = this.extend, e;
    }, i.update = function (t, e) {
      e = At(e || "update"), function (t) {
        for (var e = []; t && t !== document.body && t.parentNode;) {
          t = t.parentNode, e.unshift(t);
        }

        return e;
      }(t = t ? H(t) : document.body).map(function (t) {
        return r(t[n], e);
      }), ae(t, function (t) {
        return r(t[n], e);
      });
    }, Object.defineProperty(i, "container", {
      get: function get() {
        return e || document.body;
      },
      set: function set(t) {
        e = Be(t);
      }
    });
  }(Fi), (Hi = Fi).prototype._callHook = function (t) {
    var e = this,
        i = this.$options[t];
    i && i.forEach(function (t) {
      return t.call(e);
    });
  }, Hi.prototype._callConnected = function () {
    var t = this;
    this._connected || (this._data = {}, this._initProps(), this._callHook("beforeConnect"), this._connected = !0, this._initEvents(), this._initObserver(), this._callHook("connected"), this._isReady || Rt(function () {
      return t._callReady();
    }), this._callUpdate());
  }, Hi.prototype._callDisconnected = function () {
    this._connected && (this._callHook("beforeDisconnect"), this._observer && (this._observer.disconnect(), this._observer = null), this._unbindEvents(), this._callHook("disconnected"), this._connected = !1);
  }, Hi.prototype._callReady = function () {
    this._isReady || (this._isReady = !0, this._callHook("ready"), this._resetComputeds(), this._callUpdate());
  }, Hi.prototype._callUpdate = function (o) {
    var s = this,
        a = (o = At(o || "update")).type;
    b(["update", "load", "resize"], a) && this._resetComputeds();
    var t = this.$options.update,
        e = this._frames,
        l = e.reads,
        h = e.writes;
    t && t.forEach(function (t, e) {
      var i = t.read,
          n = t.write,
          r = t.events;
      ("update" === a || b(r, a)) && (i && !b(fi.reads, l[e]) && (l[e] = fi.read(function () {
        var t = s._connected && i.call(s, s._data, o);
        !1 === t && n ? (fi.clear(h[e]), delete h[e]) : $(t) && Y(s._data, t), delete l[e];
      })), n && !b(fi.writes, h[e]) && (h[e] = fi.write(function () {
        s._connected && n.call(s, s._data, o), delete h[e];
      })));
    });
  }, function (t) {
    var e = 0;

    function s(t, e) {
      var i = {},
          n = t.args;
      void 0 === n && (n = []);
      var r = t.props;
      void 0 === r && (r = {});
      var o = t.el;
      if (!r) return i;

      for (var s in r) {
        var a = m(s),
            l = it(o, a);

        if (!D(l)) {
          if (l = d(r[s], l), "target" === a && (!l || v(l, "_"))) continue;
          i[s] = l;
        }
      }

      var h = $i(it(o, e), n);

      for (var c in h) {
        var u = g(c);
        void 0 !== r[u] && (i[u] = d(r[u], h[c]));
      }

      return i;
    }

    function i(n, r, o) {
      Object.defineProperty(n, r, {
        enumerable: !0,
        get: function get() {
          var t = n._computeds,
              e = n.$props,
              i = n.$el;
          return h(t, r) || (t[r] = o.call(n, e, i)), t[r];
        },
        set: function set(t) {
          n._computeds[r] = t;
        }
      });
    }

    function f(e, i, n) {
      $(i) || (i = {
        name: n,
        handler: i
      });
      var r,
          o,
          t = i.name,
          s = i.el,
          a = i.handler,
          l = i.capture,
          h = i.passive,
          c = i.delegate,
          u = i.filter,
          d = i.self;
      s = x(s) ? s.call(e) : s || e.$el, y(s) ? s.forEach(function (t) {
        return f(e, Y({}, i, {
          el: t
        }), n);
      }) : !s || u && !u.call(e) || (r = N(a) ? e[a] : p(a, e), a = function a(t) {
        return y(t.detail) ? r.apply(void 0, [t].concat(t.detail)) : r(t);
      }, d && (o = a, a = function a(t) {
        if (t.target === t.currentTarget || t.target === t.current) return o.call(null, t);
      }), e._events.push(Tt(s, t, c ? N(c) ? c : c.call(e) : null, a, A(h) ? {
        passive: h,
        capture: l
      } : l)));
    }

    function n(t, e) {
      return t.every(function (t) {
        return !t || !h(t, e);
      });
    }

    function d(t, e) {
      return t === Boolean ? B(e) : t === Number ? z(e) : "list" === t ? j(e) : "media" === t ? function (t) {
        if (N(t)) if ("@" === t[0]) {
          var e = "media-" + t.substr(1);
          t = P($e(e));
        } else if (isNaN(t)) return t;
        return !(!t || isNaN(t)) && "(min-width: " + t + "px)";
      }(e) : t ? t(e) : e;
    }

    t.prototype._init = function (t) {
      (t = t || {}).data = function (t, e) {
        var i = t.data,
            n = (t.el, e.args),
            r = e.props;
        if (void 0 === r && (r = {}), i = y(i) ? n && n.length ? i.slice(0, n.length).reduce(function (t, e, i) {
          return $(e) ? Y(t, e) : t[n[i]] = e, t;
        }, {}) : void 0 : i) for (var o in i) {
          D(i[o]) ? delete i[o] : i[o] = r[o] ? d(r[o], i[o]) : i[o];
        }
        return i;
      }(t, this.constructor.options), this.$options = ki(this.constructor.options, t, this), this.$el = null, this.$props = {}, this._frames = {
        reads: {},
        writes: {}
      }, this._events = [], this._uid = e++, this._initData(), this._initMethods(), this._initComputeds(), this._callHook("created"), t.el && this.$mount(t.el);
    }, t.prototype._initData = function () {
      var t = this.$options.data;

      for (var e in void 0 === t && (t = {}), t) {
        this.$props[e] = this[e] = t[e];
      }
    }, t.prototype._initMethods = function () {
      var t = this.$options.methods;
      if (t) for (var e in t) {
        this[e] = p(t[e], this);
      }
    }, t.prototype._initComputeds = function () {
      var t = this.$options.computed;
      if (this._resetComputeds(), t) for (var e in t) {
        i(this, e, t[e]);
      }
    }, t.prototype._resetComputeds = function () {
      this._computeds = {};
    }, t.prototype._initProps = function (t) {
      var e;

      for (e in this._resetComputeds(), t = t || s(this.$options, this.$name)) {
        D(t[e]) || (this.$props[e] = t[e]);
      }

      var i = [this.$options.computed, this.$options.methods];

      for (e in this.$props) {
        e in t && n(i, e) && (this[e] = this.$props[e]);
      }
    }, t.prototype._initEvents = function () {
      var i = this,
          t = this.$options.events;
      t && t.forEach(function (t) {
        if (h(t, "handler")) f(i, t);else for (var e in t) {
          f(i, t[e], e);
        }
      });
    }, t.prototype._unbindEvents = function () {
      this._events.forEach(function (t) {
        return t();
      }), this._events = [];
    }, t.prototype._initObserver = function () {
      var i = this,
          t = this.$options,
          n = t.attrs,
          e = t.props,
          r = t.el;

      if (!this._observer && e && n) {
        n = y(n) ? n : Object.keys(e), this._observer = new MutationObserver(function () {
          var e = s(i.$options, i.$name);
          n.some(function (t) {
            return !D(e[t]) && e[t] !== i.$props[t];
          }) && i.$reset();
        });
        var o = n.map(function (t) {
          return m(t);
        }).concat(this.$name);

        this._observer.observe(r, {
          attributes: !0,
          attributeFilter: o.concat(o.map(function (t) {
            return "data-" + t;
          }))
        });
      }
    };
  }(Fi), Li = (Wi = Fi).data, ji = {}, Wi.component = function (s, t) {
    if (!t) return $(ji[s]) && (ji[s] = Wi.extend(ji[s])), ji[s];

    Wi[s] = function (t, i) {
      for (var e = arguments.length, n = Array(e); e--;) {
        n[e] = arguments[e];
      }

      var r = Wi.component(s);
      return $(t) ? new r({
        data: t
      }) : r.options.functional ? new r({
        data: [].concat(n)
      }) : t && t.nodeType ? o(t) : ze(t).map(o)[0];

      function o(t) {
        var e = Wi.getComponent(t, s);

        if (e) {
          if (!i) return e;
          e.$destroy();
        }

        return new r({
          el: t,
          data: i
        });
      }
    };

    var e = $(t) ? Y({}, t) : t.options;

    if (e.name = s, e.install && e.install(Wi, e, s), Wi._initialized && !e.functional) {
      var i = m(s);
      fi.read(function () {
        return Wi[s]("[uk-" + i + "],[data-uk-" + i + "]");
      });
    }

    return ji[s] = $(t) ? e : t;
  }, Wi.getComponents = function (t) {
    return t && t[Li] || {};
  }, Wi.getComponent = function (t, e) {
    return Wi.getComponents(t)[e];
  }, Wi.connect = function (t) {
    if (t[Li]) for (var e in t[Li]) {
      t[Li][e]._callConnected();
    }

    for (var i = 0; i < t.attributes.length; i++) {
      var n = Pi(t.attributes[i].name);
      n && n in ji && Wi[n](t);
    }
  }, Wi.disconnect = function (t) {
    for (var e in t[Li]) {
      t[Li][e]._callDisconnected();
    }
  }, function (n) {
    var r = n.data;
    n.prototype.$mount = function (t) {
      var e = this.$options.name;
      t[r] || (t[r] = {}), t[r][e] || ((t[r][e] = this).$el = this.$options.el = this.$options.el || t, this._callHook("init"), St(t, document) && this._callConnected());
    }, n.prototype.$emit = function (t) {
      this._callUpdate(t);
    }, n.prototype.$reset = function () {
      this._callDisconnected(), this._callConnected();
    }, n.prototype.$destroy = function (t) {
      void 0 === t && (t = !1);
      var e = this.$options,
          i = e.el,
          n = e.name;
      i && this._callDisconnected(), this._callHook("destroy"), i && i[r] && (delete i[r][n], Object.keys(i[r]).length || delete i[r], t && te(this.$el));
    }, n.prototype.$create = function (t, e, i) {
      return n[t](e, i);
    }, n.prototype.$update = n.update, n.prototype.$getComponent = n.getComponent;
    var e = {};
    Object.defineProperties(n.prototype, {
      $container: Object.getOwnPropertyDescriptor(n, "container"),
      $name: {
        get: function get() {
          var t = this.$options.name;
          return e[t] || (e[t] = n.prefix + m(t)), e[t];
        }
      }
    });
  }(Fi);
  var Vi = {
    connected: function connected() {
      le(this.$el, this.$name);
    }
  },
      Yi = {
    props: {
      cls: Boolean,
      animation: "list",
      duration: Number,
      origin: String,
      transition: String,
      queued: Boolean
    },
    data: {
      cls: !1,
      animation: [!1],
      duration: 200,
      origin: !1,
      transition: "linear",
      queued: !1,
      initProps: {
        overflow: "",
        height: "",
        paddingTop: "",
        paddingBottom: "",
        marginTop: "",
        marginBottom: ""
      },
      hideProps: {
        overflow: "hidden",
        height: 0,
        paddingTop: 0,
        paddingBottom: 0,
        marginTop: 0,
        marginBottom: 0
      }
    },
    computed: {
      hasAnimation: function hasAnimation(t) {
        return !!t.animation[0];
      },
      hasTransition: function hasTransition(t) {
        var e = t.animation;
        return this.hasAnimation && !0 === e[0];
      }
    },
    methods: {
      toggleElement: function toggleElement(h, c, u) {
        var d = this;
        return new zt(function (t) {
          h = L(h);

          var e,
              i = function i(t) {
            return zt.all(t.map(function (t) {
              return d._toggleElement(t, c, u);
            }));
          },
              n = h.filter(function (t) {
            return d.isToggled(t);
          }),
              r = h.filter(function (t) {
            return !b(n, t);
          });

          if (d.queued && D(u) && D(c) && d.hasAnimation && !(h.length < 2)) {
            var o = document.body,
                s = o.scrollTop,
                a = n[0],
                l = De.inProgress(a) && de(a, "uk-animation-leave") || _e.inProgress(a) && "0px" === a.style.height;
            e = i(n), l || (e = e.then(function () {
              var t = i(r);
              return o.scrollTop = s, t;
            }));
          } else e = i(r.concat(n));

          e.then(t, X);
        });
      },
      toggleNow: function toggleNow(e, i) {
        var n = this;
        return new zt(function (t) {
          return zt.all(L(e).map(function (t) {
            return n._toggleElement(t, i, !1);
          })).then(t, X);
        });
      },
      isToggled: function isToggled(t) {
        var e = L(t || this.$el);
        return this.cls ? de(e, this.cls.split(" ")[0]) : !Q(e, "hidden");
      },
      updateAria: function updateAria(t) {
        !1 === this.cls && Z(t, "aria-hidden", !this.isToggled(t));
      },
      _toggleElement: function _toggleElement(t, e, i) {
        var n = this;
        if (e = A(e) ? e : De.inProgress(t) ? de(t, "uk-animation-leave") : _e.inProgress(t) ? "0px" === t.style.height : !this.isToggled(t), !_t(t, "before" + (e ? "show" : "hide"), [this])) return zt.reject();
        var r = (!1 !== i && this.hasAnimation ? this.hasTransition ? this._toggleHeight : this._toggleAnimation : this._toggleImmediate)(t, e);
        return _t(t, e ? "show" : "hide", [this]), r.then(function () {
          _t(t, e ? "shown" : "hidden", [n]), n.$update(t);
        });
      },
      _toggle: function _toggle(t, e) {
        var i;
        t && (this.cls ? (i = b(this.cls, " ") || Boolean(e) !== de(t, this.cls)) && fe(t, this.cls, b(this.cls, " ") ? void 0 : e) : (i = Boolean(e) === Q(t, "hidden")) && Z(t, "hidden", e ? null : ""), ze("[autofocus]", t).some(function (t) {
          return xt(t) && (t.focus() || !0);
        }), this.updateAria(t), i && this.$update(t));
      },
      _toggleImmediate: function _toggleImmediate(t, e) {
        return this._toggle(t, e), zt.resolve();
      },
      _toggleHeight: function _toggleHeight(t, e) {
        var i = this,
            n = _e.inProgress(t),
            r = t.hasChildNodes ? P(be(t.firstElementChild, "marginTop")) + P(be(t.lastElementChild, "marginBottom")) : 0,
            o = xt(t) ? Ve(t) + (n ? 0 : r) : 0;

        _e.cancel(t), this.isToggled(t) || this._toggle(t, !0), Ve(t, ""), fi.flush();
        var s = Ve(t) + (n ? 0 : r);
        return Ve(t, o), (e ? _e.start(t, Y({}, this.initProps, {
          overflow: "hidden",
          height: s
        }), Math.round(this.duration * (1 - o / s)), this.transition) : _e.start(t, this.hideProps, Math.round(this.duration * (o / s)), this.transition).then(function () {
          return i._toggle(t, !1);
        })).then(function () {
          return be(t, i.initProps);
        });
      },
      _toggleAnimation: function _toggleAnimation(t, e) {
        var i = this;
        return De.cancel(t), e ? (this._toggle(t, !0), De.in(t, this.animation[0], this.duration, this.origin)) : De.out(t, this.animation[1] || this.animation[0], this.duration, this.origin).then(function () {
          return i._toggle(t, !1);
        });
      }
    }
  },
      Ri = {
    mixins: [Vi, Yi],
    props: {
      targets: String,
      active: null,
      collapsible: Boolean,
      multiple: Boolean,
      toggle: String,
      content: String,
      transition: String
    },
    data: {
      targets: "> *",
      active: !1,
      animation: [!0],
      collapsible: !0,
      multiple: !1,
      clsOpen: "uk-open",
      toggle: "> .uk-accordion-title",
      content: "> .uk-accordion-content",
      transition: "ease"
    },
    computed: {
      items: function items(t, e) {
        return ze(t.targets, e);
      }
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return this.targets + " " + this.$props.toggle;
      },
      handler: function handler(t) {
        t.preventDefault(), this.toggle(qt(ze(this.targets + " " + this.$props.toggle, this.$el), t.current));
      }
    }],
    connected: function connected() {
      if (!1 !== this.active) {
        var t = this.items[Number(this.active)];
        t && !de(t, this.clsOpen) && this.toggle(t, !1);
      }
    },
    update: function update() {
      var e = this;
      this.items.forEach(function (t) {
        return e._toggleImmediate(Be(e.content, t), de(t, e.clsOpen));
      });
      var t = !this.collapsible && !de(this.items, this.clsOpen) && this.items[0];
      t && this.toggle(t, !1);
    },
    methods: {
      toggle: function toggle(r, o) {
        var s = this,
            t = Ut(r, this.items),
            a = It(this.items, "." + this.clsOpen);
        (r = this.items[t]) && [r].concat(!this.multiple && !b(a, r) && a || []).forEach(function (t) {
          var e = t === r,
              i = e && !de(t, s.clsOpen);

          if (i || !e || s.collapsible || !(a.length < 2)) {
            fe(t, s.clsOpen, i);
            var n = t._wrapper ? t._wrapper.firstElementChild : Be(s.content, t);
            t._wrapper || (t._wrapper = ee(n, "<div>"), Z(t._wrapper, "hidden", i ? "" : null)), s._toggleImmediate(n, !0), s.toggleElement(t._wrapper, i, o).then(function () {
              de(t, s.clsOpen) === i && (i || s._toggleImmediate(n, !1), t._wrapper = null, ne(n));
            });
          }
        });
      }
    }
  },
      qi = {
    mixins: [Vi, Yi],
    args: "animation",
    attrs: !0,
    props: {
      close: String
    },
    data: {
      animation: [!0],
      selClose: ".uk-alert-close",
      duration: 150,
      hideProps: Y({
        opacity: 0
      }, Yi.data.hideProps)
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return this.selClose;
      },
      handler: function handler(t) {
        t.preventDefault(), this.close();
      }
    }],
    methods: {
      close: function close() {
        var t = this;
        this.toggleElement(this.$el).then(function () {
          return t.$destroy(!0);
        });
      }
    }
  };

  function Ui(o) {
    Rt(function () {
      var i = 0,
          n = 0;

      if (Tt(window, "load resize", function (t) {
        return o.update(null, t);
      }), Tt(window, "scroll", function (t) {
        var e = t.target;
        t.dir = i <= window.pageYOffset ? "down" : "up", t.pageYOffset = i = window.pageYOffset, o.update(1 !== e.nodeType ? document.body : e, t);
      }, {
        passive: !0,
        capture: !0
      }), Tt(document, "loadedmetadata load", function (t) {
        var e = t.target;
        return o.update(e, "load");
      }, !0), Tt(document, "animationstart", function (t) {
        var e = t.target;
        (be(e, "animationName") || "").match(/^uk-.*(left|right)/) && (n++, be(document.body, "overflowX", "hidden"), setTimeout(function () {
          --n || be(document.body, "overflowX", "");
        }, F(be(e, "animationDuration")) + 100));
      }, !0), ai) {
        var r = "uk-hover";
        Tt(document, "tap", function (t) {
          var e = t.target;
          return ze("." + r).forEach(function (t) {
            return !St(e, t) && he(t, r);
          });
        }), Object.defineProperty(o, "hoverSelector", {
          set: function set(t) {
            Tt(document, "tap", t, function (t) {
              return le(t.current, r);
            });
          }
        }), o.hoverSelector = ".uk-animation-toggle, .uk-transition-toggle, [uk-hover]";
      }
    });
  }

  var Xi,
      Ji,
      Ki = {
    args: "autoplay",
    props: {
      automute: Boolean,
      autoplay: Boolean
    },
    data: {
      automute: !1,
      autoplay: !0
    },
    computed: {
      inView: function inView(t) {
        return "inview" === t.autoplay;
      }
    },
    connected: function connected() {
      this.inView && !Q(this.$el, "preload") && (this.$el.preload = "none");
    },
    ready: function ready() {
      this.player = new Si(this.$el), this.automute && this.player.mute();
    },
    update: [{
      read: function read(t, e) {
        var i = e.type;
        return !(!this.player || !("scroll" !== i && "resize" !== i || this.inView)) && {
          visible: xt(this.$el) && "hidden" !== be(this.$el, "visibility"),
          inView: this.inView && Ge(this.$el)
        };
      },
      write: function write(t) {
        var e = t.visible,
            i = t.inView;
        !e || this.inView && !i ? this.player.pause() : (!0 === this.autoplay || this.inView && i) && this.player.play();
      },
      events: ["load", "resize", "scroll"]
    }]
  },
      Gi = {
    mixins: [Vi, Ki],
    props: {
      width: Number,
      height: Number
    },
    data: {
      automute: !0
    },
    update: {
      read: function read() {
        var t = this.$el;
        if (!xt(t)) return !1;
        var e = t.parentNode;
        return {
          height: e.offsetHeight,
          width: e.offsetWidth
        };
      },
      write: function write(t) {
        var e = t.height,
            i = t.width,
            n = this.$el,
            r = this.width || n.naturalWidth || n.videoWidth || n.clientWidth,
            o = this.height || n.naturalHeight || n.videoHeight || n.clientHeight;
        r && o && be(n, G.cover({
          width: r,
          height: o
        }, {
          width: i + (i % 2 ? 1 : 0),
          height: e + (e % 2 ? 1 : 0)
        }));
      },
      events: ["load", "resize"]
    }
  },
      Zi = {
    props: {
      pos: String,
      offset: null,
      flip: Boolean,
      clsPos: String
    },
    data: {
      pos: "bottom-" + (ri ? "right" : "left"),
      flip: !0,
      offset: !1,
      clsPos: ""
    },
    computed: {
      pos: function pos(t) {
        var e = t.pos;
        return (e + (b(e, "-") ? "" : "-center")).split("-");
      },
      dir: function dir() {
        return this.pos[0];
      },
      align: function align() {
        return this.pos[1];
      }
    },
    methods: {
      positionAt: function positionAt(t, e, i) {
        var n;
        ce(t, this.clsPos + "-(top|bottom|left|right)(-[a-z]+)?"), be(t, {
          top: "",
          left: ""
        });
        var r = this.offset;
        r = M(r) ? r : (n = Be(r)) ? Le(n)["x" === o ? "left" : "top"] - Le(e)["x" === o ? "right" : "bottom"] : 0;
        var o = this.getAxis(),
            s = We(t, e, "x" === o ? Ke(this.dir) + " " + this.align : this.align + " " + Ke(this.dir), "x" === o ? this.dir + " " + this.align : this.align + " " + this.dir, "x" === o ? "" + ("left" === this.dir ? -r : r) : " " + ("top" === this.dir ? -r : r), null, this.flip, i).target,
            a = s.x,
            l = s.y;
        this.dir = "x" === o ? a : l, this.align = "x" === o ? l : a, fe(t, this.clsPos + "-" + this.dir + "-" + this.align, !1 === this.offset);
      },
      getAxis: function getAxis() {
        return "top" === this.dir || "bottom" === this.dir ? "y" : "x";
      }
    }
  },
      Qi = {
    mixins: [Zi, Yi],
    args: "pos",
    props: {
      mode: "list",
      toggle: Boolean,
      boundary: Boolean,
      boundaryAlign: Boolean,
      delayShow: Number,
      delayHide: Number,
      clsDrop: String
    },
    data: {
      mode: ["click", "hover"],
      toggle: "- *",
      boundary: window,
      boundaryAlign: !1,
      delayShow: 0,
      delayHide: 800,
      clsDrop: !1,
      hoverIdle: 200,
      animation: ["uk-animation-fade"],
      cls: "uk-open"
    },
    computed: {
      boundary: function boundary(t, e) {
        return nt(t.boundary, e);
      },
      clsDrop: function clsDrop(t) {
        return t.clsDrop || "uk-" + this.$options.name;
      },
      clsPos: function clsPos() {
        return this.clsDrop;
      }
    },
    init: function init() {
      this.tracker = new vi();
    },
    connected: function connected() {
      le(this.$el, this.clsDrop);
      var t = this.$props.toggle;
      this.toggle = t && this.$create("toggle", nt(t, this.$el), {
        target: this.$el,
        mode: this.mode
      }), this.updateAria(this.$el);
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return "." + this.clsDrop + "-close";
      },
      handler: function handler(t) {
        t.preventDefault(), this.hide(!1);
      }
    }, {
      name: "click",
      delegate: function delegate() {
        return 'a[href^="#"]';
      },
      handler: function handler(t) {
        if (!t.defaultPrevented) {
          var e = t.target.hash;
          e || t.preventDefault(), e && St(e, this.$el) || this.hide(!1);
        }
      }
    }, {
      name: "beforescroll",
      handler: function handler() {
        this.hide(!1);
      }
    }, {
      name: "toggle",
      self: !0,
      handler: function handler(t, e) {
        t.preventDefault(), this.isToggled() ? this.hide(!1) : this.show(e, !1);
      }
    }, {
      name: ui,
      filter: function filter() {
        return b(this.mode, "hover");
      },
      handler: function handler(t) {
        Di(t) || (Xi && Xi !== this && Xi.toggle && b(Xi.toggle.mode, "hover") && !St(t.target, Xi.toggle.$el) && !K({
          x: t.pageX,
          y: t.pageY
        }, Le(Xi.$el)) && Xi.hide(!1), t.preventDefault(), this.show(this.toggle));
      }
    }, {
      name: "toggleshow",
      handler: function handler(t, e) {
        e && !b(e.target, this.$el) || (t.preventDefault(), this.show(e || this.toggle));
      }
    }, {
      name: "togglehide " + di,
      handler: function handler(t, e) {
        Di(t) || e && !b(e.target, this.$el) || (t.preventDefault(), this.toggle && b(this.toggle.mode, "hover") && this.hide());
      }
    }, {
      name: "beforeshow",
      self: !0,
      handler: function handler() {
        this.clearTimers(), De.cancel(this.$el), this.position();
      }
    }, {
      name: "show",
      self: !0,
      handler: function handler() {
        this.tracker.init(), this.toggle && (le(this.toggle.$el, this.cls), Z(this.toggle.$el, "aria-expanded", "true")), function () {
          if (Ji) return;
          Ji = !0, Tt(document, "click", function (t) {
            var e,
                i = t.target,
                n = t.defaultPrevented;
            if (!n) for (; Xi && Xi !== e && !St(i, Xi.$el) && (!Xi.toggle || !St(i, Xi.toggle.$el));) {
              (e = Xi).hide(!1);
            }
          });
        }();
      }
    }, {
      name: "beforehide",
      self: !0,
      handler: function handler() {
        this.clearTimers();
      }
    }, {
      name: "hide",
      handler: function handler(t) {
        var e = t.target;
        this.$el === e ? (Xi = this.isActive() ? null : Xi, this.toggle && (he(this.toggle.$el, this.cls), Z(this.toggle.$el, "aria-expanded", "false"), this.toggle.$el.blur(), ze("a, button", this.toggle.$el).forEach(function (t) {
          return t.blur();
        })), this.tracker.cancel()) : Xi = null === Xi && St(e, this.$el) && this.isToggled() ? this : Xi;
      }
    }],
    update: {
      write: function write() {
        this.isToggled() && !De.inProgress(this.$el) && this.position();
      },
      events: ["resize"]
    },
    methods: {
      show: function show(e, i) {
        var n = this;
        void 0 === i && (i = !0);

        var r = function r() {
          return !n.isToggled() && n.toggleElement(n.$el, !0);
        },
            t = function t() {
          if (n.toggle = e || n.toggle, n.clearTimers(), !n.isActive()) if (i && Xi && Xi !== n && Xi.isDelaying) n.showTimer = setTimeout(n.show, 10);else {
            if (n.isParentOf(Xi)) {
              if (!Xi.hideTimer) return;
              Xi.hide(!1);
            } else if (Xi && !n.isChildOf(Xi) && !n.isParentOf(Xi)) for (var t; Xi && Xi !== t && !n.isChildOf(Xi);) {
              (t = Xi).hide(!1);
            }

            i && n.delayShow ? n.showTimer = setTimeout(r, n.delayShow) : r(), Xi = n;
          }
        };

        e && this.toggle && e.$el !== this.toggle.$el ? (Ct(this.$el, "hide", t), this.hide(!1)) : t();
      },
      hide: function hide(t) {
        var e = this;
        void 0 === t && (t = !0);

        var i = function i() {
          return e.toggleNow(e.$el, !1);
        };

        this.clearTimers(), this.isDelaying = this.tracker.movesTo(this.$el), t && this.isDelaying ? this.hideTimer = setTimeout(this.hide, this.hoverIdle) : t && this.delayHide ? this.hideTimer = setTimeout(i, this.delayHide) : i();
      },
      clearTimers: function clearTimers() {
        clearTimeout(this.showTimer), clearTimeout(this.hideTimer), this.showTimer = null, this.hideTimer = null, this.isDelaying = !1;
      },
      isActive: function isActive() {
        return Xi === this;
      },
      isChildOf: function isChildOf(t) {
        return t && t !== this && St(this.$el, t.$el);
      },
      isParentOf: function isParentOf(t) {
        return t && t !== this && St(t.$el, this.$el);
      },
      position: function position() {
        ce(this.$el, this.clsDrop + "-(stack|boundary)"), be(this.$el, {
          top: "",
          left: "",
          display: "block"
        }), fe(this.$el, this.clsDrop + "-boundary", this.boundaryAlign);
        var t = Le(this.boundary),
            e = this.boundaryAlign ? t : Le(this.toggle.$el);

        if ("justify" === this.align) {
          var i = "y" === this.getAxis() ? "width" : "height";
          be(this.$el, i, e[i]);
        } else this.$el.offsetWidth > Math.max(t.right - e.left, e.right - t.left) && le(this.$el, this.clsDrop + "-stack");

        this.positionAt(this.$el, this.boundaryAlign ? this.boundary : this.toggle.$el, this.boundary), be(this.$el, "display", "");
      }
    }
  };
  var tn = {
    extends: Qi
  },
      en = {
    mixins: [Vi],
    args: "target",
    props: {
      target: Boolean
    },
    data: {
      target: !1
    },
    computed: {
      input: function input(t, e) {
        return Be(kt, e);
      },
      state: function state() {
        return this.input.nextElementSibling;
      },
      target: function target(t, e) {
        var i = t.target;
        return i && (!0 === i && this.input.parentNode === e && this.input.nextElementSibling || nt(i, e));
      }
    },
    update: function update() {
      var t = this.target,
          e = this.input;

      if (t) {
        var i,
            n = $t(t) ? "value" : "textContent",
            r = t[n],
            o = e.files && e.files[0] ? e.files[0].name : ft(e, "select") && (i = ze("option", e).filter(function (t) {
          return t.selected;
        })[0]) ? i.textContent : e.value;
        r !== o && (t[n] = o);
      }
    },
    events: [{
      name: "focusin focusout mouseenter mouseleave",
      delegate: kt,
      handler: function handler(t) {
        var e = t.type;
        t.current === this.input && fe(this.state, "uk-" + (b(e, "focus") ? "focus" : "hover"), b(["focusin", "mouseenter"], e));
      }
    }, {
      name: "change",
      handler: function handler() {
        this.$emit();
      }
    }]
  },
      nn = {
    update: {
      read: function read(t) {
        var e = Ge(this.$el);
        if (!e || t.isInView === e) return !1;
        t.isInView = e;
      },
      write: function write() {
        this.$el.src = this.$el.src;
      },
      events: ["scroll", "load", "resize"]
    }
  },
      rn = {
    props: {
      margin: String,
      firstColumn: Boolean
    },
    data: {
      margin: "uk-margin-small-top",
      firstColumn: "uk-first-column"
    },
    update: {
      read: function read(t) {
        var e = this.$el.children;
        if (!e.length || !xt(this.$el)) return t.rows = [[]];
        t.rows = on(e), t.stacks = !t.rows.some(function (t) {
          return 1 < t.length;
        });
      },
      write: function write(t) {
        var n = this;
        t.rows.forEach(function (t, i) {
          return t.forEach(function (t, e) {
            fe(t, n.margin, 0 !== i), fe(t, n.firstColumn, 0 === e);
          });
        });
      },
      events: ["load", "resize"]
    }
  };

  function on(t) {
    for (var e = [[]], i = 0; i < t.length; i++) {
      var n = t[i],
          r = sn(n);
      if (r.height) for (var o = e.length - 1; 0 <= o; o--) {
        var s = e[o];

        if (!s[0]) {
          s.push(n);
          break;
        }

        var a = sn(s[0]);

        if (r.top >= a.bottom - 1) {
          e.push([n]);
          break;
        }

        if (r.bottom > a.top) {
          if (r.left < a.left && !ri) {
            s.unshift(n);
            break;
          }

          s.push(n);
          break;
        }

        if (0 === o) {
          e.unshift([n]);
          break;
        }
      }
    }

    return e;
  }

  function sn(t) {
    var e = t.offsetTop,
        i = t.offsetLeft,
        n = t.offsetHeight;
    return {
      top: e,
      left: i,
      height: n,
      bottom: e + n
    };
  }

  var an = {
    extends: rn,
    mixins: [Vi],
    attrs: !0,
    name: "grid",
    props: {
      masonry: Boolean,
      parallax: Number
    },
    data: {
      margin: "uk-grid-margin",
      clsStack: "uk-grid-stack",
      masonry: !1,
      parallax: 0
    },
    computed: {
      length: function length(t, e) {
        return e.children.length;
      },
      parallax: function parallax(t) {
        var e = t.parallax;
        return e && this.length ? Math.abs(e) : "";
      }
    },
    connected: function connected() {
      this.masonry && le(this.$el, "uk-flex-top uk-flex-wrap-top");
    },
    update: [{
      read: function read(t) {
        var r = t.rows;
        (this.masonry || this.parallax) && (r = r.map(function (t) {
          return q(t, "offsetLeft");
        }));
        var e,
            i,
            n,
            o,
            s,
            a = r.some(function (t) {
          return t.some(function (t) {
            return "static" === be(t, "position");
          });
        }),
            l = !1,
            h = "";

        if (this.masonry && this.length) {
          var c = 0;
          l = r.reduce(function (i, t, n) {
            return i[n] = t.map(function (t, e) {
              return 0 === n ? 0 : P(i[n - 1][e]) + (c - P(r[n - 1][e] && r[n - 1][e].offsetHeight));
            }), c = t.reduce(function (t, e) {
              return Math.max(t, e.offsetHeight);
            }, 0), i;
          }, []), s = r, h = Math.max.apply(Math, s.reduce(function (i, t) {
            return t.forEach(function (t, e) {
              return i[e] = (i[e] || 0) + t.offsetHeight;
            }), i;
          }, [])) + (e = this.$el, i = this.margin, n = L(e.children), P((o = n.filter(function (t) {
            return de(t, i);
          })[0]) ? be(o, "marginTop") : be(n[0], "paddingLeft")) * (r.length - 1));
        }

        return {
          rows: r,
          translates: l,
          height: !!a && h
        };
      },
      write: function write(t) {
        var e = t.stacks,
            i = t.height;
        fe(this.$el, this.clsStack, e), be(this.$el, "paddingBottom", this.parallax), !1 !== i && be(this.$el, "height", i);
      },
      events: ["load", "resize"]
    }, {
      read: function read(t) {
        var e = t.height;
        return {
          scrolled: !!this.parallax && Ze(this.$el, e ? e - Ve(this.$el) : 0) * this.parallax
        };
      },
      write: function write(t) {
        var e = t.rows,
            n = t.scrolled,
            r = t.translates;
        (!1 !== n || r) && e.forEach(function (t, i) {
          return t.forEach(function (t, e) {
            return be(t, "transform", n || r ? "translateY(" + ((r && -r[i][e]) + (n ? e % 2 ? n : n / 8 : 0)) + "px)" : "");
          });
        });
      },
      events: ["scroll", "load", "resize"]
    }]
  };
  var ln = {
    args: "target",
    props: {
      target: String,
      row: Boolean
    },
    data: {
      target: "> *",
      row: !0
    },
    computed: {
      elements: function elements(t, e) {
        return ze(t.target, e);
      }
    },
    update: {
      read: function read() {
        var e = this;
        return be(this.elements, {
          minHeight: "",
          boxSizing: ""
        }), {
          rows: this.row ? on(this.elements).map(function (t) {
            return e.match(t);
          }) : [this.match(this.elements)]
        };
      },
      write: function write(t) {
        t.rows.forEach(function (t) {
          var e = t.height;
          return be(t.elements, {
            minHeight: e,
            boxSizing: "border-box"
          });
        });
      },
      events: ["load", "resize"]
    },
    methods: {
      match: function match(t) {
        if (t.length < 2) return {};
        var i = [],
            n = 0;
        return t.forEach(function (t) {
          var e = Le(t).height;
          n = Math.max(n, e), i.push(e);
        }), t = t.filter(function (t, e) {
          return i[e] < n;
        }), {
          height: n,
          elements: t
        };
      }
    }
  },
      hn = {
    props: {
      expand: Boolean,
      offsetTop: Boolean,
      offsetBottom: Boolean,
      minHeight: Number
    },
    data: {
      expand: !1,
      offsetTop: !1,
      offsetBottom: !1,
      minHeight: 0
    },
    connected: function connected() {
      be(this.$el, "boxSizing", "border-box");
    },
    update: {
      read: function read() {
        var t = Ve(window),
            e = "";
        if (this.expand) e = t - (cn(document.documentElement) - cn(this.$el)) || "";else {
          var i = Le(this.$el).top;
          e = "calc(100vh", i < t / 2 && this.offsetTop && (e += " - " + i + "px"), !0 === this.offsetBottom ? e += " - " + cn(this.$el.nextElementSibling) + "px" : M(this.offsetBottom) ? e += " - " + this.offsetBottom + "vh" : this.offsetBottom && u(this.offsetBottom, "px") ? e += " - " + P(this.offsetBottom) + "px" : N(this.offsetBottom) && (e += " - " + cn(nt(this.offsetBottom, this.$el)) + "px"), e += ")";
        }
        return {
          minHeight: e,
          viewport: t
        };
      },
      write: function write(t) {
        var e,
            i = t.minHeight;
        be(this.$el, {
          height: "",
          minHeight: i
        }), this.minHeight && P(be(this.$el, "minHeight")) < this.minHeight && be(this.$el, "minHeight", this.minHeight), (e = Math.round(P(be(this.$el, "minHeight")))) >= cn(this.$el) && be(this.$el, "height", e);
      },
      events: ["load", "resize"]
    }
  };

  function cn(t) {
    return t && t.offsetHeight || 0;
  }

  var un = {},
      dn = {
    attrs: !0,
    props: {
      id: String,
      icon: String,
      src: String,
      style: String,
      width: Number,
      height: Number,
      ratio: Number,
      class: String
    },
    data: {
      ratio: 1,
      id: !1,
      exclude: ["ratio", "src", "icon"],
      class: ""
    },
    connected: function connected() {
      var t,
          a = this;

      if (this.class += " uk-svg", !this.icon && b(this.src, "#")) {
        var e = this.src.split("#");
        1 < e.length && (t = e, this.src = t[0], this.icon = t[1]);
      }

      this.svg = this.getSvg().then(function (t) {
        var e;
        if (N(t) ? (a.icon && b(t, "<symbol") && (t = function (t, e) {
          if (!pn[t]) {
            var i;

            for (pn[t] = {}; i = fn.exec(t);) {
              pn[t][i[3]] = '<svg xmlns="http://www.w3.org/2000/svg"' + i[1] + "svg>";
            }

            fn.lastIndex = 0;
          }

          return pn[t][e];
        }(t, a.icon) || t), e = Be(t.substr(t.indexOf("<svg")))) : e = t.cloneNode(!0), !e) return zt.reject("SVG not found.");
        var i = Z(e, "viewBox");

        for (var n in i && (i = i.split(" "), a.width = a.$props.width || i[2], a.height = a.$props.height || i[3]), a.width *= a.ratio, a.height *= a.ratio, a.$options.props) {
          a[n] && !b(a.exclude, n) && Z(e, n, a[n]);
        }

        a.id || tt(e, "id"), a.width && !a.height && tt(e, "height"), a.height && !a.width && tt(e, "width");
        var r = a.$el;

        if (yt(r) || "CANVAS" === r.tagName) {
          Z(r, {
            hidden: !0,
            id: null
          });
          var o = r.nextElementSibling;
          o && e.isEqualNode(o) ? e = o : Zt(r, e);
        } else {
          var s = r.lastElementChild;
          s && e.isEqualNode(s) ? e = s : Kt(r, e);
        }

        return a.svgEl = e;
      }, X);
    },
    disconnected: function disconnected() {
      var e = this;
      yt(this.$el) && Z(this.$el, {
        hidden: null,
        id: this.id || null
      }), this.svg && this.svg.then(function (t) {
        return (!e._connected || t !== e.svgEl) && te(t);
      }, X), this.svg = this.svgEl = null;
    },
    methods: {
      getSvg: function getSvg() {
        var i = this;
        return this.src ? (un[this.src] || (un[this.src] = new zt(function (e, t) {
          v(i.src, "data:") ? e(decodeURIComponent(i.src.split(",")[1])) : Ft(i.src).then(function (t) {
            return e(t.response);
          }, function () {
            return t("SVG not found.");
          });
        })), un[this.src]) : zt.reject();
      }
    }
  },
      fn = /<symbol(.*?id=(['"])(.*?)\2[^]*?<\/)symbol>/g,
      pn = {};
  var mn = {},
      gn = {
    spinner: '<svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" cx="15" cy="15" r="14"/></svg>',
    totop: '<svg width="18" height="10" viewBox="0 0 18 10" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="1 9 9 1 17 9 "/></svg>',
    marker: '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="9" y="4" width="1" height="11"/><rect x="4" y="9" width="11" height="1"/></svg>',
    "close-icon": '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"/><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"/></svg>',
    "close-large": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.4" x1="1" y1="1" x2="19" y2="19"/><line fill="none" stroke="#000" stroke-width="1.4" x1="19" y1="1" x2="1" y2="19"/></svg>',
    "navbar-toggle-icon": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect y="9" width="20" height="2"/><rect y="3" width="20" height="2"/><rect y="15" width="20" height="2"/></svg>',
    "overlay-icon": '<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><rect x="19" y="0" width="1" height="40"/><rect x="0" y="19" width="40" height="1"/></svg>',
    "pagination-next": '<svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="1 1 6 6 1 11"/></svg>',
    "pagination-previous": '<svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="6 1 1 6 6 11"/></svg>',
    "search-icon": '<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9" cy="9" r="7"/><path fill="none" stroke="#000" stroke-width="1.1" d="M14,14 L18,18 L14,14 Z"/></svg>',
    "search-large": '<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.8" cx="17.5" cy="17.5" r="16.5"/><line fill="none" stroke="#000" stroke-width="1.8" x1="38" y1="39" x2="29" y2="30"/></svg>',
    "search-navbar": '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="10.5" cy="10.5" r="9.5"/><line fill="none" stroke="#000" stroke-width="1.1" x1="23" y1="23" x2="17" y2="17"/></svg>',
    "slidenav-next": '<svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "/></svg>',
    "slidenav-next-large": '<svg width="25px" height="40px" viewBox="0 0 25 40" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="2" points="4.002,38.547 22.527,20.024 4,1.5 "/></svg>',
    "slidenav-previous": '<svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "/></svg>',
    "slidenav-previous-large": '<svg width="25px" height="40px" viewBox="0 0 25 40" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="2" points="20.527,1.5 2,20.024 20.525,38.547 "/></svg>'
  },
      vn = {
    install: function install(r) {
      r.icon.add = function (t, e) {
        var i,
            n = N(t) ? ((i = {})[t] = e, i) : t;
        R(n, function (t, e) {
          gn[e] = t, delete mn[e];
        }), r._initialized && ae(document.body, function (t) {
          return R(r.getComponents(t), function (t) {
            return t.$options.isIcon && t.icon in n && t.$reset();
          });
        });
      };
    },
    attrs: ["icon", "ratio"],
    mixins: [Vi, dn],
    args: "icon",
    props: ["icon"],
    data: {
      exclude: ["id", "style", "class", "src", "icon", "ratio"]
    },
    isIcon: !0,
    connected: function connected() {
      le(this.$el, "uk-icon");
    },
    methods: {
      getSvg: function getSvg() {
        var t,
            e = function (t) {
          if (!gn[t]) return null;
          mn[t] || (mn[t] = Be(gn[t].trim()));
          return mn[t];
        }((t = this.icon, ri ? V(V(t, "left", "right"), "previous", "next") : t));

        return e ? zt.resolve(e) : zt.reject("Icon not found.");
      }
    }
  },
      wn = {
    extends: vn,
    data: function data(t) {
      return {
        icon: m(t.constructor.options.name)
      };
    }
  },
      bn = {
    extends: wn,
    connected: function connected() {
      le(this.$el, "uk-slidenav");
    },
    computed: {
      icon: function icon(t, e) {
        var i = t.icon;
        return de(e, "uk-slidenav-large") ? i + "-large" : i;
      }
    }
  },
      yn = {
    extends: wn,
    computed: {
      icon: function icon(t, e) {
        var i = t.icon;
        return de(e, "uk-search-icon") && gt(e, ".uk-search-large").length ? "search-large" : gt(e, ".uk-search-navbar").length ? "search-navbar" : i;
      }
    }
  },
      xn = {
    extends: wn,
    computed: {
      icon: function icon() {
        return "close-" + (de(this.$el, "uk-close-large") ? "large" : "icon");
      }
    }
  },
      kn = {
    extends: wn,
    connected: function connected() {
      var e = this;
      this.svg.then(function (t) {
        return 1 !== e.ratio && be(Be("circle", t), "strokeWidth", 1 / e.ratio);
      }, X);
    }
  };
  var $n = {
    attrs: !0,
    props: {
      dataSrc: String,
      dataSrcset: Boolean,
      sizes: String,
      width: Number,
      height: Number,
      offsetTop: String,
      offsetLeft: String,
      target: String
    },
    data: {
      dataSrc: "",
      dataSrcset: !1,
      sizes: !1,
      width: !1,
      height: !1,
      offsetTop: "50vh",
      offsetLeft: 0,
      target: !1
    },
    computed: {
      cacheKey: function cacheKey(t) {
        var e = t.dataSrc;
        return this.$name + "." + e;
      },
      width: function width(t) {
        var e = t.width,
            i = t.dataWidth;
        return e || i;
      },
      height: function height(t) {
        var e = t.height,
            i = t.dataHeight;
        return e || i;
      },
      sizes: function sizes(t) {
        var e = t.sizes,
            i = t.dataSizes;
        return e || i;
      },
      isImg: function isImg(t, e) {
        return Nn(e);
      },
      target: function target(t) {
        var e = t.target;
        return [this.$el].concat(rt(e, this.$el));
      },
      offsetTop: function offsetTop(t) {
        return Cn(t.offsetTop, "height");
      },
      offsetLeft: function offsetLeft(t) {
        return Cn(t.offsetLeft, "width");
      }
    },
    connected: function connected() {
      Mn[this.cacheKey] ? In(this.$el, Mn[this.cacheKey] || this.dataSrc, this.dataSrcset, this.sizes) : this.isImg && this.width && this.height && In(this.$el, function (t, e, i) {
        var n;

        if (i) {
          for (var r; r = Sn.exec(i);) {
            if (!r[1] || window.matchMedia(r[1]).matches) {
              o = r[2], r = v(o, "calc") ? o.substring(5, o.length - 1).replace(Tn, function (t) {
                return Cn(t);
              }).replace(/ /g, "").match(En).reduce(function (t, e) {
                return t + +e;
              }, 0) : o;
              break;
            }
          }

          Sn.lastIndex = 0, n = G.ratio({
            width: t,
            height: e
          }, "width", Cn(r || "100vw")), t = n.width, e = n.height;
        }

        var o;
        return 'data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="' + t + '" height="' + e + '"></svg>';
      }(this.width, this.height, this.sizes));
    },
    update: [{
      read: function read(t) {
        var e = this,
            i = t.delay,
            n = t.image;

        if (i) {
          if (!n && this.target.some(function (t) {
            return Ge(t, e.offsetTop, e.offsetLeft, !0);
          })) return {
            image: Vt(this.dataSrc, this.dataSrcset, this.sizes).then(function (t) {
              return In(e.$el, On(t), t.srcset, t.sizes), Mn[e.cacheKey] = On(t), t;
            }, X)
          };
          !this.isImg && n && n.then(function (t) {
            return t && In(e.$el, On(t));
          });
        }
      },
      write: function write(t) {
        if (!t.delay) return this.$emit(), t.delay = !0;
      },
      events: ["scroll", "load", "resize"]
    }]
  };

  function In(t, e, i, n) {
    if (Nn(t)) e && (t.src = e), i && (t.srcset = i), n && (t.sizes = n);else if (e) {
      var r = !b(t.style.backgroundImage, e);
      be(t, "backgroundImage", "url(" + e + ")"), r && _t(t, At("load", !1));
    }
  }

  var Sn = /\s*(.*?)\s*(\w+|calc\(.*?\))\s*(?:,|$)/g;
  var Tn = /\d+(?:\w+|%)/g,
      En = /[+-]?(\d+)/g;

  function Cn(t, e, i) {
    return void 0 === e && (e = "width"), void 0 === i && (i = window), M(t) ? +t : u(t, "vw") ? An(i, "width", t) : u(t, "vh") ? An(i, "height", t) : u(t, "%") ? An(i, e, t) : P(t);
  }

  var _n = {
    height: Ve,
    width: Ye
  };

  function An(t, e, i) {
    return _n[e](t) * P(i) / 100;
  }

  function Nn(t) {
    return "IMG" === t.tagName;
  }

  function On(t) {
    return t.currentSrc || t.src;
  }

  var Mn,
      Dn = "__test__";

  try {
    (Mn = window.sessionStorage || {})[Dn] = 1, delete Mn[Dn];
  } catch (t) {
    Mn = {};
  }

  var Bn,
      zn,
      Pn = {
    mixins: [Vi],
    props: {
      fill: String,
      media: "media"
    },
    data: {
      fill: "",
      media: !1,
      clsWrapper: "uk-leader-fill",
      clsHide: "uk-leader-hide",
      attrFill: "data-fill"
    },
    computed: {
      fill: function fill(t) {
        return t.fill || $e("leader-fill");
      }
    },
    connected: function connected() {
      var t;
      t = ie(this.$el, '<span class="' + this.clsWrapper + '">'), this.wrapper = t[0];
    },
    disconnected: function disconnected() {
      ne(this.wrapper.childNodes);
    },
    update: [{
      read: function read(t) {
        var e = t.changed,
            i = t.width,
            n = i;
        return {
          width: i = Math.floor(this.$el.offsetWidth / 2),
          changed: e || n !== i,
          hide: this.media && !window.matchMedia(this.media).matches
        };
      },
      write: function write(t) {
        fe(this.wrapper, this.clsHide, t.hide), t.changed && (t.changed = !1, Z(this.wrapper, this.attrFill, new Array(t.width).join(this.fill)));
      },
      events: ["load", "resize"]
    }]
  },
      Hn = {
    props: {
      container: Boolean
    },
    data: {
      container: !0
    },
    computed: {
      container: function container(t) {
        var e = t.container;
        return !0 === e && this.$container || e && Be(e);
      }
    }
  },
      Wn = {
    mixins: [Vi, Hn, Yi],
    props: {
      selPanel: String,
      selClose: String,
      escClose: Boolean,
      bgClose: Boolean,
      stack: Boolean
    },
    data: {
      cls: "uk-open",
      escClose: !0,
      bgClose: !0,
      overlay: !0,
      stack: !1
    },
    computed: {
      panel: function panel(t, e) {
        return Be(t.selPanel, e);
      },
      transitionElement: function transitionElement() {
        return this.panel;
      },
      transitionDuration: function transitionDuration() {
        return F(be(this.transitionElement, "transitionDuration"));
      },
      bgClose: function bgClose(t) {
        return t.bgClose && this.panel;
      }
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return this.selClose;
      },
      handler: function handler(t) {
        t.preventDefault(), this.hide();
      }
    }, {
      name: "toggle",
      self: !0,
      handler: function handler(t) {
        t.defaultPrevented || (t.preventDefault(), this.toggle());
      }
    }, {
      name: "beforeshow",
      self: !0,
      handler: function handler(t) {
        var e = Bn && Bn !== this && Bn;

        if (Bn = this, e) {
          if (!this.stack) return e.hide().then(this.show), void t.preventDefault();
          this.prev = e;
        }

        !function () {
          if (zn) return;
          zn = [Tt(document, "click", function (t) {
            var e = t.target,
                i = t.defaultPrevented;
            !Bn || !Bn.bgClose || i || Bn.overlay && !St(e, Bn.$el) || St(e, Bn.panel) || Bn.hide();
          }), Tt(document, "keydown", function (t) {
            27 === t.keyCode && Bn && Bn.escClose && (t.preventDefault(), Bn.hide());
          })];
        }();
      }
    }, {
      name: "beforehide",
      self: !0,
      handler: function handler() {
        (Bn = Bn && Bn !== this && Bn || this.prev) || (zn && zn.forEach(function (t) {
          return t();
        }), zn = null);
      }
    }, {
      name: "show",
      self: !0,
      handler: function handler() {
        de(document.documentElement, this.clsPage) || (this.scrollbarWidth = Ye(window) - Ye(document), be(document.body, "overflowY", this.scrollbarWidth && this.overlay ? "scroll" : "")), le(document.documentElement, this.clsPage);
      }
    }, {
      name: "hidden",
      self: !0,
      handler: function handler() {
        for (var t, e = this.prev; e;) {
          if (e.clsPage === this.clsPage) {
            t = !0;
            break;
          }

          e = e.prev;
        }

        t || he(document.documentElement, this.clsPage), !this.prev && be(document.body, "overflowY", "");
      }
    }],
    methods: {
      toggle: function toggle() {
        return this.isToggled() ? this.hide() : this.show();
      },
      show: function show() {
        return this.isToggled() ? zt.resolve() : (this.container && this.$el.parentNode !== this.container && (Kt(this.container, this.$el), this._callConnected()), this.toggleNow(this.$el, !0));
      },
      hide: function hide() {
        return this.isToggled() ? this.toggleNow(this.$el, !1) : zt.resolve();
      },
      getActive: function getActive() {
        return Bn;
      },
      _toggleImmediate: function _toggleImmediate(e, i) {
        var n = this;
        return new zt(function (t) {
          return requestAnimationFrame(function () {
            n._toggle(e, i), n.transitionDuration ? Ct(n.transitionElement, "transitionend", t, !1, function (t) {
              return t.target === n.transitionElement;
            }) : t();
          });
        });
      }
    }
  };
  var Ln = {
    install: function install(a) {
      a.modal.dialog = function (t, e) {
        var n = a.modal(' <div class="uk-modal"> <div class="uk-modal-dialog">' + t + "</div> </div> ", e);
        return n.show(), Tt(n.$el, "hidden", function (t) {
          var e = t.target,
              i = t.currentTarget;
          e === i && n.$destroy(!0);
        }), n;
      }, a.modal.alert = function (e, i) {
        return i = Y({
          bgClose: !1,
          escClose: !1,
          labels: a.modal.labels
        }, i), new zt(function (t) {
          return Tt(a.modal.dialog(' <div class="uk-modal-body">' + (N(e) ? e : Jt(e)) + '</div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-primary uk-modal-close" autofocus>' + i.labels.ok + "</button> </div> ", i).$el, "hide", t);
        });
      }, a.modal.confirm = function (r, o) {
        return o = Y({
          bgClose: !1,
          escClose: !0,
          labels: a.modal.labels
        }, o), new zt(function (e, t) {
          var i = a.modal.dialog(' <form> <div class="uk-modal-body">' + (N(r) ? r : Jt(r)) + '</div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-default uk-modal-close" type="button">' + o.labels.cancel + '</button> <button class="uk-button uk-button-primary" autofocus>' + o.labels.ok + "</button> </div> </form> ", o),
              n = !1;
          Tt(i.$el, "submit", "form", function (t) {
            t.preventDefault(), e(), n = !0, i.hide();
          }), Tt(i.$el, "hide", function () {
            n || t();
          });
        });
      }, a.modal.prompt = function (t, o, s) {
        return s = Y({
          bgClose: !1,
          escClose: !0,
          labels: a.modal.labels
        }, s), new zt(function (e) {
          var i = a.modal.dialog(' <form class="uk-form-stacked"> <div class="uk-modal-body"> <label>' + (N(t) ? t : Jt(t)) + '</label> <input class="uk-input" autofocus> </div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-default uk-modal-close" type="button">' + s.labels.cancel + '</button> <button class="uk-button uk-button-primary">' + s.labels.ok + "</button> </div> </form> ", s),
              n = Be("input", i.$el);
          n.value = o;
          var r = !1;
          Tt(i.$el, "submit", "form", function (t) {
            t.preventDefault(), e(n.value), r = !0, i.hide();
          }), Tt(i.$el, "hide", function () {
            r || e(null);
          });
        });
      }, a.modal.labels = {
        ok: "Ok",
        cancel: "Cancel"
      };
    },
    mixins: [Wn],
    data: {
      clsPage: "uk-modal-page",
      selPanel: ".uk-modal-dialog",
      selClose: ".uk-modal-close, .uk-modal-close-default, .uk-modal-close-outside, .uk-modal-close-full"
    },
    events: [{
      name: "show",
      self: !0,
      handler: function handler() {
        de(this.panel, "uk-margin-auto-vertical") ? le(this.$el, "uk-flex") : be(this.$el, "display", "block"), Ve(this.$el);
      }
    }, {
      name: "hidden",
      self: !0,
      handler: function handler() {
        be(this.$el, "display", ""), he(this.$el, "uk-flex");
      }
    }]
  };
  var jn,
      Fn = {
    extends: Ri,
    data: {
      targets: "> .uk-parent",
      toggle: "> a",
      content: "> ul"
    }
  },
      Vn = {
    mixins: [Vi],
    props: {
      dropdown: String,
      mode: "list",
      align: String,
      offset: Number,
      boundary: Boolean,
      boundaryAlign: Boolean,
      clsDrop: String,
      delayShow: Number,
      delayHide: Number,
      dropbar: Boolean,
      dropbarMode: String,
      dropbarAnchor: Boolean,
      duration: Number
    },
    data: {
      dropdown: ".uk-navbar-nav > li",
      align: ri ? "right" : "left",
      clsDrop: "uk-navbar-dropdown",
      mode: void 0,
      offset: void 0,
      delayShow: void 0,
      delayHide: void 0,
      boundaryAlign: void 0,
      flip: "x",
      boundary: !0,
      dropbar: !1,
      dropbarMode: "slide",
      dropbarAnchor: !1,
      duration: 200
    },
    computed: {
      boundary: function boundary(t, e) {
        var i = t.boundary,
            n = t.boundaryAlign;
        return !0 === i || n ? e : i;
      },
      dropbarAnchor: function dropbarAnchor(t, e) {
        return nt(t.dropbarAnchor, e);
      },
      pos: function pos(t) {
        return "bottom-" + t.align;
      },
      dropdowns: function dropdowns(t, e) {
        return ze(t.dropdown + " ." + t.clsDrop, e);
      }
    },
    beforeConnect: function beforeConnect() {
      var t = this.$props.dropbar;
      this.dropbar = t && (nt(t, this.$el) || Be("+ .uk-navbar-dropbar", this.$el) || Be("<div></div>")), this.dropbar && (le(this.dropbar, "uk-navbar-dropbar"), "slide" === this.dropbarMode && le(this.dropbar, "uk-navbar-dropbar-slide"));
    },
    disconnected: function disconnected() {
      this.dropbar && te(this.dropbar);
    },
    update: function update() {
      var e = this;
      this.$create("drop", this.dropdowns.filter(function (t) {
        return !e.getDropdown(t);
      }), Y({}, this.$props, {
        boundary: this.boundary,
        pos: this.pos,
        offset: this.dropbar || this.offset
      }));
    },
    events: [{
      name: "mouseover",
      delegate: function delegate() {
        return this.dropdown;
      },
      handler: function handler(t) {
        var e = t.current,
            i = this.getActive();
        i && i.toggle && !St(i.toggle.$el, e) && !i.tracker.movesTo(i.$el) && i.hide(!1);
      }
    }, {
      name: "mouseleave",
      el: function el() {
        return this.dropbar;
      },
      handler: function handler() {
        var t = this.getActive();
        t && !ft(this.dropbar, ":hover") && t.hide();
      }
    }, {
      name: "beforeshow",
      capture: !0,
      filter: function filter() {
        return this.dropbar;
      },
      handler: function handler() {
        this.dropbar.parentNode || Zt(this.dropbarAnchor || this.$el, this.dropbar);
      }
    }, {
      name: "show",
      capture: !0,
      filter: function filter() {
        return this.dropbar;
      },
      handler: function handler(t, e) {
        var i = e.$el,
            n = e.dir;
        this.clsDrop && le(i, this.clsDrop + "-dropbar"), "bottom" === n && this.transitionTo(i.offsetHeight + P(be(i, "marginTop")) + P(be(i, "marginBottom")), i);
      }
    }, {
      name: "beforehide",
      filter: function filter() {
        return this.dropbar;
      },
      handler: function handler(t, e) {
        var i = e.$el,
            n = this.getActive();
        ft(this.dropbar, ":hover") && n && n.$el === i && t.preventDefault();
      }
    }, {
      name: "hide",
      filter: function filter() {
        return this.dropbar;
      },
      handler: function handler(t, e) {
        var i = e.$el,
            n = this.getActive();
        (!n || n && n.$el === i) && this.transitionTo(0);
      }
    }],
    methods: {
      getActive: function getActive() {
        var t = this.dropdowns.map(this.getDropdown).filter(function (t) {
          return t.isActive();
        })[0];
        return t && b(t.mode, "hover") && St(t.toggle.$el, this.$el) && t;
      },
      transitionTo: function transitionTo(t, e) {
        var i = this.dropbar,
            n = xt(i) ? Ve(i) : 0;
        return be(e = n < t && e, "clip", "rect(0," + e.offsetWidth + "px," + n + "px,0)"), Ve(i, n), _e.cancel([e, i]), zt.all([_e.start(i, {
          height: t
        }, this.duration), _e.start(e, {
          clip: "rect(0," + e.offsetWidth + "px," + t + "px,0)"
        }, this.duration)]).catch(X).then(function () {
          return be(e, {
            clip: ""
          });
        });
      },
      getDropdown: function getDropdown(t) {
        return this.$getComponent(t, "drop") || this.$getComponent(t, "dropdown");
      }
    }
  },
      Yn = {
    mixins: [Wn],
    args: "mode",
    props: {
      content: String,
      mode: String,
      flip: Boolean,
      overlay: Boolean
    },
    data: {
      content: ".uk-offcanvas-content",
      mode: "slide",
      flip: !1,
      overlay: !1,
      clsPage: "uk-offcanvas-page",
      clsContainer: "uk-offcanvas-container",
      selPanel: ".uk-offcanvas-bar",
      clsFlip: "uk-offcanvas-flip",
      clsContent: "uk-offcanvas-content",
      clsContentAnimation: "uk-offcanvas-content-animation",
      clsSidebarAnimation: "uk-offcanvas-bar-animation",
      clsMode: "uk-offcanvas",
      clsOverlay: "uk-offcanvas-overlay",
      selClose: ".uk-offcanvas-close"
    },
    computed: {
      content: function content(t) {
        return Be(t.content) || document.body;
      },
      clsFlip: function clsFlip(t) {
        var e = t.flip,
            i = t.clsFlip;
        return e ? i : "";
      },
      clsOverlay: function clsOverlay(t) {
        var e = t.overlay,
            i = t.clsOverlay;
        return e ? i : "";
      },
      clsMode: function clsMode(t) {
        var e = t.mode;
        return t.clsMode + "-" + e;
      },
      clsSidebarAnimation: function clsSidebarAnimation(t) {
        var e = t.mode,
            i = t.clsSidebarAnimation;
        return "none" === e || "reveal" === e ? "" : i;
      },
      clsContentAnimation: function clsContentAnimation(t) {
        var e = t.mode,
            i = t.clsContentAnimation;
        return "push" !== e && "reveal" !== e ? "" : i;
      },
      transitionElement: function transitionElement(t) {
        return "reveal" === t.mode ? this.panel.parentNode : this.panel;
      }
    },
    update: {
      write: function write() {
        this.getActive() === this && ((this.overlay || this.clsContentAnimation) && Ye(this.content, Ye(window) - this.scrollbarWidth), this.overlay && (Ve(this.content, Ve(window)), jn && (this.content.scrollTop = jn.y)));
      },
      events: ["resize"]
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return 'a[href^="#"]';
      },
      handler: function handler(t) {
        var e = t.current;
        e.hash && Be(e.hash, this.content) && (jn = null, this.hide());
      }
    }, {
      name: "beforescroll",
      filter: function filter() {
        return this.overlay;
      },
      handler: function handler(t, e, i) {
        e && i && this.isToggled() && Be(i, this.content) && (Ct(this.$el, "hidden", function () {
          return e.scrollTo(i);
        }), t.preventDefault());
      }
    }, {
      name: "show",
      self: !0,
      handler: function handler() {
        jn = jn || {
          x: window.pageXOffset,
          y: window.pageYOffset
        }, "reveal" !== this.mode || de(this.panel, this.clsMode) || (ee(this.panel, "<div>"), le(this.panel.parentNode, this.clsMode)), be(document.documentElement, "overflowY", (!this.clsContentAnimation || this.flip) && this.scrollbarWidth && this.overlay ? "scroll" : ""), le(document.body, this.clsContainer, this.clsFlip, this.clsOverlay), Ve(document.body), le(this.content, this.clsContentAnimation), le(this.panel, this.clsSidebarAnimation, "reveal" !== this.mode ? this.clsMode : ""), le(this.$el, this.clsOverlay), be(this.$el, "display", "block"), Ve(this.$el);
      }
    }, {
      name: "hide",
      self: !0,
      handler: function handler() {
        he(this.content, this.clsContentAnimation);
        var t = this.getActive();
        ("none" === this.mode || t && t !== this && t !== this.prev) && _t(this.panel, "transitionend");
      }
    }, {
      name: "hidden",
      self: !0,
      handler: function handler() {
        if ("reveal" === this.mode && ne(this.panel), this.overlay) {
          if (!jn) {
            var t = this.content,
                e = t.scrollLeft,
                i = t.scrollTop;
            jn = {
              x: e,
              y: i
            };
          }
        } else jn = {
          x: window.pageXOffset,
          y: window.pageYOffset
        };

        he(this.panel, this.clsSidebarAnimation, this.clsMode), he(this.$el, this.clsOverlay), be(this.$el, "display", ""), he(document.body, this.clsContainer, this.clsFlip, this.clsOverlay), document.body.scrollTop = jn.y, be(document.documentElement, "overflowY", ""), Ye(this.content, ""), Ve(this.content, ""), window.scroll(jn.x, jn.y), jn = null;
      }
    }, {
      name: "swipeLeft swipeRight",
      handler: function handler(t) {
        this.isToggled() && Di(t) && ("swipeLeft" === t.type && !this.flip || "swipeRight" === t.type && this.flip) && this.hide();
      }
    }]
  },
      Rn = {
    mixins: [Vi],
    props: {
      selModal: String,
      selPanel: String
    },
    data: {
      selModal: ".uk-modal",
      selPanel: ".uk-modal-dialog"
    },
    computed: {
      modal: function modal(t, e) {
        return mt(e, t.selModal);
      },
      panel: function panel(t, e) {
        return mt(e, t.selPanel);
      }
    },
    connected: function connected() {
      be(this.$el, "minHeight", 150);
    },
    update: {
      read: function read() {
        return !(!this.panel || !this.modal) && {
          current: P(be(this.$el, "maxHeight")),
          max: Math.max(150, Ve(this.modal) - (Le(this.panel).height - Ve(this.$el)))
        };
      },
      write: function write(t) {
        var e = t.current,
            i = t.max;
        be(this.$el, "maxHeight", i), Math.round(e) !== Math.round(i) && _t(this.$el, "resize");
      },
      events: ["load", "resize"]
    }
  },
      qn = {
    props: ["width", "height"],
    connected: function connected() {
      le(this.$el, "uk-responsive-width");
    },
    update: {
      read: function read() {
        return !!(xt(this.$el) && this.width && this.height) && {
          width: Ye(this.$el.parentNode),
          height: this.height
        };
      },
      write: function write(t) {
        Ve(this.$el, G.contain({
          height: this.height,
          width: this.width
        }, t).height);
      },
      events: ["load", "resize"]
    }
  },
      Un = {
    props: {
      duration: Number,
      offset: Number
    },
    data: {
      duration: 1e3,
      offset: 0
    },
    methods: {
      scrollTo: function scrollTo(i) {
        var n = this;
        i = i && Be(i) || document.body;
        var t = Ve(document),
            e = Ve(window),
            r = Le(i).top - this.offset;

        if (t < r + e && (r = t - e), _t(this.$el, "beforescroll", [this, i])) {
          var o = Date.now(),
              s = window.pageYOffset,
              a = function a() {
            var t,
                e = s + (r - s) * (t = U((Date.now() - o) / n.duration), .5 * (1 - Math.cos(Math.PI * t)));
            Qe(window, e), e !== r ? requestAnimationFrame(a) : _t(n.$el, "scrolled", [n, i]);
          };

          a();
        }
      }
    },
    events: {
      click: function click(t) {
        t.defaultPrevented || (t.preventDefault(), this.scrollTo(wt(this.$el.hash).substr(1)));
      }
    }
  };
  var Xn = {
    args: "cls",
    props: {
      cls: "list",
      target: String,
      hidden: Boolean,
      offsetTop: Number,
      offsetLeft: Number,
      repeat: Boolean,
      delay: Number
    },
    data: function data() {
      return {
        cls: [],
        target: !1,
        hidden: !0,
        offsetTop: 0,
        offsetLeft: 0,
        repeat: !1,
        delay: 0,
        inViewClass: "uk-scrollspy-inview"
      };
    },
    computed: {
      elements: function elements(t, e) {
        var i = t.target;
        return i ? ze(i, e) : [e];
      }
    },
    update: [{
      write: function write() {
        this.hidden && be(It(this.elements, ":not(." + this.inViewClass + ")"), "visibility", "hidden");
      }
    }, {
      read: function read(r) {
        var o = this;
        r.delay && this.elements.forEach(function (t, e) {
          var i = r[e];

          if (!i || i.el !== t) {
            var n = it(t, "uk-scrollspy-class");
            i = {
              el: t,
              toggles: n && n.split(",") || o.cls
            };
          }

          i.show = Ge(t, o.offsetTop, o.offsetLeft), r[e] = i;
        });
      },
      write: function write(o) {
        var s = this;
        if (!o.delay) return this.$emit(), o.delay = !0;
        var a = 1 === this.elements.length ? 1 : 0;
        this.elements.forEach(function (t, e) {
          var i = o[e],
              n = i.toggles[e] || i.toggles[0];
          if (!i.show || i.inview || i.timer) !i.show && i.inview && s.repeat && (i.timer && (clearTimeout(i.timer), delete i.timer), be(t, "visibility", s.hidden ? "hidden" : ""), he(t, s.inViewClass), fe(t, n), _t(t, "outview"), s.$update(t), i.inview = !1);else {
            var r = function r() {
              be(t, "visibility", ""), le(t, s.inViewClass), fe(t, n), _t(t, "inview"), s.$update(t), i.inview = !0, delete i.timer;
            };

            s.delay && a ? i.timer = setTimeout(r, s.delay * a) : r(), a++;
          }
        });
      },
      events: ["scroll", "load", "resize"]
    }]
  },
      Jn = {
    props: {
      cls: String,
      closest: String,
      scroll: Boolean,
      overflow: Boolean,
      offset: Number
    },
    data: {
      cls: "uk-active",
      closest: !1,
      scroll: !1,
      overflow: !0,
      offset: 0
    },
    computed: {
      links: function links(t, e) {
        return ze('a[href^="#"]', e).filter(function (t) {
          return t.hash;
        });
      },
      elements: function elements() {
        return this.closest ? mt(this.links, this.closest) : this.links;
      },
      targets: function targets() {
        return ze(this.links.map(function (t) {
          return t.hash;
        }).join(","));
      }
    },
    update: [{
      read: function read() {
        this.scroll && this.$create("scroll", this.links, {
          offset: this.offset || 0
        });
      }
    }, {
      read: function read(o) {
        var s = this,
            a = window.pageYOffset + this.offset + 1,
            l = Ve(document) - Ve(window) + this.offset;
        o.active = !1, this.targets.every(function (t, e) {
          var i = Le(t).top,
              n = e + 1 === s.targets.length;
          if (!s.overflow && (0 === e && a < i || n && i + t.offsetTop < a)) return !1;
          if (!n && Le(s.targets[e + 1]).top <= a) return !0;
          if (l <= a) for (var r = s.targets.length - 1; e < r; r--) {
            if (Ge(s.targets[r])) {
              t = s.targets[r];
              break;
            }
          }
          return !(o.active = Be(It(s.links, '[href="#' + t.id + '"]')));
        });
      },
      write: function write(t) {
        var e = t.active;
        this.links.forEach(function (t) {
          return t.blur();
        }), he(this.elements, this.cls), e && _t(this.$el, "active", [e, le(this.closest ? mt(e, this.closest) : e, this.cls)]);
      },
      events: ["scroll", "load", "resize"]
    }]
  },
      Kn = {
    mixins: [Vi],
    attrs: !0,
    props: {
      top: null,
      bottom: Boolean,
      offset: Number,
      animation: String,
      clsActive: String,
      clsInactive: String,
      clsFixed: String,
      clsBelow: String,
      selTarget: String,
      widthElement: Boolean,
      showOnUp: Boolean,
      media: "media",
      targetOffset: Number
    },
    data: {
      top: 0,
      bottom: !1,
      offset: 0,
      animation: "",
      clsActive: "uk-active",
      clsInactive: "",
      clsFixed: "uk-sticky-fixed",
      clsBelow: "uk-sticky-below",
      selTarget: "",
      widthElement: !1,
      showOnUp: !1,
      media: !1,
      targetOffset: !1
    },
    computed: {
      selTarget: function selTarget(t, e) {
        var i = t.selTarget;
        return i && Be(i, e) || e;
      },
      widthElement: function widthElement(t, e) {
        return nt(t.widthElement, e) || this.placeholder;
      }
    },
    connected: function connected() {
      this.placeholder = Be("+ .uk-sticky-placeholder", this.$el) || Be('<div class="uk-sticky-placeholder"></div>'), this.isActive || this.hide();
    },
    disconnected: function disconnected() {
      this.isActive && (this.isActive = !1, this.hide(), he(this.selTarget, this.clsInactive)), te(this.placeholder), this.placeholder = null, this.widthElement = null;
    },
    events: [{
      name: "active",
      self: !0,
      handler: function handler() {
        ue(this.selTarget, this.clsInactive, this.clsActive);
      }
    }, {
      name: "inactive",
      self: !0,
      handler: function handler() {
        ue(this.selTarget, this.clsActive, this.clsInactive);
      }
    }, {
      name: "load hashchange popstate",
      el: window,
      handler: function handler() {
        var n = this;

        if (!1 !== this.targetOffset && location.hash && 0 < window.pageYOffset) {
          var r = Be(location.hash);
          r && fi.read(function () {
            var t = Le(r).top,
                e = Le(n.$el).top,
                i = n.$el.offsetHeight;
            n.isActive && t <= e + i && e <= t + r.offsetHeight && Qe(window, t - i - (M(n.targetOffset) ? n.targetOffset : 0) - n.offset);
          });
        }
      }
    }],
    update: [{
      read: function read() {
        return {
          height: this.$el.offsetHeight,
          top: Le(this.isActive ? this.placeholder : this.$el).top
        };
      },
      write: function write(t) {
        var e = t.height,
            i = t.top,
            n = this.placeholder;
        be(n, Y({
          height: "absolute" !== be(this.$el, "position") ? e : ""
        }, be(this.$el, ["marginTop", "marginBottom", "marginLeft", "marginRight"]))), St(n, document) || (Zt(this.$el, n), Z(n, "hidden", "")), this.topOffset = i, this.bottomOffset = this.topOffset + e;
        var r = Gn("bottom", this);
        this.top = Math.max(P(Gn("top", this)), this.topOffset) - this.offset, this.bottom = r && r - e, this.inactive = this.media && !window.matchMedia(this.media).matches;
      },
      events: ["load", "resize"]
    }, {
      read: function read(t, e) {
        var i = e.scrollY;
        return void 0 === i && (i = window.pageYOffset), this.width = (xt(this.widthElement) ? this.widthElement : this.$el).offsetWidth, {
          scroll: this.scroll = i,
          visible: xt(this.$el)
        };
      },
      write: function write(t, e) {
        var i = this,
            n = t.visible,
            r = t.scroll;
        void 0 === e && (e = {});
        var o = e.dir;
        if (!(r < 0 || !n || this.disabled || this.showOnUp && !o)) if (this.inactive || r < this.top || this.showOnUp && (r <= this.top || "down" === o || "up" === o && !this.isActive && r <= this.bottomOffset)) {
          if (!this.isActive) return;
          this.isActive = !1, this.animation && r > this.topOffset ? (De.cancel(this.$el), De.out(this.$el, this.animation).then(function () {
            return i.hide();
          }, X)) : this.hide();
        } else this.isActive ? this.update() : this.animation ? (De.cancel(this.$el), this.show(), De.in(this.$el, this.animation).catch(X)) : this.show();
      },
      events: ["load", "resize", "scroll"]
    }],
    methods: {
      show: function show() {
        this.isActive = !0, this.update(), Z(this.placeholder, "hidden", null);
      },
      hide: function hide() {
        this.isActive && !de(this.selTarget, this.clsActive) || _t(this.$el, "inactive"), he(this.$el, this.clsFixed, this.clsBelow), be(this.$el, {
          position: "",
          top: "",
          width: ""
        }), Z(this.placeholder, "hidden", "");
      },
      update: function update() {
        var t = 0 !== this.top || this.scroll > this.top,
            e = Math.max(0, this.offset);
        this.bottom && this.scroll > this.bottom - this.offset && (e = this.bottom - this.scroll), be(this.$el, {
          position: "fixed",
          top: e + "px",
          width: this.width
        }), de(this.selTarget, this.clsActive) ? t || _t(this.$el, "inactive") : t && _t(this.$el, "active"), fe(this.$el, this.clsBelow, this.scroll > this.bottomOffset), le(this.$el, this.clsFixed);
      }
    }
  };

  function Gn(t, e) {
    var i = e.$props,
        n = e.$el,
        r = e[t + "Offset"],
        o = i[t];

    if (o) {
      if (M(o)) return r + P(o);
      if (N(o) && o.match(/^-?\d+vh$/)) return Ve(window) * P(o) / 100;
      var s = !0 === o ? n.parentNode : nt(o, n);
      return s ? Le(s).top + s.offsetHeight : void 0;
    }
  }

  var Zn,
      Qn = {
    mixins: [Yi],
    args: "connect",
    props: {
      connect: String,
      toggle: String,
      active: Number,
      swiping: Boolean
    },
    data: {
      connect: "~.uk-switcher",
      toggle: "> *",
      active: 0,
      swiping: !0,
      cls: "uk-active",
      clsContainer: "uk-switcher",
      attrItem: "uk-switcher-item",
      queued: !0
    },
    computed: {
      connects: function connects(t, e) {
        return rt(t.connect, e);
      },
      toggles: function toggles(t, e) {
        return ze(t.toggle, e);
      }
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return this.toggle + ":not(.uk-disabled)";
      },
      handler: function handler(t) {
        t.preventDefault(), this.show(t.current);
      }
    }, {
      name: "click",
      el: function el() {
        return this.connects;
      },
      delegate: function delegate() {
        return "[" + this.attrItem + "],[data-" + this.attrItem + "]";
      },
      handler: function handler(t) {
        t.preventDefault(), this.show(it(t.current, this.attrItem));
      }
    }, {
      name: "swipeRight swipeLeft",
      filter: function filter() {
        return this.swiping;
      },
      el: function el() {
        return this.connects;
      },
      handler: function handler(t) {
        Di(t) && (t.preventDefault(), window.getSelection().toString() || this.show("swipeLeft" === t.type ? "next" : "previous"));
      }
    }],
    update: function update() {
      var e = this;
      this.connects.forEach(function (t) {
        return e.updateAria(t.children);
      }), this.show(It(this.toggles, "." + this.cls)[0] || this.toggles[this.active] || this.toggles[0]);
    },
    methods: {
      index: function index() {
        return !!this.connects.length && qt(It(this.connects[0].children, "." + this.cls)[0]);
      },
      show: function show(t) {
        for (var e, i = this, n = this.toggles.length, r = this.index(), o = 0 <= r, s = "previous" === t ? -1 : 1, a = Ut(t, this.toggles, r), l = 0; l < n; l++, a = (a + s + n) % n) {
          if (!ft(i.toggles[a], ".uk-disabled, [disabled]")) {
            e = i.toggles[a];
            break;
          }
        }

        !e || 0 <= r && de(e, this.cls) || r === a || (he(this.toggles, this.cls), Z(this.toggles, "aria-expanded", !1), le(e, this.cls), Z(e, "aria-expanded", !0), this.connects.forEach(function (t) {
          o ? i.toggleElement([t.children[r], t.children[a]]) : i.toggleNow(t.children[a]);
        }));
      }
    }
  },
      tr = {
    mixins: [Vi],
    extends: Qn,
    props: {
      media: "media"
    },
    data: {
      media: 960,
      attrItem: "uk-tab-item"
    },
    connected: function connected() {
      var t = de(this.$el, "uk-tab-left") ? "uk-tab-left" : !!de(this.$el, "uk-tab-right") && "uk-tab-right";
      t && this.$create("toggle", this.$el, {
        cls: t,
        mode: "media",
        media: this.media
      });
    }
  },
      er = {
    mixins: [Yi],
    args: "target",
    props: {
      href: String,
      target: null,
      mode: "list",
      media: "media"
    },
    data: {
      href: !1,
      target: !1,
      mode: "click",
      queued: !0,
      media: !1
    },
    computed: {
      target: function target(t, e) {
        var i = t.href,
            n = t.target;
        return (n = rt(n || i, e)).length && n || [e];
      }
    },
    events: [{
      name: ui + " " + di,
      filter: function filter() {
        return b(this.mode, "hover");
      },
      handler: function handler(t) {
        Di(t) || this.toggle("toggle" + (t.type === ui ? "show" : "hide"));
      }
    }, {
      name: "click",
      filter: function filter() {
        return b(this.mode, "click") || ai && b(this.mode, "hover");
      },
      handler: function handler(t) {
        var e;
        (Di(t) || b(this.mode, "click")) && ((mt(t.target, 'a[href="#"], button') || (e = mt(t.target, "a[href]")) && (this.cls || !xt(this.target) || e.hash && ft(this.target, e.hash))) && Ct(document, "click", function (t) {
          return t.preventDefault();
        }), this.toggle());
      }
    }],
    update: {
      write: function write() {
        if (b(this.mode, "media") && this.media) {
          var t = this.isToggled(this.target);
          (window.matchMedia(this.media).matches ? !t : t) && this.toggle();
        }
      },
      events: ["load", "resize"]
    },
    methods: {
      toggle: function toggle(t) {
        _t(this.target, t || "toggle", [this]) && this.toggleElement(this.target);
      }
    }
  };
  Fi.version = "3.0.0-rc.10", (Zn = Fi).component("accordion", Ri), Zn.component("alert", qi), Zn.component("cover", Gi), Zn.component("drop", Qi), Zn.component("dropdown", tn), Zn.component("formCustom", en), Zn.component("gif", nn), Zn.component("grid", an), Zn.component("heightMatch", ln), Zn.component("heightViewport", hn), Zn.component("icon", vn), Zn.component("img", $n), Zn.component("leader", Pn), Zn.component("margin", rn), Zn.component("modal", Ln), Zn.component("nav", Fn), Zn.component("navbar", Vn), Zn.component("offcanvas", Yn), Zn.component("overflowAuto", Rn), Zn.component("responsive", qn), Zn.component("scroll", Un), Zn.component("scrollspy", Xn), Zn.component("scrollspyNav", Jn), Zn.component("sticky", Kn), Zn.component("svg", dn), Zn.component("switcher", Qn), Zn.component("tab", tr), Zn.component("toggle", er), Zn.component("video", Ki), Zn.component("close", xn), Zn.component("marker", wn), Zn.component("navbarToggleIcon", wn), Zn.component("overlayIcon", wn), Zn.component("paginationNext", wn), Zn.component("paginationPrevious", wn), Zn.component("searchIcon", yn), Zn.component("slidenavNext", bn), Zn.component("slidenavPrevious", bn), Zn.component("spinner", kn), Zn.component("totop", wn), Zn.use(Ui);
  var ir = {
    mixins: [Vi],
    attrs: !0,
    props: {
      date: String,
      clsWrapper: String
    },
    data: {
      date: "",
      clsWrapper: ".uk-countdown-%unit%"
    },
    computed: {
      date: function date(t) {
        var e = t.date;
        return Date.parse(e);
      },
      days: function days(t, e) {
        return Be(t.clsWrapper.replace("%unit%", "days"), e);
      },
      hours: function hours(t, e) {
        return Be(t.clsWrapper.replace("%unit%", "hours"), e);
      },
      minutes: function minutes(t, e) {
        return Be(t.clsWrapper.replace("%unit%", "minutes"), e);
      },
      seconds: function seconds(t, e) {
        return Be(t.clsWrapper.replace("%unit%", "seconds"), e);
      },
      units: function units() {
        var e = this;
        return ["days", "hours", "minutes", "seconds"].filter(function (t) {
          return e[t];
        });
      }
    },
    connected: function connected() {
      this.start();
    },
    disconnected: function disconnected() {
      var e = this;
      this.stop(), this.units.forEach(function (t) {
        return Xt(e[t]);
      });
    },
    events: [{
      name: "visibilitychange",
      el: document,
      handler: function handler() {
        document.hidden ? this.stop() : this.start();
      }
    }],
    update: {
      write: function write() {
        var t,
            e,
            n = this,
            r = (t = this.date, {
          total: e = t - Date.now(),
          seconds: e / 1e3 % 60,
          minutes: e / 1e3 / 60 % 60,
          hours: e / 1e3 / 60 / 60 % 24,
          days: e / 1e3 / 60 / 60 / 24
        });
        r.total <= 0 && (this.stop(), r.days = r.hours = r.minutes = r.seconds = 0), this.units.forEach(function (t) {
          var e = String(Math.floor(r[t]));
          e = e.length < 2 ? "0" + e : e;
          var i = n[t];
          i.textContent !== e && ((e = e.split("")).length !== i.children.length && Jt(i, e.map(function () {
            return "<span></span>";
          }).join("")), e.forEach(function (t, e) {
            return i.children[e].textContent = t;
          }));
        });
      }
    },
    methods: {
      start: function start() {
        var t = this;
        this.stop(), this.date && this.units.length && (this.$emit(), this.timer = setInterval(function () {
          return t.$emit();
        }, 1e3));
      },
      stop: function stop() {
        this.timer && (clearInterval(this.timer), this.timer = null);
      }
    }
  };
  var nr,
      rr = "uk-animation-target",
      or = {
    props: {
      animation: Number
    },
    data: {
      animation: 150
    },
    computed: {
      target: function target() {
        return this.$el;
      }
    },
    methods: {
      animate: function animate(t) {
        var n = this;
        nr || (nr = Kt(document.head, "<style>").sheet).insertRule("." + rr + " > * {\n                    margin-top: 0 !important;\n                    transform: none !important;\n                }", 0);
        var r = L(this.target.children),
            o = r.map(function (t) {
          return sr(t, !0);
        }),
            e = Ve(this.target),
            i = window.pageYOffset;
        t(), _e.cancel(this.target), r.forEach(_e.cancel), ar(this.target), this.$update(this.target), fi.flush();
        var s = Ve(this.target),
            a = (r = r.concat(L(this.target.children).filter(function (t) {
          return !b(r, t);
        }))).map(function (t, e) {
          return !!(t.parentNode && e in o) && (o[e] ? xt(t) ? lr(t) : {
            opacity: 0
          } : {
            opacity: xt(t) ? 1 : 0
          });
        });
        return o = a.map(function (t, e) {
          var i = r[e].parentNode === n.target && (o[e] || sr(r[e]));
          if (i) if (t) {
            if (!("opacity" in t)) {
              i.opacity % 1 ? t.opacity = 1 : delete i.opacity;
            }
          } else delete i.opacity;
          return i;
        }), le(this.target, rr), r.forEach(function (t, e) {
          return o[e] && be(t, o[e]);
        }), be(this.target, "height", e), Qe(window, i), zt.all(r.map(function (t, e) {
          return o[e] && a[e] ? _e.start(t, a[e], n.animation, "ease") : zt.resolve();
        }).concat(_e.start(this.target, {
          height: s
        }, this.animation, "ease"))).then(function () {
          r.forEach(function (t, e) {
            return be(t, {
              display: 0 === a[e].opacity ? "none" : "",
              zIndex: ""
            });
          }), ar(n.target), n.$update(n.target), fi.flush();
        }, X);
      }
    }
  };

  function sr(t, e) {
    var i = be(t, "zIndex");
    return !!xt(t) && Y({
      display: "",
      opacity: e ? be(t, "opacity") : "0",
      pointerEvents: "none",
      position: "absolute",
      zIndex: "auto" === i ? qt(t) : i
    }, lr(t));
  }

  function ar(t) {
    be(t.children, {
      height: "",
      left: "",
      opacity: "",
      pointerEvents: "",
      position: "",
      top: "",
      width: ""
    }), he(t, rr), be(t, "height", "");
  }

  function lr(t) {
    var e = t.getBoundingClientRect(),
        i = e.height,
        n = e.width,
        r = Fe(t),
        o = r.top,
        s = r.left;
    return {
      top: o += P(be(t, "marginTop")),
      left: s,
      height: i,
      width: n
    };
  }

  var hr = {
    mixins: [or],
    args: "target",
    attrs: !0,
    props: {
      target: Boolean,
      selActive: Boolean
    },
    data: {
      target: null,
      selActive: !1,
      attrItem: "uk-filter-control",
      cls: "uk-active",
      animation: 250
    },
    computed: {
      toggles: function toggles(t, e) {
        t.attrItem;
        return ze("[" + this.attrItem + "],[data-" + this.attrItem + "]", e);
      },
      target: function target(t, e) {
        return Be(t.target, e);
      }
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return "[" + this.attrItem + "],[data-" + this.attrItem + "]";
      },
      handler: function handler(t) {
        t.preventDefault(), this.apply(t.current);
      }
    }],
    connected: function connected() {
      var e = this;

      if (!1 !== this.selActive) {
        var i = ze(this.selActive, this.$el);
        this.toggles.forEach(function (t) {
          return fe(t, e.cls, b(i, t));
        });
      }
    },
    update: function update(t) {
      var e = t.toggles,
          i = t.children;
      dr(e, this.toggles, !1) && dr(i, this.target.children, !1) || (t.toggles = this.toggles, t.children = this.target.children, this.setState(this.getState(), !1));
    },
    methods: {
      apply: function apply(t) {
        this.setState(ur(t, this.attrItem, this.getState()));
      },
      getState: function getState() {
        var i = this;
        return this.toggles.filter(function (t) {
          return de(t, i.cls);
        }).reduce(function (t, e) {
          return ur(e, i.attrItem, t);
        }, {
          filter: {
            "": ""
          },
          sort: []
        });
      },
      setState: function setState(h, t) {
        var c = this;
        void 0 === t && (t = !0), h = Y({
          filter: {
            "": ""
          },
          sort: []
        }, h), _t(this.$el, "beforeFilter", [this, h]);
        var u = L(this.target.children);
        this.toggles.forEach(function (t) {
          return fe(t, c.cls, function (t, e, i) {
            var n = i.filter,
                r = i.sort,
                o = r[0],
                s = r[1],
                a = cr(t, e),
                l = a.filter,
                h = a.group;
            void 0 === h && (h = "");
            var c = a.sort,
                u = a.order;
            void 0 === u && (u = "asc");
            return Boolean((l || D(c)) && h in n && (l === n[h] || D(l) && !n[h]) || o && c && o === c && s === u);
          }(t, c.attrItem, h));
        });

        var e = function e() {
          var t,
              e,
              i = (t = h.filter, e = "", R(t, function (t) {
            return e += t || "";
          }), e);
          u.forEach(function (t) {
            return be(t, "display", i && !ft(t, i) ? "none" : "");
          });
          var n,
              r,
              o = h.sort,
              s = o[0],
              a = o[1];

          if (s) {
            var l = (n = s, r = a, L(u).sort(function (t, e) {
              return it(t, n).localeCompare(it(e, n), void 0, {
                numeric: !0
              }) * ("asc" === r || -1);
            }));
            dr(l, u) || l.forEach(function (t) {
              return Kt(c.target, t);
            });
          }
        };

        t ? this.animate(e).then(function () {
          return _t(c.$el, "afterFilter", [c]);
        }) : (e(), _t(this.$el, "afterFilter", [this]));
      }
    }
  };

  function cr(t, e) {
    return $i(it(t, e), ["filter"]);
  }

  function ur(t, s, a) {
    return L(t).forEach(function (t) {
      var e = cr(t, s),
          i = e.filter,
          n = e.group,
          r = e.sort,
          o = e.order;
      void 0 === o && (o = "asc"), (i || D(r)) && (n ? (delete a.filter[""], a.filter[n] = i) : a.filter = {
        "": i
      }), D(r) || (a.sort = [r, o]);
    }), a;
  }

  function dr(t, i, n) {
    return void 0 === n && (n = !0), t = L(t), i = L(i), t.length === i.length && t.every(function (t, e) {
      return n ? t === i[e] : ~i.indexOf(t);
    });
  }

  var fr = {
    slide: {
      show: function show(t) {
        return [{
          transform: mr(-100 * t)
        }, {
          transform: mr()
        }];
      },
      percent: function percent(t) {
        return pr(t);
      },
      translate: function translate(t, e) {
        return [{
          transform: mr(-100 * e * t)
        }, {
          transform: mr(100 * e * (1 - t))
        }];
      }
    }
  };

  function pr(t) {
    return Math.abs(be(t, "transform").split(",")[4] / t.offsetWidth) || 0;
  }

  function mr(t, e) {
    return void 0 === t && (t = 0), void 0 === e && (e = "%"), "translateX(" + t + (t ? e : "") + ")";
  }

  function gr(t) {
    return "scale3d(" + t + ", " + t + ", 1)";
  }

  var vr = Y({}, fr, {
    fade: {
      show: function show() {
        return [{
          opacity: 0
        }, {
          opacity: 1
        }];
      },
      percent: function percent(t) {
        return 1 - be(t, "opacity");
      },
      translate: function translate(t) {
        return [{
          opacity: 1 - t
        }, {
          opacity: t
        }];
      }
    },
    scale: {
      show: function show() {
        return [{
          opacity: 0,
          transform: gr(.8)
        }, {
          opacity: 1,
          transform: gr(1)
        }];
      },
      percent: function percent(t) {
        return 1 - be(t, "opacity");
      },
      translate: function translate(t) {
        return [{
          opacity: 1 - t,
          transform: gr(1 - .2 * t)
        }, {
          opacity: t,
          transform: gr(.8 + .2 * t)
        }];
      }
    }
  });

  function wr(t, e, i) {
    _t(t, At(e, !1, !1, i));
  }

  var br = {
    mixins: [{
      props: {
        autoplay: Boolean,
        autoplayInterval: Number,
        pauseOnHover: Boolean
      },
      data: {
        autoplay: !1,
        autoplayInterval: 7e3,
        pauseOnHover: !0
      },
      connected: function connected() {
        this.startAutoplay();
      },
      disconnected: function disconnected() {
        this.stopAutoplay();
      },
      events: [{
        name: "visibilitychange",
        el: document,
        handler: function handler() {
          document.hidden ? this.stopAutoplay() : this.startAutoplay();
        }
      }, {
        name: li,
        handler: "stopAutoplay"
      }, {
        name: "mouseenter",
        filter: function filter() {
          return this.autoplay;
        },
        handler: function handler() {
          this.isHovering = !0;
        }
      }, {
        name: "mouseleave",
        filter: function filter() {
          return this.autoplay;
        },
        handler: function handler() {
          this.isHovering = !1;
        }
      }],
      methods: {
        startAutoplay: function startAutoplay() {
          var t = this;
          this.stopAutoplay(), this.autoplay && (this.interval = setInterval(function () {
            return !(t.isHovering && t.pauseOnHover) && !t.stack.length && t.show("next");
          }, this.autoplayInterval));
        },
        stopAutoplay: function stopAutoplay() {
          this.interval && clearInterval(this.interval);
        }
      }
    }, {
      data: {
        threshold: 10,
        preventCatch: !1
      },
      init: function init() {
        var n = this;
        ["start", "move", "end"].forEach(function (t) {
          var i = n[t];

          n[t] = function (t) {
            var e = Bi(t).x * (ri ? -1 : 1);
            n.prevPos = e !== n.pos ? n.pos : n.prevPos, n.pos = e, i(t);
          };
        });
      },
      events: [{
        name: li,
        delegate: function delegate() {
          return this.slidesSelector;
        },
        handler: function handler(t) {
          var e;
          !Di(t) && !(e = t.target).children.length && e.childNodes.length || 0 < t.button || this.length < 2 || this.preventCatch || this.start(t);
        }
      }, {
        name: "touchmove",
        passive: !1,
        handler: "move",
        delegate: function delegate() {
          return this.slidesSelector;
        }
      }, {
        name: "dragstart",
        handler: function handler(t) {
          t.preventDefault();
        }
      }],
      methods: {
        start: function start() {
          var t = this;
          this.drag = this.pos, this._transitioner ? (this.percent = this._transitioner.percent(), this.drag += this._transitioner.getDistance() * this.percent * this.dir, this._transitioner.cancel(), this._transitioner.translate(this.percent), this.dragging = !0, this.stack = []) : this.prevIndex = this.index;
          var e = Tt(document, hi.replace(" touchmove", ""), this.move, {
            passive: !1
          });
          this.unbindMove = function () {
            e(), t.unbindMove = null;
          }, Tt(window, "scroll", this.unbindMove), Tt(document, ci, this.end, !0);
        },
        move: function move(t) {
          var e = this;

          if (this.unbindMove) {
            var i = this.pos - this.drag;

            if (!(0 === i || this.prevPos === this.pos || !this.dragging && Math.abs(i) < this.threshold)) {
              t.cancelable && t.preventDefault(), this.dragging = !0, this.dir = i < 0 ? 1 : -1;

              for (var n = this.slides, r = this.prevIndex, o = Math.abs(i), s = this.getIndex(r + this.dir, r), a = this._getDistance(r, s) || n[r].offsetWidth; s !== r && a < o;) {
                e.drag -= a * e.dir, r = s, o -= a, s = e.getIndex(r + e.dir, r), a = e._getDistance(r, s) || n[r].offsetWidth;
              }

              this.percent = o / a;
              var l,
                  h = n[r],
                  c = n[s],
                  u = this.index !== s,
                  d = r === s;
              [this.index, this.prevIndex].filter(function (t) {
                return !b([s, r], t);
              }).forEach(function (t) {
                _t(n[t], "itemhidden", [e]), d && (l = !0, e.prevIndex = r);
              }), (this.index === r && this.prevIndex !== r || l) && _t(n[this.index], "itemshown", [this]), u && (this.prevIndex = r, this.index = s, !d && _t(h, "beforeitemhide", [this]), _t(c, "beforeitemshow", [this])), this._transitioner = this._translate(Math.abs(this.percent), h, !d && c), u && (!d && _t(h, "itemhide", [this]), _t(c, "itemshow", [this]));
            }
          }
        },
        end: function end() {
          if (Et(window, "scroll", this.unbindMove), this.unbindMove && this.unbindMove(), Et(document, ci, this.end, !0), this.dragging) {
            if (this.dragging = null, this.index === this.prevIndex) this.percent = 1 - this.percent, this.dir *= -1, this._show(!1, this.index, !0), this._transitioner = null;else {
              var t = (ri ? this.dir * (ri ? 1 : -1) : this.dir) < 0 == this.prevPos > this.pos;
              this.index = t ? this.index : this.prevIndex, t && (this.percent = 1 - this.percent), this.show(0 < this.dir && !t || this.dir < 0 && t ? "next" : "previous", !0);
            }
            Bt();
          }

          this.drag = this.percent = null;
        }
      }
    }, {
      data: {
        selNav: !1
      },
      computed: {
        nav: function nav(t, e) {
          return Be(t.selNav, e);
        },
        navItemSelector: function navItemSelector(t) {
          var e = t.attrItem;
          return "[" + e + "],[data-" + e + "]";
        },
        navItems: function navItems(t, e) {
          return ze(this.navItemSelector, e);
        }
      },
      update: [{
        write: function write() {
          var i = this;
          this.nav && this.length !== this.nav.children.length && Jt(this.nav, this.slides.map(function (t, e) {
            return "<li " + i.attrItem + '="' + e + '"><a href="#"></a></li>';
          }).join("")), fe(ze(this.navItemSelector, this.$el).concat(this.nav), "uk-hidden", !this.maxIndex), this.updateNav();
        },
        events: ["load", "resize"]
      }],
      events: [{
        name: "click",
        delegate: function delegate() {
          return this.navItemSelector;
        },
        handler: function handler(t) {
          t.preventDefault(), t.current.blur(), this.show(it(t.current, this.attrItem));
        }
      }, {
        name: "itemshow",
        handler: "updateNav"
      }],
      methods: {
        updateNav: function updateNav() {
          var i = this,
              n = this.getValidIndex();
          this.navItems.forEach(function (t) {
            var e = it(t, i.attrItem);
            fe(t, i.clsActive, z(e) === n), fe(t, "uk-invisible", i.finite && ("previous" === e && 0 === n || "next" === e && n >= i.maxIndex));
          });
        }
      }
    }],
    attrs: !0,
    props: {
      clsActivated: Boolean,
      easing: String,
      index: Number,
      finite: Boolean,
      velocity: Number
    },
    data: function data() {
      return {
        easing: "ease",
        finite: !1,
        velocity: 1,
        index: 0,
        stack: [],
        percent: 0,
        clsActive: "uk-active",
        clsActivated: !1,
        Transitioner: !1,
        transitionOptions: {}
      };
    },
    computed: {
      duration: function duration(t, e) {
        var i = t.velocity;
        return yr(e.offsetWidth / i);
      },
      length: function length() {
        return this.slides.length;
      },
      list: function list(t, e) {
        return Be(t.selList, e);
      },
      maxIndex: function maxIndex() {
        return this.length - 1;
      },
      slidesSelector: function slidesSelector(t) {
        return t.selList + " > *";
      },
      slides: function slides() {
        return L(this.list.children);
      }
    },
    events: {
      itemshown: function itemshown() {
        this.$update(this.list);
      }
    },
    methods: {
      show: function show(t, e) {
        var i = this;

        if (void 0 === e && (e = !1), !this.dragging && this.length) {
          var n = this.stack,
              r = e ? 0 : n.length,
              o = function o() {
            n.splice(r, 1), n.length && i.show(n.shift(), !0);
          };

          if (n[e ? "unshift" : "push"](t), !e && 1 < n.length) 2 === n.length && this._transitioner.forward(Math.min(this.duration, 200));else {
            var s = this.index,
                a = de(this.slides, this.clsActive) && this.slides[s],
                l = this.getIndex(t, this.index),
                h = this.slides[l];

            if (a !== h) {
              var c, u;
              if (this.dir = (u = s, "next" === (c = t) ? 1 : "previous" === c ? -1 : c < u ? -1 : 1), this.prevIndex = s, this.index = l, a && _t(a, "beforeitemhide", [this]), !_t(h, "beforeitemshow", [this, a])) return this.index = this.prevIndex, void o();

              var d = this._show(a, h, e).then(function () {
                return a && _t(a, "itemhidden", [i]), _t(h, "itemshown", [i]), new zt(function (t) {
                  fi.write(function () {
                    n.shift(), n.length ? i.show(n.shift(), !0) : i._transitioner = null, t();
                  });
                });
              });

              return a && _t(a, "itemhide", [this]), _t(h, "itemshow", [this]), d;
            }

            o();
          }
        }
      },
      getIndex: function getIndex(t, e) {
        return void 0 === t && (t = this.index), void 0 === e && (e = this.index), U(Ut(t, this.slides, e, this.finite), 0, this.maxIndex);
      },
      getValidIndex: function getValidIndex(t, e) {
        return void 0 === t && (t = this.index), void 0 === e && (e = this.prevIndex), this.getIndex(t, e);
      },
      _show: function _show(t, e, i) {
        if (this._transitioner = this._getTransitioner(t, e, this.dir, Y({
          easing: i ? e.offsetWidth < 600 ? "cubic-bezier(0.25, 0.46, 0.45, 0.94)" : "cubic-bezier(0.165, 0.84, 0.44, 1)" : this.easing
        }, this.transitionOptions)), !i && !t) return this._transitioner.translate(1), zt.resolve();
        var n = this.stack.length;
        return this._transitioner[1 < n ? "forward" : "show"](1 < n ? Math.min(this.duration, 75 + 75 / (n - 1)) : this.duration, this.percent);
      },
      _getDistance: function _getDistance(t, e) {
        return new this._getTransitioner(t, t !== e && e).getDistance();
      },
      _translate: function _translate(t, e, i) {
        void 0 === e && (e = this.prevIndex), void 0 === i && (i = this.index);

        var n = this._getTransitioner(e !== i && e, i);

        return n.translate(t), n;
      },
      _getTransitioner: function _getTransitioner(t, e, i, n) {
        return void 0 === t && (t = this.prevIndex), void 0 === e && (e = this.index), void 0 === i && (i = this.dir || 1), void 0 === n && (n = this.transitionOptions), new this.Transitioner(O(t) ? this.slides[t] : t, O(e) ? this.slides[e] : e, i * (ri ? -1 : 1), n);
      }
    }
  };

  function yr(t) {
    return .5 * t + 300;
  }

  var xr = {
    mixins: [br],
    props: {
      animation: String
    },
    data: {
      animation: "slide",
      clsActivated: "uk-transition-active",
      Animations: fr,
      Transitioner: function Transitioner(o, s, a, t) {
        var e = t.animation,
            l = t.easing,
            i = e.percent,
            n = e.translate,
            r = e.show;
        void 0 === r && (r = X);
        var h = r(a),
            c = new Pt();
        return {
          dir: a,
          show: function show(t, e, i) {
            var n = this;
            void 0 === e && (e = 0);
            var r = i ? "linear" : l;
            return t -= Math.round(t * U(e, -1, 1)), this.translate(e), wr(s, "itemin", {
              percent: e,
              duration: t,
              timing: r,
              dir: a
            }), wr(o, "itemout", {
              percent: 1 - e,
              duration: t,
              timing: r,
              dir: a
            }), zt.all([_e.start(s, h[1], t, r), _e.start(o, h[0], t, r)]).then(function () {
              n.reset(), c.resolve();
            }, X), c.promise;
          },
          stop: function stop() {
            return _e.stop([s, o]);
          },
          cancel: function cancel() {
            _e.cancel([s, o]);
          },
          reset: function reset() {
            for (var t in h[0]) {
              be([s, o], t, "");
            }
          },
          forward: function forward(t, e) {
            return void 0 === e && (e = this.percent()), _e.cancel([s, o]), this.show(t, e, !0);
          },
          translate: function translate(t) {
            this.reset();
            var e = n(t, a);
            be(s, e[1]), be(o, e[0]), wr(s, "itemtranslatein", {
              percent: t,
              dir: a
            }), wr(o, "itemtranslateout", {
              percent: 1 - t,
              dir: a
            });
          },
          percent: function percent() {
            return i(o || s, s, a);
          },
          getDistance: function getDistance() {
            return o.offsetWidth;
          }
        };
      }
    },
    computed: {
      animation: function animation(t) {
        var e = t.animation,
            i = t.Animations;
        return Y(e in i ? i[e] : i.slide, {
          name: e
        });
      },
      transitionOptions: function transitionOptions() {
        return {
          animation: this.animation
        };
      }
    },
    events: {
      "itemshow itemhide itemshown itemhidden": function itemshowItemhideItemshownItemhidden(t) {
        var e = t.target;
        this.$update(e);
      },
      itemshow: function itemshow() {
        O(this.prevIndex) && fi.flush();
      },
      beforeitemshow: function beforeitemshow(t) {
        le(t.target, this.clsActive);
      },
      itemshown: function itemshown(t) {
        le(t.target, this.clsActivated);
      },
      itemhidden: function itemhidden(t) {
        he(t.target, this.clsActive, this.clsActivated);
      }
    }
  },
      kr = {
    mixins: [Hn, Wn, Yi, xr],
    functional: !0,
    props: {
      delayControls: Number,
      preload: Number,
      videoAutoplay: Boolean,
      template: String
    },
    data: function data() {
      return {
        preload: 1,
        videoAutoplay: !1,
        delayControls: 3e3,
        items: [],
        cls: "uk-open",
        clsPage: "uk-lightbox-page",
        selList: ".uk-lightbox-items",
        attrItem: "uk-lightbox-item",
        selClose: ".uk-close-large",
        pauseOnHover: !1,
        velocity: 2,
        Animations: vr,
        template: '<div class="uk-lightbox uk-overflow-hidden"> <ul class="uk-lightbox-items"></ul> <div class="uk-lightbox-toolbar uk-position-top uk-text-right uk-transition-slide-top uk-transition-opaque"> <button class="uk-lightbox-toolbar-icon uk-close-large" type="button" uk-close></button> </div> <a class="uk-lightbox-button uk-position-center-left uk-position-medium uk-transition-fade" href="#" uk-slidenav-previous uk-lightbox-item="previous"></a> <a class="uk-lightbox-button uk-position-center-right uk-position-medium uk-transition-fade" href="#" uk-slidenav-next uk-lightbox-item="next"></a> <div class="uk-lightbox-toolbar uk-lightbox-caption uk-position-bottom uk-text-center uk-transition-slide-bottom uk-transition-opaque"></div> </div>'
      };
    },
    created: function created() {
      var t = this;
      this.$mount(Kt(this.container, this.template)), this.caption = Be(".uk-lightbox-caption", this.$el), this.items.forEach(function () {
        return Kt(t.list, "<li></li>");
      });
    },
    events: [{
      name: hi + " " + li + " keydown",
      handler: "showControls"
    }, {
      name: "click",
      self: !0,
      delegate: function delegate() {
        return this.slidesSelector;
      },
      handler: function handler(t) {
        t.preventDefault(), this.hide();
      }
    }, {
      name: "shown",
      self: !0,
      handler: "showControls"
    }, {
      name: "hide",
      self: !0,
      handler: function handler() {
        this.hideControls(), he(this.slides, this.clsActive), _e.stop(this.slides);
      }
    }, {
      name: "keyup",
      el: document,
      handler: function handler(t) {
        if (this.isToggled(this.$el)) switch (t.keyCode) {
          case 37:
            this.show("previous");
            break;

          case 39:
            this.show("next");
        }
      }
    }, {
      name: "beforeitemshow",
      handler: function handler(t) {
        this.isToggled() || (this.preventCatch = !0, t.preventDefault(), this.toggleNow(this.$el, !0), this.animation = vr.scale, he(t.target, this.clsActive), this.stack.splice(1, 0, this.index));
      }
    }, {
      name: "itemshow",
      handler: function handler(t) {
        var e = qt(t.target),
            i = this.getItem(e).caption;
        be(this.caption, "display", i ? "" : "none"), Jt(this.caption, i);

        for (var n = 0; n <= this.preload; n++) {
          this.loadItem(this.getIndex(e + n)), this.loadItem(this.getIndex(e - n));
        }
      }
    }, {
      name: "itemshown",
      handler: function handler() {
        this.preventCatch = !1;
      }
    }, {
      name: "itemload",
      handler: function handler(t, r) {
        var o,
            s = this,
            e = r.source,
            i = r.type,
            n = r.alt;
        if (this.setItem(r, "<span uk-spinner></span>"), e) if ("image" === i || e.match(/\.(jp(e)?g|png|gif|svg)($|\?)/i)) Vt(e).then(function (t) {
          return s.setItem(r, '<img width="' + t.width + '" height="' + t.height + '" src="' + e + '" alt="' + (n || "") + '">');
        }, function () {
          return s.setError(r);
        });else if ("video" === i || e.match(/\.(mp4|webm|ogv)($|\?)/i)) {
          var a = Be("<video controls playsinline" + (r.poster ? ' poster="' + r.poster + '"' : "") + ' uk-video="' + this.videoAutoplay + '"></video>');
          Z(a, "src", e), Tt(a, "error", function () {
            return s.setError(r);
          }), Tt(a, "loadedmetadata", function () {
            Z(a, {
              width: a.videoWidth,
              height: a.videoHeight
            }), s.setItem(r, a);
          });
        } else if ("iframe" === i || e.match(/\.(html|php)($|\?)/i)) this.setItem(r, '<iframe class="uk-lightbox-iframe" src="' + e + '" frameborder="0" allowfullscreen></iframe>');else if (o = e.match(/\/\/.*?youtube(-nocookie)?\.[a-z]+\/watch\?v=([^&\s]+)/) || e.match(/()youtu\.be\/(.*)/)) {
          var l = o[2],
              h = function h(t, e) {
            return void 0 === t && (t = 640), void 0 === e && (e = 450), s.setItem(r, $r("https://www.youtube" + (o[1] || "") + ".com/embed/" + l, t, e, s.videoAutoplay));
          };

          Vt("https://img.youtube.com/vi/" + l + "/maxresdefault.jpg").then(function (t) {
            var e = t.width,
                i = t.height;
            120 === e && 90 === i ? Vt("https://img.youtube.com/vi/" + l + "/0.jpg").then(function (t) {
              var e = t.width,
                  i = t.height;
              return h(e, i);
            }, h) : h(e, i);
          }, h);
        } else (o = e.match(/(\/\/.*?)vimeo\.[a-z]+\/([0-9]+).*?/)) && Ft("https://vimeo.com/api/oembed.json?maxwidth=1920&url=" + encodeURI(e), {
          responseType: "json",
          withCredentials: !1
        }).then(function (t) {
          var e = t.response,
              i = e.height,
              n = e.width;
          return s.setItem(r, $r("https://player.vimeo.com/video/" + o[2], n, i, s.videoAutoplay));
        }, function () {
          return s.setError(r);
        });
      }
    }],
    methods: {
      loadItem: function loadItem(t) {
        void 0 === t && (t = this.index);
        var e = this.getItem(t);
        e.content || _t(this.$el, "itemload", [e]);
      },
      getItem: function getItem(t) {
        return void 0 === t && (t = this.index), this.items[t] || {};
      },
      setItem: function setItem(t, e) {
        Y(t, {
          content: e
        });
        var i = Jt(this.slides[this.items.indexOf(t)], e);
        _t(this.$el, "itemloaded", [this, i]), this.$update(i);
      },
      setError: function setError(t) {
        this.setItem(t, '<span uk-icon="icon: bolt; ratio: 2"></span>');
      },
      showControls: function showControls() {
        clearTimeout(this.controlsTimer), this.controlsTimer = setTimeout(this.hideControls, this.delayControls), le(this.$el, "uk-active", "uk-transition-active");
      },
      hideControls: function hideControls() {
        he(this.$el, "uk-active", "uk-transition-active");
      }
    }
  };

  function $r(t, e, i, n) {
    return '<iframe src="' + t + '" width="' + e + '" height="' + i + '" style="max-width: 100%; box-sizing: border-box;" frameborder="0" allowfullscreen uk-video="autoplay: ' + n + '" uk-responsive></iframe>';
  }

  var Ir,
      Sr = {
    install: function install(t, e) {
      t.lightboxPanel || t.component("lightboxPanel", kr);
      Y(e.props, t.component("lightboxPanel").options.props);
    },
    attrs: !0,
    props: {
      toggle: String
    },
    data: {
      toggle: "a"
    },
    computed: {
      toggles: function toggles(t, e) {
        return ze(t.toggle, e);
      }
    },
    disconnected: function disconnected() {
      this._destroy();
    },
    events: [{
      name: "click",
      delegate: function delegate() {
        return this.toggle + ":not(.uk-disabled)";
      },
      handler: function handler(t) {
        t.preventDefault(), t.current.blur(), this.show(qt(this.toggles, t.current));
      }
    }],
    update: function update(t) {
      var e, i;
      (t.toggles = this.panel && t.toggles || this.toggles, this.panel && (e = t.toggles, i = this.toggles, e.length !== i.length || !e.every(function (t, e) {
        return t === i[e];
      }))) && (t.toggles = this.toggles, this._destroy(), this._init());
    },
    methods: {
      _init: function _init() {
        return this.panel = this.panel || this.$create("lightboxPanel", Y({}, this.$props, {
          items: this.toggles.reduce(function (t, i) {
            return t.push(["href", "caption", "type", "poster", "alt"].reduce(function (t, e) {
              return t["href" === e ? "source" : e] = it(i, e), t;
            }, {})), t;
          }, [])
        }));
      },
      _destroy: function _destroy() {
        this.panel && (this.panel.$destroy(!0), this.panel = null);
      },
      show: function show(t) {
        return this.panel || this._init(), this.panel.show(t);
      },
      hide: function hide() {
        return this.panel && this.panel.hide();
      }
    }
  };
  var Tr = {},
      Er = {
    functional: !0,
    args: ["message", "status"],
    data: {
      message: "",
      status: "",
      timeout: 5e3,
      group: null,
      pos: "top-center",
      clsClose: "uk-notification-close",
      clsMsg: "uk-notification-message"
    },
    install: function install(r) {
      r.notification.closeAll = function (i, n) {
        ae(document.body, function (t) {
          var e = r.getComponent(t, "notification");
          !e || i && i !== e.group || e.close(n);
        });
      };
    },
    created: function created() {
      Tr[this.pos] || (Tr[this.pos] = Kt(this.$container, '<div class="uk-notification uk-notification-' + this.pos + '"></div>'));
      var t = be(Tr[this.pos], "display", "block");
      this.$mount(Kt(t, '<div class="' + this.clsMsg + (this.status ? " " + this.clsMsg + "-" + this.status : "") + '"> <a href="#" class="' + this.clsClose + '" data-uk-close></a> <div>' + this.message + "</div> </div>"));
    },
    ready: function ready() {
      var t = this,
          e = P(be(this.$el, "marginBottom"));

      _e.start(be(this.$el, {
        opacity: 0,
        marginTop: -this.$el.offsetHeight,
        marginBottom: 0
      }), {
        opacity: 1,
        marginTop: 0,
        marginBottom: e
      }).then(function () {
        t.timeout && (t.timer = setTimeout(t.close, t.timeout));
      });
    },
    events: (Ir = {
      click: function click(t) {
        mt(t.target, 'a[href="#"]') && t.preventDefault(), this.close();
      }
    }, Ir[ui] = function () {
      this.timer && clearTimeout(this.timer);
    }, Ir[di] = function () {
      this.timeout && (this.timer = setTimeout(this.close, this.timeout));
    }, Ir),
    methods: {
      close: function close(t) {
        var e = this,
            i = function i() {
          _t(e.$el, "close", [e]), te(e.$el), Tr[e.pos].children.length || be(Tr[e.pos], "display", "none");
        };

        this.timer && clearTimeout(this.timer), t ? i() : _e.start(this.$el, {
          opacity: 0,
          marginTop: -this.$el.offsetHeight,
          marginBottom: 0
        }).then(i);
      }
    }
  };
  var Cr = ["x", "y", "bgx", "bgy", "rotate", "scale", "color", "backgroundColor", "borderColor", "opacity", "blur", "hue", "grayscale", "invert", "saturate", "sepia", "fopacity"],
      _r = {
    props: Cr.reduce(function (t, e) {
      return t[e] = "list", t;
    }, {
      media: "media"
    }),
    data: Cr.reduce(function (t, e) {
      return t[e] = void 0, t;
    }, {
      media: !1
    }),
    computed: {
      props: function props(f, p) {
        var m = this;
        return Cr.reduce(function (t, e) {
          if (D(f[e])) return t;
          var i,
              n,
              r,
              o = e.match(/color/i),
              s = o || "opacity" === e,
              a = f[e].slice(0);
          s && be(p, e, ""), a.length < 2 && a.unshift(("scale" === e ? 1 : s ? be(p, e) : 0) || 0);
          var l = b(a.join(""), "%") ? "%" : "px";

          if (o) {
            var h = p.style.color;
            a = a.map(function (t) {
              return be(be(p, "color", t), "color").split(/[(),]/g).slice(1, -1).concat(1).slice(0, 4).map(function (t) {
                return P(t);
              });
            }), p.style.color = h;
          } else a = a.map(P);

          if (e.match(/^bg/)) if (be(p, "background-position-" + e[2], ""), n = be(p, "backgroundPosition").split(" ")["x" === e[2] ? 0 : 1], m.covers) {
            var c = Math.min.apply(Math, a),
                u = Math.max.apply(Math, a),
                d = a.indexOf(c) < a.indexOf(u);
            r = u - c, a = a.map(function (t) {
              return t - (d ? c : u);
            }), i = (d ? -r : 0) + "px";
          } else i = n;
          return t[e] = {
            steps: a,
            unit: l,
            pos: i,
            bgPos: n,
            diff: r
          }, t;
        }, {});
      },
      bgProps: function bgProps() {
        var e = this;
        return ["bgx", "bgy"].filter(function (t) {
          return t in e.props;
        });
      },
      covers: function covers(t, e) {
        return n = (i = e).style.backgroundSize, r = "cover" === be(be(i, "backgroundSize", ""), "backgroundSize"), i.style.backgroundSize = n, r;
        var i, n, r;
      }
    },
    disconnected: function disconnected() {
      delete this._image;
    },
    update: [{
      read: function read(e) {
        var i = this;

        if (e.active = !this.media || window.matchMedia(this.media).matches, e.image && (e.image.dimEl = {
          width: this.$el.offsetWidth,
          height: this.$el.offsetHeight
        }), !("image" in e) && this.covers && this.bgProps.length) {
          var t = be(this.$el, "backgroundImage").replace(/^none|url\(["']?(.+?)["']?\)$/, "$1");
          t && (e.image = !1, Vt(t).then(function (t) {
            e.image = {
              width: t.naturalWidth,
              height: t.naturalHeight
            }, i.$emit();
          }));
        }
      },
      write: function write(t) {
        var l = this,
            h = t.image,
            e = t.active;
        if (h) if (e) {
          var c = h.dimEl,
              u = G.cover(h, c);
          this.bgProps.forEach(function (t) {
            var e = l.props[t],
                i = e.diff,
                n = e.bgPos,
                r = e.steps,
                o = "bgy" === t ? "height" : "width",
                s = u[o] - c[o];

            if (n.match(/%$|0px/)) {
              if (s < i) c[o] = u[o] + i - s;else if (i < s) {
                var a = parseFloat(n);
                a && (l.props[t].steps = r.map(function (t) {
                  return t - (s - i) / (100 / a);
                }));
              }
              u = G.cover(h, c);
            }
          }), be(this.$el, {
            backgroundSize: u.width + "px " + u.height + "px",
            backgroundRepeat: "no-repeat"
          });
        } else be(this.$el, {
          backgroundSize: "",
          backgroundRepeat: ""
        });
      },
      events: ["load", "resize"]
    }],
    methods: {
      reset: function reset() {
        var i = this;
        R(this.getCss(0), function (t, e) {
          return be(i.$el, e, "");
        });
      },
      getCss: function getCss(p) {
        var m = this.props,
            g = !1;
        return Object.keys(m).reduce(function (t, e) {
          var i = m[e],
              n = i.steps,
              r = i.unit,
              o = i.pos,
              s = Nr(n, p);

          switch (e) {
            case "x":
            case "y":
              if (g) break;
              var a = ["x", "y"].map(function (t) {
                return e === t ? s + r : m[t] ? Nr(m[t].steps, p) + m[t].unit : 0;
              }),
                  l = a[0],
                  h = a[1];
              g = t.transform += " translate3d(" + l + ", " + h + ", 0)";
              break;

            case "rotate":
              t.transform += " rotate(" + s + "deg)";
              break;

            case "scale":
              t.transform += " scale(" + s + ")";
              break;

            case "bgy":
            case "bgx":
              t["background-position-" + e[2]] = "calc(" + o + " + " + (s + r) + ")";
              break;

            case "color":
            case "backgroundColor":
            case "borderColor":
              var c = Ar(n, p),
                  u = c[0],
                  d = c[1],
                  f = c[2];
              t[e] = "rgba(" + u.map(function (t, e) {
                return t += f * (d[e] - t), 3 === e ? P(t) : parseInt(t, 10);
              }).join(",") + ")";
              break;

            case "blur":
              t.filter += " blur(" + s + "px)";
              break;

            case "hue":
              t.filter += " hue-rotate(" + s + "deg)";
              break;

            case "fopacity":
              t.filter += " opacity(" + s + "%)";
              break;

            case "grayscale":
            case "invert":
            case "saturate":
            case "sepia":
              t.filter += " " + e + "(" + s + "%)";
              break;

            default:
              t[e] = s;
          }

          return t;
        }, {
          transform: "",
          filter: ""
        });
      }
    }
  };

  function Ar(t, e) {
    var i = t.length - 1,
        n = Math.min(Math.floor(i * e), i - 1),
        r = t.slice(n, n + 2);
    return r.push(1 === e ? 1 : e % (1 / i) * i), r;
  }

  function Nr(t, e) {
    var i = Ar(t, e),
        n = i[0],
        r = i[1],
        o = i[2];
    return (O(n) ? n + Math.abs(n - r) * o * (n < r ? 1 : -1) : +r).toFixed(2);
  }

  var Or = {
    mixins: [_r],
    props: {
      target: String,
      viewport: Number,
      easing: Number
    },
    data: {
      target: !1,
      viewport: 1,
      easing: 1
    },
    computed: {
      target: function target(t, e) {
        var i = t.target;
        return i && nt(i, e) || e;
      }
    },
    update: [{
      read: function read(t) {
        var e, i;
        return {
          prev: t.percent,
          percent: (e = Ze(this.target) / (this.viewport || 1), i = this.easing, U(e * (1 - (i - i * e))))
        };
      },
      write: function write(t, e) {
        var i = t.prev,
            n = t.percent,
            r = t.active;
        "scroll" !== e.type && (i = !1), r ? i !== n && be(this.$el, this.getCss(n)) : this.reset();
      },
      events: ["scroll", "load", "resize"]
    }]
  };
  var Mr = {
    update: [{
      write: function write() {
        if (!this.stack.length && !this.dragging) {
          var t = this.getValidIndex();
          delete this.index, he(this.slides, this.clsActive, this.clsActivated), this.show(t);
        }
      },
      events: ["load", "resize"]
    }]
  };

  function Dr(t, e, i) {
    var n,
        r = Pr(t, e);
    return i ? r - (n = t, e.offsetWidth / 2 - n.offsetWidth / 2) : Math.min(r, Br(e));
  }

  function Br(t) {
    return Math.max(0, zr(t) - t.offsetWidth);
  }

  function zr(t) {
    return Wr(t).reduce(function (t, e) {
      return e.offsetWidth + t;
    }, 0);
  }

  function Pr(t, e) {
    return (t.offsetLeft + (ri ? t.offsetWidth - e.offsetWidth : 0)) * (ri ? -1 : 1);
  }

  function Hr(t, e, i) {
    _t(t, At(e, !1, !1, i));
  }

  function Wr(t) {
    return L(t.children);
  }

  var Lr = {
    mixins: [Vi, br, Mr],
    props: {
      center: Boolean,
      sets: Boolean
    },
    data: {
      center: !1,
      sets: !1,
      attrItem: "uk-slider-item",
      selList: ".uk-slider-items",
      selNav: ".uk-slider-nav",
      clsContainer: "uk-slider-container",
      Transitioner: function Transitioner(r, n, o, t) {
        var e = t.center,
            s = t.easing,
            a = t.list,
            l = new Pt(),
            i = r ? Dr(r, a, e) : Dr(n, a, e) + n.offsetWidth * o,
            h = n ? Dr(n, a, e) : i + r.offsetWidth * o * (ri ? -1 : 1);
        return {
          dir: o,
          show: function show(t, e, i) {
            void 0 === e && (e = 0);
            var n = i ? "linear" : s;
            return t -= Math.round(t * U(e, -1, 1)), this.translate(e), r && this.updateTranslates(), e = r ? e : U(e, 0, 1), Hr(this.getItemIn(), "itemin", {
              percent: e,
              duration: t,
              timing: n,
              dir: o
            }), r && Hr(this.getItemIn(!0), "itemout", {
              percent: 1 - e,
              duration: t,
              timing: n,
              dir: o
            }), _e.start(a, {
              transform: mr(-h * (ri ? -1 : 1), "px")
            }, t, n).then(l.resolve, X), l.promise;
          },
          stop: function stop() {
            return _e.stop(a);
          },
          cancel: function cancel() {
            _e.cancel(a);
          },
          reset: function reset() {
            be(a, "transform", "");
          },
          forward: function forward(t, e) {
            return void 0 === e && (e = this.percent()), _e.cancel(a), this.show(t, e, !0);
          },
          translate: function translate(t) {
            var e = this.getDistance() * o * (ri ? -1 : 1);
            be(a, "transform", mr(U(e - e * t - h, -zr(a), a.offsetWidth) * (ri ? -1 : 1), "px")), this.updateTranslates(), r && (t = U(t, -1, 1), Hr(this.getItemIn(), "itemtranslatein", {
              percent: t,
              dir: o
            }), Hr(this.getItemIn(!0), "itemtranslateout", {
              percent: 1 - t,
              dir: o
            }));
          },
          percent: function percent() {
            return Math.abs((be(a, "transform").split(",")[4] * (ri ? -1 : 1) + i) / (h - i));
          },
          getDistance: function getDistance() {
            return Math.abs(h - i);
          },
          getItemIn: function getItemIn(t) {
            void 0 === t && (t = !1);
            var e = this.getActives(),
                i = q(Wr(a), "offsetLeft"),
                n = qt(i, e[0 < o * (t ? -1 : 1) ? e.length - 1 : 0]);
            return ~n && i[n + (r && !t ? o : 0)];
          },
          getActives: function getActives() {
            var i = Dr(r || n, a, e);
            return q(Wr(a).filter(function (t) {
              var e = Pr(t, a);
              return i <= e && e + t.offsetWidth <= a.offsetWidth + i;
            }), "offsetLeft");
          },
          updateTranslates: function updateTranslates() {
            var i = this.getActives();
            Wr(a).forEach(function (t) {
              var e = b(i, t);
              Hr(t, "itemtranslate" + (e ? "in" : "out"), {
                percent: e ? 1 : 0,
                dir: t.offsetLeft <= n.offsetLeft ? 1 : -1
              });
            });
          }
        };
      }
    },
    computed: {
      avgWidth: function avgWidth() {
        return zr(this.list) / this.length;
      },
      finite: function finite(t) {
        return t.finite || zr(this.list) < this.list.offsetWidth + Wr(this.list).reduce(function (t, e) {
          return Math.max(t, e.offsetWidth);
        }, 0) + this.center;
      },
      maxIndex: function maxIndex() {
        if (!this.finite || this.center && !this.sets) return this.length - 1;
        if (this.center) return this.sets[this.sets.length - 1];
        be(this.slides, "order", "");

        for (var t = Br(this.list), e = this.length; e--;) {
          if (Pr(this.list.children[e], this.list) < t) return Math.min(e + 1, this.length - 1);
        }

        return 0;
      },
      sets: function sets(t) {
        var o = this,
            e = t.sets,
            s = this.list.offsetWidth / (this.center ? 2 : 1),
            a = 0,
            l = s,
            h = 0;
        return (e = e && this.slides.reduce(function (t, e, i) {
          var n = Le(e).width;

          if (a < h + n && (!o.center && i > o.maxIndex && (i = o.maxIndex), !b(t, i))) {
            var r = o.slides[i + 1];
            o.center && r && n < l - Le(r).width / 2 ? l -= n : (l = s, t.push(i), a = h + s + (o.center ? n / 2 : 0));
          }

          return h += n, t;
        }, [])) && e.length && e;
      },
      transitionOptions: function transitionOptions() {
        return {
          center: this.center,
          list: this.list
        };
      }
    },
    connected: function connected() {
      fe(this.$el, this.clsContainer, !Be("." + this.clsContainer, this.$el));
    },
    update: {
      write: function write() {
        var i = this;
        ze("[" + this.attrItem + "],[data-" + this.attrItem + "]", this.$el).forEach(function (t) {
          var e = it(t, i.attrItem);
          i.maxIndex && fe(t, "uk-hidden", M(e) && (i.sets && !b(i.sets, P(e)) || e > i.maxIndex));
        });
      },
      events: ["load", "resize"]
    },
    events: {
      beforeitemshow: function beforeitemshow(t) {
        !this.dragging && this.sets && this.stack.length < 2 && !b(this.sets, this.index) && (this.index = this.getValidIndex());
        var e = Math.abs(this.index - this.prevIndex + (0 < this.dir && this.index < this.prevIndex || this.dir < 0 && this.index > this.prevIndex ? (this.maxIndex + 1) * this.dir : 0));

        if (!this.dragging && 1 < e) {
          for (var i = 0; i < e; i++) {
            this.stack.splice(1, 0, 0 < this.dir ? "next" : "previous");
          }

          t.preventDefault();
        } else this.duration = yr(this.avgWidth / this.velocity) * ((this.dir < 0 || !this.slides[this.prevIndex] ? this.slides[this.index] : this.slides[this.prevIndex]).offsetWidth / this.avgWidth), this.reorder();
      },
      itemshow: function itemshow() {
        !D(this.prevIndex) && le(this._getTransitioner().getItemIn(), this.clsActive);
      },
      itemshown: function itemshown() {
        var e = this,
            i = this._getTransitioner(this.index).getActives();

        this.slides.forEach(function (t) {
          return fe(t, e.clsActive, b(i, t));
        }), (!this.sets || b(this.sets, P(this.index))) && this.slides.forEach(function (t) {
          return fe(t, e.clsActivated, b(i, t));
        });
      }
    },
    methods: {
      reorder: function reorder() {
        var i = this;

        if (be(this.slides, "order", ""), !this.finite) {
          var n = 0 < this.dir && this.slides[this.prevIndex] ? this.prevIndex : this.index;
          if (this.slides.forEach(function (t, e) {
            return be(t, "order", 0 < i.dir && e < n ? 1 : i.dir < 0 && e >= i.index ? -1 : "");
          }), this.center) for (var t = this.slides[n], e = this.list.offsetWidth / 2 - t.offsetWidth / 2, r = 0; 0 < e;) {
            var o = i.getIndex(--r + n, n),
                s = i.slides[o];
            be(s, "order", n < o ? -2 : -1), e -= s.offsetWidth;
          }
        }
      },
      getValidIndex: function getValidIndex(t, e) {
        var i;
        if (void 0 === t && (t = this.index), void 0 === e && (e = this.prevIndex), t = this.getIndex(t, e), !this.sets) return t;

        do {
          if (b(this.sets, t)) return t;
          i = t, t = this.getIndex(t + this.dir, e);
        } while (t !== i);

        return t;
      }
    }
  },
      jr = {
    mixins: [_r],
    data: {
      selItem: "!li"
    },
    computed: {
      item: function item(t, e) {
        return nt(t.selItem, e);
      }
    },
    events: [{
      name: "itemshown",
      self: !0,
      el: function el() {
        return this.item;
      },
      handler: function handler() {
        be(this.$el, this.getCss(.5));
      }
    }, {
      name: "itemin itemout",
      self: !0,
      el: function el() {
        return this.item;
      },
      handler: function handler(t) {
        var e = t.type,
            i = t.detail,
            n = i.percent,
            r = i.duration,
            o = i.timing,
            s = i.dir;
        _e.cancel(this.$el), be(this.$el, this.getCss(Vr(e, s, n))), _e.start(this.$el, this.getCss(Fr(e) ? .5 : 0 < s ? 1 : 0), r, o).catch(X);
      }
    }, {
      name: "transitioncanceled transitionend",
      self: !0,
      el: function el() {
        return this.item;
      },
      handler: function handler() {
        _e.cancel(this.$el);
      }
    }, {
      name: "itemtranslatein itemtranslateout",
      self: !0,
      el: function el() {
        return this.item;
      },
      handler: function handler(t) {
        var e = t.type,
            i = t.detail,
            n = i.percent,
            r = i.dir;
        _e.cancel(this.$el), be(this.$el, this.getCss(Vr(e, r, n)));
      }
    }]
  };

  function Fr(t) {
    return u(t, "in");
  }

  function Vr(t, e, i) {
    return i /= 2, Fr(t) ? e < 0 ? 1 - i : i : e < 0 ? i : 1 - i;
  }

  var Yr,
      Rr,
      qr = Y({}, fr, {
    fade: {
      show: function show() {
        return [{
          opacity: 0,
          zIndex: 0
        }, {
          zIndex: -1
        }];
      },
      percent: function percent(t) {
        return 1 - be(t, "opacity");
      },
      translate: function translate(t) {
        return [{
          opacity: 1 - t,
          zIndex: 0
        }, {
          zIndex: -1
        }];
      }
    },
    scale: {
      show: function show() {
        return [{
          opacity: 0,
          transform: gr(1.5),
          zIndex: 0
        }, {
          zIndex: -1
        }];
      },
      percent: function percent(t) {
        return 1 - be(t, "opacity");
      },
      translate: function translate(t) {
        return [{
          opacity: 1 - t,
          transform: gr(1 + .5 * t),
          zIndex: 0
        }, {
          zIndex: -1
        }];
      }
    },
    pull: {
      show: function show(t) {
        return t < 0 ? [{
          transform: mr(30),
          zIndex: -1
        }, {
          transform: mr(),
          zIndex: 0
        }] : [{
          transform: mr(-100),
          zIndex: 0
        }, {
          transform: mr(),
          zIndex: -1
        }];
      },
      percent: function percent(t, e, i) {
        return i < 0 ? 1 - pr(e) : pr(t);
      },
      translate: function translate(t, e) {
        return e < 0 ? [{
          transform: mr(30 * t),
          zIndex: -1
        }, {
          transform: mr(-100 * (1 - t)),
          zIndex: 0
        }] : [{
          transform: mr(100 * -t),
          zIndex: 0
        }, {
          transform: mr(30 * (1 - t)),
          zIndex: -1
        }];
      }
    },
    push: {
      show: function show(t) {
        return t < 0 ? [{
          transform: mr(100),
          zIndex: 0
        }, {
          transform: mr(),
          zIndex: -1
        }] : [{
          transform: mr(-30),
          zIndex: -1
        }, {
          transform: mr(),
          zIndex: 0
        }];
      },
      percent: function percent(t, e, i) {
        return 0 < i ? 1 - pr(e) : pr(t);
      },
      translate: function translate(t, e) {
        return e < 0 ? [{
          transform: mr(100 * t),
          zIndex: 0
        }, {
          transform: mr(-30 * (1 - t)),
          zIndex: -1
        }] : [{
          transform: mr(-30 * t),
          zIndex: -1
        }, {
          transform: mr(100 * (1 - t)),
          zIndex: 0
        }];
      }
    }
  }),
      Ur = {
    mixins: [Vi, xr, Mr],
    props: {
      ratio: String,
      minHeight: Boolean,
      maxHeight: Boolean
    },
    data: {
      ratio: "16:9",
      minHeight: !1,
      maxHeight: !1,
      selList: ".uk-slideshow-items",
      attrItem: "uk-slideshow-item",
      selNav: ".uk-slideshow-nav",
      Animations: qr
    },
    update: {
      read: function read() {
        var t = this.ratio.split(":").map(Number),
            e = t[0],
            i = t[1];
        return i = i * this.$el.offsetWidth / e, this.minHeight && (i = Math.max(this.minHeight, i)), this.maxHeight && (i = Math.min(this.maxHeight, i)), {
          height: i
        };
      },
      write: function write(t) {
        var e = t.height;
        Ve(this.list, Math.floor(e));
      },
      events: ["load", "resize"]
    }
  },
      Xr = {
    mixins: [Vi, or],
    props: {
      group: String,
      threshold: Number,
      clsItem: String,
      clsPlaceholder: String,
      clsDrag: String,
      clsDragState: String,
      clsBase: String,
      clsNoDrag: String,
      clsEmpty: String,
      clsCustom: String,
      handle: String
    },
    data: {
      group: !1,
      threshold: 5,
      clsItem: "uk-sortable-item",
      clsPlaceholder: "uk-sortable-placeholder",
      clsDrag: "uk-sortable-drag",
      clsDragState: "uk-drag",
      clsBase: "uk-sortable",
      clsNoDrag: "uk-sortable-nodrag",
      clsEmpty: "uk-sortable-empty",
      clsCustom: "",
      handle: !1
    },
    init: function init() {
      var o = this;
      ["init", "start", "move", "end"].forEach(function (t) {
        var r = o[t];

        o[t] = function (t) {
          o.scrollY = window.pageYOffset;
          var e = Bi(t),
              i = e.x,
              n = e.y;
          o.pos = {
            x: i,
            y: n
          }, r(t);
        };
      });
    },
    events: (Yr = {}, Yr[li] = "init", Yr),
    update: {
      write: function write() {
        if (this.clsEmpty && fe(this.$el, this.clsEmpty, !this.$el.children.length), this.drag) {
          Le(this.drag, {
            top: this.pos.y + this.origin.top,
            left: this.pos.x + this.origin.left
          });
          var t,
              e = Le(this.drag).top,
              i = e + this.drag.offsetHeight;
          0 < e && e < this.scrollY ? t = this.scrollY - 5 : i < Ve(document) && i > Ve(window) + this.scrollY && (t = this.scrollY + 5), t && setTimeout(function () {
            return Qe(window, t);
          }, 5);
        }
      }
    },
    methods: {
      init: function init(t) {
        var e = t.target,
            i = t.button,
            n = t.defaultPrevented,
            r = L(this.$el.children).filter(function (t) {
          return St(e, t);
        })[0];
        !r || $t(t.target) || this.handle && !St(e, this.handle) || 0 < i || St(e, "." + this.clsNoDrag) || n || (t.preventDefault(), this.touched = [this], this.placeholder = r, this.origin = Y({
          target: e,
          index: qt(r)
        }, this.pos), Tt(document, hi, this.move), Tt(document, ci, this.end), Tt(window, "scroll", this.scroll), this.threshold || this.start(t));
      },
      start: function start(t) {
        this.drag = Kt(this.$container, this.placeholder.outerHTML.replace(/^<li/i, "<div").replace(/li>$/i, "div>")), be(this.drag, Y({
          boxSizing: "border-box",
          width: this.placeholder.offsetWidth,
          height: this.placeholder.offsetHeight
        }, be(this.placeholder, ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom"]))), Z(this.drag, "uk-no-boot", ""), le(this.drag, this.clsDrag, this.clsCustom), Ve(this.drag.firstElementChild, Ve(this.placeholder.firstElementChild));
        var e = Le(this.placeholder),
            i = e.left,
            n = e.top;
        Y(this.origin, {
          left: i - this.pos.x,
          top: n - this.pos.y
        }), le(this.placeholder, this.clsPlaceholder), le(this.$el.children, this.clsItem), le(document.documentElement, this.clsDragState), _t(this.$el, "start", [this, this.placeholder]), this.move(t);
      },
      move: function move(t) {
        if (this.drag) {
          this.$emit();
          var e = "mousemove" === t.type ? t.target : document.elementFromPoint(this.pos.x - document.body.scrollLeft, this.pos.y - document.body.scrollTop),
              i = this.getSortable(e),
              n = this.getSortable(this.placeholder),
              r = i !== n;

          if (i && !St(e, this.placeholder) && (!r || i.group && i.group === n.group)) {
            if (e = i.$el === e.parentNode && e || L(i.$el.children).filter(function (t) {
              return St(e, t);
            })[0], r) n.remove(this.placeholder);else if (!e) return;
            i.insert(this.placeholder, e), b(this.touched, i) || this.touched.push(i);
          }
        } else (Math.abs(this.pos.x - this.origin.x) > this.threshold || Math.abs(this.pos.y - this.origin.y) > this.threshold) && this.start(t);
      },
      scroll: function scroll() {
        var t = window.pageYOffset;
        t !== this.scrollY && (this.pos.y += t - this.scrollY, this.scrollY = t, this.$emit());
      },
      end: function end(t) {
        if (Et(document, hi, this.move), Et(document, ci, this.end), Et(window, "scroll", this.scroll), this.drag) {
          Bt();
          var e = this.getSortable(this.placeholder);
          this === e ? this.origin.index !== qt(this.placeholder) && _t(this.$el, "moved", [this, this.placeholder]) : (_t(e.$el, "added", [e, this.placeholder]), _t(this.$el, "removed", [this, this.placeholder])), _t(this.$el, "stop", [this, this.placeholder]), te(this.drag), this.drag = null;
          var i = this.touched.map(function (t) {
            return t.clsPlaceholder + " " + t.clsItem;
          }).join(" ");
          this.touched.forEach(function (t) {
            return he(t.$el.children, i);
          }), he(document.documentElement, this.clsDragState);
        } else "mouseup" !== t.type && St(t.target, "a[href]") && (location.href = mt(t.target, "a[href]").href);
      },
      insert: function insert(i, n) {
        var r = this;
        le(this.$el.children, this.clsItem);

        var t = function t() {
          var t, e;
          n ? !St(i, r.$el) || (e = n, (t = i).parentNode === e.parentNode && qt(t) > qt(e)) ? Gt(n, i) : Zt(n, i) : Kt(r.$el, i);
        };

        this.animation ? this.animate(t) : t();
      },
      remove: function remove(t) {
        St(t, this.$el) && (this.animation ? this.animate(function () {
          return te(t);
        }) : te(t));
      },
      getSortable: function getSortable(t) {
        return t && (this.$getComponent(t, "sortable") || this.getSortable(t.parentNode));
      }
    }
  };
  var Jr = [],
      Kr = {
    mixins: [Hn, Yi, Zi],
    args: "title",
    attrs: !0,
    props: {
      delay: Number,
      title: String
    },
    data: {
      pos: "top",
      title: "",
      delay: 0,
      animation: ["uk-animation-scale-up"],
      duration: 100,
      cls: "uk-active",
      clsPos: "uk-tooltip"
    },
    beforeConnect: function beforeConnect() {
      this._hasTitle = Q(this.$el, "title"), Z(this.$el, {
        title: "",
        "aria-expanded": !1
      });
    },
    disconnected: function disconnected() {
      this.hide(), Z(this.$el, {
        title: this._hasTitle ? this.title : null,
        "aria-expanded": null
      });
    },
    methods: {
      show: function show() {
        var e = this;
        b(Jr, this) || (Jr.forEach(function (t) {
          return t.hide();
        }), Jr.push(this), this._unbind = Tt(document, "click", function (t) {
          return !St(t.target, e.$el) && e.hide();
        }), clearTimeout(this.showTimer), this.tooltip = Kt(this.container, '<div class="' + this.clsPos + '" aria-hidden><div class="' + this.clsPos + '-inner">' + this.title + "</div></div>"), Z(this.$el, "aria-expanded", !0), this.positionAt(this.tooltip, this.$el), this.origin = "y" === this.getAxis() ? Ke(this.dir) + "-" + this.align : this.align + "-" + Ke(this.dir), this.showTimer = setTimeout(function () {
          e.toggleElement(e.tooltip, !0), e.hideTimer = setInterval(function () {
            xt(e.$el) || e.hide();
          }, 150);
        }, this.delay));
      },
      hide: function hide() {
        var t = Jr.indexOf(this);
        !~t || ft(this.$el, "input") && this.$el === document.activeElement || (Jr.splice(t, 1), clearTimeout(this.showTimer), clearInterval(this.hideTimer), Z(this.$el, "aria-expanded", !1), this.toggleElement(this.tooltip, !1), this.tooltip && te(this.tooltip), this.tooltip = !1, this._unbind());
      }
    },
    events: (Rr = {}, Rr["focus " + ui + " " + li] = function (t) {
      t.type === li && Di(t) || this.show();
    }, Rr.blur = "hide", Rr[di] = function (t) {
      Di(t) || this.hide();
    }, Rr)
  },
      Gr = {
    props: {
      allow: String,
      clsDragover: String,
      concurrent: Number,
      maxSize: Number,
      method: String,
      mime: String,
      msgInvalidMime: String,
      msgInvalidName: String,
      msgInvalidSize: String,
      multiple: Boolean,
      name: String,
      params: Object,
      type: String,
      url: String
    },
    data: {
      allow: !1,
      clsDragover: "uk-dragover",
      concurrent: 1,
      maxSize: 0,
      method: "POST",
      mime: !1,
      msgInvalidMime: "Invalid File Type: %s",
      msgInvalidName: "Invalid File Name: %s",
      msgInvalidSize: "Invalid File Size: %s Kilobytes Max",
      multiple: !1,
      name: "files[]",
      params: {},
      type: "",
      url: "",
      abort: X,
      beforeAll: X,
      beforeSend: X,
      complete: X,
      completeAll: X,
      error: X,
      fail: X,
      load: X,
      loadEnd: X,
      loadStart: X,
      progress: X
    },
    events: {
      change: function change(t) {
        ft(t.target, 'input[type="file"]') && (t.preventDefault(), t.target.files && this.upload(t.target.files), t.target.value = "");
      },
      drop: function drop(t) {
        Qr(t);
        var e = t.dataTransfer;
        e && e.files && (he(this.$el, this.clsDragover), this.upload(e.files));
      },
      dragenter: function dragenter(t) {
        Qr(t);
      },
      dragover: function dragover(t) {
        Qr(t), le(this.$el, this.clsDragover);
      },
      dragleave: function dragleave(t) {
        Qr(t), he(this.$el, this.clsDragover);
      }
    },
    methods: {
      upload: function upload(t) {
        var n = this;

        if (t.length) {
          _t(this.$el, "upload", [t]);

          for (var e = 0; e < t.length; e++) {
            if (n.maxSize && 1e3 * n.maxSize < t[e].size) return void n.fail(n.msgInvalidSize.replace("%s", n.maxSize));
            if (n.allow && !Zr(n.allow, t[e].name)) return void n.fail(n.msgInvalidName.replace("%s", n.allow));
            if (n.mime && !Zr(n.mime, t[e].type)) return void n.fail(n.msgInvalidMime.replace("%s", n.mime));
          }

          this.multiple || (t = [t[0]]), this.beforeAll(this, t);

          var r = function (t, e) {
            for (var i = [], n = 0; n < t.length; n += e) {
              for (var r = [], o = 0; o < e; o++) {
                r.push(t[n + o]);
              }

              i.push(r);
            }

            return i;
          }(t, this.concurrent),
              o = function o(t) {
            var e = new FormData();

            for (var i in t.forEach(function (t) {
              return e.append(n.name, t);
            }), n.params) {
              e.append(i, n.params[i]);
            }

            Ft(n.url, {
              data: e,
              method: n.method,
              responseType: n.type,
              beforeSend: function beforeSend(t) {
                var e = t.xhr;
                e.upload && Tt(e.upload, "progress", n.progress), ["loadStart", "load", "loadEnd", "abort"].forEach(function (t) {
                  return Tt(e, t.toLowerCase(), n[t]);
                }), n.beforeSend(t);
              }
            }).then(function (t) {
              n.complete(t), r.length ? o(r.shift()) : n.completeAll(t);
            }, function (t) {
              return n.error(t.message);
            });
          };

          o(r.shift());
        }
      }
    }
  };

  function Zr(t, e) {
    return e.match(new RegExp("^" + t.replace(/\//g, "\\/").replace(/\*\*/g, "(\\/[^\\/]+)*").replace(/\*/g, "[^\\/]+").replace(/((?!\\))\?/g, "$1.") + "$", "i"));
  }

  function Qr(t) {
    t.preventDefault(), t.stopPropagation();
  }

  return Fi.component("countdown", ir), Fi.component("filter", hr), Fi.component("lightbox", Sr), Fi.component("lightboxPanel", kr), Fi.component("notification", Er), Fi.component("parallax", Or), Fi.component("slider", Lr), Fi.component("sliderParallax", jr), Fi.component("slideshow", Ur), Fi.component("slideshowParallax", jr), Fi.component("sortable", Xr), Fi.component("tooltip", Kr), Fi.component("upload", Gr), function (o) {
    var s = o.connect,
        a = o.disconnect;

    function t() {
      l(document.body, s), fi.flush(), new MutationObserver(function (t) {
        return t.forEach(e);
      }).observe(document, {
        childList: !0,
        subtree: !0,
        characterData: !0,
        attributes: !0
      }), o._initialized = !0;
    }

    function e(t) {
      var e = t.target;
      ("attributes" !== t.type ? function (t) {
        for (var e = t.addedNodes, i = t.removedNodes, n = 0; n < e.length; n++) {
          l(e[n], s);
        }

        for (var r = 0; r < i.length; r++) {
          l(i[r], a);
        }

        return !0;
      }(t) : function (t) {
        var e = t.target,
            i = t.attributeName;
        if ("href" === i) return !0;
        var n = Pi(i);

        if (n && n in o) {
          if (Q(e, i)) return o[n](e), !0;
          var r = o.getComponent(e, n);
          return r ? (r.$destroy(), !0) : void 0;
        }
      }(t)) && o.update(e);
    }

    function l(t, e) {
      if (1 === t.nodeType && !Q(t, "uk-no-boot")) for (e(t), t = t.firstElementChild; t;) {
        var i = t.nextElementSibling;
        l(t, e), t = i;
      }
    }

    "MutationObserver" in window && (document.body ? t() : new MutationObserver(function () {
      document.body && (this.disconnect(), t());
    }).observe(document, {
      childList: !0,
      subtree: !0
    }));
  }(Fi), Fi;
});