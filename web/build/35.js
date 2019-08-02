webpackJsonp([35],{

/***/ 827:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CreatelignePageModule", function() { return CreatelignePageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__createligne__ = __webpack_require__(875);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var CreatelignePageModule = /** @class */ (function () {
    function CreatelignePageModule() {
    }
    CreatelignePageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__createligne__["a" /* CreatelignePage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__createligne__["a" /* CreatelignePage */]),
            ],
        })
    ], CreatelignePageModule);
    return CreatelignePageModule;
}());

//# sourceMappingURL=createligne.module.js.map

/***/ }),

/***/ 875:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return CreatelignePage; });
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
 * Generated class for the CreatelignePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var CreatelignePage = /** @class */ (function () {
    function CreatelignePage(navCtrl, viewCtrl, navParams) {
        this.navCtrl = navCtrl;
        this.viewCtrl = viewCtrl;
        this.navParams = navParams;
        this.ligne = { quantite: 1, stock: 0, acn: true };
        this.produit = this.navParams.get('produit');
        this.ligne.produit = this.produit;
        this.ligne.nom = this.produit.nom;
        this.ligne.pu = this.produit.cout;
    }
    CreatelignePage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad CreatelignePage');
    };
    CreatelignePage.prototype.dismiss = function (data) {
        this.viewCtrl.dismiss(data);
    };
    CreatelignePage.prototype.total = function () {
        this.ligne.total = this.ligne.quantite * this.ligne.pu;
        return this.ligne.total;
    };
    CreatelignePage.prototype.isInvalid = function () {
        return !this.ligne.quantite;
    };
    CreatelignePage.prototype.onSubmit = function () {
        this.dismiss(this.ligne);
    };
    CreatelignePage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-createligne',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\createligne\createligne.html"*/'\n<ion-header>\n  <ion-navbar>\n    <ion-title>{{ligne.nom}} </ion-title>\n    <ion-buttons end>\n    <button ion-button="ion-button" (click)="dismiss()" icon-left>\n      <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n      Fermer\n  </button>\n</ion-buttons>     \n  </ion-navbar>\n</ion-header>\n<ion-content padding>\n    <div text-center>Précisez la quantité commendée, le stock trouvé sur place et si il est de vous.</div>\n  <ion-item>\n    <ion-label color="primary"><span>Quantité </span> </ion-label>\n    <ion-input [(ngModel)]="ligne.quantite" name="quantite" type="number" placeholder="" #quantite="ngModel"></ion-input>\n  </ion-item>\n  <ion-item>\n      <ion-label color="primary"><span>Prix Unitaire </span> </ion-label>\n      <ion-input [(ngModel)]="ligne.pu" name="pu" type="number" placeholder="" #pu="ngModel"></ion-input>\n    </ion-item>  \n  <ion-item>\n    <ion-label color="primary"><span>Stock trouvé </span> </ion-label>\n    <ion-input [(ngModel)]="ligne.stock" name="stock" type="number" placeholder="" #stock="ngModel"></ion-input>\n  </ion-item> \n  <ion-item>\n    <ion-label>Acheté chez nous</ion-label>\n    <ion-checkbox item-right [(ngModel)]="ligne.acn" name="acn" #acn="ngModel"></ion-checkbox>\n  </ion-item> \n <ion-item>\n     <ion-row><ion-col>Total:</ion-col><ion-col>{{total()}} FCFA</ion-col></ion-row>\n  </ion-item>\n </ion-content>\n<ion-footer>\n  <button ion-button full [disabled]="isInvalid()" (click)="onSubmit()">Ajouter à la commende\n</button>\n</ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\createligne\createligne.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], CreatelignePage);
    return CreatelignePage;
}());

//# sourceMappingURL=createligne.js.map

/***/ })

});
//# sourceMappingURL=35.js.map