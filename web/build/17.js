webpackJsonp([17],{

/***/ 849:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RequestsPageModule", function() { return RequestsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__requests__ = __webpack_require__(900);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var RequestsPageModule = /** @class */ (function () {
    function RequestsPageModule() {
    }
    RequestsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__requests__["a" /* RequestsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__requests__["a" /* RequestsPage */]),
            ],
        })
    ], RequestsPageModule);
    return RequestsPageModule;
}());

//# sourceMappingURL=requests.module.js.map

/***/ }),

/***/ 900:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return RequestsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
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
 * Generated class for the RequestsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var RequestsPage = /** @class */ (function () {
    function RequestsPage(navCtrl, notify, manager, navParams) {
        this.navCtrl = navCtrl;
        this.notify = notify;
        this.manager = manager;
        this.navParams = navParams;
        this.requests = [];
        this.requests = this.navParams.get('requests');
        console.log(this.requests);
    }
    RequestsPage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad RequestsPage');
    };
    RequestsPage.prototype.dismiss = function (skippecheck) {
        if (skippecheck === void 0) { skippecheck = true; }
        this.navCtrl.setRoot('TabsPage', { skippecheck: skippecheck }, { animate: true, direction: 'forward' });
    };
    RequestsPage.prototype.accepter = function (request) {
        var _this = this;
        console.log(request);
        var self = this;
        this.notify.showAlert({
            title: "Acceptation",
            message: "Voulez-vous integrer l'equipe de vente ?",
            buttons: [
                {
                    text: 'Annuler',
                    handler: function () {
                        console.log('Disagree clicked');
                    }
                },
                {
                    text: 'Integrer',
                    handler: function (data) {
                        var loader = _this.notify.loading({
                            content: "Acceptation...",
                        });
                        _this.manager.delete('request', request, 'accept').then(function (data) {
                            if (data.ok) {
                                loader.dismiss().then(function () {
                                    self.dismiss(false);
                                    _this.notify.onSuccess({ message: "Vous etes bien integre" });
                                });
                            }
                            else {
                                loader.dismiss();
                                _this.notify.onError({ message: "L'operation n' a pas pu se derouler normalement" });
                            }
                        }, function (error) {
                            loader.dismiss();
                            _this.notify.onError({ message: "Un probleme est survenu" });
                        });
                        loader.present();
                    }
                }
            ]
        });
    };
    RequestsPage.prototype.refuser = function (request) {
        var _this = this;
        console.log(request);
        var self = this;
        var loader = this.notify.loading({
            content: "Suppression...",
        });
        this.manager.delete('request', request, 'refuse').then(function (data) {
            if (data.ok) {
                loader.dismiss().then(function () {
                    if (_this.requests.length <= 1)
                        return self.dismiss(false);
                    var index = _this.requests.findIndex(function (item) { return item.id == data.deletedId; });
                    if (index > -1)
                        _this.requests.splice(index, 1);
                });
            }
            else {
                loader.dismiss();
            }
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Un probleme est survenu" });
        });
        loader.present();
    };
    RequestsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-requests',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\requests\requests.html"*/'<!--\n  Generated template for the RequestsPage page.\n\n  See http://ionicframework.com/docs/components/#navigation for more info on\n  Ionic pages and navigation.\n-->\n<ion-header no-border no-shadow>\n  <ion-navbar>\n    <ion-title>Invitations</ion-title>\n       <ion-buttons showWhen="android,windows,core" end>\n          <button ion-button="ion-button" (click)="dismiss()" icon-left>\n              <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n              Fermer\n          </button>\n</ion-buttons>  \n  </ion-navbar>\n\n</ion-header>\n<ion-content padding>\n<ion-list *ngIf="requests">\n  <ion-card *ngFor="let request of requests">\n    <ion-card-header>{{request.user.nom}}</ion-card-header>\n    <ion-card-content>Acceptez de rejoindre l\'equipe de vente {{request.user.entreprise}}.</ion-card-content>\n    <ion-row>\n      <ion-col><button button ion-button outline small color="danger" (click)="refuser(request)">Refuser</button></ion-col>\n      <ion-col><button button ion-button  small color="primary" (click)="accepter(request)">Accepter</button></ion-col>\n    </ion-row>\n  </ion-card>\n</ion-list>\n</ion-content>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\requests\requests.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], RequestsPage);
    return RequestsPage;
}());

//# sourceMappingURL=requests.js.map

/***/ })

});
//# sourceMappingURL=17.js.map