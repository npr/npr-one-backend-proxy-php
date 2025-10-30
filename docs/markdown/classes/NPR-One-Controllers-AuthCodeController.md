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
- [Controllers](namespaces/npr-one-controllers.html)
 
 <article class="phpdocumentor-element -class"> AuthCodeController <span class="phpdocumentor-element__extends"> extends <abbr title="\NPR\One\Controllers\AbstractOAuth2Controller">AbstractOAuth2Controller</abbr> </span><div class="phpdocumentor-element__package"> in package - [NPR](packages/NPR.html)
- [One](packages/NPR-One.html)
- [Controllers](packages/NPR-One-Controllers.html)
 
 </div> 
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<div class="phpdocumentor-label-line"></div> <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">20</span> </aside>Use this controller to power your OAuth2 proxy if you are using the `authorization\_code` grant.

 <section class="phpdocumentor-description">The consumer of this codebase is responsible for setting up a router which forwards on the relevant requests to the [<abbr title="\NPR\One\Controllers\AuthCodeController::startAuthorizationGrant()">AuthCodeController::startAuthorizationGrant()</abbr>](classes/NPR-One-Controllers-AuthCodeController.html#method_startAuthorizationGrant) and [<abbr title="\NPR\One\Controllers\AuthCodeController::completeAuthorizationGrant()">AuthCodeController::completeAuthorizationGrant()</abbr>](classes/NPR-One-Controllers-AuthCodeController.html#method_completeAuthorizationGrant)public methods in this class.

</section>###  Table of Contents [](classes/NPR-One-Controllers-AuthCodeController.html#toc)

####  Methods [](classes/NPR-One-Controllers-AuthCodeController.html#toc-methods)

<dl class="phpdocumentor-table-of-contents"> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [\_\_construct()](classes/NPR-One-Controllers-AuthCodeController.html#method___construct) <span> : mixed </span></dt><dd>{@inheritdoc}</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [completeAuthorizationGrant()](classes/NPR-One-Controllers-AuthCodeController.html#method_completeAuthorizationGrant) <span> : [<abbr title="\NPR\One\Models\AccessTokenModel">AccessTokenModel</abbr>](classes/NPR-One-Models-AccessTokenModel.html) </span></dt><dd>Finishes the authorization grant flow</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getRedirectUri()](classes/NPR-One-Controllers-AuthCodeController.html#method_getRedirectUri) <span> : string </span></dt><dd>Returns the webapp URL as set in the configuration provider.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [setConfigProvider()](classes/NPR-One-Controllers-AuthCodeController.html#method_setConfigProvider) <span> : mixed </span></dt><dd>{@inheritdoc}</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [setStorageProvider()](classes/NPR-One-Controllers-AuthCodeController.html#method_setStorageProvider) <span> : $this </span></dt><dd>Sets a storage provider to use across PHP sessions. Used to validate the OAuth `state` param.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [startAuthorizationGrant()](classes/NPR-One-Controllers-AuthCodeController.html#method_startAuthorizationGrant) <span> : string </span></dt><dd>Kicks off a new authorization grant flow</dd> </dl> <section class="phpdocumentor-methods">###  Methods [](classes/NPR-One-Controllers-AuthCodeController.html#methods) 

 <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  \_\_construct() [](classes/NPR-One-Controllers-AuthCodeController.html#method___construct) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">36</span> </aside>{@inheritdoc}

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">__construct</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">mixed</span>`<div class="phpdocumentor-label-line"> </div> </article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  completeAuthorizationGrant() [](classes/NPR-One-Controllers-AuthCodeController.html#method_completeAuthorizationGrant) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">134</span> </aside>Finishes the authorization grant flow

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">completeAuthorizationGrant</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">string </span><span class="phpdocumentor-signature__argument__name">$authorizationCode</span></span><span class="phpdocumentor-signature__argument"><span>, </span><span class="phpdocumentor-signature__argument__return-type">string </span><span class="phpdocumentor-signature__argument__name">$state</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type"><a href="classes/NPR-One-Models-AccessTokenModel.html"><abbr title="\NPR\One\Models\AccessTokenModel">AccessTokenModel</abbr></a></span>`<div class="phpdocumentor-label-line"><div class="phpdocumentor-label phpdocumentor-label--success"><span>API</span><span>Yes</span></div> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$authorizationCode</span> : <span class="phpdocumentor-signature__argument__return-type">string</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$state</span> : <span class="phpdocumentor-signature__argument__return-type">string</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl>#####  Tags [](classes/NPR-One-Controllers-AuthCodeController.html#method_completeAuthorizationGrant#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\InvalidArgumentException">InvalidArgumentException</abbr></span> </dd> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\Exception">Exception</abbr></span> <section class="phpdocumentor-description">when state param is invalid

</section> </dd> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\GuzzleHttp\Exception\GuzzleException">GuzzleException</abbr></span> </dd> </dl> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">[<abbr title="\NPR\One\Models\AccessTokenModel">AccessTokenModel</abbr>](classes/NPR-One-Models-AccessTokenModel.html)</span> — <section class="phpdocumentor-description">- useful for debugging

</section> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getRedirectUri() [](classes/NPR-One-Controllers-AuthCodeController.html#method_getRedirectUri) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">84</span> </aside>Returns the webapp URL as set in the configuration provider.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getRedirectUri</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  setConfigProvider() [](classes/NPR-One-Controllers-AuthCodeController.html#method_setConfigProvider) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">45</span> </aside>{@inheritdoc}

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">setConfigProvider</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type"><a href="classes/NPR-One-Interfaces-ConfigInterface.html"><abbr title="\NPR\One\Interfaces\ConfigInterface">ConfigInterface</abbr></a> </span><span class="phpdocumentor-signature__argument__name">$configProvider</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">mixed</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$configProvider</span> : <span class="phpdocumentor-signature__argument__return-type">[<abbr title="\NPR\One\Interfaces\ConfigInterface">ConfigInterface</abbr>](classes/NPR-One-Interfaces-ConfigInterface.html)</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl> </article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  setStorageProvider() [](classes/NPR-One-Controllers-AuthCodeController.html#method_setStorageProvider) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">59</span> </aside>Sets a storage provider to use across PHP sessions. Used to validate the OAuth `state` param.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">setStorageProvider</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type"><a href="classes/NPR-One-Interfaces-StorageInterface.html"><abbr title="\NPR\One\Interfaces\StorageInterface">StorageInterface</abbr></a> </span><span class="phpdocumentor-signature__argument__name">$storageProvider</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">$this</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$storageProvider</span> : <span class="phpdocumentor-signature__argument__return-type">[<abbr title="\NPR\One\Interfaces\StorageInterface">StorageInterface</abbr>](classes/NPR-One-Interfaces-StorageInterface.html)</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">$this</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  startAuthorizationGrant() [](classes/NPR-One-Controllers-AuthCodeController.html#method_startAuthorizationGrant) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Controllers/AuthCodeController.php">[<abbr title="src/Controllers/AuthCodeController.php">AuthCodeController.php</abbr>](files/src-controllers-authcodecontroller.html)</abbr> : <span class="phpdocumentor-element-found-in__line">102</span> </aside>Kicks off a new authorization grant flow

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">startAuthorizationGrant</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">array<string|int, string> </span><span class="phpdocumentor-signature__argument__name">$scopes</span></span><span class="phpdocumentor-signature__argument"><span>[</span><span>, </span><span class="phpdocumentor-signature__argument__return-type">string|null </span><span class="phpdocumentor-signature__argument__name">$email</span><span> = </span><span class="phpdocumentor-signature__argument__default-value">null</span><span> ]</span></span><span class="phpdocumentor-signature__argument"><span>[</span><span>, </span><span class="phpdocumentor-signature__argument__return-type">string|null </span><span class="phpdocumentor-signature__argument__name">$userId</span><span> = </span><span class="phpdocumentor-signature__argument__default-value">null</span><span> ]</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"><div class="phpdocumentor-label phpdocumentor-label--success"><span>API</span><span>Yes</span></div> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$scopes</span> : <span class="phpdocumentor-signature__argument__return-type">array&lt;string|int, string&gt;</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$email</span> : <span class="phpdocumentor-signature__argument__return-type">string|null</span> = <span class="phpdocumentor-signature__argument__default-value">null</span> </dt> <dd class="phpdocumentor-argument-list__definition"> <section class="phpdocumentor-description">- This email address will be used to pre-populate the login page.

</section> </dd> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$userId</span> : <span class="phpdocumentor-signature__argument__return-type">string|null</span> = <span class="phpdocumentor-signature__argument__default-value">null</span> </dt> <dd class="phpdocumentor-argument-list__definition"> <section class="phpdocumentor-description">- User id if known

</section> </dd> </dl>#####  Tags [](classes/NPR-One-Controllers-AuthCodeController.html#method_startAuthorizationGrant#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\InvalidArgumentException">InvalidArgumentException</abbr></span> </dd> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\Exception">Exception</abbr></span> </dd> </dl> <section>##### Return values

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
- - [Methods](classes/NPR-One-Controllers-AuthCodeController.html#toc-methods)
- Methods
- - [\_\_construct()](classes/NPR-One-Controllers-AuthCodeController.html#method___construct)
    - [completeAuthorizationGrant()](classes/NPR-One-Controllers-AuthCodeController.html#method_completeAuthorizationGrant)
    - [getRedirectUri()](classes/NPR-One-Controllers-AuthCodeController.html#method_getRedirectUri)
    - [setConfigProvider()](classes/NPR-One-Controllers-AuthCodeController.html#method_setConfigProvider)
    - [setStorageProvider()](classes/NPR-One-Controllers-AuthCodeController.html#method_setStorageProvider)
    - [startAuthorizationGrant()](classes/NPR-One-Controllers-AuthCodeController.html#method_startAuthorizationGrant)
 
 </section> </section> </div> <section class="phpdocumentor-search-results phpdocumentor-search-results--hidden" data-search-results=""> <section class="phpdocumentor-search-results__dialog"> <header class="phpdocumentor-search-results__header">Search results
--------------

 <button class="phpdocumentor-search-results__close"></button> </header> <section class="phpdocumentor-search-results__body">
 </section> </section></section> </div> [](classes/NPR-One-Controllers-AuthCodeController.html#top) </main> <script>
        cssVars({});
    </script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/autoloader/prism-autoloader.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.min.js"></script>