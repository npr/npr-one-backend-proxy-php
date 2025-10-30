<html lang="en"><head> <meta charset="utf-8"></meta> <title>NPR One Backend Proxy Documentation</title> <meta content="width=device-width, initial-scale=1.0" name="viewport"></meta> <base href="../"></base> <link href="images/favicon.ico" rel="icon"></link> <link href="css/normalize.css" rel="stylesheet"></link> <link href="css/base.css" rel="stylesheet"></link> <link href="https://fonts.gstatic.com" rel="preconnect"></link> <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@100;200;300;400;600;700&display=swap" rel="stylesheet"></link> <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro:wght@400;600;700&display=swap" rel="stylesheet"></link> <link href="css/template.css" rel="stylesheet"></link> <link crossorigin="anonymous" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css" integrity="sha256-ybRkN9dBjhcS2qrW1z+hfCxq+1aBdwyQM5wlQoQVt/0=" rel="stylesheet"></link> <link href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/themes/prism-okaidia.css" rel="stylesheet"></link> <link href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.css" rel="stylesheet"></link> <link href="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.css" rel="stylesheet"></link> <script src="https://cdn.jsdelivr.net/npm/fuse.js@3.4.6"></script> <script src="https://cdn.jsdelivr.net/npm/css-vars-ponyfill@2"></script> <script src="js/template.js"></script> <script src="js/search.js"></script> <script defer="defer" src="js/searchIndex.js"></script> </head><body id="top"> <header class="phpdocumentor-header phpdocumentor-section"><a class="phpdocumentor-title__link" href="">NPR One Backend Proxy Documentation</a>
====================================================================================

 <input class="phpdocumentor-header__menu-button" id="menu-button" name="menu-button" type="checkbox"></input> <label class="phpdocumentor-header__menu-icon" for="menu-button">  </label> <section class="phpdocumentor-search" data-search-form=""> <label> <span class="visually-hidden">Search for</span> <svg class="phpdocumentor-search__icon" fill="none" height="20" viewbox="0 0 21 20" width="21" xmlns="http://www.w3.org/2000/svg"> <circle cx="7.5" cy="7.5" r="6.5" stroke="currentColor" stroke-width="2"></circle> <line stroke="currentColor" stroke-width="3" x1="12.4892" x2="19.1559" y1="12.2727" y2="18.9393"></line> </svg> <input class="phpdocumentor-field phpdocumentor-search__field" disabled="disabled" placeholder="Loading .." type="search"></input> </label></section> <nav class="phpdocumentor-topnav"> 
</nav></header> <main class="phpdocumentor"><div class="phpdocumentor-section"> <input class="phpdocumentor-sidebar__menu-button" id="sidebar-button" name="sidebar-button" type="checkbox"></input><label class="phpdocumentor-sidebar__menu-icon" for="sidebar-button"> Menu </label><aside class="phpdocumentor-column -three phpdocumentor-sidebar"> <section class="phpdocumentor-sidebar__category -namespaces">Namespaces
----------

####  [NPR](namespaces/npr.html)

- [One](namespaces/npr-one.html)
 
 </section> <section class="phpdocumentor-sidebar__category -packages">Packages
--------

####  [Application](packages/Application.html)

####  [NPR](packages/NPR.html)

- [One](packages/NPR-One.html)
 
 </section> <section class="phpdocumentor-sidebar__category -reports">Reports
-------

### [Deprecated](reports/deprecated.html)

### [Errors](reports/errors.html)

### [Markers](reports/markers.html)

 </section> <section class="phpdocumentor-sidebar__category -indices">Indices
-------

### [Files](indices/files.html)

 </section></aside><div class="phpdocumentor-column -nine phpdocumentor-content"> <section>- [NPR](namespaces/npr.html)
- [One](namespaces/npr-one.html)
- [Exceptions](namespaces/npr-one-exceptions.html)
 
 <article class="phpdocumentor-element -class"> ApiException <span class="phpdocumentor-element__extends"> extends <abbr title="\Exception">Exception</abbr> </span><div class="phpdocumentor-element__package"> in package - [NPR](packages/NPR.html)
- [One](packages/NPR-One.html)
- [Exceptions](packages/NPR-One-Exceptions.html)
 
 </div> 
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<div class="phpdocumentor-label-line"></div> <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Exceptions/ApiException.php">[<abbr title="src/Exceptions/ApiException.php">ApiException.php</abbr>](files/src-exceptions-apiexception.html)</abbr> : <span class="phpdocumentor-element-found-in__line">15</span> </aside>An extension of CookieProvider that encrypts cookies before setting them and decrypts them when retrieving them

#####  Tags [](classes/NPR-One-Exceptions-ApiException.html#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">codeCoverageIgnore</span> </dt> <dd class="phpdocumentor-tag-list__definition"> </dd> </dl>###  Table of Contents [](classes/NPR-One-Exceptions-ApiException.html#toc)

####  Methods [](classes/NPR-One-Exceptions-ApiException.html#toc-methods)

<dl class="phpdocumentor-table-of-contents"> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [\_\_construct()](classes/NPR-One-Exceptions-ApiException.html#method___construct) <span> : mixed </span></dt><dd>Constructs the exception using the response from the API call.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getBody()](classes/NPR-One-Exceptions-ApiException.html#method_getBody) <span> : <abbr title="\GuzzleHttp\Psr7\Stream">Stream</abbr> </span></dt><dd>Returns the body of the response from the failed API call. May be empty.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getStatusCode()](classes/NPR-One-Exceptions-ApiException.html#method_getStatusCode) <span> : int </span></dt><dd>Returns the HTTP status code from the failed API call; should generally always be 400 or greater.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getStatusText()](classes/NPR-One-Exceptions-ApiException.html#method_getStatusText) <span> : string </span></dt><dd>Returns the HTTP status text (a.k.a. reason phrase) from the failed API call.</dd> </dl> <section class="phpdocumentor-methods">###  Methods [](classes/NPR-One-Exceptions-ApiException.html#methods) 

 <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  \_\_construct() [](classes/NPR-One-Exceptions-ApiException.html#method___construct) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Exceptions/ApiException.php">[<abbr title="src/Exceptions/ApiException.php">ApiException.php</abbr>](files/src-exceptions-apiexception.html)</abbr> : <span class="phpdocumentor-element-found-in__line">40</span> </aside>Constructs the exception using the response from the API call.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">__construct</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">string </span><span class="phpdocumentor-signature__argument__name">$message</span></span><span class="phpdocumentor-signature__argument"><span>, </span><span class="phpdocumentor-signature__argument__return-type"><abbr title="\GuzzleHttp\Psr7\Response">Response</abbr> </span><span class="phpdocumentor-signature__argument__name">$response</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">mixed</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$message</span> : <span class="phpdocumentor-signature__argument__return-type">string</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$response</span> : <span class="phpdocumentor-signature__argument__return-type"><abbr title="\GuzzleHttp\Psr7\Response">Response</abbr></span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl> </article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getBody() [](classes/NPR-One-Exceptions-ApiException.html#method_getBody) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Exceptions/ApiException.php">[<abbr title="src/Exceptions/ApiException.php">ApiException.php</abbr>](files/src-exceptions-apiexception.html)</abbr> : <span class="phpdocumentor-element-found-in__line">74</span> </aside>Returns the body of the response from the failed API call. May be empty.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getBody</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type"><abbr title="\GuzzleHttp\Psr7\Stream">Stream</abbr></span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type"><abbr title="\GuzzleHttp\Psr7\Stream">Stream</abbr></span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getStatusCode() [](classes/NPR-One-Exceptions-ApiException.html#method_getStatusCode) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Exceptions/ApiException.php">[<abbr title="src/Exceptions/ApiException.php">ApiException.php</abbr>](files/src-exceptions-apiexception.html)</abbr> : <span class="phpdocumentor-element-found-in__line">54</span> </aside>Returns the HTTP status code from the failed API call; should generally always be 400 or greater.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getStatusCode</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">int</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">int</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getStatusText() [](classes/NPR-One-Exceptions-ApiException.html#method_getStatusText) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Exceptions/ApiException.php">[<abbr title="src/Exceptions/ApiException.php">ApiException.php</abbr>](files/src-exceptions-apiexception.html)</abbr> : <span class="phpdocumentor-element-found-in__line">64</span> </aside>Returns the HTTP status text (a.k.a. reason phrase) from the failed API call.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getStatusText</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> </section><div class="phpdocumentor-modal" id="source-view"><div class="phpdocumentor-modal-bg" data-exit-button=""></div><div class="phpdocumentor-modal-container"><div class="phpdocumentor-modal-content"> ```
```

 </div> <button class="phpdocumentor-modal__close" data-exit-button="">×</button> </div></div> <script type="text/javascript">
        (function () {
            function loadExternalCodeSnippet(el, url, line) {
                Array.prototype.slice.call(el.querySelectorAll('pre[data-src]')).forEach((pre) => {
                    const src = url || pre.getAttribute('data-src').replace(/\\/g, '/');
                    const language = 'php';

                    const code = document.createElement('code');
                    code.className = 'language-' + language;
                    pre.textContent = '';
                    pre.setAttribute('data-line', line)
                    code.textContent = 'Loading…';
                    pre.appendChild(code);

                    var xhr = new XMLHttpRequest();

                    xhr.open('GET', src, true);

                    xhr.onreadystatechange = function () {
                        if (xhr.readyState !== 4) {
                            return;
                        }

                        if (xhr.status < 400 && xhr.responseText) {
                            code.textContent = xhr.responseText;
                            Prism.highlightElement(code);
                            d=document.getElementsByClassName("line-numbers");
                            d[0].scrollTop = d[0].children[1].offsetTop;
                            return;
                        }

                        if (xhr.status === 404) {
                            code.textContent = '✖ Error: File could not be found';
                            return;
                        }

                        if (xhr.status >= 400) {
                            code.textContent = '✖ Error ' + xhr.status + ' while fetching file: ' + xhr.statusText;
                            return;
                        }

                        code.textContent = '✖ Error: An unknown error occurred';
                    };

                    xhr.send(null);
                });
            }

            const modalButtons = document.querySelectorAll("[data-modal]");
            const openedAsLocalFile = window.location.protocol === 'file:';
            if (modalButtons.length > 0 && openedAsLocalFile) {
                console.warn(
                    'Viewing the source code is unavailable because you are opening this page from the file:// scheme; ' +
                    'browsers block XHR requests when a page is opened this way'
                );
            }

            modalButtons.forEach(function (trigger) {
                if (openedAsLocalFile) {
                    trigger.setAttribute("hidden", "hidden");
                }

                trigger.addEventListener("click", function (event) {
                    event.preventDefault();
                    const modal = document.getElementById(trigger.dataset.modal);
                    if (!modal) {
                        console.error(`Modal with id "${trigger.dataset.modal}" could not be found`);
                        return;
                    }
                    modal.classList.add("phpdocumentor-modal__open");

                    loadExternalCodeSnippet(modal, trigger.dataset.src || null, trigger.dataset.line)
                    const exits = modal.querySelectorAll("[data-exit-button]");
                    exits.forEach(function (exit) {
                        exit.addEventListener("click", function (event) {
                            event.preventDefault();
                            modal.classList.remove("phpdocumentor-modal__open");
                        });
                    });
                });
            });
        })();
    </script> </article> </section> <section class="phpdocumentor-on-this-page__sidebar"> <section class="phpdocumentor-on-this-page__content"> **On this page**- Table Of Contents
- - [Methods](classes/NPR-One-Exceptions-ApiException.html#toc-methods)
- Methods
- - [\_\_construct()](classes/NPR-One-Exceptions-ApiException.html#method___construct)
    - [getBody()](classes/NPR-One-Exceptions-ApiException.html#method_getBody)
    - [getStatusCode()](classes/NPR-One-Exceptions-ApiException.html#method_getStatusCode)
    - [getStatusText()](classes/NPR-One-Exceptions-ApiException.html#method_getStatusText)
 
 </section> </section> </div> <section class="phpdocumentor-search-results phpdocumentor-search-results--hidden" data-search-results=""> <section class="phpdocumentor-search-results__dialog"> <header class="phpdocumentor-search-results__header">Search results
--------------

 <button class="phpdocumentor-search-results__close"></button> </header> <section class="phpdocumentor-search-results__body">
 </section> </section></section> </div> [](classes/NPR-One-Exceptions-ApiException.html#top) </main> <script>
        cssVars({});
    </script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/autoloader/prism-autoloader.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.min.js"></script>