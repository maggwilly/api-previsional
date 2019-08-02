webpackJsonp([26],{

/***/ 839:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "PopOverMenuPageModule", function() { return PopOverMenuPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__pop_over_menu__ = __webpack_require__(888);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var PopOverMenuPageModule = /** @class */ (function () {
    function PopOverMenuPageModule() {
    }
    PopOverMenuPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__pop_over_menu__["a" /* PopOverMenuPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__pop_over_menu__["a" /* PopOverMenuPage */]),
            ],
        })
    ], PopOverMenuPageModule);
    return PopOverMenuPageModule;
}());

//# sourceMappingURL=pop-over-menu.module.js.map

/***/ }),

/***/ 888:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return PopOverMenuPage; });
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



/**
 * Generated class for the PopOverMenuPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var PopOverMenuPage = /** @class */ (function () {
    function PopOverMenuPage(viewCtrl, navParams, userService) {
        this.viewCtrl = viewCtrl;
        this.navParams = navParams;
        this.userService = userService;
        this.pages = [
            { name: 'A propos', component: 'AboutPage' },
            { name: 'Mon profil', component: 'ProfilePage' }
        ];
        this.navCtrl = this.navParams.get('navCtrl');
    }
    PopOverMenuPage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad PopOverMenuPage');
    };
    PopOverMenuPage.prototype.openPage = function (p) {
        this.viewCtrl.dismiss();
        this.navCtrl.push(p.component, { user: this.userService.user });
    };
    PopOverMenuPage.prototype.logout = function () {
        this.viewCtrl.dismiss();
        this.userService.logout();
    };
    PopOverMenuPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-pop-over-menu',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\pop-over-menu\pop-over-menu.html"*/'<!--\n  Generated template for the PopOverMenuPage page.\n\n  See http://ionicframework.com/docs/components/#navigation for more info on\n  Ionic pages and navigation.\n-->\n\n<ion-list inset>\n<ion-item *ngFor="let p of pages; let i = index" detail-push (click)="openPage(p)">\n  {{p.name}}\n</ion-item>\n<ion-item (click)="logout()">Deconnexion</ion-item>\n</ion-list>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\pop-over-menu\pop-over-menu.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_2__providers_user_user__["a" /* UserProvider */]])
    ], PopOverMenuPage);
    return PopOverMenuPage;
}());

//# sourceMappingURL=pop-over-menu.js.map

/***/ })

});
//# sourceMappingURL=26.js.map