webpackJsonp([12],{

/***/ 854:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ShoulPayPageModule", function() { return ShoulPayPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__shoul_pay__ = __webpack_require__(905);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var ShoulPayPageModule = /** @class */ (function () {
    function ShoulPayPageModule() {
    }
    ShoulPayPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__shoul_pay__["a" /* ShoulPayPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__shoul_pay__["a" /* ShoulPayPage */]),
            ],
        })
    ], ShoulPayPageModule);
    return ShoulPayPageModule;
}());

//# sourceMappingURL=shoul-pay.module.js.map

/***/ }),

/***/ 905:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ShoulPayPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__ionic_storage__ = __webpack_require__(88);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};





var ShoulPayPage = /** @class */ (function () {
    function ShoulPayPage(navCtrl, notify, manager, loadingCtrl, navParams, storage) {
        this.navCtrl = navCtrl;
        this.notify = notify;
        this.manager = manager;
        this.loadingCtrl = loadingCtrl;
        this.navParams = navParams;
        this.storage = storage;
    }
    ShoulPayPage.prototype.ionViewDidLoad = function () {
        this.abonnement = this.navParams.get('abonnement');
        this.loadData();
    };
    ShoulPayPage.prototype.loadData = function () {
        var _this = this;
        this.manager.get('price', true).then(function (data) {
            _this.prices = data ? data : [];
            _this.storage.set('_prices', _this.prices);
        }, function (error) {
            _this.notify.onError({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
    };
    ShoulPayPage.prototype.dismiss = function (skippecheck) {
        if (skippecheck === void 0) { skippecheck = true; }
        this.navCtrl.setRoot('MenuPage', { skippecheck: skippecheck }, { animate: true, direction: 'forward' });
    };
    ShoulPayPage.prototype.loadRemoteData = function () {
        var _this = this;
        var loader = this.loadingCtrl.create({
            content: "chargement...",
        });
        this.manager.get('prices').then(function (data) {
            _this.prices = data ? data : [];
            _this.storage.set('_prices', _this.prices);
        }, function (error) {
            _this.notify.onError({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
        loader.present();
    };
    ShoulPayPage.prototype.openPrice = function (price) {
        this.navCtrl.push('PriceDetailPage', { price: price });
    };
    ShoulPayPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-shoul-pay',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\shoul-pay\shoul-pay.html"*/'<ion-header  no-border no-shadow>\n  <ion-navbar>\n    <ion-title>Limitations</ion-title>\n     <ion-buttons showWhen="android,windows,core" end>\n        <button ion-button="ion-button" (click)="dismiss()" icon-left>\n            <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n            Fermer\n        </button>\n</ion-buttons>     \n  </ion-navbar>\n</ion-header>\n<ion-content >\n  <ion-list>\n    <ion-item text-wrap no-lines class="inform abonne">\n       <p>\n        <span  *ngIf="!abonnement||abonnement.expired">\n          Votre abonnement est maintenant arrivé à expiration. Pour continuer à utiliser le service, \n          vous devez souscrire à nouveau en choisissant parmi les options ci-dessous.\n        </span>\n        <span  *ngIf="abonnement&&!abonnement.expired">\n          Votre abonnement actuel ne vous permet pas de gérer un nombre d\'utilisqteur supérieur à {{abonnement.nombreusers}}.\n          Vous pouvez toujours augmenter ce nombre en changeant de formule. Choisir parmi les options ci-dessous.\n        </span>\n      </p>\n     </ion-item>\n     </ion-list>\n     <ion-list>\n     <ion-item   text-wrap *ngFor="let price of prices; let i = index" [ngClass]="(\'item-\'+i)" (click)="openPrice(price)" detail-push>\n      {{price.nom}}\n      <p>{{price.description}}</p>\n      <ion-note item-right>{{price.amount| number:\'3.0-5\'}} XAF</ion-note>\n  </ion-item>\n   </ion-list>\n</ion-content>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\shoul-pay\shoul-pay.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["j" /* LoadingController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_4__ionic_storage__["b" /* Storage */]])
    ], ShoulPayPage);
    return ShoulPayPage;
}());

//# sourceMappingURL=shoul-pay.js.map

/***/ })

});
//# sourceMappingURL=12.js.map