# JqueryPhp
Server side dom manipulation wriiten on php as it's Jquery clientside counter-part

This project aims at providing a seamless, simple way to perform advanced DOM manipulation on the serverside.

IDEA
---------
 While my years as a Freelance programmer, I always toward inspiring new ways to do things. I started using nodepad++ as my favorite tool in 2012. Meanwhile, I have tried my hand on dozens of other tools as regards to finding a solution that allows for deeper possibilities and tweaking. I never regretted using WebEasy,DreamWeaver,PSD to Html, and never wanted to reinvent their likes. However, approach is to be able to do my things without software-related limitation or restrictions. That was what led me into an indepth research that discovered Notepad++.
 
 But before that, I am already a close friend to javascript. A lovely pal! But until a friend introduced me to Jquery via his blog, I never admitted that DOM manipulation could be this flawless and easy. And this is my 3rd year cruising with Jquery!
 
 Furthermore, after months of absence aways from my smart devices, I came home one thursday and decided to take a peep at my inbox and wait...... are those meant for only me?? I got huge number of messages waiting for me. But only two out of about 170 messages caught my eyes and those guys if I must say, inspired JqueryPHP as it is today.
 
 JqueryPHP as it is
 ----------
 JqueryPHP provides methods, constants, functions, abstracts for advanced operations like PHP DOM, Jquery styled query,DOMevents,iteration,Window.
 
 Folder Struction
=====================
  * abstracts - Contains abstract classes for JqueryPhp
  * methods - Methods (70+)
  
Supported  Methods
=====================
  * addClass
  * after
  * append
  * appendTo
  * attr
  * before
  * children
  * clone
  * contains
  * contents
  * css
  * data
  * dom
  * each
  * empty
  * end
  * find
  * get
  * has
  * hasClass
  * height
  * hide
  * html
  * insertAfter
  * insertBefore
  * is
  * length
  * map
  * next
  * nextall
  * nextuntil
  * not
  * off
  * on
  * one
  * parent
  * parents
  * parentsUntil
  * prepend
  * prependTo
  * prev
  * prevAll
  * prevUntil
  * remove
  * removeAttr
  * removeClass
  * replaceAll
  * replaceWith
  * serializeArray
  * serialize
  * show
  * siblings
  * tag
  * text
  * toggle
  * toggleClass
  * trigger
  * unwrap
  * val
  * width
  * wrap
  * wrapinner
  * last
  * first
  * eq
  * filter
  * index
  * slice
 
Window
=====================
JqueryPHP Window is a class that mimicks standard browser window. It comes with methods needed to load,reload document and work with Events in it's natural way. 
It currently supports 3 document protocols which is provided to "Load" method e.g http,file,blobdata.

 Event
=====================
Implement window Event feature. 
Currently, [click,load] event is implemented fully as we work towareds coming up with best possible for mouseover,mousedown,mouseout,keydown,keypress,keyup events. 


 FEATURES
=====================
* Optimized for speed
* Implements events and custom event binding
* Load document from http url,local file or string
* Using $this to access current element
* New extension by simply extending the [jqueryphp_abstracts_element] class
* Almost all jquery methods is implemented
* Chaining is supported
* You can now invoke query directly on a element i.e $j('body.class')
* Deep document hierachy selector support i.e $j('html head > link')
* Implemented :visible and :hidden Jquery selector
* Elements are represented in JqueryPHP object that is readily accessible
* JqueryPHP implements __toString method in both Document and Element
* Supports multiple selectors per query i.e $j('body,div,p')
* Fixes broken document
* Optonally load document from Window
* Supports Window.onload asported to Window->onload

 HOW TO USE
=====================
```php
  require("PATH_TO_LIBRARY/init.php");
  $j = jqm($html);
  //Search html
  $j("a[href]").each(function(){
   if($this->is(":disabled")->get() ==true){
   $this->remove();
   }
  })
  $scripts = $j->search("body script:empty");
  if($scripts->length > 0){
  $this.appendTo("body head")
  }
  $win = jqm_window();
  $win->onload(function($e){
  //Do things
  })
  $win->load($PATH_TO_LOCAL_FILE,'file');
```
 or
 ```php
  $win->load($URL_TO_HTTP_FILE,'http');
```
 or
 ```php
  $win->load($HTML_STRING,'blobdata')
```
USES
=========
Endless!
Though I developed it for a custom PHP project for presentation/templating purposes.
 * Transverse XML/HTML document in an easy jqyery-like style
 * Web Scraper
 * Website Screenshot
 * Window Class is readily available to be implemented with a Browser class
 * ......the need is endless
 * 

Credits
=========
Simpon Sapin -  CSSselector
Symphony Framework
Jquery javascript library


Author
=========
Leo.I.Anthony
(http://twitter.com/imagickpro)

