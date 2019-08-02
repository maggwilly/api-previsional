webpackJsonp([29],{

/***/ 835:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "MenuPageModule", function() { return MenuPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__menu__ = __webpack_require__(884);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var MenuPageModule = /** @class */ (function () {
    function MenuPageModule() {
    }
    MenuPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__menu__["a" /* MenuPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__menu__["a" /* MenuPage */]),
            ],
        })
    ], MenuPageModule);
    return MenuPageModule;
}());

//# sourceMappingURL=menu.module.js.map

/***/ }),

/***/ 884:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return MenuPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_user_user__ = __webpack_require__(152);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};



var MenuPage = /** @class */ (function () {
    function MenuPage(navCtrl, popoverCtrl, modalCtrl, userService, menu, navParams) {
        var _this = this;
        this.navCtrl = navCtrl;
        this.popoverCtrl = popoverCtrl;
        this.modalCtrl = modalCtrl;
        this.userService = userService;
        this.menu = menu;
        this.navParams = navParams;
        this.rootPage = 'HomePage';
        this.pages = [
            { name: 'Accueil', component: 'HomePage', icon: 'home' },
            { name: 'Mes Clients', component: 'PointventesPage', addPage: 'PointVentePage', icon: 'contacts' },
            { name: 'Mes Produits', component: 'ProduitsPage', addPage: 'ProduitPage', icon: 'md-bookmarks' },
            { name: 'Zones de vente', component: 'SecteursPage', addPage: 'SecteurPage', icon: 'md-map' },
            { name: 'Mes Ventes', component: 'CommendesPage', addPage: 'SelectclientPage', icon: 'ios-stats-outline' }
        ];
        this.suppages = [
            { name: 'Mon equipe', component: 'VendeursPage', icon: 'ios-people' },
            { name: 'Tableau de bord', component: 'StatsPage', icon: 'md-analytics' },
            { name: 'Cartographie', component: 'CartographPage', icon: 'ios-map-outline' },
            { name: 'Prévisions', component: 'PrevisionsPage', icon: 'md-pulse' }
        ];
        var skippecheck = this.navParams.get('skippecheck');
        userService.resetObserver();
        userService.complete.then(function (user) {
            if (!user || !user.id || !user.parent)
                return userService.go(user);
            else if (user.receiveRequests && user.receiveRequests.length && !skippecheck)
                return userService.request(user.receiveRequests);
            else if ((userService.amIMyParent() && (!user.entreprise || !user.ville || !user.pays) && !skippecheck)
                ||
                    (!userService.amIMyParent() && (!user.nom) && !skippecheck))
                return _this.nav.setRoot('ProfilePage', { user: user }); //userService.profile(user);
            /* else if( (!user.parent.abonnement||user.parent.abonnement.expired)&&!skippecheck)
                   return userService.shoulpay(user.parent.abonnement);*/
        }, function (ERROR) {
            console.log(ERROR);
            return userService.unavailable();
        });
    }
    MenuPage.prototype.presentPopover = function (ev) {
        var popover = this.popoverCtrl.create('PopOverMenuPage', { navCtrl: this.nav });
        popover.present({
            ev: ev
        });
    };
    MenuPage.prototype.openPage = function (p, openAddPage) {
        this.menu.close();
        this.nav.setRoot(p.component, { openAddPage: openAddPage });
    };
    __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["ViewChild"])(__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["m" /* Nav */]),
        __metadata("design:type", __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["m" /* Nav */])
    ], MenuPage.prototype, "nav", void 0);
    MenuPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-menu',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\menu\menu.html"*/'<ion-split-pane>\n<ion-menu [content]="content"  type="reveal" side="left" persistent="true">\n    <ion-header  >\n        <ion-navbar>\n          <ion-title></ion-title>\n<ion-buttons end>\n    <button ion-button icon-only end (click)="presentPopover($event)">\n        <ion-icon name="more"></ion-icon>\n      </button> \n</ion-buttons>\n        </ion-navbar>\n      </ion-header>  \n<ion-content>\n  <ion-list>\n    <ion-item *ngFor="let p of pages; let i = index" detail-push (click)="openPage(p)">\n      <ion-icon [name]="p.icon" item-left></ion-icon>\n      <button ion-button item-right small outline (click)="openPage(p,true)" *ngIf="p.addPage">\n        <ion-icon name="add" item-left></ion-icon>\n      </button>\n      {{p.name}}\n    </ion-item>\n    <ion-item-divider color="light">Options</ion-item-divider>\n    <ion-item *ngFor="let p of suppages; let i = index" detail-push (click)="openPage(p)">\n      <ion-icon [name]="p.icon" item-left></ion-icon>\n      {{p.name}}\n    </ion-item>\n  </ion-list>\n</ion-content>\n<ion-footer text-center  no-border>\n    <p><a><small>&copy; 2019. Centor .in</small></a></p>\n    </ion-footer>\n</ion-menu>\n<ion-nav [root]="rootPage" main  #content swipeBackEnabled="false"></ion-nav>\n</ion-split-pane>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\menu\menu.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["q" /* PopoverController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["l" /* ModalController */],
            __WEBPACK_IMPORTED_MODULE_2__providers_user_user__["a" /* UserProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["k" /* MenuController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], MenuPage);
    return MenuPage;
}());

//# sourceMappingURL=menu.js.map

/***/ })

});
//# sourceMappingURL=29.js.map