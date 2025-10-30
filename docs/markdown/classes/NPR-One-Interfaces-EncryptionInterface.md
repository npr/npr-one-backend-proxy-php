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
 
 <article class="phpdocumentor-element -interface"> EncryptionInterface <div class="phpdocumentor-element__package"> in - [NPR](packages/NPR.html)
- [One](packages/NPR-One.html)
- [Interfaces](packages/NPR-One-Interfaces.html)
 
 </div> 
------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/EncryptionInterface.php">[<abbr title="src/Interfaces/EncryptionInterface.php">EncryptionInterface.php</abbr>](files/src-interfaces-encryptioninterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">11</span> </aside>Establishes a set of requirements for the encryption provider for the project

###  Table of Contents [](classes/NPR-One-Interfaces-EncryptionInterface.html#toc)

####  Methods [](classes/NPR-One-Interfaces-EncryptionInterface.html#toc-methods)

<dl class="phpdocumentor-table-of-contents"> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [decrypt()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_decrypt) <span> : string </span></dt><dd>Securely decrypts the given text.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [encrypt()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_encrypt) <span> : string </span></dt><dd>Securely encrypts the given text.</dd> <dt class="phpdocumentor-table-of-contents__entry -method -public"> [isValid()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_isValid) <span> : bool </span></dt><dd>Returns whether or not this EncryptionProvider is valid and ready to be used. This is a good place to perform checks such as making sure any particular PHP extensions or packages required for this encryption algorithm are installed. If no such checks are required, just hard-code the function to return true.</dd> </dl> <section class="phpdocumentor-methods">###  Methods [](classes/NPR-One-Interfaces-EncryptionInterface.html#methods) 

 <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  decrypt() [](classes/NPR-One-Interfaces-EncryptionInterface.html#method_decrypt) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/EncryptionInterface.php">[<abbr title="src/Interfaces/EncryptionInterface.php">EncryptionInterface.php</abbr>](files/src-interfaces-encryptioninterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">39</span> </aside>Securely decrypts the given text.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">decrypt</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">string </span><span class="phpdocumentor-signature__argument__name">$value</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$value</span> : <span class="phpdocumentor-signature__argument__return-type">string</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl>#####  Tags [](classes/NPR-One-Interfaces-EncryptionInterface.html#method_decrypt#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\InvalidArgumentException">InvalidArgumentException</abbr></span> <section class="phpdocumentor-description">if no value is passed in, or the value isn't a string

</section> </dd> </dl> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  encrypt() [](classes/NPR-One-Interfaces-EncryptionInterface.html#method_encrypt) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/EncryptionInterface.php">[<abbr title="src/Interfaces/EncryptionInterface.php">EncryptionInterface.php</abbr>](files/src-interfaces-encryptioninterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">30</span> </aside>Securely encrypts the given text.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">encrypt</span><span>(</span><span class="phpdocumentor-signature__argument"><span class="phpdocumentor-signature__argument__return-type">string </span><span class="phpdocumentor-signature__argument__name">$value</span></span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">string</span>`<div class="phpdocumentor-label-line"> </div>##### Parameters

 <dl class="phpdocumentor-argument-list"> <dt class="phpdocumentor-argument-list__entry"> <span class="phpdocumentor-signature__argument__name">$value</span> : <span class="phpdocumentor-signature__argument__return-type">string</span> </dt> <dd class="phpdocumentor-argument-list__definition"> </dd> </dl>#####  Tags [](classes/NPR-One-Interfaces-EncryptionInterface.html#method_encrypt#tags) 

 <dl class="phpdocumentor-tag-list"> <dt class="phpdocumentor-tag-list__entry"> <span class="phpdocumentor-tag__name">throws</span> </dt> <dd class="phpdocumentor-tag-list__definition"> <span class="phpdocumentor-tag-link"><abbr title="\InvalidArgumentException">InvalidArgumentException</abbr></span> <section class="phpdocumentor-description">if no value is passed in, or the value isn't a string

</section> </dd> </dl> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">string</span> </section></article> <article class="phpdocumentor-element
            -method
            -public
                                                        ">####  isValid() [](classes/NPR-One-Interfaces-EncryptionInterface.html#method_isValid) 

 <aside class="phpdocumentor-element-found-in"> <abbr class="phpdocumentor-element-found-in__file" title="src/Interfaces/EncryptionInterface.php">[<abbr title="src/Interfaces/EncryptionInterface.php">EncryptionInterface.php</abbr>](files/src-interfaces-encryptioninterface.html)</abbr> : <span class="phpdocumentor-element-found-in__line">21</span> </aside>Returns whether or not this EncryptionProvider is valid and ready to be used. This is a good place to perform checks such as making sure any particular PHP extensions or packages required for this encryption algorithm are installed. If no such checks are required, just hard-code the function to return true.

 `    <span class="phpdocumentor-signature__visibility">public</span>                    <span class="phpdocumentor-signature__name">isValid</span><span>(</span><span>)</span><span> : </span><span class="phpdocumentor-signature__response_type">bool</span>`<div class="phpdocumentor-label-line"> </div> <section>##### Return values

 <span class="phpdocumentor-signature__response_type">bool</span> </section></article> </section><div class="phpdocumentor-modal" id="source-view"><div class="phpdocumentor-modal-bg" data-exit-button=""></div><div class="phpdocumentor-modal-container"><div class="phpdocumentor-modal-content"> ```
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
- - [Constants](classes/NPR-One-Interfaces-EncryptionInterface.html#toc-constants)
    - [Methods](classes/NPR-One-Interfaces-EncryptionInterface.html#toc-methods)
- Methods
- - [decrypt()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_decrypt)
    - [encrypt()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_encrypt)
    - [isValid()](classes/NPR-One-Interfaces-EncryptionInterface.html#method_isValid)
 
 </section> </section> </div> <section class="phpdocumentor-search-results phpdocumentor-search-results--hidden" data-search-results=""> <section class="phpdocumentor-search-results__dialog"> <header class="phpdocumentor-search-results__header">Search results
--------------

 <button class="phpdocumentor-search-results__close"></button> </header> <section class="phpdocumentor-search-results__body">
 </section> </section></section> </div> [](classes/NPR-One-Interfaces-EncryptionInterface.html#top) </main> <script>
        cssVars({});
    </script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/prism.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/autoloader/prism-autoloader.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-numbers/prism-line-numbers.min.js"></script> <script src="https://cdn.jsdelivr.net/npm/prismjs@1.23.0/plugins/line-highlight/prism-line-highlight.min.js"></script>