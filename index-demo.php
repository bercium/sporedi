<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
  <head>
    <meta charset="UTF-8">

    <meta name="description" content="Nobly is a social network to start a chain reaction of awesome deeds." />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">    
    <title></title>
    
 <style>
   

body,
html {
  color: #f4f4f4;
  width: 100%;
  height: 100%;
  font-family: 'Segoe UI', 'Open Sans', Helvetica, Arial, sans-serif;
  overflow: hidden;
  background: #0000dd;
  background-image: -webkit-gradient(radial, center center, 0, center center, 460, color-stop(0%, #99ccee), color-stop(100%, #0088bb));
  background-image: -webkit-radial-gradient(50% 0%, circle farthest-corner, #99ccee, #0088bb);
  background-image: radial-gradient(circle farthest-corner at 50% 0%, #99ccee, #0088bb);
}
body a,
html a {
  text-decoration: none;
  color: white;
  font-size: 17px;
  font-size: 1.0625rem;
  font-weight: bold;
  -moz-transition: color 0.3s ease-in;
  -o-transition: color 0.3s ease-in;
  -webkit-transition: color 0.3s ease-in;
  transition: color 0.3s ease-in;
}

#main-content {
  height: 900px;
  width: 100%;
}
   
.particle-canvas {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
  width: 100%;
  height: 100%;
  -moz-animation-duration: 3s;
  -o-animation-duration: 3s;
  -webkit-animation-duration: 3s;
  animation-duration: 3s;
}
.particle-canvas.particle-canvas--blurred {
  z-index: 0;
  filter: blur(5px);
  -webkit-filter: blur(5px);
  -moz-filter: blur(5px);
  -o-filter: blur(5px);
  -ms-filter: blur(5px);
  filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius='5');
  -moz-animation-duration: 1s;
  -o-animation-duration: 1s;
  -webkit-animation-duration: 1s;
  animation-duration: 1s;
}
.container {
  position: relative;
  z-index: 2;
  display: table;
  width: 100%;
  height: 100%;
}
@media screen and (max-width: 700px), screen and (max-height: 650px) {
  #particles-left,
  #particles-right {
    display: none;
    opacity: 0;
  }
}
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
  #particles-middle {
    opacity: .3;
  }
}


    </style>
    
  
  </head>
  <body>
    <?php
    // put your code here


$userGuid = "221ed9a4-cf28-42bb-ab6e-351128a177ef";
$apiKey = "Ak1I4IhdgcQqmAuwXlLpqV8X8QoUSpN2LAKbD17NeC8Z/98/NoCZZ71q0Cc+r3U7aYHwfVWkbse22hzuFN1/3g==";

function query($connectorGuid, $input, $userGuid, $apiKey, $additionalInput) {

  $url = "https://api.import.io/store/connector/" . $connectorGuid . "/_query?_user=" . urlencode($userGuid) . "&_apikey=" . urlencode($apiKey);

  $data = array("input" => $input);
  if ($additionalInput) {
    $data["additionalInput"] = $additionalInput;
  }

  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
  curl_setopt($ch, CURLOPT_POSTFIELDS,  json_encode($data));
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $result = curl_exec($ch);
  curl_close($ch);

  return json_decode($result);
}

// Query for tile kickstarter
$result = query("a0250b6e-f4b6-494c-8f53-01305c3e1ba8", array(
  "webpage/url" => "https://www.kickstarter.com/discover/recently-launched?page=1&state=live&ref=recently_launched",
), $userGuid, $apiKey, false);
//var_dump($result);
    
    ?>

    <div id="main-content">
    <canvas id="particles-left" class="particle-canvas animated fadeIn"></canvas>
<canvas id="particles-middle" class="particle-canvas particle-canvas--blurred"></canvas>
<canvas id="particles-right" class="particle-canvas animated fadeIn"></canvas>
    </div>
    <div class="container">
    <div class="content--centered">
        <section class="content">
            <div class="sections">
                <div id="s1-content" class="section text animated">
                    <div class="container">
                        <div class="content--centered">
                            <h1 class="section__header">What is nobly?</h1>
                            <p>
                                 Nobly is a place where people can connect with those in need, embrace their capacity for kindness, and track their altruism across timezones, cultures, and continents.  Nobly features a fun and social means for finding ways to enrich the lives of those around you.  This will be done through Random Acts of Kindness and Pay it Forward cards that can be tracked within the app.
                            </p>

                            <p class="last">
                                “I long to see a radical shift in philanthropy that will come to characterize the 21st century. That is, a reclaiming of the root meaning of philanthropy: love of what it means to be human.” 
                                <br />
                                <span class="text--right text--block">- Valaida Fullwood</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div id="s2-content" class="section active logo animated">
                    <div class="container">
                        <div class="content--centered">
                            <img id="logo" class="logo__img animated fadeInUp" src="/images/nobly-logo.png" alt="nobly logo"/>
                        </div>
                    </div>                    
                </div>

                <div id="s3-content" class="section section__change text animated">
                    <div class="container">
                        <div class="content--centered">
                            <p>
                                Start a chain reaction of awesome deeds by joining the #goNobly movement.  How can you do this?  Well, to begin we're welcoming beta-invite requests at the moment (see the input box below to request an invite).  <span class="strippable">Those in the beta will receive the first ever live Nobly experience and be afforded exclusive perks once we officially launch.</span>
                                Next, we'd love for you to follow our social outlets<span class="strippable">, where we'll be providing development details, important dates, and the comical yet pertinent musings of our content editors</span>.  You'll also find
                                us around almost every social corner of the web: <a href="https://www.facebook.com/gonobly" target="_blank">Facebook</a>, <a href="https://twitter.com/gonobly"  target="_blank">Twitter</a>, <a href="http://instagram.com/gonobly"  target="_blank">Instagram</a>, and <a href="http://dribbble.com/gamifydesigns"  target="_blank">Dribbble</a>.  Join us now to be a part of the #goNobly movement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="content__text animated fadeInUp">
                <span id="s1">What is nobly?</span>
                <span id="s2" class="square-divider"></span>
                <span id="s3">Be the change</span>
            </div>

            <div class="user__actions">
                <div id="form-wrap" class="animated fadeInUp form__wrap">
                    <form id="nobly-form">
                        <div class="grid grid--full">
                            <div class="grid__item three-quarters palm-one-whole">
                                <input id="input__email" type="email" class="text-input form__input" required="required" placeholder="Your email">
                                <div class="field__faux"><input type="text" name="b_c211b52e5164c16e47ce86721_99498beaab" value=""></div>
                            </div><!--

                         --><div class="grid__item one-quarter palm-one-whole">
                                <button id="input__submit" class="form__button progress-button"><span class="button__content animated">GET INVITE</span></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="social-outlets" class="social-outlets">
                    <div>
                        <ul class="nav">
                            <li><a href="https://twitter.com/gonobly"><i class="icon icon-twitter"></i></a></li>
                            <li><a href="https://www.facebook.com/gonobly"><i class="icon icon-facebook-squared"></i></a></li>
                            <li><a href="https://plus.google.com/u/0/b/116219578755319130078/116219578755319130078/about"><i class="icon icon-gplus"></i></a></li>                                                                       
                        </ul>
                    </div>
                    <div class="notes">CONNECT WITH US</div>
                </div>
            </div>
        </section>
    </div>
</div>

    </div>

    <footer class="footer text--center">
        © 2014 NOBLY. ALL RIGHTS RESERVED. <span class="spacer">|</span>  
        <ul class="nav">
            <li><a href="https://twitter.com/gonobly" target="_blank"><i class="icon icon-twitter"></i></a></li>
            <li><a href="https://www.facebook.com/gonobly" target="_blank"><i class="icon icon-facebook-squared"></i></a></li>
            <li><a href="https://plus.google.com/u/0/b/116219578755319130078/116219578755319130078/about" target="_blank"><i class="icon icon-gplus"></i></a></li>                                                      
        </ul>
    </footer>

    <div id="overlays" class="overlay"></div>
    <div id="alerts" class="rounded"></div>
    <script>
      var gdx;
      (function (n, t) {
          function yu(n) {
              var t = wt[n] = {};
              return i.each(n.split(h), function (n, i) {
                  t[i] = !0
              }), t
          }

          function ui(n, r, u) {
              if (u === t && n.nodeType === 1) {
                  var f = "data-" + r.replace(sr, "-$1").toLowerCase();
                  if (u = n.getAttribute(f), typeof u == "string") {
                      try {
                          u = u === "true" ? !0 : u === "false" ? !1 : u === "null" ? null : +u + "" === u ? +u : or.test(u) ? i.parseJSON(u) : u
                      } catch (e) {}
                      i.data(n, r, u)
                  } else u = t
              }
              return u
          }

          function at(n) {
              var t;
              for (t in n)
                  if ((t !== "data" || !i.isEmptyObject(n[t])) && t !== "toJSON") return !1;
              return !0
          }

          function a() {
              return !1
          }

          function d() {
              return !0
          }

          function b(n) {
              return !n || !n.parentNode || n.parentNode.nodeType === 11
          }

          function fi(n, t) {
              do n = n[t]; while (n && n.nodeType !== 1);
              return n
          }

          function ei(n, t, r) {
              if (t = t || 0, i.isFunction(t)) return i.grep(n, function (n, i) {
                  var u = !!t.call(n, i, n);
                  return u === r
              });
              if (t.nodeType) return i.grep(n, function (n) {
                  return n === t === r
              });
              if (typeof t == "string") {
                  var u = i.grep(n, function (n) {
                      return n.nodeType === 1
                  });
                  if (fe.test(t)) return i.filter(t, u, !r);
                  t = i.filter(t, u)
              }
              return i.grep(n, function (n) {
                  return i.inArray(n, t) >= 0 === r
              })
          }

          function oi(n) {
              var i = kr.split("|"),
                  t = n.createDocumentFragment();
              if (t.createElement)
                  while (i.length) t.createElement(i.pop());
              return t
          }

          function pu(n, t) {
              return n.getElementsByTagName(t)[0] || n.appendChild(n.ownerDocument.createElement(t))
          }

          function si(n, t) {
              if (t.nodeType === 1 && i.hasData(n)) {
                  var u, f, o, s = i._data(n),
                      r = i._data(t, s),
                      e = s.events;
                  if (e) {
                      delete r.handle, r.events = {};
                      for (u in e)
                          for (f = 0, o = e[u].length; f < o; f++) i.event.add(t, u, e[u][f])
                  }
                  r.data && (r.data = i.extend({}, r.data))
              }
          }

          function hi(n, t) {
              var r;
              t.nodeType === 1 && (t.clearAttributes && t.clearAttributes(), t.mergeAttributes && t.mergeAttributes(n), r = t.nodeName.toLowerCase(), r === "object" ? (t.parentNode && (t.outerHTML = n.outerHTML), i.support.html5Clone && n.innerHTML && !i.trim(t.innerHTML) && (t.innerHTML = n.innerHTML)) : r === "input" && nu.test(n.type) ? (t.defaultChecked = t.checked = n.checked, t.value !== n.value && (t.value = n.value)) : r === "option" ? t.selected = n.defaultSelected : r === "input" || r === "textarea" ? t.defaultValue = n.defaultValue : r === "script" && t.text !== n.text && (t.text = n.text), t.removeAttribute(i.expando))
          }

          function g(n) {
              return typeof n.getElementsByTagName != "undefined" ? n.getElementsByTagName("*") : typeof n.querySelectorAll != "undefined" ? n.querySelectorAll("*") : []
          }

          function ci(n) {
              nu.test(n.type) && (n.defaultChecked = n.checked)
          }

          function li(n, t) {
              if (t in n) return t;
              for (var r = t.charAt(0).toUpperCase() + t.slice(1), u = t, i = fu.length; i--;)
                  if (t = fu[i] + r, t in n) return t;
              return u
          }

          function nt(n, t) {
              return n = t || n, i.css(n, "display") === "none" || !i.contains(n.ownerDocument, n)
          }

          function ai(n, t) {
              for (var r, o, e = [], f = 0, s = n.length; f < s; f++)(r = n[f], r.style) && (e[f] = i._data(r, "olddisplay"), t ? (!e[f] && r.style.display === "none" && (r.style.display = ""), r.style.display === "" && nt(r) && (e[f] = i._data(r, "olddisplay", wi(r.nodeName)))) : (o = u(r, "display"), !e[f] && o !== "none" && i._data(r, "olddisplay", o)));
              for (f = 0; f < s; f++)(r = n[f], r.style) && (t && r.style.display !== "none" && r.style.display !== "" || (r.style.display = t ? e[f] || "" : "none"));
              return n
          }

          function vi(n, t, i) {
              var r = be.exec(t);
              return r ? Math.max(0, r[1] - (i || 0)) + (r[2] || "px") : t
          }

          function yi(n, t, r, f) {
              for (var e = r === (f ? "border" : "content") ? 4 : t === "width" ? 1 : 0, o = 0; e < 4; e += 2) r === "margin" && (o += i.css(n, r + c[e], !0)), f ? (r === "content" && (o -= parseFloat(u(n, "padding" + c[e])) || 0), r !== "margin" && (o -= parseFloat(u(n, "border" + c[e] + "Width")) || 0)) : (o += parseFloat(u(n, "padding" + c[e])) || 0, r !== "padding" && (o += parseFloat(u(n, "border" + c[e] + "Width")) || 0));
              return o
          }

          function pi(n, t, r) {
              var f = t === "width" ? n.offsetWidth : n.offsetHeight,
                  e = !0,
                  o = i.support.boxSizing && i.css(n, "boxSizing") === "border-box";
              if (f <= 0 || f == null) {
                  if (f = u(n, t), (f < 0 || f == null) && (f = n.style[t]), et.test(f)) return f;
                  e = o && (i.support.boxSizingReliable || f === n.style[t]), f = parseFloat(f) || 0
              }
              return f + yi(n, t, r || (o ? "border" : "content"), e) + "px"
          }

          function wi(n) {
              if (ti[n]) return ti[n];
              var f = i("<" + n + ">").appendTo(r.body),
                  t = f.css("display");
              return f.remove(), (t === "none" || t === "") && (v = r.body.appendChild(v || i.extend(r.createElement("iframe"), {
                  frameBorder: 0,
                  width: 0,
                  height: 0
              })), y && v.createElement || (y = (v.contentWindow || v.contentDocument).document, y.write("<!doctype html><html><body>"), y.close()), f = y.body.appendChild(y.createElement(n)), t = u(f, "display"), r.body.removeChild(v)), ti[n] = t, t
          }

          function vt(n, t, r, u) {
              var f;
              if (i.isArray(t)) i.each(t, function (t, i) {
                  r || to.test(n) ? u(n, i) : vt(n + "[" + (typeof i == "object" ? t : "") + "]", i, r, u)
              });
              else if (r || i.type(t) !== "object") u(n, t);
              else
                  for (f in t) vt(n + "[" + f + "]", t[f], r, u)
          }

          function bi(n) {
              return function (t, r) {
                  typeof t != "string" && (r = t, t = "*");
                  var u, o, f, s = t.toLowerCase().split(h),
                      e = 0,
                      c = s.length;
                  if (i.isFunction(r))
                      for (; e < c; e++) u = s[e], f = /^\+/.test(u), f && (u = u.substr(1) || "*"), o = n[u] = n[u] || [], o[f ? "unshift" : "push"](r)
              }
          }

          function tt(n, i, r, u, f, e) {
              f = f || i.dataTypes[0], e = e || {}, e[f] = !0;
              for (var o, s = n[f], h = 0, l = s ? s.length : 0, c = n === ii; h < l && (c || !o); h++) o = s[h](i, r, u), typeof o == "string" && (!c || e[o] ? o = t : (i.dataTypes.unshift(o), o = tt(n, i, r, u, o, e)));
              return (c || !o) && !e["*"] && (o = tt(n, i, r, u, "*", e)), o
          }

          function ki(n, r) {
              var u, f, e = i.ajaxSettings.flatOptions || {};
              for (u in r) r[u] !== t && ((e[u] ? n : f || (f = {}))[u] = r[u]);
              f && i.extend(!0, n, f)
          }

          function wu(n, i, r) {
              var o, u, e, s, h = n.contents,
                  f = n.dataTypes,
                  c = n.responseFields;
              for (u in c) u in r && (i[c[u]] = r[u]);
              while (f[0] === "*") f.shift(), o === t && (o = n.mimeType || i.getResponseHeader("content-type"));
              if (o)
                  for (u in h)
                      if (h[u] && h[u].test(o)) {
                          f.unshift(u);
                          break
                      }
              if (f[0] in r) e = f[0];
              else {
                  for (u in r) {
                      if (!f[0] || n.converters[u + " " + f[0]]) {
                          e = u;
                          break
                      }
                      s || (s = u)
                  }
                  e = e || s
              } if (e) return e !== f[0] && f.unshift(e), r[e]
          }

          function bu(n, t) {
              var i, o, r, e, s = n.dataTypes.slice(),
                  f = s[0],
                  u = {},
                  h = 0;
              if (n.dataFilter && (t = n.dataFilter(t, n.dataType)), s[1])
                  for (i in n.converters) u[i.toLowerCase()] = n.converters[i];
              for (; r = s[++h];)
                  if (r !== "*") {
                      if (f !== "*" && f !== r) {
                          if (i = u[f + " " + r] || u["* " + r], !i)
                              for (o in u)
                                  if (e = o.split(" "), e[1] === r && (i = u[f + " " + e[0]] || u["* " + e[0]], i)) {
                                      i === !0 ? i = u[o] : u[o] !== !0 && (r = e[0], s.splice(h--, 0, r));
                                      break
                                  }
                          if (i !== !0)
                              if (i && n.throws) t = i(t);
                              else try {
                                  t = i(t)
                              } catch (c) {
                                  return {
                                      state: "parsererror",
                                      error: i ? c : "No conversion from " + f + " to " + r
                                  }
                              }
                      }
                      f = r
                  }
              return {
                  state: "success",
                  data: t
              }
          }

          function di() {
              try {
                  return new n.XMLHttpRequest
              } catch (t) {}
          }

          function ku() {
              try {
                  return new n.ActiveXObject("Microsoft.XMLHTTP")
              } catch (t) {}
          }

          function gi() {
              return setTimeout(function () {
                  ht = t
              }, 0), ht = i.now()
          }

          function du(n, t) {
              i.each(t, function (t, i) {
                  for (var u = (k[t] || []).concat(k["*"]), r = 0, f = u.length; r < f; r++)
                      if (u[r].call(n, t, i)) return
              })
          }

          function nr(n, t, r) {
              var e, o = 0,
                  l = 0,
                  c = lt.length,
                  f = i.Deferred().always(function () {
                      delete h.elem
                  }),
                  h = function () {
                      for (var o = ht || gi(), t = Math.max(0, u.startTime + u.duration - o), i = 1 - (t / u.duration || 0), r = 0, e = u.tweens.length; r < e; r++) u.tweens[r].run(i);
                      return f.notifyWith(n, [u, i, t]), i < 1 && e ? t : (f.resolveWith(n, [u]), !1)
                  },
                  u = f.promise({
                      elem: n,
                      props: i.extend({}, t),
                      opts: i.extend(!0, {
                          specialEasing: {}
                      }, r),
                      originalProperties: t,
                      originalOptions: r,
                      startTime: ht || gi(),
                      duration: r.duration,
                      tweens: [],
                      createTween: function (t, r) {
                          var e = i.Tween(n, u.opts, t, r, u.opts.specialEasing[t] || u.opts.easing);
                          return u.tweens.push(e), e
                      },
                      stop: function (t) {
                          for (var i = 0, r = t ? u.tweens.length : 0; i < r; i++) u.tweens[i].run(1);
                          return t ? f.resolveWith(n, [u, t]) : f.rejectWith(n, [u, t]), this
                      }
                  }),
                  s = u.props;
              for (gu(s, u.opts.specialEasing); o < c; o++)
                  if (e = lt[o].call(u, n, s, u.opts), e) return e;
              return du(u, s), i.isFunction(u.opts.start) && u.opts.start.call(n, u), i.fx.timer(i.extend(h, {
                  anim: u,
                  queue: u.opts.queue,
                  elem: n
              })), u.progress(u.opts.progress).done(u.opts.done, u.opts.complete).fail(u.opts.fail).always(u.opts.always)
          }

          function gu(n, t) {
              var r, f, e, u, o;
              for (r in n)
                  if (f = i.camelCase(r), e = t[f], u = n[r], i.isArray(u) && (e = u[1], u = n[r] = u[0]), r !== f && (n[f] = u, delete n[r]), o = i.cssHooks[f], o && "expand" in o) {
                      u = o.expand(u), delete n[f];
                      for (r in u) r in n || (n[r] = u[r], t[r] = e)
                  } else t[f] = e
          }

          function nf(n, t, r) {
              var o, u, a, v, h, c, f, w, s = this,
                  e = n.style,
                  y = {},
                  p = [],
                  l = n.nodeType && nt(n);
              r.queue || (f = i._queueHooks(n, "fx"), f.unqueued == null && (f.unqueued = 0, w = f.empty.fire, f.empty.fire = function () {
                  f.unqueued || w()
              }), f.unqueued++, s.always(function () {
                  s.always(function () {
                      f.unqueued--, i.queue(n, "fx").length || f.empty.fire()
                  })
              })), n.nodeType === 1 && ("height" in t || "width" in t) && (r.overflow = [e.overflow, e.overflowX, e.overflowY], i.css(n, "display") === "inline" && i.css(n, "float") === "none" && (!i.support.inlineBlockNeedsLayout || wi(n.nodeName) === "inline" ? e.display = "inline-block" : e.zoom = 1)), r.overflow && (e.overflow = "hidden", i.support.shrinkWrapBlocks || s.done(function () {
                  e.overflow = r.overflow[0], e.overflowX = r.overflow[1], e.overflowY = r.overflow[2]
              }));
              for (o in t)
                  if (a = t[o], vo.exec(a)) {
                      if (delete t[o], a === (l ? "hide" : "show")) continue;
                      p.push(o)
                  }
              if (v = p.length, v)
                  for (h = i._data(n, "fxshow") || i._data(n, "fxshow", {}), l ? i(n).show() : s.done(function () {
                      i(n).hide()
                  }), s.done(function () {
                      var t;
                      i.removeData(n, "fxshow", !0);
                      for (t in y) i.style(n, t, y[t])
                  }), o = 0; o < v; o++) u = p[o], c = s.createTween(u, l ? h[u] : 0), y[u] = h[u] || i.style(n, u), u in h || (h[u] = c.start, l && (c.end = c.start, c.start = u === "width" || u === "height" ? 1 : 0))
          }

          function f(n, t, i, r, u) {
              return new f.prototype.init(n, t, i, r, u)
          }

          function it(n, t) {
              var r, i = {
                      height: n
                  },
                  u = 0;
              for (t = t ? 1 : 0; u < 4; u += 2 - t) r = c[u], i["margin" + r] = i["padding" + r] = n;
              return t && (i.opacity = i.width = n), i
          }

          function tr(n) {
              return i.isWindow(n) ? n : n.nodeType === 9 ? n.defaultView || n.parentWindow : !1
          }
          var ir, rt, r = n.document,
              tf = n.location,
              rf = n.navigator,
              uf = n.jQuery,
              ff = n.$,
              rr = Array.prototype.push,
              o = Array.prototype.slice,
              ur = Array.prototype.indexOf,
              ef = Object.prototype.toString,
              yt = Object.prototype.hasOwnProperty,
              pt = String.prototype.trim,
              i = function (n, t) {
                  return new i.fn.init(n, t, ir)
              },
              ut = /[\-+]?(?:\d*\.|)\d+(?:[eE][\-+]?\d+|)/.source,
              of = /\S/,
              h = /\s+/,
              sf = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,
              hf = /^(?:[^#<]*(<[\w\W]+>)[^>]*$|#([\w\-]*)$)/,
              fr = /^<(\w+)\s*\/?>(?:<\/\1>|)$/,
              cf = /^[\],:{}\s]*$/,
              lf = /(?:^|:|,)(?:\s*\[)+/g,
              af = /\\(?:["\\\/bfnrt]|u[\da-fA-F]{4})/g,
              vf = /"[^"\\\r\n]*"|true|false|null|-?(?:\d\d*\.|)\d+(?:[eE][\-+]?\d+|)/g,
              yf = /^-ms-/,
              pf = /-([\da-z])/gi,
              wf = function (n, t) {
                  return (t + "").toUpperCase()
              },
              ft = function () {
                  r.addEventListener ? (r.removeEventListener("DOMContentLoaded", ft, !1), i.ready()) : r.readyState === "complete" && (r.detachEvent("onreadystatechange", ft), i.ready())
              },
              er = {},
              wt, or, sr, w, st, vu, ri;
          i.fn = i.prototype = {
              constructor: i,
              init: function (n, u, f) {
                  var e, o, h, s;
                  if (!n) return this;
                  if (n.nodeType) return this.context = this[0] = n, this.length = 1, this;
                  if (typeof n == "string") {
                      if (e = n.charAt(0) === "<" && n.charAt(n.length - 1) === ">" && n.length >= 3 ? [null, n, null] : hf.exec(n), e && (e[1] || !u)) {
                          if (e[1]) return u = u instanceof i ? u[0] : u, s = u && u.nodeType ? u.ownerDocument || u : r, n = i.parseHTML(e[1], s, !0), fr.test(e[1]) && i.isPlainObject(u) && this.attr.call(n, u, !0), i.merge(this, n);
                          if (o = r.getElementById(e[2]), o && o.parentNode) {
                              if (o.id !== e[2]) return f.find(n);
                              this.length = 1, this[0] = o
                          }
                          return this.context = r, this.selector = n, this
                      }
                      return !u || u.jquery ? (u || f).find(n) : this.constructor(u).find(n)
                  }
                  return i.isFunction(n) ? f.ready(n) : (n.selector !== t && (this.selector = n.selector, this.context = n.context), i.makeArray(n, this))
              },
              selector: "",
              jquery: "1.8.2",
              length: 0,
              size: function () {
                  return this.length
              },
              toArray: function () {
                  return o.call(this)
              },
              get: function (n) {
                  return n == null ? this.toArray() : n < 0 ? this[this.length + n] : this[n]
              },
              pushStack: function (n, t, r) {
                  var u = i.merge(this.constructor(), n);
                  return u.prevObject = this, u.context = this.context, t === "find" ? u.selector = this.selector + (this.selector ? " " : "") + r : t && (u.selector = this.selector + "." + t + "(" + r + ")"), u
              },
              each: function (n, t) {
                  return i.each(this, n, t)
              },
              ready: function (n) {
                  return i.ready.promise().done(n), this
              },
              eq: function (n) {
                  return n = +n, n === -1 ? this.slice(n) : this.slice(n, n + 1)
              },
              first: function () {
                  return this.eq(0)
              },
              last: function () {
                  return this.eq(-1)
              },
              slice: function () {
                  return this.pushStack(o.apply(this, arguments), "slice", o.call(arguments).join(","))
              },
              map: function (n) {
                  return this.pushStack(i.map(this, function (t, i) {
                      return n.call(t, i, t)
                  }))
              },
              end: function () {
                  return this.prevObject || this.constructor(null)
              },
              push: rr,
              sort: [].sort,
              splice: [].splice
          }, i.fn.init.prototype = i.fn, i.extend = i.fn.extend = function () {
              var o, e, u, r, s, h, n = arguments[0] || {},
                  f = 1,
                  l = arguments.length,
                  c = !1;
              for (typeof n == "boolean" && (c = n, n = arguments[1] || {}, f = 2), typeof n != "object" && !i.isFunction(n) && (n = {}), l === f && (n = this, --f); f < l; f++)
                  if ((o = arguments[f]) != null)
                      for (e in o)(u = n[e], r = o[e], n !== r) && (c && r && (i.isPlainObject(r) || (s = i.isArray(r))) ? (s ? (s = !1, h = u && i.isArray(u) ? u : []) : h = u && i.isPlainObject(u) ? u : {}, n[e] = i.extend(c, h, r)) : r !== t && (n[e] = r));
              return n
          }, i.extend({
              noConflict: function (t) {
                  return n.$ === i && (n.$ = ff), t && n.jQuery === i && (n.jQuery = uf), i
              },
              isReady: !1,
              readyWait: 1,
              holdReady: function (n) {
                  n ? i.readyWait++ : i.ready(!0)
              },
              ready: function (n) {
                  if (n === !0 ? !--i.readyWait : !i.isReady) {
                      if (!r.body) return setTimeout(i.ready, 1);
                      (i.isReady = !0, n !== !0 && --i.readyWait > 0) || (rt.resolveWith(r, [i]), i.fn.trigger && i(r).trigger("ready").off("ready"))
                  }
              },
              isFunction: function (n) {
                  return i.type(n) === "function"
              },
              isArray: Array.isArray || function (n) {
                  return i.type(n) === "array"
              },
              isWindow: function (n) {
                  return n != null && n == n.window
              },
              isNumeric: function (n) {
                  return !isNaN(parseFloat(n)) && isFinite(n)
              },
              type: function (n) {
                  return n == null ? String(n) : er[ef.call(n)] || "object"
              },
              isPlainObject: function (n) {
                  if (!n || i.type(n) !== "object" || n.nodeType || i.isWindow(n)) return !1;
                  try {
                      if (n.constructor && !yt.call(n, "constructor") && !yt.call(n.constructor.prototype, "isPrototypeOf")) return !1
                  } catch (u) {
                      return !1
                  }
                  var r;
                  for (r in n);
                  return r === t || yt.call(n, r)
              },
              isEmptyObject: function (n) {
                  var t;
                  for (t in n) return !1;
                  return !0
              },
              error: function (n) {
                  throw new Error(n);
              },
              parseHTML: function (n, t, u) {
                  var f;
                  return !n || typeof n != "string" ? null : (typeof t == "boolean" && (u = t, t = 0), t = t || r, (f = fr.exec(n)) ? [t.createElement(f[1])] : (f = i.buildFragment([n], t, u ? null : []), i.merge([], (f.cacheable ? i.clone(f.fragment) : f.fragment).childNodes)))
              },
              parseJSON: function (t) {
                  if (!t || typeof t != "string") return null;
                  if (t = i.trim(t), n.JSON && n.JSON.parse) return n.JSON.parse(t);
                  if (cf.test(t.replace(af, "@").replace(vf, "]").replace(lf, ""))) return new Function("return " + t)();
                  i.error("Invalid JSON: " + t)
              },
              parseXML: function (r) {
                  var u, f;
                  if (!r || typeof r != "string") return null;
                  try {
                      n.DOMParser ? (f = new DOMParser, u = f.parseFromString(r, "text/xml")) : (u = new ActiveXObject("Microsoft.XMLDOM"), u.async = "false", u.loadXML(r))
                  } catch (e) {
                      u = t
                  }
                  return (!u || !u.documentElement || u.getElementsByTagName("parsererror").length) && i.error("Invalid XML: " + r), u
              },
              noop: function () {},
              globalEval: function (t) {
                  t && of.test(t) && (n.execScript || function (t) {
                      n.eval.call(n, t)
                  })(t)
              },
              camelCase: function (n) {
                  return n.replace(yf, "ms-").replace(pf, wf)
              },
              nodeName: function (n, t) {
                  return n.nodeName && n.nodeName.toLowerCase() === t.toLowerCase()
              },
              each: function (n, r, u) {
                  var f, e = 0,
                      o = n.length,
                      s = o === t || i.isFunction(n);
                  if (u) {
                      if (s) {
                          for (f in n)
                              if (r.apply(n[f], u) === !1) break
                      } else
                          for (; e < o;)
                              if (r.apply(n[e++], u) === !1) break
                  } else if (s) {
                      for (f in n)
                          if (r.call(n[f], f, n[f]) === !1) break
                  } else
                      for (; e < o;)
                          if (r.call(n[e], e, n[e++]) === !1) break; return n
              },
              trim: pt && !pt.call("﻿ ") ? function (n) {
                  return n == null ? "" : pt.call(n)
              } : function (n) {
                  return n == null ? "" : (n + "").replace(sf, "")
              },
              makeArray: function (n, t) {
                  var r, u = t || [];
                  return n != null && (r = i.type(n), n.length == null || r === "string" || r === "function" || r === "regexp" || i.isWindow(n) ? rr.call(u, n) : i.merge(u, n)), u
              },
              inArray: function (n, t, i) {
                  var r;
                  if (t) {
                      if (ur) return ur.call(t, n, i);
                      for (r = t.length, i = i ? i < 0 ? Math.max(0, r + i) : i : 0; i < r; i++)
                          if (i in t && t[i] === n) return i
                  }
                  return -1
              },
              merge: function (n, i) {
                  var f = i.length,
                      u = n.length,
                      r = 0;
                  if (typeof f == "number")
                      for (; r < f; r++) n[u++] = i[r];
                  else
                      while (i[r] !== t) n[u++] = i[r++];
                  return n.length = u, n
              },
              grep: function (n, t, i) {
                  var u, f = [],
                      r = 0,
                      e = n.length;
                  for (i = !!i; r < e; r++) u = !!t(n[r], r), i !== u && f.push(n[r]);
                  return f
              },
              map: function (n, r, u) {
                  var f, h, e = [],
                      s = 0,
                      o = n.length,
                      c = n instanceof i || o !== t && typeof o == "number" && (o > 0 && n[0] && n[o - 1] || o === 0 || i.isArray(n));
                  if (c)
                      for (; s < o; s++) f = r(n[s], s, u), f != null && (e[e.length] = f);
                  else
                      for (h in n) f = r(n[h], h, u), f != null && (e[e.length] = f);
                  return e.concat.apply([], e)
              },
              guid: 1,
              proxy: function (n, r) {
                  var f, e, u;
                  return typeof r == "string" && (f = n[r], r = n, n = f), i.isFunction(n) ? (e = o.call(arguments, 2), u = function () {
                      return n.apply(r, e.concat(o.call(arguments)))
                  }, u.guid = n.guid = n.guid || i.guid++, u) : t
              },
              access: function (n, r, u, f, e, o, s) {
                  var c, l = u == null,
                      h = 0,
                      a = n.length;
                  if (u && typeof u == "object") {
                      for (h in u) i.access(n, r, h, u[h], 1, o, f);
                      e = 1
                  } else if (f !== t) {
                      if (c = s === t && i.isFunction(f), l && (c ? (c = r, r = function (n, t, r) {
                          return c.call(i(n), r)
                      }) : (r.call(n, f), r = null)), r)
                          for (; h < a; h++) r(n[h], u, c ? f.call(n[h], h, r(n[h], u)) : f, s);
                      e = 1
                  }
                  return e ? n : l ? r.call(n) : a ? r(n[0], u) : o
              },
              now: function () {
                  return +new Date
              }
          }), i.ready.promise = function (t) {
              if (!rt)
                  if (rt = i.Deferred(), r.readyState === "complete") setTimeout(i.ready, 1);
                  else if (r.addEventListener) r.addEventListener("DOMContentLoaded", ft, !1), n.addEventListener("load", i.ready, !1);
              else {
                  r.attachEvent("onreadystatechange", ft), n.attachEvent("onload", i.ready);
                  var u = !1;
                  try {
                      u = n.frameElement == null && r.documentElement
                  } catch (e) {}
                  u && u.doScroll && function f() {
                      if (!i.isReady) {
                          try {
                              u.doScroll("left")
                          } catch (n) {
                              return setTimeout(f, 50)
                          }
                          i.ready()
                      }
                  }()
              }
              return rt.promise(t)
          }, i.each("Boolean Number String Function Array Date RegExp Object".split(" "), function (n, t) {
              er["[object " + t + "]"] = t.toLowerCase()
          }), ir = i(r), wt = {}, i.Callbacks = function (n) {
              n = typeof n == "string" ? wt[n] || yu(n) : i.extend({}, n);
              var f, c, o, l, s, e, r = [],
                  u = !n.once && [],
                  a = function (t) {
                      for (f = n.memory && t, c = !0, e = l || 0, l = 0, s = r.length, o = !0; r && e < s; e++)
                          if (r[e].apply(t[0], t[1]) === !1 && n.stopOnFalse) {
                              f = !1;
                              break
                          }
                      o = !1, r && (u ? u.length && a(u.shift()) : f ? r = [] : h.disable())
                  },
                  h = {
                      add: function () {
                          if (r) {
                              var t = r.length;
                              (function u(t) {
                                  i.each(t, function (t, f) {
                                      var e = i.type(f);
                                      e === "function" && (!n.unique || !h.has(f)) ? r.push(f) : f && f.length && e !== "string" && u(f)
                                  })
                              })(arguments), o ? s = r.length : f && (l = t, a(f))
                          }
                          return this
                      },
                      remove: function () {
                          return r && i.each(arguments, function (n, t) {
                              for (var u;
                                  (u = i.inArray(t, r, u)) > -1;) r.splice(u, 1), o && (u <= s && s--, u <= e && e--)
                          }), this
                      },
                      has: function (n) {
                          return i.inArray(n, r) > -1
                      },
                      empty: function () {
                          return r = [], this
                      },
                      disable: function () {
                          return r = u = f = t, this
                      },
                      disabled: function () {
                          return !r
                      },
                      lock: function () {
                          return u = t, f || h.disable(), this
                      },
                      locked: function () {
                          return !u
                      },
                      fireWith: function (n, t) {
                          return t = t || [], t = [n, t.slice ? t.slice() : t], r && (!c || u) && (o ? u.push(t) : a(t)), this
                      },
                      fire: function () {
                          return h.fireWith(this, arguments), this
                      },
                      fired: function () {
                          return !!c
                      }
                  };
              return h
          }, i.extend({
              Deferred: function (n) {
                  var u = [
                          ["resolve", "done", i.Callbacks("once memory"), "resolved"],
                          ["reject", "fail", i.Callbacks("once memory"), "rejected"],
                          ["notify", "progress", i.Callbacks("memory")]
                      ],
                      f = "pending",
                      r = {
                          state: function () {
                              return f
                          },
                          always: function () {
                              return t.done(arguments).fail(arguments), this
                          },
                          then: function () {
                              var n = arguments;
                              return i.Deferred(function (r) {
                                  i.each(u, function (u, f) {
                                      var e = f[0],
                                          o = n[u];
                                      t[f[1]](i.isFunction(o) ? function () {
                                          var n = o.apply(this, arguments);
                                          n && i.isFunction(n.promise) ? n.promise().done(r.resolve).fail(r.reject).progress(r.notify) : r[e + "With"](this === t ? r : this, [n])
                                      } : r[e])
                                  }), n = null
                              }).promise()
                          },
                          promise: function (n) {
                              return n != null ? i.extend(n, r) : r
                          }
                      },
                      t = {};
                  return r.pipe = r.then, i.each(u, function (n, i) {
                      var e = i[2],
                          o = i[3];
                      r[i[1]] = e.add, o && e.add(function () {
                          f = o
                      }, u[n ^ 1][2].disable, u[2][2].lock), t[i[0]] = e.fire, t[i[0] + "With"] = e.fireWith
                  }), r.promise(t), n && n.call(t, t), t
              },
              when: function (n) {
                  var t = 0,
                      u = o.call(arguments),
                      r = u.length,
                      e = r !== 1 || n && i.isFunction(n.promise) ? r : 0,
                      f = e === 1 ? n : i.Deferred(),
                      c = function (n, t, i) {
                          return function (r) {
                              t[n] = this, i[n] = arguments.length > 1 ? o.call(arguments) : r, i === s ? f.notifyWith(t, i) : --e || f.resolveWith(t, i)
                          }
                      },
                      s, l, h;
                  if (r > 1)
                      for (s = new Array(r), l = new Array(r), h = new Array(r); t < r; t++) u[t] && i.isFunction(u[t].promise) ? u[t].promise().done(c(t, h, u)).fail(f.reject).progress(c(t, l, s)) : --e;
                  return e || f.resolveWith(h, u), f.promise()
              }
          }), i.support = function () {
              var u, h, e, c, l, f, o, a, v, s, y, t = r.createElement("div");
              if (t.setAttribute("className", "t"), t.innerHTML = "  <link/><table><\/table><a href='/a'>a<\/a><input type='checkbox'/>", h = t.getElementsByTagName("*"), e = t.getElementsByTagName("a")[0], e.style.cssText = "top:1px;float:left;opacity:.5", !h || !h.length) return {};
              c = r.createElement("select"), l = c.appendChild(r.createElement("option")), f = t.getElementsByTagName("input")[0], u = {
                  leadingWhitespace: t.firstChild.nodeType === 3,
                  tbody: !t.getElementsByTagName("tbody").length,
                  htmlSerialize: !!t.getElementsByTagName("link").length,
                  style: /top/.test(e.getAttribute("style")),
                  hrefNormalized: e.getAttribute("href") === "/a",
                  opacity: /^0.5/.test(e.style.opacity),
                  cssFloat: !!e.style.cssFloat,
                  checkOn: f.value === "on",
                  optSelected: l.selected,
                  getSetAttribute: t.className !== "t",
                  enctype: !!r.createElement("form").enctype,
                  html5Clone: r.createElement("nav").cloneNode(!0).outerHTML !== "<:nav><\/:nav>",
                  boxModel: r.compatMode === "CSS1Compat",
                  submitBubbles: !0,
                  changeBubbles: !0,
                  focusinBubbles: !1,
                  deleteExpando: !0,
                  noCloneEvent: !0,
                  inlineBlockNeedsLayout: !1,
                  shrinkWrapBlocks: !1,
                  reliableMarginRight: !0,
                  boxSizingReliable: !0,
                  pixelPosition: !1
              }, f.checked = !0, u.noCloneChecked = f.cloneNode(!0).checked, c.disabled = !0, u.optDisabled = !l.disabled;
              try {
                  delete t.test
              } catch (p) {
                  u.deleteExpando = !1
              }
              if (!t.addEventListener && t.attachEvent && t.fireEvent && (t.attachEvent("onclick", y = function () {
                  u.noCloneEvent = !1
              }), t.cloneNode(!0).fireEvent("onclick"), t.detachEvent("onclick", y)), f = r.createElement("input"), f.value = "t", f.setAttribute("type", "radio"), u.radioValue = f.value === "t", f.setAttribute("checked", "checked"), f.setAttribute("name", "t"), t.appendChild(f), o = r.createDocumentFragment(), o.appendChild(t.lastChild), u.checkClone = o.cloneNode(!0).cloneNode(!0).lastChild.checked, u.appendChecked = f.checked, o.removeChild(f), o.appendChild(t), t.attachEvent)
                  for (v in {
                      submit: !0,
                      change: !0,
                      focusin: !0
                  }) a = "on" + v, s = a in t, s || (t.setAttribute(a, "return;"), s = typeof t[a] == "function"), u[v + "Bubbles"] = s;
              return i(function () {
                  var i, t, f, e, h = "padding:0;margin:0;border:0;display:block;overflow:hidden;",
                      o = r.getElementsByTagName("body")[0];
                  o && (i = r.createElement("div"), i.style.cssText = "visibility:hidden;border:0;width:0;height:0;position:static;top:0;margin-top:1px", o.insertBefore(i, o.firstChild), t = r.createElement("div"), i.appendChild(t), t.innerHTML = "<table><tr><td><\/td><td>t<\/td><\/tr><\/table>", f = t.getElementsByTagName("td"), f[0].style.cssText = "padding:0;margin:0;border:0;display:none", s = f[0].offsetHeight === 0, f[0].style.display = "", f[1].style.display = "none", u.reliableHiddenOffsets = s && f[0].offsetHeight === 0, t.innerHTML = "", t.style.cssText = "box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;padding:1px;border:1px;display:block;width:4px;margin-top:1%;position:absolute;top:1%;", u.boxSizing = t.offsetWidth === 4, u.doesNotIncludeMarginInBodyOffset = o.offsetTop !== 1, n.getComputedStyle && (u.pixelPosition = (n.getComputedStyle(t, null) || {}).top !== "1%", u.boxSizingReliable = (n.getComputedStyle(t, null) || {
                      width: "4px"
                  }).width === "4px", e = r.createElement("div"), e.style.cssText = t.style.cssText = h, e.style.marginRight = e.style.width = "0", t.style.width = "1px", t.appendChild(e), u.reliableMarginRight = !parseFloat((n.getComputedStyle(e, null) || {}).marginRight)), typeof t.style.zoom != "undefined" && (t.innerHTML = "", t.style.cssText = h + "width:1px;padding:1px;display:inline;zoom:1", u.inlineBlockNeedsLayout = t.offsetWidth === 3, t.style.display = "block", t.style.overflow = "visible", t.innerHTML = "<div><\/div>", t.firstChild.style.width = "5px", u.shrinkWrapBlocks = t.offsetWidth !== 3, i.style.zoom = 1), o.removeChild(i), i = t = f = e = null)
              }), o.removeChild(t), h = e = c = l = f = o = t = null, u
          }(), or = /(?:\{[\s\S]*\}|\[[\s\S]*\])$/, sr = /([A-Z])/g, i.extend({
              cache: {},
              deletedIds: [],
              uuid: 0,
              expando: "jQuery" + (i.fn.jquery + Math.random()).replace(/\D/g, ""),
              noData: {
                  embed: !0,
                  object: "clsid:D27CDB6E-AE6D-11cf-96B8-444553540000",
                  applet: !0
              },
              hasData: function (n) {
                  return n = n.nodeType ? i.cache[n[i.expando]] : n[i.expando], !!n && !at(n)
              },
              data: function (n, r, u, f) {
                  if (i.acceptData(n)) {
                      var s, h, c = i.expando,
                          a = typeof r == "string",
                          l = n.nodeType,
                          o = l ? i.cache : n,
                          e = l ? n[c] : n[c] && c;
                      if (e && o[e] && (f || o[e].data) || !a || u !== t) return e || (l ? n[c] = e = i.deletedIds.pop() || i.guid++ : e = c), o[e] || (o[e] = {}, l || (o[e].toJSON = i.noop)), (typeof r == "object" || typeof r == "function") && (f ? o[e] = i.extend(o[e], r) : o[e].data = i.extend(o[e].data, r)), s = o[e], f || (s.data || (s.data = {}), s = s.data), u !== t && (s[i.camelCase(r)] = u), a ? (h = s[r], h == null && (h = s[i.camelCase(r)])) : h = s, h
                  }
              },
              removeData: function (n, t, r) {
                  if (i.acceptData(n)) {
                      var e, o, h, s = n.nodeType,
                          u = s ? i.cache : n,
                          f = s ? n[i.expando] : i.expando;
                      if (u[f]) {
                          if (t && (e = r ? u[f] : u[f].data, e)) {
                              for (i.isArray(t) || (t in e ? t = [t] : (t = i.camelCase(t), t = t in e ? [t] : t.split(" "))), o = 0, h = t.length; o < h; o++) delete e[t[o]];
                              if (!(r ? at : i.isEmptyObject)(e)) return
                          }(r || (delete u[f].data, at(u[f]))) && (s ? i.cleanData([n], !0) : i.support.deleteExpando || u != u.window ? delete u[f] : u[f] = null)
                      }
                  }
              },
              _data: function (n, t, r) {
                  return i.data(n, t, r, !0)
              },
              acceptData: function (n) {
                  var t = n.nodeName && i.noData[n.nodeName.toLowerCase()];
                  return !t || t !== !0 && n.getAttribute("classid") === t
              }
          }), i.fn.extend({
              data: function (n, r) {
                  var u, s, h, o, l, e = this[0],
                      c = 0,
                      f = null;
                  if (n === t) {
                      if (this.length && (f = i.data(e), e.nodeType === 1 && !i._data(e, "parsedAttrs"))) {
                          for (h = e.attributes, l = h.length; c < l; c++) o = h[c].name, o.indexOf("data-") || (o = i.camelCase(o.substring(5)), ui(e, o, f[o]));
                          i._data(e, "parsedAttrs", !0)
                      }
                      return f
                  }
                  return typeof n == "object" ? this.each(function () {
                      i.data(this, n)
                  }) : (u = n.split(".", 2), u[1] = u[1] ? "." + u[1] : "", s = u[1] + "!", i.access(this, function (r) {
                      if (r === t) return f = this.triggerHandler("getData" + s, [u[0]]), f === t && e && (f = i.data(e, n), f = ui(e, n, f)), f === t && u[1] ? this.data(u[0]) : f;
                      u[1] = r, this.each(function () {
                          var t = i(this);
                          t.triggerHandler("setData" + s, u), i.data(this, n, r), t.triggerHandler("changeData" + s, u)
                      })
                  }, null, r, arguments.length > 1, null, !1))
              },
              removeData: function (n) {
                  return this.each(function () {
                      i.removeData(this, n)
                  })
              }
          }), i.extend({
              queue: function (n, t, r) {
                  var u;
                  if (n) return t = (t || "fx") + "queue", u = i._data(n, t), r && (!u || i.isArray(r) ? u = i._data(n, t, i.makeArray(r)) : u.push(r)), u || []
              },
              dequeue: function (n, t) {
                  t = t || "fx";
                  var r = i.queue(n, t),
                      e = r.length,
                      u = r.shift(),
                      f = i._queueHooks(n, t),
                      o = function () {
                          i.dequeue(n, t)
                      };
                  u === "inprogress" && (u = r.shift(), e--), u && (t === "fx" && r.unshift("inprogress"), delete f.stop, u.call(n, o, f)), !e && f && f.empty.fire()
              },
              _queueHooks: function (n, t) {
                  var r = t + "queueHooks";
                  return i._data(n, r) || i._data(n, r, {
                      empty: i.Callbacks("once memory").add(function () {
                          i.removeData(n, t + "queue", !0), i.removeData(n, r, !0)
                      })
                  })
              }
          }), i.fn.extend({
              queue: function (n, r) {
                  var u = 2;
                  return typeof n != "string" && (r = n, n = "fx", u--), arguments.length < u ? i.queue(this[0], n) : r === t ? this : this.each(function () {
                      var t = i.queue(this, n, r);
                      i._queueHooks(this, n), n === "fx" && t[0] !== "inprogress" && i.dequeue(this, n)
                  })
              },
              dequeue: function (n) {
                  return this.each(function () {
                      i.dequeue(this, n)
                  })
              },
              delay: function (n, t) {
                  return n = i.fx ? i.fx.speeds[n] || n : n, t = t || "fx", this.queue(t, function (t, i) {
                      var r = setTimeout(t, n);
                      i.stop = function () {
                          clearTimeout(r)
                      }
                  })
              },
              clearQueue: function (n) {
                  return this.queue(n || "fx", [])
              },
              promise: function (n, r) {
                  var u, e = 1,
                      o = i.Deferred(),
                      f = this,
                      s = this.length,
                      h = function () {
                          --e || o.resolveWith(f, [f])
                      };
                  for (typeof n != "string" && (r = n, n = t), n = n || "fx"; s--;) u = i._data(f[s], n + "queueHooks"), u && u.empty && (e++, u.empty.add(h));
                  return h(), o.promise(r)
              }
          });
          var s, hr, cr, lr = /[\t\r\n]/g,
              bf = /\r/g,
              kf = /^(?:button|input)$/i,
              df = /^(?:button|input|object|select|textarea)$/i,
              gf = /^a(?:rea|)$/i,
              ar = /^(?:autofocus|autoplay|async|checked|controls|defer|disabled|hidden|loop|multiple|open|readonly|required|scoped|selected)$/i,
              vr = i.support.getSetAttribute;
          i.fn.extend({
              attr: function (n, t) {
                  return i.access(this, i.attr, n, t, arguments.length > 1)
              },
              removeAttr: function (n) {
                  return this.each(function () {
                      i.removeAttr(this, n)
                  })
              },
              prop: function (n, t) {
                  return i.access(this, i.prop, n, t, arguments.length > 1)
              },
              removeProp: function (n) {
                  return n = i.propFix[n] || n, this.each(function () {
                      try {
                          this[n] = t, delete this[n]
                      } catch (i) {}
                  })
              },
              addClass: function (n) {
                  var r, f, o, t, e, u, s;
                  if (i.isFunction(n)) return this.each(function (t) {
                      i(this).addClass(n.call(this, t, this.className))
                  });
                  if (n && typeof n == "string")
                      for (r = n.split(h), f = 0, o = this.length; f < o; f++)
                          if (t = this[f], t.nodeType === 1)
                              if (t.className || r.length !== 1) {
                                  for (e = " " + t.className + " ", u = 0, s = r.length; u < s; u++) e.indexOf(" " + r[u] + " ") < 0 && (e += r[u] + " ");
                                  t.className = i.trim(e)
                              } else t.className = n;
                  return this
              },
              removeClass: function (n) {
                  var e, r, u, f, s, o, c;
                  if (i.isFunction(n)) return this.each(function (t) {
                      i(this).removeClass(n.call(this, t, this.className))
                  });
                  if (n && typeof n == "string" || n === t)
                      for (e = (n || "").split(h), o = 0, c = this.length; o < c; o++)
                          if (u = this[o], u.nodeType === 1 && u.className) {
                              for (r = (" " + u.className + " ").replace(lr, " "), f = 0, s = e.length; f < s; f++)
                                  while (r.indexOf(" " + e[f] + " ") >= 0) r = r.replace(" " + e[f] + " ", " ");
                              u.className = n ? i.trim(r) : ""
                          }
                  return this
              },
              toggleClass: function (n, t) {
                  var r = typeof n,
                      u = typeof t == "boolean";
                  return i.isFunction(n) ? this.each(function (r) {
                      i(this).toggleClass(n.call(this, r, this.className, t), t)
                  }) : this.each(function () {
                      if (r === "string")
                          for (var f, s = 0, o = i(this), e = t, c = n.split(h); f = c[s++];) e = u ? e : !o.hasClass(f), o[e ? "addClass" : "removeClass"](f);
                      else(r === "undefined" || r === "boolean") && (this.className && i._data(this, "__className__", this.className), this.className = this.className || n === !1 ? "" : i._data(this, "__className__") || "")
                  })
              },
              hasClass: function (n) {
                  for (var i = " " + n + " ", t = 0, r = this.length; t < r; t++)
                      if (this[t].nodeType === 1 && (" " + this[t].className + " ").replace(lr, " ").indexOf(i) >= 0) return !0;
                  return !1
              },
              val: function (n) {
                  var r, u, e, f = this[0];
                  return arguments.length ? (e = i.isFunction(n), this.each(function (u) {
                      var f, o = i(this);
                      this.nodeType === 1 && (f = e ? n.call(this, u, o.val()) : n, f == null ? f = "" : typeof f == "number" ? f += "" : i.isArray(f) && (f = i.map(f, function (n) {
                          return n == null ? "" : n + ""
                      })), r = i.valHooks[this.type] || i.valHooks[this.nodeName.toLowerCase()], r && "set" in r && r.set(this, f, "value") !== t || (this.value = f))
                  })) : f ? (r = i.valHooks[f.type] || i.valHooks[f.nodeName.toLowerCase()], r && "get" in r && (u = r.get(f, "value")) !== t ? u : (u = f.value, typeof u == "string" ? u.replace(bf, "") : u == null ? "" : u)) : void 0
              }
          }), i.extend({
              valHooks: {
                  option: {
                      get: function (n) {
                          var t = n.attributes.value;
                          return !t || t.specified ? n.value : n.text
                      }
                  },
                  select: {
                      get: function (n) {
                          var o, r, h, t, u = n.selectedIndex,
                              s = [],
                              f = n.options,
                              e = n.type === "select-one";
                          if (u < 0) return null;
                          for (r = e ? u : 0, h = e ? u + 1 : f.length; r < h; r++)
                              if (t = f[r], t.selected && (i.support.optDisabled ? !t.disabled : t.getAttribute("disabled") === null) && (!t.parentNode.disabled || !i.nodeName(t.parentNode, "optgroup"))) {
                                  if (o = i(t).val(), e) return o;
                                  s.push(o)
                              }
                          return e && !s.length && f.length ? i(f[u]).val() : s
                      },
                      set: function (n, t) {
                          var r = i.makeArray(t);
                          return i(n).find("option").each(function () {
                              this.selected = i.inArray(i(this).val(), r) >= 0
                          }), r.length || (n.selectedIndex = -1), r
                      }
                  }
              },
              attrFn: {},
              attr: function (n, r, u, f) {
                  var e, o, h, c = n.nodeType;
                  if (n && c !== 3 && c !== 8 && c !== 2) {
                      if (f && i.isFunction(i.fn[r])) return i(n)[r](u);
                      if (typeof n.getAttribute == "undefined") return i.prop(n, r, u);
                      if (h = c !== 1 || !i.isXMLDoc(n), h && (r = r.toLowerCase(), o = i.attrHooks[r] || (ar.test(r) ? hr : s)), u !== t) {
                          if (u === null) {
                              i.removeAttr(n, r);
                              return
                          }
                          return o && "set" in o && h && (e = o.set(n, u, r)) !== t ? e : (n.setAttribute(r, u + ""), u)
                      }
                      return o && "get" in o && h && (e = o.get(n, r)) !== null ? e : (e = n.getAttribute(r), e === null ? t : e)
                  }
              },
              removeAttr: function (n, t) {
                  var u, f, r, e, o = 0;
                  if (t && n.nodeType === 1)
                      for (f = t.split(h); o < f.length; o++) r = f[o], r && (u = i.propFix[r] || r, e = ar.test(r), e || i.attr(n, r, ""), n.removeAttribute(vr ? r : u), e && u in n && (n[u] = !1))
              },
              attrHooks: {
                  type: {
                      set: function (n, t) {
                          if (kf.test(n.nodeName) && n.parentNode) i.error("type property can't be changed");
                          else if (!i.support.radioValue && t === "radio" && i.nodeName(n, "input")) {
                              var r = n.value;
                              return n.setAttribute("type", t), r && (n.value = r), t
                          }
                      }
                  },
                  value: {
                      get: function (n, t) {
                          return s && i.nodeName(n, "button") ? s.get(n, t) : t in n ? n.value : null
                      },
                      set: function (n, t, r) {
                          if (s && i.nodeName(n, "button")) return s.set(n, t, r);
                          n.value = t
                      }
                  }
              },
              propFix: {
                  tabindex: "tabIndex",
                  readonly: "readOnly",
                  "for": "htmlFor",
                  "class": "className",
                  maxlength: "maxLength",
                  cellspacing: "cellSpacing",
                  cellpadding: "cellPadding",
                  rowspan: "rowSpan",
                  colspan: "colSpan",
                  usemap: "useMap",
                  frameborder: "frameBorder",
                  contenteditable: "contentEditable"
              },
              prop: function (n, r, u) {
                  var e, f, s, o = n.nodeType;
                  if (n && o !== 3 && o !== 8 && o !== 2) return s = o !== 1 || !i.isXMLDoc(n), s && (r = i.propFix[r] || r, f = i.propHooks[r]), u !== t ? f && "set" in f && (e = f.set(n, u, r)) !== t ? e : n[r] = u : f && "get" in f && (e = f.get(n, r)) !== null ? e : n[r]
              },
              propHooks: {
                  tabIndex: {
                      get: function (n) {
                          var i = n.getAttributeNode("tabindex");
                          return i && i.specified ? parseInt(i.value, 10) : df.test(n.nodeName) || gf.test(n.nodeName) && n.href ? 0 : t
                      }
                  }
              }
          }), hr = {
              get: function (n, r) {
                  var u, f = i.prop(n, r);
                  return f === !0 || typeof f != "boolean" && (u = n.getAttributeNode(r)) && u.nodeValue !== !1 ? r.toLowerCase() : t
              },
              set: function (n, t, r) {
                  var u;
                  return t === !1 ? i.removeAttr(n, r) : (u = i.propFix[r] || r, u in n && (n[u] = !0), n.setAttribute(r, r.toLowerCase())), r
              }
          }, vr || (cr = {
              name: !0,
              id: !0,
              coords: !0
          }, s = i.valHooks.button = {
              get: function (n, i) {
                  var r;
                  return r = n.getAttributeNode(i), r && (cr[i] ? r.value !== "" : r.specified) ? r.value : t
              },
              set: function (n, t, i) {
                  var u = n.getAttributeNode(i);
                  return u || (u = r.createAttribute(i), n.setAttributeNode(u)), u.value = t + ""
              }
          }, i.each(["width", "height"], function (n, t) {
              i.attrHooks[t] = i.extend(i.attrHooks[t], {
                  set: function (n, i) {
                      if (i === "") return n.setAttribute(t, "auto"), i
                  }
              })
          }), i.attrHooks.contenteditable = {
              get: s.get,
              set: function (n, t, i) {
                  t === "" && (t = "false"), s.set(n, t, i)
              }
          }), i.support.hrefNormalized || i.each(["href", "src", "width", "height"], function (n, r) {
              i.attrHooks[r] = i.extend(i.attrHooks[r], {
                  get: function (n) {
                      var i = n.getAttribute(r, 2);
                      return i === null ? t : i
                  }
              })
          }), i.support.style || (i.attrHooks.style = {
              get: function (n) {
                  return n.style.cssText.toLowerCase() || t
              },
              set: function (n, t) {
                  return n.style.cssText = t + ""
              }
          }), i.support.optSelected || (i.propHooks.selected = i.extend(i.propHooks.selected, {
              get: function (n) {
                  var t = n.parentNode;
                  return t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex), null
              }
          })), i.support.enctype || (i.propFix.enctype = "encoding"), i.support.checkOn || i.each(["radio", "checkbox"], function () {
              i.valHooks[this] = {
                  get: function (n) {
                      return n.getAttribute("value") === null ? "on" : n.value
                  }
              }
          }), i.each(["radio", "checkbox"], function () {
              i.valHooks[this] = i.extend(i.valHooks[this], {
                  set: function (n, t) {
                      if (i.isArray(t)) return n.checked = i.inArray(i(n).val(), t) >= 0
                  }
              })
          });
          var bt = /^(?:textarea|input|select)$/i,
              yr = /^([^\.]*|)(?:\.(.+)|)$/,
              ne = /(?:^|\s)hover(\.\S+|)\b/,
              te = /^key/,
              ie = /^(?:mouse|contextmenu)|click/,
              pr = /^(?:focusinfocus|focusoutblur)$/,
              wr = function (n) {
                  return i.event.special.hover ? n : n.replace(ne, "mouseenter$1 mouseleave$1")
              };
          i.event = {
                  add: function (n, r, u, f, e) {
                      var a, s, v, y, p, o, b, l, w, c, h;
                      if (n.nodeType !== 3 && n.nodeType !== 8 && r && u && (a = i._data(n))) {
                          for (u.handler && (w = u, u = w.handler, e = w.selector), u.guid || (u.guid = i.guid++), v = a.events, v || (a.events = v = {}), s = a.handle, s || (a.handle = s = function (n) {
                              return typeof i != "undefined" && (!n || i.event.triggered !== n.type) ? i.event.dispatch.apply(s.elem, arguments) : t
                          }, s.elem = n), r = i.trim(wr(r)).split(" "), y = 0; y < r.length; y++) p = yr.exec(r[y]) || [], o = p[1], b = (p[2] || "").split(".").sort(), h = i.event.special[o] || {}, o = (e ? h.delegateType : h.bindType) || o, h = i.event.special[o] || {}, l = i.extend({
                              type: o,
                              origType: p[1],
                              data: f,
                              handler: u,
                              guid: u.guid,
                              selector: e,
                              needsContext: e && i.expr.match.needsContext.test(e),
                              namespace: b.join(".")
                          }, w), c = v[o], c || (c = v[o] = [], c.delegateCount = 0, h.setup && h.setup.call(n, f, b, s) !== !1 || (n.addEventListener ? n.addEventListener(o, s, !1) : n.attachEvent && n.attachEvent("on" + o, s))), h.add && (h.add.call(n, l), l.handler.guid || (l.handler.guid = u.guid)), e ? c.splice(c.delegateCount++, 0, l) : c.push(l), i.event.global[o] = !0;
                          n = null
                      }
                  },
                  global: {},
                  remove: function (n, t, r, u, f) {
                      var l, p, e, w, h, b, a, v, c, o, s, y = i.hasData(n) && i._data(n);
                      if (y && (v = y.events)) {
                          for (t = i.trim(wr(t || "")).split(" "), l = 0; l < t.length; l++) {
                              if (p = yr.exec(t[l]) || [], e = w = p[1], h = p[2], !e) {
                                  for (e in v) i.event.remove(n, e + t[l], r, u, !0);
                                  continue
                              }
                              for (c = i.event.special[e] || {}, e = (u ? c.delegateType : c.bindType) || e, o = v[e] || [], b = o.length, h = h ? new RegExp("(^|\\.)" + h.split(".").sort().join("\\.(?:.*\\.|)") + "(\\.|$)") : null, a = 0; a < o.length; a++) s = o[a], (f || w === s.origType) && (!r || r.guid === s.guid) && (!h || h.test(s.namespace)) && (!u || u === s.selector || u === "**" && s.selector) && (o.splice(a--, 1), s.selector && o.delegateCount--, c.remove && c.remove.call(n, s));
                              o.length === 0 && b !== o.length && ((!c.teardown || c.teardown.call(n, h, y.handle) === !1) && i.removeEvent(n, e, y.handle), delete v[e])
                          }
                          i.isEmptyObject(v) && (delete y.handle, i.removeData(n, "events", !0))
                      }
                  },
                  customEvent: {
                      getData: !0,
                      setData: !0,
                      changeData: !0
                  },
                  trigger: function (u, f, e, o) {
                      if (!e || e.nodeType !== 3 && e.nodeType !== 8) {
                          var w, d, c, h, l, v, a, y, p, k, s = u.type || u,
                              b = [];
                          if (pr.test(s + i.event.triggered)) return;
                          if (s.indexOf("!") >= 0 && (s = s.slice(0, -1), d = !0), s.indexOf(".") >= 0 && (b = s.split("."), s = b.shift(), b.sort()), (!e || i.event.customEvent[s]) && !i.event.global[s]) return;
                          if (u = typeof u == "object" ? u[i.expando] ? u : new i.Event(s, u) : new i.Event(s), u.type = s, u.isTrigger = !0, u.exclusive = d, u.namespace = b.join("."), u.namespace_re = u.namespace ? new RegExp("(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, v = s.indexOf(":") < 0 ? "on" + s : "", !e) {
                              w = i.cache;
                              for (c in w) w[c].events && w[c].events[s] && i.event.trigger(u, f, w[c].handle.elem, !0);
                              return
                          }
                          if (u.result = t, u.target || (u.target = e), f = f != null ? i.makeArray(f) : [], f.unshift(u), a = i.event.special[s] || {}, a.trigger && a.trigger.apply(e, f) === !1) return;
                          if (p = [
                              [e, a.bindType || s]
                          ], !o && !a.noBubble && !i.isWindow(e)) {
                              for (k = a.delegateType || s, h = pr.test(k + s) ? e : e.parentNode, l = e; h; h = h.parentNode) p.push([h, k]), l = h;
                              l === (e.ownerDocument || r) && p.push([l.defaultView || l.parentWindow || n, k])
                          }
                          for (c = 0; c < p.length && !u.isPropagationStopped(); c++) h = p[c][0], u.type = p[c][1], y = (i._data(h, "events") || {})[u.type] && i._data(h, "handle"), y && y.apply(h, f), y = v && h[v], y && i.acceptData(h) && y.apply && y.apply(h, f) === !1 && u.preventDefault();
                          return u.type = s, !o && !u.isDefaultPrevented() && (!a._default || a._default.apply(e.ownerDocument, f) === !1) && (s !== "click" || !i.nodeName(e, "a")) && i.acceptData(e) && v && e[s] && (s !== "focus" && s !== "blur" || u.target.offsetWidth !== 0) && !i.isWindow(e) && (l = e[v], l && (e[v] = null), i.event.triggered = s, e[s](), i.event.triggered = t, l && (e[v] = l)), u.result
                      }
                      return
                  },
                  dispatch: function (r) {
                      r = i.event.fix(r || n.event);
                      var f, c, e, l, a, h, v, u, s, g, y = (i._data(this, "events") || {})[r.type] || [],
                          p = y.delegateCount,
                          k = o.call(arguments),
                          d = !r.exclusive && !r.namespace,
                          w = i.event.special[r.type] || {},
                          b = [];
                      if (k[0] = r, r.delegateTarget = this, !w.preDispatch || w.preDispatch.call(this, r) !== !1) {
                          if (p && (!r.button || r.type !== "click"))
                              for (e = r.target; e != this; e = e.parentNode || this)
                                  if (e.disabled !== !0 || r.type !== "click") {
                                      for (a = {}, v = [], f = 0; f < p; f++) u = y[f], s = u.selector, a[s] === t && (a[s] = u.needsContext ? i(s, this).index(e) >= 0 : i.find(s, this, null, [e]).length), a[s] && v.push(u);
                                      v.length && b.push({
                                          elem: e,
                                          matches: v
                                      })
                                  }
                          for (y.length > p && b.push({
                              elem: this,
                              matches: y.slice(p)
                          }), f = 0; f < b.length && !r.isPropagationStopped(); f++)
                              for (h = b[f], r.currentTarget = h.elem, c = 0; c < h.matches.length && !r.isImmediatePropagationStopped(); c++) u = h.matches[c], (d || !r.namespace && !u.namespace || r.namespace_re && r.namespace_re.test(u.namespace)) && (r.data = u.data, r.handleObj = u, l = ((i.event.special[u.origType] || {}).handle || u.handler).apply(h.elem, k), l !== t && (r.result = l, l === !1 && (r.preventDefault(), r.stopPropagation())));
                          return w.postDispatch && w.postDispatch.call(this, r), r.result
                      }
                  },
                  props: "attrChange attrName relatedNode srcElement altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),
                  fixHooks: {},
                  keyHooks: {
                      props: "char charCode key keyCode".split(" "),
                      filter: function (n, t) {
                          return n.which == null && (n.which = t.charCode != null ? t.charCode : t.keyCode), n
                      }
                  },
                  mouseHooks: {
                      props: "button buttons clientX clientY fromElement offsetX offsetY pageX pageY screenX screenY toElement".split(" "),
                      filter: function (n, i) {
                          var o, u, f, e = i.button,
                              s = i.fromElement;
                          return n.pageX == null && i.clientX != null && (o = n.target.ownerDocument || r, u = o.documentElement, f = o.body, n.pageX = i.clientX + (u && u.scrollLeft || f && f.scrollLeft || 0) - (u && u.clientLeft || f && f.clientLeft || 0), n.pageY = i.clientY + (u && u.scrollTop || f && f.scrollTop || 0) - (u && u.clientTop || f && f.clientTop || 0)), !n.relatedTarget && s && (n.relatedTarget = s === n.target ? i.toElement : s), !n.which && e !== t && (n.which = e & 1 ? 1 : e & 2 ? 3 : e & 4 ? 2 : 0), n
                      }
                  },
                  fix: function (n) {
                      if (n[i.expando]) return n;
                      var f, e, t = n,
                          u = i.event.fixHooks[n.type] || {},
                          o = u.props ? this.props.concat(u.props) : this.props;
                      for (n = i.Event(t), f = o.length; f;) e = o[--f], n[e] = t[e];
                      return n.target || (n.target = t.srcElement || r), n.target.nodeType === 3 && (n.target = n.target.parentNode), n.metaKey = !!n.metaKey, u.filter ? u.filter(n, t) : n
                  },
                  special: {
                      load: {
                          noBubble: !0
                      },
                      focus: {
                          delegateType: "focusin"
                      },
                      blur: {
                          delegateType: "focusout"
                      },
                      beforeunload: {
                          setup: function (n, t, r) {
                              i.isWindow(this) && (this.onbeforeunload = r)
                          },
                          teardown: function (n, t) {
                              this.onbeforeunload === t && (this.onbeforeunload = null)
                          }
                      }
                  },
                  simulate: function (n, t, r, u) {
                      var f = i.extend(new i.Event, r, {
                          type: n,
                          isSimulated: !0,
                          originalEvent: {}
                      });
                      u ? i.event.trigger(f, null, t) : i.event.dispatch.call(t, f), f.isDefaultPrevented() && r.preventDefault()
                  }
              }, i.event.handle = i.event.dispatch, i.removeEvent = r.removeEventListener ? function (n, t, i) {
                  n.removeEventListener && n.removeEventListener(t, i, !1)
              } : function (n, t, i) {
                  var r = "on" + t;
                  n.detachEvent && (typeof n[r] == "undefined" && (n[r] = null), n.detachEvent(r, i))
              }, i.Event = function (n, t) {
                  if (this instanceof i.Event) n && n.type ? (this.originalEvent = n, this.type = n.type, this.isDefaultPrevented = n.defaultPrevented || n.returnValue === !1 || n.getPreventDefault && n.getPreventDefault() ? d : a) : this.type = n, t && i.extend(this, t), this.timeStamp = n && n.timeStamp || i.now(), this[i.expando] = !0;
                  else return new i.Event(n, t)
              }, i.Event.prototype = {
                  preventDefault: function () {
                      this.isDefaultPrevented = d;
                      var n = this.originalEvent;
                      n && (n.preventDefault ? n.preventDefault() : n.returnValue = !1)
                  },
                  stopPropagation: function () {
                      this.isPropagationStopped = d;
                      var n = this.originalEvent;
                      n && (n.stopPropagation && n.stopPropagation(), n.cancelBubble = !0)
                  },
                  stopImmediatePropagation: function () {
                      this.isImmediatePropagationStopped = d, this.stopPropagation()
                  },
                  isDefaultPrevented: a,
                  isPropagationStopped: a,
                  isImmediatePropagationStopped: a
              }, i.each({
                  mouseenter: "mouseover",
                  mouseleave: "mouseout"
              }, function (n, t) {
                  i.event.special[n] = {
                      delegateType: t,
                      bindType: t,
                      handle: function (n) {
                          var f, e = this,
                              r = n.relatedTarget,
                              u = n.handleObj,
                              o = u.selector;
                          return r && (r === e || i.contains(e, r)) || (n.type = u.origType, f = u.handler.apply(this, arguments), n.type = t), f
                      }
                  }
              }), i.support.submitBubbles || (i.event.special.submit = {
                  setup: function () {
                      if (i.nodeName(this, "form")) return !1;
                      i.event.add(this, "click._submit keypress._submit", function (n) {
                          var u = n.target,
                              r = i.nodeName(u, "input") || i.nodeName(u, "button") ? u.form : t;
                          r && !i._data(r, "_submit_attached") && (i.event.add(r, "submit._submit", function (n) {
                              n._submit_bubble = !0
                          }), i._data(r, "_submit_attached", !0))
                      })
                  },
                  postDispatch: function (n) {
                      n._submit_bubble && (delete n._submit_bubble, this.parentNode && !n.isTrigger && i.event.simulate("submit", this.parentNode, n, !0))
                  },
                  teardown: function () {
                      if (i.nodeName(this, "form")) return !1;
                      i.event.remove(this, "._submit")
                  }
              }), i.support.changeBubbles || (i.event.special.change = {
                  setup: function () {
                      if (bt.test(this.nodeName)) return (this.type === "checkbox" || this.type === "radio") && (i.event.add(this, "propertychange._change", function (n) {
                          n.originalEvent.propertyName === "checked" && (this._just_changed = !0)
                      }), i.event.add(this, "click._change", function (n) {
                          this._just_changed && !n.isTrigger && (this._just_changed = !1), i.event.simulate("change", this, n, !0)
                      })), !1;
                      i.event.add(this, "beforeactivate._change", function (n) {
                          var t = n.target;
                          bt.test(t.nodeName) && !i._data(t, "_change_attached") && (i.event.add(t, "change._change", function (n) {
                              !this.parentNode || n.isSimulated || n.isTrigger || i.event.simulate("change", this.parentNode, n, !0)
                          }), i._data(t, "_change_attached", !0))
                      })
                  },
                  handle: function (n) {
                      var t = n.target;
                      if (this !== t || n.isSimulated || n.isTrigger || t.type !== "radio" && t.type !== "checkbox") return n.handleObj.handler.apply(this, arguments)
                  },
                  teardown: function () {
                      return i.event.remove(this, "._change"), !bt.test(this.nodeName)
                  }
              }), i.support.focusinBubbles || i.each({
                  focus: "focusin",
                  blur: "focusout"
              }, function (n, t) {
                  var u = 0,
                      f = function (n) {
                          i.event.simulate(t, n.target, i.event.fix(n), !0)
                      };
                  i.event.special[t] = {
                      setup: function () {
                          u++ == 0 && r.addEventListener(n, f, !0)
                      },
                      teardown: function () {
                          --u == 0 && r.removeEventListener(n, f, !0)
                      }
                  }
              }), i.fn.extend({
                  on: function (n, r, u, f, e) {
                      var o, s;
                      if (typeof n == "object") {
                          typeof r != "string" && (u = u || r, r = t);
                          for (s in n) this.on(s, r, u, n[s], e);
                          return this
                      }
                      if (u == null && f == null ? (f = r, u = r = t) : f == null && (typeof r == "string" ? (f = u, u = t) : (f = u, u = r, r = t)), f === !1) f = a;
                      else if (!f) return this;
                      return e === 1 && (o = f, f = function (n) {
                          return i().off(n), o.apply(this, arguments)
                      }, f.guid = o.guid || (o.guid = i.guid++)), this.each(function () {
                          i.event.add(this, n, f, u, r)
                      })
                  },
                  one: function (n, t, i, r) {
                      return this.on(n, t, i, r, 1)
                  },
                  off: function (n, r, u) {
                      var f, e;
                      if (n && n.preventDefault && n.handleObj) return f = n.handleObj, i(n.delegateTarget).off(f.namespace ? f.origType + "." + f.namespace : f.origType, f.selector, f.handler), this;
                      if (typeof n == "object") {
                          for (e in n) this.off(e, r, n[e]);
                          return this
                      }
                      return (r === !1 || typeof r == "function") && (u = r, r = t), u === !1 && (u = a), this.each(function () {
                          i.event.remove(this, n, u, r)
                      })
                  },
                  bind: function (n, t, i) {
                      return this.on(n, null, t, i)
                  },
                  unbind: function (n, t) {
                      return this.off(n, null, t)
                  },
                  live: function (n, t, r) {
                      return i(this.context).on(n, this.selector, t, r), this
                  },
                  die: function (n, t) {
                      return i(this.context).off(n, this.selector || "**", t), this
                  },
                  delegate: function (n, t, i, r) {
                      return this.on(t, n, i, r)
                  },
                  undelegate: function (n, t, i) {
                      return arguments.length === 1 ? this.off(n, "**") : this.off(t, n || "**", i)
                  },
                  trigger: function (n, t) {
                      return this.each(function () {
                          i.event.trigger(n, t, this)
                      })
                  },
                  triggerHandler: function (n, t) {
                      if (this[0]) return i.event.trigger(n, t, this[0], !0)
                  },
                  toggle: function (n) {
                      var t = arguments,
                          u = n.guid || i.guid++,
                          r = 0,
                          f = function (u) {
                              var f = (i._data(this, "lastToggle" + n.guid) || 0) % r;
                              return i._data(this, "lastToggle" + n.guid, f + 1), u.preventDefault(), t[f].apply(this, arguments) || !1
                          };
                      for (f.guid = u; r < t.length;) t[r++].guid = u;
                      return this.click(f)
                  },
                  hover: function (n, t) {
                      return this.mouseenter(n).mouseleave(t || n)
                  }
              }), i.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "), function (n, t) {
                  i.fn[t] = function (n, i) {
                      return i == null && (i = n, n = null), arguments.length > 0 ? this.on(t, null, n, i) : this.trigger(t)
                  }, te.test(t) && (i.event.fixHooks[t] = i.event.keyHooks), ie.test(t) && (i.event.fixHooks[t] = i.event.mouseHooks)
              }),
              function (n, t) {
                  function r(n, t, i, r) {
                      i = i || [], t = t || s;
                      var e, u, o, f, h = t.nodeType;
                      if (!n || typeof n != "string") return i;
                      if (h !== 1 && h !== 9) return [];
                      if (o = it(t), !o && !r && (e = di.exec(n)))
                          if (f = e[1]) {
                              if (h === 9) {
                                  if (u = t.getElementById(f), !u || !u.parentNode) return i;
                                  if (u.id === f) return i.push(u), i
                              } else if (t.ownerDocument && (u = t.ownerDocument.getElementById(f)) && ni(t, u) && u.id === f) return i.push(u), i
                          } else {
                              if (e[2]) return p.apply(i, w.call(t.getElementsByTagName(n), 0)), i;
                              if ((f = e[3]) && hi && t.getElementsByClassName) return p.apply(i, w.call(t.getElementsByClassName(f), 0)), i
                          }
                      return lt(n.replace(ft, "$1"), t, i, r, o)
                  }

                  function b(n) {
                      return function (t) {
                          var i = t.nodeName.toLowerCase();
                          return i === "input" && t.type === n
                      }
                  }

                  function dt(n) {
                      return function (t) {
                          var i = t.nodeName.toLowerCase();
                          return (i === "input" || i === "button") && t.type === n
                      }
                  }

                  function a(n) {
                      return h(function (t) {
                          return t = +t, h(function (i, r) {
                              for (var u, f = n([], i.length, t), e = f.length; e--;) i[u = f[e]] && (i[u] = !(r[u] = i[u]))
                          })
                      })
                  }

                  function d(n, t, i) {
                      if (n === t) return i;
                      for (var r = n.nextSibling; r;) {
                          if (r === t) return -1;
                          r = r.nextSibling
                      }
                      return 1
                  }

                  function g(n, t) {
                      var o, f, c, h, i, l, a, v = fi[e][n];
                      if (v) return t ? 0 : v.slice(0);
                      for (i = n, l = [], a = u.preFilter; i;) {
                          (!o || (f = wi.exec(i))) && (f && (i = i.slice(f[0].length)), l.push(c = [])), o = !1, (f = bi.exec(i)) && (c.push(o = new ii(f.shift())), i = i.slice(o.length), o.type = f[0].replace(ft, " "));
                          for (h in u.filter)(f = et[h].exec(i)) && (!a[h] || (f = a[h](f, s, !0))) && (c.push(o = new ii(f.shift())), i = i.slice(o.length), o.type = h, o.matches = f);
                          if (!o) break
                      }
                      return t ? i.length : i ? r.error(n) : fi(n, l).slice(0)
                  }

                  function ot(n, t, i) {
                      var r = t.dir,
                          u = i && t.dir === "parentNode",
                          f = ai++;
                      return t.first ? function (t, i, f) {
                          while (t = t[r])
                              if (u || t.nodeType === 1) return n(t, i, f)
                      } : function (t, i, o) {
                          if (o) {
                              while (t = t[r])
                                  if ((u || t.nodeType === 1) && n(t, i, o)) return t
                          } else
                              for (var s, h = ut + " " + f + " ", c = h + at; t = t[r];)
                                  if (u || t.nodeType === 1) {
                                      if ((s = t[e]) === c) return t.sizset;
                                      if (typeof s == "string" && s.indexOf(h) === 0) {
                                          if (t.sizset) return t
                                      } else {
                                          if (t[e] = c, n(t, i, o)) return t.sizset = !0, t;
                                          t.sizset = !1
                                      }
                                  }
                      }
                  }

                  function st(n) {
                      return n.length > 1 ? function (t, i, r) {
                          for (var u = n.length; u--;)
                              if (!n[u](t, i, r)) return !1;
                          return !0
                      } : n[0]
                  }

                  function nt(n, t, i, r, u) {
                      for (var e, o = [], f = 0, s = n.length, h = t != null; f < s; f++)(e = n[f]) && (!i || i(e, r, u)) && (o.push(e), h && t.push(f));
                      return o
                  }

                  function ht(n, t, i, r, u, f) {
                      return r && !r[e] && (r = ht(r)), u && !u[e] && (u = ht(u, f)), h(function (f, e, o, s) {
                          if (!f || !u) {
                              var c, l, a, v = [],
                                  y = [],
                                  b = e.length,
                                  k = f || li(t || "*", o.nodeType ? [o] : o, [], f),
                                  w = n && (f || !t) ? nt(k, v, n, o, s) : k,
                                  h = i ? u || (f ? n : b || r) ? [] : e : w;
                              if (i && i(w, h, o, s), r)
                                  for (a = nt(h, y), r(a, [], o, s), c = a.length; c--;)(l = a[c]) && (h[y[c]] = !(w[y[c]] = l));
                              if (f)
                                  for (c = n && h.length; c--;)(l = h[c]) && (f[v[c]] = !(e[v[c]] = l));
                              else h = nt(h === e ? h.splice(b, h.length) : h), u ? u(null, e, h, s) : p.apply(e, h)
                          }
                      })
                  }

                  function ct(n) {
                      for (var s, r, i, o = n.length, h = u.relative[n[0].type], c = h || u.relative[" "], t = h ? 1 : 0, l = ot(function (n) {
                          return n === s
                      }, c, !0), a = ot(function (n) {
                          return ri.call(s, n) > -1
                      }, c, !0), f = [
                          function (n, t, i) {
                              return !h && (i || t !== rt) || ((s = t).nodeType ? l(n, t, i) : a(n, t, i))
                          }
                      ]; t < o; t++)
                          if (r = u.relative[n[t].type]) f = [ot(st(f), r)];
                          else {
                              if (r = u.filter[n[t].type].apply(null, n[t].matches), r[e]) {
                                  for (i = ++t; i < o; i++)
                                      if (u.relative[n[i].type]) break;
                                  return ht(t > 1 && st(f), t > 1 && n.slice(0, t - 1).join("").replace(ft, "$1"), r, t < i && ct(n.slice(t, i)), i < o && ct(n = n.slice(i)), i < o && n.join(""))
                              }
                              f.push(r)
                          }
                      return st(f)
                  }

                  function ci(n, t) {
                      var f = t.length > 0,
                          e = n.length > 0,
                          i = function (o, h, c, l, a) {
                              var y, b, k, w = [],
                                  d = 0,
                                  v = "0",
                                  g = o && [],
                                  tt = a != null,
                                  it = rt,
                                  et = o || e && u.find.TAG("*", a && h.parentNode || h),
                                  ft = ut += it == null ? 1 : Math.E;
                              for (tt && (rt = h !== s && h, at = i.el);
                                  (y = et[v]) != null; v++) {
                                  if (e && y) {
                                      for (b = 0; k = n[b]; b++)
                                          if (k(y, h, c)) {
                                              l.push(y);
                                              break
                                          }
                                      tt && (ut = ft, at = ++i.el)
                                  }
                                  f && ((y = !k && y) && d--, o && g.push(y))
                              }
                              if (d += v, f && v !== d) {
                                  for (b = 0; k = t[b]; b++) k(g, w, h, c);
                                  if (o) {
                                      if (d > 0)
                                          while (v--) g[v] || w[v] || (w[v] = vi.call(l));
                                      w = nt(w)
                                  }
                                  p.apply(l, w), tt && !o && w.length > 0 && d + t.length > 1 && r.uniqueSort(l)
                              }
                              return tt && (ut = ft, rt = it), g
                          };
                      return i.el = 0, f ? h(i) : i
                  }

                  function li(n, t, i, u) {
                      for (var f = 0, e = t.length; f < e; f++) r(n, t[f], i, u);
                      return i
                  }

                  function lt(n, t, i, r, f) {
                      var o, e, s, c, l, h = g(n),
                          a = h.length;
                      if (!r && h.length === 1) {
                          if (e = h[0] = h[0].slice(0), e.length > 2 && (s = e[0]).type === "ID" && t.nodeType === 9 && !f && u.relative[e[1].type]) {
                              if (t = u.find.ID(s.matches[0].replace(y, ""), t, f)[0], !t) return i;
                              n = n.slice(e.shift().length)
                          }
                          for (o = et.POS.test(n) ? -1 : e.length - 1; o >= 0; o--) {
                              if (s = e[o], u.relative[c = s.type]) break;
                              if ((l = u.find[c]) && (r = l(s.matches[0].replace(y, ""), kt.test(e[0].type) && t.parentNode || t, f))) {
                                  if (e.splice(o, 1), n = r.length && e.join(""), !n) return p.apply(i, w.call(r, 0)), i;
                                  break
                              }
                          }
                      }
                      return yt(n, h)(r, t, f, i, kt.test(n)), i
                  }

                  function gt() {}
                  var at, vt, u, tt, it, ni, yt, pt, k, rt, ti = !0,
                      c = "undefined",
                      e = ("sizcache" + Math.random()).replace(".", ""),
                      ii = String,
                      s = n.document,
                      o = s.documentElement,
                      ut = 0,
                      ai = 0,
                      vi = [].pop,
                      p = [].push,
                      w = [].slice,
                      ri = [].indexOf || function (n) {
                          for (var t = 0, i = this.length; t < i; t++)
                              if (this[t] === n) return t;
                          return -1
                      },
                      h = function (n, t) {
                          return n[e] = t == null || t, n
                      },
                      wt = function () {
                          var n = {},
                              t = [];
                          return h(function (i, r) {
                              return t.push(i) > u.cacheLength && delete n[t.shift()], n[i] = r
                          }, n)
                      },
                      ui = wt(),
                      fi = wt(),
                      ei = wt(),
                      f = "[\\x20\\t\\r\\n\\f]",
                      v = "(?:\\\\.|[-\\w]|[^\\x00-\\xa0])+",
                      yi = v.replace("w", "w#"),
                      pi = "([*^$|!~]?=)",
                      oi = "\\[" + f + "*(" + v + ")" + f + "*(?:" + pi + f + "*(?:(['\"])((?:\\\\.|[^\\\\])*?)\\3|(" + yi + ")|)|)" + f + "*\\]",
                      bt = ":(" + v + ")(?:\\((?:(['\"])((?:\\\\.|[^\\\\])*?)\\2|([^()[\\]]*|(?:(?:" + oi + ")|[^:]|\\\\.)*|.*))\\)|)",
                      si = ":(even|odd|eq|gt|lt|nth|first|last)(?:\\(" + f + "*((?:-\\d)?\\d*)" + f + "*\\)|)(?=[^-]|$)",
                      ft = new RegExp("^" + f + "+|((?:^|[^\\\\])(?:\\\\.)*)" + f + "+$", "g"),
                      wi = new RegExp("^" + f + "*," + f + "*"),
                      bi = new RegExp("^" + f + "*([\\x20\\t\\r\\n\\f>+~])" + f + "*"),
                      ki = new RegExp(bt),
                      di = /^(?:#([\w\-]+)|(\w+)|\.([\w\-]+))$/,
                      fr = /^:not/,
                      kt = /[\x20\t\r\n\f]*[+~]/,
                      er = /:not\($/,
                      gi = /h\d/i,
                      nr = /input|select|textarea|button/i,
                      y = /\\(?!\\)/g,
                      et = {
                          ID: new RegExp("^#(" + v + ")"),
                          CLASS: new RegExp("^\\.(" + v + ")"),
                          NAME: new RegExp("^\\[name=['\"]?(" + v + ")['\"]?\\]"),
                          TAG: new RegExp("^(" + v.replace("w", "w*") + ")"),
                          ATTR: new RegExp("^" + oi),
                          PSEUDO: new RegExp("^" + bt),
                          POS: new RegExp(si, "i"),
                          CHILD: new RegExp("^:(only|nth|first|last)-child(?:\\(" + f + "*(even|odd|(([+-]|)(\\d*)n|)" + f + "*(?:([+-]|)" + f + "*(\\d+)|))" + f + "*\\)|)", "i"),
                          needsContext: new RegExp("^" + f + "*[>+~]|" + si, "i")
                      },
                      l = function (n) {
                          var t = s.createElement("div");
                          try {
                              return n(t)
                          } catch (i) {
                              return !1
                          } finally {
                              t = null
                          }
                      },
                      tr = l(function (n) {
                          return n.appendChild(s.createComment("")), !n.getElementsByTagName("*").length
                      }),
                      ir = l(function (n) {
                          return n.innerHTML = "<a href='#'><\/a>", n.firstChild && typeof n.firstChild.getAttribute !== c && n.firstChild.getAttribute("href") === "#"
                      }),
                      rr = l(function (n) {
                          n.innerHTML = "<select><\/select>";
                          var t = typeof n.lastChild.getAttribute("multiple");
                          return t !== "boolean" && t !== "string"
                      }),
                      hi = l(function (n) {
                          return n.innerHTML = "<div class='hidden e'><\/div><div class='hidden'><\/div>", !n.getElementsByClassName || !n.getElementsByClassName("e").length ? !1 : (n.lastChild.className = "e", n.getElementsByClassName("e").length === 2)
                      }),
                      ur = l(function (n) {
                          n.id = e + 0, n.innerHTML = "<a name='" + e + "'><\/a><div name='" + e + "'><\/div>", o.insertBefore(n, o.firstChild);
                          var t = s.getElementsByName && s.getElementsByName(e).length === 2 + s.getElementsByName(e + 0).length;
                          return vt = !s.getElementById(e), o.removeChild(n), t
                      });
                  try {
                      w.call(o.childNodes, 0)[0].nodeType
                  } catch (or) {
                      w = function (n) {
                          for (var t, i = []; t = this[n]; n++) i.push(t);
                          return i
                      }
                  }
                  r.matches = function (n, t) {
                      return r(n, null, null, t)
                  }, r.matchesSelector = function (n, t) {
                      return r(t, null, null, [n]).length > 0
                  }, tt = r.getText = function (n) {
                      var r, i = "",
                          u = 0,
                          t = n.nodeType;
                      if (t) {
                          if (t === 1 || t === 9 || t === 11) {
                              if (typeof n.textContent == "string") return n.textContent;
                              for (n = n.firstChild; n; n = n.nextSibling) i += tt(n)
                          } else if (t === 3 || t === 4) return n.nodeValue
                      } else
                          for (; r = n[u]; u++) i += tt(r);
                      return i
                  }, it = r.isXML = function (n) {
                      var t = n && (n.ownerDocument || n).documentElement;
                      return t ? t.nodeName !== "HTML" : !1
                  }, ni = r.contains = o.contains ? function (n, t) {
                      var r = n.nodeType === 9 ? n.documentElement : n,
                          i = t && t.parentNode;
                      return n === i || !!(i && i.nodeType === 1 && r.contains && r.contains(i))
                  } : o.compareDocumentPosition ? function (n, t) {
                      return t && !!(n.compareDocumentPosition(t) & 16)
                  } : function (n, t) {
                      while (t = t.parentNode)
                          if (t === n) return !0;
                      return !1
                  }, r.attr = function (n, t) {
                      var i, r = it(n);
                      return r || (t = t.toLowerCase()), (i = u.attrHandle[t]) ? i(n) : r || rr ? n.getAttribute(t) : (i = n.getAttributeNode(t), i ? typeof n[t] == "boolean" ? n[t] ? t : null : i.specified ? i.value : null : null)
                  }, u = r.selectors = {
                      cacheLength: 50,
                      createPseudo: h,
                      match: et,
                      attrHandle: ir ? {} : {
                          href: function (n) {
                              return n.getAttribute("href", 2)
                          },
                          type: function (n) {
                              return n.getAttribute("type")
                          }
                      },
                      find: {
                          ID: vt ? function (n, t, i) {
                              if (typeof t.getElementById !== c && !i) {
                                  var r = t.getElementById(n);
                                  return r && r.parentNode ? [r] : []
                              }
                          } : function (n, i, r) {
                              if (typeof i.getElementById !== c && !r) {
                                  var u = i.getElementById(n);
                                  return u ? u.id === n || typeof u.getAttributeNode !== c && u.getAttributeNode("id").value === n ? [u] : t : []
                              }
                          },
                          TAG: tr ? function (n, t) {
                              if (typeof t.getElementsByTagName !== c) return t.getElementsByTagName(n)
                          } : function (n, t) {
                              var f = t.getElementsByTagName(n),
                                  i, r, u;
                              if (n === "*") {
                                  for (r = [], u = 0; i = f[u]; u++) i.nodeType === 1 && r.push(i);
                                  return r
                              }
                              return f
                          },
                          NAME: ur && function (n, t) {
                              if (typeof t.getElementsByName !== c) return t.getElementsByName(name)
                          },
                          CLASS: hi && function (n, t, i) {
                              if (typeof t.getElementsByClassName !== c && !i) return t.getElementsByClassName(n)
                          }
                      },
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
                          ATTR: function (n) {
                              return n[1] = n[1].replace(y, ""), n[3] = (n[4] || n[5] || "").replace(y, ""), n[2] === "~=" && (n[3] = " " + n[3] + " "), n.slice(0, 4)
                          },
                          CHILD: function (n) {
                              return n[1] = n[1].toLowerCase(), n[1] === "nth" ? (n[2] || r.error(n[0]), n[3] = +(n[3] ? n[4] + (n[5] || 1) : 2 * (n[2] === "even" || n[2] === "odd")), n[4] = +(n[6] + n[7] || n[2] === "odd")) : n[2] && r.error(n[0]), n
                          },
                          PSEUDO: function (n) {
                              var t, i;
                              return et.CHILD.test(n[0]) ? null : (n[3] ? n[2] = n[3] : (t = n[4]) && (ki.test(t) && (i = g(t, !0)) && (i = t.indexOf(")", t.length - i) - t.length) && (t = t.slice(0, i), n[0] = n[0].slice(0, i)), n[2] = t), n.slice(0, 3))
                          }
                      },
                      filter: {
                          ID: vt ? function (n) {
                              return n = n.replace(y, ""),
                                  function (t) {
                                      return t.getAttribute("id") === n
                                  }
                          } : function (n) {
                              return n = n.replace(y, ""),
                                  function (t) {
                                      var i = typeof t.getAttributeNode !== c && t.getAttributeNode("id");
                                      return i && i.value === n
                                  }
                          },
                          TAG: function (n) {
                              return n === "*" ? function () {
                                  return !0
                              } : (n = n.replace(y, "").toLowerCase(), function (t) {
                                  return t.nodeName && t.nodeName.toLowerCase() === n
                              })
                          },
                          CLASS: function (n) {
                              var t = ui[e][n];
                              return t || (t = ui(n, new RegExp("(^|" + f + ")" + n + "(" + f + "|$)"))),
                                  function (n) {
                                      return t.test(n.className || typeof n.getAttribute !== c && n.getAttribute("class") || "")
                                  }
                          },
                          ATTR: function (n, t, i) {
                              return function (u) {
                                  var e = r.attr(u, n);
                                  return e == null ? t === "!=" : t ? (e += "", t === "=" ? e === i : t === "!=" ? e !== i : t === "^=" ? i && e.indexOf(i) === 0 : t === "*=" ? i && e.indexOf(i) > -1 : t === "$=" ? i && e.substr(e.length - i.length) === i : t === "~=" ? (" " + e + " ").indexOf(i) > -1 : t === "|=" ? e === i || e.substr(0, i.length + 1) === i + "-" : !1) : !0
                              }
                          },
                          CHILD: function (n, t, i, r) {
                              return n === "nth" ? function (n) {
                                  var t, u, f = n.parentNode;
                                  if (i === 1 && r === 0) return !0;
                                  if (f)
                                      for (u = 0, t = f.firstChild; t; t = t.nextSibling)
                                          if (t.nodeType === 1 && (u++, n === t)) break;
                                  return u -= r, u === i || u % i == 0 && u / i >= 0
                              } : function (t) {
                                  var i = t;
                                  switch (n) {
                                  case "only":
                                  case "first":
                                      while (i = i.previousSibling)
                                          if (i.nodeType === 1) return !1;
                                      if (n === "first") return !0;
                                      i = t;
                                  case "last":
                                      while (i = i.nextSibling)
                                          if (i.nodeType === 1) return !1;
                                      return !0
                                  }
                              }
                          },
                          PSEUDO: function (n, t) {
                              var f, i = u.pseudos[n] || u.setFilters[n.toLowerCase()] || r.error("unsupported pseudo: " + n);
                              return i[e] ? i(t) : i.length > 1 ? (f = [n, n, "", t], u.setFilters.hasOwnProperty(n.toLowerCase()) ? h(function (n, r) {
                                  for (var u, f = i(n, t), e = f.length; e--;) u = ri.call(n, f[e]), n[u] = !(r[u] = f[e])
                              }) : function (n) {
                                  return i(n, 0, f)
                              }) : i
                          }
                      },
                      pseudos: {
                          not: h(function (n) {
                              var i = [],
                                  r = [],
                                  t = yt(n.replace(ft, "$1"));
                              return t[e] ? h(function (n, i, r, u) {
                                  for (var e, o = t(n, null, u, []), f = n.length; f--;)(e = o[f]) && (n[f] = !(i[f] = e))
                              }) : function (n, u, f) {
                                  return i[0] = n, t(i, null, f, r), !r.pop()
                              }
                          }),
                          has: h(function (n) {
                              return function (t) {
                                  return r(n, t).length > 0
                              }
                          }),
                          contains: h(function (n) {
                              return function (t) {
                                  return (t.textContent || t.innerText || tt(t)).indexOf(n) > -1
                              }
                          }),
                          enabled: function (n) {
                              return n.disabled === !1
                          },
                          disabled: function (n) {
                              return n.disabled === !0
                          },
                          checked: function (n) {
                              var t = n.nodeName.toLowerCase();
                              return t === "input" && !!n.checked || t === "option" && !!n.selected
                          },
                          selected: function (n) {
                              return n.parentNode && n.parentNode.selectedIndex, n.selected === !0
                          },
                          parent: function (n) {
                              return !u.pseudos.empty(n)
                          },
                          empty: function (n) {
                              var t;
                              for (n = n.firstChild; n;) {
                                  if (n.nodeName > "@" || (t = n.nodeType) === 3 || t === 4) return !1;
                                  n = n.nextSibling
                              }
                              return !0
                          },
                          header: function (n) {
                              return gi.test(n.nodeName)
                          },
                          text: function (n) {
                              var t, i;
                              return n.nodeName.toLowerCase() === "input" && (t = n.type) === "text" && ((i = n.getAttribute("type")) == null || i.toLowerCase() === t)
                          },
                          radio: b("radio"),
                          checkbox: b("checkbox"),
                          file: b("file"),
                          password: b("password"),
                          image: b("image"),
                          submit: dt("submit"),
                          reset: dt("reset"),
                          button: function (n) {
                              var t = n.nodeName.toLowerCase();
                              return t === "input" && n.type === "button" || t === "button"
                          },
                          input: function (n) {
                              return nr.test(n.nodeName)
                          },
                          focus: function (n) {
                              var t = n.ownerDocument;
                              return n === t.activeElement && (!t.hasFocus || t.hasFocus()) && (!!n.type || !!n.href)
                          },
                          active: function (n) {
                              return n === n.ownerDocument.activeElement
                          },
                          first: a(function () {
                              return [0]
                          }),
                          last: a(function (n, t) {
                              return [t - 1]
                          }),
                          eq: a(function (n, t, i) {
                              return [i < 0 ? i + t : i]
                          }),
                          even: a(function (n, t) {
                              for (var r = 0; r < t; r += 2) n.push(r);
                              return n
                          }),
                          odd: a(function (n, t) {
                              for (var r = 1; r < t; r += 2) n.push(r);
                              return n
                          }),
                          lt: a(function (n, t, i) {
                              for (var r = i < 0 ? i + t : i; --r >= 0;) n.push(r);
                              return n
                          }),
                          gt: a(function (n, t, i) {
                              for (var r = i < 0 ? i + t : i; ++r < t;) n.push(r);
                              return n
                          })
                      }
                  }, pt = o.compareDocumentPosition ? function (n, t) {
                      return n === t ? (k = !0, 0) : (!n.compareDocumentPosition || !t.compareDocumentPosition ? n.compareDocumentPosition : n.compareDocumentPosition(t) & 4) ? -1 : 1
                  } : function (n, t) {
                      var i;
                      if (n === t) return k = !0, 0;
                      if (n.sourceIndex && t.sourceIndex) return n.sourceIndex - t.sourceIndex;
                      var e, h, u = [],
                          f = [],
                          o = n.parentNode,
                          s = t.parentNode,
                          r = o;
                      if (o === s) return d(n, t);
                      if (!o) return -1;
                      if (!s) return 1;
                      while (r) u.unshift(r), r = r.parentNode;
                      for (r = s; r;) f.unshift(r), r = r.parentNode;
                      for (e = u.length, h = f.length, i = 0; i < e && i < h; i++)
                          if (u[i] !== f[i]) return d(u[i], f[i]);
                      return i === e ? d(n, f[i], -1) : d(u[i], t, 1)
                  }, [0, 0].sort(pt), ti = !k, r.uniqueSort = function (n) {
                      var i, t = 1;
                      if (k = ti, n.sort(pt), k)
                          for (; i = n[t]; t++) i === n[t - 1] && n.splice(t--, 1);
                      return n
                  }, r.error = function (n) {
                      throw new Error("Syntax error, unrecognized expression: " + n);
                  }, yt = r.compile = function (n, t) {
                      var r, u = [],
                          f = [],
                          i = ei[e][n];
                      if (!i) {
                          for (t || (t = g(n)), r = t.length; r--;) i = ct(t[r]), i[e] ? u.push(i) : f.push(i);
                          i = ei(n, ci(f, u))
                      }
                      return i
                  }, s.querySelectorAll && function () {
                      var u, s = lt,
                          h = /'|\\/g,
                          c = /\=[\x20\t\r\n\f]*([^'"\]]*)[\x20\t\r\n\f]*\]/g,
                          n = [":focus"],
                          t = [":active", ":focus"],
                          i = o.matchesSelector || o.mozMatchesSelector || o.webkitMatchesSelector || o.oMatchesSelector || o.msMatchesSelector;
                      l(function (t) {
                          t.innerHTML = "<select><option selected=''><\/option><\/select>", t.querySelectorAll("[selected]").length || n.push("\\[" + f + "*(?:checked|disabled|ismap|multiple|readonly|selected|value)"), t.querySelectorAll(":checked").length || n.push(":checked")
                      }), l(function (t) {
                          t.innerHTML = "<p test=''><\/p>", t.querySelectorAll("[test^='']").length && n.push("[*^$]=" + f + "*(?:\"\"|'')"), t.innerHTML = "<input type='hidden'/>", t.querySelectorAll(":enabled").length || n.push(":enabled", ":disabled")
                      }), n = new RegExp(n.join("|")), lt = function (t, i, r, u, f) {
                          if (!u && !f && (!n || !n.test(t))) {
                              var o, l, a = !0,
                                  c = e,
                                  y = i,
                                  v = i.nodeType === 9 && t;
                              if (i.nodeType === 1 && i.nodeName.toLowerCase() !== "object") {
                                  for (o = g(t), (a = i.getAttribute("id")) ? c = a.replace(h, "\\$&") : i.setAttribute("id", c), c = "[id='" + c + "'] ", l = o.length; l--;) o[l] = c + o[l].join("");
                                  y = kt.test(t) && i.parentNode || i, v = o.join(",")
                              }
                              if (v) try {
                                  return p.apply(r, w.call(y.querySelectorAll(v), 0)), r
                              } catch (b) {} finally {
                                  a || i.removeAttribute("id")
                              }
                          }
                          return s(t, i, r, u, f)
                      }, i && (l(function (n) {
                          u = i.call(n, "div");
                          try {
                              i.call(n, "[test!='']:sizzle"), t.push("!=", bt)
                          } catch (r) {}
                      }), t = new RegExp(t.join("|")), r.matchesSelector = function (f, e) {
                          if (e = e.replace(c, "='$1']"), !it(f) && !t.test(e) && (!n || !n.test(e))) try {
                              var o = i.call(f, e);
                              if (o || u || f.document && f.document.nodeType !== 11) return o
                          } catch (s) {}
                          return r(e, null, null, [f]).length > 0
                      })
                  }(), u.pseudos.nth = u.pseudos.eq, u.filters = gt.prototype = u.pseudos, u.setFilters = new gt, r.attr = i.attr, i.find = r, i.expr = r.selectors, i.expr[":"] = i.expr.pseudos, i.unique = r.uniqueSort, i.text = r.getText, i.isXMLDoc = r.isXML, i.contains = r.contains
              }(n);
          var re = /Until$/,
              ue = /^(?:parents|prev(?:Until|All))/,
              fe = /^.[^:#\[\.,]*$/,
              br = i.expr.match.needsContext,
              ee = {
                  children: !0,
                  contents: !0,
                  next: !0,
                  prev: !0
              };
          i.fn.extend({
              find: function (n) {
                  var t, f, o, u, e, r, s = this;
                  if (typeof n != "string") return i(n).filter(function () {
                      for (t = 0, f = s.length; t < f; t++)
                          if (i.contains(s[t], this)) return !0
                  });
                  for (r = this.pushStack("", "find", n), t = 0, f = this.length; t < f; t++)
                      if (o = r.length, i.find(n, this[t], r), t > 0)
                          for (u = o; u < r.length; u++)
                              for (e = 0; e < o; e++)
                                  if (r[e] === r[u]) {
                                      r.splice(u--, 1);
                                      break
                                  }
                  return r
              },
              has: function (n) {
                  var t, r = i(n, this),
                      u = r.length;
                  return this.filter(function () {
                      for (t = 0; t < u; t++)
                          if (i.contains(this, r[t])) return !0
                  })
              },
              not: function (n) {
                  return this.pushStack(ei(this, n, !1), "not", n)
              },
              filter: function (n) {
                  return this.pushStack(ei(this, n, !0), "filter", n)
              },
              is: function (n) {
                  return !!n && (typeof n == "string" ? br.test(n) ? i(n, this.context).index(this[0]) >= 0 : i.filter(n, this).length > 0 : this.filter(n).length > 0)
              },
              closest: function (n, t) {
                  for (var r, f = 0, o = this.length, u = [], e = br.test(n) || typeof n != "string" ? i(n, t || this.context) : 0; f < o; f++)
                      for (r = this[f]; r && r.ownerDocument && r !== t && r.nodeType !== 11;) {
                          if (e ? e.index(r) > -1 : i.find.matchesSelector(r, n)) {
                              u.push(r);
                              break
                          }
                          r = r.parentNode
                      }
                  return u = u.length > 1 ? i.unique(u) : u, this.pushStack(u, "closest", n)
              },
              index: function (n) {
                  return n ? typeof n == "string" ? i.inArray(this[0], i(n)) : i.inArray(n.jquery ? n[0] : n, this) : this[0] && this[0].parentNode ? this.prevAll().length : -1
              },
              add: function (n, t) {
                  var u = typeof n == "string" ? i(n, t) : i.makeArray(n && n.nodeType ? [n] : n),
                      r = i.merge(this.get(), u);
                  return this.pushStack(b(u[0]) || b(r[0]) ? r : i.unique(r))
              },
              addBack: function (n) {
                  return this.add(n == null ? this.prevObject : this.prevObject.filter(n))
              }
          }), i.fn.andSelf = i.fn.addBack, i.each({
              parent: function (n) {
                  var t = n.parentNode;
                  return t && t.nodeType !== 11 ? t : null
              },
              parents: function (n) {
                  return i.dir(n, "parentNode")
              },
              parentsUntil: function (n, t, r) {
                  return i.dir(n, "parentNode", r)
              },
              next: function (n) {
                  return fi(n, "nextSibling")
              },
              prev: function (n) {
                  return fi(n, "previousSibling")
              },
              nextAll: function (n) {
                  return i.dir(n, "nextSibling")
              },
              prevAll: function (n) {
                  return i.dir(n, "previousSibling")
              },
              nextUntil: function (n, t, r) {
                  return i.dir(n, "nextSibling", r)
              },
              prevUntil: function (n, t, r) {
                  return i.dir(n, "previousSibling", r)
              },
              siblings: function (n) {
                  return i.sibling((n.parentNode || {}).firstChild, n)
              },
              children: function (n) {
                  return i.sibling(n.firstChild)
              },
              contents: function (n) {
                  return i.nodeName(n, "iframe") ? n.contentDocument || n.contentWindow.document : i.merge([], n.childNodes)
              }
          }, function (n, t) {
              i.fn[n] = function (r, u) {
                  var f = i.map(this, t, r);
                  return re.test(n) || (u = r), u && typeof u == "string" && (f = i.filter(u, f)), f = this.length > 1 && !ee[n] ? i.unique(f) : f, this.length > 1 && ue.test(n) && (f = f.reverse()), this.pushStack(f, n, o.call(arguments).join(","))
              }
          }), i.extend({
              filter: function (n, t, r) {
                  return r && (n = ":not(" + n + ")"), t.length === 1 ? i.find.matchesSelector(t[0], n) ? [t[0]] : [] : i.find.matches(n, t)
              },
              dir: function (n, r, u) {
                  for (var e = [], f = n[r]; f && f.nodeType !== 9 && (u === t || f.nodeType !== 1 || !i(f).is(u));) f.nodeType === 1 && e.push(f), f = f[r];
                  return e
              },
              sibling: function (n, t) {
                  for (var i = []; n; n = n.nextSibling) n.nodeType === 1 && n !== t && i.push(n);
                  return i
              }
          });
          var kr = "abbr|article|aside|audio|bdi|canvas|data|datalist|details|figcaption|figure|footer|header|hgroup|mark|meter|nav|output|progress|section|summary|time|video",
              oe = / jQuery\d+="(?:null|\d+)"/g,
              kt = /^\s+/,
              dr = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,
              gr = /<([\w:]+)/,
              se = /<tbody/i,
              he = /<|&#?\w+;/,
              ce = /<(?:script|style|link)/i,
              le = /<(?:script|object|embed|option|style)/i,
              dt = new RegExp("<(?:" + kr + ")[\\s/>]", "i"),
              nu = /^(?:checkbox|radio)$/,
              tu = /checked\s*(?:[^=]|=\s*.checked.)/i,
              ae = /\/(java|ecma)script/i,
              ve = /^\s*<!(?:\[CDATA\[|\-\-)|[\]\-]{2}>\s*$/g,
              e = {
                  option: [1, "<select multiple='multiple'>", "<\/select>"],
                  legend: [1, "<fieldset>", "<\/fieldset>"],
                  thead: [1, "<table>", "<\/table>"],
                  tr: [2, "<table><tbody>", "<\/tbody><\/table>"],
                  td: [3, "<table><tbody><tr>", "<\/tr><\/tbody><\/table>"],
                  col: [2, "<table><tbody><\/tbody><colgroup>", "<\/colgroup><\/table>"],
                  area: [1, "<map>", "<\/map>"],
                  _default: [0, "", ""]
              },
              iu = oi(r),
              gt = iu.appendChild(r.createElement("div"));
          e.optgroup = e.option, e.tbody = e.tfoot = e.colgroup = e.caption = e.thead, e.th = e.td, i.support.htmlSerialize || (e._default = [1, "X<div>", "<\/div>"]), i.fn.extend({
                  text: function (n) {
                      return i.access(this, function (n) {
                          return n === t ? i.text(this) : this.empty().append((this[0] && this[0].ownerDocument || r).createTextNode(n))
                      }, null, n, arguments.length)
                  },
                  wrapAll: function (n) {
                      if (i.isFunction(n)) return this.each(function (t) {
                          i(this).wrapAll(n.call(this, t))
                      });
                      if (this[0]) {
                          var t = i(n, this[0].ownerDocument).eq(0).clone(!0);
                          this[0].parentNode && t.insertBefore(this[0]), t.map(function () {
                              for (var n = this; n.firstChild && n.firstChild.nodeType === 1;) n = n.firstChild;
                              return n
                          }).append(this)
                      }
                      return this
                  },
                  wrapInner: function (n) {
                      return i.isFunction(n) ? this.each(function (t) {
                          i(this).wrapInner(n.call(this, t))
                      }) : this.each(function () {
                          var t = i(this),
                              r = t.contents();
                          r.length ? r.wrapAll(n) : t.append(n)
                      })
                  },
                  wrap: function (n) {
                      var t = i.isFunction(n);
                      return this.each(function (r) {
                          i(this).wrapAll(t ? n.call(this, r) : n)
                      })
                  },
                  unwrap: function () {
                      return this.parent().each(function () {
                          i.nodeName(this, "body") || i(this).replaceWith(this.childNodes)
                      }).end()
                  },
                  append: function () {
                      return this.domManip(arguments, !0, function (n) {
                          (this.nodeType === 1 || this.nodeType === 11) && this.appendChild(n)
                      })
                  },
                  prepend: function () {
                      return this.domManip(arguments, !0, function (n) {
                          (this.nodeType === 1 || this.nodeType === 11) && this.insertBefore(n, this.firstChild)
                      })
                  },
                  before: function () {
                      if (!b(this[0])) return this.domManip(arguments, !1, function (n) {
                          this.parentNode.insertBefore(n, this)
                      });
                      if (arguments.length) {
                          var n = i.clean(arguments);
                          return this.pushStack(i.merge(n, this), "before", this.selector)
                      }
                  },
                  after: function () {
                      if (!b(this[0])) return this.domManip(arguments, !1, function (n) {
                          this.parentNode.insertBefore(n, this.nextSibling)
                      });
                      if (arguments.length) {
                          var n = i.clean(arguments);
                          return this.pushStack(i.merge(this, n), "after", this.selector)
                      }
                  },
                  remove: function (n, t) {
                      for (var r, u = 0;
                          (r = this[u]) != null; u++)(!n || i.filter(n, [r]).length) && (t || r.nodeType !== 1 || (i.cleanData(r.getElementsByTagName("*")), i.cleanData([r])), r.parentNode && r.parentNode.removeChild(r));
                      return this
                  },
                  empty: function () {
                      for (var n, t = 0;
                          (n = this[t]) != null; t++)
                          for (n.nodeType === 1 && i.cleanData(n.getElementsByTagName("*")); n.firstChild;) n.removeChild(n.firstChild);
                      return this
                  },
                  clone: function (n, t) {
                      return n = n == null ? !1 : n, t = t == null ? n : t, this.map(function () {
                          return i.clone(this, n, t)
                      })
                  },
                  html: function (n) {
                      return i.access(this, function (n) {
                          var r = this[0] || {},
                              u = 0,
                              f = this.length;
                          if (n === t) return r.nodeType === 1 ? r.innerHTML.replace(oe, "") : t;
                          if (typeof n == "string" && !ce.test(n) && (i.support.htmlSerialize || !dt.test(n)) && (i.support.leadingWhitespace || !kt.test(n)) && !e[(gr.exec(n) || ["", ""])[1].toLowerCase()]) {
                              n = n.replace(dr, "<$1><\/$2>");
                              try {
                                  for (; u < f; u++) r = this[u] || {}, r.nodeType === 1 && (i.cleanData(r.getElementsByTagName("*")), r.innerHTML = n);
                                  r = 0
                              } catch (o) {}
                          }
                          r && this.empty().append(n)
                      }, null, n, arguments.length)
                  },
                  replaceWith: function (n) {
                      return b(this[0]) ? this.length ? this.pushStack(i(i.isFunction(n) ? n() : n), "replaceWith", n) : this : i.isFunction(n) ? this.each(function (t) {
                          var r = i(this),
                              u = r.html();
                          r.replaceWith(n.call(this, t, u))
                      }) : (typeof n != "string" && (n = i(n).detach()), this.each(function () {
                          var t = this.nextSibling,
                              r = this.parentNode;
                          i(this).remove(), t ? i(t).before(n) : i(r).append(n)
                      }))
                  },
                  detach: function (n) {
                      return this.remove(n, !0)
                  },
                  domManip: function (n, r, u) {
                      n = [].concat.apply([], n);
                      var h, o, f, a, e = 0,
                          s = n[0],
                          c = [],
                          l = this.length;
                      if (!i.support.checkClone && l > 1 && typeof s == "string" && tu.test(s)) return this.each(function () {
                          i(this).domManip(n, r, u)
                      });
                      if (i.isFunction(s)) return this.each(function (f) {
                          var e = i(this);
                          n[0] = s.call(this, f, r ? e.html() : t), e.domManip(n, r, u)
                      });
                      if (this[0]) {
                          if (h = i.buildFragment(n, this, c), f = h.fragment, o = f.firstChild, f.childNodes.length === 1 && (f = o), o)
                              for (r = r && i.nodeName(o, "tr"), a = h.cacheable || l - 1; e < l; e++) u.call(r && i.nodeName(this[e], "table") ? pu(this[e], "tbody") : this[e], e === a ? f : i.clone(f, !0, !0));
                          f = o = null, c.length && i.each(c, function (n, t) {
                              t.src ? i.ajax ? i.ajax({
                                  url: t.src,
                                  type: "GET",
                                  dataType: "script",
                                  async: !1,
                                  global: !1,
                                  throws: !0
                              }) : i.error("no ajax") : i.globalEval((t.text || t.textContent || t.innerHTML || "").replace(ve, "")), t.parentNode && t.parentNode.removeChild(t)
                          })
                      }
                      return this
                  }
              }), i.buildFragment = function (n, u, f) {
                  var o, s, h, e = n[0];
                  return u = u || r, u = !u.nodeType && u[0] || u, u = u.ownerDocument || u, n.length === 1 && typeof e == "string" && e.length < 512 && u === r && e.charAt(0) === "<" && !le.test(e) && (i.support.checkClone || !tu.test(e)) && (i.support.html5Clone || !dt.test(e)) && (s = !0, o = i.fragments[e], h = o !== t), o || (o = u.createDocumentFragment(), i.clean(n, u, o, f), s && (i.fragments[e] = h && o)), {
                      fragment: o,
                      cacheable: s
                  }
              }, i.fragments = {}, i.each({
                  appendTo: "append",
                  prependTo: "prepend",
                  insertBefore: "before",
                  insertAfter: "after",
                  replaceAll: "replaceWith"
              }, function (n, t) {
                  i.fn[n] = function (r) {
                      var o, u = 0,
                          s = [],
                          f = i(r),
                          h = f.length,
                          e = this.length === 1 && this[0].parentNode;
                      if ((e == null || e && e.nodeType === 11 && e.childNodes.length === 1) && h === 1) return f[t](this[0]), this;
                      for (; u < h; u++) o = (u > 0 ? this.clone(!0) : this).get(), i(f[u])[t](o), s = s.concat(o);
                      return this.pushStack(s, n, f.selector)
                  }
              }), i.extend({
                  clone: function (n, t, r) {
                      var f, o, u, e;
                      if (i.support.html5Clone || i.isXMLDoc(n) || !dt.test("<" + n.nodeName + ">") ? e = n.cloneNode(!0) : (gt.innerHTML = n.outerHTML, gt.removeChild(e = gt.firstChild)), (!i.support.noCloneEvent || !i.support.noCloneChecked) && (n.nodeType === 1 || n.nodeType === 11) && !i.isXMLDoc(n))
                          for (hi(n, e), f = g(n), o = g(e), u = 0; f[u]; ++u) o[u] && hi(f[u], o[u]);
                      if (t && (si(n, e), r))
                          for (f = g(n), o = g(e), u = 0; f[u]; ++u) si(f[u], o[u]);
                      return f = o = null, e
                  },
                  clean: function (n, t, u, f) {
                      var h, c, o, p, v, d, s, w, a, g, b, k, y = t === r && iu,
                          l = [];
                      for (t && typeof t.createDocumentFragment != "undefined" || (t = r), h = 0;
                          (o = n[h]) != null; h++)
                          if (typeof o == "number" && (o += ""), o) {
                              if (typeof o == "string")
                                  if (he.test(o)) {
                                      for (y = y || oi(t), s = t.createElement("div"), y.appendChild(s), o = o.replace(dr, "<$1><\/$2>"), p = (gr.exec(o) || ["", ""])[1].toLowerCase(), v = e[p] || e._default, d = v[0], s.innerHTML = v[1] + o + v[2]; d--;) s = s.lastChild;
                                      if (!i.support.tbody)
                                          for (w = se.test(o), a = p === "table" && !w ? s.firstChild && s.firstChild.childNodes : v[1] === "<table>" && !w ? s.childNodes : [], c = a.length - 1; c >= 0; --c) i.nodeName(a[c], "tbody") && !a[c].childNodes.length && a[c].parentNode.removeChild(a[c]);
                                      !i.support.leadingWhitespace && kt.test(o) && s.insertBefore(t.createTextNode(kt.exec(o)[0]), s.firstChild), o = s.childNodes, s.parentNode.removeChild(s)
                                  } else o = t.createTextNode(o);
                              o.nodeType ? l.push(o) : i.merge(l, o)
                          }
                      if (s && (o = s = y = null), !i.support.appendChecked)
                          for (h = 0;
                              (o = l[h]) != null; h++) i.nodeName(o, "input") ? ci(o) : typeof o.getElementsByTagName != "undefined" && i.grep(o.getElementsByTagName("input"), ci);
                      if (u)
                          for (b = function (n) {
                                  if (!n.type || ae.test(n.type)) return f ? f.push(n.parentNode ? n.parentNode.removeChild(n) : n) : u.appendChild(n)
                              }, h = 0;
                              (o = l[h]) != null; h++) i.nodeName(o, "script") && b(o) || (u.appendChild(o), typeof o.getElementsByTagName != "undefined" && (k = i.grep(i.merge([], o.getElementsByTagName("script")), b), l.splice.apply(l, [h + 1, 0].concat(k)), h += k.length));
                      return l
                  },
                  cleanData: function (n, t) {
                      for (var f, u, r, e, h = 0, o = i.expando, s = i.cache, c = i.support.deleteExpando, l = i.event.special;
                          (r = n[h]) != null; h++)
                          if ((t || i.acceptData(r)) && (u = r[o], f = u && s[u], f)) {
                              if (f.events)
                                  for (e in f.events) l[e] ? i.event.remove(r, e) : i.removeEvent(r, e, f.handle);
                              s[u] && (delete s[u], c ? delete r[o] : r.removeAttribute ? r.removeAttribute(o) : r[o] = null, i.deletedIds.push(u))
                          }
                  }
              }),
              function () {
                  var t, n;
                  i.uaMatch = function (n) {
                      n = n.toLowerCase();
                      var t = /(chrome)[ \/]([\w.]+)/.exec(n) || /(webkit)[ \/]([\w.]+)/.exec(n) || /(opera)(?:.*version|)[ \/]([\w.]+)/.exec(n) || /(msie) ([\w.]+)/.exec(n) || n.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec(n) || [];
                      return {
                          browser: t[1] || "",
                          version: t[2] || "0"
                      }
                  }, t = i.uaMatch(rf.userAgent), n = {}, t.browser && (n[t.browser] = !0, n.version = t.version), n.chrome ? n.webkit = !0 : n.webkit && (n.safari = !0), i.browser = n, i.sub = function () {
                      function n(t, i) {
                          return new n.fn.init(t, i)
                      }
                      i.extend(!0, n, this), n.superclass = this, n.fn = n.prototype = this(), n.fn.constructor = n, n.sub = this.sub, n.fn.init = function t(c, r) {
                          return r && r instanceof i && !(r instanceof n) && (r = n(r)), i.fn.init.call(this, t, r, u)
                      }, n.fn.init.prototype = n.fn;
                      var u = n(r);
                      return n
                  }
              }();
          var u, v, y, ni = /alpha\([^)]*\)/i,
              ye = /opacity=([^)]*)/,
              pe = /^(top|right|bottom|left)$/,
              we = /^(none|table(?!-c[ea]).+)/,
              ru = /^margin/,
              be = new RegExp("^(" + ut + ")(.*)$", "i"),
              et = new RegExp("^(" + ut + ")(?!px)[a-z%]+$", "i"),
              ke = new RegExp("^([-+])=(" + ut + ")", "i"),
              ti = {},
              de = {
                  position: "absolute",
                  visibility: "hidden",
                  display: "block"
              },
              uu = {
                  letterSpacing: 0,
                  fontWeight: 400
              },
              c = ["Top", "Right", "Bottom", "Left"],
              fu = ["Webkit", "O", "Moz", "ms"],
              ge = i.fn.toggle;
          i.fn.extend({
              css: function (n, r) {
                  return i.access(this, function (n, r, u) {
                      return u !== t ? i.style(n, r, u) : i.css(n, r)
                  }, n, r, arguments.length > 1)
              },
              show: function () {
                  return ai(this, !0)
              },
              hide: function () {
                  return ai(this)
              },
              toggle: function (n, t) {
                  var r = typeof n == "boolean";
                  return i.isFunction(n) && i.isFunction(t) ? ge.apply(this, arguments) : this.each(function () {
                      (r ? n : nt(this)) ? i(this).show(): i(this).hide()
                  })
              }
          }), i.extend({
              cssHooks: {
                  opacity: {
                      get: function (n, t) {
                          if (t) {
                              var i = u(n, "opacity");
                              return i === "" ? "1" : i
                          }
                      }
                  }
              },
              cssNumber: {
                  fillOpacity: !0,
                  fontWeight: !0,
                  lineHeight: !0,
                  opacity: !0,
                  orphans: !0,
                  widows: !0,
                  zIndex: !0,
                  zoom: !0
              },
              cssProps: {
                  float: i.support.cssFloat ? "cssFloat" : "styleFloat"
              },
              style: function (n, r, u, f) {
                  if (n && n.nodeType !== 3 && n.nodeType !== 8 && n.style) {
                      var o, s, e, h = i.camelCase(r),
                          c = n.style;
                      if (r = i.cssProps[h] || (i.cssProps[h] = li(c, h)), e = i.cssHooks[r] || i.cssHooks[h], u === t) return e && "get" in e && (o = e.get(n, !1, f)) !== t ? o : c[r];
                      if ((s = typeof u, s === "string" && (o = ke.exec(u)) && (u = (o[1] + 1) * o[2] + parseFloat(i.css(n, r)), s = "number"), u != null && (s !== "number" || !isNaN(u))) && (s !== "number" || i.cssNumber[h] || (u += "px"), !e || !("set" in e) || (u = e.set(n, u, f)) !== t)) try {
                          c[r] = u
                      } catch (l) {}
                  }
              },
              css: function (n, r, f, e) {
                  var o, c, s, h = i.camelCase(r);
                  return r = i.cssProps[h] || (i.cssProps[h] = li(n.style, h)), s = i.cssHooks[r] || i.cssHooks[h], s && "get" in s && (o = s.get(n, !0, e)), o === t && (o = u(n, r)), o === "normal" && r in uu && (o = uu[r]), f || e !== t ? (c = parseFloat(o), f || i.isNumeric(c) ? c || 0 : o) : o
              },
              swap: function (n, t, i) {
                  var u, r, f = {};
                  for (r in t) f[r] = n.style[r], n.style[r] = t[r];
                  u = i.call(n);
                  for (r in t) n.style[r] = f[r];
                  return u
              }
          }), n.getComputedStyle ? u = function (t, r) {
              var f, o, s, h, e = n.getComputedStyle(t, null),
                  u = t.style;
              return e && (f = e[r], f === "" && !i.contains(t.ownerDocument, t) && (f = i.style(t, r)), et.test(f) && ru.test(r) && (o = u.width, s = u.minWidth, h = u.maxWidth, u.minWidth = u.maxWidth = u.width = f, f = e.width, u.width = o, u.minWidth = s, u.maxWidth = h)), f
          } : r.documentElement.currentStyle && (u = function (n, t) {
              var f, u, i = n.currentStyle && n.currentStyle[t],
                  r = n.style;
              return i == null && r && r[t] && (i = r[t]), et.test(i) && !pe.test(t) && (f = r.left, u = n.runtimeStyle && n.runtimeStyle.left, u && (n.runtimeStyle.left = n.currentStyle.left), r.left = t === "fontSize" ? "1em" : i, i = r.pixelLeft + "px", r.left = f, u && (n.runtimeStyle.left = u)), i === "" ? "auto" : i
          }), i.each(["height", "width"], function (n, t) {
              i.cssHooks[t] = {
                  get: function (n, r, f) {
                      if (r) return n.offsetWidth === 0 && we.test(u(n, "display")) ? i.swap(n, de, function () {
                          return pi(n, t, f)
                      }) : pi(n, t, f)
                  },
                  set: function (n, r, u) {
                      return vi(n, r, u ? yi(n, t, u, i.support.boxSizing && i.css(n, "boxSizing") === "border-box") : 0)
                  }
              }
          }), i.support.opacity || (i.cssHooks.opacity = {
              get: function (n, t) {
                  return ye.test((t && n.currentStyle ? n.currentStyle.filter : n.style.filter) || "") ? .01 * parseFloat(RegExp.$1) + "" : t ? "1" : ""
              },
              set: function (n, t) {
                  var r = n.style,
                      u = n.currentStyle,
                      e = i.isNumeric(t) ? "alpha(opacity=" + t * 100 + ")" : "",
                      f = u && u.filter || r.filter || "";
                  (r.zoom = 1, t >= 1 && i.trim(f.replace(ni, "")) === "" && r.removeAttribute && (r.removeAttribute("filter"), u && !u.filter)) || (r.filter = ni.test(f) ? f.replace(ni, e) : f + " " + e)
              }
          }), i(function () {
              i.support.reliableMarginRight || (i.cssHooks.marginRight = {
                  get: function (n, t) {
                      return i.swap(n, {
                          display: "inline-block"
                      }, function () {
                          if (t) return u(n, "marginRight")
                      })
                  }
              }), !i.support.pixelPosition && i.fn.position && i.each(["top", "left"], function (n, t) {
                  i.cssHooks[t] = {
                      get: function (n, r) {
                          if (r) {
                              var f = u(n, t);
                              return et.test(f) ? i(n).position()[t] + "px" : f
                          }
                      }
                  }
              })
          }), i.expr && i.expr.filters && (i.expr.filters.hidden = function (n) {
              return n.offsetWidth === 0 && n.offsetHeight === 0 || !i.support.reliableHiddenOffsets && (n.style && n.style.display || u(n, "display")) === "none"
          }, i.expr.filters.visible = function (n) {
              return !i.expr.filters.hidden(n)
          }), i.each({
              margin: "",
              padding: "",
              border: "Width"
          }, function (n, t) {
              i.cssHooks[n + t] = {
                  expand: function (i) {
                      for (var u = typeof i == "string" ? i.split(" ") : [i], f = {}, r = 0; r < 4; r++) f[n + c[r] + t] = u[r] || u[r - 2] || u[0];
                      return f
                  }
              }, ru.test(n) || (i.cssHooks[n + t].set = vi)
          });
          var no = /%20/g,
              to = /\[\]$/,
              eu = /\r?\n/g,
              io = /^(?:color|date|datetime|datetime-local|email|hidden|month|number|password|range|search|tel|text|time|url|week)$/i,
              ro = /^(?:select|textarea)/i;
          i.fn.extend({
              serialize: function () {
                  return i.param(this.serializeArray())
              },
              serializeArray: function () {
                  return this.map(function () {
                      return this.elements ? i.makeArray(this.elements) : this
                  }).filter(function () {
                      return this.name && !this.disabled && (this.checked || ro.test(this.nodeName) || io.test(this.type))
                  }).map(function (n, t) {
                      var r = i(this).val();
                      return r == null ? null : i.isArray(r) ? i.map(r, function (n) {
                          return {
                              name: t.name,
                              value: n.replace(eu, "\r\n")
                          }
                      }) : {
                          name: t.name,
                          value: r.replace(eu, "\r\n")
                      }
                  }).get()
              }
          }), i.param = function (n, r) {
              var u, f = [],
                  e = function (n, t) {
                      t = i.isFunction(t) ? t() : t == null ? "" : t, f[f.length] = encodeURIComponent(n) + "=" + encodeURIComponent(t)
                  };
              if (r === t && (r = i.ajaxSettings && i.ajaxSettings.traditional), i.isArray(n) || n.jquery && !i.isPlainObject(n)) i.each(n, function () {
                  e(this.name, this.value)
              });
              else
                  for (u in n) vt(u, n[u], r, e);
              return f.join("&").replace(no, "+")
          };
          var p, l, uo = /#.*$/,
              fo = /^(.*?):[ \t]*([^\r\n]*)\r?$/mg,
              eo = /^(?:about|app|app\-storage|.+\-extension|file|res|widget):$/,
              oo = /^(?:GET|HEAD)$/,
              so = /^\/\//,
              ou = /\?/,
              ho = /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi,
              co = /([?&])_=[^&]*/,
              su = /^([\w\+\.\-]+:)(?:\/\/([^\/?#:]*)(?::(\d+)|)|)/,
              hu = i.fn.load,
              ii = {},
              cu = {},
              lu = ["*/"] + ["*"];
          try {
              l = tf.href
          } catch (wo) {
              l = r.createElement("a"), l.href = "", l = l.href
          }
          p = su.exec(l.toLowerCase()) || [], i.fn.load = function (n, r, u) {
              if (typeof n != "string" && hu) return hu.apply(this, arguments);
              if (!this.length) return this;
              var f, o, s, h = this,
                  e = n.indexOf(" ");
              return e >= 0 && (f = n.slice(e, n.length), n = n.slice(0, e)), i.isFunction(r) ? (u = r, r = t) : r && typeof r == "object" && (o = "POST"), i.ajax({
                  url: n,
                  type: o,
                  dataType: "html",
                  data: r,
                  complete: function (n, t) {
                      u && h.each(u, s || [n.responseText, t, n])
                  }
              }).done(function (n) {
                  s = arguments, h.html(f ? i("<div>").append(n.replace(ho, "")).find(f) : n)
              }), this
          }, i.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "), function (n, t) {
              i.fn[t] = function (n) {
                  return this.on(t, n)
              }
          }), i.each(["get", "post"], function (n, r) {
              i[r] = function (n, u, f, e) {
                  return i.isFunction(u) && (e = e || f, f = u, u = t), i.ajax({
                      type: r,
                      url: n,
                      data: u,
                      success: f,
                      dataType: e
                  })
              }
          }), i.extend({
              getScript: function (n, r) {
                  return i.get(n, t, r, "script")
              },
              getJSON: function (n, t, r) {
                  return i.get(n, t, r, "json")
              },
              ajaxSetup: function (n, t) {
                  return t ? ki(n, i.ajaxSettings) : (t = n, n = i.ajaxSettings), ki(n, t), n
              },
              ajaxSettings: {
                  url: l,
                  isLocal: eo.test(p[1]),
                  global: !0,
                  type: "GET",
                  contentType: "application/x-www-form-urlencoded; charset=UTF-8",
                  processData: !0,
                  async: !0,
                  accepts: {
                      xml: "application/xml, text/xml",
                      html: "text/html",
                      text: "text/plain",
                      json: "application/json, text/javascript",
                      "*": lu
                  },
                  contents: {
                      xml: /xml/,
                      html: /html/,
                      json: /json/
                  },
                  responseFields: {
                      xml: "responseXML",
                      text: "responseText"
                  },
                  converters: {
                      "* text": n.String,
                      "text html": !0,
                      "text json": i.parseJSON,
                      "text xml": i.parseXML
                  },
                  flatOptions: {
                      context: !0,
                      url: !0
                  }
              },
              ajaxPrefilter: bi(ii),
              ajaxTransport: bi(cu),
              ajax: function (n, r) {
                  function y(n, r, h, l) {
                      var a, tt, w, it, p, y = r;
                      e !== 2 && (e = 2, d && clearTimeout(d), c = t, k = l || "", f.readyState = n > 0 ? 4 : 0, h && (it = wu(u, f, h)), n >= 200 && n < 300 || n === 304 ? (u.ifModified && (p = f.getResponseHeader("Last-Modified"), p && (i.lastModified[o] = p), p = f.getResponseHeader("Etag"), p && (i.etag[o] = p)), n === 304 ? (y = "notmodified", a = !0) : (a = bu(u, it), y = a.state, tt = a.data, w = a.error, a = !w)) : (w = y, (!y || n) && (y = "error", n < 0 && (n = 0))), f.status = n, f.statusText = (r || y) + "", a ? nt.resolveWith(s, [tt, y, f]) : nt.rejectWith(s, [f, y, w]), f.statusCode(b), b = t, v && g.trigger("ajax" + (a ? "Success" : "Error"), [f, u, a ? tt : w]), ut.fireWith(s, [f, y]), v && (g.trigger("ajaxComplete", [f, u]), --i.active || i.event.trigger("ajaxStop")))
                  }
                  var it, rt;
                  typeof n == "object" && (r = n, n = t), r = r || {};
                  var o, k, w, c, d, a, v, l, u = i.ajaxSetup({}, r),
                      s = u.context || u,
                      g = s !== u && (s.nodeType || s instanceof i) ? i(s) : i.event,
                      nt = i.Deferred(),
                      ut = i.Callbacks("once memory"),
                      b = u.statusCode || {},
                      ft = {},
                      et = {},
                      e = 0,
                      ot = "canceled",
                      f = {
                          readyState: 0,
                          setRequestHeader: function (n, t) {
                              if (!e) {
                                  var i = n.toLowerCase();
                                  n = et[i] = et[i] || n, ft[n] = t
                              }
                              return this
                          },
                          getAllResponseHeaders: function () {
                              return e === 2 ? k : null
                          },
                          getResponseHeader: function (n) {
                              var i;
                              if (e === 2) {
                                  if (!w)
                                      for (w = {}; i = fo.exec(k);) w[i[1].toLowerCase()] = i[2];
                                  i = w[n.toLowerCase()]
                              }
                              return i === t ? null : i
                          },
                          overrideMimeType: function (n) {
                              return e || (u.mimeType = n), this
                          },
                          abort: function (n) {
                              return n = n || ot, c && c.abort(n), y(0, n), this
                          }
                      };
                  if (nt.promise(f), f.success = f.done, f.error = f.fail, f.complete = ut.add, f.statusCode = function (n) {
                      if (n) {
                          var t;
                          if (e < 2)
                              for (t in n) b[t] = [b[t], n[t]];
                          else t = n[f.status], f.always(t)
                      }
                      return this
                  }, u.url = ((n || u.url) + "").replace(uo, "").replace(so, p[1] + "//"), u.dataTypes = i.trim(u.dataType || "*").toLowerCase().split(h), u.crossDomain == null && (a = su.exec(u.url.toLowerCase()) || !1, u.crossDomain = a && a.join(":") + (a[3] ? "" : a[1] === "http:" ? 80 : 443) !== p.join(":") + (p[3] ? "" : p[1] === "http:" ? 80 : 443)), u.data && u.processData && typeof u.data != "string" && (u.data = i.param(u.data, u.traditional)), tt(ii, u, r, f), e === 2) return f;
                  v = u.global, u.type = u.type.toUpperCase(), u.hasContent = !oo.test(u.type), v && i.active++ == 0 && i.event.trigger("ajaxStart"), u.hasContent || (u.data && (u.url += (ou.test(u.url) ? "&" : "?") + u.data, delete u.data), o = u.url, u.cache === !1 && (it = i.now(), rt = u.url.replace(co, "$1_=" + it), u.url = rt + (rt === u.url ? (ou.test(u.url) ? "&" : "?") + "_=" + it : ""))), (u.data && u.hasContent && u.contentType !== !1 || r.contentType) && f.setRequestHeader("Content-Type", u.contentType), u.ifModified && (o = o || u.url, i.lastModified[o] && f.setRequestHeader("If-Modified-Since", i.lastModified[o]), i.etag[o] && f.setRequestHeader("If-None-Match", i.etag[o])), f.setRequestHeader("Accept", u.dataTypes[0] && u.accepts[u.dataTypes[0]] ? u.accepts[u.dataTypes[0]] + (u.dataTypes[0] !== "*" ? ", " + lu + "; q=0.01" : "") : u.accepts["*"]);
                  for (l in u.headers) f.setRequestHeader(l, u.headers[l]);
                  if (!u.beforeSend || u.beforeSend.call(s, f, u) !== !1 && e !== 2) {
                      ot = "abort";
                      for (l in {
                          success: 1,
                          error: 1,
                          complete: 1
                      }) f[l](u[l]);
                      if (c = tt(cu, u, r, f), c) {
                          f.readyState = 1, v && g.trigger("ajaxSend", [f, u]), u.async && u.timeout > 0 && (d = setTimeout(function () {
                              f.abort("timeout")
                          }, u.timeout));
                          try {
                              e = 1, c.send(ft, y)
                          } catch (st) {
                              if (e < 2) y(-1, st);
                              else throw st;
                          }
                      } else y(-1, "No Transport");
                      return f
                  }
                  return f.abort()
              },
              active: 0,
              lastModified: {},
              etag: {}
          });
          var au = [],
              lo = /\?/,
              ot = /(=)\?(?=&|$)|\?\?/,
              ao = i.now();
          i.ajaxSetup({
                  jsonp: "callback",
                  jsonpCallback: function () {
                      var n = au.pop() || i.expando + "_" + ao++;
                      return this[n] = !0, n
                  }
              }), i.ajaxPrefilter("json jsonp", function (r, u, f) {
                  var e, s, o, h = r.data,
                      c = r.url,
                      l = r.jsonp !== !1,
                      a = l && ot.test(c),
                      v = l && !a && typeof h == "string" && !(r.contentType || "").indexOf("application/x-www-form-urlencoded") && ot.test(h);
                  if (r.dataTypes[0] === "jsonp" || a || v) return e = r.jsonpCallback = i.isFunction(r.jsonpCallback) ? r.jsonpCallback() : r.jsonpCallback, s = n[e], a ? r.url = c.replace(ot, "$1" + e) : v ? r.data = h.replace(ot, "$1" + e) : l && (r.url += (lo.test(c) ? "&" : "?") + r.jsonp + "=" + e), r.converters["script json"] = function () {
                      return o || i.error(e + " was not called"), o[0]
                  }, r.dataTypes[0] = "json", n[e] = function () {
                      o = arguments
                  }, f.always(function () {
                      n[e] = s, r[e] && (r.jsonpCallback = u.jsonpCallback, au.push(e)), o && i.isFunction(s) && s(o[0]), o = s = t
                  }), "script"
              }), i.ajaxSetup({
                  accepts: {
                      script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
                  },
                  contents: {
                      script: /javascript|ecmascript/
                  },
                  converters: {
                      "text script": function (n) {
                          return i.globalEval(n), n
                      }
                  }
              }), i.ajaxPrefilter("script", function (n) {
                  n.cache === t && (n.cache = !1), n.crossDomain && (n.type = "GET", n.global = !1)
              }), i.ajaxTransport("script", function (n) {
                  if (n.crossDomain) {
                      var i, u = r.head || r.getElementsByTagName("head")[0] || r.documentElement;
                      return {
                          send: function (f, e) {
                              i = r.createElement("script"), i.async = "async", n.scriptCharset && (i.charset = n.scriptCharset), i.src = n.url, i.onload = i.onreadystatechange = function (n, r) {
                                  (r || !i.readyState || /loaded|complete/.test(i.readyState)) && (i.onload = i.onreadystatechange = null, u && i.parentNode && u.removeChild(i), i = t, r || e(200, "success"))
                              }, u.insertBefore(i, u.firstChild)
                          },
                          abort: function () {
                              i && i.onload(0, 1)
                          }
                      }
                  }
              }), st = n.ActiveXObject ? function () {
                  for (var n in w) w[n](0, 1)
              } : !1, vu = 0, i.ajaxSettings.xhr = n.ActiveXObject ? function () {
                  return !this.isLocal && di() || ku()
              } : di,
              function (n) {
                  i.extend(i.support, {
                      ajax: !!n,
                      cors: !!n && "withCredentials" in n
                  })
              }(i.ajaxSettings.xhr()), i.support.ajax && i.ajaxTransport(function (r) {
                  if (!r.crossDomain || i.support.cors) {
                      var u;
                      return {
                          send: function (f, e) {
                              var h, s, o = r.xhr();
                              if (r.username ? o.open(r.type, r.url, r.async, r.username, r.password) : o.open(r.type, r.url, r.async), r.xhrFields)
                                  for (s in r.xhrFields) o[s] = r.xhrFields[s];
                              r.mimeType && o.overrideMimeType && o.overrideMimeType(r.mimeType), r.crossDomain || f["X-Requested-With"] || (f["X-Requested-With"] = "XMLHttpRequest");
                              try {
                                  for (s in f) o.setRequestHeader(s, f[s])
                              } catch (c) {}
                              o.send(r.hasContent && r.data || null), u = function (n, f) {
                                  var s, a, v, c, l;
                                  try {
                                      if (u && (f || o.readyState === 4))
                                          if (u = t, h && (o.onreadystatechange = i.noop, st && delete w[h]), f) o.readyState !== 4 && o.abort();
                                          else {
                                              s = o.status, v = o.getAllResponseHeaders(), c = {}, l = o.responseXML, l && l.documentElement && (c.xml = l);
                                              try {
                                                  c.text = o.responseText
                                              } catch (n) {}
                                              try {
                                                  a = o.statusText
                                              } catch (y) {
                                                  a = ""
                                              }!s && r.isLocal && !r.crossDomain ? s = c.text ? 200 : 404 : s === 1223 && (s = 204)
                                          }
                                  } catch (p) {
                                      f || e(-1, p)
                                  }
                                  c && e(s, a, c, v)
                              }, r.async ? o.readyState === 4 ? setTimeout(u, 0) : (h = ++vu, st && (w || (w = {}, i(n).unload(st)), w[h] = u), o.onreadystatechange = u) : u()
                          },
                          abort: function () {
                              u && u(0, 1)
                          }
                      }
                  }
              });
          var ht, ct, vo = /^(?:toggle|show|hide)$/,
              yo = new RegExp("^(?:([-+])=|)(" + ut + ")([a-z%]*)$", "i"),
              po = /queueHooks$/,
              lt = [nf],
              k = {
                  "*": [
                      function (n, t) {
                          var o, s, r = this.createTween(n, t),
                              e = yo.exec(t),
                              h = r.cur(),
                              u = +h || 0,
                              f = 1,
                              c = 20;
                          if (e) {
                              if (o = +e[2], s = e[3] || (i.cssNumber[n] ? "" : "px"), s !== "px" && u) {
                                  u = i.css(r.elem, n, !0) || o || 1;
                                  do f = f || ".5", u = u / f, i.style(r.elem, n, u + s); while (f !== (f = r.cur() / h) && f !== 1 && --c)
                              }
                              r.unit = s, r.start = u, r.end = e[1] ? u + (e[1] + 1) * o : o
                          }
                          return r
                      }
                  ]
              };
          i.Animation = i.extend(nr, {
              tweener: function (n, t) {
                  i.isFunction(n) ? (t = n, n = ["*"]) : n = n.split(" ");
                  for (var r, u = 0, f = n.length; u < f; u++) r = n[u], k[r] = k[r] || [], k[r].unshift(t)
              },
              prefilter: function (n, t) {
                  t ? lt.unshift(n) : lt.push(n)
              }
          }), i.Tween = f, f.prototype = {
              constructor: f,
              init: function (n, t, r, u, f, e) {
                  this.elem = n, this.prop = r, this.easing = f || "swing", this.options = t, this.start = this.now = this.cur(), this.end = u, this.unit = e || (i.cssNumber[r] ? "" : "px")
              },
              cur: function () {
                  var n = f.propHooks[this.prop];
                  return n && n.get ? n.get(this) : f.propHooks._default.get(this)
              },
              run: function (n) {
                  var t, r = f.propHooks[this.prop];
                  return this.pos = this.options.duration ? t = i.easing[this.easing](n, this.options.duration * n, 0, 1, this.options.duration) : t = n, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), r && r.set ? r.set(this) : f.propHooks._default.set(this), this
              }
          }, f.prototype.init.prototype = f.prototype, f.propHooks = {
              _default: {
                  get: function (n) {
                      var t;
                      return n.elem[n.prop] == null || !!n.elem.style && n.elem.style[n.prop] != null ? (t = i.css(n.elem, n.prop, !1, ""), !t || t === "auto" ? 0 : t) : n.elem[n.prop]
                  },
                  set: function (n) {
                      i.fx.step[n.prop] ? i.fx.step[n.prop](n) : n.elem.style && (n.elem.style[i.cssProps[n.prop]] != null || i.cssHooks[n.prop]) ? i.style(n.elem, n.prop, n.now + n.unit) : n.elem[n.prop] = n.now
                  }
              }
          }, f.propHooks.scrollTop = f.propHooks.scrollLeft = {
              set: function (n) {
                  n.elem.nodeType && n.elem.parentNode && (n.elem[n.prop] = n.now)
              }
          }, i.each(["toggle", "show", "hide"], function (n, t) {
              var r = i.fn[t];
              i.fn[t] = function (u, f, e) {
                  return u == null || typeof u == "boolean" || !n && i.isFunction(u) && i.isFunction(f) ? r.apply(this, arguments) : this.animate(it(t, !0), u, f, e)
              }
          }), i.fn.extend({
              fadeTo: function (n, t, i, r) {
                  return this.filter(nt).css("opacity", 0).show().end().animate({
                      opacity: t
                  }, n, i, r)
              },
              animate: function (n, t, r, u) {
                  var e = i.isEmptyObject(n),
                      f = i.speed(t, r, u),
                      o = function () {
                          var t = nr(this, i.extend({}, n), f);
                          e && t.stop(!0)
                      };
                  return e || f.queue === !1 ? this.each(o) : this.queue(f.queue, o)
              },
              stop: function (n, r, u) {
                  var f = function (n) {
                      var t = n.stop;
                      delete n.stop, t(u)
                  };
                  return typeof n != "string" && (u = r, r = n, n = t), r && n !== !1 && this.queue(n || "fx", []), this.each(function () {
                      var o = !0,
                          t = n != null && n + "queueHooks",
                          e = i.timers,
                          r = i._data(this);
                      if (t) r[t] && r[t].stop && f(r[t]);
                      else
                          for (t in r) r[t] && r[t].stop && po.test(t) && f(r[t]);
                      for (t = e.length; t--;) e[t].elem === this && (n == null || e[t].queue === n) && (e[t].anim.stop(u), o = !1, e.splice(t, 1));
                      (o || !u) && i.dequeue(this, n)
                  })
              }
          }), i.each({
              slideDown: it("show"),
              slideUp: it("hide"),
              slideToggle: it("toggle"),
              fadeIn: {
                  opacity: "show"
              },
              fadeOut: {
                  opacity: "hide"
              },
              fadeToggle: {
                  opacity: "toggle"
              }
          }, function (n, t) {
              i.fn[n] = function (n, i, r) {
                  return this.animate(t, n, i, r)
              }
          }), i.speed = function (n, t, r) {
              var u = n && typeof n == "object" ? i.extend({}, n) : {
                  complete: r || !r && t || i.isFunction(n) && n,
                  duration: n,
                  easing: r && t || t && !i.isFunction(t) && t
              };
              return u.duration = i.fx.off ? 0 : typeof u.duration == "number" ? u.duration : u.duration in i.fx.speeds ? i.fx.speeds[u.duration] : i.fx.speeds._default, (u.queue == null || u.queue === !0) && (u.queue = "fx"), u.old = u.complete, u.complete = function () {
                  i.isFunction(u.old) && u.old.call(this), u.queue && i.dequeue(this, u.queue)
              }, u
          }, i.easing = {
              linear: function (n) {
                  return n
              },
              swing: function (n) {
                  return .5 - Math.cos(n * Math.PI) / 2
              }
          }, i.timers = [], i.fx = f.prototype.init, i.fx.tick = function () {
              for (var r, n = i.timers, t = 0; t < n.length; t++) r = n[t], r() || n[t] !== r || n.splice(t--, 1);
              n.length || i.fx.stop()
          }, i.fx.timer = function (n) {
              n() && i.timers.push(n) && !ct && (ct = setInterval(i.fx.tick, i.fx.interval))
          }, i.fx.interval = 13, i.fx.stop = function () {
              clearInterval(ct), ct = null
          }, i.fx.speeds = {
              slow: 600,
              fast: 200,
              _default: 400
          }, i.fx.step = {}, i.expr && i.expr.filters && (i.expr.filters.animated = function (n) {
              return i.grep(i.timers, function (t) {
                  return n === t.elem
              }).length
          }), ri = /^(?:body|html)$/i, i.fn.offset = function (n) {
              if (arguments.length) return n === t ? this : this.each(function (t) {
                  i.offset.setOffset(this, n, t)
              });
              var u, o, s, h, c, l, a, f = {
                      top: 0,
                      left: 0
                  },
                  r = this[0],
                  e = r && r.ownerDocument;
              if (e) return (o = e.body) === r ? i.offset.bodyOffset(r) : (u = e.documentElement, i.contains(u, r) ? (typeof r.getBoundingClientRect != "undefined" && (f = r.getBoundingClientRect()), s = tr(e), h = u.clientTop || o.clientTop || 0, c = u.clientLeft || o.clientLeft || 0, l = s.pageYOffset || u.scrollTop, a = s.pageXOffset || u.scrollLeft, {
                  top: f.top + l - h,
                  left: f.left + a - c
              }) : f)
          }, i.offset = {
              bodyOffset: function (n) {
                  var t = n.offsetTop,
                      r = n.offsetLeft;
                  return i.support.doesNotIncludeMarginInBodyOffset && (t += parseFloat(i.css(n, "marginTop")) || 0, r += parseFloat(i.css(n, "marginLeft")) || 0), {
                      top: t,
                      left: r
                  }
              },
              setOffset: function (n, t, r) {
                  var f = i.css(n, "position");
                  f === "static" && (n.style.position = "relative");
                  var e = i(n),
                      o = e.offset(),
                      l = i.css(n, "top"),
                      a = i.css(n, "left"),
                      v = (f === "absolute" || f === "fixed") && i.inArray("auto", [l, a]) > -1,
                      u = {},
                      s = {},
                      h, c;
                  v ? (s = e.position(), h = s.top, c = s.left) : (h = parseFloat(l) || 0, c = parseFloat(a) || 0), i.isFunction(t) && (t = t.call(n, r, o)), t.top != null && (u.top = t.top - o.top + h), t.left != null && (u.left = t.left - o.left + c), "using" in t ? t.using.call(n, u) : e.css(u)
              }
          }, i.fn.extend({
              position: function () {
                  if (this[0]) {
                      var u = this[0],
                          n = this.offsetParent(),
                          t = this.offset(),
                          r = ri.test(n[0].nodeName) ? {
                              top: 0,
                              left: 0
                          } : n.offset();
                      return t.top -= parseFloat(i.css(u, "marginTop")) || 0, t.left -= parseFloat(i.css(u, "marginLeft")) || 0, r.top += parseFloat(i.css(n[0], "borderTopWidth")) || 0, r.left += parseFloat(i.css(n[0], "borderLeftWidth")) || 0, {
                          top: t.top - r.top,
                          left: t.left - r.left
                      }
                  }
              },
              offsetParent: function () {
                  return this.map(function () {
                      for (var n = this.offsetParent || r.body; n && !ri.test(n.nodeName) && i.css(n, "position") === "static";) n = n.offsetParent;
                      return n || r.body
                  })
              }
          }), i.each({
              scrollLeft: "pageXOffset",
              scrollTop: "pageYOffset"
          }, function (n, r) {
              var u = /Y/.test(r);
              i.fn[n] = function (f) {
                  return i.access(this, function (n, f, e) {
                      var o = tr(n);
                      if (e === t) return o ? r in o ? o[r] : o.document.documentElement[f] : n[f];
                      o ? o.scrollTo(u ? i(o).scrollLeft() : e, u ? e : i(o).scrollTop()) : n[f] = e
                  }, n, f, arguments.length, null)
              }
          }), i.each({
              Height: "height",
              Width: "width"
          }, function (n, r) {
              i.each({
                  padding: "inner" + n,
                  content: r,
                  "": "outer" + n
              }, function (u, f) {
                  i.fn[f] = function (f, e) {
                      var o = arguments.length && (u || typeof f != "boolean"),
                          s = u || (f === !0 || e === !0 ? "margin" : "border");
                      return i.access(this, function (r, u, f) {
                          var e;
                          return i.isWindow(r) ? r.document.documentElement["client" + n] : r.nodeType === 9 ? (e = r.documentElement, Math.max(r.body["scroll" + n], e["scroll" + n], r.body["offset" + n], e["offset" + n], e["client" + n])) : f === t ? i.css(r, u, f, s) : i.style(r, u, f, s)
                      }, r, o ? f : t, o, null)
                  }
              })
          }), n.jQuery = n.$ = i, typeof define == "function" && define.amd && define.amd.jQuery && define("jquery", [], function () {
              return i
          })
      })(window),  
      
      gdx = gdx || {}, gdx.core = function () {
              var n = function () {
                      window.requestAnimFrame = function () {
                          return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (n) {
                              window.setTimeout(n, 1e3 / 60)
                          }
                      }()
                  },
                  t = function () {
                      var n = $("#particles-left"),
                          t = $("#particles-right"),
                          i = 90;
                      window.innerWidth <= 500 && (i = 5), $("#particles-middle").particles({
                          particleCount: i,
                          size: 2,
                          heightFactor: .8,
                          widthFactor: .5,
                          maxVelocity: .6,
                          minDistance: 70
                      }), n.is(":visible") && t.is(":visible") && (n.particles({
                          particleCount:55,
                          size: 3,
                          heightFactor: .8,
                          widthFactor: .333,
                          maxVelocity: .4,
                          minDistance: 70,
                          position: "left"
                      }), t.particles({
                          particleCount: 55,
                          size: 3,
                          heightFactor: .8,
                          widthFactor: .333,
                          maxVelocity: .4,
                          minDistance: 70,
                          position: "right"
                      }))
                  },

                  r = function () {
                      function t(n) {
                          var t = "slideOutUp";
                          return n == "s1-content" ? t = "slideOutLeft" : n == "s3-content" && (t = "slideOutRight"), t
                      }
                      var n = $(".section.active", ".sections");
                      $(".content__text").on("click", "span", function () {
                          var r = $(this).attr("id"),
                              f = r + "-content",
                              e, i, u;
                          if (f == n.attr("id")) return !1;
                          e = t(f), n.removeClass("active grow").addClass(e), n = $("#" + f), n.removeClass("slideOutUp slideOutLeft slideOutRight").addClass("active grow"), i = $("#particles-left"), u = $("#particles-right"), r == "s1" ? i.is(":visible") && !i.hasClass("highlighted") && (i.addClass("highlighted").trigger("highlight"), u.addClass("highlighted").trigger("highlight")) : r == "s2" ? i.is(":visible") && i.hasClass("highlighted") && (i.trigger("reset"), u.trigger("reset")) : r == "s3" && i.is(":visible") && i.hasClass("highlighted") && !i.hasClass("magnetized") && (i.addClass("magnetized").trigger("magnetize"), u.addClass("magnetized").trigger("magnetize"))
                      })
                  };
              return {
                  settings: {
                      tapTxt: "click"
                  },
                  init: function () {
                      n(), t(), i(), r()
                  }
              }
          }(),  $(document).ready(function () {
              gdx.core.init()
          }),
          function (n) {
              n.fn.modal = function (t) {
                  function r(t) {
                      t.removeClass("show"), u.off(gdx.core.settings.tapTxt), f.off(gdx.core.settings.tapTxt), n(document).unbind("keyup")
                  }
                  var e = {
                          theme: "light",
                          width: undefined,
                          height: undefined,
                          layout: undefined,
                          url: undefined,
                          content: undefined,
                          padding: undefined,
                          animation: "flipInX"
                      },
                      t = n.extend(e, t),
                      i = n(this),
                      u = n("#overlays"),
                      f = n(".close", i);
                  u.on(gdx.core.settings.tapTxt, function () {
                      r(i)
                  });
                  f.on(gdx.core.settings.tapTxt, function () {
                      r(i)
                  });
                  n(document).keyup(function (n) {
                      n.which == 27 && r(i)
                  }), i.addClass("show")
              }
          }(jQuery), gdx = gdx || {}, gdx.particles = {
              Particle: function (n, t, i, r) {
                  this.x = Math.floor(Math.random() * n), this.y = Math.floor(Math.random() * t), this.initialVx = Math.random() * i * (Math.random() < .5 ? -1 : 1), this.initialVy = Math.random() * i * (Math.random() < .5 ? -1 : 1), this.vx = this.initialVx, this.vy = this.initialVy, this.radius = r, this.alpha = 1, this.timeAccelerating = 0, this.state = gdx.particles.ParticleState.ROAMING, this.orbit = 1, this.magnet = null, this.force = 1 - Math.random() * .11, this.angle = 0, this.shift = {
                      x: 0,
                      y: 0
                  }
              },
              Magnet: function (n, t, i, r) {
                  gdx.particles.Particle.call(this, n, t, i, r), this.orbit = 100
              },
              ParticleState: {
                  ROAMING: 1,
                  ATTRACTING: 2,
                  SLOWING: 4,
                  ACCELERATING: 8,
                  HIGHLIGHTED: 16,
                  ORBITING: 62,
                  GROWING: 64
              }
          }, gdx.particles.Particle.prototype = {
              hasState: function (n) {
                  return (this.state & n) == n
              },
              addState: function (n) {
                  this.state = this.state | n
              },
              setState: function (n) {
                  this.state = n
              },
              removeState: function (n) {
                  this.state = this.state & ~n
              }
          }, gdx.particles.Magnet.prototype = new gdx.particles.Particle, gdx.particles.Magnet.prototype.constructor = gdx.particles.Magnet,
          function (n) {
              n.fn.particles = function (t) {
                  function c() {
                      e = [], h = !1, f.removeClass("highlighted magnetized");
                      for (var n = 0; n < i.length; n++) i[n].setState(gdx.particles.ParticleState.ROAMING), i[n].radius = t.size
                  }

                  function g() {
                      for (var n = 0; n < 4; n++) e.push(new gdx.particles.Magnet(r.width, r.height, t.maxVelocity, t.size)), e[n].setState(gdx.particles.ParticleState.HIGHLIGHTED | gdx.particles.ParticleState.GROWING)
                  }

                  function nt() {
                      var n, t;
                      for (h = !0, n = 0; n < i.length; n++) i[n].setState(gdx.particles.ParticleState.ORBITING), i[n].radius = .5 + Math.random() * 3.5, i[n].speed = .01 + i[n].radius / 5 * .01, t = e[n % 3], i[n].magnet = t, i[n].shift.x = t.x, i[n].shift.y = t.y
                  }

                  function l(n) {
                      var u = Math.floor(o.outerWidth() * t.widthFactor),
                          e = Math.floor(o.outerHeight() * t.heightFactor),
                          v, h, l;
                      for (r.width = u, r.height = e, f.css("width", u + "px"), f.css("height", e + "px"), i.length = 0, v = o.position().top - (e - o.height()) / 2, h = o.position().left, t.position == "right" ? (h = o.width() * .66667, s = 0) : t.position == "default" ? h -= (u - o.width()) / 2 : s = r.width, f.css("top", v), f.css("left", h), l = 0; l < t.particleCount; l++) i.push(new gdx.particles.Particle(u, e, t.maxVelocity, t.size));
                      n ? c() : a()
                  }

                  function a() {
                      var f, c, n, o, s, nt, k, g;
                      for (u.clearRect(0, 0, r.width, r.height), o = 0; o < e.length; o++) f = e[o], f.alpha = p(f.x), w(d + f.alpha + ")", f), f.hasState(gdx.particles.ParticleState.GROWING) && (f.radius = Math.min(f.radius + .05, 8), f.radius == 8 && f.removeState(gdx.particles.ParticleState.GROWING)), y(f);
                      for (c = 0; c < i.length; c++)
                          if (n = i[c], n.alpha = p(n.x), w("rgba(255,255, 255, " + n.alpha + ")", n), (n.vx.toFixed(2) == 0 || n.vy.toFixed(2) == 0) && (n.vx = n.initialVx, n.vy = n.initialVy), h) {
                              var b = {
                                      x: 0,
                                      y: 0
                                  },
                                  l = 300,
                                  it = -1;
                              for (o = 0; o < e.length; o++) s = e[o], nt = v(n.x, n.y, s.x, s.y) - s.orbit * .5, n.magnet != s && (k = s.x - n.x, g = s.y - n.y, k > -l && k < l && (b.x += k / l), g > -l && g < l && (b.y += g / l)), (n.magnet == null || nt < it) && (it = nt, n.magnet = s);
                              n.angle += n.speed, n.shift.x += (n.magnet.x + b.x * 6 - n.shift.x) * n.speed, n.shift.y += (n.magnet.y + b.y * 6 - n.shift.y) * n.speed, n.x = n.shift.x + Math.cos(c + n.angle) * n.orbit * n.force, n.y = n.shift.y + Math.sin(c + n.angle) * n.orbit * n.force, n.x = Math.max(Math.min(n.x, r.width - n.radius), n.radius), n.y = Math.max(Math.min(n.y, r.height - n.radius), n.radius), n.orbit += (n.magnet.orbit - n.orbit) * .1
                          } else !n.hasState(gdx.particles.ParticleState.SLOWING) && !n.hasState(gdx.particles.ParticleState.ATTRACTING) && (n.vx > t.maxVelocity || n.vy > t.maxVelocity) && n.addState(gdx.particles.ParticleState.SLOWING), n.hasState(gdx.particles.ParticleState.ATTRACTING) && (n.timeAccelerating += 1, n.timeAccelerating >= 240 && (n.addState(gdx.particles.ParticleState.ACCELERATING), n.removeState(gdx.particles.ParticleState.ATTRACTING), n.timeAccelerating = 0, n.vx += n.vx * .25, n.vy += n.vy * .25)), n.hasState(gdx.particles.ParticleState.ACCELERATING) && (n.timeAccelerating += 1, n.timeAccelerating >= 30 && (n.addState(gdx.particles.ParticleState.SLOWING), n.removeState(gdx.particles.ParticleState.ACCELERATING), n.timeAccelerating = 0)), n.hasState(gdx.particles.ParticleState.SLOWING) && (n.vx *= t.dragCoefficient, n.vy *= t.dragCoefficient, (Math.abs(n.vx) >= Math.abs(n.initialVx) * .9 && Math.abs(n.vx) <= Math.abs(n.initialVx * 1.1) || Math.abs(n.vy) >= Math.abs(n.initialVy) * .9 && Math.abs(n.vy) <= Math.abs(n.initialVy) * 1.1) && (n.addState(gdx.particles.ParticleState.ROAMING), n.removeState(gdx.particles.ParticleState.SLOWING))), y(n), tt(n, c);
                      requestAnimFrame(a)
                  }

                  function v(n, t, i, r) {
                      var u = n - i,
                          f = t - r;
                      return Math.sqrt(u * u + f * f)
                  }

                  function tt(n, r) {
                      for (var f, o, s, h, e = 0; e < i.length; e++) e != r && (f = i[e], o = v(n.x, n.y, f.x, f.y), o <= t.minDistance && (u.beginPath(), u.strokeStyle = "rgba(255,255,255," + n.alpha * (1.2 - o / t.minDistance)*0.6 + ")", u.moveTo(n.x, n.y), u.lineTo(f.x, f.y), u.stroke(), u.closePath(), n.hasState(gdx.particles.ParticleState.ACCELERATING) || n.hasState(gdx.particles.ParticleState.SLOWING) || f.hasState(gdx.particles.ParticleState.ACCELERATING) || f.hasState(gdx.particles.ParticleState.SLOWING) || (s = (n.x - f.x) / 2e3, h = (n.y - f.y) / 2e3, n.vx -= s, n.vy -= h, f.vx += s, f.vy += h, n.addState(gdx.particles.ParticleState.ATTRACTING), f.addState(gdx.particles.ParticleState.ATTRACTING))))
                  }

                  function y(n) {
                      n.x += n.vx, n.y += n.vy, n.x + n.radius > r.width ? n.x = n.radius : n.x - n.radius < 0 && (n.x = r.width - n.radius), n.y + n.radius > r.height ? n.y = n.radius : n.y - n.radius < 0 && (n.y = r.height - n.radius)
                  }

                  function p(n) {
                      if (t.position != "default") {
                          var i = Math.abs(n - s);
                          return Math.min(i / r.width, 1)
                      }
                      return 1
                  }

                  function w(n, t) {
                      u.fillStyle = n, u.beginPath(), u.arc(t.x, t.y, t.radius, 0, k, !1), u.fill()
                  }

                  function it() {
                      l(!0)
                  }
                  var b = {
                          particleCount: 35,
                          size: 2,
                          heightFactor: 1.2,
                          widthFactor: .8,
                          maxVelocity: .2,
                          minDistance: 10,
                          dragCoefficient: .99,
                          position: "default"
                      },
                      t = n.extend(b, t),
                      f = n(this),
                      o = n("#main-content"),
                      r = document.getElementById(n(this).attr("id")),
                      u = r.getContext("2d"),
                      i = [],
                      e = [],
                      k = Math.PI * 2,
                      s = 0,
                      d = n("#s2").css("background-color").replace(")", ",").replace("rgb", "rgba"),
                      h = !1;
                  f.on("highlight", g);
                  f.on("magnetize", nt);
                  f.on("reset", c);
                  l(), n(window).resize(it)
              }
          }(jQuery);
        </script>
  </body>
</html>
