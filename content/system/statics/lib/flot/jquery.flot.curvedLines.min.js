/* The MIT License

Copyright (c) 2011 by Michael Zinsmaier and nergal.dev

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/


/*

____________________________________________________

what it is:
____________________________________________________

curvedLines is a plugin for flot, that tries to display lines in a smoother way.
The plugin is based on nergal.dev's work https://code.google.com/p/flot/issues/detail?id=226
and further extended with a mode that forces the min/max points of the curves to be on the
points. Both modes are achieved through adding of more data points
=> 1) with large data sets you may get trouble
=> 2) if you want to display the points too, you have to plot them as 2nd data series over the lines

This is version 0.1 of curvedLines so it will probably not work in every case. However
the basic form of use descirbed next works (:
	
Feel free to further improve the code

____________________________________________________

how to use it:
____________________________________________________


	var d1 = [[5,5],[7,3],[9,12]];

	var options = { series: { curvedLines: {  active: true }}};
	

    $.plot($("#placeholder"), [{data = d1, curvedLines: { show: true}}], options);
  
_____________________________________________________

options:
_____________________________________________________

	fill: 			  bool true => lines get filled
	fillColor: 		  null or the color that should be used for filling 
	active:           bool true => plugin can be used
	show:             bool true => series will be drawn as curved line
	fit:              bool true => forces the max,mins of the curve to be on the datapoints
	lineWidth:        int  width of the line
	curvePointFactor  int  defines how many "virtual" points are used per "real" data point to
						   emulate the curvedLines
	fitPointDist:      int  defines the x axis distance of the additional two points that are used
						   to enforce the min max condition. (you will get curvePointFactor * 3 * |datapoints|
						   "virtual" points if fit is true) 
	
  
*/

/* 
 *  v0.1   initial commit
 *  v0.15  negative values should work now (outcommented a negative -> 0 hook hope it does no harm)
 *  v0.2   added fill option (thanks to monemihir) and multi axis support (thanks to soewono effendi)
 * 
 * 
 */
(function(t){t.plot.plugins.push({init:function(w){function x(r,n){for(var l,u=r.getData(),v=r.getPlotOffset(),s=0;s<u.length;s++)if(l=u[s],l.curvedLines.show&&0<l.curvedLines.lineWidth){axisx=l.xaxis;axisy=l.yaxis;n.save();n.translate(v.left,v.top);n.lineJoin="round";n.strokeStyle=l.color;if(l.curvedLines.fill){var m=t.color.parse(null==l.curvedLines.fillColor?l.color:l.curvedLines.fillColor);m.a="number"==typeof fill?fill:0.4;m.normalize();n.fillStyle=m.toString()}n.lineWidth=l.curvedLines.lineWidth; var g;a:{var b=l.data,j=l.curvedLines,m=j.curvePointFactor*b.length;g=[];var e=[];if(j.fit)for(var j=j.fitPointDist,d=0,a=0;a<b.length;a++)g[d]=b[a][0]-0.1,e[d]=0<a?b[a-1][1]*j+b[a][1]*(1-j):b[a][1],d++,g[d]=b[a][0],e[d]=b[a][1],d++,g[d]=b[a][0]+0.1,e[d]=a+1<b.length?b[a+1][1]*j+b[a][1]*(1-j):b[a][1],d++;else for(a=0;a<b.length;a++)g[a]=b[a][0],e[a]=b[a][1];var b=g.length,j=[],k=[];j[0]=0;j[b-1]=0;k[0]=0;for(a=1;a<b-1;++a){d=g[a+1]-g[a-1];if(0==d){g=null;break a}var d=(g[a]-g[a-1])/d,c=d*j[a-1]+2; j[a]=(d-1)/c;k[a]=(e[a+1]-e[a])/(g[a+1]-g[a])-(e[a]-e[a-1])/(g[a]-g[a-1]);k[a]=(6*k[a]/(g[a+1]-g[a-1])-d*k[a-1])/c}for(d=b-2;0<=d;--d)j[d]=j[d]*j[d+1]+k[d];var a=(g[b-1]-g[0])/(m-1),k=[],c=[],f=[];k[0]=g[0];c[0]=e[0];for(d=1;d<m;++d){k[d]=k[0]+d*a;for(var h=b-1,i=0;1<h-i;){var o=Math.round((h+i)/2);g[o]>k[d]?h=o:i=o}o=g[h]-g[i];if(0==o){g=null;break a}var p=(g[h]-k[d])/o,q=(k[d]-g[i])/o;c[d]=p*e[i]+q*e[h]+((p*p*p-p)*j[i]+(q*q*q-q)*j[h])*o*o/6;f.push(k[d]);f.push(c[d])}g=f}m=n;e=axisx;b=axisy;l=l.curvedLines.fill; d=j=null;a=0;m.beginPath();for(k=2;k<g.length;k+=2)if(c=g[k-2],f=g[k-2+1],h=g[k],i=g[k+1],!(null==c||null==h)){if(f<=i&&f<b.min){if(i<b.min)continue;c=(b.min-f)/(i-f)*(h-c)+c;f=b.min}else if(i<=f&&i<b.min){if(f<b.min)continue;h=(b.min-f)/(i-f)*(h-c)+c;i=b.min}if(f>=i&&f>b.max){if(i>b.max)continue;c=(b.max-f)/(i-f)*(h-c)+c;f=b.max}else if(i>=f&&i>b.max){if(f>b.max)continue;h=(b.max-f)/(i-f)*(h-c)+c;i=b.max}if(c<=h&&c<e.min){if(h<e.min)continue;f=(e.min-c)/(h-c)*(i-f)+f;c=e.min}else if(h<=c&&h<e.min){if(c< e.min)continue;i=(e.min-c)/(h-c)*(i-f)+f;h=e.min}if(c>=h&&c>e.max){if(h>e.max)continue;f=(e.max-c)/(h-c)*(i-f)+f;c=e.max}else if(h>=c&&h>e.max){if(c>e.max)continue;i=(e.max-c)/(h-c)*(i-f)+f;h=e.max}(c!=j||f!=d)&&m.lineTo(e.p2c(c),b.p2c(f));null==j&&(a=i);j=h;d=i;m.lineTo(e.p2c(h),b.p2c(i))}l&&(m.lineTo(e.p2c(e.max),b.p2c(b.min)),m.lineTo(e.p2c(e.min),b.p2c(b.min)),m.lineTo(e.p2c(e.min),b.p2c(a)),m.fill());m.stroke();n.restore()}}w.hooks.processOptions.push(function(r,n){n.series.curvedLines.active&& r.hooks.draw.push(x)})},options:{series:{curvedLines:{active:!1,show:!1,fit:!1,fill:!1,fillColor:null,lineWidth:2,curvePointFactor:20,fitPointDist:1.0E-4}}},name:"curvedLines",version:"0.2"})})(jQuery);