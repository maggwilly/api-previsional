webpackJsonp([24],{

/***/ 841:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PriceDetailPageModule", function() { return PriceDetailPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__price_detail__ = __webpack_require__(890);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var PriceDetailPageModule = /** @class */ (function () {
    function PriceDetailPageModule() {
    }
    PriceDetailPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__price_detail__["a" /* PriceDetailPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__price_detail__["a" /* PriceDetailPage */]),
            ],
        })
    ], PriceDetailPageModule);
    return PriceDetailPageModule;
}());

//# sourceMappingURL=price-detail.module.js.map

/***/ }),

/***/ 890:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PriceDetailPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
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
 * Generated class for the PriceDetailPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var PriceDetailPage = /** @class */ (function () {
    function PriceDetailPage(modalCtrl, navCtrl, notify, manager, navParams) {
        this.modalCtrl = modalCtrl;
        this.navCtrl = navCtrl;
        this.notify = notify;
        this.manager = manager;
        this.navParams = navParams;
        this.payement = { duree: "1" };
        this.price = this.navParams.get('price');
        if (!this.price)
            return;
        this.payement.price = this.price.id;
    }
    PriceDetailPage.prototype.ionViewDidLoad = function () {
        this.initPayement();
    };
    PriceDetailPage.prototype.dismiss = function (skippecheck) {
        if (skippecheck === void 0) { skippecheck = true; }
        this.navCtrl.setRoot('TabsPage', { skippecheck: true }, { animate: true, direction: 'forward' });
    };
    PriceDetailPage.prototype.openUrl = function () {
        var _this = this;
        var ch = this.manager.getObservable('payement', this.payement.cmd).subscribe(function (data) {
            if (data.json() && data.json().status && data.json().status == 'SUCCESS') {
                ch.unsubscribe();
                _this.dismiss(false);
            }
            else if (data.json() && data.json().status && data.json().status == 'FAILED' || !data) {
                ch.unsubscribe();
                return _this.notify.onError({ message: "Le prelevement n'a pas put etre effectue" });
            }
        }, function (error) {
            _this.notify.onError({ message: 'Un problème est survenu. verifiez votre connexion internet' });
        });
        // open this.payement.url
    };
    PriceDetailPage.prototype.help = function () {
        var modal = this.modalCtrl.create('HelpPage', { page: 'om' });
        modal.present();
        //this.navCtrl.push('HelpPage',{page:'om'})
    };
    PriceDetailPage.prototype.amount = function () {
        switch (Number(this.payement.duree)) {
            case 1:
                this.payement.cmd = this.oneMonth.cmd;
                this.payement.url = this.oneMonth.payment_url;
                this.payement.amount = this.price.amount;
                break;
            case 6:
                this.payement.cmd = this.sixMonth.cmd;
                this.payement.url = this.sixMonth.payment_url;
                this.payement.amount = this.price.amount * 5;
                break;
            default:
                this.payement.cmd = this.twelveMonth.cmd;
                this.payement.url = this.twelveMonth.payment_url;
                this.payement.amount = this.price.amount * 10;
                break;
        }
    };
    PriceDetailPage.prototype.initPayement = function ($event) {
        var _this = this;
        if ($event === void 0) { $event = null; }
        if (!this.price)
            return;
        this.payement.amount = undefined;
        if (Number(this.payement.duree) == 1 && this.oneMonth ||
            Number(this.payement.duree) == 6 && this.sixMonth ||
            Number(this.payement.duree) == 12 && this.twelveMonth)
            return this.amount();
        this.manager.post('payement', this.payement, 'new', true).then(function (data) {
            if (!data.payment_url)
                return _this.notify.onError({ message: "Le paiement est momentanement indisponible. Reessayez plus tard" });
            switch (data.duree) {
                case 1:
                    _this.oneMonth = data;
                    break;
                case 6:
                    _this.sixMonth = data;
                    break;
                default:
                    _this.twelveMonth = data;
                    break;
            }
            return _this.amount();
        }, function (error) {
            _this.notify.onError({ message: "PROBLEME ! Verifiez votre connexion internet" });
        });
    };
    PriceDetailPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-price-detail',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\price-detail\price-detail.html"*/'\n<ion-header no-border no-shadow >\n  <ion-navbar>\n    <ion-title>Paiement</ion-title>\n         <ion-buttons showWhen="android,windows,core" end>\n          <button ion-button (click)="dismiss()" icon-left>\n            <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n            Fermer\n          </button>\n</ion-buttons>\n  </ion-navbar>\n</ion-header>\n<ion-content >\n<div class="om-baner"></div>\n  <div padding>\n    <ion-segment [(ngModel)]="payement.duree" mode="ios" color="orange" (ionChange)="initPayement($event)" [disabled]="!payement.amount">\n      <ion-segment-button value="1" >\n        01 Mois\n      </ion-segment-button>\n      <ion-segment-button value="6" >\n        06 Mois\n      </ion-segment-button>      \n      <ion-segment-button value="12" >\n        12 Mois\n      </ion-segment-button>\n    </ion-segment>\n  </div>\n  \n  <div  padding>\n    <h2 *ngIf="price">{{price.nom}}</h2>\n    <ion-row *ngIf="price" style="height: 80px">\n    <ion-col>\n        <p>{{price.description}}</p>\n    </ion-col>\n    <ion-col text-right>\n        <ion-grid  style="height: 100%;justify-content: center;">\n            <ion-row justify-content-center align-items-center>\n               <ion-spinner [hidden]="payement.amount"  name="ios"></ion-spinner>\n               <ion-note class="amount" [hidden]="!payement.amount">{{payement.amount| number}} XAF</ion-note>\n            </ion-row>\n          </ion-grid>\n   </ion-col>  \n  </ion-row>  \n  <br>\n  <div *ngIf="payement.amount">\n   <button ion-button block color="orange"  (click)="openUrl()" >Effectuer le paiement</button> \n  </div>\n  </div>\n\n</ion-content>\n<ion-footer no-border>\n  <div padding text-wrap >\n    <p>\n      Payez votre abonnement en toute simplicité par Orange Money.\n      <button ion-button clear small (click)="help()" style="text-transform: none;">Obtenir de l\'aide.</button>\n    </p>\n  </div>\n</ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\price-detail\price-detail.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], PriceDetailPage);
    return PriceDetailPage;
}());

//# sourceMappingURL=price-detail.js.map

/***/ })

});
//# sourceMappingURL=24.js.map