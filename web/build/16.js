webpackJsonp([16],{

/***/ 850:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "SecteurPageModule", function() { return SecteurPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__secteur__ = __webpack_require__(901);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var SecteurPageModule = /** @class */ (function () {
    function SecteurPageModule() {
    }
    SecteurPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__secteur__["a" /* SecteurPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__secteur__["a" /* SecteurPage */]),
            ],
        })
    ], SecteurPageModule);
    return SecteurPageModule;
}());

//# sourceMappingURL=secteur.module.js.map

/***/ }),

/***/ 901:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return SecteurPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_localisation_localisation__ = __webpack_require__(483);
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
 * Generated class for the SecteurPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var SecteurPage = /** @class */ (function () {
    function SecteurPage(navCtrl, viewCtrl, notify, manager, location, navParams) {
        this.navCtrl = navCtrl;
        this.viewCtrl = viewCtrl;
        this.notify = notify;
        this.manager = manager;
        this.location = location;
        this.navParams = navParams;
        this.secteur = {};
        this.inset = true;
        this.openAddPage = this.navParams.get('openAddPage');
        this.inset = this.navParams.get('inset');
        this.secteur = this.navParams.get('secteur') ? this.navParams.get('secteur') : {};
        console.log(this.secteur);
    }
    SecteurPage.prototype.ionViewDidLoad = function () {
        var _this = this;
        if (this.secteur.id)
            return;
        this.location.getCurrentPosition().then(function (resp) {
            _this.secteur.latitude = resp.coords.latitude;
            _this.secteur.longitude = resp.coords.longitude;
        }).catch(function (error) {
            console.log(error);
        });
    };
    SecteurPage.prototype.dismiss = function (data) {
        this.viewCtrl.dismiss(data);
    };
    SecteurPage.prototype.isInvalid = function () {
        return (!this.secteur.nom || !this.secteur.ville);
    };
    SecteurPage.prototype.onSubmit = function () {
        var _this = this;
        this.secteur.change = true;
        var self = this;
        var loader = this.notify.loading({
            content: "Enregistrement...",
        });
        this.manager.save('secteur', this.secteur, this.location.isOnline()).then(function (data) {
            loader.dismiss().then(function () {
                if (!data.error) {
                    self.dismiss(data);
                    return _this.notify.onSuccess({ message: "Enregistrement effectué" });
                }
                _this.notify.onError({ message: "Une erreur s'est produite et l'opération n'a pas put se terminer correctement" });
            });
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: " Verifiez votre connexion internet" });
        });
        loader.present();
    };
    SecteurPage.prototype.deleteItem = function () {
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
                        _this.manager.delete('secteur', _this.secteur).then(function (data) {
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
    SecteurPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-secteur',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\secteur\secteur.html"*/'\n<ion-header no-border no-shadow >\n    <ion-navbar>\n        <ion-title><span *ngIf="!secteur.nom">Créer une zone</span><span *ngIf="secteur.nom">{{secteur.nom}}</span></ion-title>     \n        <ion-buttons end>\n                <button ion-button="ion-button" (click)="dismiss()" icon-left>\n                    <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n                    Fermer\n                </button>\n            </ion-buttons> \n    </ion-navbar>\n</ion-header>\n<ion-content >\n        <ion-card>\n                <ion-card-header text-wrap>Créer ou modifier une zone</ion-card-header>\n        </ion-card>    \n    <form #form="ngForm" novalidate="novalidate">\n        <ion-list>\n            <ion-item>\n                <ion-label color="primary" floating><span>Nom de la zone</span> </ion-label>\n                <ion-input [(ngModel)]="secteur.nom" name="nom" type="text" placeholder="" #nom="ngModel"></ion-input>\n            </ion-item>\n            <ion-item >\n                <ion-label color="primary" floating>\n                    <span>Ville</span>\n                </ion-label>\n                <ion-select  [(ngModel)]="secteur.ville" name="ville" #ville="ngModel">\n                        <ion-option value="Yaoundé">Yaoundé</ion-option>\n                        <ion-option value="Douala">Douala</ion-option>\n                        <ion-option value="Bafoussam">Bafoussam</ion-option>\n                        <ion-option value="Bertoua">Bertoua</ion-option>\n                        <ion-option value="Bamenda">Bamenda</ion-option>\n                        <ion-option value="Dschang">Dschang</ion-option>\n                        <ion-option value="Autre">Autre</ion-option>\n                    </ion-select>\n            </ion-item>\n            <ion-item>\n                <ion-textarea rows="1" [(ngModel)]="secteur.description" placeholder="Description du secteur"\n                    name="description" #description="ngModel"></ion-textarea>\n            </ion-item>\n        </ion-list>\n        <div padding="padding">\n            <button *ngIf="!inset" ion-button block icon-right [disabled]="isInvalid()" (click)="onSubmit()">\n                <span *ngIf="!secteur.id">Créer un secteur</span>\n                <span *ngIf="secteur.id">Enregistrer les changements</span>\n                    <ion-icon name="md-done-all"></ion-icon>\n            </button>\n             <br>\n            <button *ngIf="secteur.id" ion-button outline block icon-right color="danger" (click)="deleteItem()">\n                    <span>Supprimer ce secteur\n                        <ion-icon name="close"></ion-icon>\n                    </span>\n               </button>             \n        </div>\n    </form>\n</ion-content>\n<ion-footer *ngIf="inset">\n    <button ion-button full [disabled]="isInvalid()" (click)="onSubmit()">\n        <span *ngIf="!secteur.id">Créer une zone</span>\n        <span *ngIf="secteur.id">Enregistrer les changements</span>\n    </button>\n  </ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\secteur\secteur.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_2_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_1__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_4__providers_localisation_localisation__["a" /* LocalisationProvider */],
            __WEBPACK_IMPORTED_MODULE_2_ionic_angular__["o" /* NavParams */]])
    ], SecteurPage);
    return SecteurPage;
}());

//# sourceMappingURL=secteur.js.map

/***/ })

});
//# sourceMappingURL=16.js.map