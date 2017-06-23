/*
 * Flot plugin to order bars side by side.
 * 
 * Released under the MIT license by Benjamin BUFFET, 20-Sep-2010.
 *
 * This plugin is an alpha version.
 *
 * To activate the plugin you must specify the parameter "order" for the specific serie :
 *
 *  $.plot($("#placeholder"), [{ data: [ ... ], bars :{ order = null or integer }])
 *
 * If 2 series have the same order param, they are ordered by the position in the array;
 *
 * The plugin adjust the point by adding a value depanding of the barwidth
 * Exemple for 3 series (barwidth : 0.1) :
 *
 *          first bar dĂŠcalage : -0.15
 *          second bar dĂŠcalage : -0.05
 *          third bar dĂŠcalage : 0.05
 *
 */

(function(k){k.plot.plugins.push({init:function(k){function m(a,c){for(var d=[],b=0;b<a.length;b++)d[0]=a[b].data[0][c],d[1]=a[b].data[a[b].data.length-1][c];return d}function q(a,c){var d=a.bars.order,b=c.bars.order;return d<b?-1:d>b?1:0}function n(a,c,d){for(var b=0;c<=d;c++)b+=a[c].bars.barWidth+2*l;return b}var g,h,o,l,p=1,j=!1;k.hooks.processDatapoints.push(function(a,c,d){var b=null;if(null!=c.bars&&c.bars.show&&null!=c.bars.order){c.bars.horizontal&&(j=!0);var f=j?a.getPlaceholder().innerHeight(): a.getPlaceholder().innerWidth(),e=j?m(a.getData(),1):m(a.getData(),0);p=(e[1]-e[0])/f;a=a.getData();f=[];for(e=0;e<a.length;e++)null!=a[e].bars.order&&a[e].bars.show&&f.push(a[e]);g=f.sort(q);h=g.length;o=c.bars.lineWidth?c.bars.lineWidth:2;l=o*p;if(2<=h){for(a=b=0;a<g.length;++a)if(c==g[a]){b=a;break}b+=1;a=a=0;0!=h%2&&(a=g[Math.ceil(h/2)].bars.barWidth/2);for(var b=a=b<=Math.ceil(h/2)?-1*n(g,b-1,Math.floor(h/2)-1)-a:n(g,Math.ceil(h/2),b-2)+a+2*l,a=d.pointsize,f=d.points,e=0,i=j?1:0;i<f.length;i+= a)f[i]+=b,c.data[e][3]=f[i],e++;b=f;d.points=b}}return b})},options:{series:{bars:{order:null}}},name:"orderBars",version:"0.2"})})(jQuery);