webpackJsonp([32],{

/***/ 830:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "FiltreStatsPageModule", function() { return FiltreStatsPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__filtre_stats__ = __webpack_require__(878);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var FiltreStatsPageModule = /** @class */ (function () {
    function FiltreStatsPageModule() {
    }
    FiltreStatsPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__filtre_stats__["a" /* FiltreStatsPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__filtre_stats__["a" /* FiltreStatsPage */]),
            ],
        })
    ], FiltreStatsPageModule);
    return FiltreStatsPageModule;
}());

//# sourceMappingURL=filtre-stats.module.js.map

/***/ }),

/***/ 878:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return FiltreStatsPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
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
 * Generated class for the FiltreStatsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var FiltreStatsPage = /** @class */ (function () {
    function FiltreStatsPage(navCtrl, manager, viewCtrl, navParams) {
        this.navCtrl = navCtrl;
        this.manager = manager;
        this.viewCtrl = viewCtrl;
        this.navParams = navParams;
        this.filtre = {};
        this.users = [];
        this.secteurs = [];
        this.filtre = navParams.get('filtre') ? navParams.get('filtre') : {};
    }
    FiltreStatsPage.prototype.ionViewDidLoad = function () {
        var _this = this;
        this.manager.get('user').then(function (data) {
            _this.users = data ? data : [];
        }, function (error) {
        });
        this.manager.get('secteur').then(function (data) {
            _this.secteurs = data ? data : [];
        }, function (error) {
            console.log(error);
        });
    };
    FiltreStatsPage.prototype.dismiss = function (data) {
        this.viewCtrl.dismiss(data);
    };
    FiltreStatsPage.prototype.onSubmit = function () {
        this.viewCtrl.dismiss(this.filtre);
    };
    FiltreStatsPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-filtre-stats',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\filtre-stats\filtre-stats.html"*/'<ion-header>\n    <ion-navbar>\n        <ion-title>Critères de recherche</ion-title>\n        <ion-buttons end>\n            <button ion-button (click)="dismiss()" icon-left>\n                <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon>\n                Fermer\n            </button>\n        </ion-buttons>\n    </ion-navbar>\n</ion-header>\n<ion-content padding>   \n    <ion-item>\n        <ion-label color="primary">\n            <span>Categorie</span>\n        </ion-label>\n        <ion-select [(ngModel)]="filtre.type" name="type" #type="ngModel">\n            <ion-option value="">Toutes catégories</ion-option>\n            <ion-option value="Boutique-de-Quartier">Boutique-de-Quartier</ion-option>\n            <ion-option value="Kiosque">Kiosque</ion-option>\n            <ion-option value="Super-Marche">Super-Marché</ion-option>\n            <ion-option value="Boulangerie">Boulangerie</ion-option>\n            <ion-option value="Debit-de-boisson">Debit-de-boisson</ion-option>\n            <ion-option value="Station-service">Station-service</ion-option>\n            <ion-option value="Etalage-de-marché">Etalage-de-marché</ion-option>\n        </ion-select>\n    </ion-item>\n    <ion-item>\n        <ion-label color="primary">\n            <span>Dans la ville de </span>\n        </ion-label>\n        <ion-select [(ngModel)]="filtre.ville" name="ville" #ville="ngModel">\n            <ion-option value="">Toutes les villes</ion-option>\n            <ion-option value="Yaoundé">Yaoundé</ion-option>\n            <ion-option value="Douala">Douala</ion-option>\n            <ion-option value="Bafoussam">Bafoussam</ion-option>\n            <ion-option value="Bertoua">Bertoua</ion-option>\n            <ion-option value="Bamenda">Bamenda</ion-option>\n            <ion-option value="Dschang">Dschang</ion-option>\n        </ion-select>\n    </ion-item>\n    <ion-item *ngIf="secteurs&&secteurs.length">\n        <ion-label color="primary" >\n            <span>Situés dans la zone de </span>\n        </ion-label>\n        <ion-select [(ngModel)]="filtre.secteur" name="secteur" #secteur="ngModel">\n            <ion-option  value="">Toutes les zones</ion-option>\n            <ion-option *ngFor="let secteur of secteurs" [value]="secteur.id">{{secteur.nom}}</ion-option>\n        </ion-select>\n    </ion-item>\n    <ion-item-divider>Periode</ion-item-divider>\n        <ion-row>\n                <ion-col>\n                    <ion-item>\n                        <ion-label color="primary" floating><span>Entre le </span></ion-label>\n                        <ion-datetime displayFormat="DD/MM/YYYY" pickerFormat="D MMM  YYYY" min="2019" doneText="Terminé"\n                            cancelText="Annuler" name="afterdate" [(ngModel)]="filtre.afterdate" #date="ngModel"></ion-datetime>\n                    </ion-item>\n                </ion-col>\n                <ion-col>\n                    <ion-item>\n                        <ion-label color="primary" floating><span> avant le </span></ion-label>\n                        <ion-datetime displayFormat="DD/MM/YYYY" pickerFormat="D MMM  YYYY" min="2019" doneText="Terminé"\n                            cancelText="Annuler" name="beforedate" [(ngModel)]="filtre.beforedate" #date="ngModel">\n                        </ion-datetime>\n                    </ion-item>\n                </ion-col>\n            </ion-row>            \n    <ion-item *ngIf="users&&users.length">\n        <ion-label color="primary" >\n            <span>Clients prospectés par</span>\n        </ion-label>\n        <ion-select [(ngModel)]="filtre.user" name="user" #user="ngModel">\n            <ion-option  value="">Tout le monde</ion-option>\n            <ion-option *ngFor="let user of users" [value]="user.id">{{user.nom}}</ion-option>\n        </ion-select>\n    </ion-item>\n</ion-content>\n<ion-footer>\n    <button ion-button full (click)="onSubmit()">Appliquer les critères\n    </button>\n</ion-footer>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\filtre-stats\filtre-stats.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], FiltreStatsPage);
    return FiltreStatsPage;
}());

//# sourceMappingURL=filtre-stats.js.map

/***/ })

});
//# sourceMappingURL=32.js.map