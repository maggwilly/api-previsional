webpackJsonp([0],{

/***/ 856:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "StatsPageModule", function() { return StatsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__stats__ = __webpack_require__(908);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_ng2_google_charts__ = __webpack_require__(909);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var StatsPageModule = /** @class */ (function () {
    function StatsPageModule() {
    }
    StatsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__stats__["a" /* StatsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__stats__["a" /* StatsPage */]),
                __WEBPACK_IMPORTED_MODULE_3_ng2_google_charts__["a" /* Ng2GoogleChartsModule */]
            ],
        })
    ], StatsPageModule);
    return StatsPageModule;
}());

//# sourceMappingURL=stats.module.js.map

/***/ }),

/***/ 867:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return GoogleChartComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__google_charts_loader_service__ = __webpack_require__(868);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__chart_html_tooltip__ = __webpack_require__(869);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var GoogleChartComponent = /** @class */ (function () {
    function GoogleChartComponent(el, loaderService) {
        var _this = this;
        this.mouseOverListener = function (item) {
            var event = _this.parseMouseEvent(item);
            event.tooltip = _this.getHTMLTooltip();
            return event;
        };
        this.mouseOutListener = function (item) {
            var event = _this.parseMouseEvent(item);
            return event;
        };
        this.selectListener = function () {
            var event = {
                message: 'select',
                row: null,
                column: null,
                selectedRowValues: [],
                selectedRowFormattedValues: [],
                columnLabel: ''
            };
            var s = _this.wrapper.visualization.getSelection();
            var gs = s[s.length - 1];
            if (!gs) {
                event.message = 'deselect';
                return event;
            }
            var selection = gs;
            if (gs.row != null) {
                event.row = selection.row;
                var selectedRowValues = [];
                var selectedRowFormattedValues = [];
                var dataTable = _this.wrapper.getDataTable();
                var numberOfColumns = dataTable.getNumberOfColumns();
                for (var i = 0; i < numberOfColumns; i++) {
                    selectedRowValues.push(dataTable.getValue(selection.row, i));
                    selectedRowFormattedValues.push(dataTable.getFormattedValue(selection.row, i));
                }
                event.selectedRowValues = selectedRowValues;
                event.selectedRowFormattedValues = selectedRowFormattedValues;
            }
            if (selection.column != null) {
                event.column = selection.column;
                event.columnLabel = _this.getColumnLabelAtPosition(selection);
            }
            if (gs.name) {
                event.columnLabel = gs.name;
            }
            return event;
        };
        this.el = el;
        this.loaderService = loaderService;
        this.chartSelect = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.chartSelectOneTime = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.chartReady = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.chartReadyOneTime = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.chartError = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.chartErrorOneTime = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.mouseOver = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.mouseOverOneTime = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.mouseOut = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.mouseOutOneTime = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
    }
    GoogleChartComponent.prototype.ngOnChanges = function (changes) {
        var _this = this;
        var key = 'data';
        if (changes[key]) {
            if (!this.data) {
                return;
            }
            this.options = this.data.options;
            if (!this.options) {
                this.options = {};
            }
            this.data.component = this;
            this.loaderService.load().then(function () {
                if (_this.wrapper === undefined || _this.wrapper.getChartType() !== _this.data.chartType) {
                    _this.convertOptions();
                    if (_this.data.opt_firstRowIsData && Array.isArray(_this.data.dataTable)) {
                        _this.data.dataTable = google.visualization.arrayToDataTable(_this.data.dataTable, true);
                    }
                    _this.wrapper = new google.visualization.ChartWrapper(_this.data);
                    _this.registerChartWrapperEvents();
                }
                else {
                    // this.unregisterEvents();
                }
                _this.draw();
            });
        }
    };
    GoogleChartComponent.prototype.draw = function () {
        this.wrapper.setDataTable(this.data.dataTable);
        this.convertOptions();
        this.wrapper.setOptions(this.options);
        this.reformat();
        this.wrapper.draw(this.el.nativeElement.querySelector('div'));
    };
    /**
     * Applies formatters to data columns, if defined
     */
    GoogleChartComponent.prototype.reformat = function () {
        if (!this.data) {
            return;
        }
        if (this.data.formatters !== undefined) {
            for (var _i = 0, _a = this.data.formatters; _i < _a.length; _i++) {
                var formatterConfig = _a[_i];
                var formatterConstructor = google.visualization[formatterConfig.type];
                var formatterOptions = formatterConfig.options;
                var formatter = new formatterConstructor(formatterOptions);
                if (formatterConfig.type === 'ColorFormat' && formatterOptions) {
                    for (var _b = 0, _c = formatterOptions.ranges; _b < _c.length; _b++) {
                        var range = _c[_b];
                        if (typeof (range.fromBgColor) !== 'undefined' && typeof (range.toBgColor) !== 'undefined') {
                            formatter.addGradientRange(range.from, range.to, range.color, range.fromBgColor, range.toBgColor);
                        }
                        else {
                            formatter.addRange(range.from, range.to, range.color, range.bgcolor);
                        }
                    }
                }
                var dt = this.wrapper.getDataTable();
                for (var _d = 0, _e = formatterConfig.columns; _d < _e.length; _d++) {
                    var col = _e[_d];
                    formatter.format(dt, col);
                }
            }
        }
    };
    GoogleChartComponent.prototype.getSelectorBySeriesType = function (seriesType) {
        var selectors = {
            bars: 'bar#%s#%r',
            haxis: 'hAxis#0#label',
            line: 'point#%s#%r',
            legend: 'legendentry#%s',
            area: 'point#%s#%r'
        };
        var selector = selectors[seriesType];
        return selector;
    };
    /**
     * Given a column number, counts how many
     * columns have rol=="data". Those are mapped
     * one-to-one to the series array. When rol is not defined
     * a column of type number means a series column.
     * @param column to inspect
     */
    GoogleChartComponent.prototype.getSeriesByColumn = function (column) {
        var series = 0;
        var dataTable = this.wrapper.getDataTable();
        for (var i = column - 1; i >= 0; i--) {
            var role = dataTable.getColumnRole(i);
            var type = dataTable.getColumnType(i);
            if (role === 'data' || type === 'number') {
                series++;
            }
        }
        return series;
    };
    GoogleChartComponent.prototype.getBoundingBoxForItem = function (item) {
        var boundingBox = { top: 0, left: 0, width: 0, height: 0 };
        if (this.cli) {
            var column = item.column;
            var series = this.getSeriesByColumn(column);
            var row = item.row;
            var seriesType = this.options.seriesType;
            if (this.options.series && this.options.series[series] && this.options.series[series].type) {
                seriesType = this.options.series[series].type;
            }
            if (seriesType) {
                var selector = this.getSelectorBySeriesType(seriesType);
                if (selector) {
                    selector = selector.replace('%s', series + '').replace('%c', column + '').replace('%r', row + '');
                    var box = this.cli.getBoundingBox(selector);
                    if (box) {
                        boundingBox = box;
                    }
                }
            }
        }
        return boundingBox;
    };
    GoogleChartComponent.prototype.getValueAtPosition = function (position) {
        if (position.row == null) {
            return null;
        }
        var dataTable = this.wrapper.getDataTable();
        var value = dataTable.getValue(position.row, position.column);
        return value;
    };
    GoogleChartComponent.prototype.getColumnTypeAtPosition = function (position) {
        var dataTable = this.wrapper.getDataTable();
        var type = dataTable.getColumnType(position.column) || '';
        return type;
    };
    GoogleChartComponent.prototype.getColumnLabelAtPosition = function (position) {
        var dataTable = this.wrapper.getDataTable();
        var type = dataTable.getColumnLabel(position.column) || '';
        return type;
    };
    GoogleChartComponent.prototype.getHTMLTooltip = function () {
        var tooltipER = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"](this.el.nativeElement.querySelector('.google-visualization-tooltip'));
        return new __WEBPACK_IMPORTED_MODULE_2__chart_html_tooltip__["a" /* ChartHTMLTooltip */](tooltipER);
    };
    GoogleChartComponent.prototype.parseMouseEvent = function (item) {
        var chartType = this.wrapper.getChartType();
        var eventColumn = item.column;
        if (eventColumn == null) {
            switch (chartType) {
                case 'Timeline':
                    eventColumn = this.wrapper.getDataTable().getNumberOfColumns() === 3 ? 0 : 1;
                    break;
                default:
                    eventColumn = 0;
            }
        }
        var eventRow = item.row;
        var myItem = {
            row: eventRow,
            column: eventColumn
        };
        var event = {
            position: item,
            boundingBox: this.getBoundingBoxForItem(myItem),
            value: this.getValueAtPosition(myItem),
            columnType: this.getColumnTypeAtPosition(myItem),
            columnLabel: this.getColumnLabelAtPosition(myItem)
        };
        return event;
    };
    GoogleChartComponent.prototype.unregisterEvents = function () {
        google.visualization.events.removeAllListeners(this.wrapper.getChart());
        google.visualization.events.removeAllListeners(this.wrapper);
    };
    GoogleChartComponent.prototype.registerChartEvents = function () {
        var _this = this;
        var chart = this.wrapper.getChart();
        this.cli = chart.getChartLayoutInterface ? chart.getChartLayoutInterface() : null;
        if (this.mouseOver.observers.length > 0) {
            google.visualization.events.addListener(chart, 'onmouseover', function (item) {
                var event = _this.parseMouseEvent(item);
                event.tooltip = _this.getHTMLTooltip();
                _this.mouseOver.emit(event);
            });
        }
        if (this.mouseOverOneTime.observers.length > 0) {
            google.visualization.events.addOneTimeListener(chart, 'onmouseover', function (item) {
                var event = _this.parseMouseEvent(item);
                event.tooltip = _this.getHTMLTooltip();
                _this.mouseOverOneTime.emit(event);
            });
        }
        if (this.mouseOut.observers.length > 0) {
            google.visualization.events.addListener(chart, 'onmouseout', function (item) {
                var event = _this.parseMouseEvent(item);
                _this.mouseOut.emit(event);
            });
        }
        if (this.mouseOutOneTime.observers.length > 0) {
            google.visualization.events.addOneTimeListener(chart, 'onmouseout', function (item) {
                var event = _this.parseMouseEvent(item);
                _this.mouseOutOneTime.emit(event);
            });
        }
    };
    GoogleChartComponent.prototype.registerChartWrapperEvents = function () {
        var _this = this;
        google.visualization.events.addListener(this.wrapper, 'ready', function () {
            _this.chartReady.emit({ message: 'Chart ready' });
        });
        google.visualization.events.addOneTimeListener(this.wrapper, 'ready', function () {
            _this.chartReadyOneTime.emit({ message: 'Chart ready (one time)' });
            _this.registerChartEvents();
        });
        google.visualization.events.addListener(this.wrapper, 'error', function (error) {
            _this.chartError.emit(error);
        });
        google.visualization.events.addOneTimeListener(this.wrapper, 'error', function (error) {
            _this.chartErrorOneTime.emit(error);
        });
        this.addListener(this.wrapper, 'select', this.selectListener, this.chartSelect);
        this.addOneTimeListener(this.wrapper, 'select', this.selectListener, this.chartSelectOneTime);
    };
    GoogleChartComponent.prototype.addListener = function (source, eventType, listenerFn, evEmitter) {
        google.visualization.events.addListener(source, eventType, function () {
            evEmitter.emit(listenerFn());
        });
    };
    GoogleChartComponent.prototype.addOneTimeListener = function (source, eventType, listenerFn, evEmitter) {
        google.visualization.events.addOneTimeListener(source, eventType, function () {
            evEmitter.emit(listenerFn());
        });
    };
    GoogleChartComponent.prototype.convertOptions = function () {
        try {
            this.options = google.charts[this.data.chartType].convertOptions(this.options);
        }
        catch (error) {
            return;
        }
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"])(),
        __metadata("design:type", Object)
    ], GoogleChartComponent.prototype, "data", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartReady", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartReadyOneTime", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartError", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartErrorOneTime", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartSelect", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "chartSelectOneTime", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "mouseOver", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "mouseOverOneTime", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "mouseOut", void 0);
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"])(),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"])
    ], GoogleChartComponent.prototype, "mouseOutOneTime", void 0);
    GoogleChartComponent = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'google-chart',
            template: '<div></div>',
            changeDetection: __WEBPACK_IMPORTED_MODULE_0__angular_core__["ChangeDetectionStrategy"].OnPush
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_0__angular_core__["ElementRef"],
            __WEBPACK_IMPORTED_MODULE_1__google_charts_loader_service__["a" /* GoogleChartsLoaderService */]])
    ], GoogleChartComponent);
    return GoogleChartComponent;
}());



/***/ }),

/***/ 868:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return GoogleChartsLoaderService; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};

var GoogleChartsLoaderService = /** @class */ (function () {
    function GoogleChartsLoaderService(localeId, googleChartsVersion, mapsApiKey) {
        this.googleChartsVersion = googleChartsVersion;
        this.mapsApiKey = mapsApiKey;
        this.googleScriptLoadingNotifier = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        this.googleScriptIsLoading = false;
        this.localeId = localeId;
        if (this.googleChartsVersion === null) {
            this.googleChartsVersion = '46';
        }
    }
    GoogleChartsLoaderService.prototype.load = function (packages) {
        var _this = this;
        return new Promise(function (resolve, reject) {
            if (resolve === void 0) { resolve = Function.prototype; }
            if (reject === void 0) { reject = Function.prototype; }
            _this.loadGoogleChartsScript().then(function () {
                var initializer = {
                    language: _this.localeId,
                    callback: resolve,
                    packages: packages
                };
                if (_this.mapsApiKey) {
                    initializer.mapsApiKey = _this.mapsApiKey;
                }
                google.charts.load(_this.googleChartsVersion, initializer);
            }).catch(function (err) { return reject(); });
        });
    };
    GoogleChartsLoaderService.prototype.loadGoogleChartsScript = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            if (resolve === void 0) { resolve = Function.prototype; }
            if (reject === void 0) { reject = Function.prototype; }
            if (typeof google !== 'undefined' && google.charts) {
                resolve();
            }
            else if (!_this.googleScriptIsLoading) {
                _this.googleScriptIsLoading = true;
                var script = document.createElement('script');
                script.type = 'text/javascript';
                script.src = 'https://www.gstatic.com/charts/loader.js';
                script.async = true;
                script.defer = true;
                script.onload = function () {
                    _this.googleScriptIsLoading = false;
                    _this.googleScriptLoadingNotifier.emit(true);
                    resolve();
                };
                script.onerror = function () {
                    _this.googleScriptIsLoading = false;
                    _this.googleScriptLoadingNotifier.emit(false);
                    reject();
                };
                document.getElementsByTagName('head')[0].appendChild(script);
            }
            else {
                _this.googleScriptLoadingNotifier.subscribe(function (loaded) {
                    if (loaded) {
                        resolve();
                    }
                    else {
                        reject();
                    }
                });
            }
        });
    };
    GoogleChartsLoaderService = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Injectable"])(),
        __param(0, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])(__WEBPACK_IMPORTED_MODULE_0__angular_core__["LOCALE_ID"])),
        __param(1, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])('googleChartsVersion')), __param(1, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Optional"])()),
        __param(2, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"])('mapsApiKey')), __param(2, Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Optional"])()),
        __metadata("design:paramtypes", [String, String, String])
    ], GoogleChartsLoaderService);
    return GoogleChartsLoaderService;
}());



/***/ }),

/***/ 869:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ChartHTMLTooltip; });
var ChartHTMLTooltip = /** @class */ (function () {
    function ChartHTMLTooltip(el) {
        this.tooltipDOMElement = el;
    }
    ChartHTMLTooltip.prototype.setPosition = function (x, y) {
        this.tooltipDOMElement.nativeElement.style.left = x + ChartHTMLTooltip.PIXELS;
        this.tooltipDOMElement.nativeElement.style.top = y + ChartHTMLTooltip.PIXELS;
    };
    ChartHTMLTooltip.prototype.getDOMElement = function () {
        return this.tooltipDOMElement;
    };
    ChartHTMLTooltip.PIXELS = 'px';
    return ChartHTMLTooltip;
}());



/***/ }),

/***/ 908:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return StatsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_moment__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_moment___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_moment__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__providers_localisation_localisation__ = __webpack_require__(483);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};






/**
 * Generated class for the StatsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var StatsPage = /** @class */ (function () {
    function StatsPage(navCtrl, navParams, modalCtrl, localisation, manager, loadingCtrl, notify) {
        this.navCtrl = navCtrl;
        this.navParams = navParams;
        this.modalCtrl = modalCtrl;
        this.localisation = localisation;
        this.manager = manager;
        this.loadingCtrl = loadingCtrl;
        this.notify = notify;
    }
    StatsPage.prototype.ionViewDidLoad = function () {
        this.refresh();
    };
    StatsPage.prototype.loadData = function () {
        var _this = this;
        this.manager.show('stat', 'sale-satat').then(function (data) {
            _this.stats = data;
            _this.makeUpData().then(function (datatable) {
                _this.useAngularLibrary(datatable);
            }, function (err) { });
        }, function (error) {
            _this.notify.onSuccess({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
    };
    ;
    StatsPage.prototype.refresh = function () {
        this.filtre = { type: '',
            user: '', secteur: '',
            ville: '',
            afterdate: __WEBPACK_IMPORTED_MODULE_4_moment__().startOf('month').format("YYYY-MM-DD"),
            beforedate: __WEBPACK_IMPORTED_MODULE_4_moment__().endOf('month').format("YYYY-MM-DD") };
        if (this.localisation.isOnline())
            return this.loadRemoteData();
        return this.loadData();
    };
    StatsPage.prototype.openMap = function () {
        this.navCtrl.push('CartographPage', { filtre: this.filtre });
    };
    StatsPage.prototype.makeUpData = function () {
        var _this = this;
        return new Promise(function (resolve, reject) {
            _this.datatable = [['Semaine', 'Prospectés', 'Engagés', 'Rendez-vous programmés', 'Livraisons ou visites']];
            Object.keys(_this.stats.weeks).forEach(function (key) {
                var entry = _this.stats.weeks[key];
                var week = [];
                week.push(key);
                week.push(Number(entry.created));
                week.push(Number(entry.engaged));
                week.push(Number(entry.visitedtarget));
                week.push(Number(entry.visited));
                _this.datatable.push(week);
            });
            resolve(_this.datatable);
        });
    };
    StatsPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.loadingCtrl.create({
            content: "chargement...",
        });
        this.manager.show('stat', 0, true, this.filtre).then(function (data) {
            _this.stats = data;
            _this.makeUpData().then(function (datatable) {
                _this.useAngularLibrary(datatable);
            }, function (err) { });
            loader.dismiss();
        }, function (error) {
            loader.dismiss();
            console.log(error);
            _this.notify.onSuccess({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
        loader.present();
    };
    StatsPage.prototype.useAngularLibrary = function (datatable) {
        this.pieChartData = {
            chartType: 'ColumnChart',
            dataTable: datatable,
            options: {
                height: 400,
                legend: { position: 'top', maxLines: 1 },
                hAxis: {
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                }
            }
        };
        //  let ccComponent = this.pieChartData.component
        //ccComponent.draw();
        //console.log(this.pieChartData);
    };
    StatsPage.prototype.openFilter = function () {
        var _this = this;
        var modal = this.modalCtrl.create('FiltreStatsPage', { filtre: this.filtre });
        modal.onDidDismiss(function (data) {
            if (!data)
                return;
            return _this.loadRemoteData();
        });
        modal.present();
    };
    StatsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-stats',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\stats\stats.html"*/'<ion-header no-border no-shadow>\n  <ion-navbar>\n    <ion-title>Tableau de bord <strong *ngIf="filtre">\n      <span *ngIf="filtre.afterdate">, Entre le {{filtre.afterdate|date:\'dd/MM/yyyy\'}}</span>\n      <span *ngIf="filtre.beforedate"> <span *ngIf="filtre.afterdate">et</span><span *ngIf="!filtre.afterdate">, Avant</span> le {{filtre.beforedate|date:\'dd/MM/yyyy\'}}</span></strong></ion-title>\n    <ion-buttons end>\n      <button ion-button icon-left (click)="refresh()"> \n        <ion-icon name="refresh"></ion-icon> Actualiser\n      </button> \n      <button ion-button icon-only (click)="openMap()">\n          <ion-icon name="ios-map"></ion-icon>\n        </button>      \n    </ion-buttons>   \n  </ion-navbar>\n</ion-header> \n<ion-content>\n  <div *ngIf="stats">\n<ion-grid>\n  <ion-row>\n<ion-card>\n  <ion-card-header>\n    <ion-item text-wrap>\n        Tableau de bord  <strong *ngIf="filtre"><span *ngIf="filtre.afterdate">, Entre le {{filtre.afterdate|date:\'dd/MM/yyyy\'}}</span>\n          <span *ngIf="filtre.beforedate"> <span *ngIf="filtre.afterdate">et</span><span *ngIf="!filtre.afterdate">, Avant</span> le {{filtre.beforedate|date:\'dd/MM/yyyy\'}}</span></strong>\n        <p *ngIf="filtre">\n            <span *ngIf="filtre.type">, {{filtre.type}}</span><span *ngIf="!filtre.type">Toutes catégories</span>\n            <span *ngIf="filtre.ville">{{filtre.ville}}</span><span *ngIf="!filtre.ville">, toutes les villes</span>\n           <span *ngIf="filtre.quartier">, {{filtre.quartier}}</span><span *ngIf="!filtre.quartier">, tous les quartiers</span>\n        </p>\n            <button ion-button icon-left item-right    (click)="openFilter()"><ion-icon name="funnel"  ></ion-icon> Seletionnez</button>    \n    </ion-item>\n  </ion-card-header>\n</ion-card>  \n</ion-row>\n  <ion-row>\n      <ion-col>\n          <ion-card class="kpi"> \n              <ion-card-content>\n                <ion-row class="box-info">\n                  <ion-col><span class="circle-text primary"><ion-icon name="md-people"></ion-icon> </span></ion-col>\n                  <ion-col text-center> <span class="label">{{stats.total_count}}</span></ion-col>\n                </ion-row>\n                <p><ion-icon name="ios-information-circle-outline"></ion-icon> Nombre total des clients</p>\n              </ion-card-content>\n            </ion-card>\n      </ion-col>\n      <ion-col>\n          <ion-card class="kpi">\n              <ion-card-content>\n                  <ion-row class="box-info">\n                      <ion-col><span class="circle-text orange"><ion-icon name="md-person-add"></ion-icon></span></ion-col>\n                      <ion-col text-center> <span class="label">{{stats.created_count}}</span></ion-col>\n                    </ion-row>                  \n                <p><ion-icon name="ios-information-circle-outline"></ion-icon> Clients prospectés</p>\n              </ion-card-content>\n            </ion-card>\n      </ion-col>\n      <ion-col>\n          <ion-card class="kpi">\n              <ion-card-content>\n                <ion-row class="box-info">\n                    <ion-col><span class="circle-text danger"><ion-icon name="md-checkbox-outline"></ion-icon></span></ion-col>\n                    <ion-col text-center> <span class="label">{{stats.engaged_count}}</span></ion-col>\n                  </ion-row>                \n                <p><ion-icon name="ios-information-circle-outline"></ion-icon> Clients engagés </p>\n              </ion-card-content>\n            </ion-card>\n      </ion-col>\n      <ion-col>\n          <ion-card class="kpi">\n            <ion-card-content>\n              <ion-row class="box-info">\n                  <ion-col><span class="circle-text secondary"><ion-icon name="md-clipboard"></ion-icon></span></ion-col>\n                  <ion-col text-center>  <span class="label">{{stats.target_vs_visited}}%</span></ion-col>\n                </ion-row>              \n              <p><ion-icon name="ios-information-circle-outline"></ion-icon> Objectif des livraisons</p>\n            </ion-card-content>\n          </ion-card>\n        </ion-col>\n    </ion-row>\n\n  <ion-row>\n  <ion-card id="chart-sale">\n    <ion-card-header>\n        Evolutions hebdomadaires des indicateurs\n    </ion-card-header>\n           <google-chart style = "width: 550px; height: 400px; margin: 0 auto" [data]="pieChartData"></google-chart>\n  </ion-card>\n  </ion-row>\n</ion-grid>\n   </div>\n    <ion-grid style="height: 80%;justify-content: center;position:absolute;top:15vh" *ngIf="!pieChartData">\n      <ion-row style="height: 100%;justify-content: center;" justify-content-center align-items-center>\n          <ion-spinner name="ios"></ion-spinner>\n      </ion-row>\n    </ion-grid> \n</ion-content>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\stats\stats.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_5__providers_localisation_localisation__["a" /* LocalisationProvider */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */]])
    ], StatsPage);
    return StatsPage;
}());

//# sourceMappingURL=stats.js.map

/***/ }),

/***/ 909:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__google_chart_google_chart_component__ = __webpack_require__(867);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__google_chart_chart_html_tooltip__ = __webpack_require__(869);
/* unused harmony reexport ChartHTMLTooltip */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__google_chart_chart_mouse_event__ = __webpack_require__(910);
/* unused harmony reexport ChartMouseOverEvent */
/* unused harmony reexport ChartMouseOutEvent */
/* unused harmony reexport MouseOverEvent */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__google_charts_module__ = __webpack_require__(911);
/* harmony reexport (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_3__google_charts_module__["a"]; });






/***/ }),

/***/ 910:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* unused harmony export ChartMouseEvent */
/* unused harmony export MouseOverEvent */
/* unused harmony export ChartMouseOverEvent */
/* unused harmony export ChartMouseOutEvent */
var __extends = (this && this.__extends) || (function () {
    var extendStatics = function (d, b) {
        extendStatics = Object.setPrototypeOf ||
            ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
            function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
        return extendStatics(d, b);
    };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
var ChartMouseEvent = /** @class */ (function () {
    function ChartMouseEvent() {
    }
    return ChartMouseEvent;
}());

/**
 * @deprecated Use ChartMouseOverEvent instead
 */
var MouseOverEvent = /** @class */ (function (_super) {
    __extends(MouseOverEvent, _super);
    function MouseOverEvent() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return MouseOverEvent;
}(ChartMouseEvent));

var ChartMouseOverEvent = /** @class */ (function (_super) {
    __extends(ChartMouseOverEvent, _super);
    function ChartMouseOverEvent() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return ChartMouseOverEvent;
}(ChartMouseEvent));

var ChartMouseOutEvent = /** @class */ (function (_super) {
    __extends(ChartMouseOutEvent, _super);
    function ChartMouseOutEvent() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    return ChartMouseOutEvent;
}(ChartMouseEvent));



/***/ }),

/***/ 911:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return Ng2GoogleChartsModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__google_chart_google_chart_component__ = __webpack_require__(867);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__google_charts_loader_service__ = __webpack_require__(868);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var Ng2GoogleChartsModule = /** @class */ (function () {
    function Ng2GoogleChartsModule() {
    }
    Ng2GoogleChartsModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_1__google_chart_google_chart_component__["a" /* GoogleChartComponent */]
            ],
            providers: [
                __WEBPACK_IMPORTED_MODULE_2__google_charts_loader_service__["a" /* GoogleChartsLoaderService */]
            ],
            exports: [
                __WEBPACK_IMPORTED_MODULE_1__google_chart_google_chart_component__["a" /* GoogleChartComponent */]
            ]
        })
    ], Ng2GoogleChartsModule);
    return Ng2GoogleChartsModule;
}());



/***/ })

});
//# sourceMappingURL=0.js.map