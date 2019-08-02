webpackJsonp([20],{

/***/ 845:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ProfilePageModule", function() { return ProfilePageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__profile__ = __webpack_require__(894);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var ProfilePageModule = /** @class */ (function () {
    function ProfilePageModule() {
    }
    ProfilePageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__profile__["a" /* ProfilePage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__profile__["a" /* ProfilePage */]),
            ],
        })
    ], ProfilePageModule);
    return ProfilePageModule;
}());

//# sourceMappingURL=profile.module.js.map

/***/ }),

/***/ 894:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return ProfilePage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__providers_user_user__ = __webpack_require__(152);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5__ionic_storage__ = __webpack_require__(88);
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
 * Generated class for the ProfilePage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var ProfilePage = /** @class */ (function () {
    function ProfilePage(navCtrl, navParams, notify, userService, storage, manager) {
        this.navCtrl = navCtrl;
        this.navParams = navParams;
        this.notify = notify;
        this.userService = userService;
        this.storage = storage;
        this.manager = manager;
        this.user = {};
        this.user = this.navParams.get('user');
        if (!this.userService.amIMyParent())
            this.user.entreprise = this.user.parent.entreprise;
        this.user.pays = this.user.parent.pays;
        this.user.ville = this.user.parent.ville;
    }
    ProfilePage.prototype.ionViewDidLoad = function () {
        console.log('ionViewDidLoad ProfilePage');
    };
    ProfilePage.prototype.isInvalid = function () {
        if (this.userService.amIMyParent())
            return (!this.user.entreprise || !this.user.ville || !this.user.pays);
        else
            return (!this.user.nom);
    };
    ProfilePage.prototype.dismiss = function (skippecheck) {
        if (skippecheck === void 0) { skippecheck = true; }
        this.navCtrl.setRoot('MenuPage', { skippecheck: skippecheck }, { animate: true, direction: 'forward' });
    };
    ProfilePage.prototype.onSubmit = function () {
        var _this = this;
        this.manager.put('user', this.user, true).then(function (data) {
            if (data.id) {
                _this.storage.set('user', data).then(function () {
                    _this.dismiss(false);
                });
            }
        }, function (error) {
            console.log(error);
            _this.notify.onSuccess({ message: "Verifiez votre connexion internet" });
        });
    };
    ProfilePage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-profile',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\profile\profile.html"*/'<!--\n  Generated template for the ProfilePage page.\n\n  See http://ionicframework.com/docs/components/#navigation for more info on\n  Ionic pages and navigation.\n-->\n<ion-header>\n\n  <ion-navbar>\n    <ion-title>Informations génerales</ion-title>\n    <ion-buttons end>\n            <button ion-button="ion-button" (click)="dismiss()" icon-left>\n                <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n                Fermer\n            </button>\n        </ion-buttons>\n  </ion-navbar>\n</ion-header>\n<ion-content padding>\n        <ion-card>\n                <ion-card-header text-wrap>Modifiez ou completez vos informations </ion-card-header>\n        </ion-card>     \n  <form #form="ngForm" novalidate="novalidate">\n    <ion-list *ngIf="user">\n        <ion-item>\n            <ion-label color="primary" floating><span>Entreprise </span> </ion-label>\n            <ion-input [(ngModel)]="user.entreprise" name="entreprise" type="text" placeholder="" #entreprise="ngModel" [disabled]="!userService.amParent"></ion-input>\n        </ion-item>     \n        <ion-item>\n            <ion-label color="primary" floating><span>Votre nom </span> </ion-label>\n            <ion-input [(ngModel)]="user.nom" name="nom" type="text" placeholder="" #nom="ngModel"></ion-input>\n        </ion-item>\n        <ion-item>\n            <ion-label color="primary" floating>\n                <span>Télephone</span>\n            </ion-label>\n            <ion-input [(ngModel)]="user.phone" name="phone" type="tel" placeholder="" #tel="ngModel" disabled="true"></ion-input>\n        </ion-item>\n        <ion-item>\n            <ion-label color="primary" floating><span>Pays </span> </ion-label>\n            <ion-input [(ngModel)]="user.pays" name="pays" type="text" placeholder=""  #pays="ngModel" [disabled]="!userService.amParent"></ion-input>\n        </ion-item>\n        <ion-item >\n            <ion-label color="primary" floating> \n                <span>Ville</span>\n            </ion-label>\n            <ion-select [(ngModel)]="user.ville" name="ville" #ville="ngModel" [disabled]="!userService.amParent">\n                    <ion-option value="Yaoundé">Yaoundé</ion-option>\n                    <ion-option value="Douala">Douala</ion-option>\n                    <ion-option value="Bafoussam">Bafoussam</ion-option>\n                    <ion-option value="Bertoua">Bertoua</ion-option>\n                    <ion-option value="Bamenda">Bamenda</ion-option>\n                    <ion-option value="Dschang">Dschang</ion-option>\n                    <ion-option value="Autre">Autre</ion-option>\n                </ion-select>\n            </ion-item>    \n                <ion-item>\n                    \n            <ion-textarea rows="2" [(ngModel)]="user.adresse" placeholder="Adresse" name="adresse" #adresse="ngModel"></ion-textarea>\n        </ion-item>\n    </ion-list>\n    <div padding="padding">\n        <button ion-button block icon-right [disabled]="isInvalid()" (click)="onSubmit()">\n            <span>Enrégistrer les changements\n                <ion-icon name="md-done-all"></ion-icon>\n            </span>\n        </button>\n      \n    </div>\n</form>\n</ion-content>\n'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\profile\profile.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */],
            __WEBPACK_IMPORTED_MODULE_2__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_4__providers_user_user__["a" /* UserProvider */],
            __WEBPACK_IMPORTED_MODULE_5__ionic_storage__["b" /* Storage */],
            __WEBPACK_IMPORTED_MODULE_3__providers_manager_manager__["a" /* ManagerProvider */]])
    ], ProfilePage);
    return ProfilePage;
}());

//# sourceMappingURL=profile.js.map

/***/ })

});
//# sourceMappingURL=20.js.map