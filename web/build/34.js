webpackJsonp([34],{

/***/ 828:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "DonneesPageModule", function() { return DonneesPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__donnees__ = __webpack_require__(876);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var DonneesPageModule = /** @class */ (function () {
    function DonneesPageModule() {
    }
    DonneesPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__donnees__["a" /* DonneesPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__donnees__["a" /* DonneesPage */]),
            ],
        })
    ], DonneesPageModule);
    return DonneesPageModule;
}());

//# sourceMappingURL=donnees.module.js.map

/***/ }),

/***/ 876:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return DonneesPage; });
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
 * Generated class for the DonneesPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var DonneesPage = /** @class */ (function () {
    function DonneesPage(navCtrl, popoverCtrl, app, navParams) {
        this.navCtrl = navCtrl;
        this.popoverCtrl = popoverCtrl;
        this.app = app;
        this.navParams = navParams;
        this.pages = [
            { name: 'Mes Clients', component: 'PointventesPage', icon: 'contacts' },
            { name: 'Mes Produits', component: 'ProduitsPage', icon: 'md-bookmarks' },
            { name: 'Mes Secteurs', component: 'SecteursPage', icon: 'md-map' }
        ];
        this.suppages = [
            { name: 'Mon equipe de vente', component: 'VendeursPage', icon: 'ios-people' },
            { name: 'Statistiques du mois', component: 'StatsPage', icon: 'md-analytics' },
            { name: 'Rapports memsuels', component: 'RapportsPage', icon: 'ios-paper' },
        ];
    }
    DonneesPage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad DonneesPage');
    };
    DonneesPage.prototype.presentPopover = function (ev) {
        var popover = this.popoverCtrl.create('PopOverMenuPage', { navCtrl: this.navCtrl });
        popover.present({
            ev: ev
        });
    };
    DonneesPage.prototype.openPage = function (p) {
        this.app.getRootNav().push(p.component);
    };
    DonneesPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-donnees',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\donnees\donnees.html"*/'<ion-header  no-border no-shadow>\n    <ion-navbar>\n      <ion-title>Mes donnees</ion-title>\n      <ion-buttons end>\n          <button ion-button icon-only (click)="presentPopover($event)">\n              <ion-icon name="more"></ion-icon>\n            </button> \n        </ion-buttons>     \n    </ion-navbar>\n  </ion-header>\n  <ion-content >\n  <ion-list inset>\n\n<ion-item-divider color="light">Mes donnees</ion-item-divider>    \n<ion-item *ngFor="let p of pages; let i = index" detail-push (click)="openPage(p)">\n  <ion-icon [name]="p.icon" item-left></ion-icon>\n  {{p.name}}\n  </ion-item>  \n<ion-item-divider color="light">Options</ion-item-divider>    \n<ion-item *ngFor="let p of suppages; let i = index" detail-push (click)="openPage(p)">\n   <ion-icon [name]="p.icon" item-left></ion-icon>\n  {{p.name}}\n  </ion-item>  \n    \n  </ion-list>\n  </ion-content>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\donnees\donnees.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["q" /* PopoverController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["b" /* App */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], DonneesPage);
    return DonneesPage;
}());

//# sourceMappingURL=donnees.js.map

/***/ })

});
//# sourceMappingURL=34.js.map