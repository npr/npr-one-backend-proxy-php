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
- [Interfaces](namespaces/npr-one-interfaces.html)
 
 <article class="phpdocumentor-element -interface"> ConfigInterface <div class="phpdocumentor-element__package"> in - [NPR](packages/NPR.html)
- [One](packages/NPR-One.html)
- [Interfaces](packages/NPR-One-Interfaces.html)
 
 </div> 
--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">11</span> </aside>Establishes a set of requirements for the configuration provider for the project

###  Table of Contents [](classes/NPR-One-Interfaces-ConfigInterface.html#toc)

####  Methods [](classes/NPR-One-Interfaces-ConfigInterface.html#toc-methods)

<dl class="phpdocumentor-table-of-contents"> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getAuthCodeCallbackUrl()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getAuthCodeCallbackUrl) <span> : string </span></dt><dd>Returns the url of this backend proxy, corresponding specifically to the path that invokes `completeAuthorizationGrant()` in the AuthCodeController. This is where the `authorization\_code` flow first redirects to; this URL \*\*must\*\* be added as a valid `redirect\_uri` in the NPR One Developer Center's Developer Console.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getClientCredentialsToken()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientCredentialsToken) <span> : string </span></dt><dd>Returns a single, static client credentials token associated with the same `client\_id` from `getClientId()` above that we can use for the logout/disconnect functionality. (See also: `LogoutController`.)</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getClientId()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientId) <span> : string </span></dt><dd>Returns the NPR One OAuth2 client ID, obtainable from the NPR One Developer Center's Developer Console</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getClientSecret()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientSecret) <span> : string </span></dt><dd>Returns the NPR One OAuth2 client secret, obtainable from the NPR One Developer Center's Developer Console</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getClientUrl()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientUrl) <span> : string </span></dt><dd>Returns the host (or path) of the NPR One application (the client/frontend). This is where the `authorization\_code` flow \*eventually\* redirects to, either when it has successfully obtained an access token or if there was an unrecoverable error. This is \*\*NOT\*\* the `redirect\_uri` that you've added in the NPR One Developer Center's Developer Console; see `getAuthCodeCallbackUrl()` for that.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getCookieDomain()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookieDomain) <span> : string|null </span></dt><dd>Returns the custom domain to use for your cookies. If your cookies do not require a custom domain, have this function return `null`.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getCookiePrefix()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookiePrefix) <span> : string </span></dt><dd>If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able to use a prefix to differentiate between them. In that case, have this function return a non-empty string. If your cookies do not require a prefix, have this function return an empty string (`''`).</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getEncryptionSalt()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getEncryptionSalt) <span> : string </span></dt><dd>Returns a salt to use for the default EncryptionProvider. If you are using your own custom secure storage provider and/or an encryption provider that does not require a salt, just have this function return an empty string.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [getNprAuthorizationServiceHost()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getNprAuthorizationServiceHost) <span> : string </span></dt><dd>Returns the NPR One Authorization Service hostname, useful for testing on staging environments.</dd> </dl> <section class="phpdocumentor-methods">###  Methods [](classes/NPR-One-Interfaces-ConfigInterface.html#methods) 

 <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getAuthCodeCallbackUrl() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getAuthCodeCallbackUrl) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">74</span> </aside>Returns the url of this backend proxy, corresponding specifically to the path that invokes `completeAuthorizationGrant()` in the AuthCodeController. This is where the `authorization\_code` flow first redirects to; this URL \*\*must\*\* be added as a valid `redirect\_uri` in the NPR One Developer Center's Developer Console.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getAuthCodeCallbackUrl</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section class="phpdocumentor-description">If you are using the `device_code` grant instead of the `authorization_code` grant, you do not need this function and can simply hard-code it to return an empty string.

</section> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getClientCredentialsToken() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientCredentialsToken) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">42</span> </aside>Returns a single, static client credentials token associated with the same `client\_id` from `getClientId()` above that we can use for the logout/disconnect functionality. (See also: `LogoutController`.)

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getClientCredentialsToken</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section class="phpdocumentor-description">Because there currently is no other use case requiring client credentials tokens, this proxy does not implement the functionality to generate a `client_credentials` token for you; you are expected to provide your own. The easiest method to do so is to go to our interactive API documentation at http://dev.npr.org/api/#!/authorization/createToken and plug in your `client_id` and `client_secret`, the only two parameters required by the `client_credentials`grant type. Currently, client credentials tokens never expire, so hard-coding it here is not an issue.

**Only** if your app does not provide any kind of logout/disconnect functionality (and you are not using `LogoutController` at all), you can set this function to return an empty string.

</section> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getClientId() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientId) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">18</span> </aside>Returns the NPR One OAuth2 client ID, obtainable from the NPR One Developer Center's Developer Console

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getClientId</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getClientSecret() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientSecret) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">25</span> </aside>Returns the NPR One OAuth2 client secret, obtainable from the NPR One Developer Center's Developer Console

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getClientSecret</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getClientUrl() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientUrl) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">63</span> </aside>Returns the host (or path) of the NPR One application (the client/frontend). This is where the `authorization\_code` flow \*eventually\* redirects to, either when it has successfully obtained an access token or if there was an unrecoverable error. This is \*\*NOT\*\* the `redirect\_uri` that you've added in the NPR One Developer Center's Developer Console; see `getAuthCodeCallbackUrl()` for that.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getClientUrl</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section class="phpdocumentor-description">If you are using the `device_code` grant instead of the `authorization_code` grant, you do not need this function and can simply hard-code it to return an empty string.

</section> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getCookieDomain() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookieDomain) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">82</span> </aside>Returns the custom domain to use for your cookies. If your cookies do not require a custom domain, have this function return `null`.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getCookieDomain</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string|null</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string|null</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getCookiePrefix() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookiePrefix) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">91</span> </aside>If you have multiple proxies living on one server and are using the same cookie domain, you may need to be able to use a prefix to differentiate between them. In that case, have this function return a non-empty string. If your cookies do not require a prefix, have this function return an empty string (`''`).

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getCookiePrefix</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getEncryptionSalt() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getEncryptionSalt) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">99</span> </aside>Returns a salt to use for the default EncryptionProvider. If you are using your own custom secure storage provider and/or an encryption provider that does not require a salt, just have this function return an empty string.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getEncryptionSalt</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  getNprAuthorizationServiceHost() [](classes/NPR-One-Interfaces-ConfigInterface.html#method_getNprAuthorizationServiceHost) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/ConfigInterface.php">[<abbr title="src/Interfaces/ConfigInterface.php">ConfigInterface.php</abbr>](files/src-interfaces-configinterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">51</span> </aside>Returns the NPR One Authorization Service hostname, useful for testing on staging environments.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">getNprAuthorizationServiceHost</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div> <section class="phpdocumentor-description">Most consumers will want to hard-code this to always return `https://authorization.api.npr.org`. Please do not include a trailing slash.

</section> <section>##### Return values

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
- - [Constants](classes/NPR-One-Interfaces-ConfigInterface.html#toc-constants)
    - [Methods](classes/NPR-One-Interfaces-ConfigInterface.html#toc-methods)
- Methods
- - [getAuthCodeCallbackUrl()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getAuthCodeCallbackUrl)
    - [getClientCredentialsToken()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientCredentialsToken)
    - [getClientId()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientId)
    - [getClientSecret()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientSecret)
    - [getClientUrl()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getClientUrl)
    - [getCookieDomain()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookieDomain)
    - [getCookiePrefix()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getCookiePrefix)
    - [getEncryptionSalt()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getEncryptionSalt)
    - [getNprAuthorizationServiceHost()](classes/NPR-One-Interfaces-ConfigInterface.html#method_getNprAuthorizationServiceHost)
 
 </section> </section> </div> <section class="phpdocumentor-search-results phpdocumentor-search-results--hidden" data-search-results=""> <section class="phpdocumentor-search-results__dialog"> <header class="phpdocumentor-search-results__header">Search results
--------------

 <button class="phpdocumentor-search-results__close"></button> </header> <section class="phpdocumentor-search-results__body">
 </section> </section></section> </div> [](classes/NPR-One-Interfaces-ConfigInterface.html#top) </main> <script>
        cssVars({});
    </script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/autoloader/prism-autoloader.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.min.js"></script>