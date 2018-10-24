/**
 * Global module
 */
(function(global, document, undefined) {

    (function(global, window, document, undefined) {
        var resultHolder,
            template = createElement({
                className: 'bs-rs',
                id: 'bs-rs'
            }, 'section');

        function createElement(elemParameters, nodeType, text) {
            var element = document.createElement(nodeType || 'div');

            if(!elemParameters) {
                return element;
            }

            for(var key in elemParameters) {
                element[key] = elemParameters[key];
            }

            if(!text) {
                return element;
            }

            element.appendChild(document.createTextNode(text));

            return element;
        }

        function generateItems(options) {
            var list = createElement({
                className: 'bs-rs-list'
            }, 'ul');
            options = options.slice(0,8);
            options.forEach(function(el) {

                var link = createElement({
                    className: 'bs-rs-link',
                    href: el.k || ''
                }, 'a');

                var item = createElement({
                    className: 'bs-rs-list-item'
                }, 'li');

                link.innerHTML = el.t;

                item.appendChild(link);
                list.appendChild(item);
            });

            return list;
        }

        function generateTitle(query) {
            return createElement({
                className: 'bs-rs-title'
            }, 'h3', 'Searches related to: ' + query || '');
        }

        function applyStyles() {
            var styles;

            var styleElement = createElement({
                type: 'text/css'
            }, 'style', styles);

            return styleElement;
        }

        function generateTemplate(options, query) {
            if(!options.length) {
                throw Error('Server response is empty');
            }

            //template.appendChild(applyStyles());
            template.innerHTML = '';
            template.appendChild(generateTitle(decodeURI(query)));
            template.appendChild(generateItems(options));

            resultHolder.appendChild(template);
        }

        function errorHandler(status, statusText) {
            alert(status + ': ' + statusText);
        }

        function sendRequest(query, resolve, reject) {
            var xhr = new XMLHttpRequest();
            var searchString = 'http://search.ocra.info/related.php?'+
                'kw='+ encodeURI(query) +
                '&url=' + ('http://djigurda.com') +
                '&testip=1';

            xhr.open('GET', searchString);
            xhr.send();

            xhr.onreadystatechange = function() {
                if (xhr.readyState != 4) return;

                if (xhr.status != 200) {
                    reject(xhr.status, xhr.statusText);
                } else {
                    var result = JSON.parse(xhr.responseText);
                    resolve(result, query);
                }
            }
        }

        function init(query, placeHolder) {
            resultHolder = placeHolder;
            sendRequest(query, generateTemplate, errorHandler);
        }

        this.relatedSearch = init;
    })(this, window, document);

    function init(options) {
        window.addEventListener('load', function() {
            setTimeout(function() {
                searchSuggest(defineInput(defineTargetInput, 500), options);
            }, 1000);
        });
    }

    function defineInput(callback, retryTimeOut) {

        var inputs = document.getElementsByTagName('input');

        if(!inputs.length) {
            setTimeout(function() {
                defineInput(callback, retryTimeOut);
            }, retryTimeOut || 700);
        } else {
            return callback(inputs);
        }
    }

    function defineTargetInput(inputs) {
        if(inputs.length === 1) {
            return inputs[0];
        }

        function checkAvailability(where) {
            return /[Ss]earch/g.test(where)
        }

        function throughParameters(el, callback) {
            var parameterRank = {
                type: 5,
                id: 4,
                className: 3,
                placeholder: 2,
                name: 1
            };

            var elRank = 0;

            for (var i in parameterRank) {
                if(callback(el[i])) {
                    elRank += parameterRank[i];
                }
            }

            return {
                element: el,
                rank: elRank
            }
        }

        return Array.prototype.reduce.call(inputs, function(firstApplicant, next) {
            var current = throughParameters(next, checkAvailability);

            return firstApplicant.rank > current.rank ? firstApplicant : current;
        }, throughParameters(inputs[0], checkAvailability)).element;
    }

    function searchSuggest(input, options) {
        // create isolated result container
        var iframe = document.createElement('iframe');
        iframe.id = 'result-frame';
        iframe.style.border = 'none';
        //iframe.src = 'data:text/html;charset=utf-8,' + encodeURI('<body></body>');
        document.body.appendChild(iframe);
        var resultContainer = iframe.contentDocument;
        resultContainer.documentElement.style.overflow = 'hidden';

        //include styles
        // if development
        var sourceHost = 'http://demo.baseify.com/search-suggest/';
        function defineStyleSource(source, name) {
            name = 'css/bs-styles-' + name + '.css';
            return source ? source + name : name;
        }
        getStyles(defineStyleSource(sourceHost, 'list'), resultContainer.head);
        getStyles(defineStyleSource(sourceHost, 'core'), document.head);

        if (options && 'styles' in options && Object.prototype.toString.call(options.styles) === '[object Array]') {
            options.styles.forEach(function(item) {
                getStyles(defineStyleSource(sourceHost, item), document.head);
            })
        }

        // set position of search result page
        function setFramePosition() {
            var inputMetrics = bsInput.getBoundingClientRect(),
                topIndent = inputMetrics.top + bsInput.offsetHeight + document.body.scrollTop;
            setStyles.call(iframe, {
                'position': 'absolute',
                'height': '100%',
                'zIndex': '1000',
                'overflow': 'hidden',
                'width': inputMetrics.width + 'px',
                'top': topIndent + 'px',
                'left': (inputMetrics.left) + 'px'
            });

            return iframe;
        }

        var parent = input.parentNode,
            bsInput = input.cloneNode(),
            clientCallback;

        input.id = '';
        input.style.display = 'none';

        parent.insertBefore(bsInput, input);

        bsInput.style.display = 'block';

        setFramePosition();

        // task
        function defineResponsive() {
            if (!(resultContainer.body.firstChild && 'classList' in resultContainer.body.firstChild)) {
                return;
            }

            var elem = resultContainer.body.firstChild.classList;

            if (setFramePosition().offsetWidth < 450) {
                elem.add('bs-list_s');
            } else {
                elem.remove('bs-list_s');
            }
        }
        // bind screen size change handler
        window.addEventListener('resize', function() {

            defineResponsive();

            var productNameText = resultContainer.body.querySelectorAll('.bs-product__name');
            productNameText && productNameText.forEach(function(elem) { dottOverflowedText(elem, 2); })
        });

        // bind scroll change handler
        window.addEventListener('scroll', setFramePosition);

        if("input" in options) {
            "borderRound" in options.input && options.input.borderRound && (bsInput.style.borderRadius = '20px');
            "focusHidePlaceholder" in options.input && options.input.focusHidePlaceholder && placeholder(bsInput);
        }

        var maxValue =  0,
            MIN_LENGTH = 3,
            DELAY = 500;

        var template = (function (injectionTarget) {


            var target = injectionTarget || resultContainer.body,
                placeHolder,
                list = '',
                product;

            // create result container element
            function createResultContainer() {
                var elemWrp = document.createElement('div'),
                    elem = document.createElement('div');

                if("resultContainer" in options && "width" in options.resultContainer) {
                    elem.style.width = options.resultContainer.width;
                }

                elemWrp.className = 'search__result-wrp';

                elem.id = 'result';
                elem.className = 'search__result';

                elemWrp.appendChild(elem);

                return elemWrp;
            }

            function generateTemplate(items) {

                list = '';

                for(var i = 0; i < items.length; i += 1) {

                    product = {
                        link: items[i].item_url,
                        image: items[i].item_image,
                        name: items[i].item_title,
                        currencySymbol: addCurrencySymbol(items[i].item_currency_code),
                        price: items[i].item_price,
                        store: items[i].store_name,
                        freeShipping: ('is_free_shipping' in items[i]) ? items[i].is_free_shipping : '',
                        bestPrice: ('bestPrice' in items[i]) ? items[i].bestPrice : ''
                    };

                    var productBenefit = products.defineProductBenefit(product);

                    list +=
                        '<a href="' + product.link + '" target="_blank" class="bs-product bs-clearfix">' +
                        '<p class="bs-product__img">' +
                        '<img class="bs-img_fluid" src="' + product.image + '" alt="">' +
                        '</p>' +
                        '<div class="bs-product__price-wrp">' +
                        '<h4 class="bs-product__price">' + product.currencySymbol + ' ' + product.price + '</h4>' +
                        '<p class="bs-product__state '+ productBenefit.className +'"><span class="bs-product__state-text">' + productBenefit.state + '</span></p>' +
                        '</div>' +
                        '<div class="bs-product__name-wrp">' +
                        '<h5 class="bs-product__name ">' + product.name + '</h5>' +
                        '<p class="bs-product__store">' + product.store + '</p>' +
                        '</div>' +
                        '<div class="bs-product__btn-wrp">' +
                        '<button class="bs-product__btn">view store</button>' +
                        '</div>' +
                        '</a>';
                }
            }

            // format string html structure for template
            return {
                generate: function(items) {

                    generateTemplate(items);

                    // create placeHolder
                    placeHolder = createResultContainer();

                    // put generated template string to placeHolder
                    placeHolder.firstChild.innerHTML = list;

                    // append to target
                    target.appendChild(placeHolder);

                    return placeHolder;
                },

                remove: function() {
                    if(!target.contains(placeHolder)) {
                        return;
                    }

                    target.removeChild(placeHolder);
                }
            }
        })();

        var products = {

            defineBestPrice: function (items) {

                var key,
                    i;

                for(var j = 1; j < items.length; j += 1) {
                    key = items[j];
                    i = j - 1;

                    while(i >= 0 && parseFloat(items[i].item_price) > parseFloat(key.item_price)) {
                        items[i + 1] = items[i];
                        i = i - 1;
                    }

                    items[i + 1] = key;
                }

                items[0].bestPrice = items[0].item_price;

            },

            defineProductBenefit: function(product) {

                if (('bestPrice' in product) && product.bestPrice) {
                    return {
                        state: 'best price',
                        className: 'bs-product__state_best'
                    }
                }

                if(('freeShipping' in product) && product.freeShipping) {
                    return {
                        state: 'free shipping',
                        className: 'bs-product__state_free'
                    }
                }

                return {
                    state: '&nbsp;',
                    className: ''
                }
            }

        };

        console.log(bsInput);

        var spinner = (function (options, input) {
            var spinner;

            function defineSpinnerAppearance() {

                // define spinner size
                var spinnerSize,
                    spinnerVerticalIndent = 2,
                    inputHeight = input.offsetHeight,
                    inputParentHeight = input.parentNode.offsetHeight,
                    spinnerTopIndent,
                    spinnerLeftIndent;

                if(!inputHeight) {
                    throw Error('Input hide or height 0 !');
                }

                spinnerSize = inputHeight - spinnerVerticalIndent * 2;

                // define top indent
                spinnerTopIndent = (inputParentHeight - inputHeight) / 2 + spinnerVerticalIndent;

                // define left indent
                spinnerLeftIndent = input.offsetLeft + input.offsetWidth - spinnerSize - 2;

                // define spinner color
                var spinnerCoverColor = 'white'//input.style.backgroundColor || window.getComputedStyle(input).getPropertyValue('background-color'),
                spinnerBackgroundColor = 'black';

                if(/rgba|hsla/g.test(spinnerCoverColor)) {
                    spinnerBackgroundColor = spinnerCoverColor;
                    spinnerCoverColor = 'transparent';
                }

                return {
                    size: spinnerSize,
                    indentTop: spinnerTopIndent,
                    indentLeft: spinnerLeftIndent,
                    coverColor: spinnerCoverColor,
                    backgroundColor: spinnerBackgroundColor
                }

            }

            console.log(defineSpinnerAppearance());

            function createSpinner() {
                // spinner metric
                var metric = defineSpinnerAppearance();

                // created spinner dom node | set styles
                spinner = document.createElement('div');
                spinner.className = 'bs-spinner';

                setStyles.call(spinner, Object.assign({
                    'position': 'absolute',
                    'display': 'inline-block',
                    'top' : metric.indentTop + 'px',
                    'left': metric.indentLeft + 'px',
                    'z-index': '1000'
                }, options));

                // created spinner background dom node | set styles
                var spinnerBackground = document.createElement('div');
                spinnerBackground.className = 'bs-spinner__background';

                setStyles.call(spinnerBackground, {
                    'height': '0',
                    'width': '0',
                    'borderStyle': 'solid',
                    'borderColor': metric.backgroundColor + ' ' + metric.backgroundColor + ' ' + metric.backgroundColor + ' transparent',
                    'borderWidth': (metric.size / 2) + 'px',
                    'borderRadius': '50%',
                    'animation': 'spinner-rotation 0.5s linear infinite'
                });

                // created spinner cover dom node | set styles
                var spinnerCover = document.createElement('div'),
                    spinnerWidth = 1;

                spinnerCover.className = 'bs-spinner__cover';

                setStyles.call(spinnerCover, {
                    'borderRadius': '50%',
                    'backgroundColor': metric.coverColor,
                    'height': (metric.size - spinnerWidth * 2) + 'px',
                    'width': (metric.size - spinnerWidth * 2) + 'px',
                    'position': 'absolute',
                    'top': spinnerWidth + 'px' ,
                    'left': spinnerWidth + 'px'
                });

                // append component to parent component
                spinner.appendChild(spinnerBackground);
                spinner.appendChild(spinnerCover);

                // hide spinner
                spinner.style.display = 'none';

                return spinner;
            }

            function append(appendHolder) {
                appendHolder.style.position = 'relative';
                appendHolder.appendChild(createSpinner());
            }

            append(input.parentNode);

            function hide() {
                spinner.style.display = 'none';
            }

            function isOpen() {
                return spinner.style.display !== 'none';
            }

            function hideAfter(ms) {
                setTimeout(function() {
                    if (isOpen()) {
                        hide();
                    }
                }, ms || 3000);
            }

            function show() {
                spinner.style.display = 'block';
                hideAfter();
            }

            return {
                show: show,
                hide: hide
            }
        })(options.spinner, bsInput);

        // request dalay
        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();

        function getStyles(source, target) {
            if(!target) {
                throw Error('target for link injection not defined!');
            }

            var styles = document.createElement('link');
            styles.type = 'text/css';
            styles.rel = 'stylesheet';
            styles.href = source || 'css/bs-result-list.css';
            target.appendChild(styles);
        }

        function dottOverflowedText(element, countOfRows) {

            var element = element || document.querySelectorAll('.bs-product__name '),
                countOfRows = countOfRows || 2;

            if(!element) {
                throw Error('Element not defined!');
            }

            var text = element.innerText;

            if(!text) {
                throw Error('Text node absent in current Element');
            }

            var elementStyles = window.getComputedStyle(element),
                fontSize = elementStyles.getPropertyValue('font-size'),
                fontFamily = elementStyles.getPropertyValue('font-family'),
                etalon = document.createElement('span');

            etalon.innerText = text;
            etalon.style.position = 'absolute';
            etalon.style.display = 'block';
            etalon.style.whiteSpace = 'nowrap';
            etalon.style.fontFamily = fontFamily;
            etalon.style.fontSize = fontSize;

            document.body.appendChild(etalon);
            var textWidth = etalon.offsetWidth,
                parentWidth = element.offsetWidth;
            document.body.removeChild(etalon);

            var maxAllowedWidth = (parentWidth * countOfRows) * 0.9,
                symbolPerWidth = textWidth / text.length;

            if(textWidth > maxAllowedWidth) {
                var appendix = textWidth - maxAllowedWidth,
                    countOfSymbols = appendix / symbolPerWidth,
                    // will calculate it in future
                    buffer = 10;

                element.innerText = text.replace(new RegExp('.\{' + (Math.round(countOfSymbols + buffer)) + '\}$','g'), '...');
            }
        }

        function detach() {
            bsInput.style.display = 'none';
            input.style.display = 'block';
        }

        function attach(callback) {
            bsInput.style.display = 'block';
            input.style.display = 'none';

            clientCallback = callback;
        }

        function addCurrencySymbol(currencyCode) {
            var currencySymbols = {
                'EUR': '€',
                'RUB': '₽',
                'USD': '$'
            };

            return (currencyCode in currencySymbols)
                ? currencySymbols[currencyCode]
                : currencyCode;
        }

        function setStyles(styles) {
            for (var key in styles) {
                this.style[key] = styles[key];
            }
        }

        function defineLenguage() {
            var rawLanguage = navigator.languages
                ? navigator.languages[0]
                : (navigator.language || navigator.userLanguage);

            return rawLanguage.split('-')[0].toUpperCase();
        }

        function error(status, statusText) {
            console.log('Occur ' + status + ': ' + statusText);
        }

        function sendSearchQuery(query) {

            var feedURL = 'http://search.ocra.info/api/v2/search?q='+
                decodeURI(query) +'&jsver=1.5.24b&asin=&user=1728132379&domain=hotline.ua&dealsource=&widget=Search%20Suggest&language=EN&resolution=1366x768&time=5:44:56%20PM&cuid=f28eb652f695b78be8673f523cd923e8&category=undefined&ip=173.244.209.23';

            // 'q='+ query +
            // 'jsver=1.5.24b&'+
            // 'asin=&'+
            // 'user=1728132379&'+
            // 'domain=hotline.ua&'+
            // 'dealsource=&'+
            // 'widget=In Image Button&'+
            // 'language='+ defineLenguage() +'&'+
            // 'resolution=1366x768&'+
            // 'time=5:44:56 PM&'+
            // 'configurator_unique_id=a9a256e4a7c7595a7c1120d73661363b&'+
            // 'callback=bs.search&'+
            // 'category=undefined';

            var xhr = new XMLHttpRequest();

            xhr.open('GET', feedURL, true);

            xhr.send();

            xhr.onreadystatechange = function() {
                if (xhr.readyState != 4) return;

                if (xhr.status != 200) {
                    error(xhr.status, xhr.statusText);
                } else {
                    callBack(xhr.responseText, query);
                }
            };
        }

        function setHref(query) {
            query = query.trim();
            query = query.replace(' ', '+');

            var btn = document.querySelector('.bs-search-link');

            if(!btn) {
                return;
            }

            btn.href = ('https://www.google.com.ua/webhp#q=' + query);
        }

        function placeholder(elem) {
            var placeholder = elem.placeholder || '';

            function toggleHolder(ev) {
                ev.target.placeholder = ev.target.placeholder ? '' : placeholder;
            }

            elem.addEventListener('focus', toggleHolder);
            elem.addEventListener('blur', toggleHolder);
        }

        function queryCompliance(query, callBack) {
            if (query.length === 0) {
                template.remove();
            }

            input.value = query;

            setHref(query);

            if (!(query && query.length > MIN_LENGTH - 1)) {
                return;
            }

            (function isCurrentMorePrevious() {
                if(query.length && query.length > maxValue && query.charCodeAt(query.length - 1) !== 32) {

                    // print delay before send request
                    delay(function(){

                        // show spinner
                        spinner.show();

                        callBack(query.trim());

                    }, DELAY);
                }

                maxValue = query.length;
            })();
        }

        var callBack = function(response, query) {
            response = JSON.parse(response);

            if(response.success && response.info.items.length) {

                console.log('bs search');
                var items = response.info.items;

                // define product best price
                products.defineBestPrice(items);

                // hide spinner
                spinner.hide();

                // remove item
                template.remove();

                // generate and inject template
                relatedSearch(query, template.generate(items).firstChild);

                // define responsive appearance
                defineResponsive();

                resultContainer.body.querySelectorAll('.bs-product__name').forEach(function(elem) {
                    dottOverflowedText(elem, 2);
                });

            } else {
                console.log('search');
                clientCallback && clientCallback(bsInput);
            }
        };

        bsInput.addEventListener('keyup', function(ev) {
            queryCompliance(ev.target.value, sendSearchQuery);
        });
        bsInput.addEventListener('blur', function() {
            this.value = '';
        });

        document.body.addEventListener('click', function(ev) {
            if(ev.target == bsInput) return;

            template.remove();
        });

        window.bsSearchSuggest.detach = detach;
        window.bsSearchSuggest.attach = attach;
    }

    global.bsSearchSuggest = {
        init: init
    };
})(window, document);