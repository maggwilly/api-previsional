webpackJsonp([18],{

/***/ 848:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "RendezvousPageModule", function() { return RendezvousPageModule; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__rendezvous__ = __webpack_require__(899);
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};



var RendezvousPageModule = /** @class */ (function () {
    function RendezvousPageModule() {
    }
    RendezvousPageModule = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["NgModule"])({
            declarations: [
                __WEBPACK_IMPORTED_MODULE_2__rendezvous__["a" /* RendezvousPage */],
            ],
            imports: [
                __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["i" /* IonicPageModule */].forChild(__WEBPACK_IMPORTED_MODULE_2__rendezvous__["a" /* RendezvousPage */]),
            ],
        })
    ], RendezvousPageModule);
    return RendezvousPageModule;
}());

//# sourceMappingURL=rendezvous.module.js.map

/***/ }),

/***/ 899:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return RendezvousPage; });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__angular_core__ = __webpack_require__(1);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_ionic_angular__ = __webpack_require__(44);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__ = __webpack_require__(47);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__app_app_notify__ = __webpack_require__(482);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__angular_common__ = __webpack_require__(65);
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
 * Generated class for the RendezvousPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */
var RendezvousPage = /** @class */ (function () {
    function RendezvousPage(navCtrl, manager, viewCtrl, notify, navParams) {
        this.navCtrl = navCtrl;
        this.manager = manager;
        this.viewCtrl = viewCtrl;
        this.notify = notify;
        this.navParams = navParams;
        this.rendezvous = {};
        this.users = [];
        this.pointVente = {};
        this.rendezvous = this.navParams.get('rendezvous');
        this.pointVente = navParams.get('pointVente');
    }
    RendezvousPage.prototype.ionViewDidLoad = function () {
        var _this = this;
        var datePipe = new __WEBPACK_IMPORTED_MODULE_4__angular_common__["d" /* DatePipe */]('en');
        if (!this.rendezvous.dateat) {
            this.rendezvous.dateat = datePipe.transform(new Date(), 'yyyy-MM-dd');
            this.rendezvous.date = datePipe.transform(new Date(), 'yyyy-MM-dd');
        }
        if (this.rendezvous.user && this.rendezvous.user.id)
            this.rendezvous.user = this.rendezvous.user.id;
        this.manager.get('user').then(function (data) {
            _this.users = data ? data : [];
        }, function (error) {
        });
    };
    RendezvousPage.prototype.dismiss = function (data) {
        this.viewCtrl.dismiss(data);
    };
    RendezvousPage.prototype.onSubmit = function () {
        var _this = this;
        var self = this;
        this.rendezvous.change = true;
        var loader = this.notify.loading({
            content: "Enregistrement...",
        });
        this.rendezvous.pointVente = this.pointVente.id;
        this.manager.save('rendezvous', this.rendezvous).then(function (data) {
            loader.dismiss().then(function () {
                if (!data.error) {
                    self.dismiss(data);
                    return _this.notify.onSuccess({ message: "Enregistrement effectué" });
                }
                _this.notify.onError({ message: "Une erreur s'est produite" });
            });
        }, function (error) {
            loader.dismiss();
            _this.notify.onError({ message: "Un probleme est survenu" });
        });
        loader.present();
    };
    RendezvousPage.prototype.isInvalid = function () {
        return !this.rendezvous.dateat;
    };
    RendezvousPage = __decorate([
        Object(__WEBPACK_IMPORTED_MODULE_0__angular_core__["Component"])({
            selector: 'page-rendezvous',template:/*ion-inline-start:"C:\Users\HP\workspace\provisional-mobile\src\pages\rendezvous\rendezvous.html"*/'<ion-header no-border no-shadow >\n    <ion-navbar>\n          <ion-title><span>Rendez-vous</span></ion-title>\n          <ion-buttons end>\n                  <button ion-button="ion-button" (click)="dismiss()" icon-left>\n                      <ion-icon name="md-close" color="danger" showwhen="android,windows,core"></ion-icon> \n                      Fermer\n                  </button>\n              </ion-buttons>        \n    </ion-navbar>\n  </ion-header>\n  <ion-content >\n        <ion-card>\n                <ion-card-header text-wrap>Enrégistrer ou modifier un rendez-vous</ion-card-header>\n        </ion-card>      \n      <form #form="ngForm" novalidate="novalidate">\n          <ion-list>\n              <ion-item>\n                  <ion-label color="primary" floating>Saisir la date</ion-label>\n                  <ion-datetime \n                     displayFormat="DD/MM/YYYY"\n                     pickerFormat="D MMM  YYYY" min="2019" max="2019"\n                     doneText="Terminé" cancelText="Annuler"\n                     name="dateat"\n                     [(ngModel)]="rendezvous.dateat"\n                      #date="ngModel"></ion-datetime>\n                </ion-item>\n                <ion-item *ngIf="users&&users.length">\n                    <ion-label color="primary" floating>\n                  <span>A honorer par</span>\n              </ion-label>\n                <ion-select [(ngModel)]="rendezvous.user" name="user" #user="ngModel">\n                      <ion-option *ngFor="let user of users" [value]="user.id">{{user.nom}}</ion-option>\n                  </ion-select>\n          </ion-item>            \n           <ion-item>\n                    <ion-textarea rows="2" [(ngModel)]="rendezvous.commentaire" placeholder="Commentaire"\n                          name="commentaire" #commentaire="ngModel"></ion-textarea>\n              </ion-item>                      \n          </ion-list>\n      </form>\n  </ion-content>\n  <ion-footer >\n      <button ion-button full [disabled]="isInvalid()" (click)="onSubmit()">\n        Creer un rendezvous\n      </button>\n  </ion-footer>'/*ion-inline-end:"C:\Users\HP\workspace\provisional-mobile\src\pages\rendezvous\rendezvous.html"*/,
        }),
        __metadata("design:paramtypes", [__WEBPACK_IMPORTED_MODULE_1_ionic_angular__["n" /* NavController */],
            __WEBPACK_IMPORTED_MODULE_2__providers_manager_manager__["a" /* ManagerProvider */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["s" /* ViewController */],
            __WEBPACK_IMPORTED_MODULE_3__app_app_notify__["a" /* AppNotify */],
            __WEBPACK_IMPORTED_MODULE_1_ionic_angular__["o" /* NavParams */]])
    ], RendezvousPage);
    return RendezvousPage;
}());

//# sourceMappingURL=rendezvous.js.map

/***/ })

});
//# sourceMappingURL=18.js.map