webpackJsonp([1],{

/***/ 846:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "QuartiersPageModule", function() { return QuartiersPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__quartiers__ = __webpack_require__(895);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_ionic2_google_places_autocomplete__ = __webpack_require__(896);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};




var QuartiersPageModule = /** @class */ (function () {
    function QuartiersPageModule() {
    }
    QuartiersPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__quartiers__["a" /* QuartiersPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__quartiers__["a" /* QuartiersPage */]),
                __WEBPACK_IMPORTED_MODULE_3_ionic2_google_places_autocomplete__["a" /* GooglePlacesAutocompleteComponentModule */]
            ],
        })
    ], QuartiersPageModule);
    return QuartiersPageModule;
}());

//# sourceMappingURL=quartiers.module.js.map

/***/ }),

/***/ 865:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return GooglePlacesAutocompleteComponent; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_http__ = __webpack_require__(153);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_map__ = __webpack_require__(154);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_map___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_rxjs_add_operator_map__);



var GOOGLE_API_URL = "https://maps.googleapis.com/maps/api/place/";
var GooglePlacesAutocompleteComponent = (function () {
    function GooglePlacesAutocompleteComponent(http) {
        this.http = http;
        this.callback = new __WEBPACK_IMPORTED_MODULE_0__angular_core__["EventEmitter"]();
        if (this.placeholder == null) {
            this.placeholder = "Search";
        }
    }
    GooglePlacesAutocompleteComponent.prototype.autocomplete = function (input) {
        var typesParam = this.types != null ? ("&types=" + this.types) : "";
        var typeParam = this.type != null ? ("&type=" + this.type) : "";
        var offsetParam = this.offset != null ? ("&offset=" + this.offset) : "";
        var locationParam = this.location != null ? ("&location=" + this.location) : "";
        var radiusParam = this.radius != null ? ("&radius=" + this.radius) : "";
        var languageParam = this.language != null ? ("&language=" + this.language) : "";
        var componentsParam = this.components != null ? ("&components=" + this.components) : "";
        var strictboundsParam = this.strictbounds != null ? ("&strictbounds=" + this.strictbounds) : "";
        var params = typesParam + typeParam + offsetParam + locationParam + radiusParam + languageParam + componentsParam + strictboundsParam;
        return this.http.get(GOOGLE_API_URL + "autocomplete/json?input=" + input + "&key=" + this.key + params)
            .map(function (res) { return res.json(); });
    };
    GooglePlacesAutocompleteComponent.prototype.getLocals = function (ev) {
        var _this = this;
        var val = ev.target.value;
        if (val && val.trim().length > 3) {
            this.autocomplete(val)
                .subscribe(function (res) {
                _this.locals = res.predictions;
            });
        }
        else {
            this.locals = [];
        }
    };
    GooglePlacesAutocompleteComponent.prototype.detail = function (item) {
        this.callback.emit([item]);
        this.locals = [];
    };
    GooglePlacesAutocompleteComponent.decorators = [
        { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"], args: [{
                    selector: 'google-places-autocomplete',
                    template: '<ion-searchbar (ionInput)="getLocals($event)" debounce="700" placeholder="{{placeholder}}"></ion-searchbar><ion-list><ion-item *ngFor="let item of locals" (click)="detail(item)">{{item.description}}</ion-item><ion-item *ngIf="locals != null && locals.length > 0"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJAAAAASCAYAAAC0PldrAAAIHElEQVR4Ae3ZBXDbWB7H8efglpmZGW0HlhzJDpSZmZkZ3W3s2DpmZmbmKx0zM/NdoGhotxTf9x9LHY027paW85v5bBRQopn32weqasqzk5Jw7BE9nHijHo5/Rw/HfqaHYl/keldZ8GJ7qBeqZ/6PNGlPUT5DeVKNqkyc18PJ6VDPtfEfnvUJz0dmpbwfmzMW6k5YFy96pBRTkCnL4MUDiy94oS0F+ZVZlD/5qxLLfNFkz0D0fBtfKOkpCcffrFfG6vVQ4hDUc6ypQLdDFmMdMiWIcjywaOHEB8zynPEFa1pCOWnHLw2Bej5oKtDzqEC+cGyoWZ5YaTDeGer57r4LRPLRCi40liy0QR4eVB5CG2QhU3KQneG+TM/qQhvk424L1Bwt73P22d9QoFD8bVB3KxVUWTX+gqW1mvvLtbr7Z7V+z6frNM/UlFIuKAD83I2v5y69eiL3y9dPZP/s2tdyPn39ZN7UVEq5oCz8x+WvjC/SQrEv8/u/z/O9siSUKNfC8agWSbrRaIH+p3lH1Pg976jxe38gz8JzzLM/g2QhpmIuIjCwB/0cg6HjGAxEsQQtIZmCtbBnLbY4BngZptkGaQmiMHAUhbCyEJMxCxGsh6QFltruOwIv7BmEfTAQwWwsvYMCTcMqGKat6AJJCXYjD1ZcWIdZsEdK8K50gZLroez4+l4G8j1PURlfAJWaMye7Vvd+otbvTVVr7hvVmvc/ci0YyNdAidTHVPa1EzmfuH4iN0WBbnD9H7lu8PXc10CJYDCVxanvffI8nAZvloQTNenZMXYt/YyJ5Y3tgar9nkCt5n2y4Tl073+5TprPEIYSknW2ARpkWosQOkFSiijK0BtuHME2ZGMMDLSDpBMMU29bYaIYBxfW4wBGojcmw8BIWM8Vwjq40QMubMR+231TYGAYJN1QhVUYgEHYgMgdFCiCBeiLYdiJI2iO9og6St4XBgZnKpAWjm2AsmNZO+E8jdlnqzrdvS49aO4fndWLekDVlbmHMoB/MQewAorCrDML86P6E816QD35lbyhzER/SZcouwJKq0oskd9PSX9aVnm5F1RJVbKQr13IVKCU251b7Xf/WwpcqxfMkVnngm9MW+sZ6gJeD24N1BHkwUouDmI28hDGBNjTDwZGIR9hFEOiYyu2YRIkY1GFhzAABvrCnpVYbyvQAeTAyiBHKa2sNUnmY5/jvnwcvYMCbXDMmG1QBR2SJdhu+5l52NXYMsqA7EsXI/5OKBvEhnMKK7LwtePpgYy9HIpB+lbDIGmFbihLTcAzs6FAuueDUJTkW0hdO5XrhrJc/1reTPk6BfsgZMY7iZS/KumFsmihxIFMBaoNeHxmiT/6H5+7Y41esJcl7K/pmdD9N64n4tZALYQzs7EDvTMMmgtBW7GWYyUk26DDj/1wYYHt+z7bUhixMXDMVqDFznG5zX1HIdmDGbDnTvdAGpzZhGWO/2n6ojnCKIIzDNClwQ1LRmU8ETCS3aEysU5r7FHmQckAyUD9sWJgPpSlNlA4SL7O0vJNqGtfz/6bFKX+SyofyvLk1/IGNcxAX8v9JpS8QpDfX/Ha+nwoC8vplIwFYq/TUFbN+w9Zxqr93vpq3fOFWn/BJFlioYQ1UEvgzHxsRQ8Y6NdIgY6jDBI3wugGA53QxVa+IAogeQwR9EB3h27IVGwfqjLc1xWSnZgNZ5bdQYECcGabrcgubMUCPIZjtztQWPsOZpjvPRq52A7KSatKTpV3QfxcXenL61tASUFk8M7q7gIoiywl6UF1fwBKCmLONAVQlhsn8+aYX/8AVEll4pQ8h7x7grLIRj9TgWo0z8Ppsnqv1eqeyP98hX2hZClrrEDH0QpWWuIYJiMbQcx1TNWjYWCQbY8TwQbshJXdWI+obdPdEwbGwJ7ipylQH2vZdN5nK9AMHEVzx1JUeQcF2uVY+rojimJYGY8q7MdEZIy8MGTwfmHuhf5JkTbJex/fyxJdtcpLDzNob5JNrbn/mQMl2ECvNpeKn1sDV6MVjGEz/U9zWSmFYuO82tzr/PzK6fy+UFdP5o6hNP9M742ySyFL1VJrDxSIXu4NJUunvAXPVCApCfufP5p7rg1y2pMZkeswX/u+zIawF0jtwyOmvThiK5UXBhbDgwkIY7mjVKthoBRWymE0MngLbXsrN+bbS5WhQC4sRggVjvtGQ9IWQexGMR7BfjxxBwV6AptRgBIcxU7kwkoODiOCtrhtZOZhkD52m3/KiFGs+VCAdYT3fsicAer5WIcU4DGghPzcta/nfKjhFPa13HrUybW5fBlQQk5hWmXi/fL3rNnuTk5hdX6Pl79/wTwNXrJOYbIXOh9w98atgVqAx7EPx7AUHWDPSGy2la0MOY38zCp0gZWuWNXIbJONAPYhhK0YDSsTocGZbJRmuM9KJ6zAceyHD489zYyxCGMwGYdts24LOLMWi3DHkQ0sg/QqWU5KwvEf4HPMDHseDcc6QTnJUiH7EGajz8g7GPYiH2EWKoOyk/c9vAeax6zzGcryAz5+5PrJ7DIoO37QxTufhRT0C+zLvst11FrC5JQG5f7IrJd5Pjzzx56Pzh4CJc76CnryHugVPMe3OcqfYTkLymkMCpk30RnTlG62jfQLIr5gKkf+wVY29lAWWULTM2HsMah70VSgu888bIULL4hw2pqRPhEmfiMbadmbyWzE/utqSSj2nznBVB7UvWgq0N2lLSIYhxdOWL5k+Xzq/it2mdcGAah7ZV00eQlgxvFRpNfJeyc+Bn2RK32h7sf/AesqcHB02e65AAAAAElFTkSuQmCC"></ion-item></ion-list>'
                },] },
    ];
    /** @nocollapse */
    GooglePlacesAutocompleteComponent.ctorParameters = function () { return [
        { type: __WEBPACK_IMPORTED_MODULE_1__angular_http__["b" /* Http */], decorators: [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Inject"], args: [__WEBPACK_IMPORTED_MODULE_1__angular_http__["b" /* Http */],] },] },
    ]; };
    GooglePlacesAutocompleteComponent.propDecorators = {
        'callback': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Output"], args: ["callback",] },],
        'placeholder': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["placeholder",] },],
        'types': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["types",] },],
        'type': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["type",] },],
        'key': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["key",] },],
        'offset': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["offset",] },],
        'location': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["location",] },],
        'radius': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["radius",] },],
        'language': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["language",] },],
        'components': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["components",] },],
        'strictbounds': [{ type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["Input"], args: ["strictbounds",] },],
    };
    return GooglePlacesAutocompleteComponent;
}());
//# sourceMappingURL=google-places-autocomplete.js.map

/***/ }),

/***/ 895:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return QuartiersPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_config__ = __webpack_require__(485);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};




/*
  Generated class for the Select page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
var QuartiersPage = /** @class */ (function () {
    function QuartiersPage(navCtrl, navParams, viewCtrl, alertCtrl, manager) {
        this.navCtrl = navCtrl;
        this.navParams = navParams;
        this.viewCtrl = viewCtrl;
        this.alertCtrl = alertCtrl;
        this.manager = manager;
        this.newQuartiers = [];
        this.ville = '';
        this.apikey = __WEBPACK_IMPORTED_MODULE_3__app_config__["a" /* Config */].googleApiKey;
        this.ville = this.navParams.get('ville');
    }
    QuartiersPage.prototype.ionViewDidEnter = function () {
        var _this = this;
        this.manager.getQuartiers().then(function (data) {
            _this.newQuartiers = data.filter(function (item) {
                return item.ville == _this.ville;
            });
        });
    };
    QuartiersPage.prototype.detail = function ($event) {
    };
    QuartiersPage.prototype.search = function () {
        var _this = this;
        var queryText = this.queryText.toLowerCase().replace(/,|\.|-/g, ' ');
        var queryWords = queryText.split(' ').filter(function (w) { return !!w.trim().length; });
        this.newQuartiers.forEach(function (item) {
            item.hide = true;
            _this.filter(item, queryWords);
        });
    };
    QuartiersPage.prototype.filter = function (item, queryWords) {
        var matchesQueryText = false;
        if (queryWords.length) {
            // of any query word is in the session name than it passes the query test
            queryWords.forEach(function (queryWord) {
                if (item.nom && item.nom.toLowerCase().indexOf(queryWord) > -1) {
                    matchesQueryText = true;
                }
            });
        }
        else {
            // if there are no query words then this session passes the query test
            matchesQueryText = true;
        }
        item.hide = !(matchesQueryText);
    };
    QuartiersPage.prototype.dismiss = function (selectedItem) {
        this.viewCtrl.dismiss(selectedItem);
    };
    QuartiersPage.prototype.exist = function (items, seach) {
        var item = items.find(function (item) {
            return (item.nom == seach);
        });
        return item;
    };
    QuartiersPage.prototype.newQuartier = function () {
        if (this.exist(this.newQuartiers, this.queryText))
            return this.dismiss(this.queryText);
        this.dismiss(this.queryText);
    };
    QuartiersPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'quartier',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\quartiers\quartiers.html"*/'\n\n<ion-header>\n\n    <ion-navbar>\n\n    <ion-row no-padding>\n\n        <ion-col>  <ion-title>Les quartiers</ion-title></ion-col>\n\n        <ion-col>\n\n          <ion-searchbar [hidden]="!newQuartiers.length"  [(ngModel)]="queryText" (ionInput)="search()" placeholder="Rechercher">\n\n          </ion-searchbar>         \n\n        </ion-col>\n\n      </ion-row>    \n\n    <ion-buttons end>\n\n        <button ion-button (click)="dismiss()" icon-left>\n\n            <ion-icon name="md-close" showWhen="android,windows,core"></ion-icon>\n\n            <span color="primary" showWhen="android,ios,core">Fermer</span>\n\n          </button>\n\n    </ion-buttons>\n\n  </ion-navbar>\n\n</ion-header>\n\n<ion-content >\n\n  <ion-list *ngIf="newQuartiers.length" inset>\n\n      <ion-item *ngFor="let quartier of newQuartiers" (click)="dismiss(quartier.nom)" [hidden]="quartier.hide">\n\n        {{quartier.nom}}\n\n      </ion-item>\n\n      <div  [hidden]="!queryText">\n\n          <button ion-button   (click)="newQuartier()" block > Créer un quartier \n\n              <ion-icon name="add"></ion-icon>\n\n            </button>\n\n        </div>      \n\n  </ion-list>\n\n</ion-content>\n\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\quartiers\quartiers.html"*/
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["a" /* AlertController */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */]])
    ], QuartiersPage);
    return QuartiersPage;
}());

//# sourceMappingURL=quartiers.js.map

/***/ }),

/***/ 896:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_google_places_autocomplete__ = __webpack_require__(865);
/* unused harmony namespace reexport */
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__google_places_autocomplete_module__ = __webpack_require__(897);
/* harmony namespace reexport (by used) */ __webpack_require__.d(__webpack_exports__, "a", function() { return __WEBPACK_IMPORTED_MODULE_1__google_places_autocomplete_module__["a"]; });


//# sourceMappingURL=index.js.map

/***/ }),

/***/ 897:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return GooglePlacesAutocompleteComponentModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__angular_http__ = __webpack_require__(153);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_google_places_autocomplete__ = __webpack_require__(865);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_common__ = __webpack_require__(65);





var GooglePlacesAutocompleteComponentModule = (function () {
    function GooglePlacesAutocompleteComponentModule() {
    }
    GooglePlacesAutocompleteComponentModule.decorators = [
        { type: __WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"], args: [{
                    declarations: [
                        __WEBPACK_IMPORTED_MODULE_3__components_google_places_autocomplete__["a" /* GooglePlacesAutocompleteComponent */],
                    ],
                    imports: [
                        __WEBPACK_IMPORTED_MODULE_4__angular_common__["b" /* CommonModule */],
                        __WEBPACK_IMPORTED_MODULE_1__angular_http__["c" /* HttpModule */],
                        __WEBPACK_IMPORTED_MODULE_2_ionic_angular__["h" /* IonicModule */]
                    ],
                    exports: [
                        __WEBPACK_IMPORTED_MODULE_3__components_google_places_autocomplete__["a" /* GooglePlacesAutocompleteComponent */]
                    ],
                    schemas: [
                        __WEBPACK_IMPORTED_MODULE_0__angular_core__["CUSTOM_ELEMENTS_SCHEMA"]
                    ]
                },] },
    ];
    /** @nocollapse */
    GooglePlacesAutocompleteComponentModule.ctorParameters = function () { return []; };
    return GooglePlacesAutocompleteComponentModule;
}());
//# sourceMappingURL=google-places-autocomplete.module.js.map

/***/ })

});
//# sourceMappingURL=1.js.map