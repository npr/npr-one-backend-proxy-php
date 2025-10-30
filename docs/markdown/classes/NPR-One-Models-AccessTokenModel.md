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
- [Models](namespaces/npr-one-models.html)
 
 <article class="phpdocumentor-element -class"> AccessTokenModel <span class="phpdocumentor-element__extends"> extends [<abbr title="\NPR\One\Models\JsonModel">JsonModel</abbr>](classes/NPR-One-Models-JsonModel.html) </span><div class="phpdocumentor-element__package"> in package - [NPR](packages/NPR.html)
- [One](packages/NPR-One.html)
- [Models](packages/NPR-One-Models.html)
 
 </div> 
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<div class="phpdocumentor-label-line"></div> <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">11</span> </aside>A thin wrapper around an access token, based on the raw JSON returned from the `POST /token` endpoint.

###  Table of Contents [](classes/NPR-One-Models-AccessTokenModel.html#toc)

####  Methods [](classes/NPR-One-Models-AccessTokenModel.html#toc-methods)

<dl class="phpdocumentor-table-of-contents"> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [\_\_construct()](classes/NPR-One-Models-AccessTokenModel.html#method___construct) <span> : mixed </span></dt><dd>AccessTokenModel constructor.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [\_\_toString()](classes/NPR-One-Models-JsonModel.html#method___toString) <span> : string </span></dt><dd>Re-encodes the original JSON model as a string and returns it.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getAccessToken()](classes/NPR-One-Models-AccessTokenModel.html#method_getAccessToken) <span> : string </span></dt><dd>Returns the access token itself -- a 40-character, alphanumeric string.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getExpiresIn()](classes/NPR-One-Models-AccessTokenModel.html#method_getExpiresIn) <span> : int </span></dt><dd>Returns the remaining seconds in the lifetime of the access token.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getRefreshToken()](classes/NPR-One-Models-AccessTokenModel.html#method_getRefreshToken) <span> : null|string </span></dt><dd>Returns the refresh token associated with this access token, if it exists.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getTokenType()](classes/NPR-One-Models-AccessTokenModel.html#method_getTokenType) <span> : string </span></dt><dd>Returns the type of token, usually assumed to be `Bearer`.</dd> </dl> <section class="phpdocumentor-methods">###  Methods [](classes/NPR-One-Models-AccessTokenModel.html#methods) 

 <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  \_\_construct() [](classes/NPR-One-Models-AccessTokenModel.html#method___construct) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">33</span> </aside>AccessTokenModel constructor.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">__construct</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">mixed </span><span class="phpdocumentor-signature__argument__name">$json</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">mixed</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$json</span> : <span class="phpdocumentor-signature__argument__return-type">mixed</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl>#####  Tags [](classes/NPR-One-Models-AccessTokenModel.html#method___construct#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\Exception">Exception</abbr></span> </dd> </dl> </article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  \_\_toString() [](classes/NPR-One-Models-JsonModel.html#method___toString) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/JsonModel.php">[<abbr title="src/Models/JsonModel.php">JsonModel.php</abbr>](files/src-models-jsonmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">38</span> </aside>Re-encodes the original JSON model as a string and returns it.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">__toString</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getAccessToken() [](classes/NPR-One-Models-AccessTokenModel.html#method_getAccessToken) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">57</span> </aside>Returns the access token itself -- a 40-character, alphanumeric string.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getAccessToken</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getExpiresIn() [](classes/NPR-One-Models-AccessTokenModel.html#method_getExpiresIn) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">77</span> </aside>Returns the remaining seconds in the lifetime of the access token.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getExpiresIn</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">int</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">int</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getRefreshToken() [](classes/NPR-One-Models-AccessTokenModel.html#method_getRefreshToken) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">87</span> </aside>Returns the refresh token associated with this access token, if it exists.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getRefreshToken</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">null|string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">null|string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getTokenType() [](classes/NPR-One-Models-AccessTokenModel.html#method_getTokenType) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Models/AccessTokenModel.php">[<abbr title="src/Models/AccessTokenModel.php">AccessTokenModel.php</abbr>](files/src-models-accesstokenmodel.html)</abbr> : <span class="phpdocumentor-element-found-in__line">67</span> </aside>Returns the type of token, usually assumed to be `Bearer`.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getTokenType</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

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
- - [Methods](classes/NPR-One-Models-AccessTokenModel.html#toc-methods)
- Methods
- - [\_\_construct()](classes/NPR-One-Models-AccessTokenModel.html#method___construct)
    - [\_\_toString()](classes/NPR-One-Models-JsonModel.html#method___toString)
    - [getAccessToken()](classes/NPR-One-Models-AccessTokenModel.html#method_getAccessToken)
    - [getExpiresIn()](classes/NPR-One-Models-AccessTokenModel.html#method_getExpiresIn)
    - [getRefreshToken()](classes/NPR-One-Models-AccessTokenModel.html#method_getRefreshToken)
    - [getTokenType()](classes/NPR-One-Models-AccessTokenModel.html#method_getTokenType)
 
 </section> </section> </div> <section class="phpdocumentor-search-results phpdocumentor-search-results--hidden" data-search-results=""> <section class="phpdocumentor-search-results__dialog"> <header class="phpdocumentor-search-results__header">Search results
--------------

 <button class="phpdocumentor-search-results__close"></button> </header> <section class="phpdocumentor-search-results__body">
 </section> </section></section> </div> [](classes/NPR-One-Models-AccessTokenModel.html#top) </main> <script>
        cssVars({});
    </script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/autoloader/prism-autoloader.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.min.js"></script>