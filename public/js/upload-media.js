!function(e){function t(r){if(n[r])return n[r].exports;var o=n[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,t),o.l=!0,o.exports}var n={};t.m=e,t.c=n,t.i=function(e){return e},t.d=function(e,n,r){t.o(e,n)||Object.defineProperty(e,n,{configurable:!1,enumerable:!0,get:r})},t.n=function(e){var n=e&&e.__esModule?function(){return e.default}:function(){return e};return t.d(n,"a",n),n},t.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},t.p="",t(t.s=1)}([function(e,t){jQuery(document).ready(function(e){e(document).on("click",".upload_image_button",function(){return jQuery.data(document.body,"prevElement",e(this).prev()),window.send_to_editor=function(e){var t=jQuery("img",e).attr("src"),n=jQuery.data(document.body,"prevElement");void 0!=n&&""!=n&&n.val(t),tb_remove()},tb_show("","media-upload.php?type=image&TB_iframe=true"),!1})})},function(e,t,n){e.exports=n(0)}]);