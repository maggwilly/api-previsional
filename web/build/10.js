webpackJsonp([10],{

/***/ 858:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "UnavailablePageModule", function() { return UnavailablePageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__unavailable__ = __webpack_require__(913);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var UnavailablePageModule = /** @class */ (function () {
    function UnavailablePageModule() {
    }
    UnavailablePageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__unavailable__["a" /* UnavailablePage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__unavailable__["a" /* UnavailablePage */]),
            ],
        })
    ], UnavailablePageModule);
    return UnavailablePageModule;
}());

//# sourceMappingURL=unavailable.module.js.map

/***/ }),

/***/ 913:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return UnavailablePage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
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
 * Generated class for the UnavailablePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var UnavailablePage = /** @class */ (function () {
    function UnavailablePage(navCtrl, navParams) {
        this.navCtrl = navCtrl;
        this.navParams = navParams;
    }
    UnavailablePage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad UnavailablePage');
    };
    UnavailablePage.prototype.retry = function () {
        this.navCtrl.setRoot('TabsPage', { skippecheck: false }, { animate: true, direction: 'forward' });
    };
    UnavailablePage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-unavailable',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\unavailable\unavailable.html"*/'\n<ion-header no-border no-shadow>\n  <ion-navbar>\n    <ion-title>Systeme indisponible</ion-title>\n  </ion-navbar>\n</ion-header>\n<ion-content padding>\n<div text-center vertical-center layout horizontal-center style="margin-top: 30%">\n  <p style="color: red; font-size: 1.2em; font-weight: bold;">\n  Le service est momentanement indisponible, peut-etre a cause d\'une operation de maintenenance en cours. Reessayez plus tard.\n</p>\n<button  ion-button outline round (click)="retry()"> Ressayer a nouveau</button>\n</div>\n</ion-content>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\unavailable\unavailable.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */], __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], UnavailablePage);
    return UnavailablePage;
}());

//# sourceMappingURL=unavailable.js.map

/***/ })

});
//# sourceMappingURL=10.js.map