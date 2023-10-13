# JqueryPhp
Server side dom manipulation wriiten on php as it's Jquery clientside counter-part

This project aims at providing a seamless, simple way to perform advanced DOM manipulation on the serverside.

IDEA
---------
 
This is inspired by the almighty javascript library caled Jquery. 
 
 
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

