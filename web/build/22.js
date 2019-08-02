webpackJsonp([22],{

/***/ 843:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProduitPageModule", function() { return ProduitPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__produit__ = __webpack_require__(892);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var ProduitPageModule = /** @class */ (function () {
    function ProduitPageModule() {
    }
    ProduitPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__produit__["a" /* ProduitPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__produit__["a" /* ProduitPage */]),
            ],
        })
    ], ProduitPageModule);
    return ProduitPageModule;
}());

//# sourceMappingURL=produit.module.js.map

/***/ }),

/***/ 892:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProduitPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__ionic_storage__ = __webpack_require__(88);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_manager_manager__ = __webpack_require__(47);
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
 * Generated class for the ProduitPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var ProduitPage = /** @class */ (function () {
    function ProduitPage(navCtrl, storage, navParams, viewCtrl, notify, manager) {
        this.navCtrl = navCtrl;
        this.storage = storage;
        this.navParams = navParams;
        this.viewCtrl = viewCtrl;
        this.notify = notify;
        this.manager = manager;
        this.produit = {};
        this.produit = this.navParams.get('produit') ? this.navParams.get('produit') : {};
        if (!this.inset)
            this.inset = this.navParams.get('inset');
    }
    ProduitPage.prototype.ionViewDidLoad = function () {
        console.log(this.produit);
    };
    ProduitPage.prototype.isInvalid = function () {
        return (!this.produit.nom || !this.produit.cout);
    };
    ProduitPage.prototype.dismiss = function (data) {
        this.viewCtrl.dismiss(data);
    };
    ProduitPage.prototype.onSubmit = function () {
        var _this = this;
        this.produit.change = true;
        var self = this;
        var loader = this.notify.loading({
            content: "Enregistrement...",
        });
        this.manager.save('produit', this.produit).then(function (data) {
            loader.dismiss().then(function () {
                if (!data.error) {
                    self.dismiss(data);
                    return _this.notify.onSuccess({ message: "Enregistrement effectué" });
                }
                _this.notify.onError({ message: "Une erreur s'est produite et l'opération n'a pas put se terminer correctement" });
            });
        }, function (error) {
            loader.dismiss();
            _this.notify.onSuccess({ message: "Verifiez votre connexion internet" });
        });
        loader.present();
    };
    ProduitPage.prototype.deleteItem = function () {
        var _this = this;
        var self = this;
        this.notify.showAlert({
            title: "Suppression",
            message: "Voulez-vous supprimer cet element ?",
            buttons: [
                {
                    text: 'Annuler',
                    handler: function () {
                        console.log('Disagree clicked');
                    }
                },
                {
                    text: 'Supprimer',
                    handler: function (data) {
                        var loader = _this.notify.loading({
                            content: "Suppression...",
                        });
                        _this.manager.delete('produit', _this.produit).then(function (data) {
                            if (data.ok) {
                                loader.dismiss().then(function () {
                                    self.dismiss(data);
                                    _this.notify.onSuccess({ message: "Element supprime" });
                                });
                            }
                            else {
                                loader.dismiss();
                                _this.notify.onError({ message: "Cet element est lie a d'autres. Vous ne pouvez pas le supprimer" });
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
    ProduitPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-produit',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\produit\produit.html"*/'<ion-header no-border no-shadow >\n  <ion-navbar>\n        <ion-title><span *ngIf="!produit.nom">Créer un produit</span><span *ngIf="produit.nom">{{produit.nom}}</span></ion-title>\n        <ion-buttons end>\n                <button ion-button="ion-button" (click)="dismiss()" icon-left>\n                    <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n                    Fermer\n                </button>\n            </ion-buttons>        \n  </ion-navbar>\n</ion-header>\n<ion-content >\n        <ion-card>\n                <ion-card-header text-wrap>Créer ou modifier un article</ion-card-header>\n        </ion-card>     \n    <form #form="ngForm" novalidate="novalidate">\n        <ion-list>\n            <ion-item>\n                <ion-label color="primary" floating><span>Nom du produit </span> </ion-label>\n                <ion-input [(ngModel)]="produit.nom" name="nom" type="text" placeholder="" #nom="ngModel"></ion-input>\n            </ion-item>\n            <ion-item>\n                <ion-label color="primary"><span>Prix de vente </span> </ion-label>\n                <ion-input [(ngModel)]="produit.cout" name="cout" type="number" placeholder="" #nom="ngModel"></ion-input>\n            </ion-item>  \n            <ion-item>\n                    <ion-textarea rows="1" [(ngModel)]="produit.description" placeholder="Description ddu produit"\n                        name="description" #description="ngModel"></ion-textarea>\n              </ion-item>                      \n        </ion-list>\n        <div padding="padding" >\n            <button *ngIf="!inset" ion-button block icon-right [disabled]="isInvalid()" (click)="onSubmit()">\n                    <span *ngIf="!produit.id">Creer un produit</span>\n                    <span *ngIf="produit.id">Enregistrer les changements</span>\n                    <ion-icon name="md-done-all"></ion-icon>\n               \n            </button>\n             <br>\n            <button  *ngIf="produit.id" ion-button outline block icon-right color="danger" (click)="deleteItem()">\n                    <span>Supprimer ce produit\n                        <ion-icon name="close"></ion-icon>\n                    </span>\n               </button>              \n        </div>\n    </form>\n</ion-content>\n<ion-footer *ngIf="inset">\n    <button ion-button full [disabled]="isInvalid()" (click)="onSubmit()">Creer un produit\n    </button>\n  </ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\produit\produit.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__ionic_storage__["b" /* Storage */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_4__providers_manager_manager__["a" /* ManagerProvider */]])
    ], ProduitPage);
    return ProduitPage;
}());

//# sourceMappingURL=produit.js.map

/***/ })

});
//# sourceMappingURL=22.js.map